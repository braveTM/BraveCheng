<?php

/**
  /**
 * 获取指定分类下的所有子分类ID，对引用的理解与引用算法
 * @param type $catid
 * @return type
 */
function getCategoryID($catid, &$str = '') {
    // if this function in class, $url must be set static
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
 * create a directory cycle
 * @param string $path filepath
 */
function createDir($path) {
    if (!file_exists($path)) {
        self::createDir(dirname($path));
        mkdir($path, 0777);
    }
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

/**
 * php三维数组去重
 * @param array $array
 * @return array
 */
function remove_same_muti_array($array) {
    // 新建一个空的数组.
    $tmp_array = array();
    $new_array = array();
    // 1. 循环出所有的行. ( $val 就是某个行)
    foreach ($array as $val) {
        $hash = md5(json_encode($val));
        if (!in_array($hash, $tmp_array)) {
            // 2. 在 foreach 循环的主体中, 把每行数组对象得hash 都赋值到那个临时数组中.
            $tmp_array[] = $hash;
            $new_array[] = $val;
        }
    }
    return $new_array;
}

/**
 * PHP XSS过滤函数
 * @param mixed $val
 * @return mixed
 */
function RemoveXSS($val) {
    // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed  
    // this prevents some character re-spacing such as <java\0script>  
    // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs  
    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

    // straight replacements, the user should never need these since they're normal characters  
    // this prevents like <IMG SRC=@avascript:alert('XSS')>  
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        // ;? matches the ;, which is optional 
        // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars 
        // @ @ search for the hex values 
        $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ; 
        // @ @ 0{0,7} matches '0' zero to seven times  
        $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ; 
    }

    // now the only remaining whitespace attacks are \t, \n, and \r 
    $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true; // keep replacing as long as the previous round replaced something 
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern .= '|';
                    $pattern .= '|(&#0{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag  
            $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags  
            if ($val_before == $val) {
                // no replacements were made, so exit the loop  
                $found = false;
            }
        }
    }
    return $val;
}

function executeDownloadCsv() {
    $csvName = $this->getRequestParameter('csvName');
    $csvHandle = fopen('php://output', 'w');
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=$csvName.csv");
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    if ($csvHandle) {
        fputcsv($csvHandle, self::$config[$csvName]);
    }
    exit;
}

function createDirByExec($path, $mode, $user, $group) {
    if (!file_exists($path)) {
        self::createDir(dirname($path), $mode, $user, $group);
        mkdir($path);
        exec("chmod -R $mode $path");
        exec("chown -R $user:$group $path");
    }
}


/**
 * get conference file data multi-array sort and multi-array merge
 * @param string $sportName
 * @param int $genderId
 */
function utilGetCurlConferenceData($sportName, $genderId) {
    $new = array('PPG' => array(), 'AVG' => array());
    $conference = array(
        'acaa',
        'acac',
        'ocaa',
        'pacwest',
        'rseq',
    );
    $sex = intval($genderId) === 1 ? 'Mens' : 'Womens';
    $keys = array_keys($new);
    foreach ($conference as $con) {
        $logPath = SF_ROOT_DIR . '/frontend/sites/ccaa/web/scrapedata/' . $con . '/';
        $mens = $logPath . $sportName . $sex . ucfirst($con) . '.txt';
        $content = utilReadOver($mens);
        $res = $content ? unserialize($content) : FALSE;
        foreach ($res as $key => $value) {
            if (in_array($key, $keys)) {
                if ($res[$key]) {
                    $new[$key] = array_merge($new[$key], $res[$key]);
                }
            }
            unset($value);
        }
    }

    //classic code. sort by code desc
    foreach ($keys as $item) {
        foreach ($new[$item] as $k => $v) {
            if ($v[$item]) {
                $code[$k] = $v[$item];
            }
        }
        if ($item == 'GA') {
            array_multisort($code, SORT_ASC, $new[$item]);
        } else {
            array_multisort($code, SORT_DESC, $new[$item]);
        }
        unset($code);
    }
}