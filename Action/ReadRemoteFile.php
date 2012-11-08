<?php

header('Content-type:text/html;charset=utf-8');

/**
 * 远程获取大文件内容 比较
 */
//基于内存的读取
function getData1($url) {
    ob_start();
    readfile($url);
    $data = ob_get_contents();
    ob_end_clean();
    return $data;
}

//传统获取方式
function getData2($url) {
    $data = file_get_contents($url);
    return $data;
}

//获取当前时间
function getTime($convert = true) {
    return microtime($convert);
}

//获取当前内存
function memory() {
    return memory_get_usage();
}

/**
 * --------测试1
 */
$url = 'http://player.youku.com/player.php/sid/XNDU0MzY0Mjky/v.swf'; //雷霆扫毒30集 测试1
//$url = 'http://detail.tmall.com/item.htm?spm=a1z10.1.w3.18.FauNyr&id=19338828264&&ali_trackid=17_b459f4fd94045903eac23599aaf1a627'; //测试2
$m = memory();
$s = getTime();
$data = getData1($url);
file_put_contents('data1.txt', $data);
echo "方式：readfile ";
echo '文件大小:' . filesize('data1.txt') . '内存：' . (memory() - $m) . ',耗时:' . (getTime() - $s);
exit;
/**
 * --------测试2
 */
$m = memory();
$s = getTime();
$data = getData2($url);
echo "方式：file_get_content";
file_put_contents('data2.txt', $data);

echo '文件大小:' . filesize('data2.txt') . '内存：' . (memory() - $m) . ',耗时:' . (getTime() - $s);