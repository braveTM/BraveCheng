<?php

define('MKEY', 'ky7ac#@zvm291rm!91asf&@af'); #私钥
define('IN_ECS', true);
require (dirname(__FILE__) . '/includes/init.php');

class Web_Service_Client {

    public $db;

    public function __construct() {
        $this->db = & $GLOBALS['db'];
    }

    /**
     * 获取整车基础信息
     */
    public function get_vehicle_info() {
//        $where = " AND esn.warehouse_id = '149'";
        //查询车次单里面的已经发货的包含青岛仓库，同时没有同步完成的车次单
        $sql = " SELECT * FROM `ecs_shipcar_number`AS esn WHERE 1 {$where}  AND esn.fstatus = 'shippied' AND esn.is_sync_haier = 0 AND esn.type=7 limit 1";
        $list = $this->db->getAll($sql);

        //如果存在
        if ($list) {
            foreach ($list as $row) {
                //车次单单据号
                $invoices = $this->get_vehicle_invoices($row['shipcar_id']);
                //单据总数
                $inv_total = sizeof($invoices);
                $array = array(
                    'shipcar_sn' => $row['shipcar_sn'],
                    'dest_wh_id' => 149,
                    'warehouse_id' => $row['warehouse_id'],
                    'arrival_time' => $row['arrival_time'], //预计到货时间
                    'driver_name' => $row['driver_name'], //司机名称
                    'license_number' => $row['car_number'], //车牌号
                    'driver_mobile' => $row['driver_mobile'] ? $row['driver_mobile'] : '', //司机电话
                    'inv_total' => $inv_total, //发货单单据数量
                    'package_total' => $row['package_total'], //总包件数
                    'operator' => $row['loader'], //排车人
                    'operator_tel' => $row['shipcar_sn'], //排车人电话
                    'createdate' => $row['add_time'], //创建时间
                    'note' => $row['note'], //备注
                );
                $push_xml = $this->create_xml($array, $invoices);

                //发送数据，获取返回的结果
                try {
                    $soap = new SoapClient(null, array(
                                "location" => "http://beta.meilele.com:8080/web_service.php",
                                "uri" => "http://test.meilele.com:8085/webservice/", //资源描述符服务器和客户端必须对应
                                "style" => SOAP_RPC,
                                "use" => SOAP_ENCODED
                            ));
                    //调用服务端的方法
                    $boolean = $soap->demo();
                    $xml = new XMLReader();
                    $xml->XML($boolean->return);
                    $flag = false;
                    while ($xml->read()) {
                        if ($xml->nodeType == 3 && $xml->depth == 2) {
                            if ($xml->value === 'success') {
                                $flag = true;
                            }
                        }
                    }
                    //如果成功调用webservice成功，同时返回成功值，继续发送该发货单明细
                    if ($flag) {
                        if (is_array($invoices)) {
                            foreach ($invoices as $invoice_id => $val) {
                                $per_push_xml = $this->get_diff_invoice_detail($invoice_id);
                            }
                        }
                    }
                } catch (Exception $exc) {
                    var_dump($exc->getMessage());
                }
            }
        }
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
            $str .="<item>" . $value . "</item>";
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
      获取车次单里面的单据信息
     * @param int $shipcar_id 车次单id
     * @param boolean $is_synnc 是否同步过
     */
    public function get_vehicle_invoices($shipcar_id, $is_synnc = FALSE) {
        $where = ' WHERE 1';
        $array = array();
        $where .= $is_synnc ? " AND is_sync_haier = 1 " : " AND is_sync_haier = 0";
        $where .= $shipcar_id ? " AND shipcar_id = {$shipcar_id}" : '';
        $list = $this->db->getAll("SELECT * FROM `ecs_shipcar_client` {$where}");
        if ($list) {
            foreach ($list as $row) {
                $array[$row['invoice_id']] = '<invoice_sn>' . $row['invoice_sn'] . '</invoice_sn>';
            }
        }
        return $array;
    }

    /**
     * 查询整车单据详细信息
     * @param int $id 单据id
     * @return array 单据信息数组
     */
    public function get_vehicle_invoice_info($id) {
        $sql = "SELECT `id`, `shipcar_id`, `invoice_id`, `invoice_sn`, `consignee`, `package_total`, `volumn_total`, `city`, `fstatus`, `type`, `pre_shipcar_id`, `order_id`, `order_sn`, `is_sync_haier` FROM `ecs_shipcar_client` WHERE `id` ={$id} ";
        return $this->db->getRow($sql);
    }

    /**
     * 获取不同单据的相信信息
     * @param int $id 单据id
     */
    public function get_diff_invoice_detail($id) {
        $sql = "SELECT * FROM `ecs_stock_invoice_info` WHERE `invoice_id` = {$id}  AND is_sync_haier = 0";
        $row = $this->db->getRow($sql);
        switch ($row['type']) {
            case 'allocate':

                //调拨单
                break;
            case 'patch':
                //补件单
                break;
            case 'invoice':
                //发货单单据基础信息
                $basic_array = array(
                    'invoice_sn' => $row['invoice_sn'], //单据号
                    'order_sn' => $row['order_sn'], //订单号
                    'consignee' => $row['consignee'], //收货人名称
                    'country' => $row['country'], //收货人所在的国家的id
                    'province' => $row['province'], //收货人所在的省id
                    'city' => $row['city'], //市区
                    'district' => $row['district'], //收货人所在的区
                    'address' => $row['address'], //收货人地址
                    'goods_amount' => $row['goods_amount'], //商品种类总数
                    'total_package_num' => $row['total_package_num'], //单据总包件数
                    'companyCode' => $row['company_id'],
                    'note' => $row['note'],
                );
                $goods = $this->db->getAll("SELECT * FROM `ecs_stock_invoice_goods` WHERE `invoice_id` = {$id}");
                if ($goods) {
                    foreach ($goods as $key => $value) {
                        //发货单明细信息
                        $detail_array[$key] = array(
                            'goodsSn' => $value['goods_sn'], //商品编号
                            'goodsName' => $value['goods_name'], //商品名称
                            'goodsNum' => $value['goods_number'], //商品数量
                            'total_package_num' => $value['package_number'], //单据总包件数
                        );
                    }
                }
                //生成xml格式数据
                $push_xml = $this->create_xml($basic_array, $detail_array);
                return $push_xml;
                break;
        }
    }

    /**
     * 仓库收货确认接口
     * @param type $invoice_sn
     */
    public function check_invoice_is_reviced($invoice_sn) {
        try {
            $soap = new SoapClient(null, array(
                        "location" => "http://beta.meilele.com:8080/web_service.php",
                        "uri" => "http://beta.meilele.com:8080/", //资源描述符服务器和客户端必须对应
                        "style" => SOAP_RPC,
                        "use" => SOAP_ENCODED
                    ));
            //调用服务端的方法
            $boolean = $soap->demo();
            $xml = new XMLReader();
            $xml->XML($boolean->return);
            $flag = false;
            while ($xml->read()) {
                if ($xml->nodeType == 3 && $xml->depth == 2) {
                    if ($xml->value === 'success') {
                        $flag = true;
                    }
                }
            }

            //如果成功调用webservice成功，同时返回成功值，继续发送该发货单明细
            if ($flag) {
                $data = array(
                    'invoice_sn' => '',
                    'order_sn' => '',
                    'goods_amount' => '',
                    'total_package_num' => '',
                    'rece_date' => '',
                    'note' => '',
                    'note_url' => '',
                    'companyCode' => '',
                );
            }
        } catch (Exception $exc) {
            var_dump($exc->getMessage());
        }
    }

}

$obj = new Web_Service_Client();
$obj->get_vehicle_info();
