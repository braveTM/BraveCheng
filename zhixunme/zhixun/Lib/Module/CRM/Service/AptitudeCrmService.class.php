<?php

/**
 * Description of AptitudeCrmService
 *
 * @author YoyiorLee & brave
 */
class AptitudeCrmService {

    /**
     * 获取证书列表
     * @return type 
     */
    public function getCertificate() {
        $aptObj = new AptitudeCrmProvider();
        /*
          $row = array();
          $rows = $this->aptitudeObj->getCertificate();
          foreach ($rows as $value) {
          $row[$value['cert_id']] = $value['cert_name'];
          }
          return $row;
         */
        return $aptObj->getCertificate();
    }

    /**
     * 获取行业列表
     * @return type 
     */
    public function getIndustry() {
        $aptObj = new AptitudeCrmProvider();
        /*
          $row = array();
          $rows = $this->aptitudeObj->getIndustry();
          foreach ($rows as $value) {
          $row[$value['in_id']] = $value['in_name'];
          }
          return $row;
         */
        return $aptObj->getIndustry();
    }

    /**
     * 获取指定证书id的行业列表
     * @param type $cert_id
     * @return type 
     */
    public function getIndustryByCertid($cert_id) {
        $aptObj = new AptitudeCrmProvider();
        $relationObj = new RelationCrmProvider();
        $rows = $relationObj->getRelationByCert($cert_id);
        foreach ($rows as $key => $value) {
            $rows[$key]['indstry'] = $aptObj->getIndustryByInid($value['in_id']);
        }
        return $rows;
    }

    /**
     * 获取指定证书id与行业id对应的关系apt_id
     * @param int $cert_id 证书id
     * @param int $in_id 行业id
     * @return string 返回关系id 
     */
    public function getAptId($cert_id, $in_id) {
        if (!var_validation($cert_id, VAR_ID) || !var_validation($cert_id, VAR_ID)) {
            return;
        }
        $relationObj = new RelationCrmProvider();
        if (!$relationObj->isExist('cert_id', $cert_id, 'crm_certificate') || !$relationObj->isExist('in_id', $in_id, 'crm_aptitude')) {
            return E(ErrorMessage::$RECORD_NOT_EXISTS);
        }
        return $relationObj->getApt_id($cert_id, $in_id);
    }

}

?>
