<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

unique_muti_array();

function unique_muti_array() {
    $argc = array(
        array(
            array(1 => 1, 2 => 5),
            array(1 => 451, 2 => 67),
        ),
        array(
            array(1 => 1, 2 => 5),
            array(1 => 451, 2 => 67),
        ),
        array(
            array(1 => 5656, 2 => 67),
        ),
    );
    var_dump($argc);



    echo '<hr>';
    $new_array = remove_same_muti_array($argc);
    var_dump($new_array);
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

?>
