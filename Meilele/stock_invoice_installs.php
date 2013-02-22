<?php

/**
 * 发货单安装信息模块
 * @author chenghuiyong <sir.bravecheng@gmail.com>
 *  @date 2013-1-16
 */
require(dirname(__FILE__) . '/DataModel.class.php');

class stock_invoice_installs extends DataModel {

    public static $master_type = array(1 => '职工', 2 => '临时', 3 => '外包');
    public static $pay_way = array(1 => '月结', 2 => '次付', 3 => '职工提成', 4 => '按点提');
    public static $pay_type = array(/* 1 => '现金', */ 2 => '银行');
    public static $cost_type = array(1 => '送货费', 2 => '安装费', 3 => '装货费', 4 => '卸货费', 5 => '一至三上楼费', 6 => '提货费', 8 => '体验馆摆场费');
    public static $bank = array(
        1 => "建设银行",
        2 => "工商银行",
        3 => "农业银行",
        4 => "中国银行",
        5 => "交通银行",
        6 => "招商银行",
        7 => "光大银行",
        8 => "中信银行",
        9 => "邮政储蓄银行",
        10 => "深圳发展银行",
        11 => "农村合作银行",
        12 => "农村商业银行",
        13 => "农村信用社",
    );
    public static $invoice_status = array(
        "nodetermine" => '待确定',
        "new" => '新单',
        "printed" => '已打印',
        "shipped" => '已发货',
        "cancel" => '取消',
        "reserv" => '备货中',
        "merged" => '已合并',
        "shipped_expr" => '已发货到体验馆',
        "transport" => '配送在途',
        "receiv" => '配送在库',
        "dest_print" => '配送打印',
    );
    public static $TEMPLATE = 'stock_invoice_installs.html';
    public static $status = array(
        0 => '未请款',
        1 => '已打款',
        2 => '财务打款拒绝',
        3 => '请款中',
        4 => '已取消',
        5 => '审核失败',
        6 => '财务审核通过',
    );

    public function __construct() {
        parent::__construct();
    }

    public function filter(&$filter = array()) {
        
    }

    public function query() {
        $filter = array();
        $this->filter($filter);
        make_json_result($this->smarty->fetch(self::$TEMPLATE), '', array('filter' => $filter, 'page_count' => $filter['page_count']));
    }

    public function show() {
        $this->filter();
        $this->smarty->assign('full_page', 1);
        $this->smarty->display(self::$TEMPLATE);
    }

    /**
     * 费用信息页面
     */
    public function fee() {
        $invoice_id = empty($_REQUEST['invoice_sn']) ? '' : trim($_REQUEST['invoice_sn']);
        //已经存在的请款单id
        $billing = empty($_REQUEST['billing_id']) ? 0 : intval($_REQUEST['billing_id']);
        /**
         * 优化数据库V2.0版本
         */
        $billing_id = $billing == 0 ? $this->create_new_master_billing($invoice_id) : $billing;
//        $merge = $this->get_master_billing($billing_id);
//        $this->smarty->assign('merge', $merge);
//        $this->smarty->assign('full_page', 1);
//        $invoices = $this->get_master_billing_detail($billing_id);
        if (empty($invoice_id)) {
            sys_msg('发货单SN不能为空!');
        }
        //如果不存在扩展表，则增加一个新的扩展表
        $invoice_id = $this->no_exsit_in_extend($invoice_id);
        $this->smarty->assign('full_page', 1);
        $merge = $this->merge_info($invoice_id);
        if ($merge) {
            if ($merge['merge_id']) {
                //如果发货单已经合并过，则显示合并过的发货单
                $this->smarty->assign('merge', $merge);
                //合并单据的多个发货单信息
                foreach (explode(',', $merge['merge_id']) as $key => $value) {
                    $sn = $this->db->getOne('SELECT  `invoice_sn` FROM `ecs_stock_invoice_info` WHERE `invoice_id` = ' . $value);
                    $invoices[$key] = $this->get_simple_stock_invoice($sn);
                }
            } else {
                $invoices[0] = $this->get_simple_stock_invoice($invoice_id);
            }
        } else {
            $invoices[0] = $this->get_simple_stock_invoice($invoice_id);
        }

        //判断发货单费用类别是否已使用完
        $bool = $this->invoice_fee_is_used($invoice_id);
        $bool && $this->smarty->assign('not_add', $bool);
        $this->smarty->assign("invoice", $invoices);
        //发货单费用信息
        $array = $this->get_invoice_fee_by_invoice_id($invoice_id);
        $this->smarty->assign('list', $array);
        $this->smarty->assign('invoice_status', self::$invoice_status);
        $this->smarty->assign('opt_log', $this->get_opt_log($invoice_id));
        $this->smarty->assign('status', self::$status);
        $this->smarty->assign('ur_here', '发货单费用信息列表');
        $this->smarty->display(self::$TEMPLATE);
    }

    /**
     * 发货单是否存在扩展表，不存在则创建单据【V1.0】
     * @param string $invoice
     */
    private function no_exsit_in_extend($invoice) {
        $exsit = $this->get_merge_info($invoice);
        if (empty($exsit)) {
            $sql = "SELECT `invoice_id`, `invoice_sn`, `order_id`, `order_sn`, `fstatus` , `consignee` , `warehouse_id` FROM `ecs_stock_invoice_info` WHERE `invoice_sn` = '{$invoice}'";
            $id = $this->db->getRow($sql);
            if ($id == FALSE) {
                sys_msg("发货单不存在，请重试!");
            }
            if ($sn = $this->is_merged($id['invoice_id'])) {
                return $sn;
            }
            //判断单据sn否在存在发货单中
            $data = array(
                'invoice_sn' => $invoice,
                'invoice_id' => $id['invoice_id'],
                'merge_id' => '',
                'merge_time' => '',
                'invoice_fee' => '',
                'order_id' => $id['order_id'],
                'order_sn' => $id['order_sn'],
                'order_fee' => $this->order_amount_field($id['order_id']),
                'warehouse_id' => $id['warehouse_id'],
                'consignee' => $id['consignee'],
                'oprator' => $_SESSION['admin_real_name'],
                'status' => 'shipped',
            );
            $this->db->autoExecute("ecs_stock_invoice_extend", $data);
            return $invoice;
        } else {
            //如果单据存在，则判断是否合并过
            if ($exsit['merge_id']) {
                //合并过返回sn
                return $exsit['invoice_sn'];
            } else {
                //如果合并不存在，则判断该发货单是否存在被合并的单据中
                $sn = $this->is_merged($exsit['invoice_id']);
                if ($sn === FALSE) {
                    return $exsit['invoice_sn'];
                }
                return $sn;
            }
        }
    }

    /**
     * 创建新的发货单的师傅请款单据【主要兼容老版本和新版的独立单据】
     * @param string $invoice_sn 发货单号
     */
    private function create_new_master_billing($invoice_sn) {
        //判断该发货单据是否存在师傅请款单据表中
        $exsit = $this->get_merge_info($invoice_sn);
        if ($exsit) {
            //已经存在师傅请款单据表中
            if ($exsit['merge_id']) {
                //如果merge_id存在,表示该发货单是合并发货单据
                $merge = explode(',', $exsit['merge_id']);
                if (is_array($merge)) {
                    //查询合并单据里面的真实发货单号
                    $billing_id = $this->create_invoice_billing('创建已经存在的合并发货单' . $invoice_sn . '的师傅请款单', strtotime($exsit['merge_time']), $exsit['oprator']);
                    foreach ($merge as $value) {
                        $this->update_billing_id($value, $billing_id, TRUE);
                    }
                }
            } else {
                //如果不存在，则表示该发货单是独立单据
                if ($exsit['billing_id'] > 0) {
                    //如果请款单据id存在，则获取该请款单据sn
                    $billing_id = $exsit['billing_id'];
                } else {
                    //如果不存在请款单据id,则需要新生成一个请款单据,然后在更新该发货单的billing_id
                    $billing_id = $this->create_invoice_billing('创建已经存在的发货单' . $invoice_sn . '的师傅请款单');
                    $this->update_billing_id($invoice_sn, $billing_id);
                }
            }
        } else {
            //不存在师傅请款单据表中,创建新的发货单对应的请款单据
            $billing_id = $this->create_invoice_billing('新建发货单' . $invoice_sn . '的师傅请款单');
            $this->create_invoice_billing_detail($invoice_sn, $billing_id);
        }
        return $billing_id;
    }

    /**
     * 创建新的师傅请款单据
     * @param string $note 备注
     * @param int $merge_time 合并时间
     * @param string $merger 合并人
     * @return int 请款单id
     */
    private function create_invoice_billing($note = '', $merge_time = FALSE, $merger = '') {
        $data = array(
            'billing_sn' => gen_bill_sn('MNV'),
            'add_time' => date('Y-m-d H:i:s'),
            'opreator' => $merger ? $merger : $_SESSION['admin_real_name'],
            'note' => $note,
        );
        $merge_time && $merge_time['merge_time'] = $_SERVER['REQUEST_TIME'];
        $this->db->autoExecute("ecs_stock_invoice_extend_info", $data);
        return $this->db->insert_id();
    }

    /**
     * 更新发货单的师傅请款单据id
     * @param mixed $invoice_sn 发货单sn或者id
     * @param int $billing_id  请款单id
     * @param boolean $index 是否是索引id
     */
    private function update_billing_id($invoice_sn, $billing_id, $index = FALSE) {
        $filter = $index ? "`invoice_id`='{$invoice_sn}'" : "`invoice_sn`='{$invoice_sn}'";
        $this->db->query("UPDATE `ecs_stock_invoice_extend` SET `billing_id`='{$billing_id}' WHERE {$filter}");
    }

    /**
     * 创建新的师傅请款单据详细信息
     * @param string $invoice_sn 发货单sn
     */
    private function create_invoice_billing_detail($invoice_sn, $billing_id, $index = FALSE) {
        $filter = $index ? "`invoice_id` = '{$invoice_sn}'" : "`invoice_sn` = '{$invoice_sn}'";
        $sql = "SELECT `invoice_id`, `invoice_sn`, `order_id`, `order_sn`, `fstatus` , `consignee` , `warehouse_id` FROM `ecs_stock_invoice_info` WHERE {$filter}";
        //查看该单据是否是真实数据，是否存在发货单数据库中
        $id = $this->db->getRow($sql);
        //判断单据sn否在存在发货单中
        $data = array(
            'invoice_sn' => $invoice_sn,
            'invoice_id' => $id['invoice_id'],
            'billing_id' => $billing_id,
            'invoice_fee' => '',
            'order_id' => $id['order_id'],
            'order_sn' => $id['order_sn'],
            'order_fee' => $this->order_amount_field($id['order_id']),
            'warehouse_id' => $id['warehouse_id'],
            'consignee' => $id['consignee'],
            'oprator' => $_SESSION['admin_real_name'],
            'status' => 'shipped',
        );
        $this->db->autoExecute("ecs_stock_invoice_extend", $data);
    }

    /**
     * 获取指定师傅请款id信息
     * @param int $billing_id 请款id
     * @return mixed 成功返回数组 否则返回false
     */
    private function get_master_billing($billing_id) {
        return $this->getRow("SELECT `id`, `billing_sn`, `add_time`, `merge_time`, `opreator`, `note` FROM `ecs_stock_invoice_extend_info` WHERE `id` = '{$billing_id}'");
    }

    /**
     * 费用显示
     * @param string $fee_type
     * @return string
     */
    public function set_fee_type($fee_type, $type = '', $array = '', $is_show = FALSE) {
        if (strpos($fee_type, ',') === FALSE) {
            $fee_type = $fee_type . ',';
        }
        $arr = explode(',', $fee_type);
        switch ($type) {
            case 1:
                foreach ($arr as $fee_id) {
                    if (in_array($fee_id, array_flip($array))) {
                        $is_show && $string .='<input type="checkbox" name="left_sel_combile_type[]"   value="' . $fee_id . '" checked ><span class="unused">' . self::$cost_type[$fee_id] . '</span>';

                        unset($array[$fee_id]);
                    }
                }
                if ($is_show) {
                    return $string;
                }
                foreach ($array as $key => $value) {
                    $string .='<input type="checkbox" name="left_sel_combile_type[]" value="' . $key . '">' . $value;
                }
                break;
            case 2:
                foreach ($arr as $fee_id) {
                    if (in_array($fee_id, array_flip($array))) {
                        $is_show && $string .='<input type="checkbox" name="right_sel_combile_type[]"   value="' . $fee_id . '" checked ><span class="unused">' . self::$cost_type[$fee_id] . '</span>';

                        unset($array[$fee_id]);
                    }
                }
                if ($is_show) {
                    return $string;
                }
                foreach ($array as $key => $value) {
                    $string .='<input type="checkbox" name="right_sel_combile_type[]" value="' . $key . '">' . $value;
                }
                break;
            case 3:
                foreach ($arr as $fee_id) {
                    if (in_array($fee_id, array_flip($array))) {
                        $is_show && $string .='<input type="checkbox" name="middle_sel_combile_type[]"   value="' . $fee_id . '" checked ><span class="unused">' . self::$cost_type[$fee_id] . '</span>';
                        unset($array[$fee_id]);
                    }
                }
                if ($is_show) {
                    return $string;
                }
                foreach ($array as $key => $value) {
                    $string .='<input type="checkbox" name="middle_sel_combile_type[]" value="' . $key . '">' . $value;
                }
                break;
            case '4':
                foreach ($arr as $fee_id) {
                    if (in_array($fee_id, array_flip($array))) {
                        $is_show && $string .='<input type="checkbox" name="right_sel_combile_type[]"   value="' . $fee_id . '" checked ><span class="unused">' . self::$cost_type[$fee_id] . '</span>';
                        unset($array[$fee_id]);
                    }
                }
                if ($is_show) {
                    return $string;
                }
                foreach ($array as $key => $value) {
                    $string .='<input type="checkbox" name="right_sel_combile_type[]" value="' . $key . '">' . $value;
                }
                break;
        }
        return $string;
    }

    /**
     * 费用信息
     * 发货单安装信息模块
     */
    public function invoice_installs() {
        $invoice_id = empty($_REQUEST['invoice_sn']) ? 0 : trim($_REQUEST['invoice_sn']);
        if ($invoice_id) {
            //发货单状态如果不是已发货状态的单据提示不能修改
            $invoices = $this->get_simple_stock_invoice($invoice_id);
            ($invoices['fstatus'] != 'shipped' && $invoices['status'] != 'shipped' ) && sys_msg("发货单：" . $invoice_id . '没有发货，不能申请费用!');
            //是否已经存在了发货单费用信息
            $installs = $this->get_invoice_fee_by_invoice_id($invoice_id);
            //如果费用信息已经添加过，则获取添加过的费用和师傅信息
            foreach ($installs as $row) {
                $exsit_fee_type .= $row['combile_fee_type'] . ',';
                if ($row['workers']) {
                    $exsit_worker .= $row['workers'] . ',';
                }
            }
            //取消已经选择过的费用类别
            $not_fee_type['worker'] = $this->set_fee_type($exsit_fee_type, 1, self::$cost_type);
            $not_fee_type['tmp_worker'] = $this->set_fee_type($exsit_fee_type, 2, self::$cost_type);
            $not_fee_type['out'] = $this->set_fee_type($exsit_fee_type, 3, self::$cost_type);
            $this->smarty->assign('not_fee_type', $not_fee_type);
            if ($exsit_worker) {
                //读取已经选择的师傅信息
                $workers = $this->get_show_master_name(trim($exsit_worker, ','), '');
                if ($installs['bank']) {
                    $waibao = $this->get_basic_bank($installs['bank']);
                    $this->smarty->assign("waibao_bank", $waibao);
                    $this->smarty->assign('mcountry_list', get_regions());
                    /* 取得省份 */
                    $this->smarty->assign('mprovince_list', get_regions(1, $waibao['country']));
                    /* 取得城市 */
                    $this->smarty->assign('mcity_list', get_regions(2, $waibao['provice']));
                    /* 取得区域 */
                    $this->smarty->assign('mdistrict_list', get_regions(3, $waibao['city']));
                }
            }
            //发货单基础信息
            $this->smarty->assign("invoices", $invoices);
            $this->smarty->assign('workers', $workers);
            $this->smarty->assign('worker', $this->get_master());
            $this->smarty->assign('master_type', self::$master_type);
            $this->smarty->assign('pay_way', self::$pay_way);
            $this->smarty->assign('pay_type', self::$pay_type);
            $this->smarty->assign('invoice_id', $invoice_id);
            $this->smarty->assign('bank', self::$bank);
            /* 显示模板 */
            $this->smarty->assign("installs", $installs);
            $this->smarty->assign('ur_here', '添加发货单费用信息');
            $this->smarty->assign('action_link', (array('text' => '发货单费用信息列表', 'href' => '?act=fee&invoice_sn=' . $invoice_id)));
            assign_query_info();
            $this->smarty->assign('FUNCTION', __FUNCTION__);
            $this->smarty->assign("full_page", TRUE);
            $this->smarty->display(self::$TEMPLATE);
        } else {
            sys_msg("发货单不能为空！");
        }
    }

    /**
     * 修改页面
     */
    public function invoice_fee_step() {
        $invoice_id = empty($_REQUEST['invoice_id']) ? 0 : trim($_REQUEST['invoice_id']);
        $step = empty($_REQUEST['type']) ? '' : intval($_REQUEST['type']);
        $install_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
        $data = $this->get_invoice_fee_by_id($install_id);
        //判断发货单费用类别是否已使用完
        $bool = $this->invoice_fee_is_used($invoice_id);
        $bool && $this->smarty->assign('not_add', $bool);
        //师傅信息
        if ($data['workers']) {
            $master_info = $this->get_master_info($data['workers']);
            $this->smarty->assign('master_info', $master_info);
            //身份证号码归属 
            /* 取得国家 */
            $this->smarty->assign('_country_list', get_regions());
            if ($master_info['country'] > 0) {
                /* 取得省份 */
                $this->smarty->assign('_province_list', get_regions(1, $master_info['country']));
                if ($master_info['province_id'] > 0) {
                    /* 取得城市 */
                    $this->smarty->assign('_city_list', get_regions(2, $master_info['province_id']));
                    if ($master_info['city_id'] > 0) {
                        /* 取得区域 */
                        $this->smarty->assign('_district_list', get_regions(3, $master_info['city_id']));
                    }
                }
            }

            if ($master_info['bank_ids']) {

                //获取银行信息
                $id_bank = $this->get_basic_bank($master_info['bank_ids']);
                $this->smarty->assign('id_bank', $id_bank);

                /* 取得国家 */
                $this->smarty->assign('id_country_list', get_regions());
                if ($id_bank['country'] > 0) {
                    /* 取得省份 */
                    $this->smarty->assign('id_province_list', get_regions(1, $id_bank['country']));
                    if ($id_bank['provice'] > 0) {
                        /* 取得城市 */
                        $this->smarty->assign('id_city_list', get_regions(2, $id_bank['provice']));
                        if ($id_bank['city'] > 0) {
                            /* 取得区域 */
                            $this->smarty->assign('id_district_list', get_regions(3, $id_bank['city']));
                        }
                    }
                }
            }
        }
        $this->smarty->assign("select_master", $this->get_show_master_name($data['workers'], $data['master_type']));
        $this->smarty->assign("installs", $data);
        $this->smarty->assign("invoices", $this->get_simple_stock_invoice($invoice_id));
        $this->smarty->assign('worker', $this->get_master());
        $this->smarty->assign('pay_way', self::$pay_way);
        $this->smarty->assign('pay_type', self::$pay_type);
        $this->smarty->assign('invoice_id', $invoice_id);
        $this->smarty->assign('bank', self::$bank);
        $this->smarty->assign("FUNCTION", __FUNCTION__);
        $this->smarty->assign('full_page', 1);
        $this->smarty->assign("STEP", $step);
        //导航
        $this->smarty->assign('ur_here', '修改发货单费用基础信息');
        $this->smarty->assign('action_link', (array('text' => '发货单费用信息列表', 'href' => '?act=fee&invoice_sn=' . $invoice_id)));
        $this->smarty->display(self::$TEMPLATE);
    }

    /**
     * 添加或编辑发货单费用处理逻辑
     */
    public function invoice_installs_action() {
        //操作类型
        $type = empty($_REQUEST['type']) ? '' : trim($_REQUEST['type']);
        //发货单安装信息处理模块
        $invoice_id = empty($_REQUEST['invoice_id']) ? 0 : trim($_REQUEST['invoice_id']);
        $install_id = empty($_REQUEST['install_id']) ? 0 : intval($_REQUEST['install_id']);
        if (!$invoice_id) {
            sys_msg('参数错误！');
        }
        //基础信息组装
        $invoice_installs = array(
            'invoice_sn' => $invoice_id,
            'percent' => empty($_REQUEST[$type . '_percent']) ? 0 : trim($_REQUEST[$type . '_percent']),
        );
        if (!$install_id) {
            $invoice_installs['add_time'] = date('Y-m-d H:i:s');
            $invoice_installs['oprator'] = $_SESSION['admin_real_name'];
        }
        //并发问题，如果同时在修改和更新状态，则先判断如果没有设置请款则还可以修改
        $do_ing = $this->get_invoice_fee_by_id($install_id);
        $do_ing['status'] = (int) $do_ing['status'];
        if ($do_ing['status'] == 0 || $do_ing['status'] == 2 || $do_ing['status'] == 4 || $do_ing['status'] == 5) {
            
        } else {
            sys_msg("单据在请款中不能修改！");
        }
        switch ($type) {
            case 'left':
                /**
                 * 如果师傅类型选择了职工
                 */
                $invoice_installs['master_type'] = 1;
                $invoice_installs['pay_type'] = empty($_REQUEST['left_pay_type']) ? 0 : intval($_REQUEST['left_pay_type']);
                $invoice_installs['pay_way'] = empty($_REQUEST['left_pay_way']) ? 0 : intval($_REQUEST['left_pay_way']);
                //费用类别组合
                $fee_fixed_type = empty($_REQUEST['left_sel_combile_type']) ? '' : ($_REQUEST['left_sel_combile_type']);
                $fee_fixed_type = implode(',', $fee_fixed_type);
                if (empty($fee_fixed_type) && !$install_id) {
                    sys_msg('错误：没有选择费用类别！');
                }
                if ($fee_fixed_type && !$install_id) {

                    $fee_id = $this->get_exsits_fee_type($invoice_id, $fee_fixed_type);
                    if ($fee_id) {
                        sys_msg('该单据已经存在了相同费用类别组合信息！');
                    }
                    $invoice_installs['combile_fee_type'] = $fee_fixed_type;
                }
                //修改费用信息
                if ($fee_fixed_type && $install_id) {
                    //判断选择的是否和数据库存储的相等
                    $sql = "SELECT `id` FROM `ecs_stock_invoice_installs_fee` WHERE `id` ='{$install_id}' AND (`combile_fee_type` = '{$fee_fixed_type}' OR `combile_fee_type` = '" . strrev($fee_fixed_type) . "')";
                    $eq_fee = $this->db->getOne($sql);
                    if (!$eq_fee) {
                        $this->db->query("UPDATE `ecs_stock_invoice_installs_fee` SET `combile_fee_type` = '{$fee_fixed_type}' WHERE `id` = {$install_id}");
                    }
                }
                $worker = empty($_REQUEST['zhigong']) ? '' : ($_REQUEST['zhigong']);
                //职工信息
                if (!$install_id) {
                    if ($worker) {
                        $invoice_installs['workers'] = implode(',', $worker);
                    }
                } else {
                    $wk = $this->get_invoice_fee_by_id($install_id);
                    if ($worker) {
                        $invoice_installs['workers'] = $wk['workers'] . ',' . implode(',', $worker);
                    }
                }
                $invoice_installs['remark'] = empty($_REQUEST['left_remark']) ? '' : trim($_REQUEST['left_remark']);
                if ($install_id) {
                    $this->db->autoExecute('ecs_stock_invoice_installs_fee', $invoice_installs, 'UPDATE', ' id =' . $install_id);
                    $this->insert_opt_log($invoice_id, '更新' . $invoice_id . '费用成功');
                } else {
                    $this->db->autoExecute('ecs_stock_invoice_installs_fee', $invoice_installs);
                    $this->insert_opt_log($invoice_id, '添加' . $invoice_id . '费用成功');
                }
                break;
            case 'right':
                //如果师傅类型选择临时
                /**
                 * 基础信息
                 */
                $bank_exsit_id = empty($_REQUEST['bank_id']) ? 0 : intval($_REQUEST['bank_id']);
                $master_id = empty($_REQUEST['master_id']) ? 0 : intval($_REQUEST['master_id']);
                $invoice_installs['master_type'] = 2;
                $invoice_installs['pay_type'] = empty($_REQUEST['right_pay_type']) ? 0 : intval($_REQUEST['right_pay_type']);
                $invoice_installs['pay_way'] = empty($_REQUEST['right_pay_way']) ? 0 : intval($_REQUEST['right_pay_way']);
                //费用类别组合
                $fee_fixed_type = empty($_REQUEST['right_sel_combile_type']) ? '' : ($_REQUEST['right_sel_combile_type']);
                $fee_fixed_type = implode(',', $fee_fixed_type);
                if (empty($fee_fixed_type) && !$install_id) {
                    sys_msg('错误：没有选择费用类别！');
                }
                if ($fee_fixed_type && !$install_id) {
                    $fee_id = $this->get_exsits_fee_type($invoice_id, $fee_fixed_type);
                    if ($fee_id) {
                        sys_msg('该单据已经存在了相同费用类别组合信息！');
                    }
                    $invoice_installs['combile_fee_type'] = $fee_fixed_type;
                }
                //修改费用信息
                if ($fee_fixed_type && $install_id) {
                    //判断选择的是否和数据库存储的相等
                    $sql = "SELECT `id` FROM `ecs_stock_invoice_installs_fee` WHERE `id` ='{$install_id}' AND (`combile_fee_type` = '{$fee_fixed_type}' OR `combile_fee_type` = '" . strrev($fee_fixed_type) . "')";
                    $eq_fee = $this->db->getOne($sql);
                    if (!$eq_fee) {
                        $this->db->query("UPDATE `ecs_stock_invoice_installs_fee` SET `combile_fee_type` = '{$fee_fixed_type}' WHERE `id` = {$install_id}");
                    }
                }

                $invoice_installs['combile_total_fee'] = empty($_REQUEST['right_tmp_fee']) ? 0 : floatval($_REQUEST['right_tmp_fee']);
                $invoice_installs['remark'] = empty($_REQUEST['right_remark']) ? 0 : trim($_REQUEST['right_remark']);
                /**
                 * 银行信息
                 */
                $bank_country = empty($_REQUEST['right_country']) ? 1 : intval($_REQUEST['right_country']);
                $bank_province = empty($_REQUEST['right_province']) ? '' : intval($_REQUEST['right_province']);
                $bank_city = empty($_REQUEST['right_city']) ? '' : intval($_REQUEST['right_city']);
                $bank_region = empty($_REQUEST['right_district']) ? '' : intval($_REQUEST['right_district']);
                $bank_number = empty($_REQUEST['right_bank_card_number']) ? '' : trim($_REQUEST['right_bank_card_number']);
                $bank_type = empty($_REQUEST['right_bank_card_type']) ? '' : trim($_REQUEST['right_bank_card_type']);
                $bank_name = empty($_REQUEST['right_bank_card_name']) ? '' : trim($_REQUEST['right_bank_card_name']);
                $bank_array = array(
                    'country' => $bank_country,
                    'provice' => $bank_province,
                    'city' => $bank_city,
                    'region' => $bank_region,
                    'bank_type' => $bank_type,
                    'bank_card_number' => $bank_number,
                    'bank_card_name' => $bank_name,
                    'sub_bank' => empty($_REQUEST['right_sub_bank']) ? '' : trim($_REQUEST['right_sub_bank']),
                );

                $bank_id = $this->insert_bank_info($bank_array, $bank_exsit_id);
                if (!$bank_id) {
                    sys_msg('银行信息不完整，请重新填写！');
                }
                /**
                 * 师傅信息
                 */
                $master_name = empty($_REQUEST['right_master_right']) ? '' : trim($_REQUEST['right_master_right']);
                $master_tell = empty($_REQUEST['right_master_call']) ? '' : trim($_REQUEST['right_master_call']);
                $master_identity = empty($_REQUEST['right_card']) ? '' : trim($_REQUEST['right_card']);
                $master_idcountry = empty($_REQUEST['right_country']) ? 1 : intval($_REQUEST['right_country']);
                $master_idProvinces = empty($_REQUEST['right_province']) ? '' : intval($_REQUEST['right_province']);
                $master_idcity = empty($_REQUEST['right_city']) ? '' : intval($_REQUEST['right_city']);
                $master_iddistrict = empty($_REQUEST['right_district']) ? '' : intval($_REQUEST['right_district']);
                $master_array = array(
                    'identity_card' => $master_identity,
                    'bank_ids' => $bank_id,
                    'country' => $master_idcountry,
                    'region' => $master_iddistrict,
                    'province_id' => $master_idProvinces,
                    'city_id' => $master_idcity,
                    'contact_name' => $master_name,
                    'phone' => $master_tell,
                );

                $id = $this->is_same_identity_card($master_identity, $master_name);
                if ($id === FALSE) {
                    // sys_msg("该身份证与库中身份证姓名不一致，请重试！");
                    //如果之前的师傅存在，则更新之前的信息
                    $m_row = $this->db->getOne("SELECT `identity_card` FROM  `ecs_install_data`  WHERE `contact_name` = '{$master_name}'");
                    if ($m_row) {
                        $this->db->query("UPDATE `ecs_install_data` SET `identity_card` = '{$master_identity}' WHERE `contact_name` = '{$master_name}'");
                        $master_id = $this->db->getOne("SELECT `install_id` FROM  `ecs_install_data`  WHERE `contact_name` = '{$master_name}'");
                    }
                } elseif (is_numeric($id)) {
                    $master_id = $id;
                }

                $master_id = $this->insert_master_info($master_array, $master_id);
                //临时职工信息
                $invoice_installs['workers'] = $master_id;
                if ($install_id) {
                    $this->db->autoExecute('ecs_stock_invoice_installs_fee', $invoice_installs, 'UPDATE', ' id =' . $install_id);
                    $this->insert_opt_log($invoice_id, '更新' . $invoice_id . '费用成功');
                } else {
                    $this->db->autoExecute('ecs_stock_invoice_installs_fee', $invoice_installs);
                    $this->insert_opt_log($invoice_id, '添加' . $invoice_id . '费用成功');
                }
                break;
            case 'middle':
                //如果师傅类型选择了外包
                /**
                 * 基础信息
                 */
                $master_id = empty($_REQUEST['master_id']) ? 0 : intval($_REQUEST['master_id']);
                $bank_exsit_id = empty($_REQUEST['bank_id']) ? 0 : intval($_REQUEST['bank_id']);
                $invoice_installs['master_type'] = 3;
                $invoice_installs['pay_type'] = empty($_REQUEST['middle_pay_type']) ? 0 : intval($_REQUEST['middle_pay_type']);
                $invoice_installs['pay_way'] = empty($_REQUEST['middle_pay_way']) ? 0 : intval($_REQUEST['middle_pay_way']);
                //费用类别组合
                $fee_fixed_type = empty($_REQUEST['middle_sel_combile_type']) ? '' : ($_REQUEST['middle_sel_combile_type']);
                $fee_fixed_type = implode(',', $fee_fixed_type);
                if (empty($fee_fixed_type) && !$install_id) {
                    sys_msg('错误：没有选择费用类别！');
                }
                if ($fee_fixed_type && !$install_id) {

                    $fee_id = $this->get_exsits_fee_type($invoice_id, $fee_fixed_type);
                    if ($fee_id) {
                        sys_msg('该单据已经存在了相同费用类别组合信息！');
                    }
                    $invoice_installs['combile_fee_type'] = $fee_fixed_type;
                }
                //修改费用信息
                if ($fee_fixed_type && $install_id) {
                    //判断选择的是否和数据库存储的相等
                    $sql = "SELECT `id` FROM `ecs_stock_invoice_installs_fee` WHERE `id` ='{$install_id}' AND (`combile_fee_type` = '{$fee_fixed_type}' OR `combile_fee_type` = '" . strrev($fee_fixed_type) . "')";
                    $eq_fee = $this->db->getOne($sql);
                    if (!$eq_fee) {
                        $this->db->query("UPDATE `ecs_stock_invoice_installs_fee` SET `combile_fee_type` = '{$fee_fixed_type}' WHERE `id` = {$install_id}");
                    }
                }
                $invoice_installs['combile_total_fee'] = empty($_REQUEST['middle_outsourcing_fee']) ? 0 : floatval($_REQUEST['middle_outsourcing_fee']);
                $invoice_installs['remark'] = empty($_REQUEST['middle_remark']) ? '' : trim($_REQUEST['middle_remark']);

                /**
                 * 银行信息
                 */
                $bank_country = empty($_REQUEST['middle_country']) ? 1 : intval($_REQUEST['middle_country']);
                $bank_province = empty($_REQUEST['middle_province']) ? '' : intval($_REQUEST['middle_province']);
                $bank_city = empty($_REQUEST['middle_city']) ? '' : intval($_REQUEST['middle_city']);
                $bank_region = empty($_REQUEST['middle_district']) ? '' : intval($_REQUEST['middle_district']);
                $bank_number = empty($_REQUEST['middle_bank_card_number']) ? '' : trim($_REQUEST['middle_bank_card_number']);
                $bank_type = empty($_REQUEST['middle_bank_card_type']) ? '' : trim($_REQUEST['middle_bank_card_type']);
                $bank_name = empty($_REQUEST['middle_bank_card_title']) ? '' : trim($_REQUEST['middle_bank_card_title']);
                $bank_array = array(
                    'country' => $bank_country,
                    'provice' => $bank_province,
                    'city' => $bank_city,
                    'region' => $bank_region,
                    'bank_type' => $bank_type,
                    'bank_card_number' => $bank_number,
                    'bank_card_name' => $bank_name,
                    'sub_bank' => empty($_REQUEST['middle_sub_bank']) ? '' : trim($_REQUEST['middle_sub_bank']),
                );

                $bank_id = $this->insert_bank_info($bank_array, $bank_exsit_id);
                if (!$bank_id) {
                    sys_msg('银行信息不完整，请重新填写！');
                }
                //师傅信息
                $master_identity = empty($_REQUEST['middle_card']) ? '' : trim($_REQUEST['middle_card']);
                $master_tell = empty($_REQUEST['middle_master_call']) ? '' : trim($_REQUEST['middle_master_call']);
                $master_name = empty($_REQUEST['middle_master_right']) ? '' : trim($_REQUEST['middle_master_right']);
                if (!$master_identity || !$master_tell || !$master_name) {
                    //如果为空
                    sys_msg('承包人或电话或身份证不能为空！');
                }
                $master_array = array(
                    'identity_card' => $master_identity,
                    'bank_ids' => $bank_id,
                    'country' => $master_idcountry,
                    'region' => $master_iddistrict,
                    'province_id' => $master_idProvinces,
                    'city_id' => $master_idcity,
                    'contact_name' => $master_name,
                    'phone' => $master_tell,
                );
                $id = $this->is_same_identity_card($master_identity, $master_name);
                if ($id === FALSE) {
                    //sys_msg("该身份证与库中身份证姓名不一致，请重试！");
                    //如果之前的师傅存在，则更新之前的信息
                    $m_row = $this->db->getOne("SELECT `identity_card` FROM  `ecs_install_data`  WHERE `contact_name` = '{$master_name}'");
                    if ($m_row) {
                        $this->db->query("UPDATE `ecs_install_data` SET `identity_card` = '{$master_identity}' WHERE `contact_name` = '{$master_name}'");
                        $master_id = $this->db->getOne("SELECT `install_id` FROM  `ecs_install_data`  WHERE `contact_name` = '{$master_name}'");
                    }
                } elseif (is_numeric($id)) {
                    $master_id = $id;
                }

                $master_id = $this->insert_master_info($master_array, $master_id);
                //临时职工信息
                $invoice_installs['workers'] = $master_id;
                if ($install_id) {
                    $this->db->autoExecute('ecs_stock_invoice_installs_fee', $invoice_installs, 'UPDATE', ' id =' . $install_id);
                    $this->insert_opt_log($invoice_id, '更新' . $invoice_id . '费用成功');
                } else {
                    $this->db->autoExecute('ecs_stock_invoice_installs_fee', $invoice_installs);
                    $this->insert_opt_log($invoice_id, '添加' . $invoice_id . '费用成功');
                }
                break;
        }

        sys_msg('操作成功！', 0, array(array('text' => '单据费用信息', 'href' => '?act=fee&invoice_sn=' . $invoice_id)));
    }

    /**
     * 添加安装师傅信息
     * @param array $data 师傅信息
     * @return id  师傅id
     */
    public function insert_master_info($data, $exsit_id = '') {
        $where = "";
        foreach ($data as $key => $value) {
            $where .=" AND `$key` = '" . $value . "'";
        }
        //如果银行信息存在，则返回id
        $id = $this->db->getOne("SELECT `install_id` FROM `ecs_install_data` WHERE 1 {$where}");
        if ($id) {
            return $id;
        } else {
            if ($exsit_id) {
                $this->db->autoExecute('ecs_install_data', $data, 'UPDATE', 'install_id=' . $exsit_id);
                return $exsit_id;
            } else {
                $this->db->autoExecute('ecs_install_data', $data);
                return $this->db->insert_id();
            }
        }
    }

    /**
     * 判断身份证是否相同
     * @param string $identity_card 身份证号码
     * @return 存在返回true否则返回false
     */
    private function is_same_identity_card($identity_card, $name) {
        $sql = "SELECT `install_id`, `contact_name` FROM `ecs_install_data` WHERE `identity_card` ='{$identity_card}'";
        $id = $this->db->getRow($sql);

        return !$id ? TRUE : $id['contact_name'] == $name ? $id['install_id'] : FALSE;
    }

    /**
     * 获取可用的费用类别
     * @param mixed $remove 需要去除的费用类别
     * @return string 可用的费用类别
     */
    public static function availabe_fee_type($remove) {
        if (strpos($remove, ',') === FALSE) {
            unset(self::$cost_type[$remove]);
        } else {
            $remove_arr = explode(',', $remove);
            foreach ($remove_arr as $value) {
                unset(self::$cost_type[$value]);
            }
        }
        return self::$cost_type;
    }

    /**
      查询发货单的组合费用类别是否存在
     * @param int $invoice_id 发货单id
     * @param string $fixed 费用类别组合信息
     * @return 存在返回id 否则返回false
     */
    public function get_exsits_fee_type($invoice_id, $fixed) {
        $sql = "SELECT `id` FROM `ecs_stock_invoice_installs_fee` WHERE `invoice_sn` ='{$invoice_id}' AND (`combile_fee_type` = '{$fixed}' OR `combile_fee_type` = '" . strrev($fixed) . "')";
        return $this->db->getOne($sql, TRUE);
    }

    /**
     * 获取指定发货单的费用信息
     * @param int $invoice_id 发货单id
     */
    function get_invoice_fee_by_invoice_id($install_id) {
        $array = array();
        $sql = "SELECT `id`, `invoice_sn`, `master_type`, `combile_fee_type`, `combile_total_fee`, `pay_way`, `percent`, `pay_type`, `workers`, `remark`, `status`, `add_time`, `billing_time`, `oprator` FROM `ecs_stock_invoice_installs_fee` WHERE  `invoice_sn` = '{$install_id}'";
        $list = $this->db->getAll($sql);
        foreach ($list as $key => $value) {
            $value['master_type_name'] = self::$master_type[$value['master_type']];
            $value['pay_way_name'] = self::$pay_way[$value['pay_way']];
            $value['pay_type_name'] = self::$pay_type[$value['pay_type']];
            $value['fee_string'] = $this->set_fee_type($value['combile_fee_type'], $value['master_type'], self::$cost_type, TRUE);
            $value['master'] = $this->get_show_master_name($value['workers'], $value['master_type']);
            $value['billing_time'] = $value['billing_time'] == '0000-00-00 00:00:00' ? '' : $value['billing_time'];
            $value['add_time'] = $value['add_time'] == '0000-00-00 00:00:00' ? '' : $value['add_time'];
            $value['percent'] = $value['percent'] == '0.000' ? '' : $value['percent'];
            $array[$key] = $value;
        }
        return $array;
    }

    /**
     * 获取指定发货单的费用信息
     * @param int $invoice_id 发货单id
     */
    function get_invoice_fee_by_id($install_id) {
        $sql = "SELECT `id`, `invoice_sn`, `master_type`, `combile_fee_type`, `combile_total_fee`, `pay_way`, `percent`, `pay_type`, `workers`, `remark`, `status`, `add_time`, `billing_time`, `oprator` FROM `ecs_stock_invoice_installs_fee` WHERE `id` = {$install_id}";
        $value = $this->db->getRow($sql);
        $value['master_type_name'] = self::$master_type[$value['master_type']];
        $value['pay_way_name'] = self::$pay_way[$value['pay_way']];
        $value['pay_type_name'] = self::$pay_type[$value['pay_type']];
        $value['fee_string'] = $this->set_fee_type($value['combile_fee_type'], $value['master_type'], self::$cost_type, TRUE);
        $value['billing_time'] = $value['billing_time'] == '0000-00-00 00:00:00' ? '' : $value['billing_time'];
        $value['add_time'] = $value['pay_time'] == '0000-00-00 00:00:00' ? '' : $value['add_time'];
        $value['percent'] = $value['percent'] == '0.000' ? '' : $value['percent'];
        return $value;
    }

    /**
     * 获取内部师傅信息
     */
    function get_master() {
        $worker = array();
        //聘请师傅
        $outside = $this->db->getAll("SELECT `install_id` , `contact_name` FROM `ecs_install_data` ");
        foreach ($outside as $out) {
            $worker[$out['install_id']] = $out['contact_name'];
        }
        return $worker;
    }

    /**
     * 获取师傅名称
     * @param int $id id
     * @return string 名称
     */
    function get_master_name($id) {
        return $this->db->getOne("SELECT `contact_name` FROM `ecs_install_data` WHERE `install_id` = {$id} ");
    }

    /**
     * 获取师傅信息
     * @param int $id 师傅id
     * @return array 师傅数组
     */
    public function get_master_info($id) {
        if (strpos($id, ',') === FALSE) {
            return $this->db->getRow("SELECT * FROM `ecs_install_data` WHERE `install_id`={$id} ");
        }
    }

    /**
     * 格式化显示存在的师傅名称
     * @param string $master 师傅id字符串
     * @return string 格式
     */
    public function get_show_master_name($master, $type = '') {
        if (strpos($master, ',') === FALSE) {
            $string = '<input type="checkbox" name="zhigong[]" value="' . $master . '" checked disabled><span class="unused">' . $this->get_master_name($master) . '</span>';
        } else {
            $arr = explode(',', $master);
            foreach ($arr as $value) {
                if ($value) {
                    $string .= '<input type="checkbox" name="zhigong[]" value="' . $value . '" checked disabled><span class="unused">' . $this->get_master_name($value) . '</font>';
                }
            }
        }
        return $string;
    }

    /**
     * 判断身份证是否存在
     * @param int $card
     * @return mixed
     */
    function get_exsit_worker($card) {
        $sql = "SELECT `install_id` FROM `ecs_install_data` WHERE `identity_card` = '{$card}'";
        return $this->db->getRow($sql);
    }

    /**
     * 插入银行信息
     * @param array $bank_data 银行信息
     * @return int 银行信息id
     */
    function insert_bank_info($bank_data, $exsit_id) {

        $bid = $this->db->getOne("SELECT id from ecs_basic_account WHERE bank_card_number = '" . $bank_data['bank_card_number'] . "'");
        if ($bid) {
            $this->db->autoExecute('ecs_basic_account', $bank_data, 'UPDATE', 'id=' . $bid);
            return $bid;
        }

        //如果银行信息存在，则返回id

        if ($exsit_id) {
            $this->db->autoExecute('ecs_basic_account', $bank_data, 'UPDATE', 'id=' . $exsit_id);
            return $exsit_id;
        } else {
            $this->db->autoExecute('ecs_basic_account', $bank_data);
            return $this->db->insert_id();
        }
    }

    /**
     * 获取银行信息
     * @param int $id
     * @return array
     */
    function get_basic_bank($id) {
        $row = $this->db->getRow("SELECT `id`, `country`, `provice`, `city`, `region`, `bank_type`, `bank_card_number`, `bank_card_name`, `sub_bank` FROM `ecs_basic_account` WHERE `id` = {$id}");
        if ($row) {
            $row['country_name'] = $this->get_regoin_name($row['country']);
            $row['provice_name'] = $this->get_regoin_name($row['provice']);
            $row['city_name'] = $this->get_regoin_name($row['city']);
            $row['region_name'] = $this->get_regoin_name($row['region']);
        }
        return $row;
    }

    function get_regoin_name($id) {
        return $this->db->getOne("SELECT `region_name` FROM ecs_region WHERE `region_id` = $id");
    }

    /**
     * 获取发货单的基础信息
     * @param int $id 发货单id
     * @return array 发货单信息
     */
    public function get_simple_stock_invoice($id) {
//        $sql = "SELECT `invoice_id`, `invoice_sn`, `order_id`, `order_sn`, `fstatus` , `consignee` , `warehouse_id` FROM `ecs_stock_invoice_info` WHERE `invoice_id` = '{$id}' OR `invoice_sn` = '{$id}'";
//        if ($row = $this->db->getRow($sql, TRUE)) {
//            $row['fstatus_name'] = self::$invoice_status[$row['fstatus']];
//            $row['warehouse'] = $this->get_warehouse_name($row['warehouse_id']);
//            $row['order_fee'] = $this->order_amount_field($row['order_id']);
//            return $row;
//        }
        //如果发货单不存在，判断合并单据是否存在
        if ($merge = $this->get_merge_info($id)) {
            return $merge;
        }
        return false;
    }

    /**
     * 获取合并的单据信息
     * @param string $invoice_sn 合并单号
     * @return array 单据array
     */
    private function get_merge_info($invoice_sn) {
        $sql = " SELECT `id`, `billing_id`, `invoice_sn`, `invoice_id`, `merge_id`, `merge_time`, `invoice_fee`, `order_id`, `order_sn`, `order_fee`, `oprator`, `warehouse_id`, `consignee`, `status` FROM `ecs_stock_invoice_extend` WHERE  `invoice_sn`='{$invoice_sn}'";
        return $this->db->getRow($sql);
    }

    public function get_warehouse_name($id) {
        return $this->db->getOne("select name from ecs_warehouse WHERE `warehouse_id` = {$id}");
    }

    /**
     * 异步合并发货单费用并创建单据
     */
    public function ajax_merge_fee() {
        $invoice_ids = empty($_REQUEST['ids']) ? '' : trim($_REQUEST['ids']);

        if (strpos($invoice_ids, ',') === FALSE) {
            make_json_error('至少选择两个发货单！');
        }
        //循环处理多个发货单信息
//        $invoices = explode(',', $invoice_ids);
//        foreach ($invoices as $id) {
//            $value = $this->db->getRow("SELECT `invoice_sn`,`expr_id`,`warehouse_id` FROM `ecs_stock_invoice_info` WHERE `invoice_id` = '{$id}'");
//            //盘点单据是否已经设置过费用信息
//            $this->get_invoice_fee_by_invoice_id($value['invoice_sn']) && make_json_error('发货单:' . $id . ' 已经申请过费用，请选则其他发货单在试！');
//            //如果不是已发货的发货单则不能合并
//            $this->invoice_is_ship($id) === FALSE && make_json_error('发货单:' . $id . ' 还没有发货，请选则其他发货单在试！');
//            //如果发货单里面的订单是体验馆掉货订单就不能合并
//            $this->invoice_is_exper_order($id) === TRUE && make_json_error('发货单:' . $id . ' 的订单是体验馆掉货订单，请选则其他发货单在试！');
//            //如果发货单已经被合并过，则不需要再次合并
//            $this->is_merged($id) && make_json_error('发货单:' . $id . ' 已经合并过，请选则其他发货单在试！');
//            //如果不是体验馆的订单
//            $this->invoice_is_exper_order_r($id) == FALSE && make_json_error('发货单:' . $id . ' 不是体验馆订单！');
//            //如果体验馆权限不足
//            ($value['expr_id'] == $this->get_user_expr_id() || $value['warehouse_id'] == $this->get_user_warehouse() || $value['warehouse_id'] == 1 || $value['warehouse_id'] == 130 || $value['warehouse_id'] == 63) == FALSE && make_json_error('发货单:' . $id . '不能合并，可能是某些单没有相关费用设置或没权限操作！');
//        }
        /**
         * 优化数据库V2.0版本
         */
//        $id = $this->create_new_merge_master_billing($invoice_ids);
        $id = $this->create_merge_invoice($invoice_ids);
        $id ? make_json_result($id, '合并发货单成功！') : make_json_error('合并发货单失败！');
    }

    /**
     * 发货单已经被合并过
     * @param int $id 发货单id
     * @return 合并过返回真，否则返回false
     */
    private function is_merged($id) {
        $sql = "SELECT `invoice_sn`  FROM `ecs_stock_invoice_extend` WHERE  FIND_IN_SET('{$id}',merge_id)";
        $is_merge = $this->db->getOne($sql);
        return empty($is_merge) ? FALSE : $is_merge;
    }

    /**
     * 更新归属合并费用单据
     * @param int $invoce_id 发货单
     */
    private function insert_invoce_merge($invoce_id, $sn) {
        foreach ($invoce_id as $id) {
            if ($id) {
                $this->db->query("UPDATE `ecs_stock_invoice_info` SET `merge` = '{$sn}' WHERE `invoice_id` = {$id}");
            }
        }
    }

    /**
     * 合并请款单号
     */
    private function create_merge_invoice($id) {
        foreach (explode(',', $id) as $value) {
            $sn = $this->db->getOne('SELECT  `invoice_sn` FROM `ecs_stock_invoice_info` WHERE `invoice_id` = ' . $value);
            $this->no_exsit_in_extend($sn);
        }

        $invoice_sn = gen_bill_sn("INV");
        $data = array(
            'status' => 'shipped',
            'invoice_sn' => $invoice_sn,
            'merge_id' => $id,
            'merge_time' => date('Y-m-d H:i:s'),
            'oprator' => $_SESSION['admin_real_name'],
        );
        $this->db->autoExecute("ecs_stock_invoice_extend", $data);
        return $invoice_sn;
    }

    /**
     * 创建新的发货单的师傅请款单据【新版的合并发货单的请款单据】
     * @param string $invoice_ids 发货单id
     * @return boolean 成功合并返回合并单据id 否则返回false
     */
    private function create_new_merge_master_billing($invoice_ids) {
        $ids = explode(',', $invoice_ids);
        foreach ($ids as $value) {
            $id = $this->db->getOne("select id from ecs_stock_invoice_extend where invoice_id = '{$value}'");
            if ($id) {
                return FALSE;
            }
        }
        $billing_id = $this->create_invoice_billing('创建新的合并发货单的师傅请款单', TRUE);
        foreach ($ids as $id) {
            $this->create_invoice_billing_detail($id, $billing_id, TRUE);
        }
        return $billing_id;
    }

    /**
     * 发货单是否是已经发货
     * @param int $id 发货单id
     */
    private function invoice_is_ship($id, $status = 'shipped') {
        return $this->db->getOne("SELECT `invoice_id` FROM `ecs_stock_invoice_info` WHERE `invoice_id` = {$id} AND `fstatus` = '{$status}'") > 0 ? TRUE : FALSE;
    }

    /**
     * 发货单里面的订单是体验馆掉货订单
     * @param int $id 发货单id
     */
    private function invoice_is_exper_order($id, $order_type = 'exper_order') {
        $sql = "SELECT  `order_id` FROM `ecs_stock_invoice_info` WHERE `invoice_id` = {$id}";
        $order_id = $this->db->getOne($sql);
        if ($order_id) {
            return $this->db->getOne("SELECT `order_id` FROM `ecs_order_info` WHERE `order_id` = {$order_id} AND `order_type` = '{$order_type}'") > 0 ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * 发货单是否在合并的单据中
     * @param int $invoice_id 发货单id
     */
    private function merge_info($invoice_id) {
        $sql = "SELECT `id`, `invoice_sn`, `invoice_id`, `merge_id`, `merge_time`, `invoice_fee`, `order_id`, `order_sn`, `order_fee`, `oprator`, `warehouse_id`, `consignee`, `status` FROM `ecs_stock_invoice_extend` WHERE  `invoice_sn` = '{$invoice_id}'";
        return $this->db->getRow($sql);
    }

    /**
     * 获取指定师傅请款id的详细信息
     * @param int $billing_id 请款单id
     */
    private function get_master_billing_detail($billing_id) {
        return $this->db->getAll("SELECT `id`, `billing_id`, `invoice_sn`, `invoice_id`, `merge_id`, `merge_time`, `invoice_fee`, `order_id`, `order_sn`, `order_fee`, `oprator`, `warehouse_id`, `consignee`, `status` FROM `ecs_stock_invoice_extend` WHERE `billing_id` = {$billing_id}");
    }

    /**
     * 判断发货单费用类别是否已使用完
     * @param int $invoice 发货单id
     */
    private function invoice_fee_is_used($invoice) {
        $invoice_fee_info = $this->get_invoice_fee_by_invoice_id($invoice);
        foreach ($invoice_fee_info as $fee) {
            $fees .=$fee['combile_fee_type'] . ',';
        }
        $rand_fee = trim($fees, ',');
        $sort_fee = explode(',', $rand_fee);
        $diff = array_diff(array_flip(self::$cost_type), $sort_fee);
        return $diff ? FALSE : TRUE;
    }

    /**
     * 获取单据日志
     * @param int $invoice_id 单据id
     * @return mixed 成功返回日志array 否则返回false
     */
    private function get_opt_log($invoice_id) {
        $array = $this->db->getAll("SELECT `id`, `invoice_sn`, `oprator`, `add_time`, `log` FROM `ecs_stock_invoice_installs_logs` WHERE `invoice_sn`='{$invoice_id}'  ORDER BY `add_time` DESC");
        return $array;
    }

    /**
     * 单据操作日志
     * @param int $invoice_id 单据id
     * @param string $note 单据日志
     */
    private function insert_opt_log($invoice_id, $note) {
        $logs = array(
            'invoice_sn' => $invoice_id,
            'log' => $note,
            'oprator' => $_SESSION['admin_real_name'],
            'add_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
        );
        $this->db->autoExecute('ecs_stock_invoice_installs_logs', $logs);
    }

    /**
     * 生成查询订单总金额的字段
     * @param   string  $alias  order表的别名（包括.例如 o.）
     * @return  string
     */
    private function order_amount_field($order_id) {
        $total_fee = $this->db->getOne("select " . $this->order_split('oi.') . " as total_fee from ecs_order_info oi where oi.order_id='$order_id'");
        return $total_fee;
    }

    private function order_split($alias = 'oi.') {
        return "   {$alias}goods_amount + {$alias}tax + {$alias}shipping_fee" .
                " + {$alias}insure_fee + {$alias}pay_fee + {$alias}pack_fee" .
                " + {$alias}card_fee - {$alias}discount -{$alias}bonus";
    }

    public function ajax_search() {
        $val = empty($_REQUEST['val']) ? '' : trim($_REQUEST['val']);
        $type = empty($_REQUEST['type']) ? '' : trim($_REQUEST['type']);
        if ($val) {
            $sql = "SELECT `install_id`,  `contact_name`  FROM `ecs_install_data` WHERE  `contact_name` like '%{$val}%'";
            $list = $this->db->getAll($sql);
            if ($list) {
                foreach ($list as $value) {
                    $row[$value['install_id']] = $value['contact_name'];
                }
                make_json_result(array('suc' => 1, 'type' => $type), $row);
            } else {
                make_json_result(array('suc' => 0, 'type' => $type), '没有搜索到师傅信息!');
            }
        } else {
            make_json_error("参数错误！");
        }
    }

    public function ajax_get_master_info() {
        $val = empty($_REQUEST['val']) ? '' : trim($_REQUEST['val']);
        $type = empty($_REQUEST['type']) ? '' : trim($_REQUEST['type']);
        if ($val) {
            $master = $this->get_master_info($val);
            if ($master['bank_ids']) {
                $bank = $this->get_basic_bank($master['bank_ids']);
            }
            make_json_result(array('suc' => 1, 'type' => $type), array('bank' => $bank, 'master' => $master));
        } else {
            make_json_error("参数错误！");
        }
    }

    private function get_user_warehouse() {
        return $this->db->getOne("SELECT a.warehouse_id FROM ecs_warehouse a LEFT JOIN ecs_admin_user b ON a.warehouse_id = b.warehouse_id WHERE b.user_id = '{$_SESSION['admin_id']}'");
    }

    private function invoice_is_exper_order_r($id) {
        $sql = "SELECT  `order_id`,order_sn FROM `ecs_stock_invoice_info` WHERE `invoice_id` = {$id}";
        $order_info = $this->db->getRow($sql);
        $order_id = $order_info['order_id'];

        if ($order_id) {
            $bool = $this->db->getOne("SELECT `order_id` FROM `ecs_order_info` WHERE `order_id` = {$order_id} AND ((`order_type` = 'exper_order' AND `order_type` < '" . strtotime(date('2013-02-01 00:00:00')) . "') OR `order_type`= 'patch_order' OR `order_type` = 'normal' OR `order_sn` LIKE 'TB%' OR `order_sn` LIKE 'JD%')") > 0 ? TRUE : FALSE;
            if (FALSE === $bool) {
                $scond_bool = $this->db->getOne("SELECT a.`id` FROM `ecs_order_extend` a, ecs_order_info b  WHERE  a.`trans_type` =4  AND (a.order_id = b.order_id) AND a.`order_id` = $order_id AND b.add_time < " . strtotime('2013-02-01 00:00:00')) > 0 ? TRUE : FALSE;
                if ($scond_bool === FALSE) {
                    if ($this->get_user_expr_id()) {
                        return $this->db->getOne("SELECT a.`order_id` FROM  `ecs_order_info` AS a  WHERE a.ship_direction != 0 AND a.ship_direction = '" . $this->get_user_expr_id() . "'") > 0 ? TRUE : FALSE;
                    } else {
                        return false;
                    }
                }
                return $scond_bool;
            }
            return $bool;
        }
        return FALSE;
    }

    function get_user_expr_id() {
        return $this->db->getOne("SELECT een.expr_id  FROM ecs_expr_nature een JOIN meilele_group mg on een.group_id =mg.group_id JOIN ecs_admin_user eau on mg.group_id=eau.group_id where eau.user_id  = '{$_SESSION['admin_id']}'");
    }

    public function invoice_fee_del() {
        $id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
        $invoice_sn = empty($_REQUEST['invoice_sn']) ? '' : trim($_REQUEST['invoice_sn']);
        if ($id) {
            $sql = "DELETE FROM `ecs_stock_invoice_installs_fee` WHERE `id` = '{$id}'";
            $this->db->query($sql);
            sys_msg('操作成功！', 0, array(array('text' => '单据费用信息', 'href' => '?act=fee&invoice_sn=' . $invoice_sn)));
        } else {
            sys_msg("参数错误！");
        }
    }

    /**
     * 删除合并单据
     */
    public function invoice_merge_del() {
        $invoice_sn = empty($_REQUEST['invoice_sn']) ? '' : trim($_REQUEST['invoice_sn']);
        $exist_fee = $this->get_invoice_fee_by_invoice_id($invoice_sn);
        ($exist_fee && is_array($exist_fee)) && sys_msg("该单据存在费用信息，请删除再试！");
        $this->db->query("DELETE FROM `ecs_stock_invoice_extend` WHERE `invoice_sn`='{$invoice_sn}'");
        sys_msg("删除成功！", array(array('href' => 'stock_invoice_installs_list.php', 'text' => '发货单费用信息列表')));
    }

}

$act = empty($_REQUEST['act']) ? 'fee' : trim($_REQUEST['act']);
$obj = new stock_invoice_installs();
$obj->$act();

