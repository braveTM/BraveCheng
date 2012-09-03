<?php
/**
 * Description of home_index_index
 * 首页模块数据提供
 * @author moi
 */
class home_index_index_page {
    /**
     * 首页顶部幻灯片
     * @return <mixed>
     */
    public static function top_slides(){
        $service = new SlideService();
        $data    = FactoryVMap::list_to_models($service->get_slides(C('INDEX_TOP_LID')), 'home_index_slide');
        return $data;
    }
    
    /**
     * 获取注册页面链接地址
     */
    public static function get_urls(){
        $array['turl'] = C('WEB_ROOT').'/register/'.C('ROLE_TALENTS');
        $array['eurl'] = C('WEB_ROOT').'/register/'.C('ROLE_ENTERPRISE');
        $array['aurl'] = C('WEB_ROOT').'/register/'.C('ROLE_AGENT');
        $array['surl'] = C('WEB_ROOT').'/register/'.C('ROLE_SUBCONTRACTOR');
        return FactoryVMap::array_to_model($array, 'home_index_rurl');
    }
    
    /**
     * 获取推荐人才
     * @param int $count 数量
     * @return array
     */
    public static function get_recommend_human($count){
        $userService = new UserService();
        $users = $userService->get_rand_user_human($count);
        $resumeService = new ResumeService();
        $certificateService = new CertificateService();
        foreach($users as $item){
            if($item['job_category'] == 1){
                $job_intent = $resumeService->getJobIntent($item['job_intent_id']);
                $salary = $job_intent['job_salary'];
            }
            else if($item['job_category'] == 2){
                $hc_intent = $resumeService->getHCintentByHCID($item['hang_card_intent_id']);
                $salary = $hc_intent['job_salary'];
            }
            else{
                $salary = 0;
            }
            $certs = $certificateService->getRegisterCertificateListByHuman($item['data_id']);
            if(empty($certs[0])){
                $certs = $certificateService->getGradeCertificateListByHuman($item['data_id']);
            }
            $data['id'] = $item['user_id'];
            $data['name'] = $item['name'];
            $data['cert'] = $certs[0];
            $data['salary'] = $salary;
            $list[] = $data;
        }
        return FactoryVMap::list_to_models($list, 'home_index_rhuman');
        //上面为临时功能，下面为正式功能
//        $cache_key = __METHOD__.'_'.$count;                 //组装缓存键值
//        $cache_value = DataCache::get($cache_key);          //获取缓存数据
//        if(!empty($cache_value)){                           //存在缓存直接返回缓存数据
//            return $cache_value;
//        }
//        $promoteService = new PromoteService();
//        $userService = new UserService();
//        $humanService = new HumanService();
//        $certificateService = new CertificateService();
//        $resumeService = new ResumeService();
//        $location = $promoteService->get_promote_list(1, $count, null, C('ROLE_TALENTS'), C('INDEX_RHUMAN'));
//        foreach($location as $item){
//            $record = $promoteService->get_current_promote_record($item['id']);
//            if(!empty($record)){
//                $user = $userService->get_user($record['user_id']);
//                $human = $humanService->get_human($user['data_id']);
//                $resume = $resumeService->get_resume($human['resume_id']);
//                if($resume['job_category'] == 1){
//                    $job_intent = $resumeService->getJobIntent($resume['job_intent_id']);
//                    $salary = $job_intent['job_salary'];
//                }
//                else if($resume['job_category'] == 2){
//                    $hc_intent = $resumeService->getHCintentByHCID($resume['hang_card_intent_id']);
//                    $salary = $hc_intent['job_salary'];
//                }
//                else{
//                    continue;
//                }
//                $certs = $certificateService->getRegisterCertificateListByHuman($user['data_id']);
//                $data['id'] = $user['user_id'];
//                $data['name'] = $user['name'];
//                $data['cert'] = $certs[0];
//                $data['salary'] = $salary;
//                $list[] = $data;
//            }
//        }
//        $cache_value = FactoryVMap::list_to_models($list, 'home_index_rhuman');
//        DataCache::set($cache_key, $cache_value, CC('CACHE_TIME_LITTLE'));      //将数据进行缓存，缓存时长10分钟
//        return $cache_value;
    }
    
    /**
     * 获取推荐企业
     * @param int $count 数量
     * @return array
     */
    public static function get_recommend_company($count,$page=1){
        $promoteService = new PromoteService();
        $userService = new UserService();
        $jobService = new JobService();
        $companyService = new CompanyService();
        $location = $promoteService->get_promote_list($page, $count, null, C('ROLE_ENTERPRESE'), C('INDEX_RCOMPANY'));
        foreach($location as $item){
            $record = $promoteService->get_current_promote_record($item['id']);
            if(!empty($record)){
                $user = $userService->get_user($record['user_id']);
                $company = $companyService->get_company($user['data_id']);
                $jobs = $jobService->get_pub_jobs($user['user_id'], null, 2, 1, 3); //获取该企业正在运作的招聘信息，最多仅显示3条
                $data['id'] = $user['user_id'];
                $data['name'] = $company['company_name'];
                $data['logo'] = $record['picture'];
                $data['jobs'] = $jobs;
                $list[] = $data;
            }
        }
        return FactoryVMap::list_to_models($list, 'home_index_rcompany');
    }
    
    /**
     * 获取推荐经纪人
     * @param int $count 数量
     * @return array
     */
    public static function get_recommend_agent($count){
        $userService = new UserService();
        $users = $userService->get_rand_user_agent($count);
        foreach($users as $user){
            $data['id'] = $user['user_id'];
            $data['name'] = $user['name'];
            $data['photo'] = $user['photo'];
            $list[] = $data;
        }
        return FactoryVMap::list_to_models($list, 'home_index_ragent');
        //上面为临时功能，下面为正式功能
//        $promoteService = new PromoteService();
//        $userService = new UserService();
//        $location = $promoteService->get_promote_list(1, $count, null, C('ROLE_AGENT'), C('INDEX_RAGENT'));
//        foreach($location as $item){
//            $record = $promoteService->get_current_promote_record($item['id']);
//            if(!empty($record)){
//                $user = $userService->get_user($record['user_id']);
//                $data['id'] = $user['user_id'];
//                $data['name'] = $user['name'];
//                $data['photo'] = $user['photo'];
//                $list[] = $data;
//            }
//        }
//        return FactoryVMap::list_to_models($list, 'home_index_ragent');
    }

    /**
     * 获取人才列表
     * @param  <int> $page 第几页
     * @param  <int> $size 每页几条
     * @return <mixed>
     */
    public static function get_talents($page, $size){
        if($page > 10)                  //只允许获取前十页内容
            return null;
        if($size > 6)                  //单页最大只允许获取十条
            $size = 6;
        $service = new HumanService();
        $list = $service->get_human_list($page, $size);
        $service = new CertificateService();
        foreach($list as $key => $human){
            $list[$key]['RC_list'] = $service->getRegisterCertificateListByHuman($human['human_id']);
        }
        return FactoryVMap::list_to_models($list, 'home_recommend_human');
    }

    /**
     * 获取人才列表总条数
     * @return <int> 总条数
     */
    public static function get_talents_count(){
        $service = new HumanService();
        $count   = $service->get_human_list(null, null, null, true);
        if($count > 60)
            $count = 60;
        return $count;
    }
}
?>
