<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//echo "<pre>";
//print_r($GLOBALS);

/**
 * 文章内容关键字替换函数，除了html代码里面的关键字都会进行替换
 * @global string $db 数据库链接对象
 * @param string $article 文章内容
 * @return string 返回替换后的文章内容
 */
function relpaceArticeKeywords($article = '') {
    global $db;
    $sql = "SELECT link_name,link_url FROM post_link where link_show = 1";
    $ar = $db->getAll($sql);

    foreach ($ar as $val) {
        $keyword[$val['link_name']] = '<a href="' . $val['link_url'] . '">' . $val['link_name'] . '</a>';
    }

    $reg = "/<[a][^>]+>.+<\/a>/i";
    preg_match_all($reg, $article, $array);
    #var_dump($array);
    #echo $article;exit;
    foreach ($array[0] as $value) {
        $keys = strtr($value, $keyword);

        $var[$keys] = $value;
    }
    $reg = "/<[^>]+>/i";
    preg_match_all($reg, $article, $array);
    #var_dump($array);
    #echo $article;exit;
    foreach ($array[0] as $value) {
        $keys = strtr($value, $keyword);

        $var[$keys] = $value;
    }
    $out = strtr($article, $keyword);
    if ($var) {
        $out = strtr($out, $var);
    }
    #echo $out;exit;
    return $out;
}

function relpaceOnceArticeKeywords($article = '') {
    global $db;
    $sql = "SELECT link_name,link_url FROM post_link where link_show = 1";
    $ar = $db->getAll($sql);

    foreach ($ar as $val) {
        $keyword[$val['link_name']] = '<a href="' . $val['link_url'] . '">' . $val['link_name'] . '</a>';
    }

    foreach ($keyword as $key => $value) {
        $article = str_replace_limit($key, $value, $article, 1);
    }

    return $article;
}

function str_replace_limit($search, $replace, $subject, $limit = -1) {
    if (is_array($search)) {
        foreach ($search as $k => $v) {
            $search[$k] = '`' . preg_quote($search[$k], '`') . '`';
        }
    } else {
        $search = '`' . preg_quote($search, '`') . '`';
    }
    return preg_replace($search, $replace, $subject, $limit);
}

$a = range(0.1, 4.9, 0.1);


$ac = array_map('array_flip', $a);
print_r($ac);

print_r($a);