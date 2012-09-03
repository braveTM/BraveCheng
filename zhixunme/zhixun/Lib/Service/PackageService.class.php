<?php
/**
 * Description of PackageService
 *
 * @author moi
 */
class PackageService {
    //----------------private-------------------
    private $provider;

    //----------------public--------------------
    public function  __construct() {
        $this->provider = new PackageProvider();
    }
    
    /**
     * 购买套餐
     * @param  <int> $user_id    用户编号
     * @param  <int> $role_id    角色编号
     * @param  <int> $package_id 套餐编号
     * @param  <bool> $can_free  是否能购买免费套餐
     * @return <bool>
     */
    public function buy_package($user_id, $role_id, $package_id, $can_free = false){
        $package = $this->provider->get_package_info($package_id);
        if(empty($package) || $package['role_id'] != $role_id){                 //套餐不存在或者不适用于当前角色
            return E(ErrorMessage::$PACKAGE_NOT_EXISTS);
        }
        if($can_free == false && $package['free'] == 1){
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        $this->provider->trans();
        if($package['free'] != 1){
            $bill = new BillService();
            $consume = $bill->consume($user_id, '', $package['price'], '购买套餐:'.$package['title'].',有效期为'.$package['deadline'].'个月');
            if(is_zerror($consume)){
                $this->provider->rollback();
                return $consume;
            }
        }
        $date = date_f();
        $end_time = strtotime('+'.$package['deadline'].' month');
        $end =  date_f(null, $end_time);
        $record = $this->provider->get_package_record($user_id);                //获取用户当前套餐
        if($this->provider->delete_user_old_record($user_id) === false){        //删除用户原有套餐记录
            $this->provider->rollback();
            return E();
        }
        //增加用户新套餐
        $nrecord = $this->provider->add_package_record($user_id, $package_id, $package['price'], $date, $end);
        if(!$nrecord){
            $this->provider->rollback();
            return E();
        }
        $modules = $this->provider->get_package_module_info($package_id);       //获取新套餐模块记录
        foreach($modules as $module){
//            if(!empty($record)){                                                //累加当前套餐剩余项
//                $pmr = $this->provider->get_package_record_free($record['id'], $module['module_id']);
//                if($pmr['free_count'] > 0){
//                    if($module['free_count'] >= 0)
//                        $module['free_count'] += $pmr['free_count'];
//                }
//            }
            if(!$this->provider->add_package_record_free($nrecord, $module['module_id'], $module['free_count'], $module['price'])){
                $this->provider->rollback();
                return E();
            }
        }
        ExperienceCrmService::add_experience_buy_package($user_id, $package['price']);
        $user = new UserProvider();
        if($package['free'] != 1){
            if($role_id == C('ROLE_ENTERPRISE')){                                   //企业购买套餐激活账户
                $info = $user->get_user_by_id($user_id, 'ARRAY');
                if($info['is_activate'] == 0){                                      //账户未激活
                    $array['is_activate'] = 1;
                }
            }
        }
        $array['expired'] = $end_time;
        $array['package'] = $package_id;
        if(!$user->update_user($user_id, $array)){
            $this->provider->rollback();
            return E();
        }
        $this->provider->commit();
        return true;
    }

    /**
     * 套餐续费
     * @param  <int> $user_id 用户编号
     * @return <bool>
     */
    public function renewals_package($user_id){
        $record = $this->provider->get_package_record($user_id);
        if(empty($record)){
            return E();                         //指定使用记录不存在，无法进行续费
        }
        $package = $this->provider->get_package_info($record['package_id']);
        if($package['free'] == 1){
            return E('免费套餐无法续费');
        }
        $this->provider->trans();
        $bill = new BillService();
        $consume = $bill->consume($user_id, '', $package['price'], '套餐<'.$package['title'].'>续费'.$package['deadline'].'个月');
        if(is_zerror($consume)){
            $this->provider->rollback();
            return $consume;
        }
        $end_time = strtotime('+'.$package['deadline'].' month', strtotime($record['end_time']));
        $end = date_f(null, $end_time);
        if(!$this->provider->update_package_record($record['id'], array(
                'cost'      => $record['cost'] + $package['price'],
                'end_time'  => $end
            ))){
            $this->provider->rollback();
            return E();
        }
        $modules = $this->provider->get_package_module_info($record['package_id']);
        foreach($modules as $module){
            $mrecord = $this->provider->get_package_record_free($record['id'], $module['module_id']);
            if(empty($mrecord)){
                if(!$this->provider->add_package_record_free($record, $module['module_id'], $module['free_count'], $module['price'])){
                    $this->provider->rollback();
                    return E();
                }
            }
            else{
                if($module['free_count'] > 0){
                    if($mrecord['initial_free_count'] >= 0){
                        $mrecord['initial_free_count'] = $mrecord['initial_free_count'] + $module['free_count'];
                        $mrecord['free_count'] = $mrecord['free_count'] + $module['free_count'];
                    }
                }
                if(!$this->provider->update_package_record_free($mrecord['id'], array(
                    'initial_free_count'    => $mrecord['initial_free_count'],
                    'free_count'            => $mrecord['free_count']
                ))){
                    $this->provider->rollback();
                    return E();
                }
            }
        }
        $user = new UserProvider();
        if(!$user->update_user($user_id, array('expired' => $end_time))){
            $this->provider->rollback();
            return E();
        }
        ExperienceCrmService::add_experience_buy_package($user_id, $package['price']);
        $this->provider->commit();
        return true;
    }

    /**
     * 积分兑换套餐
     * @param int $user_id 用户编号
     * @param int $role_id 角色编号
     * @param int $package_id 套餐编号
     * @return boolean 
     */
    public function exp_exchange_package($user_id, $role_id, $package_id){
        $package = $this->provider->get_package_info($package_id);
        if(empty($package) || $package['role_id'] != $role_id){                 //套餐不存在或者不适用于当前角色
            return E(ErrorMessage::$PACKAGE_NOT_EXISTS);
        }
        if($can_free == false && $package['free'] == 1){
            return E(ErrorMessage::$PERMISSION_LESS);
        }
        $user = new UserProvider();
        $info = $user->get_user_info($user_id);
        if($package['free'] != 1){
           if($package['price'] > $info['total_experience']){
               return E('对不起，您的积分不足！');
           }
        }
        else{
            return E();
        }
        $this->provider->trans();
        $date = date_f();
        $end_time = strtotime('+'.$package['deadline'].' month');
        $end =  date_f(null, $end_time);
        $record = $this->provider->get_package_record($user_id);                //获取用户当前套餐
        if($this->provider->delete_user_old_record($user_id) === false){        //删除用户原有套餐记录
            $this->provider->rollback();
            return E();
        }
        //增加用户新套餐
        $nrecord = $this->provider->add_package_record($user_id, $package_id, $package['price'], $date, $end);
        if(!$nrecord){
            $this->provider->rollback();
            return E();
        }
        $modules = $this->provider->get_package_module_info($package_id);       //获取新套餐模块记录
        foreach($modules as $module){
//            if(!empty($record)){                                                //累加当前套餐剩余项
//                $pmr = $this->provider->get_package_record_free($record['id'], $module['module_id']);
//                if($pmr['free_count'] > 0){
//                    if($module['free_count'] >= 0)
//                        $module['free_count'] += $pmr['free_count'];
//                }
//            }
            if(!$this->provider->add_package_record_free($nrecord, $module['module_id'], $module['free_count'], $module['price'])){
                $this->provider->rollback();
                return E();
            }
        }
        $array['total_experience'] = $info['total_experience'] - $package['price'];
        $array['expired'] = $end_time;
        $array['package'] = $package_id;
        if(!$user->update_user($user_id, $array)){
            $this->provider->rollback();
            return E();
        }
        $this->provider->commit();
        return true;
    }
    
    /**
     * 积分续费套餐
     * @param int $user_id 用户编号
     * @return boolean 
     */
    public function exp_renewals_package($user_id){
        $record = $this->provider->get_package_record($user_id);
        if(empty($record)){
            return E();                         //指定使用记录不存在，无法进行续费
        }
        $package = $this->provider->get_package_info($record['package_id']);
        if($package['free'] == 1){
            return E('免费套餐无法续费');
        }
        $user = new UserProvider();
        $info = $user->get_user_info($user_id);
        if($package['price'] > $info['total_experience']){
            return E('对不起，您的积分不足！');
        }
        $this->provider->trans();
        $end_time = strtotime('+'.$package['deadline'].' month', strtotime($record['end_time']));
        $end = date_f(null, $end_time);
        if(!$this->provider->update_package_record($record['id'], array(
                'cost'      => $record['cost'] + $package['price'],
                'end_time'  => $end
            ))){
            $this->provider->rollback();
            return E();
        }
        $modules = $this->provider->get_package_module_info($record['package_id']);
        foreach($modules as $module){
            $mrecord = $this->provider->get_package_record_free($record['id'], $module['module_id']);
            if(empty($mrecord)){
                if(!$this->provider->add_package_record_free($record, $module['module_id'], $module['free_count'], $module['price'])){
                    $this->provider->rollback();
                    return E();
                }
            }
            else{
                if($module['free_count'] > 0){
                    if($mrecord['initial_free_count'] >= 0){
                        $mrecord['initial_free_count'] = $mrecord['initial_free_count'] + $module['free_count'];
                        $mrecord['free_count'] = $mrecord['free_count'] + $module['free_count'];
                    }
                }
                if(!$this->provider->update_package_record_free($mrecord['id'], array(
                    'initial_free_count'    => $mrecord['initial_free_count'],
                    'free_count'            => $mrecord['free_count']
                ))){
                    $this->provider->rollback();
                    return E();
                }
            }
        }
        if(!$user->update_user($user_id, array('total_experience' => $info['total_experience'] - $package['price'], 'expired' => $end_time))){
            $this->provider->rollback();
            return E();
        }
        ExperienceCrmService::add_experience_buy_package($user_id, $package['price']);
        $this->provider->commit();
        return true;
    }
    
    /**
     * 获取指定套餐的信息
     * @param  <int> $id 套餐编号
     * @return <mixed>
     */
    public function get_package($id) {
        return $this->provider->get_package_info($id);
    }
    
    /**
     * 获取指定角色能够购买的套餐列表
     * @param  <int> $role_id 角色编号
     * @return <mixed>
     */
    public function get_package_list($role_id){
        return $this->provider->get_package_list($role_id, 1, 20);
    }

    /**
     * 获取指定套餐的模块信息
     * @param  <int> $id 套餐编号
     * @return <mixed>
     */
    public function get_package_modules($id){
        return $this->provider->get_package_module_info($id);
    }

    /**
     * 获取指定用户当前的套餐记录
     * @param  <int> $id 用户编号
     * @return <mixed>
     */
    public function get_package_record($user_id) {
        return $this->provider->get_package_record($user_id);
    }

    /**
     * 获取指定套餐的模块信息
     * @param  <int> $id 套餐编号
     * @return <mixed>
     */
    public function get_package_record_free_list($pu_id) {
        return $this->provider->get_package_record_free_list($pu_id);
    }

    /**
     * 开始付费操作
     * @param  <int>    $user_id   用户编号
     * @param  <int>    $module_id 模块编号
     * @param  <string> $sup       额外参数
     * @return <bool>
     */
    public function start_paying_operation($user_id, $module_id, $sup){
        if(empty($module_id))
            return true;
        $this->provider->trans();
        $usvc = new UserService();
        $user = $usvc->get_account($user_id, 'ARRAY');                          //获取用户信息
        if(empty($user)){
            return E(ErrorMessage::$USER_NOT_EXISTS);
        }
        $module = $this->provider->get_package_module($module_id);
        if(empty($module)){
            return true;
        }
        if($user['package'] == 0){                                              //用户没有套餐
            $price = $module['price'];                                          //获取操作费用
        }
        else{                                                                   //用户有套餐
            $record = $this->provider->get_package_record($user_id);
            //获取套餐功能模块免费信息
            $pm = $this->provider->get_package_record_free($record['id'], $module_id);
            if($pm['free_count'] < 0){
                return true;                                                    //用户使用条数无限制，不做操作
            }
            if(!empty($pm) && $pm['free_count'] > 0){                           //套餐还剩有相应模块的免费条数
                if(!$this->provider->use_free_count($pm['id'], 1)){             //使用免费条数
                    $this->provider->rollback();
                    return E();
                }
                //添加免费条数使用记录
                if(!$this->provider->add_use_free_record($user_id, $pm['id'], $module['title'].":".$sup, $module_id, 1)){
                    $this->provider->rollback();
                    return E();
                }
                $price = 0;
            }
            else if(!empty($pm) && $pm['free_count'] == 0){                     //有套餐，无免费条数
                $price = $pm['price'];
            }
            else{                                                               //套餐无此项优惠政策
                $price = $module['price'];
            }
        }
        //不允许超出模式
        if($price != 0){
            return E('您的套餐条数不足，请购买相应套餐再继续此操作');
        }
        //超出扣费模式
//        $bsvc = new BillService();
//        if($price > 0)                                                          //支出
//            $consume = $bsvc->consume($user_id, '', $price, $module['title'].":".$sup);
//        else if($price < 0){                                                    //收入
//            $price = -$price;
//            $consume = $bsvc->income($user_id, $price, $module['title'].":".$sup);
//        }
//        else{
//            return true;
//        }
//        if(is_zerror($consume)){
//            return $consume;
//        }
        return true;
    }

    /**
     * 结束付费操作
     * @return <bool>
     */
    public function end_paying_operation(){
        $this->provider->commit();
        return true;
    }

    /**
     * 获取用户指定付费操作信息
     * @param  <int> $user_id   用户编号
     * @param  <int> $module_id 模块编号
     * @return <array>
     */
    public function get_user_operate_pay_info($user_id, $module_id, $uid, $package){
        if($module_id == 16 && !empty($uid)){//查看简历联系方式
            $service = new ResumeService();
            $exists = $service->exists_send_resume_with_resume($uid, $user_id);
            if($exists){
                $module_id = 18;                                        //查看投递来的简历联系方式
            }
            else{
                $exists = $service->exists_delegate_resume_with_resume($uid, $user_id);
                if($exists){
                    $module_id = 19;                                        //查看委托来的简历联系方式
                }
            }
        }
        else if($module_id == 17 && !empty($uid)){  //查看职位联系方式
            $service = new JobService();
            $exists = $service->exists_delegate_job($uid, $user_id);
            if($exists){
                $module_id = 20;                                        //查看委托来的职位系方式
            }
        }
        $module = $this->provider->get_package_module($module_id);
        if(empty($module) || $module['price'] <= 0){                            //模块不存在或者不为收费模块
            return null;
        }
        $package = $this->provider->get_package_record($user_id);
        if(!empty($package)){
            $record = $this->provider->get_package_record_free($package['id'], $module_id);
            if(!empty($record)){
                if($record['free_count'] > 0)
                    return array('price' => $record['price'], 'free' => $record['free_count']);
            }
        }
        return null;                //不提供扣费提示
        //return array('price' => $module['price'], 'free' => 0);               //免费条数不足提示扣费
    }

    /**
     * 购买免费套餐
     * @param int $user_id 用户编号
     * @param int $role_id 角色编号
     * @return bool 
     */
    public function buy_free_package($user_id, $role_id){
        $package = $this->provider->get_free_package($role_id);
        if(empty($package)){
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        return $this->buy_package($user_id, $role_id, $package['id'], true);
    }
    
    /**
     * 获取免费套餐信息
     * @param int $role_id 角色编号
     * @return array 
     */
    public function get_free_package($role_id){
        return $this->provider->get_free_package($role_id);
    }
    
    /**
     * 单项续费
     * @param int $user_id 用户编号
     * @param int $module_id 续费模块
     * @param int $var 变量
     * @return boolean 
     */
    public function renewals_single($user_id, $module_id, $var){
        $count = $this->get_renewals_count($module_id, $var);
        if(is_zerror($count)){
            return $count;
        }
        $record = $this->provider->get_package_record($user_id);                //获取用户当前套餐
        if(empty($record)){                                                     //套餐不存在，无法单项续费
            return E('操作失败，你当前还没有套餐');
        }
        $rm = $this->provider->get_package_record_free($record['id'], $module_id);
        if(empty($rm)){
            return E('操作失败，当前套餐没有这项业务');
        }
        if($rm['initial_free_count'] < 0){                                      //负数表示数量无限制
            return E('您目前具有该功能的无限操作数量，无需续费');
        }
        $this->provider->trans();
        $result = $this->provider->update_package_record_free($rm['id'], array(
            'initial_free_count' => $rm['initial_free_count'] + $count[1],
            'free_count' => $rm['free_count'] + $count[1]));
        if(!$result){
            $this->provider->rollback();
            return E();
        }
        $module = $this->provider->get_package_module($module_id);
        $service = new BillService();
        $result = $service->consume($user_id, '', $count[0], '续费'.$module['title'].'数'.$count[1].'条');
        if(is_zerror($result)){
            $this->provider->rollback();
            return $result;
        }
        $this->provider->commit();
        return true;
    }
    
    /**
     * 获取续费结果字符串
     * @param int $module_id 模块编号
     * @param int $var 变量
     * @return string 
     */
    public function get_renewals_result($module_id, $var){
        $result = $this->get_renewals_count($module_id, $var);
        if(is_zerror($result))
            return $result->get_message();
        if($module_id == 8)
            $str = '可增加拨打分钟数'.$result[1].'分钟，花费金额'.$result[0];
        else
            $str = '可增加免费条数'.$result[1].'条，花费金额'.$result[0];
        return $str;
    }
    
    /**
     * 获取续费结果
     * @param int $module_id 模块编号
     * @param int $var 变量
     * @return array [0]花费金额 [1]续费数量 
     */
    public function get_renewals_count($module_id, $var){
        $module = $this->provider->get_package_module($module_id);
        $error = '续费条数少于最小限制';
        switch ($module_id){
            case 1 :                                        //发布职位
                if($var < 10) 
                    return E($error);
                $result[0] = $var * $module['price'];
                $result[1] = $var;
                break;
            case 2 :                                        //邀请简历
                if($var < 10) 
                    return E($error);
                $result[0] = $var * $module['price'];
                $result[1] = $var;
                break;
            case 5 :                                        //查看人才联系方式
                if($var < 10) 
                    return E($error);
                $result[0] = $var * $module['price'];
                $result[1] = $var;
                break;
            case 6 :                                        //查看企业联系方式
                if($var < 10) 
                    return E($error);
                $result[0] = $var * $module['price'];
                $result[1] = $var;
                break;
            case 7 :                                        //查看经纪人联系方式
                if($var < 10) 
                    return E($error);
                $result[0] = $var * $module['price'];
                $result[1] = $var;
                break;
            case 8 :                                        //电话拨打分钟
                $list = $this->provider->get_call_min_list();
                foreach($list as $item){
                    if($var == $item['price']){
                        $result[1] = $item['min'];
                        break;
                    }
                }
                if(empty($result)){
                    return E('参数错误');
                }
                $result[0] = $var;
                break;
            default : $result[0] = 0; $result[1] = 0; break;
        }
        return $result;
    }

    /**
     * 获取模块续费提示
     * @param int $module_id 模块编号
     * @return array [0]剩余数 [1]最低续费提示 
     */
    public function get_renewals_tips($user_id, $module_id){
        $surplus = $this->get_surplus_count($user_id, $module_id);
        if($surplus < 0){
            $surplus = '无限';
        }
        switch ($module_id){
            case 1 :                                        //发布职位
                $tips[0] = '您当前剩余免费条数为<em class="red"> '.$surplus.' </em>条';
                //$tips[1] = '最低续费条数<em class="red"> 10 </em>条';
                break;
            case 2 :                                        //邀请简历
                $tips[0] = '您当前剩余免费条数为<em class="red"> '.$surplus.' </em>条';
                //$tips[1] = '最低续费条数<em class="red"> 10 </em>条';
                break;
            case 5 :                                        //查看人才联系方式
                $tips[0] = '您当前剩余免费条数为<em class="red"> '.$surplus.' </em>条';
                //$tips[1] = '最低续费条数<em class="red"> 10 </em>条';
                break;
            case 6 :                                        //查看企业联系方式
                $tips[0] = '您当前剩余免费条数为<em class="red"> '.$surplus.' </em>条';
                //$tips[1] = '最低续费条数<em class="red"> 10 </em>条';
                break;
            case 7 :                                        //查看经纪人联系方式
                $tips[0] = '您当前剩余免费条数为<em class="red"> '.$surplus.' </em>条';
                //$tips[1] = '最低续费条数<em class="red"> 10 </em>条';
                break;
            case 8 :                                        //电话拨打分钟
                $tips[0] = '您当前剩余分钟数为<em class="red"> '.$surplus.' </em>分钟';
                //$tips[1] = '最低续费金额<em class="red"> 10 </em>元';
                break;
            default : $tips[0] = ''; $tips[1] = ''; break;
        }
        return $tips;
    }

    /**
     * 获取用户指定套餐模块剩余免费条数
     * @param int $user_id 用户编号
     * @param int $module_id 模块编号
     * @return int
     */
    public function get_surplus_count($user_id, $module_id){
        $package = $this->provider->get_package_record($user_id);
        $record = $this->provider->get_package_record_free($package['id'], $module_id);
        return intval($record['free_count']);
    }
    
    /**
     * 获取用户剩余分钟数
     * @param int $user_id 用户编号
     * @return int 
     */
    public function get_min_num($user_id){
        return $this->get_surplus_count($user_id, 8);
    }
    
    /**
     * 使用拨打电话的分钟数（此方法为系统异步调用，故存在较强容错能力）
     * @param int $user_id 用户编号
     * @param int $num 分钟数
     * @return bool
     */
    public function use_min($user_id, $num){
        $record = $this->provider->get_package_record($user_id);
        //获取套餐功能模块信息
        $pm = $this->provider->get_package_record_free($record['id'], 8);
        if($pm['free_count'] < $num){                                           //若剩余数不足，则将使用数设置为剩余数，避免出现负数
            $num = $pm['free_count'];
        }
        if(!$this->provider->use_free_count($pm['id'], $num)){                  //使用分钟数
            return E();
        }
        return true;
    }
    
    /**
     * 获取通话分钟数信息
     * @return array
     */
    public function get_call_min_list(){
        return $this->provider->get_call_min_list();
    }
}
?>
