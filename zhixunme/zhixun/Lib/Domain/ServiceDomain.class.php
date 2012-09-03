<?php
/**
 * Description of ServiceDomain
 *
 * @author moi
 */
class ServiceDomain {
    private $provider;

    function  __construct() {
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
    /**
     * 获取服务信息列表
     * @return <type> 
     */

    public function get_service_list(){
        return $this->provider->get_service_list();
    }
}
?>
