<?php
/**
 * 观察者
 *
 * @author moi
 */
class Observer implements SplObserver{
    public function  __construct($id) {
        $this->id = $id;
    }

    /**
     * 更新
     */
    public function update(SplSubject $subject){
//        //使用缓存
//        $cache_key = CC('USER_REMIND').$this->id;
//        $remind = DataCache::get($cache_key);
//        if(!empty($remind) && array_key_exists($subject->get_key(), $remind)){
//            $remind[$subject->get_key()] += 1;
//        }
//        else{
//            $remind[$subject->get_key()] = 1;
//        }
//        DataCache::set($cache_key, $remind, CC('CACHE_TIME_LONG'));
        //使用数据库
        $service = new RemindService();
        $remind = $service->get_remind($this->id);
        if(!empty($remind) && array_key_exists($subject->get_key(), $remind)){
            $remind[$subject->get_key()] += 1;
        }
        else{
            $remind[$subject->get_key()] = 1;
        }
        $service->update_remind($this->id, serialize($remind));
    }
}


?>
