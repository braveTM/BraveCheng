<?php

/**
 * Description of FactoryVMap
 *
 * @author moi
 */
class FactoryVMap {

    /**
     * 列表转化为模型数组
     * @param <type> $list
     * @param <type> $type
     * @return <type> 
     */
    public static function list_to_models($list, $type) {
        if (empty($list))
            return null;
        $models = array();
        $method = 'array_to_' . strtolower($type) . '_model';
        $privacyService=new PrivacyService();
        foreach ($list as $key => $value) {        
            $privacyService->replace($type,$value);
            $models[$key] = ViewModelMap::$method($value);
        }
        return $models;
    }

    /**
     * 字段数组转化为相应的模型
     * @param  <array>  $array
     * @param  <string> $type
     * @return <mixed>
     */
    public static function array_to_model($array, $type) {
        if (empty($array))
            return null;
        $privacyService=new PrivacyService();
        $privacyService->replace($type, $array);
        $method = 'array_to_' . strtolower($type) . '_model';
        return ViewModelMap::$method($array);
    }

    /**
     * 模型对象列表转化为数组
     * @param <mixed> $model
     * @return <array>
     */
    public static function models_to_array($models) {
        if (empty($models))
            return null;
        $array = array();
        foreach ($models as $model) {
            $array[] = ViewModelMap::model_to_array($model);
        }
        return $array;
    }

    /**
     * 模型对象转化为数组
     * @param <mixed> $model
     * @return <array>
     */
    public static function model_to_array($model) {
        return ViewModelMap::model_to_array($model);
    }

}

?>
