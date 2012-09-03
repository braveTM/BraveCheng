<?php

/**
 * Description of AttachmentCrmService
 * 
 * @author YoyiorLee & brave
 */
class AttachmentCrmService {

    //------------private------------
    private $provider = null;

    //------------public-------------
    /**
     * 构造函数 
     */
    public function __construct() {
        $this->provider = new AttachmentCrmProvider();
    }

    /**
     * 添加一条附件信息
     * @param array $data 附件字段数组
     * @return mixed 返回附件id或者错误信息 
     */
    public function addAttachment($data) {
        if (!is_array($data)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $data = argumentValidate(AttachmentCrmProvider::$attchmentArgRule, $data);
        if (is_zerror($data))
            return $data;
        $att_id = $this->provider->addAttachment($data);
        return $att_id ? $att_id : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 更新
     * @param int $att_id 附件ID
     * @param array $data 附件信息
     * @return boolean 是否更新成功（true成功，false失败）
     */
    public function update($att_id, $data) {
        return $this->provider->update($att_id, $data);
    }

    /**
     * 删除附件
     * @param type $att_id 
     * @param type $data
     * @return type 
     */
    public function delete($att_id, $data) {
        return $this->provider->deleteAttachment($att_id, $data);
    }

    /**
     * 获取附件类型列表
     * @return array 
     */
    public function getAttachmentType() {
        return $this->provider->getAttachmentType();
    }

}

?>
