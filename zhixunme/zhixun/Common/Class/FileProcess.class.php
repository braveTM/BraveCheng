<?php
/**
 * Description of FileProcess
 * 文件处理类
 * @author moi
 */
class FileProcess {
    /**
     * 允许上传的文件后缀
     * @var <array>
     */
    public $allow_exts = array();       //为空表示无限制

    /**
     * 允许上传的文件类型
     * @var <array>
     */
    public $allow_types = array();      //为空表示无限制

    /**
     * 允许上传的最大文件大小
     * @var <int>
     */
    public $max_size = -1;              //-1表示大小无限制

    /**
     * 文件上传
     * @param  <string> $name      上传表单中file标签的name
     * @param  <string> $save_path 保存目录
     * @return <mixed> 成功：上传文件保存路径
     *                  失败：-1 文件大小超出了最大限制     -2 文件后缀名不合法    -3 文件类型不合法
     *                       -4 文件上传出错     -5 文件名重复    -6 文件保存出错
     */
    public function upload($name, $save_path){
        if(!$this->check_size($_FILES[$name]["size"])){
            return -1;                  //文件大小超出了最大限制
        }
        $ext = $this->get_ext($_FILES[$name]["name"]);
        if(!$this->check_ext($ext)){
            return -2;                  //文件后缀名不合法
        }
        if(!$this->check_type($_FILES[$name]["type"])){
            return -3;                  //文件类型不合法
        }
        if ($_FILES[$name]["error"] > 0){
            return -4;                  //文件上传出错
        }
        $filename = $this->get_filename($save_path, $ext);
        //if (!file_exists($save_path))   //目录不存在则新建目录
        mk_dir($save_path);               //递归创建目录
        if (file_exists($filename)){
            return -5;                  //文件名重复
        }
        $result = move_uploaded_file($_FILES[$name]["tmp_name"], $filename);
        if(!$result){
            return -6;                  //文件保存出错
        }
        return $filename;
    }

    /**
     * 获取文件后缀名
     * @param  <string> $file 文件名
     * @return <string> 后缀名
     */
    public function get_ext($file){
        $filenameinfo = pathinfo($file);
        return $filenameinfo['extension'];
    }

    /**
     * 获取文件名称
     * @param  <string> $dir 文件路径
     * @param  <string> $ext 文件后缀名
     * @return <string> 文件名称
     */
    public function get_filename($dir = '', $ext = ''){
        if($ext != '')
            $ext = '.'.$ext;
        return $dir.time().$ext;
    }

    /**
     * 检测文件后缀
     * @param  <string> $ext 文件后缀
     * @return <bool> 是否合法
     */
    public function check_ext($ext){
        if(!empty($this->allow_exts))
            return in_array(strtolower($ext),$this->allow_exts);
        return true;
    }

    /**
     * 检测文件类型
     * @param  <string> $type 文件类型
     * @return <bool> 是否合法
     */
    public function check_type($type){
        if(!empty($this->allow_types))
            return in_array(strtolower($type),$this->allow_types);
        return true;
    }

    /**
     * 检测文件大小
     * @param  <int> $size 文件大小
     * @return <bool> 是否合法
     */
    public function check_size($size){
        if(($this->max_size != -1) && ($_FILES[$name]["size"] > $this->max_size))
            return false;
        return true;
    }
}
?>
