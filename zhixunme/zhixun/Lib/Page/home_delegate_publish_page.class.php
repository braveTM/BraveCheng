<?php
/**
 * 委托发布页面数据提供
 * @author YoyiorLee
 */
class home_delegate_publish_page { 
    /**
     * 委托任务分类数据
     * @return <bool>
     */
    public static function get_class(){
        $service = new DelegateService();
        $data = $service->get_types(0);         //获取一级分类
        foreach ($data as $key => $value) {
            //获取二级分类作为指定一级分类的CHILDREN
            $data[$key]['children'] = FactoryVMap::list_to_models($service->get_types($value['class_id']), 'home_index_tclass');
        }
        $data    = FactoryVMap::list_to_models($data, 'home_index_tclass');
        return $data;
    }
    
    /**
     * 获取经纪人
     * @return <bool>
     */
    public static function get_broker($keywords=null){
        $service = new ProfileService();
        $broker = $service->get_resource_profile_list(null, C('ROLE_AGENT'), '0000', null, null, 0, 10, $keywords, null);
        $data = FactoryVMap::list_to_models($broker, 'home_lib_resource');
        return $data;
    }

    /**
     * 获取委托详细数据
     * @param  <int> $id 委托编号
     * @return <type> 
     */
    public static function get_detail($id){
        $service = new DelegateService();
        $info    = $service->get_delegate($id);
        if(empty($info))
            return null;
        $user_id = AccountInfo::get_user_id();
        if($user_id != $info['user_id'] && $user_id != $info['delegate_id'])
            return null;            //无权访问
        if($user_id == $info['delegate_id'] && $info['status'] == 2)
            $info['_show_reply'] = 1;
        else {
            $info['_show_reply'] = 0;
        }
        $prosvc = new ProfileService();
        $user   = $prosvc->get_profile_by_user_id($info['user_id']);
        $info['_uphoto']  = $user['photo'];
        $dele   = $prosvc->get_profile_by_user_id($info['delegate_id']);
        $info['_ruphoto'] = $dele['photo'];
        return FactoryVMap::array_to_model($info, 'home_delegate_detail');
    }
}
?>
