<?php
include_once "UtilForum.php";
include_once "UtilBreadCrumbNavigation.php";
global $enableModules;
if(isset($enableModules)){
	//If turn on some special module, include related files
	$frontendIncludePath = SF_ROOT_DIR . DIRECTORY_SEPARATOR . "frontend" . DIRECTORY_SEPARATOR . "includes";
	
	if(in_array("Scoring", $enableModules)){
		$statsUtilFile = $frontendIncludePath . DIRECTORY_SEPARATOR . "stats" . DIRECTORY_SEPARATOR . "statsUtil.php";
		if(file_exists($statsUtilFile)) include_once($statsUtilFile);
	}
	
	if(in_array("ConnectCjfl", $enableModules)){
		$cjflUtilFile = $frontendIncludePath . DIRECTORY_SEPARATOR . "cjfl" . DIRECTORY_SEPARATOR . "CjflUtil.php";
		if(file_exists($cjflUtilFile)) include_once($cjflUtilFile);
	}
}


function utilGetSphinxLimit($curPage=1 , $pageSize=20){
    $curPage = intval($curPage);
    if($curPage<=0)$curPage=1;
    $limit= (($curPage-1)*$pageSize) . ",".$pageSize;
    return $limit;
}


function utilGetPoll() {
	$polls = utilGetPolls(1);
	return $polls[0];
}

function utilGetPollById($pollId) {
	return utilToCPoll(PollPeer::retrieveByPK($pollId));
}

function utilGetPollByGroupTag($tag) {
	$polls = utilGetPollsByGroupTag($tag, 1);
	return $polls[0];
}

function utilGetPollByGroupId($groupId) {
	$polls = utilGetPollsByGroupId($groupId, 1);
	return $polls[0];
}

function utilGetPolls($limit) {
	$p = array(rm2Util::getSiteId());
	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}

	$sql = "SELECT poll.* FROM %%poll%% AS poll
			 WHERE poll.site_id=? 
			   AND poll.active=1 
			  $AND_search 
			  $AND_group 
			  ORDER BY poll.id DESC
			  $LIMIT";
	$sql = str_replace("%%poll%%", PollPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%poll_i18n%%", PollI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%pollgrouppoll%%", PollGroupPollPeer::TABLE_NAME, $sql);
	$pollList = rm2Util::execSql($sql, $p, "PollPeer");
	return utilToCPoll($pollList);
}
function utilGetPollGroupByTag($tag) {
	$p = array(rm2Util::getSiteId(), $tag);
	$sql = "SELECT * FROM %%pollGroup%% AS pollGroup
			 WHERE pollGroup.site_id=? AND pollGroup.active=1 AND pollGroup.display_tag=?";
	$sql = str_replace("%%pollGroup%%", PollGroupPeer::TABLE_NAME, $sql);
	$groupList = rm2Util::execSql($sql, $p, "PollGroupPeer");
	return utilToCPollGroup($groupList[0]);
}

function utilGetPollsByGroupTag($tag, $limit="") {
	$group = utilGetPollGroupByTag($tag);
	if ($group != null) {
		return utilGetPollsByGroupId($group->getId(), $limit);
	}
}

function utilGetPollsByGroupId($groupId, $limit="") {
	$p = array(rm2Util::getSiteId());
	$AND_group = "";
	if ($groupId != "") {
		$AND_group = "AND poll.id IN (SELECT poll_id FROM %%pollgrouppoll%% WHERE site_id=? AND poll_group_id=?)";
		$p[] = rm2Util::getSiteId();
		$p[] = $groupId;
	}

	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}

	$sql = "SELECT poll.* FROM %%poll%% AS poll
			 WHERE poll.site_id=? 
			   AND poll.active=1 
			  $AND_search 
			  $AND_group 
			  ORDER BY poll.id DESC
			  $LIMIT";
	$sql = str_replace("%%poll%%", PollPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%poll_i18n%%", PollI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%pollgrouppoll%%", PollGroupPollPeer::TABLE_NAME, $sql);
	$pollList = rm2Util::execSql($sql, $p, "PollPeer");
	return utilToCPoll($pollList);
}

function utilToCWine($o) {
	if ($o == null) return null;
	if (is_array($o)) {
		$list = array();
		foreach($o as $item) {
			$list[] = new CWine($item, getLanguage());
		}
		return $list;
	} else {
		return new CWine($o, getLanguage());
	}
}

function utilToCPage($o,$replacePreview=1) {
	if ($o == null) return null;
	if (is_array($o)) {
		$list = array();
        foreach($o as $item) {
			$list[] = new CPage($item, getLanguage(),$replacePreview);
        }
		return $list;
	} else {
		return new CPage($o, getLanguage(),$replacePreview);
	}
}

function utilToCPoll($o) {
	if ($o == null) return null;
	if (is_array($o)) {
		$list = array();
		foreach($o as $item) {
			$list[] = new CPoll($item, getLanguage());
		}
		return $list;
	} else {
		return new CPoll($o, getLanguage());
	}
}

function utilToCPollGroup($o) {
	if ($o == null) return null;
	if (is_array($o)) {
		$list = array();
		foreach($o as $item) {
			$list[] = new CPollGroup($item);
		}
		return $list;
	} else {
		return new CPollGroup($o);
	}
}

function utilToCSection($o) {
	if ($o == null) return null;
	if (is_array($o)) {
		$list = array();
		foreach($o as $item) {
			$list[] = new CSection($item, getLanguage());
		}
		return $list;
	} else {
		return new CSection($o, getLanguage());
	}
}

function utilToCCategory($o) {
	if ($o == null) return null;
	if (is_array($o)) {
		$list = array();
		foreach($o as $item) {
			$list[] = new CCategory($item, getLanguage());
		}
		return $list;
	} else {
		return new CCategory($o, getLanguage());
	}
}

function utilToCArticle($o, $ref="") {
	if ($o == null) return null;
	if (is_array($o)) {
		$list = array();
		foreach($o as $item) {
			$list[] = new CArticle($item, getLanguage());
		}
		return $list;
	} else {
		return new CArticle($o, getLanguage(), $ref);
	}
}

function utilToMediaFile($o, $ref="") {
	if ($o == null) return null;
	if (is_array($o)) {
		$list = array();
		foreach($o as $item) {
			$list[] = new CMediaFile($item, getLanguage());
		}
		return $list;
	} else {
		return new CMediaFile($o, getLanguage(), $ref);
	}
}

function utilToForm($o, $ref="") {
	if ($o == null) return null;
	if (is_array($o)) {
		$list = array();
		foreach($o as $item) {
			$list[] = new CForm($item, getLanguage());
		}
		return $list;
	} else {
		return new CForm($o, getLanguage(), $ref);
	}
}

function utilGetSectionsByName($sectionName, $parentId="", $limit="", $sortBy="", $sort="DESC") {
	$SITEID = rm2Util::getSiteId();
	$p = array($SITEID, getLanguage());
	//$p = array(rm2Util::getSiteId());
	$currentCulture = getLanguage();

	$AND_search = "";
	if ($sectionName != "") {
		$AND_search .= "AND section.id IN (SELECT id FROM %%section_i18n%% WHERE name=? AND site_id = '$SITEID' )";
		$p[] = "$sectionName";
	}
	
	$AND_parent = "";
	if ($parentId !== "") {
		$AND_parent = "AND section.parent_id=?";
		$p[] = (int)$parentId;
	}

	$ORDERBY = "";
	
	if ($sortBy == "modifiedDate") { $sortBy = "section.updated_at"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "section.created_at"; } 
	elseif ($sortBy == "name") { $sortBy = "section_i18n.name"; } 
	elseif ($sortBy == "id") { $sortBy = "section.id"; } 
	elseif ($sortBy == "sortOrder") { $sortBy = "section.sort_order"; } 
	else { $sortBy = "section.id"; }

	if ($sortBy != "") {
		$ORDERBY = "ORDER BY $sortBy $sort";
	}
		
	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}

	$sql = "SELECT section.* FROM %%section%% AS section, %%section_i18n%% AS section_i18n 
			 WHERE section.site_id=? AND section.id=section_i18n.id
			   AND (section.active=1 OR section.redirect_active=1) 
			   AND section_i18n.culture = ?
			  $AND_search 
			  $AND_parent 
			  $ORDERBY  
			  $LIMIT";
	$sql = str_replace("%%section%%", SectionPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%section_i18n%%", SectionI18nPeer::TABLE_NAME, $sql);
	$sectionList = rm2Util::execSql($sql, $p, "SectionPeer");
	return utilToCSection($sectionList);
}

function utilGetSectionByName($sectionName, $parentId="") {
	$sectionNamePath = explode("/", $sectionName);
	if ($parentId == "") { $parentId = 0; }
	foreach($sectionNamePath as $name) {
		$sections = utilGetSectionsByName($name, $parentId, 1);
		if ($sections[0] == null) return null;
		$parentId = $sections[0]->getId();
	}
	
	return $sections[0];
}

function utilGetDropDownSectionsByParent($parent="", $sortBy="", $sort="ASC") {
	if ($parent === 0 || $parent === '0') {
		$parentId = 0;
	} else {
		$parentSection = utilGetSectionById((int)$parent);
		if ($parentSection == null) { $parentSection = utilGetSectionByName($parent); }
		if ($parentSection != null) {
			$parentId = $parentSection->getId();
		} else {
			$parentId = 0;
		}
	}
	
	$p = array(rm2Util::getSiteId(), $parentId);
	
	$ORDERBY = "";
	
	if ($sortBy == "modifiedDate") { $sortBy = "section.updated_at"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "section.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "section.id"; } 
	elseif ($sortBy == "sortOrder") { $sortBy = "section.sort_order"; } 
	else { $sortBy = "section.sort_order"; }

	if ($sortBy != "") {
		$ORDERBY = "ORDER BY $sortBy $sort";
	}

	$sql = "SELECT * FROM %%section%% AS section
			 WHERE section.site_id=? 
			   AND (section.active=1 OR section.redirect_active=1) 
			   AND (section.show_dropdown=1) 
			   AND section.parent_id=? 
			  $ORDERBY 
			  $LIMIT";
	
	$sql = str_replace("%%section%%", SectionPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%section_i18n%%", SectionI18nPeer::TABLE_NAME, $sql);
	$sectionList = rm2Util::execSql($sql, $p, "SectionPeer");
	return utilToCSection($sectionList);
}

/**
 * all the codes below are from mysql prodeducer of spDropDownSections
 * get Menus
 */
function getMenuChildsByParentId($parentId='' , $sortBy="sort_order" , $sort="ASC" , $level = 0){
    $siteId = rm2Util::getSiteId();
    $culture = getLanguage();
    $parentId = (int)$parentId;

    $sql = "SELECT section.id, section_i18n.name, section.redirect_active, section.redirect_url, section.redirect_type  
            FROM section
            LEFT JOIN section_i18n ON section.id = section_i18n.id
            LEFT JOIN section_share ON (section_share.section_id = section.id AND section_share.site_sharing=section.site_id)
            WHERE (section.site_id=".$siteId." OR section_share.site_shared=".$siteId.")
                AND section.id=section_i18n.id
                AND (section.active=1 OR section.redirect_active=1) 
                AND (section.show_dropdown=1) 
                AND section_i18n.culture='".$culture."' 
                AND section.parent_id=".$parentId." 
            ORDER BY ".$sortBy." ".$sort.", section.id ASC";
    
    $connection = Propel::getConnection(UserPeer::DATABASE_NAME);
    $result = $connection->executeQuery ($sql);
    
    $rows = getRowsFromResultSet($result);
    if($level<3){
        foreach($rows as $index=>$row){
            $rows[$index]['childs'] = getMenuChildsByParentId($row['id'] ,  $sortBy  , $sort  , $level + 1);
        }
    }
    return $rows;
}
function getRowsFromResultSet($result){
    $rows = array();
    while($result->next()){
        $rows[]=$result->getRow();
    }
    return $rows;
}

/**
 * This is from mysql function, we need to hardcode it, it's hard to move it to smarty
 */
function getSectionUrlByMenuItem($row){
    $isOpenInTheNewWindow = false ;
    if($row['redirect_active']){
        if($row['redirect_type'] > 0){  //open in the new window
            $isOpenInTheNewWindow = true ;
        }
        $url = $row['redirect_url'] ;
    }else{
        $url = "/".str_replace(" ","-" , utilClearCharacter(strtolower($row['name']))) . '-s'.$row['id'];
    }
    return array(
        'isOpenInTheNewWindow'=> $isOpenInTheNewWindow ,
        'url'=>$url,
    );
}

function getMenuHtmlArray($rows , $level = 1){
    $html = '';
    if($level ==1 ){
        foreach($rows as $index=> $row){
            $nameHtmlValue = htmlspecialchars($row['name']);
            $urlData = getSectionUrlByMenuItem($row);
            $html .='<ul><li><h2><a class="LS_nav'.($index + 1).'" href="'.$urlData['url'].'"'.($urlData['isOpenInTheNewWindow'] ? ' target="_blank" ': '').' title="'.$nameHtmlValue.'"><span>'.$nameHtmlValue.'</span></a></h2>';
            if(isset($row['childs']) && is_array($row['childs']) && !empty($row['childs'])){
                $html .= getMenuHtmlArray($row['childs'] , $level+1 );
            }
            $html .= "</li></ul>";
        }
    }else{
        $html .= "<ul>";
        foreach($rows as $index=>$row){
            $nameHtmlValue = htmlspecialchars($row['name']);
            $urlData = getSectionUrlByMenuItem($row);
            $html .='<li><a href="'.$urlData['url'].'"'.($urlData['isOpenInTheNewWindow'] ? ' target="_blank" ': '').' title="'.$nameHtmlValue.'"><span>'.$nameHtmlValue.'</span></a>';
            if(isset($row['childs']) && is_array($row['childs']) && !empty($row['childs'])){
                $html .= getMenuHtmlArray($row['childs'] , $level+1 );
            }
        }
        $html.="</ul>";
    }
    return $html;
}

function utilGetDropDownSectionsByParentId($parentId="", $sortBy="sort_order", $sort="ASC") {
    $siteId = rm2Util::getSiteId();
    $culture = getLanguage();
    $parentId = (int)$parentId;
    
    $cacheKey = "site_top_menu_html_".$siteId."_".$culture."_".$parentId;
    
    if(isset($_SESSION[$cacheKey])){
        $html = $_SESSION[$cacheKey];
    }else{
        $rows = getMenuChildsByParentId($parentId, $sortBy, $sort);
        $html = getMenuHtmlArray($rows);
        //$html = getMenusFromMysqlFunction($parentId, $sortBy, $sort);
        //$_SESSION[$cacheKey] = $html ;
    }
    
    SmartyUtil::getInstance()->assign("memberId", $_SESSION['memberId']);
    SiteUtil::getSmarty()->assign("memberId", $_SESSION['memberId']);
    SmartyUtil::getInstance()->assign("membercategoryId", $_SESSION['categoryLevel']);
    SiteUtil::getSmarty()->assign("membercategoryId", $_SESSION['categoryLevel']);
    return $html;
}

function getMenusFromMysqlFunction($parentId="", $sortBy="sort_order", $sort="ASC"){
    $site_id = rm2Util::getSiteId();
    $lang = getLanguage();
    $parentId = (int)$parentId;
    
    $sql = "call spDropDownSections($site_id, $parentId, '$lang', '$sortBy', '$sort')";
    
    $connection = Propel::getConnection(UserPeer::DATABASE_NAME);
    $dsninfo = $connection->getDSN();
    if (isset($dsninfo['protocol']) && $dsninfo['protocol'] == 'unix') {
        $dbhost = ':' . $dsninfo['socket'];
    } else {
        $dbhost = $dsninfo['hostspec'] ? $dsninfo['hostspec'] : 'localhost';
        if (!empty($dsninfo['port'])) {
            $dbhost .= ':' . $dsninfo['port'];
        }
    }
    $user = $dsninfo['username'];
    $pw = $dsninfo['password'];
    $encoding = !empty($dsninfo['encoding']) ? $dsninfo['encoding'] : null;
    // define that client supports the multiple statements
    define('CLIENT_MULTI_STATEMENTS',65536);
    // define that client supports multiple results
    define('CLIENT_MULTI_RESULTS',131072);
    $conn = mysql_connect($dbhost, $user, $pw, null, CLIENT_MULTI_STATEMENTS|CLIENT_MULTI_RESULTS);
    mysql_select_db($dsninfo['database'], $conn);
    if ($encoding) {
        mysql_query("SET NAMES " . $encoding);
    }
    $resultSet = mysql_query($sql, $conn);
    $row = mysql_fetch_array($resultSet, MYSQL_NUM);
    $dropdown = $row[0];
    mysql_free_result($resultSet);
    mysql_close($conn);
    return $dropdown ;
}
/**
 * end  the logic of spDropDownSections
 */


function utilGetSectionById($sectionId) {
	return utilToCSection(SectionPeer::retrieveByPK($sectionId));
}
function utilGetSectionByPageId($pageId) {
 	$c =  new Criteria();
 	$c->add(SectionPagePeer::PAGE_ID,$pageId);
 	$sessionPage = SectionPagePeer::doSelectOne($c);
 	if($sessionPage){
		$sectionId = $sessionPage->getSectionId();
 	}else{
 		return null;
 	}
	return utilToCSection(SectionPeer::retrieveByPK($sectionId));
 }

function utilGet404Page() {
	$criteria = new Criteria();
	$criteria->addJoin(PagePeer::ID, PageI18nPeer::ID);
	$criteria->add(PagePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(PageI18nPeer::CULTURE, rm2Util::getDefaultLanguage());
	$criteria->add(PageI18nPeer::TITLE, "404");
	$page = PagePeer::doSelectOne($criteria);
	if ($page == null) return null;
	else return utilToCPage($page);
}

function utilGetPageBySectionId($sectionId, $redirect=true) {
	$siteId = rm2Util::getSiteId();
    $p = array();
    $p[] = $siteId;
    $p[] = $siteId;

	$AND_section = "";
	if ($sectionId != "") {
		$AND_section = " AND section_page.section_id=? ";
		$p[] = $sectionId;
	}

    // get the site ids
    $siteIds = array(rm2Util::getSiteId());
    $criteria = new Criteria();
    $criteria->add(SectionSharePeer::SITE_SHARED, rm2Util::getSiteId());
    $criteria->addGroupByColumn(SectionSharePeer::SITE_SHARING);
    $sections = SectionSharePeer::doSelect($criteria);
    if($sections){
        foreach($sections as $section){
            array_push($siteIds, $section->getSiteSharing());
        }
    }
	$sql = "SELECT page.* FROM %%page%% AS page
             LEFT JOIN %%sectionpage%% AS section_page ON page.id = section_page.page_id
             LEFT JOIN %%section%% AS section ON section_page.section_id = section.id
             LEFT JOIN %%sectionshare%% AS section_share ON (section_share.section_id = section.id and section_share.site_sharing=section.site_id)
			 WHERE page.site_id IN (".implode(',', array_unique($siteIds)).")
               AND (page.site_id=? OR section_share.site_shared=?)
               $AND_section 
			   AND (page.active=1 OR page.redirect_active=1) 
			   AND ((page.launch_date IS NULL OR page.launch_date='') OR (CONCAT(page.launch_date, ' ', page.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((page.expiry_date IS NULL OR page.expiry_date='') OR (CONCAT(page.expiry_date, ' ', page.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			  ORDER BY page.display_date DESC, page.created_at DESC, page.sort_order DESC   
			  LIMIT 0,1 ";
	$sql = str_replace("%%page%%", PagePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $sql);
    $sql = str_replace("%%section%%", SectionPeer::TABLE_NAME, $sql);
    $sql = str_replace("%%sectionshare%%", SectionSharePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%sectionpage%%", SectionPagePeer::TABLE_NAME, $sql);
	$pageList = rm2Util::execSql($sql, $p, "PagePeer");
	return utilToCPage($pageList[0]);
}

function utilGetChildSectionId($sectionId, $recursive) {
	$p = array(rm2Util::getSiteId(), $sectionId);
	$sql = "SELECT * FROM %%section%% WHERE site_id=? AND parent_id=? AND (active = 1 OR redirect_active = 1)";
	$sql = str_replace("%%section%%", SectionPeer::TABLE_NAME, $sql);
	$sectionList = rm2Util::execSql($sql, $p, "SectionPeer");
	$a = array();
	foreach($sectionList as $section) {
		$a[] = $section->getId();
		if ($recursive == true) {
			$c = utilGetChildSectionId($section->getId(), $recursive);
			$a = array_merge($a, $c);
		}
	}
	return $a;
}

function utilGetPagesBySectionId($sectionId, $limit="", $search="", $sortBy="createdDate", $sort="DESC", $tag="", $recursive=false, $siteMap=false,$replacePreview=1) {
	$siteId = rm2Util::getSiteId();
    $p = array();
    $p[] = $siteId;
    $p[] = $siteId;

	$AND_search = "";
    if ($search != "") {
		$AND_search .= "AND page.id IN (SELECT id FROM %%page_i18n%% WHERE title like ?)";
		$p[] = "%$search%";
	}

	$AND_tag = "";
	if ($tag != "") {
		$AND_tag .= "AND page.id IN (SELECT id FROM %%page_i18n%% WHERE meta_keyword like ?)";
		$p[] = "%$tag%";
	}
	
	if ($recursive == true) {
		$AND_section = "";
		if ($sectionId != "") {
			$sectionTmp = (array)explode(',', $sectionId);
			foreach ($sectionTmp as $sectionId){
				$sectionIds .= $sectionId . ",";
				$childSectionIds = utilGetChildSectionId($sectionId, $recursive);
				foreach($childSectionIds as $childSectionId) {
					$sectionIds .= $childSectionId . ",";
				}
			}
			$sectionIds = substr($sectionIds, 0, strlen($sectionIds)-1);
            $AND_section = "AND section_page.section_id IN ($sectionIds) ";
		}
	} else {
		$AND_section = "";
		if ($sectionId != "") {
            $AND_section = "AND section_page.section_id IN ($sectionId) ";
		}
	}

	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}
	
	$ORDERBY = "";
	if ($sortBy == "modifiedDate") { $sortBy = "page.updated_at"; } 
	elseif ($sortBy == "displayDate") { $sortBy = "page.display_date"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "page.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "page.id"; } 
	elseif ($sortBy == "title") { $sortBy = "page_i18n.title"; } 
	else { $sortBy = "page.sort_order"; }

	if ($sortBy != "") {
		$ORDERBY = "ORDER BY $sortBy $sort";
	}
	
	$AND_siteMap = "";
	if($siteMap){
		$AND_siteMap = " AND page.showSiteMap = 1";
	}

    // get the site ids
    $siteIds = array(rm2Util::getSiteId());
    $criteria = new Criteria();
    $criteria->add(SectionSharePeer::SITE_SHARED, rm2Util::getSiteId());
    $criteria->addGroupByColumn(SectionSharePeer::SITE_SHARING);
    $sections = SectionSharePeer::doSelect($criteria);
    if($sections){
        foreach($sections as $section){
            array_push($siteIds, $section->getSiteSharing());
        }
    }
	$sql = "SELECT DISTINCT * FROM %%page%% AS page LEFT JOIN %%page_i18n%% AS page_i18n ON page.id = page_i18n.id
             LEFT JOIN %%sectionpage%% AS section_page ON page_i18n.id = section_page.page_id
             LEFT JOIN %%section%% AS section ON section_page.section_id = section.id
             LEFT JOIN %%sectionshare%% AS section_share ON (section_share.section_id = section.id and section_share.site_sharing=section.site_id)
             WHERE page.site_id IN (".implode(',', array_unique($siteIds)).")
               AND (page.site_id=? OR section_share.site_shared=?)
			   AND page_i18n.culture = '".getLanguage()."'
			   AND (page.active=1 OR page.redirect_active=1) 
			   AND ((page.launch_date IS NULL OR page.launch_date='') OR (CONCAT(page.launch_date, ' ', page.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((page.expiry_date IS NULL OR page.expiry_date='') OR (CONCAT(page.expiry_date, ' ', page.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			  $AND_search 
			  $AND_tag 
			  $AND_section 
			  $AND_siteMap
			  $ORDERBY  
			  $LIMIT ";
	$sql = str_replace("%%page%%", PagePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $sql);
    $sql = str_replace("%%section%%", SectionPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%sectionpage%%", SectionPagePeer::TABLE_NAME, $sql);
    $sql = str_replace("%%sectionshare%%", SectionSharePeer::TABLE_NAME, $sql);
    $pageList = rm2Util::execSql($sql, $p, "PagePeer");
	return utilToCPage($pageList,$replacePreview);
}

function utilInitAttributes($pages , $steep=0){
    $isArray = is_array($pages);
    if(!$isArray)$pages = array($pages);
    
    $needToConvertClassNames=array(
        'CPage',
        'CSection',
        'CMediaFile',
    );
    
    $ignoreFields = array(
        'instance'
    );
    
    $data = array();
    foreach($pages as $page){
        if(!is_object($page)) continue;
        $vars = $page->getAllVars();
        if(!is_array($vars))$vars = array();

        $row = array();
        foreach($vars as $name=>$value){
            try{
                if(in_array($name , $ignoreFields)){
                    continue;
                }
                $row[$name] =@ $page->$name;
                if(gettype($row[$name]) == "object" && in_array( get_class( $row[$name])  , $needToConvertClassNames)){
                    if($steep<=2){
                        $row[$name] = utilInitAttributes($row[$name] , $steep+1);
                    }
                }
            }catch(Exception $ex){
                
            }
        }
        $data [] = $row;
    }
    if(!$isArray){
        return $data[0];
    }
    return $data;
}

function utilGetPagesBySectionIdFilterDate($sectionId, $limit="", $year="", $month="", $sortBy="createdDate", $sort="DESC", $tag="", $recursive=false, $siteMap=false,$replacePreview=1) {
	$p = array(rm2Util::getSiteId());

    $AND_search = "";
    if ($year != ""){
        if($month != ""){
            $month = sprintf("%02d",$month);
            $AND_search .= "AND page.id IN (SELECT id FROM %%page%% WHERE page.created_at >= ? AND page.created_at <= ?)";
            $p[] = "$year-$month-01";
		    $p[] = "$year-$month-31";
        }else{
            $AND_search .= "AND page.id IN (SELECT id FROM %%page%% WHERE page.created_at >= ? AND page.created_at <= ?)";
            $p[] = "$year-01-01";
		    $p[] = "$year-12-31";        
        }
    }

	$AND_tag = "";
	if ($tag != "") {
		$AND_tag .= "AND page.id IN (SELECT id FROM %%page_i18n%% WHERE meta_keyword like ?)";
		$p[] = "%$tag%";
	}
	
	if ($recursive == true) {
		$AND_section = "";
		if ($sectionId != "") {
			$sectionTmp = (array)explode(',', $sectionId);
			foreach ($sectionTmp as $sectionId){
				$sectionIds .= $sectionId . ",";
				$childSectionIds = utilGetChildSectionId($sectionId, $recursive);
				foreach($childSectionIds as $childSectionId) {
					$sectionIds .= $childSectionId . ",";
				}
			}
			$sectionIds = substr($sectionIds, 0, strlen($sectionIds)-1);
			$AND_section = "AND page.id IN (SELECT page_id FROM %%sectionpage%% WHERE site_id=? AND section_id IN (".rapidManagerUtil::mysqlEscape($sectionIds)."))";
			$p[] = rm2Util::getSiteId();
			$p[] = $sectionId;
		}
	} else {
		$AND_section = "";
		if ($sectionId != "") {
			$AND_section = "AND page.id IN (SELECT page_id FROM %%sectionpage%% WHERE site_id=? AND section_id IN (".rapidManagerUtil::mysqlEscape($sectionId)."))";
			$p[] = rm2Util::getSiteId();
			$p[] = $sectionId;
		}
	}

	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}
	
	$ORDERBY = "";
	
	if ($sortBy == "modifiedDate") { $sortBy = "page.updated_at"; } 
	elseif ($sortBy == "displayDate") { $sortBy = "page.display_date"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "page.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "page.id"; } 
	else { $sortBy = "page.sort_order"; }

	if ($sortBy != "") {
		$ORDERBY = " ORDER BY $sortBy $sort";
	}
	
	$AND_siteMap = "";
	if($siteMap){
		$AND_siteMap = " AND page.showSiteMap = 1";
	}

	$sql = "SELECT * FROM %%page%% AS page
			 WHERE page.site_id=? 
			   AND (page.active=1 OR page.redirect_active=1) 
			   AND ((page.launch_date IS NULL OR page.launch_date='') OR (CONCAT(page.launch_date, ' ', page.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((page.expiry_date IS NULL OR page.expiry_date='') OR (CONCAT(page.expiry_date, ' ', page.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			  $AND_search 
			  $AND_tag 
			  $AND_section 
			  $AND_siteMap
			  $ORDERBY  
			  $LIMIT ";
	$sql = str_replace("%%page%%", PagePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $sql);
    $sql = str_replace("%%sectionpage%%", SectionPagePeer::TABLE_NAME, $sql);
    $pageList = rm2Util::execSql($sql, $p, "PagePeer");
	return utilToCPage($pageList,$replacePreview);
}

function utilGetPagesBySectionName($sectionName, $parentId=0, $limit="", $sortBy="createdDate", $sort="DESC", $tag="", $recursive=false) {
    $sectionNameTmp = (array)explode(',', $sectionName);
	$sectionId = "";
	foreach ($sectionNameTmp as $sectionName){
		$section = utilGetSectionByName($sectionName, $parentId);
		if($section){
			$sectionId .= $section->getId() . ',';
		}
	}
	$sectionId = substr($sectionId, 0, strlen($sectionId)-1);
	if (!$sectionId) { return array(); }
	return utilGetPagesBySectionId($sectionId, $limit, "", $sortBy, $sort, $tag, $recursive);
}

function utilGetPagesBySectionNameWithoutEmptyPreview($sectionName, $parentId=0, $limit="", $sortBy="createdDate", $sort="DESC", $tag="", $recursive=false) {
    $sectionNameTmp = (array)explode(',', $sectionName);
	$sectionId = "";
	foreach ($sectionNameTmp as $sectionName){
		$section = utilGetSectionByName($sectionName, $parentId);
		if($section){
			$sectionId .= $section->getId() . ',';
		}
	}
    $sectionId = substr($sectionId, 0, strlen($sectionId)-1);
    if (!$sectionId) { return array(); }
	return utilGetPagesBySectionId($sectionId, $limit, "", $sortBy, $sort, $tag, $recursive,false,0);
}

function utilGetPagesByPageName($pageName) {
	$p = array(rm2Util::getSiteId(),$pageName);
	$sql = "SELECT * FROM %%page%% AS page LEFT JOIN %%page_i18n%% AS page_i18n ON page.id = page_i18n.id
			 WHERE page.site_id=? AND (page.active=1 OR page.redirect_active=1)
			   AND page_i18n.title = ? ";
	$sql = str_replace("%%page%%", PagePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $sql);
	$pageList = rm2Util::execSql($sql, $p, "PagePeer");
	return utilToCPage($pageList[0]);
	
}




function utilGetWineIdByPageId($pageId){
    $c = new Criteria();
    $c->add(WinePeer::SITE_ID,rm2Util::getSiteId());
    $c->add(WinePeer::PAGE_ID,$pageId);
    $wine = WinePeer::doSelectOne($c);
    if($wine){
        return utilToCWine($wine);
    }
}

function utilGetSimilarWineByWine($wineId, $limit=5, $sortBy='createdDate', $sort='desc' ){
	$similarWine = wineTools::getSimilarWineByWine($wineId, $limit, $sortBy, $sort);
	return utilToCWine($similarWine);
	
}

function utilGetPageListBySectionName($sectionName, $parentId=0, $pageId="", $limit="", $sortBy="createdDate", $sort="DESC", $tag="", $recursive=false){
	
	
	$sectionNameTmp = (array)explode(',', $sectionName);
	$sectionId = "";
	foreach ($sectionNameTmp as $sectionName){
		$section = utilGetSectionByName($sectionName, $parentId);
		if($section){
			$sectionId .= $section->getId() . ',';
		}
	}
	$sectionId = substr($sectionId, 0, strlen($sectionId)-1);
	if (!$sectionId) { return array(); }
	
	
	$p = array(rm2Util::getSiteId());

	$AND_search = "";
	if ($search != "") {
		$AND_search .= "AND page.id IN (SELECT id FROM %%page_i18n%% WHERE title like ?)";
		$p[] = "%$search%";
	}

	$AND_tag = "";
	if ($tag != "") {
		$AND_tag .= "AND page.id IN (SELECT id FROM %%page_i18n%% WHERE meta_keyword like ?)";
		$p[] = "%$tag%";
	}
	
	if ($recursive == true) {
		$AND_section = "";
		if ($sectionId != "") {
			$sectionTmp = (array)explode(',', $sectionId);
			foreach ($sectionTmp as $sectionId){
				$sectionIds .= $sectionId . ",";
				$childSectionIds = utilGetChildSectionId($sectionId, $recursive);
				foreach($childSectionIds as $childSectionId) {
					$sectionIds .= $childSectionId . ",";
				}
			}
			$sectionIds = substr($sectionIds, 0, strlen($sectionIds)-1);
			$AND_section = "AND page.id IN (SELECT page_id FROM %%sectionpage%% WHERE site_id=? AND section_id IN (".rapidManagerUtil::mysqlEscape($sectionIds)."))";
			$p[] = rm2Util::getSiteId();
			$p[] = $sectionId;
		}
	} else {
		$AND_section = "";
		if ($sectionId != "") {
			$AND_section = "AND page.id IN (SELECT page_id FROM %%sectionpage%% WHERE site_id=? AND section_id IN (".rapidManagerUtil::mysqlEscape($sectionId)."))";
			$p[] = rm2Util::getSiteId();
			$p[] = $sectionId;
		}
	}

	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}
	
	$ORDERBY = "";
	
	if ($sortBy == "modifiedDate") { $sortBy = "page.updated_at"; } 
	elseif ($sortBy == "displayDate") { $sortBy = "page.display_date"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "page.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "page.id"; } 
	else { $sortBy = "page.sort_order"; }

	if ($sortBy != "") {
		$ORDERBY = "ORDER BY $sortBy $sort";
	}
	$AndPageId = "";
	if($pageId !=""){
		$AndPageId = " AND page.id != $pageId ";
	}

	$sql = "SELECT * FROM %%page%% AS page
			 WHERE page.site_id=? 
			   AND (page.active=1 OR page.redirect_active=1) 
			   AND ((page.launch_date IS NULL OR page.launch_date='') OR (CONCAT(page.launch_date, ' ', page.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((page.expiry_date IS NULL OR page.expiry_date='') OR (CONCAT(page.expiry_date, ' ', page.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			  $AND_search 
			  $AND_tag 
			  $AND_section
			  $AndPageId 
			  $ORDERBY  
			  $LIMIT ";
	$sql = str_replace("%%page%%", PagePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%sectionpage%%", SectionPagePeer::TABLE_NAME, $sql);
	$pager = rm2Util::pagerSql(rm2Util::sortBySql($sql), $p, "PagePeer");
	$url_this = "http://".$_SERVER ['HTTP_HOST'].$_SERVER["REQUEST_URI"];
	$pageArray = array();
   	if($pager['pagerPage'] > 0){
   		$pageArray = range(1,$pager['pagerPage']);
   	}
  	$url_this = str_replace("/pager-".$pager['pager'], "", $url_this);

   	foreach ($pageArray as $page){
   		$newstr = $str.'&pager='.$page;
   		if($page == $pager['pager']){
   			$linkUrl .= $page. " ";
   		}else{
   			$linkUrl .= '<a href="'.$url_this.'/pager-'.$page.'">'.$page. "</a> ";
   		}
   	}
	SmartyUtil::getInstance()->assign("linkUrl", $linkUrl);
	SmartyUtil::getInstance()->assign("culture", getLanguage());
	return $pager;
}




function utilGetMediaPagesBySectionId($sectionId, $limit="", $search="", $media="", $tag="") {
	
	$p = array(rm2Util::getSiteId());

	$AND_search = "";
	if ($search != "") {
		$AND_search .= "AND page.id IN (SELECT id FROM %%page_i18n%% WHERE title like ?)";
		$p[] = "%$search%";
	}

	$AND_tag = "";
	if ($tag != "") {
		$AND_tag .= "AND page.id IN (SELECT id FROM %%page_i18n%% WHERE meta_keyword like ?)";
		$p[] = "%$tag%";
	}
	
	$AND_section = "";
	if ($sectionId != "") {
		$AND_section = "AND page.id IN (SELECT page_id FROM %%sectionpage%% WHERE site_id=? AND section_id=?)";
		$p[] = rm2Util::getSiteId();
		$p[] = $sectionId;
	}

	$AND_media = "";
	if($media) {
		$AND_media = "AND page.id IN (SELECT page_id FROM %%pageMediaFile%% AS pageMediaFile WHERE pageMediaFile.media_file_id IN 
						(SELECT mediaFile.id FROM %%mediaFile%% AS mediaFile, %%mediaFileI18n%% AS mediaFileI18n
						 WHERE mediaFile.site_id=? AND mediaFile.id=mediaFileI18n.id AND mediaFileI18n.type=?))";
		$p[] = rm2Util::getSiteId();
		$p[] = $media;
	}

	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}

	$sql = "SELECT page.* FROM %%page%% AS page
			 WHERE page.site_id=? 
			   AND (page.active=1 OR page.redirect_active=1) 
			   AND ((page.launch_date IS NULL OR page.launch_date='') OR (CONCAT(page.launch_date, ' ', page.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((page.expiry_date IS NULL OR page.expiry_date='') OR (CONCAT(page.expiry_date, ' ', page.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			  $AND_search 
			  $AND_tag 
			  $AND_section 
			  $AND_media 
			  ORDER BY page.id DESC 
			  $LIMIT ";
	$sql = str_replace("%%page%%", PagePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%sectionpage%%", SectionPagePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%pageMediaFile%%", PageMediaFilePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%mediaFile%%", MediaFilePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%mediaFileI18n%%", MediaFileI18nPeer::TABLE_NAME, $sql);
	$pageList = rm2Util::execSql($sql, $p, "PagePeer");
	return utilToCPage($pageList);
}

function utilGetMediaPagesBySectionName($sectionName, $parentId=0, $limit="", $media="", $search="", $tag="") {
	$section = utilGetSectionByName($sectionName, $parentId);
	if ($section == null) { return array(); }
	return utilGetMediaPagesBySectionId($section->getId(), $limit, $search, $media, $tag);
}

function utilGetMediaPageBySectionName($sectionName, $parentId=0, $media="") {
	$pages = utilGetMediaPagesBySectionName($sectionId, $parentId, 1, $media);
	return $pages[0];
}

function utilGetMediaPageBySectionId($sectionId, $media="") {
	$pages = utilGetMediaPagesBySectionId($sectionId, $parentId, 1, "", $media);
	return $pages[0];
}

function utilGetGalleryPagesBySectionId($sectionId, $limit="", $search="", $sortBy="createdDate", $sort="DESC") {
	$p = array(rm2Util::getSiteId(), rm2Util::getSiteId());

	$AND_search = "";
	if ($search != "") {
		$AND_search .= "AND page.id IN (SELECT id FROM %%page_i18n%% WHERE title like ?)";
		$p[] = "%$search%";
	}

	$AND_section = "";
	if ($sectionId != "") {
		$AND_section = "AND page.id IN (SELECT page_id FROM %%sectionpage%% WHERE site_id=? AND section_id=?)";
		$p[] = rm2Util::getSiteId();
		$p[] = $sectionId;
	}

	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}
	
	$ORDERBY = "";
	
	if ($sortBy == "modifiedDate") { $sortBy = "page.updated_at"; } 
	elseif ($sortBy == "displayDate") { $sortBy = "page.display_date"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "page.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "page.id"; } 
	else { $sortBy == "page.sort_order"; }

	if ($sortBy != "") {
		$ORDERBY = "ORDER BY $sortBy $sort";
	}

	$sql = "SELECT page.* FROM %%page%% AS page
			 WHERE page.site_id=? 
			   AND (page.active=1 OR page.redirect_active=1) 
			   AND ((page.launch_date IS NULL OR page.launch_date='') OR (CONCAT(page.launch_date, ' ', page.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((page.expiry_date IS NULL OR page.expiry_date='') OR (CONCAT(page.expiry_date, ' ', page.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			   AND page.id IN (SELECT pageGallery.page_id FROM %%pageGallery%% AS pageGallery WHERE pageGallery.site_id=?) 
			  $AND_search 
			  $AND_section 
			  $ORDERBY  
			  $LIMIT ";
		
	$sql = str_replace("%%page%%", PagePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%sectionpage%%", SectionPagePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%pageGallery%%", PageGalleryPeer::TABLE_NAME, $sql);

	$pageList = rm2Util::execSql($sql, $p, "PagePeer");
	return utilToCPage($pageList);
}



function utilGetGalleryPagesBySectionName($sectionName, $parentId=0, $limit="", $sortBy="createdDate", $sort="DESC") {
	$section = utilGetSectionByName($sectionName, $parentId);
	if ($section == null) { return array(); }
	return utilGetGalleryPagesBySectionId($section->getId(), $limit, "", $sortBy, $sort);
}

function utilGetGalleryPageBySectionName($sectionName, $parentId=0) {
	$pages = utilGetGalleryPagesBySectionName($sectionName, $parentId, 1);
	
	return $pages[0];
}

function utilGetGalleryPageBySectionId($sectionId) {
	$pages = utilGetGalleryPagesBySectionId($sectionId, 1);
	return $pages[0];
}

function utilGetPageById($pageId) {
	return utilToCPage(PagePeer::retrieveByPK($pageId));
}

function utilSearchPagesBySectionId($sectionId, $keyword, $year, $month, $sortBest=0, $recursive=false, $sortBy="modifiedDate", $sort="DESC") {
	$connection = Propel::getConnection();
	$limit = " limit 100";
	//check the word
	$p = array();
	$keyword = str_replace(array("?"),array(""),$keyword);
	$selectSql = "";
	$sortByWeight = "";
	if($keyword !=""){
		$selectSql = "( IF( ( match(meta_keyword) against(?) ), (40 + (match(meta_keyword) against(?)) + ( IF( (meta_keyword REGEXP ?),10,0) ) ) , 0 ) ) as meta_keyword_weight, ( IF( ( match(content) against(?) ), (20 + (match(content) against(?)) + ( IF( (content REGEXP ?),10,0) ) ) , 0 ) ) as content_weight, ( IF( ( match(meta_description) against(?) ), (10 + (match(meta_description) against(?)) + ( IF( (meta_description REGEXP ?),5,0) ) ) , 0 ) ) as meta_description_weight, ( IF( ( match(body) against(?) ), (10 + (match(body) against(?)) + ( IF( (body REGEXP ?),5,0) ) ) , 0 ) ) as body_weight, ( IF( ( match(title) against(?) ), (30 + (match(title) against(?)) ) , 0 ) ) as title_weight, ( IF( ( match(meta_title) against(?) ), (10 + (match(meta_title) against(?)) ) , 0 ) ) as meta_title_weight,";
		$p[] = "$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword.*$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword.*$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword.*$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword.*$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword";
	
		//check the memory table data
		$tempKeyWord = strtolower($keyword);
		$memoryKeyWord = md5($tempKeyWord."_".rm2Util::getSiteId()."_".$year."_".$month."_".$sectionId."_".$sortBest);
		$memoryTable = "rm2_memory_table";
		$sqlCheckTable = "SHOW TABLES LIKE '$memoryTable'";
		$statementCheckTable = $connection->prepareStatement($sqlCheckTable);
		$resultsetCheckTable = $statementCheckTable->executeQuery();
		$checkTable = $resultsetCheckTable->getRecordCount();
		if(!$checkTable){
			$sqlCreate = " CREATE TABLE `$memoryTable` (
								`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
								`page_id` INT( 11 ) NULL DEFAULT '0',
								`keyword` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
								 `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
								PRIMARY KEY ( `id` ) ,
								INDEX ( `page_id` , `keyword` )
							) ENGINE = MEMORY";
			$statementCreate = $connection->prepareStatement($sqlCreate);
			$statementCreate->executeQuery();
		}else{
			$sqlDelete = "DELETE FROM `$memoryTable` WHERE created_at <= '".date('Y-m-d H:i:s', time()-60*60)."'";
			$statementCreate = $connection->prepareStatement($sqlDelete);
			$statementCreate->executeQuery();
		}
		
		$sqlData = "select * from `$memoryTable` where keyword = '$memoryKeyWord' order by id asc";
		$statementData = $connection->prepareStatement($sqlData);
		$resultsetData = $statementData->executeQuery();
		$checkData = $resultsetData->getRecordCount();
		$sortByWeight = "(meta_keyword_weight + content_weight + meta_description_weight + body_weight + title_weight + meta_title_weight) desc "; 
		
		if($sortBest == "1"){
			$ORDERBY = " ORDER BY $sortByWeight , page.created_at desc";
		}else{
			$ORDERBY = " ORDER BY page.created_at desc, $sortByWeight ";	
		}
	}else{
		$ORDERBY = " ORDER BY page.created_at desc ";
	}
	/*
	if ($sortBy == "modifiedDate") { $sortBy = "page.updated_at"; } 
	elseif ($sortBy == "displayDate") { $sortBy = "page.display_date"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "page.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "page.id"; } 
	else { $sortBy = "page.sort_order"; }
	
	if ($sortBy != "") {
		if ($sortBy == "page.display_date") {
			$tempOrderBy = " $sortByWeight $sortBy $sort, page.created_at $sort";
		} else {
			$tempOrderBy = " $sortByWeight $sortBy $sort ";
		}
	}
	*/
	
	//var_dump("windy:".$sortBest.$ORDERBY);
	$p[] = rm2Util::getSiteId();
	$p[] = getLanguage();
	$AND_search = "";
	if ($keyword != "") {
		$AND_search .= "AND page.id IN (SELECT id FROM %%page_i18n%% WHERE match(meta_keyword) against(? in boolean mode) OR match(title) against (? in boolean mode) OR match(meta_title) against (? in boolean mode) OR match(meta_description) against(? in boolean mode) OR match(body) against(? in boolean mode) OR  match(content) against(? in boolean mode) )";
		$p[] = "$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword";
		$p[] = "$keyword";
	}

	if ($recursive == true) {
		$AND_section = "";
		if ($sectionId != "") {
			$sectionTmp = (array)explode(',', $sectionId);
			foreach ($sectionTmp as $sectionIdTmp){
				$sectionIds = $sectionIdTmp . ",";
				$childSectionIds = utilGetChildSectionId($sectionIdTmp, $recursive);
				foreach($childSectionIds as $childSectionId) {
					$sectionIds .= $childSectionId . ",";
				}
			}
			
			$sectionIds = substr($sectionIds, 0, strlen($sectionIds)-1);
			$AND_section = "AND page.id IN (SELECT page_id FROM %%sectionpage%% WHERE site_id=? AND section_id IN (".rapidManagerUtil::mysqlEscape($sectionIds)."))";
			$p[] = rm2Util::getSiteId();
			//$p[] = $sectionId;
		}
	} else {
		$AND_section = "";
		if ($sectionId != "") {
			$AND_section = "AND page.id IN (SELECT page_id FROM %%sectionpage%% WHERE site_id=? AND section_id IN (".rapidManagerUtil::mysqlEscape($sectionId)."))";
			$p[] = rm2Util::getSiteId();
			$p[] = $sectionId;
		}
	}
	
	$AND_date = "";
	if ($year !="" && $month != "" && $month != "0" && $year!="0") {
		$AND_date = "AND DATE_FORMAT(page.display_date, '%Y')=? AND DATE_FORMAT(page.display_date, '%c')=?";
		$p[] = $year;
		$p[] = $month;
	} else if ($year !="") {
		$AND_date = "AND DATE_FORMAT(page.display_date, '%Y')=?";
		$p[] = $year;
	} else if($month != ""){
        $AND_date = "AND DATE_FORMAT(page.display_date, '%c')=?";
		$p[] = $month;
    }
	

	if($checkData){

		$data = array();
		while($resultsetData->next()){
			$tempPage = array();
			$tempPage['id'] = $resultsetData->get('page_id');
			$data[] = $tempPage;
		}
	}else{
			$sql = "SELECT $selectSql page.id, page.updated_at, page.display_date, page.created_at, page.sort_order, page_i18n.meta_keyword, page_i18n.title, page_i18n.meta_title, page_i18n.meta_description, page_i18n.body, page_i18n.content FROM %%page%% AS page left join %%page_i18n%% AS page_i18n on page.id = page_i18n.id
				 WHERE page.site_id=?  
				   AND (page.active=1 OR page.redirect_active=1)
				   AND page_i18n.culture = ?
				   AND ((page.launch_date IS NULL OR page.launch_date='') OR (CONCAT(page.launch_date, ' ', page.launch_time) <= '".date('Y-m-d H:i:s')."')) 
				   AND ((page.expiry_date IS NULL OR page.expiry_date='') OR (CONCAT(page.expiry_date, ' ', page.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
				  $AND_search 
				  $AND_section 
				  $AND_date  
				  $ORDERBY 
				  $limit";
			
			$sql = str_replace("%%page%%", PagePeer::TABLE_NAME, $sql);
			$sql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $sql);
			$sql = str_replace("%%sectionpage%%", SectionPagePeer::TABLE_NAME, $sql);
			//echo $sql;
			//exit("windy");
			$statement = $connection->prepareStatement($sql);
			$resultset = $statement->executeQuery($p);
			
			
			
			//print_r($resultset);
			//get the search data
			$data = array();
			$pageData = array();
			while($resultset->next()){
				//var_dump($resultset->get('id')); 
				$tempPage = array();
				$tempPage['id'] = $resultset->get('id');
				$data[] = $tempPage;
				$pageData[] = $tempPage[id];
			}
				
		//memory table do not exist and create
		if($keyword != ""){
			$sqlData = array();
			foreach ($pageData as $pageId){
				$sqlData[] = "(NULL, '$pageId', '$memoryKeyWord')";
			}
			//inset data to memorydata
			if($sqlData){
				$sqlInsert = "";
				$stringSql = implode(",", $sqlData);
				$sqlInsert .= "INSERT INTO `$memoryTable` (`id` ,`page_id`, `keyword` ) VALUES $stringSql ";
				$statementInsert = $connection->prepareStatement($sqlInsert);
				$statementInsert->executeQuery();
			}
		
		}
		
	}
	$newData = rm2Util::getPagerDataArray($data);
	$pager = rm2Util::getObjData($newData);
	$pager["results"] = utilToCPage($pager["results"]);
	return $pager;
}

function utilSearchPagesBySectionId1($sectionId, $keyword, $recursive=false, $sortBy="createdDate", $sort="DESC") {
	$p = array(rm2Util::getSiteId());
	
	$AND_search = "";
	if ($keyword != "") {
		$AND_search .= "AND page.id IN (SELECT id FROM %%page_i18n%% WHERE title like ? OR content like ?)";
		$p[] = "%$keyword%";
		$p[] = "%$keyword%";
	}

	if ($recursive == true) {
		$AND_section = "";
		if ($sectionId != "") {
			$sectionIds = $sectionId . ",";
			$childSectionIds = utilGetChildSectionId($sectionId, $recursive);
			foreach($childSectionIds as $childSectionId) {
				$sectionIds .= $childSectionId . ",";
			}
			$sectionIds = substr($sectionIds, 0, strlen($sectionIds)-1);
			$AND_section = "AND page.id IN (SELECT page_id FROM %%sectionpage%% WHERE site_id=? AND section_id IN (".rapidManagerUtil::mysqlEscape($sectionIds)."))";
			$p[] = rm2Util::getSiteId();
			//$p[] = $sectionId;
		}
	} else {
		$AND_section = "";
		if ($sectionId != "") {
			$AND_section = "AND page.id IN (SELECT page_id FROM %%sectionpage%% WHERE site_id=? AND section_id=?)";
			$p[] = rm2Util::getSiteId();
			$p[] = $sectionId;
		}
	}

	if ($sortBy == "modifiedDate") { $sortBy = "page.updated_at"; } 
	elseif ($sortBy == "displayDate") { $sortBy = "page.display_date"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "page.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "page.id"; } 
	else { $sortBy == "page.sort_order"; }

	if ($sortBy != "") {
		if ($sortBy == "page.display_date") {
			$ORDERBY = "ORDER BY $sortBy $sort, page.created_at $sort";
		} else {
			$ORDERBY = "ORDER BY $sortBy $sort";
		}
	}
	$sql = "SELECT page.* FROM %%page%% AS page
			 WHERE page.site_id=? 
			   AND (page.active=1 OR page.redirect_active=1) 
			   AND ((page.launch_date IS NULL OR page.launch_date='') OR (CONCAT(page.launch_date, ' ', page.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((page.expiry_date IS NULL OR page.expiry_date='') OR (CONCAT(page.expiry_date, ' ', page.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			  $AND_search 
			  $AND_section 
			  $ORDERBY 
			  $LIMIT ";
	$sql = str_replace("%%page%%", PagePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%sectionpage%%", SectionPagePeer::TABLE_NAME, $sql);
	$pager = rm2Util::pagerSql($sql, $p, "PagePeer");
	$pager["results"] = utilToCPage($pager["results"]);
	return $pager;
}

function utilInsertAd($content, $spath="", $template="bigBoxAdInline.tpl") {

	$smarty = SmartyUtil::getSmarty();
	$smarty->assign("spath", $spath);
	$adContent = $smarty->fetch($template, null, null, false);
	
	if ($pos = strpos($content, "<br/>")) {
		$newContent = substr($content, 0, $pos + 5) . $adContent . substr($content, $pos + 5);
	} elseif ($pos = strpos($content, "<br /><br />")) {
		$newContent = substr($content, 0, $pos + 12) . $adContent . substr($content, $pos + 12);
	} elseif ($pos = strpos($content, "<br />")) {
		$newContent = substr($content, 0, $pos + 6) . $adContent . substr($content, $pos + 6);
	} elseif ($pos = strpos($content, "<br>")) {
		$newContent = substr($content, 0, $pos + 4) . $adContent . substr($content, $pos + 4);
	} elseif ($pos = strpos($content, "</p>")) {
		$newContent = substr($content, 0, $pos + 4) . $adContent . substr($content, $pos + 4);
	} else {
		$newContent = $content;
	}
	return $newContent;
}

function getMediaFileInfo($mediaFile){
	$r = array();
	if($mediaFile == null){
		return $r;
	}
	if (getLanguage() != getDefaultLanguage()) {
		$mediaFile->setCulture(getLanguage());
		if ($mediaFile->getTitle() == "") { $mediaFile->setCulture(getDefaultLanguage()); }
	} else {
		$mediaFile->setCulture(getLanguage());
	}
	$titleinfo = pathinfo($mediaFile->getTitle());
	$pathinfo = pathinfo($mediaFile->getFilename());
	$filePath = $mediaFile->getFileFullDirectory();
	$filesize = @filesize($filePath.$mediaFile->getFilename());
	if ($filesize / 1024 > 1) {
		$filesizeFormat = number_format($filesize / 1024, 3) . " K";
	}
	if ($filesize / 1024 / 1024 > 1) {
		$filesizeFormat = number_format($filesize / 1024 / 1024, 3) . " M";
	}
	
	$r = array(
			"id" => $mediaFile->getId(),
			"title" => htmlspecialchars($mediaFile->getTitle()),
			"filename" => $mediaFile->getFilename(),
			"oldFilename" => $mediaFile->getOldFilename(),
			"caption" => preg_replace("/\[[\s\S]*\]/", "", str_replace("<br>","<br/>",$mediaFile->getCaption())),
			"url" => URL . strtolower(str_replace(" ", "-", utilClearCharacter($titleinfo["filename"]))) . "-r".$mediaFile->getId(),
			"type" => $pathinfo["extension"],
			"created" => $mediaFile->getCreatedAT(),
			"updated" => $mediaFile->getUpdatedAT(),
			"filesize" => $filesize,
			"filesizeFormat" => $filesizeFormat,
			"mediaObject" => utilToMediaFile($mediaFile),
		);
	
	if($mediaFile->getIsRemote()){
		$r["url"] = $mediaFile->getOldFilename();
	}else{
		if($mediaFile->getType == 'video' || $mediaFile->getType == 'audio'){
			//$r["url"] = "src=/temp/" . $mediaInfo->getFilename();
			if (!file_exists("temp/".basename($mediaInfo->getFilename()))) {
				copy(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'site'.DIRECTORY_SEPARATOR.rm2Util::getSiteId().DIRECTORY_SEPARATOR.$mediaInfo->getFilename(), "temp/".basename($mediaInfo->getFilename()));
			}
		}
	}
	return $r;
}

function utilGetRandomGalleryById($galleryId) {
	$criteria = new Criteria();
	$criteria->addJoin(MediaFilePeer::ID, GalleryImagePeer::MEDIA_FILE_ID);
	$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(GalleryImagePeer::GALLERY_ID, $galleryId);
	$mediaFileList = MediaFilePeer::doSelect($criteria);
	$a = array();
	foreach ($mediaFileList as $mediaFile) {
		$a[] = getMediaFileInfo($mediaFile);
	}
	if (count($a) == 0) { return array(); }
	$key = array_rand($a);
	return $a[$key];
}

function utilGetRandomGalleryByIds($galleryIdsStr) {
	$tmp = array();
	$tmp = explode(',', $galleryIdsStr);
	$criteria = new Criteria();
	$criteria->addJoin(MediaFilePeer::ID, GalleryImagePeer::MEDIA_FILE_ID);
	$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(GalleryImagePeer::GALLERY_ID, $tmp, Criteria::IN);
	$mediaFileList = MediaFilePeer::doSelect($criteria);
	$a = array();
	foreach ($mediaFileList as $mediaFile) {
		$a[] = getMediaFileInfo($mediaFile);
	}
	if (count($a) == 0) { return array(); }
	$key = array_rand($a);
	return $a[$key];
}

function utilGetGalleryByMediaFileId($mediaFileId){
	$criteria = new Criteria();
	$criteria->addJoin(GalleryPeer::ID, GalleryImagePeer::GALLERY_ID);
	$criteria->add(GalleryImagePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(GalleryImagePeer::MEDIA_FILE_ID, $mediaFileId);
	$gallery = GalleryPeer::doSelectOne($criteria);
	if($gallery){
		/*@var $gallery Gallery*/
		if (getLanguage() != getDefaultLanguage()) {
			$gallery->setCulture(getLanguage());
			if ($gallery->getTitle() == "") { $gallery->setCulture(getDefaultLanguage()); }
		} else {
			$gallery->setCulture(getLanguage());
		}
		$a['id'] = $gallery->getId();
		$a['title'] = $gallery->getTitle();
		return $a;
	}
	return ;
}

function utilGetRandomMeidaByFolderId($folderId) {
	$a = array();
	$criteria = new Criteria();
	$criteria->addJoin(MediaFilePeer::ID, MediaFolderFilePeer::MEDIA_FILE_ID);
	$criteria->addJoin(MediaFilePeer::ID, MediaFileI18nPeer::ID);
	$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(MediaFileI18nPeer::TYPE, "image");
	//$criteria->add(MediaFileI18nPeer::CULTURE, rm2Util::getSession()->getCulture());
	$criteria->add(MediaFolderFilePeer::MEDIA_FOLDER_ID, $folderId);
	$mediaFileList = MediaFilePeer::doSelect($criteria);
	
	foreach ($mediaFileList as $mediaFile) {
		$a[] = getMediaFileInfo($mediaFile);
	}
	if (count($a) == 0) { return array(); }
	$key = array_rand($a);
	return $a[$key];
}
//for the other right function
function utilGetRandomMediaByFolderId($folderId) {
	$a = array();
	$criteria = new Criteria();
	$criteria->addJoin(MediaFilePeer::ID, MediaFolderFilePeer::MEDIA_FILE_ID);
	$criteria->addJoin(MediaFilePeer::ID, MediaFileI18nPeer::ID);
	$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(MediaFileI18nPeer::TYPE, "image");
	//$criteria->add(MediaFileI18nPeer::CULTURE, rm2Util::getSession()->getCulture());
	$criteria->add(MediaFolderFilePeer::MEDIA_FOLDER_ID, $folderId);
	$mediaFileList = MediaFilePeer::doSelect($criteria);
	
	foreach ($mediaFileList as $mediaFile) {
		$a[] = getMediaFileInfo($mediaFile);
	}
	if (count($a) == 0) { return array(); }
	$key = array_rand($a);
	return $a[$key];
}



function utilGetAllMeidaByFolderId($folderId, $limit="", $sortBy="createdDate", $sort="DESC", $type="") {
	$a = array();
	$criteria = new Criteria();
	$criteria->addJoin(MediaFilePeer::ID, MediaFolderFilePeer::MEDIA_FILE_ID);
	$criteria->addJoin(MediaFilePeer::ID, MediaFileI18nPeer::ID);
	$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(MediaFileI18nPeer::TYPE, "image");
	$criteria->add(MediaFolderFilePeer::MEDIA_FOLDER_ID, $folderId);
	
	if ($sort == "DESC") {
		if ($sortBy == "modifiedDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addDescendingOrderByColumn(MediaFilePeer::ID); } 
		else {  }
	} else {		
		if ($sortBy == "modifiedDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addAscendingOrderByColumn(MediaFilePeer::ID); } 
		else {  }
	}
	
	if($limit == ''){
		$limit = rapidManagerUtil::getDefaultLimit();
	}
	$criteria->setLimit($limit);
	$criteria->setOffset(0);
	

	$mediaFileList = MediaFilePeer::doSelect($criteria);
	
	$tMediaFileIds = array();
	foreach ($mediaFileList as $mediaFile) {
		$aTmp = array();
		if (getLanguage() != getDefaultLanguage()) {
			$mediaFile->setCulture(getLanguage());
			if ($mediaFile->getTitle() == "") { $mediaFile->setCulture(getDefaultLanguage()); }
		} else {
			$mediaFile->setCulture(getLanguage());
		}
		$pathinfo = pathinfo($mediaFile->getFilename());
		if ($type == "") {
			$aTmp = getMediaFileInfo($mediaFile);
		} else {
			if (strtolower($type) == strtolower($pathinfo["extension"])) {
				$aTmp = getMediaFileInfo($mediaFile);
			}
		}
		//if( in_array( $aTmp , $a ) ) continue;   //To determine whether there is duplication, overlap continued to(Fuck this, has error, do not why, but we need to remove this code)
		if(in_array($mediaFile->getId(), $tMediaFileIds)){
			continue;
		}
		$tMediaFileIds[] = $mediaFile->getId();
		$a[] = $aTmp;
	}
	return $a;
}

function utilGetAllVideoByFolderId($folderId, $limit="", $sortBy="createdDate", $sort="DESC", $type="") {
	$a = array();
	$criteria = new Criteria();
	$criteria->addJoin(MediaFilePeer::ID, MediaFolderFilePeer::MEDIA_FILE_ID);
	$criteria->addJoin(MediaFilePeer::ID, MediaFileI18nPeer::ID);
	$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(MediaFileI18nPeer::TYPE, "video");
	$criteria->add(MediaFolderFilePeer::MEDIA_FOLDER_ID, $folderId);
	
	if ($sort == "DESC") {
		if ($sortBy == "modifiedDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addDescendingOrderByColumn(MediaFilePeer::ID); } 
		else {  }
	} else {
		if ($sortBy == "modifiedDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addAscendingOrderByColumn(MediaFilePeer::ID); } 
		else {  }
	}

	if($limit == ''){
		$limit = rapidManagerUtil::getDefaultLimit();
	}
	$criteria->setLimit($limit);
	$criteria->setOffset(0);
	
	$mediaFileList = MediaFilePeer::doSelect($criteria);
	foreach ($mediaFileList as $mediaFile) {
		if (getLanguage() != getDefaultLanguage()) {
			$mediaFile->setCulture(getLanguage());
			if ($mediaFile->getTitle() == "") { $mediaFile->setCulture(getDefaultLanguage()); }
		} else {
			$mediaFile->setCulture(getLanguage());
		}
		$pathinfo = pathinfo($mediaFile->getFilename());
		if ($type == "") {
			$a[] = getMediaFileInfo($mediaFile);
		} else {
			if (strtolower($type) == strtolower($pathinfo["extension"])) {
				$a[] = getMediaFileInfo($mediaFile);
			}
		}
	}
	return $a;
}


function utilGetAllMediaByFolderIdAndType($folderId, $limit="", $sortBy="createdDate", $sort="DESC", $type="") {
	$a = array();
	$criteria = new Criteria();
	$criteria->addJoin(MediaFilePeer::ID, MediaFolderFilePeer::MEDIA_FILE_ID);
	$criteria->addJoin(MediaFilePeer::ID, MediaFileI18nPeer::ID);
	$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(MediaFolderFilePeer::MEDIA_FOLDER_ID, $folderId);
	$criteria->add(MediaFilePeer::ACTIVE, 1);
	
	if ($sort == "DESC") {
		if ($sortBy == "modifiedDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addDescendingOrderByColumn(MediaFilePeer::ID); } 
		else {  }
	} else {
		if ($sortBy == "modifiedDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addAscendingOrderByColumn(MediaFilePeer::ID); } 
		else {  }
	}

	if($limit == ''){
		$limit = rapidManagerUtil::getDefaultLimit();
	}
	$criteria->setLimit($limit);
	$criteria->setOffset(0);
	
	$mediaFileList = MediaFilePeer::doSelect($criteria);
	foreach ($mediaFileList as $mediaFile) {
		if (getLanguage() != getDefaultLanguage()) {
			$mediaFile->setCulture(getLanguage());
			if ($mediaFile->getTitle() == "") { $mediaFile->setCulture(getDefaultLanguage()); }
		} else {
			$mediaFile->setCulture(getLanguage());
		}
		$pathinfo = pathinfo($mediaFile->getFilename());
		if ($type == "") {
			$a[] = getMediaFileInfo($mediaFile);
		} else {
			if (in_array(strtolower($pathinfo["extension"]), array_values(explode(",", strtolower($type))))) {
				$a[] = getMediaFileInfo($mediaFile);
			}
		}
	}
	return $a;
}

function utilGetAllMediaByFolderIdAndType1($folderId, $limit="", $sortBy="createdDate", $sort="DESC", $type="") {
	$a = array();
	$criteria = new Criteria();
	$criteria->addJoin(MediaFilePeer::ID, MediaFolderFilePeer::MEDIA_FILE_ID);
	$criteria->addJoin(MediaFilePeer::ID, MediaFileI18nPeer::ID);
	$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(MediaFolderFilePeer::MEDIA_FOLDER_ID, $folderId);
	if($type != ""){
		$criteria->add(MediaFileI18nPeer::TYPE, $type);
	}
	$criteria->add(MediaFilePeer::ACTIVE, 1);
	
	if ($sort == "DESC") {
		if ($sortBy == "modifiedDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addDescendingOrderByColumn(MediaFilePeer::ID); } 
		else {  }
	} else {
		if ($sortBy == "modifiedDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addAscendingOrderByColumn(MediaFilePeer::ID); } 
		else {  }
	}

	if($limit == ''){
		$limit = rapidManagerUtil::getDefaultLimit();
	}
	$criteria->setLimit($limit);
	$criteria->setOffset(0);
	
	$mediaFileList = MediaFilePeer::doSelect($criteria);
	foreach ($mediaFileList as $mediaFile) {
		$a[] = getMediaFileInfo($mediaFile);
	}
	return $a;
}

/**
 * Get current site gallery
 *
 */
function getGalleryCriteria(){
	$criteria = new Criteria();
	$criteria->add(GalleryPeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(GalleryPeer::ACTIVE, 1);
	$criteria->addJoin(GalleryPeer::ID, GalleryI18nPeer::ID);
	$criteria->add(GalleryI18nPeer::CULTURE, getLanguage());
	return $criteria;
}

function utilGetPageGallery($currentPage=1, $pageSize=20 , $sortBy="title", $sort="ASC"){
    $currentPage = intval($currentPage);
    if($currentPage<=0)$currentPage=1;
    $criteria = getGalleryCriteria();
    $totalRecord = GalleryPeer::doCount($criteria);
    $result = array();
    $result['totalRecord']=$totalRecord;
    $result['totalPage']=ceil($totalRecord/$pageSize);
    if($currentPage > $result['totalPage'])$currentPage = $result['totalPage'];
    $offset = ($currentPage - 1) * $pageSize ;
    $result['pageSize'] = $pageSize ;
    $result['prevPage'] = $currentPage>1?$currentPage-1:$currentPage;
    $result['nextPage'] = $currentPage<$result['totalPage']? $currentPage+1: $currentPage;
    $result['currentPage'] = $currentPage;
    $result['data'] = utilGetAllGallery($pageSize , $sortBy, $sort , $offset);
    return $result;
}

function utilGetAllGallery($limit="", $sortBy="title", $sort="ASC" , $offset=0) {
    $criteria = getGalleryCriteria();
	if ($sort == "DESC") {
		if ($sortBy == "modifiedDate") { $criteria->addDescendingOrderByColumn(GalleryPeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addDescendingOrderByColumn(GalleryPeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addDescendingOrderByColumn(GalleryPeer::ID); } 
		elseif ($sortBy == "title") { $criteria->addDescendingOrderByColumn(GalleryI18nPeer::TITLE); } 
		else {  }
	} else {
		if ($sortBy == "modifiedDate") { $criteria->addAscendingOrderByColumn(GalleryPeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addAscendingOrderByColumn(GalleryPeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addAscendingOrderByColumn(GalleryPeer::ID); } 
		elseif ($sortBy == "title") { $criteria->addAscendingOrderByColumn(GalleryI18nPeer::TITLE); } 
		else {  }
	}
	if($limit == ''){
		$limit = rapidManagerUtil::getDefaultLimit();
	}
	$criteria->setLimit($limit);
	
	$offset = intval($offset);
	if($offset<=0)$offset=0;
	$criteria->setOffset($offset);
	

	$galleryList = GalleryPeer::doSelect($criteria);
	
	$g = array();
	foreach ($galleryList as $gallery) {
		// get gallery item
		$criteria = new Criteria();
		$criteria->addJoin(MediaFilePeer::ID, GalleryImagePeer::MEDIA_FILE_ID);
		$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
		$criteria->add(GalleryImagePeer::GALLERY_ID, $gallery->getId());
		$criteria->addDescendingOrderByColumn(GalleryImagePeer::SORT_ORDER);
		$criteria->addDescendingOrderByColumn(GalleryImagePeer::DEFAULT_DISPLAY);
		$mediaFileList = MediaFilePeer::doSelect($criteria);
		$a = array();
		foreach ($mediaFileList as $mediaFile) {
			$a[] = getMediaFileInfo($mediaFile);
		}

		if (getLanguage() != getDefaultLanguage()) {
			$gallery->setCulture(getLanguage());
			if ($gallery->getTitle() == "") { $gallery->setCulture(getDefaultLanguage()); }
		} else {
			$gallery->setCulture(getLanguage());
		}
		$g[] = array(
				"id" => $gallery->getId(),
				"title" => $gallery->getTitle(),
				"img" => $a[0],
				"imgs" => $a,
				"galleryObject" => new CGallery($gallery, $gallery->getCulture()),
			);
	}
	return $g;
}

function utilSearchMeidaByCaption($keyword, $limit=20, $type="image", $sortBy="createdDate", $sort="DESC") {
	$a = array();
	$criteria = new Criteria();
	$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->addJoin(MediaFilePeer::ID, MediaFileI18nPeer::ID);
	$criteria->add(MediaFileI18nPeer::TYPE, $type);
	$keywords = explode(" ", $keyword);

	$keywordString = "%";
	foreach ($keywords as $keyword) {
		$keywordString .= "[%" . $keyword . "%]%";
	}
	if ($keywordString != "") {
		
		$criteria->add(MediaFileI18nPeer::CAPTION, $keywordString, Criteria::LIKE);
	} else {
		
		$criteria->add(MediaFileI18nPeer::CAPTION, "%[%]%", Criteria::LIKE);
	}
	
	if ($sort == "DESC") {
		if ($sortBy == "modifiedDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addDescendingOrderByColumn(MediaFilePeer::ID); } 
		elseif ($sortBy == "title") { $criteria->addDescendingOrderByColumn(MediaFileI18nPeer::TITLE); } 
		elseif ($sortBy == "caption") { $criteria->addDescendingOrderByColumn(MediaFileI18nPeer::CAPTION); } 
		else {  }
	} else {
		
		if ($sortBy == "modifiedDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addAscendingOrderByColumn(MediaFilePeer::ID); } 
		elseif ($sortBy == "title") { $criteria->addAscendingOrderByColumn(MediaFileI18nPeer::TITLE); } 
		elseif ($sortBy == "caption") { $criteria->addAscendingOrderByColumn(MediaFileI18nPeer::CAPTION); } 
		else {  }
	}

	if ($limit != "") {
		$requeset = sfContext::getInstance()->getRequest();
		$pageRowNum = $requeset->setParameter("PageRowNum", $limit);
	}

	$pager = rm2Util::pager("MediaFilePeer", "doSelect", $criteria);
	$mediaFileList = $pager["results"];
	
	foreach ($mediaFileList as $mediaFile) {
		$a[] = getMediaFileInfo($mediaFile);
	}
	$pager["results"] = $a;
	return $pager;
}

function utilSearchMeida($folder, $keyword, $limit=20, $searchBy="id", $type="image", $sortBy="createdDate", $sort="DESC") {
	if($searchBy == 'id'){
		$allMedia = utilGetAllMediaByFolderIdAndType1($folder, $limit, $sortBy, $sort, $type);
	}elseif($searchBy == 'name'){
		$c = new Criteria();
		$c->add(MediaFolderPeer::NAME, $folder);
		$c->add(MediaFolderPeer::SITE_ID, rm2Util::getSiteId());
		$folderInfo = MediaFolderPeer::doSelectOne($c);
		if($folderInfo){
			$allMedia = utilGetAllMediaByFolderIdAndType1($folderInfo->getId(), $limit, $sortBy, $sort, $type);
		}
	}
	if($allMedia){
		foreach((array)$allMedia as $key => $v){
			if($v){
				$allMediaId[] = $v['id'];
			}
		}
	}
	
	$keywords = explode(" ", $keyword);
	$keywordString = "";
	foreach ($keywords as $keyword) {
		$keywordString .= "%" . $keyword . "%";
	}
	$c = new Criteria();
	$c->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$c->addJoin(MediaFilePeer::ID, MediaFileI18nPeer::ID);
	$c->add(MediaFileI18nPeer::TITLE, $keywordString, Criteria::LIKE);
	$titleSearchMedia = MediaFilePeer::doSelect($c);
	foreach((array)$titleSearchMedia as $v){
		if($v){
			$titleSearchMediaIds[] = $v->getId();
		}
	}
	$c = new Criteria();
	$c->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$c->addJoin(MediaFilePeer::ID, MediaFileI18nPeer::ID);
	$c->add(MediaFileI18nPeer::CAPTION, $keywordString, Criteria::LIKE);
	$captionSearchMedia = MediaFileI18nPeer::doSelect($c);
	foreach((array)$captionSearchMedia as $v){
		if($v){
			$captionSearchMediaIds[] = $v->getId();
		}
	}
	$searchMediaIds = array_unique(array_merge((array)$titleSearchMediaIds,(array)$captionSearchMediaIds));
	$allMediaIds = array_intersect((array)$allMediaId,(array)$searchMediaIds);
	
	$a = array();
	$criteria = new Criteria();
	$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->addJoin(MediaFilePeer::ID, MediaFileI18nPeer::ID);
	$criteria->add(MediaFileI18nPeer::TYPE, $type);
	$criteria->add(MediaFilePeer::ID, $allMediaIds, Criteria::IN);
	
	if ($sort == "DESC") {
		if ($sortBy == "modifiedDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addDescendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addDescendingOrderByColumn(MediaFilePeer::ID); } 
		elseif ($sortBy == "title") { $criteria->addDescendingOrderByColumn(MediaFileI18nPeer::TITLE); } 
		elseif ($sortBy == "caption") { $criteria->addDescendingOrderByColumn(MediaFileI18nPeer::CAPTION); } 
		else {  }
	} else {
		
		if ($sortBy == "modifiedDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::UPDATED_AT); } 
		elseif ($sortBy == "createdDate") { $criteria->addAscendingOrderByColumn(MediaFilePeer::CREATED_AT); } 
		elseif ($sortBy == "id") { $criteria->addAscendingOrderByColumn(MediaFilePeer::ID); } 
		elseif ($sortBy == "title") { $criteria->addAscendingOrderByColumn(MediaFileI18nPeer::TITLE); } 
		elseif ($sortBy == "caption") { $criteria->addAscendingOrderByColumn(MediaFileI18nPeer::CAPTION); } 
		else {  }
	}

	if ($limit != "") {
		$requeset = sfContext::getInstance()->getRequest();
		$pageRowNum = $requeset->setParameter("PageRowNum", $limit);
	}

	$pager = rm2Util::pager("MediaFilePeer", "doSelect", $criteria);
	$mediaFileList = $pager["results"];
	
	foreach ($mediaFileList as $mediaFile) {
		$a[] = getMediaFileInfo($mediaFile);
	}
	$pager["results"] = $a;
	return $pager;
}

function utilGetGalleryById($galleryId,$sortBy="sort_order",$sort="DESC") {
    if(empty($galleryId)){
        throw new InvalidArgumentException("the gallery id can't be blank.");
    }
	$criteria = new Criteria();
	$criteria->addJoin(MediaFilePeer::ID, GalleryImagePeer::MEDIA_FILE_ID);
	$criteria->addJoin(GalleryImagePeer::MEDIA_FILE_ID, MediaFileI18nPeer::ID);
	$criteria->add(MediaFilePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(MediaFileI18nPeer::CULTURE, getLanguage());
	$criteria->add(GalleryImagePeer::GALLERY_ID, $galleryId);
	if($sort == "DESC"){
		if( $sortBy == 'modifiedDate' ){
			$criteria->addDescendingOrderByColumn(MediaFilePeer::UPDATED_AT);
		} elseif ( $sortBy == 'createdDate' ){
			$criteria->addDescendingOrderByColumn(MediaFilePeer::CREATED_AT);
		} elseif ( $sortBy == 'id' ){
			$criteria->addDescendingOrderByColumn(MediaFilePeer::ID);
		} elseif ( $sortBy == 'title' ){
			$criteria->addDescendingOrderByColumn(MediaFileI18nPeer::TITLE);
		} elseif ( $sortBy == 'DEFAULT' ){
			$criteria->addDescendingOrderByColumn(GalleryImagePeer::DEFAULT_DISPLAY);
		}  else {
			$criteria->addDescendingOrderByColumn(GalleryImagePeer::SORT_ORDER);
		}
	} else {
		if( $sortBy == 'modifiedDate' ){
			$criteria->addAscendingOrderByColumn(MediaFilePeer::UPDATED_AT);
		} elseif ( $sortBy == 'createdDate' ){
			$criteria->addAscendingOrderByColumn(MediaFilePeer::CREATED_AT);
		} elseif ( $sortBy == 'id' ){
			$criteria->addAscendingOrderByColumn(MediaFilePeer::ID);
		} elseif ( $sortBy == 'title' ){			
			$criteria->addAscendingOrderByColumn(MediaFileI18nPeer::TITLE);
		} elseif ( $sortBy == 'DEFAULT' ){			
			$criteria->addAscendingOrderByColumn(GalleryImagePeer::DEFAULT_DISPLAY);
		} else {
			$criteria->addAscendingOrderByColumn(GalleryImagePeer::SORT_ORDER);
		}
	}
	$mediaFileList = MediaFilePeer::doSelect($criteria);
			//if set default image for gallery ��get default image ID to def_id
			$p = array(rm2Util::getSiteId());
			$sql = "SELECT * FROM %%gallery_image%% AS gallery_image 
			   WHERE  gallery_id = {$galleryId}
			   AND site_id = ".rm2Util::getSiteId() ."
			   AND default_display = 1
			  LIMIT 1 ";
			    $sql = str_replace("%%gallery_image%%", GalleryImagePeer::TABLE_NAME, $sql);
				$galleryDefault = rm2Util::execSql($sql, $p, "GalleryImagePeer");
				if ($galleryDefault[0]) 
				{
					$def_id = $galleryDefault[0]->getMediaFileId();
				}
	
	$a = array(); 
	$btmp = array(); // temp for default image information
	foreach ($mediaFileList as $mediaFile) {
		$atmp = getMediaFileInfo($mediaFile);
				
		if(in_array($atmp , $a)) continue;
			else $a[] = $atmp;
			
		if($def_id > 0 && $def_id == $mediaFile->getId()){
			$btmp = $atmp;
		}
	}
	
	if( $def_id <= 0 && !$btmp ) $btmp = $a[0]; //if there is no default image ,set to $a[0]
	
	$gallery = GalleryPeer::retrieveByPK($galleryId);
	if ($gallery == null) { return null; }
	if (getLanguage() != getDefaultLanguage()) {
		$gallery->setCulture(getLanguage());
		if ($gallery->getTitle() == "") { $gallery->setCulture(getDefaultLanguage()); }
	} else {
		$gallery->setCulture(getLanguage());
	}
	$g = array(
			"id" => $gallery->getId(),
			"title" => $gallery->getTitle(),
			"img" => $btmp,
			"imgs" => $a,
			"galleryObject" => new CGallery($gallery, $gallery->getCulture()),
		);
	return $g;
}

function utilGetMediaFileById($id) {
	$mediaFile = MediaFilePeer::retrieveByPK($id);
	$a = array();
	if ($mediaFile == null) { return $a; }
	$a = getMediaFileInfo($mediaFile);
	return $a;
}

if(!function_exists("utilClearCharacter")){
	function utilClearCharacter($string) {
	    $string = preg_replace('/\W/u',' ',$string);
	    $string = preg_replace('/\s(?=\s)/', '', $string);
	    $string = str_replace(' - ','-',$string);
		$a1 = array('~','`','"',"'",'!','@','#','$','%','^','&','*',',','.','?','=','+','(',')','[',']','{','}','\\','/','|','<','>',':');
		$a2 = array('','','',"",'','','','','','','','','','','','','','','','','','','','','','','','','');
		return str_replace($a1, $a2, $string);
	}
}

if(!function_exists("utilGetUrlOfPageMeidaFile")){
	function utilGetUrlOfPageMeidaFile($mediaFile) {
        $pathinfo = pathinfo($mediaFile->getFilename());
		$titleinfo = pathinfo($mediaFile->getTitle());
        return URL 
                . strtolower(str_replace(" ", "-", utilClearCharacter($titleinfo["filename"])))
                . "-r".$mediaFile->getId();
	}
}
/** kb **/
function utilGetCategorysByName($categoryName, $parentId="", $limit="") {
	$p = array(rm2Util::getSiteId());

	$AND_search = "";
	if ($categoryName != "") {
		$AND_search .= "AND category.id IN (SELECT id FROM %%category_i18n%% WHERE name=?)";
		$p[] = "$categoryName";
	}
	
	$AND_parent = "";
	if ($parentId !== "") {
		$AND_parent = "AND category.parent_id=?";
		$p[] = (int)$parentId;
	}
		
	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}

	$sql = "SELECT * FROM %%category%% AS category
			 WHERE category.site_id=? 
			   AND (category.active=1 OR category.redirect_active=1) 
			  $AND_search 
			  $AND_parent 
			  ORDER BY category.id DESC 
			  $LIMIT";
	$sql = str_replace("%%category%%", CategoryPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%category_i18n%%", CategoryI18nPeer::TABLE_NAME, $sql);
	$categoryList = rm2Util::execSql($sql, $p, "CategoryPeer");
	return utilToCCategory($categoryList);
}

function utilGetCategoryByName($categoryName, $parentId="") {
	$categoryNamePath = explode("/", $categoryName);
	if ($parentId == "") { $parentId = 0; }
	foreach($categoryNamePath as $name) {
		$categorys = utilGetCategorysByName($name, $parentId, 1);
		if ($categorys[0] == null) return null;
		$parentId = $categorys[0]->getId();
	}
	
	return $categorys[0];
}

function utilGetDropDownCategorysByParent($parent="") {
	if ($parent === 0 || $parent === '0') {
		$parentId = 0;
	} else {
		$parentCategory = utilGetCategoryById((int)$parent);
		if ($parentCategory == null) { $parentCategory = utilGetCategoryByName($parent); }
		if ($parentCategory != null) {
			$parentId = $parentCategory->getId();
		} else {
			$parentId = 0;
		}
	}
	
	$p = array(rm2Util::getSiteId(), $parentId);
	
	$sql = "SELECT * FROM %%category%% AS category
			 WHERE category.site_id=? 
			   AND (category.active=1 OR category.redirect_active=1) 
			   AND (category.show_dropdown=1) 
			   AND category.parent_id=? 
			  ORDER BY sort_order ASC,category.id ASC 
			  $LIMIT";
	
	$sql = str_replace("%%category%%", CategoryPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%category_i18n%%", CategoryI18nPeer::TABLE_NAME, $sql);
	$categoryList = rm2Util::execSql($sql, $p, "CategoryPeer");
	return utilToCCategory($categoryList);
}

function utilGetCategoryById($categoryId) {
	return utilToCCategory(CategoryPeer::retrieveByPK($categoryId));
}

function utilGetArticleByCategoryId($categoryId) {
	$p = array(rm2Util::getSiteId());

	$AND_category = "";
	if ($categoryId != "") {
		$AND_category = "AND article.id IN (SELECT article_id FROM %%categoryarticle%% WHERE site_id=? AND category_id=?)";
		$p[] = rm2Util::getSiteId();
		$p[] = $categoryId;
	}

	$sql = "SELECT article.* FROM %%article%% AS article
			 WHERE article.site_id=?
			   AND title_page=0
			   AND short_title_page=0
			   AND (article.active=1 OR article.redirect_active=1) AND article.workflow_status=1 
			   AND ((article.launch_date IS NULL OR article.launch_date='') OR (CONCAT(article.launch_date, ' ', article.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((article.expiry_date IS NULL OR article.expiry_date='') OR (CONCAT(article.expiry_date, ' ', article.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			  $AND_category 
			  ORDER BY article.display_date DESC, article.created_at DESC, article.sort_order DESC   
			  LIMIT 0,1 ";
	$sql = str_replace("%%article%%", ArticlePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%article_i18n%%", ArticleI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%categoryarticle%%", CategoryArticlePeer::TABLE_NAME, $sql);
	$articleList = rm2Util::execSql($sql, $p, "ArticlePeer");
	return utilToCArticle($articleList[0], $categoryId);
}

function utilGetChildCategoryId($categoryId, $recursive) {
	$p = array(rm2Util::getSiteId(), $categoryId);
	$sql = "SELECT * FROM %%category%% WHERE site_id=? AND parent_id=?";
	$sql = str_replace("%%category%%", CategoryPeer::TABLE_NAME, $sql);
	$categoryList = rm2Util::execSql($sql, $p, "CategoryPeer");
	$a = array();
	foreach($categoryList as $category) {
		$a[] = $category->getId();
		if ($recursive == true) {
			$c = utilGetChildCategoryId($category->getId(), $recursive);
			$a = array_merge($a, $c);
		}
	}
	return $a;
}

function utilGetArticlesByCategoryId($categoryId, $limit="", $search="", $sortBy="createdDate", $sort="DESC", $tag="", $recursive=false) {
	
	$p = array(rm2Util::getSiteId());

	$AND_search = "";
	if ($search != "") {
		$p[] = "%$search%";
		$str = '';
		$searchArray = explode(' ', trim($search));
		foreach ((array)$searchArray as $key => $v){
			$str .= ' or title like ? or content like ?';
			$p[] = "%$v%";
			$p[] = "%$v%";
		}
		$AND_search .= "AND article.id IN (SELECT id FROM %%article_i18n%% WHERE title like ? $str )";
	}
	
	$AND_tag = "";
	if ($tag != "") {
		$AND_tag .= "AND article.id IN (SELECT id FROM %%article_i18n%% WHERE meta_keyword like ?)";
		$p[] = "%$tag%";
	}
	
	if ($recursive == true) {
		$AND_category = "";
		if ($categoryId != "") {
			$categoryIds = $categoryId . ",";
			$childCategoryIds = utilGetChildCategoryId($categoryId, $recursive);
			foreach($childCategoryIds as $childCategoryId) {
				$categoryIds .= $childCategoryId . ",";
			}
			$categoryIds = substr($categoryIds, 0, strlen($categoryIds)-1);
			$AND_category = "AND article.id IN (SELECT article_id FROM %%categoryarticle%% WHERE site_id=? AND category_id IN (".rapidManagerUtil::mysqlEscape($categoryIds)."))";
			$p[] = rm2Util::getSiteId();
			$p[] = $categoryId;
		}
	} else {
		$AND_category = "";
		if ($categoryId != "") {
			$AND_category = "AND article.id IN (SELECT article_id FROM %%categoryarticle%% WHERE site_id=? AND category_id=?)";
			$p[] = rm2Util::getSiteId();
			$p[] = $categoryId;
		}
		
	}

	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}
	
	$ORDERBY = "";
	
	if ($sortBy == "modifiedDate") { $sortBy = "article.updated_at"; } 
	elseif ($sortBy == "displayDate") { $sortBy = "article.display_date"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "article.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "article.id"; } 
	else { $sortBy = "article.sort_order"; }

	if ($sortBy != "") {
		$ORDERBY = "ORDER BY $sortBy $sort";
	}

	$sql = "SELECT * FROM %%article%% AS article
			 WHERE article.site_id=? 
			   AND title_page=0
			   AND short_title_page=0
			   AND (article.active=1 OR article.redirect_active=1) AND article.workflow_status=1  
			   AND ((article.launch_date IS NULL OR article.launch_date='') OR (CONCAT(article.launch_date, ' ', article.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((article.expiry_date IS NULL OR article.expiry_date='') OR (CONCAT(article.expiry_date, ' ', article.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			  $AND_search 
			  $AND_tag 
			  $AND_category 
			  $ORDERBY  
			  $LIMIT ";
	$sql = str_replace("%%article%%", ArticlePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%article_i18n%%", ArticleI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%categoryarticle%%", CategoryArticlePeer::TABLE_NAME, $sql);
	$articleList = rm2Util::execSql($sql, $p, "ArticlePeer");
	return utilToCArticle($articleList, $categoryId);
	
}

function utilGetArticlesByCategoryName($categoryName, $parentId=0, $limit="", $sortBy="createdDate", $sort="DESC", $tag="", $recursive=false) {
	$category = utilGetCategoryByName($categoryName, $parentId);
	if ($category == null) { return array(); }
	return utilGetArticlesByCategoryId($category->getId(), $limit, "", $sortBy, $sort, $tag, $recursive);
}

function utilGetMediaArticlesByCategoryId($categoryId, $limit="", $search="", $media="", $tag="") {
	
	$p = array(rm2Util::getSiteId());

	$AND_search = "";
	if ($search != "") {
		$AND_search .= "AND article.id IN (SELECT id FROM %%article_i18n%% WHERE title like ?)";
		$p[] = "%$search%";
	}

	$AND_tag = "";
	if ($tag != "") {
		$AND_tag .= "AND article.id IN (SELECT id FROM %%article_i18n%% WHERE meta_keyword like ?)";
		$p[] = "%$tag%";
	}
	
	$AND_category = "";
	if ($categoryId != "") {
		$AND_category = "AND article.id IN (SELECT article_id FROM %%categoryarticle%% WHERE site_id=? AND category_id=?)";
		$p[] = rm2Util::getSiteId();
		$p[] = $categoryId;
	}

	$AND_media = "";
	if($media) {
		$AND_media = "AND article.id IN (SELECT article_id FROM %%articleMediaFile%% AS articleMediaFile WHERE articleMediaFile.media_file_id IN 
						(SELECT mediaFile.id FROM %%mediaFile%% AS mediaFile, %%mediaFileI18n%% AS mediaFileI18n
						 WHERE mediaFile.site_id=? AND mediaFile.id=mediaFileI18n.id AND mediaFileI18n.type=?))";
		$p[] = rm2Util::getSiteId();
		$p[] = $media;
	}

	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}

	$sql = "SELECT article.* FROM %%article%% AS article
			 WHERE article.site_id=? 
			   AND title_page=0
			   AND short_title_page=0
			   AND (article.active=1 OR article.redirect_active=1) AND article.workflow_status=1  
			   AND ((article.launch_date IS NULL OR article.launch_date='') OR (CONCAT(article.launch_date, ' ', article.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((article.expiry_date IS NULL OR article.expiry_date='') OR (CONCAT(article.expiry_date, ' ', article.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			  $AND_search 
			  $AND_tag 
			  $AND_category 
			  $AND_media 
			  ORDER BY article.id DESC 
			  $LIMIT ";
	$sql = str_replace("%%article%%", ArticlePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%article_i18n%%", ArticleI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%categoryarticle%%", CategoryArticlePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%articleMediaFile%%", ArticleMediaFilePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%mediaFile%%", MediaFilePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%mediaFileI18n%%", MediaFileI18nPeer::TABLE_NAME, $sql);
	$articleList = rm2Util::execSql($sql, $p, "ArticlePeer");
	return utilToCArticle($articleList, $categoryId);
}

function utilGetMediaArticlesByCategoryName($categoryName, $parentId=0, $limit="", $media="", $search="", $tag="") {
	$category = utilGetCategoryByName($categoryName, $parentId);
	if ($category == null) { return array(); }
	return utilGetMediaArticlesByCategoryId($category->getId(), $limit, $search, $media, $tag);
}

function utilGetMediaArticleByCategoryName($categoryName, $parentId=0, $media="") {
	$articles = utilGetMediaArticlesByCategoryName($categoryId, $parentId, 1, $media);
	return $articles[0];
}

function utilGetMediaArticleByCategoryId($categoryId, $media="") {
	$articles = utilGetMediaArticlesByCategoryId($categoryId, $parentId, 1, "", $media);
	return $articles[0];
}

function utilGetGalleryArticlesByCategoryId($categoryId, $limit="", $search="", $sortBy="createdDate", $sort="DESC") {
	$p = array(rm2Util::getSiteId(), rm2Util::getSiteId());

	$AND_search = "";
	if ($search != "") {
		$AND_search .= "AND article.id IN (SELECT id FROM %%article_i18n%% WHERE title like ?)";
		$p[] = "%$search%";
	}

	$AND_category = "";
	if ($categoryId != "") {
		$AND_category = "AND article.id IN (SELECT article_id FROM %%categoryarticle%% WHERE site_id=? AND category_id=?)";
		$p[] = rm2Util::getSiteId();
		$p[] = $categoryId;
	}

	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}
	
	$ORDERBY = "";
	
	if ($sortBy == "modifiedDate") { $sortBy = "article.updated_at"; } 
	elseif ($sortBy == "displayDate") { $sortBy = "article.display_date"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "article.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "article.id"; } 
	else { $sortBy == "article.sort_order"; }

	if ($sortBy != "") {
		$ORDERBY = "ORDER BY $sortBy $sort";
	}

	$sql = "SELECT article.* FROM %%article%% AS article
			 WHERE article.site_id=? 
			   AND title_page=0
			   AND short_title_page=0
			   AND (article.active=1 OR article.redirect_active=1) AND article.workflow_status=1  
			   AND ((article.launch_date IS NULL OR article.launch_date='') OR (CONCAT(article.launch_date, ' ', article.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((article.expiry_date IS NULL OR article.expiry_date='') OR (CONCAT(article.expiry_date, ' ', article.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			   AND article.id IN (SELECT articleGallery.article_id FROM %%articleGallery%% AS articleGallery WHERE articleGallery.site_id=?) 
			  $AND_search 
			  $AND_category 
			  $ORDERBY  
			  $LIMIT ";
		
	$sql = str_replace("%%article%%", ArticlePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%article_i18n%%", ArticleI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%categoryarticle%%", CategoryArticlePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%articleGallery%%", ArticleGalleryPeer::TABLE_NAME, $sql);

	$articleList = rm2Util::execSql($sql, $p, "ArticlePeer");
	return utilToCArticle($articleList, $categoryId);
}



function utilGetGalleryArticlesByCategoryName($categoryName, $parentId=0, $limit="", $sortBy="createdDate", $sort="DESC") {
	$category = utilGetCategoryByName($categoryName, $parentId);
	if ($category == null) { return array(); }
	return utilGetGalleryArticlesByCategoryId($category->getId(), $limit, "", $sortBy, $sort);
}

function utilGetGalleryArticleByCategoryName($categoryName, $parentId=0) {
	$articles = utilGetGalleryArticlesByCategoryName($categoryName, $parentId, 1);
	
	return $articles[0];
}

function utilGetGalleryArticleByCategoryId($categoryId) {
	$articles = utilGetGalleryArticlesByCategoryId($categoryId, 1);
	return $articles[0];
}

function utilGetArticleById($articleId) {
	return utilToCArticle(ArticlePeer::retrieveByPK($articleId));
}

function utilSearchArticlesByCategoryId($categoryId, $keyword, $year, $month, $recursive=false, $sortBy="createdDate", $sort="DESC") {
	$p = array(rm2Util::getSiteId());
	$AND_search = "";
	if ($keyword != "") {
		$AND_search .= "AND article.id IN (SELECT id FROM %%article_i18n%% WHERE title like ? OR content like ?)";
		$p[] = "%$keyword%";
		$p[] = "%$keyword%";
	}

	if ($recursive == true) {
		$AND_category = "";
		if ($categoryId != "") {
			$categoryIds = $categoryId . ",";
			$childCategoryIds = utilGetChildCategoryId($categoryId, $recursive);
			foreach($childCategoryIds as $childCategoryId) {
				$categoryIds .= $childCategoryId . ",";
			}
			$categoryIds = substr($categoryIds, 0, strlen($categoryIds)-1);
			$AND_category = "AND article.id IN (SELECT article_id FROM %%categoryarticle%% WHERE site_id=? AND category_id IN (".rapidManagerUtil::mysqlEscape($categoryIds)."))";
			$p[] = rm2Util::getSiteId();
			$p[] = $categoryId;
		}
	} else {
		$AND_category = "";
		if ($categoryId != "") {
			$AND_category = "AND article.id IN (SELECT article_id FROM %%categoryarticle%% WHERE site_id=? AND category_id=?)";
			$p[] = rm2Util::getSiteId();
			$p[] = $categoryId;
		}
	}
	
	$AND_date = "";
	if ($year !="" && $month != "") {
		$AND_date = "AND DATE_FORMAT(article.updated_at, '%Y')=? AND DATE_FORMAT(article.updated_at, '%c')=?";
		$p[] = $year;
		$p[] = $month;
	} else if ($year !="") {
		$AND_date = "AND DATE_FORMAT(article.updated_at, '%Y')=?";
		$p[] = $year;
	}

	if ($sortBy == "modifiedDate") { $sortBy = "article.updated_at"; } 
	elseif ($sortBy == "displayDate") { $sortBy = "article.display_date"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "article.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "article.id"; } 
	else { $sortBy == "article.sort_order"; }

	if ($sortBy != "") {
		if ($sortBy == "article.display_date") {
			$ORDERBY = "ORDER BY $sortBy $sort, article.created_at $sort";
		} else {
			$ORDERBY = "ORDER BY $sortBy $sort";
		}
	}
	
	$sql = "SELECT article.* FROM %%article%% AS article
			 WHERE article.site_id=? 
			   AND title_page=0
			   AND short_title_page=0
			   AND (article.active=1 OR article.redirect_active=1) AND article.workflow_status=1  
			   AND ((article.launch_date IS NULL OR article.launch_date='') OR (CONCAT(article.launch_date, ' ', article.launch_time) <= '".date('Y-m-d H:i:s')."')) 
			   AND ((article.expiry_date IS NULL OR article.expiry_date='') OR (CONCAT(article.expiry_date, ' ', article.expiry_time) >= '".date('Y-m-d H:i:s')."')) 
			  $AND_search 
			  $AND_category 
			  $AND_date 
			  $ORDERBY 
			  $LIMIT ";
	$sql = str_replace("%%article%%", ArticlePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%article_i18n%%", ArticleI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%categoryarticle%%", CategoryArticlePeer::TABLE_NAME, $sql);
	$articler = rm2Util::articlerSql($sql, $p, "ArticlePeer");
	$articler["results"] = utilToCArticle($articler["results"], $categoryId);
	return $articler;
}

function utilCategoryPath($article, $refCategoryId="", $prefix="", $postfix=" > ", $deny="") {
	$categoryList = $article->categories;
	$curCategory = null;
	
	if(!$article){
		$curCategory = CategoryPeer::retrieveByPK($refCategoryId);
	}else{
		$c = new Criteria();
		$c->add(CategoryPeer::PARENT_ID, $refCategoryId);
		$c->add(CategoryPeer::SITE_ID, rm2Util::getSiteId());
		$categorys = CategoryPeer::doSelect($c);
		$tmpId= null;
		$tmp1 = array();
		$tmp2 = array();
		foreach ((array)$categoryList as $value){
			$tmp1[] = $value->getId();
		}
		foreach ((array)$categorys as $value){
			$tmp2[] = $value->getId();
		}
		$curCategoryId = array_intersect($tmp1, $tmp2);
		foreach ($curCategoryId as $v){
			$tmpId = $v;
		}
		$curCategory   = CategoryPeer::retrieveByPK($tmpId);
	}
	/*foreach ($categoryList as $category) {
		if ($category->getId() == $refCategoryId) {
			$curCategory = $category;
		}
	}*/
	if ($curCategory == null) {
		$curCategory = $categoryList[0];
	}
	if ($curCategory == null) {
		return $article->title;
	}
	
	$categoryName = "";

	$categorys = CategoryPeer::doSelectCategoryParentList(rm2Util::getSiteId(), $curCategory->getId());
	
	$categorys = utilToCCategory($categorys);
	$denys = explode(",", $deny);
	$k = 0;
	for ($i = count($categorys) - 1; $i > -1; $i--) {
		$item = $categorys[$i];
		if (!in_array($item->id, $denys)) {
			//$articles = utilGetArticlesByCategoryId($item->id);
			//if ($articles != null && count($articles) > 0) {
			if ( ($k == '0') || !($k%3)){
				$categoryName .= $prefix . '<a href="' . $item->url . '/t-knowledgeBaselistingstony-selcat-' . $item->id . '">' . htmlspecialchars($item->title) . '</a>' . $postfix;
			} else {
				$categoryName .= $prefix . '<span>' . htmlspecialchars($item->title) . '</span>' . $postfix;
			}
			$k++;
		}
	}
	
	return substr($categoryName, 0, -3);
}

function utilCategorySectionPath($article, $refCategoryId="", $prefix="", $postfix=" > ", $deny="",$AppSettings="") {
	$sectionName = "";
	$techArray = utilCategorySectionArray();
	foreach ($techArray as $key=>$value){
		if($refCategoryId == $value){
			$sectionId = $key;
			break;
		}
	}
	$section = utilGetSectionById($sectionId);
	$category = utilGetCategoryById($refCategoryId);
	$sectionName .= $prefix . '<a href="' . $section->url . '">' . htmlspecialchars($category->title) . '</a>' . $postfix;
	return $sectionName;
	
}

function utilGetArticlesTreeListByCategoryId($categoryId, $limit="", $search="", $sortBy="createdDate", $sort="DESC", $tag="", $recursive=false, $includeCur=false, $showNull=false) {
	$articles = utilGetArticlesByCategoryId($categoryId, $limit, $search, $sortBy, $sort, $tag, $recursive);
	$a = array();
	
	if ($articles != null && count($articles) > 0) {
		foreach ($articles as $article) {
			if ($article->categories != null) {
				foreach($article->categories as $category) {
					$a[$category->id][] = $article;
				}
			}
		}
	} else {
		return '<ul>Sorry, there are no articles with those keywords found.</ul>';
	}
	$s = utilGetChildCategoryTreeListId($categoryId, $a, true, $showNull);

	if ($includeCur) {
		$articles = $a[$categoryId];
		if (count($articles) > 0) {
			foreach ($articles as $article) {
				$articleString .= "<p class='article'>"."\r\n"."<a href='".$article->getRefUrl($categoryId)."'>".$article->title."</a>"."\r\n"."</p>"."\r\n";
			}
		}
		$curCategory = utilGetCategoryById($categoryId);
		$s = $s . $articleString;
	}
	
	return $s;
}

function utilGetChildCategoryTreeListId($categoryId, $articlesTreeList, $recursive, $showNull=false) {

	$p = array(rm2Util::getSiteId(), (int)$categoryId);
	$sql = "SELECT * FROM %%category%% WHERE site_id=? AND parent_id=?";
	$sql = str_replace("%%category%%", CategoryPeer::TABLE_NAME, $sql);
	$categoryList = rm2Util::execSql($sql, $p, "CategoryPeer");
	$categoryList = utilToCCategory($categoryList);
	$string = "";
	$itemString = "";
	foreach($categoryList as $category) {
		$articles = $articlesTreeList[$category->id];
		
		$childString = "";
		if ($recursive == true) {
			$childString = utilGetChildCategoryTreeListId($category->getId(), $articlesTreeList, $recursive);
		}

		$articleString = "";
		if (count($articles) > 0) {
			foreach ($articles as $article) {
				$articleString .= "<p class='article'>"."\r\n"."<a href='".$article->getRefUrl($category->id)."'>".$article->title."</a>"."\r\n"."</p>"."\r\n";
			}
		}
		
		if ($showNull) {
			$itemString .= "<li class='folder'>"."\r\n".$category->title."\r\n".$childString.$articleString."</li>"."\r\n";
		} else {
			if ($childString != "" || $articleString != "") {
				$itemString .= "<li class='folder'>"."\r\n".$category->title."\r\n".$childString.$articleString."</li>"."\r\n";
			}
		}
		
	}
	
	if ($showNull) {
		$string = "<ul>"."\r\n" . $itemString . "</ul>"."\r\n";
	} else {
		if ($itemString != "") {
			$string = "<ul>"."\r\n" . $itemString . "</ul>"."\r\n";
		}
	}
	
	return $string;
}

function utilGetAdvertisementByZoneId($zoneid) {
	$advId = $zoneid;
	$a = array();
	$adv = AdvertisePeer::retrieveByPk((int)$advId);
	if ($adv == null) return $a;
	$adv->setCulture(getLanguage());
	if ($adv->getTitle() == "") { $adv->setCulture(getDefaultLanguage()); }
	
	$a["title"] = $adv->getTitle();
	$a["zone"] = $adv->getZone();
	$a["url"] = URL . "advertising.php?act=click&aid=".$adv->getId();
	$a["tracking"] = URL . "advertising.php?act=view&aid=" . $adv->getId();
	$mediaFile = MediaFilePeer::retrieveByPK($adv->getMediaFileId());
	if ($mediaFile) {
		$mediaFile->setCulture(getLanguage());
		if ($mediaFile->getTitle() == "") { $mediaFile->setCulture(getDefaultLanguage()); }
		$filename = $mediaFile->getOldFilename();
		$realFilename = $mediaFile->getFilename();

		$pathinfo = pathinfo($mediaFile->getFilename());
		$titleinfo = pathinfo($mediaFile->getTitle());

		$resurl = URL . strtolower(str_replace(" ", "-", utilClearCharacter($titleinfo["filename"]))) . "-r".$mediaFile->getId();
	}
	$a["filename"] = $filename;
	$a["realFilename"] = $realFilename;
	$a["resurl"] = $resurl;
	$a["type"] = $pathinfo["extension"];
	return $a;
}

function utilGetAdvertisementByZoneName($zonename) {
	$a = array();
	$criteria = new Criteria();
	$criteria->add(AdvertisePeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(AdvertisePeer::ZONE, $zonename);
	$criteria->addDescendingOrderByColumn(AdvertisePeer::VIEW);
	$criteria->addAscendingOrderByColumn(AdvertisePeer::WEIGHT);
	$advList = AdvertisePeer::doSelect($criteria);
	if (count($advList) == 0) return $a;

	$sort = array();
	foreach ($advList as $index => $adv) {
		$sort[$adv->getId()] = $adv->getView() / $adv->getWeight();
	}
	asort($sort);
	$ids = array_keys($sort);
	if (count($ids) == 0) return $a;

	$group = array();
	$groupValue = $sort[$ids[0]];
	foreach ($sort as $key => $value) {
		if ($groupValue == $value) {
			$group[$key] = $value;
		}
	}
	if (count($group) == 0) return $a;
	
	$id = array_rand($group);

	$a["advertisement"] = utilGetAdvertisementByZoneId($id);
	return $a;
}
/** kb end **/

/* Tregaskiss pdf download*/
/**
 * get category info which have select " Allow PDF download" option
 *
 * @param $categoryId
 * @return category object
 */
function getAllowPdfCategoryByCategoryId($categoryId){
	if(!$categoryId) return false;
	$categoryInfo = CategoryPeer::retrieveByPK($categoryId);
	if($categoryInfo){
		if($categoryInfo->getPdf()){
			return $categoryInfo;
		}elseif($categoryInfo->getParentId() == '0'){
			return false;
		}else{
			return getAllowPdfCategoryByCategoryId($categoryInfo->getParentId());
		}
	}
}

/**
 * get long pdf url
 *
 * @param $articleId
 * @param $categoryId
 * @return url
 */
function utilGetLongPdfUrl($articleId, $categoryId) {
	if(!$articleId) return false;
	$r = "1";
	$curCategoryId = null;
	if($categoryId){
		$curCategoryId = $categoryId;
	}else{
		$c = new Criteria();
		$c->add(CategoryArticlePeer::ARTICLE_ID, $articleId);
		$articleInfo = CategoryArticlePeer::doSelectOne($c);
		$curCategoryId = $articleInfo->getCategoryId();
	}
	
	if($curCategoryId){
		$categoryInfo = getAllowPdfCategoryByCategoryId($curCategoryId);
		if($categoryInfo){
			$categoryInfo->setCulture('en');
			$url = '/knowledgePdf/Long Manual - '.$categoryInfo->getName().'.pdf';
			//if(file_exists(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'sites'.DIRECTORY_SEPARATOR.SITE_CODE.'web'.DIRECTORY_SEPARATOR.'knowledgePdf'.DIRECTORY_SEPARATOR.'Long Manual - '.$categoryInfo->getName().'.pdf')){
				$r = $url;
			//}
		}
	}
	return $r;
}

/**
 * get short pdf url
 *
 * @param $articleId
 * @param $categoryId
 * @return 
 */
function utilGetShortPdfUrl($articleId, $categoryId) {
	if(!$articleId) return false;
	$r = "1";
	$curCategoryId = null;
	if($categoryId){
		$curCategoryId = $categoryId;
	}else{
		$c = new Criteria();
		$c->add(CategoryArticlePeer::ARTICLE_ID, $articleId);
		$articleInfo = CategoryArticlePeer::doSelectOne($c);
		$curCategoryId = $articleInfo->getCate;
	}
	$categoryInfo = getAllowPdfCategoryByCategoryId($curCategoryId);
	
	if($categoryInfo){
		$articles = utilGetArticlesByCategoryId($categoryInfo->getId(),"","","createDate","DESC","",true);
		if(count($articles) > 1){
			foreach($articles as $article){
				if($article->pdf == 1){
					$categoryInfo->setCulture('en');
					$url = '/knowledgePdf/Short Manual - '.$categoryInfo->getName().'.pdf';
					//if(file_exists(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'sites'.DIRECTORY_SEPARATOR.SITE_CODE.'web'.DIRECTORY_SEPARATOR.'knowledgePdf'.DIRECTORY_SEPARATOR.'Long Manual - '.$categoryInfo->getName().'.pdf')){
						$r = $url;
					//}
				}
			}
		}
	}
	return $r;
}

/**
 * get article access
 * @param $articleId
 * @param object $userObj
 * @return 
 */
function getArticleAccessByArticleId($articleId, $userObj, $categoryId){
	if(!$userObj || $userObj == 'public') {
		return '-1';
	}
	$categoryParents = CategoryPeer::doSelectCategoryParentList(SITE_ID, $categoryId);
	foreach ($categoryParents as $category){
		if($category){
			$categoryParentIds[] = $category->getId();
		}
	}
	$categoryChildIds = CategoryPeer::doSelectCategoryChildIds(SITE_ID, $categoryId);
	$categoryIds = array_merge($categoryParentIds, $categoryChildIds);
	$userObj = KbUserPeer::retrieveByPK($userObj->getId());
	if($userObj){
		$categoryAccessIds = explode(',', $userObj->getAccess());
	}else{
		return '-1';
	}
	$intersection = array_intersect($categoryIds, $categoryAccessIds);
	if(count($intersection)){
		return '1';
	}else{
		return '-1';
	}
}

function utilGetArticlesListBySectionId($sectionId, $limit="", $search="", $sortBy="datePosted", $sort="DESC", $tag="", $recursive=false, $includeCur=false, $showNull=false,$page='1'){
	//$map = utilCategorySectionArray();

	$articleArray = array();
	$articles = utilGetPagesBySectionId($sectionId, $limit="", $search="", $sortBy, $sort, $tag, $recursive);
	if($articles){
		
		foreach($articles as $article){
			if($article->metaDescription == ""){
	 		 	$article->metaDescription = $article->title;
	 		 }
			$articleArray[$article->id] = array('id'=>$article->id,'datePosted'=>$article->dateDisplay,
	 		 								'title'=>$article->title,'description'=>$article->metaDescription,
	 		 								'url'=>$article->url);
		
		}
	}
	
	//sort
	if($articleArray){
		foreach($articleArray as $key=>$value){
			$datePosted[$key] = $value['datePosted'];
			$description[$key] = $value['description'];
		}
	}
	//ECHO $sortBy.$sort;
	if($sortBy == 'datePosted'){
		if($sort == 'DESC'){
			 array_multisort($datePosted,SORT_DESC,$articleArray);
		}else{
			array_multisort($datePosted,SORT_ASC,$articleArray);
		}
	}elseif($sortBy == 'description'){
		if($sort == 'DESC'){
			 array_multisort($description,SORT_DESC,$articleArray);
		}else{
			array_multisort($description,SORT_ASC,$articleArray);
		}
	}
  
   $list = rm2Util::pagerList($articleArray,$page);
   return $list;
	
}

/**
 * get article by categoryId
 * 
 */
/*
function utilGetArticlesListByCategoryId($categoryId, $limit="", $search="", $sortBy="datePosted", $sort="DESC", $tag="", $recursive=false, $includeCur=false, $showNull=false,$page='1') {
	$articleArray = array();
	 $a = utilGetChildCategoryId($categoryId, true);
	 $a[] = $categoryId;
	 $categoryInfo = utilGetCategoryById($categoryId);
	 if($a){
	 	foreach($a as $key=>$value){
	 		 $articelObj = utilGetArticlesByCategoryId($value);
	 		 if($articelObj){
	 		 	foreach ($articelObj as $article){
	 		 		if($article->metaDescription == ""){
	 		 			$article->metaDescription = $article->title;
	 		 		}
	 		 		$articleArray[$article->id] = array('id'=>$article->id,'datePosted'=>$article->dateCreated,
	 		 								'title'=>$article->title,'description'=>$article->metaDescription,
	 		 								'url'=>$article->url);
	 		 	}
	 		 }
	 	}
	 }
	//sort
	if($articleArray){
		foreach($articleArray as $key=>$value){
			$datePosted[$key] = $value['datePosted'];
			$description[$key] = $value['description'];
		}
	}
	//ECHO $sortBy.$sort;
	if($sortBy == 'datePosted'){
		if($sort == 'DESC'){
			 array_multisort($datePosted,SORT_DESC,$articleArray);
		}else{
			array_multisort($datePosted,SORT_ASC,$articleArray);
		}
	}elseif($sortBy == 'description'){
		if($sort == 'DESC'){
			 array_multisort($description,SORT_DESC,$articleArray);
		}else{
			array_multisort($description,SORT_ASC,$articleArray);
		}
	}
  
   $list = rm2Util::pagerList($articleArray,$page);
   $list['categoryInfo'] = $categoryInfo;
   return $list;

}
*/

function utilGetTriviaByPollId($pollId){
	$answer = "";
	$poll = utilGetPollById($pollId);
	if($poll->trivia == "1" && $poll->triviaResult){
		$answer = "This answer is ";
		foreach ($poll->triviaResult as $key => $value){
			if($key == 0){
				$answer .=  $poll->arrayResultoption[$value];
			}else{
				$answer .=  ' and ' .$poll->arrayResultoption[$value];
			}	
		}
		$answer .= '.';
	}
	return $answer;
}

function getChainByChainName($chainName){
	if(!$chainName){
		return ;
	}
	$criteria = new Criteria();
	$criteria->add(ChainPeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(ChainI18nPeer::TITLE, $chainName);
	$chainInfo = ChainPeer::doSelectWithI18n($criteria, rm2Util::getDefaultLanguage());
	return $chainInfo['0'];
}

function utilGetAllVideosByChainName($chainName,$limit=""){
	$r = array();
	if(!$chainName){
		return ;
	}
	$chainInfo = getChainByChainName($chainName);
	if(!$chainInfo){
		return ;
	}
	
	$criteria = new Criteria();
	$criteria->add(ChainVideoPeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(ChainVideoPeer::CHAIN_ID, $chainInfo->getId());
	$criteria->addAscendingOrderByColumn(ChainVideoPeer::SORT_ORDER);
	if($limit == ''){
		$limit = rapidManagerUtil::getDefaultLimit();
	}
	$criteria->setLimit($limit);
	$videosInfo = ChainVideoPeer::doSelect($criteria);
	foreach ($videosInfo as $k => $video){
		if($video){
			$mediaInfo = MediaFilePeer::retrieveByPK($video->getMediaFileId());
			if($mediaInfo){
				$r[$k] = getMediaFileInfo($mediaInfo);
			}
		}
	}
	return $r;
}

function utilGetNextVideo($chainName, $videoId){
	$r = array();
	if(!$chainName || !$videoId){
		return ;
	}
	$chainInfo = getChainByChainName($chainName);
	if(!$chainInfo){
		return ;
	}
	
	$criteria = new Criteria();
	$criteria->add(ChainVideoPeer::SITE_ID, rm2Util::getSiteId());
	$criteria->add(ChainVideoPeer::CHAIN_ID, $chainInfo->getId());
	$criteria->addAscendingOrderByColumn(ChainVideoPeer::SORT_ORDER);
	$videosInfo = ChainVideoPeer::doSelect($criteria);
	$nextVideoId = '';
	foreach ($videosInfo as $key => $video){
		if( $video && ($video->getMediaFileId() == $videoId) ){
			if($videosInfo[$key+1]){
				$nextVideoId = $videosInfo[$key+1]->getMediaFileId();
			}
		}
	}
	$nextVideoInfo = MediaFilePeer::retrieveByPK($nextVideoId);
	if($nextVideoInfo){
		$r = getMediaFileInfo($nextVideoInfo);
	}
	//print_r($r);
	return $r;
}
function utilGetVideoChains($pageId,$sortBy="ci.title",$sort="ASC"){
	$chains = array();
	$sql = "SELECT pc.*,c.*,ci.* FROM %%pageChain%% AS pc, %%chain%% AS c, %%chain_i18n%% AS ci 
					 WHERE pc.site_id = ?
					 AND pc.page_id = ?
					 AND pc.chain_id = c.id 
					 AND c.site_id = ?
					 AND c.id = ci.id
					 ORDER BY $sortBy $sort";
	$p[] = rm2Util::getSiteId();
	$p[] = $pageId;
	$p[] = rm2Util::getSiteId();
	$sql = str_replace('%%pageChain%%', PageChainPeer::TABLE_NAME, $sql);
	$sql = str_replace('%%chain%%', ChainPeer::TABLE_NAME, $sql);
	$sql = str_replace('%%chain_i18n%%', ChainI18nPeer::TABLE_NAME, $sql);
	$result = rm2Util::execSql($sql, $p);
	$tmp = array();
	$chains = array();
	foreach ($result as $key => $row) {
		$tmp[$row['id']][$row['culture']]['name'] = $row['title'];
		$tmp[$row['id']]['default_display'] = $row['default_display'];
	}
	$i = 0;
	foreach ($tmp as $key => $value){
		
		$chains[$i]['id'] = $key;
		if( getLanguage() != rm2Util::getDefaultLanguage() ){
			if($value[getLanguage()]['name']){
				$chains[$i]['name'] =$value[getLanguage()]['name'];
			}else{
				$chains[$i]['name'] =$value[rm2Util::getDefaultLanguage()]['name'];
			}
		}else{
			$chains[$i]['name'] =$value[rm2Util::getDefaultLanguage()]['name'];
		}
		$chains[$i]['primary'] = $value['default_display'];
		$i++;
	}
	
	return $chains;
} 
function utilGetRandomPageBySectionName($sectionName, $parentId=0, $limit="", $sortBy="createdDate", $sort="DESC", $tag="", $recursive=false) {
        $a = utilGetPagesBySectionName($sectionName, $parentId, $limit, $sortBy, $sort, $tag, $recursive);
        if (count($a) == 0) { return array(); }
        $key = array_rand($a);
        return $a[$key];
}

function utilGetRandomPagesBySectionID($sectionId,$limit){
    $pages = utilGetPagesBySectionId($sectionId);
    //print_r($pages);
    $r = array_rand($pages,$limit);
    //print_r($r);
    $result = array();
    
    if(!$limit){
        return $pages;
    }

    if($limit==1){
        return array($pages[$r]);
    }
    
    foreach($r as $page){
        $result[] = $pages[$page];
    }
    //print_r($result);
    return $result;
}

function utilGetSiteMap($sectionId="0", $recursive="1", $sortBy="sort_order", $sort="ASC"){
	$p = array(rm2Util::getSiteId(), $sectionId);
	//section
	if ($sortBy == "createdDate") { $sortBy = "section.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "section.id"; } 
	else { $sortBy == "section.sort_order"; }
	
	$sectionSql = "SELECT DISTINCT section.* FROM %%section%% AS section LEFT JOIN %%section_i18n%% AS section_i18n ON (section.id = section_i18n.id)
						WHERE section.site_id = ?
						AND (section.active = 1 OR section.redirect_active = 1)
						AND section.parent_id = ?
						AND section.showSiteMap = 1
						ORDER BY $sortBy $sort
		   				";
	$sectionSql = str_replace("%%section%%", SectionPeer::TABLE_NAME, $sectionSql);
	$sectionSql = str_replace("%%section_i18n%%", SectionI18nPeer::TABLE_NAME, $sectionSql);
	$sections = rm2Util::execSql($sectionSql, $p, "SectionPeer");
	if($recursive){
		$recursive--;
		foreach ($sections as $section){
			$tmp['info']     = utilToCSection($section);
			$tmp['sections'] = utilGetSiteMap($section->getId(), $recursive, $sortBy, $sort);
			$tmp['pages']    = utilGetPagesBySectionId($section->getId(), "", "", $sortBy, $sort, "", false, true);
			$data[$section->getId()] = $tmp;
		}
	}
	return $data;
}

/**
 * Search the medias by tag
 *
 */
function utilSearchMediaByTags($keyword, $tag, $folderName='',$sortBy="modifiedDate", $sort="DESC"){
	//$limit = " limit 100";

	$AndSearch = "";
	$p = array(rm2Util::getSiteId(), getLanguage());
	if($keyword){
		$AndSearch .= " AND (media_file_i18n.title LIKE ? OR media_file_i18n.caption LIKE ? )";
		$p[] = "%$keyword%"; 
		$p[] = "%$keyword%"; 
	}
	if($tag){
		$tagArray = explode(",", $tag);
		if($tagArray){
			$tempTagSearch = "";
			$tagArray = array_diff($tagArray, array(""));
			foreach ($tagArray as $key=>$data){
				if($tagArray[$key+1]){
					$tempTagSearch .= " match(tag) against(?) OR ";
				}else{
					$tempTagSearch .= " match(tag) against(?) ";
				}
				$p[] = $data;
				
			}
			$AndSearch .= " AND ($tempTagSearch)" ;
		}
	}
	$orderBy = "";
	if ($sort == "DESC") {
		if ($sortBy == "modifiedDate") { $orderBy = " ORDER BY media_file.`updated_at` desc";} 
		elseif ($sortBy == "createdDate") { $orderBy = " ORDER BY media_file.`created_at` desc"; } 
		elseif ($sortBy == "id") { $orderBy = " ORDER BY media_file.`id` desc"; } 
		elseif ($sortBy == "title") { $orderBy = " ORDER BY media_file_i18n.`title` desc"; } 
		elseif ($sortBy == "caption") { $orderBy = " ORDER BY media_file_i18n.`caption` desc"; } 
		else {  }
	} else {
		
		if ($sortBy == "modifiedDate") { $orderBy = " ORDER BY media_file.`updated_at` asc";} 
		elseif ($sortBy == "createdDate") { $orderBy = " ORDER BY media_file.`created_at` asc"; } 
		elseif ($sortBy == "id") { $orderBy = " ORDER BY media_file.`id` asc"; } 
		elseif ($sortBy == "title") { $orderBy = " ORDER BY media_file_i18n.`title` asc"; } 
		elseif ($sortBy == "caption") { $orderBy = " ORDER BY media_file_i18n.`caption` asc"; } 
		else {  }
	}
	
	if($folderName){
		$leftJoinSearch = "LEFT JOIN %%media_folder_file%% AS media_folder_file ON media_folder_file.media_file_id = media_file.id
					LEFT JOIN %%media_folder%% AS media_folder ON media_folder_file.media_folder_id = media_folder.id";
		$andFolderSearch = " AND media_folder_file.site_id = ? AND media_folder.name LIKE ?";
		$p[] = rm2Util::getSiteId();
		$p[] = "%$folderName%";
	}
	$sql = "SELECT media_file.* FROM %%media_file%% AS media_file 
					LEFT JOIN %%media_file_i18n%% AS media_file_i18n ON media_file.id = media_file_i18n.id
					$leftJoinSearch
				WHERE media_file.site_id = ? 
					AND media_file_i18n.culture = ?
					$AndSearch 
					$andFolderSearch
					$orderBy";
	$sql = str_replace("%%media_file%%", MediaFilePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%media_file_i18n%%", MediaFileI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%media_folder%%", MediaFolderPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%media_folder_file%%", MediaFolderFilePeer::TABLE_NAME, $sql);
	$pager = rm2Util::pagerSql($sql, $p, "MediaFilePeer");
	$pager["results"] = utiltoMediaFile($pager["results"]);
	return $pager;
	
}

/**
 * Search the pages by tags
 *
 * @param string $keyword just search the title and content and body
 * @param string $tag  just use the meta keyword
 * @param unknown_type $folderName
 * @param unknown_type $sortBy
 * @param unknown_type $sort
 * @return unknown
 */
function utilSearchPageByTags($keyword, $tag, $sectionName='',$sortBy="modifiedDate", $sort="DESC"){
	//$limit = " limit 100";

	$AndSearch = "";
	$p = array(rm2Util::getSiteId(), getLanguage());
	if($keyword){
		$AndSearch .= " AND ( MATCH(page_i18n.title) AGAINST(?) OR MATCH(page_i18n.body) AGAINST(?) OR MATCH(page_i18n.content) AGAINST(?) )";
		$p[] = "$keyword"; 
		$p[] = "$keyword"; 
		$p[] = "$keyword"; 
	}
	if($tag){
		$tagArray = explode(",", $tag);
		if($tagArray){
			$tempTagSearch = "";
			$tagArray = array_diff($tagArray, array(""));
			foreach ($tagArray as $key=>$data){
				if($tagArray[$key+1]){
					$tempTagSearch .= " match(page_i18n.meta_keyword) AGAINST(?) OR ";
				}else{
					$tempTagSearch .= " match(page_i18n.meta_keyword) AGAINST(?) ";
				}
				$p[] = $data;
				
			}
			$AndSearch .= " AND ($tempTagSearch)" ;
		}
	}
	$orderBy = "";
	if ($sort == "DESC") {
		if ($sortBy == "modifiedDate") { $orderBy = " ORDER BY page.`updated_at` desc";} 
		elseif ($sortBy == "createdDate") { $orderBy = " ORDER BY page.`created_at` desc"; } 
		elseif ($sortBy == "id") { $orderBy = " ORDER BY page.`id` desc"; } 
		elseif ($sortBy == "title") { $orderBy = " ORDER BY page_i18n`title` desc"; } 
		else {  }
	} else {
		
		if ($sortBy == "modifiedDate") { $orderBy = " ORDER BY page.`updated_at` asc";} 
		elseif ($sortBy == "createdDate") { $orderBy = " ORDER BY page.`created_at` asc"; } 
		elseif ($sortBy == "id") { $orderBy = " ORDER BY page.`id` asc"; } 
		elseif ($sortBy == "title") { $orderBy = " ORDER BY page_i18n.`title` asc"; } 
		else {  }
	}
	
	if($sectionName){
		$leftJoinSearch = "LEFT JOIN %%section_page%% AS section_page ON section_page.page_id = page.id
					LEFT JOIN %%section%% AS section ON section_page.section_id = section.id
					LEFT JOIN %%section_i18n%% AS section_i18n ON section.id = section_i18n.id";
		$andSectionSearch = " AND section_page.site_id = ? AND section_i18n.name LIKE ?";
		$p[] = rm2Util::getSiteId();
		$p[] = "%$sectionName%";
	}
	$sql = "SELECT page.* FROM %%page%% AS page 
					LEFT JOIN %%page_i18n%% AS page_i18n ON page.id = page_i18n.id
					$leftJoinSearch
				WHERE page.site_id = ? 
					AND page_i18n.culture = ?
					$AndSearch 
					$andSectionSearch
					$orderBy";
	$sql = str_replace("%%page%%", PagePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%section%%", SectionPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%section_i18n%%", SectionI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%section_page%%", SectionPagePeer::TABLE_NAME, $sql);
	$pager = rm2Util::pagerSql($sql, $p, "PagePeer");
	$pager["results"] = utilToCPage($pager["results"]);
	return $pager;
	
}
function utilGetChildMediaFolderIds($mediaFolderIds, $recursive, $active = 0) {
	$p = array(rm2Util::getSiteId());
	if($active == 1){
		$AndSearch = " AND active = 1";
	}
	$sql = "SELECT * FROM %%media_folder%% WHERE site_id=? AND parent_id in (".rapidManagerUtil::mysqlEscape($mediaFolderIds).") $AndSearch";
	$sql = str_replace("%%media_folder%%", MediaFolderPeer::TABLE_NAME, $sql);
	$folderList = rm2Util::execSql($sql, $p, "MediaFolderPeer");
	$a = array();
	foreach($folderList as $folder) {
		$a[] = $folder->getId();
	}
	$folderIds = implode(",", $a);
	if($folderIds){
		if ($recursive == true) {
			$c = utilGetChildMediaFolderIds($folderIds, $recursive, $active);
			$a = array_merge($a, $c);
		}
	}
	
	return $a;
}
function utilSearchMediaByFolderIds($keyword, $folderIds, $searchBy, $type=null, $sortBy="modifiedDate", $sort="DESC", $limit=20, $recursive=false,$tag=""){

	$AndSearch = "";
	$p = array(rm2Util::getSiteId(), getLanguage());
	$searchByArray = explode(",", $searchBy);

	$AND_tag = "";
	if ($tag != "") {
		$tagArray = explode(",", $tag);
		$tempTagSearch = "";
		$tagArray = array_diff($tagArray, array(""));
		foreach ($tagArray as $key=>$data){
			if($tagArray[$key+1]){
				$tempTagSearch .= " match(tag) against(?) OR ";
			}else{
				$tempTagSearch .= " match(tag) against(?) ";
			}
			$p[] = $data;
			$AND_tag .= " AND ($tempTagSearch)" ;
		}
	}
	#echo "and tag? ($tag):" .$AND_tag;

	//strat if 1
	if($keyword){
		//start if 2
		if($searchByArray){
			$AndSearch = " 1 = 2 ";
			foreach ($searchByArray as $key=>$column){
				$column = strtolower($column);
				switch ($column){
					case "id":
						$AndSearch .= " OR media_file.id = ? ";
						$p[] = "$keyword"; 
						break;
					case "title":
						$AndSearch .= " OR media_file_i18n.title LIKE ? ";
						$p[] = "%$keyword%"; 
						break;
					case "caption":
						$AndSearch .= " OR media_file_i18n.caption LIKE ? ";
						$p[] = "%$keyword%"; 
						break;
					case "filename":
						$AndSearch .= " OR media_file_i18n.filename LIKE ? ";
						$p[] = "%$keyword%"; 
						break;
					case "oldfilename":
						$AndSearch .= " OR media_file_i18n.oldFilename LIKE ? ";
						$p[] = "%$keyword%"; 
						break;
					
					case "tag":
						$tagArray = explode(",", $keyword);
						$tempTagSearch = "";
						$tagArray = array_diff($tagArray, array(""));
						foreach ($tagArray as $key=>$data){
							if($tagArray[$key+1]){
								$tempTagSearch .= " match(tag) against(?) OR ";
							}else{
								$tempTagSearch .= " match(tag) against(?) ";
							}
							$p[] = $data;
							
						}
						$AndSearch .= " OR ($tempTagSearch)" ;
						break;
					default:
						$AndSearch .= " OR media_file_i18n.title LIKE ? ";
						$p[] = "%$keyword%"; 
						break;
						
				}	
			}
			$AndSearch = " AND ($AndSearch)";
		}//end if 2		
		
	}//end if 1
	
	if($type !== null){
		$AndSearch .= " AND media_file_i18n.type = ?";
		$p[] = "$type"; 
	}

	if($folderIds){
		$foldersArray = explode(",", $folderIds);
		if($foldersArray){
			//folder ids $foldersArray
			$tempFoldersArray = array();
			foreach ($foldersArray as $key=>$value){
				$tempFoldersArray[] = (int)$value;
			}
			$tempFoldersArray = array_unique($tempFoldersArray);
			$folderIds = implode(",", $tempFoldersArray);
			if(!$folderIds) $folderIds = "0";
			if($recursive == true){
				if($folderIds){
					$tempFoderIdsArray = utilGetChildMediaFolderIds($folderIds, true, 1);
					$totalFolderIdsArray = array_merge($tempFoderIdsArray, $tempFoldersArray);
					$folderIds = implode(",", $totalFolderIdsArray);
					if(!$folderIds) $folderIds = "0";
					//echo $folderIds;
				}
			}
			$leftJoinSearch = "LEFT JOIN %%media_folder_file%% AS media_folder_file ON media_folder_file.media_file_id = media_file.id
					LEFT JOIN %%media_folder%% AS media_folder ON media_folder_file.media_folder_id = media_folder.id";
			$andFolderSearch = " AND media_folder_file.site_id = ? AND media_folder.id in ($folderIds)";
			$p[] = rm2Util::getSiteId();
		}
	}
	//set the sort
	$orderBy = "";
	if ($sort == "DESC") {
		if ($sortBy == "modifiedDate") { $orderBy = " ORDER BY media_file.`updated_at` desc";} 
		elseif ($sortBy == "createdDate") { $orderBy = " ORDER BY media_file.`created_at` desc"; } 
		elseif ($sortBy == "id") { $orderBy = " ORDER BY media_file.`id` desc"; } 
		elseif ($sortBy == "title") { $orderBy = " ORDER BY media_file_i18n.`title` desc"; } 
		elseif ($sortBy == "caption") { $orderBy = " ORDER BY media_file_i18n.`caption` desc"; } 
		else {  }
	} else {
		
		if ($sortBy == "modifiedDate") { $orderBy = " ORDER BY media_file.`updated_at` asc";} 
		elseif ($sortBy == "createdDate") { $orderBy = " ORDER BY media_file.`created_at` asc"; } 
		elseif ($sortBy == "id") { $orderBy = " ORDER BY media_file.`id` asc"; } 
		elseif ($sortBy == "title") { $orderBy = " ORDER BY media_file_i18n.`title` asc"; } 
		elseif ($sortBy == "caption") { $orderBy = " ORDER BY media_file_i18n.`caption` asc"; } 
		else {  }
	}
	
	//set the limit
	if ($limit != "") {
		$requeset = sfContext::getInstance()->getRequest();
		$pageRowNum = $requeset->setParameter("PageRowNum", $limit);
	}
	
	$sql = "SELECT media_file.* FROM %%media_file%% AS media_file 
					LEFT JOIN %%media_file_i18n%% AS media_file_i18n ON media_file.id = media_file_i18n.id
					$leftJoinSearch
				WHERE media_file.site_id = ? 
					AND media_file_i18n.culture = ?
					$AND_tag
					$AndSearch 
					$andFolderSearch				
					$orderBy";
	$sql = str_replace("%%media_file%%", MediaFilePeer::TABLE_NAME, $sql);
	$sql = str_replace("%%media_file_i18n%%", MediaFileI18nPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%media_folder%%", MediaFolderPeer::TABLE_NAME, $sql);
	$sql = str_replace("%%media_folder_file%%", MediaFolderFilePeer::TABLE_NAME, $sql);
	//print_r($p);
	//echo "$sql";
	//print_r($p);
	$pager = rm2Util::pagerSql($sql, $p, "MediaFilePeer");
	$pager["results"] = utiltoMediaFile($pager["results"]);
	return $pager;
}
function utilSearchMediaByFolderNames($keyword, $folderNames, $searchBy, $type=null, $sortBy="modifiedDate", $sort="DESC", $limit=20, $recursive=false){
		//get the folderIds by names 
		$folderIds = "";
		if($folderNames){
			$foldersArray = explode(",", $folderNames);
			$tempFoldersArray = array();
			$folderP = array(rm2Util::getSiteId());
			$andTempFolderSearch = " 1 = 2 ";
			foreach ($foldersArray as $key=>$value){
				$andTempFolderSearch .= " OR media_folder.name = ?";
				$folderP[] = "$value";
			}
			$andTempFolderSearch = " AND ($andTempFolderSearch)";
			$folderSql = "SELECT media_folder.id from %%media_folder%% AS media_folder WHERE media_folder.site_id = ? $andTempFolderSearch ";
			$folderSql = str_replace("%%media_folder%%", MediaFolderPeer::TABLE_NAME, $folderSql);
			//echo $folderSql;
			$resultset = rm2Util::execSql($folderSql, $folderP);
			while($resultset->next()){
				$v = $resultset->getRow();
				$tempFoldersArray[] = $v['id'];
			}
			$folderIds = implode(",", $tempFoldersArray);
			if(!$folderIds){
				$folderIds = 'no result';
			}
		}
		//do not have the result
		
		$pager = utilSearchMediaByFolderIds($keyword, $folderIds, $searchBy, $type, $sortBy, $sort, $limit, $recursive);
		return $pager;
}

//check the member login
function utilIsMemberLoggedIn(){
	if($_SESSION['memberId']){
		return true;
	}else{
		return false;
	}
}

//get the memberId
function utilGetMemberId(){
	if($_SESSION['memberId']){
		return $_SESSION['memberId'];
	}else{
		return null;
	}
}

/**
 * Check the category name
 *
 * @param $categoryName - string - membership category name
 * @returns boolean - true if the user is logged in and assigned to the category, false otherwise. 
 */
function utilMemberIsAssignedToCategory($categoryName){
	if(!$_SESSION['categoryLevel'] || !$categoryName){
		return false;
	}
	$categoryLevel = $_SESSION['categoryLevel'];
	$c = new Criteria();
	$c->add(MemberCategoryPeer::SITE_ID, rm2Util::getSiteId());
	$c->addJoin(MemberCategoryPeer::ID, MemberCategoryI18nPeer::ID, Criteria::LEFT_JOIN);
	$c->add(MemberCategoryI18nPeer::NAME, $categoryName);
	$c->add(MemberCategoryPeer::ID, $categoryLevel, Criteria::IN);
	$memberCategory = MemberCategoryPeer::doSelectOne($c);
	if($memberCategory){
		return true;
	}else{
		return false;
	}
}

function utilGetAutoPublishRssFeeds($sectionId=0){
	$rssFeedString = "";
	/*@var $section Section*/
	if($sectionId){
		$section = SectionPeer::retrieveByPK($sectionId);
		$rssFeedString = getRssFeedString($section);
	}else{
		$homeSection    = utilGetSectionByName("Home Page Setting");
		$rssFeedString .= getRssFeedString($homeSection);
		
		$sectionList = getAutoPublishRssFeedSections();
		foreach ($sectionList as $section){
			$rssFeedString .= getRssFeedString($section);
		}
	}
	return $rssFeedString;
}

function getAutoPublishRssFeedSections($sectionId){
	if(!$sectionId) $sectionId = 0;
	$p = array(rm2Util::getSiteId(), $sectionId, 1, 1);
	$sql = "SELECT * FROM %%section%% WHERE site_id=? AND parent_id=? AND include_rss_feed=? AND auto_publish_rss_feed=? AND active = 1 ORDER BY updated_at DESC";
	$sql = str_replace("%%section%%", SectionPeer::TABLE_NAME, $sql);
	$sectionList = rm2Util::execSql($sql, $p, "SectionPeer");
	$a = array();
	foreach($sectionList as $section) {
		$a[] = $section;
		$c = getAutoPublishRssFeedSections($section->getId());
		$a = array_merge($a, $c);
	}
	return $a;
}

function getRssFeedString($section){
	$rssFeedString = "";
	/*@var $section Section*/
	if( ($section == null) || !is_object($section) || !($section instanceof Section) ) return $rssFeedString;
	if( $section->getAutoPublishRssFeed() ){
		$section->setCulture(getLanguage());
		$rssFeedString =  '<link rel="alternate" type="application/rss+xml" title="'.$section->getRssFeedName().'" href="'.SectionPeer::getCurrentRssUrl($section->getId()).'" />' . "\r\n";
	}
	return $rssFeedString;
}

function utilGetRightMenuForSMCS($sectionId=0){
	$displays = array();
	$string   = "";
	if(!$sectionId) return $string;
	$currentSection = utilGetSectionById($sectionId);
	if($currentSection == null) return $string;
	
	$childSectionSql = "SELECT * FROM %%section%% AS section LEFT JOIN %%section_i18n%% AS section_i18n ON (section.id = section_i18n.id)
								 WHERE section.site_id = ?
								 AND section.parent_id = ?
								 AND (section.active=1 OR section.redirect_active=1)";
	$childSectionSql = str_replace("%%section%%", SectionPeer::TABLE_NAME, $childSectionSql);
	$childSectionSql = str_replace("%%section_i18n%%", SectionI18nPeer::TABLE_NAME, $childSectionSql);
	
	$p = array(rm2Util::getSiteId(), $sectionId);
	$childSections   = rm2Util::execSql($childSectionSql, $p, "SectionPeer");
	foreach ($childSections as $section) {
		/*@var $section Section*/
		$section->setCulture(getLanguage());
		$displays[$section->getSortOrder()][$section->getName()] = utilToCSection($section);
	}
	
	$childPageSql = "SELECT * FROM %%page%% AS page 
						  LEFT JOIN %%page_i18n%% AS page_i18n ON (page.id = page_i18n.id)
						  LEFT JOIN %%section_page%% AS section_page ON (page.id = section_page.page_id)
						  WHERE section_page.site_id = ?
						  AND (page.active=1 OR page.redirect_active=1) 
		   				  AND ((page.launch_date IS NULL OR page.launch_date='') OR (CONCAT(page.launch_date, ' ', page.launch_time) <= '".date('Y-m-d H:i:s')."')) 
		   				  AND ((page.expiry_date IS NULL OR page.expiry_date='') OR (CONCAT(page.expiry_date, ' ', page.expiry_time) >= '".date('Y-m-d H:i:s')."'))
						  AND section_page.section_id = ?";
	$childPageSql = str_replace("%%page%%", PagePeer::TABLE_NAME, $childPageSql);
	$childPageSql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $childPageSql);
	$childPageSql = str_replace("%%section_page%%", SectionPagePeer::TABLE_NAME, $childPageSql);
	$p = array(rm2Util::getSiteId(), $sectionId);
	$childPages   = rm2Util::execSql($childPageSql, $p, "PagePeer");
	foreach ($childPages as $page){
		/*@var $page Page*/
		$page->setCulture(getLanguage());
		$displays[$page->getSortOrder()][$page->getTitle()] = utilToCPage($page);
	}
	
	if(sizeof($displays)){
		ksort($displays);
		$parentSection = utilGetSectionById($currentSection->parentId);
		$string .= '<a class="hdr">' . $currentSection->title . '</a>';
		foreach ($displays as $items){
			ksort($items);
			foreach ($items as $display){
				$string .= '<div class="navSpacer" onmouseover="this.className=\'navSpacerOver\'" onmouseout="this.className=\'navSpacer\'">';
				if($display->parentId){
					$string .= '<div class="navPlus"> </div>';
					$string .= '<a class="nav" title="' . $display->title . '" href="' . $display->url . '/sid-' . $display->id . '">' . $display->title . '</a>';
				}else{
					$string .= '<a class="nav" title="' . $display->title . '" href="' . $display->url . '/sid-' . $currentSection->id . '">' . $display->title . '</a>';
				}
				$string .= '</div>';
			}
		}
		if($parentSection != null){
			$string .= '<div class="back">';
			$string .= '<div class="navBack"></div>';
        	$string .= '<a class="back" title="' . $parentSection->title . '" href="' . $parentSection->url . '/sid-' . $parentSection->id . '">Back to ' . $parentSection->title . '</a>';
    		$string .= '</div>';
		}
	}
	return $string;
}

function testUtilCall(){
	return rand();
}


function getExcludeFolderIds(){
	$folderIds = array();
	$c = new Criteria();
	$c->add(MediaFolderPeer::SITE_ID, SITE_ID);
	$c->add(MediaFolderPeer::EXCLUDE, 1);
	$c->add(MediaFolderPeer::ACTIVE, 1);
	$folders = MediaFolderPeer::doSelect($c);
	if($folders){
		foreach ($folders as $folder){
			$folderIds[] = $folder->getId();
		}
	}
	return $folderIds;
}

function getAllSiteFolderIds($limit=""){
	$folderIds = array();
	$c = new Criteria();
	$c->add(MediaFolderPeer::SITE_ID, SITE_ID);
	$c->add(MediaFolderPeer::ACTIVE, 1);
	if($limit == ''){
		$limit = rapidManagerUtil::getDefaultLimit();
	}
	$c->setLimit($limit);
	$c->setOffset(0);
	$folders = MediaFolderPeer::doSelect($c);
	if($folders){
		foreach ($folders as $folder){
			$folderIds[] = $folder->getId();
		}
	}
	return $folderIds;
}
/**
 * search the page or media
 */
function utilSphinxSearchMediaByFoldName($keyword, $folderNameStr, $matchMode="SPH_MATCH_ANY", $sortBy="@weight DESC, @id ASC", $limit="100", $recursive=false , $fileType='' , $includeSectionOfZero=true){
    $folderIds = array();
    
    $folderNameStr = explode(",",$folderNameStr);
    foreach($folderNameStr as $folderName){
        $c = new Criteria();
        $c->add(MediaFolderPeer::SITE_ID, SITE_ID);
        $c->add(MediaFolderPeer::ACTIVE, 1);
        $c->add(MediaFolderPeer::NAME, $folderName);
        $folders = MediaFolderPeer::doSelect($c);
        
        foreach($folders as $folder){
            $folderIds[]=$folder->getId();
        }
    }
    $folderIdStr = implode(",",$folderIds);
    
    $result = utilSphinxSearch($keyword, $year=null, $month=null, $sectionIdStr="", $folderIdStr, $type="media", $matchMode, $sortBy, $limit, $recursive , $fileType , $includeSectionOfZero);
    return $result ;
}

function utilSphinxSearch($keyword, $year, $month, $sectionIdStr="", $folderIdStr="", $type="all", $matchMode="SPH_MATCH_ANY", $sortBy="@weight DESC, @id ASC", $limit="100", $recursive=false , $fileType='' , $includeSectionOfZero=true){
	global $pageWeight, $mediaWeight;
	//var_dump($keyword, $type, $sectionIdStr, $folderIdStr, SPHINX_HOST, SPHINX_PORT);
	//get section ids
	$sectionIds = array();
	if($sectionIdStr){
		$sectionIds = explode(",", $sectionIdStr);
	}
	if(!empty($fileType)){
	    $fileType = explode(",",$fileType);
	    foreach($fileType as $index=>$typeName){
	        $numberOfTypeName = crc32($typeName);
	        $fileType[$index] = sprintf("%u", $numberOfTypeName);
	    }
	    $fileType = array_unique($fileType);
	}
	if(sizeof($sectionIds)){
		$allChildIds = array();
		if($recursive){
			foreach ($sectionIds as $sectionId){
				$allChildIds = array_merge($allChildIds, (array)utilGetChildSectionId($sectionId, true));
			}
		}
		$sectionIds = array_merge($sectionIds, $allChildIds);
	}
	if(sizeof($sectionIds) && $includeSectionOfZero) array_push($sectionIds, 0);
	
	//get folder ids
	$folderIds = array();
	
	$excludeFolderIds = getExcludeFolderIds();
	if($folderIdStr){
		if($recursive){
			$folderIds = utilGetChildMediaFolderIds($folderIdStr, true, 1);
			$tmpIds = explode(",",$folderIdStr);
			$folderIds = array_merge($folderIds , $tmpIds);
		}else{
			$folderIds = explode(",", $folderIdStr);
		}
		
		//ignore the folder
		$folderIds = array_diff($folderIds, $excludeFolderIds);
	}else{
		$allFolderIds = getAllSiteFolderIds(1000000);
		$folderIds = array_diff($allFolderIds, $excludeFolderIds);
	}
	if(sizeof($folderIds)) array_push($folderIds, 0);
	if(rm2Util::getSiteId() == 15){
        //var_dump($recursive);
        //var_dump($sectionIds, $folderIds);exit;
	}
	$cl = new SphinxClient ();
	$sphinx_host = defined("SPHINX_HOST") ? SPHINX_HOST : "sphinx-rm.commer.com";
	$sphinx_port = defined("SPHINX_PORT") ? SPHINX_PORT : "9312";
	$cl->SetServer($sphinx_host, $sphinx_port);
	$cl->SetConnectTimeout(5);
	$cl->SetArrayResult(true);
	$cl->SetMatchMode($matchMode);
	if(defined("PROPEL_DB")){
		$connectName = PROPEL_DB;
	}else{
		$connectName = "admin";
	}
	switch ($type){
		case "page":
			$index = "page_".$connectName."_main,page_".$connectName."_delta";
			if(!$pageWeight || !is_array($pageWeight)){
				$pageWeight = array("title"            => "1000", 
									"body"             => "100", 
									"content"          => "1",
									"meta_title"       => "50",
									"meta_keyword"     => "50",
									"meta_description" => "50"
									);
			}
			$cl->SetWeights($pageWeight);
			$cl->SetFilter("section_id", $sectionIds);
			if($year) $cl->SetFilter("display_date_year", array($year));
			if($month) $cl->SetFilter("display_date_month", array($month));
			$cl->SetFilterRange("launch", time(), strtotime("+20 year"), true);
			$cl->SetFilterRange("expiry", 1, time(), true);
			break;
		case "media":
			if(!$mediaWeight || !is_array($mediaWeight)){
				$mediaWeight = array("title"           => 1000,
									 "caption"         => 100,
									 "text"            => 1
									 );
			}
			$index = "media_".$connectName."_main,media_".$connectName."_delta";
			$cl->SetWeights($mediaWeight);
			$cl->SetFilter("folder_id", $folderIds);
        	if(is_array($fileType) && count($fileType)){
        	   $cl->SetFilter("type", $fileType);
        	}
			break;
		case "all":
			$index = "page_".$connectName."_main,page_".$connectName."_delta,media_".$connectName."_main,media_".$connectName."_delta";
			$cl->SetFilter("section_id", $sectionIds);
			$cl->SetFilter("folder_id", $folderIds);
			if($year) $cl->SetFilter("display_date_year", array($year));
			if($month) $cl->SetFilter("display_date_month", array($month));
			$cl->SetFilterRange("launch", time(), strtotime("+20 year"), true);
			$cl->SetFilterRange("expiry", 1, time(), true);
			break;
		default:
			$index = "page_".$connectName."_main,page_".$connectName."_delta,media_".$connectName."_main,media_".$connectName."_delta";
			break;
	}
	
	$cl->SetFilter("site_id", array(rm2Util::getSiteId()));
	$cl->SetFilter("active", array(1));
	$cl->SetGroupDistinct("@id");
	/*if($_SERVER['REMOTE_ADDR'] == '64.34.234.67') {
		echo "sort: $sortBy";
		exit;
	}*/
	$cl->SetSortMode(SPH_SORT_EXTENDED, $sortBy);
	
	$limit = explode(",",$limit);
	if(!isset($limit[1])){
        $limit[1]=intval($limit[0]);
        $limit[0] = 0;
        if($limit[1]==0)$limit[1]=100;
    }
	$cl->SetLimits($limit[0], $limit[1]);

	$cl->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
	$res = $cl->Query($keyword, $index);
	$pager = array();
	if(rm2Util::getSiteId() == 15){
        //var_dump($cl, $res);exit;
	}
	if($res === false){
		print "Query failed: " . $cl->GetLastError() . ".";
	}else{
        $pager = array();
        $pager['pagerRowNum'] = $pager['totalRecord'] = $res['total_found'];
        $pager['pagerPageRowNum'] = $pager['pageSize'] = $limit[1];
        $pager['totalPage'] = $pager['pagerPage'] = ceil($pager['totalRecord'] / $pager['pageSize']);
        $pager['currentPage'] = $pager['pager'] = ceil ($limit[0] ? ceil($limit[0] / $pager['pageSize'])+1 : 1 );
        $pager['results']=array();
        
        foreach($res["matches"] as $key=>$match){
            if($match["attrs"]["search_type"] == "1"){
                //page
                $cpage = utilGetPageById($match["id"]);
                if($cpage){
                    $url = $cpage->getUrl();
                }
                if($url && $cpage){
                    $pager["results"][$key] = $cpage;
                }
            }elseif ($match["attrs"]["search_type"] == "2"){
                //media
                $mediaInfo = MediaFilePeer::retrieveByPK($match["id"]);
                if($mediaInfo){
                    $pager["results"][$key] = new CMediaFile($mediaInfo, getLanguage());
                }else{
                    //$pager["results"][$key] = null;
                }
            }
        }
	}
	//var_dump($pager);exit;
	return $pager;
}

/**
 * Enter Just for all the pages AND directories marked as "Show as Drop down".
 *
 * @param int $sectionId
 * @param string $sortBy
 * @param string $sort
 * @param int $limit
 * @return unknown
 */
function utilGetRightMenu($sectionId=0, $sortBy='sortOrder', $sort='DESC', $limit=''){
	$displays = array();
	if(!$sectionId) return $displays;
	$currentSection = utilGetSectionById($sectionId);
	if($currentSection == null) return $displays;
	if($currentSection->dropDown == "0") return $displays;
	
	$ORDERBY = "";
	if ($sortBy == "modifiedDate") { $sortBy = "section.updated_at"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "section.created_at"; } 
	elseif ($sortBy == "name") { $sortBy = "section_i18n.name"; } 
	elseif ($sortBy == "id") { $sortBy = "section.id"; } 
	elseif ($sortBy == "sortOrder") { $sortBy = "section.sort_order"; } 
	else { $sortBy = "section.id"; }

	if ($sortBy != "") {
		$ORDERBY = "ORDER BY $sortBy $sort";
	}
		
	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}
	
	$childSectionSql = "SELECT * FROM %%section%% AS section LEFT JOIN %%section_i18n%% AS section_i18n ON (section.id = section_i18n.id)
								 WHERE section.site_id = ?
								 AND section.parent_id = ?
								 AND (section.active=1 OR section.redirect_active=1)
								 AND section.show_dropdown = 1
								 $ORDERBY
								 $LIMIT";
	$childSectionSql = str_replace("%%section%%", SectionPeer::TABLE_NAME, $childSectionSql);
	$childSectionSql = str_replace("%%section_i18n%%", SectionI18nPeer::TABLE_NAME, $childSectionSql);
	$p = array(rm2Util::getSiteId(), $sectionId);
	$childSections   = rm2Util::execSql($childSectionSql, $p, "SectionPeer");
	foreach ($childSections as $section) {
		/*@var $section Section*/
		$displays['section'][$section->getId()] = utilToCSection($section);
	}
	
	
	$ORDERBY = "";
	if ($sortBy == "modifiedDate") { $sortBy = "page.updated_at"; } 
	elseif ($sortBy == "displayDate") { $sortBy = "page.display_date"; } 
	elseif ($sortBy == "createdDate") { $sortBy = "page.created_at"; } 
	elseif ($sortBy == "id") { $sortBy = "page.id"; } 
	elseif ($sortBy == "title") { $sortBy = "page_i18n.title"; } 
	else { $sortBy = "page.sort_order"; }

	if ($sortBy != "") {
		$ORDERBY = "ORDER BY $sortBy $sort";
	}
	
	$LIMIT = "";
	if ($limit != "") {
		$LIMIT = "LIMIT 0, $limit";
	}
	
	//get the childPage
	$childPageSql = "SELECT * FROM %%page%% AS page 
						  LEFT JOIN %%page_i18n%% AS page_i18n ON (page.id = page_i18n.id)
						  LEFT JOIN %%section_page%% AS section_page ON (page.id = section_page.page_id)
						  WHERE section_page.site_id = ?
						  AND (page.active=1 OR page.redirect_active=1) 
		   				  AND ((page.launch_date IS NULL OR page.launch_date='') OR (CONCAT(page.launch_date, ' ', page.launch_time) <= '".date('Y-m-d H:i:s')."')) 
		   				  AND ((page.expiry_date IS NULL OR page.expiry_date='') OR (CONCAT(page.expiry_date, ' ', page.expiry_time) >= '".date('Y-m-d H:i:s')."'))
						  AND section_page.section_id = ?
						  $ORDERBY
						  $LIMIT";
	$childPageSql = str_replace("%%page%%", PagePeer::TABLE_NAME, $childPageSql);
	$childPageSql = str_replace("%%page_i18n%%", PageI18nPeer::TABLE_NAME, $childPageSql);
	$childPageSql = str_replace("%%section_page%%", SectionPagePeer::TABLE_NAME, $childPageSql);
	$p = array(rm2Util::getSiteId(), $sectionId);
	$childPages   = rm2Util::execSql($childPageSql, $p, "PagePeer");
	foreach ($childPages as $page){
		/*@var $page Page*/
		$displays['page'][$page->getId()] = utilToCPage($page);
	}
	return $displays;
}

function utilGetSiteCdnUrl()
{
    return rm2Util::getSite()->getCdnCompatibleWebUrl();
}

/**
 * all the codes below are from mysql prodeducer of spDropDownSections
 * get Menus max level 4
 */
function getMenuChildsByParentIdLevel4($parentId='' , $sortBy="sort_order" , $sort="ASC" , $level = 0){
    
    $siteId = rm2Util::getSiteId();
    $culture = getLanguage();
    $parentId = (int)$parentId;

    $sql = "SELECT section.id, section_i18n.name, section.redirect_active, section.redirect_url, section.redirect_type  
    		FROM section, section_i18n 
    		WHERE section.site_id=".$siteId." 
    			AND section.id=section_i18n.id 
    			AND (section.active=1 OR section.redirect_active=1)
    			AND section.show_dropdown = 1
    			AND section_i18n.culture='".$culture."' 
    			AND section.parent_id=".$parentId." 
    			ORDER BY ".$sortBy." ".$sort.", section.id ASC";
    $connection = Propel::getConnection(UserPeer::DATABASE_NAME);
    $result = $connection->executeQuery ($sql);
    $rows = getRowsFromResultSet($result);
    if($level<4){
        foreach($rows as $index=>$row){
            $rows[$index]['childs'] = getMenuChildsByParentIdLevel4($row['id'] ,  $sortBy  , $sort  , $level + 1);
        }
    }
    return $rows;
}

/**
 * all the codes below are from mysql prodeducer of spDropDownSections
 * get all parent sections
 */
function getParentSectionsByPageId($pageId=''){
	
	$siteId = rm2Util::getSiteId();
    $culture = getLanguage();
    $pageId = (int)$pageId;
    $sql = "SELECT section_id
    		FROM section_page
    		WHERE site_id=".$siteId." 
    			AND page_id=".$pageId;
   	$connection = Propel::getConnection(UserPeer::DATABASE_NAME);
    $result = $connection->executeQuery ($sql);
    $rows = getRowsFromResultSet($result);
    $parentId = $rows[0]['section_id'];
    if(isset($rows[0]['section_id'])){
    	getParentSectionsBySectionId($parentIds, $parentId);
    	sort($parentIds);
    }else{
    	$parentIds = array();
    }
    
    return $parentIds;
}

function getParentSectionsBySectionId(&$parentIds, $sectionId='', $level = 0){
	$siteId = rm2Util::getSiteId();
    $culture = getLanguage();
    $sectionId = (int)$sectionId;

    $sql = "SELECT parent_id  
    		FROM section 
    		WHERE site_id=".$siteId." 
    		    AND id=".$sectionId;
    $connection = Propel::getConnection(UserPeer::DATABASE_NAME);
    $result = $connection->executeQuery ($sql);
    $rows= getRowsFromResultSet($result);
    $parentIds[] = $sectionId;
    if(0 != $rows[0]["parent_id"] && $level < 100){
        getParentSectionsBySectionId($parentIds, $rows[0]["parent_id"] , $level + 1);
    }
}

function utilHighlightWords($query, $str){
	$newArray = array();
	$array = explode(' ', $query);
	foreach($array as $val){
		if($val){
			$newArray[] = $val;
		}
	}
	$specialChars = array('*', '.', '?', '+', '$', '^', '[', ']', '(', ')', '{', '}', '|', '\\', '/', '%');
	foreach($specialChars as $char){
		foreach($newArray as $key => $val){
			if(strstr($val, $char)){
				$newArray[$key] = str_replace($char, "", $val);
			}
		}
	}
	usort($newArray, "cmp");

	$search  = array();
	$replace = array();
	foreach ($newArray as $key => $keyword){
		$str = preg_replace("/(" . $keyword . ")/i", '<span class="highlight">$1</span>', $str);
		preg_match_all('/<span (.*?)>(.*?)<\/span>/i', $str, $matches);
		foreach ($matches['0'] as $elementKey => $element){
			$search[]  = "%".$key."_".$elementKey."%";
			$replace[] = $element;
			$str = str_replace($element, "%".$key."_".$elementKey."%", $str);
		}
	}
	$str = str_replace($search, $replace, $str);
	return $str;
}

function utilRemoveSpecialChar($str, $chars){
	$charArray = explode(",", $chars);
	foreach($charArray as $char){
		if(strstr($str, $char)){
			$str = str_replace($char, "", $str);
		}
	}
	return $str;
}

/* @desc: get the customerField 
 * @auto: windy
 * @return: array $customerField
 */
 
 function utilGetCustomField($contentId, $moduleId){
    $culture = getLanguage();
    $customerField = new CCustomField($contentId,$moduleId,$culture);
    return $customerField;
 }
 
 function utilGetCustomFieldValueByFieldId($customFieldId, $contentId, $moduleId){
    $customerField = utilGetCustomField($contentId, $moduleId);
    $value = $customerField->getCustomValue($customFieldId,$contentId);
    return $value;
 }

/** 
 * update the form data status 
 * @author  michael.yang
 * @param   formId          [integer]       the form id
 * @param   submissionId    [integer]       the form data id
 * @param   toStatus        [string]        the form data status, must be in the list: 'New', 'Saved', 'Submitted', 'Approved'. ignore case.
 * @return  true    update successfully
 * @return  false   the form doesn't exist; the form data id is empty; the status is not in the list: 'New', 'Saved', 'Submitted', 'Approved';
 *                  the status is not changed.
 */
function utilUpdateFormSubmissionStatus($formId, $submissionId, $toStatus){ 

    $submissionId = intval($submissionId);
    if(!$submissionId){
        throw new InvalidArgumentException("invalid submission id");
    }
    
    $statusArray = FormPeer::getRecordStatus();
    $status = '';
    $toStatus = strtolower($toStatus);
    foreach($statusArray as $key => $val){
        if($toStatus == strtolower($val)){
            $status = $key;
            break;
        }
    }
    if('' == $status){
        throw new InvalidArgumentException("invalid status");
    }
    
    $formId = intval($formId);
    $c = new Criteria();
    $c->add(FormPeer::SITE_ID, rm2Util::getSiteId());
    $c->add(FormPeer::ID, $formId);
    $form = FormPeer::doSelectOne($c);
    if(!$form){
        throw new InvalidArgumentException("invalid form id");
    }

    $tableName = FormPeer::getTableName($form);
    $fieldName = FormPeer::getFormRecordStatusFieldName();

    $sql = "UPDATE $tableName SET $fieldName=? WHERE id=?";
    $p = array($status, $submissionId);
    $connection = Propel::getConnection("master");
    $statement = $connection->prepareStatement($sql);
    $row = $statement->executeUpdate($p);
    if($row){
        return true;
    }else{
        return false;
    }
}

/**
 * 
 * @param string $sportName
 * @param int $genderId
 */
function utilGetCurlConferenceData($sportName, $genderId) {
    $originalReturnArray = array('PPG' => array(), 'AVG' => array(), 'G' => array(), 'GA' => array(), 'kills' => array(), 'blocks' => array());
    $conferences = array('acaa', 'acac', 'ocaa', 'pacwest', 'rseq');
    $returnArray = array();
    $gender = intval($genderId) === 1 ? 'Mens' : 'Womens';
    foreach ($conferences as $conference) {
        $sportFilename = SF_ROOT_DIR . '/frontend/sites/ccaa/web/scrapedata/' . $conference . DIRECTORY_SEPARATOR . $sportName . $gender . ucfirst($conference) . '.txt';
        $sportDataOfConference = rapidManagerUtil::readPathFile($sportFilename);
        $sportData = $sportDataOfConference ? unserialize($sportDataOfConference) : array();
        //Removed with a key element of independent
        foreach ($sportData as $key => $gameDatas) {
            unset($gameDatas);
            if ($sportData[$key]) {
                $originalReturnArray[$key] = array_merge($originalReturnArray[$key], $sportData[$key]);
            }
        }
    }
    foreach ($originalReturnArray as $index => $data) {
        $returnArray[$index] = rapidManagerUtil::removeSameInMultiArray($data);
        utilSortArrayByKey($returnArray[$index], $index);
        $returnArray[$index] = rapidManagerUtil::appendRankByKey($returnArray[$index], $index);
    }
    return $returnArray;
}

function utilSortArrayByKey(&$array, $key) {
    $sortKey = array();
    foreach ($array as $rows) {
        $sortKey[] = $rows[$key];
    }
    $key == 'GA' ? array_multisort($sortKey, SORT_ASC, $array) : array_multisort($sortKey, SORT_DESC, $array);
}
