<?php
/**
 * Description of home_index_company_page
 *
 * @author moi
 */
class home_index_company_page {
    /**
     * 获取企业墙数据
     */
    public static function get_company_wall(){
        $service = new PromoteService();
        $record = $service->get_area_promote_records(C('COMPANY_WALL'));
        $usvc = new UserService();
        $csvc = new CompanyService();
        $tsvc = new TaskService();
        $jsvc = new JobService();
        for($i = 0; $i < C('COMPANY_WALL_COUNT'); $i++){
            $data[] = array('sort' => $i + 1, 'user_id' => 0);
        }
        foreach($record as $key => $item){
            $user = $usvc->get_user($item['user_id']);
            $company = $csvc->get_company($user['data_id']);
            $item['_name'] = $company['company_name'];
            $item['_task'] = $tsvc->get_task_list(null, null, null, null, null, 1, 1, null, true, null, $item['user_id']);
            $item['_job'] = $jsvc->get_pub_jobs($item['user_id'], null, null, 1, 1, true);
            $data[$item['sort'] - 1] = $item;
        }
        return FactoryVMap::list_to_models($data, 'home_index_company');
    }
}
?>
