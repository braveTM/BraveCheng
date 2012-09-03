<?php
/**
 * Description of SMSRecordService
 *
 * @author moi
 */
class SMSRecordService {
    /**
     * 添加简历要求通知记录
     * @param  <int> $job_id    职位编号
     * @param  <int> $resume_id 简历编号
     * @param  <int> $key       KEY
     * @return <bool>
     */
    public function inviteResumeNotify($job_id, $resume_id, $key){
        $provider = new SMSRecordProvider();
        if(!$provider->add_invite_resume_notify($job_id, $resume_id, $key)){
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        return true;
    }

    /**
     * 获取邀请简历通知
     * @param <type> $key
     * @return <type> 
     */
    public function get_IRN_record($key){
        $provider = new SMSRecordProvider();
        return $provider->get_invite_resume_notify($key);
    }

    /**
     * 删除邀请简历记录
     * @param <string> $key
     * @return <bool>
     */
    public function delete_IRN_record($key){
        $provider = new SMSRecordProvider();
        if(!$provider->delete_invite_resume_notify($key))
            return E(ErrorMessage::$OPERATION_FAILED);
        return true;
    }
}
?>
