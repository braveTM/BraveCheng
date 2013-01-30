<?php

/**
 * 生成WDSL文件
 * 
 */
//require dirname(__FILE__) . '/webservice/web_service_server.php';
//require dirname(__FILE__) . '/SoapDiscovery.class.php';
//
//$disco = new SoapDiscovery('Web_Service_Server', 'webservice'); //第一个参数是类名（生成的wsdl文件就是以它来命名的），即Service类，第二个参数是服务的名字（这个可以随便写）。
//$disco->getWSDL();
//exit();

/**
 * 根据wsdl文件访问接口
 * 
 */
//ini_set('soap.wsdl_cache_enabled', "0"); //关闭wsdl缓存
//$soap = new SoapClient('http://beta.meilele.com:8080/Web_Service_Server.wsdl');
//
//$res = $soap->customer_return_receipt(2);
//var_dump($res);
//exit();
/**
 * SOAP 数据测试
 * 
 */
try {
    $_xml = <<<XML
  <?xml version="1.0" encoding="UTF-8"?>
  <invInfo>
  <invHeader>
  <invoice_sn>SCN-20120907-95807</invoice_sn>
  <dest_wh_id>149</dest_wh_id><warehouse_id>1</warehouse_id>
  <arrival_time>0</arrival_time>
  <driver_name>租车</driver_name>
  <license_number>租车</license_number>
  <driver_mobile></driver_mobile>
  <inv_total>2</inv_total>
  <package_total>604</package_total>
  <operator>仓库</operator>
  <operator_tel>SCN-20120907-95807</operator_tel>
  <createdate>1347003136</createdate>
  <note></note>
  </invHeader>
  <items>
  <item>
  <goodsSn>INV-20130108-11092</goodsSn>
  <goodsNum>INV-20130116-34609</goodsNum>
  <status>INV-20130116-34609</status>
  <note>INV-20130116-34609</note>
  </item>
  <item>
  <goodsSn>INV-20130108-11092</goodsSn>
  <goodsNum>INV-20130116-34609</goodsNum>
  <status>INV-20130116-34609</status>
  <note>INV-20130116-34609</note>
  </item>
  </items>
  <authKey>e9e25025abb7526d35f7a399779743bf_</authKey>
  </invInfo>
XML;

//    $soap = new SoapClient(null, array(
//                "location" => "http://beta.meilele.com:8080/webservice/web_service.php",
//                "uri" => "http://test.meilele.com:8085/", //资源描述符服务器和客户端必须对应
//                "style" => SOAP_RPC,
//                "use" => SOAP_ENCODED
//            ));
    $soap = new SoapClient('http://test.meilele.com:8085/web_interface.php');
    var_dump($soap->customer_delivery_receipt(1, 111));
//    $soap = new SoapClient('http://beta.meilele.com:8080/webservice/web_service_server.php');
//    $res = $soap->test_api(1, 111);
//    printr($res);
} catch (Exction $e) {
    echo print_r($e->getMessage(), true);
}

function printr($expression) {
    echo "<pre>";
    var_dump($expression);
}
