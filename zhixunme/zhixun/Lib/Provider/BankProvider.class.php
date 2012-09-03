<?php
/**
 * Description of BankProvider
 *
 * @author moi
 */
class BankProvider extends BaseProvider{
    /**
     * 指定银行编号是否存在
     * @param  <int> $bank_id 银行编号
     * @return <bool> 是否存在
     */
    public function exists_bank_id($bank_id){
        $this->da->setModelName('bank');
        $where['bank_id']     = $bank_id;
        $where['is_del'] = 0;
        return $this->da->where($where)->count() > 0;
    }

    /**
     * 获取银行列表
     * @returne <mixed> 银行列表
     */
    public function get_bank_list(){
        $this->da->setModelName('bank');
        $where['is_del'] = 0;
        return $this->da->where($where)->order('sort DESC')->select();
    }
}
?>
