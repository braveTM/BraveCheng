<?php
/**
 * Description of PromoteDomain
 *
 * @author zhiguo
 */
class PromoteDomain {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new PromoteProvider();
    }

    /**
     *获取推广位占用记录列表
     * @param <type> $user_id 用户编号
     */
    public function get_promote_record_list($user_id,$order) {
        return $this->provider->get_promote_record_list($user_id, $order);
    }

    /**
     *获取推广位列表
     * @param <type> $page 第几页
     * @param <type> $size 每页条数
     * @param <type> $order 排序
     * @param <int>  $role_id 角色编号
     */
    public function get_promote_list($page,$size,$order, $role_id = null) {
        return $this->provider->get_promote_list($page, $size, $order, $role_id);
    }

    /**
     *添加推广位记录
     * @param <type> $user_id 用户编号
     * @param <type> $promote_id 推广位编号
     * @param <type> $start_time 开始时间
     * @param <type> $end_time 过期时间
     */
    public function add_promote_record($user_id,$promote_id,$start_time,$end_time) {
        return $this->provider->add_promote_record($user_id, $promote_id, $start_time, $end_time);
    }

    /**
     *判断指定推广位当前是否被占用
     * @param <type> $promote_id 推广位ID
     * @return <type>
     */
    public function is_hold_promote($promote_id) {
        return $this->provider->is_hold_promote($promote_id);
    }

    /**
     *获取指定推广位的当前占用记录
     * @param <type> $promote_id  推广位ID
     */
    public function get_current_promote_record($promote_id) {
        return $this->provider->get_current_promote_record($promote_id);
    }

    /**
     * 获取指定推广位
     * @param <type> $promote_id 推广位ID
     * @return <type>
     */
    public function get_promote($promote_id) {
        return $this->provider->get_promote($promote_id);
    }

    /**
     * 获取推广位数目
     */
    public function get_promote_total_count() {
        return $this->provider->get_promote_total_count();
    }

    /**
     * 占用推广位
     * @param <int> $promote_id 推广位编号
     * @param <int> $days   占用天数
     * @param <int> $user_id  用户编号
     * @param <string> $user_name 用户昵称
     * @return <mixed>  成功返回ture ，失败返回错误信息 
      */
    public function hold_promote($promote_id,$days,$user_id,$user_name) {
        $promote=$this->provider->get_promote($promote_id);
        if (is_null($promote)) {                                  //判断该推广位是否存在
            return E(ErrorMessage::$PROMOTE_NOT_EXISTS);
        }
        if (AccountInfo::get_role_id() !== intval($promote['role_id'])) {  //判断是否有抢占该推广位的权限
            return E(ErrorMessage::$NO_HOLD_PROMOTE_PERMISSION);
        }
        if ($this->provider->is_hold_promote($promote_id)) {           //判断该推广位是否被占用
            return E(ErrorMessage::$IS_HOLD_PROMOTE);
        }
        if ($days < intval($promote['min_days']) || $days > intval($promote['max_days'])){ // 判断申请的推广位占用天数是否合法
            return E(ErrorMessage::$PROMOTE_DAYS_ERROR);
        }

        $this->provider->trans();                                           //事务开启
        $domain = new BillDomain();
        $money=intval($promote['price'])*$days;
        $result = $domain->consume($user_id, $user_name, $money, '抢占推广位:'.$promote['title']);      //支付推广位
        if($result !== true) {                                       //支付失败
            $this->provider->rollback();                            //事务回滚
            return $result;
        }
        $start_time=date_f();
        $end_time=date_f(null, time() +  $days* 86400);
        if(!$this->provider->add_promote_record($user_id, $promote_id, $start_time, $end_time)) {   //添加推广位记录                                 //发布任务
            $this->provider->rollback();                                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();                                          //事务提交
        return true;
    }
}
?>
