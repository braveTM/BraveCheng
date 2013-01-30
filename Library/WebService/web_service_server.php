<?php

define('MKEY', 'ky7ac#@zvm291rm!91asf&@af'); #私钥
define('IN_ECS', true);
require (dirname(__FILE__) . '/includes/init.php');

class Web_Service_Server {

    public static $receipt_type = array(
        0 => '送货服务单 ',
        1 => '退货服务单',
    );
    public $db;

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

    /**
     * MEILELE客户送货服务单回执（MEILELE<-->海尔接口，数据推/拉）
     * @param string $xmlcon xml格式数据
     * @return mixed
     */
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
            'invoice_sn' => $xml_array['invHeader']['invoice_sn'],
            'type' => 0,
            'note' => $xml_array['invHeader']['note'],
            'note_url' => $xml_array['invHeader']['note_url'],
            'receipt_time' => $xml_array['invHeader']['senddate'],
            'rate' => $xml_array['invHeader']['rate'],
        );
        //商品数量
        $rec_goods_total = sizeof($xml_array['items']['item']);
        if ($rec_goods_total > 0) {
            //添加商品
            $i = 0;
            while ($i < $rec_goods_total) {
                $rec_goods_data = array(
                    'invoice_sn' => $xml_array['invHeader']['invoice_sn'],
                    'goods_sn' => $xml_array['items']['item'][$i]['goodsSn'],
                    'goods_num' => $xml_array['items']['item'][$i]['goodsNum'],
                    'status' => $xml_array['items']['item'][$i]['status'],
                    'note' => $xml_array['items']['item'][$i]['note'],
                );
                $detail_insert = $this->db->autoExecute('ecs_stock_invoice_goods_extend', $rec_goods_data);
                if (!$detail_insert) {
                    return $this->xml_error(1, '商品数据入库失败！');
                }
                $i++;
            }
        }
        $basic_insert = $this->db->autoExecute('ecs_stock_invoice_info_extend', $rec_data);
        if (!$basic_insert) {
            return $this->xml_error(1, '单据数据入库失败！');
        }
        return $this->xml_error();
    }

    /**
     * MEILELE客户退货服务单回执（MEILELE<-->海尔接口，数据推/拉）
     * @param string $xmlcon xml格式数据
     * @return mixed
     */
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
            'invoice_sn' => $xml_array['invHeader']['invoice_sn'],
            'type' => 1,
            'note' => $xml_array['invHeader']['note'],
            'note_url' => $xml_array['invHeader']['note_url'],
            'receipt_time' => $xml_array['invHeader']['senddate'],
            'rate' => $xml_array['invHeader']['rate'],
        );
        //商品数量
        $rec_goods_total = sizeof($xml_array['items']['item']);
        if ($rec_goods_total > 0) {
            //添加商品
            $i = 0;
            while ($i < $rec_goods_total) {
                $rec_goods_data = array(
                    'invoice_sn' => $xml_array['invHeader']['invoice_sn'],
                    'goods_sn' => $xml_array['items']['item'][$i]['goodsSn'],
                    'goods_num' => $xml_array['items']['item'][$i]['goodsNum'],
                    'status' => $xml_array['items']['item'][$i]['status'],
                    'note' => $xml_array['items']['item'][$i]['note'],
                );
                $detail_insert = $this->db->autoExecute('ecs_stock_invoice_goods_extend', $rec_goods_data);
                if (!$detail_insert) {
                    return $this->xml_error(1, '商品数据入库失败！');
                }
                $i++;
            }
        }
        $basic_insert = $this->db->autoExecute('ecs_stock_invoice_info_extend', $rec_data);
        if (!$basic_insert) {
            return $this->xml_error(1, '单据数据入库失败！');
        }
        return $this->xml_error();
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
     * 测试接口
     * @param mixed $a
	 * @param mixed $b
     * @return mixed 相加结果
     */
    public function test_api($a, $b) {
        return $a + $b;
    }

}

$soap = new SoapServer(null, array('uri' => "http://test.meilele.com:8085/"));
$soap->setClass('Web_Service_Server');
$soap->handle();
?>



