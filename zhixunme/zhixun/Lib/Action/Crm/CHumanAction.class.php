<?php

/**
 * CHumanAction
 * @note 从左到右：匿名用户、个人用户、企业用户、经纪人用户、分包商用户；0代表没有权限，1代表有权限
 * @author YoyiorLee
 * @date 2012-04-06
 */
class CHumanAction extends BaseAction {

    /**
     * 详情页00010
     */
    function index() {
        $human_id = empty($_GET['id']) ? 0 : $_GET['id']; //人才ID
        if (empty($human_id))
            redirect(C('ERROR_PAGE'));
        if (!ApiCrmService::isExist('human_id', $human_id, 'crm_human'))
            redirect(C('ERROR_PAGE'));
        $human = crm_detail_page::get_human($human_id, AccountInfo::get_user_id());
        $this->assign('human', $human);
        $this->assign('source', crm_detail_page::get_source());
        $this->assign('provinces', crm_index_page::get_district(0));
        if (!empty($human->province_id)) {
            $this->assign('citys', crm_index_page::get_district($human->province_id));
        }
        if (!empty($human->province_id) && !empty($human->city_id)) {
            $this->assign('regions', crm_index_page::get_district($human->city_id));
        }
        if (!empty($human->province_id) && !empty($human->city_id) && !empty($human->region_id)) {
            $this->assign('communitys', crm_index_page::get_district($human->region_id));
        }
        if (!$human->id)
            redirect(C('ERROR_PAGE'));
        $this->display();
    }

    /**
     * 添加人才页00010
     */
    function add_human() {
        $this->display();
    }

    /**
     * 更新人才基本资料 00010
     */
    public function do_update_base() {
        if (!$this->is_legal_request())
            return;
        $service = new HumanCrmService();
        $dataArr = array(
            'human_id' => empty($_POST['human_id']) ? 0 : $_POST['human_id'],
            'name' => empty($_POST['name']) ? '' : $_POST['name'],
            'sex' => isset($_POST['sex']) ? intval($_POST['sex']) : 0,
            'sour_id' => empty($_POST['sour_id']) ? 1 : $_POST['sour_id'],
            'birthday' => $_POST['birthday'] == '0000-00-00' ? '0000-00-00' : $_POST['birthday'],
            'doc_number' => empty($_POST['identifier']) ? 0 : $_POST['identifier'],
            'mobile' => empty($_POST['mobile']) ? '' : $_POST['mobile'],
            'phone' => empty($_POST['phone']) ? '' : $_POST['phone'],
            'email' => empty($_POST['email']) ? '' : $_POST['email'],
            'qq' => empty($_POST['qq']) ? '' : $_POST['qq'],
            'fax' => empty($_POST['fax']) ? '' : $_POST['fax'],
            'postcode' => empty($_POST['zipcode']) ? '' : $_POST['zipcode'],
            'province_id' => empty($_POST['province_id']) ? 0 : $_POST['province_id'],
            'city_id' => empty($_POST['city_id']) ? 0 : $_POST['city_id'],
            'region_id' => empty($_POST['region_id']) ? 0 : $_POST['region_id'],
            'community_id' => empty($_POST['community_id']) ? 0 : $_POST['community_id'],
            'address' => empty($_POST['address']) ? '' : $_POST['address'],
            'att_human_id' => empty($_POST['att_human_id']) ? 1 : $_POST['att_human_id'],
            'doc_type' => empty($_POST['att_type_id']) ? 0 : $_POST['att_type_id'],
        );
        $result = $service->updateHuman($dataArr);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 添加人才资质证书 00010
     */
    public function do_add_aptitude() {
        if (!$this->is_legal_request())
            return;
        $dataArr = array(
            'human_id' => empty($_POST['human_id']) ? 0 : $_POST['human_id'],
            'apt_id' => empty($_POST['apt_id']) ? 0 : $_POST['apt_id'],
            'reg_info' => empty($_POST['reg_info']) ? 0 : $_POST['reg_info'],
            'province_id' => empty($_POST['province_id']) ? 0 : $_POST['province_id']
        );
        $service = new HumanCrmService();
        $result = $service->addApthuman($dataArr);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 更新人才资质证书 00010
     */
    public function do_update_aptitude() {
        if (!$this->is_legal_request())
            return;
        $dataArr = array(
            'aman_id' => empty($_POST['aman_id']) ? 0 : $_POST['aman_id'],
            'human_id' => empty($_POST['human_id']) ? 0 : $_POST['human_id'],
            'apt_id' => empty($_POST['apt_id']) ? 0 : $_POST['apt_id'],
            'reg_info' => empty($_POST['reg_info']) ? 0 : $_POST['reg_info'],
            'province_id' => empty($_POST['province_id']) ? 0 : $_POST['province_id']
        );
        $service = new HumanCrmService();
        $result = $service->updateApthuman($dataArr);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 删除人才资质证书 00010
     */
    public function do_delete_aptitude() {
        if (!$this->is_legal_request())
            return;
        $aman_id = empty($_POST['aman_id']) ? 0 : $_POST['aman_id'];
        $service = new HumanCrmService();
        $result = $service->deleteApthuman($aman_id);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新人才职称 00010
     */
    public function do_update_title() {
        if (!$this->is_legal_request())
            return;
        $dataArr = array(
            'human_id' => empty($_POST['human_id']) ? 0 : $_POST['human_id'],
            'tp_id' => empty($_POST['title_id']) ? 0 : $_POST['title_id'],
            'tp_level' => empty($_POST['title_level']) ? 0 : $_POST['title_level'],
            'quote' => empty($_POST['quote']) ? 0 : $_POST['quote'],
        );
        $service = new HumanCrmService();
        $result = $service->updateHuman($dataArr);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新人才开户行 00010
     */
    public function do_update_bank() {
        if (!$this->is_legal_request())
            return;
        $data = array(
            'human_id' => empty($_POST['human_id']) ? 0 : $_POST['human_id'],
            'bank_id' => empty($_POST['bank_id']) ? 0 : $_POST['bank_id'],
            'bank_name' => empty($_POST['bank_name']) ? 0 : $_POST['bank_name'],
            'bank_account' => empty($_POST['account']) ? 0 : $_POST['account'],
            'bank_username' => empty($_POST['username']) ? 0 : $_POST['username']
        );
        $service = new BankCrmService();
        $result = $service->update($data);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新人才注册企业情况 00010
     */
    public function do_update_employ() {
        if (!$this->is_legal_request())
            return;
        $dataArr = array(
            'human_id' => empty($_POST['human_id']) ? 0 : $_POST['human_id'],
            'employ_pay_time' => $_POST['pay_time'] == '0000-00-00' ? '0000-00-00' : $_POST['pay_time'],
            'employ_payment' => empty($_POST['payment']) ? '' : $_POST['payment'],
            'employ_expr_time' => $_POST['expr_time'] == '0000-00-00' ? '0000-00-00' : $_POST['expr_time'],
            'employ_contract' => empty($_POST['contract']) ? '' : $_POST['contract'],
            'employ_sign_time' => $_POST['sign_time'] == '0000-00-00' ? '0000-00-00' : $_POST['sign_time'],
            'employ_pay' => empty($_POST['pay']) ? '0.00' : $_POST['pay'],
            'employ_charger' => empty($_POST['charger']) ? '' : $_POST['charger'],
            'employ_location' => empty($_POST['location']) ? '' : $_POST['location'],
            'employ_name' => empty($_POST['company_name']) ? '' : $_POST['company_name'],
            'att_type_id' => empty($_POST['att_type_id']) ? '' : $_POST['att_type_id'],
            'att_human_id' => empty($_POST['att_human_id']) ? '' : $_POST['att_human_id']
        );
        $service = new HumanCrmService();
        $result = $service->updateHuman($dataArr);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 更新人才备注 00010
     */
    public function do_update_remark() {
        if (!$this->is_legal_request())
            return;
        $dataArr = array(
            'human_id' => isset($_POST['human_id']) ? $_POST['human_id'] : 0,
            'remark' => isset($_POST['remark']) ? $_POST['remark'] : '',
            'att_type_id' => empty($_POST['att_type_id']) ? '' : $_POST['att_type_id'],
            'att_human_id' => empty($_POST['att_human_id']) ? '' : $_POST['att_human_id']
        );
        $service = new HumanCrmService();
        $result = $service->updateHuman($dataArr);
        if (empty($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /*     * **********************************获取**************************************** */

    /**
     * 获取人才资料完成度 00010
     */
    function get_completed_degree() {
        if ($this->is_legal_request())
            return;
        $human_id = isset($_GET['human_id']) ? $_GET['human_id'] : 0;
        $result = crm_detail_page::get_human_completed_degree($human_id);
        if (empty($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

    /*     * **********************************添加**************************************** */

    /**
     * 添加人才 00010
     */
    function do_add_human() {
        if (!$this->is_legal_request())
            return;
        $dataArr = array(
            'name' => empty($_POST['name']) ? '' : $_POST['name'],
            'sex' => empty($_POST['sex']) ? 1 : $_POST['sex'],
            'sour_id' => empty($_POST['sour_id']) ? 1 : $_POST['sour_id'],
            'att_type_id' => empty($_POST['idcard_type_id']) ? '1' : $_POST['idcard_type_id'],
            'identifier' => empty($_POST['idcard']) ? '' : $_POST['idcard'],
            'mobile' => empty($_POST['mobile']) ? '' : $_POST['mobile'],
            'phone' => empty($_POST['phone']) ? '' : $_POST['phone'],
            'qq' => empty($_POST['qq']) ? '' : $_POST['qq'],
        );
        $service = new HumanCrmService();
        $result = $service->addApthuman($dataArr);
        if (empty($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
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
    public function do_upload_crmAttHuman() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $name = $_FILES['upfile']['name'];
        require_cache(APP_PATH . '/Common/Function/file.php');
        $result = file_upload('upfile', get_crm_path_root(AccountInfo::get_user_id()) . get_crm_path_att(), 'FILE');
        if (is_int($result)) {
            echo "<script type=\"text/javascript\">window.parent.resourcedetailRender.tf(\"附件上传失败，请检查\")</script>";
        } else {
            $data['att_name'] = $name;
            $data['att_type_id'] = $_POST['att_type_id'];
            $data['identifier'] = '1';
            $data['att_path'] = $result;
            $attachmentCrmRervice = new AttachmentCrmService();
            $att_id = $attachmentCrmRervice->addAttachment($data);
            if (is_zerror($att_id)) {
                echo jsonp_encode(false, $att_id->get_message());
            } else {
                $humanData['att_id'] = $att_id;
                $humanData['human_id'] = $_POST['human_id'];
                $atthumanCrmRervice = new AtthumanCrmService();
                $human_id = $atthumanCrmRervice->addAtthuman($humanData);
                if (is_zerror($human_id)) {
                    echo "<script type=\"text/javascript\">window.parent.resourcedetailRender.tf(\"附件上传失败，请检查\")</script>";
                } else {
                    echo "<script type=\"text/javascript\">window.parent.resourcedetailRender.td()</script>";
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
            $data['att_name'] = 'csv,execl';
            $data['att_type_id'] = 10;
            $data['att_path'] = $result;
            $attachmentCrmRervice = new AttachmentCrmService();
            $att_id = $attachmentCrmRervice->addAttachment($data);
            if (is_zerror($att_id)) {
                echo "<script type=\"text/javascript\">window.parent.resourceRender.bf(\"上传出错，请重新上传\")</script>";
            } else {
                $pro = new AttachmentCrmProvider();
                $result = $pro->getAttchmentById($att_id);
                $serObj = new HumanCrmService();
                $res = $serObj->build_file($result['att_path']);
                $string = xls_error($res[0]);
                header('Content-type:text/html;charset=UTF-8');
                echo '<script type="text/javascript">window.parent.resourceRender.be("' . $string . '")</script>';
            }
        }
    }

    /**
     * 删除一条资质证书
     * @param int $id 记录id
     * @return mixed 成功返回true
     * 00010
     */
    function delete_certificate_copy() {
        if (!$this->is_legal_request())      //是否合法请求
            return;
        $id = (int) $_POST['certificate_id'];
        $certobj = new certificateCrmService();
        $result = $certobj->delete_broker_certificate_copy($id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true);
        }
    }

    public function do_xls() {
        header('Content-type:text/html;charset=UTF-8');
        $file = '1/10017/csv/20120703/1341309765.xls';
        $serObj = new HumanCrmService();
        $res = $serObj->build_file($file);
        $string = xls_error($res[0]);
        echo $string;
    }

}

?>
