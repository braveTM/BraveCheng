<?php

/**
 * CCompanyAction
 * @note 从左到右：匿名用户、个人用户、企业用户、经纪人用户、分包商用户；0代表没有权限，1代表有权限
 * @author YoyiorLee
 * @date 2012-04-06
 */
class CCompanyAction extends BaseAction {

    /**
     * 企业详情 00010
     */
    public function index() {
        $company_id = isset($_GET['id']) ? $_GET['id'] : 0;
        if (empty($company_id))
            redirect(C('ERROR_PAGE'));
        $company = crm_detail_page::get_company($company_id, AccountInfo::get_user_id());
        $this->assign('company', $company);
        $this->assign('source', crm_detail_page::get_source());
        $this->assign('provinces', crm_index_page::get_district(0, 1));
        if (!empty($company->province_id)) {
            $this->assign('citys', crm_index_page::get_district($company->province_id));
        }
        if (!empty($company->province_id) && !empty($company->city_id)) {
            $this->assign('regions', crm_index_page::get_district($company->city_id));
        }
        if (!empty($company->province_id) && !empty($company->city_id) && !empty($company->region_id)) {
            $this->assign('communitys', crm_index_page::get_district($company->region_id));
        }
        if (!$company->id)
            redirect(C('ERROR_PAGE'));
        $this->display();
    }

    /**
     * 添加企业 00010
     */
    public function add_company() {
        $this->display();
    }

    /**
     * 更新企业基本信息 00010
     */
    public function do_update_base() {
        if (!$this->is_legal_request())
            return;
        $data = array(
            'enter_id' => isset($_POST['enter_id']) ? $_POST['enter_id'] : 0,
            'name' => isset($_POST['name']) ? $_POST['name'] : '',
            'sour_id' => isset($_POST['source_id']) ? $_POST['source_id'] : 0,
            'nature' => isset($_POST['type_id']) ? $_POST['type_id'] : 0,
            'found_time' => $_POST['found_time'] == '0000-00-00' ? '0000-00-00' : $_POST['found_time'],
            'site' => isset($_POST['site']) ? $_POST['site'] : '',
            'brief' => isset($_POST['brief']) ? $_POST['brief'] : ''
        );
        $service = new CompanyCrmService();
        $result = $service->updateCompany($data);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 添加一个企业资质 00010
     */
    public function do_add_nature() {
        if (!$this->is_legal_request())
            return;
        $enter_id = isset($_POST['enter_id']) ? $_POST['enter_id'] : 0;
        $nature_name = isset($_POST['name']) ? $_POST['name'] : '';
        $service = new CompanyCrmService();
        $result = $service->addNatureByEnterId($enter_id, $nature_name);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 更新一个企业资质 00010
     */
    public function do_update_nature() {
        if (!$this->is_legal_request())
            return;
        $cn_id = isset($_POST['cn_id']) ? $_POST['cn_id'] : '';
        $nature_name = isset($_POST['name']) ? $_POST['name'] : '';
        $service = new CompanyCrmService();
        $result = $service->updateNature($cn_id, $nature_name);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result);
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 删除一个企业资质 00010
     */
    public function do_delete_nature() {
        if (!$this->is_legal_request())
            return;
        $cn_id = isset($_POST['cn_id']) ? $_POST['cn_id'] : 0;
        $service = new CompanyCrmService();
        $result = $service->delNatruecom($cn_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result);
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新企业联系人信息 00010
     */
    public function do_update_contact() {
        if (!$this->is_legal_request())
            return;
        $data = array(
            'enter_id' => isset($_POST['enter_id']) ? $_POST['enter_id'] : 0,
            'contact' => isset($_POST['name']) ? $_POST['name'] : '',
            'mobile' => isset($_POST['mobile']) ? $_POST['mobile'] : 0,
            'email' => isset($_POST['email']) ? $_POST['email'] : '',
            'qq' => isset($_POST['qq']) ? $_POST['qq'] : 0,
            'fax' => isset($_POST['fax']) ? $_POST['fax'] : '',
            'zipcode' => isset($_POST['zipcode']) ? $_POST['zipcode'] : 0,
            'province_id' => isset($_POST['province_id']) ? $_POST['province_id'] : 0,
            'city_id' => isset($_POST['city_id']) ? $_POST['city_id'] : 0,
            'region_id' => isset($_POST['region_id']) ? $_POST['region_id'] : 0,
            'community_id' => isset($_POST['community_id']) ? $_POST['community_id'] : 0,
            'address' => isset($_POST['address']) ? $_POST['address'] : '',
        );
        $service = new CompanyCrmService();
        $result = $service->updateCompany($data);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 添加一条企业需求 00010
     */
    public function do_add_demand() {
        if (!$this->is_legal_request())
            return;
        $enter_id = isset($_POST['enter_id']) ? $_POST['enter_id'] : 0;
        $apt_id = isset($_POST['apt_id']) ? $_POST['apt_id'] : 0;
        $reg_info = isset($_POST['reg_info']) ? $_POST['reg_info'] : 0;
        $need_price = isset($_POST['need_price']) ? $_POST['need_price'] : '';
        $need_year = isset($_POST['need_year']) ? $_POST['need_year'] : '';
        $need_num = isset($_POST['need_num']) ? $_POST['need_num'] : 0;
        $is_fulltime = isset($_POST['is_fulltime']) ? $_POST['is_fulltime'] : 0;
        $service_charge = isset($_POST['service_charge']) ? $_POST['service_charge'] : '';
        $is_tax = isset($_POST['demand_is_tax']) ? $_POST['demand_is_tax'] : '';
        $effect = isset($_POST['use']) ? $_POST['use'] : '';
        $information = isset($_POST['demand_notes']) ? $_POST['demand_notes'] : '';
        $service = new CompanyCrmService();
        $result = $service->addDemand($effect, $information, $apt_id, $need_num, $is_fulltime, $is_tax, $service_charge, $reg_info, $need_year, $need_price, $enter_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 更新一条企业需求 00010
     */
    public function do_update_demand() {
        if (!$this->is_legal_request())
            return;
        $enter_id = isset($_POST['enter_id']) ? $_POST['enter_id'] : 0;
        $demand_id = isset($_POST['demand_id']) ? $_POST['demand_id'] : 0;
        $apt_id = isset($_POST['apt_id']) ? $_POST['apt_id'] : 0;
        $reg_info = isset($_POST['reg_info']) ? $_POST['reg_info'] : 0;
        $need_price = isset($_POST['need_price']) ? $_POST['need_price'] : '';
        $need_year = isset($_POST['need_year']) ? $_POST['need_year'] : '';
        $need_num = isset($_POST['need_num']) ? $_POST['need_num'] : 0;
        $is_fulltime = isset($_POST['is_fulltime']) ? $_POST['is_fulltime'] : 0;
        $service_charger = isset($_POST['service_charge']) ? $_POST['service_charge'] : '';
        $is_tax = isset($_POST['demand_is_tax']) ? $_POST['demand_is_tax'] : '';
        $effect = isset($_POST['use']) ? $_POST['use'] : '';
        $information = isset($_POST['demand_notes']) ? $_POST['demand_notes'] : '';
        $service = new CompanyCrmService();
        $result = $service->updateDemand($demand_id, $effect, $information, $apt_id, $need_num, $is_fulltime, $is_tax, $service_charger, $reg_info, $need_year, $need_price, $enter_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 删除一条企业需求 00010
     */
    public function do_delete_demand() {
        if (!$this->is_legal_request())
            return;
        $demand_id = isset($_POST['demand_id']) ? $_POST['demand_id'] : 0;
        $service = new CompanyCrmService();
        $result = $service->delDemand($demand_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result);
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 添加一个企业注册人信息 00010
     */
    public function do_add_register() {
        if (!$this->is_legal_request())
            return;
        $enter_id = isset($_POST['enter_id']) ? $_POST['enter_id'] : 0;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $sex = isset($_POST['sex']) ? $_POST['sex'] : 0;
        $employ_pay = isset($_POST['pay']) ? $_POST['pay'] : 0;
        $apt_id = isset($_POST['apt_id']) ? $_POST['apt_id'] : 0;
        $reg_info = isset($_POST['reg_info']) ? $_POST['reg_info'] : 0; //注册情况
        $sign_time = $_POST['sign_time'] == '0000-00-00' ? '0000-00-00' : $_POST['sign_time'];
        $contract_period = isset($_POST['contract_period']) ? $_POST['contract_period'] : 0;
        $expiration_time = $_POST['expiration_time'] == '0000-00-00' ? '0000-00-00' : $_POST['expiration_time'];
        $pay_way = isset($_POST['pay_way']) ? $_POST['pay_way'] : 0;
        $pay_time = $_POST['pay_time'] == '0000-00-00' ? '0000-00-00' : $_POST['pay_time'];
        $is_refund = isset($_POST['is_refund']) ? $_POST['is_refund'] : 0;
        $refund_time = $_POST['refund_time'] == '0000-00-00' ? '0000-00-00' : $_POST['refund_time'];
        $refund_money = isset($_POST['refund_money']) ? $_POST['refund_money'] : 0;
        $refund_singor = isset($_POST['refund_singor']) ? $_POST['refund_singor'] : '';
        $refund_signer = isset($_POST['refund_signer']) ? $_POST['refund_signer'] : '';
        $refund_reseaon = isset($_POST['refund_reseaon']) ? $_POST['refund_reseaon'] : '';
        $service = new CompanyCrmService();
        $result = $service->addRegister($name, $sex, $apt_id, $reg_info, $employ_pay, $sign_time, $contract_period, $expiration_time, $pay_way, $pay_time, $is_refund, $refund_time, $refund_money, $refund_singor, $refund_signer, $refund_reseaon, $enter_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 更新一个企业注册人信息 00010
     */
    public function do_update_register() {
        if (!$this->is_legal_request())
            return;
        $rc_id = isset($_POST['rc_id']) ? $_POST['rc_id'] : 0;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $sex = isset($_POST['sex']) ? $_POST['sex'] : 0;
        $employ_pay = isset($_POST['pay']) ? $_POST['pay'] : 0;
        $apt_id = isset($_POST['apt_id']) ? $_POST['apt_id'] : 0;
        $reg_info = isset($_POST['reg_info']) ? $_POST['reg_info'] : 0; //注册情况
        $sign_time = $_POST['sign_time'] == '0000-00-00' ? '0000-00-00' : $_POST['sign_time'];
        $contract_period = isset($_POST['contract_period']) ? $_POST['contract_period'] : 0;
        $expiration_time = $_POST['expiration_time'] == '0000-00-00' ? '0000-00-00' : $_POST['expiration_time'];
        $pay_way = isset($_POST['pay_way']) ? $_POST['pay_way'] : 0;
        $pay_time = $_POST['pay_time'] == '0000-00-00' ? '0000-00-00' : $_POST['pay_time'];
        $is_refund = isset($_POST['is_refund']) ? $_POST['is_refund'] : 0;
        $refund_time = $_POST['refund_time'] == '0000-00-00' ? '0000-00-00' : $_POST['refund_time'];
        $refund_money = isset($_POST['refund_money']) ? $_POST['refund_money'] : 0;
        $refund_singor = isset($_POST['refund_singor']) ? $_POST['refund_singor'] : '';
        $refund_signer = isset($_POST['refund_signer']) ? $_POST['refund_signer'] : '';
        $refund_reseaon = isset($_POST['refund_reseaon']) ? $_POST['refund_reseaon'] : '';
        $service = new CompanyCrmService();
        $result = $service->updateRegister($rc_id, $name, $sex, $apt_id, $reg_info, $employ_pay, $sign_time, $contract_period, $expiration_time, $pay_way, $pay_time, $is_refund, $refund_time, $refund_money, $refund_singor, $refund_signer, $refund_reseaon);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 删除一个企业注册人信息 00010
     */
    public function do_delete_register() {
        if (!$this->is_legal_request())
            return;
        $rc_id = isset($_POST['rc_id']) ? $_POST['rc_id'] : 0;
        $service = new CompanyCrmService();
        $result = $service->delRegcom($rc_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 更新企业备注 00010
     */
    public function do_update_remark() {
        if (!$this->is_legal_request())
            return;
        $data = array(
            'enter_id' => isset($_POST['enter_id']) ? $_POST['enter_id'] : 0,
            'remark' => isset($_POST['remark']) ? $_POST['remark'] : ''
        );
        $service = new CompanyCrmService();
        $result = $service->updateCompany($data);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 获取企业资料完成度 00010
     */
    function get_completed_degree() {
        if ($this->is_legal_request())
            return;
        $enter_id = isset($_POST['enter_id']) ? $_POST['enter_id'] : 0;
        $result = $this->assign('completed', crm_detail_page::get_company_completed_degree($enter_id));
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 从职讯网导入企业 00010
     */
    function do_import_company_by_zx() {
        if (!$this->is_legal_request())
            return;
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
        $service = new ApiCrmService();
        $result = $service->importCompany($id, $user_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 添加企业 00010
     */
    function do_add_company() {
        if (!$this->is_legal_request())
            return;
        $dataArr = array(
            'enter_id' => isset($_POST['enter_id']) ? $_POST['enter_id'] : 0,
            'name' => isset($_POST['name']) ? $_POST['name'] : '',
            'sour_id' => isset($_POST['source_id']) ? $_POST['source_id'] : 0,
            'nature' => isset($_POST['type_id']) ? $_POST['type_id'] : '',
            'found_time' => isset($_POST['found_time']) ? $_POST['found_time'] : 0,
            'site' => isset($_POST['site']) ? $_POST['site'] : '',
            'brief' => isset($_POST['brief']) ? $_POST['brief'] : ''
        );
        $service = new CompanyCrmService();
        $result = $service->addCompany($dataArr);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 上传附件 post
     * @param  att_name  varchar   文件名称
     *  @param  att_type_id  int 文件类型
     *  @param  identifier  varchar 证件编号 
     *  @param  enter_id  INT   企业id 
     *  @param  att_name  varchar 
     * 00010
     */
    public function do_upload_crmAttCompany() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        require_cache(APP_PATH . '/Common/Function/file.php');
        $name = $_FILES['upfile']['name'];
        $result = file_upload('upfile', get_crm_path_root(AccountInfo::get_user_id()) . get_crm_path_att(), 'FILE');
        if (is_int($result)) {
            echo "<script type=\"text/javascript\">window.parent.resourcedetailRender.tg(\"附件上传失败，请检查\")</script>";
        } else {
            $data['att_name'] = $name;
            $data['att_type_id'] = $_POST['att_type_id'];
            $data['identifier'] = $_POST['identifier'];
            $data['att_path'] = $result;
            $attachmentCrmRervice = new AttachmentCrmService();
            $att_id = $attachmentCrmRervice->addAttachment($data);
            if (is_zerror($att_id)) {
                echo jsonp_encode(false, $att_id->get_message());
            } else {
                $humanData['att_id'] = $att_id;
                $humanData['enter_id'] = $_POST['enter_id'];
                $atthumanCrmRervice = new AtthumanCrmService();
                $atthuman_id = $atthumanCrmRervice->addAtthuman($humanData);
                if (is_zerror($atthuman_id)) {
                    echo "<script type=\"text/javascript\">window.parent.resourcedetailRender.tg(\"附件上传失败，请检查\")</script>";
                } else {
                    echo "<script type=\"text/javascript\">window.parent.resourcedetailRender.te()</script>";
                }
            }
        }
    }

    /**
     * 上传附件 post
     * @param  att_name  varchar   文件名称
     *  @param  att_type_id  int 文件类型
     *  @param  identifier  varchar 证件编号 
     *  @param  human_id  INT   人才id 
     *  @param  att_name  varchar 
     * 00010
     */
    public function do_upload_crmAttCsv() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        require_cache(APP_PATH . '/Common/Function/file.php');
        $result = file_upload('upfile', get_crm_path_root(AccountInfo::get_user_id()) . get_crm_path_attCsv(), 'IMAGE');
        if (is_int($result)) {
            echo "<script type=\"text/javascript\">window.parent.resourceRender.bf()</script>";
        } else {
            $data['att_name'] = 'g';
            $data['att_type_id'] = 10;
            $data['att_path'] = $result;
            $attachmentCrmRervice = new AttachmentCrmService();
            $att_id = $attachmentCrmRervice->addAttachment($data);
            if (is_zerror($att_id)) {
                echo "<script type=\"text/javascript\">window.parent.resourceRender.bi(\"上传出错，请重新上传\")</script>";
            } else {
                $pro = new AttachmentCrmProvider();
                $result = $pro->getAttchmentById($att_id);
                $serObj = new HumanCrmService();
                $res = $serObj->build_file($result['att_path'], TRUE);
                $string = xls_error($res[0]);
                header('Content-type:text/html;charset=UTF-8');
                echo '<script type = "text/javascript">window.parent.resourceRender.bh("' . $string . '")</script>';
            }
        }
    }

    /* csv处理模块    ******************** */
}

?>
