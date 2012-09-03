<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObjectPool
 *
 * @author Administrator
 */
class ObjectPool {

    //声明一个进程内资源对象池
    public static $_modelObjArr;

    public static function getObj($_appName, $_typeStr = 'class') {
        if ($_typeStr == 'class')
            $className = $_appName;
        else
            $className = $_appName . strtoupper($_typeStr);
        //资源对象已创建 直接返回使用
        if (isset(self::$_modelObjArr[$className]) && is_object(self::$_modelObjArr[$className]))
            return self::$_modelObjArr[$className];
        //加载文件资源类文件
        if (substr($_appName, -10) == "CrmService") {
            $file = (LIB_PATH . 'Module/CRM/Service/' . $_appName . '.class.php');
        } elseif (substr($_appName, -11) == "CrmProvider") {
            $file = (LIB_PATH . 'Module/CRM/Provider/' . $_appName . '.class.php');
        }
        if (file_exists($file)) {
            require_cache($file);
            if (class_exists($className)) {
                return self::_createObj($className);
            } else {
                $errStr = "no class {$className} in file {$file}"; //类名错误
            }
        } else {
            $errStr = "no class file {$file}"; //类文件错误
        }
        self::_showErr($errStr);
    }

    //创建资源对象
    public static function _createObj($_className) {
        if (isset(self::$_modelObjArr[$_className]) && is_object(self::$_modelObjArr[$_className])) {
            return self::$_modelObjArr[$_className];
        } else {
            self::$_modelObjArr[$_className] = new $_className();
            return self::$_modelObjArr[$_className];
        }
    }

    //错误提示
    public static function _showErr($_errTypeStr = '') {
        echo $_errTypeStr;
        exit;
    }

}

?>
