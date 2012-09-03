<?php
/**
 * 网银支付
 * @param <string> $order_id 订单编号
 */
function wangyinto($order_id){
    $config = C('WANGYIN_CONFIG');
    $mtype  = 'CNY';
    $text   = $_POST['money'].$mtype.$order_id.$config['mid'].$config['url'].$config['key'];
    $md5    = strtoupper(md5($text));
    $str    = '正在跳转到网银在线...
                <form method="post" name="wangyin" action="https://Pay3.chinabank.com.cn/PayGate">
                        <input type="hidden" name="v_mid"         value="'.$config['mid'].'">
                        <input type="hidden" name="v_oid"         value="'.$order_id.'">
                        <input type="hidden" name="v_amount"      value="'.$_POST['money'].'">
                        <input type="hidden" name="v_moneytype"   value="'.$mtype.'">
                        <input type="hidden" name="v_url"         value="'.$config['url'].'">
                        <input type="hidden" name="v_md5info"     value="'.$md5.'">
                </form>
                <script>document.forms["wangyin"].submit();</script>';
    return $str;
}

/**
 * 网银支付回调函数
 */
function wangyin_callback(){
    $config = C('WANGYIN_CONFIG');
    $v_oid     =trim($_POST['v_oid']);
    $v_pmode   =trim($_POST['v_pmode']);
    $v_pstatus =trim($_POST['v_pstatus']);
    $v_pstring =trim($_POST['v_pstring']);
    $v_amount  =trim($_POST['v_amount']);
    $v_moneytype  =trim($_POST['v_moneytype']);
    $remark1   =trim($_POST['remark1' ]);
    $remark2   =trim($_POST['remark2' ]);
    $v_md5str  =trim($_POST['v_md5str' ]);                                                  //返回的md5值
    $md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$config['key']));    //重新计算md5值
    if($md5string == $v_md5str && $v_pstatus == '20'){
        //md5值相等并且支付状态为20则支付成功
        return true;
    }
    else{
        return false;
    }
}
?>
