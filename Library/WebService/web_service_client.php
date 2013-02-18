<?php

define('IN_ECS', TRUE);
define('MKEY', 'ky7ac#@zvm291rm!91asf&@af'); #私钥
define('WEB_DEBUG', $_SERVER["REMOTE_ADDR"] == '127.0.0.1' && $_SERVER["SERVER_ADDR"] == '127.0.0.1' ? TRUE : FALSE);
//(1) 美乐乐整车发货接口: 
define('VEHICLE', !WEB_DEBUG ? 'http://mfs.haier.net/ws/MllToMFSVehicleDileveryWs?wsdl' : 'http://58.56.128.34:9001/mfs/ws/MllToMFSVehicleDileveryWs?wsdl');
//(2) 美乐乐仓库送货单接口
define('WAREHOUSE', 'http://58.56.128.34:9001/mfs/ws/MllToMFSWarehouseDileveryWs?wsdl');
//(3) 美乐乐仓库收货确认接口
define('CONFRIM', !WEB_DEBUG ? 'http://mfs.haier.net/ws/MllToMFSWarehouseReceiveWs?wsdl' : 'http://58.56.128.34:9001/mfs/ws/MllToMFSWarehouseReceiveWs?wsdl');
//(5) 美乐乐取消商品预留接口:
define('CANCEL', 'http://58.56.128.34:9001/mfs/ws/MllCancleOrder?wsdl');
//(4) 美乐乐客户送货服务单接口
define('CUST_DELIVERY', 'http://58.56.128.34:9001/mfs/ws/MllToMFSCustomerDileveryWs?wsdl');
//(6) 美乐乐客户退货单接口
define('RETURN', 'http://58.56.128.34:9001/mfs/ws/MllCancleOrder?wsdl');

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
//            $client = new SoapClient(VEHICLE);
//            $return = $client->setVehicleDileverys(array('dileveryInfo' => $xml));
//            $res = $this->xml_to_array($return->return);
            $client = new SoapClient(null, array('location' => "http://58.56.128.34:9001/mfs/ws/MllToMFSVehicleDileveryWs?wsdl",
                        'uri' => "http://mllvehicle.remoting.mfs.haier.com"));
            $return = $client->setVehicleDileverys(array('dileveryInfo' => $xml));
            $res = $this->xml_to_array($return->return);
            //如果成功调用webservice成功，同时返回成功值，继续发送该发货单明细
            return $res['error_status'] == 0 ? TRUE : $res['error_msg'];
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
            $res = $this->xml_to_array($return->return);
            //如果成功调用webservice成功，同时返回成功值，继续发送该发货单明细
            return $res['error_status'] == 0 ? TRUE : $res['error_msg'];
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

    /**
     * 4、 取消商品预留（MEILELE-->海尔接口，数据推送）
     */
    public function push_cancel_goods($xml) {
        //发送数据，获取返回的结果
        try {
            $client = new SoapClient(CANCEL, array('trace' => 1));
            $return = $client->setCancleInfo(array('cancleInfo' => $xml));
            $res = $this->xml_to_array($return->return);
            //如果成功调用webservice成功，同时返回成功值，继续发送该发货单明细
            return $res['error_status'] == 0 ? TRUE : $res['error_msg'];
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

    /**
     * 5、 MEILELE客户送货服务单（MEILELE<-->海尔接口，数据推/拉）
     */
    public function push_customer_delivery() {
        //发送数据，获取返回的结果
        try {
            $client = new SoapClient(CUST_DELIVERY, array('trace' => 1));
            $return = $client->setCustomerDileverys(array('dileveryInfo' => $xml));
            //如果成功调用webservice成功，同时返回成功值，继续发送该发货单明细
            return $return['error_status'] == 0 ? TRUE : $return['error_msg'];
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
            $client = new SoapClient(HAIER, array('trace' => 1));
            $para = array('return' => $xml);
            $return = $client->setVehicleDileverys($para);
            //如果成功调用webservice成功，同时返回成功值，继续发送该发货单明细
            return $return['error_status'] == 0 ? TRUE : $return['error_msg'];
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
                //车次单单据号
                $invoices = $this->get_vehicle_invoices($row['unload_id'], TRUE);
                //单据总数
                $inv_total = sizeof($invoices);
                $array = array(
                    'shipcar_id' => $row['unload_id'],
                    'shipcar_sn' => $row['unload_sn'],
                    'dest_wh_id' => 149,
                    'warehouse_id' => $row['warehouse_id'],
                    'arrival_time' => $row['arrival_time'], //预计到货时间
                    'driver_name' => $row['driver_name'], //司机名称
                    'license_number' => $row['shipcar_no'], //车牌号
                    'driver_mobile' => $row['shipcar_mobile'] ? $row['driver_mobile'] : '', //司机电话
                    'inv_total' => $inv_total, //发货单单据数量
                    'package_total' => $row['total_pack'], //总包件数
                    'operator' => $row['call_carer'], //排车人
                    'operator_tel' => $row['call_carer_phone'], //排车人电话
                    'createdate' => date('Y-m-d H:i:s', $row['add_time']), //创建时间
                    'note' => $row['note'], //备注
                );
                $push_xml = $this->create_xml($array, $invoices);
                //如果调用成功，则更新库存信息
                $boolean = $this->push_vehicle($push_xml);
                if (TRUE === $boolean) {
                    //如果车次单同步成功，则同步车次单里面的发货单与发货单商品
                    $this->get_vehicle_invoices_info($row['unload_id']);
                } else {
                    $this->error[] = $boolean;
                }
            }
        } else {
            $this->error[] = '没有查询到指定条件的数据';
        }
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
                    'companyCode' => $row['company_id'],
                    'shipcar_id' => $unload_id,
                    'note' => $row['note'],
                );
                //发货单详细信息
                $invoice_detail = $this->get_vehicle_invoice_goods($row['invoice_sn']);
                $push_xml = $this->create_xml($invoice_basic, $invoice_detail);
                //发货单信息调用接口
                $boolean = $this->push_delivery($push_xml);
                if (TRUE === $boolean) {
                    //同步成功
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
                }
            }
        }
        $this->error[] = '整车发货单信息为空!';
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
            $row = $soap->setWarehouseReceives(array('receiveInfo' => $xml));
            //如果成功调用webservice成功，同时返回成功值，继续发送该发货单明细
            if ($row) {
                $invoice_basic = array(
                    'invoice_sn' => $row['invoice_sn'],
                    'order_sn' => $row['order_sn'],
                    'goods_amount' => $row['goods_amount'],
                    'total_package_num' => $row['total_package_num'],
                    'rece_date' => $row['rece_date'],
                    'note' => $row['note'],
                    'note_url' => $row['note_url'],
                    'companyCode' => $row['companyCode'],
                );
//                $basic_res = $this->db->autoExecute('ecs_haier_received_info', $invoice_basic);
                //循环将数据插入
                $invoice_detail = array(
                    'goods_sn' => $row['goodsSn'],
                    'goods_num' => $row['goodsNum'],
                    'total_package_num' => $row['total_package_num'],
                    'note' => $row['note'],
                    'invoice_sn' => $row['invoice_sn'],
                );
                $detail_res = $this->db->autoExecute('ecs_haier_received_goods', $invoice_detail);
            }
        } catch (Exception $exc) {
            $this->error[] = $exc->getMessage();
        }
        $this->get_error();
    }

    /**
     * 4、 取消商品预留（MEILELE-->海尔接口，数据推送）
     * 查询存在的商品信息
     */
    public function get_cancel_goods() {
        $sql = "select  esii.invoice_sn,esii.order_sn,esii.company_id,erit.goods_id,erit.goods_name,erit.goods_number,erit.goods_sn,erit.note
                from ecs_returns_info erin 
                join ecs_returns_item erit on erin.returns_id=erit.returns_id
                join ecs_order_goods eog on erit.rec_id=eog.rec_id
                join ecs_stock_invoice_info esii on eog.order_id=esii.order_id
                where erit.return_destination='青岛市北区体验馆仓库' and erin.`status`='确认'; ";
        $array = $this->db->getAll($sql);
        if ($array) {
            foreach ($array as $key => $value) {
                $basic = array(
                    'invoice_sn' => $value['invoice_sn'],
                    'order_sn' => $value['order_sn'],
                    'companyCode' => $value['company_id'],
                );
                $detail = array(
                    'goodsSn' => $value['goods_sn'],
                    'goodsNum' => $value['goods_number'],
                    'note' => $value['note'],
                    'invoice_sn' => $value['invoice_sn'],
                );
                $xml = $this->create_xml($basic, $detail);
                $res = $this->push_cancel_goods($xml);
                if (TRUE === $res) {
                    $this->db->autoExecute('', $value);
                }
            }
        } else {
            return '没有数据';
        }
    }

    /**
     * 送货功能
     */
    public function get_vehicle_delivery() {
        //测试数据
        $where = WEB_DEBUG ? " AND esu.unload_id=432 " : '';
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
                $boolean = $this->get_customer_delivery($row['unload_id']);
                if (TRUE === $boolean) {
                    //同步成功
                    $this->update_is_sync($row['invoice_id'], "invoice");
                    $log = '送货单' . $row['invoice_sn'] . '在' . date('Y-m-d H:i:s', $_REQUEST['REQUEST_TIME']) . '推送海尔成功！';
                    $note = array(
                        'invoice_id' => $row['invoice_id'],
                        'action_user' => '接口同步操作',
                        'log_time' => $_SERVER['REQUEST_TIME'],
                        'action_note' => $log,
                    );
                    $this->add_opt_note($note);
                    $this->msg[] = $log;
                }
            }
        } else {
            $this->error[] = '没有查询到指定条件的数据';
        }
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
                AND etii.fstatus = 'shipped' and etii.warehouse_id=16
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
                    'companyCode' => $value['company_id'],
                    'type' => $value['delivery_type'],
                    'note' => $value['note'],
                    'createdate' => $value['add_time'],
                );
                $detail_array = $this->get_vehicle_invoice_goods($value['invoice_sn']);
                $xml = $this->create_xml($basic_array, $detail_array);
                //发货单信息调用接口
                return $this->push_customer_delivery($xml);
            }
        }
        $this->error[] = '没有查询到数据！';
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
                $this->db->query("UPDATE `ecs_stock_invoice_info` SET `is_sync_haier` = '1' WHERE `invoice_id` ={$id}");
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
                   esig.goods_sn,esig.goods_name,esig.goods_number,esig.package_number,esig.goods_number
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
                esii.company_id,esii.delivery_type,erin.action_user,erin.note,erin.return_sn
                from ecs_stock_invoice_info esii 
                join ecs_stock_invoice_goods esig on esii.invoice_id=esig.invoice_id
                join ecs_returns_item erit   on erit.rec_id=esig.rec_id 
                join ecs_returns_info erin  on erit.returns_id=erin.returns_id and erin.`status`!='cancel'
                where esii.warehouse_id=14 and esii.is_expr=0";
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
                    'companyCode' => $value['company_id'],
                    'type' => $value['delivery_type'],
                    'operator' => $value['action_user'],
                    'operator_tel' => $value[''],
                    'note' => $value['note'],
                );
                $detail_array = $this->get_returns_detail($value['return_sn']);
                $xml = $this->create_xml($basic_array, $detail_array);
                $this->push_returns($xml);
            }
        }
        die("没有查询到指定的数据!");
    }

    /**
     * 退货单明细信息
     * @param string $return
     * @return mixed
     */
    public function get_returns_detail($return) {
        $sql = "select erit.returns_id,erit.goods_sn,erit.goods_number,erit.goods_name
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
                $str .= $v;
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
        /* 排序数组每一项 */
        foreach ($item_array as &$_val) {
            sort($_val);
        }
        unset($_val);
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
                WHERE etii.expr_id =16
                AND etii.is_expr =1
                AND etii.is_sync_haier = 0
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
        var_dump($this->error);
        exit();
    }

    /**
     * 返回成功的消息
     */
    public function get_msg() {
        var_dump($this->msg);
        exit();
    }

    /**
     * 添加操作日志
     */
    public function add_opt_note($note) {
        $this->db->autoExecute('ecs_stock_action', $note);
    }

}

$obj = new Web_Service_Client();
//1、2、 美乐乐整车送货单（MEILELE<-->海尔接口，数据推/拉） MEILELE仓库送货单明细（MEILELE<-->海尔接口，数据推/拉）------------------------V5
$obj->get_vehicle_info();
//5、客户送货通知
//$obj->get_vehicle_delivery();
//3
//$obj->push_receive_confirm('DHC025', '3700');