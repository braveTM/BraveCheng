<?php
/**
 * Description of MarketProvider
 *
 * @author moi
 */
class MarketProvider extends BaseProvider{
    /**
     * 获取行情列表
     * @param  <string> $from     起始时间
     * @param  <string> $to       终止时间
     * @param  <int>    $province 省份编号
     * @param  <int>    $cert     证书编号
     * @param  <int>    $certs    多个证书编号
     * @param  <int>    $page     第几页
     * @param  <int>    $size     每页几条
     * @param  <int>    $count    是否统计总条数
     * @return <mixed>
     */
    public function get_market_list($from, $to, $province, $cert, $certs, $page, $size, $count){
        $this->da->setModelName('certificate_market');
        if(!empty($from) && !empty($to)){
            $where['date'] = array('between', "'$from','$to'");
        }
        else if(!empty($from)){
            $where['date'] = array('gt', $from);
        }
        else if(!empty($to)){
            $where['date'] = array('lt', $to);
        }
        if(!empty($province)){
            $where['province'] = $province;
        }
        if(!empty($cert)){
            $where['cert_id'] = $cert;
        }
        if(!empty($certs)){
            $where['cert_id'] = array('in', $certs);
        }
        if($count){
            return $this->da->where($where)->count('cert_id');
        }
        else{
            $order = 'sort DESC';
            return $this->da->where($where)->order($order)->page($page.','.$size)->select();
        }
    }
    
    /**
     * 模糊搜索注册证书
     * @param string $cert_like
     * @param string $major_like 
     * @return 
     */
    public function search_rcert($search){
        $this->da->setModelName('register_certificate_info t1');
        $like = explode(' ', $search);
        $cert_like = trim($like[0]);
        $major_like = trim($like[1]);
        if(empty($cert_like)){
            return null;
        }
        $where['t1.name'] = array('like', "%$cert_like%");
        $where['t1.is_del'] = 0;
        $join[] = C('DB_PREFIX').'register_certificate t2 ON t2.register_certificate_info_id=t1.register_certificate_info_id';
        $field = 't2.register_certificate_id as id';
        if(empty($major_like)){
            return $this->da->join($join)->where($where)->field($field)->select();
        }
        $join[] = C('DB_PREFIX').'register_certificate_major t3 ON t3.register_certificate_major_id=t2.register_certificate_major_id';
        $where['t3.name'] = array('like', "%$major_like%");
        $where['t3.is_del'] = 0;
        return $this->da->join($join)->where($where)->field($field)->select();
    }

    /**
     * 获取年度市场行情数据
     * @param type $cert 证书编号
     * @param type $area 地区编号
     * @return mixed
     */
    public function get_year_market_list($cert, $area){
        $this->da->setModelName('certificate_market_year');
        $where['cert_id'] = $cert;
        $where['area_id'] = $area;
        return $this->da->where($where)->select();
    }
}

?>
