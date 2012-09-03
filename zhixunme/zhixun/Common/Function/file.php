<?php
require_cache(APP_PATH.'/Common/Class/FileProcess.class.php');
/**
 * 文件上传
 * @param  <string> $name      上传表单中file标签的name
 * @param  <string> $save_path 保存目录
 * @param  <string> $type      文件类型（IMAGE,DOC,FILE）
 * @return <mixed> 成功：上传文件保存路径
 *                  失败：-1 文件大小超出了最大限制     -2 文件后缀名不合法    -3 文件类型不合法
 *                       -4 文件上传出错     -5 文件名重复    -6 文件保存出错
 */
function file_upload($name, $save_path, $type = 'IMAGE'){
    $file = new FileProcess();
    $file->max_size    = C($type.'_MAX_SIZE');
    $file->allow_exts  = C($type.'_ALL_EXTS');
    $file->allow_types = C($type.'_ALL_TYPES');
    return $file->upload($name, $save_path);
}
?>
