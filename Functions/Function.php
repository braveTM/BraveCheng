<?php

/**
  /**
 * 获取指定分类下的所有子分类ID，对引用的理解与引用算法
 * @param type $catid
 * @return type
 */
function getCategoryID($catid, &$str = '') {
    $url = $GLOBALS['_module']->getDataByMod("mod_designer.GetCategoryID", array("catparent" => $catid));
    if ($url) {
        foreach ($url as $value) {
            $str .= $value['cat_id'] . ',';
            getCategoryID($value['cat_id'], $str);
        }
    }
    return $str;
}

function mkdirs($dir) {
    if (!is_dir($dir)) {
        if (!mkdirs(dirname($dir))) {
            return false;
        }
        if (!mkdir($dir, 0777)) {
            return false;
        }
    }
    return true;
}

/**
 * 根据两个数组，判断一个数组是否在另一个数组里面的算法研究
 * @param array $arr
 * @return string
 */
function html_checkboxes($arr) {
    $name = $arr['name'];
    $checked = $arr['checked'];
    $options = $arr['options'];

    $out = '';
    $checked = explode(",", $checked);


    foreach ($options as $key => $val) {
        if (is_array($checked)) {
            $tmp = FALSE;
            foreach ($checked as $value) {
                $int = (int) $value;
                if ($key === $int) {
                    $tmp = TRUE;
                    break;
                }
            }
            if ($tmp) {
                $out.= "<input type=\"checkbox\" name=\"$name\" value=\"$key\" checked>&nbsp;{$val}&nbsp;";
            } else {
                $out.= "<input type=\"checkbox\" name=\"$name\" value=\"$key\">&nbsp;{$val}&nbsp;";
            }
        } else {
            $out.= "<input type=\"checkbox\" name=\"$name\" value=\"$key\">&nbsp;{$val}&nbsp;";
        }
    }

//                foreach ($options AS $key => $val) {
//                        if (in_array($key, $checked)) {
//                                $out.= "<input type=\"checkbox\" name=\"$name\" value=\"$key\" checked>&nbsp;{$val}&nbsp;";
//                        } else {
//                                $out .= "<input type=\"checkbox\" name=\"$name\" value=\"$key\">&nbsp;{$val}&nbsp;";
//                        }
//                }

    return $out;
}

/**
 * 替换字符关键字 仅仅替换一次，同时对<img> <a>标签友好支持
 * @global string $db 数据库句柄
 * @param string $article 字符串
 * @return string 替换后的字符串
 */
function relpaceOnceArticeKeywords($article = '') {
    global $db;
    $sql = "SELECT link_name,link_url FROM post_link where link_show = 1";
    $ar = $db->getAll($sql);

    foreach ($ar as $val) {
        $keyword[$val['link_name']] = '<a href="' . $val['link_url'] . '">' . $val['link_name'] . '</a>';
    }
    $reg = "/<a.*?>.*?<\/a>/i";
    preg_match_all($reg, $article, $array);
    $i = 0;
    foreach ($array[0] as $value) {
        $var[$value] = '{{' . $i . '}}';
        $i++;
    }
    if (is_array($var) && !empty($var)) {
        $articleTemp = strtr($article, $var);
        foreach ($keyword as $key => $value) {
            $articleTemp = str_replace_limit($key, $value, $articleTemp, 1);
        }
        $article = strtr($articleTemp, array_flip($var));
    } else {
        foreach ($keyword as $key => $value) {
            $article = str_replace_limit($key, $value, $article, 1);
        }
    }

    return $article;
}

/**
 * 替换一次或多次文字
 * @param string $search
 * @param string $replace
 * @param string $subject
 * @param number $limit
 * @return string
 */
function str_replace_limit($search, $replace, $subject, $limit = -1) {
    if (is_array($search)) {
        foreach ($search as $k => $v) {
            $search[$k] = '`' . preg_quote($search[$k], '`') . '`';
        }
    } else {
        $search = '/' . preg_quote($search, '`') . '/';
    }
    return preg_replace($search, $replace, $subject, $limit);
}

/**
 * 数组开头插入键值数组
 * @param array $arr 
 * @param mixed $key
 * @param mixed $val
 * @return array
 */
function array_unshift_assoc(&$arr, $key, $val) {
    $arr = array_reverse($arr, true);
    $arr[$key] = $val;
    $arr = array_reverse($arr, true);
    return $arr;
}
