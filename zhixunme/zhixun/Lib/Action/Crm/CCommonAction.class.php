<?php
/**
 * CRemindAction
 * @note 从左到右：匿名用户、个人用户、企业用户、经纪人用户、分包商用户；0代表没有权限，1代表有权限
 * @author YoyiorLee
 * @date 2012-04-06
 */
class CCommonAction extends BaseAction {

    /**
     * 获取地区 00010
     */
    public function get_district() {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $level = isset($_POST['level']) ? $_POST['level'] : 1;
        $result = crm_index_page::get_district($id, $level); //获取地区
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 添加人才状态 00010
     */
    public function do_add_human_status() {
        if (!$this->is_legal_request())
            return;
        $cate_id = isset($_POST['cate_id']) ? $_POST['cate_id'] : 0;
        $pro_id = isset($_POST['pro_id']) ? $_POST['pro_id'] : 0;
        $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
        $human_id = isset($_POST['human_id']) ? $_POST['human_id'] : 0;
        $service = new StatusCrmService();
        $result = $service->addStatusByHuman($cate_id, $pro_id, $notes, $human_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 添加企业状态 00010
     */
    public function do_add_enter_status() {
        if (!$this->is_legal_request())
            return;
        $cate_id = isset($_POST['cate_id']) ? $_POST['cate_id'] : 0;
        $pro_id = isset($_POST['pro_id']) ? $_POST['pro_id'] : 0;
        $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
        $enter_id = isset($_POST['enter_id']) ? $_POST['enter_id'] : 0;
        $service = new StatusCrmService();
        $result = $service->addStatusByEnter($cate_id, $pro_id, $notes, $enter_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 更新人才状态 00010
     */
    public function do_update_human_status() {
        if (!$this->is_legal_request())
            return;
        $status_id = isset($_POST['status_id']) ? $_POST['status_id'] : 0;
        $cate_id = isset($_POST['cate_id']) ? $_POST['cate_id'] : 0;
        $pro_id = isset($_POST['pro_id']) ? $_POST['pro_id'] : 0;
        $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
        $human_id = isset($_POST['human_id']) ? $_POST['human_id'] : 0;
        $service = new StatusCrmService();
        $result = $service->updateStatusByHuman($status_id, $cate_id, $pro_id, $notes, $human_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }
    
    /**
     * 更新企业状态 00010
     */
    public function do_update_enter_status() {
        if (!$this->is_legal_request())
            return;
        $status_id = isset($_POST['status_id']) ? $_POST['status_id'] : 0;
        $cate_id = isset($_POST['cate_id']) ? $_POST['cate_id'] : 0;
        $pro_id = isset($_POST['pro_id']) ? $_POST['pro_id'] : 0;
        $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
        $enter_id = isset($_POST['enter_id']) ? $_POST['enter_id'] : 0;
        $service = new StatusCrmService();
        $result = $service->updateStatusByEnter($status_id, $cate_id, $pro_id, $notes, $enter_id);
        if (empty($result)) {
            echo jsonp_encode(false);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 删除状态 00010
     */
    public function do_delete_status() {
        if (!$this->is_legal_request())
            return;
        $status_id = isset($_POST['status_id']) ? $_POST['status_id'] : 0;
        $service = new StatusCrmService();
        $result = $service->delStatus($status_id);
        if (empty($result)) {
            echo jsonp_encode(false, $result);
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 添加人才/企业附件 00010
     */
    public function do_add_attachment() {
        if (!$this->is_legal_request())
            return;
        $data = array(
            'att_name' => isset($_POST['att_name']) ? $_POST['att_name'] : '',
            'att_type_id' => isset($_POST['att_type_id']) ? $_POST['att_type_id'] : 0,
            'att_path' => isset($_POST['att_type_id']) ? $_POST['att_type_id'] : 0,
            'att_property' => isset($_POST['att_property']) ? $_POST['att_property'] : 0
        );
        $human = empty($_POST['human']) ? FALSE:$_POST['human'];
        $bind  = array();
        if(empty($human)){
            $bind = array(
                'human_id' => isset($_POST['human_id']) ? $_POST['human_id'] : 0
            );
        }else{
            $bind = array(
                'enter_id' => isset($_POST['enter_id']) ? $_POST['enter_id'] : 0
            );
        }
        $service = new AttachmentCrmService();
        $result = $service->addAttachment($data, $bind);
        if (empty($result)) {
            echo jsonp_encode(false, $result);
        } else {
            echo jsonp_encode(true, $result);
        }
    }

    /**
     * 更新人才/企业附件 00010
     */
    public function do_update_attachment() {
        if (!$this->is_legal_request())
            return;
        $bind = array(
            'enter_id' => isset($_POST['enter_id']) ? $_POST['enter_id'] : 0,
            'att_bind_id' => isset($_POST['att_bind_id']) ? $_POST['att_bind_id'] : 0
        );
        $data = array(
            'att_name' => isset($_POST['att_name']) ? $_POST['att_name'] : '',
            'att_type_id' => isset($_POST['att_type_id']) ? $_POST['att_type_id'] : 0,
            'att_path' => isset($_POST['att_type_id']) ? $_POST['att_type_id'] : 0,
            'att_property' => isset($_POST['att_property']) ? $_POST['att_property'] : 0
        );
        $service = new AttachmentCrmService();
        $result = $service->addAttachment($data, $bind);
        if (empty($result)) {
            echo jsonp_encode(false, $result);
        } else {
            echo jsonp_encode(true);
        }
    }

    /**
     * 删除人才/企业附件 00010
     */
    public function do_delete_attachment() {
        if (!$this->is_legal_request())
            return;
        $att_id = isset($_POST['att_id']) ? $_POST['att_id'] : 0;
        $service = new AttachmentCrmService();
        $result = $service->delete($att_id);
        $att_bind_id = isset($_POST['att_bind_id']) ? $_POST['att_bind_id'] : 0;
        $service = new AttachmentCrmService();
        $result = $service->delete($att_bind_id);
        if (empty($result)) {
            echo jsonp_encode(false, $result);
        } else {
            echo jsonp_encode(true);
        }
    }
}
?>
