<?php
/**
 * Description of RemindService
 *
 * @author moi
 */
class RemindService {
    /**
     * 初始化提醒
     */
    public function init_remind($user_id){
//        //使用缓存
//        $cache_key = CC('USER_REMIND').$id;
//        $remind = DataCache::get($cache_key);
//        if($remind === false){
//            DataCache::set($cache_key, array(), CC('CACHE_TIME_LONG'));
//        }
        //使用数据库
        $provider = new RemindProvider();
        $remind = $provider->get($user_id);
        if(empty($remind)){
            $remind = '';
            $provider->add($user_id, '');
        }
        else{
            $remind = unserialize($remind['remind']);
        }
        foreach ($remind as $key => $value) {
            if($value > 0)
                $data[$key] = $value;
        }
        $service = new MessageService();
        $unread = $service->assembly_unread($user_id);
        foreach($unread as $key => $value){
            $data[$key] = $value;
        }
//        if(!empty($data)){
//            $provider->update($user_id, '');
//        }
        return $data;
    }

    /**
     * 获取提醒数据
     * @param <int> $id
     */
    public function get_remind($id){
        //使用缓存
        $cache_key = CC('USER_REMIND').$id;
        $remind = DataCache::get($cache_key);
        if($remind === false){
            DataCache::set($cache_key, array(), CC('CACHE_TIME_LONG'));
        }
//        //使用数据库
//        $provider = new LongConnectProvider();
//        $remind = $provider->get_user_remind($id);
//        if(empty($remind))
//            return null;
//        $remind = unserialize($remind['remind']);
        foreach($remind as $key => $item){
            if($item > 0){
                $data[$key] = $item;
            }
        }
        return $data;
    }

    /**
     * 检测客户端是否存在
     * @param <string> $id
     * @return <bool>
     */
    public function exists_remind_client($id){
        return DataCache::get(CC('USER_LONG_CONN').$id) != false;
    }

    /**
     * 清除提醒数据
     * @param <int> $id
     */
    public function clear_remind($id, $user_id){
        DataCache::remove(CC('USER_REMIND').$id);
        $provider = new RemindProvider();
        $provider->update($user_id, '');
    }

    /**
     * 生成会话记录
     * @param  <string> $key
     * @param  <int>    $user_id
     * @param  <string> $session_id
     * @return <bool>
     */
    public function generate_session($key, $user_id, $session_id){
        $provider = new LongConnectProvider();
        $this->clear_remind_client($session_id);
        if(!$provider->add($key, $user_id, $session_id)){
            return E();
        }
        else{
            DataCache::set(CC('USER_REMIND').$key, array(), CC('CACHE_TIME_LONG'));
            DataCache::set(CC('USER_LONG_CONN').$key, 1, CC('CACHE_TIME_NORMAL'));
            return true;
        }
    }

    /**
     * 清除提醒客户端
     * @param <string> $session_id
     */
    public function clear_remind_client($session_id){
        $provider = new LongConnectProvider();
        $record = $provider->get_by_session_id($session_id);
        if(!empty($record)){
            DataCache::remove(CC('USER_LONG_CONN').$record['id']);
            $provider->delete_by_session_id($session_id);
        }
    }

    /**
     * 通知
     * @param <string> $type
     * @param <int> $user_id
     */
    public function notify($type, $user_id){
        require_cache(APP_PATH.'/Lib/Module/Remind/Subject.class.php');
//        $provider = new LongConnectProvider();
//        //使用缓存
//        $result = $provider->get_user_record($user_id);
//        $service = new UserService();
//        if(empty($result) || !$service->check_user_online($user_id)){
//            $this->save_last_remind($type, $user_id);
//            return;
//        }
//        $subject = new Subject($type);
//        foreach($result as $item){
//            $subject->attach(new Observer($item['id']));
//        }
        //使用数据库
        $subject = new Subject($type);
        $subject->attach(new Observer($user_id));
        $subject->notify();
    }

    /**
     * 保存持久的提醒数据
     * @param <type> $type
     * @param <type> $user_id
     */
    public function save_last_remind($type, $user_id){
        $pro = new RemindProvider();
        $remind = $pro->get($user_id);
        $remind = unserialize($remind['remind']);
        if(!empty($remind) && array_key_exists($type, $remind)){
            $remind[$type] += 1;
        }
        else{
            $remind[$type] = 1;
        }
        $this->update_remind($user_id, serialize($remind));
    }

    /**
     * 更新用户提醒记录
     * @param  <int>    $user_id 用户编号
     * @param  <string> $remind  提醒
     * @return <bool> 是否成功
     */
    public function update_remind($user_id, $remind){
        $provider = new RemindProvider();
        if(!$provider->update($user_id, $remind)){
            return E();
        }
        return true;
    }

    /**
     * 更新会话提醒记录
     * @param  <int>    $user_id 用户编号
     * @param  <string> $remind  提醒
     * @return <bool> 是否成功
     */
    public function update_record_remind($id, $remind){
        $provider = new LongConnectProvider();
        if(!$provider->update_user_remind($id, $remind)){
            return E();
        }
        return true;
    }

    /**
     * 清除特殊提醒数据
     * @param int $user_id 用户编号
     * @param mixed $type 提醒类型
     */
    public function clear_sp_remind($user_id, $type){
        //使用数据库
        $provider = new RemindProvider();
        $remind = $provider->get($user_id);
        $remind = unserialize($remind['remind']);
        if(is_array($type)){
            foreach($type as $item)
                unset($remind[$item]);
        }
        else if(is_string($type)){
            unset($remind[$type]);
        }
        $provider->update($user_id, serialize($remind));
    }
}
?>
