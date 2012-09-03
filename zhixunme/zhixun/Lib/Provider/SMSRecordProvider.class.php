<?php
/**
 * Description of SMSRecordProvider
 *
 * @author moi
 */
class SMSRecordProvider extends BaseProvider{
    /**
     * 添加简历要求通知记录
     * @param  <int> $job_id    职位编号
     * @param  <int> $resume_id 简历编号
     * @param  <int> $key       KEY
     * @return <bool>
     */
    public function add_invite_resume_notify($job_id, $resume_id, $key){
        $this->da->setModelName('invite_resume_notify');
        $data['job_id']    = $job_id;
        $data['resume_id'] = $resume_id;
        $data['key']       = $key;
        $data['date']      = date_f();
        $data['is_del']    = 0;
        return $this->da->add($data) != false;
    }

    /**
     * 获取邀请简历通知
     * @param <string> $key
     * @return <type> 
     */
    public function get_invite_resume_notify($key){
        $this->da->setModelName('invite_resume_notify');
        $where['key'] = $key;
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 删除邀请简历记录
     * @param <string> $key
     * @return <bool>
     */
    public function delete_invite_resume_notify($key){
        $this->da->setModelName('invite_resume_notify');
        $where['key'] = $key;
        $data['is_del'] = 1;
        return $this->da->where($where)->save($data) != false;
    }
}
?>
