<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecommendService
 *
 * @author JZG
 */
class RecommendService {
    //put your code here

    /**
     * 获取推荐职位
     * @param <int> $acceptor_id 被推荐人ID（人才或经纪人用户ID）
     * @param <int> $promote_service 推广服务
     * @param <bool> $count 为true则返回总条数
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $job_category 工作性质（全职、兼职）
     * @param <int> $register_case 注册情况（初始注册、变更注册）
     * @param <int> $publisher_role 发布人角色（经纪人、企业）
     * @param <int> $job_province_code 工作地点（证书使用地）省份编号
     * @param <int> $register_certificate_id 注册证书ID
     */
    public function getJob($acceptor_id, $promote_service, $count, $page, $size, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id) {
        $recommendProvider = new RecommendProvider();
        $field = array(
            'job.creator_id', 'job.job_id', 'job.job_category', 'job.company_name', 'job.title as job_title',
            'publisher.is_email_auth', 'publisher.is_phone_auth', 'publisher.is_real_auth',
            'job.publisher_id', 'job.publisher_role', 'publisher.name', 'publisher.photo', 'job.degree', 'job.job_city_code',
            'job.count', 'job.job_name', 'job.job_province_code', 'job.require_place', 'job.job_salary', 'job.salary_unit'
            , 'job.pub_datetime','job.input_salary'
        );
        if (!C('RE_ENABLED')) {
            $where = array();
            return $recommendProvider->getJob($field, $where, $count, $page, $size, null, $job_category, $publisher_role, $job_province_code);
        } else {
            return $recommendProvider->getJobList($acceptor_id, $promote_service, $field, $count, $page, $size, $job_category, $publisher_role);
        }
    }

    /**
     * 获取推荐简历
     * @param <int> $acceptor_id 被推荐人ID
     * @param <int> $promote_service 推广服务
     * @param <bool> $count 为true返回总条数
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $job_category 工作性质
     * @param <int> $register_case 注册情况
     * @param <int> $publisher_role 发布人角色
     * @param <string> $register_province_ids 期望注册地
     * @param <int> $register_certificate_id 注册证书ID
     * @return <mixed>
     */
    public function getHuman($acceptor_id, $promote_service, $count, $page, $size, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id) {
        $recommendProvider = new RecommendProvider();
        $field = array(
            'human.human_id', 'resume.job_category', 'human.name' => 'human_name', 'publisher.is_email_auth',
            'publisher.is_phone_auth', 'publisher.is_real_auth', 'publisher.user_id',
            'publisher.name', 'publisher.role_id', 'publisher.photo', 'resume.resume_id', 'resume.update_datetime',
            'human.work_age', 'job_intent.job_city_code', 'job_intent.job_name', 'job_intent.job_province_code',
            'job_intent.job_salary','job_intent.input_salary', 'job_intent.salary_unit', 'hang_card_intent.register_province_ids',
            'hang_card_intent.job_salary' => 'hang_card_salary',
            'hang_card_intent.salary_unit' => 'hang_salary_unit','hang_card_intent.input_salary' => 'hang_input_salary'
        );
        if (!C('RE_ENABLED')) {
            $where = array();
            return $recommendProvider->getHuman($field, $where, $count, $page, $size, null, $job_category, $publisher_role);
        } else {
            return $recommendProvider->getResumeList($acceptor_id, $promote_service, $field, $count, $page, $size, $job_category, $publisher_role);
        }
    }

    /**
     * 获取推荐人才基本信息
     * @param <type> $acceptor_id
     * @param <type> $promote_service
     * @param <type> $count
     * @param <type> $page
     * @param <type> $size
     * @param <type> $job_category
     * @param <type> $register_case
     * @param <type> $publisher_role
     * @param <type> $register_province_ids
     * @param <type> $register_certificate_id
     * @return <type>
     */
    public function get_recommend_human_base($acceptor_id, $promote_service, $count, $page, $size, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id) {
        $recommendProvider = new RecommendProvider();
        $field = array(
            'user.user_id', 'human.name', 'user.photo', 'user.role_id'
        );
        if (!C('RE_ENABLED')) {
            $where = array();
            return $recommendProvider->getHuman(array('publisher.user_id', 'human.name', 'publisher.photo'), $where, $count, $page, $size, null, $job_category, $publisher_role);
        } else {
            return $recommendProvider->getHumanList($acceptor_id, $promote_service, $field, $count, $page, $size);
        }
    }

    /**
     * 获取推荐任务列表
     * @param  <int>    $user_id 用户编号
     * @param  <int>    $class_a 一级分类
     * @param  <int>    $class_b 二级分类
     * @param  <int>    $role    用户角色
     * @param  <int>    $page    第几页
     * @param  <int>    $size    每页几条
     * @param  <bool>   $count   是否统计总条数
     * @return <mixed> 任务列表
     */
    public function get_task($user_id, $class_a, $class_b, $role, $page, $size, $count = false) {
        $provider = new TaskProvider();
        return $provider->get_task_by_recommend($user_id, $class_a, $class_b, $role, $page, $size, $count);
    }

    /**
     * 获取感兴趣的职位
     * @param <int> $acceptor_id 接收方ID
     * @param <int> $promote_service 推广服务
     * @param <bool> $count 为true则返回总条数
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $job_category 工作性质（全职、兼职）
     * @param <int> $register_case 注册情况（初始注册、变更注册）
     * @param <int> $publisher_role 发布人角色（经纪人、企业）
     * @param <int> $job_province_code 工作地点（证书使用地）省份编号
     * @param <int> $register_certificate_id 注册证书ID
     */
    public function getInterestedJob($acceptor_id, $promote_service, $count, $page, $size, $job_category, $register_case, $publisher_role, $job_province_code, $register_certificate_id) {
        $recommendProvider = new RecommendProvider();
        $field = array(
            'job.creator_id', 'job.job_id', 'job.job_category', 'job.company_name', 'job.title as job_title',
            'publisher.is_email_auth', 'publisher.is_phone_auth', 'publisher.is_real_auth',
            'job.publisher_id', 'job.publisher_role', 'publisher.name', 'publisher.photo', 'job.degree', 'job.job_city_code',
            'job.count', 'job.job_name', 'job.job_province_code', 'job.require_place', 'job.job_salary', 'job.salary_unit'
            , 'job.pub_datetime','job.input_salary'
        );
        if (!C('RE_ENABLED')) {
            $where = array();
            return $recommendProvider->getJob($field, $where, $count, $page, $size, null, $job_category, $publisher_role, $job_province_code);
        } else {
            return $recommendProvider->getJobList($acceptor_id, $promote_service, $field, $count, $page, $size, $job_category, $publisher_role);
        }
    }

    /**
     * 获取感兴趣的简历
     * @param <int> $acceptor_id 接收方ID
     * @param <int> $promote_service 推广服务
     * @param <bool> $count 为true返回总条数
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $job_category 工作性质
     * @param <int> $register_case 注册情况
     * @param <int> $publisher_role 发布人角色
     * @param <string> $register_province_ids 期望注册地
     * @param <int> $register_certificate_id 注册证书ID
     * @return <mixed>
     */
    public function getInterestedHuman($acceptor_id, $promote_service, $count, $page, $size, $job_category, $register_case, $publisher_role, $register_province_ids, $register_certificate_id) {
        $recommendProvider = new RecommendProvider();
        $field = array(
            'human.human_id', 'resume.job_category', 'human.name' => 'human_name', 'publisher.is_email_auth',
            'publisher.is_phone_auth', 'publisher.is_real_auth', 'publisher.user_id',
            'publisher.name', 'publisher.role_id', 'publisher.photo', 'resume.resume_id', 'resume.update_datetime',
            'human.work_age', 'job_intent.job_city_code', 'job_intent.job_name', 'job_intent.job_province_code',
            'job_intent.job_salary', 'job_intent.input_salary', 'job_intent.salary_unit', 'hang_card_intent.register_province_ids',
            'hang_card_intent.job_salary' => 'hang_card_salary',
            'hang_card_intent.salary_unit' => 'hang_salary_unit',
            'hang_card_intent.input_salary' => 'hang_input_salary'
        );
        if (!C('RE_ENABLED')) {
            return $recommendProvider->getHuman($field, $where, $count, $page, $size, null, $job_category, $publisher_role);
        } else {
            return $recommendProvider->getResumeList($acceptor_id, $promote_service, $field, $count, $page, $size, $job_category, $publisher_role);
        }
    }

    /**
     * 获取感兴趣的企业
     * @param <int> $acceptor_id 接收方ID
     * @param <int> $promote_service 推广服务
     * @param <bool>$count 为true时返回总记录数
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <int> $company_province_code 公司注册地省份编号
     * @param <int> $company_city_code 公司注册地城市编号
     * @return <mixed>
     */
    public function getInterestedCompany($acceptor_id, $promote_service, $count, $page, $size, $company_province_code, $company_city_code) {
        $recommendProvider = new RecommendProvider();
        $field = array(
            'company.company_city_code', 'company.introduce', 'company.company_name',
            'company.company_province_code', 'user.name', 'user.is_email_auth', 'user.is_phone_auth',
            'user.is_real_auth', 'user.user_id', 'user.photo'
        );
        if (!C('RE_ENABLED')) {
            return $recommendProvider->getCompany($field, $where, $count, $page, $size, null, $company_province_code, $company_city_code);
        } else {
            return $recommendProvider->getCompanyList($acceptor_id, $promote_service, $field, $count, $page, $size, $company_province_code, $company_city_code);
        }
    }

    /**
     * 触发推荐引擎更新数据
     */
    public function triggerRecommendUpdate() {
        $recommendProvider = new RecommendProvider();
        $recommendProvider->triggerRecommendUpdate();
    }

    /**
     * 用户登录触发推荐更新
     * @param <type> $user_id
     * @param <type> $user_role
     */
    public function loginTriggerUpdate($user_id, $user_role) {
        $recommendProvider = new RecommendProvider();
        $recommendProvider->loginTriggerUpdate($user_id, $user_role);
    }

    /**
     * 用户注册触发推荐更新
     * @param <type> $user_id
     * @param <type> $user_role
     */
    public function registerTriggerUpdate($user_id, $user_role) {
        $recommendProvider = new RecommendProvider();
        $recommendProvider->registerTriggerUpdate($user_id, $user_role);
    }

    /**
     * 查看职位详细触发相似职位更新
     * @param <type> $job_id
     * @param <type> $job_category 
     */
    public function jobDetailTriggerUpdate($job_id, $job_category) {
        $recommendProvider = new RecommendProvider();
        $recommendProvider->jobDetailTriggerUpdate($job_id, $job_category);
    }

    /**
     * 公开简历时触发推荐更新
     * @param type $user_id
     * @param type $user_role 
     */
    public function openResumeTriggerUpdate($user_id, $user_role) {
        $recommendProvider = new RecommendProvider();
        $recommendProvider->openResumeTriggerUpdate($user_id, $user_role);
    }

    /**
     * 修改简历时触发推荐更新
     * @param type $user_id
     * @param type $user_role 
     */
    public function alterResumeTriggerUpdate($user_id, $user_role) {
        $recommendProvider = new RecommendProvider();
        $recommendProvider->openResumeTriggerUpdate($user_id, $user_role);
    }

    /**
     * 公开职位时触发推荐更新
     * @param type $user_id
     * @param type $user_role 
     */
    public function openJobTriggerUpdate($user_id, $user_role) {
        $recommendProvider = new RecommendProvider();
        $recommendProvider->openResumeTriggerUpdate($user_id, $user_role);
    }

    /**
     * 推荐经纪人
     * @param <int> $acceptor_id
     * @param <int> $promote_service
     * @param <int> $service_category_id
     * @param <int> $type
     * @param <int> $addr_province_code
     * @param <int> $addr_city_code
     * @param <int> $page
     * @param <int> $size
     * @param <bool> $count
     * @return <mixed>
     */
    public function getAgent($acceptor_id, $promote_service, $service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size, $count) {
        $field = array(
            'agent.agent_id', 'agent.addr_city_code', 'agent.addr_province_code', 'agent.introduce', 'agent.company_name', 'agent.name',
            'user.user_id', 'user.photo', 'user.is_email_auth', 'user.is_phone_auth', 'user.is_real_auth'
        );
        $middleManService = new MiddleManService();
        $recommendProvider = new RecommendProvider();
        if (!C('RE_ENABLED')) {
            return $middleManService->getDetailAgentList($service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size, $count);
        } else {
            return $recommendProvider->getAgentList($acceptor_id, $promote_service, $field, $service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size, $count);
        }
    }

    /**
     * 获取推荐经纪人基本信息
     * @param <int> $acceptor_id
     * @param <int> $promote_service
     * @param <int> $service_category_id
     * @param <int> $type
     * @param <int> $addr_province_code
     * @param <int> $addr_city_code
     * @param <int> $page
     * @param <int> $size
     * @param <bool> $count
     * @return <mixed>
     */
    public function get_recommend_agent_base($acceptor_id, $promote_service, $service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size, $count) {
        $field = array(
            'agent.name', 'user.user_id', 'user.photo'
        );
        if (!C('RE_ENABLED')) {
            $middleManService = new MiddleManService();
            return $middleManService->getDetailAgentList($service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size, $count);
        } else {
            $recommendProvider = new RecommendProvider();
            return $recommendProvider->getAgentList($acceptor_id, $promote_service, $field, $service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size, $count);
        }
    }

    /**
     * 获取相似的职位
     * @param <int> $job_id 职位ID
     * @param <bool> $count 为true返回总条数
     * @param <int> $page 第几页
     * @param <int> $size 每页几条
     * @return <mixed>
     */
    public function getSimilarJob($job_id, $count, $page, $size) {
        $field = array('job_id', 'title' => 'job_title');
        $recommendProvider = new RecommendProvider();
        return $recommendProvider->getSimilarJobList($job_id, $field, $count, $page, $size);
    }
    
    /**
     * 获取人才简历
     * @param int $job_category
     * @return array 
     */
    public function getHumanResume($job_category){
        $recommendProvider=new RecommendProvider();
        $field = array(
            'human.human_id', 'resume.job_category', 'human.name' => 'human_name', 'publisher.is_email_auth',
            'publisher.is_phone_auth', 'publisher.is_real_auth', 'publisher.user_id',
            'publisher.name', 'publisher.role_id', 'publisher.photo', 'resume.resume_id', 'resume.update_datetime',
            'human.work_age', 'job_intent.job_city_code', 'job_intent.job_name', 'job_intent.job_province_code',
            'job_intent.job_salary','job_intent.input_salary', 'job_intent.salary_unit', 'hang_card_intent.register_province_ids',
            'hang_card_intent.job_salary' => 'hang_card_salary',
            'hang_card_intent.salary_unit' => 'hang_salary_unit','hang_card_intent.input_salary' => 'hang_input_salary'
        );
        $size=50;
        $resumeList=$recommendProvider->getHumanResume($field, $size, $job_category);
        $count=count($resumeList);
        if($count>2){
            $index1=rand(0,($count-1)/2);
            $index2=rand(($count-1)/2+1,$count-1);
            return array(
                $resumeList[$index1],$resumeList[$index2]
            );
        }
        return null;
    }
}

?>
