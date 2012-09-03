<?php
/**
 * Description of home_tool_market_page
 *
 * @author moi
 */
class home_tool_market_page {
    /**
     * 获取行情列表
     * @param type $province
     * @param type $like
     * @param type $page
     * @param type $size
     * @return type 
     */
    public static function get_market_list($province, $like, $page, $size){
        $service = new MarketService();
        $data = $service->search_market_by_current_month($province, $page, $size, false, $like);
        $cs = new CertificateService();
        foreach($data as $key => $value){
            $cert = $cs->get_register_certificate_info($value['cert_id']);
            $data[$key]['cert_name'] = $cert['cert_name'];
            if(array_key_exists('major_name', $cert))
                $data[$key]['major_name'] = $cert['major_name'];
        }
        return FactoryVMap::list_to_models($data, 'home_market_normal');
    }
    
    /**
     * 获取行情数量
     * @param type $province
     * @param type $like
     * @return type 
     */
    public static function get_market_count($province, $like){
        $service = new MarketService();
        return $service->search_market_by_current_month($province, 1, 1, true, $like);
    }
    
    /**
     * 获取年度行情统计
     * @param type $cert_id
     * @param type $province
     * @param type $year
     * @return type 
     */
    public static function get_year_market($cert_id, $province, $year){
        $service = new MarketService();
        $data = $service->get_year_market($cert_id, $province, $year);
        return FactoryVMap::list_to_models($data, 'home_market_chart');
    }
    
    /**
     * 获取年度行情统计对比
     * @param type $cert 证书编号
     * @param type $area 地区编号 
     * @return type 
     */
    public static function get_year_market_compare($cert, $area){
        $service = new MarketService();
        $data = $service->get_year_market_list($cert, $area);
        return FactoryVMap::list_to_models($data, 'home_market_year');
    }
}

?>
