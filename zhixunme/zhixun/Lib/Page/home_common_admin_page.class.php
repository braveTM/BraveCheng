<?php
/**
 * 后台管理公共数据提供
 * @author YoyiorLee
 */
class home_common_admin_page {
    /**
     * 左侧导航
     * @return <mixed>
     */
    public static function left_navigate(){
        $user = AccountInfo::get_role_id();//判断权限
        //如果为个人，获取导航分类
        if($user == C('ROLE_TALENTS')){
            $data = array(self::n_account(), self::n_bill(), self::n_package(), self::n_task(), self::n_delegate(), self::n_message(), self::n_promote());
        }
        //如果为经纪人/经济公司，获取导航分类
        else if($user == C('ROLE_AGENT')){
            $data = array(self::n_account(), self::n_bill(), self::n_package(), self::n_task(), self::n_delegate(2), self::n_message(), self::n_promote(), self::n_pool());
        }
        //如果为承包商，获取导航分类
        else if($user == C('ROLE_SUBCONTRACTOR')){
            $data = array(self::n_account(), self::n_bill(), self::n_package(), self::n_task(), self::n_delegate(), self::n_message(), self::n_promote());
        }
        //如果为企业，获取导航分类
        else if($user == C('ROLE_ENTERPRISE')){
            $data = array(self::n_account(), self::n_bill(), self::n_package(), self::n_task(), self::n_delegate(), self::n_message(), self::n_promote());
        }
        //如果为管理员，获取导航分类
//            else if($user == 5){
//            }
        else{
            $data  = null;
        }
        foreach ($data as $key => $value) {
            //获取二级分类作为指定一级分类的CHILDREN
            $data[$key]['children'] = FactoryVMap::list_to_models($value['children'], 'common_common_tnav');
        }
        $data    = FactoryVMap::list_to_models($data, 'common_common_tnav');
        return $data;
    }

    /**
     * 后台头部
     */
    public static function back_header(){
        switch (AccountInfo::get_role_id()) {
            case C('ROLE_TALENTS')       : $header = 'Home:Public:tbackheader'; break;
            case C('ROLE_ENTERPRISE')    : $header = 'Home:Public:ebackheader'; break;
            case C('ROLE_AGENT')         : $header = 'Home:Public:abackheader'; break;
            case C('ROLE_SUBCONTRACTOR') : $header = 'Home:Public:abackheader'; break;
            default : $header = 'Public:tbackheader'; break;
        }
        return $header;
    }

    /**
     * 后台导航
     */
    public static function back_navigate(){
        switch (AccountInfo::get_role_id()) {
            case C('ROLE_TALENTS')       : $navigate = 'tnav'; break;
            case C('ROLE_ENTERPRISE')    : $navigate = 'enav'; break;
            case C('ROLE_AGENT')         : $navigate = 'anav'; break;
            case C('ROLE_SUBCONTRACTOR') : $navigate = 'snav'; break;
            default : $navigate = ''; break;
        }
        return $navigate;
    }

    //----------------protected------------------

    /**
     * 导航——账户设置
     * @return <array>
     */
    protected static function n_account(){
        return array('id'=>1000,'title'=>'账户设置','icon'=>'icon.png','url'=>C('WEB_ROOT').'/profiles',
            'children'=>array(
                self::n_profile(),
                self::n_password(),
                self::n_label(),
                self::n_auth()
            ));
    }

    /**
     * 导航——我的账本
     * @return <array>
     */
    protected static function n_bill(){
        return array('id'=>1001,'title'=>'我的账本','icon'=>'icon.png','url'=>C('WEB_ROOT').'/bill',
            'children'=>array(
                self::n_binfo(),
                self::n_recharge()
            ));
    }

    /**
     * 导航——套餐管理
     * @return <array>
     */
    protected static function n_package(){
        return array('id'=>1002,'title'=>'套餐管理','icon'=>'icon.png','url'=>C('WEB_ROOT').'/mpackage','children'=>null);
    }

    /**
     * 导航——任务管理
     * @return <array>
     */
    protected static function n_task(){
        return array('id'=>1003,'title'=>'任务管理','icon'=>'icon.png','url'=>C('WEB_ROOT').'/mtask',
            'children'=>array(
                self::n_tpost(),
                self::n_tbid()
            ));
    }

    /**
     * 导航——委托管理
     * @return <array>
     */
    protected static function n_delegate($type = 1){
        if($type == 1)
            $array = array(self::n_dsend());
        else if($type == 2)
            $array = array(self::n_dsend(), self::n_dreceive());
        return array('id'=>1004,'title'=>'委托管理','icon'=>'icon.png','url'=>C('WEB_ROOT').'/mdelegate','children'=>$array);
    }

    /**
     * 导航——消息管理
     * @return <array>
     */
    protected static function n_message(){
        return array('id'=>1005,'title'=>'消息管理','icon'=>'icon.png','url'=>C('WEB_ROOT').'/messages',
            'children'=>array(
                self::n_allmes(),
                self::n_sysmes(),
                self::n_permes(),
                self::n_sendmes()
            ));
    }

    /**
     * 导航——我要推广
     * @return <array>
     */
    protected static function n_promote(){
        return array('id'=>1006,'title'=>'我要推广','icon'=>'icon.png','url'=>C('WEB_ROOT').'/promote','children'=>null);
    }

    /**
     * 导航——我的资源库
     * @return <array>
     */
    protected static function n_pool(){
        return array('id'=>1007,'title'=>'我的资源库','icon'=>'icon.png','url'=>C('WEB_ROOT').'/pool','children'=>null);
    }

    /**
     * 导航——基本资料
     * @return <array>
     */
    protected static function n_profile(){
        return array('id'=>10001,'title'=>'基本资料','icon'=>'icon.png','url'=>C('WEB_ROOT').'/profiles','children'=>null);
    }

    /**
     * 导航——修改密码
     * @return <array>
     */
    protected static function n_password(){
        return array('id'=>10002,'title'=>'修改密码','icon'=>'icon.png','url'=>C('WEB_ROOT').'/profiles/1','children'=>null);
    }

    /**
     * 导航——资质管理
     * @return <array>
     */
    protected static function n_label(){
        return array('id'=>10003,'title'=>'资质管理','icon'=>'icon.png','url'=>C('WEB_ROOT').'/profiles/2','children'=>null);
    }

    /**
     * 导航——信用认证
     * @return <array>
     */
    protected static function n_auth(){
        return array('id'=>10004,'title'=>'信用认证','icon'=>'icon.png','url'=>C('WEB_ROOT').'/profiles/3','children'=>null);
    }

    /**
     * 导航——账单明细
     * @return <array>
     */
    protected static function n_binfo(){
        return array('id'=>10005,'title'=>'账单明细','icon'=>'icon.png','url'=>C('WEB_ROOT').'/bill','children'=>null);
    }

    /**
     * 导航——账户充值
     * @return <array>
     */
    protected static function n_recharge(){
        return array('id'=>10006,'title'=>'账户充值','icon'=>'icon.png','url'=>C('WEB_ROOT').'/bill/1','children'=>null);
    }

    /**
     * 导航——我发布的任务
     * @return <array>
     */
    protected static function n_tpost(){
        return array('id'=>10007,'title'=>'我发布的任务','icon'=>'icon.png','url'=>C('WEB_ROOT').'/mtask','children'=>null);
    }

    /**
     * 导航——我竞标的任务
     * @return <array>
     */
    protected static function n_tbid(){
        return array('id'=>10008,'title'=>'我竞标的任务','icon'=>'icon.png','url'=>C('WEB_ROOT').'/mtask/1','children'=>null);
    }

    /**
     * 导航——我发出的委托
     * @return <array>
     */
    protected static function n_dsend(){
        return array('id'=>10009,'title'=>'我发出的委托','icon'=>'icon.png','url'=>C('WEB_ROOT').'/mdelegate','children'=>null);
    }

    /**
     * 导航——我竞标的任务
     * @return <array>
     */
    protected static function n_dreceive(){
        return array('id'=>10010,'title'=>'我收到的委托','icon'=>'icon.png','url'=>C('WEB_ROOT').'/mdelegate/1','children'=>null);
    }

    /**
     * 导航——全部消息
     * @return <array>
     */
    protected static function n_allmes(){
        return array('id'=>10011,'title'=>'全部消息','icon'=>'icon.png','url'=>C('WEB_ROOT').'/messages','children'=>null);
    }

    /**
     * 导航——系统消息
     * @return <array>
     */
    protected static function n_sysmes(){
        return array('id'=>10012,'title'=>'系统消息','icon'=>'icon.png','url'=>C('WEB_ROOT').'/messages/1','children'=>null);
    }

    /**
     * 导航——私人消息
     * @return <array>
     */
    protected static function n_permes(){
        return array('id'=>10013,'title'=>'私人消息','icon'=>'icon.png','url'=>C('WEB_ROOT').'/messages/2','children'=>null);
    }

    /**
     * 导航——已发送
     * @return <array>
     */
    protected static function n_sendmes(){
        return array('id'=>10014,'title'=>'已发送','icon'=>'icon.png','url'=>C('WEB_ROOT').'/messages/3','children'=>null);
    }
}
?>
