<?php
header('Content-type:text/html;charset=utf-8');

require_once 'city.php';
@error_reporting(0);
if ($_POST['submit'] === 'OK') {
    $client = new SoapClient('http://www.webxml.com.cn/WebServices/WeatherWebService.asmx?wsdl');
    $code = $_POST['city'];
    //$code = '深圳';
    $para = array('theCityName' => $code);
    $res = $client->__Call('getWeatherbyCityName', array('paramters' => $para))->getWeatherbyCityNameResult->string;
    echo "<pre>";
    echo "城市：" . $res[1];
    echo "<br/>气温：" . $res[5];
    echo "<br/>天气：" . $res[6];
    echo "<br/>风力：" . $res[7];
    echo "</pre>";
    //$qq = $_POST['qqnum'];
    $qq = $_REQUEST['qqnum'];
    if (!empty($qq)) {
        if (preg_match('/^\d+$/', $qq)) {
            $client = new SoapClient('http://www.webxml.com.cn/webservices/qqOnlineWebService.asmx?wsdl', array('trace' => 1));
            var_dump($client->__getFunctions());
            $para = array('qqCode' => $qq);
            $res = $client->__Call('qqCheckOnline', array('paramters' => $para))->qqCheckOnlineResult;
            echo $qq . ' 目前' . ($res == 'Y' ? '在线' : '离线');
        } else {
            echo '<em>错误的qq号码</em>';
        }
    }
}
?>
<form method="post">
    天气预报查询：
    <select name="city">
        <?php
        foreach ($Citys as $k => $v) {
            echo "<option value=\"$k\">$v</option>";
        }
        ?>
    </select>
    <br />
    QQ在线查询：<input type="text" name="qqnum" />
    <input type="submit" value="OK" name="submit" />
</form>