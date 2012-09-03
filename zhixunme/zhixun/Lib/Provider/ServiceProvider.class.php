<?php
/**
 * Description of ServiceProvider
 *
 * @author moi
 */
class ServiceProvider extends BaseProvider{
    /**
     * 获取指定编号服务信息
     * @param  <int> $id 服务编号
     * @return <array> 服务信息
     */
    public function get_service($id){
        $this->da->setModelName('system_service');              //使用系统增值服务表
        $where['id'] = $id;
        return $this->da->where($where)->find();
    }

    /**
     *
     * @return <type> 推广套餐列表
     */

    public function get_service_list(){
        $this->da->setModelName('system_service');              //使用系统增值服务表
        return $this->da->select();
    }

    /**
     * 是否存在指定服务
     * @param  <int> $id 编号
     * @return <bool> 是否存在
     */
    public function is_exists_service($id){
        $this->da->setModelName('system_service');              //使用系统增值服务表
        $where['id'] = $id;
        return $this->da->where($where)->count('id') > 0;
    }
}
?>
