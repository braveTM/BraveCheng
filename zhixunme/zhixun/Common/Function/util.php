<?php
/**
 * 文件下载
 * @param <string> $file 文件路径 
 * @param <string> $name 下载的文件名（非真实文件名）
 */
function download_file($file, $name){
    $type = substr($file, 0, 4);
    if($type == 'http'){
        $fp = fopen($file,"r");
        if(!$fp){
            echo 'File not found';
            exit();
        }
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=".$name);
        while (!feof($fp)){
            echo fread($fp, 50000);
        }
        fclose($fp);
    }
    else{
        if(!file_exists($file)){
            echo 'File not found';
            exit();
        }
        $fp = fopen($file,"r");
        $size = filesize($file);
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: ".$size);
        header("Content-Disposition: attachment; filename=".$name);
        echo fread($fp, $size);
        fclose($fp);
    }
}
?>
