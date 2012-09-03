<?php
/**
 * Description of home_human_certificate_page
 *
 * @author moi
 */
class home_human_certificate_page {
    /**
     * 获取拥有的注册证书列表
     * @return <type>
     */
    public static function get_register_certs(){
        $service = new CertificateService();
        $list = $service->getRegisterCertificateListByHuman(AccountInfo::get_data_id());
        return FactoryVMap::list_to_models($list, 'home_hcert_register');
    }
    
    /**
     * 获取拥有的职称证书
     * @return <type>
     */
    public static function get_grade_cert(){
        $service = new CertificateService();
        $list = $service->getGradeCertificateListByHuman(AccountInfo::get_data_id());
        return FactoryVMap::array_to_model($list[0], 'home_hcert_grade');
    }
}
?>
