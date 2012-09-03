<?php

/**
 * 企业信息处理模型
 *
 * @author Brave
 */
class CompanyCrmProvider extends BaseProvider {

    public static $companyArgRule = array(
        'name' => array(
            'name' => '企业资源名称',
            'length' => 64,
            'null' => false,
        ),
        'sour_id' => array(
            'name' => '企业资源来源',
            'check' => VAR_ID,
            'null' => false,
        ),
        'found_time' => array(
            'name' => '企业资源创立时间',
            'check' => VAR_DATE,
        ),
        'nature' => array(
            'name' => '企业性质id',
            'check' => VAR_ID,
        ),
        'province_id' => array(
            'name' => '企业资源省ID',
            'check' => VAR_ID,
        ),
        'city_id' => array(
            'name' => '企业资源 城市ID',
            'check' => VAR_ID,
        ),
        'region_id' => array(
            'name' => '企业资源区域id',
            'check' => VAR_ID,
        ),
        'community_id ' => array(
            'name' => '企业资源镇id',
            'check' => VAR_ID,
        ),
        'site' => array(
            'name' => '企业资源网址',
            'check' => VAR_SITE,
        ),
        'brief' => array(
            'name' => '企业资源简介',
        ),
        'contact' => array(
            'name' => '企业资源 联系人',
            'length' => 64,
        ),
        'email' => array(
            'name' => '企业资源email',
            'check' => VAR_EMAIL,
        ),
        'qq' => array(
            'name' => '企业资源qq',
            'filter' => VAR_QQ,
        ),
        'zipcode' => array(
            'name' => '企业资源 邮编',
        ),
        'address' => array(
            'name' => '企业资源详细地址',
            'length' => 255,
        ),
        'mobile' => array(
            'name' => '企业资源手机',
            'check' => VAR_PHONE,
        ),
        'phone' => array(
            'name' => '企业资源电话',
            'check' => VAR_FIXED_PHONE,
        ),
        'remark' => array(
            'name' => '企业资源备注',
        ),
        'fax' => array(
            'name' => '传真号码',
            'check' => VAR_FIXED_PHONE,
        ),
    );

    /**
     *  数据插入
     * @param array $data
     * @return type 
     */
    function addCompany($data) {
        $this->da->setModelName('crm_company');
        $data['is_delete'] = 0; //未删除标识
        $data['time'] = date('Y-m-d'); //时间
        return $this->da->add($data);
    }

    /**
     *  数据插入
     * @param array $data
     * @return type 
     */
    function addCompanySim($data) {
        $this->da->setModelName('crm_company');
        $data['is_delete'] = 0; //未删除标识
        $data['time'] = date('Y-m-d'); //时间
        return $this->da->add($data);
    }

    /**
     *   根据主键进行数据修改
     * @param int $enter_id
     * @param array $data 
     */
    function updateCompany($data) {
        $this->da->setModelName('crm_company');
        $data['time'] = date('Y-m-d');
        return $this->da->where('enter_id=' . $data['enter_id'])->save($data);
    }

    /**
     *  获取指定id的一条企业资源信息
     * @param type $enter_id
     * @param type $is_del
     * @param type $where
     * @return type 
     */
    function getCompany($enter_id, $useId) {
        $this->da->setModelName('crm_company c');
        $where['enter_id'] = $enter_id;
        $where['is_delete'] = 0;
        $where['user_id'] = $useId;
        //联合查询条件数组
        $join = array(
            //来源联合
            C('DB_PREFIX') . 'crm_source sour ON c.sour_id = sour.sour_id',
            //省联合
            C('DB_PREFIX') . 'crm_district d ON c.province_id = d.dist_id',
            //市联合
            C('DB_PREFIX') . 'crm_district d1 ON c.city_id = d1.dist_id',
            //区联合
            C('DB_PREFIX') . 'crm_district d2 ON c.region_id = d2.dist_id',
            //镇联合
            C('DB_PREFIX') . 'crm_district d3 ON c.community_id = d3.dist_id'
        );
        $fields = 'c.*,d.dist_name as province,d1.dist_name as city,d2.dist_name as region,
                    d3.dist_name as community,sour.sour_name';
        $list = $this->da->join($join)->field($fields)->where($where)->find();
        $list['property'] = cc_format($list['nature']);
        return $list;
    }

    /**
     * 条件查询数据 
     * @param int $curPage 当前页
     * @param int $pageSize 页大小
     * @param array $condition 条件数组
     * @return array  返回数组 
     */
    public function getCompanyList($curPage, $pageSize, $condition) {
        $this->da->setModelName('crm_company c');
        $where = array(
            'c.is_delete' => 0,
            's.is_delete' => 0,
            'de.is_delete' => 0,
        );
        foreach ($condition as $v) {
            foreach ($v as $key => $value) {
                if (!empty($value)) {
                    $where[$key] = $value;
                }
            }
        }
        //联合查询条件数组
        $join = array(
            //来源联合
            C('DB_PREFIX') . 'crm_source sour ON c.sour_id = sour.sour_id',
            //省联合
            C('DB_PREFIX') . 'crm_district d ON c.province_id = d.dist_id',
            //市联合
            C('DB_PREFIX') . 'crm_district d1 ON c.city_id = d1.dist_id',
            //区联合
            C('DB_PREFIX') . 'crm_district d2 ON c.region_id = d2.dist_id',
            //镇联合
            C('DB_PREFIX') . 'crm_district d3 ON c.community_id = d3.dist_id',
            //进度阶段关系ID 与 企业资源 
            C('DB_PREFIX') . 'crm_status s ON s.enter_id = c.enter_id',
            //进度阶段 与 阶段 关系
            C('DB_PREFIX') . 'crm_category ca ON ca.cate_id = s.cate_id',
            // 进度阶段 与 进度 关系
            C('DB_PREFIX') . 'crm_progress p ON p.pro_id = s.pro_id',
            //需求联合 
            C('DB_PREFIX') . 'crm_demand de ON de.enter_id = c.enter_id',
            //企业需求 与 行业证书关系ID  
            C('DB_PREFIX') . 'crm_aptitude a ON a.apt_id  = de.apt_id',
            //行业证书 与 证书
            C('DB_PREFIX') . 'crm_certificate ce ON ce.cert_id = a.cert_id',
            //行业证书 与 行业
            C('DB_PREFIX') . 'crm_industry i ON i.in_id = a.in_id',
        );

        $fields = array(
            'c.enter_id',
            'c.name',
            'c.contact',
            'c.nature',
            'c.phone',
            'c.mobile',
            'c.brief',
            'sour.sour_name',
            's.status_id',
            's.cate_id',
            's.pro_id',
            'ca.cate_name',
            'p.pro_name',
            's.notes',
            'de.apt_id',
            'de.effect',
            'de.information',
            'de.is_fulltime',
            'de.need_num',
            'de.need_price',
            'de.reg_info',
            'a.cert_id',
            'a.in_id',
            'ce.cert_name',
            'i.in_name',
        );
        $new = array();
        $list = $this->da->join($join)->field($fields)->where($where)->page($curPage . ',' . $pageSize)->order($condition['order'])->select();
        foreach ($list as $key => $value) {
            $new[$value['enter_id']][] = $value; //好好体会
        }
        return $new;
    }

    /**
     * 分页查询
     * @param type $curPage 当前页数
     * @param type $pageSize 页面数据大小
     * @return type 
     */
    public function getAllCompany($curPage, $pageSize, $userid) {
        $this->da->setModelName('crm_company c');
        $where = array(
            'c.is_delete' => 0,
            'c.user_id' => $userid,
        );
        //联合查询条件数组
        $join = array(
            //来源联合
            C('DB_PREFIX') . 'crm_source sour ON c.sour_id = sour.sour_id',
            //省联合
            C('DB_PREFIX') . 'crm_district d ON c.province_id = d.dist_id',
            //市联合
            C('DB_PREFIX') . 'crm_district d1 ON c.city_id = d1.dist_id',
            //区联合
            C('DB_PREFIX') . 'crm_district d2 ON c.region_id = d2.dist_id',
            //镇联合
            C('DB_PREFIX') . 'crm_district d3 ON c.community_id = d3.dist_id'
        );
        if (empty($order)) {
            $order = 'c.enter_id DESC';
        }
        $fields = array(
            'c.*',
            'sour.sour_name',
            'd.dist_name',
        );
        return $this->da->join($join)->field($fields)->where($where)->page($curPage . ',' . $pageSize)->order($order)->select();
    }

    /**
     * 获取总记录数
     * @return type 
     */
    public function getCount($user_id) {
        $this->da->setModelName('crm_company');
        $where = array(
            'is_delete' => 0,
            'user_id' => $user_id,
        );
        return $this->da->where($where)->count('enter_id');
    }

    /**
     * 发送邮件 
     */
    public function sendMail($enter_id, $title, $content) {

        $this->da->setModelName('crm_company');
        $where['enter_id'] = $enter_id;
        //联合查询条件数组
        $fields = 'email';
        $info = $this->da->field($fields)->where($where)->find();
        $provider = new UserProvider();
        $user = $provider->get_user_by_id($uid);                //获取指定用户账户信息
        if (empty($user)) {
            $uname = '尊敬的' . C('WEB_NAME') . '用户';
        } else {
            $uname = $user->__get('name');
        }
        $en = new EmailNotify();
        $result = $en->send($info['email'], $uname, $title, $content);
        return $result;
    }

    /**
     * 给指定邮箱发送邮件
     * @param  <type> $email
     * @param  <type> $tpl_id
     * @param  <type> $uid
     * @param  <type> $code
     * @return <type>
     */
    /* public function send_email($email, $tpl_id, $uid, $code,$content,$uname){
      $nProvider = new NotifyProvider();
      $notify = $nProvider->get_notify_tpl($tpl_id);     //获取指定通知模版
      if(empty($notify)){
      return;                                             //指定模版不存在
      }
      $en = new EmailNotify();                                //启用邮件通知
      $date = date_f('Y-m-d');                                //获取当前日期
      $provider = new UserProvider();
      $user = $provider->get_user_by_id($uid);                //获取指定用户账户信息
      if(empty($user)){
      $uname = '尊敬的'.C('WEB_NAME').'用户';
      }
      else{
      $uname = $user->__get('name');
      }
      //通知内容自定义标签替换
      $content = notify_replace($notify['content'], $uname, $date, $code);
      //邮件通知
      $en->send($email, $uname, $notify['title'], $content);
      } */
}

?>
