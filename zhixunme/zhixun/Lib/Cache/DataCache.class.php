<?php
/**
 * Description of ProfileCache
 *
 * @author moi
 */
class DataCache {
    /**
     * 获取缓存
     * @param <string> $key 键值
     * @return <mixed> 缓存数据
     */
    public static function get($key){
        //return false;
        //return unserialize(SS(md5($key)));
        return unserialize(SS($key));
    }

    /**
     * 设置缓存
     * @param <string> $key    键值
     * @param <mixed>  $value  缓存值
     * @param <int>    $expire 缓存时间
     */
    public static function set($key, $value, $expire = 864000){
        //return;
        if($expire === -1)
            SS($key, serialize($value));
        else if($expire > 0)
            SS($key, serialize($value), $expire);
    }

    /**
     * 删除缓存
     * @param <string> $key 键值
     * @return <bool> 是否成功
     */
    public static function remove($key){
        return SS($key, null);
    }
}
?>
