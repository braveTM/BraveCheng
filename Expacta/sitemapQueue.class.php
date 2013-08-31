<?php

/**
 * Description of sitemapQueue
 *
 * @author brave.cheng
 */
class sitemapQueue extends rmQueue {

    const QUEUE_NAME = 'sitemap_queue';
    const RETRY_TIMES = 5;

    private $site = null;
    private $sitemapTempXml = null;
    private $sitemapXml = null;
    private $fileHandle = null;
    private static $errorLog = 'sitemap_error.log';
    private static $limit = 100;
    private $sitemapHeader = array(
        '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.google.com/schemas/sitemap/0.84">',
        '</urlset>',
    );

    public function __construct() {
        parent::__construct(self::QUEUE_NAME);
    }

    /**
     * add a new queue unless the queue is not exsit which condition is include site_id, name, status[0,3]
     * @param int $siteId
     */
    public function addQueue($siteId) {
        //item is exsit
        $criteria = new Criteria();
        $criteria->add(QueueDataPeer::SITE_ID, (int) $siteId);
        $criteria->add(QueueDataPeer::NAME, self::QUEUE_NAME);
        $criteria->add(QueueDataPeer::STATUS, array(parent::STATUS_NEW, parent::STATUS_FAILED), Criteria::IN);
        $exsit = QueueDataPeer::doSelectOne($criteria);
        if (empty($exsit)) {
            $this->enqueue('', array(), array('site_id' => $siteId));
        }
    }

    public function reload() {
        $criteria = new Criteria();
        $criteria->add(QueueDataPeer::NAME, self::QUEUE_NAME);
        $criteria->add(QueueDataPeer::STATUS, array(parent::STATUS_NEW, parent::STATUS_FAILED), Criteria::IN);
        $criteria->setLimit(self::$limit);
        $this->queue = QueueDataPeer::doSelect($criteria);
        if (empty($this->queue)) {
            $this->queue = array();
        }
        $this->isLoaded = 1;
        $this->isReadAll = count($this->queue) < self::MAX_ITEM_PER_QUERY;
    }

    public function processingQueue() {
        if (!$this->isLoaded || (!$this->queue && !$this->isReadAll)) {
            $this->reload();
        }
        if ($this->queue) {
            foreach ($this->queue as $currentQueue) {
                $currentSiteId = $currentQueue->getSiteId();
                empty($this->site) && $this->getSite($currentSiteId);
                empty($this->sitemapTempXml) && $this->getSiteSitemapXml();
                //Remove content to prevent the rewrite
                file_exists($this->sitemapTempXml) && unlink($this->sitemapTempXml);
                $this->fileHandle = fopen($this->sitemapTempXml, 'ab');
                //write sitemap header
                $this->writeSitemapContent($this->sitemapHeader[0]);
                //write section url
                $this->loopWriteSectionSitemapUrl($currentSiteId);
                //write page url
                $this->loopWritePageSitemapUrl($currentSiteId);
                //write sitemap footer
                $this->writeSitemapContent($this->sitemapHeader[1]);
                fclose($this->fileHandle);
                if (rename($this->sitemapTempXml, $this->sitemapXml) === false) {
                    rapidManagerUtil::logMessage('rename ' . $this->sitemapTempXmlXml . ' to ' . $this->sitemapXml . ' error.', self::$errorLog);
                }
                parent::dequeue();
            }
        } else {
            throw new Exception('not exsit setmap queue!');
        }
    }

    private function loopWriteSectionSitemapUrl($siteId, $parent = 0) {
        $criteria = new Criteria();
        $criteria->add(SectionPeer::ACTIVE, 1);
        $criteria->add(SectionPeer::SITE_ID, $siteId);
        $criteria->add(SectionPeer::PARENT_ID, $parent);
        $criteria->add(SectionPeer::SHOWSITEMAP, 1);
        $criteria->add(SectionPeer::IS_PRIVATE, 0);
        $criteria->addJoin(SectionPeer::ID, SectionI18nPeer::ID);
        $criteria->clearSelectColumns();
        $criteria->addSelectColumn(SectionPeer::ID);
        $criteria->addSelectColumn(SectionPeer::UPDATED_AT);
        $criteria->addSelectColumn(SectionI18nPeer::NAME);
        $criteria->add(SectionI18nPeer::CULTURE, rm2Util::getDefaultLanguage($siteId));
        $rs = SectionPeer::doSelectRS($criteria);
        if (!is_null($rs)) {
            while ($sectionArray = mysql_fetch_assoc($rs->getResource())) {
                $subSectionArray = $this->loopWriteSectionSitemapUrl($siteId, $sectionArray['ID']);
                if ($subSectionArray) {
                    $subContent = $this->assemblySingleSectionOrPageUrl($subSectionArray);
                    $this->writeSitemapContent($subContent);
                }
                $content = $this->assemblySingleSectionOrPageUrl($sectionArray);
                $this->writeSitemapContent($content);
            }
        }
    }

    private function loopWritePageSitemapUrl($siteId) {
        $criteria = new Criteria();
        $criteria->addJoin(PagePeer::ID, SectionPagePeer::PAGE_ID, Criteria::LEFT_JOIN);
        $criteria->add(PagePeer::SITE_ID, $siteId);
        $criteria->add(PagePeer::ACTIVE, 1);
        $criteria->add(PagePeer::PUBLISH, 1);
        $criteria->add(PagePeer::IS_PRIVATE, 0);
        $criteria->add(PagePeer::SHOWSITEMAP, 1);
        $criteria->addJoin(PagePeer::ID, PageI18nPeer::ID);
        $criteria->clearSelectColumns();
        $criteria->addSelectColumn(PagePeer::ID);
        $criteria->addSelectColumn(PagePeer::UPDATED_AT);
        $criteria->addSelectColumn(PageI18nPeer::TITLE);
        $criteria->add(PageI18nPeer::CULTURE, rm2Util::getDefaultLanguage($siteId));
        $rs = PagePeer::doSelectRS($criteria);
        if (!is_null($rs)) {
            while ($pageArray = mysql_fetch_assoc($rs->getResource())) {
                $content = $this->assemblySingleSectionOrPageUrl($pageArray, false);
                $this->writeSitemapContent($content);
            }
        }
    }

    private function assemblySingleSectionOrPageUrl($section, $isSection = true) {
        $urlField = $isSection ? '<url><loc>' . rtrim($this->site->getWebUrl(), '/') . "/" . strtolower(str_replace(" ", "-", utilClearCharacter($section['NAME']))) . "-s" . $section['ID'] . '</loc><lastmod>' . date('Y-m-d', strtotime($section['UPDATED_AT'])) . '</lastmod></url>' : '<url><loc>' . rtrim($this->site->getWebUrl(), '/') . "/" . strtolower(str_replace(" ", "-", utilClearCharacter($section['TITLE']))) . "-p" . $section['ID'] . '</loc><lastmod>' . date('Y-m-d', strtotime($section['UPDATED_AT'])) . '</lastmod></url>';
        return empty($section) ? '' : $urlField;
    }

    private function getSite($siteId) {
        $this->site = SitePeer::retrieveByPK($siteId);
    }

    private function getSiteSitemapXml() {
        $this->sitemapTempXml = SF_ROOT_DIR . '/frontend/sites/' . $this->site->getCode() . '/web/sitemap.temp.xml';
        $this->sitemapXml = SF_ROOT_DIR . '/frontend/sites/' . $this->site->getCode() . '/web/sitemap.xml';
    }

    private function writeSitemapContent($content) {
        if (fwrite($this->fileHandle, $content) === false) {
            rapidManagerUtil::logMessage($this->sitemapTempXml . 'write error:' . $content, self::$errorLog);
        }
    }

}
