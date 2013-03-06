<?php

define('IN_ECS', TRUE);
define('MKEY', 'ky7ac#@zvm291rm!91asf&@af'); #私钥
define('WEB_DEBUG', $_SERVER["REMOTE_ADDR"] == '127.0.0.1' && $_SERVER["SERVER_ADDR"] == '127.0.0.1' ? TRUE : FALSE);
//(1) 美乐乐整车发货接口: 
define('VEHICLE', 'http://mfs.haier.net/ws/MllToMFSVehicleDileveryWs?wsdl');
//(2) 美乐乐仓库送货单接口
define('WAREHOUSE', 'http://mfs.haier.net/ws/MllToMFSWarehouseDileveryWs?wsdl');
//(3) 美乐乐仓库收货确认接口
define('CONFRIM', 'http://mfs.haier.net/ws/MllToMFSWarehouseReceiveWs?wsdl');
//(4) 美乐乐客户送货服务单接口
define('CUST_DELIVERY', 'http://mfs.haier.net/ws/MllToMFSCustomerDileveryWs?wsdl');
//(6) 美乐乐客户退货单接口
define('RETURNS', 'http://mfs.haier.net/ws/mellcustback?wsdl');

require (dirname(__FILE__) . '/includes/init.php');

class Web_Service_Client {

    public $db;
    public $error = array();
    public $msg = array();

    public function __construct() {
        $this->db = & $GLOBALS['db'];
    }

    /**
     * 1、美乐乐整车送货单（MEILELE<-->海尔接口，数据推/拉）
     * @param XMLReader $xml
     */
    public function push_vehicle($xml) {
        //发送数据，获取返回的结果
        try {
            $client = new SoapClient(VEHICLE);
            $return = $client->setVehicleDileverys(array('dileveryInfo' => $xml));
            return $this->xml_to_array($return->return);
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

    /**
     * 2、MEILELE仓库送货单明细（MEILELE<-->海尔接口，数据推/拉）
     * @param XMLReader $xml
     */
    public function push_delivery($xml) {
        //发送数据，获取返回的结果
        try {
            $client = new SoapClient(WAREHOUSE, array('trace' => 1));
            $return = $client->setWarehouseDileverys(array('dileveryInfo' => $xml));
            return $this->xml_to_array($return->return);
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

    /**
     * 5、 MEILELE客户送货服务单（MEILELE<-->海尔接口，数据推/拉）
     */
    public function push_customer_delivery($xml) {
        //发送数据，获取返回的结果
        try {
            $client = new SoapClient(CUST_DELIVERY, array('trace' => 1));
            $return = $client->setCustomerDileverys(array('dileveryInfo' => $xml));
            //如果成功调用webservice成功，同时返回成功值，继续发送该发货单明细
            return $this->xml_to_array($return->return);
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

    /**
     * 7、 MEILELE客户退货单（MEILELE<-->海尔接口，数据推/拉）
     * @param XMLReader $xml
     */
    public function push_returns($xml) {
        //发送数据，获取返回的结果
        try {
            $client = new SoapClient(RETURNS);
            $return = $client->getMellCustBackInfo(array('custBackInfo' => $xml));
            return $this->xml_to_array($return->return);
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

    /**
     * 返回生成xml格式错误数据
     * @param int $error_status
     * @param string $error_msg
     * @return string
     */
    public function xml_error($error_status = 0, $error_msg = 'success') {
        $ret = <<<EOA
                <?xml version='1.0' encoding='UTF-8'?>
                <error>
                <error_status>$error_status</error_status>
                <error_msg>$error_msg</error_msg>
                </error>
EOA;
        return $ret;
    }

    /**
     * 1、 美乐乐整车送货单（MEILELE<-->海尔接口，数据推/拉）
     */
    public function get_vehicle_info() {
        //测试数据
        //查询车次单里面的已经发货的包含青岛仓库，同时没有同步完成的车次单
        $sql = "SELECT esu.unload_id, esu.warehouse_id_str, esu.unload_sn, esu.warehouse_id, esu.arrive_time, esu.driver_name, esu.shipcar_no, esu.shipcar_mobile, 
                esu. STATUS, sum(esud.package_sum) AS total_pack, 
                esu.call_carer, esu.call_carer_phone, esu.add_time, esu.note
                FROM ecs_shipcar_unload esu 
                JOIN ecs_shipcar_unload_detail esud ON esu.unload_id = esud.unload_id 
                WHERE esu.warehouse_id = 1 
                AND esu.`status` IN ('confirmed', 'success') AND find_in_set('14', esu.warehouse_id_str)  AND esu.is_sync_haier=0
                GROUP BY esu.unload_id ";
        $list = $this->db->getAll($sql);
        //如果存在
        if ($list) {
            foreach ($list as $row) {
                //车次单单据号
                $invoices = $this->get_vehicle_invoices($row['unload_id'], TRUE);
                //单据总数
                $inv_total = sizeof($invoices);
                $array = array(
                    'shipcar_id' => $row['unload_id'],
                    'shipcar_sn' => $row['unload_sn'],
                    'dest_wh_id' => 149,
                    'warehouse_id' => $row['warehouse_id'],
                    'arrival_time' => $row['arrival_time'] ? date("Y-m-d H:i:s", $row['arrival_time']) : '0000-00-00 00:00:00', //预计到货时间
                    'driver_name' => $row['driver_name'], //司机名称
                    'license_number' => $row['shipcar_no'], //车牌号
                    'driver_mobile' => $row['shipcar_mobile'] ? $row['driver_mobile'] : '', //司机电话
                    'inv_total' => $inv_total, //发货单单据数量
                    'package_total' => $row['total_pack'], //总包件数
                    'operator' => $row['call_carer'], //排车人
                    'operator_tel' => $row['call_carer_phone'], //排车人电话
                    'createdate' => $row['add_time'] ? date('Y-m-d H:i:s', $row['add_time']) : '0000-00-00 00:00:00', //创建时间
                    'note' => 'MLL测试数据' . $row['note'], //备注
                );
                $push_xml = $this->create_xml($array, $invoices);
                //如果调用成功，则更新库存信息
                $boolean = $this->push_vehicle($push_xml);
                if (0 == $boolean['error_status']) {
                    $this->msg[] = $boolean['error_msg'];
                    //如果车次单同步成功，则同步车次单里面的发货单与发货单商品
                    $this->get_vehicle_invoices_info($row['unload_id']);
                } else {
                    $this->error[] = $boolean['error_msg'];
                }
            }
        } else {
            $this->error[] = '没有查询到指定条件的数据';
        }
        $this->get_msg();
        $this->get_error();
    }

    /**
     * 2、 MEILELE仓库送货单明细（MEILELE<-->海尔接口，数据推/拉）
     */
    public function get_vehicle_invoices_info($unload_id) {
        $list = $this->get_vehicle_invoices($unload_id);
        if ($list) {
            foreach ($list as $row) {
                //发货单基础信息
                $invoice_basic = array(
                    'invoice_sn' => $row['invoice_sn'],
                    'order_sn' => $row['order_sn'],
                    'consignee' => $row['consignee'],
                    'country' => $row['country'],
                    'province' => $row['province'],
                    'city' => $row['city'],
                    'district' => $row['district'],
                    'address' => $row['address'],
                    'goods_amount' => $row['total_amount'],
                    'total_package_num' => $row['total_number'],
                    'companyCode' => 'JB0000001',
                    'shipcar_id' => $unload_id,
                    'note' => 'MLL测试数据' . $row['note'],
                );
                //发货单详细信息
                $invoice_detail = $this->get_vehicle_invoice_goods($row['invoice_sn']);
                $push_xml = $this->create_xml($invoice_basic, $invoice_detail);
                //发货单信息调用接口
                $boolean = $this->push_delivery($push_xml);
                if (0 == $boolean['error_status']) {
                    //同步成功
                    $this->msg[] = $boolean['error_msg'];
                    $this->update_is_sync($row['invoice_id'], "invoice");
                    $log = '送货单' . $row['invoice_sn'] . '在' . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . '推送海尔成功！';
                    $note = array(
                        'invoice_id' => $row['invoice_id'],
                        'action_user' => '接口同步操作',
                        'log_time' => $_SERVER['REQUEST_TIME'],
                        'action_note' => $log,
                    );
                    $this->add_opt_note($note);
                    $this->msg[] = $log;
                } else {
                    $this->error[] = $boolean['error_msg'];
                }
            }
        } else {
            $this->error[] = '整车发货单信息为空!';
        }
    }

    /**
     * 3、 仓库收货确认（MEILELE-->海尔接口，数据拉，查询参数invoice_sn, companyCode）
     * @param string $invoice_sn 发货单
     * @param int $company 公司id
     */
    public function push_receive_confirm($invoice_sn, $company) {
        try {
            $soap = new SoapClient(CONFRIM);
            $xml = '<?xml version="1.0" encoding="UTF-8"?><invInfo><invHeader><invoice_sn>' . $invoice_sn . '</invoice_sn><companyCode>' . $company . '</companyCode></invHeader></invInfo>';
            //调用服务端的方法
            $return = $soap->setWarehouseReceives(array('receiveInfo' => $xml));
            $row = $this->xml_to_array($return->return);
            //如果成功调用webservice成功，同时返回成功值，继续发送该发货单明细
            if ($row) {
                $invoice_basic = array(
                    'invoice_sn' => $row['invHeader']['invoice_sn'],
                    'order_sn' => $row['invHeader']['order_sn'],
                    'goods_amount' => $row['invHeader']['goods_amount'],
                    'total_package_num' => $row['invHeader']['total_package_num'],
                    'rece_date' => $row['invHeader']['rece_date'],
                    'note' => $row['invHeader']['note'],
                    'note_url' => $row['invHeader']['note_url'],
                    'companyCode' => $row['invHeader']['companyCode'],
                );
                //如果存在，则不需要进行添加
                $exs_id = $this->db->getOne("select id from ecs_haier_received_info where invoice_sn = '{$invoice_basic['invoice_sn']}' AND order_sn = '{$invoice_basic['order_sn']}'");
                if (!$exs_id) {
                    $this->db->autoExecute('ecs_haier_received_info', $invoice_basic);
                }
                $this->msg[] = '单据:' . $row['invHeader']['invoice_sn'] . ' 收货确认成功!';
                //循环将数据插入
                if ($this->array_is_null($row['items']['item'])) {
                    foreach ($row['items']['item'] as $val) {
                        $invoice_detail = array(
                            'goods_sn' => $val['goodsSn'],
                            'goods_num' => $val['goodsNum'],
                            'total_package_num' => $val['total_package_num'],
                            'note' => $val['note'],
                            'invoice_sn' => $row['invHeader']['invoice_sn'],
                        );
                        //如果存在，不需要重新添加
                        $res_exs_id = $this->db->getOne("select id from ecs_haier_received_goods where invoice_sn = '{$invoice_detail['invoice_sn']}' AND goods_sn = '{$invoice_detail['goods_sn']}' AND goods_num='{$invoice_detail['goods_num']}' AND total_package_num='{$invoice_detail['total_package_num']}'");
                        if (!$res_exs_id) {
                            $this->db->autoExecute('ecs_haier_received_goods', $invoice_detail);
                        }
                        $this->msg[] = '单据:' . $row['invHeader']['invoice_sn'] . ' 商品:' . $val['goodsSn'] . ' 收货确认成功!';
                    }
                }
            }
        } catch (Exception $exc) {
            $this->error[] = $exc->getMessage();
        }
        $this->get_msg();
        $this->get_error();
    }

    function array_is_null($array) {
        if (is_array($array)) {
            foreach ($array as $value) {
                return $this->array_is_null($value);
            }
        } else {
            return empty($array) ? FALSE : TRUE;
        }
    }

    /**
     * 送货功能
     */
    public function get_vehicle_delivery() {
        //测试数据
        $where = WEB_DEBUG ? " AND esu.unload_id=218 " : '';
        //查询车次单里面的已经发货的包含青岛仓库，同时没有同步完成的车次单
        $sql = "SELECT esu.unload_id, esu.warehouse_id_str, esu.unload_sn, esu.warehouse_id, esu.arrive_time, esu.driver_name, esu.shipcar_no, esu.shipcar_mobile, 
                esu. STATUS, sum(esud.package_sum) AS total_pack, 
                esu.call_carer, esu.call_carer_phone, esu.add_time, esu.note
                FROM ecs_shipcar_unload esu 
                JOIN ecs_shipcar_unload_detail esud ON esu.unload_id = esud.unload_id 
                WHERE esu.warehouse_id = 1 
                AND esu.`status` IN ('confirmed', 'success') AND find_in_set('14', esu.warehouse_id_str)  AND esu.is_sync_haier=0  {$where}
                GROUP BY esu.unload_id ";
        $list = $this->db->getAll($sql);
        //如果存在
        if ($list) {
            foreach ($list as $row) {
                $this->get_customer_delivery($row['unload_id']);
            }
        } else {
            $this->error[] = '没有查询到符合条件的车次单数据!';
        }
        $this->get_msg();
        $this->get_error();
    }

    /**
     * 5、 MEILELE客户送货服务单（MEILELE<-->海尔接口，数据推/拉）
     */
    public function get_customer_delivery($unload_id) {
        $sql = "SELECT
                etii.invoice_sn,
                etii.invoice_id,
                etii.order_sn,
                etii.consignee,
                etii.country,
                etii.province,
                etii.city,
                etii.district,
                etii.address,etii.mobile,etii.tel,etii.delivery_type,
                sum(esig.stock_goods_amount) AS total_amount,
                sum(esig.package_number) AS total_number,
                etii.company_id,
                etii.note,etii.add_time,
                etii.warehouse_id
                FROM ecs_shipcar_unload_detail esud
                JOIN ecs_stock_invoice_info etii ON esud.invoice_id = etii.invoice_id
                JOIN ecs_stock_invoice_goods esig ON etii.invoice_id = esig.invoice_id
                WHERE etii.is_expr = 0
                AND etii.third_sync = 0
                AND etii.fstatus = 'shipped' and etii.warehouse_id=14
                AND esud.unload_id IN ({$unload_id})
                GROUP BY etii.invoice_id";
        $array = $this->db->getAll($sql);
        if ($array) {
            foreach ($array as $value) {
                $basic_array = array(
                    'invoice_sn' => $value['invoice_sn'],
                    'order_sn' => $value['order_sn'],
                    'consignee' => $value['consignee'],
                    'country' => $value['country'],
                    'province' => $value['province'],
                    'city' => $value['city'],
                    'district' => $value['district'],
                    'mobile' => $value['mobile'],
                    'Tel' => $value['tel'],
                    'address' => $value['address'],
                    'companyCode' => 'JB0000001',
                    'type' => $value['delivery_type'],
                    'note' => 'MLL测试数据',
                    'createdate' => $value['add_time'] ? date('Y-m-d H:i:s', $value['add_time']) : '0000-00-00 00:00:00',
                );
                $detail_array = $this->get_vehicle_invoice_goods($value['invoice_sn']);
                $xml = $this->create_xml($basic_array, $detail_array);
                //发货单信息调用接口
                $boolean = $this->push_customer_delivery($xml);
                if (0 == $boolean['error_status']) {
                    //同步成功
                    $this->msg[] = $boolean['error_msg'];
                    $this->update_is_sync($value['invoice_id'], "invoice");
                    $log = '送货单' . $value['invoice_sn'] . '在' . date('Y-m-d H:i:s', $_REQUEST['REQUEST_TIME']) . '推送海尔成功！';
                    $note = array(
                        'invoice_id' => $value['invoice_id'],
                        'action_user' => '接口同步操作',
                        'log_time' => $_SERVER['REQUEST_TIME'],
                        'action_note' => $log,
                    );
                    $this->add_opt_note($note);
                    $this->msg[] = $log;
                } else {
                    $this->error[] = $boolean['error_msg'];
                }
            }
        } else {
            $this->error[] = '该车次没有客户送货单据！';
        }
    }

    /**
     * 更新不同id类型的同步状态
     * @param int $id
     */
    protected function update_is_sync($id, $type) {
        switch ($type) {
            case 'goods':
                $this->db->query("UPDATE `ecs_stock_invoice_goods` SET `is_sync_haier` = '1' WHERE `goods_sn` ='{$id}'");
                break;
            case 'invoice':
                $this->db->query("UPDATE `ecs_stock_invoice_info` SET `third_sync` = '1' WHERE `invoice_id` ={$id}");
                $this->db->query("UPDATE `ecs_shipcar_unload_detail` SET `is_sync_haier` = '1' WHERE `invoice_id` ={$id}");
                break;
            case 'vehicle':
                $this->db->query("UPDATE `ecs_shipcar_unload` SET `is_sync_haier` = '1' WHERE `unload_id` ={$id}");
                break;
        }
    }

    /**
     * 获取发货单里面的商品详细信息
     * @param string $invoice_sn 发货单信息
     */
    protected function get_vehicle_invoice_goods($invoice_sn) {
        $sql = " SELECT etii.invoice_sn,etii.invoice_id,
                   esig.goods_sn as goodsSn,esig.goods_name as goodsName,esig.goods_number as goodsNum,esig.package_number as total_package_num
                   FROM ecs_shipcar_unload_detail esud
                   JOIN ecs_stock_invoice_info etii ON esud.invoice_id = etii.invoice_id
                   JOIN ecs_stock_invoice_goods esig ON etii.invoice_id = esig.invoice_id
                   WHERE etii.invoice_sn = '{$invoice_sn}' AND esig.is_sync_haier =0
                   GROUP BY etii.invoice_id";
        return $this->db->getAll($sql);
    }

    /**
     * 7、 MEILELE客户退货单（MEILELE<-->海尔接口，数据推/拉）
     */
    public function get_returns() {
        $sql = "select esii.invoice_id,esii.invoice_sn,esii.order_sn,esii.consignee,esii.country,
                esii.province,esii.city,esii.district,esii.mobile,esii.tel,esii.address,
                esii.company_id,esii.delivery_type,erin.action_user,erin.note,erin.returns_sn
                from ecs_stock_invoice_info esii 
                join ecs_stock_invoice_goods esig on esii.invoice_id=esig.invoice_id
                join ecs_returns_item erit   on erit.rec_id=esig.rec_id 
                join ecs_returns_info erin  on erit.returns_id=erin.returns_id and erin.`status`!='cancel'
                where esii.warehouse_id=14 and esii.is_expr=0 AND esii.third_sync=0";
        $array = $this->db->getAll($sql);
        if ($array) {
            foreach ($array as $value) {
                $basic_array = array(
                    'invoice_sn' => $value['invoice_sn'],
                    'order_sn' => $value['order_sn'],
                    'consignee' => $value['consignee'],
                    'country' => $value['country'],
                    'province' => $value['province'],
                    'city' => $value['city'],
                    'district' => $value['district'],
                    'mobile' => $value['mobile'],
                    'Tel' => $value['tel'],
                    'address' => $value['address'],
                    'companyCode' => 'JB0000001',
                    'type' => $value['delivery_type'],
                    'operator' => $value['action_user'],
                    'operator_tel' => '',
                    'note' => 'MLL测试数据' . $value['note'],
                );
                $detail_array = $this->get_returns_detail($value['return_sn']);
                $xml = $this->create_xml($basic_array, $detail_array);
                $boolean = $this->push_returns($xml);
                if (0 == $boolean['error_status']) {
                    $this->msg[] = $boolean['error_msg'];
                } else {
                    $this->error[] = $boolean['error_msg'];
                }
            }
        } else {
            $this->error[] = '没有查询到满足条件的客户退货单！';
        }
        $this->get_msg();
        $this->get_error();
    }

    /**
     * 退货单明细信息
     * @param string $return
     * @return mixed
     */
    public function get_returns_detail($return) {
        $sql = "select erit.returns_id,erit.goods_sn as goodsSn,erit.goods_number as goodsNum,erit.goods_name as goodsName
                from  ecs_returns_info erin  
                join  ecs_returns_item erit  on erit.returns_id=erin.returns_id 
                where erin.returns_sn='{$return}'";
        return $this->db->getAll($sql);
    }

    /**
     * 创建XML数据
     * @param array $basic_array 基础信息
     * @param array $detail_array 详细信息
     */
    public function create_xml($basic_array, $detail_array) {
        //组装xml数据
        $string = '<?xml version="1.0" encoding="UTF-8"?><invInfo><invHeader>';
        foreach ($basic_array as $key => $val) {
            $string .= "<$key>" . $val . "</$key>";
        }
        $str = '<items>';
        foreach ($detail_array as $value) {
            if (is_array($value)) {
                $str .= '<item>';
                foreach ($value as $k => $v) {
                    $str .= "<$k>" . $v . "</$k>";
                }
                $str.='</item>';
            } else {
                $str .="<item><invoice_sn>" . $value . "</invoice_sn></item>";
            }
        }
        $str .="</items>";
        $string .='</invHeader>' . $str;
        //数据加密生成唯一的key
        $items = array('orderHeader' => $basic_array, 'orderItems' => $detail_array);
        $auth_key = $this->data_encrtpt($items);
        $string .= '<authKey>' . $auth_key . '</authKey></invInfo>';
        return $string;
    }

    /**
     * xml格式转化为数组
     * @param string $xml xml格式数据
     * @return array array数据
     */
    public function xml_to_array($xml) {
        $res = @simplexml_load_string($xml, NULL, LIBXML_NOCDATA);
        return json_decode(json_encode($res), true);
    }

    /**
     * 加密每一条Item
     * @param string $items xml格式的数据
     * @return string md5之后的数据
     */
    public function data_encrtpt($items) {
        $str = '';
        $authkey = '';
        ksort($items['orderHeader']);
        foreach ($items['orderHeader'] as $k => $v) {
            if ($k != 'authKey') {  //authkey不参与签名计算
                $str .= trim($v);
            } else {
                $authkey = $v;
            }
        }
        /* 获取数组的每一个名字的值 */
        $item_array = array();
        foreach ($items['orderItems'] as $k => $v) {
            foreach ($v as $_k => $val)
                $item_array[$_k][] = $val;
        }
        /* 排序数组的KEY */
        ksort($item_array);
        $item_str = '';
        foreach ($item_array as $md5_value_array) {
            foreach ($md5_value_array as $value) {
                $item_str .= $value;
            }
        }
        $encrypt = md5(md5($str . $item_str) . MKEY);
        return $encrypt;
    }

    /**
     * 2、获取车次单里面的单据信息
     * @param int $shipcar_id 车次单id
     * @param boolean $profile 是否简要输出
     * @return array 车次单发货单数据
     */
    public function get_vehicle_invoices($unload_id, $profile = FALSE) {
        $where = "AND esud.unload_id = {$unload_id}";
        $sql = "SELECT etii.invoice_sn, etii.invoice_id, etii.order_sn, etii.consignee, etii.country, etii.province, etii.city, etii.district, etii.address,
                sum( esig.stock_goods_amount ) AS total_amount, sum( esig.package_number ) AS total_number, etii.company_id, etii.note, etii.fstatus, esud.unload_id
                FROM ecs_shipcar_unload_detail esud
                JOIN ecs_stock_invoice_info etii ON esud.invoice_id = etii.invoice_id
                JOIN ecs_stock_invoice_goods esig ON etii.invoice_id = esig.invoice_id
                WHERE (etii.expr_id =16 OR etii.unloading_point=14)
                AND etii.third_sync = 0
                {$where}
                AND etii.fstatus IN ('shipped_expr', 'shipped', 'transport') 
                GROUP BY etii.invoice_id";
        $list = $this->db->getAll($sql);
        if ($list) {
            if ($profile) {
                foreach ($list as $row) {
                    $array[$row['invoice_id']] = $row['invoice_sn'];
                }
                return $array;
            }
        }
        return $list;
    }

    /**
     * 返回错误消息
     */
    public function get_error() {
        echo "<p>错误消息：<hr /></p><pre>", var_dump($this->error) . '</pre>';
        exit();
    }

    /**
     * 返回成功的消息
     */
    public function get_msg() {
        echo "<p>成功处理结果：<hr /></p><pre>", var_dump($this->msg) . '</pre>';
    }

    /**
     * 添加操作日志
     */
    public function add_opt_note($note) {
        $this->db->autoExecute('ecs_stock_action', $note);
    }

    public function __call($name, $arg) {
        sys_msg('方法' . $name . '[参数：' . $arg . ']不存在!');
    }

}

//测试接口
$action = $_REQUEST['act'] ? trim($_REQUEST['act']) : '';
$invoice_sn = $_REQUEST['invoice_sn'] ? trim($_REQUEST['invoice_sn']) : 'DHC025';
$company = $_REQUEST['company'] ? trim($_REQUEST['company']) : '3700';
$obj = new Web_Service_Client();
switch ($action) {
    case 'zhengche':
        //1、2、 美乐乐整车送货单（MEILELE<-->海尔接口，数据推/拉） MEILELE仓库送货单明细（MEILELE<-->海尔接口，数据推/拉）------------------------V5
        $obj->get_vehicle_info();
        break;
    case 'tuihuo':
        //7 退货
        $obj->get_returns();
        break;
    case 'shouhuoqueren':
        //3仓库收货确认
        $obj->push_receive_confirm($invoice_sn, $company);
        break;
    case 'songhuo':
        //5、客户送货通知
        $obj->get_vehicle_delivery();
        break;
    default:
        exit('Action访问错误:不存在或者错误！');
        break;
}

