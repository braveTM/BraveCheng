<?php
/**
 * Description of SlideService
 *
 * @author moi
 */
class SlideService{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new SlideProvider();
    }
    
    /**
     * 获取指定位置的幻灯片列表
     * @param  <int> $location_id 位置编号
     * @return <mixed> 幻灯片列表
     */
    public function get_slides($location_id){
        return $this->provider->get_slides($this->filter_location_id($location_id));
    }

    /**
     * 添加幻灯片图片
     * @param  <int>    $location_id   位置编号
     * @param  <string> $location_name 位置描述
     * @param  <string> $image         图片路径
     * @param  <string> $alt           图片描述
     * @return <bool> 是否成功
     */
    public function add_slide($location_id, $location_name, $image, $alt){
        if($this->provider->add_slide($this->filter_location_id($location_id), $this->filter_location_name($location_name), $this->filter_image($image), $this->filter_alt($alt))){
            return true;
        }
        return false;
    }

    /**
     * 删除指定幻灯片
     * @param  <int> $id 幻灯片编号
     * @return <bool> 是否成功
     */
    public function delete_slide($id){
        if($this->provider->delete_slide($id)){
            return true;
        }
        return false;
    }

    /**
     * 更新幻灯片
     * @param  <int>    $id
     * @param  <string> $image
     * @return <bool> 是否成功
     */
    public function update_slide($id, $image, $alt){
        if($this->provider->update_slide($id, $this->filter_image($image), $this->filter_alt($alt))){
            $slide = $this->provider->get_slide($id);
            return true;
        }
        return false;
    }

    /**
     * 获取指定编号幻灯片
     * @param  <int> $id 编号
     * @return <array> 幻灯片
     */
    public function get_slide($id){
        return $this->provider->get_slide($id);
    }

    //---------------protected----------------
    /**
     * 位置编号过滤
     * @param  <int> $location_id 位置编号
     * @return <int>
     */
    protected function filter_location_id($location_id){
        return intval($location_id);
    }

    /**
     * 位置描述过滤
     * @param  <string> $location_name 位置描述
     * @return <string>
     */
    protected function filter_location_name($location_name){
        if(strlen($location_name) > 60)
            $location_name = str_sub ($location_name, 60);
        return htmlspecialchars($location_name);
    }

    /**
     * 图片路径过滤
     * @param  <string> $image 图片路径
     * @return <string>
     */
    protected function filter_image($image){
        if(strlen($image) > 100)
            $image = str_sub ($image, 100);
        return $image;
    }

    /**
     * 图片描述过滤
     * @param  <string> $alt 图片描述
     * @return <string>
     */
    protected function filter_alt($alt){
        if(strlen($alt) > 100)
            $alt = str_sub ($alt, 100);
        return $alt;
    }
}
?>
