<?php
/**
 * Description of MarketService
 *
 * @author moi
 */
class MarketService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new MarketProvider();
    }
    
    /**
     * 搜索本月行情
     * @param int    $province 省份编号
     * @param int    $page     第几页
     * @param int    $size     每页几条
     * @param bool   $count    是否统计总条数
     * @param string $like     关键字
     * @return 
     */
    public function search_market_by_current_month($province, $page, $size, $count = false, $like = null){
        if(empty($province))            //地区不能为空
            return null;
        $month =date('m');
        $from = date('Y-m-d H:i:s', mktime(00, 00, 00, $month, 1));
        $to = date('Y-m-d H:i:s', mktime(23, 59, 59, $month + 1, 0));
        if(empty($like)){
            return $this->provider->get_market_list($from, $to, $province, null, null, PF($page), SF($size), $count);
        }
        else{
            $ids = $this->provider->search_rcert($like);
            if(empty($ids))
                return null;
            foreach($ids as $id){
                $in .= $id['id'].',';
            }
            $in = rtrim($in, ',');
            return $this->provider->get_market_list($from, $to, $province, null, $in, PF($page), SF($size), $count);
        }
    }

    /**
     * 获取指定地区证书的指定年份行情
     * @param int $cert_id  证书编号
     * @param int $province 省份编号
     * @param int $year     年份
     * @return  
     */
    public function get_year_market($cert_id, $province, $year){
        if(!var_validation($year, VAR_YEAR))
            return null;
        $from = $year.'-01-01 00:00:00';
        $to   = $year.'-12-31 23:59:59';
        return $this->provider->get_market_list($from, $to, $province, $cert_id, null, 1, 12, false);
    }
    
    /**
     * 获取年度市场行情数据
     * @param type $cert 证书编号
     * @param type $area 地区编号
     * @return mixed
     */
    public function get_year_market_list($cert, $area){
        return $this->provider->get_year_market_list($cert, $area);
    }
}

?>
