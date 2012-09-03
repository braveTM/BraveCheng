<?php

 /** Description of AttachmentCrmService
 * 
 * @author YoyiorLee & brave
 */
class AtthumanCrmService {

    //------------private------------
    private $provider = null;

    //------------public-------------
    /**
     * 构造函数 
     */
    public function __construct() {
        $this->provider = new AtthumanCrmProvider();
    }
    
    /**
     * 添加一条附件信息
     * @param array $data 附件字段数组
     * @return mixed 返回附件id或者错误信息 
     */
    public function addAtthuman($data) {
        if (!is_array($data)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $data = argumentValidate(AtthumanCrmProvider::$attchmentArgRule, $data);
        if (is_zerror($data))
            return $data;
        $att_human_id = $this->provider->addAtthuman($data);
        //return $att_human_id ? $att_human_id : E(ErrorMessage::$OPERATION_FAILED);
        return $att_human_id;
    }
    
    /**
     * 添加一条附件信息
     * @param array $data 附件字段数组
     * @return mixed 返回附件id或者错误信息 
     */
    public function deleteAtthuman($user_id,$human = TRUE) {
        if($human){
            $where['human_id'] = $user_id;
        }else{
            $where['enter_id'] = $user_id;
        }
        return $this->provider->deleteAtthuman($user_id,$where);
    }
}
?>
