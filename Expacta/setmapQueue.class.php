<?php

/**
 * Description of setmapQueue
 *
 * @author brave.cheng
 */
class setmapQueue extends rmQueue {

    const QUEUE_NAME = 'setmap_queue';
    const RETRY_TIMES = 5;

    private static $limit = 500;

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

    public function getSiteBySetmapQueue() {
        $criteria = new Criteria();
        $criteria->add(QueueDataPeer::NAME, self::QUEUE_NAME);
        $criteria->add(QueueDataPeer::STATUS, array(parent::STATUS_NEW, parent::STATUS_FAILED), Criteria::IN);
        $criteria->setLimit(self::$limit);
        $this->queue = QueueDataPeer::doSelect($criteria);
    }

    public function dequeue() {
        $strings = '';
        if (!$this->queue) {
            $this->getSiteBySetmapQueue();
        }
        if ($this->queue) {
            foreach ($this->queue as $item) {
                //get valid section url
                $strings .= $this->getValidSectionUrl($item->getSiteId());
                //get valid page url
                $strings .= $this->getValidPageUrl($item->getSiteId());
                //create setmap.xml
                $setmap = $this->makeSiteSetmap($strings);
                //setup site xml
                $site = SitePeer::retrieveByPK($item->getSiteId());
                $siteDir = SF_ROOT_DIR . '/frontend/sites/' . $site->getCode() . '/web/sitmap.xml';
                $paths = pathinfo($siteDir);
                rapidManagerUtil::createDir($paths['dirname'], '775', 'brave.cheng', 'design');
                rapidManagerUtil::writePathLogs($siteDir, $setmap);
                //out of queue
                parent::dequeue();
            }
        } else {
            throw new Exception("not exsit setmap queue!");
        }
    }

    /**
     * get to meet the conditions of section urls
     * the section is active
     * @param int $siteId
     * @return array
     */
    public function getValidSectionUrl($siteId) {
        $strings = '';
        $criteria = new Criteria();
        $site = SitePeer::retrieveByPK($siteId);
        $criteria->add(SectionPeer::ACTIVE, 1);
        $criteria->add(SectionPeer::SITE_ID, $siteId);
        $criteria->add(SectionPeer::PARENT_ID, 0);
        $items = SectionPeer::doSelectWithI18n($criteria, rm2Util::getDefaultLanguage());
        if ($items) {
            foreach ($items as $section) {
                $subSection = SectionPeer::doSelectSectionPathsSort($siteId, $section, rm2Util::getDefaultLanguage());
                if ($subSection) {
                    foreach ($subSection as $sub) {
                        $url = rtrim($site->getWebUrl(), '/') . "/" . strtolower(str_replace(" ", "-", utilClearCharacter($sub->getName()))) . "-s" . $sub->getId();
                        $strings .= '<url><loc>' . $url . '</loc><lastmod>' . $section->getUpdatedAt('Y-m-d') . '</lastmod></url>';
                    }
                }
                $url = rtrim($site->getWebUrl(), '/') . "/" . strtolower(str_replace(" ", "-", utilClearCharacter($section->getName()))) . "-s" . $section->getId();
                $strings .= '<url><loc>' . $url . '</loc><lastmod>' . $section->getUpdatedAt('Y-m-d') . '</lastmod></url>';
            }
        }
        return $strings;
    }

    /**
     * get to meet the conditions of page urls.
     * 1.the page is active, 2.the public is not private, 3.the date/time is valid
     * @param int $siteId
     * @return array
     */
    public function getValidPageUrl($siteId) {
        $timestp = $_SERVER['REQUEST_TIME'];
        $site = SitePeer::retrieveByPK($siteId);
        $strings = '';
        $criteria = new Criteria();
        $criteria->addJoin(PagePeer::ID, SectionPagePeer::PAGE_ID, Criteria::LEFT_JOIN);
        $criteria->add(PagePeer::SITE_ID, $siteId);
        $criteria->add(PagePeer::ACTIVE, 1);
        $criteria->add(PagePeer::PUBLISH, 1);
        $criteria->add(PagePeer::IS_PRIVATE, 1);
        $criteria->add(PagePeer::LAUNCH_DATE, date('Y-m-d', $timestp), Criteria::LESS_EQUAL);
        $criteria->add(PagePeer::LAUNCH_TIME, date('H:i:s', $timestp), Criteria::LESS_EQUAL);
        $criteria->add(PagePeer::EXPIRY_DATE, date('Y-m-d', $timestp), Criteria::GREATER_EQUAL);
        $criteria->add(PagePeer::LAUNCH_TIME, date('H:i:s', $timestp), Criteria::GREATER_EQUAL);
        $items = PagePeer::doSelectWithI18n($criteria, rm2Util::getDefaultLanguage());
        if ($items) {
            foreach ($items as $page) {
                $url = rtrim($site->getWebUrl(), '/') . "/" . strtolower(str_replace(" ", "-", utilClearCharacter($page->getTitle()))) . "-p" . $page->getId();
                $strings .= '<url><loc>' . $url . '</loc><lastmod>' . $page->getUpdatedAt('Y-m-d') . '</lastmod></url>';
            }
        }
        return $strings;
    }

    public function makeSiteSetmap($urls) {
        $map = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';
        $map .=$urls . '</urlset>';
        return $map;
    }

}
