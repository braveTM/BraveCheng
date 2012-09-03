<?php
/**
 * liDescription of FactoryDMap
 *
 * @author moi
 */
class FactoryDMap {
    /**
     * 字段数组转化为相应的模型
     * @param  <array>  $array
     * @param  <string> $type
     * @return <mixed>
     */
    public static function array_to_model($array, $type){
        if(empty ($array))
            return null;
        $method = 'array_to_'.strtolower($type).'_model';
        return DomainModelMap::$method($array);
    }

    /**
     * 将模型属性转化为数组
     * @param <type> $model
     * @param <type> $type
     * @return <array>
     */
    public static function model_to_array($model, $type){
        if(empty ($model))
            return array();
        $method = strtolower($type).'_model_to_array';
        return DomainModelMap::$method($model);
    }
}
?>
