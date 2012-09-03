<?php
define('CALL_NONE', 0);
define('CALL_INIT', 1);
define('CALL_START', 2);
define('CALL_END', 3);
/**
 * Description of Call
 *
 * @author moi
 */
class Call {
    /**
     * 拨打电话
     * @param string $own_number 拨打者的联系方式（必选）
     * @param string $call_number 被拨打的联系方式（必选）
     * @param int $max_seconds 通话的最大秒数（必选）
     * @param string $order_id 订单编号，用于对应商家的订单（可选）
     * @param int $delay 延迟拨打的秒数（0-86400之间）（可选）
     * @param string $des 本次通话的文字描述（可选）
     * @return string 成功返回本次请求编号，失败返回空字符串
     */
    public function call($own_number, $call_number, $max_seconds, $order_id, $delay, $des){}
    
    /**
     * 获取通话状态
     * @param string $request_id 通话编号（必选）
     * @return int 0.通话不存在 1.通话连接中 2.正在通话中 3.通话已结束
     */
    public function get_status($request_id){}
    
    /**
     * 获取通话结果
     * @param string $request_id 通话编号（必选）
     * @return
     */
    public function get_result($request_id){}
}

class AnveoCall extends Call {
    private $config = array(
        'user_key'      => '4ed6d0118804912741cb3f5d874f00ce9a0425c4',
        'call_flow'     => '40dc6583e68907dc9057608f0fb27f8b773bd531',
        'caller_id'     => '862885333199',
        'api_url'       => 'https://www.anveo.com/apicall.asp'
    );
    
    /**
     * 拨打电话
     * @param string $own_number 拨打者的联系方式（必选）
     * @param string $call_number 被拨打的联系方式（必选）
     * @param int $max_seconds 通话的最大秒数（必选）
     * @param string $order_id 订单编号，用于对应商家的订单（可选）
     * @param int $delay 延迟拨打的秒数（0-86400之间）（可选）
     * @param string $des 本次通话的文字描述（可选）
     * @return string 成功返回本次通话编号，失败返回空字符串
     */
    public function call($own_number, $call_number, $max_seconds, $order_id = '', $delay = 0, $des = ''){
        if($delay <= 0)
            return '';
        else if($delay > 86400){
            $delay = 86400;
        }
        $data = '<?xml version="1.0" standalone="no" ?>
                    <REQUEST>
                            <USERTOKEN>
                                    <USERKEY>'.$this->config['user_key'].'</USERKEY>
                            </USERTOKEN>
                            <ACTION NAME="DIAL.CALLFLOW"> 
                                    <PARAMETER NAME="PHONENUMBER">86'.$own_number.'</PARAMETER>	
                                    <PARAMETER NAME="CALLERID">'.$this->config['caller_id'].'</PARAMETER>
                                    <PARAMETER NAME="CALLFLOW">'.$this->config['call_flow'].'</PARAMETER>
                                    <PARAMETER NAME="VARIABLE" VARIABLENAME="CALLINGPARTY">'.$call_number.'</PARAMETER>
                                    <PARAMETER NAME="VARIABLE" VARIABLENAME="MAXTIME">'.$max_seconds.'</PARAMETER> 
                                    <PARAMETER NAME="BILLINGCODE">'.$order_id.'</PARAMETER>
                                    <PARAMETER NAME="DELAY">'.$delay.'</PARAMETER>
                                    <PARAMETER NAME="MEMO">'.$des.'</PARAMETER>
                            </ACTION>
                    </REQUEST>
        ';
        $response = $this->request($data);
        $xml = (array)simplexml_load_string($response);
        if($xml['RESULT'] == 'SUCCESS'){
            if(!empty($xml['VALUE'])){
                return $xml['VALUE'];
            }
        }
        return '';
    }
    
    /**
     * 获取通话状态
     * @param string $request_id 通话编号（必选）
     * @return int 0.通话不存在 1.通话连接中 2.正在通话中 3.通话已结束
     */
    public function get_status($request_id){
        $data = '<?xml version="1.0" standalone="no" ?>
                    <REQUEST>
                            <USERTOKEN>
                                    <USERKEY>'.$this->config['user_key'].'</USERKEY>
                            </USERTOKEN>
                            <ACTION NAME="DIAL.GETSTATUS">
                                <PARAMETER NAME="REQUESTID">'.$request_id.'</PARAMETER>
                            </ACTION>
                    </REQUEST>
        ';
        $response = $this->request($data);
        $xml = (array)simplexml_load_string($response);
        switch ($xml['RESULT']) {
            case 'NONE' : $return = CALL_NONE; break;
            case 'INIT' : $return = CALL_INIT; break;
            case 'START' : $return = CALL_START; break;
            case 'END' : $return = CALL_END; break;
            default : $return = CALL_NONE; break;
        }
        return $return;
    }
    
    /**
     * 获取通话结果
     * @param string $request_id 通话编号（必选）
     * @return
     */
    public function get_result($request_id){
        $data = '<?xml version="1.0" standalone="no" ?>
                    <REQUEST>
                            <USERTOKEN>
                                    <USERKEY>'.$this->config['user_key'].'</USERKEY>
                            </USERTOKEN>
                            <ACTION NAME="DIAL.CALLFLOW.GETRESULT">
                                <PARAMETER NAME="REQUESTID">'.$request_id.'</PARAMETER>
                            </ACTION>
                    </REQUEST>
        ';
        $response = $this->request($data);
        $xml = (array)simplexml_load_string($response);
        return $result = $xml['RESULT'];
    }
    
    protected function request($data){
        $timeout = 15;
        $url = $this->config['api_url'];
        $matches = parse_url($url);
        !isset($matches['host']) && $matches['host'] = '';
        !isset($matches['path']) && $matches['path'] = '';
        !isset($matches['query']) && $matches['query'] = '';
        !isset($matches['port']) && $matches['port'] = '';
        $host = $matches['host'];
        $path = $matches['path'] ? $matches['path'] . ($matches['query'] ? '?' . $matches['query'] : '') : '/';
        $port = !empty($matches['port']) ? $matches['port'] : 80;
            $out = "POST $path HTTP/1.0\r\n";
            $out .= "Accept: */*\r\n";
            //$out .= "Referer: $boardurl\r\n";
            $out .= "Accept-Language: zh-cn\r\n";
            $out .= "Content-Type: application/xml; charset=UTF-8\r\n";
            $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
            $out .= "Host: $host\r\n";
            $out .= 'Content-Length: ' . strlen($data) . "\r\n";
            $out .= 'Accept: application/xml; charset=UTF-8\r\n';
            $out .= "Connection: Close\r\n";
            $out .= "Cache-Control: no-cache\r\n";
            $out .= "Cookie: \r\n\r\n";
            $out .= $data;
        $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!$fp) {
            return ''; //note $errstr : $errno \r\n
        } else {
            stream_set_blocking($fp, TRUE);
            stream_set_timeout($fp, $timeout);
            @fwrite($fp, $out);
            $status = stream_get_meta_data($fp);
            if (!$status['timed_out']) {
                while (!feof($fp)) {
                    if (($header = @fgets($fp)) && ($header == "\r\n" || $header == "\n")) {
                        break;
                    }
                }

                $stop = false;
                while (!feof($fp) && !$stop) {
                    $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                    $return .= $data;
                    if ($limit) {
                        $limit -= strlen($data);
                        $stop = $limit <= 0;
                    }
                }
            }
            @fclose($fp);
            return $return;
        }
    }
}

class CallFactory {
    /**
     * 获取拨打电话对象实例
     * @return Call
     */
    public static function get_instance(){
        return new AnveoCall();
    }
}

?>
