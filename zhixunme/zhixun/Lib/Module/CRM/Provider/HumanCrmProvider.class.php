<?php

/**
 * 人才数据提供器
 * @author YoyiorLee
 */
class HumanCrmProvider extends BaseProvider {

    /**
     * 全职兼职
     * @var array 
     */
    public static $fulltime = array(
        0 => '不限',
        1 => '兼职',
        2 => '全职',
    );

    /**
     * 性别
     * @var array 
     */
    public static $sex = array(
        0 => '女',
        1 => '男',
    );

    /**
     * 职称等级
     * @var type 
     */
    public static $titlelevel = array(
        1 => '初级',
        2 => '中级',
        3 => '高级',
    );

    /**
     * 人才资源字段规则
     * @var <array>
     */
    public static $humanArgRule = array(
        'human_id' => array(
            'name' => '人才资源id',
            'check' => VAR_ID,
        ),
        'sour_id' => array(
            'name' => '人才资源来源',
            'check' => VAR_ID,
            'null' => false,
        ),
        'name' => array(
            'name' => '人才资源名称',
            'check' => VAR_NAME,
            'null' => false,
        ),
        'sex' => array(
            'name' => '人才资源性别',
            'check' => VAR_SEX,
            'null' => false,
        ),
        'province_id' => array(
            'name' => '人才资源省ID',
            'check' => VAR_ID,
            'null' => false,
        ),
        'city_id' => array(
            'name' => '人才资源 城市ID',
            'check' => VAR_ID,
            'null' => false,
        ),
        'region_id' => array(
            'name' => '人才资源区域id',
            'check' => VAR_ID,
            'null' => false,
        ),
        'community_id ' => array(
            'name' => '人才资源镇id',
            'check' => VAR_ID,
            'null' => false,
        ),
        'birthday ' => array(
            'name' => '人才资源生日',
            'check' => VAR_DATE,
        ),
        'brief' => array(
            'name' => '人才资源简介',
        ),
        'fax' => array(
            'name' => '人才资源传真',
        ),
        'email' => array(
            'name' => '人才资源email',
            'check' => VAR_EMAIL,
        ),
        'qq' => array(
            'name' => '人才资源qq',
            'filter' => VAR_QQ,
        ),
        'postcode' => array(
            'name' => '人才资源 邮编',
            'check' => VAR_ZIP,
        ),
        'doc_type' => array(
            'name' => '人才资源 证件类型',
        ),
        'doc_number' => array(
            'name' => '人才资源 证件号码',
        ),
        'address ' => array(
            'name' => '人才资源详细地址',
            'length' => 255,
        ),
        'mobile' => array(
            'name' => '人才资源手机',
            'check' => VAR_PHONE,
        ),
        'employ_name' => array(
            'name' => '人才资源注册企业名称',
            'filter' => VAR_NAME,
        ),
        'employ_location ' => array(
            'name' => '人才资源注册聘用单位所在地',
        ),
        'employ_pay' => array(
            'name' => '人才资源注册企业 聘用工资',
        ),
        'employ_contract ' => array(
            'name' => '人才资源注册企业合同期',
        ),
        'employ_pay_time ' => array(
            'name' => '人才资源注册企业付款时间',
            'check' => VAR_DATE,
        ),
        'employ_payment ' => array(
            'name' => '人才资源注册企业付款方式',
        ),
        'employ_sign_time ' => array(
            'name' => '人才资源注册企业签约时间',
            'check' => VAR_DATE,
        ),
        'employ_expr_time ' => array(
            'name' => '人才资源注册企业到期时间',
            'check' => VAR_DATE,
        ),
        'employ_charger ' => array(
            'name' => '人才资源注册企业负责人',
        ),
        'employ_payment ' => array(
            'name' => '人才资源注册企业付款方式',
        ),
    );

    /**
     * 人才表字段
     */

    const HUMAN_TALBLE = 'crm_human ch';

    /**
     * 构造函数 
     */
    public function __construct() {
        parent::__construct(self::HUMAN_TALBLE);
    }

    /**
     *  数据插入
     * @param array $data
     * @return type 
     */
    function addHuman($data) {
        $this->da->setModelName('crm_human');
        $data['is_delete'] = 0; //未删除标识
        $data['time'] = date('Y-m-d', time()); //时间
        return $this->da->add($data);
    }

    /**
     *  数据插入
     * @param array $data
     * @return type 
     */
    function addHumanSim($data) {
        $this->da->setModelName('crm_human');
        $data['time'] = date('Y-m-d', time()); //时间
        return $this->da->add($data);
    }

    /**
     * 更新人才
     * @param type $data
     * @return type 
     */
    public function updateHuman($data) {
        $this->da->setModelName('crm_human');
        $data['time'] = date('Y-m-d', time());
        return $this->da->where('human_id = ' . $data['human_id'])->save($data);
    }

    /**
     * 获取人才信息
     * @param int $human_id 人才ID
     * @return mixed 结果集
     */
    public function get_human($human_id, $user_id) {
        $join = array(
            C('DB_PREFIX') . 'crm_district cd1 ON cd1.dist_id = ch.province_id',
            C('DB_PREFIX') . 'crm_district cd2 ON cd2.dist_id = ch.city_id',
            C('DB_PREFIX') . 'crm_district cd3 ON cd3.dist_id = ch.region_id',
            C('DB_PREFIX') . 'crm_district cd4 ON cd4.dist_id = ch.community_id',
            C('DB_PREFIX') . 'crm_source cs ON cs.sour_id  = ch.sour_id',
        );
        $where['ch.human_id'] = $human_id;
        $where['ch.user_id'] = $user_id;
        $where['ch.is_delete'] = 0;
        $field = array('ch.*,cd1.dist_name as province,cd2.dist_name as city',
            'cd3.dist_name as region,cd4.dist_name as community', 'ch.address',
            'cs.sour_name as source');
        $result = $this->da->join($join)->field($field)->where($where)->find();
        $result['sex_name'] = self::$sex[$result['sex']];
        $result['title_level'] = self::$titlelevel[$result['tp_level']];
        return $result;
    }

    /**
     * 获取人才总条数
     * @return int 总条数 
     */
    public function get_humans_count($user_id) {
        $this->da->setModelName('crm_human');
        $where = array(
            'is_delete' => 0,
            'user_id' => $user_id,
        );
        return $this->da->where($where)->count('human_id');
    }

    /**
     * 获取人才列表（默认列表）
     * @param int $page 当前页码
     * @param int $size 页大小
     * @param string $order 排序
     * @param bool $count 总条数
     * @return array 结果集
     */
    public function get_humans($page, $size, $user_id, $order) {
        $this->da->setModelName('crm_human ch');
        $join[0] = C('DB_PREFIX') . 'crm_district cd1 ON cd1.dist_id = ch.province_id';
        $join[1] = C('DB_PREFIX') . 'crm_district cd2 ON cd2.dist_id = ch.city_id';
        $join[2] = C('DB_PREFIX') . 'crm_district cd3 ON cd3.dist_id = ch.region_id';
        $join[3] = C('DB_PREFIX') . 'crm_district cd4 ON cd4.dist_id = ch.community_id';
        $join[4] = C('DB_PREFIX') . 'crm_source cs ON cs.sour_id = ch.sour_id';
        $where['ch.user_id'] = $user_id;
        $where['ch.is_delete'] = 0;
        $field = array(
            'ch.human_id', 'ch.name', 'ch.quote', 'ch.qq', 'ch.mobile', 'ch.is_fulltime', 'ch.tp_id', 'ch.tp_level',
            'cd1.dist_name as province',
            'cs.sour_name',
        );
        if (empty($order)) {
            $order = 'ch.human_id DESC';
        }
        $list = $this->da->join($join)->field($field)->where($where)->page("$page,$size")->order($order)->select();
        foreach ($list as $key => $value) {
            $list[$key]['fulltime'] = self::$fulltime[$value['is_fulltime']];
            $list[$key]['title_level'] = self::$titlelevel[$value['tp_level']];
        }
        return $list;
    }

    /**
     * 基本信息-聘用信息-备注 完成进度
     * @param int $human_id 人才ID
     * @return array('base','employ','note')-('X%|OK|提示')
     */
    public function get_base_info_complete_progress($human_id) {
        $where['human_id'] = $human_id;
        $field = array('name as base_name', 'sour_id as base_sour_id', 'sex as base_sex',
            'birthday as base_birthday', 'province_id as base_province_id', 'city_id as base_city_id',
            'region_id as base_region_id', 'community_id as base_community_id', 'idcard as base_idcard',
            'idcard_type as base_idcard_type', 'mobile as base_mobile', 'ch.phone as base_phone',
            'email as base_email', 'postcode as base_postcode', 'qq as base_qq', 'fax as base_fax', 'address as base_address',
            'employ_pay_time', 'employ_payment', 'employ_expr_time', 'employ_contract', 'employ_sign_time', 'employ_pay', 'employ_charger', 'employ_location', 'employ_name',
            'remark as note_remark');
        $result = $this->da->field($field)->where($where)->find();
        $com1 = 0;
        $com2 = 0;
        $com3 = '未备注';
        //拆分数组preg_match('/base_.*day/',$temp1,$m); 
        foreach ($result as $k => $v) {
            //基本信息/^[A-Z][a-z\d\_]{4,15}$/i
            if (preg_match('/^base_/i', $k) > 0) {
                if (!empty($v) || $v == 0) {
                    $com1++;
                }
            }
            //聘用信息
            else if (preg_match('/^employ_/i', $k) > 0) {
                if (!empty($v) || $v == 0) {
                    $com2++;
                }
            }
            //备注
            else if (preg_match('/^note_$/i', $k) > 0) {
                if (!empty($v)) {
                    $com3 = '已备注';
                }
            }
        }
        $status1 = sprintf('%01.2f', $com1 / 17) * 100;
        $status2 = sprintf('%01.2f', $com2 / 9) * 100;
        $arr = array(
            'base' => $status1 . '%',
            'employ' => $status2 . '%',
            'note' => $com3,
        );
        return $arr;
    }

    /**
     * 发送邮件 
     */
    public function sendMail($enter_id, $title, $content) {

        $this->da->setModelName('crm_human');
        $where['human_id'] = $enter_id;
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

}

?>
