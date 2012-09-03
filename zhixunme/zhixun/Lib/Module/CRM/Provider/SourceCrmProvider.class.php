<?php

/**
 * 来源信息表
 *
 * @author Administrator
 */
class SourceCrmProvider extends BaseProvider {

    public function getSource() {
        $this->da->setModelName('crm_source');
        return $this->da->select();
    }

}

?>
