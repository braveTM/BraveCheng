<?php
/**
 * Description of ImageProcess
 * 图像处理类
 * @author moi
 */
class ImageProcess {
    /**
     * 获取图像信息
     * @param <string> $img 图像路径
     * @return <mixed> 图像信息
     */
    public function get_image_info($img) {
        $imageInfo = getimagesize($img);
        if ($imageInfo !== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
            $imageSize = filesize($img);
            $info = array(
                "width" => $imageInfo[0],
                "height" => $imageInfo[1],
                "type" => $imageType,
                "size" => $imageSize,
                "mime" => $imageInfo['mime']
            );
            return $info;
        } else {
            return false;
        }
    }

    /**
     * 图片压缩
     * @param  <int>    $max_x 图片最大宽度
     * @param  <int>    $max_y 图片最大高度
     * @param  <string> $path  图片路径
     * @param  <bool>   $fixed 大小是否固定
     * @return <bool> 是否成功
     */
    public function image_compress($max_x, $max_y, $path, $save_path = "", $fixed = false){
        $img_src   = file_get_contents($path);
        $image     = imagecreatefromstring($img_src);//用该方法获得图象,可以避免“图片格式”的问题
        $width     = imagesx($image);//取得图像宽度
        $height    = imagesy($image);//取得图像高度
        $save_path = $save_path == "" ? $path : $save_path;
        $pathinfo  = pathinfo($save_path);
        if(!file_exists($pathinfo["dirname"]))
            mk_dir ($pathinfo["dirname"]);
        $c = false;
        if($fixed){
            $c       = true;
            $_width  = $max_x;
            $_height = $max_y;
        }
        else{
            $_width  = $width;
            $_height = $height;
            if($_width > $max_x){
                $_height = $_height * $max_x / $_width;
                $_width  = $max_x;
                $c       = true;
            }
            if($_height > $max_y){
                $_width  = $_width * $max_y / $_height;
                $_height = $max_y;
                $c       = true;
            }
        }
        if($c){
            $_width  = (int)$_width;
            $_height = (int)$_height;
            $img_src = file_get_contents($path);
            $image   = imagecreatefromstring($img_src);//用该方法获得图象,可以避免“图片格式”的问题
            if (function_exists('imagecreatetruecolor')&&(function_exists('imagecopyresampled'))){
                /*生成高质量的缩略图方法*/
                $dst=imagecreatetruecolor($_width,$_height);//新建一个真彩色图象
                $background_color = imagecolorallocate($dst, 255, 255, 255);
                imagefilledrectangle($dst,0,0,$_width,$_height,$background_color);
                imagecopyresampled($dst,$image,0,0,0,0,$_width,$_height,$width,$height);//重采样拷贝部分图像并调整大小
            }
            else {
                $dst=imagecreate($_width,$_height);
                $background_color = imagecolorallocate($dst, 255, 255, 255);
                imagefilledrectangle($dst,0,0,$_width,$_height,$background_color);
                imagecopyresized($dst,$image,0,0,0,0,$_width,$_height,$width,$height);
            }
            $fileSuffix = $pathinfo["extension"];
            $fileSuffix = strtolower($fileSuffix);
            if($fileSuffix == "gif")
                $result = imagegif ($dst, $save_path);
            else if($fileSuffix == "png")
                $result = imagepng ($dst, $save_path);
            else
                $result = imagejpeg($dst, $save_path);
            imagedestroy($image);
            imagedestroy($dst);
            return $result;
        }
        if($path == $save_path)
            return true;
        return copy($path, $save_path);
    }

    /**
     * 图片剪裁
     * @param <int>    $offset_x   起始点的横向偏移量
     * @param <int>    $offset_y   起始点的纵向偏移量
     * @param <int>    $need_x     裁剪宽度
     * @param <int>    $need_y     裁剪高度
     * @param <int>    $canvas_x   新图宽度
     * @param <int>    $canvas_y   新图高度
     * @param <string> $image_path 原图路径
     * @param <string> $save_path  保存路径
     * @return <bool> 是否成功
     */
    public function image_cut($offset_x, $offset_y, $need_x, $need_y, $canvas_x, $canvas_y, $image_path, $save_path = null){
        $img_src = file_get_contents($image_path);
        $image = imagecreatefromstring($img_src);//用该方法获得图象,可以避免“图片格式”的问题
        $pathinfo = pathinfo($image_path);
        if(empty($save_path))
            $save_path = $image_path;//保存路径为空则覆盖原图
        $pinfo    = pathinfo($save_path);
        if(!file_exists($pinfo["dirname"]))
            mk_dir ($pinfo["dirname"]);
        if (function_exists('imagecreatetruecolor')&&(function_exists('imagecopyresampled'))){
            /*生成高质量的缩略图方法*/
            $dst=imagecreatetruecolor($canvas_x,$canvas_y);//新建一个真彩色图象
            $background_color = imagecolorallocate($dst, 255, 255, 255);
            imagefilledrectangle($dst,0,0,$canvas_x,$canvas_y,$background_color);
            imagecopyresampled($dst,$image,0,0,$offset_x,$offset_y,$canvas_x,$canvas_y,$need_x,$need_y);//重采样拷贝部分图像并调整大小
        }
        else {
            $dst=imagecreate($canvas_x,$canvas_y);
            $background_color = imagecolorallocate($dst, 255, 255, 255);
            imagefilledrectangle($dst,0,0,$canvas_x,$canvas_y,$background_color);
            imagecopyresized($dst,$image,0,0,$offset_x,$offset_y,$canvas_x,$canvas_y,$need_x,$need_y);
        }
        $fileSuffix = $pathinfo["extension"];
        $fileSuffix = strtolower($fileSuffix);
        if($fileSuffix == "gif")
            $result = imagegif ($dst, $save_path);
        else if($fileSuffix == "png")
            $result = imagepng ($dst, $save_path);
        else
            $result = imagejpeg($dst, $save_path);
        imagedestroy($image);
        imagedestroy($dst);
        return $result;
    }

    /**
     * 图片加水印（适用于png/jpg/gif格式）
     * @param $src_img    原图片
     * @param $water_img  水印图片
     * @param $save_path  保存路径
     * @param $savename  保存名字
     * @param $positon   水印位置
     *                   1:顶部居左, 2:顶部居右, 3:居中, 4:底部局左, 5:底部居右
     * @param $alpha     透明度 -- 0:完全透明, 100:完全不透明
     * @return 成功 -- 加水印后的新图片地址
     *      失败 -- -1:原文件不存在, -2:水印图片不存在, -3:原文件图像对象建立失败
     *              -4:水印文件图像对象建立失败 -5:加水印后的新图片保存失败
     */
    public function image_water_mark($src_img, $water_img, $save_path=null, $savename=null, $positon=5, $alpha=100){
         $temp = pathinfo($src_img);
         $name = $temp['basename'];
         $path = $temp['dirname'];
         $exte = $temp['extension'];
         $exte = strtolower($exte);
         if($exte == "gif"){
             if(isGifAnimation($src_img))//gif动画不加水印
                return;
         }
         $savename = $savename ? $savename : $name;
         $save_path = $save_path ? $save_path : $path;
         $savefile = $save_path .'/'. $savename;
         $srcinfo = @getimagesize($src_img);
         if($srcinfo[0] < 220 || $srcinfo[1] < 130)
             return;
         if (!$srcinfo) {
            return -1;  //原文件不存在
         }
         $waterinfo = @getimagesize($water_img);
         if (!$waterinfo) {
            return -2;  //水印图片不存在
         }
         $src_imgObj = $this->image_create_from_ext($src_img);
         if (!$src_imgObj) {
              return -3;  //原文件图像对象建立失败
         }
         $water_imgObj = $this->image_create_from_ext($water_img);
         if (!$water_imgObj) {
              return -4;  //水印文件图像对象建立失败
         }
         switch ($positon) {
             //1顶部居左
             case 1: $x=$y=0; break;
             //2顶部居右
             case 2: $x = $srcinfo[0]-$waterinfo[0]; $y = 0; break;
             //3居中
             case 3: $x = ($srcinfo[0]-$waterinfo[0])/2; $y = ($srcinfo[1]-$waterinfo[1])/2; break;
             //4底部居左
             case 4: $x = 0; $y = $srcinfo[1]-$waterinfo[1]; break;
             //5底部居右
             case 5: $x = $srcinfo[0]-$waterinfo[0]; $y = $srcinfo[1]-$waterinfo[1]; break;
             default: $x=$y=0;
         }
         imagecopymerge($src_imgObj, $water_imgObj, $x, $y, 0, 0, $waterinfo[0], $waterinfo[1], $alpha);
         //imagecopy($src_imgObj, $water_imgObj, $x, $y, 0, 0, $waterinfo[0], $waterinfo[1]);
         switch ($srcinfo[2]) {
             case 1: imagegif($src_imgObj, $savefile); break;
             case 2: imagejpeg($src_imgObj, $savefile); break;
             case 3: imagepng($src_imgObj, $savefile); break;
             default: return -5;  //保存失败
         }
         imagedestroy($src_imgObj);
         imagedestroy($water_imgObj);
         return $savefile;
}

    protected function image_create_from_ext($imgfile){
         $info = getimagesize($imgfile);
         $im = null;
         switch ($info[2]){
             case 1: $im=imagecreatefromgif($imgfile); break;
             case 2: $im=imagecreatefromjpeg($imgfile); break;
             case 3: $im=imagecreatefrompng($imgfile); break;
         }
         return $im;
    }
}
?>
