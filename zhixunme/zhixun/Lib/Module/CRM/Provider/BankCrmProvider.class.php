<?php

/**
 * 开户行数据提供器
 * @author YoyiorLee
 */
class BankCrmProvider extends BaseProvider {
    /**
     * 表名
     * @var type 
     */

    const TABLE_NAME = 'crm_bank cb';

    /**
     * 验证规则
     * @var array 
     */
    public $bankArgRule = array(
        'bank_id' => array(
            'name' => '银行ID',
            'filter' => VAR_ID,
        ),
        'bank_name' => array(
            'name' => '开户行名称',
            'filter' => VAR_NAME,
            'length' => 64,
            'null' => false
        ),
        'bank_account' => array(
            'name' => '开户账号',
            'length' => 18,
            'null' => false
        ),
        'bank_username' => array(
            'name' => '开户名',
            'filter' => VAR_NAME,
            'null' => false
        ),
        'human_id' => array(
            'name' => '人才ID',
            'filter' => VAR_ID,
        ),
    );

    /**
     * 构造函数
     */
    public function __construct() {
        parent::__construct(self::TABLE_NAME);
    }

    /**
     * 判断银行是否存在
     * @param type $bank_id 银行ID
     * @param type $human_id  人才ID
     * @return bool 
     */
    public function is_exist($bank_id, $human_id = 0) {
        $where['bank_id'] = $bank_id;
        if (empty($human_id)) {
            $where['human_id'] = $human_id;
        }
        return $this->da->where($where)->find() > 0;
    }

    /**
     * 添加开户行
     * @param int $bank_id 银行ID
     * @param array $data 银行数据
     * @return boolean 是否成功（true成功|false失败）
     */
    public function add($data) {
        $this->da->setModelName('crm_bank');
        unset($data['bank_id']);
        $data['is_delete'] = 0;
        return $this->da->add($data);
    }

    /**
     * 更新开户行
     * @param array $data 银行数据
     * @return boolean 是否成功（true成功|false失败）
     */
    public function update($data) {
        $where['bank_id'] = $data['bank_id'];
        return $this->da->where($where)->save($data);
    }

    /**
     * 删除开户行
     * @param int $bank_id 银行ID
     * @return boolean 是否成功（true成功|false失败）
     */
    public function delete($bank_id) {
        $where['bank_id'] = $bank_id;
        $data['is_delete'] = 1;
        return $this->da->where($where)->save($data);
    }

    /**
     * 根据银行ID获取开户行
     * @param int $bank_id 银行ID
     * @return array 
     */
    public function get($bank_id) {
        $where['bank_id'] = $bank_id;
        $where['is_delete'] = 0;
        return $this->da->where($where)->find();
    }

    /**
     * 根据人才ID获取开户行
     * @param int $human_id 人才ID
     * @return array 
     */
    public function get_by_human($human_id) {
        $where['human_id'] = $human_id;
        $where['is_delete'] = 0;
        return $this->da->where($where)->select();
    }

}

?>
