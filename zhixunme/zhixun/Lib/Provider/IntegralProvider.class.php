<?php
/**
 * Description of IntegralProvider
 *
 * @author moi
 */
class IntegralProvider extends BaseProvider{
    /**
     * 添加积分增长记录
     * @param  <int>    $user_id   用户编号
     * @param  <string> $user_name 用户名
     * @param  <int>    $integral  积分
     * @param  <string> $reason    增长原因
     * @param  <int>    $type      增长类型
     * @return <bool> 是否成功
     */
    public function add_integral_record($user_id, $user_name, $integral, $reason, $type){
        $this->da->setModelName('user_integral');                  //使用积分表
        $data['user_id']   = $user_id;
        $data['user_name'] = $user_name;
        $data['integral']  = $integral;
        $data['reason']    = $reason;
        $data['type']      = $type;
        $data['date']      = date_f();
        $data['is_del']    = 0;
        return $this->da->add($data) !== false;
    }

    /**
     * 用户积分增长记录列表
     * @param  <int> $user_id 用户编号
     * @param  <int> $page    第几页
     * @param  <int> $size    每页几条
     * @return <mixed> 增长列表
     */
    public function get_integral_list($user_id, $page, $size){
        $this->da->setModelName('user_integral');                  //使用信誉度表
        $where['user_id'] = $user_id;
        $where['is_del']  = 0;
        $data = $this->da->where($where)->page($page.','.$size)->order('date desc')->select();
        if(!empty($data)){
            return $data;
        }
        return null;
     }
}
?>
