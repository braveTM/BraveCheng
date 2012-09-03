<?php
require_cache(APP_PATH.'/Common/Class/ImageProcess.class.php');
/**
 * 图片加水印（适用于png/jpg/gif格式）
 * @param $src_img    原图片
 * @param $water_img  水印图片
 * @param $savepath  保存路径
 * @param $savename  保存名字
 * @param $positon   水印位置
 *                   1:顶部居左, 2:顶部居右, 3:居中, 4:底部局左, 5:底部居右
 * @param $alpha     透明度 -- 0:完全透明, 100:完全不透明
 * @return 成功 -- 加水印后的新图片地址
 *      失败 -- -1:原文件不存在, -2:水印图片不存在, -3:原文件图像对象建立失败
 *              -4:水印文件图像对象建立失败 -5:加水印后的新图片保存失败
 */
function image_water($src_img, $water_img, $savepath=null, $savename=null, $positon=5, $alpha=100){
    $image = new ImageProcess();
    return $image->image_water_mark($src_img, $water_img, $savepath, $savename, $positon, $alpha);
}

/**
 * 头像剪裁
 * @param  <string> $image_path 图片路径
 * @param  <int>    $offset_x   横向偏移量
 * @param  <int>    $offset_y   纵向偏移量
 * @param  <int>    $need_x     裁剪宽度
 * @param  <int>    $need_y     裁剪高度
 * @param  <int>    $canvas_x   新图宽度
 * @param  <int>    $canvas_y   新图高度
 * @param  <int>    $box_x      图片框宽度
 * @param  <int>    $box_y      图片框高度
 * @param  <string> $save_path  保存路径
 * @return <bool> 是否成功
 */
function image_cut_avatar($image_path, $offset_x, $offset_y, $need_x, $need_y, $canvas_x = 100, $canvas_y = 100, $box_x = 200, $box_y = 200, $save_path = null){
    $image  = new ImageProcess();
    $info   = $image->get_image_info($image_path);           //获取图像信息
    $width  = $info['width'];
    $height = $info['height'];
    $ratio  = 1;                                             //缩放比例
    if($width > $box_x)                                      //根据图像宽度获取缩放比例
        $ratio *= $width/$box_x;
    $height /= $ratio;
    if($height > $box_y)                                     //根据图像高度获取进一步缩放比例
        $ratio *= $height/$box_y;
    $offset_x = (int)($offset_x * $ratio);                   //计算真实横向偏移量
    $offset_y = (int)($offset_y * $ratio);                   //计算真实纵向偏移量
    $need_x   = (int)($need_x * $ratio);                     //计算真实裁剪宽度
    $need_y   = (int)($need_y * $ratio);                     //计算真实裁剪高度
    if($need_x > $info['width'] && $need_y > $info['height']){
        $need_x = $info['width'];
        $need_y = $info['height'];
    }
    return $image->image_cut($offset_x, $offset_y, $need_x, $need_y, $canvas_x, $canvas_y, $image_path, $save_path);
}

/**
 * 图片压缩
 * @param  <int>    $max_x 图片最大宽度
 * @param  <int>    $max_y 图片最大高度
 * @param  <string> $path  图片路径
 * @param  <bool>   $fixed 大小是否固定
 * @return <bool> 是否成功
 */
function image_compress($max_x, $max_y, $path, $save_path = '', $fixed = false){
    $image = new ImageProcess();
    return $image->image_compress($max_x, $max_y, $path, $save_path, $fixed);
}

/**
 * 获取图像详细信息
 * @param <type> $img
 * @return <type>
 */
function get_image_info($img){
    $image  = new ImageProcess();
    return $image->get_image_info($img);
}
?>
