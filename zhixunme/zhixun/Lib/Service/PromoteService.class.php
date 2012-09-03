<?php
/**
 * Description of PromoteService
 *
 * @author zhiguo
 */
define('PROMOTE_TYPE_JOB', 1);
define('PROMOTE_TYPE_RESUME', 2);
define('PROMOTE_TYPE_TASK', 3);
define('PROMOTE_TYPE_TALENTS', 4);
define('PROMOTE_TYPE_COMPANY', 5);
define('PROMOTE_TYPE_AGENT', 6);
class PromoteService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new PromoteProvider();
    }

    /**
     * 获取推广位占用记录列表
     * @param <type> $user_id 用户编号
     */
    public function get_promote_record_list($user_id, $order) {
        return $this->provider->get_promote_record_list($user_id, $order);
    }

    /**
     * 获取推广位列表
     * @param <int>    $page    第几页
     * @param <int>    $size    每页条数
     * @param <string> $order   排序
     * @param <int>    $role_id 角色编号
     * @param <int>    $area    区域编号
     * @param <int>    $user_id 获取人编号
     * @param <int>    $marked  是否标注占用情况
     */
    public function get_promote_list($page, $size, $order, $role_id = null, $area = null, $user_id = null, $marked = false) {
        $data = $this->provider->get_promote_list($page, $size, $order, $role_id, $area);
        if($marked){
            foreach($data as $key => $value){
                $hold = $this->provider->get_hold_promote($value['id']);
                if(!empty($hold)){
                    if($hold['user_id'] == $user_id){
                        $data[$key]['_hold'] = 2;           //自己占用
                        $data[$key]['_info'] = $hold;
                    }
                    else
                        $data[$key]['_hold'] = 1;           //别人占用
                }
                else{
                    $data[$key]['_hold'] = 0;               //未被占用
                }
            }
        }
        return $data;
    }

    /**
     *添加推广位记录
     * @param <type> $user_id 用户编号
     * @param <type> $promote_id 推广位编号
     * @param <type> $start_time 开始时间
     * @param <type> $end_time 过期时间
     */
    public function add_promote_record($user_id, $promote_id, $start_time, $end_time) {
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
     * @param <int> $days       占用天数
     * @param <int> $user_id    用户编号
     * @param <int> $role_id    用户角色
     * @return <mixed>  成功返回ture ，失败返回错误信息
     */
    public function hold_promote($promote_id, $days, $user_id, $role_id) {
        $promote=$this->provider->get_promote($promote_id);
        if (empty($promote)) {                                  //判断该推广位是否存在
            return E(ErrorMessage::$PROMOTE_NOT_EXISTS);
        }
        if ($role_id != $promote['role_id']) {                  //判断是否有抢占该推广位的权限
            return E(ErrorMessage::$NO_HOLD_PROMOTE_PERMISSION);
        }
        if ($days < $promote['min_days'] || $days > $promote['max_days']){ // 判断申请的推广位占用天数是否合法
            return E(ErrorMessage::$PROMOTE_DAYS_ERROR);
        }
        if ($this->provider->is_hold_promote($promote_id)) {    //判断该推广位是否被占用
            return E(ErrorMessage::$IS_HOLD_PROMOTE);
        }
        $count = $this->provider->get_promote_records($user_id, $promote_id, date_f(), true);
        if($count > 0){
            return E(ErrorMessage::$PROMOTE_HAD);               //同一类推广位只允许购买一个
        }
        $this->provider->trans();                                           //事务开启
        $domain = new BillService();
        $money = intval($promote['price']) * $days;
        $result = $domain->consume($user_id, '', $money, '抢占推广位:' . $promote['title']);      //支付推广位
        if ($result !== true) {                                       //支付失败
            $this->provider->rollback();                            //事务回滚
            return $result;
        }
        $start_time = date_f();
        $end_time = date_f(null, time() + $days * 86400);
        if (!$this->provider->add_promote_record($user_id, $promote_id, $start_time, $end_time, $money)) {   //添加推广位记录                                 //发布任务
            $this->provider->rollback();                                    //事务回滚
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $this->provider->commit();                                          //事务提交
        return true;
    }

    /**
     *
     * 获取指定区域的推广位记录
     * @param  <int> $area_id 区域编号
     * @return <mixed>
     */
    public function get_area_promote_records($area_id){
        return $this->provider->get_area_promote_records($area_id, date_f(), false);
    }

    //-------------------以上为推广位-------------------
    
    /**
     * 获取推广服务列表
     * @param  <int> $type 服务类型（1职位2简历3任务4人才5企业6经纪人）
     * @return <mixed>
     */
    public function get_promote_services($type){
        return $this->provider->get_promote_services($type);
    }

    /**
     * 获取指定推广服务信息
     * @param  <int> $id 推广服务编号
     * @return <mixed>
     */
    public function get_promote_service($id){
        return $this->provider->get_promote_service($id);
    }

    /**
     * 获取指定用户和职位的指定服务未过期记录
     * @param  <int> $user_id 用户编号
     * @param  <int> $job_id  职位编号
     * @param  <int> $service 服务编号
     * @return <mixed>
     */
    public function get_job_promote_record($user_id, $job_id, $service){
        return $this->provider->get_promote_job_record($user_id, $job_id, $service, null, date_f(), true);
    }

    /**
     * 购买职位推广服务
     * @param  <int> $user_id    用户编号
     * @param  <int> $job_id     职位编号
     * @param  <int> $service_id 服务编号
     * @param  <int> $days       购买天数
     * @return <bool> 是否成功
     */
    public function buy_promote_job($user_id, $job_id, $service_id, $days){
        $service = new JobService();
        $check = $service->check_job_op_permission($job_id, $user_id, $job);    //检测职位操作权限
        if(is_zerror($check)){
            return $check;
        }
        $svc = $this->provider->get_promote_service($service_id);
        if(empty($svc) || $svc['type'] != PROMOTE_TYPE_JOB){                //检测服务类型
            return E(ErrorMessage::$PROMOTE_SERVICE_ERROR);
        }
        if($svc['min_days'] > $days || $svc['max_days'] < $days){               //检测服务购买天数
            return E(ErrorMessage::$PROMOTE_SERVICE_DATE_ERROR);
        }
        $date = date_f();
        if($svc['max_count'] != -1){                                            //提供总数不为无限
            $count = $this->count_job_promote_record(null, null, $service_id, null, $date);
            if($svc['max_count'] <= $count){
                return E(ErrorMessage::$PROMOTE_USER_FULL);                     //推广服务使用人数已满
            }
        }
        $money = $svc['price'] * $days;
        $service = new BillService();
        $this->provider->trans();                                               //事务开启
        $consume = $service->consume($user_id, '', $money, '[职位推广服务] 购买<'.$svc['title'].'>'.$days.'周; 推广职位:'.$job['title'].'.');
        if(is_zerror($consume)){                                                //消费
            $this->provider->rollback();                                        //事务开启
            return $consume;
        }
        $record = $this->provider->get_promote_job_record($user_id, $job_id, $service_id, null, $date, true);
        if(empty($record)){                                                     //添加职位推广记录
            $result = $this->provider->add_promote_job_record ($user_id, $job_id, $service_id, $date, date_f(null, time() + $days * 86400 * 7), $money);
        }
        else{                                                                   //延长职位推广时间
            //暂不提供延长推广
            return E(ErrorMessage::$PROMOTE_HAD);
//            $result = $this->provider->update_promote_job_record($record['id'], array(
//                'end_time'  => date_f(null, get_time($record['end_time']) + $days * 86400),
//                'cost'      => $record['cost'] + $money
//            ));
        }
        if(!$result){
            $this->provider->rollback();                                        //事务回滚
            return E();
        }
        $this->provider->commit();                                              //事务提交
        return true;
    }

    /**
     * 获取指定用户和简历的指定服务未过期记录
     * @param  <int> $user_id   用户编号
     * @param  <int> $resume_id 简历编号
     * @param  <int> $service   服务编号
     * @return <mixed>
     */
    public function get_resume_promote_record($user_id, $resume_id, $service){
        return $this->provider->get_promote_resume_record($user_id, $resume_id, $service, null, date_f(), true);
    }

    /**
     * 购买简历推广服务
     * @param  <int> $user_id    用户编号
     * @param  <int> $role_id    角色编号
     * @param  <int> $resume_id  简历编号
     * @param  <int> $service_id 服务编号
     * @param  <int> $days       购买天数
     * @return <bool> 是否成功
     */
    public function buy_promote_resume($user_id, $role_id, $resume_id, $service_id, $days){
        $provider = new ResumeProvider();                                       //检测简历操作权限
        if($role_id == C('ROLE_AGENT')){
            $data = $provider->getPrivateResumeStatus($resume_id);
            if($data['agent_id'] != $user_id){
                return E(ErrorMessage::$PERMISSION_LESS);
            }
        }
        else{
            $data = $provider->getResumeStatus($resume_id);
            if($data['creator_id'] != $user_id || $data['agent_id'] != 0)
                return E(ErrorMessage::$PERMISSION_LESS);
        }
        $svc = $this->provider->get_promote_service($service_id);
        if(empty($svc) || $svc['type'] != PROMOTE_TYPE_RESUME){             //检测服务类型
            return E(ErrorMessage::$PROMOTE_SERVICE_ERROR);
        }
        if($svc['min_days'] > $days || $svc['max_days'] < $days){               //检测服务购买天数
            return E(ErrorMessage::$PROMOTE_SERVICE_DATE_ERROR);
        }
        $date = date_f();
        if($svc['max_count'] != -1){                                            //提供总数不为无限
            $count = $this->count_resume_promote_record(null, null, $service_id, null, $date);
            if($svc['max_count'] <= $count){
                return E(ErrorMessage::$PROMOTE_USER_FULL);                     //推广服务使用人数已满
            }
        }
        $money = $svc['price'] * $days;
        $service = new BillService();
        $this->provider->trans();                                               //事务开启
        if($role_id == C('ROLE_AGENT')){
            $hservice = new HumanService();
            $human = $hservice->get_human_by_resume($resume_id);
            $title = '[简历推广服务] 购买<'.$svc['title'].'>'.$days.'周; 推广简历:'.$human['name'].'.';
        }
        else{
            $title = '[简历推广服务] 购买<'.$svc['title'].'>'.$days.'周; .';
        }
        $consume = $service->consume($user_id, '', $money, $title);
        if(is_zerror($consume)){                                                //消费
            $this->provider->rollback();                                        //事务开启
            return $consume;
        }
        $record = $this->provider->get_promote_resume_record($user_id, $resume_id, $service_id, null, $date, true);
        if(empty($record)){                                                     //添加简历推广记录
            $result = $this->provider->add_promote_resume_record ($user_id, $resume_id, $service_id, $date, date_f(null, time() + $days * 86400 * 7), $money);
        }
        else{                                                                   //延长简历推广时间
            //暂不提供延长推广
            return E(ErrorMessage::$PROMOTE_HAD);
//            $result = $this->provider->update_promote_resume_record($record['id'], array(
//                'end_time'  => date_f(null, get_time($record['end_time']) + $days * 86400),
//                'cost'      => $record['cost'] + $money
//            ));
        }
        if(!$result){
            $this->provider->rollback();                                        //事务回滚
            return E();
        }
        $this->provider->commit();                                              //事务提交
        return true;
    }

    /**
     * 获取指定用户和任务的指定服务未过期记录
     * @param  <int> $user_id 用户编号
     * @param  <int> $task_id 任务编号
     * @param  <int> $service 服务编号
     * @return <mixed>
     */
    public function get_task_promote_record($user_id, $task_id, $service){
        return $this->provider->get_promote_task_record($user_id, $task_id, $service, null, date_f(), true);
    }
    
    /**
     * 检测指定职位当前是否购买了指定推广服务
     * @param  <int> $job_id     职位编号
     * @param  <int> $service_id 服务编号
     * @return <bool>
     */
    public function job_is_promoting($job_id, $service_id){
        return $this->provider->get_promote_job_record(null, $job_id, $service_id, null, date_f(), false, 1, 1, true) > 0;
    }

    /**
     * 检测指定简历当前是否购买了指定推广服务
     * @param  <int> $resume_id  简历编号
     * @param  <int> $service_id 服务编号
     * @return <bool>
     */
    public function resume_is_promoting($resume_id, $service_id){
        return $this->provider->get_promote_resume_record(null, $resume_id, $service_id, null, date_f(), false, 1, 1, true) > 0;
    }

    /**
     * 检测指定任务当前是否购买了指定推广服务
     * @param  <int> $task_id    任务编号
     * @param  <int> $service_id 服务编号
     * @return <bool>
     */
    public function task_is_promoting($task_id, $service_id){
        return $this->provider->get_promote_task_record(null, $task_id, $service_id, null, date_f(), false, 1, 1, true) > 0;
    }

    /**
     * 购买企业账户推广服务
     * @param  <int> $user_id    用户编号
     * @param  <int> $task_id    任务编号
     * @param  <int> $service_id 服务编号
     * @param  <int> $days       购买天数
     * @return <bool> 是否成功
     */
    public function buy_promote_company($user_id, $service_id, $days){
        $svc = $this->provider->get_promote_service($service_id);
        if(empty($svc) || $svc['type'] != PROMOTE_TYPE_COMPANY){                //检测服务类型
            return E(ErrorMessage::$PROMOTE_SERVICE_ERROR);
        }
        if($svc['min_days'] > $days || $svc['max_days'] < $days){               //检测服务购买天数
            return E(ErrorMessage::$PROMOTE_SERVICE_DATE_ERROR);
        }
        $date = date_f();
        if($svc['max_count'] != -1){                                            //提供总数不为无限
            $count = $this->count_company_promote_record(null, null, $service_id, null, $date);
            if($svc['max_count'] <= $count){
                return E(ErrorMessage::$PROMOTE_USER_FULL);                     //推广服务使用人数已满
            }
        }
        
        //--------检测套餐中是否有免费推广数----------
        $pk_service = new PackageService();
        $package = $pk_service->get_package_record($user_id);
        
        $money = $svc['price'] * $days;
        $service = new BillService();
        $this->provider->trans();                                               //事务开启
        $consume = $service->consume($user_id, '', $money, '[购买账户推广服务] 服务名称:'.$svc['title'].'; 购买周数:'.$days.'.');
        if(is_zerror($consume)){                                                //消费
            $this->provider->rollback();                                        //事务开启
            return $consume;
        }
        $record = $this->provider->get_promote_company_record($user_id, $service_id, null, $date, true);
        if(empty($record)){                                                     //添加职位推广记录
            $result = $this->provider->add_promote_company_record ($user_id, $service_id, $date, date_f(null, time() + $days * 86400 * 7), $money);
        }
        else{                                                                   //延长职位推广时间
            //暂不提供延长推广
            return E(ErrorMessage::$PROMOTE_HAD);
//            $result = $this->provider->update_promote_company_record($record['id'], array(
//                'end_time'  => date_f(null, get_time($record['end_time']) + $days * 86400),
//                'cost'      => $record['cost'] + $money
//            ));
        }
        if(!$result){
            $this->provider->rollback();                                        //事务回滚
            return E();
        }
        $this->provider->commit();                                              //事务提交
        return true;
    }

    /**
     * 检测指定企业当前是否购买了指定推广服务
     * @param  <int> $user_id    企业编号
     * @param  <int> $service_id 服务编号
     * @return <bool>
     */
    public function company_is_promoting($user_id, $service_id){
        return $this->provider->get_promote_company_record($user_id, $service_id, date_f(), $end, false, 1, 1, true) > 0;
    }

    /**
     * 购买经纪人账户推广服务
     * @param  <int> $user_id    用户编号
     * @param  <int> $task_id    任务编号
     * @param  <int> $service_id 服务编号
     * @param  <int> $days       购买天数
     * @return <bool> 是否成功
     */
    public function buy_promote_agent($user_id, $service_id, $days){
        $svc = $this->provider->get_promote_service($service_id);
        if(empty($svc) || $svc['type'] != PROMOTE_TYPE_AGENT){              //检测服务类型
            return E(ErrorMessage::$PROMOTE_SERVICE_ERROR);
        }
        if($svc['min_days'] > $days || $svc['max_days'] < $days){               //检测服务购买天数
            return E(ErrorMessage::$PROMOTE_SERVICE_DATE_ERROR);
        }
        $date = date_f();
        if($svc['max_count'] != -1){                                            //提供总数不为无限
            $count = $this->count_agent_promote_record(null, null, $service_id, null, $date);
            if($svc['max_count'] <= $count){
                return E(ErrorMessage::$PROMOTE_USER_FULL);                     //推广服务使用人数已满
            }
        }
        $money = $svc['price'] * $days;
        $service = new BillService();
        $this->provider->trans();                                               //事务开启
        $consume = $service->consume($user_id, '', $money, '[购买账户推广服务] 服务名称:'.$svc['title'].'; 购买周数:'.$days.'.');
        if(is_zerror($consume)){                                                //消费
            $this->provider->rollback();                                        //事务开启
            return $consume;
        }
        $record = $this->provider->get_promote_agent_record($user_id, $service_id, null, $date, true);
        if(empty($record)){                                                     //添加职位推广记录
            $result = $this->provider->add_promote_agent_record ($user_id, $service_id, $date, date_f(null, time() + $days * 86400 * 7), $money);
        }
        else{                                                                   //延长职位推广时间
            //暂不提供延长推广
            return E(ErrorMessage::$PROMOTE_HAD);
//            $result = $this->provider->update_promote_agent_record($record['id'], array(
//                'end_time'  => date_f(null, get_time($record['end_time']) + $days * 86400),
//                'cost'      => $record['cost'] + $money
//            ));
        }
        if(!$result){
            $this->provider->rollback();                                        //事务回滚
            return E();
        }
        $this->provider->commit();                                              //事务提交
        return true;
    }

    /**
     * 检测指定经纪人当前是否购买了指定推广服务
     * @param  <int> $user_id    企业编号
     * @param  <int> $service_id 服务编号
     * @return <bool>
     */
    public function agent_is_promoting($user_id, $service_id){
        return $this->provider->get_promote_agent_record($user_id, $service_id, date_f(), $end, false, 1, 1, true) > 0;
    }

    /**
     * 获取指定企业的指定服务未过期记录
     * @param  <int> $user_id 企业编号
     * @param  <int> $service 服务编号
     * @return <mixed>
     */
    public function get_company_promote_record($user_id, $service){
        return $this->provider->get_promote_company_record($user_id, $service, null, date_f(), true);
    }

    /**
     * 获取指定经纪人的指定服务未过期记录
     * @param  <int> $user_id 经纪人编号
     * @param  <int> $service 服务编号
     * @return <mixed>
     */
    public function get_agent_promote_record($user_id, $service){
        return $this->provider->get_promote_agent_record($user_id, $service, null, date_f(), true);
    }

    /**
     * 统计指定条件经纪人推广记录数量
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $service 服务编号
     * @param  <string> $start   开始时间
     * @param  <string> $end     结束时间
     * @return <int>
     */
    public function count_agent_promote_record($user_id, $service, $start = null, $end = null){
        return $this->provider->get_promote_agent_record($user_id, $service, $start, $end, false, 1, 1, true);
    }

    /**
     * 统计指定条件企业推广记录数量
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $service 服务编号
     * @param  <string> $start   开始时间
     * @param  <string> $end     结束时间
     * @return <int>
     */
    public function count_company_promote_record($user_id, $service, $start = null, $end = null){
        return $this->provider->get_promote_company_record($user_id, $service, $start, $end, false, 1, 1, true);
    }

    /**
     * 统计指定条件职位推广记录数量
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $job_id  职位编号
     * @param  <int>    $service 服务编号
     * @param  <string> $start   开始时间
     * @param  <string> $end     结束时间
     * @return <int>
     */
    public function count_job_promote_record($user_id, $job_id, $service, $start = null, $end = null){
        return $this->provider->get_promote_job_record($user_id, $job_id, $service, $start, $end, false, 1, 1, true);
    }

    /**
     * 统计指定条件职位推广记录数量
     * @param  <int>    $user_id   用户编号
     * @param  <int>    $resume_id 简历编号
     * @param  <int>    $service   服务编号
     * @param  <string> $start     开始时间
     * @param  <string> $end       结束时间
     * @return <int>
     */
    public function count_resume_promote_record($user_id, $resume_id, $service, $start = null, $end = null){
        return $this->provider->get_promote_resume_record($user_id, $resume_id, $service, $start, $end, false, 1, 1, true);
    }

    /**
     * 统计指定条件职位推广记录数量
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $task_id 职位编号
     * @param  <int>    $service 服务编号
     * @param  <string> $start   开始时间
     * @param  <string> $end     结束时间
     * @return <int>
     */
    public function count_task_promote_record($user_id, $task_id, $service, $start = null, $end = null){
        return $this->provider->get_promote_task_record($user_id, $task_id, $service, $start, $end, false, 1, 1, true);
    }

    /**
     * 更新推广位描述信息
     * @param <type> $id
     * @param <type> $picture
     * @param <type> $text
     */
    public function update_promote_record($id, $user_id, $picture, $text){
        $record = $this->provider->get_promote_location_record($id);
        if(empty($record)){
            return E(ErrorMessage::$PROMOTE_NOT_EXISTS);
        }
        if($record['user_id'] != $user_id){
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        if($record['end_time'] < date_f()){
            return E(ErrorMessage::$PROMOTE_EXPIRED);
        }
        $data = array(
            'picture'   => $picture,
            'dtext'     => $text
        );
        if(!$this->provider->update_promote_record($id, $data)){
            return E();
        }
        return true;
    }
}
?>
