<?php

/**
 * 后台我的资源库管理页面数据提供
 * @author zhiguo
 */

class home_pool_admin_page {

    /**
     * 获取个人资源库列表
     * @param <int> $user_id 用户编号
     * @param <int> $type 资源类型（1为人才，2为企业）
     * @param <string> $like 模糊查询关键字
     * @param <int> $page 第几页
     * @param <int> $size 每页条数
     * @return <mixed> 对象数组
     */
    public static function get_pool_list($user_id,$type,$like,$page,$order) {
        $service =new PoolService();
        $data    = $service->get_pool_list($user_id, $type, $like, $page, C('SIZE_POOL_ADMIN'), $order);
        $data    = FactoryVMap::list_to_models($data, 'home_pool');
        return $data;
    }

    /**
     *获取个人资源库总条数
     * @param <type> $user_id 用户编号
     * @param <type> $type 资源类型（1为人才，2为企业）
     * @param <type> $like 模糊查询关键字
     * @return <int> 
     */
    public static function get_pool_total_count($user_id,$type,$like){
        $service =new PoolService();
        $data=$service->get_pool_total_count($user_id, $type, $like);
        return $data;
    }
}
?>
