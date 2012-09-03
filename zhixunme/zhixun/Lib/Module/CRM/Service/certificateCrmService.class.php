<?php

/**
 * Description of certificateCrmService
 *
 * @author brave
 */
class certificateCrmService {

    public $obj = null;

    public function __construct() {
        $this->obj = new certificateCrmProvider();
    }

    /**
     * 添加一条数据资质证书
     * @param array $insert 需要插入的证书信息
     * @return mixed 成功返回id否则返回错误
     */
    public function add_certificate_copy($insert = array()) {
        $result = argumentValidate($this->obj->certArgRule, $insert);
        if (is_zerror($result))
            $result->get_message();
        return $this->obj->add($result);
    }

    /**
     * 获取经纪人的资质证书
     * @param int $broker 经纪人id
     * @return array 证书信息
     */
    public function get_broker_certificate_copy($user_id) {
        $list = $this->obj->get($user_id);
        foreach ($list as $value) {
            $array[$value['id']] = $value['certificate_copy_name'];
        }
        return $array;
    }

    /**
     * 删除一条资质证书
     * @param int $id 记录id
     * @return mixed 成功返回true
     */
    public function delete_broker_certificate_copy($id) {
        if ($this->obj->isExist($id)) {
            return $this->obj->delete($id);
        }
    }

}

?>
