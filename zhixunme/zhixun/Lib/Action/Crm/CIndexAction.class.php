<?php

/**
 * CIndexAction
 * @note 从左到右：匿名用户、个人用户、企业用户、经纪人用户、分包商用户；0代表没有权限，1代表有权限
 * @author YoyiorLee
 * @date 2012-04-06
 */
class CIndexAction extends BaseAction {
    //===========================公用===========================

    /**
     * 列表页00010
     */
    public function index() {
        $this->assign('category', crm_index_page::get_category()); //阶段
        $this->assign('progress', crm_index_page::get_progress(2)); //进度
        $this->assign('source', crm_index_page::get_source()); //来源
        $this->display();
    }

    /**
     * 获取资质证书00010
     */
    public function get_certificates() {
        header('Content-Type:text/html;charset=utf-8;');
        $result = crm_index_page::get_certificates();
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 获取资质专业00010
     */
    public function get_industries() {
        header('Content-Type:text/html;charset=utf-8;');
        $cert_id = isset($_POST['id']) ? $_POST['id'] : 0;
        $result = crm_index_page::get_industries($cert_id);
        if (empty($result)) {
            $apt_id = crm_index_page::get_industries($cert_id, TRUE);
            if (empty($apt_id) || is_zerror($apt_id)) {
                echo jsonp_encode(false);
            } else {
                echo jsonp_encode(true, NULL, NULL, $apt_id);
            }
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 获取职称00010
     */
    public function get_title_types() {
        $result = crm_index_page::get_title_types();
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 获取职称00010
     */
    public function get_titles() {
        $t_id = isset($_POST['id']) ? $_POST['id'] : 0;
        $result = crm_index_page::get_titles($t_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    //===========================人才===========================

    /**
     * 获取人才列表00010
     */
    public function get_humans() {
        $page = isset($_POST['page']) ? $_POST['page'] : 0;
        $size = isset($_POST['size']) ? $_POST['size'] : 10;
        $result = crm_index_page::get_human_default($page, $size, AccountInfo::get_user_id());
        if (!$result) {
            echo jsonp_encode(false);
            return;
        }
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result, crm_index_page::get_humans_count(AccountInfo::get_user_id()));
        }
    }

    /**
     * 人才资源筛选 00010
     */
    public function get_humans_by_filter() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $size = isset($_POST['size']) ? $_POST['size'] : 20;
        $condition = array(
            'is_fulltime' => !empty($_POST['is_fultime']) ? intval($_POST['is_fultime']) : '', //全职/兼职/不限
            'sour_id' => !empty($_POST['sour_id']) ? intval($_POST['sour_id']) : '', //来源id
            'province_id' => !empty($_POST['province_id']) ? intval($_POST['province_id']) : '', //省id
            'name' => !empty($_POST['keywords']) ? trim($_POST['keywords']) : '', //关键字/备注
            'tp_id' => !empty($_POST['title_id']) ? intval($_POST['title_id']) : '', //职称
            'tp_level' => !empty($_POST['title_level_id']) ? intval($_POST['title_level_id']) : '', //职称等级
            'user_id' => AccountInfo::get_user_id(),
            'quote' => empty($_POST['quote']) ? '' : $_POST['quote'], //经纪人给人才的报价
        );
        //进度阶段查询条件组合
        if (!empty($_POST['cate_id'])) {
            $condition['crm_status'] = array(
                'as' => 'sta',
                'index' => 'human_id',
                'sta.cate_id' => intval($_POST['cate_id']),
            );
        }
        if (!empty($_POST['pro_id']))
            $condition['crm_status']['sta.pro_id'] = intval($_POST['pro_id']);
        //人才行业证书/资质证书
        if (!empty($_POST['apt_id']) || !empty($_POST['reg_info'])) {
            $condition['crm_apt_human'] = array(
                'as' => 'apt',
                'index' => 'human_id',
                'apt.apt_id' => intval($_POST['apt_id']),
                'apt.reg_info' => intval($_POST['reg_info']),
            );
        }
        $order = array(
            'hu.human_id' => 'DESC',
        );
        $result = crm_index_page::get_humans_filter($condition, $page, $size, 'crm_human', 'hu', $order);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, ApiCrmService::getWhereCount($condition, $page, $size, 'crm_human', 'hu', 'human_id', TRUE));
        }
    }

    /**
     * 批量删除人才00010
     */
    public function do_delete_humans() {
        if (!$this->is_legal_request())
            return;
        $human_ids = isset($_POST['ids']) ? $_POST['ids'] : 0;
        $service = new HumanCrmService();
        $result = $service->delete_batch($human_ids);
        if (empty($result)) {
            echo jsonp_encode(false, $result);
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 邮件群发
     * $ids int 发送邮件的id号
     * 00010
     */
    public function send_mail_human() {
        if (!$this->is_legal_request())
            return;
        if (empty($_POST['ids'])) {
            echo jsonp_encode(false, "没有选择发送邮件用户");
        } elseif (empty($_POST['title'])) {
            echo jsonp_encode(false, "请填写邮件主题");
        } elseif (empty($_POST['content'])) {
            echo jsonp_encode(false, "请填写邮件内容");
        } else {
            $enter_ids = isset($_POST['ids']) ? $_POST['ids'] : 0;
            $title = isset($_POST['title']) ? $_POST['title'] : 0;
            $content = isset($_POST['content']) ? $_POST['content'] : 0;
            $service = new HumanCrmService();
            $result = $service->sendMial($enter_ids, $title, $content);
            if (empty($result)) {
                echo jsonp_encode(false, $result->get_message());
            } else {
                echo jsonp_encode(true, $result);
            }
        }
    }

    /**
     * 简要信息添加00010
     */
    public function add_human() {
        if (!$this->is_legal_request())
            return;
        $data['name'] = isset($_POST['name']) ? $_POST['name'] : 0;
        $data['sour_id'] = isset($_POST['sour_id']) ? $_POST['sour_id'] : 0;
        $data['province_id'] = 0;
        $data['city_id'] = 0;
        $data['user_id'] = AccountInfo::get_user_id();
        $service = new HumanCrmService();
        $result = $service->addHumanSimple($data);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(TRUE, $result);
        }
    }

    //===========================企业===========================

    /**
     * 筛选人企业列表00011
     */
    public function get_companys() {
        $page = $_POST['page'];
        $size = $_POST['size'];
        $result = crm_index_page::get_companys($page, $size, AccountInfo::get_user_id());
        if (!$result) {
            echo jsonp_encode(false);
            return;
        }
        if (is_zerror($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, crm_index_page::get_companys_count(AccountInfo::get_user_id()));
        }
    }

    /**
     * 企业搜索条件筛选
     * 企业会根据一下条件进行索引
     * 1、企业需求中是否是全职、兼职
     * 2、企业需求中注册情况筛选
     * 3、企业需求中资质证书
     * 4、企业需求中报价，既是人才聘用费
     * 5、企业名称与企业备注
     * 6、企业来源
     * 7、企业阶段进度 
     * 00010
     */
    public function get_companys_by_filter() {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $size = isset($_POST['size']) ? $_POST['size'] : 20;
        $condition = array(
            'sour_id' => !empty($_POST['sour_id']) ? intval($_POST['sour_id']) : '', //来源id
            'province_id' => !empty($_POST['province_id']) ? intval($_POST['province_id']) : '', //省id
            'name' => !empty($_POST['keywords']) ? trim($_POST['keywords']) : '', //关键字/备注
            'user_id' => AccountInfo::get_user_id(),
        );
        //进度阶段查询条件组合
        if (!empty($_POST['cate_id'])) {
            $condition['crm_status'] = array(
                'as' => 'sta',
                'index' => 'enter_id',
                'sta.cate_id' => intval($_POST['cate_id']),
            );
        }
        if (!empty($_POST['pro_id']))
            $condition['crm_status']['sta.pro_id'] = intval($_POST['pro_id']);
        /**
         * 需求行业证书/资质证书 
         */
        if (!empty($_POST['apt_id'])) {
            $condition['crm_demand'] = array(
                'as' => 'de',
                'index' => 'enter_id',
                'de.apt_id' => empty($_POST['apt_id']) ? '' : intval($_POST['apt_id']),
            );
        }
        //企业需求注册情况条件
        if (!empty($_POST['reg_info'])) {
            $condition['crm_demand'] = array(
                'as' => 'de',
                'index' => 'enter_id',
                'de.reg_info' => empty($_POST['reg_info']) ? '' : intval($_POST['reg_info']),
            );
        }
        //企业需求是否兼职条件
        if (!empty($_POST['is_fultime'])) {
            $condition['crm_demand'] = array(
                'as' => 'de',
                'index' => 'enter_id',
                'de.is_fulltime' => empty($_POST['is_fultime']) ? '' : intval($_POST['is_fultime']),
            );
        }
        //企业需求报价条件
        if (!empty($_POST['quote'])) {
            $condition['crm_demand'] = array(
                'as' => 'de',
                'index' => 'enter_id',
                'de.need_price' => empty($_POST['quote']) ? '' : intval($_POST['quote']),
            );
        }

        $order = array(
            'c.enter_id' => 'DESC',
        );
        $result = crm_index_page::get_company_filter($condition, $page, $size, 'crm_company', 'c', $order);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result, ApiCrmService::getWhereCount($condition, $page, $size, 'crm_company', 'c', 'enter_id', TRUE));
        }
    }

    /**
     *  获取企业性质00010
     */
    public function get_natures() {
        $result = crm_index_page::get_natures();
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 删除 00010
     */
    public function do_delete_companys() {
        if (!$this->is_legal_request())
            return;
        $enter_ids = isset($_POST['ids']) ? $_POST['ids'] : 0;
        $service = new CompanyCrmService();
        $result = $service->deleteCompanyBatch($enter_ids);
        if (empty($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 邮件群发 
     * $ids int 发送邮件的id号
     * 00010
     */
    public function send_mail_companys() {
        if (!$this->is_legal_request())
            return;
        if (empty($_POST['ids'])) {
            echo jsonp_encode(false, "没有选择发送邮件用户");
        } elseif (empty($_POST['title'])) {
            echo jsonp_encode(false, "请填写邮件主题");
        } elseif (empty($_POST['content'])) {
            echo jsonp_encode(false, "请填写邮件内容");
        } else {
            $enter_ids = isset($_POST['ids']) ? $_POST['ids'] : 0;
            $title = isset($_POST['title']) ? $_POST['title'] : 0;
            $content = isset($_POST['content']) ? $_POST['content'] : 0;
            $service = new CompanyCrmService();
            $result = $service->sendMial($enter_ids, $title, $content);
            if (empty($result)) {
                echo jsonp_encode(false, $result->get_message());
            } else {
                echo jsonp_encode(true, $result);
            }
        }
    }

    /**
     * 简要信息添加00010
     */
    public function add_company() {
        if (!$this->is_legal_request())
            return;
        $data['name'] = isset($_POST['name']) ? $_POST['name'] : 0;
        $data['contact'] = isset($_POST['contracter']) ? $_POST['contracter'] : 0;
        $data['sour_id'] = isset($_POST['sour_id']) ? $_POST['sour_id'] : 0;
        $data['province_id'] = 0;
        $data['city_id'] = 0;
        $data['user_id'] = AccountInfo::get_user_id();
        $service = new CompanyCrmService();
        $result = $service->addCompanySimple($data);
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(TRUE, $result);
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
                echo "<script type=\"text/javascript\">window.parent.resourceRender.bf()</script>";
            } else {
                echo "<script type=\"text/javascript\">window.parent.resourceRender.be()</script>";
            }
        }
    }

    /**
     * 删除 00010
     */
    public function do_delete_crmAtt() {
        if (!$this->is_legal_request())
            return;
        $att_id = empty($_POST['att_id']) ? 0 : $_POST['att_id'];
        $service = new RelationCrmProvider();
        $result = $service->delData('att_id', $att_id, 'crm_atthuman');
        $result = $service->delData('att_id', $att_id, 'att_id');
        if (is_zerror($result)) {
            echo jsonp_encode(false, $result->get_message());
        } else {
            echo jsonp_encode(true);
        }
    }

}

?>
