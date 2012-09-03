<?php

/**
 * 注册人信息处理模块
 *
 * @author Brave
 */
class RegisterCrmProvider extends BaseProvider {

    public static $registerArgRule = array(
        'name' => array(
            'name' => '注册人姓名',
            'null' => false,
            'check' => VAR_NAME,
            'filter' => VAR_NAME,
        ),
        'apt_id' => array(
            'name' => '行业资质id',
            'null' => false,
            'check' => VAR_ID,
        ),
        'employ_pay' => array(
            'name' => '聘用工资',
            'null' => false,
            'check' => VAR_ID,
        ),
        'reg_info_id' => array(
            'name' => '注册情况',
            'check' => VAR_ID,
        ),
        'contract_period' => array(
            'name' => '合同期',
            'null' => false,
            'check' => VAR_ID,
        ),
        'pay_way' => array(
            'name' => '付款方式',
            'null' => false,
            'length' => 64,
        ),
        'refund_singor' => array(
            'name' => '退款企业签字人',
            'check' => VAR_NAME,
        ),
        'refund_reseaon' => array(
            'name' => '退款原因',
            'length' => '200',
        ),
        'sex' => array(
            'name' => '性别',
            'filter' => VAR_GENDER,
        ),
        'is_refund' => array(
            'name' => '是否退款',
            'check' => VAR_ID,
        ),
        'refund_money' => array(
            'name' => '退款金额',
        ),
        'refund_signer' => array(
            'name' => '退款我方签字人',
            'check' => VAR_NAME,
        ),
        'refund_time' => array(
            'name' => '退款时间',
            'check' => VAR_DATE,
        ),
        'pay_time' => array(
            'name' => ' 付款时间',
            'check' => VAR_DATE,
        ),
        'expiration_time ' => array(
            'name' => '到期时间',
            'check' => VAR_DATE,
        ),
        'contract_last_time  ' => array(
            'name' => '签约时间',
            'check' => VAR_DATE,
        ),
    );

    /**
     * 获取指定注册人信息
     * @param type $enter_id
     * @param array $where 
     */
    public function getRegisterById($reg_id) {
        $this->da->setModelName('crm_register');
        $where = array(
            'reg_id' => $reg_id,
            'is_delete' => 0
        );
        return $this->da->where($where)->find();
    }

    /**
     *  获取指定企业资源注册人信息
     * @param int $enter_id
     * @return array 
     */
    public function getComRegister($enter_id) {
        $this->da->setModelName('crm_register');
        return $this->da->where('enter_id= ' . $enter_id)->select();
    }

    /**
     * 添加一条注册人信息
     * @param array $data 注册人信息数组
     * @return mixed 
     */
    public function addRegister($data) {
        $this->da->setModelName('crm_register');
        $data['is_delete'] = 0;
        return $this->da->add($data);
    }

    /**
     * 修改一条主持人信息
     * @param int $reg_id 注册人id
     * @param array $data 注册人信息数组
     * @return boolean 
     */
    public function updateRegister($reg_id, $data) {
        $this->da->setModelName('crm_register');
        return $this->da->where('reg_id = ' . $reg_id)->save($data);
    }

}

?>
