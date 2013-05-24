<?php

/**

 * @author chenghuiyong <sir.bravecheng@gmai.com>
 * @name 仓库函数集合 
 * 
 */
defined('IN_ECS') OR die('Hacking attempt');

/**
 * 获取仓库商品的储位信息
 * @param string $goods_sn 商品SN
 * @param int $warehouse_id 仓库ID
 * @return mixed 
 */
if (!function_exists('get_storage')) {

    function get_storage($goods_sn, $warehouse_id) {
        $info = array();
        if (empty($goods_sn) || empty($warehouse_id)) {
            return;
        }
        $sql = "SELECT warehouse_id, warehousing_id FROM ecs_stock_invoice_labels WHERE goods_sn = '{$goods_sn}' AND is_shipments = 0 AND warehouse_id > 0 AND warehousing_id > 0 AND warehouse_id = {$warehouse_id}";
        $array = $GLOBALS['db']->getAll($sql);
        if ($array) {
            foreach ($array as $value) {
                $var[$value['warehousing_id']] = $value['warehouse_id'];
            }
            foreach ($var as $k => $v) {
                $warehouse = get_warehouse($v);
                $row = get_warehousing($k);
                $info[$warehouse['name']][] = $row['name'];
            }
            foreach ($info as $h) {
                $string .= implode('、', $h);
            }
            return $string;
        }
        return '（无）';
    }

}

/**
 * 获取仓库基础信息
 * @param int $warehouse_id 仓库ID 
 * @return mixed 仓库信息
 */
if (!function_exists('get_warehouse')) {

    function get_warehouse($warehouse_id) {
        $sql = "SELECT warehouse_sn,warehouse_id,name FROM `ecs_warehouse` WHERE warehouse_id = '{$warehouse_id}'";
        return $GLOBALS['db']->getRow($sql);
    }

}

/**
 * 获取储位信息
 * @param int $id 储位ID
 * @return array 储位信息
 */
if (!function_exists('get_warehousing')) {

    function get_warehousing($id) {
        $sql = "SELECT id, warehouse_id, `name`, admin_id, is_valid, add_time, note, last_update_time, last_admin_id FROM ecs_warehousing WHERE id = '{$id}'";
        return $GLOBALS['db']->getRow($sql);
    }

}

/**
 * 管理员是否在指定的工作组中
 * @param mixed $group 组ID
 * @param mixed $user_id 用户ID 
 * @param boolean $msg_output 是否页面返回
 * @return mixed
 */
if (!function_exists('admin_user_is_group')) {

    function admin_user_is_group($group, $user_id = NULL, $msg_output = FALSE) {
        static $result = FALSE;
        $user_id = $user_id ? $user_id : $_SESSION['admin_id'];
        if (is_array($group)) {
            foreach ($group as $gp) {
                admin_user_is_group($gp);
            }
        } else {
            $sql = "SELECT a.group_id FROM ecs_admin_user AS a JOIN meilele_group AS b ON a.group_id = b.group_id WHERE a.user_id = '{$user_id}' AND b.group_id = '{$group}'";
            $GLOBALS['db']->getOne($sql) > 0 && $result = TRUE;
        }
        if (FALSE === $result) {
            $link[] = array('text' => $GLOBALS['_LANG']['go_back'], 'href' => 'javascript:history.back(-1)');
            if ($msg_output) {
                sys_msg($GLOBALS['_LANG']['priv_error'], 0, $link);
            }
        }
        return $result;
    }

}

/**
 * 获取指定名称的组ID
 * @param mixed $array 组名
 * @return array
 */
function get_group_id($array = array()) {
    static $group_id = array();
    if (is_array($array)) {
        foreach ($array as $value) {
            get_group_id($value);
        }
    } else {
        $gid = $GLOBALS['db']->getOne("SELECT group_id FROM meilele_group WHERE group_name = '{$array}'");
        if (is_numeric($gid)) {
            $group_id[] = $gid;
        }
    }
    return $group_id;
}