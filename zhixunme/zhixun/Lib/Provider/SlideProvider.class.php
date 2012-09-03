<?php
/**
 * Description of SlideProvider
 *
 * @author moi
 */
class SlideProvider extends BaseProvider{
    /**
     * 获取指定位置的幻灯片列表
     * @param  <int> $location_id 位置编号
     * @return <mixed> 幻灯片列表
     */
    public function get_slides($location_id){
        $this->da->setModelName('slide');               //使用幻灯片表
        $where['location_id'] = $location_id;
        $where['is_del']      = 0;
        return $this->da->where($where)->order('sort desc')->select();
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
        $this->da->setModelName('slide');               //使用幻灯片表
        $data['location_id']   = $location_id;
        $data['location_name'] = $location_name;
        $data['image']         = $image;
        $data['alt']           = $alt;
        $data['is_del']        = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 删除指定幻灯片
     * @param  <int> $id 幻灯片编号
     * @return <bool> 是否成功
     */
    public function delete_slide($id){
        $this->da->setModelName('slide');               //使用幻灯片表
        return $this->da->where(array('id' => $id))->save(array('is_del' => 0)) != false;
    }

    /**
     * 更新幻灯片
     * @param  <int>    $id
     * @param  <string> $image
     * @return <bool> 是否成功
     */
    public function update_slide($id, $image, $alt){
        $this->da->setModelName('slide');               //使用幻灯片表
        $where['id']     = $id;
        $where['is_del'] = $id;
        $data['image']   = $image;
        $data['alt']     = $alt;
        return $this->da->where($where)->save($data) !== false;
    }

    /**
     * 获取指定编号幻灯片
     * @param  <int> $id 编号
     * @return <array> 幻灯片
     */
    public function get_slide($id){
        $this->da->setModelName('slide');               //使用幻灯片表
        $where['id']     = $id;
        $where['is_del'] = $id;
        return $this->da->where($where)->find();
    }
}
?>
