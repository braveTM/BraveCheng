<?php

header("Content-type:text/html;charset=utf-8");
echo "Today is :" . date(DATE_COOKIE);

function ExplodeLines($text, $cloumnNames) {
    $oneArray = explode(" ", $text);
    $i = $j = 0;
    foreach ($oneArray as $value) {
        $val = explode(",", $value);
        $ar[$i] = array($cloumnNames[0] => $val[0], $cloumnNames[1] => $val[1], $cloumnNames[2] => $val[2]);
        $i++;
    }
    return $ar;
}

$text = "Apple,20,red Pear,10,yellow";
$columnNames = array('Fruit', 'Number', 'Color');
$array = ExplodeLines($text, $columnNames);
printr($array);

function ch_num($num, $mode = true) {
    $char = array("零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖");
    $dw = array("", "拾", "佰", "仟", "", "萬", "億", "兆");
    $dec = "點";
    $retval = "";
    if ($mode)
        preg_match_all("/^0*(\d*)\.?(\d*)/", $num, $ar);
    else
        preg_match_all("/(\d*)\.?(\d*)/", $num, $ar);

    if ($ar[2][0] != "")
        $retval = $dec . ch_num($ar[2][0], false); //如果有小数，先递归处理小数 
    if ($ar[1][0] != "") {
        $str = strrev($ar[1][0]);
        for ($i = 0; $i < strlen($str); $i++) {
            $out[$i] = $char[$str[$i]];
            if ($mode) {
                $out[$i] .= $str[$i] != "0" ? $dw[$i % 4] : "";
                if ($str[$i] + $str[$i - 1] == 0)
                    $out[$i] = "";
                if ($i % 4 == 0)
                    $out[$i] .= $dw[4 + floor($i / 4)];
            }
        }
        $retval = join("", array_reverse($out)) . $retval;
    }
    return $retval;
}

echo ch_num("300045");

/**
 * 冒泡排序
 * @param array $array 需要排序的数组
 * @return array 排序后的数组
 */
function bsort($array = array()) {
    $len = count($array);
    if (!is_array($array) || $len <= 0)
        return FALSE;
    for ($i = 1; $i < $len; $i++) {
        for ($index = 0; $index < $len; $index++) {
            /**
             * 从小到大的顺寻
             */
//            if ($array[$i] < $array[$index]) {
//                $temp = $array[$i];
//                $array[$i] = $array[$index];
//                $array[$index] = $temp;
//            }
            /**
             * 从大到小的顺序
             */
            if ($array[$i] > $array[$index]) {
                $temp = $array[$index];
                $array[$index] = $array[$i];
                $array[$i] = $temp;
            }
        }
    }
    return $array;
}
if (!function_exists('compare')) {

    function compare() {
        $args = func_get_args();
        $count = count($args[0]);
        $list = $args[0];
        //控制循环的个数
        for ($index = 1; $index < ( $count - 1); $index++) {
            //两两比较
            for ($j = 0; $j < ($count - $index); $j++) {
                if ($list[$j] < $list[$j + 1]) {
                    $temp = $list[$j];
                    $list[$j] = $list[$j + 1];
                    $list[$j + 1] = $temp;
                }
            }
        }
        return $list;
    }

}
/**
 * 友好输出
 * @param mixed $expression
 */
function printr($expression) {
    echo "<pre>";
    print_r($expression);
}

printr(bsort(array(1, 3, 44, 2, 134, 1, 23, 0)));

/**
  sort(),asort(),ksort()的区别
  1、sort()函数按升序对给定的数组值排序，同时原有的键会被删除。
  2、asort()函数按升序给指定的数组值排序，同时保持索引关系
  3、ksort()函数按照键名对数组排序，同时保持索引关系
  $sortArray = array("a" => 1, 12, "11", "hello,world", "1" => 5, "keyword");
  printr($sortArray);
  sort($sortArray);
  echo "sort函数排序的结果如下：", printr($sortArray);
  asort($sortArray);
  echo "<b>asort函数的排序结果如下：</b>", printr($sortArray);
  ksort($sortArray);
  echo "<b>ksort函数的排序结果如下：</b>", printr($sortArray);
 * 
 */
/**
  用PHP打印前一天的时间
  echo date("Y-m-d H:i:s", strtotime("-1 day"));
 * 
 */
/**
  echo(),print(),print_r()的区别
  echo "echo 是语言结构，无返回值";
  echo "print功能和echo相同，print是函数，有返回值";
  echo "print_r是递归打印，用于数组打印";
 * 
 */
/**
  如何实现PHP,JSP交互
  SOAP,XML_RPC,SocketFunction,CURL
 * 
 */
/**
 * 如何实现字符串的反转
 *  echo strrev("hello,brave");

  function reverse($string) {
  $res = "";
  for ($index = 0, $i = strlen($string); $index < $i; $index++) {
  $res = $string[$index] . $res;
  }
  return $res;
  }

  echo reverse("hello");
 * 
 */
/**
 * 优化mysql数据库的方法
 * 1、选取最适用的字段属性，尽可能减少自定义字段长度，尽量把字段设置为NOT NULL,性别，省份最好设置为ENUM枚举类型
 * 2、使用连接(JOIN)来代替子查询(Sub-Queries)
 * 3、使用事务来进行多任务的操作
 * 
 */
/**
 * 实现中文字串截取无乱码的方法
 * mb_substr()函数与mb_strcut()函数
 * echo mb_substr("中华任命共和国", 0, 3, "utf-8");
 * echo "mb_strcut:" . mb_strcut("程度事情样去工业", 0, 3, 'utf-8');
 */
/**
 * 用PHP写出显示服务器端IP与客户端ＩＰ
 * echo "客户端端:" . $_SERVER['REMOTE_ADDR'];
 * echo "或者是:" . getenv("REMOTE_ADDR");
 * echo "服务器端代码:" . gethostbyname("www.cnblogs.com");
 * 
 */
/**
 * 写一个函数遍历文件夹下所有的文件
  function scan_dir($dir) {
  $files = array();
  if (is_dir($dir)) {
  if ($handle = opendir($dir)) {
  while (($file = readdir($handle)) !== FALSE) {
  if ($file != "." && $file != "..") {
  $files[$file] = scan_dir($dir . "/" . $file);
  } else {
  $files[] = $dir . "/" . $file;
  }
  }
  }
  closedir($handle);
  return $files;
  }
  }

  printr(scan_dir("/usr/share/nginx/www/demo/Demo/"));
 */
/**
 * MYSQL取得当前时间的函数是?，格式化日期的函数是
 * now(),dateformat()
 */
/**
 * 写一个函数，算出两个文件的相对路径?
  function getRelativePath($a, $b) {
  $returnPath = array(dirname($b));
  $arrA = explode('/', $a);
  $arrB = explode('/', $returnPath[0]);
  for ($n = 1, $len = count($arrB); $n < $len; $n++) {
  if ($arrA[$n] != $arrB[$n]) {
  break;
  }
  }
  if ($len - $n > 0) {
  $returnPath = array_merge($returnPath, array_fill(1, $len - $n, '..'));
  }

  $returnPath = array_merge($returnPath, array_slice($arrA, $n));
  return implode('/', $returnPath);
  }
 */
//http://data.meilele.com:8004/phpserver.php?module=user&method=Login&param={"user_name":"tester","password":"mll123"}
//$ch = curl_init("http://data.meilele.com/phpserver.php?module=common&method=xmlApi&param={%22sql_name%22:%22mod_apply.getProjectType%22,%22query_type%22:%22getAll%22,%22param%22:[]}");
//curl_exec($ch);
//curl_close($ch);


/**
 * MYSQL事务：
 * 事务是作为一个单元的一组有序的数据库操作，如果组中所有的操作都成功，则认为事务成功，同时执行所有的数据库操作，即使只有一个操作失败，则也认为事务失败，同时所有的已经执行的操作都将回滚，所作用的操作都将取消
 */
//PHP打印前一天的时间
var_dump(date('Y-m-d H:i:s'));
var_dump(date('Y-m-d H:i:s', strtotime('-2 day')));

//echo(),print(),print_r()的区别(3分)
/**
 * echo 是PHP语句，print print_r是函数，语句没有返回值，函数有返回值
 * print 只能打印简单类型的变量
 * print_r 可以打印复杂类型的变量，如数组
 */
//能够使HTML和PHP分离开使用的模板(1分)
/**
 * smarty
 * template lite
 */
//6、如何实现字符串翻转？(3分)

$str = "abcdefg";

function strrevv($str) {
    $len = strlen($str);
    $newstr = '';
    for ($i = $len; $i >= 0; $i--) {
        $newstr .= $str{$i};
    }
    return $newstr;
}

$showstr = strrevv($str);
var_dump($showstr);

//优化MYSQL数据库的方法。(4分，多写多得)
/**
 * 1、选择最适用的字段，应该把字段尽量设置为not null,这样在执行查询的时候，数据库不用去比较null值
 * 2、尽量少使用LIkE关键字和同佩服
 * 3、使用事务和外建
 * (1).数据库设计方面,这是DBA和Architect的责任,设计结构良好的数据库,必要的时候,去正规化(英文是这个:denormalize,中文翻译成啥我不知道),允许部分数据冗余,避免JOIN操作,以提高查询效率
  (2).系统架构设计方面,表散列,把海量数据散列到几个不同的表里面.快慢表,快表只留最新数据,慢表是历史存档.集群,主服务器Read & write,从服务器read only,或者N台服务器,各机器互为Master
 * SELECT * FROM order WHERE title>=”good” and name<”good”;
 */
//PHP的意思(送1分)
/**
 * Hypertext Preprocessor：PHP是一个基于服务端来创建动态网站的脚本语言，您可以用PHP和HTML生成网站主页
 */
//MYSQL取得当前时间的函数是?，格式化日期的函数是(2分)
/**
 * now()
 * DATE_FORMAT(date,format);
 */
//实现中文字串截取无乱码的方法
//mt_substr();

function redir($dir) {
    $filename = array();
    if (is_dir($dir)) {
        if (($resource = opendir($dir))) {
            while (($row = readdir($resource)) !== FALSE) {
                if ($row != "." && $row != "..") {
                    if (is_dir($dir . '/' . $row)) {
                        $filename[$row] = redir($dir . '/' . $row);
                    } else {
                        $filename[] = $dir . '/' . $row;
                    }
                }
            }
        } else {
            $filename[] = 'not open this folder';
        }
    } else {
        $filename[] = 'not is folder';
    }
    return $filename;
}

//$res = redir('/home/wwwroot');
//echo '<pre>',var_dump($res);

//快速排序（数组排序）
function quick_sort($array) {
if (count($array) <= 1) return $array;

$key = $array[0];
$left_arr = array();
$right_arr = array();

for ($i=1; $i<count($array); $i++){
if ($array[$i] <= $key)
$left_arr[] = $array[$i];
else
$right_arr[] = $array[$i];
}

$left_arr = quick_sort($left_arr);
$right_arr = quick_sort($right_arr);

return array_merge($left_arr, array($key), $right_arr);
}
2. 使用PHP描述顺序查找和二分查找（也叫做折半查找）算法，顺序查找必须考虑效率，对象可以是一个有序数组

//二分查找（数组里查找某个元素）
function bin_sch($array, $low, $high, $k){
if ($low <= $high){
$mid = intval(($low+$high)/2);
if ($array[$mid] == $k){
return $mid;
}elseif ($k < $array[$mid]){
return bin_sch($array, $low, $mid-1, $k);
}else{
return bin_sch($array, $mid+1, $high, $k);
}
}
return -1;
}

//顺序查找（数组里查找某个元素）
function seq_sch($array, $n, $k){
$array[$n] = $k;
for($i=0; $i<$n; $i++){
if($array[$i]==$k){
break;
}
}
if ($i<$n){
return $i;
}else{
return -1;
}
}
