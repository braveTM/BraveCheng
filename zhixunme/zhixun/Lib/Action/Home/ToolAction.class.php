<?php
/**
 * Module:020
 */
class ToolAction extends BaseAction{
    /**
     * 合同下载页面01111
     */
    public function contract(){
//        $service=new JobService();
//        $service->importJobIndex();
        $this->display();
    }
    
    /**
     * 市场行情页面00000
     */
    public function market(){	
        $this->assign('province', home_common_front_page::get_area_list());
        $this->display();
    }
    
    /**
     * 资讯查询页面11111
     */
    public function refer(){
        $this->assign('login', AccessControl::is_logined() ? 1 : 0);
        $this->display();
    }
    
    /**
     * 受理发证信息查询页面11111
     */
    public function arefer(){
        $this->assign('login', AccessControl::is_logined() ? 1 : 0);
        $this->display();
    }
    
    /**
     * 人员资格页面11111
     */
    public function prefer(){
        $this->assign('login', AccessControl::is_logined() ? 1 : 0);
        $this->display();
    }
    
    /**
     * 通讯录页面11111 
     */
    public function contactbook(){
        $this->assign('login', AccessControl::is_logined() ? 1 : 0);
        $this->display();
    }
    
    /**
     * 人事部通讯录页面11111 
     */
    public function pdmail(){
        $this->assign('login', AccessControl::is_logined() ? 1 : 0);
        $this->display();
    }
    
    /**
     * 合同下载01111
     */
    public function contract_download(){
        $fid = intval($_GET['id']);
        $path = 'Files/system/contract/';
        switch ($fid){
            case  1 : $file = 'gjrc.doc'; $name = '高级人才聘用（兼职）协议.doc';
                break;
//            case  2 : $file = 'wtht.doc'; $name = '委托合同.doc';
//                break;
//            case  3 : $file = 'bgwt.doc'; $name = '变更委托合同内容.doc';
//                break;
//            case  4 : $file = 'xqwt.doc'; $name = '续签委托合同.doc';
//                break;
//            case  5 : $file = 'tjqr.doc'; $name = '推荐确认函.doc';
//                break;
            case  6 : $file = 'jpzm.doc'; $name = '解聘证明.doc';
                break;
            case  7 : $file = 'zydd.doc'; $name = '职业道德证明.doc';
                break;
            case  8 : $file = 'zgcn.doc'; $name = '在岗承诺书.doc';
                break;
//            case  9 : $file = 'jzsx.doc'; $name = '建造师信息调错退回申请证明.doc';
//                break;
//            case 10 : $file = 'qt.doc'; $name = '欠条.doc';
//                break;
//            case 11 : $file = 'yczf.doc'; $name = '延迟支付确认书.doc';
//                break;
            default : echo 'File not found';
                exit();
        }
        require_cache(APP_PATH.'/Common/Function/util.php');
        download_file($path.$file, $name);
    }

    /**
     * 获取年度行情01111 
     */
    public function get_year_market(){
        if(!$this->is_legal_request())
            return;
        $data = home_tool_market_page::get_year_market($_POST['cid'], $_POST['pid'], $_POST['year']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }
    
    /**
     * 获取年度市场行情对比01111
     */
    public function get_year_market_compare(){
        if(!$this->is_legal_request())
            return;
        $data = home_tool_market_page::get_year_market_compare($_POST['cid'], $_POST['pid']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }

    /**
     * 获取当月行情01111 
     */
    public function get_market_current(){
        if(!$this->is_legal_request())
            return;
        $data = home_tool_market_page::get_market_list($_POST['pid'], $_POST['like'], $_POST['page'], $_POST['size']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            $count = home_tool_market_page::get_market_count($_POST['pid'], $_POST['like']);
            echo jsonp_encode(true, $data, $count);
        }
    }
}

?>
