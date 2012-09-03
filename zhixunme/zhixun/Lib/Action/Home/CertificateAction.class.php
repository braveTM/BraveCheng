<?php
header('content-type:text/html;charset=utf-8');
/**
 * Module:009
 */
class CertificateAction extends BaseAction{
    /**
     * 获取注册证书11111
     */
    public function get_register_cert(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $data = home_cert_index_page::get_register_cert_list();
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }

    /**
     * 获取指定注册证书的专业11111
     */
    public function get_rcert_major(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $data = home_cert_index_page::get_rcert_major_list($_POST['id']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            if(is_array($data)){
                echo jsonp_encode(true, $data);
            }
            else{
                echo jsonp_encode(true, null, null, $data);
            }
        }
    }

    /**
     * 获取职称证书分类列表11111
     */
    public function get_gcert_type(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $data = home_cert_index_page::get_gcert_type_list();
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }

    /**
     * 获取职称证书专业列表11111
     */
    public function get_grade_cert(){
        if(!$this->is_legal_request())           //是否合法请求
            return;
        $data = home_cert_index_page::get_grade_cert_list($_POST['id']);
        if(empty($data)){
            echo jsonp_encode(false);
        }
        else{
            echo jsonp_encode(true, $data);
        }
    }
}
?>
