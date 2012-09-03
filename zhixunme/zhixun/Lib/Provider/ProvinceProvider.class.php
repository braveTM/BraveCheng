<?php
/**
 * Description of ProvinceProvider
 *
 * @author moi
 */
class ProvinceProvider extends BaseProvider{
    /**
     * 获取省份列表
     * @return <mixed> 省份列表
     */
    public function get_province_list(){
        $this->da->setModelName('province');                //使用省份表
        return $this->da->order('sort desc')->select();
    }

    /**
     * 指定代码省份是否存在
     * @param  <string> $code 省份代码
     * @return <bool> 是否成功
     */
    public function is_exists_province($code){
        $this->da->setModelName('province');                //使用省份表
        $data = $this->da->where(array('code' => $code))->find();
        if(!empty($data)){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * 获取指定省份信息
     * @param  <int> $code 省份代码
     * @return <array> 省份信息
     */
    public function get_province($code){
        $this->da->setModelName('province');                //使用省份表
        return $this->da->where(array('code' => $code))->find();
    }
}
?>
