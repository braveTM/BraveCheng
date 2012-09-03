<?php

/**
 * 人才服务提供器
 * @author YoyiorLee & brave
 */
class HumanCrmService {

    //------------private------------
    /**
     * 私有变量
     * @var type 
     */
    private $provider = null;

    //------------public-------------
    /**
     * 构造函数 
     */
    public function __construct() {
        $this->provider = new HumanCrmProvider();
    }

    /**
     * 添加人才
     * @param type $dataArr 人才数据[基本信息，聘用企业，开户行]
     * @param array $attArr 附件[附件信息]
     * @return boolean 
     */
    public function import($dataArr, $attArr, $bankArr, $certArr, $statusArr) {
        //验证字段
        $result = argumentValidate($this->provider->humanArgRule, $dataArr);
        if (is_zerror($result)) {
            return $result;
        }
        //数据字段
        $result = false;
        if (empty($result['sour_id'])) {
            $result['sour_id'] = 0; //默认来自职讯网
        }
        if (empty($result['name'])) {
            $result['sour_id'] = 0; //默认来自职讯网
        }
        $result['time'] = time();
        $result['is_delete'] = 0;
        //添加人才基本信息
        $human_id = $this->provider->add($result);
        if (!empty($human_id)) {
            return false;
        }
        //添加资质证书
        //添加开户行
        //添加身份证
        //添加阶段进度
        //添加附件
        $attProvider = new AttachmentCrmProvider();
        $attArr['human_id'] = $human_id;
        return $attProvider->addAttachment($attArr);
    }

    /**
     * 添加[交易记录]
     * @param int $human_id 人才ID
     * @param int $cat_id 阶段ID
     * @param int $pro_id 进度ID
     * @param string $notes 备注
     * @return boolean 是否添加成功（true成功，false失败） 
     */
    public function add_status($human_id, $cat_id, $pro_id, $notes) {
        $statusProvider = new StatusCrmProvider();
        //验证字段
        $data = array(
            'cat_id' => $cat_id,
            'pro_id' => $pro_id,
            'notes' => $notes,
            'human_id' => $human_id
        );
        $result = argumentValidate($statusProvider->statusArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        }
        return $statusProvider->addStatus($data);
    }

    /**
     * 添加[文件管理]
     * @param type $att_name
     * @param type $att_type_id
     * @param type $att_path
     * @param type $att_property
     * @param type $human_id
     * @param type $enter_id
     * @return type 
     */
    public function add_file($att_name, $att_type_id, $att_path, $att_property, $human_id) {
        //验证字段
        $att_name = var_validation($att_name, VAR_STRING, OPERATE_FILTER);
        $att_type_id = var_validation($att_type_id, VAR_ID);
        //......
        $att = new AttachmentCrmProvider();
        return $att->add($att_name, $att_type_id, $att_path, $att_property, $human_id);
    }

    /**
     * 更新[证书情况]（资质-职称）
     * @param type $human_id
     * @param type $apt_ids
     * @param type $title_id
     * @param type $price
     * @return type 
     */
    public function update_certificate($human_id, $apt_ids, $title_id, $price) {
        //验证字段
        $human_id = var_validation($human_id, VAR_ID);
        $apt_ids = var_validation($apt_ids, VAR_STRING, OPERATE_FILTER);
        $title_id = var_validation($title_id, VAR_ID);
        //$price = var_validation($price, VAR_ID, OPERATE_FILTER);
        //数据字段
        $data['human_id'] = $human_id;
        $data['apt_ids'] = $apt_ids;
        $data['title_id'] = $title_id;
        $result = $this->provider->update_certificate($data);
        //更新报价
        $human['price'] = $price;
        $result = $this->provider->update($human_id, $human);
        return $result;
    }

    /**
     * 更新[交易记录]（备注）
     * @param int $status_id 状态ID
     * @param string $notes 状态备注
     * @return boolean 是否更新成功(true成功，false失败)
     */
    public function update_status($status_id, $notes) {
        //验证字段
        if (!var_validation($status_id, VAR_ID)) {
            return false;
        }
        $notes = var_validation($notes, VAR_STRING, OPERATE_FILTER);
        //数据字段
        $data['status_id'] = $status_id;
        $data['notes'] = $notes;
        $statusProvider = new StatusCrmProvider();
        return $statusProvider->updateStatus($status_id, $data);
    }

    /**
     * 更新[开户行信息]
     * @param string $bank_name 开户行名称
     * @param string $bank_username 开户名
     * @param int $bank_account 开户账号
     * @return boolean 是否更新成功（true成功，false失败）
     */
    public function update_bank($bank_id, $bank_name, $bank_username, $bank_account) {
        $bankProvider = new BankCrmProvider();
        //验证字段
        $data = array(
            bank_id => $bank_id,
            bank_name => $bank_name,
            bank_username => $bank_username,
            bank_account => $bank_account,
        );
        $result = argumentValidate($bankProvider->bankArgRule, $data);
        if (is_zerror($result)) {
            return $result;
        }
        return $bankProvider->update($data);
    }

    /**
     * 更新[文件管理]
     * @param type $human_id
     * @param type $file
     * @return boolean 
     */
    public function update_file($att_id, $human_id) {
        //验证字段
        $att_id = var_validation($att_id, VAR_ID);
        $human_id = var_validation($human_id, VAR_ID);
        //文件上传
        //......
        $att_path = '/';
        //插入记录
        $data['att_id'] = $att_id;
        $data['att_path'] = $att_path;
        $att = new AttachmentCrmService();
        return $att->update($data);
        ;
    }

    /**
     * 更新[备注]
     * @param type $human_id
     * @param type $remark
     * @return type 
     */
    public function update_note($human_id, $remark) {
        //验证字段
        $human_id = var_validation($human_id, VAR_ID);
        $human_id = var_validation($human_id, VAR_STRING, OPERATE_FILTER);
        //数据字段
        $data['remark'] = $remark;
        return $this->provider->update($human_id, $data);
    }

    /**
     * 批量删除人才
     * @param type $human_ids 
     * @return boolean
     */
    public function delete_batch($human_ids) {
        //验证字段
        //执行删除
        $id_arr = explode(',', $human_ids);
        $id_arr = array_filter($id_arr);
        foreach ($id_arr as $key => $value) {
            $data['human_id'] = $value;
            $data['is_delete'] = 1;
            $ret = $this->provider->updateHuman($data);
            if ($ret < 0) {
                return E(ErrorMessage::$OPERATION_FAILED);
            }
        }
        return true;
    }

    /**
     * 获取人才信息
     * @param <int> $human_id
     * @return <mixed> 
     */
    public function get_human($human_id, $user_id) {
        //验证字段
        if (!var_validation($human_id, VAR_ID)) {
            return false;
        }
        //获取数据
        $relationObj = new RelationCrmProvider();
        $bool = $relationObj->isExist('human_id', $human_id, 'crm_human');
        if ($bool) {
            //获取基本信息，注册企业信息，开户行，备注
            $result = $this->provider->get_human($human_id, $user_id);
            //获取资质证书情况
            $result['aptitude'] = array();
            $aptitudeProvider = new AptitudeCrmProvider();
            $aptitude = $aptitudeProvider->get_aptitude_by_human($human_id);
            foreach ($aptitude as $k => $apt) {
                $relationProvider = new RelationCrmProvider();
                $relation = $relationProvider->getAptitude($apt['apt_id']);
                $result['aptitude'][$k]['apt_human_id'] = $apt['aman_id'];
                $result['aptitude'][$k]['apt_id'] = $apt['apt_id'];
                $result['aptitude'][$k]['certificate_id'] = $relation['cert_id'];
                $result['aptitude'][$k]['certificate'] = $relation['cert_name'];
                $result['aptitude'][$k]['industry_id'] = $relation['in_id'];
                $result['aptitude'][$k]['industry'] = $relation['in_name'];
                $result['aptitude'][$k]['province_id'] = $apt['province_id'];
                $result['aptitude'][$k]['province'] = $apt['province'];
                $result['aptitude'][$k]['reg_info'] = $apt['reg_info'];
                $result['aptitude'][$k]['reg_case'] = $apt['reg_case'];
            }
            //资质证书文件导入
            $certobj = new certificateCrmService();
            $result['certificate_copy'] = $certobj->get_broker_certificate_copy($human_id);
            //获取职称
            $result['title'] = array();
            $titleProvider = new TitleCrmProvider();
            $result['title'] = $titleProvider->get_title($result['tp_id']);
            //获取交易记录
            $result['status'] = array();
            $statusService = new StatusCrmProvider();
            $status = $statusService->getStatusById($human_id);
            foreach ($status as $k => $v) {
                $result['status'][$k] = $v;
            }
            //获取开户行
            $bankProvider = new BankCrmProvider();
            $bank = $bankProvider->get_by_human($human_id);
            foreach ($bank as $k => $v) {
                $result['bank'][$k] = $v;
            }
            //获取附件（文件，身份证）
            $relationProvider = new RelationCrmProvider();
            $relation = $relationProvider->getAtthumanByEnter($human_id);
            $attatchmentProvider = new AttachmentCrmProvider();
//            foreach ($relation as $k => $v) {
//                $result['attachment'] = $attatchmentProvider->getAttchmentById($v['att_id']);
//                $result['attachment']['att_human_id'] = $v['att_human_id'];
//            }

            /**
             * 企业附件信息 
             */
            $comAtt = $relationObj->getAtthumanByEnter($human_id);
            foreach ($comAtt as $k => $v) {
                $comAtt[$k]['att_info'] = $attatchmentProvider->getAttchmentById($v['att_id']);
            }
            $result['att_array'] = $comAtt;
//            
//            foreach ($relation as $k => $v) {
//                $value = $attatchmentProvider->getAttchmentById($v['att_id']);
//                $comAtts[$value['att_type_id']] = $attatchmentProvider->getAttchmentById($v['att_id']);
//            }
//            $result['att_array'] = $comAtts;
            /**
             * 信息完成度 
             */
            $result['humanInforPercent'] = $this->humanInforPercent($human_id);
            $result['humanCertPercent'] = $this->humanCertPercent($human_id);
            $result['humanStatusPercent'] = $this->humanStatusPercent($human_id);
            $result['humanRegisterPercent'] = $this->humanRegisterPercent($human_id);
            $result['humanBankPercent'] = $this->humanBankPercent($human_id);
            $result['humanAttPercent'] = $this->humanAttPercent($human_id);
            return $result;
        }
        return false;
    }

    /**
     * 获取人才总条数
     * @return int 总条数
     */
    public function get_humans_count($user_id) {
        return $this->provider->get_humans_count($user_id);
    }

    /**
     * 默认获取人才列表(分页)
     * @param int $page 当前页
     * @param int $size 页大小
     * @param string $order 排序
     * @param bool $count 总条数
     * @return array 返回集合
     */
    public function get_humans($page, $size, $user_id) {
        //验证字段
        $page = var_validation($page, VAR_PAGE, OPERATE_FILTER);
        $size = var_validation($size, VAR_SIZE, OPERATE_FILTER);
        //获取数据
        $result = $this->provider->get_humans($page, $size, $user_id);
        //获取其他信息
        foreach ($result as $key => $value) {
            //获取最后一次阶段进度及备注
            $statusService = new StatusCrmProvider();
            $status = $statusService->getStatusById($value['human_id'], true, true);
            if (!empty($status)) {
                $result[$key] = array_merge($result[$key], $status);
            }
            //资质证书文件导入
            $certobj = new certificateCrmService();
            $result[$key]['certificate_copy'] = $certobj->get_broker_certificate_copy($result[$key]['human_id']);
            //获取资质证书
            $result[$key]['aptitude'] = array();
            $aptService = new AptitudeCrmProvider();
            $aptitude = $aptService->get_aptitude_by_human($value['human_id']);
            foreach ($aptitude as $k => $apt) {
                $relationProvider = new RelationCrmProvider();
                $relation = $relationProvider->getAptitude($apt['apt_id']);
                $result[$key]['aptitude'][$k]['certificate'] = $relation['cert_name'];
                $result[$key]['aptitude'][$k]['industry'] = $relation['in_name'];
                $result[$key]['aptitude'][$k]['province_id'] = $apt['province_id'];
                $result[$key]['aptitude'][$k]['province'] = $apt['province'];
                $result[$key]['aptitude'][$k]['reg_info'] = $apt['reg_info'];
                $result[$key]['aptitude'][$k]['reg_case'] = $apt['reg_case'];
            }
            //获取职称
            $result[$key]['title'] = array();
            $titleProvider = new TitleCrmProvider();
            $result[$key]['title'] = $titleProvider->get_title($value['tp_id']);
        }
        return $result;
    }

    /**
     * 根据条件筛选
     * @param type $is_fulltime
     * @param type $source
     * @param type $region
     * @param type $cate
     * @param type $progress
     * @param type $page
     * @param type $size
     * @return type 
     */
    public function get_humans_by_filter($is_fulltime, $source, $region, $cate, $progress, $page, $size, $count = false) {
        //验证字段
        $page = var_validation($page, VAR_PAGE);
        $size = var_validation($size, VAR_SIZE);
        //获取数据
        return $this->provider->get_humans_by_filter($is_fulltime, $source, $region, $cate, $progress, $page, $size, $count = false);
    }

    /**
     * 获取资料完成进度
     * @param type $human_id
     * @return type 
     */
    public function get_complete_progress($human_id) {
        //验证字段
        if (!var_validation($human_id, VAR_ID)) {
            //基本信息-注册企业-备注完成度
            $status = $this->provider->get_base_info_complete_progress($human_id);
            //证书完成度
            $cert_status = array();
            array_merge($status, $cert_status);
            //交易记录
            $prog_status = array();
            array_merge($status, $prog_status);
            //开户行
            $bank_status = array();
            array_merge($status, $bank_status);
            //文件管理
            $file_status = array();
            array_merge($status, $file_status);
            return $status;
        }
        return false;
    }

    /**
     * 获取职称类型列表
     * @return type 
     */
    public function getTitlesType() {
        $titlesObj = new TitleCrmProvider();
        return $titlesObj->get_title_types();
    }

    /**
     * 获取指定职称类型的职称列表
     * @param type $t_id
     * @return type 
     */
    public function getTitlesByTid($t_id) {
        $titlesObj = new TitleCrmProvider();
        $rows = $titlesObj->get_title_by_type($t_id);
        return $rows;
    }

    /*     * ************************人才信息********************************************************* */

    /**
     * 添加一条人才资源数据
     * @param array $dataArr
     * @return mixed 
     */
    public function addHuman($dataArr) {
        $attObj = new AttachmentCrmProvider();
        $relationObj = new RelationCrmProvider();
        if (!is_array($dataArr)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $data = argumentValidate(HumanCrmProvider::$humanArgRule, $dataArr);
        if (is_zerror($data))
            return $data;
        //附件添加
        $att['att_type_id'] = $data['att_type_id'];
        $att['identifier'] = $data['identifier'] ? $data['identifier'] : '';
        $att = argumentValidate(AttachmentCrmProvider::$attchmentArgRule, $att);
        if (is_zerror($att))
            return $att;
        $att_id = $attObj->addAttachment($att);
        //附件添加失败
        if (!$att_id)
            return E(ErrorMessage::$OPERATION_FAILED);
        $human_id = $this->provider->addHuman($data);
        //人才添加失败
        if (!$human_id)
            return E(ErrorMessage::$OPERATION_FAILED);
        //关系添加
        $relation ['att_id'] = $att_id;
        $relation['human_id'] = $human_id;
        $relation = argumentValidate(RelationCrmProvider::$atthumanArgRule, $relation);
        if (is_zerror($att))
            return $att;
        return $relationObj->addAtthuman($relation) > 0 ? TRUE : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 简单添加一条人才信息
     * @param array $dataArr
     * @return int 
     */
    public function addHumanSimple($dataArr) {
        $relationObj = new RelationCrmProvider();
        $data = argumentValidate(HumanCrmProvider::$humanArgRule, $dataArr);
        if (is_zerror($data))
            return $data;
        if ($relationObj->isExist('name', $data['name'], 'crm_human'))
            E(ErrorMessage::$OPERATION_FAILED);
        $human_id = $this->provider->addHuman($data);
        return $human_id ? $human_id : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     *  csv文件添加数据
     * @param array $dataArr 添加的数组
     * @return mixed 成功返回id
     */
    public function addHumanCsv($dataArr) {
        $error = array(
            '1' => '手机号码重复！',
        );
        $relationObj = new RelationCrmProvider();
        $dataArr = argumentValidate(HumanCrmProvider::$humanArgRule, $dataArr);
        if (is_zerror($dataArr))
            return $dataArr->get_message();
        if ($relationObj->isExist('mobile', $dataArr['mobile'], 'crm_human'))
            return $error[1];
        return $this->provider->addHumanSim($dataArr);
    }

    /**
     * 更新一条人才信息
     * @param type $dataArr
     * @return type 
     */
    public function updateHuman($dataArr) {
        $relationObj = new RelationCrmProvider();
        if (!is_array($dataArr)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $data = argumentValidate(HumanCrmProvider::$humanArgRule, $dataArr);
        if (is_zerror($data))
            return $data;
        //人才信息不存在
        if (!$relationObj->isExist('human_id', $data['human_id'], 'crm_human'))
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        //更新人才信息
        return $this->provider->updateHuman($data) >= 0 ? TRUE : E(ErrorMessage::$OPERATION_FAILED);
    }

    /*     * ************************人才与证书行业关系********************************************************* */

    /**
     * 添加一条人才、证书、行业关系记录
     * @param array $data
     * array(
     *       'apt_id',
     *       'human_id',
     *       'reg_info',
     *       'province_id',
     *   )
     * @return mixed 
     */
    public function addApthuman($data) {
        $relationObj = new RelationCrmProvider();
        //数据验证
        $data = argumentValidate(RelationCrmProvider::$atthumanArgRule, $data);
        if (is_zerror($data))
            return $data;
        //判断关系是否存在
        if (!$relationObj->isExist('human_id', $data['human_id'], 'crm_human') ||
                !$relationObj->isExist('apt_id', $data['apt_id'], 'crm_aptitude'))
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        //数据入库
        $result = $relationObj->addApthuman($data);
        return $result > 0 ? $result : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 添加一条人才、证书、行业关系记录
     * @param array $data
     * array(
     *       'aman_id'
     *       'apt_id',
     *       'human_id',
     *       'reg_info',
     *       'province_id',
     *   )
     * @return mixed 
     */
    public function updateApthuman($data) {
        $relationObj = new RelationCrmProvider();
        //数据验证
        $data = argumentValidate(RelationCrmProvider::$atthumanArgRule, $data);
        if (is_zerror($data))
            return $data;
        //判断关系是否存在
        if (!$relationObj->isExist('human_id', $data['human_id'], 'crm_human') ||
                !$relationObj->isExist('apt_id', $data['apt_id'], 'crm_aptitude') ||
                !$relationObj->isExist('aman_id', $data['aman_id'], 'crm_apt_human'))
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        //数据更新
        return $relationObj->updateApthuman($data) ? TRUE : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 删除一条人才 证书 行业关系
     * @param int $aman_id
     * @param boolean $realDel
     * @return boolean 
     */
    public function deleteApthuman($aman_id, $realDel = FALSE) {
        $relationObj = new RelationCrmProvider();
        if (!$relationObj->isExist('aman_id', $aman_id, 'crm_apt_human')) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        return $relationObj->delData('aman_id', $aman_id, 'crm_apt_human', $realDel);
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
     * 人才资源基本信息完成度
     * @param int $human_id 人才资源id
     * @return float  返回百分比
     */
    public static function humanInforPercent($human_id) {
        $relationObj = new RelationCrmProvider();
        $inArray = array('name', 'sex', 'mobile', 'phone', 'email', 'qq', 'province_id', 'city_id', 'region_id', 'sour_id', 'birthday', 'fax', 'postcode');
        $rows = $relationObj->getSpecialFields('human_id', $human_id, $inArray, 'crm_human');

        if ($rows) {
            return ApiCrmService::dataPercent($rows, count($inArray));
        } else {
            return '0%';
        }
    }

    /**
     * 人才资源基本信息完成度
     * @param int $human_id 企业资源id
     * @return float  返回百分比
     */
    public static function humanCertPercent($human_id) {
        $relationObj = new RelationCrmProvider();
        $inArray = array('tp_id', 'tp_level');
        $rows = $relationObj->getSpecialFields('human_id', $human_id, $inArray, 'crm_human');
        if ($rows) {
            return ApiCrmService::dataPercent($rows, count($inArray));
        } else {
            return '0%';
        }
    }

    /**
     * 人才资源阶段进度完成度
     * @param type $enter_id 人才资源id
     * @return float 返回百分比 
     */
    public static function humanStatusPercent($human_id) {
        $statusObj = new StatusCrmProvider();
        $comStatus = $statusObj->getStatusById($human_id);
        $row = array_pop($comStatus);
        return $row['pro_name'] ? $row['cate_name'] . ' - ' . $row['pro_name'] : $row['cate_name'];
    }

    /**
     * 人才资源注册企业完成度
     * @param type $enter_id 人才资源id
     * @return float 返回百分比 
     */
    public static function humanRegisterPercent($human_id) {
        $relationObj = new RelationCrmProvider();
        $inArray = array('employ_name', 'employ_charger', 'employ_sign_time', 'employ_payment', 'employ_location', 'employ_pay', 'employ_contract', 'employ_pay_time');
        $rows = $relationObj->getSpecialFields('human_id', $human_id, $inArray, 'crm_human');
        if ($rows) {
            return ApiCrmService::dataPercent($rows, count($inArray));
        } else {
            return '0%';
        }
    }

    /**
     * 人才资源阶段进度完成度
     * @param type $enter_id 人才资源id
     * @return float 返回百分比 
     */
    public static function humanBankPercent($human_id) {
        $relationObj = new RelationCrmProvider();
        $inArray = array('bank_name', 'bank_account', 'bank_username');
        $rows = $relationObj->getSpecialFields('human_id', $human_id, $inArray, 'crm_bank');
        if ($rows) {
            return ApiCrmService::dataPercent($rows, count($inArray));
        } else {
            return '0%';
        }
    }

    /**
     * 备注 
     */
    public static function humanAttPercent($human_id) {
        $att = new AtthumanCrmProvider();
        $inArray = array(1, 3, 4, 9);
        $count = count($inArray);
        $fen = 100 / $count;
        $percent = 0;
        foreach ($inArray as $value) {
            if ($att->spaiecalPercent($human_id, 1, $value)) {
                $percent += $fen;
            }
        }
        return $percent . "%";
    }

    /**
     * 人才csv文件导入
     * @param string $file 文件地址
     * @return boolean 
     */
    public function doCsv($file) {
        $result = array();
        if (!is_file($file)) {
            echo "<script type=\"text/javascript\">window.parent.resourceRender.bf(\"不是一个有效的文件!\")</script>";
            exit();
        }
        //获取不同类型的文件数组
        $dataArr = ApiCrmService::transformArray($file);
        $firstRow = array_shift($dataArr);
        $count_num = count($firstRow);
        foreach ($firstRow as $k => $va) {
            $firstRow[$k] = trim($va);
        }
        if (!in_array('生日', $firstRow)) {
            echo "<script type=\"text/javascript\">window.parent.resourceRender.bf(\"错误！无效人才资源CSV格式模板\")</script>";
            exit();
        }
        unset($firstRow);
        foreach ($dataArr as $k => $v) {
            $title = filter_chinese($v[2]);
            if (empty($title) || count($v) != $count_num) {
                array_push($result, "第 <font color='red'>" . ($k + 1) . "</font> 条数据格式不正确 ");
                unset($v);
                continue;
            }
            /**
             * 人才数据库 
             */
            $province_id = ApiCrmService::getField('dist_name', $v[26], 'crm_district', 'dist_id');
            $com_id = ApiCrmService::getField('dist_name', $v[29], 'crm_district', 'dist_id');
            $reg_id = ApiCrmService::getField('dist_name', $v[28], 'crm_district', 'dist_id');
            $cty_id = ApiCrmService::getField('dist_name', $v[27], 'crm_district', 'dist_id');
            $tp_id = ApiCrmService::getField('tp_name', $v[13], 'crm_titles', 'tp_id');
            $doc_type = ApiCrmService::getField('att_type_name', $v[14], 'crm_att_type', 'att_type_id');
            $insertData = array(
                'sour_id' => $v[0] ? intval($v[0]) : 1,
                'province_id' => $province_id ? $province_id : 1,
                'sex' => is_int($v[3]) > 1 ? 0 : intval($v[3]),
                'is_fulltime' => is_int($v[1]) ? intval($v[1]) : 0,
                'community_id' => $com_id ? $com_id : 70,
                'region_id' => $reg_id ? $reg_id : 37,
                'city_id' => $cty_id ? $cty_id : 1,
                'fax' => $v[8] ? filter_chinese($v[8]) : '',
                'quote' => $v[14] ? $v[16] : 0,
                'sort' => 0,
                'tp_id' => $tp_id ? $tp_id : 0,
                'employ_pay_time' => $v[19] ? filter_chinese($v[19]) : '0000-00-00',
                'employ_payment' => $v[20] ? filter_chinese($v[20]) : '',
                'employ_expr_time' => $v[21] ? filter_chinese($v[21]) : '0000-00-00',
                'employ_contract' => $v[22] ? filter_chinese($v[22]) : 0,
                'employ_sign_time' => $v[23] ? filter_chinese($v[23]) : '0000-00-00',
                'employ_pay' => $v[18] ? filter_chinese($v[18]) : 0,
                'employ_charger' => $v[24] ? filter_chinese($v[24]) : '',
                'employ_location' => $v[25] ? filter_chinese($v[25]) : '',
                'employ_name' => $v[17] ? filter_chinese($v[17]) : '',
                'remark' => $v[31] ? filter_chinese($v[31]) : '',
                'address' => filter_chinese($v[30]),
                'name' => filter_chinese($v[2]),
                'birthday' => $v[10] ? $v[10] : '0000-00-00',
                'postcode' => filter_chinese($v[9]),
                'phone' => filter_chinese($v[5]),
                'qq' => filter_chinese($v[6]),
                'email' => filter_chinese($v[7]),
                'mobile' => filter_chinese($v[4]),
                'tp_level' => $v[12] > 3 ? 1 : $v[12],
                'user_id' => AccountInfo::get_user_id(),
                'doc_type' => $doc_type ? $doc_type : 1,
                'doc_number' => filter_chinese($v[15]),
            );
            /**
             * 记录是否会有相同字段的记录信息
             * 将每条记录存于数组中，然后遍历里面的值与正在循环的值比较，如果相同则删除不添加到数据库 
             */
            if (ApiCrmService::isExist('mobile', trim(filter_chinese($v[4])), 'crm_human', TRUE)) {
                unset($insertData);
                array_push($result, "第 <font color='red'>" . ($k + 1) . "</font> 条数据出现重复 ");
                continue;
            }
            //插入一条人才信息
            $human_id = $this->addHumanCsv($insertData);
            /**
             * 人才与证书行业关系  
             */
            $relation = explode(';', strtr(substr($v[11], 0, -1), array("；" => ";", ";" => ';')));
            if (is_array($relation)) {
                foreach ($relation as $value) {
                    $values = explode('-', $value);
                    if (count($values) == 4) {
                        $cert_id = ApiCrmService::getField('cert_name', $values[0], 'crm_certificate', 'cert_id');
                        $in_id = ApiCrmService::getField('in_name', $values[1], 'crm_industry', 'in_id');
                        $row['reg_info'] = $values[2];
                        $row['province_id'] = ApiCrmService::getField('dist_name', $values[3], 'crm_district', 'dist_id');
                        $aptid = ApiCrmService::getAptId($cert_id, $in_id);
                        if (is_numeric($aptid)) {
                            $row['apt_id'] = $aptid;
                            $row['human_id'] = $human_id;
                            ApiCrmService::addAptHuamn($row);
                        }
                    } else {
                        $cert_id = ApiCrmService::getField('cert_name', $values[0], 'crm_certificate', 'cert_id');
                        $in_id = 0;
                        $row['reg_info'] = $values[1];
                        $row['province_id'] = ApiCrmService::getField('dist_name', $values[2], 'crm_district', 'dist_id');
                        $aptid = ApiCrmService::getAptId($cert_id, $in_id);
                        if (is_numeric($aptid)) {
                            $row['apt_id'] = $aptid;
                            $row['human_id'] = $human_id;
                            ApiCrmService::addAptHuamn($row);
                        }
                    }
                }
            }
        }
        array_push($result, '成功导入<font>' . (count($dataArr) - count($result)) . '</font>条数据');
        return $result;
    }

    /*     * *******************************************升级数据导入接口 ******************************************** */

    /**
     * 新excel格式文件导入接口
     * @param string $filename 文件路径
     */
    function build_file($filename = '', $compnay = FALSE) {
        if (!is_file($filename)) {
            echo "<script type=\"text/javascript\">window.parent.resourceRender.bf(\"不是一个有效的文件!\")</script>";
            exit();
        }
        $dataArr = ApiCrmService::transformArray($filename);
        foreach ($dataArr as $key => $array) {
            $msg[$key] = $this->build_data($array['cells'], $compnay);
        }
        return $msg;
    }

    /**
     * 数据组装
     * @param array $array 需要组装的数据 
     * @param type $company  是否是企业资源
     * @return array 成功或错误消息
     */
    function build_data($array = array(), $company = false) {
        $result = $count = array();
        $data = array_map('trim', array_shift($array));
        if ($company) {
            if (!in_array('企业名称', $data))
                return $result = array("<font color='red'>导入失败！无效企业资源格式文件</font>");
            $c_service = new CompanyCrmService();
            foreach ($array as $k => $value) {
                $boolean = $c_service->addCompanyCsv($this->build_company_data(array_flip($data), $value));
                if (is_string($boolean)) {
                    $result[$boolean][] = $k + 1;
                    array_push($count, ($k + 1));
                }
            }
        } else {
            if (!in_array('生日', $data))
                return $result = array("<font color='red'>导入失败！无效人才资源格式文件</font>");
            foreach ($array as $k => $value) {
                $boolean = $this->addHumanCsv($this->build_human_data(array_flip($data), $value));
                if (is_string($boolean)) {
                    $result[$boolean][] = $k + 1;
                    array_push($count, ($k + 1));
                }
                if (is_int($boolean)) {
                    $cert = new certificateCrmService();
                    $certificate = $this->build_certificate(array_flip($data), $value);
                    $certificate_copy = FALSE !== strpos($certificate, ';') ? array_filter(explode(';', $certificate)) : $certificate;
                    if (is_array($certificate_copy)) {
                        foreach ($certificate_copy as $val) {
                            $cert_data = array(
                                'user_id' => $boolean,
                                'certificate_copy_name' => $val,
                            );
                            $cert->add_certificate_copy($cert_data);
                        }
                    } else {
                        $cert_data = array(
                            'user_id' => $boolean,
                            'certificate_copy_name' => $certificate_copy,
                        );
                        $cert->add_certificate_copy($cert_data);
                    }
                }
            }
        }
        return array('1' => $result, '2' => array(1 => (count($array) - count($count)), 2 => count($count)));
    }

    /**
     * excel格式与数据库字段接口数据转换
     * @param array $index_array excel描述数组
     * @param array $value_array 真实数据数组
     * @return array 转换后的数据 
     */
    function build_human_data($index_array = array(), $value_array = array()) {
        $province_id = ApiCrmService::getField('dist_name', $value_array[$index_array['省']], 'crm_district', 'dist_id');
        $community_id = ApiCrmService::getField('dist_name', $value_array[$index_array['镇']], 'crm_district', 'dist_id');
        $region_id = ApiCrmService::getField('dist_name', $value_array[$index_array['区']], 'crm_district', 'dist_id');
        $city_id = ApiCrmService::getField('dist_name', $value_array[$index_array['市']], 'crm_district', 'dist_id');
        $tp_id = ApiCrmService::getField('tp_name', $value_array[$index_array['职称专业']], 'crm_titles', 'tp_id');
        $doc_type = ApiCrmService::getField('att_type_name', $value_array[$index_array['证件类型']], 'crm_att_type', 'att_type_id');
        return array(
            'sour_id' => (int) $value_array[$index_array['来源ID']],
            'province_id' => is_int($province_id) ? $province_id : 0,
            'sex' => (int) $value_array[$index_array['性别']],
            'is_fulltime' => is_int($value_array[$index_array['职位']]) ? $value_array[$index_array['职位']] : 0,
            'community_id' => is_int($community_id) ? $community_id : 0,
            'region_id' => is_int($region_id) ? $region_id : 0,
            'city_id' => is_int($city_id) ? $city_id : 0,
            'fax' => $value_array[$index_array['传真']] ? $value_array[$index_array['传真']] : '',
            'quote' => $value_array[$index_array['经纪人给人才报价']] ? $value_array[$index_array['经纪人给人才报价']] : 0,
            'sort' => 0,
            'tp_id' => is_int($tp_id) ? $tp_id : 0,
            'employ_pay_time' => $value_array[$index_array['付款时间']] ? $value_array[$index_array['付款时间']] : '0000-00-00',
            'employ_payment' => $value_array[$index_array['付款方式']] ? $value_array[$index_array['付款方式']] : '',
            'employ_expr_time' => $value_array[$index_array['到期时间']] ? $value_array[$index_array['到期时间']] : "0000-00-00",
            'employ_contract' => $value_array[$index_array['合同期']] ? $value_array[$index_array['合同期']] : '',
            'employ_sign_time' => $value_array[$index_array['签约时间']] ? $value_array[$index_array['签约时间']] : '0000-00-00',
            'employ_pay' => $value_array[$index_array['聘用工资']] ? $value_array[$index_array['聘用工资']] : 0,
            'employ_charger' => $value_array[$index_array['聘用单位联系人']] ? $value_array[$index_array['聘用单位联系人']] : '',
            'employ_location' => $value_array[$index_array['聘用单位所在地']] ? $value_array[$index_array['聘用单位所在地']] : '',
            'employ_name' => $value_array[$index_array['聘用单位名称']] ? $value_array[$index_array['聘用单位名称']] : '',
            'remark' => $value_array[$index_array['备注']] ? $value_array[$index_array['备注']] : '',
            'address' => $value_array[$index_array['联系详细地址']] ? $value_array[$index_array['联系详细地址']] : '',
            'name' => $value_array[$index_array['姓名']] ? $value_array[$index_array['姓名']] : '',
            'birthday' => $value_array[$index_array['生日']] ? $value_array[$index_array['生日']] : '',
            'postcode' => $value_array[$index_array['邮编']] ? $value_array[$index_array['邮编']] : '',
            'phone' => $value_array[$index_array['座机']] ? $value_array[$index_array['座机']] : '',
            'qq' => $value_array[$index_array['QQ']] ? $value_array[$index_array['QQ']] : 0,
            'email' => $value_array[$index_array['邮箱']] ? $value_array[$index_array['邮箱']] : '',
            'mobile' => $value_array[$index_array['手机']] ? $value_array[$index_array['手机']] : '',
            'tp_level' => $value_array[$index_array['职称等级']] ? $value_array[$index_array['职称等级']] : 0,
            'user_id' => AccountInfo::get_user_id(),
            'doc_type' => is_int($doc_type) ? $doc_type : 1,
            'doc_number' => $value_array[$index_array['证件号码']] ? $value_array[$index_array['证件号码']] : 0,
        );
    }

    /**
     * 资质证书格式与数据库字段接口数据转换
     * @param array $index_array excel描述数组
     * @param array $value_array 真实数据数组
     * @return array 转换后的数据 
     */
    public function build_certificate($index_array = array(), $value_array = array()) {
        return $value_array[$index_array['资质证书']] ? strtr($value_array[$index_array['资质证书']], array('；' => ';')) : '';
    }

    /**
     * 企业excel格式与数据库字段接口数据转换
      @param array $index_array excel描述数组
     * @param array $value_array 真实数据数组
     * @return array 转换后的数据 
     */
    public function build_company_data($index_array = array(), $value_array = array()) {
        $province_id = ApiCrmService::getField('dist_name', $value_array[$index_array['省']], 'crm_district', 'dist_id');
        $community_id = ApiCrmService::getField('dist_name', $value_array[$index_array['镇']], 'crm_district', 'dist_id');
        $region_id = ApiCrmService::getField('dist_name', $value_array[$index_array['区']], 'crm_district', 'dist_id');
        $city_id = ApiCrmService::getField('dist_name', $value_array[$index_array['市']], 'crm_district', 'dist_id');
        return array(
            'name' => $value_array[$index_array['企业名称']],
            'province_id' => is_int($province_id) ? $province_id : 0,
            'contact' => $value_array[$index_array['企业联系人']],
            'sour_id' => $value_array[$index_array['来源ID']],
            'community_id' => is_int($community_id) ? $community_id : 0,
            'region_id' => is_int($region_id) ? $region_id : 0,
            'city_id' => is_int($city_id) ? $city_id : 0,
            'nature' => $value_array[$index_array['企业性质']],
            'zipcode' => $value_array[$index_array['邮编']],
            'sort' => 0,
            'site' => $value_array[$index_array['网址']],
            'address' => $value_array[$index_array['详细地址']],
            'qq' => $value_array[$index_array['QQ']],
            'email' => $value_array[$index_array['email']],
            'fax' => $value_array[$index_array['传真']],
            'phone' => $value_array[$index_array['座机']],
            'mobile' => $value_array[$index_array['手机']],
            'brief' => $value_array[$index_array['简介']],
            'found_time' => $value_array[$index_array['成立时间']],
            'remark' => $value_array[$index_array['备注']],
            'user_id' => AccountInfo::get_user_id(),
        );
    }

}

?>
