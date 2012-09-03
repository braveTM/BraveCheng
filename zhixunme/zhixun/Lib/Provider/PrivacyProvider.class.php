<?php
/**
 * 隐私
 * @author jabari
 */
class PrivacyProvider extends BaseProvider{
    /**
     *人才隐私表字段验证规则
     * @var array 
     */
    public $humanPrivacyArgRule = array(
        'resume' => array(
            'name' => '简历',
            'check' =>VAR_HP_RESUME,
            'null' => false
        ),
        'name'=>array(
            'name'=>'姓名',
            'check'=>VAR_HP_NAME,
            'null'=>false
        ),
        'birthday' => array(
            'name' => '生日',
            'check' =>VAR_HP_BIRTHDAY,
            'null' => false
        ),
        'contact_way'=>array(
            'name'=>'联系方式',
            'check'=>VAR_HP_CONTACT_WAY,
            'null'=>false
        )
    );
    /**
     *企业隐私表字段验证规则
     * @var array 
     */
    public $companyPrivacyArgRule=array(
        'job'=>array(
            'name'=>'职位',
            'check'=>VAR_CP_JOB,
            'null'=>false
        ),
        'company_name'=>array(
            'name'=>'企业名称',
            'check'=>VAR_CP_COMPANY_NAME,
            'null'=>false
        ),
        'contact_name'=>array(
            'name'=>'联系人姓名',
            'check'=>VAR_CP_CONTACT_NAME,
            'null'=>false
        ),
        'contact_way'=>array(
            'name'=>'联系方式',
            'check'=>VAR_CP_CONTACT_WAY,
            'null'=>false
        ),
    );
    /**
     *经纪人隐私表字段验证规则
     * @var array 
     */
    public $agentPrivacyArgRule=array(
        'resume'=>array(
            'name'=>'简历',
            'check'=>VAR_AP_RESUME,
            'null'=>false
        ),
        'job'=>array(
            'name'=>'职位',
            'check'=>VAR_AP_JOB,
            'null'=>false
        ),
        'name'=>array(
            'name'=>'姓名',
            'check'=>VAR_AP_NAME,
            'null'=>false
        ),
        'contact_way'=>array(
            'name'=>'联系方式',
            'check'=>VAR_AP_CONTACT_WAY,
            'null'=>false
        ),
    );
    
    /**
     * 人才隐私替换规则
     * @var array
     */
    public $humanPrivacyReplaceRule = array(
        'home_recommend_human' => array(
            'replace_rule' => array(
                'human_name'=>'human.name',
                'name'=>'human.name',
            ),
            'privacy_id' => array('human_id','human_id'),
        ),
        'home_user_base'=>array(
            'replace_rule'=>array(
                'name'=>'human.name',
            ),
            'privacy_id' => array('user_id','user_id'),
        ),
        'home_delegate_human'=>array(
            'replace_rule'=>array(
                'name'=>'human.name',
            ),
            'privacy_id'=>array('user_id','user_id'),
        ),
        'home_resume_sent'=>array(
            'replace_rule'=>array(
                'name'=>'human.name',
            ),
            'privacy_id'=>array('human_id','human_id'),
        ),
        'home_human_profile_model'=>array(
            'replace_rule'=>array(
                'name'=>'human.name',
                'birthday'=>'human.birthday',
            ),
            'privacy_id'=>array('human_id','human_id'),
        ),
        'home_resume_own'=>array(
            'replace_rule'=>array(
                'name'=>'human.name',
            ),
            'privacy_id'=>array('human_id','human_id'),
        ),
        'home_contacts_follow' => array(
            'replace_rule' => array(
                'name' => 'human.name'
            ),
            'privacy_id' => array('user_id', 'user_id'),
        ),
        'home_contacts_moving' => array(
            'replace_rule' => array(
                'name' => 'human.name'
            ),
            'privacy_id' => array('user_id', 'user_id'),
        )
    );
    /**
     *企业隐私替换规则
     * @var array 
     */
    public $companyPrivacyReplaceRule=array(
        'home_recommend_job' => array(
            'replace_rule' => array(
                'name'=>'company.contact_name',
                'company_name'=>'company.company_name'
            ),
            'privacy_id' =>array('creator_id','user_id'),
        ),
        'home_job_agented' => array(
            'replace_rule'=>array(
                'name'=>'company.contact_name',
                'company_name'=>'company.company_name'
            ),
            'privacy_id' =>array('creator_id','user_id'),
        ),
        'home_job_detail' => array(
            'replace_rule'=>array(
                'company_name'=>'company.company_name'
            ),
            'privacy_id'=>array('creator_id','user_id'),
        ),
        'home_user_base' => array(
            'replace_rule'=>array(
                'name'=>'company.contact_name',
            ),
            'privacy_id'=>array('user_id','user_id'),
        ),
        'home_interested_company'=>array(
            'replace_rule'=>array(
                'company_name'=>'company.company_name'
            ),
            'privacy_id'=>array('user_id','user_id'),
        ),
        'home_job_list'=>array(
            'replace_rule'=>array(
                'company_name'=> 'company.company_name'
            ),
            'privacy_id'=>array('creator_id','user_id'),
        ),
        'home_company_profile'=>array(
            'replace_rule'=>array(
                'company_name'=>'company.company_name'
            ),
            'privacy_id'=> array('user_id','user_id'),
        ),
        'home_company_detail'=>array(
            'replace_rule'=>array(
                'company_name'=>'company.company_name',
                'name'=>'company.contact_name',
            ),
            'privacy_id'=>array('user_id','user_id'),
        ),
        'home_contacts_follow' => array(
            'replace_rule' => array(
                'name' => 'company.contact_name'
            ),
            'privacy_id' => array('user_id', 'user_id'),
        ),
        'home_contacts_moving' => array(
            'replace_rule' => array(
                'name' => 'company.contact_name'
            ),
            'privacy_id' => array('user_id', 'user_id'),
        )
    );
    
    /**
     *经纪人隐私替换规则
     * @var array 
     */
    public $agentPrivacyReplaceRule = array(
        'home_recommend_human' => array(
            'replace_rule' => array(
                'name' => 'agent.name',
            ),
            'privacy_id' => array('user_id', 'user_id'),
        ),
        'home_recommend_job'=>array(
            'replace_rule'=>array(
                'name'=>'agent.name',
            ),
            'privacy_id'=>array('publisher_id','user_id'),
        ),
        'home_resume_sent'=>array(
            'replace_rule'=>array(
                'name'=>'agent.name',
            ),
            'privacy_id'=>array('user_id','user_id'),
        ),
        'home_agent_detail'=>array(
            'replace_rule'=>array(
                'name'=>'agent.name',
            ),
            'privacy_id'=>array('agent_id','user_id'),
        ),
        'home_user_base' => array(
            'replace_rule'=>array(
                'name'=>'agent.name',
            ),
            'privacy_id'=>array('user_id','user_id'),
        ),
        'home_found_agent'=>array(
            'replace_rule'=>array(
                'name'=>'agent.name',
            ),
            'privacy_id'=>array('agent_id','user_id'),
        ),
        'home_blog_sum'=>array(
            'replace_rule'=>array(
                'name'=> 'agent.name'
            ),
            'privacy_id'=>array('creator_id','user_id'),
        ),
        'home_blog_release'=>array(
            'replace_rule'=>array(
                'name'=>'agent.name'
            ),
            'privacy_id'=>array('user_id','user_id'),
        ),
        'home_blog'=>array(
            'replace_rule'=>array(
                'name'=>'agent.name'
            ),
            'privacy_id'=>array('creator_id','user_id'),
        ),
        'home_contacts_follow' => array(
            'replace_rule' => array(
                'name' => 'agent.name'
            ),
            'privacy_id' => array('user_id', 'user_id'),
        ),
        'home_contacts_moving' => array(
            'replace_rule' => array(
                'name' => 'agent.name'
            ),
            'privacy_id' => array('user_id', 'user_id'),
        ),
        'home_agent_popup'=>array(
            'replace_rule'=>array(
                'name'=>'agent.name'
            ),
            'privacy_id' => array('user_id', 'user_id'),
        ),
    );
    
    /**
     * 添加人才隐私
     * @param array $data 人才隐私记录数组
     * @return mixed 成功返回添加记录ID，失败返回false 
     */
    public function addHumanPrivacy($data){
        if (is_null($data)){
            $data['is_del']=0;
        }
        $this->da->setModelName('human_privacy');
        return $this->da->add($data);
    }
    /**
     * 添加企业隐私
     * @param array $data 企业隐私记录数组
     * @return mixed 成功返回添加记录ID，失败返回false 
     */
    public function addCompanyPrivacy($data){
        if (is_null($data)){
            $data['is_del']=0;
        }
        $this->da->setModelName('company_privacy');
        return $this->da->add($data);
    }
    /**
     * 添加经纪人隐私
     * @param array $data 经纪人隐私记录数组
     * @return mixed 成功返回添加记录ID，失败返回false 
     */
    public function addAgentPrivacy($data){
        if (is_null($data)){
            $data['is_del']=0;
        }
        $this->da->setModelName('agent_privacy');
        return $this->da->add($data);
    }
    /**
     * 查询人才隐私单条记录
     * @param array $where 查询条件数组
     * @return mixed 成功返回数组（一条记录）或null,失败返回false
     */
    public function getHumanPrivacy($where){
        $this->da->setModelName('human_privacy');
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }
    /**
     * 查询企业隐私单条记录
     * @param array $where 查询条件数组
     * @return mixed 成功返回数组（一条记录）或null,失败返回false
     */
    public function getCompanyPrivacy($where){
        $this->da->setModelName('company_privacy');
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }
    /**
     * 查询经纪人隐私单条记录
     * @param array $where 查询条件数组
     * @return mixed 成功返回数组（一条记录）或null,失败返回false
     */
    public function getAgentPrivacy($where){
        $this->da->setModelName('agent_privacy');
        $where['is_del'] = 0;
        return $this->da->where($where)->find();
    }
    
	/**
     * 更新企业隐私信息
     * @param <int>   $company_privacy_id 企业隐私id
     * @param <array> $data    信息
     * @return <bool> 是否成功
     */
    public function updateCompanyPrivacy($company_privacy_id, $data){
        $this->da->setModelName('company_privacy');            //使用账户表
        $where['company_privacy_id'] = $company_privacy_id;
        return $this->da->where($where)->save($data) !== false;
    }
    
	/**
     * 更新经纪人隐私信息
     * @param <int>   $agent_privacy_id 经纪人隐私id
     * @param <array> $data    信息
     * @return <bool> 是否成功
     */
    public function updateAgentPrivacy($agent_privacy_id, $data){
        $this->da->setModelName('agent_privacy');            //使用账户表
        $where['agent_privacy_id'] = $agent_privacy_id;
        return $this->da->where($where)->save($data) !== false;
    }
    
	/**
     * 更新人才隐私信息
     * @param <int>   $human_privacy_id 人才隐私id
     * @param <array> $data    信息
     * @return <bool> 是否成功
     */
    public function updateHumanPrivacy($human_privacy_id, $data){
        $this->da->setModelName('human_privacy');            //使用账户表
        $where['human_privacy_id'] = $human_privacy_id;
        return $this->da->where($where)->save($data) !== false;
    }
    
}
?>
