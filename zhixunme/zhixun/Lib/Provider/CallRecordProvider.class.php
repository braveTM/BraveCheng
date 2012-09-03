<?php
/**
 * Description of CallSetProvider
 *
 * @author wgz
 */
class CallRecordProvider extends BaseProvider {
     /**
     * 保存默认数据
     * Enter description here ...
     * @param unknown_type $data
     */
    public function addCallRecordInfo($data){
    	$this->da->setModelName('call_record');
        return $this->da->add($data);
    }
    
}