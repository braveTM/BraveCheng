<?php
/**
 * Description of home_user_agent_page
 *
 * @author moi
 */
class home_user_agent_page {
    /**
     * 获取页面信息
     * @return <mixed>
     */
    public static function get_page_info(){
        $array['name'] = AccountInfo::get_user_name();
        $array['url']  = C('WEB_ROOT').C('MEMBER_PAGE');
        return FactoryVMap::array_to_model($array, 'home_user_agent');
    }
}
?>
