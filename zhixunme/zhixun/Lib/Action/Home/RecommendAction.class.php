<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecommendAction
 *权限（匿名，人才，企业，经纪人，劳务分包商）
 * @author JZG
 */
class RecommendAction extends BaseAction{
    //put your code here
    /**
     * 推荐职位（人才，经纪人）01010
     */
    public function get_job(){
        $acceptor_id=AccountInfo::get_user_id();
        $page=$_POST['page'];
        $size=$_POST['size'];
        $job_category=$_POST['job_category'];
        $register_case=$_POST['register_case'];
        $publisher_role=$_POST['publisher_role'];
        $job_province_code=$_POST['job_province_code'];
        $register_certificate_id=$_POST['register_certificate_id'];
        $promote_service=1;
        $result=home_recommend_page::getRecommendJob($acceptor_id, $promote_service,$page, $size, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id);
        if (empty($result)){
            echo jsonp_encode(false);
        }else{
            echo jsonp_encode(true, $result,home_recommend_page::getRecommendJobCount($acceptor_id, $promote_service,$job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id));
        }
    }

    /**
     * 推荐简历（企业，经纪人）00110
     */
    public function get_resume(){
        if (!$this->is_legal_request())
                return;
        $acceptor_id=AccountInfo::get_user_id();
        $page=$_POST['page'];
        $size=$_POST['size'];
        $job_category=$_POST['job_category'];
        $register_case=$_POST['register_case'];
        $publisher_role=$_POST['publisher_role'];
        $register_province_ids=$_POST['register_province_ids'];
        $register_certificate_id=$_POST['register_certificate_id'];
        $promote_service=3;
        $result=home_recommend_page::getInterestedHuman($acceptor_id,$promote_service,$page, $size, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id);
        if (empty($result)){
            echo jsonp_encode(false);
        }else{
            echo jsonp_encode(true, $result,home_recommend_page::getInterestedHumanCount($acceptor_id, $promote_service,$job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id));
        }
    }

    /**
     * 首页推荐人才换一换（企业，经纪人）00110
     */
    public function get_human(){
        if (!$this->is_legal_request())
            return;
        $data = home_recommend_page::get_recommend_human_rand(AccountInfo::get_user_id(), 8);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }

    /**
     * 首页推荐经纪人换一换（企业，人才）01100
     */
    public function get_agent_change(){
        if (!$this->is_legal_request())
            return;
        $data = home_recommend_page::get_recommend_agent_rand(AccountInfo::get_user_id(), 8);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }

    /**
     * 推荐企业（人才，经纪人）01010
     */
    public function get_company(){
        if (!$this->is_legal_request())
            return;
        $acceptor_id = AccountInfo::get_user_id();
        $page = $_POST['page'];
        $size = $_POST['size'];
        $company_province_code = $_POST['company_province_code'];
        $company_city_code = $_POST['company_city_code'];
        $promote_service=7;
        $result = home_recommend_page::getInterestedCompany($acceptor_id,$promote_service, $page, $size, $company_province_code, $company_city_code);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, home_recommend_page::getInterestedCompanyCount($acceptor_id,$promote_service,$company_province_code, $company_city_code));
        }
    }

    /**
     * 推荐经纪人（人才，企业）01100
     */
    public function get_agent(){
         if (!$this->is_legal_request())
            return;
        $acceptor_id=AccountInfo::get_user_id();
        $promote_service=10;
        $service_category_id=$_POST['service_category_id'];
        $type=$_POST['type'];
        $addr_province_code = $_POST['addr_province_code'];
        $addr_city_code = $_POST['addr_city_code'];
        $page = $_POST['page'];
        $size = $_POST['size'];
        $result= home_recommend_page::getRecommendAgent($acceptor_id, $promote_service, $service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result,home_recommend_page::getRecommendAgentCount($acceptor_id, $promote_service, $service_category_id, $type, $addr_province_code, $addr_city_code));
        }
    }
    
    /**
     *弹出推荐经纪人01100 
     */
//    public function get_popup_recommend_agent(){
////        if (!$this->is_legal_request())
////            return;
//        $acceptor_id=  AccountInfo::get_user_id();
//        $promote_service=10;
//        $result=  home_recommend_page::getPopupRecommendAgent($acceptor_id, $promote_service);
//        if (empty($result)){
//            echo jsonp_encode(false);
//        }else{
//            echo jsonp_encode(true,$result);
//        }
//    }
}
?>
