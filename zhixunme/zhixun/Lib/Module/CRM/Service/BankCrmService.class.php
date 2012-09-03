<?php

/**
 * Description of BankCrmService
 *
 * @author YoyiorLee
 */
class BankCrmService {

    /**
     * 私有变量
     * @var Object 
     */
    private $provider = null;

    /**
     * 构造函数
     */
    public function __construct() {
        $this->provider = new BankCrmProvider();
    }

    /**
     * 判断银行是否存在
     * @param type $bank_id 银行ID
     * @param type $human_id  人才ID
     * @return bool 
     */
    public function is_exist($bank_id, $human_id) {
        return $this->provider->is_exist($bank_id, $human_id);
    }

    /**
     * 添加开户行
     * @param array $data 银行数据
     * @return boolean 是否成功（成功返回银行ID|失败返回false）
     */
    public function add($data) {
        if (!is_array($data)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $result = argumentValidate($provider->bankArgRule, $data);
        if (is_zerror($result)) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        if ($this->is_exist($data['bank_id'])) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        $bank_id = $this->provider->add($data);
        return $bank_id ? $bank_id : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 添加/修改开户行信息
     * @param array $data
     * @return boolean 
     */
    public function update($data) {
        if (!is_array($data)) {
            return E(ErrorMessage::$OPERATION_FAILED);
        }
        $result = argumentValidate($provider->bankArgRule, $data);
        if (is_zerror($result)) {
            return false;
        }
        if ($this->is_exist($data['bank_id'])) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        if (empty($data['bank_id'])) {
            $bool = $this->add($data);
        } else {
            $bool = $this->provider->update($data);
        }
        return $bool !== FALSE ? $bool : E(ErrorMessage::$OPERATION_FAILED);
    }

    /**
     * 删除开户行
     * @param int $bank_id 银行ID
     * @return boolean 是否成功（true成功|false失败）
     */
    public function delete($bank_id) {
        if (var_validation($bank_id, VAR_ID)) {
            return $this->provider->delete($bank_id);
        }
        return false;
    }

}

?>
