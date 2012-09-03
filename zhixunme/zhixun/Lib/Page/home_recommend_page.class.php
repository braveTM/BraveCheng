<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_human_page
 *
 * @author JZG
 */
class home_recommend_page {
    //put your code here

    /**
     * 获取感兴趣的职位
     * @param <int> $acceptor_id 接收者ID
     * @param <int $promote_service 推广服务
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $job_category 工作性质
     * @param <int> $register_case 注册情况
     * @param <int> $publisher_role 发布人角色
     * @param <int> $job_province_code 工作地点省份编号
     * @param <int> $register_certificate_id 注册证书ID
     * @return <home_recommend_job_model> 推荐职位对象数组
     */
    public static function getInterestedJob($acceptor_id, $promote_service, $page, $size, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id) {
        $recommendService = new RecommendService();
        $job_list = $recommendService->getInterestedJob($acceptor_id, $promote_service, false, $page, $size, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id);
        $certificateService = new CertificateService();
        $service = new ContactsService();
        $jobService = new JobService();
        foreach ($job_list as $key => $job) {
            $job_id = $job['job_id'];
            $job_list[$key]['job_certificate_list'] = $certificateService->getRegisterCertificateListByJob($job_id);
            $job_list[$key]['follow'] = $service->exists_user_follow($acceptor_id, $job['publisher_id']);
            $job_list[$key]['job_name'] = $jobService->get_job_position($job['job_name']);
        }
        return FactoryVMap::list_to_models($job_list, 'home_recommend_job');
    }

    /**
     * 获取感兴趣的职位的总条数
     * @param <int> $acceptor_id 接收者ID
     * @param <int> $promote_service 推广服务
     * @param <int> $job_category 工作性质
     * @param <int> $register_case 注册情况
     * @param <int> $publisher_role 发布人角色
     * @param <int> $job_province_code 工作地点省份编号
     * @param <int> $register_certificate_id 注册证书ID
     * @return <int>
     */
    public static function getInterestedJobCount($acceptor_id, $promote_service, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id) {
        $recommendService = new RecommendService();
        $count = $recommendService->getInterestedJob($acceptor_id, $promote_service, true, null, null, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id);
        return $count;
    }

    /**
     * 获取感兴趣的人才
     * @param <int> $acceptor_id 接收者ID
     * @param <int> $promote_service 推广服务
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $job_category 工作性质（1为全职，2为兼职）
     * @param <int> $register_case 注册情况
     * @param <int> $publisher_role 发布人角色
     * @param <string> $register_province_ids 期望注册地
     * @param <int> $register_certificate_id 注册证书ID
     * @return <home_recommend_human_model> 推荐人才对象数组
     */
    public static function getInterestedHuman($acceptor_id, $promote_service, $page, $size, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id) {
        if ($publisher_role != C('ROLE_TALENTS') && $publisher_role != C('ROLE_AGENT'))
            $publisher_role = null;
        $recommendService = new RecommendService();
        $human_list = $recommendService->getInterestedHuman($acceptor_id, $promote_service, false, $page, $size, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id);
        $certificateService = new CertificateService();
        $service = new ContactsService();
        $jobService = new JobService();
        foreach ($human_list as $key => $human) {
            $human_id = $human['human_id'];
            $human_list[$key]['RC_list'] = $certificateService->getRegisterCertificateListByHuman($human_id);
            $human_list[$key]['follow'] = $service->exists_user_follow($acceptor_id, $human['user_id']);
            $human_list[$key]['job_name'] = $jobService->get_job_position($human['job_name']);
        }
        return FactoryVMap::list_to_models($human_list, 'home_recommend_human');
    }

    /**
     * 获取感兴趣的人才总记录数
     * @param <int> $acceptor_id 接收者ID
     * @param <int> $promote_service 推广服务
     * @param <int> $job_category 工作性质（1为全职，2为兼职）
     * @param <int> $register_case 注册情况
     * @param <int> $publisher_role 发布人角色
     * @param <string> $register_province_ids 期望注册地
     * @param <int> $register_certificate_id 注册证书ID
     * @return <int>
     */
    public static function getInterestedHumanCount($acceptor_id, $promote_service, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id) {
        $recommendService = new RecommendService();
        $count = $recommendService->getInterestedHuman($acceptor_id, $promote_service, true, null, null, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id);
        return $count;
    }

    /**
     * 获取推荐的职位
     * @param <int> $acceptor_id 接收者ID
     * @param <int> $promote_service 推广服务
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $job_category 工作性质
     * @param <int> $register_case 注册情况
     * @param <int> $publisher_role 发布人角色
     * @param <int> $job_province_code 工作地点省份编号
     * @param <int> $register_certificate_id 注册证书ID
     * @return <home_recommend_job_model> 推荐职位对象数组
     */
    public static function getRecommendJob($acceptor_id, $promote_service, $page, $size, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id) {
        $recommendService = new RecommendService();
        $job_list = $recommendService->getJob($acceptor_id, $promote_service, false, $page, $size, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id);
        $certificateService = new CertificateService();
        $jobService = new JobService();
        $service = new ContactsService();
        foreach ($job_list as $key => $job) {
            $job_id = $job['job_id'];
            $job_list[$key]['job_certificate_list'] = $certificateService->getRegisterCertificateListByJob($job_id);
            $job_list[$key]['follow'] = $service->exists_user_follow($acceptor_id, $job['publisher_id']);
            $job_list[$key]['job_name'] = $jobService->get_job_position($job['job_name']);
        }
        return FactoryVMap::list_to_models($job_list, 'home_recommend_job');
    }

    /**
     * 获取推荐的职位总记录数
     * @param <int> $acceptor_id 接收者ID
     * @param <int> $promote_servcie 推广服务
     * @param <int> $job_category 工作性质
     * @param <int> $register_case 注册情况
     * @param <int> $publisher_role 发布人角色
     * @param <int> $job_province_code 工作地点省份编号
     * @param <int> $register_certificate_id 注册证书ID
     * @return <int>
     */
    public static function getRecommendJobCount($acceptor_id, $promote_service, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id) {
        $recommendService = new RecommendService();
        $count = $recommendService->getJob($acceptor_id, $promote_service, true, null, null, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id);
        return $count;
    }

    /**
     * 获取推荐的人才
     * @param <int> $acceptor_id 接收者ID
     * @param <int> $promote_service 推广服务
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $job_category 工作性质（1为全职，2为兼职）
     * @param <int> $register_case 注册情况
     * @param <int> $publisher_role 发布人角色
     * @param <string> $register_province_ids 期望注册地
     * @param <int> $register_certificate_id 注册证书ID
     * @return <home_recommend_human_model> 推荐人才对象数组
     */
    public static function getRecommendHuman($acceptor_id, $promote_service, $page, $size, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id) {
        $recommendService = new RecommendService();
        $human_list = $recommendService->getHuman($acceptor_id, $promote_service, false, $page, $size, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id);
        $certificateService = new CertificateService();
        $service = new ContactsService();
        $jobService = new JobService();
        foreach ($human_list as $key => $human) {
            $human_id = $human['human_id'];
            $human_list[$key]['RC_list'] = $certificateService->getRegisterCertificateListByHuman($human_id);
            $human_list[$key]['follow'] = $service->exists_user_follow($acceptor_id, $human['user_id']);
            $human_list[$key]['job_name'] = $jobService->get_job_position($human['job_name']);
        }
        return FactoryVMap::list_to_models($human_list, 'home_recommend_human');
    }

    /**
     * 获取推荐的人才总记录数
     * @param <int> $acceptor_id 接收者ID
     * @param <int> $promote_service 推广服务
     * @param <int> $job_category 工作性质（1为全职，2为兼职）
     * @param <int> $register_case 注册情况
     * @param <int> $publisher_role 发布人角色
     * @param <string> $register_province_ids 期望注册地
     * @param <int> $register_certificate_id 注册证书ID
     * @return <int>
     */
    public static function getRecommendHumanCount($acceptor_id, $promote_service, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id) {
        $recommendService = new RecommendService();
        $count = $recommendService->getHuman($acceptor_id, $promote_service, true, null, null, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id);
        return $count;
    }

    /**
     * 获取推荐任务列表
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $class_a 一级分类
     * @param  <int>    $class_b 二级分类
     * @param  <int>    $role    用户角色
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @return <mixed> 任务列表
     */
    public static function get_recommend_task($user_id, $class_a, $class_b, $role, $page, $size) {
        $service = new RecommendService();
        $list = $service->get_task($user_id, $class_a, $class_b, $role, $page, $size);
        return FactoryVMap::list_to_models($list, 'home_task_normal');
    }

    /**
     * 获取推荐任务列表总条数
     * @param  <int> $user_id 用户编号
     * @param  <int> $class_a 一级分类
     * @param  <int> $class_b 二级分类
     * @param  <int> $role    用户角色
     * @return <int> 总条数
     */
    public static function get_recommend_task_count($user_id, $class_a, $class_b, $role) {
        $service = new RecommendService();
        return $service->get_task($user_id, $class_a, $class_b, $role, 1, 1, true);
    }

    /**
     * 获取感兴趣的企业
     * @param <int> $acceptor_id 接收方ID
     * @param <int> $promote_service 推广服务
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $company_province_code 公司注册地省份编号
     * @param <int> $company_city_code 公司注册地城市编号
     * @return <mixed>
     */
    public static function getInterestedCompany($acceptor_id, $promote_service, $page, $size, $company_province_code, $company_city_code) {
        $recommendService = new RecommendService();
        $companyList = $recommendService->getInterestedCompany($acceptor_id, $promote_service, false, $page, $size, $company_province_code, $company_city_code);
        $service = new ContactsService();
        foreach ($companyList as $key => $value) {
            $companyList[$key]['follow'] = $service->exists_user_follow($acceptor_id, $value['user_id']);
        }
        return FactoryVMap::list_to_models($companyList, 'home_interested_company');
    }

    /**
     * 获取感兴趣的企业总记录数
     * @param <int> $acceptor_id 接收方ID
     * @param <int> $promote_service 推广服务
     * @param <int> $company_province_code 公司注册地省份编号
     * @param <int> $company_city_code 公司注册地城市编号
     * @return <int>
     */
    public static function getInterestedCompanyCount($acceptor_id, $promote_service, $company_province_code, $company_city_code) {
        $recommendService = new RecommendService();
        $count = $recommendService->getInterestedCompany($acceptor_id, $promote_service, true, null, null, $company_province_code, $company_city_code);
        return $count;
    }

    /**
     * 获取用户首页的推荐简历数据
     * @param <type> $acceptor_id
     * @param <int> $promote_service
     * @param <type> $page
     * @param <type> $size
     * @return <type>
     */
    public static function get_home_recommend_resume($acceptor_id, $promote_service, $page, $size) {
        $recommendService = new RecommendService();
        $human_list = $recommendService->getHuman($acceptor_id, $promote_service, false, $page, $size);
        $certificateService = new CertificateService();
        $service = new ContactsService();
        $jobService = new JobService();
        foreach ($human_list as $key => $human) {
            $human_id = $human['human_id'];
            $human_list[$key]['RC_list'] = $certificateService->getRegisterCertificateListByHuman($human_id);
            $human_list[$key]['follow'] = $service->exists_user_follow($acceptor_id, $human['user_id']);
            $human_list[$key]['job_name'] = $jobService->get_job_position($human['job_name']);
        }
        return FactoryVMap::list_to_models($human_list, 'home_recommend_human');
    }

    /**
     * 随机获取首页推荐简历
     * @param <type> $acceptor_id
     * @param <type> $count 
     */
    public static function get_recommend_resume_rand($acceptor_id, $count) {
        $cache_key = __METHOD__ . $acceptor_id . $count;
        $resumes = DataCache::get($cache_key);
        if (empty($resumes)) {
            $recommendService = new RecommendService();
            $human_list = $recommendService->getHuman($acceptor_id, C('PROMOTE_RESUME_INDEX'), false, 1, 12);
            $certificateService = new CertificateService();
            $service = new ContactsService();
            $jobService = new JobService();
            foreach ($human_list as $key => $human) {
                $human_id = $human['human_id'];
                $human_list[$key]['RC_list'] = $certificateService->getRegisterCertificateListByHuman($human_id);
                $human_list[$key]['follow'] = $service->exists_user_follow($acceptor_id, $human['user_id']);
                $human_list[$key]['job_name'] = $jobService->get_job_position($human['job_name']);
            }
            $resumes = FactoryVMap::list_to_models($human_list, 'home_recommend_human');
            DataCache::set($cache_key, $resumes, CC('CACHE_TIME_LITTLE'));
        }
        $indexs = get_array_rand_index($resumes, $count);
        foreach ($indexs as $index) {
            $data[] = $resumes[$index];
        }
        if(!AccountInfo::get_activate()){
            //未实名认证企业或猎头，个人中心推荐简历至少推荐2个人才简历
            home_recommend_page::insertHumanResume($data);
        }
        return $data;
    }

    /**
     * 未实名认证企业或猎头，个人中心推荐简历至少推荐2个人才简历
     * @param type $data 
     */
    private static function insertHumanResume(&$data) {
        $recommendService = new RecommendService();
        $human_list = $recommendService->getHumanResume(null);
        $certificateService = new CertificateService();
        $service = new ContactsService();
        $jobService = new JobService();
        foreach ($human_list as $key => $human) {
            $human_id = $human['human_id'];
            $human_list[$key]['RC_list'] = $certificateService->getRegisterCertificateListByHuman($human_id);
            $human_list[$key]['follow'] = $service->exists_user_follow($acceptor_id, $human['user_id']);
            $human_list[$key]['job_name'] = $jobService->get_job_position($human['job_name']);
        }
        $resumes = FactoryVMap::list_to_models($human_list, 'home_recommend_human');
        $count=count($data);
        if (!empty($resumes)) {
            $prosition1 = rand(0, ($count - 1) / 2);
            $prosition2 = rand(($count - 1) / 2, $count - 1);
            array_splice($data, $prosition1, 1, array($resumes[0]));
            array_splice($data, $prosition2, 1, array($resumes[1]));
        }
    }

    /**
     * 获取用户首页的推荐职位数据
     * @param <type> $acceptor_id
     * @param <int> $promote_service
     * @param <type> $page
     * @param <type> $size
     * @return <type>
     */
    public static function get_home_recommend_job($acceptor_id, $promote_service, $page, $size) {
        $recommendService = new RecommendService();
        $job_list = $recommendService->getJob($acceptor_id, $promote_service, false, $page, $size);
        $certificateService = new CertificateService();
        $jobService = new JobService();
        $service = new ContactsService();
        foreach ($job_list as $key => $job) {
            $job_id = $job['job_id'];
            $job_list[$key]['job_certificate_list'] = $certificateService->getRegisterCertificateListByJob($job_id);
            $job_list[$key]['follow'] = $service->exists_user_follow($acceptor_id, $job['publisher_id']);
            $job_list[$key]['job_name'] = $jobService->get_job_position($job['job_name']);
        }
        return FactoryVMap::list_to_models($job_list, 'home_recommend_job');
    }

    /**
     * 随机获取首页推荐职位
     * @param <type> $acceptor_id
     * @param <type> $count
     * @return <type>
     */
    public static function get_recommend_job_rand($acceptor_id, $count) {
        $key = __METHOD__ . $acceptor_id;
        $jobs = DataCache::get($key);
        if (empty($jobs)) {
            $recommendService = new RecommendService();
            $job_list = $recommendService->getJob($acceptor_id, C('PROMOTE_JOB_INDEX'), false, 1, 15);
            $certificateService = new CertificateService();
            $jobService = new JobService();
            $service = new ContactsService();
            foreach ($job_list as $key => $job) {
                $job_id = $job['job_id'];
                $job_list[$key]['job_certificate_list'] = $certificateService->getRegisterCertificateListByJob($job_id);
                $job_list[$key]['follow'] = $service->exists_user_follow($acceptor_id, $job['publisher_id']);
                $job_list[$key]['job_name'] = $jobService->get_job_position($job['job_name']);
            }
            $jobs = FactoryVMap::list_to_models($job_list, 'home_recommend_job');
            DataCache::set($key, $jobs, CC('CACHE_TIME_LITTLE'));
        }
        $indexs = get_array_rand_index($jobs, $count);
        foreach ($indexs as $index) {
            $data[] = $jobs[$index];
        }
        return $data;
    }

    /**
     * 获取用户首页的推荐职位数据
     * @param <type> $acceptor_id
     * @param <type> $page
     * @param <type> $size
     * @return <type>
     */
    public static function get_home_recommend_task($acceptor_id, $page, $size) {
        $service = new RecommendService();
        $list = $service->get_task($acceptor_id, null, null, null, $page, $size);
        return FactoryVMap::list_to_models($list, 'home_task_normal');
    }

    /**
     * 随机获取用户首页的推荐职位数据
     * @param <type> $acceptor_id
     * @param <type> $page
     * @param <type> $size
     * @return <type>
     */
    public static function get_recommend_task_rand($acceptor_id, $count) {
        $key = __METHOD__ . $acceptor_id;
        $tasks = DataCache::get($key);
        if (empty($tasks)) {
            $service = new RecommendService();
            $list = $service->get_task($acceptor_id, null, null, null, 1, C('RE_SIZE'));
            $tasks = FactoryVMap::list_to_models($list, 'home_task_normal');
            DataCache::set($key, $tasks, CC('CACHE_TIME_LITTLE'));
        }
        $indexs = get_array_rand_index($tasks, $count);
        foreach ($indexs as $index) {
            $data[] = $tasks[$index];
        }
        return $data;
    }

    /**
     * 获取推荐人
     * @param <int> $acceptor_id 接收方ID
     * @param <type> $promote_service 推广服务
     * @param <type> $service_category_id 服务类别ID
     * @param <type> $type 类型（1为个人，2为公司）
     * @param <type> $addr_province_code 省份编号
     * @param <type> $addr_city_code 城市编号
     * @param <type> $page 第几页
     * @param <type> $size 每页几条
     * @return <type>
     */
    public static function getRecommendAgent($acceptor_id, $promote_service, $service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size) {
        $recommendService = new RecommendService();
        $list = $recommendService->getAgent($acceptor_id, $promote_service, $service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size, false);
        return FactoryVMap::list_to_models($list, "home_found_agent");
    }

    /**
     * 获取推荐经纪人总条数
     * @param <type> $acceptor_id
     * @param <type> $promote_service
     * @param <type> $service_category_id
     * @param <type> $type
     * @param <type> $addr_province_code
     * @param <type> $addr_city_code
     * @return <type>
     */
    public static function getRecommendAgentCount($acceptor_id, $promote_service, $service_category_id, $type, $addr_province_code, $addr_city_code) {
        $recommendService = new RecommendService();
        $count = $recommendService->getAgent($acceptor_id, $promote_service, $service_category_id, $type, $addr_province_code, $addr_city_code, null, null, true);
        return $count;
    }

    /**
     * 随机获取推荐人才
     * @param <type> $user_id
     * @param <type> $count
     */
    public static function get_recommend_human_rand($user_id, $count) {
        $key = __METHOD__ . $user_id;
        $humans = DataCache::get($key);
        if (empty($humans)) {
            $recommendService = new RecommendService();
            $humans = $recommendService->get_recommend_human_base($user_id, C('PROMOTE_RESUME_INDEX'), false, 1, 100, null, null, null, null, null);
            DataCache::set($key, $humans, CC('CACHE_TIME_LITTLE'));
        }
        $indexs = get_array_rand_index($humans, $count);
        foreach ($indexs as $index) {
            $data[] = $humans[$index];
        }
        return FactoryVMap::list_to_models($data, 'home_user_base');
    }

    /**
     * 随机获取推荐经纪人
     * @param <type> $user_id
     * @param <type> $count
     */
    public static function get_recommend_agent_rand($user_id, $count) {
        $key = __METHOD__ . $user_id;
        $agents = DataCache::get($key);
        if (empty($agents)) {
            $recommendService = new RecommendService();
            $agents = $recommendService->get_recommend_agent_base($user_id, C('PROMOTE_AGENT_INDEX'), null, null, null, null, 1, 100, false);
            DataCache::set($key, $agents, CC('CACHE_TIME_LITTLE'));
        }
        $indexs = get_array_rand_index($agents, $count);
        foreach ($indexs as $index) {
            $data[] = $agents[$index];
        }
        return FactoryVMap::list_to_models($data, 'home_user_base');
    }

    /**
     * 获取相似的职位
     * @param <int> $job_id 职位ID
     * @param <int> $page 第几页
     * @param <int> $size 每页几条
     */
    public static function getSimilarJobList($job_id, $page, $size) {
        $recommendService = new RecommendService();
        $list = $recommendService->getSimilarJob($job_id, false, $page, $size);
        return FactoryVMap::list_to_models($list, 'home_recommend_job');
    }

    /**
     * 获取相似的职位条数
     * @param <int> $job_id  职位ID
     */
    public static function getSimilarJobListCount($job_id) {
        $recommendService = new RecommendService();
        $count = $recommendService->getSimilarJob($job_id, true, null, null);
        return $count;
    }

    /**
     * 获取弹出推荐经纪人
     * @param int $user_id
     * @param int $promote_service
     * @return array 
     */
    public static function getPopupRecommendAgent($user_id, $promote_service) {
        $recommendService = new RecommendService();
        $agent_list = $recommendService->getAgent($user_id, $promote_service, null, 0, null, null, 1, 20, false);
        $count = count($agent_list);
        if ($count) {
            $index = rand(0, $count - 1);
            $data = $agent_list[$index];
            $userService = new UserService();
            $data_id = $userService->get_data_id($user_id);
            $role_id = AccountInfo::get_role_id();
            $data_info = $userService->get_data_info($data_id, $role_id);
            if ($role_id == 1) {
                $data['human_name'] = $data_info['name'];
            } else if ($role_id == 2) {
                $data['company_name'] = $data_info['company_name'];
            }
            $contactService = new ContactsService();
            $data['is_follow'] = $contactService->exists_user_follow($user_id, $data['user_id']);
            return FactoryVMap::array_to_model($data, 'home_agent_popup');
        }
        return null;
    }

}

?>
