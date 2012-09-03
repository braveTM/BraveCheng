<?php

/**
 * 关系映射处理模型 , 证书列表，行业列表 证书行业关系 注册人才信息 注册人才与企业关系 
 *
 * @author Brave
 */
class RelationCrmProvider extends BaseProvider {

    //企业资质关系验证
    public static $relationArgRule = array(
        'enter_id' => array(
            'name' => '企业资源ID',
            'filter' => VAR_ID,
            'null' => false
        ),
        'nid' => array(
            'name' => '资质情况ID',
            'filter' => VAR_ID,
            'null' => false
        ),
    );
    //人才 ，企业 与附件关系
    public static $atthumanArgRule = array(
        'att_human_id' => array(
            'name' => '人才企业附件关系ID',
            'check' => VAR_ID,
        ),
        'att_id' => array(
            'name' => '附件ID',
            'check' => VAR_ID,
        ),
        'human_id' => array(
            'name' => '人才ID',
            'check' => VAR_ID,
        ),
        'enter_id' => array(
            'name' => '企业ID',
            'check' => VAR_ID,
        ),
    );
    //人才，证书，行业关系
    public static $apthumanArgRule = array(
        'aman_id' => array(
            'name' => '人才证书行业关系id',
            'check' => VAR_ID,
        ),
        'apt_id' => array(
            'name' => '证书行业关系id',
            'check' => VAR_ID,
        ),
        'human_id' => array(
            'name' => '人才id',
            'check' => VAR_ID,
        ),
        'reg_info' => array(
            'name' => '人才证书行业关系注册情况',
            'check' => VAR_ID,
        ),
        'province_id' => array(
            'name' => '人才证书行业关系省id',
            'check' => VAR_ID,
        ),
    );

    /**
     * 时间转换
     * @param type $date
     * @param type $format
     * @return type 
     */
    public static function formatDate($date, $format) {
        if (is_string($date) && empty($format))
            return strtotime($date);
        else
            return date($format, $date);
    }

    /*     * ************************证书与行业关系****************************************************************************************************************** */

    /**
     * 获取指定证书id与行业id对应的关系apt_id
     * @param int $cert_id 证书id
     * @param int $in_id 行业id
     * @return string 返回关系id 
     */
    public function getApt_id($cert_id, $in_id) {
        $this->da->setModelName('crm_aptitude');
        $where = array(
            'is_delete' => 0,
            'cert_id' => $cert_id,
            'in_id' => $in_id,
        );
        $row = $this->da->where($where)->field('apt_id')->find();
        return $row['apt_id'];
    }

    /**
     * 获取证书行业关系ID对应的行业资质证书 
     * @param int $apt_id 关系ID
     * @return array 
     */
    public function getAptitude($apt_id) {
        $this->da->setModelName('crm_aptitude a');
        $join = array(
            C('DB_PREFIX') . 'crm_certificate c ON c.cert_id = a.cert_id',
            C('DB_PREFIX') . 'crm_industry i ON i.in_id = a.in_id',
        );
        $fields = 'c.cert_name,c.cert_id,i.in_name,i.in_id';
        return $this->da->join($join)->field($fields)->where('apt_id=' . $apt_id)->find();
    }

    /**
     * 企业资质与企业关系
     * 获取指定企业资源的企业资质情况
     * @param type $enter_id
     * @return type 
     */
    public function getNaturecomByEnter($enter_id) {
        $this->da->setModelName('crm_naturecom');
        $where = array(
            'enter_id' => $enter_id,
            'is_delete' => 0,
        );
        $fields = array(
            'cn_id',
            'nid',
        );
        return $this->da->field($fields)->where($where)->select();
    }

    /**
     * 添加一条企业资质情况关系
     * @param array $data
     * @return type 
     */
    public function addNaturecom($data) {
        $this->da->setModelName('crm_naturecom');
        $data['is_delete'] = 0;
        return $this->da->add($data);
    }

    /**
     * 获取指定企业资质情况关系
     * @param type $cn_id
     * @return type 
     */
    public function getNatureBycnid($cn_id) {
        $this->da->setModelName('crm_naturecom');
        return $this->da->where('cn_id=' . $cn_id)->find();
    }

    /**
     * 获取指定证书id的所有行业信息关系
     * @param type $cert_id
     * @return type 
     */
    public function getRelationByCert($cert_id) {
        $this->da->setModelName('crm_aptitude');
        $where = array(
            'cert_id' => $cert_id,
            'is_delete' => 0,
            //证书没有行业列表
            'in_id' => array('gt', 0),
        );
        $fields = array(
            'apt_id',
            'in_id',
            'cert_id',
        );
        return $this->da->field($fields)->where($where)->select();
    }

    /**
     * 删除记录接口
     * @param char $fieldName 字段名称
     * @param int $fieldValue字段值
     * @param char $table 数据表
     * @param boolean $completeDel 是否完全删除
     * @return boolean 
     */
    public function delData($fieldName, $fieldValue, $table, $completeDel = FALSE) {
        $this->da->setModelName($table);
        $data = array(
            'is_delete' => 1,
        );
        if ($completeDel) {
            return $this->da->where($fieldName . '=' . $fieldValue)->delete() > 0 ? TRUE : FALSE;
        }
        return $this->da->where($fieldName . '=' . $fieldValue)->save($data) > 0 ? TRUE : FALSE;
    }

    /**
     * 判断数据字段是否存在数据值
     * @param type $fieldName 数据字段
     * @param type $fieldValue 字段值
     * @param type $table 数据表
     * @return boolean
     */
    public function isExist($fieldName, $fieldValue, $table, $isDel = NULL) {
        $this->da->setModelName($table);
        $where = array(
            $fieldName => $fieldValue,
        );
        if ($isDel)
            $where['is_delete'] = 0;
        return $this->da->where($where)->count($fieldName) > 0 ? TRUE : FALSE;
    }

    /**
     * 获取指定记录结果集
     * @param string $fieldName 指定查找字段
     * @param string $fieldValue 指定查找字段值
     * @param array $params 要指定的结果集字段
     * @param sting $_table 表名
     * @return array 结果集字段 
     */
    public function getSpecialFields($fieldName, $fieldValue, $params, $_table) {
        $this->da->setModelName($_table);
        return $this->da->field($params)->where($fieldName . '=' . $fieldValue)->find();
    }

    /**
     * 获取字段的信息
     * @param string $fieldName 字段名称
     * @param string $fieldValue 字段值
     * @param string $getField 需要查询的字段
     * @param string $table 表名
     * @return mixed  返回需要查询的字段
     */
    public function getFields($fieldName, $fieldValue, $table, $getField = '*') {
        $this->da->setModelName($table);
        $where = array(
            'is_delete' => 0,
            $fieldName => $fieldValue,
        );
        return $this->da->field($getField)->where($where)->find();
    }

    /**
     * 获取字段的信息
     * @param string $fieldName 字段名称
     * @param string $fieldValue 字段值
     * @param string $getField 需要查询的字段
     * @param string $table 表名
     * @return mixed  返回需要查询的字段
     */
    public function getNeedFields($fieldName, $fieldValue, $table, $getField = '*') {
        $this->da->setModelName($table);
        $where = array(
            $fieldName => $fieldValue,
        );
        return $this->da->field($getField)->where($where)->find();
    }

    /**
     * 模糊匹配字段信息
     * @param string $fieldName 字段名称
     * @param string $fieldValue 字段值
     * @param string $getField 需要查询的字段
     * @param string $table 表名
     * @return mixed  返回需要查询的字段
     */
    public function getLikeFields($fieldName, $fieldValue, $table, $getField = '*') {
        $this->da->setModelName($table);
        $where = array(
            $fieldName => array('LIKE', '%' . $fieldValue . '%'),
        );
        return $this->da->field($getField)->where($where)->find();
    }

    /**
     * 条件查询数组 分别做了三个特列 {1、根据人才、企业名称或备注2、经纪人给人才的报价3、企业需求报价} 
     * @param array $condition 条件数组
     * @param int $page 页数
     * @param int $size 大小
     * @param string $table 表名
     * @param string $prefix 表别名
     * @param array $order 排序
     * @return array 返回结果数组
     * 
      array = (
      'is_fulltime' = 0, //全职/兼职/不限
      'sour_id' =  '', //来源id
      'province_id' =  '', //省id
      'name' =  '', //关键字/备注
      'tp_id' =  '', //职称
      'tp_level' =  '', //职称等级
      'user_id' = '',)
     */
    public function getWhereList($condition, $page, $size, $table, $prefix, $order, $count = FALSE) {
        $where = $join = $fields = array();
        $this->da->setModelName($table . ' ' . $prefix);
        $join = array(
            C('DB_PREFIX') . 'crm_source sour ON sour.sour_id = ' . $prefix . '.sour_id',
        );
        $fields = array($prefix . '.*', 'sour.sour_name');
        if (is_array($condition)) {
            foreach ($condition as $key => $value) {
                if (strlen($value) > 0) {
                    $where[$prefix . '.' . $key] = $value;
                    if ($key == 'name') {
                        $where['_string'] = $prefix . '.name LIKE \'%' . $value . '%\' OR ' . $prefix . '.remark LIKE \'%' . $value . '%\'';
                        unset($where[$prefix . '.' . $key]);
                    }
                    //经纪人给人才的报价搜索
                    if ($key == 'quote') {
                        switch ($value) {
                            case 1:
                                $where[$prefix . '.' . $key] = array(array('gt', 10), array('ELT', 15));
                                break;
                            case 2:
                                $where[$prefix . '.' . $key] = array(array('gt', 15), array('ELT', 20));
                                break;
                            case 3:
                                $where[$prefix . '.' . $key] = array(array('gt', 20), array('ELT', 30));
                                break;
                            case 4:
                                $where[$prefix . '.' . $key] = array(array('gt', 30), array('ELT', 50));
                                break;
                            case 5:
                                $where[$prefix . '.' . $key] = array(array('gt', 50), array('ELT', 100));
                                break;
                            case 6:
                                $where[$prefix . '.' . $key] = array(array('gt', 100));
                                break;
                            case 7:
                                $where[$prefix . '.' . $key] = array(array('gt', 1), array('ELT', 10));
                                break;
                            default:
                                $where[$prefix . '.' . $key] = array(array('gt', 0));
                                break;
                        }
                    }
                }
                if (is_array($value) && isset($value['index'])) {
                    array_push($join, C('DB_PREFIX') . $key . ' ' . $value['as'] . '  ON ' . $value['as'] . '.' . $value['index'] . ' = ' . $prefix . '.' . $value['index']);
                    unset($value['index']);
                    array_push($fields, $value['as'] . '.*');
                    array_shift($value);
                    foreach ($value as $k => $v) {
                        //企业需求报价条件筛选
                        if ($k == 'de.need_price') {
                            switch ($value['de.need_price']) {
                                case 1:
                                    $where['de.need_price'] = array(array('gt', 10), array('ELT', 15));
                                    break;
                                case 2:
                                    $where['de.need_price'] = array(array('gt', 15), array('ELT', 20));
                                    break;
                                case 3:
                                    $where['de.need_price'] = array(array('gt', 20), array('ELT', 30));
                                    break;
                                case 4:
                                    $where['de.need_price'] = array(array('gt', 30), array('ELT', 50));
                                    break;
                                case 5:
                                    $where['de.need_price'] = array(array('gt', 50), array('ELT', 100));
                                    break;
                                case 6:
                                    $where['de.need_price'] = array(array('gt', 100));
                                    break;
                                case 7:
                                    $where['de.need_price'] = array(array('gt', 1), array('ELT', 10));
                                    break;
                                default:
                                    $where['de.need_price'] = array(array('gt', 0));
                                    break;
                            }
                        } else {
                            $where[$k] = $v;
                        }
                    }
                }
            }
        }
        $where[$prefix . '.is_delete'] = 0;
        if ($count)
            return $this->da->join($join)->where($where)->count($prefix . '.' . $order);
        $com = $this->da->join($join)->field($fields)->page($page . ',' . $size)->where($where)->order($order)->select();
        return $com;
    }

    /*     * ************************企业与企业注册人关系记录****************************************************** */

    /**
     * 添加一条企业与注册人之间的关系记录
     * @param array $data
     * @return mixed 
     */
    public function addRegcom($data) {
        $this->da->setModelName('crm_regcom');
        $data['is_delete'] = 0;
        return $this->da->add($data);
    }

    /**
     * 注册人才与企业关系
     * 获取指定企业资源的注册人信息  
     * @param int $enter_id 企业资源ID 
     * @return array 
     */
    public function getRegcomByEnter($enter_id) {
        $this->da->setModelName('crm_regcom');
        $where = array(
            'enter_id' => $enter_id,
            'is_delete' => 0
        );
        return $this->da->where($where)->select();
    }

    /**
     * 获取一条企业与注册人关系
     * @param int $rc_id
     * @return mixed 
     */
    public function getRegcom($rc_id) {
        $this->da->setModelName('crm_regcom');
        $where = array(
            'rc_id' => $rc_id,
            'is_delete' => 0
        );
        return $this->da->where($where)->find();
    }

    /*     * ************************人才，企业 与 附件关系记录****************************************************** */

    /**
     * 企业、人才资源与附件关系 
     * @param type $enter_human_id 企业ID与人才ID
     * @param type $is_human 判断是否是企业或者人才
     * @return array 
     */
    public function getAtthumanByEnter($enter_human_id, $is_human = TRUE) {
        $this->da->setModelName('crm_atthuman');
        $where = array(
            'is_delete' => 0
        );
        if ($is_human)
            $where['human_id'] = $enter_human_id;
        else
            $where['enter_id'] = $enter_human_id;
        $fields = array(
            'att_human_id',
            'att_id',
        );
        return $this->da->field($fields)->where($where)->select();
    }

    /**
     * 添加企业、人才资源与附件关系 
     * @param array $data
     * @return type 
     */
    public function addAtthuman($data) {
        $this->da->setModelName('crm_atthuman');
        $data['is_delete'] = 0;
        return $this->da->add($data);
    }

    /**
     * 获取附件的attid
     * @param type $att_human_id
     * @return type 
     */
    public function getAtthumanAttid($att_human_id) {
        $this->da->setModelName('crm_atthuman');
        $where = array(
            'is_delete' => 0,
            'att_human_id' => $att_human_id,
        );
        $row = $this->da->where($where)->find();
        return $row['att_id'];
    }

    /*     * ************************人才，行业 与 证书关系记录****************************************************** */

    /**
     * 添加人才资源与行业证书关系 
     * @param array $data
     * @return mixed 
     */
    public function addApthuman($data) {
        $this->da->setModelName('crm_apt_human');
        $data['is_delete'] = 0;
        return $this->da->add($data);
    }

    /**
     * 更新人才资源与行业证书关系 
     * @param array $data
     * @return boolean 
     */
    public function updateApthuman($data) {
        $this->da->setModelName('crm_apt_human');
        $data['is_delete'] = 0;
        return $this->da->where('aman_id=' . $data['aman_id'])->save($data) > 1 ? TRUE : FALSE;
    }

}

?>
