<?php
/**
 * Description of SMS
 *
 * @author moi
 */
class SMSFactory{
    /**
     * 获取短信类实例
     * @param <type> $tos
     * @param <type> $content
     * @return LKSMS 
     */
    public static function get_object($tos, $content){
        $sms = new LKSMS($tos, $content);
        return $sms;
    }
}

class SMS {
    protected $username = '';

    protected $password = '';

    protected $tos;

    protected $content;

    public function  __construct($tos, $content) {
        $this->tos     = $tos;
        $this->content = $content;
    }

    public function send(){
        return false;
    }

    public function receive(){
        /**
         * phone,content,date,key
         */
        return null;
    }

    public function set_info($tos, $content){
        $this->tos     = $tos;
        $this->content = $content;
    }

    protected function check_send(){
        if(!empty($this->username) && !empty($this->password) && !empty($this->tos) && !empty($this->content)){
            return true;
        }
        else{
            return false;
        }
    }
}

class LKSMS extends SMS{
    public function  __construct($tos, $content) {
        parent::__construct($tos, $content);
        $this->username = 'LKSDK0001902';
        $this->password = 'zx2012~!';
    }
    
    public function send($key){
        if(!$this->check_send())
            return false;
        //凌凯编码为GB2312
        $this->content = iconv('utf-8', 'gb2312', $this->content);
        $to = explode(',', $this->tos);
        if(count($to) > 1){
            return $this->batch_send($key);
        }
        else{
            return $this->single_send($key);
        }
    }

    public function receive(){
        $url = 'http://mb345.com/WS/Get.aspx?CorpID='.$this->username.'&Pwd='.$this->password;
        $result = file_get_contents($url);
        if(empty($result))
            return null;
        $receive = explode('||', $result);
        foreach($receive as $item){
            if(!empty($item)){
                $temp = explode('#', $item);
                $info['phone']   = $temp[0];
                $info['content'] = $temp[1];
                $info['date']    = $temp[2];
                $info['key']     = $temp[3];
                $data[] = $info;
            }
        }
        return $data;
    }

    protected function single_send($key){
        $url = 'http://mb345.com/WS/Send.aspx?CorpID='.$this->username.'&Pwd='.$this->password.'&Mobile='.$this->tos.'&Content='.$this->content.'&Cell='.$key.'&SendTime=';
        $result = file_get_contents($url);
        if($result === 0 || $result === '0')
            return true;
        else{
            return false;
        }
    }

    protected function batch_send($key){
        $url = 'http://mb345.com/WS/BatchSend.aspx?CorpID='.$this->username.'&Pwd='.$this->password.'&Mobile='.$this->tos.'&Content='.$this->content.'&Cell='.$key.'&SendTime=';
        $result = file_get_contents($url);
        if($result === 0 || $result === '0' || $result === 1 || $result === '1')
            return true;
        else{
            return false;
        }
    }
}
?>
