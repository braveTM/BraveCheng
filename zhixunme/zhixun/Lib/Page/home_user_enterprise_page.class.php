<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_user_enterprise_page
 *
 * @author hp
 */
class home_user_enterprise_page {
    /**
     * 获取页面信息
     * @return <mixed>
     */
    public static function get_page_info(){
        $array['name'] = AccountInfo::get_user_name();
        $array['url']  = C('WEB_ROOT').C('MEMBER_PAGE');
        return FactoryVMap::array_to_model($array, 'home_user_enterprise');
    }
}
?>
