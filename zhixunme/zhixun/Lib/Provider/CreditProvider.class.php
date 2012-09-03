<?php
/**
 * Description of CreditProvider
 *
 * @author moi
 */
class CreditProvider extends BaseProvider {
    /**
     * 添加信誉度增长记录
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <int>    $credit    信誉度
     * @param  <string> $reason    增长原因
     * @param  <int>    $type      增长类型
     * @return <bool> 是否成功
     */
    public function add_credit_record($user_id, $user_name, $credit, $reason, $type){
        $this->da->setModelName('user_credit');                  //使用信誉度表
        $data['user_id']   = $user_id;
        $data['user_name'] = $user_name;
        $data['credit']    = $credit;
        $data['reason']    = $reason;
        $data['type']      = $type;
        $data['date']      = date_f();
        $data['is_del']    = 0;
        return $this->da->add($data) !== false;
    }

    /**
     * 用户信誉度增长记录列表
     * @param  <int> $user_id 用户编号
     * @param  <int> $page    第几页
     * @param  <int> $size    每页几条
     * @return <mixed> 增长列表
     */
    public function get_credit_list($user_id, $page, $size){
        $this->da->setModelName('user_credit');                  //使用信誉度表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        $data = $this->da->where($where)->page($page.','.$size)->order('date desc')->select();
        if(!empty($data)){
            return $data;
        }
        return null;
    }

    /**
     * 根据信誉度分数获取对应信誉度等级信息
     * @param  <int> $credit 信誉度分数
     * @return <array> 等级信息
     */
    public function get_credit_level($credit){
        $this->da->setModelName('user_credit_level');       //使用信誉度表
        $where['min_score'] = array('elt', $credit);
        $where['max_score'] = array('egt', $credit);
        return $this->da->where($where)->find();
    }
}
?>
