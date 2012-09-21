<?php

/**
 * 读取Excel内容
 * @param type $file_name
 */
function readExcel($file_name) {
        require ('../Library/Excel/Excel.class.php');
        $excel = new Excel();
        $excel->setOutputEncoding("UTF-8");
        $excel->read($file_name);
        $data = $excel->sheets[0]['cells'];
        return $data;
}

