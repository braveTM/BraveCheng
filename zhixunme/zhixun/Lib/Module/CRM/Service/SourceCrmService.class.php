<?php

/**
 * 来源信息组合器
 *
 * @author Administrator
 */
class SourceCrmService {

    public function getSource() {
        $sourceObj = new SourceCrmProvider();
        return $sourceObj->getSource();
    }

}

?>
