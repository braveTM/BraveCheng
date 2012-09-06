<?php

header("Content-type:text/html;charset=UTF-8");
define('IN_ECS', true);
// database host
$db_host = "192.168.0.250:3306";

// database name
$db_name = "meilele_zx";

// database username
$db_user = "meilele";

// database password
$db_pass = "mllhelp139";

require('./includes/cls_mysql.php');
require ('./includes/lib_base.php');
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$db->query("set wait_timeout = 28000");
$db->query("set names utf8");

/**
 * getAllInfo();
 */
/**
 * setKeywordsLink();
 */

/**
 * 获取所有的文章信息
 */
function getAllInfo() {
    $list = getQueryCat(72);
    foreach ($list as $value) {
        $listElse[] = getQueryCat($value['term_id']);
    }
    foreach ($listElse as $value) {
        foreach ($value as $val) {
            array_push($list, $val);
        }
    }
    $i = $j = 0;
    foreach ($list as $value) {
        //文章
        $articles = getRelationArticle($value['term_taxonomy_id']);
        $term = getTermID($value['term_taxonomy_id']);
        if ($articles) {
            foreach ($articles as $value) {
                $article = getArticle($value['object_id']);
                $insertArt = array(
                    'post_id' => $article['ID'],
                    "post_cat" => $term['term_id'],
                    "post_title" => ($article['post_title']),
                    'post_content' => ("<p>" . str_replace("\n", "</p><p>", str_replace("\r\n", "</p><p>", $article['post_content'])) . "</p>"),
                    'post_author' => '美乐乐装修网',
                    'post_order' => $article['menu_order'],
                    'post_show' => 1,
                    'post_recommend' => 1,
                    'post_time' => strtotime($article['post_date']),
                    'post_modify_time' => strtotime($article['post_modified']),
                    'seo_title' => ($article['seo_title']),
                    'seo_keywords' => ($article['seo_keywords']),
                    'seo_description' => ($article['seo_description']),
                );
                insertArt(setDB('192.168.0.250:3306', 'meilele', 'mllhelp139', 'zx_new'), $insertArt);
                echo $i . "<br>";
                $i++;
            }
        }
        //文章分类
        $category = getCatInfo($value['term_id']);
        if ($category) {
            $data = array(
                "cat_id" => $value['term_id'],
                'cat_parent' => $value['parent'],
                'cat_name' => $category['name'],
                'cat_url' => $category['slug'],
                'cat_order' => $category['order'],
                'cat_show' => $category['is_show'],
                'seo_title' => $category['seo_title'],
                'seo_keywords' => $category['seo_keywords'],
                'seo_description' => $category['seo_description'],
            );
            insertCate(setDB('192.168.0.250:3306', 'meilele', 'mllhelp139', 'zx_new'), $data);
            echo $j . "<br>";
            $j++;
        }
    }
}

function setDB($db_host, $db_user, $db_pass, $db_name) {
    $db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
    $db->query("set wait_timeout = 28000");
    $db->query("set names utf8");
    return $db;
}

/**
 * 插入新数据库文章分类
 * @param type $db
 * @param type $array
 */
function insertCate($db, $array = array()) {
    $data["cat_id"] = $array['cat_id'];
    $data['cat_parent'] = $array['cat_parent'];
    $data['cat_name'] = $array['cat_name'];
    $data['cat_url'] = $array['cat_url'];
    $data['cat_order'] = $array['cat_order'];
    $data['cat_show'] = $array['cat_show'];
    $data['seo_title'] = $array['seo_title'];
    $data['seo_keywords'] = $array['seo_keywords'];
    $data['seo_description'] = $array['seo_description'];
    $db->autoExecute('post_cat', $data, 'INSERT');
}

/**
 * 插入新数据库文章
 * @param type $db
 * @param type $array
 */
function insertArt($db, $array = array()) {
    $data['post_id'] = $array['post_id'];
    $data['post_cat'] = $array['post_cat'];
    $data['post_title'] = $array['post_title'];
    $data['post_content'] = $array['post_content'];
    $data['post_author'] = $array['post_author'];
    $data['post_order'] = $array['post_order'];
    $data['post_show'] = $array['post_show'];
    $data['post_recommend'] = $array['post_recommend'];
    $data['post_time'] = time();
    $data['post_modify_time'] = time();
    $data['seo_title'] = $array['seo_title'];
    $data['seo_keywords'] = $array['seo_keywords'];
    $data['seo_description'] = $array['seo_description'];
    $db->autoExecute('post', $data, 'INSERT');
}

/**
 * 获取指定类别关系
 * @return type
 */
function getQueryCat($id) {
    global $db;
//    $sql = 'select * from _term_taxonomy where taxonomy = "category"';
    $sql = 'select * from _term_taxonomy where parent = ' . $id;
    return $db->getAll($sql);
}

function getTermID($termid) {
    global $db;
    $sql = 'select term_id from _term_taxonomy where term_taxonomy_id = ' . $termid;
    return $db->getRow($sql);
}

/**
 * 分类信息
 * @global cls_mysql $db
 * @param type $id
 * @return type
 */
function getCatInfo($id) {
    global $db;
    $sql = "SELECT * FROM _terms Where term_id = '$id'";
    return $db->getRow($sql);
}

/**
 * 文章信息
 * @global cls_mysql $db
 * @return type
 */
function getArticle($aid) {
    global $db;
    if ($aid) {
        $sql = 'SELECT * FROM _posts where ID = ' . $aid;
        return $db->getRow($sql);
    } else {
        return false;
    }
}

/**
 * 文章关系
 * @global cls_mysql $db
 * @param type $rid
 * @return type
 */
function getRelationArticle($rid) {
    global $db;
    $sql = 'SELECT * FROM _term_relationships where term_taxonomy_id = ' . $rid;
    $col = $db->getAll($sql);
    return $col;
}

/**
 * 读取老数据库的关键字链接
 * @global cls_mysql $db
 * @return type
 */
function keywordsLink() {
    global $db;
    $sql = "SELECT * FROM meilele_zx.wp_keywords";
    return $db->getAll($sql);
}

/**
 * 
 */
function setKeywordsLink() {
    $keyword = keywordsLink();
    $i = 0;
    foreach ($keyword as $value) {
        $data = array(
            'link_name' => $value['name'],
            'link_url' => $value['url'],
            'link_show' => 1,
            'link_order' => 0,
        );
        $db = setDB('192.168.0.250:3306', 'meilele', 'mllhelp139', 'zx_new');
        $db->autoExecute('post_link', $data, 'INSERT');
        echo $i . '<br>';
        $i++;
    }
}

function getArticeKeywords($article = '') {
    $db = setDB('192.168.0.250:3306', 'meilele', 'mllhelp139', 'zx_new');
    $sql = "SELECT link_name,link_url FROM zx_new.post_link where link_show = 1";
    foreach ($db->getAll($sql) as $val) {
        $keyword[$val['link_name']] = '<a href="' . $val['link_url'] . '">' . $val['link_name'] . '</a>';
    }
    $reg = "/<.+?>.+<.+?>/i";
    preg_match_all($reg, $article, $array);
    foreach ($array as $value) {
        foreach ($value as $key => $value) {
            $keys = strtr($value, $keyword);
            $var[$keys] = $value;
        }
    }
    return strtr(strtr($article, $keyword), $var);
}

$art = '儿童房 客厅图片 dasfasdfasd的ｕ哈润肤露那三地方看见啊ｌｋａｓｄ；ｆｌｋ厨房图片<li><a href="/php/php_functions.asp" title="PHP 函数">PHP 函数</a></li>
<li><a href="/php/php_forms.asp" title="PHP 表单和用户输入">PHP 表单</a></li>
<li><a href="/php/php_get.asp" title="儿童房">PHP $_GET</a></li>
<li><a href="/php/php_post.asp" title="PHP $_POST">PHP $_POST</a></li>
';
print_r(getArticeKeywords($art));


