<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecommendProvider
 *
 * @author JZG
 */
class RecommendProvider extends BaseProvider {
    //put your code here

    /**
     * 推荐职位
     */
    public function getJob($field, $where, $count, $page, $size, $order, $job_category, $publisher_role, $job_province_code) {
        $table = C('DB_PREFIX') . 'job job';
        $join = array();
        $tableArray = $this->extractTable($field);
        foreach ($tableArray as $key => $value) {
            if ($value == 'publisher') {
                $join[$key] = 'inner join ' . C('DB_PREFIX') . 'user publisher on job.publisher_id=publisher.user_id';
            }
        }
        if (!empty($job_category)) {
            $where['job.job_category'] = $job_category;
        }
        if (!empty($publisher_role)) {
            $where['job.publisher_role'] = $publisher_role;
        }
        if (!empty($job_province_code)) {
            $where['job.job_province_code'] = $job_province_code;
        }
        if ($count) {
            return $this->da->table($table)->join($join)->where($where)->count('job.job_id');
        }
        if (empty($order))
            $order = 'job.pub_datetime DESC';
        return $this->da->table($table)->join($join)->where($where)->field($field)->order($order)->page("$page,$size")->select();
    }

    //human,resume,publisher,job_intent,hang_card_intent
    public function getHuman($field, $where, $count, $page, $size, $order, $job_category, $publisher_role) {
        $table = C('DB_PREFIX') . 'human human';
        $join = array();
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'resume resume on human.resume_id=resume.resume_id';
        $join[1] = 'inner join ' . C('DB_PREFIX') . 'user publisher on resume.publisher_id=publisher.user_id';
        $join[2] = 'inner join ' . C('DB_PREFIX') . 'job_intent job_intent on resume.job_intent_id=job_intent.job_intent_id';
        $join[3] = 'inner join ' . C('DB_PREFIX') . 'hang_card_intent hang_card_intent on resume.hang_card_intent_id=hang_card_intent.hang_card_intent_id';
        if (!empty($job_category)) {
            $where['resume.job_category'] = $job_category;
        };
        if (!empty($publisher_role)) {
            $where['publisher.role_id'] = $publisher_role;
        };
        $where['publisher.is_freeze'] = 0;
        $where['publisher.is_activate'] = 1;
        $where['publisher.email_activate'] = 1;
        if ($count) {
            return $this->da->table($table)->join($join)->where($where)->count('human.human_id');
        }
        return $this->da->table($table)->join($join)->where($where)->field($field)->order($order)->page("$page,$size")->select();
    }

    //company user
    /**
     * 推荐企业
     * @param <array> $field 查询字段数组
     * @param <array> $where 推荐条件
     * @param <bool> $count 为true时返回推荐企业总条数
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @param <string> $order 排序
     * @param <int> $company_province_code 公司注册地省份编号
     * @param <int> $company_city_code 公司注册地城市编号
     * @return <mixed>
     */
    public function getCompany($field, $where, $count, $page, $size, $order, $company_province_code, $company_city_code) {
        $table = C('DB_PREFIX') . 'user user';
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'company company on user.data_id=company.company_id';
        $where['user.role_id'] = C('ROLE_ENTERPRISE');
        if (!empty($company_province_code)) {
            $where['company.company_province_code'] = $company_province_code;
        }
        if (!empty($company_city_code)) {
            $where['company.company_city_code'] = $company_city_code;
        }
        $where['user.is_freeze'] = 0;
        $where['user.is_activate'] = 1;
        $where['user.email_activate'] = 1;
        if ($count) {
            return $this->da->table($table)->join($join)->where($where)->count('user.user_id');
        }
        return $this->da->table($table)->join($join)->where($where)->field($field)->page("$page,$size")->order($order)->select();
    }

    private function extractTable($field) {
        $table = array();
        if (is_array($field)) {
            $i = 0;
            foreach ($field as $key => $value) {
                $tempArray = explode('.', $value);
                $table[$i] = $tempArray[0];
                $i++;
            }
        }
        $table = array_unique($table);
        return $table;
    }

    private function getJobIdList($acceptor_id, $promote_service) {
        $url = C('RE_URL') . 'job?size=' . C('RE_SIZE') . '&user_id=' . $acceptor_id . '&promote_service=' . $promote_service;
        $data = uc_fopen($url);
        return json_decode($data);
    }

    private function getJobInfo($field, $job_id, $job_category, $publisher_role) {
        $table = C('DB_PREFIX') . 'job job';
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'user publisher on job.publisher_id=publisher.user_id';
        $where['job.job_id'] = $job_id;
        if (!empty($job_category)) {
            $where['job.job_category'] = $job_category;
        }
        if (!empty($publisher_role)) {
            $where['job.publisher_role'] = $publisher_role;
        }
        $where['publisher.is_freeze'] = 0;
       // $where['publisher.is_activate'] = 1;
        $where['publisher.email_activate'] = 1;
        $where['publisher.is_del'] = 0;
        //$where['publisher.is_real_auth'] = 1;
        return $this->da->table($table)->join($join)->where($where)->field($field)->find();
    }

    public function getJobList($acceptor_id, $promote_service, $field, $count, $page, $size, $job_category, $publisher_role) {
        $jobIdList = $this->getJobIdList($acceptor_id, $promote_service);
        $jobList = Array();
        $i = 0;
        $privaceService = new PrivacyService();
        foreach ($jobIdList as $rj) {
            $job_id = $rj->jobID;
            $job_info = $this->getJobInfo($field, $job_id, $job_category, $publisher_role);
            if ($this->isDisabledUser($job_info['publisher_id'])) {
                continue;
            }
            if (!empty($job_info)) {
                if (!$privaceService->isAllowViewJob(AccountInfo::get_role_id(), $job_info['publisher_role'], $job_info['publisher_id'])) {
                    continue;
                }
                $jobList[$i] = $job_info;
                $i++;
            }
        }
        if ($count) {
            return $i;
        }
        $offset = ($page - 1) * $size;
        return array_slice($jobList, $offset, $size);
    }

    private function getCompanyIdList($acceptor_id, $promote_service) {
        $url = C('RE_URL') . 'user?size=' . C('RE_SIZE') . '&user_id=' . $acceptor_id . '&promote_service=' . $promote_service . '&ruser_role=2';
        $data = uc_fopen($url);
        return json_decode($data);
    }

    private function getCompanyInfo($field, $ruser_id, $company_province_code, $company_city_code) {
        $table = C('DB_PREFIX') . 'user user';
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'company company on user.data_id=company.company_id';
        $where['user.role_id'] = C('ROLE_ENTERPRISE');
        if (!empty($company_province_code)) {
            $where['company.company_province_code'] = $company_province_code;
        }
        if (!empty($company_city_code)) {
            $where['company.company_city_code'] = $company_city_code;
        }
        $where['user.is_freeze'] = 0;
  //      $where['user.is_activate'] = 1;
        $where['user.email_activate'] = 1;
        $where['user.user_id'] = $ruser_id;
 //       $where['user.is_real_auth'] = 1;
        return $this->da->table($table)->join($join)->where($where)->field($field)->find();
    }

    public function getCompanyList($acceptor_id, $promote_service, $field, $count, $page, $size, $company_province_code, $company_city_code) {
        $companyIdList = $this->getCompanyIdList($acceptor_id, $promote_service);
        $companyList = Array();
        $i = 0;
        foreach ($companyIdList as $rc) {
            $ruser_id = $rc->user_id;
            if ($this->isDisabledUser($ruser_id)) {
                continue;
            }
            $company_info = $this->getCompanyInfo($field, $ruser_id, $company_province_code, $company_city_code);
            if (!empty($company_info)) {
                $companyList[$i] = $company_info;
                $i++;
            }
        }
        if ($count) {
            return $i;
        }
        $offset = ($page - 1) * $size;
        return array_slice($companyList, $offset, $size);
    }

    private function getResumeIdList($acceptor_id, $promote_service) {
        $url = C('RE_URL') . 'resume?size=' . C('RE_SIZE') . '&user_id=' . $acceptor_id . '&promote_service=' . $promote_service;
        $data = uc_fopen($url);
        return json_decode($data);
    }

    private function getResumeInfo($field, $resume_id, $job_category, $publisher_role) {
        $table = C('DB_PREFIX') . 'human human';
        $join = array();
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'resume resume on human.resume_id=resume.resume_id';
        $join[1] = 'inner join ' . C('DB_PREFIX') . 'user publisher on resume.publisher_id=publisher.user_id';
        $join[2] = 'inner join ' . C('DB_PREFIX') . 'job_intent job_intent on resume.job_intent_id=job_intent.job_intent_id';
        $join[3] = 'inner join ' . C('DB_PREFIX') . 'hang_card_intent hang_card_intent on resume.hang_card_intent_id=hang_card_intent.hang_card_intent_id';
        if (!empty($job_category)) {
            $where['resume.job_category'] = $job_category;
        };
        if (!empty($publisher_role)) {
            $where['publisher.role_id'] = $publisher_role;
        };
        $where['publisher.is_freeze'] = 0;
//        $where['publisher.is_activate'] = 1;
        $where['publisher.email_activate'] = 1;
        $where['publisher.is_del'] = 0;
        //$where['publisher.is_real_auth'] = 1;
        $where['resume.resume_id'] = $resume_id;
        $where['resume.is_del']=0;
        return $this->da->table($table)->join($join)->where($where)->field($field)->find();
    }

    public function getResumeList($acceptor_id, $promote_service, $field, $count, $page, $size, $job_category, $publisher_role) {
        $resumeIdList = $this->getResumeIdList($acceptor_id, $promote_service);
        $resumeList = Array();
        $i = 0;
        $privacyService = new PrivacyService();
        foreach ($resumeIdList as $rr) {
            $resume_id = $rr->resume_id;
            $resume_info = $this->getResumeInfo($field, $resume_id, $job_category, $publisher_role);
            if ($this->isDisabledUser($resume_info['user_id'])) {
                continue;
            }
            if (!empty($resume_info)) {
                if (!$privacyService->isAllowViewResume(AccountInfo::get_role_id(), $resume_info['role_id'], $resume_info['user_id'])) {
                    continue;
                }
                $resumeList[$i] = $resume_info;
                $i++;
            }
        }
        if ($count) {
            return $i;
        }
        $offset = ($page - 1) * $size;
        return array_slice($resumeList, $offset, $size);
    }

    public function triggerRecommendUpdate() {
        $url = C('RE_URL') . 'trigger';
        //asyn_do($url);
    }

    public function loginTriggerUpdate($user_id, $user_role) {
        $url = C('RE_URL') . 'cpt?user_id=' . $user_id . '&user_role=' . $user_role . '&cpt_type=0&cpt_priority=1';
        asyn_do($url);
    }

    public function registerTriggerUpdate($user_id, $user_role) {
        $url = C('RE_URL') . 'cpt?user_id=' . $user_id . '&user_role=' . $user_role . '&cpt_type=0&cpt_priority=8';
        asyn_do($url);
    }

    public function jobDetailTriggerUpdate($job_id, $job_category) {
        $url = C('RE_URL') . 'cpt?job_id=' . $job_id . '&cpt_type=1&cpt_priority=1&job_category=' . $job_category;
        asyn_do($url);
    }

    public function openResumeTriggerUpdate($user_id, $user_role) {
        $url = C('RE_URL') . 'cpt?user_id=' . $user_id . '&user_role=' . $user_role . '&cpt_type=0&cpt_priority=1&reset=true';
        asyn_do($url);
    }

    private function getAgentIdList($acceptor_id, $promote_service) {
        $url = C('RE_URL') . 'user?size=' . C('RE_SIZE') . '&user_id=' . $acceptor_id . '&promote_service=' . $promote_service . '&ruser_role=3';
        $data = uc_fopen($url);
        return json_decode($data);
    }

    private function getAgentInfo($field, $ruser_id, $type, $addr_province_code, $addr_city_code) {
        $table = C('DB_PREFIX') . 'user user';
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'agent agent on user.data_id=agent.agent_id';
        $where['user.role_id'] = C('ROLE_AGENT');
        if ($type == 1) {
            $where['agent.company_name'] = '';
        } else if ($type == 2) {
            $where['agent.company_name'] = array('neq', '');
        }
        if (!empty($addr_province_code)) {
            $where['agent.addr_province_code'] = $addr_province_code;
        }
        if (!empty($addr_city_code)) {
            $where['agent.addr_city_code'] = $addr_city_code;
        }
        $where['user.is_del'] = 0;
        $where['user.is_freeze'] = 0;
 //       $where['user.is_activate'] = 1;
        $where['user.email_activate'] = 1;
        $where['agent.is_del'] = 0;
        $where['user.user_id'] = $ruser_id;
 //       $where['user.is_real_auth'] = 1;
        return $this->da->table($table)->join($join)->where($where)->field($field)->find();
    }

    public function getAgentList($acceptor_id, $promote_service, $field, $service_category_id, $type, $addr_province_code, $addr_city_code, $page, $size, $count) {
        $agentIdList = $this->getAgentIdList($acceptor_id, $promote_service);
        $agentList = Array();
        $i = 0;
        foreach ($agentIdList as $ra) {
            $ruser_id = $ra->user_id;
            if ($this->isDisabledUser($ruser_id)) {
                continue;
            }
            $agent_info = $this->getAgentInfo($field, $ruser_id, $type, $addr_province_code, $addr_city_code);
            if (!empty($agent_info)) {
                $agentList[$i] = $agent_info;
                $i++;
            }
        }
        if ($count) {
            return $i;
        }
        $offset = ($page - 1) * $size;
        return array_slice($agentList, $offset, $size);
    }

    private function getHumanIdList($acceptor_id, $promote_service) {
        $url = C('RE_URL') . 'user?size=' . C('RE_SIZE') . '&user_id=' . $acceptor_id . '&promote_service=' . $promote_service . '&ruser_role=1';
        $data = uc_fopen($url);
        return json_decode($data);
    }

    private function getHumanInfo($field, $ruser_id) {
        $table = C('DB_PREFIX') . 'human human';
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'user user on human.human_id=user.data_id';
        $where['user.user_id'] = $ruser_id;
        $where['human.is_del'] = 0;
        $where['user.is_del'] = 0;
        $where['user.role_id'] = C('ROLE_TALENTS');
        $where['user.is_freeze'] = 0;
//        $where['user.is_activate'] = 1;
        $where['user.email_activate'] = 1;
        //$where['user.is_real_auth']=1;

        return $this->da->table($table)->join($join)->where($where)->field($field)->find();
    }

    public function getHumanList($acceptor_id, $promote_service, $field, $count, $page, $size) {
        $humanIdList = $this->getHumanIdList($acceptor_id, $promote_service);
        $humanList = Array();
        $i = 0;
        $privacyService = new PrivacyService();
        foreach ($humanIdList as $rh) {
            $ruser_id = $rh->user_id;
            if ($this->isDisabledUser($ruser_id)) {
                continue;
            }
            $human_info = $this->getHumanInfo($field, $ruser_id);
            if (!empty($human_info)) {
                if (!$privacyService->isAllowViewResume(AccountInfo::get_role_id(), $human_info['role_id'], $human_info['user_id'])) {
                    continue;
                }
                $humanList[$i] = $human_info;
                $i++;
            }
        }
        if ($count) {
            return $i;
        }
        $offset = ($page - 1) * $size;
        return array_slice($humanList, $offset, $size);
    }

    private function getSimilarJobIdList($job_id) {
        $url = C('RE_URL') . 'similarJob?size=' . C('RE_SIZE') . '&job_id=' . $job_id;
        $data = uc_fopen($url);
        return json_decode($data);
    }

    private function getSimilarJobInfo($field, $sjob_id) {
        $table = C('DB_PREFIX') . 'job job';
        $join[0] = 'inner join ' . C('DB_PREFIX') . 'user publisher on job.publisher_id=publisher.user_id';
        $where['job.publisher_id'] = array('gt', 0);
        $where['job.is_del'] = 0;
        $where['job.status'] = 2;
        $where['job.job_id'] = $sjob_id;

        $where['publisher.is_freeze'] = 0;
//        $where['publisher.is_activate'] = 1;
        $where['publisher.email_activate'] = 1;
        $where['publisher.is_del'] = 0;
//        $where['publisher.is_real_auth'] = 1;

        return $this->da->table($table)->join($join)->where($where)->field($field)->find();
    }

    public function getSimilarJobList($job_id, $field, $count, $page, $size) {
        $similarJobIdList = $this->getSimilarJobIdList($job_id);
        $similarJobList = Array();
        $i = 0;
        foreach ($similarJobIdList as $sj) {
            $sjob_id = $sj->jobID;
            $job_info = $this->getSimilarJobInfo($field, $sjob_id);
            if ($this->isDisabledUser($job_info['publisher_id'])) {
                continue;
            }
            if (!empty($job_info)) {
                $similarJobList[$i] = $job_info;
                $i++;
            }
        }
        if ($count) {
            return $i;
        }
        $offset = ($page - 1) * $size;
        return array_slice($similarJobList, $offset, $size);
    }

    /**
     * 屏蔽指定用户
     * @staticvar array $disabled_users
     * @param type $user_id
     * @return boolean 
     */
    public function isDisabledUser($user_id) {
        static $disabled_users = array(10017, 10020, 10021);
        foreach ($disabled_users as $disabled_user) {
            if ($disabled_user == $user_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * 获取指定数量的人才简历ID
     * @param int $count 
     */
    private function getHumanResumeIdList($count) {
        $table=C('DB_PREFIX').'resume resume';
        $where['resume.publisher_id']=array('gt', 0);
        $where['resume.agent_id']=0;
        $field = 'resume.resume_id';
        $order = 'resume.pub_datetime desc';
        return $this->da->table($table)->where($where)->field($field)->page("0,$count")->order($order)->select();
    }

    /**
     * 获取指定数量的人才简历
     * @param array $field
     * @param int $size
     * @param int $job_category
     * @return array 
     */
    public function getHumanResume($field, $size, $job_category) {
        $resumeIdList = $this->getHumanResumeIdList($size);
        $resumeList = Array();
        $i = 0;
        $privacyService = new PrivacyService();
        foreach ($resumeIdList as $resume_id) {
            $resume_id=$resume_id['resume_id'];
            $resume_info = $this->getResumeInfo($field, $resume_id, $job_category, 1);
            if (empty($resume_info)){
                continue;
            }
            if ($this->isDisabledUser($resume_info['user_id'])) {
                continue;
            }
            if (!empty($resume_info)) {
                if (!$privacyService->isAllowViewResume(AccountInfo::get_role_id(), $resume_info['role_id'], $resume_info['user_id'])) {
                    continue;
                }
                $resumeList[$i] = $resume_info;
                $i++;
            }
        }
        return $resumeList;
    }

}

?>
