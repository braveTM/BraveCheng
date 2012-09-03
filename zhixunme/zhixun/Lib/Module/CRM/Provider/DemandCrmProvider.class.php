<?php

/**
 * 需求表处理模型
 *
 * @author Brave
 */
class DemandCrmProvider extends BaseProvider {

    //证书用途
    public static $effect = array(
        1 => '升级',
        2 => '年检',
        3 => '投标',
    );
    //需求职位状态
    public static $fulltime = array(
        1 => '兼职',
        0 => '不限',
        2 => '全职',
    );
    //是否函数
    public static $tax = array(
        0 => '否',
        1 => '是',
    );
    //需求表数据验证
    public static $demandArgRule = array(
        'demaind_id' => array(
            'name' => '需求ID',
            'check' => VAR_ID,
            'null' => false,
        ),
        'effect' => array(
            'name' => '需求证书用途',
            'null' => false,
            'check' => VAR_ID,
        ),
        'information' => array(
            'name' => '需求不中说明',
            'null' => true,
            'length' => 300,
        ),
        'need_num' => array(
            'name' => '需求人数',
            'null' => false,
            'check' => VAR_ID,
        ),
        'apt_id' => array(
            'name' => '行业资质id',
            'null' => false,
            'check' => VAR_ID,
        ),
        'reg_info' => array(
            'name' => '注册情况信息',
            'null' => false,
            'check' => VAR_ID,
        ),
        'need_price' => array(
            'name' => '需求人才聘用费/人',
            'null' => false,
            'check' => VAR_ID,
        ),
        'need_year' => array(
            'name' => '需求人才聘用年/人',
            'null' => false,
            'check' => VAR_ID,
        ),
        'service_charge' => array(
            'name' => '需求服务费',
            'null' => false,
            'check' => VAR_ID,
        ),
        'is_tax' => array(
            'name' => '是否含税',
            'null' => false,
            'check' => VAR_ID,
        ),
        'enter_id' => array(
            'name' => '企业资源id',
            'null' => false,
            'check' => VAR_ID
        ),
    );

    /**
     * 获取指定企业资源对应的各种需求
     * @param type $enter_id
     * @return type 
     */
    public function getCompanyDemand($enter_id) {
        $this->da->setModelName('crm_demand');
        $where['is_delete'] = 0;
        $where['enter_id'] = $enter_id;
        $results = $this->da->where($where)->select();
        $result = array();
        foreach ($results as $k => $v) {
            $result[$k]['demand_id'] = $v['demand_id'];
            $result[$k]['demand_use_id'] = $v['effect'];
            $result[$k]['demand_use'] = self::$effect[$v['effect']];
            $result[$k]['demand_reg_info'] = registerCase_format($v['reg_info']);
            $result[$k]['demand_reg_info_id'] = $v['reg_info'];
            $result[$k]['demand_need_price'] = $v['need_price'];
            $result[$k]['demand_need_year'] = $v['need_year'];
            $result[$k]['demand_service_charge'] = $v['service_charge'];
            $result[$k]['demand_apt_id'] = $v['apt_id'];
            $result[$k]['demand_tax'] = self::$tax[$v['is_tax']];
            $result[$k]['demand_is_tax'] = $v['is_tax'];
            $result[$k]['demand_notes'] = $v['information'];
            $result[$k]['demand_need_num'] = $v['need_num'];
            $result[$k]['demand_is_fulltime'] = $v['is_fulltime'];
            $result[$k]['demand_fulltime'] = self::$fulltime[$v['is_fulltime']];
        }
        return $result;
    }

    /**
     * 添加一条企业需求
     * @param array $data 需求数组
     * @return mixed 
     */
    public function addDemand($data) {
        $this->da->setModelName('crm_demand');
        $data['is_delete'] = 0;
        return $this->da->add($data);
    }

    /**
     * 更新一条企业需求
     * @param int $demand_id 需求id
     * @param array $data 需求数组
     * @return mixed 
     */
    public function updateDemand($demand_id, $data) {
        $this->da->setModelName('crm_demand');
        return $this->da->where('demand_id  = ' . $demand_id)->save($data);
    }

}

?>
