<?php

/**
 * Description of CompanyCrmService
 *
 * @author Brave
 */
class CompanyCrmService {

    private $provider;

    /**
     * 实例化对象 
     */
    public function __construct() {
        $this->provider = new CompanyCrmProvider();
    }

    /**
     * 获取指定企业资源ID的信息
     * @param type $enter_id
     * @return type 
     */
    public function get_row_company($enter_id, $useId) {
        if (!var_validation($enter_id, VAR_ID))
            return E(ErrorMessage::$RECORD_NOT_EXISTS); //记录不存在
        /**
         * 实例化关系
         */
        $relationObj = new RelationCrmProvider();
        /**
         * 获取指定企业资源数据 
         */
        $comList = $this->provider->getCompany($enter_id, $useId);
        /**
         * 企业资质
         */
        $comNatureObj = new NatureCrmProvider();
        $comNature = $relationObj->getNaturecomByEnter($enter_id);
        foreach ($comNature as $k => $v) {
            $comN = $comNatureObj->getNatureById($v['nid']);
            $comNature[$k]['nature_name'] = $comN['nature_name'];
        }
        $comList['nature_array'] = $comNature;
        /**
         * 企业需求
         */
        $comDemandObj = new DemandCrmProvider();
        $comDemand = $comDemandObj->getCompanyDemand($enter_id);
        //企业需求行业证书
        foreach ($comDemand as $k => $v) {
            $apt = $relationObj->getAptitude($v['demand_apt_id']);
            $comDemand[$k] = array_merge($comDemand[$k], $apt);
        }
        $comList['demand_array'] = $comDemand;
        /**
         * 企业阶段进度信息
         */
        $statusObj = new StatusCrmProvider();
        $comStatus = $statusObj->getStatusById($enter_id, false);
        $comList['status_array'] = $comStatus;
        /**
         * 企业注册人信息 
         */
        $comRegObj = new RegisterCrmProvider();
        $comRegRel = $relationObj->getRegcomByEnter($enter_id);
        $relationProvider = new RelationCrmProvider();
        foreach ($comRegRel as $k => $v) {
            $register = $comRegObj->getRegisterById($v['reg_id']);
            $register['registration'] = registerCase_format($register['reg_info_id']);
            $register['sign_time'] = $register['sign_time'] != '0000-00-00' ? $register['sign_time'] : '';
            $register['refund_time'] = $register['refund_time'] != '0000-00-00' ? $register['refund_time'] : '';
            $register['pay_time'] = $register['pay_time'] != '0000-00-00' ? $register['pay_time'] : '';
            $register['expiration_time'] = $register['expiration_time'] != '0000-00-00' ? $register['expiration_time'] : '';
            $comRegRel[$k]['reg_info'] = $register;
            $aptitude = $relationProvider->getAptitude($register['apt_id']);
            $comRegRel[$k]['aptitude'] = $aptitude;
        }
        $comList['reg_array'] = $comRegRel;
        /**
         * 企业附件信息 
         */
        $comAttObj = new AttachmentCrmProvider();
        $comAtt = $relationObj->getAtthumanByEnter($enter_id, FALSE);
        foreach ($comAtt as $k => $v) {
            $comAtt[$k]['att_info'] = $comAttObj->getAttchmentById($v['att_id']);
        }
        $comList['att_array'] = $comAtt;
        /**
         * 信息完成度 
         */
        $comList['comInforPercent'] = $this->comInforPercent($enter_id);
        $comList['comNaturePercent'] = $this->comNaturePercent($enter_id);
        $comList['comContactPercent'] = $this->comContactPercent($enter_id);
        $comList['comDemandPercent'] = $this->comDemandPercent($enter_id);
        $comList['comStatusPercent'] = $this->comStatusPercent($enter_id);
        $comList['comRegisterPercent'] = $this->comRegisterPercent($enter_id);
        $comList['comAttPercent'] = $this->comAttPercent($enter_id);
        $comList['brief_short'] = str_sub($comList['brief'], 100);
        return $comList;
    }

    /**
     * 获取分页记录
     * @param type $curPage
     * @param type $pageSize 
     */
    public function get_all_company($curPage, $pageSize, $useId) {
        /**
         * 实例化关系
         */
        $relationObj = new RelationCrmProvider();
        $comDemandObj = new DemandCrmProvider();
        $rows = $this->provider->getAllCompany($curPage, $pageSize, $useId);
        foreach ($rows as $k => $v) {
            /**
             * 企业需求
             */
            $comDemand = $comDemandObj->getCompanyDemand($v['enter_id']);
            //企业需求行业证书
            foreach ($comDemand as $key => $value) {
                $comDemand[$key]['demand_apt_info'] = $relationObj->getAptitude($value['demand_apt_id']);
            }
            $rows[$k]['demand_array'] = $comDemand;
            /**
             * 企业阶段进度信息
             */
            $statusObj = new StatusCrmProvider();
            $comStatus = $statusObj->getStatusById($v['enter_id'], false, true);
            $rows[$k]['status_array'] = $comStatus;
            $pro = $relationObj->getSpecialFields('dist_id', $v['province_id'], 'dist_name', 'crm_district');
            $rows[$k]['province'] = $pro['dist_name'];
        }
        return $rows;
    }

    /**
     * 获取总记录数
     * @return type 
     */
    public function getCount($user_id) {
        return $this->provider->getCount($user_id);
    }

    /**
     * 添加一条企业资源数据
     * @param array $dataArr
     * @return mixed 
     */
    public function addCompany($dataArr) {
        if (!is_array($dataArr)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $data = argumentValidate(CompanyCrmProvider::$companyArgRule, $dataArr);
        if (is_zerror($data))
            return $data;
        $enter_id = $this->provider->addCompany($data);
        return $enter_id ? $enter_id : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 简单添加一条企业信息
     * @param array $dataArr
     * @return int 
     */
    public function addCompanySimple($dataArr) {
        $relationObj = new RelationCrmProvider();
        $data = argumentValidate(CompanyCrmProvider::$companyArgRule, $dataArr);
        if (is_zerror($data))
            return $data;
        if ($relationObj->isExist('name', $data['name'], 'crm_company'))
            return E(ErrorMessage::$USERNAME_EXISTS);
        $enter_id = $this->provider->addCompanySim($data);
        return $enter_id ? $enter_id : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * csv文件添加
     * @param array $dataArr 
     */
    public function addCompanyCsv($dataArr) {
        $error = array(
            '1' => '手机号码重复！',
        );
        $relationObj = new RelationCrmProvider();
        $dataArr = argumentValidate(CompanyCrmProvider::$companyArgRule, $dataArr);
        if (is_zerror($dataArr))
            return $dataArr->get_message();
        if ($relationObj->isExist('mobile', $dataArr['mobile'], 'crm_company'))
            return $error[1];
        return $this->provider->addCompanySim($dataArr);
    }

    /**
     * 更新一条企业数据
     * @param int $enter_id
     * @param array $dataArr
     * @return type 
     */
    public function updateCompany($dataArr) {
        $relationObj = new RelationCrmProvider();
        if (!is_array($dataArr)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $data = argumentValidate(CompanyCrmProvider::$companyArgRule, $dataArr);
        if (is_zerror($data))
            return $data;
        if (!$relationObj->isExist('enter_id', $data['enter_id'], 'crm_company'))
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        return $this->provider->updateCompany($data);
    }

    /**
     * 删除企业数据
     * @param int $enter_ids
     * @return type 
     */
    public function deleteCompanyBatch($enter_ids) {
        $ids = explode(',', $enter_ids);
        $ids = array_filter($ids);
        if (empty($ids)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        foreach ($ids as $key => $value) {
            $data['enter_id'] = $value;
            $data['is_delete'] = 1;
            $result = $this->provider->updateCompany($data);
            if ($result < 0) {
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        return TRUE;
    }

    /*     * ************************企业与企业资质关系记录******************************************************************************************************** */

    /**
     * 添加指定企业资源一条企业资质情况记录
     * @param int $enter_id 企业资源ID
     * @param string $nature_name 资质名称
     * @param int $contract 资质承包方式
     * @param int $level 资质等级
     * @return type 
     */
    public function addNatureByEnterId($enter_id, $nature_name) {
        $natureObj = new NatureCrmProvider();
        $relationObj = new RelationCrmProvider();
        //添加一条资质情况
        $data = array(
            'nature_name' => $nature_name,
        );
        $data = argumentValidate(NatureCrmProvider::$natureArgRule, $data);
        if (is_zerror($data))
            return $data;
        $nid = $natureObj->addNature($data);
        if (!$nid)
            return E(ErrorMessage::$OPERATION_FAILED);
        //添加企业与资质情况关系
        $relation = array(
            'enter_id' => $enter_id,
            'nid' => $nid
        );
        $relation = argumentValidate(RelationCrmProvider::$relationArgRule, $relation);
        if (is_zerror($relation))
            return $relation;
        $result = $relationObj->addNaturecom($relation);
        return $result ? $result : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 修改企业资质
     * @param type $cn_id
     * @param type $nature_name
     * @return type     
     */
    public function updateNature($cn_id, $nature_name) {
        $relationObj = new RelationCrmProvider();
        $natureObj = new NatureCrmProvider();
        if (!$relationObj->isExist('cn_id', $cn_id, 'crm_naturecom')) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        $row = $relationObj->getNatureBycnid($cn_id);
        $data = array(
            'nature_name' => $nature_name,
        );
        $data = argumentValidate(NatureCrmProvider::$natureArgRule, $data);
        if (is_zerror($data))
            return $data;
        return $natureObj->updateNature($row['nid'], $data);
    }

    /**
     * 获取所有企业资质列表
     * @return type 
     */
    public function getNature() {
        $natureObj = new NatureCrmProvider();
        return $natureObj->getNature();
    }

    /**
     * 删除企业资质情况关系记录
     * @param int $cn_id 企业资质关系ID
     * @param boolean $full_del 是否完全删除
     * @return boolean 
     */
    public function delNatruecom($cn_id, $realDel = FALSE) {
        $relationObj = new RelationCrmProvider();
        if (!$relationObj->isExist('cn_id', $cn_id, 'crm_naturecom')) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        return $relationObj->delData('cn_id', $cn_id, 'crm_naturecom', $realDel);
    }

    /*     * ************************企业与企业需求关系记录******************************************************************************************************** */

    /**
     *  添加一条企业需求信息
     * @param int $effect 用途
     * @param string $information 详细介绍
     * @param int $apt_id 行业在证书关系id
     * @param int $need_num 需求数量
     * @param int $is_fulltime 是否全职
     * @param int $is_tax 是否含税
     * @param float $service_charger 服务费
     * @param int $reg_info 注册情况
     * @param int $need_year 需求年数
     * @param float $need_price 需求价格
     * @param int $enter_id 企业资源id
     * @return type 
     */
    public function addDemand($effect, $information, $apt_id, $need_num, $is_fulltime, $is_tax, $service_charger, $reg_info, $need_year, $need_price, $enter_id) {
        $relationObj = new RelationCrmProvider();
        $demandObj = new DemandCrmProvider();
        $data = array(
            'effect' => $effect,
            'information' => $information,
            'need_num' => $need_num,
            'is_fulltime' => $is_fulltime,
            'is_tax' => $is_tax,
            'service_charge' => $service_charger,
            'reg_info' => $reg_info,
            'need_year' => $need_year,
            'need_price' => $need_price,
        );
        //判断行业证书与企业资源是否存在
        if (!$relationObj->isExist('apt_id', $apt_id, 'crm_aptitude') || !$relationObj->isExist('enter_id', $enter_id, 'crm_company')) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        } else {
            $data['apt_id'] = $apt_id;
            $data['enter_id'] = $enter_id;
        }
        //数据验证
        $data = argumentValidate(DemandCrmProvider::$demandArgRule, $data);
        if (is_zerror($data))
            return $data;
        //数据入库
        $demand_id = $demandObj->addDemand($data);
        return $demand_id ? $demand_id : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     *  添加一条企业需求信息
     * @param int $demand_id 企业需求id
     * @param int $effect 用途
     * @param string $information 详细介绍
     * @param int $apt_id 行业证书关系id
     * @param int $need_num 需求数量
     * @param int $is_fulltime 是否全职
     * @param int $is_tax 是否含税
     * @param float $service_charger 服务费
     * @param int $reg_info 注册情况
     * @param int $need_year 需求年数
     * @param float $need_price 需求价格
     * @param int $enter_id 企业资源id
     * @return mixed 
     */
    public function updateDemand($demand_id, $effect, $information, $apt_id, $need_num, $is_fulltime, $is_tax, $service_charger, $reg_info, $need_year, $need_price, $enter_id) {
        $relationObj = new RelationCrmProvider();
        $demandObj = new DemandCrmProvider();
        $data = array(
            'effect' => $effect,
            'information' => $information,
            'need_num' => $need_num,
            'is_fulltime' => $is_fulltime,
            'is_tax' => $is_tax,
            'service_charge' => $service_charger,
            'reg_info' => $reg_info,
            'need_year' => $need_year,
            'need_price' => $need_price,
        );
        //判断行业证书与企业资源是否存在
        if (!$relationObj->isExist('apt_id', $apt_id, 'crm_aptitude') || !$relationObj->isExist('enter_id', $enter_id, 'crm_company')
                || !$relationObj->isExist('demand_id', $demand_id, 'crm_demand')) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        } else {
            $data['apt_id'] = $apt_id;
            $data['enter_id'] = $enter_id;
        }
        //数据验证
        $data = argumentValidate(DemandCrmProvider::$demandArgRule, $data);
        if (is_zerror($data))
            return $data;
        //数据更新
        return $demandObj->updateDemand($demand_id, $data);
    }

    /**
     * 删除一条企业需求
     * @param int $cn_id 企业需求ID
     * @param boolean $full_del 是否完全删除
     * @return boolean 
     */
    public function delDemand($demand_id, $realDel = FALSE) {
        $relationObj = new RelationCrmProvider();
        if (!$relationObj->isExist('demand_id', $demand_id, 'crm_demand')) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        return $relationObj->delData('demand_id', $demand_id, 'crm_demand', $realDel);
    }

    /*     * ************************企业与企业注册人关系记录******************************************************************************************************** */

    /**
     * 添加一条企业注册人信息与企业注册人关系记录
     * @param char $name 企业注册人姓名
     * @param int $sex 性别
     * @param int $apt_id  行业资质id
     * @param int $reg_info_id 注册情况
     * @param float $employ_pay 聘用工资
     * @param int $sign_time 签约时间
     * @param int $contract_period 合同期 
     * @param int $expiration_time 到期时间
     * @param char $pay_way 付款方式
     * @param int $pay_time 付款时间
     * @param int $is_refund 是否退款
     * @param int $refund_time 退款时间
     * @param float $refund_money 退款金额
     * @param char $refund_singor 退款企业签字人
     * @param char $refund_signer 退款我方签字人
     * @param char $refund_reseaon  退款原因
     * @param int $enter_id  企业资源ID
     * @return mixed 返回注册人ID 或者 Error 
     */
    public function addRegister($name, $sex, $apt_id, $reg_info_id, $employ_pay, $sign_time, $contract_period, $expiration_time, $pay_way, $pay_time, $is_refund, $refund_time, $refund_money, $refund_singor, $refund_signer, $refund_reseaon, $enter_id) {
        //初始化关系对象
        $relationObj = new RelationCrmProvider();
        $registerObj = new RegisterCrmProvider();
        //数据组装
        $data = array(
            'name' => $name,
            'sex' => $sex,
            'employ_pay' => $employ_pay,
            'contract_period' => $contract_period,
            'pay_way' => $pay_way,
            'is_refund' => $is_refund,
            'refund_money' => $refund_money,
            'refund_singor' => $refund_singor,
            'refund_signer' => $refund_signer,
            'refund_reseaon' => $refund_reseaon,
            'sign_time' => $sign_time,
            'expiration_time' => $expiration_time,
            'refund_time' => $refund_time,
            'pay_time' => $pay_time,
            'reg_info_id' => $reg_info_id,
        );
        //判断行业证书与企业资源是否存在
        if (!$relationObj->isExist('apt_id', $apt_id, 'crm_aptitude')) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        } else {
            $data['apt_id'] = $apt_id;
            $data['enter_id'] = $enter_id;
        }
        //数据验证
        $data = argumentValidate(RegisterCrmProvider::$registerArgRule, $data);
        if (is_zerror($data))
            return $data;
        //数据入库
        $reg_id = $registerObj->addRegister($data);
        if (!$reg_id)
            E(ErrorMessage::$OPERATION_FAILED);
        if (!$relationObj->isExist('enter_id', $enter_id, 'crm_company'))
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        $regcom = array(
            'reg_id' => $reg_id,
            'enter_id' => $enter_id,
        );
        $rc_id = $relationObj->addRegcom($regcom);
        return $rc_id ? $rc_id : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 更新一条企业注册人信息与企业注册人关系记录
     * @param int $rc_id 注册人详情id
     * @param char $name 企业注册人姓名
     * @param int $sex 性别
     * @param int $apt_id  行业资质id
     * @param int $reg_info_id 注册情况
     * @param float $employ_pay 聘用工资
     * @param int $sign_time 签约时间
     * @param int $contract_period 合同期 
     * @param int $expiration_time 到期时间
     * @param char $pay_way 付款方式
     * @param int $pay_time 付款时间
     * @param int $is_refound 是否退款
     * @param int $refund_time 退款时间
     * @param float $refound_money 退款金额
     * @param char $refound_singor 退款企业签字人
     * @param char $refound_signer 退款我方签字人
     * @param char $refound_reseaon  退款原因
     * @return mixed 返回注册人ID 或者 Error 
     */
    public function updateRegister($rc_id, $name, $sex, $apt_id, $reg_info_id, $employ_pay, $sign_time, $contract_period, $expiration_time, $pay_way, $pay_time, $is_refund, $refund_time, $refund_money, $refund_singor, $refund_signer, $refund_reseaon) {
        //初始化关系对象
        $relationObj = new RelationCrmProvider();
        $registerObj = new RegisterCrmProvider();
        //判断关系
        if (!$relationObj->isExist('rc_id', $rc_id, 'crm_regcom'))
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        $row = $relationObj->getRegcom($rc_id);
        //数据组装
        $data = array(
            'name' => $name,
            'sex' => $sex,
            'employ_pay' => $employ_pay,
            'contract_period' => $contract_period,
            'pay_way' => $pay_way,
            'is_refund' => $is_refund,
            'refund_money' => $refund_money,
            'refund_singor' => $refund_singor,
            'refund_signer' => $refund_signer,
            'refund_reseaon' => $refund_reseaon,
            'sign_time' => $sign_time,
            'expiration_time' => $expiration_time,
            'refund_time' => $refund_time,
            'pay_time' => $pay_time,
            'reg_info_id' => $reg_info_id,
        );
        //判断行业证书与企业资源是否存在
        if (!$relationObj->isExist('apt_id', $apt_id, 'crm_aptitude'))
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        else
            $data['apt_id'] = $apt_id;
        //数据验证
        $data = argumentValidate(RegisterCrmProvider::$registerArgRule, $data);
        if (is_zerror($data))
            return $data;
        //数据更新
        return $registerObj->updateRegister($row['reg_id'], $data);
    }

    /**
     * 删除一条企业与注册人才关系
     * @param int $rc_id 企业与注册人关系ID
     * @param boolean $full_del 是否完全删除
     * @return boolean 
     */
    public function delRegcom($rc_id, $realDel = FALSE) {
        $relationObj = new RelationCrmProvider();
        if (!$relationObj->isExist('rc_id', $rc_id, 'crm_regcom')) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        return $relationObj->delData('rc_id', $rc_id, 'crm_regcom', $realDel);
    }

    /**
     * 邮件群发
     * @param int $enter_ids
     * @param varchar $title
     * @param var content
     * @return type 
     */
    public function sendMial($enter_ids, $title, $content) {
        $ids = explode(',', $enter_ids);
        $ids = array_filter($ids);
        if (empty($ids)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        foreach ($ids as $key => $value) {
            $result = $this->provider->sendMail($value, $title, $content);
            if ($result < 0) {
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        return TRUE;
    }

    /**
     * 企业资源基本信息完成度
     * @param int $enter_id 企业资源id
     * @return float  返回百分比
     */
    public static function comInforPercent($enter_id) {
        $relationObj = new RelationCrmProvider();
        $inArray = array('name', 'nature', 'found_time', 'brief', 'sour_id', 'site');
        $rows = $relationObj->getSpecialFields('enter_id', $enter_id, $inArray, 'crm_company');
        if ($rows) {
            return ApiCrmService::dataPercent($rows, count($inArray));
        } else {
            return '0%';
        }
    }

    /**
     * 企业资源资质情况完成度
     * @param type $enter_id 企业资源id
     * @return type 
     */
    public static function comNaturePercent($enter_id) {
        $relationObj = new RelationCrmProvider();
        $inArray = array('cn_id', 'nid');
        $rows = $relationObj->getSpecialFields('enter_id', $enter_id, $inArray, 'crm_naturecom');
        if ($rows) {
            return ApiCrmService::dataPercent($rows, count($inArray));
        } else {
            return '0%';
        }
    }

    /**
     * 企业资源联系信息完成度
     * @param int $enter_id 企业资源id
     * @return float  返回百分比
     */
    public static function comContactPercent($enter_id) {
        $relationObj = new RelationCrmProvider();
        $inArray = array('contact', 'email', 'qq', 'zipcode', 'mobile', 'phone', 'fax', 'province_id', 'city_id', 'region_id', 'address');
        $rows = $relationObj->getSpecialFields('enter_id', $enter_id, $inArray, 'crm_company');
        if ($rows) {
            return ApiCrmService::dataPercent($rows, count($inArray));
        } else {
            return '0%';
        }
    }

    /**
     * 企业资源需求信息完成度
     * @param int $enter_id 企业资源id
     * @return float  返回百分比
     */
    public static function comDemandPercent($enter_id) {
        $relationObj = new RelationCrmProvider();
        $inArray = array('apt_id', 'effect', 'information', 'need_num', 'service_charge', 'reg_info', 'need_price', 'need_year', 'is_tax', 'is_fulltime');
        $rows = $relationObj->getSpecialFields('enter_id', $enter_id, $inArray, 'crm_demand');
        if ($rows) {
            return ApiCrmService::dataPercent($rows, count($inArray));
        } else {
            return '0%';
        }
    }

    /**
     * 企业资源阶段进度完成度
     * @param type $enter_id 企业资源id
     * @return float 返回百分比 
     */
    public static function comStatusPercent($enter_id) {
        $statusObj = new StatusCrmProvider();
        $comStatus = $statusObj->getStatusById($enter_id, false);
        $row = array_pop($comStatus);
        return $row['pro_name'] ? $row['cate_name'] . ' - ' . $row['pro_name'] : $row['cate_name'];
    }

    /**
     * 企业资源注册人完成度
     * @param type $enter_id 企业资源id
     * @return float 返回百分比
     */
    public static function comRegisterPercent($enter_id) {
        $relationObj = new RelationCrmProvider();
        $inArray = array('name', 'apt_id', 'employ_pay', 'contract_period', 'pay_way', 'pay_time', 'refund_time', 'refund_singor', 'refund_reseaon', 'sex', 'sign_time', 'expiration_time', 'refund_money', 'officer', 'reg_info_id');
        $row = $relationObj->getSpecialFields('enter_id', $enter_id, $inArray, 'crm_regcom');
        $rows = $relationObj->getSpecialFields('reg_id', $row['reg_id'], $inArray, 'crm_register');
        if ($rows) {
            return ApiCrmService::dataPercent($rows, count($inArray));
        } else {
            return '0%';
        }
    }

    /**
     * 附件
     */
    public static function comAttPercent($human_id) {
        $att = new AtthumanCrmProvider();
        $inArray = array(1, 3, 4, 9);
        $count = count($inArray);
        $fen = 100 / $count;
        $percent = 0;
        foreach ($inArray as $value) {
            if ($att->spaiecalPercent($human_id, 2, $value)) {
                $percent += $fen;
            }
        }
        return $percent . "%";
    }

    /**
     * 企业csv文件导入
     * @param string $file 文件地址
     * @return boolean 
     * 00010
     */
    public function doCsv($file) {
        $result = array();
        if (!is_file($file)) {
            echo "<script type=\"text/javascript\">window.parent.resourceRender.bf(\"不是一个有效的文件!\")</script>";
            exit();
        }
        //获取不同类型的文件数组
        $dataArr = ApiCrmService::transformArray($file);
        $dataArr = $dataArr['cells'];
        $firstRow = array_shift($dataArr);
        $count_num = count($firstRow);
        foreach ($firstRow as $k => $va) {
            $firstRow[$k] = trim($va);
        }
        if (!in_array('企业名称', $firstRow)) {
            echo "<script type=\"text/javascript\">window.parent.resourceRender.bi(\"错误！无效企业资源CSV格式模板\")</script>";
            exit();
        }
        unset($firstRow);
        foreach ($dataArr as $k => $value) {
            $title = filter_chinese($$value[1]);
            if (empty($title) || count($value) != $count_num) {
                array_push($result, "第 <font color='red'>" . ($k + 1) . "</font> 条数据格式不正确 ");
                unset($value);
                continue;
            }
            $province_id = ApiCrmService::getField('dist_name', $value[9], 'crm_district', 'dist_id');
            $com_id = ApiCrmService::getField('dist_name', $value[12], 'crm_district', 'dist_id');
            $reg_id = ApiCrmService::getField('dist_name', $value[11], 'crm_district', 'dist_id');
            $cty_id = ApiCrmService::getField('dist_name', $value[10], 'crm_district', 'dist_id');
            $insertData = array(
                'name' => filter_chinese($value[1]),
                'province_id' => $province_id ? $province_id : 1,
                'contact' => filter_chinese($value[3]),
                'sour_id' => filter_chinese($value[0]),
                'community_id' => $com_id ? $com_id : 70,
                'region_id' => $reg_id ? $reg_id : 37,
                'city_id' => $cty_id ? $cty_id : 1,
                'nature' => filter_chinese($value[2]),
                'zipcode' => filter_chinese($value[14]),
                'sort' => 0,
                'site' => filter_chinese($value[15]),
                'address' => filter_chinese($value[13]),
                'qq' => filter_chinese($value[6]),
                'email' => filter_chinese($value[7]),
                'fax' => filter_chinese($value[8]),
                'phone' => filter_chinese($value[5]),
                'mobile' => filter_chinese($value[4]),
                'brief' => filter_chinese($value[17]),
                'found_time' => filter_chinese($value[16]),
                'remark' => filter_chinese($value[18]),
                'user_id' => AccountInfo::get_user_id(),
            );
            /**
             * 记录是否会有相同字段的记录信息
             * 将每条记录存于数组中，然后遍历里面的值与正在循环的值比较，如果相同则删除不添加到数据库 
             */
            if (ApiCrmService::isExist('mobile', trim($value[4]), 'crm_company', TRUE)) {
                unset($insertData);
                array_push($result, "第 <font color='red'>" . ($k + 1) . "</font> 条数据出现重复 ");
                continue;
            }
            $this->addCompanyCsv($insertData);
        }
        array_push($result, '成功导入<font>' . (count($dataArr) - count($result)) . '</font>条数据');
        return $result;
    }

}

?>
