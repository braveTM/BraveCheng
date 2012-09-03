<?php

/**
 * 隐私
 * @author jabari
 */
class PrivacyService{
    /**
     *提供provider层实现 
     */
    private $privacyProvider;
    /**
     *构造函数 
     */
    public function __construct() {
        $this->privacyProvider=new PrivacyProvider();
    }
    /**
     * 创建人才隐私
     * @param int $user_id 用户ID
     * @param int $human_id 人才资料ID
     * @param int $resume_id 简历ID
     * @param int $resume 简历（1-企业和经纪人能看，2-经纪人能看，3-企业能看）
     * @param int $name 姓名（1-显示真实姓名，2-显示姓先生，3-显示姓女士）
     * @param int $birthday （1-年月日，2-月日，3-保密）
     * @param int $contact_way  （1-公开，2-不公开）
     * @return <mixed> 成功返回新创建隐私ID，失败返回错误信息
     */
    public function createHumanPrivacy($user_id,$human_id,$resume_id,$resume,$name,$birthday,$contact_way){
        $data=array(
            'user_id'=>$user_id,
            'human_id'=>$human_id,
            'resume_id'=>$resume_id,
            'resume'=>$resume,
            'name'=>$name,
            'birthday'=>$birthday,
            'contact_way'=>$contact_way
        );
        //数据验证
        $result=argumentValidate($this->privacyProvider->humanPrivacyArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        }else {
            $data=$result;
        }
        return $this->privacyProvider->addHumanPrivacy($data);
    }
    /**
     * 创建企业隐私
     * @param int $user_id 用户ID
     * @param int $company_id 企业资料ID
     * @param int $job 职位（1-人才和经纪人能看，2-经纪人能看，3-人才能看）
     * @param int $company_name 企业名称（1-显示真实名称，2-显示替换名称）
     * @param int $contact_name 联系人名称（1-显示真实名称，2-显示替换名称）
     * @param int $contact_way 联系方式（1-公开，2-不公开）
     * @return <mixed> 成功返回新创建隐私ID，失败返回错误信息
     */
    public function createCompanyPrivacy($user_id,$company_id,$job,$company_name,$contact_name,$contact_way){
        $data=array(
            'user_id'=>$user_id,
            'company_id'=>$company_id,
            'job'=>$job,
            'company_name'=>$company_name,
            'contact_name'=>$contact_name,
            'contact_way'=>$contact_way
        );
        //数据验证
        $result=argumentValidate($this->privacyProvider->companyPrivacyArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        }else {
            $data=$result;
        }
        return $this->privacyProvider->addCompanyPrivacy($data);
    }
    /**
     * 创建经纪人隐私
     * @param int $user_id 用户ID
     * @param int $agent_id 经纪人资料ID
     * @param int $resume 简历（1-企业和经纪人能看，2-经纪人能看，3-企业能看）
     * @param int $job  职位 （1-人才和经纪人能看，2-经纪人能看，3-人才能看）
     * @param int $name 姓名 （1-显示真实姓名，2-显示姓先生，3-显示姓女士）
     * @param int $contact_way 联系方式 （1-公开，2-不公开）
     * @return <mixed> 成功返回新创建隐私ID，失败返回错误信息
     */
    public function createAgentPrivacy($user_id,$agent_id,$resume,$job,$name,$contact_way){
        $data=array(
            'user_id'=>$user_id,
            'agent_id'=>$agent_id,
            'resume'=>$resume,
            'job'=>$job,
            'name'=>$name,
            'contact_way'=>$contact_way
        );
        //数据验证
        $result=argumentValidate($this->privacyProvider->agentPrivacyArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        }else {
            $data=$result;
        }
        return $this->privacyProvider->addAgentPrivacy($data);
    }
    
    /**
     * 是否允许查看职位
     * @param int $view_role 查看人角色
     * @param int $viewed_role 被查看人角色
     * @param int $viewed_user_id 被查看人用户ID
     * @return bool 
     */
    public function isAllowViewJob($view_role,$viewed_role,$viewed_user_id){
        if ($viewed_role == 2){
            $where=array(
                'user_id'=>$viewed_user_id
            );
            $privacy=$this->privacyProvider->getCompanyPrivacy($where);
            $job=$privacy['job'];
            switch ($job){
                case 1:
                    if ($view_role == 1 || $view_role == 3){
                        return true;
                    }
                    break;
                case 2:
                    if ($view_role == 3){
                        return true;
                    }
                    break;
                case 3:
                    if ($view_role == 1){
                        return true;
                    }
                    break;
                default:
                    return false;
            }
        }else if($viewed_role == 3){
            $where=array(
                'user_id'=>$viewed_user_id
            );
            $privacy=$this->privacyProvider->getAgentPrivacy($where);
            $job=$privacy['job'];
            switch ($job){
                case 1:
                    if ($view_role == 1 || $view_role == 3){
                        return true;
                    }
                    break;
                case 2:
                    if ($view_role == 3){
                        return true;
                    }
                    break;
                case 3:
                    if ($view_role == 1){
                        return true;
                    }
                    break;
                default:
                    return false;
            }
        }
        return false;
    }
    
    /**
     *是否允许查看简历
     * @param int $view_role 查看人角色
     * @param int $viewed_role 被查看人角色
     * @param int $viewed_user_id 被查看人用户ID
     * @return boolean 
     */
    public function isAllowViewResume($view_role,$viewed_role,$viewed_user_id){
        if ($viewed_role == 1){
            $where=array(
                'user_id'=>$viewed_user_id
            );
            $privacy=$this->privacyProvider->getHumanPrivacy($where);
            $resume=$privacy['resume'];
            switch ($resume){
                case 1:
                    if ($view_role == 2 || $view_role == 3){
                        return true;
                    }
                    break;
                case 2:
                    if ($view_role == 3){
                        return true;
                    }
                    break;
                case 3:
                    if ($view_role == 2){
                        return true;
                    }
                    break;
                default:
                    return false;
            }
        }else if($viewed_role == 3){
            $where=array(
                'user_id'=>$viewed_user_id
            );
            $privacy=$this->privacyProvider->getAgentPrivacy($where);
            $resume=$privacy['resume'];
            switch ($resume){
                case 1:
                    if ($view_role == 2 || $view_role == 3){
                        return true;
                    }
                    break;
                case 2:
                    if ($view_role == 3){
                        return true;
                    }
                    break;
                case 3:
                    if ($view_role == 2){
                        return true;
                    }
                    break;
                default:
                    return false;
            }
        }
        return false;
    }
    
	/**
     * 编辑企业隐私
     * @param int $company_privacy_id 企业隐私ID
     * @param array $data 企业资料ID
     * @return bool  true  false
     */
    public function updateCompanyPrivacy($company_privacy_id,$data){
        //数据验证
        $result=argumentValidate($this->privacyProvider->companyPrivacyArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        }else {
            $data=$result;
        }
        return $this->privacyProvider->updateCompanyPrivacy($company_privacy_id, $data);
    }
	/**
     * 编辑经纪人隐私
     * @param int $agent_privacy_id 经纪人隐私ID
     * @param array $data 信息
     * @return bool  true  false
     */
    public function updateAgentPrivacy($agent_privacy_id,$data){
        //数据验证
        $result=argumentValidate($this->privacyProvider->agentPrivacyArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        }else {
            $data=$result;
        }
        return $this->privacyProvider->updateAgentPrivacy($agent_privacy_id, $data);
    }
	/**
     * 编辑人才隐私
     * @param int $human_privacy_id 人才隐私ID
     * @param array $data 信息
     * @return bool  true  false
     */
    public function updateHumanPrivacy($human_privacy_id,$data){
        //数据验证
        $result=argumentValidate($this->privacyProvider->humanPrivacyArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        }else {
            $data=$result;
        }
        return $this->privacyProvider->updateHumanPrivacy($human_privacy_id, $data);
    }
    
	/**
     * 查询人才隐私单条记录
     * @param array $human_privacy_id 人才隐私id
     * @return mixed 成功返回数组（一条记录）或null,失败返回false
     */
    public function getHumanPrivacy($user_id){
        $where['user_id'] = $user_id;
        return $this->privacyProvider->getHumanPrivacy($where);
    }
    
	/**
     * 查询经纪人隐私单条记录
     * @param array $agent_privacy_id 人才隐私id
     * @return mixed 成功返回数组（一条记录）或null,失败返回false
     */
    public function getAgentPrivacy($user_id){
        $where['user_id'] = $user_id;
        return $this->privacyProvider->getAgentPrivacy($where);
    }
    
	/**
     * 查询企业隐私单条记录
     * @param array $company_privacy_id 人才隐私id
     * @return mixed 成功返回数组（一条记录）或null,失败返回false
     */
    public function getCompanyPrivacy($user_id){
        $where['user_id'] = $user_id;
        return $this->privacyProvider->getCompanyPrivacy($where);
    }
    
    /**
     *替换算法
     * @param string $model model名称
     * @param string $key 键
     * @param string $value 值
     * @return string 替换后的值
     */
    public function replace($model,&$list){
        $view_role = AccountInfo::get_role_id();
        foreach ($list as $key => $value) {
            if ($view_role == 1) {
                $list[$key]=$this->replace_dispatch($model, $key, $value, $this->privacyProvider->agentPrivacyReplaceRule, $list);
                if ($list[$key] == $value){
                    $list[$key]=$this->replace_dispatch($model, $key, $value, $this->privacyProvider->companyPrivacyReplaceRule, $list);
                }
            } else if ($view_role == 2) {
                $list[$key]=$this->replace_dispatch($model, $key, $value, $this->privacyProvider->agentPrivacyReplaceRule, $list);
                if ($list[$key] == $value){
                    $list[$key]=$this->replace_dispatch($model, $key, $value, $this->privacyProvider->humanPrivacyReplaceRule, $list);
                }
            } else if ($view_role == 3) {
                $list[$key]=$this->replace_dispatch($model, $key, $value, $this->privacyProvider->humanPrivacyReplaceRule,$list);
                if ($list[$key] == $value){
                    $list[$key]=$this->replace_dispatch($model, $key, $value, $this->privacyProvider->agentPrivacyReplaceRule,$list);
                }
                if ($list[$key] == $value){
                    $list[$key]=$this->replace_dispatch($model, $key, $value, $this->privacyProvider->companyPrivacyReplaceRule,$list);
                }
            }
        }
    }
    
    /**
     *替换分发
     * @param string $model model名称
     * @param string $key 替换键
     * @param string $value 替换值
     * @param string $rule 替换规则
     * @param array $list 数据
     * @return string 替换后的值 
     */
    private function replace_dispatch($model,$key,$value,$rule,$list){
       foreach($rule as $rule_key=>$rule_item){
           if ($rule_key == $model){
               $replace_rule=$rule_item['replace_rule'];
               $privacy_id=$rule_item['privacy_id'];
               foreach($replace_rule as $field=>$pattern){
                   if ($field == $key){
                       $value=$this->replace_process($pattern, $value,$privacy_id,$list);
                       return $value;
                   }
               }
           }
       }
       return $value;
    }
    
    /**
     * 替换处理 
     * @param string $pattern 替换模式
     * @param string $value 替换前的值
     * @param array $privacy_id 查询隐私的条件
     * @param array $list 数据
     * @return string 替换后的值 
     */
    private function replace_process($pattern, $value, $privacy_id, $list) {
        $where = array(
            $privacy_id[1] => $list[$privacy_id[0]]
        );
        switch ($pattern) {
            case 'human.name':
                $privacy = $this->privacyProvider->getHumanPrivacy($where);
                if (is_null($privacy)) {
                    break;
                }
                $name_pattern = $privacy['name'];
                $value = $this->name_replace($value, $name_pattern);
                break;
            case 'agent.name':
                $privacy = $this->privacyProvider->getAgentPrivacy($where);
                if (is_null($privacy)) {
                    break;
                }
                $name_pattern = $privacy['name'];
                $value = $this->name_replace($value, $name_pattern);
                break;
            case 'company.contact_name':
                $privacy=$this->privacyProvider->getCompanyPrivacy($where);
                if (is_null($privacy)){
                    break;
                }
                $name_pattern = $privacy['contact_name'];
                $value = $this->name_replace($value, $name_pattern);
                break;
            case 'company.company_name':
                $privacy=$this->privacyProvider->getCompanyPrivacy($where);
                if (is_null($privacy)){
                    break;
                }
                $name_pattern=$privacy['company_name'];
                $value=$this->company_name_replace($value,$name_pattern);
                break;
            case 'human.birthday':
                $privacy = $this->privacyProvider->getHumanPrivacy($where);
                if (is_null($privacy)) {
                    break;
                }
                $birthday_pattern = $privacy['birthday'];
                $value = $this->birthday_replace($value, $birthday_pattern);
                break;
        }
        return $value;
    }
    
    /**
     * 姓名替换
     * @param string $value 替换前的值
     * @param int $pattern 替换模式
     * @return string 替换后的值
     */
    private function name_replace($value,$pattern){
        $firstName=  str_sub($value,1);
        switch($pattern){
            case 1:
                break;
            case 2:
                $value=$firstName."先生";
                break;
            case 3:
                $value=$firstName."女士";
                break;
        }
        return $value;
    }
    
    /**
     * 公司名称替换
     * @param string $value 替换前的值
     * @param int $pattern 替换模式
     * @return string 替换后的值
     */
    private function company_name_replace($value,$pattern){
        switch ($pattern){
            case 1:
                break;
            case 2:
                $value=company_name_format($value);
                break;
        }
        return $value;
    }
    
    /**
     * 生日替换
     * @param string $value 替换的值
     * @param int $pattern 替换模式
     * @return string 替换后的值 
     */
    private function birthday_replace($value,$pattern){
        switch($pattern){
            case 1:
                break;
            case 2:
                $value=str_sub($value,5,5);
                break;
            case 3:
                $value="保密";
                break;
        }
        return $value;
    }
}
?>
