<?php

/**
 * 接口服务
 * @author YoyiorLee
 */
class ApiCrmService {

    public static $cfulltime = array(
        0 => 0, //不限
        1 => 2, //全职=>兼职
        2 => 1, //兼职=>全职
    );

    /**
     * （经纪人）发布职位|（企业）委托职位 后将企业资源导入到CRM
     * @param int $job_id 职位ID
     * @param int $user_id 用户ID
     * @param int $company_id 企业ID 如果为企业委托，则穿企业company_id
     * @return array('enter_id','demand_id')
     */
    public function importCompany($job_id, $user_id, $company_id = 0) {
        if (empty($job_id)) {
            return FALSE;
        }
        //企业职位=企业需求
        $job_service = new JobService();
        $job_info = $job_service->get_job($job_id);
        //判断是否存在该企业
        $relation = new RelationCrmProvider();
        $bool = $relation->isExist('name', $job_info['company_name'], 'crm_company');
        //创建CRM企业服务
        $company_crm_service = new CompanyCrmService();
        //组装企业需求
        $certificate_service = new CertificateService();
        $certificate_arr = $certificate_service->getRegisterCertificateListByJob($job_id);
        foreach ($certificate_arr as $value) {
            $certificate = $value;
        }
        $is_fulltime = self::$cfulltime[$job_info['job_category']]; //转化 兼职/全职
        //不存在企业在就创建企业
        if (empty($bool)) {
            $dataArr = array(
                'name' => $job_info['company_name'], //企业名称
                'user_id' => $user_id, //用户名
                'sour_id' => 1, //来源
                'found_time' => $job_info['company_regtime'],
                'nature' => $job_info['company_category'], //企业性质
                'brief' => $job_info['company_introduce'], //简介 
            );
            //组装企业基本信息
            if (!empty($company_id)) {
                $company_service = new CompanyService();
                $company_info = $company_service->get_company($company_id);
                $district = new DistrictCrmService();
                $province = $district->get_district_by_code($company_info['company_province_code']);
                $city = $district->get_district_by_code($company_info['company_city_code']);
                $tempArr = array(
                    'province_id' => $province['province_id'], //省ID
                    'city_id' => $city['city_id'], //市ID
                    'contact' => $company_info['contact_name'], //联系人
                    'qq' => $company_info['contact_qq'], //QQ
                    'mobile' => $company_info['contact_mobile'], //mobile
                    'email' => $company_info['contact_email'], //email
                );
                $dataArr = array_merge($dataArr, $tempArr);
            }
            //添加一个企业
            $enter_id = $company_crm_service->addCompany($dataArr);
            if (empty($enter_id)) {
                return false;
            }
            $salary = $job_info['input_salary'] ? $job_info['input_salary'] : 0;
            $company_crm_service->addNatureByEnterId($enter_id, $job_info['company_qualification']);
            $demand_id = $company_crm_service->addDemand(1, $job_info['job_describle'], $certificate['certificate_id'], $certificate['count'], $is_fulltime, 0, '10.00', $certificate['status'], 1, $salary, $enter_id);
            return array(
                'enter_id' => $enter_id,
                'demand_id' => $demand_id
            );
        }
        $enter = $relation->getFields('name', $job_info['company_name'], 'crm_company');
        //已存在企业就更新（更新企业基本细信息，更新企业信息需求信息）
        $demand_id = $company_crm_service->addDemand(1, $job_info['job_describle'], $certificate['certificate_id'], $certificate['count'], $is_fulltime, 0, '10.00', $certificate['status'], 1, $job_info['job_salary'], $enter['enter_id']);
        return array(
            'enter_id' => $enter_id,
            'demand_id' => $demand_id
        );
    }

    /**
     * 
     * @param array $data  
     * array(
     *       'human', 职讯人才id
     *       'user_id' 经纪人id
     *       )  
     */
    public static function importHuman($data) {
        if (empty($data))
            return FALSE;
        //人才基本信息
        $human = self::getInstance('HumanService')->get_human($data['human']);
        //人才资质证书列表
        $humanCert = self::getInstance('CertificateService')->getRegisterCertificateListByHuman($data['human']);
        //人才职称证列表
        $humanTitles = self::getInstance('CertificateService')->getGradeCertificateListByHuman($data['human']);
        $treatment = self::getInstance('ResumeService')->getHCintent($human['resume_id']);
        $data['quote'] = $treatment['job_salary'] ? $treatment['job_salary'] : 0;
        foreach ($humanTitles as $value) {
            $humanTitle = $value;
        }
        unset($value);
        /**
         * 接口数组
         * 1、去掉职讯平台的工作年限work_age
         * 2、去掉职讯凭条的certificate_remark
         */
        /** #人才基本信息#  */
        if (self::isExist('mobile', $human['contact_mobile'], 'crm_human')) {
            return FALSE;
        };
        $data['user_id'] = $data['user_id']; //经纪人id
        $data['name'] = $human['name']; //姓名
        $data['sex'] = $human['gender'] == 1 ? 0 : 1; //性别
        $data['sour_id'] = 1; //来自职讯网
        $data['birthday'] = $human['birthday']; //生日
        $data['doc_type'] = 1; //默认初始化为身份证类型
        $data['doc_number'] = empty($human['identity_card']) ? '' : trim($human['identity_card']); //身份证号码
        $province = self::getInstance('DistrictCrmService')->get_district_by_code($human['province_code']); //转换为省id
        $city = self::getInstance('DistrictCrmService')->get_district_by_code($human['city_code']); //转化为市id
        $data['city_id'] = $city['dist_id'] ? $city['dist_id'] : 0;
        $data['province_id'] = $province['dist_id'] ? $province['dist_id'] : 0;
        $data['qq'] = $human['contact_qq']; //qq
        $data['mobile'] = $human['contact_mobile']; //mobile
        $data['email'] = $human['contact_email']; //email
        if ($humanTitle) {
            $data['tp_level'] = $humanTitle['grade_certificate_class']; //职称等级
            $data['tp_id'] = $humanTitle['grade_certificate_id']; //职称id
        } else {
            $data['tp_level'] = 0; //职称等级
            $data['tp_id'] = 0; //职称id
        }
        $data['employ_pay_time'] = '0000-00-00';
        $data['employ_expr_time'] = '0000-00-00';
        $data['employ_sign_time'] = '0000-00-00';
        if (!self::getInstance('HumanCrmService')->addHumanSimple($data))
            return FALSE;
        //获取该名称的id
        $human_row = self::getInstance('RelationCrmProvider')->getFields('name', $human['name'], 'crm_human', 'human_id');
        if (!$human_id = $human_row['human_id'])
            return FALSE;
        //人才证书行业关系
        foreach ($humanCert as $v) {
            $province_id = self::getInstance('DistrictCrmService')->get_district_by_code($v['register_place']); //转换为省id
            $aptHuman = array(
                'apt_id' => $v['register_certificate_id'],
                'human_id' => $human_id,
                'reg_info' => $v['class'] + 1,
                'province_id' => $province_id['dist_id'] ? $province_id['dist_id'] : 0,
            );
            if (!self::getInstance('HumanCrmService')->addApthuman($aptHuman))
                return FALSE;
        }
        return TRUE;
    }

    /**
     * 实例化接口
     * @param type $name
     * @param type $config
     * @return \name 
     */
    public static function getInstance($name, $config = null) {
        return new $name($config);
    }

    /**
     *  数据转换 
     * @author brave 
     */
    public static function getzxCity($page, $pageSize) {
        //更新城市code
        /**
          $cityList = self::getInstance('CityProvider')->getList($page, $pageSize);
          foreach ($cityList as $value) {
          $rec = self::getcrmCityRow($value['name']);
          $data = array(
          'dist_id' => $rec['dist_id'],
          'code' => $value['code'],
          );
          self::updatecrmCityRow($data);
          }
         */
        //更新省份操作接口
        /**
          $province = self::getInstance('CityProvider')->get_province_list();
          foreach ($province as $value) {
          $rec = self::getcrmCityRow($value['name']);
          $data = array(
          'dist_id' => $rec['dist_id'],
          'code' => $value['code'],
          );
          self::updatecrmCityRow($data);
          }
         */
    }

    public static function getcrmCityRow($name) {
        return ObjectPool::getObj('DistrictCrmProvider')->getList($name);
    }

    public static function updatecrmCityRow($data) {
        ObjectPool::getObj('DistrictCrmProvider')->update($data);
    }

    /**
     * 获取指定字段的值 
     * @param  string $fieldName字段名称
     * @param string $fieldValue 字段值
     * @param string $table 表名
     * @param string $getField 需要获取的字段值
     * @return string  返回字段值
     */
    public static function getField($fieldName, $fieldValue, $table, $getField) {
        $row = ObjectPool::getObj('RelationCrmProvider')->getLikeFields($fieldName, $fieldValue, $table, $getField);
        return $row[$getField];
    }

    /**
     * 获取字段的信息
     * @param string $fieldName 字段名称
     * @param string $fieldValue 字段值
     * @param string $getField 需要查询的字段
     * @param string $table 表名
     * @return mixed  返回需要查询的字段
     */
    public static function getNeedFields($fieldName, $fieldValue, $table, $getField = '*') {
        return ObjectPool::getObj('RelationCrmProvider')->getNeedFields($fieldName, $fieldValue, $table, $getField);
    }

    /**
     * 读取csv文件,转换为数组
     * @param string $filename csv文件路劲
     * @return array 返回csv数组
     */
    public static function getCsvArray($filename) {
        $csv = importInstance('csv');
        $csv->setFileName($filename);
        return $csv->getRecord();
    }

    /**
     * 读取excel文件，并转换为数组
     * @param string $filename excel文件路径
     * @return array 返回excel数组
     */
    public static function getExcelArray($filename) {
        $arg = array();
        $excel = importInstance('Excel');
        $excel->setOutputEncoding('UTF-8');
        $excel->read($filename);
        return $excel->sheets;
//        foreach ($excel->sheets[0]['cells'] as $key => $value) {
//            $arg[$key] = array_values($value);
//        }
//        return $arg;
    }

    /**
     * 获取文件后缀,并且读取不同的文件获取数组
     * @param string $file 文件名称 
     * @return array 返回不同类型的数组 
     */
    public static function transformArray($file) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        switch ($extension) {
            case 'csv':
                $dataArr = self::getCsvArray($file);
                break;
            case 'xls':
                $dataArr = self::getExcelArray($file);
                break;
            default:
                break;
        }
        return $dataArr;
    }

    /**
     * 读取百分比函数
     * @param array $array 需要判断的数据字段
     * @param type $table 表名
     * @return mixed 
     */
    public static function dataPercent($array, $total) {
        $i = 0;
        if (!is_array($array))
            return E(ErrorMessage::$OPERATION_FAILED);
        foreach ($array as $value) {
            if (strlen($value))
                $i++;
        }
        return round(($i / $total) * 100) . '%';
    }

    /**
     * 人才条件查询数据
     * @param array $condition 条件数组
     * @param int $page 页数
     * @param int $size 每页大小
     * @param string $table 条件表
     * @param string $prefix 条件表前缀
     * @param string $order 排序条件
     * @return array  返回搜索记录结果
     */
    public static function humanWhereData($condition, $page, $size, $table, $prefix, $order) {
        $rows = ObjectPool::getObj('RelationCrmProvider')->getWhereList($condition, $page, $size, $table, $prefix, $order);
        foreach ($rows as $key => $value) {
            if (array_key_exists('status_id', $value)) {
                //如果条件中包含阶段进度信息
                $rows[$key]['status'] = ObjectPool::getObj('StatusCrmService')->getStatusById($value['status_id']);
            } else {
                //如果条件中不包含阶段进度信息,默认根据人才读取最新一条阶段进度信息
                $rows[$key]['status'] = ObjectPool::getObj('StatusCrmService')->getStatusRows($value['human_id'], TRUE);
            }
            //人才资质证书修改
            $rows[$key]['aptitude'] = ObjectPool::getObj('AptitudeCrmProvider')->get_aptitude_by_human($value['human_id']);
            foreach ($rows[$key]['aptitude'] as $k => $apt) {
                $relation = ObjectPool::getObj('RelationCrmProvider')->getAptitude($apt['apt_id']);
                $rows[$key]['aptitude'][$k]['apt_human_id'] = $apt['aman_id'];
                $rows[$key]['aptitude'][$k]['apt_id'] = $apt['apt_id'];
                $rows[$key]['aptitude'][$k]['certificate_id'] = $relation['cert_id'];
                $rows[$key]['aptitude'][$k]['certificate'] = $relation['cert_name'];
                $rows[$key]['aptitude'][$k]['industry_id'] = $relation['in_id'];
                $rows[$key]['aptitude'][$k]['industry'] = $relation['in_name'];
                $rows[$key]['aptitude'][$k]['province_id'] = $apt['province_id'];
                $rows[$key]['aptitude'][$k]['province'] = $apt['province'];
                $rows[$key]['aptitude'][$k]['reg_info'] = $apt['reg_info'];
                $rows[$key]['aptitude'][$k]['reg_case'] = $apt['reg_case'];
            }
            $rows[$key]['titles'] = ObjectPool::getObj('TitleCrmProvider')->get_title($value['tp_id']);
            $rows[$key]['tp_level_name'] = HumanCrmProvider::$titlelevel[$value['tp_level']];
            $rows[$key]['fulltime'] = HumanCrmProvider::$fulltime[$value['is_fulltime']];
            $pro = ObjectPool::getObj('RelationCrmProvider')->getSpecialFields('dist_id', $value['province_id'], 'dist_name', 'crm_district');
            $rows[$key]['province'] = $pro['dist_name'];
            $rows[$key]['apt_reginfo'] = AptitudeCrmProvider::$reginfo[$value['reg_info']];
        }
        return $rows;
    }

    /**
     * 获取条件记录
     * @param array $condition 条件数组
     * @param int $page 页数
     * @param int $size 每页大小
     * @param string $table 条件表
     * @param string $prefix 条件表前缀
     * @param string $order 排序条件
     * @return array  返回搜索记录结果
     */
    public static function getWhereCount($condition, $page, $size, $table, $prefix, $indexId, $count) {
        return ObjectPool::getObj('RelationCrmProvider')->getWhereList($condition, $page, $size, $table, $prefix, $indexId, $count);
    }

    /**
     *
     * 人才条件查询数据
     * @param array $condition 条件数组
     * @param int $page 页数
     * @param int $size 每页大小
     * @param string $table 条件表
     * @param string $prefix 条件表前缀
     * @param string $order 排序条件
     * @return array  返回搜索记录结果
     */
    public static function companyWhereData($condition, $page, $size, $table, $prefix, $order) {
        $rows = ObjectPool::getObj('RelationCrmProvider')->getWhereList($condition, $page, $size, $table, $prefix, $order);
        foreach ($rows as $key => $value) {
            /**
             * 省 
             */
            $pro = ObjectPool::getObj('RelationCrmProvider')->getSpecialFields('dist_id', $value['province_id'], 'dist_name', 'crm_district');
            $rows[$key]['province'] = $pro['dist_name'];
            /**
             * 企业需求
             */
            $comDemand = ObjectPool::getObj('DemandCrmProvider')->getCompanyDemand($value['enter_id']);
            //企业需求行业证书
            foreach ($comDemand as $k => $v) {
                $comDemand[$k]['demand_apt_info'] = ObjectPool::getObj('RelationCrmProvider')->getAptitude($v['demand_apt_id']);
            }
            $rows[$key]['demand_array'] = $comDemand;

            /**
             * 企业阶段进度信息
             */
//            $comStatus = self::getInstance('StatusCrmProvider')->getStatusById($value['enter_id'], false, true);
//            $rows[$key]['status_array'] = $comStatus;
//            
            if (array_key_exists('status_id', $value)) {
                //如果条件中包含阶段进度信息
                $rows[$key]['status_array'] = ObjectPool::getObj('StatusCrmService')->getStatusById($value['status_id']);
            } else {
                //如果条件中不包含阶段进度信息,默认根据人才读取最新一条阶段进度信息
                $rows[$key]['status_array'] = ObjectPool::getObj('StatusCrmService')->getStatusRows($value['enter_id'], TRUE, FALSE);
            }
        }
        return $rows;
    }

    /**
     * 判断字段是否存在
     * @param sring $fieldName 字段名称
     * @param sring $fieldValue 字段值
     * @param sring $table 表名
     * @return boolean  存在返回真，否则返回假
     */
    public static function isExist($fieldName, $fieldValue, $table, $isDel = null) {
        return ObjectPool::getObj('RelationCrmProvider')->isExist($fieldName, $fieldValue, $table, $isDel);
    }

    /**
     * 获取指定证书id与行业id对应的关系apt_id
     * @param int $cert_id 证书id
     * @param int $in_id 行业id
     * @return string 返回关系id 
     */
    public static function getAptId($cert_id, $in_id) {
        return ObjectPool::getObj('AptitudeCrmService')->getAptId($cert_id, $in_id);
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
    public static function addAptHuamn($data) {
        return ObjectPool::getObj('HumanCrmService')->addApthuman($data);
    }

}

?>
