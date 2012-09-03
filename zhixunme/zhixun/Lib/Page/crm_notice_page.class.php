<?php

/**
 * crm_notice_page 提醒前端提供page层
 *
 * @author brave
 */
class crm_notice_page {

    /**
     * 经纪人提醒设置初始化
     * @param int $uid 经纪人id
     * @return obj
     */
    public static function notice_user_init($uid) {
        $data = ObjectPool::getObj('NoticeCrmService')->get_notice_user_setting_by_id($uid);
        return FactoryVMap::list_to_models($data, 'crm_notice');
    }

}

?>
