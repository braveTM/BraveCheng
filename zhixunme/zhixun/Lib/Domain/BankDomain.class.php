<?php
/**
 * Description of BankDomain
 *
 * @author moi
 */
class BankDomain{
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new BankProvider();
    }

    /**
     * 指定银行编号是否存在
     * @param  <int> $bank_id 银行编号
     * @return <bool> 是否存在
     */
    public function exists_bank_id($bank_id){
        return $this->provider->exists_bank_id($bank_id);
    }

    /**
     * 获取银行列表
     * @returne <mixed> 银行列表
     */
    public function get_bank_list(){
        return $this->provider->get_bank_list();
    }
}
?>
