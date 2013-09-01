<?php

class rapidManagerUtil {

    /**
     * Automatic loading a folder with all the PHP files
     *
     * @param string $dir folder
     */
    public static function autoloadFiles($dir) {
        $handle = opendir($dir);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $pathinfo = pathinfo($dir . $file);
                if ($pathinfo['extension'] == 'php') {
                    require_once($dir . $file);
                }
            }
        }
    }

    public static function judgeOS() {
        $_SERVER['WINDIR'] = isset($_SERVER['WINDIR']) ? $_SERVER['WINDIR'] : '';
        if (($_SERVER['WINDIR'] != "") && ($_ENV['OSTYPE'] == "")) {
            return "WIN";
        } else {
            return "LINUX";
        }
    }

    public static function getMediaFileSetup($name = "", $siteId = "") {
        static $default, $cache = array();
        $default = array(
            "total" => 1000 * 1024 * 1024,
            "flv" => 10 * 1024 * 1024,
            "mov" => 10 * 1024 * 1024,
            "mp4" => 10 * 1024 * 1024,
            "m4v" => 10 * 1024 * 1024,
            "wmv" => 10 * 1024 * 1024,
            "mp3" => 5 * 1024 * 1024,
            "jpg" => 150 * 1024,
            "png" => 150 * 1024,
            "gif" => 150 * 1024,
            "doc" => 1 * 1024 * 1024,
            "pdf" => 1 * 1024 * 1024,
            "xls" => 1 * 1024 * 1024,
            "ppt" => 2 * 1024 * 1024,
            "zip" => 5 * 1024 * 1024,
            "rar" => 5 * 1024 * 1024,
            "other" => 500 * 1024,
            "subscribers" => 500,
            "jpgquality" => 50,
        );
        if (empty($siteId)) {
            $current = $default;
        } else {
            if (!isset($cache[$siteId])) {
                $cache[$siteId] = $default;
                $values = ConfigurePeer::getValues(array_keys($default), $siteId);
                foreach ($values as $k => $v) {
                    $cache[$siteId][$k] = empty($v) ? $default[$k] : $v;
                }
            }
            $current = $cache[$siteId];
        }
        if ($name) {
            return $current[$name];
        }
        return $current;
    }

    static public function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function getFckToolBar() {
        $toolBar = "";
        $client = rm2Util::getClient();
        $c = new Criteria();
        $c->add(ModulePeer::NAME, 'LiveLinks');
        $c->add(SiteModulePeer::SITE_ID, rm2Util::getSiteId());
        $c->addJoin(SiteModulePeer::MODULE_ID, ModulePeer::ID, Criteria::LEFT_JOIN);
        $checkModule = SiteModulePeer::doSelectOne($c);
        if ($checkModule) {
            $toolBar = "LiveLinks";
        } else {
            $toolBar = "Default";
        }
        return $toolBar;
    }

    public function getRmCurrentRightDB($name = null) {

        if ($_SERVER["DB_CONNECT_NAME"]) {
            $name = $_SERVER["DB_CONNECT_NAME"];
        }
        return $name;
    }

    public function checkValidUrlAndGetData($url, &$data, $header = 1) {
        $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2) Gecko/20100115 Firefox/3.6 ';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, $header);
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        $data = curl_exec($curl);

        curl_close($curl);
        if (!eregi("^HTTP/1\.. 200", $data)) {
            if (eregi("^HTTP/1\.. 302", $data)) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }

    public function getDomainDirFileName($url = '', $siteId = '') {
        if (!$url) {
            if (!$siteId) {
                $siteId = rm2Util::getSiteId();
            }
            $site = SitePeer::retrieveByPK($siteId);
            if ($site) {
                $url = $site->getWebUrl();
            }
        }
        $url = strtolower($url);
        $domainFileName = preg_replace('%http://|https://%i', '', $url);
        $domainFileName = preg_replace('%[:|\\\\|||/|"|<|>|?|*]%i', '', $domainFileName);
        return $domainFileName;
    }

    public static function getFrontEndResourcesDir($url = '', $siteId = '', $history = 0, $isPrivate = false) {
        $dir = '';
        if (defined("SITE_CODE")) {
            $siteCode = strtolower(SITE_CODE);
        } else {
            if (!$siteId)
                $siteId = rm2Util::getSiteId();
            $site = SitePeer::retrieveByPK($siteId);
            if ($site) {
                $siteCode = strtolower($site->getCode());
            }
        }

        $_tmp = array(SF_ROOT_DIR,
            'frontend',
            'sites',
            $siteCode,
            'web',
            $isPrivate == true ? '../xfiles' : 'files'
        );
        $dir = implode('/', $_tmp) . '/';

        if ($history == 1) {
            if ($url) {
                $domainFileName = rapidManagerUtil::getDomainDirFileName($url);
            } else {
                if (!$siteId) {
                    $siteId = rm2Util::getSiteId();
                }
                $site = SitePeer::retrieveByPK($siteId);
                if ($site) {
                    $url = $site->getWebUrl();
                }
                $domainFileName = rapidManagerUtil::getDomainDirFileName($url);
            }

            $oldFileDir = SF_ROOT_DIR . DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . $domainFileName . DIRECTORY_SEPARATOR;
            if (!is_dir($oldFileDir)) {
                @mkdir($oldFileDir, 0775, true);
            }
            $dir = $oldFileDir . "history" . DIRECTORY_SEPARATOR;
        }
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        return $dir;
    }

    public function getAllDomainName() {
        $domainNames = array();
        //admin server
        $c = new Criteria();
        $c->add(SitePeer::CODE, '', Criteria::NOT_EQUAL);
        $c->add(SitePeer::WEB_URL, '', Criteria::NOT_EQUAL);

        $site = SitePeer::doSelect($c, Propel::getConnection('admin'));

        if ($site) {
            foreach ($site as $obj) {
                $domainNames[] = rapidManagerUtil::getDomainDirFileName($obj->getWebUrl());
            }
        }

        //ls server
        $c = new Criteria();
        $c->add(SitePeer::CODE, '', Criteria::NOT_EQUAL);
        $c->add(SitePeer::WEB_URL, '', Criteria::NOT_EQUAL);
        $siteLs = SitePeer::doSelect($c, Propel::getConnection('ls'));
        if ($siteLs) {
            foreach ($siteLs as $obj) {
                $domainNames[] = rapidManagerUtil::getDomainDirFileName($obj->getWebUrl());
            }
        }
        return $domainNames;
    }

    public static function getFrontendSiteCacheDir($siteCode=""){
        if(empty($siteCode)) $siteCode = rm2Util::getSiteCode();
        $cacheDir = SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . strtolower($siteCode) . DIRECTORY_SEPARATOR;
        if(!file_exists($cacheDir)){
            @mkdir($cacheDir, 0777, true);
        }
        return $cacheDir;
    }

    public static function getStaticCacheDir($siteCode=""){
        if(empty($siteCode)) $siteCode = rm2Util::getSiteCode();
        $cacheDir = SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'sites' . DIRECTORY_SEPARATOR . strtolower($siteCode) . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
        $staticCacheDir = $cacheDir . DIRECTORY_SEPARATOR . 'static' . DIRECTORY_SEPARATOR;
        if(!file_exists($staticCacheDir)){
            @mkdir($staticCacheDir, 0777, true);
        }
        return $staticCacheDir;
    }

    public static function twitterSendMessage($message, $username, $password) {

        //echo "windy";
        $host = 'http://twitter.com/statuses/update.xml?status=[[MESSAGE]]';
        /*         * ********************
         * TWITTER SEND MESSAGE
         * ********************* */
        $host = str_replace("[[MESSAGE]]", urlencode(stripslashes(urldecode($message))), $host);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);



        $result = curl_exec($ch);
        // Look at the returned header
        $resultArray = curl_getinfo($ch);
        //var_dump($resultArray);
        curl_close($ch);

        return $result;
    }

    public static function getTwitterMessageId($xmlData) {
        $fileName = "tempTwitter_" . time() . ".xml";
        $filePath = SF_ROOT_DIR . "/web/" . $fileName;
        $fp = @fopen("$filePath", "w");
        @fwrite($fp, $xmlData);
        fclose($fp);
        $dom = new DOMDocument();
        $dom->load($filePath);
        $x = $dom->documentElement;
        $nodeArray = array();
        foreach ($x->childNodes AS $item) {
            $nodeArray[$item->nodeName] = $item->nodeValue;
        }
        $twitterId = $nodeArray['id'];
        unlink($filePath);
        return $twitterId;
    }

    public static function twitterDeleteMessage($messageId, $username, $password) {

        $host = 'http://twitter.com/statuses/destroy/' . $messageId . '.xml';
        /*         * ********************
         * TWITTER SEND MESSAGE
         * ********************* */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $result = curl_exec($ch);
        // Look at the returned header
        $resultArray = curl_getinfo($ch);
        curl_close($ch);

        return $resultArray;
    }

    public static function twitterUpdateMessage($messageId, $username, $password) {
        rapidManagerUtil::twitterDeleteMessage($messageId, $username, $password);
        $resultArray = rapidManagerUtil::twitterSendMessage($message, $username, $password);
        return $resultArray;
    }

    //chanage the content
    public static function spHtmlToText($content) {
        $content = strip_tags($content, "<p><br><img>");
        return $content;
    }

    public static function makeBitlyUrl($url, $format = 'xml', $version = '2.0.1') {
        //create the URL
        $login = "windysl";
        $appkey = "R_9c4bfd145e0172f447b57ca461aa7dd8";
        $bitly = 'http://api.bit.ly/shorten?version=' . $version . '&longUrl=' . urlencode($url) . '&login=' . $login . '&apiKey=' . $appkey . '&format=' . $format;

        //get the url
        //could also use cURL here
        $response = file_get_contents($bitly);

        //parse depending on desired format
        if (strtolower($format) == 'json') {
            $json = @json_decode($response, true);
            return $json['results'][$url]['shortUrl'];
        } else {
            //xml
            $xml = simplexml_load_string($response);
            return 'http://bit.ly/' . $xml->results->nodeKeyVal->hash;
        }
    }

    public static function defineDBFromRunTimeSettings() {
        //get the db admin or ls
        if ($propelDB = $_SERVER["DB_CONNECT_NAME"]) {
            define('PROPEL_DB', $propelDB);
        } else {
            $propelDB = $_SERVER['argv'][1];
            if ($propelDB) {
                
            } else {
                $propelDB = 'admin';
            }
            define('PROPEL_DB', $propelDB);
        }
        return $propelDB;
    }

    //Mime Types By File Extension
    public static function getMimeTypeByExtension($fileName, $mimePath = "/etc") {
        if (function_exists(mime_content_type)) {
            $mimeType = mime_content_type($fileName);
            return $mimeType;
        } else {
            $fileext = substr(strrchr($fileName, '.'), 1);
            //if (empty($fileext)) return (false);
            $regex = "/^([\w\+\-\.\/]+)\s+(\w+\s)*($fileext\s)/i";
            $lines = file("$mimePath/mime.types");
            foreach ($lines as $line) {
                if (substr($line, 0, 1) == '#')
                    continue; // skip comments
                $line = rtrim($line) . " ";
                if (!preg_match($regex, $line, $matches))
                    continue; // no match to the extension
                return ($matches[1]);
            }
        }
        $miMeType = "application/force-download";
        return $miMeType;
    }

    /**
     * Enter description here...
     *
     * @param $string 		encode/decode string
     * @param $operation 	"DECODE" or "ENCODE"
     * @param  $key 		Encrypted string
     * @return unknown		encoded/decoded string
     */
    public static function rapidmanagerAuthcode($string, $operation, $key = '') {
        $cipher = MCRYPT_BLOWFISH;
        $mode = MCRYPT_MODE_ECB;
        $key = $key ? $key : "YYADE-+78d$-OP25b-721n-qweF3";
        if (function_exists('mcrypt_create_iv')) {
            $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher, $mode), MCRYPT_RAND);
            if ($operation == "ENCODE") {
                return base64_encode(mcrypt_encrypt($cipher, $key, $string, $mode, $iv));
            } else {
                return rtrim(mcrypt_decrypt($cipher, $key, base64_decode($string), $mode, $iv), "\0");
            }
        }
        return $string;
    }

    public static function getStripslashesBlogContent($content) {
        $content = str_replace("\\r\\n", "
", $content);
        $content = stripslashes($content);
        return $content;
    }

    public static function getSphinxIndexFileExtension() {
        return array("docx", "doc", "xlsx", "xls", "pdf", "txt", "odt");
    }

    public static function getApacheTikaCommand() {
        return "java -jar /home/httpd/html/rapidmanager/lib/tika/tika-app/target/tika-app-0.7.jar -t ";
    }

    public static function getFrontendSiteDir($siteCode) {
        $siteDir = SF_ROOT_DIR . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "sites" . DIRECTORY_SEPARATOR . strtolower($siteCode);
        return $siteDir;
    }

    public static function getBackupSitePath() {
        $backupPath = SF_ROOT_DIR . DIRECTORY_SEPARATOR . "backup";
        return $backupPath;
    }

    public static function checkLinuxCommandDone($command, $commandString) {
        $checkCommand = "ps -aux | grep -a $command";
        $string = shell_exec("$checkCommand");
        if (strstr($string, $commandString)) {
            return false;
        } else {
            return true;
        }
    }

    public static function getResizeImagePercent($cropWeight, $cropHeight, $weight, $height) {
        $percent = 1;
        $weightPercent = ceil($cropWeight / $weight);
        $heightPercent = ceil($cropHeight / $height);
        if ($weightPercent > 1 || $heightPercent > 1) {
            if ($weightPercent > $heightPercent) {
                $percent = $weightPercent;
            } else {
                $percent = $heightPercent;
            }
        } elseif ($weightPercent < 1 || $heightPercent < 1) {
            if ($weightPercent > $heightPercent) {
                $percent = $weightPercent;
            } else {
                $percent = $heightPercent;
            }
        } else {
            $percent = 1;
        }
        return $percent;
    }

    public static function replaceClickTrackUrlBackend($content, $targetId, $type = "page", $languageId) {
        $reg = '%<a\s*href\s*=\s*[\'""\s](track://.*?)[\'""]%';
        preg_match_all($reg, $content, $trackUrls);
        $clickTrackIds = array();
        foreach ($trackUrls["1"] as $key => $trackUrl) {
            $clickTrackId = "";
            $match = array();
            if (strpos($trackUrl, "trackId")) {
                $reg = "%track://(.*?)/trackId/([0-9]+)%";
                preg_match($reg, $trackUrl, $match);

                $clickTrackId = ClickTrackPeer::updateClickTrackUrl($targetId, $key, $match["1"], $match["2"], $type, $languageId);
                $patternTrackUrl = str_replace("?", "\?", $trackUrl);
                $patterns = "%$patternTrackUrl\"%";
                $replacements = str_replace("/" . $match["2"] . "\"", "/" . $clickTrackId . "\"", $trackUrl . "\"");
                $content = preg_replace($patterns, $replacements, $content, 1);
                $clickTrackIds[] = $clickTrackId;
                $clickTrackIds[] = $match["2"];
            } else {
                $reg = "%track://(.*)%";
                preg_match($reg, $trackUrl, $match);
                $clickTrackId = ClickTrackPeer::insertClickTrackUrl($targetId, $key, $match["1"], $type, $languageId);
                $patternTrackUrl = str_replace("?", "\?", $trackUrl);
                $patterns = "%$patternTrackUrl\"%";
                $replacements = $trackUrl . "/trackId/" . $clickTrackId . "\"";
                $content = preg_replace($patterns, $replacements, $content, 1);
                //$content         = preg_replace('//', $replacements, $string)($trackUrl, $trackUrl . "/trackId/" . $clickTrackId, $content);
                $clickTrackIds[] = $clickTrackId;
            }
        }
        ClickTrackPeer::deleteClickTrackUrl($targetId, $clickTrackIds, $type, $languageId);

        return $content;
    }

    public static function replaceClickTrackUrlFrontend($content, $backendUrl = '', $mailTableId = '', $subscriberId = '', $mailQueueId = '', $mailType = '') {
        $reg = '%<a\s*href\s*=\s*[\'""\s](track://.*?)[\'""]%';
        preg_match_all($reg, $content, $trackUrls);
        $reg = "%track://(.*?)/trackId/([0-9]+)%";
        if (!$backendUrl) {
            $backendUrl = getBackendUrl(1);
        }
        $clickTrackUrl = $backendUrl . "/clickTrack.php";
        foreach ($trackUrls["1"] as $key => $trackUrl) {
            $reg = "%track://(.*?)/trackId/([0-9]+)%";
            preg_match($reg, $trackUrl, $match);
            $parameterString = "";
            $parameters = array();
            $parameters['target_url'] = $match["1"];
            $parameters['trackId'] = $match["2"];
            $parameters['mailTableId'] = $mailTableId;
            $parameters['subscriberId'] = $subscriberId;
            $parameters['mailQueueId'] = $mailQueueId;
            $parameters['mailType'] = $mailType;
            $parameterString = serialize($parameters);
            $parameterString = base64_encode($parameterString);
            $content = str_replace($trackUrl, $clickTrackUrl . "?url=$parameterString", $content);
        }
        return $content;
    }

    public static function getFilesData($filePath, $etc = 'php') {
        $a = array();
        if (is_dir($filePath)) {
            $current = opendir($filePath);
            while ($file = readdir($current)) {
                if ($file != '.' && $file != '..' && $file != 'Thumbs.db' && is_file($filePath . $file)) {
                    $fileinfo = pathinfo($file);
                    if ($fileinfo['extension'] == $etc) {
                        $a[$file] = $fileinfo['filename'];
                    }
                }
            }
            closedir($current);
        }
        return $a;
    }

    public static function readPageContent($pageBId = '', $sectionBId = '', $templateB = '', $previewB = '') {
        global $pageId, $sectionId, $articleId, $categoryId, $template, $language, $lang, $preview;
        $pageId = $pageBId;
        $sectionId = $sectionBId;
        $template = $templateB;
        if (!defined("SITE_CODE")) {
            define("SITE_CODE", strtolower(rm2Util::getSiteCode()));
        }
        if (!defined("SITE_ID")) {
            define("SITE_ID", rm2Util::getSiteId());
        }
        if (!defined("URL")) {
            define("URL", '/');
        }

        rapidManagerUtil::autoloadFiles(SF_ROOT_DIR . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR);
        rapidManagerUtil::autoloadFiles(SF_ROOT_DIR . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "stats" . DIRECTORY_SEPARATOR);
        rapidManagerUtil::autoloadFiles(SF_ROOT_DIR . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "cjfl" . DIRECTORY_SEPARATOR);
        require_once(SF_ROOT_DIR . DIRECTORY_SEPARATOR . "apps" . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "SiteUtil.php");
        require_once(SF_ROOT_DIR . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "Config.php");
        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();
        if ($_GET['language']) {
            setLanguage($_GET["language"]);
        }
        if (SF_APP == 'backend') {
            SmartyUtil::getInstance(true);
        }
        SmartyUtil::getInstance()->assign("memberAccess", 1);
        if ($pageId) {
            $page = PagePeer::retrieveByPk($pageId);
            $page = new CPage($page, getLanguage());
            if (!$preview) {
                if ($page == null) {
                    $display404Page = self::getError404Page();
                }
                if ($page->active == 0 && $page->redirectActive == 0) {
                    return $display404Page = self::getError404Page();
                }
                if ($page->display == false) {
                    return $display404Page = self::getError404Page();
                }
                if (($page->active == 0 && $page->redirectActive == 0)) {
                    return $display404Page = self::getError404Page();
                }
            }
            if ($page->redirectActive == 1 && $page->url != "") {
                return self::redirectPageUrl($page->url);
            }


            if ($template == "") {
                //$template = $page->template == "" ? "article.tpl" : $page->template;
                $template = $page->template;
            }
            if ($template == "") {
                $section = utilGetSectionByPageId($pageId);
                $template = pGetSectionTemplate($section) == "" ? "article.tpl" : pGetSectionTemplate($section);
            }
            SmartyUtil::getInstance()->assign("memberId", $_SESSION['memberId']);
            SmartyUtil::getInstance()->assign("memberData", $_SESSION['member']);
            SmartyUtil::getInstance()->assign("article", $page);
            SmartyUtil::getInstance()->assign("section", new CSection(null, getLanguage()));
            //$outPageContent = SmartyUtil::getInstance()->fetch(getLangTemplate($template));
            $outPageContent = self::getOutPageContent($template);
            $cacheInfo = pGetPageCacheInfo($page);
            if (!$preview && $cacheInfo['cacheOption'] == PagePeer::CACHE_OPTION_ON) {
                $expire = $cacheInfo["expire"];
            } else {
                $expire = null;
            }
        } elseif ($sectionId) {
            if ($sectionId == (string) ((int) $sectionId)) {
                $section = utilGetSectionById($sectionId);
            } else {
                $section = utilGetSectionByName($sectionId);
            }
            if ($section == null) {
                return $display404Page = self::getError404Page();
            }
            if ($section->active == 0 && $section->redirectActive == 0) {
                return $display404Page = self::getError404Page();
            }
            if (!$preview) {
                if (($section->active == 0 && $section->redirectActive == 0) || ($section->publish == 0)) {
                    return $display404Page = self::getError404Page();
                }
            }
            if ($section->redirectActive == 1 && $section->url != "") { // readirect
                return $pageUrl = self::redirectPageUrl($section->url);
            }

            if ($template != "") {
                if ($section != null) {
                    $page = utilGetPageBySectionId($section->getId());
                    if ($page == null) {
                        SmartyUtil::getInstance()->assign("article", new CPage(null, getLanguage()));
                        $cacheInfo = pGetSectionCacheInfo($section);
                    } else {
                        if ($page->display == false) {
                            return $display404Page = self::getError404Page();
                        }
                        SmartyUtil::getInstance()->assign("article", $page);
                        $cacheInfo = pGetPageCacheInfo($page);
                    }
                }
                SmartyUtil::getInstance()->assign("memberId", $_SESSION['memberId']);
                SmartyUtil::getInstance()->assign("memberData", $_SESSION['member']);
                SmartyUtil::getInstance()->assign("section", $section);
                //$outPageContent = SmartyUtil::getInstance()->fetch(getLangTemplate($template));
                $outPageContent = self::getOutPageContent($template);
                $cacheInfo = pGetSectionCacheInfo($section);
                $databaseManager->shutdown();
                if (!$preview && $cacheInfo['cacheOption'] == PagePeer::CACHE_OPTION_ON) {
                    $expire = $cacheInfo["expire"];
                } else {
                    $expire = null;
                }
                $mainData = array('expire' => $expire, 'output' => $outPageContent);
                return $mainData;
            }

            // read a page from section
            $page = utilGetPageBySectionId($section->getId());
            if ($page == null) {
                return $display404Page = self::getError404Page();
            }
            if ($page->display == false) {
                return $display404Page = self::getError404Page();
            }
            if ($page->active == 0 && $page->redirectActive == 0) {
                return $display404Page = self::getError404Page();
            }
            if ($page->redirectActive == 1 && $page->url != "") {
                return $pageUrl = self::redirectPageUrl($page->url);
            }


            if ($template == "") {
                $template = $page->template;
                //$template = $page->template == "" ? "article.tpl" : $page->template;
            }
            if ($template == "") {
                $template = pGetSectionTemplate($section) == "" ? "article.tpl" : pGetSectionTemplate($section);
            }

            SmartyUtil::getInstance()->assign("memberId", $_SESSION['memberId']);
            SmartyUtil::getInstance()->assign("memberData", $_SESSION['member']);
            SmartyUtil::getInstance()->assign("article", $page);
            SmartyUtil::getInstance()->assign("section", $section);
            //$outPageContent = SmartyUtil::getInstance()->fetch(getLangTemplate($template));
            $outPageContent = self::getOutPageContent($template);
            //SmartyUtil::getInstance()->display(getLangTemplate($template));
            $cacheInfo = pGetSectionCacheInfo($section);
            if (!$preview && $cacheInfo['cacheOption'] == PagePeer::CACHE_OPTION_ON) {
                $expire = $cacheInfo["expire"];
            } else {
                $expire = null;
            }
        } else {

            $section = utilGetSectionByName("Home Page Setting");
            if ($template == "") {
                if ($section) {
                    $template = $section->template == "" ? "index.tpl" : $section->template;
                } else {
                    $template = "index.tpl";
                }
            }
            SmartyUtil::getInstance()->assign("article", new CPage(null, getLanguage()));
            SmartyUtil::getInstance()->assign("section", new CSection(null, getLanguage()));
            //$outPageContent = SmartyUtil::getInstance()->fetch(getLangTemplate($template));
            $outPageContent = self::getOutPageContent($template);
            if ($section) {
                $cacheInfo = pGetSectionCacheInfo($section);
                if ($cacheInfo['cacheOption'] == PagePeer::CACHE_OPTION_ON) {
                    $expire = $cacheInfo["expire"];
                }
            }
        }
        $databaseManager->shutdown();
        $mainData = array('expire' => $expire, 'output' => $outPageContent);
        return $mainData;
    }

    public static function buildStaticContent($pageBId = '', $sectionBId = '', $templateB = '', $previewB = '') {
        $bulidIndex = false;
        if ($sectionBId) {
            $section = SectionPeer::retrieveByPK($sectionBId);
            $bulidIndex = false;
            $section->setCulture('en');
            if ($section->getName() == 'Home Page Setting') {
                $bulidIndex = true;
            }
        }
        $site_code = strtolower(rm2Util::getSiteCode());
        $staticPath = rapidManagerUtil::getStaticCacheDir();
        $langs = rm2Util::getLanguages(rm2Util::getSiteId());
        $oldLanguage = $_GET['language'];
        foreach ($langs as $key => $lang) {
            $curLanguage = $_GET['language'] = $lang->getLanguage();
            if ($pageBId) {
                $static = $staticPath . "p" . $pageBId . "_" . $curLanguage . ".html";
            } elseif ($sectionBId) {
                $static = $staticPath . "s" . $sectionBId . "_" . $curLanguage . ".html";
            } else {
                //template
                $static = $staticPath . "t" . $templateB . "_" . $curLanguage . ".html";
            }

            $pagContent = self::readPageContent($pageBId, $sectionBId, $templateB, $previewB);

            $outPageContent = $pagContent['output'];
            $startTime = time();
            $curentDate = date("Y-m-d H:i:s", $startTime);
            $outPageContent .="<!-- static curent:$startTime($curentDate) -->";
            $dirname = dirname($static);
            if (!file_exists($dirname)) {
                mkdir($dirname, 0777, true);
            }
            $fp = fopen($static, "w");
            if ($fp) {
                fwrite($fp, $outPageContent);
                fclose($fp);
                chmod($static, 0777);
            }
            if ($bulidIndex) {
                $fileSection = $static;
                $newFileSection = $staticPath . "index_" . $curLanguage . ".html";
                @unlink($newFileSection);
                @copy($fileSection, $newFileSection);
                @chmod($newFileSection, 0777);
            }
        }
        $_GET['language'] = $oldLanguage;
        setLanguage($_GET["language"]);
    }

    public static function getError404Page() {
        if (SF_APP == 'backend') {
            //create get or create 404 html
            $cacheDir = rapidManagerUtil::getFrontendSiteCacheDir();
            $static404 = $cacheDir . DIRECTORY_SEPARATOR . 'static' . DIRECTORY_SEPARATOR . '404.html';
            $frontendUrl = rm2Util::getSite()->getWebUrl() . "/404.php?checkDelete=1";
            if (file_exists($static404)) {
                $fp = fopen($static404, 'rb');
                if ($fp) {
                    flock($fp, LOCK_SH);
                    clearstatcache();
                    $filesize = filesize($static404);
                    if ($filesize > 0) {
                        $outPageContent = fread($fp, $filesize);
                    } else {
                        $outPageContent = false;
                    }
                    flock($fp, LOCK_UN);
                    fclose($fp);
                } else {
                    $outPageContent = "";
                }
            } else {
                self::checkValidUrlAndGetData($frontendUrl, $outPageContent, 0);
                $fp = fopen($static404, "w+");
                if ($fp) {
                    fwrite($fp, $outPageContent);
                    fclose($fp);
                    chmod($static404, 0777);
                }
            }

            return array('expire' => $expire, 'output' => $outPageContent);
        } else {
            return $expire = pDisplay404Page();
        }
    }

    public static function redirectPageUrl($url) {
        if (SF_APP == 'frontend') {
            $outPageContent = '<script>self.location="' . $url . '";</script>';
            $mainData = array('expire' => 0, 'output' => $outPageContent);
            return $mainData;
            //return header("location: " . $url);
        } else {
            $outPageContent = '<script>self.location="' . $url . '";</script>';
            $mainData = array('expire' => 0, 'output' => $outPageContent);
            return $mainData;
        }
    }

    public static function convertTimeByTimeZone($fromTimeZone, $toTimeZone, $dateTime, $format = 'Y-m-d H:i:s') {
        if (preg_match('/^[-|+][0-9]{1,}$/', $fromTimeZone)) {
            if ($fromTimeZone == 0) {
                $fromTimeZone = 'Etc/GMT';
            } elseif ($fromTimeZone < 0) {
                $fromTimeZone = 'Etc/GMT+' . abs($fromTimeZone);
            } elseif ($fromTimeZone > 0) {
                $fromTimeZone = 'Etc/GMT-' . $fromTimeZone*1;
            }
        }
        if (preg_match('/^[-|+][0-9]{1,}$/', $toTimeZone)) {
            if ($toTimeZone == 0) {

                $toTimeZone = 'Etc/GMT';
            } elseif ($toTimeZone < 0) {
                $toTimeZone = 'Etc/GMT+' . abs($toTimeZone);
            } elseif ($toTimeZone > 0) {
                $toTimeZone = 'Etc/GMT-' . $toTimeZone*1;
            }
        }
//        echo $fromTimeZone;echo $toTimeZone;
        $fromTimeZoneObj = new DateTimeZone($fromTimeZone);
        $toTimeZoneObj = new DateTimeZone($toTimeZone);
        $date = new DateTime($dateTime, $fromTimeZoneObj);
        $date->setTimezone($toTimeZoneObj);
        return $date->format($format);
    }

    public static function getClientZone($site_id) {
        $criteria = new Criteria();
        $criteria->add(SitePeer::ID, $site_id);
        $site = SitePeer::doSelectOne($criteria);
        if ($site->getTimezone() != '') {
            $criteria = new Criteria();
            $criteria->add(StatsTimezonePeer::ID, $site->getTimezone());
            $timezone = StatsTimezonePeer::doSelectOne($criteria);
            return $timezone->getName();
        } else {
            return 'America/New_York';
        }
    }

    public static function convertTimeToUTC($launchDate, $launchHour, $expiryDate, $expiryHour, $timezone,$totimezone='+0') {
        $rs = array();
        if ($launchDate) {
            $utcLauchTime = rapidManagerUtil::convertTimeByTimeZone($timezone, $totimezone, $launchDate . ' ' . $launchHour);
            //echo  $utcLauchTime;exit;
            $utcLauchTime = explode(' ', $utcLauchTime);
            
            $rs['launchDate'] = $utcLauchTime[0];
            $rs['launchHour'] = $utcLauchTime[1];
            
        }
        if ($expiryDate) {
            $utcExpiryTime = rapidManagerUtil::convertTimeByTimeZone($timezone,$totimezone, $expiryDate . ' ' . $expiryHour);
            $utcExpiryTime = explode(' ', $utcExpiryTime);
            $rs['expiryDate'] = $utcExpiryTime[0];
            $rs['expiryHour'] = $utcExpiryTime[1];
        }


       
        return $rs;
    }

    public function isFileInPublicPath($file, $publicPath) {
        $filePublicPath = $publicPath . $file;
        if ($file && strstr(realpath(dirname($filePublicPath)), realpath($publicPath)) && file_exists($filePublicPath)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getLangJsFile($fileName) {
        if (!$fileName)
            return '';
        $language = sfContext::getInstance()->getUser()->getCulture();
        $jsFileName = $fileName . '_' . $language . '.js';
        $defaultName = $fileName . '_en.js';
        $fullJsName = SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $jsFileName;
        if (file_exists($fullJsName)) {
            return '/js/lang/' . $jsFileName;
        } else {
            return '/js/lang/' . $defaultName;
        }
    }

    public static function getDefaultLimit() {
        return 20;
    }

    public static function smartyHandler($errno, $errstr, $errfile, $errline) {
        if (in_array($errno, array(1, 16, 64, 256, 4096))) {
            throw new sfException($errstr, $errline);
        }
        return true;
    }

    public static function cathFatError() {
        $redirectUrl = $_SESSION['redirect_url'];
        unset($_SESSION['redirect_url']);
        if (@is_array($e = @error_get_last())) {
            $code = isset($e['type']) ? $e['type'] : 0;
            $msg = isset($e['message']) ? $e['message'] : '';
            $file = isset($e['file']) ? $e['file'] : '';
            $line = isset($e['line']) ? $e['line'] : '';
            if ($code == 1) {
                $errorMessage = '[in ' . $file . ' line ' . $line . "]: $msg";
                self::addSmartyErrorMessage($errorMessage);
                if (SF_APP == 'frontend') {
                    //return $expire = pDisplay404Page();
                    echo "<br />Error: " . $errorMessage;
                    exit;
                } else {
                    if (rmCacheQueue::getLastQueueItem()) {
                        rmCacheQueue::builderErrorHandler($errorMessage, $file);
                        return false;
                    } else {
                        header("location: " . $redirectUrl);
                        exit;
                    }
                }
            } else {
                self::checkContentCompleted($redirectUrl);
            }
        } else {
            self::checkContentCompleted($redirectUrl);
        }
    }

    public static function checkContentCompleted($redirectUrl = '') {
        if (!$redirectUrl) {
            $redirectUrl = "/index.php/Section/index/fbt/1/fbc/1/fbn/1/rmsg/11";
        }
        if ($_SESSION['checkContentCompleted']['completed'] == false) {
            $errorTemplate = $_SESSION['checkContentCompleted']['template'];
            if (SF_APP == 'frontend') {
                echo "<br />Error in template: " . $errorTemplate;
                exit;
            } else {
                @ob_clean();
                $errorMessage = "Error in template: " . $errorTemplate;
                self::addSmartyErrorMessage($errorMessage);
                unset($_SESSION['checkContentCompleted']);
                if (rmCacheQueue::getLastQueueItem()) {
                    rmCacheQueue::builderErrorHandler($errorMessage, $errorTemplate);
                } else {
                    header("location: " . $redirectUrl);
                    exit;
                }
            }
        }
    }

    public static function getOutPageContent($template) {
        $smarty = SmartyUtil::getInstance();
        //$smarty->error_reporting = E_ERROR;
        $errorLevel = error_reporting();
        error_reporting(0);
        set_error_handler(array('rapidManagerUtil', 'smartyHandler'));
        register_shutdown_function(array('rapidManagerUtil', 'cathFatError'));
        try {
            $_SESSION['checkContentCompleted'] = array("completed" => false, "template" => $template);
            $outPageContent = $smarty->fetch(getLangTemplate($template));
            $_SESSION['checkContentCompleted'] = array("completed" => true, "template" => $template);
        } catch (Exception $exception) {
            $_SESSION['checkContentCompleted'] = array("completed" => true, "template" => $template);
            $message = $exception->getMessage();
            if (rmCacheQueue::getLastQueueItem()) {
                rmCacheQueue::builderErrorHandler($message, $template);
            }
            error_reporting($errorLevel);
            restore_error_handler();
            //throw $exception;
            self::addSmartyErrorMessage($message);
            $errorMessage = self::getSmartyErrorMessage(false);
            $outPageContent = $errorMessage;
            //rmsg as 11 to check smarty error
            $requeset = sfContext::getInstance()->getRequest()->setParameter("rmsg", "11");

            return $outPageContent;
        }
        error_reporting($errorLevel);
        restore_error_handler();
        return $outPageContent;
    }

    public static function addSmartyErrorMessage($message) {
        session_start();
        $errorMessage = array();
        $oldMessage = $_SESSION['smarty_error'];
        if ($oldMessage) {
            $errorMessage = array_merge($oldMessage, array($message));
        } else {
            $errorMessage = array($message);
        }
        $errorMessage = array_unique($errorMessage);
        $_SESSION['smarty_error'] = $errorMessage;
    }

    public static function getSmartyErrorMessage($unsetSession = true) {
        session_start();
        $errorMessage = $_SESSION['smarty_error'];
        $errorMessage = addslashes(implode("<br />", $errorMessage));
        if ($unsetSession == true) {
            unset($_SESSION['smarty_error']);
        }
        return $errorMessage;
    }

    public static function getEnableModules() {
        $enableModules = array();
        $yamlFile = self::getFrontendSiteDir(rm2Util::getSiteCode()) . DIRECTORY_SEPARATOR . "web" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "module.yml";
        if (file_exists($yamlFile)) {
            $modules = sfYaml::load($yamlFile);
            $enableModules = $modules["modules"];
        }
        return $enableModules;
    }

    public static function mysqlEscape($string, $callback = "intval") {
        $stringArray = explode(",", $string);
        return implode(",", array_map($callback, $stringArray));
    }

    public static function datetimeFormat($datetime, $format = 'Y-m-d H:i:s') {
        if (empty($datetime))
            $datetime = date("Y-m-d H:i:s");
        $datetime = new DateTime($datetime);
        return $datetime->format($format);
    }

    /**
     * recursively delete a directory that is not empty
     *
     * @param string $dir
     */
    public static function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public static function logMessage($message, $logFile = '') {
        $logDir = sfConfig::get('sf_log_dir');
        if (empty($logFile))
            $logFile = SF_APP . '_' . SF_ENVIRONMENT . '.log';
        $handle = fopen($logDir . DIRECTORY_SEPARATOR . $logFile, "a");
        fwrite($handle, date("Y-m-d H:i:s") . ": $message\n");
        fclose($handle);
        return true;
    }
    
   public static function createDir($path, $mode, $user, $group) {
        if (!file_exists($path)) {
            self::createDir(dirname($path), $mode, $user, $group);
            mkdir($path);
            exec("chmod -R $mode $path");
            exec("chown -R $user:$group $path");
        }
    }
   
   public static function writePathLogs($logPath, $data, $method = 'w') {
        $paths = pathinfo($logPath);
        $file = fopen($logPath, $method);
        flock($file, LOCK_EX);
        $filedetail = fwrite($file, $data);
        //write log
        if (!$filedetail) {
            //get filename
            $getFilename = explode('.', $paths['basename']);
            rapidManagerUtil::logMessage('File:' . $file . $paths['basename'] . ' Write Log Error: file path is ' . $logPath . $data, $getFilename[0] . '.log');
        }
        fclose($file);
    } 

    /**
     * read log
     * @param string $filename
     * @param string $method 
     * @return mixed
     */
    public static function readPathFile($filename, $method = 'r') {
        $file = fopen($filename, $method);
        flock($file, LOCK_SH);
        $filedetail = fread($file, filesize($filename));
        fclose($file);
        return $filedetail;
    } 
    
    public static function removeSameInMultiArray($array = array()) {
        $tmp_array = array();
        $new_array = array();
        foreach ($array as $val) {
            $hash = md5(json_encode($val));
            if (!in_array($hash, $tmp_array)) {
                $tmp_array[] = $hash;
                $new_array[] = $val;
            }
        }
        return $new_array;
    }

    public static function appendRankByKey($array, $key) {
        $flipRank = $newArray = $rank = array();
        $i = 1;
        foreach ($array as $unSortedData) {
            $nowKey = intval($unSortedData[$key]);
            if (in_array($nowKey, $rank)) {
                $unSortedData['rank'] = $flipRank[$nowKey];
            } else {
                $unSortedData['rank'] = $i;
                $rank[$i] = $nowKey;
                $flipRank = array_flip($rank);
            }
            $newArray[$i] = $unSortedData;
            $i++;
        }
        return $newArray;
    }
}