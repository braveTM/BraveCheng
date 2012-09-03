<?php
/**
 * Description of home_cert_index_page
 *
 * @author moi
 */
class home_cert_index_page {
    /**
     * 获取注册证书列表
     */
    public static function get_register_cert_list(){
        $service = new CertificateService();
        $result  = $service->getAllRegisterCertificateInfo();
        return FactoryVMap::list_to_models($result, 'home_cert_register');
    }

    /**
     * 获取指定注册证书的专业列表
     */
    public static function get_rcert_major_list($id, $class = 0){
        $service = new CertificateService();
        $result  = $service->getRegisterCertificateMajorList($id, $class);
        if(is_numeric($result))
            return intval($result);
        else
            return FactoryVMap::list_to_models($result, 'home_rcert_major');
    }

    public static function get_gcert_type_list(){
        $service = new CertificateService();
        $result  = $service->getAllGradeCertificateType();
        return FactoryVMap::list_to_models($result, 'home_gcert_type');
    }

    public static function get_grade_cert_list($type){
        $service = new CertificateService();
        $result  = $service->getGradeCertificateList($type);
        return FactoryVMap::list_to_models($result, 'home_grade_cert');
    }
}
?>
