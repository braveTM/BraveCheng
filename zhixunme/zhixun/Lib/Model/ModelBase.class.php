<?php
/**
 * Description of ModelBase
 *
 * @author moi
 */
class ModelBase {
    /**
     * 获取指定属性值
     * @param <string> $name 属性名
     * @return <mixed>
     */
    public function __get($name){
        return $this->$name;
    }

    /**
     * 指定属性赋值
     * @param <string> $name  属性名
     * @param <mixed>  $value 属性值
     */
    public function __set($name, $value){
        if(property_exists($this,$name))
            $this->$name = $value;
    }
}
?>
