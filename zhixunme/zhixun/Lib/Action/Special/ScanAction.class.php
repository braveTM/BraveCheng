<?php
/**
 * Description of ScanAction
 *
 * @author moi
 */
class ScanAction extends Action{
    /**
     * 任务扫描
     */
    public function task_scan(){
        //临时方法
        $model = M('information');
        $where['end_time'] = array('lt', date_f());
        $where['status'] = 1;
        $data['status'] = 3;
        $model->where($where)->save($data);             //设置任务过期
        echo 'sctask success:'.date_f();
    }

    /**
     * 套餐扫描
     */
    public function package_scan(){
        //临时方法
        $model = M('user');
        $where['expired'] = array('lt', time());
        $where['package'] = array('gt', 0);
        $data['package'] = 0;
        $model->where($where)->save($data);         //设置套餐过期
        $w['package'] = 0;
        $w['role_id'] = 2;
        $w['is_activate'] = 1;
        $result = $model->where($w)->save(array('is_activate' => 0));         //设置未激活
        $model = M('package_record');
        $where1['end_time'] = array('lt', date_f());
        $where1['is_del'] = 0;
        $data1['is_del'] = 1;
        $model->where($where1)->save($data1);
        echo 'package success:'.date_f();
    }

//    /**
//     * 任务置顶扫描
//     */
//    public function ttop_scan(){
//        //临时方法
//        $model = M('information');
//        $table_i = C('DB_PREFIX').'information';
//        $table_t = C('DB_PREFIX').'information_top';
//        $time = time() + 60;
//        $sql = "SELECT i.info_id
//                FROM $table_i i,$table_t t
//                WHERE t.end_time<$time AND t.task_id=i.info_id AND i.sort>1000000000";
//        $result = $model->query($sql);
//        if($result == false){
//            return;
//        }
//        foreach($result as $value){
//            $in .= $value['info_id'].',';
//        }
//        $in = rtrim($in, ',');
//        $where['info_id'] = array('in', $in);
//        $data['service'] = 0;
//        $model->where($where)->save($data);         //设置任务使用服务为空
//        $model->setDec('sort', $where, 1000000000);
//        echo ACTION_NAME.' success:'.date_f();
//    }

    /**
     * 短信回复接收
     */
    public function sms_receive(){
        require_cache(APP_PATH.'/Common/Class/SMS.class.php');
        $sms = SMSFactory::get_object();
        $result = $sms->receive();
        if(!empty($result)){
            $service = new SMSRecordService();
            foreach ($result as $key => $value) {
                if(substr($value['key'], 0, 4) == C('INRE_PREFIX') || true){
                    $record  = $service->get_IRN_record($value['key']);
                    if(!empty($record)){
                        $svc = new ResumeService();
                        $resume  = $svc->getResume($record['resume_id']);
                        if($resume['agent_id'] != 0){                   //简历在经纪人手上
                            $ret = $svc->sendResumeToJob($resume['agent_id'], C('ROLE_AGENT'), $record['job_id'], $record['resume_id']);
                        }
                        else{
                            if($resume['publisher_id'] != 0){
                               $ret = $svc->sendResumeToJob($resume['publisher_id'], C('ROLE_TALENTS'), $record['job_id'], $record['resume_id']);
                            }
                            else{
                                $hsvc = new HumanService();
                                $data = $hsvc->get_human_by_resume($rid);
                                $usvc = new UserService();
                                $user = $usvc->get_user_by_data($data_id, C('ROLE_TALENTS'));
                                $ret  = $svc->sendResumeToJob($user['user_id'], C('ROLE_TALENTS'), $record['job_id'], $record['resume_id']);
                            }
                        }
                        if(!is_zerror($ret))
                            $service->delete_IRN_record($value['key']);
                    }
                }
            }
        }
        echo 'recsms success:'.date_f();
    }

    /**
     * 更新用户在线情况
     */
    public function update_online(){
        //临时方法
        $time = time() - 480;
        $model = M('user_online');
        $where['last_visit_time'] = array('lt', $time);
        $model->execute('UPDATE zx_user SET is_online=0,last_logout_date=\''.date_f().'\' WHERE user_id IN (SELECT user_id FROM zx_user_online WHERE last_visit_time < '.$time.')');
        $model->where($where)->delete();
        echo 'online success:'.date_f();
    }

    /**
     * 更新推广
     */
    public function update_promote(){
        $date = date_f();
        $model = M('promote_agent');
        $where['end_time'] = array('lt', $date);
        $where['is_del'] = 0;
        $data['is_del'] = 1;
        $model->where($where)->save($data);
        $model = M('promote_company');
        $where['end_time'] = array('lt', $date);
        $where['is_del'] = 0;
        $data['is_del'] = 1;
        $model->where($where)->save($data);
        $model = M('promote_job');
        $where['end_time'] = array('lt', $date);
        $where['is_del'] = 0;
        $data['is_del'] = 1;
        $model->where($where)->save($data);
        $model = M('promote_record');
        $where['end_time'] = array('lt', $date);
        $where['is_del'] = 0;
        $data['is_del'] = 1;
        $model->where($where)->save($data);
        $model = M('promote_resume');
        $where['end_time'] = array('lt', $date);
        $where['is_del'] = 0;
        $data['is_del'] = 1;
        $model->where($where)->save($data);
        $model = M('promote_service');
        $where['end_time'] = array('lt', $date);
        $where['is_del'] = 0;
        $data['is_del'] = 1;
        $model->where($where)->save($data);
        $model = M('promote_task');
        $where['end_time'] = array('lt', $date);
        $where['is_del'] = 0;
        $data['is_del'] = 1;
        $model->where($where)->save($data);
        echo 'promote success:'.$date;
    }

    /**
     * 更新过期邮件激活记录
     */
    public function update_n_eactive(){
        $date = date_f(null, time() - 86400);
        $model = M('user_active');
        $where['date'] = array('lt', $date);
        $where['is_del'] = 0;
        $i = 0;
        $model1 = M('user');
        while ($i < 100){
            $ids = $model->where($where)->select();
            if(empty ($ids)){
                break;
            }
            $model->where($where)->save(array('is_del' => 1));
            foreach($ids as $id){
                $where1['user_id'] = $id['user_id'];
                $where1['email_activate'] = 0;
                $else = md5(time().rand_string(8).$id['user_id']).'@null.com';
                $model1->where($where1)->save(array('email' => $else, 'is_del' => 1));
            }
            $i++;
        }
        echo 'eactive success:'.date_f();
    }
    
    /**
     * 电话回拨异常处理
     */
    public function call_abnormal(){
        
        $model = M('call_request');
        $where['status'] = 2; 
        $callAbnormal = $model->where($where)->select();
        if(!empty($callAbnormal)){
            require_cache(APP_PATH.'/Common/Class/Call.class.php');
            $call = CallFactory::get_instance();
            $requestAbnormal = array();
            $time = time();
            $callStauts = 0;
            foreach ($callAbnormal as $key => $value) {
                if(!empty($value['call_request_num']) && ($value['start_time'] == $value['end_time'])){ //判断是否存在此通话和是否已经设置通话异常限定时间
                    $status = $call->get_result($value['call_request_num']);
                    if($status == 0 || $status == 3){ //判断此通话是否存在或者已结束
                        $requestAbnormal[$value['call_request_num']] = $status;
                    }
                }elseif(($value['start_time'] != $value['end_time']) && ($value['end_time'] <= $time)){//处理异常--发送邮件
                    $status = $call->get_result($value['call_request_num']);
                    if($status == 0 || $status == 3){ //判断此通话是否存在或者已结束
                       $callStauts = 1;
                    }
                    $call_request_num .= $value['call_request_num']."--";
                }                
            }
            if($callStauts == 1){
                    //发送邮件
                    $email = "424080998@qq.com";
                    $title = "职讯网电话回拨";
                    $content = "电话回拨有异常处理，请检查";
                    normal_email_send($email,$title,$content);
            }
            if(!empty($requestAbnormal)){
                //通话已结束或者通话不存在的设置状态延后5分钟通知管理员
                foreach ($requestAbnormal as $key => $value) {
                    $where['call_request_num'] = $key;
                    $model->where($where)->save(array('end_time' => $time+300));
                }
            }
        }
    }
    /**
     * timer 
     */
    public function timer(){
        $this->package_scan();
        $this->sms_receive();
        $this->update_online();
        $this->update_promote();
        $this->update_n_eactive();
        $this->call_abnormal();
        //1、定时将符合提醒条件的资源保存到提醒记录表中,默认为符合条件的当天8点
	NoticeCrmService::save_notice();
	//2、定时计算提醒记录表中的提醒时间与当前时间相符合的条件并发送提醒内容		
	NoticeCrmService::doing_notice();
    }
}
?>
