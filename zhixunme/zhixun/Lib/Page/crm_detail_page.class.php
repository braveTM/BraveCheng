<?php

/**
 * 人才详情页
 * @author YoyiorLee
 */
class crm_detail_page {

    //---------------------------公用---------------------------
    public static function get_source() {
        $service = new SourceCrmService();
        $data = $service->getSource();
        return FactoryVMap::list_to_models($data, 'crm_index_source');
    }

    //---------------------------人才---------------------------
    /**
     * 获取人才详情
     * @param int $human_id 人才ID
     * @return mixed 结果集
     */
    public static function get_human($human_id, $user_id) {
        $service = new HumanCrmService();
        $data = $service->get_human($human_id, $user_id);
        return FactoryVMap::array_to_model($data, 'crm_human_detail');
    }

    //---------------------------企业---------------------------
    /**
     * 获取企业详情 
     * @param type $company_id 企业ID
     * @return mixed 结果集
     */
    public static function get_company($company_id, $user_id) {
        $service = new CompanyCrmService();
        $data = $service->get_row_company($company_id, $user_id);
        return FactoryVMap::array_to_model($data, 'crm_company_detail');
    }

}

?>
