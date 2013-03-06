<?php

define('IN_ECS', true);
require (dirname(__FILE__) . '/includes/init.php');
define('MKEY', 'ky7ac#@zvm291rm!91asf&@af'); #私钥

class Web_Service_Server {

    public static $receipt_type = array(
        0 => '送货服务单 ',
        1 => '退货服务单',
    );
    public $db = null;

    public function __construct() {
        $this->db = & $GLOBALS['db'];
    }

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

    public function customer_delivery_receipt($xmlcon = '') {
        if (!$xmlcon) {
            return $this->xml_error(1, '未接受到任何参数');
        }
        //转换xml格式为object格式
        $xml_array = $this->xml_to_array($xmlcon);
        //验证key规则是否相同
        if (empty($xml_array['authKey']) || md5($xml_array['invHeader']['invoice_sn'] . MKEY) != $xml_array['authKey']) {
            return $this->xml_error(1, '验证码为空或者错误！');
        }
        //数据组装
        $rec_data = array(
            'invoice_sn' => empty($xml_array['invHeader']['invoice_sn']) ? '' : $xml_array['invHeader']['invoice_sn'],
            'type' => 0,
            'note' => empty($xml_array['invHeader']['note']) ? '' : $xml_array['invHeader']['note'],
            'note_url' => empty($xml_array['invHeader']['note_url']) ? '' : $xml_array['invHeader']['note_url'],
            'receipt_time' => empty($xml_array['invHeader']['senddate']) ? '' : $xml_array['invHeader']['senddate'],
            'rate' => empty($xml_array['invHeader']['rate']) ? '' : $xml_array['invHeader']['rate'],
        );
        //商品数量
        $rec_goods_total = sizeof($xml_array['items']['item']);
        if ($rec_goods_total > 0) {
            //添加商品
            $i = 0;
            while ($i < $rec_goods_total) {
                $rec_goods_data = array(
                    'invoice_sn' => empty($xml_array['invHeader']['invoice_sn']) ? '' : $xml_array['invHeader']['invoice_sn'],
                    'goods_sn' => empty($xml_array['items']['item'][$i]['goodsSn']) ? '' : $xml_array['items']['item'][$i]['goodsSn'],
                    'goods_num' => empty($xml_array['items']['item'][$i]['goodsNum']) ? '' : $xml_array['items']['item'][$i]['goodsNum'],
                    'status' => empty($xml_array['items']['item'][$i]['status']) ? '' : $xml_array['items']['item'][$i]['status'],
                    'note' => empty($xml_array['items']['item'][$i]['note']) ? '' : $xml_array['items']['item'][$i]['note'],
                );
                //如果存在，不需要添加
                $res_exs_id = $this->db->getOne("select id from ecs_stock_invoice_goods_extend where invoice_sn = '{$rec_goods_data['invoice_sn']}' AND goods_sn = '{$rec_goods_data['goods_sn']}' AND goods_num='{$rec_goods_data['goods_num']}' AND status='{$rec_goods_data['status']}'");
                if (!$res_exs_id) {
                    $detail_insert = $this->db->autoExecute('ecs_stock_invoice_goods_extend', $rec_goods_data);
                    if (!$detail_insert) {
                        return $this->xml_error(1, '商品数据入库失败！');
                    }
                } else {
                    $this->db->autoExecute('ecs_stock_invoice_goods_extend', $rec_goods_data, 'UPDATE', " id = '{$res_exs_id}'");
                }
                $i++;
            }
        }
        $res_id = $this->db->getOne("select id from ecs_stock_invoice_info_extend where invoice_sn = '{$rec_data['invoice_sn']}' AND type = '{$rec_data['type']}' AND rate='{$rec_data['rate']}'");
        if (!$res_id) {
            $basic_insert = $this->db->autoExecute('ecs_stock_invoice_info_extend', $rec_data);
            if (!$basic_insert) {
                return $this->xml_error(1, '单据数据入库失败！');
            }
        } else {
            $this->db->autoExecute('ecs_stock_invoice_info_extend', $rec_data, 'UPDATE', " id = '{$res_id}'");
        }
        return $this->xml_error();
    }

    public function customer_return_receipt($xmlcon = '') {
        if (!$xmlcon) {
            return $this->xml_error(1, '未接受到任何参数');
        }
        //转换xml格式为object格式
        $xml_array = $this->xml_to_array($xmlcon);
        //验证key规则是否相同
        if (empty($xml_array['authKey']) || md5($xml_array['invHeader']['invoice_sn'] . MKEY) != $xml_array['authKey']) {
            return $this->xml_error(1, '验证码为空或者错误！');
        }
        //数据组装
        $rec_data = array(
            'invoice_sn' => empty($xml_array['invHeader']['invoice_sn']) ? '' : $xml_array['invHeader']['invoice_sn'],
            'type' => 1,
            'note' => empty($xml_array['invHeader']['note']) ? '' : $xml_array['invHeader']['note'],
            'note_url' => empty($xml_array['invHeader']['note_url']) ? '' : $xml_array['invHeader']['note_url'],
            'receipt_time' => empty($xml_array['invHeader']['recedate']) ? '' : $xml_array['invHeader']['recedate'],
            'rate' => empty($xml_array['invHeader']['rate']) ? 0 : $xml_array['invHeader']['rate'],
        );
        //商品数量
        $rec_goods_total = sizeof($xml_array['items']['item']);
        if ($rec_goods_total > 0) {
            //添加商品
            $i = 0;
            while ($i < $rec_goods_total) {
                $rec_goods_data = array(
                    'invoice_sn' => empty($xml_array['invHeader']['invoice_sn']) ? '' : $xml_array['invHeader']['invoice_sn'],
                    'goods_sn' => empty($xml_array['items']['item'][$i]['goodsSn']) ? '' : $xml_array['items']['item'][$i]['goodsSn'],
                    'goods_num' => empty($xml_array['items']['item'][$i]['goodsNum']) ? '' : $xml_array['items']['item'][$i]['goodsNum'],
                    'status' => empty($xml_array['items']['item'][$i]['status']) ? '' : $xml_array['items']['item'][$i]['status'],
                    'note' => empty($xml_array['items']['item'][$i]['note']) ? '' : $xml_array['items']['item'][$i]['note'],
                );
                //如果存在，不需要添加
                $res_exs_id = $this->db->getOne("select id from ecs_stock_invoice_goods_extend where invoice_sn = '{$rec_goods_data['invoice_sn']}' AND goods_sn = '{$rec_goods_data['goods_sn']}' AND goods_num='{$rec_goods_data['goods_num']}' AND status='{$rec_goods_data['status']}'");
                if (!$res_exs_id) {
                    $detail_insert = $this->db->autoExecute('ecs_stock_invoice_goods_extend', $rec_goods_data);
                    if (!$detail_insert) {
                        return $this->xml_error(1, '商品数据入库失败！');
                    }
                } else {
                    $this->db->autoExecute('ecs_stock_invoice_goods_extend', $rec_goods_data, 'UPDATE', "id = '{$res_exs_id}'");
                }
                $i++;
            }
        }
        $res_id = $this->db->getOne("select id from ecs_stock_invoice_info_extend where invoice_sn = '{$rec_data['invoice_sn']}' AND type = '{$rec_data['type']}' AND rate='{$rec_data['rate']}'");
        if (!$res_id) {
            $basic_insert = $this->db->autoExecute('ecs_stock_invoice_info_extend', $rec_data);
            if (!$basic_insert) {
                return $this->xml_error(1, '单据数据入库失败！');
            }
        } else {
            $this->db->autoExecute('ecs_stock_invoice_info_extend', $rec_data, 'UPDATE', " id = '{$res_id}' ");
        }
        return $this->xml_error();
    }

    public function xml_to_array($xml) {
        $res = @simplexml_load_string($xml, NULL, LIBXML_NOCDATA);
        return json_decode(json_encode($res), true);
    }

    public function test_api($a, $b) {
        return $a + $b;
    }

}

$soap = new SoapServer(null, array('uri' => "http://www.meilele.com/"));
$soap->setClass('Web_Service_Server');
$soap->handle();
?>



