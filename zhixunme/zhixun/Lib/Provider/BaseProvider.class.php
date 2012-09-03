<?php

/**
 * Description of BaseProvider
 *
 * @author moi
 */
class BaseProvider {

    /**
     * 数据访问
     * @var <Model>
     */
    protected $da;

    public function __construct($name = null) {
        $this->da = M($name);
    }

    /**
     * 开启事务
     */
    public function trans() {
        $this->da->startTrans();
    }

    /**
     * 回滚事务
     */
    public function rollback() {
        $this->da->rollback();
    }

    /**
     * 提交事务
     */
    public function commit($force = false) {
        $this->da->commit($force);
    }

    /**
     * 当前是否处于事务中
     */
    public function is_transed() {
        return $this->da->get_trans_time() > 0;
    }

}

?>
