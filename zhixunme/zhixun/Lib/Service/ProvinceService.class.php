<?php
/**
 * Description of ProvinceService
 *
 * @author moi
 */
class ProvinceService {
    /**
     * 期望地区过滤
     */
    public function filter_place($pids){
        $provider = new ProvinceProvider();
        if($pids === '0' || $pids === 0){
            return '0';
        }
        else{
            $pros = explode(',', $pids);                                    //地区要求
            $i = 0;                                                         //计数
            foreach($pros as $pro){
                if($i > 4){                                                 //最多五个地区
                    break;
                }
                if($pro > 0 && $provider->is_exists_province($pro)){
                    $place .= $pro.',';
                    $i++;
                }
            }
            if($i > 0){
                return rtrim($place, ',');
            }
            else{
                return '0';                                                 //地区要求为空
            }
        }
    }

    /**
     * 获取指定省份信息
     * @param  <int> $code 省份代码
     * @return <array> 省份信息
     */
    public function get_province($code){
        $provider = new ProvinceProvider();
        return $provider->get_province($code);
    }

    /**
     * 获取指定城市信息
     * @param  <int> $code 城市代码
     * @return <array> 城市信息
     */
    public function get_city($code){
        $provider = new CityProvider();
        return $provider->get_city($code);
    }
}
?>
