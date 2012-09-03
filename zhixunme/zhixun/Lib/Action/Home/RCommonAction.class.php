<?php
header('content-type:text/html;charset=utf-8');
/**
 * Module:023
 */
class RCommonAction extends BaseAction{
    /**
     * 获取查看过的简历00110 
     */
    public function get_read_resume(){
        if(!$this->is_legal_request())
            return;
        $_POST['page'] = 1;
        $_POST['size'] = 6;
        $user_id = AccountInfo::get_user_id();
        $service = new ResumeService();
        $data = $service->getReadResume($user_id, $_POST['page'], $_POST['size']);        
        $certificateService=new CertificateService();
        $contactsService = new ContactsService();
        foreach($data as $key => $value){
            $data[$key]['cert']=$certificateService->getRegisterCertificateListByHuman($value['human_id']);
            $data[$key]['follow'] = $contactsService->exists_user_follow($user_id, $value['user_id']);
        }
        $data = FactoryVMap::list_to_models($data, 'home_resume_read');
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = $service->getReadResume(AccountInfo::get_user_id(), 1, 1, true);
            echo jsonp_encode(true, $data, $count);
        }
    }

    /**
     * 获取职位大类列表01111 
     */
    public function get_p_jobs(){
        if(!$this->is_legal_request())
            return;
        $service = new JobService();
        $data = $service->get_job_positions(0);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }

    /**
     * 获取职位小类列表01111 
     */
    public function get_c_jobs(){
        if(!$this->is_legal_request())
            return;
        if($_POST['pid'] > 0){
            $service = new JobService();
            $data = $service->get_job_positions($_POST['pid']);
        }
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }
}

?>
