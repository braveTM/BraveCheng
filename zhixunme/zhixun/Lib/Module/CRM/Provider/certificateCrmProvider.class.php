<?php

/**
 * Description of certificateCrmProvider
 *
 * @author brave
 */
class certificateCrmProvider extends BaseProvider {

    public $certArgRule = array(
        'user_id' => array(
            'name' => '人才',
            'check' => VAR_ID,
            'filter' => VAR_ID,
            'null' => false
        ),
        'certificate_copy_name' => array(
            'name' => '资质证书名称',
            'null' => false
        ),
    );

    public function __construct() {
        parent::__construct('crm_certificate_copy');
    }

    /**
     * 添加一条数据资质证书
     * @param array $insert 需要插入的证书信息
     * @return mixed 成功返回id否则返回错误
     */
    public function add($insert = array()) {
        return $this->da->add($insert);
    }

    /**
     * 删除一条资质证书
     * @param int $id 记录id
     * @return mixed 成功返回true
     */
    public function delete($id) {
        $where = array(
            'id' => $id,
        );
        $data = array(
            'is_del' => 1,
        );
        return $this->da->where($where)->save($data);
    }

    /**
     * 获取经纪人的资质证书
     * @param int user_id 经纪人id
     * @return array 证书信息
     */
    public function get($user_id) {
        $where = array(
            'user_id' => $user_id,
            'is_del' => 0,
        );
        $field = array(
            'id',
            'certificate_copy_name',
        );
        return $this->da->where($where)->field($field)->select();
    }

    /**
     * 验证是否存在该记录
     * @param int $id 数据库记录id
     * @return boolean 成功返回true
     */
    public function isExist($id) {
        $where = array(
            'id' => $id,
            'is_del' => 0,
        );
        return $this->da->where($where)->count('id') > 0 ? TRUE : FALSE;
    }

}

?>
