<?php

header("Content-type:text/html;charset=UTF-8");
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
echo '<pre>';
print_r($array);

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

/**
 * 友好输出
 * @param mixed $expression
 */
function printr($expression) {
    echo "<pre>";
    print_r($expression);
}

printr(bsort(array(1, 3, 44, 2, 134, 1, 23, 0)));
?>
