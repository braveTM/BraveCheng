<?php

/**
 * 人才列表页
 * @author YoyiorLee
 */
class crm_index_page {

    //===========================公用===========================
    /**
     * 获取阶段
     */
    public static function get_category() {
        $service = new StatusCrmService();
        $data = $service->getCategory();
        return FactoryVMap::list_to_models($data, 'crm_index_category');
    }

    /**
     * 获取进度
     */
    public static function get_progress($cate_id) {
        $service = new StatusCrmService();
        $data = $service->getProgress($cate_id);
        return FactoryVMap::list_to_models($data, 'crm_index_progress');
    }

    /**
     * 获取地区
     */
    public static function get_district($id, $level) {
        $service = new DistrictCrmService();
        $data = $service->get_sub_district($id, $level);
        return FactoryVMap::list_to_models($data, 'crm_index_district');
    }

    /**
     * 获取来源
     */
    public static function get_source() {
        $service = new SourceCrmService();
        $data = $service->getSource();
        return FactoryVMap::list_to_models($data, 'crm_index_source');
    }

    /**
     * 获取证书
     */
    public static function get_certificates() {
        $service = new AptitudeCrmService();
        $data = $service->getCertificate();
        return FactoryVMap::list_to_models($data, 'crm_index_certificate');
    }

    /**
     * 获取专业
     */
    public static function get_industries($cert_id, $aptid = FALSE) {
        $service = new AptitudeCrmService();
        if (!$aptid) {
            $data = $service->getIndustryByCertid($cert_id);
            return FactoryVMap::list_to_models($data, 'crm_index_industry');
        }
        return $service->getAptId($cert_id, 0);
    }

    //==============================人才================================== 
    /**
     * 获取人才列表（默认）
     */
    public static function get_human_default($page, $size, $user_id) {
        $service = new HumanCrmService();
        $data = $service->get_humans($page, $size, $user_id);
        return FactoryVMap::list_to_models($data, 'crm_human_list');
    }

    /**
     * 筛选人才列表
     */
    public static function get_humans_by_filter($user_id, $is_fulltime, $sour_id, $province_id, $cate_id, $pro_id, $page, $size, $count = FALSE) {
        $service = new HumanCrmService();
        $data = $service->get_humans_by_filter($user_id, $is_fulltime, $sour_id, $province_id, $cate_id, $pro_id, $page, $size, $count);
        return FactoryVMap::list_to_models($data, 'crm_human_list');
    }

    /**
     * 人才资源条件筛选
     * @param array $filter 条件数组
     * @param int $page 页数
     * @param int $size 每页大小
     * @param string $table 需要查询的表名
     * @param string $prefix 表的别名
     * @return array   返回条件数组
     */
    public static function get_humans_filter($filter, $page, $size, $table, $prefix, $order) {
        if (is_array($filter)) {
            $data = ApiCrmService::humanWhereData($filter, $page, $size, $table, $prefix, $order);
            return FactoryVMap::list_to_models($data, 'crm_human_filter');
        }
    }

    /**
     * 获取人才列表从条数
     */
    public function get_humans_count($user_id) {
        $service = new HumanCrmService();
        return $service->get_humans_count($user_id);
    }

    /**
     * 获取职称类型
     */
    public static function get_title_types() {
        $service = new HumanCrmService();
        $data = $service->getTitlesType();
        return FactoryVMap::list_to_models($data, 'crm_index_title_type');
    }

    /**
     * 根据职称类型获取职称
     */
    public static function get_titles($t_id) {
        $service = new HumanCrmService();
        $data = $service->getTitlesByTid($t_id);
        return FactoryVMap::list_to_models($data, 'crm_index_title');
    }

    //==============================企业==================================

    /**
     * 获取企业列表（默认）
     */
    public static function get_companys($page, $size, $user_id) {
        $service = new CompanyCrmService();
        $data = $service->get_all_company($page, $size, $user_id);
        return FactoryVMap::list_to_models($data, 'crm_company_list');
    }

    /**
     * 获取企业列表
     */
    public static function get_companys_by_filter($is_fulltime, $sour_id, $province_id, $cate_id, $pro_id, $page, $size, $count = FALSE) {
        $service = new HumanCrmService();
        $data = $service->get_humans_by_filter($is_fulltime, $sour_id, $province_id, $cate_id, $pro_id, $page, $size, $count);
        return FactoryVMap::list_to_models($data, 'crm_company_list');
    }

    /**
     * 人才资源条件筛选
     * @param array $filter 条件数组
     * @param int $page 页数
     * @param int $size 每页大小
     * @param string $table 需要查询的表名
     * @param string $prefix 表的别名
     * @return array   返回条件数组
     */
    public static function get_company_filter($filter, $page, $size, $table, $prefix, $order) {
        if (is_array($filter)) {
            $data = ApiCrmService::companyWhereData($filter, $page, $size, $table, $prefix, $order);
            return FactoryVMap::list_to_models($data, 'crm_company_filter');
        }
    }

    /**
     * 获取企业列表从条数
     */
    public static function get_companys_count($user_id) {
        $service = new CompanyCrmService();
        return $service->getCount($user_id);
    }

    /**
     * 获取企业性质
     */
    public static function get_natures() {
        $service = new CompanyCrmService();
        $data = $service->getNature();
        return FactoryVMap::list_to_models($data, 'crm_natures');
    }

}

?>
