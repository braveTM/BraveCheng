<?php
/**
 * Description of ServiceService
 *
 * @author moi
 */
class ServiceService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new ServiceProvider();
    }

    /**
     * 获取指定编号服务信息
     * @param  <int> $id 服务编号
     * @return <array> 服务信息
     */
    public function get_service($id){
        return $this->provider->get_service(intval($id));
    }
    
    /*
     * 获取所有服务列表
     */
    public function get_service_list(){
        return $this->provider->get_service_list();
    }

    /**
     * 是否存在指定服务
     * @param  <int> $id 编号
     * @return <bool> 是否存在
     */
    public function is_exists_service($id){
        return $this->provider->is_exists_service($id);
    }
}
?>
