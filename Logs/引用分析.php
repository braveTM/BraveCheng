<?php

/**
 * ECSHOP 订单管理
 * ============================================================================
 * 版权所有 (C) 2005-2006 康盛创想（北京）科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com
 * ----------------------------------------------------------------------------
 * 这是一个免费开源的软件；这意味着您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * ============================================================================
 * $Author: zhoubo $
 * $Date: 2008/06/26 09:30:56 $
 * $Id: order.php,v 1.10 2008/06/26 09:30:56 zhoubo Exp $
 */

define('IN_ECS', true);
define('DB_SELECT', 1);
require('includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
require_once(ROOT_PATH . 'includes/lib_stock.php');
require_once(ROOT_PATH . 'includes/cls_image.php');
require(ROOT_PATH . 'includes/cls_json.php');
error_reporting(0);
// error_reporting(E_ALL & ~E_NOTICE);
define('MINBONUSUSE', 1000); //红包使用的最小金额
// const MINBONUSUSE = '1000'; 

$json = new JSON();
$exc = new exchange($ecs->table('order_info'), $db, 'order_id', 'order_sn');
$invoice_fstatus['new'] = '新单';
$invoice_fstatus['printed'] = '已打印';
$invoice_fstatus['shipped'] = '已发货';
$invoice_fstatus['cancel'] = '取消';
$invoice_fstatus['reserv'] = '备货中';
$invoice_fstatus['merged'] = '已合并';
$invoice_fstatus['shipped_expr'] = '已发货到体验馆';
$invoice_fstatus['transport'] = '配送在途';
$invoice_fstatus['receiv'] = '配送在库';
$invoice_fstatus['dest_print'] = '配送打印';

$smarty->assign('ERP_FLAG', 0);
$is_open_erp = false;
/* ------------------------------------------------------ */
//-- 订单查询
/* ------------------------------------------------------ */
if ($_REQUEST['act'] == 'order_query') {
    /* 检查权限 */
    admin_priv('order_view');

    /* 载入配送方式 */
    $smarty->assign('shipping_list', shipping_list());

    /* 载入支付方式 */
    $smarty->assign('pay_list', payment_list());

    /* 载入国家 */
    $smarty->assign('country_list', get_regions());

    /* 载入订单状态、付款状态、发货状态 */
    $smarty->assign('os_list', get_status_list('order'));
    $smarty->assign('ps_list', get_status_list('payment'));
    $smarty->assign('ss_list', get_status_list('shipping'));
    $smarty->assign('SS_UNSHIPPED', SS_UNSHIPPED);
    $smarty->assign('SS_PART_SHIPPED', SS_PART_SHIPPED);
    $smarty->assign('SS_RECEIVED', SS_RECEIVED);
    $smarty->assign('OS_AFTER_SRV', OS_AFTER_SRV);
    $smarty->assign('SS_PREPARING', SS_PREPARING);



    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['03_order_query']);
    $smarty->assign('action_link', array('href' => 'order.php?act=list', 'text' => $_LANG['02_order_list']));

    /* 显示模板 */
    assign_query_info();
    $smarty->display('order_query.htm');
}
//ajax查询操作收货人是否是发货去向体验馆
elseif ($_REQUEST['act'] == 'ajax_order') {

    $order_id = $_REQUEST['order_id'];
    $sql = "SELECT ship_direction FROM `ecs_order_info` WHERE  `order_id` = '" . $order_id . "';";
    $ship_direction = $db_select->getOne($sql);

    if ($ship_direction == '0') {
        $data['error'] = '1';
        $data['msg'] = '发货方向是客户，不能进行收货操作';
        die($json->encode($data));
    }
    $sql = "SELECT een.`expr_id` FROM `ecs_admin_user` AS eau
JOIN `ecs_warehouse` AS ew ON ew.`warehouse_id` = eau.`warehouse_id`
JOIN `ecs_expr_nature` AS een ON een.`expr_id` = ew.`expr_id`
 WHERE eau.user_id = '" . $_SESSION['admin_id'] . "';";
    $expr_id = $db_select->getOne($sql);

    if ($ship_direction == $expr_id) {
        $data['error'] = '0';
        die($json->encode($data));
    } else {
        $data['error'] = '1';
        $data['msg'] = '你不是发货方向体验馆仓库的管理员，不能进行收货操作';
        die($json->encode($data));
    }
}
/* ------------------------------------------------------ */
//-- 订单列表
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'list') {


    /* 检查权限 */
    admin_priv('order_view');
    $expr = !empty($_REQUEST['expr']) && is_numeric($_REQUEST['expr']) ? $_REQUEST['expr'] : 0;
    if ($expr > -2) {
        $sql = "SELECT expr_id,expr_name FROM `ecs_expr_nature`";
        $expr_list = array();
        $res = $db_select->query($sql);
        while ($row = $db_select->fetchRow($res)) {
            $expr_list[$row['expr_id']] = $row['expr_name'];
        }
        $smarty->assign('expr', $expr);
        $smarty->assign('expr_list', $expr_list);
    }

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['02_order_list']);
    $smarty->assign('action_link', array('href' => 'order.php?act=order_query', 'text' => $_LANG['03_order_query']));

    $smarty->assign('status_list', $_LANG['cs']);   // 订单状态

    $smarty->assign('os_unconfirmed', OS_UNCONFIRMED);
    $smarty->assign('cs_await_pay', CS_AWAIT_PAY);
    $smarty->assign('cs_await_ship', CS_AWAIT_SHIP);
    $smarty->assign('CS_SERV', CS_SERV);
    $smarty->assign('CS_SHIIPED_NO_REC', CS_SHIIPED_NO_REC);


    $smarty->assign('SS_UNSHIPPED', SS_UNSHIPPED);
    $smarty->assign('SS_PART_SHIPPED', SS_PART_SHIPPED);
    $smarty->assign('SS_RECEIVED', SS_RECEIVED);
    $smarty->assign('OS_AFTER_SRV', OS_AFTER_SRV);
    $smarty->assign('SS_PREPARING', SS_PREPARING);



    $smarty->assign('CS_AUDIT_NEW', CS_AUDIT_NEW);
    $smarty->assign('CS_AUDIT_AUDIT', CS_AUDIT_AUDIT);
    $smarty->assign('CS_AUDIT_REJECT', CS_AUDIT_REJECT);

    $smarty->assign('full_page', 1);



    //$smarty->assign('assign_status', array('no' => "未分配", 'assigned' => '已分配'));   // 订单状态
    //$smarty->assign('mech_list', array('yangyuhong' => "杨雨红", 'qinfengzeng' => 'qinfengzeng'));   // 订单状态，暂时写死，待admin_user的group_id功能好了后，改过来。 zhoubo 2011.3.26

    $order_list = order_list();

    $export_view = $db_select->getOne("SELECT COUNT(*) FROM ecs_admin_user where (action_list like '%order_export%' or action_list = 'all') and user_id = {$_SESSION['admin_id']}");
    $smarty->assign("export_view", $export_view);
    foreach ($order_list['orders'] as &$v) {
        $admin_name = '';
        if ($v['admin_id']) {
            $admin_id = explode('|', $v['admin_id']);
            foreach ($admin_id as $a) {
                if ($a) {
                    $real_name = $db_select->getOne("SELECT real_name FROM ecs_admin_user WHERE user_id = " . $a);
                    $admin_name .= '|' . $real_name;
                }
            }
            $v['admin_name'] = trim($admin_name, '|');
        }
    }

    //获取销售组

    $sql = "SELECT group_id,group_name FROM meilele_group WHERE `code` = 'is_salesman'";
    $saleman_group = $db_select->getAll($sql);
    $smarty->assign('saleman_group', $saleman_group);
    $smarty->assign('order_list', $order_list['orders']);
    $smarty->assign('filter', $order_list['filter']);
    $smarty->assign('record_count', $order_list['record_count']);
    $smarty->assign('page_count', $order_list['page_count']);
    $smarty->assign('sort_order_time', '<img src="images/sort_desc.gif">');
    $smarty->assign('pay_part', PS_PAYING);

    $sql ="SELECT `warehouse_id`,`warehouse_sn`,`name` FROM `ecs_warehouse` ORDER BY warehouse_sn";
    $warehouse = array();
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res)) {
        $row['warehouse_id'] = 'w_'.$row['warehouse_id'];
        $warehouse[] = $row;
    }
    $smarty->assign("warehouse",$warehouse);

    $third_part = $db->getAll('SELECT id shop_id,name shop_name FROM ecs_shop_info');
    $smarty->assign('thirdpartname', $third_part);

    /* 显示模板 */
    assign_query_info();
    $smarty->display('order_list.htm');
}

/* ------------------------------------------------------ */
//-- 排序、分页、查询
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'query') {
    $expr = !empty($_REQUEST['expr']) && is_numeric($_REQUEST['expr']) ? $_REQUEST['expr'] : 0;
    if ($expr > -2) {
        $sql = "SELECT expr_id,expr_name FROM `ecs_expr_nature`";
        $expr_list = array();
        $res = $db->query($sql);
        while ($row = $db->fetchRow($res)) {
            $expr_list[$row['expr_id']] = $row['expr_name'];
        }
        $smarty->assign('expr', $expr);
        $smarty->assign('expr_list', $expr_list);
    }
    unset($_SESSION['lastfiltersql']);
    if (!isset($_REQUEST['delivery']))
        $order_list = order_list();
    else
        $order_list = order_delivery_list();
    foreach ($order_list['orders'] as &$v) {
        $admin_name = '';
        if ($v['admin_id']) {
            $admin_id = explode('|', $v['admin_id']);
            foreach ($admin_id as $a) {
                if ($a) {
                    $real_name = $db_select->getOne("SELECT real_name FROM ecs_admin_user WHERE user_id = " . $a);
                    $admin_name .= '|' . $real_name;
                }
            }
            $v['admin_name'] = trim($admin_name, '|');
        }
    }
    $smarty->assign('SS_UNSHIPPED', SS_UNSHIPPED);
    $smarty->assign('SS_PART_SHIPPED', SS_PART_SHIPPED);
    $smarty->assign('SS_RECEIVED', SS_RECEIVED);
    $smarty->assign('OS_AFTER_SRV', OS_AFTER_SRV);
    $smarty->assign('SS_PREPARING', SS_PREPARING);

    //   var_dump( $order_list['filter']);

    $smarty->assign('order_list', $order_list['orders']);
    $smarty->assign('filter', $order_list['filter']);
    $smarty->assign('record_count', $order_list['record_count']);
    $smarty->assign('page_count', $order_list['page_count']);
    $sort_flag = sort_flag($order_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    if (!isset($_REQUEST['delivery']))
        make_json_result($smarty->fetch('order_list.htm'), '', array('filter' => $order_list['filter'], 'page_count' => $order_list['page_count']));
    else
        make_json_result($smarty->fetch('order_delivery_list.htm'), '', array('filter' => $order_list['filter'], 'page_count' => $order_list['page_count']));
}
elseif ($_REQUEST['act'] == 'edit_info') {
    if ($_POST['submit']) {
        $data['order_ship_type'] = (int)$_POST['order_ship_type'];
        $order_id = intval($_REQUEST['order_id']);
        $db->query("UPDATE ecs_order_info SET order_ship_type = ".$data['order_ship_type']." WHERE order_id = ".$order_id." LIMIT 1");
        $extends['order_id'] = $order_id;
        $extends['delivery_party'] = $_POST['delivery_party'];
        $extends['patch_price'] = (float)$_POST['patch_price'];
        $extends['supplier_sn'] = $_POST['supplier_sn'];
        $extends['arrive_date'] = strtotime($_POST['arrive_date']);
        $extends['complete_date'] = strtotime($_POST['complete_date']);
        
        if (!$extends['delivery_party'] || !$extends['supplier_sn']) {
            sys_msg("发货方和归属工厂必须选择");
        }
        if ($db->getRow("SELECT order_id FROM ecs_order_extend WHERE order_id = $order_id LIMIT 1")) {
           $db->query("UPDATE ecs_order_extend SET delivery_party = '".$extends['delivery_party']."', patch_price = ".$extends['patch_price'].", supplier_sn = '".$extends['supplier_sn']."', arrive_date = '".$extends['arrive_date']."', complete_date = '".$extends['complete_date']."' WHERE order_id = ".$order_id." LIMIT 1");
        } else {
            $db->query("INSERT INTO ecs_order_extend (order_id, delivery_party, patch_price, supplier_sn, arrive_date, complete_date) VALUES (".$extends['order_id'].", '".$extends['delivery_party']."', ".$extends['patch_price'].", '".$extends['supplier_sn']."', '".$extends['arrive_date']."', '".$extends['complete_date']."')");
        }
        
        header('Location: /admin/order.php?act=info&order_id='.$order_id);
        exit;
    }
    $sql ="SELECT `warehouse_id`,`warehouse_sn`,`name` FROM `ecs_warehouse` ORDER BY warehouse_sn";
    $warehouse = array();
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res)) {
        $row['warehouse_id'] = 'w_'.$row['warehouse_id'];
        $warehouse[] = $row;
    }
    $smarty->assign("warehouse",$warehouse);
    $order_id = intval($_REQUEST['order_id']);
    if (!$order_id) {
        sys_msg('非法订单');
    }
    $orderinfo = $db->getRow("SELECT * FROM ecs_order_info WHERE order_id = ".$order_id." LIMIT 1");
    if (!$orderinfo) {
        sys_msg('不存在的订单');
    }
    if ($orderinfo['order_type'] != 'patch_order') {
        sys_msg("只有补件订单可以进行此操作");
    }
    $extends = $db->getRow("SELECT * FROM ecs_order_extend WHERE order_id = ".$order_id." LIMIT 1");
    $orderinfo['delivery_party'] = $extends['delivery_party'];
    $orderinfo['patch_price'] = $extends['patch_price'];
    $orderinfo['supplier_sn'] = $extends['supplier_sn'];
    $orderinfo['arrive_date'] = $extends['arrive_date'] ? date("Y-m-d", $extends['arrive_date']) : '';
    $orderinfo['complete_date'] = $extends['complete_date'] ? date("Y-m-d", $extends['complete_date']) : '';
    
    #print_r($orderinfo);
    //拿取补件归属订单的产品
    // $parent_id = $db->getOne("SELECT parent_id FROM ecs_order_info WHERE order_id = $order_id");
    // $parent_id = $parent_id ? $parent_id : 0;
    // if ($parent_id) {
    //     $orderlist = $db->getAll("SELECT goods_id FROM ecs_order_goods WHERE order_id = $parent_id");
    //     $order_id_list = "-1";
    //     if ($orderlist) {            
    //         foreach ($orderlist as $v) {
    //             $order_id_list .= ",".$v['goods_id'];
    //         }
    //     }
    //     $supplier_sn_list = $db->getAll("SELECT supplier_sn FROM ecs_supplier_purchase WHERE goods_id IN  ($order_id_list)");
    //     $sn_list = "''";
    //     if ($supplier_sn_list) {
    //         foreach ($supplier_sn_list as $key => $value) {
    //             $sn_list .= ",'".$value['supplier_sn']."'";
    //         }
            // $supplier = $db->getAll("SELECT supplier_sn, supplier_name FROM ecs_supplier WHERE supplier_sn IN ($sn_list)");
        // }
        
        #echo "SELECT supplier_sn, supplier_name FROM ecs_supplier WHERE supplier_sn IN ($sn_list)";
        $supplier = $db->getAll("SELECT supplier_sn, supplier_name FROM ecs_supplier ORDER BY supplier_sn");
        $smarty->assign("supplier", $supplier);
    // }   
    $smarty->assign("info", $orderinfo);
    $smarty->display('order_edit_info.htm');
}
elseif ($_REQUEST['act'] == 'patch_comfirm') {
    $order_id = $_REQUEST['order_id'];
    if (ERP_FLAG == 1) {
        $orderinfo = $db->getRow("SELECT * FROM ecs_order_info WHERE order_id = $order_id LIMIT 1");
        $extends = $db->getRow("SELECT * FROM ecs_order_extend WHERE order_id = ".$order_id." LIMIT 1");
        $data['class'] = 'com.meilele.purchase.vo.PatchOrderVo';
        $data['createTime'] = date("Y-m-d H:i:s", $orderinfo['add_time']);
        $data['orderId'] = $orderinfo['order_id'];
        $data['orderSn'] = $orderinfo['order_sn'];
        $data['parentOrderId'] = $orderinfo['parent_id'];
        $data['parentOrderSn'] = $db->getOne("SELECT order_sn FROM ecs_order_info WHERE order_id = ".$orderinfo['parent_id']);
        $data['mark'] = 'insert';
        $data['supplierId'] = $db->getOne("SELECT id FROM ecs_supplier WHERE supplier_sn = '".$extends['supplier_sn']."'");
        $data['patchPrice'] = $extends['patch_price'];
        $data['arriveDate'] = $extends['arrive_date'] ? date('Y-m-d', $extends['arrive_date']) : '';
        $data['completeDate'] = $extends['complete_date'] ? date('Y-m-d', $extends['complete_date']) : '';
        $data['orderItemList'] = array();
        $orderlist = $db->getAll("SELECT * FROM ecs_order_goods WHERE order_id = $order_id AND shipping_status != 5");
        foreach ($orderlist as $key => $value) {
            $tmp = array();
            $tmp['number'] = $value['goods_number'];
            $tmp['productId'] = $value['goods_id'];
            $tmp['unitPrice'] = $value['goods_price'];
            $tmp['comments'] = "";
            if ($value['real_goods_id']) {
                $tmp['comments'] .= "真实货号:";
                $tmp['comments'] .= $db->getOne("SELECT goods_sn FROM ecs_goods WHERE goods_id = ".$value['real_goods_id']);
                $tmp['comments'] .= "。";
            }
            $tmp['comments'] .= $value['patch_note'];
            $data['orderItemList'][] = $tmp;
        }
        $ret = http_request1('receivePathchOrderFromPhp', $data, array('user_name' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));   
        $ret = json_decode($ret, 1);
        if ($ret['code'] != 1) {
            sys_msg($ret['msg']);
        }
    }
    $db->query("UPDATE ecs_order_extend SET patch_comfirm = 1 WHERE order_id = $order_id");
    $db->query("UPDATE ecs_order_info SET pay_status = 2 WHERE order_id = $order_id LIMIT 1");
    #$db->query("UPDATE ecs_order_info SET order_status = 1 WHERE order_id = $order_id LIMIT 1");
    $links[] = array('href' => '/admin/order.php?act=info&order_id='.$order_id, 'text' => '订单详情');
    sys_msg("生成成功", 0, $links);

}
/* ------------------------------------------------------ */
//-- 订单详情页面
/* ------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'info') {
    $smarty->assign('curr_time', date('Y-m-d'));
    /* 根据订单id或订单号查询订单信息 */
    if (isset($_REQUEST['order_id'])) {
        $order_id = intval($_REQUEST['order_id']);
        $order = order_info($order_id);
    } elseif (isset($_REQUEST['order_sn'])) {
        $order_sn = trim($_REQUEST['order_sn']);
        $order = order_info(0, $order_sn);
        $order_id = $order['order_id'];
    } else {
        /* 如果参数不存在，退出 */
        die('invalid parameter');
    }
    updateOrderAmount($order_id);
    
    if(admin_priv('cancel_order_pri','',false)){
    	$smarty->assign('cancel_order_pri',1);
    }
    
    
    /* 得到扩展表ecs_order_extend信息 */
    $sql = "select ship_pay_status from ecs_order_extend where order_id = '{$order_id}'";
    $order['ship_pay_status'] = $db->getOne($sql);
     //发货单费用信息
        $fee_invoice_sn = $db->getAll("SELECT `invoice_sn` FROM `ecs_stock_invoice_info` WHERE `order_id` = {$order_id}");
        if($fee_invoice_sn) {
            $is_meg = false;
            ////////////////////////////////////////////////////很重要的代码//////////////////////////////////////////////
            foreach ($fee_invoice_sn as $sn) {
                $fee_list = get_invoice_fee_by_invoice_id($sn['invoice_sn'],$is_meg);
                if($fee_list){
                     $fee_row[] =$fee_list ;
                }
            }
        }
       $uniq = $is_meg   ? array($fee_row[0]) : $fee_row;
//        var_dump($uniq);
        $smarty->assign('fee_list',$uniq);
    if($order['ship_pay_status'] == 2)
    {
        $alertgoodscon = $GLOBALS['db']->getCol("select goods_id from ecs_order_goods where order_id = '{$order_id}'");
        $alertvolume['goodsidsql'] = implode(',', $alertgoodscon);
        $alertvolume['goods'] = $GLOBALS['db']->getAll("SELECT b.goods_id,b.goods_name, b.goods_sn FROM ecs_order_goods a join ecs_goods b on a.goods_id = b.goods_id  WHERE b.stock_volumn=0 AND b.goods_id IN ($alertvolume[goodsidsql])  GROUP BY b.goods_id");
        if(empty($alertvolume['goods']))
        {
            //写日志,更改ecs_order_extend的状态
            $smarty->assign('alertvchack', 'false');
            $GLOBALS['db']->query("UPDATE ecs_order_extend SET ship_pay_status='0' where order_id='{$order_id}'");
            order_log_sqlin($order_id);
        }
        else
        {
            //显示有问题的物品并隐藏除更新活动数据的按钮
            $smarty->assign('alertvchack', 'true');
            $alertvolumenote = '';
            foreach ($alertvolume['goods'] as $v)
                $alertvolumenote .= "商品名[$v[goods_name]],商品SN[$v[goods_sn]],商品ID[$v[goods_id]]的体积为0!\\n";
            $smarty->assign('alertvolumenote', $alertvolumenote);
        }
    }

	$tb = $db->getOne("SELECT group_id from ecs_admin_user where (user_name = 'MLL_TB' and user_id = {$_SESSION['admin_id']}) or (action_list = 'all' and user_id = {$_SESSION['admin_id']})");
	$smarty->assign('tb',$tb);
    //$type = array(0 => '本站', 1 => '赠品', 2 => '促销', 3 => '特价', 4 => '限购', 5 => '包物流', 6 => '包快递', 7 => '返现', 8 => '体验馆特卖',9=>'秒杀',10=>'团购');
    $type = get_goods_type_name(0,1);
    $smarty->assign('_goods_type', $type);

    $order_user_id = $db->getOne("SELECT user_id from ecs_order_info where order_id = {$order_id}");
    $md5 = md5('mll_' . $order_user_id . $order_id);
    $smarty->assign("md5", $md5);
    if ($order['order_type'] == 'expr_order' && !$order['group_id'] && $order['order_status'] == 1) {
        echo "<script language='javascript'>alert('调货订单，请先设置订单归属!');location.href='/admin/order.php?act=owner_order&order_id=" . $order['order_id'] . "'</script>";
        exit;
    }
    $admin_info = $db_select->getRow("SELECT group_id,is_leader FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);
    //看金额是否为0 为0就可以设置取消订单

    if (!can_cancel_order($order_id)) {
        $smarty->assign('can_cancel', 1);
    }
    //销售不能修改体验馆调货订单
    if($order['group_id'])
    $order['leader_id'] = $db->getOne("SELECT group_leader_id FROM meilele_group where group_id = {$order['group_id']}");
	else
	$order['group_id'] = 0;
	
    $taobao_team = array(1, 3, 4, 5, 6, 94);
    if ($order['order_type'] == 'expr_quick')
        sys_msg('此订单还在体验馆快速下单队列中，请先设置为正常订单');
    if (!$order['admin_id']) //没有设置归属，不允许看联系方式
        $smarty->assign('order_contact_info', 0);
    else if (strpos($order['admin_id'], '|' . $_SESSION['admin_id'] . '|') !== FALSE || getorderContactInfo())
        $smarty->assign('order_contact_info', 1);
    else if ($order['leader_id'] == $_SESSION['admin_id'] || ($admin_info['group_id'] == $order['group_id'] && $admin_info['is_leader'] == 1)) //组长可以查看该组的
        $smarty->assign('order_contact_info', 1);
    else if (($order['leader_id'] == 154 || $order['leader_id'] == 131) && ($_SESSION['admin_id'] == 154 || $_SESSION['admin_id'] == 131))
        $smarty->assign('order_contact_info', 1);
    else if (viewOrderContactInfo()) //如果权限有，也可以查看
        $smarty->assign('order_contact_info', 1);
    else if ($admin_info['group_id'] == 1 && $admin_info['is_leader'] == 1) //网站组leader可以看到所有的
        $smarty->assign('order_contact_info', 1);
    else if ($admin_info['group_id'] == 48 || $admin_info['group_id'] == 8)
        $smarty->assign('order_contact_info', 1);
    else if (in_array($order['group_id'], $taobao_team) && in_array($admin_info['group_id'], $taobao_team) && $admin_info['is_leader'] == 1)//淘宝和网站组的leader可以查看所有网站和淘宝的订单信息
        $smarty->assign('order_contact_info', 1);
    if ($admin_info['group_id'] == 8) {
        $smarty->assign('order_contact_info', 1);
    }
    //$db->query("INSERT INTO ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time,log_level) VALUES(999999,'" . $_SESSION['admin_name'] . "','" . $order['order_status'] . "','" . $order['shipping_status'] . "','" . $order['pay_status'] . "','','" . $_SERVER['HTTP_X_REAL_IP'] . "','" . time() . "','0')");
    $owner_order = 1;
    if ($order['admin_id'] && strpos($order['admin_id'], '|' . $_SESSION['admin_id'] . '|') === false && !(checkOwnerOrder('order_contact_info') && $admin_info['group_id'] == $order['group_id'])) {
        $owner_order = 2;
        $assigner_id = $db_select->getALL("SELECT user_id FROM `ecs_admin_user` WHERE group_id = {$order['group_id']} and job_type = '财务助理'");
        if (!empty($assigner_id)) {
            foreach ($assigner_id as $v) {
                if ($v['user_id'] == $_SESSION['admin_id'])//用户是订单所属店的店长助理
                    $owner_order = 1;
                $smarty->assign('order_contact_info', 1);
            }
        }
        $leader_array = getLeaderByuser($order['admin_id']);
        if (!empty($leader_array)) {
            if (in_array($_SESSION['admin_id'], $leader_array)) {
                $owner_order = 1;
            }
        }
    }

    /* 取得这个订单的工作站售后单链接 */
    $sale_problem_url = $db_select->getAll("select work_state_url from ecs_sale_problem where order_sn='" . $order['order_sn'] . "' and  work_state_url !='' group by work_state_url");
    $smarty->assign('work_state_url', $sale_problem_url);

    /* 获取订单的商品的工厂库存数量 */
    //$sql = "SELECT * FROM `ecs_stock_supplier` where goods_sn in (select distinct goods_sn from ecs_order_goods where order_id = {$order_id})";
    $sql = "select esp.* from ecs_stock_supplier esp join (select distinct goods_sn as goods_sn from ecs_order_goods where order_id =$order_id) eog on esp.goods_sn=eog.goods_sn";
	$stock_supplier_tmp = $db_select->getAll($sql);
    $stock_supplier_count = array();
    foreach ($stock_supplier_tmp as $v) {
        if (empty($stock_supplier[$v['goods_sn']])) {
            if ($v['number']) {
                $stock_supplier[$v['goods_sn']] = "{$v['supplier_name']} ： {$v['number']}";
                $stock_supplier_count[$v['goods_sn']] += $v['number'];
            }
        } else {
            if ($v['number']) {
                $stock_supplier[$v['goods_sn']] .= "</br>{$v['supplier_name']} ： {$v['number']}";
                $stock_supplier_count[$v['goods_sn']] += $v['number'];
            }
        }
    }
    $smarty->assign('stock_supplier', $stock_supplier);
    $smarty->assign('stock_supplier_count', $stock_supplier_count);
    /*
      $veneto = get_veneto_userid($order['group_id']);
      if($veneto && in_array($_SESSION['admin_id'],$veneto))
      $smarty->assign('order_contact_info',1);
     */
    if ($admin_info['group_id'] == 48 || $admin_info['group_id'] == 8)//跟单售后直接给权限
        $owner_order = 1;

    $smarty->assign('owner_order', $owner_order);
    /* if ($order['order_amount']>0 and $order['money_paid']>$order['order_amount'])
      {
      $order['abackmoney']=$order['money_paid']-$order['order_amount'];
      } */
    //print $order['abackmoney'];

    /* 如果订单不存在，退出 */
    if (empty($order)) {
        die('order does not exist');
    }

    /* 根据订单是否完成检查权限 */
    if (order_finished($order)) {
        admin_priv('order_view_finished');
    } else {
        admin_priv('order_view');
    }

    /* 如果管理员属于某个办事处，检查该订单是否也属于这个办事处 */
    $sql = "SELECT agency_id FROM " . $ecs->table('admin_user') . " WHERE user_id = '$_SESSION[admin_id]'";
    $agency_id = $db_select->getOne($sql);
    if ($agency_id > 0) {
        if ($order['agency_id'] != $agency_id) {
            sys_msg($_LANG['priv_error']);
        }
    }
    $group_name = $db_select->getOne("SELECT group_name FROM meilele_group WHERE group_id = {$order['group_id']}");
    $smarty->assign('store_name', $group_name);

    // 是否需要打印合同
    $makecontract = $db_select->getOne("SELECT group_id FROM meilele_group WHERE `code`='is_salesman' AND group_id=" . $order['group_id']);
    $smarty->assign('makecontract', $makecontract);

    $invoice_bill = checkInvoiceBill($order_id); //检查是否有发货单
    $smarty->assign('invoice_bill', $invoice_bill);
    /* 取得上一个、下一个订单号 */
    $sql = "SELECT MAX(order_id) FROM " . $ecs->table('order_info') . " WHERE order_id < '$order[order_id]'";
    if ($agency_id > 0) {
        $sql .= " AND agency_id = '$agency_id'";
    }
    $smarty->assign('prev_id', $db_select->getOne($sql));
    $sql = "SELECT MIN(order_id) FROM " . $ecs->table('order_info') . " WHERE order_id > '$order[order_id]'";
    if ($agency_id > 0) {
        $sql .= " AND agency_id = '$agency_id'";
    }
    $smarty->assign('next_id', $db_select->getOne($sql));

    /* 取得用户名 */
    if ($order['user_id'] > 0) {
        $user = user_info($order['user_id']);
        if (!empty($user)) {
            $order['user_name'] = $user['user_name'];
        }
    }

    //王宜东 -> 杨志勇

    $sql = "select `vehicle_fstatus` from " . $ecs->table('order_extend') . " where `order_id`= '$order[order_id]'";
    $order['vehicle_fstatus'] = $db->getOne($sql);


    /* 取得所有办事处 */
    $sql = "SELECT agency_id, agency_name FROM " . $ecs->table('agency');
    $smarty->assign('agency_list', $db_select->getAll($sql));

    /* 取得区域名 */
    $sql = "SELECT concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''), " .
            "'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region " .
            "FROM " . $ecs->table('order_info') . " AS o " .
            "LEFT JOIN " . $ecs->table('region') . " AS c ON o.country = c.region_id " .
            "LEFT JOIN " . $ecs->table('region') . " AS p ON o.province = p.region_id " .
            "LEFT JOIN " . $ecs->table('region') . " AS t ON o.city = t.region_id " .
            "LEFT JOIN " . $ecs->table('region') . " AS d ON o.district = d.region_id " .
            "WHERE o.order_id = '$order[order_id]'";
    $order['region'] = $db_select->getOne($sql);
    $custom_edit_region = $GLOBALS['db']->getOne('SELECT region_name FROM ecs_region_edit a JOIN ecs_order_extend b ON a.region_id = b.custom_district WHERE b.order_id=' . $order['order_id']);
    $order['region'] .= ' ' . $custom_edit_region;
    //发货方向

    $ship_direction = $order['ship_direction'];
    if ($order['ship_direction'] == 0) {
        $order['ship_direction'] = '客户';
    } else {
        $sql = "SELECT expr_name FROM `ecs_expr_nature` WHERE expr_id='{$order['ship_direction']}'";
        $order['ship_direction'] = $db_select->getOne($sql);
    }

    /* 其他处理 */
    $order['order_time'] = date($_CFG['time_format'], $order['add_time']);
    //if(!empty($order['best_time']))
    //$order['best_time']     = date('Y-m-d', $order['best_time']);
    $order['pay_time'] = $order['pay_time'] > 0 ?
            date($_CFG['time_format'], $order['pay_time']) : $_LANG['ps'][PS_UNPAYED];
    $order['shipping_time'] = $order['shipping_time'] > 0 ?
            date($_CFG['time_format'], $order['shipping_time']) : $_LANG['ss'][SS_UNSHIPPED];
    $order['status'] = $_LANG['os'][$order['order_status']] . ',' . $_LANG['ps'][$order['pay_status']] . ',' . $_LANG['ss'][$order['shipping_status']];
    $order['invoice_no'] = $order['shipping_status'] == SS_UNSHIPPED || $order['shipping_status'] == SS_PREPARING ? $_LANG['ss'][SS_UNSHIPPED] : $order['invoice_no'];
    /* 取得订单的来源 */
    if ($order['from_ad'] == 0) {
        $order['referer'] = empty($order['referer']) ? $_LANG['from_self_site'] : $order['referer'];
    } elseif ($order['from_ad'] == -1) {
        $order['referer'] = $_LANG['from_goods_js'] . ' (' . $_LANG['from'] . $order['referer'] . ')';
    } else {
        /* 查询广告的名称 */
        $ad_name = $db_select->getOne("SELECT ad_name FROM " . $ecs->table('ad') . " WHERE ad_id='$order[from_ad]'");
        $order['referer'] = $_LANG['from_ad_js'] . $ad_name . ' (' . $_LANG['from'] . $order['referer'] . ')';
    }
    //尽快发货检测
    //if(($already_pay + $order['bonus'] + $order['discount'])/$order['goods_amount'] >= HURRY_PERCENT)
    $smarty->assign('hurry_flag', 1);

    /* 此订单的发货备注(此订单的最后一条操作记录) */
    $sql = "SELECT action_note FROM " . $ecs->table('order_action') .
            " WHERE order_id = '$order[order_id]' AND shipping_status = 1 ORDER BY log_time DESC";
    $order['invoice_note'] = $db_select->getOne($sql);

    /* 取得订单商品总重量 */
    $weight_price = order_weight_price($order['order_id']);
    $order['total_weight'] = $weight_price['formated_weight'];
    //获取虚拟退款
    
    $virtual_amount = $db->getOne("SELECT sum(erd.refund_amount)
    		FROM ecs_refund_detail_virtual erd
    		left join ecs_refund_virtual er on erd.refund_id=er.refund_id
    		where erd.item_type in('minus_end_fee') and erd.detail_status in ('confirmed') and er.order_id=$order_id;");
    if ($order['order_sn']) {
        $refund_id_order = $db_select->getOne("select refund_id from ecs_refund_virtual where order_sn='" . $order['order_sn'] . "'");
        //转入订单金额
        $virtual_amount_order_sn = $db_select->getAll("select rv.order_sn,rdv.refund_amount from ecs_refund_detail_virtual  rdv left join ecs_refund_virtual rv on rdv.refund_id =rv.refund_id where rdv.into_order_sn='" . $order['order_sn'] . "' and rdv.detail_status ='confirmed' and (rdv.type='into_order_fee' or rdv.item_type='into_order_fee_type')");
        //获取转出的订单金额
        // $virtual_amount_out = getVirtualAmount_new($order['order_sn']);

        // if ($virtual_amount_out) {
            $pay_sum = $db_select->getOne("SELECT sum(audit_money) as money FROM ecs_audit_withdraw WHERE order_id = $order_id AND (audit_status != 'audit_bad')");
            $smarty->assign('pay_sum', $pay_sum);
        // }
        $refund_id = $db_select->getOne("select refund_id from ecs_refund where order_sn='" . $order['order_sn'] . "'");
    }

    if ($order['add_time'] >= strtotime('2011-07-25 00:00:00') && $order['order_type'] != 'patch_order')
        modifyOrderPayStatus($order['order_id']);
    $order['goods_discount_detail'] = nl2br($order['goods_discount_detail']);

    /*
    //显示当前订单下已发货的发货单
    //已发送到体验馆的发货单
    $sql = "SELECT esii.`invoice_sn`, esii.`invoice_id`, esii.`consignee`,ew.`name`,
        esii.`total_package_num`,esii.`volumn_sum`,esii.`fstatus`,esii.`ship_time`,esii.`is_receiving`
FROM `ecs_order_info` AS eoi
LEFT JOIN `ecs_stock_invoice_info` AS esii ON esii.`order_id` = eoi.`order_id`
LEFT JOIN `ecs_warehouse` AS ew ON ew.`warehouse_id` = esii.`warehouse_id` 
WHERE esii.fstatus = 'shipped_expr' AND eoi.`order_sn` = '" . $order['order_sn'] . "' AND eoi.`ship_direction` != '0'";
    $query = $db_select->query($sql);
    $invoice_one = array();
    while ($row = $db_select->fetchRow($query)) {
        $row['fstatus'] = $invoice_fstatus[$row['fstatus']];
        $row['is_receiving'] = $row['is_receiving'] == '1' ? '已收货' : '<font color="red">未收货</font>';
        $row['ship_time'] = date("Y-m-d H:i:s", $row['ship_time']);
        $invoice_one[] = $row;
    }
    //已发货发货单
    $sql = "SELECT ew.`warehouse_id`
FROM `ecs_expr_nature` AS een
JOIN `ecs_warehouse` AS ew ON ew.`expr_id` = een.`expr_id`
WHERE een.`expr_id` = '" . $ship_direction . "'";
    $warehouse_id = $db_select->getOne($sql);


    $sql = "SELECT esii.`invoice_sn`, esii.`invoice_id`, esii.`consignee`,ew.`name`,
        esii.`total_package_num`,esii.`volumn_sum`,esii.`fstatus`,esii.`ship_time`,esii.`is_receiving`
FROM `ecs_order_info` AS eoi
LEFT JOIN `ecs_stock_invoice_info` AS esii ON esii.`order_id` = eoi.`order_id`
LEFT JOIN `ecs_warehouse` AS ew ON ew.`warehouse_id` = esii.`warehouse_id` 
WHERE esii.fstatus = 'shipped' AND eoi.`order_sn` = '" . $order['order_sn'] . "' AND eoi.`ship_direction` != '0'
AND esii.`warehouse_id` != '" . $warehouse_id . "'";
    $query = $db_select->query($sql);
    $invoice_two = array();
    while ($row = $db_select->fetchRow($query)) {
        $row['fstatus'] = $invoice_fstatus[$row['fstatus']];
        $row['is_receiving'] = '不需要体验馆收货';
        $row['ship_time'] = date("Y-m-d H:i:s", $row['ship_time']);
        $invoice_two[] = $row;
    }

    $invoice = array_merge($invoice_one, $invoice_two);
    */
    $invoice = getInvoiceList($order['order_id']);
    $smarty->assign('invoice', $invoice);
    
    $next_send='';
    $order_extend=$db->getRow("SELECT * FROM  `ecs_order_extend` WHERE `order_id`='".$order_id."'");//不是这个订单的下次发货的商品
    $next_send = $order_extend['next_send'];
    $order['next_send']= $next_send ? 1 : 0;
    $order['delivery_party'] = $order_extend['delivery_party'];
    $order['patch_price'] = $order_extend['patch_price'];
    $order['patch_comfirm'] = $order_extend['patch_comfirm'] ? $order_extend['patch_comfirm'] : 0;
    $order['supplier_sn'] = $order_extend['supplier_sn'];
    $order['arrive_date'] = $order_extend['arrive_date'] ? date("Y-m-d", $order_extend['arrive_date']) : '';
    $order['complete_date'] = $order_extend['complete_date'] ? date("Y-m-d", $order_extend['complete_date']) : '';
    $delivery_arr = array('1'=>'工厂', '2'=>'仓库', '3'=>'工厂→仓库发', '4'=>'体验馆');
    //complete_date
    $sql ="SELECT `warehouse_id`,`warehouse_sn`,`name` FROM `ecs_warehouse`";
    $warehouse = array();
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res)) {
        $row['warehouse_id'] = 'w_'.$row['warehouse_id'];
        $warehouse[] = $row;
    }
    $smarty->assign("warehouse",$warehouse);
    if ($order['delivery_party'] ==1 ||$order['delivery_party'] ==2 || $order['delivery_party'] ==3 ||$order['delivery_party'] ==4 ){
        $order['delivery_party'] = $delivery_arr[$order['delivery_party']];
    } else {
        foreach ($warehouse as $key => $value) {
            if ($order['delivery_party'] == $value['warehouse_id']) {
                $order['delivery_party'] = $value['name'];
                break;
            }
        }
    }
    if ($order['order_type'] == 'patch_order') {
        $supplier = $db->getAll("SELECT supplier_sn, supplier_name FROM ecs_supplier");
        $smarty->assign("supplier", $supplier);
    }
    #print_r($order);
    /* 参数赋值：订单 */

    // 虚拟商品显示发货提示
    $virtual_limit = @explode(',', getDBVariable('virtual_shopping'));
    if(in_array($_SESSION['admin_id'], $virtual_limit))
    {
        $is_visualorder = $db->getOne('SELECT order_id FROM ecs_order_goods WHERE goods_type=11 AND shipping_status!=1 AND order_id=' . $order_id);
        if(!empty($is_visualorder) && ($order['pay_status'] == 2))
            $smarty->assign('virtual_consign', 1);
    }
    
    $smarty->assign('order', $order);//DO
    //卸货点
    $unload = get_warehouse_info($order_id);
    $smarty->assign("unload", $unload['name']);
    if ($refund_id_order) {
        $virtual_message = $db_select->getAll("select applicantor,add_time as log_time,refund_amount,into_order_sn from ecs_refund_detail_virtual where refund_id =" . $refund_id_order . " and detail_status ='confirmed'");

        foreach ($virtual_message as $key => $val) {
            if ($val['log_time']) {
                $virtual_message[$key]['log_time'] = date("Y-m-d H:i:s", ($val['log_time'] + 60 * 60 * 8));
            }
        }

        $smarty->assign('virtual_message', $virtual_message);
    }

    // $smarty->assign('virtual_amount_out', $virtual_amount_out);
    $smarty->assign('virtual_amount', $virtual_amount);
    $smarty->assign('virtual_amount_order_sn', $virtual_amount_order_sn); //虚拟退款转订单金额
//     $virtual_order_in = $db_select->getAll("select rv.order_sn,rdv.refund_amount,rdv.applicantor,rv.log_time,confirm_time from ecs_refund_detail_virtual rdv left join ecs_refund_virtual rv on rdv.refund_id =rv.refund_id 
// where rdv.into_order_sn='" . $order['order_sn'] . "' and rdv.detail_status ='confirmed' and (rdv.type='into_order_fee' or rdv.item_type='into_order_fee_type')"); // 转入订单金额
//     $virtual_order_in_count = 0; //转订单金额总和
//     foreach($virtual_order_in as $k=>$v)
//     {
//         $v['log_time'] = date('Y-m-d H:i:s' , $v['log_time']);
//         $v['confirm_time'] = date('Y-m-d H:i:s' , $v['confirm_time']);
//         $virtual_order_in[$k] = $v;
//         $virtual_order_in_count += $v['refund_amount'];
//     }
//     $smarty->assign('virtual_order_in', $virtual_order_in);

    $audit_money_new = order_audit_list($order['order_id']);
    $audit_money_new_count = 0;
    $audit_money_new_count_all = 0;
    foreach($audit_money_new as $v)
    {
        if($v['audit_status'] != '审核失败' && $v['is_receive'] == 1)
            $audit_money_new_count += $v['audit_money'];
        if($v['audit_status'] != '审核失败')
            $audit_money_new_count_all += $v['audit_money'];
    }

    $audit_money_confirm = $audit_money_new_count + $virtual_order_in_count; // 已审核金额+转入订单金额
    $smarty->assign('audit_money_confirm', sprintf('%.2f', $audit_money_confirm));

    //该订单退款单详情
    if ($refund_id || $refund_id_order) {
        // $refund_info = refund_info($refund_id);
        if(!empty($refund_id))
        {
            $refund_use_type = array("'setup'","'repair'","'delivery_fee'","'handing_fee'");
            $refund_details = refund_details($refund_id,$refund_use_type); //订单退款列表
            $refund_details_other = refund_details($refund_id, $refund_use_type, -1); // 安装维修送货费用列表
        }
        if(!empty($refund_id_order))
        {
            $refund_details_add = refund_details($refund_id_order, '', 1); //订单退款列表虚拟
            foreach($refund_details_add as $k=>$v)
                $refund_details_add[$k]['virtual'] = 1;

            if(!empty($refund_details))
                $refund_details = array_merge($refund_details, $refund_details_add);
            else
                $refund_details = $refund_details_add;
        }

        $refund_info = array('refund_amount'=>0,'into_order_fee'=>0, 'refund_other_amount'=>0, 'pay_much'=>0, 'cancel'=>0);
        $already_refund = array('str'=>'', 'total_count'=>0);
        foreach($refund_details as $v)
        {
            if(($v['detail_status'] == '已确认' || $v['detail_status'] == '已完成') && $v['item_type'] != 'minus_end_fee')
                $refund_info['refund_amount'] += $v['refund_amount'];
            if(($v['detail_status'] == '已确认' || $v['detail_status'] == '已完成') && $v['type'] == 'pay_much')
                $refund_info['pay_much'] += $v['refund_amount'];
            if(($v['detail_status'] == '已确认' || $v['detail_status'] == '已完成') && $v['type'] == 'cancel')
                $refund_info['cancel'] += $v['refund_amount'];
            if(($v['detail_status'] == '已确认' || $v['detail_status'] == '已完成') && $v['type'] == 'into_order_fee')
            	$refund_info['into_order_fee'] += $v['refund_amount'];
            if($v['type'] == 'pay_much' && $v['detail_status'] != '新项')
            {
                $already_refund['str'][] .= $v['refund_amount'];
                $already_refund['total_count'] += $v['refund_amount'];
            }
        }
        $already_refund['str'] = implode(' + ', $already_refund['str']);
        foreach($refund_details_other as $v)
            if($v['detail_status'] != '已取消')
                $refund_info['refund_other_amount'] += $v['refund_amount'];

        $recive_pay_num = $audit_money_confirm; // 实际收款
        // $recive_pay_num = (float) substr($order['already_pay'], 3) - $virtual_amount_out; // 实际收款
        $refund_info_num = $refund_info['refund_amount'];
        $client_pay_num = $recive_pay_num - $refund_info_num; //实际和收款 - 实际退款=客户实付款
        foreach($refund_info as $k=>$v)
        {
            $v = sprintf('%.2f', $v);
            $refund_info[$k] = $v;
        }
        foreach($refund_info as $k => $v)
            $refund_info_format[$k] = number_format($v,2);
        
        $smarty->assign('client_pay_info', array('recive_pay_num'=>number_format($recive_pay_num,2),'refund_info_num'=>number_format($refund_info_num,2),'client_pay_num'=>number_format($client_pay_num,2)));
        $smarty->assign('already_refund', $already_refund);
        $smarty->assign('refund_info', $refund_info_format);
        $smarty->assign('refund_info_o', $refund_info);
        foreach($refund_details as $k => $v)
            $refund_details[$k]['refund_amount'] = number_format($v['refund_amount'],2);
        $smarty->assign('refund_details', $refund_details);
        $smarty->assign('refund_details_other', $refund_details_other);
    }
    // $already_pay_new = (float) substr($order['already_pay'], 3);
    // $order_receive_money = $already_pay_new + $virtual_amount - $refund_info['pay_much'] - $refund_info['cancel'];
    // var_dump($audit_money_new_count_all,$refund_info['pay_much'],$refund_info['cancel']);
    $order_receive_money = $audit_money_new_count_all - $refund_info['pay_much'] - $refund_info['cancel'] - $refund_info['into_order_fee'];
    $smarty->assign('order_receive_money', sprintf('%.2f',$order_receive_money)); // 订单收款金额
    // $order_amount_new = (float) substr($order['order_amount'], 3);
    $order_shouldpay_new = getOrderShouldPay($order['order_id']); // 订单应付金额[未退款]
    $order_amount_new = sprintf('%.2f', $order_shouldpay_new  - $order_receive_money); // 订单应付金额[已退款]
    $smarty->assign('order_amount_new', $order_amount_new);
    $smarty->assign('abs_order_amount_new', sprintf('%.2f', abs($order_amount_new)));
    

    // $refund_order_amount_new = (float) substr($order['formated_order_amount'], 3);
    // $refund_order_amount_new = $refund_order_amount_new - $refund_info_num; // 应退款金额 - 已退款金额
    // $smarty->assign('refund_order_amount_new', $refund_order_amount_new);

    // $order_receive_money = $pay_sum - $refund_info['pay_much'];
    // $smarty->assign('order_receive_money', $order_receive_money); // 订单收款金额 X


    //该订单的退换货明细
    $returns_item = getReturnItem($order['order_id']);
    $smarty->assign('returns_item', $returns_item);

    $returns_amount = 0;
    foreach ($returns_item as $v) {
        $returns_amount += ($v['increase_amount'] * $v['goods_number']);
        $returns_amount -= $v['reduce_ship_fee'] ;
        $returns_amount -= ($v['deductions'] * $v['goods_number']);
    }
    $smarty->assign('returns_amount', $returns_amount);


    /* 取得用户信息 */
    if ($order['user_id'] > 0) {
        /* 用户等级 */
        if ($user['user_rank'] > 0) {
            $where = " WHERE rank_id = '$user[user_rank]' ";
        } else {
            $where = " WHERE min_points <= " . intval($user['rank_points']) . " ORDER BY min_points DESC ";
        }
        $sql = "SELECT rank_name FROM " . $ecs->table('user_rank') . $where;
        $user['rank_name'] = $db_select->getOne($sql);

        // 用户红包数量
        $day = getdate();
        $today = local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);
        $sql = "SELECT COUNT(*) " .
                "FROM " . $ecs->table('bonus_type') . " AS bt, " . $ecs->table('user_bonus') . " AS ub " .
                "WHERE bt.type_id = ub.bonus_type_id " .
                "AND ub.user_id = '$order[user_id]' " .
                "AND ub.order_id = 0 " .
                "AND bt.use_start_date <= '$today' " .
                "AND bt.use_end_date >= '$today'";
        $user['bonus_count'] = $db_select->getOne($sql);
        $smarty->assign('user', $user);

        // 地址信息
        $sql = "SELECT * FROM " . $ecs->table('user_address') . " WHERE user_id = '$order[user_id]'";
        $smarty->assign('address_list', $db_select->getAll($sql));
    }

    /* 取得订单商品 */
    $goods_list = array();
    $goods_attr = array();

    $extr_where4print = "";

    if (isset($_GET['print'])) {
        $extr_where4print = " and (o.shipping_status =" . SS_UNSHIPPED . "  or o.shipping_status = " . SS_PREPARING . ")  ";
    }
    require_once('store_goods_sn.php');
    $sql = "SELECT o.*, g.goods_number AS storage,assign_group, g.goods_spec ,g.goods_name_ori ,o.goods_attr, IFNULL(b.brand_name, '') AS brand_name , g.goods_sn_ori " .
            "FROM " . $ecs->table('order_goods') . " AS o " .
            "LEFT JOIN " . $ecs->table('goods') . " AS g ON o.goods_id = g.goods_id " .
    		"LEFT JOIN " . $ecs->table('order_goods_extend') . " AS go ON go.rec_id = o.rec_id " .
            "LEFT JOIN " . $ecs->table('brand') . " AS b ON g.brand_id = b.brand_id " .
            "WHERE o.order_id = '$order[order_id]'" . $extr_where4print . " order by brand_name ";

    $res = $db_select->query($sql);
    $brands_list = array();
    $current_brands = array();

    $order_amount = 0;

    $brand_discount_array = array();
    $goods_sn_str = '';
    while ($row = $db_select->fetchRow($res)) {
        $goods_sn_str .= empty($goods_sn_str) ? "'{$row['goods_sn']}'" : ",'{$row['goods_sn']}'";
        $brand_discount_array_t = array();
        $brand_discount_array_t['goods_name'] = $row['goods_name'];
        $brand_discount_array_t['goods_number'] = $row['goods_number'];
        $brand_discount_array[$row['goods_id']] = $brand_discount_array_t;

        if ($current_brands["brand_name"] <> $row['brand_name']) {

            $current_brands["brand_name"] = $row['brand_name'];
            $current_brands["amount"] = $row['goods_price'] * $row['goods_number'];
            $current_brands["factory_amount"] = $row['factory_amount'] * $row['goods_number'];

            //$brands_group = array();

            $brands_list[] = $current_brands;
        } else {
            $brand_count = count($brands_list);

            $brands_list[$brand_count - 1]["amount"] = $brands_list[$brand_count - 1]["amount"] + $row['goods_price'] * $row['goods_number'];
            $brands_list[$brand_count - 1]["factory_amount"] = $brands_list[$brand_count - 1]["factory_amount"] + $row['factory_price'] * $row['goods_number'];
        }
        foreach ($goods_sn_config as $key => $val) {
            if (in_array($row['goods_sn'], $val))
                $row['goods_sn_ori'] .= '<span style="color:red">(' . ($key ? $key : '') . ' ' . '下批量库存)</span>';
        }

        /* 虚拟商品支持 */
        if ($row['is_real'] == 0) {
            /* 取得语言项 */
            $filename = ROOT_PATH . 'plugins/' . $row['extension_code'] . '/languages/common_' . $_CFG['lang'] . '.php';
            if (file_exists($filename)) {
                include_once($filename);
                if (!empty($_LANG[$row['extension_code'] . '_link'])) {
                    $row['goods_name'] = $row['goods_name'] . sprintf($_LANG[$row['extension_code'] . '_link'], $row['goods_id'], $order['order_sn']);
                }
            }
        }
        if ($row['cloth_goods_id']) {
            if (is_numeric($row['cloth_goods_id'])) {  //兼容以前的数据
                $sql = "SELECT goods_name FROM ecs_goods WHERE goods_id = " . $row['cloth_goods_id'];
                $goods_name = $db_select->getOne($sql);
                $row['cloth_goods_name'] .= '';
            } else {
                $arr_bb = explode(":", $row['cloth_goods_id']);
                $row['cloth_goods_name'] .= "布板型号:[<a href='http://image.meilele.com/" . $arr_bb[2] . "' target='_blank'>" . $arr_bb[1] . "</a>]";
            }
        }
        $row['formated_subtotal'] = price_format(($row['goods_price'] - $row['discount_amount']) * $row['goods_number'] );
        $row['formated_goods_price'] = price_format($row['goods_price']);

        $row['formated_factory_subtotal'] = price_format($row['factory_price'] * $row['goods_number']);
        $row['formated_factory_price'] = price_format($row['factory_price']);

        if ($row['plan_send_time'])
            $row['plan_send_time'] = date('Y-m-d', $row['plan_send_time']);

        if ($row['best_ship_time'])
            $row['best_ship_time'] = date('Y-m-d', $row['best_ship_time']);


        $row['formated_shipping_status'] = $_LANG['ss'][$row['shipping_status']];

        $goods_attr[] = explode(' ', trim($row['goods_attr'])); //将商品属性拆分为一个数组
        $row['subtotal'] = $row['goods_price'] * $row['goods_number'] - $row['discount_amount'];
        $goods_list[] = $row;
    }
    $smarty->assign('pay_part', PS_PAYING);
    $attr = array();
    $arr = array();
    foreach ($goods_attr AS $index => $array_val) {
        foreach ($array_val AS $value) {
            $arr = explode(':', $value); //以 : 号将属性拆开
            $attr[$index][] = @array('name' => $arr[0], 'value' => $arr[1]);
        }
    }
    $smarty->assign('goods_attr', $attr);
    //检查是否是体验馆订单
    if ($order['group_id'] > 10 && $order['group_id'] != 84)
        $expr_order_flag = 1;
    unset($arr);

    //查询订单商品的库存信息
    /*
      $wh_id_str = '';
      $wh_sql = "SELECT warehouse_id FROM `ecs_warehouse` WHERE expr_id='0'";
      $wh_res = $db->query($wh_sql);
      while(($row = $db->fetchRow($wh_res)) !==false ){
      $wh_id_str .= empty($wh_id_str) ? "'{$row['warehouse_id']}'" : ",'{$row['warehouse_id']}'";
      }
      $wh_id_str = empty($wh_id_str) ? "''" : $wh_id_str;

     *
     *  通过新方法获取应该得到的仓库ID   get_warehouse（）
     * */
    $wh_id_str = get_center_stock();

    $goods_sn_str = empty($goods_sn_str) ? "''" : $goods_sn_str;

    $goods_stock_info = array();
    $sotck_sql = "select esg.goods_sn,sum(esb.number) AS stock_number FROM `ecs_stock_goods` AS esg LEFT JOIN `ecs_stock_batch` AS esb ON esg.stock_id=esb.stock_id
            WHERE esg.goods_sn IN($goods_sn_str) AND esb.warehouse_id IN ($wh_id_str) AND esb.number>0 GROUP BY esb.stock_id";
    $stock_res = $db_select->query($sotck_sql);
    while (($row = $db_select->fetchRow($stock_res)) !== false) {
        $stock_key = trim($row['goods_sn']);
        $goods_stock_info[$stock_key] = $row['stock_number'];
    }

    $transit_ids = get_transit_stock();


    $warehouse_name_list = db_get_list("ecs_warehouse", "warehouse_id in ({$transit_ids})", "warehouse_id", "name");
    $transit_stock_info = array();
    $sotck_sql = "select esg.goods_sn,esb.warehouse_id,esb.number AS stock_number FROM `ecs_stock_goods` AS esg LEFT JOIN `ecs_stock_batch` AS esb ON esg.stock_id=esb.stock_id
            WHERE esg.goods_sn IN($goods_sn_str) AND esb.warehouse_id IN ($transit_ids) AND esb.number>0";
    $stock_res = $db_select->query($sotck_sql);
    while (($row = $db_select->fetchRow($stock_res)) !== false) {
        $stock_key = trim($row['goods_sn']);
        $transit_stock_info[$stock_key][$warehouse_name_list[$row['warehouse_id']]] += $row['stock_number'];
    }

    $plan_arrive_good_sn = array();
    foreach ($goods_list as $key => $val) {
        $arr[$key] = $val;
        $belong_to_ids = $db_select->getOne("SELECT belong_to_ids FROM ecs_expr_install WHERE order_rec_id = " . $val['rec_id']);
        $admin_install_user = '';
        if ($belong_to_ids) {
            $belong_to_ids = trim($belong_to_ids, '|');
            $tmp = $db_select->getAll("SELECT real_name FROM ecs_admin_user WHERE user_id in(" . str_replace('|', ',', $belong_to_ids) . ")");
            foreach ($tmp as $v) {
                $admin_install_user .= $v['real_name'] . '<br>';
            }
        }
        $custom_made = unserialize($val['custom_made']);
        if (is_array($custom_made)) {
            $arr[$key]['goods_custom_made'] = getCustomMade($custom_made);
        }
        $arr[$key]['admin_install_user'] = $admin_install_user;
        $arr[$key]['url'] = build_uri('goods', array('gid' => $val['goods_id']));
        $stock_key = trim($val['goods_sn']);
        if (array_key_exists($stock_key, $goods_stock_info)) {
            $arr[$key]['stock_number'] = $goods_stock_info[$stock_key];
        } else {
            if ($val['shipping_status'] == 0) {
                if (!empty($stock_key)) {
                    $plan_arrive_good_sn[] = $stock_key;
                }
            }
            $arr[$key]['stock_number'] = 0;
        }

        if (array_key_exists($stock_key, $transit_stock_info)) {
            $tmp_str = '';
            foreach ($transit_stock_info[$stock_key] as $ware_name => $ware_sum)
                $tmp_str .= $ware_name . "：" . $ware_sum . "<br/>";
            $arr[$key]['transit_stock_number'] = $tmp_str;
        } else {
            $arr[$key]['transit_stock_number'] = 0;
        }
    }

    /* 预计发货时间（需求 赵军平）
     *
     * 排除有库存的
     * 再次排除已发货，配货，取消的（只需要处理未发货的订单项）
     * 获得需要处理goods_sn数组（$plan_arrive_good_sn）以后传入get_plan_arrive_info处理方法里面
     * 进行处理
     * work by zhangjianlong 2012-7-12
     * */
    $plan_arrive_info = get_plan_arrive_info($order_id);
    $plan_arrive_goods_list = $plan_arrive_info['item_list'];
    $order_plan_end_time = $plan_arrive_info['order_plan_end_time'];
    $smarty->assign('expr_order_flag', $expr_order_flag);
    $smarty->assign('plan_arrive_goods_list', $plan_arrive_goods_list);
    $smarty->assign('order_plan_end_time', $order_plan_end_time);
    $smarty->assign('EXPR_GOODS_SEND', EXPR_GOODS_SEND);
    $smarty->assign('EXPR_GOODS_RETURN', EXPR_GOODS_RETURN);
    $smarty->assign('EXPR_GOODS_SERVERS', EXPR_GOODS_SERVERS);

    unset($goods_list);
    $goods_list = $arr;
    #print_r($goods_list);exit;
	foreach($goods_list as &$_va)
	{
		if($_va['real_goods_id'])
		{
			$tmp_goods_sn = $db->getOne("SELECT goods_sn FROM ecs_goods WHERE goods_id = ".$_va['real_goods_id']);
			$_va['goods_sn'] .= '<br>真实货号:'.$tmp_goods_sn;
		}
        $goods_extend = $db->getRow("SELECT * FROM ecs_order_goods_extend WHERE rec_id = ".$_va['rec_id']." LIMIT 1");
        $_va['goods_img'] = $goods_extend['goods_img'];
	}

    $goods_wait_num = get_wait_order_number($order_id, $goods_list);
    if($goods_wait_num)
    {
        foreach($goods_list as $k => $v)
        {
            $v['wait_number'] = $goods_wait_num[$v['goods_id']];
            $goods_list[$k] = $v;
        }
    }

    $smarty->assign('goods_list', $goods_list);
	
    /* 取得能执行的操作列表 */
    $operable_list = operable_list($order);
    $smarty->assign('operable_list', $operable_list);
	
	//获得是否是特卖订单
	
    /* 展示编辑页面 */
    $is_edit = 1;
    
	$_id_ = $db_select->getOne("SELECT id FROM ecs_order_extend WHERE order_id = $order_id AND trans_type = 4");
	if($_id_){
		$is_edit = 0;
	}
	
    if ($order['order_type'] == 'expr_order') {
        $assigner_id = $db_select->getALL("SELECT user_id FROM `ecs_admin_user` WHERE group_id = {$order['group_id']} and job_type = '财务助理'");
        $saleman_not_do = $db_select->getOne("SELECT code FROM meilele_group where group_id = {$admin_info['group_id']}");
        if ($saleman_not_do == 'is_salesman') {
            $is_edit = 0;
        }
    }
    
    if($order['order_type'] == 'haier_order'){
    	$is_edit = 0;
    }
    
    $user_group_id = $db->getOne("SELECT group_id from ecs_admin_user where user_id = {$_SESSION['admin_id']}");
    if($user_group_id == 67)
		$check_goods = $db->getOne("SELECT 1 from ecs_order_goods where order_id = {$order_id} and goods_type in(10,9) and shipping_status != 5");
    else
		$check_goods = $db->getOne("SELECT 1 from ecs_order_goods where order_id = {$order_id} and goods_type in(10,9,8) and shipping_status != 5");
	
	if($check_goods){
    	
    	$is_edit = 0;
    }
	/*服务费订单 朱丹需求不能编辑*/
    $check_third = $db->getOne('SELECT trans_type FROM ecs_order_extend WHERE 1 AND shop_id > 1 AND order_id=' . $order_id);
    
    // 第三方订单不能编辑商品
    $check_third = $db->getOne('SELECT 1 FROM ecs_order_extend WHERE 1 AND shop_id > 1 AND order_id=' . $order_id);
    if($check_third == 1)
        $is_edit = 0;
    
    /* 展示编辑页面 */
    $smarty->assign('is_edit',$is_edit);
    /* 取得订单操作记录 */
    $act_list = array();
    //取得支付记录
    $sql = "SELECT * FROM " . $ecs->table('pay_record') . " WHERE order_id=$order_id";
    $res = $db_select->getAll($sql);
    if (count($res) >= 1) {
        if (count($res) == 1 && $order['pay_status'] != PS_PAYING) {
            $flag = 1;
        } else {
            foreach ($res as $key => $row) {
                $tmp[$key]['order_status'] = $_LANG['os'][1];
                $tmp[$key]['pay_status'] = $_LANG['ps'][1];
                $tmp[$key]['shipping_status'] = $_LANG['ss'][0];
                $tmp[$key]['action_time'] = date('Y-m-d H:i:s', $row['pay_date']);
                $tmp[$key]['action_note'] = '付款' . $row['pay_money'] . '元';
                if ($row['pay_type'] == 1)
                    $tmp[$key]['action_note'] .= ',支付宝交易号' . $row['trade_no'];
                $tmp[$key]['action_user'] = '买家';
            }
            $act_list = $tmp;
            unset($tmp);
        }
    }
    $sql = "SELECT * FROM " . $ecs->table('order_action') . " WHERE order_id = '$order[order_id]' ORDER BY log_time DESC";
    $res = $db_select->query($sql);
    while ($row = $db_select->fetchRow($res)) {
        $row['order_status'] = $_LANG['os'][$row['order_status']];
        $row['pay_status'] = $_LANG['ps'][$row['pay_status']];
        $row['shipping_status'] = $_LANG['ss'][$row['shipping_status']];
        $row['action_time'] = date($_CFG['time_format'], $row['log_time']);
        $act_list[] = $row;
    }
    $tmp = array_sortbykey($act_list, 'action_time', 'asc');
    unset($act_list);
    $act_list = $tmp;
    unset($tmp);
    $smarty->assign('action_list', $act_list);

    $order_receive = get_order_receive($order['order_id']);
    $smarty->assign('order_receive', $order_receive);

    /* 取得是否存在实体商品 */
    $smarty->assign('exist_real_goods', exist_real_goods($order['order_id']));

    $smarty->assign('SS_UNSHIPPED', SS_UNSHIPPED);
    $smarty->assign('SS_SHIPPED', SS_SHIPPED);
    $smarty->assign('SS_CANCEL', SS_CANCEL);

    //取得订单是否特殊审核
    $special_sql = "SELECT special_id FROM `ecs_special_order` WHERE order_id='{$order[order_id]}' AND status='confirm'";
    $special_status = $db_select->getOne($special_sql);
    $smarty->assign('special_status', $special_status);
    // 财务查账列表
    $smarty->assign('audit_list', order_audit_list($order_id));
    $is_salesman = $db_select->getOne(" SELECT DISTINCT g.group_leader_id from meilele_group g  WHERE  g.code='is_salesman' and g.group_leader_id = " . $_SESSION['admin_id']);
    $smarty->assign('is_salesman', $is_salesman);
    if ($order['admin_id']) {
        $admin_id = explode('|', $order['admin_id']);
        foreach ($admin_id as $a) {
            if ($a) {
                $real_name = $db_select->getOne("SELECT real_name FROM ecs_admin_user WHERE user_id = " . $a);
                $admin_name .= '|' . $real_name;
            }
        }
        $smarty->assign('admin_name', trim($admin_name, '|'));
    }
    /* 是否打印订单，分别赋值 */
    if (isset($_GET['print'])) {

        $smarty->assign("brands_list", $brands_list);
        $smarty->assign('shop_name', $_CFG['shop_name']);
        $smarty->assign('shop_url', $ecs->url());
        $smarty->assign('shop_address', $_CFG['shop_address']);
        $smarty->assign('service_phone', $_CFG['service_phone']);
        $smarty->assign('print_time', date($_CFG['time_format']));
        $smarty->assign('action_user', $_SESSION['admin_name']);

        $smarty->template_dir = '../data';

        if (isset($_GET['deliver'])) {

            $smarty->display('deliver_bill_print.html');
        } else {
            $smarty->display('order_print.html');
        }
    } else {
        /* 模板赋值 */
        $smarty->assign('ur_here', $_LANG['order_info']);
        $smarty->assign('action_link', array('href' => 'order.php?act=list&' . list_link_postfix(), 'text' => $_LANG['02_order_list']));


        //查看商品成本权限 王宜东 2012-08-31
        if (admin_priv('view_factory_price', '', false)) {
            //if(admin_priv('view_factory_price')){
            $href = $_SERVER['REQUEST_URI'];
            if (strstr($href, '&view_factory_price')) {
                $tmp = explode('&view_factory_price', $href);
                $href = $tmp[0];
                unset($tmp);
            } else {
                $href.='&view_factory_price';
            }
            $smarty->assign('action_link2', array('href' => $href, 'text' => '查看订单详情'));
            $view_factory_price = false;
            if (isset($_REQUEST['view_factory_price'])) {
                $view_factory_price = true;
            }
            $smarty->assign('view_factory_price', $view_factory_price);
        }
        if(!empty($order['district']))
            $thing_pinfodis = $order['district']; 
        else
            $thing_pinfodis = $order['city'];
        $thing_pinfo = getservicePriceInfo($order['order_id'], $thing_pinfodis, $goods_list);
        $thing_bulk = $thing_pinfo['thing_bulk'];
        $thing_weight = $thing_pinfo['thing_weight'];
        $bulk_unitprice = $thing_pinfo['bulk_unitprice'];
        $weight_unitprice = $thing_pinfo['weight_unitprice'];

        $transtype = get_trans_type($order['order_id']);
        $smarty->assign('transtype', $transtype);//物流体积
        if($transtype == 3 )
        {
            $service_scale = getServiceScale($order['need_return_order'], $order['order_id']);    
            $smarty->assign('service_scale', $service_scale['percent']); //服务费比例
        }

        if($thing_weight != 0)
        {
            $service_deliver = get_deliver_fee($order['province'],$thing_weight);
            $smarty->assign('service_deliver', $service_deliver); //快递收费
        }

        $smarty->assign('thing_bulk', $thing_bulk);//物流体积
        $smarty->assign('thing_weight', $thing_weight);//物流重量
        $smarty->assign('bulk_unitprice', $bulk_unitprice);//物流体积单价
        $smarty->assign('weight_unitprice', $weight_unitprice);//物流重量单价
        
        $activity_con = $GLOBALS['db']->getRow('SELECT b.subject,b.link_url FROM ecs_order_extend a JOIN ecs_activity_rule b on a.activity_id = b.id where a.order_id=' . $order['order_id']);
        $smarty->assign('activity_con', $activity_con);//参与活动信息
        
        if($order['group_id'] == '1' || $order['group_id'] == '94')
        {
            $smarty->assign('showexprtransport', 1);//显示体验馆物流状态
            $smarty->assign('exprtransport', $order_extend['expr_transport']);//体验馆物流状态
        }

        //抽奖状态更新
        $prize_info = get_order_prizeinfo($order['order_id']);
        if ($prize_info) {
            $smarty->assign('prize_info', $prize_info);
        }

        // 完成订单亦可编辑
        if(in_array($order['shipping_status'], array(1,2)) && admin_priv("end_order_uname", '' , false)) //当运送状态为已发货或收货
            $smarty->assign('end_order_uname', 1);

        /* 显示模板 */
        assign_query_info();
        if ($_REQUEST['type'] == 'detail') {
            $smarty->display('order_detail_info.htm');
        } else {
            $smarty->display('order_info.htm');
        }
    }
}
//显示单个发货单下的商品
elseif ($_REQUEST['act'] == 'get_invoice_info') {
    $invoice_id = intval($_REQUEST['invoice_id']);
    $invoice_info_detail = stock_invoice_detail($invoice_id);
    $smarty->assign('invoice_info_detail', $invoice_info_detail);
    $data = array(
        'error' => '0',
        'message' => '',
        'content' => array(
            '0' => array(
                'order_id' => $invoice_id,
                'str' => $smarty->fetch('order_get_invoice_info.htm'),
            )
        )
    );
    die(json_encode($data));
}
//王宜东 -》 杨志勇
elseif ($_REQUEST['act'] == 'update_vehicle_fstatus') {
    $message = "未执行操作,请稍后再试!";
    $order_id = $_GET['order_id'];
    $vehicle_fstatus = $db->getOne("SELECT `vehicle_fstatus` FROM  `ecs_order_extend` WHERE `order_id`='" . $_GET['order_id'] . "'");
    $sql = '';
    if ($vehicle_fstatus) {
        if (in_array($_GET['vehicle_fstatus'], array('yes', 'no'))) {
            $sql = "UPDATE `ecs_order_extend` SET `vehicle_fstatus`='" . $_GET['vehicle_fstatus'] . "' WHERE `order_id`='" . $_GET['order_id'] . "'";
        }
    } else {
        $sql = "INSERT INTO `ecs_order_extend` SET `activity_id`='0',`custom_district`='0',`vehicle_fstatus`='" . $_GET['vehicle_fstatus'] . "',`order_id`='" . $_GET['order_id'] . "'";
    }


    if ($sql) {
        $db->query($sql);
        if ($db->affected_rows()) {
            $message = "修改成功!";
        } else {
            $message = "操作失败,请稍后再试!!";
        }
    }
	$detail = $db->getRow("SELECT order_status,pay_status,shipping_status from ecs_order_info where order_id = {$order_id}");
    $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $detail['order_status'] . "','" . $detail['shipping_status'] . "','" . $detail['pay_status'] . "','" . time() . "','整车预备货是否优先改为{$_GET['vehicle_fstatus']}','" . time() . "')";
    $db->query($sql);

    $data = array(
        'error' => '0',
        'message' => $message,
    );
    die(json_encode($data));
}
//改为未付运费
else if ($_REQUEST['act'] == 'nopaytmoney') {
    $order_id = $_REQUEST['order_id'];
    $db->query('UPDATE ecs_order_extend SET ship_pay_status=0 WHERE order_id = ' . $order_id);
    $notes = $_SESSION['admin_name'] . '将订单设置为未付运费.';
    order_log_sqlinnote($order_id, $notes);
    header("Location:/admin/order.php?act=info&order_id=" . $order_id);
} else if($_REQUEST['act'] == 'update_exprtransport') {
    admin_priv('order_view');

    $exprtransport_value = $_REQUEST['exprtransport_value'];
    $order_id = $_REQUEST['order_id'];
    $GLOBALS['db']->query("UPDATE ecs_order_extend SET expr_transport=$exprtransport_value WHERE order_id=" . $order_id);
    //写日志
    if($exprtransport_value == '1')
        $addnote = '体验馆自提';
    elseif($exprtransport_value == '2')
        $addnote = '体验馆中转';

    $note = $_SESSION['admin_name'] . '改变提货方式为' . $addnote;

    order_log_sqlinnote($order_id, $note);
    die(json_encode(array('error'=>'0', 'message'=>'修改为'. $addnote .'成功!')));
}

/* ------------------------------------------------------ */
//-- 发货单列表
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'delivery_list') {
    /* 检查权限 */
    admin_priv('order_view');
    $expr = !empty($_REQUEST['expr']) && is_numeric($_REQUEST['expr']) ? $_REQUEST['expr'] : 0;
    if ($expr > -2) {
        $sql = "SELECT expr_id,expr_name FROM `ecs_expr_nature`";
        $expr_list = array();
        $res = $db->query($sql);
        while ($row = $db->fetchRow($res)) {
            $expr_list[$row['expr_id']] = $row['expr_name'];
        }
        $smarty->assign('expr', $expr);
        $smarty->assign('expr_list', $expr_list);
    }

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['02_order_list']);
    $smarty->assign('action_link', array('href' => 'order.php?act=order_query', 'text' => $_LANG['03_order_query']));

    $smarty->assign('status_list', $_LANG['cs']);   // 订单状态

    $smarty->assign('os_unconfirmed', OS_UNCONFIRMED);
    $smarty->assign('cs_await_pay', CS_AWAIT_PAY);
    $smarty->assign('cs_await_ship', CS_AWAIT_SHIP);
    $smarty->assign('CS_SERV', CS_SERV);
    $smarty->assign('CS_SHIIPED_NO_REC', CS_SHIIPED_NO_REC);


    $smarty->assign('SS_UNSHIPPED', SS_UNSHIPPED);
    $smarty->assign('SS_PART_SHIPPED', SS_PART_SHIPPED);
    $smarty->assign('SS_RECEIVED', SS_RECEIVED);
    $smarty->assign('OS_AFTER_SRV', OS_AFTER_SRV);
    $smarty->assign('SS_PREPARING', SS_PREPARING);



    $smarty->assign('CS_AUDIT_NEW', CS_AUDIT_NEW);
    $smarty->assign('CS_AUDIT_AUDIT', CS_AUDIT_AUDIT);
    $smarty->assign('CS_AUDIT_REJECT', CS_AUDIT_REJECT);

    $smarty->assign('full_page', 1);



    $smarty->assign('assign_status', array('no' => "未分配", 'assigned' => '已分配'));   // 订单状态
    $smarty->assign('mech_list', array('yangyuhong' => "杨雨红", 'qinfengzeng' => 'qinfengzeng'));   // 订单状态，暂时写死，待admin_user的group_id功能好了后，改过来。 zhoubo 2011.3.26

    $_REQUEST['composite_status'] = 101;
    $order_list = order_delivery_list();
    $smarty->assign('order_list', $order_list['orders']);
    $smarty->assign('filter', $order_list['filter']);
    $smarty->assign('record_count', $order_list['record_count']);
    $smarty->assign('page_count', $order_list['page_count']);
    $smarty->assign('sort_order_time', '<img src="images/sort_desc.gif">');
    $smarty->assign('pay_part', PS_PAYING);

    /* 显示模板 */
    assign_query_info();
    $smarty->display('order_delivery_list.htm');
}
/* ------------------------------------------------------ */
//-- 修改订单（处理提交）
/* ------------------------------------------------------ */ 
elseif ($_REQUEST['act'] == 'step_post') {
    $order_id = isset($_REQUEST['order_id']) ? intval($_REQUEST['order_id']) : 0;

    /* 检查权限  只是当不是补件单的时候*/
    // if(!empty($order_id))
    //     $nocheck = $db->getOne('SELECT order_type FROM ecs_order_info WHERE order_id=' . $order_id);
    // if($nocheck != 'patch_order')
        admin_priv('order_edit');
    // else
    //     die('nochack');
    // die('chack');

    /* 取得参数 step */
    $step_list = array('user', 'edit_goods', 'add_goods', 'goods', 'consignee', 'shipping', 'payment', 'other', 'money', 'invoice', 'set_order_send_time', 'set_need_ship_time', 'end_order_uname');
    $step = isset($_REQUEST['step']) && in_array($_REQUEST['step'], $step_list) ? $_REQUEST['step'] : 'user';

    /* 取得参数 order_id */
    if ($order_id > 0) {
        $old_order = order_info($order_id);
    }

    /* 取得参数 step_act 添加还是编辑 */
    $step_act = isset($_REQUEST['step_act']) ? $_REQUEST['step_act'] : 'add';

    /* 插入订单信息 */
    if ('user' == $step) {
        /* 取得参数：user_id */
        $user_id = ($_POST['anonymous'] == 1) ? 0 : intval($_POST['user']);

        /* 插入新订单，状态为无效 */
        $order = array(
            'user_id' => $user_id,
            'add_time' => time(),
            'order_status' => OS_INVALID,
            'shipping_status' => SS_UNSHIPPED,
            'pay_status' => PS_UNPAYED,
            'from_ad' => 0,
            'referer' => $_LANG['admin']
        );

        do {
            $order['order_sn'] = get_order_sn();
            if ($db->autoExecute($ecs->table('order_info'), $order, 'INSERT', '', 'SILENT')) {
                break;
            } else {
                if ($db->errno() != 1062) {
                    die($db->error());
                }
            }
        } while (true); // 防止订单号重复

        $order_id = $db->insert_id();

        /* todo 记录日志 */
        admin_log($order['order_sn'], 'add', 'order');

        /* 插入 pay_log */
        $sql = 'INSERT INTO ' . $ecs->table('pay_log') . " (order_id, order_amount, order_type, is_paid)" .
                " VALUES ('$order_id', 0, '" . PAY_ORDER . "', 0)";
        $db->query($sql);

        /* 下一步 */
        header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=goods\n");
        exit;
    }
    elseif('end_order_uname' == $step) {
        admin_priv("end_order_uname");
        if(!empty($_POST['consignee']))
        {
            $user_addr = $GLOBALS['db']->getOne('SELECT consignee FROM ecs_order_info WHERE order_id=' . $order_id);
            $data['consignee'] = trim($_POST['consignee']);
            if($user_addr != $data['consignee'])
            {
                update_order($order_id, $data);
                order_log_sqlinnote($order_id, "$_SESSION[admin_name]将订单[ID:$order_id]的收货人由{$user_addr}修改为{$data['consignee']}.");
            }
        }
        $links[0]['text'] = $GLOBALS['_LANG']['go_back'];
        $links[0]['href'] = 'order.php?act=info&order_id=' . $order_id;
        sys_msg("修改收货人信息成功!", 1, $links);
    }
    /* 编辑商品信息 */ elseif ('edit_goods' == $step) {
        check_group($order_id);
        $sql = "SELECT * FROM ecs_order_info WHERE order_id = $order_id";
        $detail = $db->getRow($sql);    //获得订单信息
        if (isset($_POST['rec_id'])) {
            $result = get_check_brand(implode(',', $_POST['rec_id']));
            $deny_rec_id = array();
            if (!empty($result)) {
                $name_list = array();
                foreach ($result as $v) {
                    $deny_rec_id[] = $v['rec_id'];
                    $name_list[$v['rec_id']] = $v['goods_name'];
                }
                $sql = "SELECT group_id FROM
	        	 `ecs_admin_user` where user_id = '{$_SESSION['admin_id']}'";
                $group_id = $db->getOne($sql);
            }
            foreach ($_POST['rec_id'] AS $key => $rec_id) {
                if (in_array($rec_id, $deny_rec_id)) {
                    // 48跟单组 8 售后
                    if ($group_id != 48) {
                        sys_msg("由于此品牌为定制商品({$name_list[$rec_id]})，请联系相应跟单更改订单，谢谢！");
                    }
                }

                //$invoice_id = $db->getRow("SELECT esii.invoice_id FROM ecs_stock_invoice_goods esig JOIN ecs_stock_invoice_info esii ON esii.invoice_id = esig.invoice_id WHERE esig.order_rec_id = $rec_id AND esii.fstatus != 'cancel' AND esii.fstatus != 'merged' ORDER BY invoice_id DESC limit 1");
                if (checkInvoiceBill($order_id, $rec_id))
                //if($invoice_id)
                    continue;
                /* 取得参数 */
                $goods_price = floatval($_POST['goods_price'][$key]);
                $goods_number = intval($_POST['goods_number'][$key]);
                $old_goods_number = intval($_POST['old_goods_number_' . $key]);
                if ($goods_number == 0)
                    sys_msg('不能修改商品数量为0!');

                $cloth_goods_id = $_POST['cloth_goods_id'][$key];
                $goods_attr = $_POST['goods_attr'][$key];
                unset($row, $where);
                $sql = "SELECT goods_number,goods_sn,discount_amount,order_item_seq_id,goods_attr,goods_type,goods_id,cloth_goods_id,shipping_status FROM ecs_order_goods WHERE rec_id = $rec_id";
                $row = $db->getRow($sql);
                if ($row['shipping_status'] == 5)
                    sys_msg('不能对取消了的商品进行操作!');
                    
                if(($row['goods_type'] == 9 || $row['goods_type'] == 1) && $goods_number != $row['goods_number'])
                	sys_msg('不能对赠品数量进行编辑操作!');
                //限购
                $sale_limit = $db->getRow("SELECT goods_id,limit_sale,goods_number FROM ecs_goods WHERE goods_id = " . $row['goods_id'] . " AND limit_sale in (1,2)");
                if ($sale_limit) {
                    $_limit = getGoodsStockInfoLimit($row['goods_id'], $sale_limit['limit_sale']);
                    if ($sale_limit['limit_sale'] == 2) {
                        if ($goods_number > $old_goods_number) {
                            $number = $goods_number - $old_goods_number;
                            $_action = 'sub';
                            //$sql = " UPDATE ".$ecs->table('goods')." SET goods_number=goods_number-".$number." where goods_id = ".$row['goods_id'];
                        } else {
                            $number = $old_goods_number - $goods_number;
                            $_action = 'add';
                            //$sql = " UPDATE ".$ecs->table('goods')." SET goods_number=goods_number+".$number." where goods_id = ".$row['goods_id'];
                        }
                        //限购商品功能
                        updateLimitSale($row['goods_id'], $number, $_action);
                        //$db->query($sql);
                        if ($_limit['stock_number'] + $row['goods_number'] - $goods_number < 0)
                            sys_msg($row['goods_sn'] . "此商品是人工限购商品，已经超出限购数。库存:{$_limit['stock_number']}");
                    }else {
                        if ($_limit['stock_number'] - $_limit['order_number'] + $row['goods_number'] - $goods_number < 0)
                            sys_msg($row['goods_sn'] . "此商品是系统限购商品，已经超出限购。库存:{$_limit['stock_number']} 已下单:{$_limit['order_number']}");
                    }
                }
                //ERP同步需要的数据
                $_orderItemRow[] = array('orderItemSeqId' => (String) $row['order_item_seq_id'], 'quantity' => (String) $goods_number);
                if ($row['goods_number'] != $goods_number)
                    $where = "管理员修改了商品" . $row['goods_sn'] . "的数量从" . $row['goods_number'] . "到" . $goods_number;
                else if ($row['goods_attr'] != $goods_attr)
                    $where = "管理员修改了商品" . $row['goods_sn'] . "的属性,从" . $row['goods_attr'] . "到" . $goods_attr;
                else if ($row['cloth_goods_id'] != $cloth_goods_id)
                    $where = "管理员修改了商品" . $row['cloth_goods_id'] . "的布板,从" . $row['cloth_goods_id'] . "到" . $cloth_goods_id;
                else if ($row['goods_number'] != $goods_number && $row['goods_attr'] != $goods_attr && $row['cloth_goods_id'] != $cloth_goods_id)
                    $where = "管理员修改了商品" . $row['goods_sn'] . "的属性,从" . $row['goods_attr'] . "到" . $goods_attr . ",数量从" . $row['goods_number'] . "到" . $goods_number . ",布板从" . $row['cloth_goods_id'] . "到" . $cloth_goods_id;
                if ($where) {
                    $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $detail['order_status'] . "','" . $detail['shipping_status'] . "','" . $detail['pay_status'] . "','" . time() . "','$where','" . time() . "')";
                    $db->query($sql);
                }
                /* 修改 */
                if($row['discount_amount'] && $row['discount_amount'] != 0.00){
                	$dis_amount = ($goods_number - $row['goods_number']) * $row['discount_amount'];
                	$db->query("UPDATE ecs_order_info SET discount = discount + {$dis_amount} where order_id = $order_id");
                    $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $detail['order_status'] . "','" . $detail['shipping_status'] . "','" . $detail['pay_status'] . "','" . time() . "','编辑返现商品折扣增加订单{$dis_amount}','" . time() . "')";
                    $db->query($sql);
                }
                $sql = "UPDATE " . $ecs->table('order_goods') .
                        " SET goods_price = '$goods_price', " .
                        "goods_number = '$goods_number', " .
                        "goods_attr = '$goods_attr', " .
                        "cloth_goods_id = '$cloth_goods_id' " .
                        "WHERE rec_id = '$rec_id' LIMIT 1";

                $db->query($sql);
                //限购商品功能
                //updateLimitSale($row['goods_id'],$goods_limit_num,'sub');
            }
            /* 更新商品总金额和订单总金额 */
            $goods_amount = updateOrderAmount($order_id);
            $order_type = $db->getOne("SELECT order_type FROM ecs_order_info WHERE order_id = $order_id LIMIT 1");
            if ($order_type != 'patch_order') {
                modifyOrderPayStatus($order_id);
            }
            
            // update_order($order_id, array('goods_amount' => $goods_amount));
            //update_order_amount($order_id);
            //修改订单数量，同步到ERP
            if (ERP_FLAG == 1) {
                $_erp_data = $db->getRow("SELECT goods_amount,discount,already_pay,bonus,shipping_fee FROM ecs_order_info WHERE order_id = $order_id");
                $_erp_item['class'] = 'com.meilele.crmsfa.order.vo.UpdateOrderItemQuantityVO';
                $_erp_item['orderId'] = (String) $order_id;
                $_erp_item['grandTotal'] = (String) $_erp_data['goods_amount'];
                $_erp_item['remainingSubTotal'] = (String) ($_erp_data['goods_amount'] - $_erp_data['already_pay'] - $_erp_data['bonus'] - $_erp_data['discount'] + $_erp_data['shipping_fee']);
                $_erp_item['orderItems'] = $_orderItemRow;
                http_request('wsUpdateOrderItemQuantity', $_erp_item, array('user_name' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
            }

            //setOrderPayStatus($_REQUEST['order_id']);
        }
        //更新红包状态,若更改数量或取消商品,红包应重新计算
        check_unset_bonus($order_id);
        /* 跳回订单商品 */
        if ($_REQUEST['type'] == 1) {//快速下单 
            if ($_POST['patch']) {
                header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=patch_goods&type=1\n");
            } else {
                header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=goods&type=1\n");
            }
        } else {
            if ($_POST['patch']) {
            	touch_activity($order_id,1);
            } else {
            	touch_activity($order_id);
            }
        }
        exit;
    }
    /* 添加商品 */
    elseif ('add_goods' == $step) {
        check_group($order_id);
        /* 取得参数 */

		if($_POST['patch'] == 1)
		{	
            	
			$patch_type	   = $_POST['patch_type'];	
			if($patch_type == 1 && $_POST['son_goods_id'])	//是部件且有对应的商品
			{
				$goods_id = $_POST['son_goods_id'];	
				if (!$goods_id) {
					sys_msg("不存在的商品");
				}
				$patch_note    = $_POST['patch_note'];	
				$supplier = $db->getAll("SELECT supplier_sn FROM ecs_supplier_purchase WHERE goods_id = $goods_id");		
			}
			elseif ($patch_type == 2) {
				$goods_id = $_POST['goodslist'];
				if (!$goods_id) {
					sys_msg("不存在的商品");
				}
				$patch_note    = $_POST['patch_note'];
				$supplier = $db->getAll("SELECT supplier_sn FROM ecs_supplier_purchase WHERE goods_id = $goods_id");
			}
			else
			{
				$id_arr = array(14902, 14690, 31209,31210,31211,31212,31213,31214,31215,31216,31217,31218,31219,31221,31222);
				$goodslist = $db->getAll("SELECT goods_id FROM ecs_order_goods WHERE order_id = $order_id");
				$tmp = array();
				foreach ($goodslist as $key => $value) {
					$tmp[] = $value['goods_id'];
				}
				foreach ($id_arr as $key => $value) {
					$goods_id = $value;
					if (!in_array($value,$tmp)) {
						break;
					}
				}
				$real_goods_id = (int)$_POST['goodslist'];
				$supplier = $db->getAll("SELECT supplier_sn FROM ecs_supplier_purchase WHERE goods_id = $real_goods_id");
				$patch_note    = $_POST['patch_note'];
			}	
			$goods_price =0;
			//补件单工厂限制判断
			$order_supplier_sn = $db->getOne("SELECT supplier_sn FROM ecs_order_extend WHERE order_id = $order_id LIMIT 1");
			if ($order_supplier_sn) {
				
				$flag = false;

				foreach ($supplier as $key => $value) {
					if ($order_supplier_sn == $value['supplier_sn']) {
						$flag = true;
					}
				}
				if (!$flag && !$_POST['goods_search']) {
					sys_msg("订单归属的工厂不可选择该商品");
				}
			}
		
		}
		else
		{
			$goods_id = intval($_POST['goodslist']);
			$goods_price = $_POST['add_price'] != 'user_input' ? floatval($_POST['add_price']) : floatval($_POST['input_price']);
		}
        if (!$goods_id) {
            sys_msg("不存在的商品");
        }
        
        $shipping_status = $db->getOne("SELECT shipping_status from ecs_order_info where order_id = $order_id");
        if($shipping_status == 1){
        	die("已发货订单无法修改任何操作 ");
        }
        $factory_price = $db->getOne("SELECT factory_price FROM ecs_goods WHERE goods_id=$goods_id");
        // var_dump($factory_price);
        // die(debugger);

        $goods_attr = '0';
        for ($i = 0; $i < $_POST['spec_count']; $i++) {
            $goods_attr .= ',' . $_POST['spec_' . $i];
        }
        $goods_number = intval($_POST['add_number']);

        /* 取得属性 */
        $attr_list = array();
        if ($goods_attr != '') {
            $sql = "SELECT a.attr_name, g.attr_value,g.goods_attr_id,g.attr_id, g.attr_price,g.sub_goods_sn " .
                    "FROM " . $ecs->table('goods_attr') . " AS g, " .
                    $ecs->table('attribute') . " AS a " .
                    "WHERE g.attr_id = a.attr_id " .
                    "AND g.goods_attr_id " . db_create_in($goods_attr) . " ORDER BY g.attr_id ASC";
            $res = $db->getAll($sql);

            foreach ($res as $row) {
                $attr = $row['attr_name'] . ': ' . $row['attr_value'];
                $attr_price = floatval($row['attr_price']);
                if ($attr_price > 0) {
                    $attr .= ' [+' . $attr_price . ']';
                } elseif ($attr_price < 0) {
                    $attr .= ' [-' . abs($attr_price) . ']';
                }
                $attr_list[] = $attr;

                /* 更新价格 */
                $goods_price += $attr_price;
            }
        }
        if ($goods_price < 1 && $_POST['patch'] != 1)
            sys_msg('系统发生错误!');
        $attr_list = addslashes_deep($attr_list);
        $order_item_seq_id = $db->getOne("SELECT max(order_item_seq_id+0) FROM ecs_order_goods WHERE order_id = $order_id");
        $order_item_seq_id = $order_item_seq_id + 1;

        $goods_sn = $db->getRow("SELECT goods_sn,limit_sale FROM ecs_goods WHERE goods_id = $goods_id AND limit_sale in (1,2)");
        if ($goods_sn) {
            $_g_num = getGoodsStockInfoLimit($goods_id, $goods_sn['limit_sale']);
            if ($goods_sn['limit_sale'] == 2) {
                if ($_g_num['stock_number'] - $goods_number < 0) {
                    sys_msg($goods_sn['goods_sn'] . "此商品是人工限购商品，已经超出限购剩余数。库存:{$_g_num['stock_number']}");
                } else {
                    //$sql = " UPDATE ".$ecs->table('goods')." SET goods_number=goods_number-".$goods_number." where goods_id = ".$goods_id;
                    //$db->query($sql);
                    updateLimitSale($goods_id, $goods_number, 'sub');
                }
            } else if ($goods_sn['limit_sale'] == 1) {
                if ($_g_num['stock_number'] - $_g_num['order_number'] - $goods_number < 0)
                    sys_msg($goods_sn['goods_sn'] . "此商品是系统限购商品，已经超出限购剩余数。库存:{$_g_num['stock_number']} 已下单:{$_g_num['order_number']}");
            }
        }
        $free_goods = $_REQUEST['free_goods'];

        if ($free_goods == 1) { //赠品 
            $goods_type = add_gift($order_id, $goods_id,$goods_number);
            $goods_price = 0;
            $free_goods_str = '[设置此商品为赠品，价格自动计0]';
            $is_gift = 0;
        } else {
            $_price_type = getGoodsPrice_type($goods_id);
            if ($_price_type['action'] == '包物流')
                $goods_type = 5;
            else if ($_price_type['action'] == '包快递')
                $goods_type = 6;
            else if ($_price_type['discount_price'] > 0)
                $goods_type = 7;
            else if ($_price_type['action'] == '促销')
                $goods_type = 2;
            else if ($_price_type['action'] == '特价')
                $goods_type = 3;
            else if ($_price_type['action'] == '限购')
                $goods_type = 4;
            else
                $goods_type = 0;
            $free_goods = 0;
            $free_goods_str = '';
            $is_gift = 0;
        }
        $plan_send_time = $_POST['plan_send_time'] ? strtotime($_POST['plan_send_time']) : '';
		/* 插入订单gift商品 */
        $sql = "INSERT INTO " . $ecs->table('order_goods') .
                " (order_id, goods_id, goods_name, goods_sn, " .
                "goods_number, market_price,discount_amount, goods_price, factory_price, goods_attr, " .
                "is_real, extension_code, parent_id, is_gift,brand_id,order_item_seq_id,goods_type,og_add_time,plan_send_time,real_goods_id, patch_note, patch_type)" .
                "SELECT '$order_id', goods_id, goods_name, goods_sn, " .
                "'$goods_number', market_price,discount_price, '$goods_price', '$factory_price', '" . join("\r\n", $attr_list) . "', " .
                "is_real, extension_code, 0, $is_gift,brand_id,$order_item_seq_id,$goods_type ," . time() . ", '{$plan_send_time}'," .
                "'{$real_goods_id}','{$patch_note}','{$patch_type}'".
				" FROM " . $ecs->table('goods') .
                " WHERE goods_id = '$goods_id' LIMIT 1";
        $db->query($sql); 
        $rec_id = $db->insert_id();
        if ($_FILES['goods_img']) {
            $image = new cls_image();
            $image->images_dir = 'images';
            $ext = get_extend($_FILES['goods_img']['name']);
            $_FILES['goods_img']['type'] = "image/$ext";
            $image_name = $image->upload_image($_FILES['goods_img']);
            $goods_img = $image_name;
            $order_id = $_GET['order_id'];
            if ($db->getRow("SELECT id FROM ecs_order_goods_extend WHERE rec_id = $rec_id LIMIT 1")) {
                $db->query("UPDATE ecs_order_goods_extend SET goods_img = '".$goods_img."' WHERE rec_id = $rec_id");
            } else {
                $db->query("INSERT INTO ecs_order_goods_extend (rec_id, order_id, goods_id, goods_img) VALUES ($rec_id, $order_id, $goods_id, '".$goods_img."')");
            }
        }
        $_goods_amount = $db->getOne("SELECT discount_price * {$goods_number} from `ecs_goods` where goods_id = {$goods_id}");
        $db->query("UPDATE `ecs_order_info` SET `discount` =  discount + ($_goods_amount) where order_id = {$order_id}");
        $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $detail['order_status'] . "','" . $detail['shipping_status'] . "','" . $detail['pay_status'] . "','" . time() . "','添加返现商品折扣增加订单{$_goods_amount}','" . time() . "')";
		$db->query($sql);
		/* 2012-5-31 以前编辑添加没有折现 没有才分 现在添加上 先加商品折扣再拆分 */
        $erp_data = splitGoods($order_id, $goods_id, $goods_number, $rec_id);
        //exit;
        /* 更新商品总金额和订单总金额 */
        $goods_amount = updateOrderAmount($order_id);
        $order_type = $db->getOne("SELECT order_type FROM ecs_order_info WHERE order_id = $order_id LIMIT 1");
            if ($order_type != 'patch_order') {
                modifyOrderPayStatus($order_id);
            }
        //updateLimitSale($goods_id,$goods_number,'sub');

        $goods_sn = $db->getOne("SELECT goods_sn FROM ecs_goods WHERE goods_id = $goods_id");
        $row = $db->getRow("SELECT * FROM ecs_order_info WHERE order_id = $order_id");
        $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . (time() + 2) . "','新增商品:" . $goods_sn . $free_goods_str . "','" . (time() + 2) . "')";
        $db->query($sql);

        //update_order($order_id, array('goods_amount' => $goods_amount));
        //update_order_amount($order_id);
        //同步数据到ERP
        if (ERP_FLAG == 1) {
            $_erp_data = $db->getRow("SELECT goods_amount,shipping_fee,discount,already_pay,bonus FROM ecs_order_info WHERE order_id = $order_id");
            $array['orderId'] = (String) $order_id;
            $array['description'] = "组合商品折扣";
            $array['itemType'] = empty($erp_data) ? "单个订单" : "SET_DISCOUNT";
            $array['amount'] = $db->getOne("SELECT discount_price from `ecs_goods` where goods_id = {$goods_id}");
            /* VO */
            if ($erp_data) {
                $array['amount'] += $erp_data['discount'];
                foreach ($erp_data['item'] as $tmp_array) {
                    $sign_array['grandTotal'] = (String) $goods_amount;
                    $sign_array['remainingSubTotal'] = (String) ($_erp_data['goods_amount'] - $_erp_data['already_pay'] - $_erp_data['bonus'] - $_erp_data['discount'] + $_erp_data['shipping_fee']);

                    $sign_array['orderId'] = (String) $order_id;
                    $price_goods = getGoodsPrice_type($tmp_array['goods_id']);
                    $sign_array['class'] = 'com.meilele.crmsfa.order.vo.AddOrderItemVO';
                    $sign_array['orderItemSeqId'] = (String) $tmp_array['orderItemSeqId'];
                    $sign_array['productId'] = (String) $tmp_array['goods_id'];
                    $sign_array['quantity'] = (String) $goods_number;
                    $sign_array['unitPrice'] = (String) $price_goods['show_price'];
                    $sign_array['statusUserLogin'] = (String) $_SESSION['admin_name'];
                    $sign_array['itemDescription'] = (String) $tmp_array['goods_name'];
                    $array['itemList'][] = $sign_array;
                }
            } else {
                $tmp_array['orderId'] = (String) $order_id;
                $tmp_array['class'] = 'com.meilele.crmsfa.order.vo.AddOrderItemVO';
                $tmp_array['orderItemSeqId'] = (String) $order_item_seq_id;
                $tmp_array['productId'] = (String) $goods_id;
                $tmp_array['quantity'] = (String) $goods_number;
                $tmp_array['unitPrice'] = (String) $goods_price;
                $tmp_array['statusUserLogin'] = (String) $_SESSION['admin_name'];
                $tmp_array['itemDescription'] = $db->getOne("SELECT goods_name FROM ecs_goods WHERE goods_id = " . $goods_id);
                $array['itemList'][] = $tmp_array;
            }
            $array['amount'] = (String) ("-" . $array['amount']);
            http_request('wsAddOrderItem', $array, array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
        }

        //判断尽快发货
        check_hurry_now($order_id);
        if($order_type == 'expr_order')
        {
            header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=goods\n");
            exit;
        }
            

        /* 跳回订单商品 */
        if ($_POST['patch_type']) {
        	touch_activity($order_id,1);
        } else {
        	touch_activity($order_id);
        }
        
        exit;
        if ($_REQUEST['type'] == 1)
            header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=goods&type=1\n");
        else
            header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=goods\n");
        exit;
    }
    /* 商品 */
    elseif ('goods' == $step) {
        /* 下一步 */
        if (isset($_POST['next'])) {
            header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=consignee\n");
            exit;
        }
        /* 完成 */ elseif (isset($_POST['finish'])) {
            if ($_REQUEST['expr_quick'] == 1) { //快速下单，返回快速下单通道
                header("Location: expr.php?act=order_list");
                exit;
            }
            /* 跳转到订单详情 */
            header("Location: order.php?act=info&order_id=" . $order_id . "\n");
            exit;
        }
    }
    /* 保存收货人信息 */ elseif ('consignee' == $step) {
        //检查订单状况
        $user_group_id = $db->getOne("SELECT group_id FROM `ecs_admin_user` WHERE user_id = {$_SESSION['admin_id']}");
        /*
          $result = $db->getRow("SELECT order_id FROM `ecs_order_info` WHERE (pay_status = 0) and order_id = {$order_id}");
          if(empty($result) && $user_group_id != 48){//已付款订单非订单组无法修改
          sys_msg('付款中和已付款的订单不能修改收件人信息');
          exit;
          }
         */
        $shipping_status = $db->getOne("SELECT shipping_status FROM `ecs_order_info` WHERE order_id = {$order_id}");
        if (in_array($shipping_status, array(1,2)) && !admin_priv("end_order_uname", '', false)) {//已发货 已收货 订单任何人不能修改 包括订单组
            sys_msg('已发货的订单任何用户无法修改收件人！请联系相关人（赠品制作补件单，新商品请再开订单）');
            exit;
        }
        //2012-5-7 需求
        $pay_status = $db->getOne("SELECT pay_status FROM `ecs_order_info` WHERE order_id = {$order_id}");

        $gourp_id = $db->getOne("SELECT group_id FROM `ecs_order_info` WHERE order_id = {$order_id}");

        if(!empty($order_id))
            $nocheck = $db->getOne('SELECT order_type FROM ecs_order_info WHERE order_id=' . $order_id);
        $chackpatch_order = FALSE;
        if($nocheck == 'patch_order')
            $chackpatch_order = TRUE;
        if ($pay_status == 0) {
            //未付款的不管
            $result = true;
        } elseif ($user_group_id == 48) {
            //跟单组
            $result = true;
        } elseif($chackpatch_order) {
            $result = true;
        } else {

            if ($shipping_status == 0 || $shipping_status == 4) {//0 未发货 4 部分发货
                //1=>网站销售 3=>韩菲尔销售 4=>软床销售 5=>凯撒销售 6=>帝轩销售
                $taobao_team = array(1, 3, 4, 5, 6, 94);
                $is_taobao = false;
                if (in_array($gourp_id, $taobao_team)) {
                    $is_taobao = true;
                }
                if ($is_taobao) {
                    $result = web_order_check_per($order_id);
                } else {
                    $result = expr_order_check_per($order_id);
                }
            } else if ($shipping_status == 3) {
                sys_msg("备货中的订单需要修改请联系仓库修改订单发货状态为未发货，请联系仓库");
                exit;
            }
            if (!$result) {
                sys_msg("你没有权限修改收件人信息！请联系跟单组成员");
            }
        }
        /* 保存订单 */
        $order = $_POST;

        //查看用户是否修改了地址,如修改,做日志
        $change_address = $GLOBALS['db']->getRow('SELECT country, province, city, district FROM ecs_order_info WHERE order_id=' . $order_id);
        if($change_address['country']!=$order['country'] || $change_address['province']!=$order['province'] || $change_address['city']!=$order['city'] || $change_address['district']!=$order['district'])
            order_log_sqlinnote($order_id, "$_SESSION[admin_name]将订单[ID:$order_id]的地址($change_address[country],$change_address[province],$change_address[city],$change_address[district])修改为($order[country], $order[province], $order[city],$order[district])");

        
        $order['agency_id'] = get_agency_by_regions(array($order['country'], $order['province'], $order['city'], $order['district']));
        update_order($order_id, $order);

        //保存自定义地区
        // $custom_district = $order['district_extrn'];
        // $ceditorsql = "UPDATE ecs_order_extend SET custom_district='$custom_district' WHERE order_id='$order_id'";
        // $GLOBALS['db']->query($ceditorsql);

        if (ERP_FLAG == 1) {
            $user_id = $db->getOne("SELECT user_id FROM ecs_order_info WHERE order_id = " . $order_id);
            $erp['class'] = 'com.meilele.crmsfa.order.vo.HttpOrderVO';
            $erp['contactInfo']['partyId'] = (String) $user_id;
            $erp['contactInfo']['lastModifiedDate'] = date('Y-m-d H:i:s');
            $erp['contactInfo']['email'] = $_REQUEST['email'];
            $erp['contactInfo']['firstName'] = $_REQUEST['consignee'];
            $erp['contactInfo']['toName'] = $_REQUEST['consignee'];
            $erp['contactInfo']['address1'] = $_REQUEST['address'];
            $erp['contactInfo']['postalCode'] = (String) $_REQUEST['zipcode'];
            $erp['contactInfo']['telephone'] = (String) $_REQUEST['tel'];

            $province_id = $db->getOne("SELECT geo_id FROM ecs_region WHERE region_id = " . $_REQUEST['province']);
            $erp['contactInfo']['province'] = (String) $province_id;

            $city_id = $db->getOne("SELECT geo_id FROM ecs_region WHERE region_id = " . $_REQUEST['city']);
            $erp['contactInfo']['city'] = (String) $city_id;

            $district_id = $db->getOne("SELECT geo_id FROM ecs_region WHERE region_id = " . $_REQUEST['district']);
            $erp['contactInfo']['district'] = (String) $district_id;

            $erp['orderHeader']['orderId'] = (String) $_REQUEST['order_id'];

            $erp['updateFlag'] = 'updateContactInfo';
            http_request('wsCreateOrder', $erp);
        }


        if (!empty($_REQUEST['shipping_email'])) {
            $se = trim($_POST['shipping_email']);
            $db->query("UPDATE ecs_order_info SET shipping_email='$se' WHERE order_id='$order_id'");
        }

        /* 该订单所属办事处是否变化 */
        $agency_changed = $old_order['agency_id'] != $order['agency_id'];

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        admin_log($sn, 'edit', 'order');

        if (isset($_POST['next'])) {
            /* 下一步 */
            if (exist_real_goods($order_id)) {
                /* 存在实体商品，去配送方式 */
                header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=shipping\n");
                exit;
            } else {
                /* 不存在实体商品，去支付方式 */
                header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=payment\n");
                exit;
            }
        } elseif (isset($_POST['finish'])) {
            /* 如果是编辑且存在实体商品，检查收货人地区的改变是否影响原来选的配送 */
            if ('edit' == $step_act && exist_real_goods($order_id)) {
                $order = order_info($order_id);

                /* 取得可用配送方式 */
                $region_id_list = array(
                    $order['country'], $order['province'], $order['city'], $order['district']
                );
                $shipping_list = available_shipping_list($region_id_list);

                /* 判断订单的配送是否在可用配送之内 */
                $exist = false;
                foreach ($shipping_list AS $shipping) {
                    if ($shipping['shipping_id'] == $order['shipping_id']) {
                        $exist = true;
                        break;
                    }
                }

                /* 如果不在可用配送之内，提示用户去修改配送 */
                if (!$exist) {
                    // 修改配送为空，配送费和保价费为0
                    update_order($order_id, array('shipping_id' => 0, 'shipping_name' => ''));
                    $links[] = array('text' => $_LANG['step']['shipping'], 'href' => 'order.php?act=edit&order_id=' . $order_id . '&step=shipping');
                    sys_msg($_LANG['continue_shipping'], 1, $links);
                }
            }

            /* 完成 */
            if ($agency_changed) {
                header("Location: order.php?act=list\n");
            } else {
                header("Location: order.php?act=info&order_id=" . $order_id . "\n");
            }
            exit;
        }
    }
    /* 保存配送信息 */ elseif ('shipping' == $step) {
        /* 如果不存在实体商品，退出 */
        if (!exist_real_goods($order_id)) {
            die('Hacking Attemp');
        }

        /* 取得订单信息 */
        $order_info = order_info($order_id);
        $region_id_list = array($order_info['country'], $order_info['province'], $order_info['city'], $order_info['district']);

        /* 保存订单 */
        $shipping_id = $_POST['shipping'];
        $shipping = shipping_area_info($shipping_id, $region_id_list);
        $weight_amount = order_weight_price($order_id);
        $shipping_fee = shipping_fee($shipping['shipping_code'], $shipping['configure'], $weight_amount['weight'], $weight_amount['amount']);
        $order = array(
            'shipping_id' => $shipping_id,
            'shipping_name' => addslashes($shipping['shipping_name']),
            'shipping_fee' => $shipping_fee
        );

        if (isset($_POST['insure'])) {
            /* 计算保价费 */
            $order['insure_fee'] = shipping_insure_fee($shipping['shipping_code'], order_amount($order_id), $shipping['insure']);
        } else {
            $order['insure_fee'] = 0;
        }
        update_order($order_id, $order);
        update_order_amount($order_id);

        /* 更新 pay_log */
        update_pay_log($order_id);

        /* 清除首页缓存：发货单查询 */
        clear_cache_files('index.dwt');

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        $new_order = order_info($order_id);
        if ($old_order['total_fee'] != $new_order['total_fee']) {
            $sn .= ',' . sprintf($_LANG['order_amount_change'], $old_order['total_fee'], $new_order['total_fee']);
        }
        admin_log($sn, 'edit', 'order');

        if (isset($_POST['next'])) {
            /* 下一步 */
            header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=payment\n");
            exit;
        } elseif (isset($_POST['finish'])) {
            /* 初始化提示信息和链接 */
            $msgs = array();
            $links = array();

            /* 如果已付款，检查金额是否变动，并执行相应操作 */
            $order = order_info($order_id);
            handle_order_money_change($order, $msgs, $links);

            /* 如果是编辑且配送不支持货到付款且原支付方式是货到付款 */
            if ('edit' == $step_act && $shipping['support_cod'] == 0) {
                $payment = payment_info($order['pay_id']);
                if ($payment['is_cod'] == 1) {
                    /* 修改支付为空 */
                    update_order($order_id, array('pay_id' => 0, 'pay_name' => ''));
                    $msgs[] = $_LANG['continue_payment'];
                    $links[] = array('text' => $_LANG['step']['payment'], 'href' => 'order.php?act=' . $step_act . '&order_id=' . $order_id . '&step=payment');
                }
            }

            /* 显示提示信息 */
            if (!empty($msgs)) {
                sys_msg(join(chr(13), $msgs), 0, $links);
            } else {
                /* 完成 */
                header("Location: order.php?act=info&order_id=" . $order_id . "\n");
                exit;
            }
        }
    }
    /* 保存支付信息 */ elseif ('payment' == $step) {
        /* 取得支付信息 */
        $pay_id = $_POST['payment'];
        $payment = payment_info($pay_id);

        /* 计算支付费用 */
        $order_amount = order_amount($order_id);
        if ($payment['is_cod'] == 1) {
            $order = order_info($order_id);
            $region_id_list = array(
                $order['country'], $order['province'], $order['city'], $order['district']
            );
            $shipping = shipping_area_info($order['shipping_id'], $region_id_list);
            $pay_fee = pay_fee($pay_id, $order_amount, $shipping['pay_fee']);
        } else {
            $pay_fee = pay_fee($pay_id, $order_amount);
        }

        /* 保存订单 */
        $order = array(
            'pay_id' => $pay_id,
            'pay_name' => addslashes($payment['pay_name']),
            'pay_fee' => $pay_fee
        );
        update_order($order_id, $order);
        update_order_amount($order_id);

        /* 更新 pay_log */
        update_pay_log($order_id);

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        $new_order = order_info($order_id);
        if ($old_order['total_fee'] != $new_order['total_fee']) {
            $sn .= ',' . sprintf($_LANG['order_amount_change'], $old_order['total_fee'], $new_order['total_fee']);
        }
        admin_log($sn, 'edit', 'order');

        if (isset($_POST['next'])) {
            /* 下一步 */
            header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=other\n");
            exit;
        } elseif (isset($_POST['finish'])) {
            /* 初始化提示信息和链接 */
            $msgs = array();
            $links = array();

            /* 如果已付款，检查金额是否变动，并执行相应操作 */
            $order = order_info($order_id);
            handle_order_money_change($order, $msgs, $links);

            /* 显示提示信息 */
            if (!empty($msgs)) {
                sys_msg(join(chr(13), $msgs), 0, $links);
            } else {
                /* 完成 */
                header("Location: order.php?act=info&order_id=" . $order_id . "\n");
                exit;
            }
        }
    } elseif ('other' == $step) {
        /* 保存订单 */
        $order = array();
        if (isset($_POST['pack']) && $_POST['pack'] > 0) {
            $pack = pack_info($_POST['pack']);
            $order['pack_id'] = $pack['pack_id'];
            $order['pack_name'] = addslashes($pack['pack_name']);
            $order['pack_fee'] = $pack['pack_fee'];
        } else {
            $order['pack_id'] = 0;
            $order['pack_name'] = '';
            $order['pack_fee'] = 0;
        }
        if (isset($_POST['card']) && $_POST['card'] > 0) {
            $card = card_info($_POST['card']);
            $order['card_id'] = $card['card_id'];
            $order['card_name'] = addslashes($card['card_name']);
            $order['card_fee'] = $card['card_fee'];
        } else {
            $order['card_id'] = 0;
            $order['card_name'] = '';
            $order['card_fee'] = 0;
        }
        $order['inv_type'] = $_POST['inv_type'];
        $order['inv_payee'] = $_POST['inv_payee'];
        $order['inv_content'] = $_POST['inv_content'];
        $order['how_oos'] = $_POST['how_oos'];
        $order['postscript'] = $_POST['postscript'];
        $order['to_buyer'] = $_POST['to_buyer'];
        $order['service_notes'] = trim($_POST['service_notes']);
        $sql = "SELECT * FROM ecs_order_info WHERE order_id = $order_id";
        $row = $db->getRow($sql);
        update_order($order_id, $order);
        update_order_amount($order_id);
        if ($row['postscript'] != $_POST['postscript']) { //修改客户给商家留言,写日志
            //插入日志
            $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','修改了客户给商家留言:从" . $row['postscript'] . "到" . $_POST['postscript'] . "','" . time() . "')";
            $db->query($sql);
        }
        if ($row['service_notes'] != $order['service_notes']) { //修改客服备注,写日志
            //插入日志
            $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','修改了客服备注:从" . $row['service_notes'] . "到" . $order['service_notes'] . "','" . time() . "')";
            $db->query($sql);
        }
        /* 更新 pay_log */
        update_pay_log($order_id);

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        admin_log($sn, 'edit', 'order');

        if (isset($_POST['next'])) {
            /* 下一步 */
            header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=money\n");
            exit;
        } elseif (isset($_POST['finish'])) {
            /* 完成 */
            header("Location: order.php?act=info&order_id=" . $order_id . "\n");
            exit;
        }
    } elseif ('money' == $step) {
        /* 取得订单信息 */
        $old_order = order_info($order_id);
        if ($old_order['user_id'] > 0) {
            /* 取得用户信息 */
            $user = user_info($old_order['user_id']);
        }

        /* 保存信息 */
        $order['goods_amount'] = $old_order['goods_amount'];
        $order['tax'] = round(floatval($_POST['tax']), 2);
        $order['shipping_fee'] = isset($_POST['shipping_fee']) && floatval($_POST['shipping_fee']) >= 0 ? round(floatval($_POST['shipping_fee']), 2) : 0;
        $order['insure_fee'] = isset($_POST['insure_fee']) && floatval($_POST['insure_fee']) >= 0 ? round(floatval($_POST['insure_fee']), 2) : 0;
        $order['pay_fee'] = floatval($_POST['pay_fee']) >= 0 ? round(floatval($_POST['pay_fee']), 2) : 0;
        $order['pack_fee'] = isset($_POST['pack_fee']) && floatval($_POST['pack_fee']) >= 0 ? round(floatval($_POST['pack_fee']), 2) : 0;
        $order['card_fee'] = isset($_POST['card_fee']) && floatval($_POST['card_fee']) >= 0 ? round(floatval($_POST['card_fee']), 2) : 0;

        $order['money_paid'] = $old_order['money_paid'];
        $order['surplus'] = 0;
        $order['integral'] = 0;
        $order['integral_money'] = 0;
        $order['bonus_id'] = 0;
        $order['bonus'] = 0;

        /* 计算待付款金额 */
        $order['order_amount'] = $order['goods_amount']
                + $order['tax']
                + $order['shipping_fee']
                + $order['insure_fee']
                + $order['pay_fee']
                + $order['pack_fee']
                + $order['card_fee']
                - $order['money_paid'];
        if ($order['order_amount'] > 0) {
            if ($old_order['user_id'] > 0) {
                /* 如果选择了红包，先使用红包支付 */
                if ($_POST['bonus_id'] > 0) {
                    /* todo 检查红包是否可用 */
                    $order['bonus_id'] = $_POST['bonus_id'];
                    $bonus = bonus_info($_POST['bonus_id']);
                    $order['bonus'] = $bonus['type_money'];

                    $order['order_amount'] -= $order['bonus'];
                }

                /* 使用红包之后待付款金额仍大于0 */
                if ($order['order_amount'] > 0) {
                    /* 如果设置了积分，再使用积分支付 */
                    if (isset($_POST['integral']) && intval($_POST['integral']) > 0) {
                        /* 检查积分是否足够 */
                        $order['integral'] = intval($_POST['integral']);
                        $order['integral_money'] = value_of_integral(intval($_POST['integral']));
                        if ($old_order['integral'] + $user['pay_points'] < $order['integral']) {
                            sys_msg($_LANG['pay_points_not_enough']);
                        }

                        $order['order_amount'] -= $order['integral_money'];
                    }

                    if ($order['order_amount'] > 0) {
                        /* 如果设置了余额，再使用余额支付 */
                        if (isset($_POST['surplus']) && floatval($_POST['surplus']) >= 0) {
                            /* 检查余额是否足够 */
                            $order['surplus'] = round(floatval($_POST['surplus']), 2);
                            if ($old_order['surplus'] + $user['user_money'] + $user['credit_line'] < $order['surplus']) {
                                sys_msg($_LANG['user_money_not_enough']);
                            }

                            /* 如果红包和积分和余额足以支付，把待付款金额改为0，退回部分积分余额 */
                            $order['order_amount'] -= $order['surplus'];
                            if ($order['order_amount'] < 0) {
                                $order['surplus'] += $order['order_amount'];
                                $order['order_amount'] = 0;
                            }
                        }
                    } else {
                        /* 如果红包和积分足以支付，把待付款金额改为0，退回部分积分 */
                        $order['integral_money'] += $order['order_amount'];
                        $order['integral'] = integral_of_value($order['integral_money']);
                        $order['order_amount'] = 0;
                    }
                } else {
                    /* 如果红包足以支付，把待付款金额设为0 */
                    $order['order_amount'] = 0;
                }
            }
        }

        update_order($order_id, $order);

        /* 更新 pay_log */
        update_pay_log($order_id);

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        $new_order = order_info($order_id);
        if ($old_order['total_fee'] != $new_order['total_fee']) {
            $sn .= ',' . sprintf($_LANG['order_amount_change'], $old_order['total_fee'], $new_order['total_fee']);
        }
        admin_log($sn, 'edit', 'order');

        /* 如果余额、积分、红包有变化，做相应更新 */
        if ($old_order['user_id'] > 0) {
            $user_money_change = $old_order['surplus'] - $order['surplus'];
            if ($user_money_change != 0) {
                log_account_change($user['user_id'], $user_money_change, 0, 0, 0, sprintf($_LANG['change_use_surplus'], $old_order['order_sn']));
            }

            $pay_points_change = $old_order['integral'] - $order['integral'];
            if ($pay_points_change != 0) {
                log_account_change($user['user_id'], 0, 0, 0, $pay_points_change, sprintf($_LANG['change_use_integral'], $old_order['order_sn']));
            }

            if ($old_order['bonus_id'] != $order['bonus_id']) {
                if ($old_order['bonus_id'] > 0) {
                    $sql = "UPDATE " . $ecs->table('user_bonus') .
                            " SET used_time = 0, order_id = 0 " .
                            "WHERE bonus_id = '$old_order[bonus_id]' LIMIT 1";
                    $db->query($sql);
                }

                if ($order['bonus_id'] > 0) {
                    $sql = "UPDATE " . $ecs->table('user_bonus') .
                            " SET used_time = '" . time() . "', order_id = '$order_id' " .
                            "WHERE bonus_id = '$order[bonus_id]' LIMIT 1";
                    $db->query($sql);
                }
            }
        }

        if (isset($_POST['finish'])) {
            /* 完成 */
            if ($step_act == 'add') {
                /* 订单改为已确认，（已付款） */
                $arr['order_status'] = OS_CONFIRMED;
                $arr['confirm_time'] = time();
                if ($order['order_amount'] <= 0) {
                    $arr['pay_status'] = PS_PAYED;
                    $arr['pay_time'] = time();
                }
                update_order($order_id, $arr);
            }

            /* 初始化提示信息和链接 */
            $msgs = array();
            $links = array();

            /* 如果已付款，检查金额是否变动，并执行相应操作 */
            $order = order_info($order_id);
            handle_order_money_change($order, $msgs, $links);

            /* 显示提示信息 */
            if (!empty($msgs)) {
                sys_msg(join(chr(13), $msgs), 0, $links);
            } else {
                header("Location: order.php?act=info&order_id=" . $order_id . "\n");
                exit;
            }
        }
    }
    /* 保存发货后的配送方式和发货单号 */ elseif ('invoice' == $step) {
        /* 如果不存在实体商品，退出 */
        if (!exist_real_goods($order_id)) {
            die('Hacking Attemp');
        }

        /* 保存订单 */
        $shipping_id = $_POST['shipping'];
        $shipping = shipping_info($shipping_id);
        $invoice_no = $_POST['invoice_no'];
        $order = array(
            'shipping_id' => $shipping_id,
            'shipping_name' => addslashes($shipping['shipping_name']),
            'invoice_no' => $invoice_no
        );
        update_order($order_id, $order);

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        admin_log($sn, 'edit', 'order');

        if (isset($_POST['finish'])) {
            header("Location: order.php?act=info&order_id=" . $order_id . "\n");
            exit;
        }
    } elseif ('set_order_send_time' == $step) {
    	$status = $db->getOne("SELECT pre_ship_status  from ecs_order_info where order_id = {$order_id}");
    	if($status == 'hurry'){
    		sys_msg('尽快发货订单不能修改预计发货时间');
    	}
        if ($_POST['all'])
            $where = "order_id = $order_id and shipping_status = 0 "; //覆盖所有
        else
            $where = "order_id = $order_id and shipping_status = 0 and (plan_send_time = 0 or plan_send_time is null) "; //覆盖未填写的

        $data['plan_send_time'] = strtotime($_POST['plan_send_time']);

        if ($data['plan_send_time'] < (time() - (3600 * 24)))
            sys_msg('预计发货时间不能小于当前时间');
		
        if ($data['plan_send_time'] > (time() + (3600 * 24 * 90)))
        	sys_msg('预计发货时间不能大于90天');
       
        $order_type 	= $db->getOne("SELECT order_type FROM ecs_order_info where order_id = $order_id ");
        if($order_type != 'patch_order'){
	        $result = check_can_set_order_plan_time($order_id,$data['plan_send_time']);
	        if($result['error'] > 0 ){
	        	sys_msg($result['msg']." 仓库数量不足 你不能将预计发货时间从7天之外修改到7天之内");
	        }
        }
        $db->autoExecute('ecs_order_goods', $data, 'UPDATE', $where);
        $info_data = array();
        $info_data['pre_ship_time'] = $data['plan_send_time'];
        $db->autoExecute('ecs_order_info', $info_data, 'UPDATE', 'order_id = ' . $order_id);
        $row = $db->getRow("SELECT * FROM ecs_order_info WHERE order_id = $order_id");
        $notes = "设置订单预计发货时间为{$_POST['plan_send_time']}";
        $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES('" . $order_id . "','" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','" . $notes . "','" . time() . "')";
        $db->query($sql);
        header("Location: order.php?act=info&order_id=" . $order_id . "\n");
        exit;
    }else if ('set_need_ship_time' == $step) {
        if ($_POST['all']) {
            //$db->query("UPDATE ecs_order_info SET ship_all = 0 where order_id = $order_id");
        }
        $data['need_ship_time'] = strtotime($_POST['need_ship_time']);

        if ($data['need_ship_time'] < (time() - (3600 * 24)))
            sys_msg('指定发货时间不能小于当前时间');

        $info_data = array();
        $info_data['need_ship_time'] = $data['need_ship_time'];
        $db->autoExecute('ecs_order_info', $info_data, 'UPDATE', 'order_id = ' . $order_id);
        $row = $db->getRow("SELECT * FROM ecs_order_info WHERE order_id = $order_id");
        $notes = "指定发货时间为{$_POST['plan_send_time']}(重要)";
        $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES('" . $order_id . "','" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','" . $notes . "','" . time() . "')";
        $db->query($sql);
        header("Location: order.php?act=info&order_id=" . $order_id . "\n");
        exit;
    }
}
else if($_REQUEST['act'] == 'get_patch_bujian')
{
	$goods_id = $_REQUEST['goods_id'];
    if (preg_match("/([A-Za-z])/", $goods_id)) {
        $goods_id = $db->getOne("SELECT goods_id FROM ecs_goods WHERE goods_sn = '".$goods_id."' LIMIT 1");
        $res = $db->getAll("SELECT goods_id,goods_sn,goods_name FROM ecs_goods WHERE goods_id = $goods_id");
        die(json_encode($res));
    } else {
    	$res = $db->getAll("SELECT g.goods_id,g.goods_sn,g.goods_name FROM ecs_goods_relation r join ecs_goods g on r.goods_id = g.goods_id WHERE r.parent_goods_id = $goods_id");
    	die(json_encode($res));
    }
}
/* ------------------------------------------------------ */
//-- 修改订单（载入页面）
/* ------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit') {
    /* 检查权限 */
    admin_priv('order_edit');
    checkOrderAuth($_GET['order_id']);
    /* 取得参数 order_id */

    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    $smarty->assign('order_id', $order_id);

    if ($_REQUEST['act'] == 'edit' && $_REQUEST['step'] == 'goods') {
		$shipping_status = $db->getOne("SELECT shipping_status FROM ecs_order_goods WHERE shipping_status = 3 and order_id = " . $order_id);
    	if($shipping_status == 3){
    		sys_msg('存在配合中商品的订单不允许修改 请联系仓库！');
    	}
        $pay_status = $db->getOne("SELECT pay_status FROM ecs_order_info WHERE order_id = " . $order_id);
        if ($pay_status == 1 || $pay_status == 2) {
            $group_id = $db->getOne("SELECT group_id FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);
            /* 老需求 暂时注释 不清楚会不会变化
              if($group_id != 8 && $group_id != 1 && $group_id != 48){
              sys_msg('付款中和已付款的订单只有跟单人员才允许操作！');
              //检查完用户所属用户组以后再次进行检查只有admin_id 和leader_id 有操作者ID才能修改
              $admin_and_leader = $db->getRow("SELECT admin_id,leader_id FROM `ecs_order_info` WHERE `order_id` = {$order_id}");
              $in_admin = false;
              if(!empty($admin_and_leader['admin_id'])){
              //检查是否在admin_id里
              $admin_str = trim($admin_and_leader['admin_id'],"|");
              if(strrchr($admin_str, '|')){
              $admin_array = explode('|', $admin_str);
              if(in_array($_SESSION['admin_id'], $admin_array))
              $in_admin = true;
              }else{
              if($admin_str == $_SESSION['admin_id'])
              $in_admin = true;
              }
              }
              //检查是否在leader_id里
              $in_leader = false;
              if(!empty($admin_and_leader['leader_id']))
              if($admin_and_leader['leader_id'] == $_SESSION['admin_id'])
              $in_leader = true;

              //admin_id 和 leader_id 都没有当前SESSION用户
              if(!$in_admin && !$in_leader)
              sys_msg('付款中和已付款的订单只有跟单人员才允许操作！');
              }
             */
        }
        //把 ship_type 传给模版
        $smarty->assign('ship_type', $_GET['ship_type']);
    }

    /* 取得参数 step */
    $step_list = array('user', 'goods', 'consignee', 'shipping', 'payment', 'other','patch_goods', 'money', 'best_time');
    $step = isset($_GET['step']) && in_array($_GET['step'], $step_list) ? $_GET['step'] : 'user';
    $smarty->assign('step', $step);

    /* 取得参数 act */
    $act = $_GET['act'];
    $smarty->assign('ur_here', (($act == 'add') ?
                    $_LANG['add_order'] : $_LANG['edit_order']) . ' - ' . $_LANG['step'][$step]);
    $smarty->assign('step_act', $act);
    /* 取得订单信息 */
    if ($order_id > 0) {
        $order = order_info($order_id);
        //如果订单状态为部分发货，判断订单里是否只有最后一个商品是未发货，如果是则在取消商品时做出提示“将把订单状态改为已发货”。
        if ($order['shipping_status'] == SS_PART_SHIPPED) {
            $sql = "select COUNT(*) FROM `ecs_order_goods` WHERE order_id='$order_id' AND (shipping_status=0 OR shipping_status=3) AND is_receiving=0";
            $record_total = $db->getOne($sql);
            if ($record_total == 1) {
                $smarty->assign('del_confirm', true);
            } else {
                $smarty->assign('del_confirm', false);
            }
        }
        /* 如果已发货，就不能修改订单了（配送方式和发货单号除外） */
        if ($order['shipping_status'] == SS_SHIPPED || $order['shipping_status'] == SS_RECEIVED) {
            if(admin_priv("end_order_uname",'', false)) { // 此权限可以修改已发货或已收货的订单

            } else if($step != 'shipping' && $step != 'best_time') {
                sys_msg($_LANG['cannot_edit_order_shipped']);
            } else if ($step == 'shipping') {
                $step = 'invoice';
                $smarty->assign('step', $step);
            } else if ($step == 'best_time') {
                $step = 'best_time';
                $smarty->assign('step', $step);
            }
        }

        $smarty->assign('order', $order);
    } else {
        if ($act != 'add' || $step != 'user') {
            die('invalid params');
        }
    }

    /* 选择会员 */
    if ('user' == $step) {
        // 无操作
    }

    /* 增删改商品 */ elseif ('goods' == $step) {

        /* 取得订单商品 */
        /*  $adminsql="SELECT a.rcd_id,a.user_id,a.order_id,a.pay_money,a.successed,a.pay_time,a.paytype,a.paybanktype,a.action_notes,b.pay_name
          FROM ecs_payment_record AS a
          LEFT JOIN (
          SELECT pay_id,pay_name FROM ecs_payment
          )AS b ON b.pay_id = a.paybanktype
          WHERE a.successed=1 AND a.order_id = ".$order_id;
          $adminpayarray=$GLOBALS['db']->getAll($adminsql);

          if($_SESSION['admin_id']==51 or $_SESSION['admin_id']==54 or $_SESSION['admin_id']==42 or $_SESSION['admin_id']==64)
          {

          }
          else
          {
          if(count($adminpayarray))
          {
          echo "付款中，已付款的订单，你没有权限修改！";
          exit();
          }
          } */
        $goods_list = order_goods($order_id);
        if ($_REQUEST['type'] == 1) //快速下单，返回下单通道
            $smarty->assign('expr_quick', 1);
        foreach ($goods_list AS $key => $goods) {
            if ($goods['shipping_status'] == 5) {
                unset($goods_list[$key]);
                continue;
            }
            unset($sql_list, $goods_cloth, $cloth_goods_id, $sql_list_filal, $buban_list);
            /* 计算属性数 */
            $attr = $goods['goods_attr'];
            if ($attr == '') {
                $goods_list[$key]['rows'] = 1;
            } else {
                $goods_list[$key]['rows'] = count(explode(chr(13), $attr));
            }
            //处理布板型号
            $sql_list = "SELECT cloth_goods_id,brand_id FROM ecs_goods WHERE is_on_sale = 1 AND is_delete = 0 AND goods_id =" . $goods_list[$key]['goods_id'];
            $goods_cloth = $db->getRow($sql_list);
            $cloth_goods_id = $goods_cloth['cloth_goods_id'];
            if ($goods_cloth) {
                if (!$cloth_goods_id && $cloth_goods_id != -1 && $goods_cloth['brand_id']) {
                    $sql_cloth = "SELECT cloth_goods_id FROM ecs_brand WHERE brand_id = " . $goods_cloth['brand_id'];
                    $cloth_goods_id = $db->getOne($sql_cloth);
                }
                if (!empty($cloth_goods_id) && $cloth_goods_id != -1) {
                    $cloth_on_sale_res = $db->getAll("SELECT goods_id FROM ecs_goods WHERE goods_id in($cloth_goods_id) AND is_delete = 0 AND is_on_sale = 1");
                    foreach ($cloth_on_sale_res as $v) {
                        $cloth_on_sale_arr[] = $v['goods_id'];
                    }
                    $cloth_goods_id = @implode(',', $cloth_on_sale_arr);
                    if ($cloth_goods_id != "") {
                        $sql_list_filal = "SELECT img_id,img_desc,thumb_url,img_url FROM ecs_goods_gallery WHERE goods_id in($cloth_goods_id)";
                        $goods_list[$key]['cloth_goods_name2'] = $db->getAll($sql_list_filal);
                    }

                    if ($sql_list_filal)
                        $goods_list[$key]['cloth_goods_name2'] = $db->getAll($sql_list_filal);
                }
            }
            /* 时间戳 */
            $goods_list[$key]['plan_send_time'] = empty($goods_list[$key]['plan_send_time']) ? '' : date('Y-m-d', $goods_list[$key]['plan_send_time']);
            if ($goods_list[$key]['cloth_goods_id']) {
                if (!is_numeric($goods_list[$key]['cloth_goods_id'])) {
                    $arr_bb = explode(":", $goods_list[$key]['cloth_goods_id']);
                    $goods_list[$key]['cloth_goods_id'] = $arr_bb[1];
                }
            }
        }
        $action_list = $db->getOne("SELECT action_list FROM ecs_admin_user  WHERE user_id = " . $_SESSION['admin_id']);
		$smarty->assign('ship_type',$order['order_ship_type']);
        //调货订单
        if ($action_list == 'all' || strpos($action_list, 'expr_order_allocate'))
            $smarty->assign('expr_order_allocate', 1);
        $smarty->assign('goods_list', $goods_list);

        /* 取得商品总金额 */
        $smarty->assign('goods_amount', order_amount($order_id));
    }
	
	 elseif ('patch_goods' == $step) {
        $goods_list = order_goods($order_id); //DO
        $supplier_sn = $db->getOne("SELECT supplier_sn FROM ecs_order_extend WHERE order_id = $order_id LIMIT 1");
        if (!$supplier_sn) {
            sys_msg("请先选择补件单归属工厂");
        }
		//获取父订单的商品
		$_order_id = $db->getOne("SELECT parent_id FROM ecs_order_info WHERE order_id = $order_id");
		$_goods_list = $db->getAll("SELECT * FROM ecs_order_goods WHERE order_id = $_order_id AND goods_number >0 AND shipping_status IN(1,2)");   
		$smarty->assign('_goods_list',$_goods_list);
        foreach ($goods_list AS $key => $goods) {
            if ($goods['shipping_status'] == 5) {
                unset($goods_list[$key]);
                continue;
            }
            unset($sql_list, $goods_cloth, $cloth_goods_id, $sql_list_filal, $buban_list);
            /* 计算属性数 */
            $attr = $goods['goods_attr'];
            if ($attr == '') {
                $goods_list[$key]['rows'] = 1;
            } else {
                $goods_list[$key]['rows'] = count(explode(chr(13), $attr));
            }
            //处理布板型号
            $sql_list = "SELECT cloth_goods_id,brand_id FROM ecs_goods WHERE is_on_sale = 1 AND is_delete = 0 AND goods_id =" . $goods_list[$key]['goods_id'];
            $goods_cloth = $db->getRow($sql_list);
            $cloth_goods_id = $goods_cloth['cloth_goods_id'];
            if ($goods_cloth) {
                if (!$cloth_goods_id && $cloth_goods_id != -1 && $goods_cloth['brand_id']) {
                    $sql_cloth = "SELECT cloth_goods_id FROM ecs_brand WHERE brand_id = " . $goods_cloth['brand_id'];
                    $cloth_goods_id = $db->getOne($sql_cloth);
                }
                if (!empty($cloth_goods_id) && $cloth_goods_id != -1) {
                    $cloth_on_sale_res = $db->getAll("SELECT goods_id FROM ecs_goods WHERE goods_id in($cloth_goods_id) AND is_delete = 0 AND is_on_sale = 1");
                    foreach ($cloth_on_sale_res as $v) {
                        $cloth_on_sale_arr[] = $v['goods_id'];
                    }
                    $cloth_goods_id = @implode(',', $cloth_on_sale_arr);
                    if ($cloth_goods_id != "") {
                        $sql_list_filal = "SELECT img_id,img_desc,thumb_url,img_url FROM ecs_goods_gallery WHERE goods_id in($cloth_goods_id)";
                        $goods_list[$key]['cloth_goods_name2'] = $db->getAll($sql_list_filal);
                    }

                    if ($sql_list_filal)
                        $goods_list[$key]['cloth_goods_name2'] = $db->getAll($sql_list_filal);
                }
            }
            /* 时间戳 */
            $goods_list[$key]['plan_send_time'] = empty($goods_list[$key]['plan_send_time']) ? '' : date('Y-m-d', $goods_list[$key]['plan_send_time']);
            if ($goods_list[$key]['cloth_goods_id']) {
                if (!is_numeric($goods_list[$key]['cloth_goods_id'])) {
                    $arr_bb = explode(":", $goods_list[$key]['cloth_goods_id']);
                    $goods_list[$key]['cloth_goods_id'] = $arr_bb[1];
                }
            }
        }
        $action_list = $db->getOne("SELECT action_list FROM ecs_admin_user  WHERE user_id = " . $_SESSION['admin_id']);
        $smarty->assign('goods_list', $goods_list);

        /* 取得商品总金额 */
        $smarty->assign('goods_amount', order_amount($order_id));
    }
    // 设置收货人
    elseif ('consignee' == $step) {
        $group_id = $db->getOne("SELECT group_id FROM `ecs_admin_user` WHERE user_id = {$_SESSION['admin_id']}");
        $admin_info = $db->getRow("SELECT group_id,is_leader FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);
        //检查是否可以查看此订单收件人详细信息
        $owner_order = 1;
        if ($order['admin_id'] && strpos($order['admin_id'], '|' . $_SESSION['admin_id'] . '|') === false && !(checkOwnerOrder('order_contact_info') && $admin_info['group_id'] == $order['group_id'])) {
            $owner_order = 2;
            $assigner_id = $db->getALL("SELECT user_id FROM `ecs_admin_user` WHERE group_id = {$order['group_id']} and job_type = '财务助理'");
            if (!empty($assigner_id)) {
                foreach ($assigner_id as $v) {
                    if ($v['user_id'] == $_SESSION['admin_id'])//用户是订单所属店的店长助理
                        $owner_order = 1;
                }
            }
            /*
              $leader_id = $db->getOne("SELECT `group_leader_id` FROM `meilele_group` WHERE group_id =  {$order['group_id']}");
              if($leader_id == $_SESSION['admin_id']){
              $owner_order = 1;
              } */
            $leader_array = getLeaderByuser($order['admin_id']);
            if (!empty($leader_array)) {
                if (in_array($_SESSION['admin_id'], $leader_array)) {
                    $owner_order = 1;
                }
            }
        }
        if ($admin_info['group_id'] == 48 || $admin_info['group_id'] == 8)//跟单售后直接给权限
            $owner_order = 1;
        if(in_array($order['shipping_status'], array(1,2)) && admin_priv("end_order_uname", '', false)) // 拥有此权限直接给权限
        {
            $owner_order = 1;
            $smarty->assign('step', 'end_order_uname');
        }

        if ($owner_order == 2) {
            sys_msg("你无权进入查看和修改订单详细信息");
        }
        //详细信息查看结束

        /* 查询是否存在实体商品 */
        $exist_real_goods = 1; //exist_real_goods($order_id);//写死为1 2012-6-16 不清楚具体功能询问产品与松哥没得出结果
        $smarty->assign('exist_real_goods', 1);


        $smarty->assign('shipping_email_list', $db->getAll("SELECT DISTINCT email
					FROM ecs_admin_user ORDER BY email"));
        /* 取得收货地址列表 */
        if ($order['user_id'] > 0) {
            $smarty->assign('address_list', address_list($order['user_id']));
            $address_id = isset($_REQUEST['address_id']) ? intval($_REQUEST['address_id']) : 0;
            if ($address_id > 0) {
                $address = address_info($address_id);
                if ($address) {
                    $order['consignee'] = $address['consignee'];
                    $order['country'] = $address['country'];
                    $order['province'] = $address['province'];
                    $order['city'] = $address['city'];
                    
                    $order['district'] = $address['district'];
                    $order['email'] = $address['email'];
                    $order['address'] = $address['address'];
                    $order['zipcode'] = $address['zipcode'];
                    $order['tel'] = $address['tel'];
                    $order['mobile'] = $address['mobile'];
                    $order['sign_building'] = $address['sign_building'];
                    $order['best_time'] = $address['best_time'];
                    $smarty->assign('order', $order);
                }
            }
        }
        $cdistrict_id = $GLOBALS['db']->getOne('SELECT custom_district FROM `ecs_order_extend` WHERE order_id=' . $order_id);
        if(!empty($cdistrict_id))
        {
            $cdistrict_extrn = $GLOBALS['db']->getOne('SELECT region_name FROM ecs_region_edit WHERE region_id=' . $cdistrict_id);
            $smarty->assign('district_extrn_val', $cdistrict_extrn);
        }
            
        // if(!empty($cdistrict_extrn))
        // {
        //     $district_extrn_list = $GLOBALS['db']->getAll('SELECT region_id,region_name from ecs_region_edit join ecs_expr_service_manage as b on district = region_id where parent_id = (SELECT parent_id FROM ecs_region_edit WHERE region_id=' . $cdistrict_extrn . ') group by region_id');
        //     $smarty->assign('district_extrn_list', $district_extrn_list);    
        // }
        

        if ($exist_real_goods) {
            /* 取得国家 */
            $smarty->assign('country_list', get_regions());
            if ($order['country'] > 0) {
                /* 取得省份 */
                $smarty->assign('province_list', get_regions(1, $order['country']));
                if ($order['province'] > 0) {
                    /* 取得城市 */
                    $smarty->assign('city_list', get_regions(2, $order['province']));
                    if ($order['city'] > 0) {
                        /* 取得区域 */
                        $smarty->assign('district_list', get_regions(3, $order['city']));
                    }
                }
            }
        }
    }

    // 选择配送方式
    elseif ('shipping' == $step) {
        /* 如果不存在实体商品 */
        if (!exist_real_goods($order_id)) {
            die('Hacking Attemp');
        }

        /* 取得可用的配送方式列表 */
        $region_id_list = array(
            $order['country'], $order['province'], $order['city'], $order['district']
        );
        $shipping_list = available_shipping_list($region_id_list);

        /* 取得配送费用 */
        $total = order_weight_price($order_id);
        foreach ($shipping_list AS $key => $shipping) {
            $shipping_fee = shipping_fee($shipping['shipping_code'], unserialize($shipping['configure']), $total['weight'], $total['amount']);
            $shipping_list[$key]['shipping_fee'] = $shipping_fee;
            $shipping_list[$key]['format_shipping_fee'] = price_format($shipping_fee);
            $shipping_list[$key]['free_money'] = price_format($shipping['configure']['free_money']);
        }
        $smarty->assign('shipping_list', $shipping_list);
    }

    // 选择支付方式
    elseif ('payment' == $step) {
        /* 取得可用的支付方式列表 */
        if (exist_real_goods($order_id)) {
            /* 存在实体商品 */
            $region_id_list = array(
                $order['country'], $order['province'], $order['city'], $order['district']
            );
            $shipping_area = shipping_area_info($order['shipping_id'], $region_id_list);
            $pay_fee = ($shipping_area['support_cod'] == 1) ? $shipping_area['pay_fee'] : 0;

            $payment_list = available_payment_list($shipping_area['support_cod'], $pay_fee);
        } else {
            /* 不存在实体商品 */
            $payment_list = available_payment_list(false);
        }

        /* 过滤掉使用余额支付 */
        foreach ($payment_list as $key => $payment) {
            if ($payment['pay_code'] == 'balance') {
                unset($payment_list[$key]);
            }
        }
        $smarty->assign('payment_list', $payment_list);
    }

    // 选择包装、贺卡
    elseif ('other' == $step) {
        /* 查询是否存在实体商品 */
        $exist_real_goods = exist_real_goods($order_id);
        $smarty->assign('exist_real_goods', $exist_real_goods);

        if ($exist_real_goods) {
            /* 取得包装列表 */
            $smarty->assign('pack_list', pack_list());

            /* 取得贺卡列表 */
            $smarty->assign('card_list', card_list());
        }
    }

    // 费用
    elseif ('money' == $step) {
        /* 查询是否存在实体商品 */
        $exist_real_goods = exist_real_goods($order_id);
        $smarty->assign('exist_real_goods', $exist_real_goods);

        /* 取得用户信息 */
        if ($order['user_id'] > 0) {
            $user = user_info($order['user_id']);

            /* 计算可用余额 */
            $smarty->assign('available_user_money', $order['surplus'] + $user['user_money']);

            /* 计算可用积分 */
            $smarty->assign('available_pay_points', $order['integral'] + $user['pay_points']);

            /* 取得用户可用红包 */
            $user_bonus = user_bonus($order['user_id'], $order['goods_amount']);
            if ($order['bonus_id'] > 0) {
                $bonus = bonus_info($order['bonus_id']);
                $user_bonus[] = $bonus;
            }
            $smarty->assign('available_bonus', $user_bonus);
        }
    }

    // 发货后修改配送方式和发货单号
    elseif ('invoice' == $step) {
        /* 如果不存在实体商品 */
        if (!exist_real_goods($order_id)) {
            die('Hacking Attemp');
        }

        /* 取得可用的配送方式列表 */
        $region_id_list = array(
            $order['country'], $order['province'], $order['city'], $order['district']
        );
        $shipping_list = available_shipping_list($region_id_list);

        //        /* 取得配送费用 */
        //        $total = order_weight_price($order_id);
        //        foreach ($shipping_list AS $key => $shipping)
        //        {
        //            $shipping_fee = shipping_fee($shipping['shipping_code'],
        //                unserialize($shipping['configure']), $total['weight'], $total['amount']);
        //            $shipping_list[$key]['shipping_fee'] = $shipping_fee;
        //            $shipping_list[$key]['format_shipping_fee'] = price_format($shipping_fee);
        //            $shipping_list[$key]['free_money'] = price_format($shipping['configure']['free_money']);
        //        }
        $smarty->assign('shipping_list', $shipping_list);
    } else if ($step == 'best_time') {
        echo 212121;
        exit;
    }
    /* 显示模板 */
    assign_query_info();

    $smarty->display('order_step.htm');
}

/* ------------------------------------------------------ */
//-- 处理
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'process') {
    /* 取得参数 func */
    $func = isset($_GET['func']) ? $_GET['func'] : '';

    /* 删除订单商品 */
    if ('drop_order_goods' == $func) {
        /* 检查权限 */
        admin_priv('order_edit');
        /* 取得参数 */
        $rec_id = intval($_GET['rec_id']);
        $step_act = $_GET['step_act'];
        $order_id = intval($_GET['order_id']);
        /* 权限检查 体验馆 淘宝 2012-04-24 文莉需求 */
        check_group($order_id);
		
        $goods_id = $db_select->getOne("SELECT goods_id from ecs_order_goods where rec_id = {$rec_id}");
        $bonus_goods_list = db_get_list('ecs_goods_bonus',' 1 ','bonus_type','goods_id');
        if(in_array($goods_id,$bonus_goods_list) ){
        	if(!admin_priv('snatch_manage','',false))
        	sys_msg("此商品属于送红包商品，无法取消。不支持客户退款、退货等项目。请向客户解释清楚。");
        }
		
        /* 检查品牌修改权限 */
        $deny_array = get_check_brand(intval($_GET['rec_id']));
        if (!empty($deny_array)) {
            $sql = "SELECT group_id FROM `ecs_admin_user` where user_id = '{$_SESSION['admin_id']}'";
            $group_id = $db->getOne($sql);
        }

        /* 取消返现优惠 */

        $discount_amount = $db->getOne("SELECT discount_amount * goods_number from ecs_order_goods where rec_id = {$rec_id}");

        $db->query("UPDATE ecs_order_info SET discount = (discount - $discount_amount) where order_id = {$order_id}");

        /* 取消套装优惠 */

        $parent_son = $db->getOne("SELECT suit_id from ecs_order_goods where rec_id = {$rec_id}");

        if ($parent_son) {
            $suit_str = $db->getOne("SELECT suit_str from ecs_order_extend where order_id = {$order_id}");
            if ($suit_str) {
                $suit_str = trim($suit_str, '@@');
                $suit_array = explode('@@', $suit_str);

                foreach ($suit_array as $_k_suit => $_v_suit) {
                    $detail_info = explode('#', $_v_suit);
                    foreach ($detail_info as $_k => $_v) {
                        if ($_v == $parent_son && $_k == 0) {
                            $discount_money = $detail_info[1];
                            if ($discount_money) {
                                $db->query("UPDATE ecs_order_info SET discount=discount-{$discount_money} WHERE order_id = $order_id"); //套装处理

                                $db->query("UPDATE ecs_order_goods SET suit_id=0,goods_type = 0 WHERE order_id = $order_id and suit_id = '{$parent_son}'"); //套装处理
                            }
                            unset($suit_array[$_k_suit]);
                        } else {
                            continue;
                        }
                    }
                }
            }

            if ($suit_array) {
                $db->query("UPDATE ecs_order_extend SET suit_str='@@" . (implode('@@', $suit_array)) . "@@' WHERE order_id = $order_id"); //套装处理
            } else {
                $db->query("UPDATE ecs_order_extend SET suit_str='' WHERE order_id = $order_id"); //套装处理
            }
        }

        if ($rec_id == $deny_array[0]['rec_id']) {
            // 48跟单组 8 售后
            if ($group_id != 48 && $group_id != 8) {
                sys_msg("由于此品牌为定制商品({$deny_array[0]['goods_name']})，请联系相应跟单更改订单，谢谢！");
            }
        }
        //$invoice_id = $db->getOne("SELECT esii.invoice_id FROM ecs_stock_invoice_goods esig JOIN ecs_stock_invoice_info esii ON esii.invoice_id = esig.invoice_id WHERE esig.order_rec_id = $rec_id AND esii.fstatus != 'cancel' AND esii.fstatus != 'merged' ORDER BY invoice_id DESC limit 1");
        if (checkInvoiceBill($order_id, $rec_id))
            sys_msg('该商品已经生成发货单,不能删除!');

        $info = $db->getRow("SELECT goods_number,goods_sn,goods_id,order_item_seq_id FROM ecs_order_goods WHERE rec_id = " . $rec_id);
        //updateLimitSale($info['goods_id'],$info['goods_number'],'add');
        /* 删除 */
        $goods_info = $db->getRow("SELECT `goods_id`,`goods_number` FROM `ecs_order_goods` WHERE rec_id = {$rec_id}");
        $sql = "UPDATE ecs_order_goods SET shipping_status = 5,goods_number =0 WHERE rec_id = $rec_id";
        $db->query($sql);

        //取消订单项目以后如果是人工限购就添加取消的数量
        updateLimitSale($goods_info['goods_id'], $goods_info['goods_number'], 'add');

        $sql = "SELECT shipping_status FROM `ecs_order_info` WHERE order_id='$order_id'";
        $order_shipping_status = $db->getOne($sql);
        $goto_flog = false;
        $notes = "管理员取消了商品{$info['goods_sn']}";
		/**
		 *屏蔽删除订单内最后一个商品后，订单状态变为已发货
        if ($order_shipping_status == SS_PART_SHIPPED) {
            $sql = "select COUNT(*) FROM `ecs_order_goods` WHERE order_id='$order_id' AND (shipping_status=0 OR shipping_status=3) AND is_receiving=0";
            $record_total = $db->getOne($sql);
            if ($record_total == 0) {
                //更新订单状态为已发货
                $sql = "UPDATE `ecs_order_info` SET shipping_status = '" . SS_SHIPPED . "' WHERE order_id='$order_id' LIMIT 1";
                $db->query($sql);
                if ($db->affected_rows()) {
                    $notes .= "，并修改订单状态为：已发货";
                    $goto_flog = true;
                }
            }
        }
		*/
        $row = $db->getRow("SELECT * FROM ecs_order_info WHERE order_id = $order_id");
        $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES('" . $order_id . "','" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','" . $notes . "','" . time() . "')";
        $db->query($sql);
        updateOrderAmount($order_id);
        $order_type = $db->getOne("SELECT order_type FROM ecs_order_info WHERE order_id = $order_id LIMIT 1");
            if ($order_type != 'patch_order') {
                modifyOrderPayStatus($order_id);
            }
        /* 更新商品总金额和订单总金额 */
        // update_order($order_id, array('goods_amount' => order_amount($order_id)));
        //update_order_amount($order_id);
        if (ERP_FLAG == 1) {
            if (ERP_FLAG == 1) { //取消订单项
                $_erp_data = $db->getRow("SELECT goods_amount,discount,already_pay,bonus,shipping_fee FROM ecs_order_info WHERE order_id = $order_id");
                $_erp_item['class'] = 'com.meilele.crmsfa.order.vo.UpdateOrderItemQuantityVO';
                $_erp_item['orderId'] = (String) $order_id;
                $_erp_item['grandTotal'] = (String) $_erp_data['goods_amount'];
                $_erp_item['remainingSubTotal'] = (String) ($_erp_data['goods_amount'] - $_erp_data['already_pay'] - $_erp_data['bonus'] - $_erp_data['discount'] + $_erp_data['shipping_fee']);
                $_erp_item['orderItems'] = array(array('orderItemSeqId' => $info['order_item_seq_id'], 'quantity' => $info['goods_number']));
                http_request('wsCancelOrderItem', $_erp_item, array('user_name' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
            }
        }
        //查看红包状态,若更改数量或取消商品,红包应重新计算
        check_unset_bonus($order_id);

        //判断尽快发货
        check_hurry_now($order_id);
        

        if ($_REQUEST['patch']) {
        	 touch_activity($order_id,1);
            
        } else {
        	touch_activity($order_id);
        }
        exit;
        /* 跳回订单商品 */
        if ($goto_flog) {
            header("Location: order.php?act=info&order_id=$order_id\n");
            exit;
        }


        if ($_REQUEST['type'] == 1) {
            header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=goods&type=1\n");
        } else {
            header("Location: order.php?act=edit&order_id=$order_id&step=goods\n");
        }
        exit;
    }

    /* 取消刚添加或编辑的订单 */ elseif ('cancel_order' == $func) {
        $step_act = $_GET['step_act'];
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if ($step_act == 'add') {
            /* 如果是添加，删除订单，返回订单列表 */
            if ($order_id > 0) {
                sys_msg('禁止删除订单');
                /* $sql = "DELETE FROM " . $ecs->table('order_info') .
                  " WHERE order_id = '$order_id' LIMIT 1";
                  $db->query($sql); */
            }
            header("Location: order.php?act=list\n");
            exit;
        } else {
            /* 如果是编辑，返回订单信息 */
            header("Location: order.php?act=info&order_id=" . $order_id . "\n");
            exit;
        }
    }

    /* 编辑订单时由于订单已付款且金额减少而退款 */ elseif ('refund' == $func) {
        /* 处理退款 */
        $order_id = $_REQUEST['order_id'];
        $refund_type = $_REQUEST['refund'];
        $refund_note = $_REQUEST['refund_note'];
        $refund_amount = $_REQUEST['refund_amount'];
        $order = order_info($order_id);
        order_refund($order, $refund_type, $refund_note, $refund_amount);

        /* 修改应付款金额为0，已付款金额减少 $refund_amount */
        if (($order['money_paid'] - $refund_amount) <= 0) {
            update_order($order_id, array('pay_status' => 0, 'money_paid' => $order['money_paid'] - $refund_amount));
        } else {
            update_order($order_id, array('money_paid' => $order['money_paid'] - $refund_amount));
        }

        /* 返回订单详情 */
        header("Location: order.php?act=info&order_id=" . $order_id . "\n");
        exit;
    }

    /* 载入退款页面 */ elseif ('load_refund' == $func) {
        $refund_amount = floatval($_REQUEST['refund_amount']);
        $smarty->assign('refund_amount', number_format($refund_amount,2));
        $smarty->assign('formated_refund_amount', price_format($refund_amount));

        $anonymous = $_REQUEST['anonymous'];
        $smarty->assign('anonymous', $anonymous); // 是否匿名

        $order_id = intval($_REQUEST['order_id']);
        $smarty->assign('order_id', $order_id); // 订单id

        /* 显示模板 */
        $smarty->assign('ur_here', $_LANG['refund']);
        assign_query_info();
        $smarty->display('order_refund.htm');
    } else {
        die('invalid params');
    }
} elseif ($_REQUEST['act'] == 'order_change_user') {
    $order_id = $_REQUEST['order_id'];
    if ($order_id) {
        $order = $db->getRow("SELECT eoi.order_id,eoi.shipping_status,eoi.order_status,eoi.pay_status,eoi.group_id,eoi.order_sn,eoi.consignee,eu.user_name FROM ecs_order_info eoi join ecs_users eu on eoi.user_id = eu.user_id WHERE order_id = $order_id");
        $group_id = $db->getOne("SELECT group_id FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);
        if ($order['group_id'] != $group_id)
            sys_msg('您只能修改自己所在组的订单!');
        if ($_POST['order_id']) {
            $user_name = trim($_POST['user_name']);
            $user_id = $db->getOne("SELECT user_id FROM ecs_users WHERE user_name = '" . $user_name . "'");
            if (!$user_id)
                sys_msg('用户名' . $user_name . '不存在');
            $db->query("UPDATE ecs_order_info SET normal_user_id = $user_id WHERE order_id = " . $_POST['order_id']);
            $db->query("INSERT INTO ecs_order_action(order_id,action_user,order_status,shipping_status,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $order['order_status'] . "','" . $order['shipping_status'] . "','转移订单用户为" . $user_name . "','" . time() . "')");
            $links[] = array('text' => '返回订单详情', 'href' => 'order.php?act=info&order_id=' . $order_id);
            sys_msg('处理成功!', 1, $links);
        }
        $smarty->assign('order', $order);
        $smarty->display('order_change_user.htm');
        exit;
    }
    else
        sys_msg('参数错误!');
}

/* ------------------------------------------------------ */
//-- 合并订单
/* ------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'merge') {
    /* 检查权限 */
    admin_priv('order_os_edit');

    /* 取得满足条件的订单 */
    $sql = "SELECT o.order_sn, u.user_name " .
            "FROM " . $ecs->table('order_info') . " AS o " .
            "LEFT JOIN " . $ecs->table('users') . " AS u ON o.user_id = u.user_id " .
            "WHERE o.user_id > 0 " .
            "AND o.extension_code = '' " . order_query_sql('unprocessed');
    $smarty->assign('order_list', $db->getAll($sql));

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['04_merge_order']);
    $smarty->assign('action_link', array('href' => 'order.php?act=list', 'text' => $_LANG['02_order_list']));

    /* 显示模板 */
    assign_query_info();
    $smarty->display('merge_order.htm');
} else if ($_REQUEST['act'] == 'checkAdmin') {
    $partner_name = $_POST['partner_name'];
    $arr = explode('|', $partner_name);
    foreach ($arr as $v) {
        if ($v) {
            $res[] = $v;
            $t = $db->getRow("SELECT user_id,count(user_id) as num FROM ecs_admin_user u LEFT JOIN meilele_group g ON u.group_id = g.group_id WHERE real_name = '" . $v . "' AND job_status != '离职' AND g.code = 'is_salesman' GROUP BY user_id");
            $user_id = $t['user_id'];
            if ($t['num'] > 1) {
                die('用户' . $v . '存在重名,请联系程序组');
            }
            if (!$user_id) {
                die('用户' . $v . '不存在！');
            }
        }
    }
    if (count($res) <= 1 && $_REQUEST['search'] != 1)
        die('分单的人数至少要2个！');
    die('ok');
}
/* ------------------------------------------------------ */
//-- 订单打印模板（载入页面）
/* ------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'templates') {
    /* 检查权限 */
    admin_priv('order_os_edit');

    /* 读入订单打印模板文件 */
    $file_path = ROOT_PATH . 'data/order_print.html';
    $file_content = file_get_contents($file_path);
    @fclose($file_content);

    include_once(ROOT_PATH . "includes/fckeditor/fckeditor.php");

    /* 编辑器 */
    $editor = new FCKeditor('FCKeditor1');
    $editor->BasePath = "../includes/fckeditor/";
    $editor->ToolbarSet = "Normal";
    $editor->Width = "95%";
    $editor->Height = "500";
    $editor->Value = $file_content;

    $fckeditor = $editor->CreateHtml();
    $smarty->assign('fckeditor', $fckeditor);

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['edit_order_templates']);
    $smarty->assign('action_link', array('href' => 'order.php?act=list', 'text' => $_LANG['02_order_list']));
    $smarty->assign('act', 'edit_templates');

    /* 显示模板 */
    assign_query_info();
    $smarty->display('order_templates.htm');
}
/* ------------------------------------------------------ */
//-- 订单打印模板（提交修改）
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'edit_templates') {
    /* 更新模板文件的内容 */
    $file_name = @fopen("../data/order_print.html", 'w+');
    @fwrite($file_name, stripslashes($_POST['FCKeditor1']));
    @fclose($file_name);

    /* 提示信息 */
    $link[] = array('text' => $_LANG['back_list'], 'href' => 'order.php?act=list');
    sys_msg($_LANG['edit_template_success'], 0, $link);
}

/* ------------------------------------------------------ */
//-- 操作订单状态（载入页面）
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'operate') {
    if (!isset($_POST['confirm']) && !isset($_POST['ch_order_type']) && !isset($_POST['cancel']))
        checkOrderAuth($_REQUEST['order_id']);
    /* 取得订单id（可能是多个，多个sn）和操作备注（可能没有） */
    $order_id = $_REQUEST['order_id'];
    $batch = isset($_REQUEST['batch']); // 是否批处理
    $action_note = isset($_REQUEST['action_note']) ? trim($_REQUEST['action_note']) : '';

    /* 确认 */
    if (isset($_POST['confirm'])) {
        $require_note = false;
        $action = $_LANG['op_confirm'];
        $operation = 'confirm';
    }
    /* 付款 */ elseif (isset($_POST['pay'])) {
        $require_note = $_CFG['order_pay_note'] == 1;
        $action = $_LANG['op_pay'];
        $operation = 'pay';
    }
    /* 未付款 */ elseif (isset($_POST['unpay'])) {
        $require_note = $_CFG['order_unpay_note'] == 1;
        $order = order_info($order_id);
        if ($order['money_paid'] > 0) {
            $show_refund = true;
        }
        $anonymous = $order['user_id'] == 0;
        $action = $_LANG['op_unpay'];
        $operation = 'unpay';
    }
    /* 配货 */ elseif (isset($_POST['prepare'])) {
        //判断是否是仓库管理员操作
        $sql = "SELECT ew.name FROM `ecs_admin_user` AS eau
                LEFT JOIN `ecs_warehouse` AS ew ON eau.warehouse_id=ew.warehouse_id
                WHERE eau.user_id = '{$_SESSION['admin_id']}' AND ew.expr_id=0";
        $wh_name = $db->getOne($sql);

        if (!$wh_name) {
            if(!admin_priv('goods_ship', '', false) || $order['order_type'] != 'patch_order'){
                sys_msg('只在佛山仓库管理才能操作！');
            }
        }

        $require_note = false;
        $action = $_LANG['op_prepare'];
        $operation = 'prepare';

        $goods_ids = array_keys($_POST['goods_id']);
        $goods_id_str = implode(',', $goods_ids);
    }
    /* 预留 */ elseif (isset($_POST['reserve'])) {

        $require_note = true;
        $action = $_LANG['op_prepare'];
        $operation = 'reserve';



        $goods_ids = $_POST['goods_id'];
        $goods_list_str = "";

        if (count($goods_ids) <= 0) {
            echo "请选择需要保留的商品.";
            exit;
        }


        $goods_id_str = "";
        $goods_list_str = "";
        $where = "";
        foreach ($goods_ids AS $key => $val) {
            $goods_list_str = $goods_list_str . "," . $val;
            $goods_id_str = $goods_id_str . "," . $key;
            $where = $where . "$key,";
        }

        $where = $where . "0)";

        $sql = "select  rec_id, goods_sn,goods_name , goods_number ,  shipping_status, debit_sn " .
                "from ecs_order_goods where rec_id in (" . $where . " 
			    and (shipping_status = " . SS_UNSHIPPED . " or shipping_status = " . SS_P_RESERVE . ")";

        $goods_info = $GLOBALS['db']->getAll($sql);
        $smarty->assign('goods_info', $goods_info);
    }

    /* 取消预留 */ elseif (isset($_POST['reserve_cancel'])) {

        $require_note = true;
        $action = $_LANG['op_prepare'];
        $operation = 'reserve_cancel';



        $goods_ids = $_POST['goods_id'];


        if (count($goods_ids) <= 0) {
            echo "请选择需要保留的商品.";
            exit;
        }


        $goods_id_str = "";

        foreach ($goods_ids AS $key => $val) {
            $goods_id_str = $goods_id_str . "," . $key;
        }

        $smarty->assign('goods_id_str', $goods_id_str);   // 需要保留的ID
    }
    /* 发货 */ elseif (isset($_POST['ship'])) {
        $orderinfo = $db->getRow("SELECT order_id, order_type FROM ecs_order_info WHERE order_id = $order_id LIMIT 1");
        //判断是否是仓库管理员操作
        $sql = "SELECT ew.name FROM `ecs_admin_user` AS eau
                LEFT JOIN `ecs_warehouse` AS ew ON eau.warehouse_id=ew.warehouse_id
                WHERE eau.user_id = '{$_SESSION['admin_id']}' AND ew.expr_id=0";
        $wh_name = $db->getOne($sql);

        $sql = "SELECT `group_id` FROM `ecs_admin_user` WHERE user_id = {$_SESSION['admin_id']}";
        $group_id = $db_select->getOne($sql);
        if (!$wh_name && !($orderinfo['order_type'] == 'patch_order' && admin_priv('goods_ship', '', false))) {
            sys_msg('只在佛山仓库管理才能操作！');
        }
        $goods_ids = $_POST['goods_id'];
        $goods_list_str = "";

        if (count($goods_ids) <= 0) {
            echo "请选择需要发货的商品.";
            exit;
        }
        $goods_id_str = "";
        $goods_list_str = "";
        $where = "";
        foreach ($goods_ids AS $key => $val) {
            $goods_list_str = $goods_list_str . "," . $val;
            $goods_id_str = $goods_id_str . "," . $key;
            $where = $where . "$key,";
        }

        $where = $where . "0)";

        $sql = "select  rec_id, goods_sn,goods_name , goods_number ,  shipping_status, debit_sn " .
                "from ecs_order_goods where rec_id in (" . $where . " and (shipping_status = " . SS_UNSHIPPED . " or shipping_status = " . SS_P_RESERVE . " or  shipping_status = " . SS_PREPARING . ")";

        $goods_info = $GLOBALS['db']->getAll($sql);

        if (strlen($goods_list_str) > 150) {
            $goods_list_str = substr($goods_list_str, 0, 150) . " ...";
        }

        $action_note = $action_note . "\r\n" . $goods_list_str;

        $smarty->assign('goods_list_str', $goods_list_str);

        $smarty->assign('goods_info', $goods_info);
        $smarty->assign('SS_PREPARING', SS_PREPARING);
        $smarty->assign('goods_id_str', $goods_id_str);

        $require_note = $_CFG['order_ship_note'] == 1;
        $show_invoice_no = true;
        $action = $_LANG['op_ship'];
        $operation = 'ship';
    } elseif (isset($_POST['transfer_add'])) {
        $operation = 'transfer_add';
    } elseif (isset($_POST['transfer_update'])) {
        $operation = 'transfer_update';
    }

    /* 未发货 */ 
    elseif (isset($_POST['unship'])) {



        $goods_id = $_POST['goods_id'];

        if (count($goods_id) <= 0) {
            echo "请选择设定为未发货的商品.";
            exit;
        }
        $goods_list_str = "";
        $goods_id_str = "";
        foreach ($goods_id AS $key => $val) {
            $goods_list_str = $goods_list_str . "," . $val;
            $goods_id_str = $goods_id_str . "," . $key;
        }
        echo "严禁此操作谢谢合作";
        exit;
        $action_note = $action_note . "\r\n 本次设为未发货的商品有：" . $goods_list_str;
        //$smarty->assign('goods_list_str',    $goods_list_str);
        $smarty->assign('goods_id_str', $goods_id_str);



        $require_note = $_CFG['order_unship_note'] == 1;
        $action = $_LANG['op_unship'];
        $operation = 'unship';
    }
    /* 收货确认 */ 
    elseif (isset($_POST['receive'])) {
        //如果有售后单，必须要已经完成状态
        $servicer_str = $sale_problem_status = '';
        $sale_problem_order_sn = $db->getOne("select order_sn from ecs_order_info where order_id ='" . $_REQUEST['order_id'] . "'");
        $sale_problem_status = $db->getAll("select problem_status,servicer,work_state_url  from ecs_sale_problem where order_sn='$sale_problem_order_sn' and work_state_id is not null");
        if ($sale_problem_status) {
            foreach ($sale_problem_status as $spk => $spv) {
                if ($spv['problem_status'] != '售后完成' && get_status_state(trim($spv['work_state_url']))) {
                    sys_msg('此订单的售后单：' . $spv['work_state_url'] . '还没有完成,状态为：'.$spv['problem_status'].',请发邮件给回访或者联系售后，谢谢。');
                }
                $servicer_array[] = $spv['servicer'];
            }
            if ($servicer_array) {
                $servicer_str = implode('|', $servicer_array);
                $smarty->assign('servicer_str', $servicer_str); //订单商品信息列表
            }
            $smarty->assign('problem_status', 1); //
        }

        $refund_type_list = array(
            'instead_setup' => '客户垫付安装费',
            'instead_repair' => '客户垫付维修费',
            'factory' => '工厂赔偿金额',
            'company' => '我司赔偿金额',
            'setup' => '安装费',
            'repair' => '维修费',
            'damage' => '赔偿金',
            'cancel' => '取消商品',
            'change' => '换货差价',
            'return' => '退货返款',
            'delivery' => '运费补偿',
            'delivery_fee' => '送货费',
            'into_order_fee' => '转订单金额',
            'no_after_sale' => '无售后问题补偿',
            'join_insured' => '参加保价'
                //'other'           => '其它'
        );

        $require_note = $_CFG['order_receive_note'] == 1;
        $action = $_LANG['op_receive'];
        $operation = 'receive';

        $sql = " SELECT rec_id, a.goods_id, a.goods_sn, " . "  CASE b.goods_name_ori WHEN \"\" THEN b.goods_name ELSE goods_name_ori END AS goods_name  " . " FROM ecs_order_goods  a LEFT JOIN ecs_goods b ON a.goods_id = b.goods_id WHERE order_id = $order_id ";
        $order_details = $GLOBALS ['db']->getALL($sql);

        $sql = "SELECT r.refund_id,rd.detail_status AS refund_status,rd.type FROM ecs_refund r LEFT JOIN ecs_refund_detail rd ON r.refund_id = rd.refund_id LEFT JOIN ecs_order_info o ON r.order_sn = o.order_sn WHERE o.order_id = '$order_id'";
        $refund_list = $GLOBALS ['db']->getAll($sql);
        if ($refund_list) {
            foreach ($refund_list as &$refund) {
                if ($refund['refund_status'] == 'confirmed')
                    $refund['refund_status'] = 'new';
                if (!empty($refund['type']))
                    $refund['type'] = $refund_type_list[$refund['type']];
            }
        }
        //是否为体验馆订单和货到付款订单
        $is_received_pay = '';
        $is_received_pay = $GLOBALS['db']->getOne("select is_received_pay from ecs_order_info where order_id='" . $order_id . "'");
        if ($is_received_pay) {
            $smarty->assign('install_pay_type_display', 1); //为货到付款订单
        }
        if ($order_id) {
            $user_message = $GLOBALS['db']->getAll("select user_id,consignee from ecs_order_info where order_id='" . $order_id . "'");
            if ($user_message) {
                $expr_name_db = $GLOBALS['db']->getAll("select expr_name from ecs_expr_nature where manager_front_id='" . $user_message[0]['user_id'] . "'");
            }
            if ($expr_name_db[0]['expr_name']) {
                $smarty->assign('install_pay_type_display', 1); //为体验馆订单
            }
        }


        $smarty->assign('order_details', $order_details); //订单商品信息列表
        $smarty->assign('refund_list', $refund_list); //退款单状态
    }
    /* 取消 */ elseif (isset($_POST['cancel'])) {
        sys_msg('请在订单详情里面取消订单');
    }
    /* 无效 */ elseif (isset($_POST['invalid'])) {
        $require_note = $_CFG['order_invalid_note'] == 1;
        $action = $_LANG['op_invalid'];
        $operation = 'invalid';
    }
    /* 售后 */ elseif (isset($_POST['after_service'])) {
        //  $require_note   = true;
        //  $action         = $_LANG['op_after_service'];
        //  $operation      = 'after_service';
        header("Location: services_mng.php?act=add&step=add&order_id=" . $order_id . "\n");

        exit;
    } elseif (isset($_POST['audit'])) {
        $require_note = true;
        $action = "财务审核";
        $operation = 'audit';
    } elseif (isset($_POST['assign_mech'])) {
        $require_note = true;
        $action = "跟单分配";
        $operation = 'assign_mech';

        $sql = "select user_id,user_name from ecs_admin_user where  user_name  in( 'yangyuhong', 'qinfengzeng')  order by user_name "; // 写死先，待group id 功能写好了，再改过来。

        $user_list = $db->getALL($sql);

        $smarty->assign('user_list', $user_list);
    } elseif (isset($_POST['ch_order_type'])) {
        $require_note = true;
        $action = "更新订单类型";
        $operation = 'ch_order_type';
    }

    /* 售后 */ elseif (isset($_POST['close_service'])) {
        $require_note = true;
        $action = $_LANG['op_after_service'];
        $operation = 'close_service';
    }
    /* 生成退款单 */ elseif (isset($_POST['gen_refund'])) {
        header("Location: refund.php?act=operate_post&order_id=" . $order_id . "&operation=gen_refund" . "\n");

        exit;
    }
    /* 生成补件单 */ elseif (isset($_POST['gen_patch'])) {
			  // header("Location: patch_goods.php?act=operate_post&order_id=" . $order_id . "&operation=gen_patch"  . "\n");
			  // exit;
            $newpatch = $_REQUEST['newpatch'];
            if (($list = $db->getAll("SELECT i.order_id, i.order_sn FROM ecs_order_info i WHERE parent_id = ".$order_id)) && !$newpatch) {
                $delivery_arr = array('1'=>'工厂', '2'=>'仓库', '3'=>'工厂→仓库发', '4'=>'体验馆');
                //仓库信息
                $sql ="SELECT `warehouse_id`,`warehouse_sn`,`name` FROM `ecs_warehouse`";
                $warehouse = array();
                $res = $db->query($sql);
                while ($row = $db->fetchRow($res)) {
                    $row['warehouse_id'] = 'w_'.$row['warehouse_id'];
                    $warehouse[] = $row;
                }
                foreach ($list as $key => $value) {
                    $extend = $db->getRow("SELECT delivery_party, ship_pay_status FROM ecs_order_extend WHERE order_id = ".$value['order_id']);
                    $value['delivery_party'] = $extend['delivery_party'];
                    $value['ship_pay_status'] = $extend['ship_pay_status'];
                    if ($value['delivery_party'] ==1 ||$value['delivery_party'] ==2 || $value['delivery_party'] ==3 ||$value['delivery_party'] ==4 ){
                        $value['delivery_party'] = $delivery_arr[$value['delivery_party']];
                    } else {
                        foreach ($warehouse as $k => $v) {
                            if ($value['delivery_party'] == $v['warehouse_id']) {
                                $value['delivery_party'] = $v['name'];
                                break;
                            }
                        }
                    }
                    switch ($value['ship_pay_status']) {
                        case 0:
                            $value['ship_pay_status'] = '未付款';
                            break;
                        case 1:
                            $value['ship_pay_status'] = '运费已付';
                            break;
                        case 2:
                            $value['ship_pay_status'] = '下单成功但是某些原因运费未包含';
                            break;
                    }
                    $list[$key] = $value;
                }
                $smarty->assign("order_id", $order_id);
                $smarty->assign("full_page", 1);
                $smarty->assign("list", $list);
                $smarty->display("order_patch_list_detail.htm");
                exit;
            }

			$sql = " select eoi.order_sn,eoi.email, eoi.consignee,eoi.wangwang,eoi.user_id,eoi.province,eoi.city,eoi.district,eoi.address, ".
               "eoi.zipcode,eoi.tel,eoi.mobile,er1.region_name AS province_name,er2.region_name AS city_name,er3.region_name AS district_name ".
               "FROM ecs_order_info AS eoi LEFT JOIN `ecs_region` AS er1 ON eoi.province=er1.region_id ".
               "LEFT JOIN `ecs_region` AS er2 ON eoi.city=er2.region_id ".
               "LEFT JOIN `ecs_region` AS er3 ON eoi.district=er3.region_id ".
               "where order_id = $order_id";
				$order_info =  $db->getRow($sql);
				$order_info['address'] = '[ '.$order_info['province_name'].' '.$order_info['city_name'] . ' ' .$order_info['district_name'] . ' ] ' .$order_info['address'];
				$order_info['address'] = str_replace('\\','',$order_info['address']);
				
				if (empty($order_info )){
					die("没有找到对应的订单！");
				}

				$num = $db->getOne("SELECT count(*) FROM ecs_order_info WHERE parent_id = $order_id");
				
                $sn = $order_info['order_sn'];
                #$sn = "TB".$sn;
                $start = 0;
                for ($i=0; $i <= strlen($sn); $i++) {
                    $start = $i;
                    if (is_numeric($sn[$i])) {
                        break;
                    }
                }
                $sn = substr($sn, 0, $start)."".substr($sn,$start+3);
                $patch_sn = 'PAT-'.$sn.'-'.($num+1);
                //生成订单
				$sql = "INSERT INTO ecs_order_info(order_sn,user_id,order_status,shipping_status,pay_status,consignee,province,city,district,address,zipcode,tel,mobile,email,goods_amount,already_pay,shipping_fee,order_amount,add_time,order_type,parent_id)
						VALUES('".$patch_sn."',0,0,0,0,'".$order_info['consignee']."','".$order_info['province']."','".$order_info['city']."','".$order_info['district']."','".$order_info['address']."','".$order_info['zipcode']."','".$order_info['tel']."','".$order_info['mobile']."','".str_replace('\\','',$order_info['email'])."',0,0,0,0,'".time()."','patch_order',$order_id)";
				$db->query($sql);			
				$order_id = $db->insert_id();
                $db->query("INSERT INTO ecs_order_extend (order_id, vehicle_fstatus) VALUES ($order_id, 'yes')");
				header("Location:/admin/order.php?act=info&order_id=".$order_id);
				exit;
    }

    /* 退货 */ elseif (isset($_POST['return'])) {
        $require_note = $_CFG['order_return_note'] == 1;
        $order = order_info($order_id);
        if ($order['money_paid'] > 0) {
            $show_refund = true;
        }
        $anonymous = $order['user_id'] == 0;
        $action = $_LANG['op_return'];
        $operation = 'return';
    }
    /* 指派 */ elseif (isset($_POST['assign'])) {
        /* 取得参数 */
        $new_agency_id = isset($_POST['agency_id']) ? intval($_POST['agency_id']) : 0;
        if ($new_agency_id == 0) {
            sys_msg($_LANG['js_languages']['pls_select_agency']);
        }

        /* 查询订单信息 */
        $order = order_info($order_id);

        /* 如果管理员属于某个办事处，检查该订单是否也属于这个办事处 */
        $sql = "SELECT agency_id FROM " . $ecs->table('admin_user') . " WHERE user_id = '$_SESSION[admin_id]'";
        $admin_agency_id = $db->getOne($sql);
        if ($admin_agency_id > 0) {
            if ($order['agency_id'] != $admin_agency_id) {
                sys_msg($_LANG['priv_error']);
            }
        }

        /* 修改订单所属的办事处 */
        if ($new_agency_id != $order['agency_id']) {
            $sql = "UPDATE " . $ecs->table('order_info') . " SET agency_id = '$new_agency_id' " .
                    "WHERE order_id = '$order_id' LIMIT 1";
            $db->query($sql);
        }

        /* 操作成功 */
        $links[] = array('href' => 'order.php?act=list&' . list_link_postfix(), 'text' => $_LANG['02_order_list']);
        sys_msg($_LANG['act_ok'], 0, $links);
    }
    /* 删除 */ elseif (isset($_POST['remove'])) {
        $require_note = false;
        $operation = 'remove';
        if (!$batch) {
            /* 检查能否操作 */
            $is_leader = $db->getOne("SELECT is_leader FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);
            if ($is_leader != 1)
                sys_msg('您没有权限删除此订单!');
            $order = order_info($order_id);
            $operable_list = operable_list($order);
            if (!isset($operable_list['remove'])) {
                die('Hacking attempt');
            }
            //备份删除的订单
            backup_del_order($order_id);
            sys_msg('禁止删除订单');
            /* 删除订单 */
            //$db->query("DELETE FROM ".$ecs->table('order_info'). " WHERE order_id = '$order_id'");
            //$db->query("DELETE FROM ".$ecs->table('order_goods'). " WHERE order_id = '$order_id'");
            //$db->query("DELETE FROM ".$ecs->table('order_action'). " WHERE order_id = '$order_id'");

            /* todo 记录日志 */
            admin_log($order['order_sn'], 'remove', 'order');

            /* 返回 */
            sys_msg($_LANG['order_removed'], 0, array(array('href' => 'order.php?act=list&' . list_link_postfix(), 'text' => $_LANG['return_list'])));
        }
    }
    /* 前台不显示 */ elseif (isset($_POST['no_display'])) {
        $require_note = false;
        $operation = 'no_display';

        if (!$batch) {
            $db->query("UPDATE " . $ecs->table('order_info') . " SET display_in_front=0 WHERE order_sn='$order_id'");
        }
    }
    /* 批量打印订单 */ elseif (isset($_POST['print'])) {
        if (empty($_POST['order_id'])) {
            sys_msg($_LANG['pls_select_order']);
        }

        /* 赋值公用信息 */
        $smarty->assign('shop_name', $_CFG['shop_name']);
        $smarty->assign('shop_url', $ecs->url());
        $smarty->assign('shop_address', $_CFG['shop_address']);
        $smarty->assign('service_phone', $_CFG['service_phone']);
        $smarty->assign('print_time', date($_CFG['time_format']));
        $smarty->assign('action_user', $_SESSION['admin_name']);

        $html = '';
        $order_sn_list = explode(',', $_POST['order_id']);
        foreach ($order_sn_list as $order_sn) {
            /* 取得订单信息 */
            $order = order_info(0, $order_sn);
            if (empty($order)) {
                continue;
            }

            /* 根据订单是否完成检查权限 */
            if (order_finished($order)) {
                if (!admin_priv('order_view_finished', '', false)) {
                    continue;
                }
            } else {
                if (!admin_priv('order_view', '', false)) {
                    continue;
                }
            }

            /* 如果管理员属于某个办事处，检查该订单是否也属于这个办事处 */
            $sql = "SELECT agency_id FROM " . $ecs->table('admin_user') . " WHERE user_id = '$_SESSION[admin_id]'";
            $agency_id = $db->getOne($sql);
            if ($agency_id > 0) {
                if ($order['agency_id'] != $agency_id) {
                    continue;
                }
            }

            /* 取得用户名 */
            if ($order['user_id'] > 0) {
                $user = user_info($order['user_id']);
                if (!empty($user)) {
                    $order['user_name'] = $user['user_name'];
                }
            }

            /* 取得区域名 */
            $sql = "SELECT concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''), " .
                    "'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region " .
                    "FROM " . $ecs->table('order_info') . " AS o " .
                    "LEFT JOIN " . $ecs->table('region') . " AS c ON o.country = c.region_id " .
                    "LEFT JOIN " . $ecs->table('region') . " AS p ON o.province = p.region_id " .
                    "LEFT JOIN " . $ecs->table('region') . " AS t ON o.city = t.region_id " .
                    "LEFT JOIN " . $ecs->table('region') . " AS d ON o.district = d.region_id " .
                    "WHERE o.order_id = '$order[order_id]'";
            $order['region'] = $db->getOne($sql);

            /* 其他处理 */
            $order['order_time'] = date($_CFG['time_format'], $order['add_time']);
            $order['pay_time'] = $order['pay_time'] > 0 ?
                    date($_CFG['time_format'], $order['pay_time']) : $_LANG['ps'][PS_UNPAYED];
            $order['shipping_time'] = $order['shipping_time'] > 0 ?
                    date($_CFG['time_format'], $order['shipping_time']) : $_LANG['ss'][SS_UNSHIPPED];
            $order['status'] = $_LANG['os'][$order['order_status']] . ',' . $_LANG['ps'][$order['pay_status']] . ',' . $_LANG['ss'][$order['shipping_status']];
            $order['invoice_no'] = $order['shipping_status'] == SS_UNSHIPPED || $order['shipping_status'] == SS_PREPARING ? $_LANG['ss'][SS_UNSHIPPED] : $order['invoice_no'];

            /* 此订单的发货备注(此订单的最后一条操作记录) */
            $sql = "SELECT action_note FROM " . $ecs->table('order_action') .
                    " WHERE order_id = '$order[order_id]' AND shipping_status = 1 ORDER BY log_time DESC";
            $order['invoice_note'] = $db->getOne($sql);

            /* 参数赋值：订单 */
            $smarty->assign('order', $order);

            /* 取得订单商品 */
            $goods_list = array();
            $goods_attr = array();
            $sql = "SELECT o.*, g.goods_number AS storage, o.goods_attr, IFNULL(b.brand_name, '') AS brand_name " .
                    "FROM " . $ecs->table('order_goods') . " AS o " .
                    "LEFT JOIN " . $ecs->table('goods') . " AS g ON o.goods_id = g.goods_id " .
                    "LEFT JOIN " . $ecs->table('brand') . " AS b ON g.brand_id = b.brand_id " .
                    "WHERE o.order_id = '$order[order_id]' ";
            $res = $db->query($sql);
            while ($row = $db->fetchRow($res)) {
                /* 虚拟商品支持 */
                if ($row['is_real'] == 0) {
                    /* 取得语言项 */
                    $filename = ROOT_PATH . 'plugins/' . $row['extension_code'] . '/languages/common_' . $_CFG['lang'] . '.php';
                    if (file_exists($filename)) {
                        include_once($filename);
                        if (!empty($_LANG[$row['extension_code'] . '_link'])) {
                            $row['goods_name'] = $row['goods_name'] . sprintf($_LANG[$row['extension_code'] . '_link'], $row['goods_id'], $order['order_sn']);
                        }
                    }
                }

                $row['formated_subtotal'] = price_format($row['goods_price'] * $row['goods_number']);
                $row['formated_goods_price'] = price_format($row['goods_price']);

                $goods_attr[] = explode(' ', trim($row['goods_attr'])); //将商品属性拆分为一个数组
                $goods_list[] = $row;
            }

            $attr = array();
            $arr = array();
            foreach ($goods_attr AS $index => $array_val) {
                foreach ($array_val AS $value) {
                    $arr = explode(':', $value); //以 : 号将属性拆开
                    $attr[$index][] = @array('name' => $arr[0], 'value' => $arr[1]);
                }
            }
            $smarty->assign('goods_attr', $attr);
            $smarty->assign('goods_list', $goods_list);

            $smarty->template_dir = '../data';
            $html .= $smarty->fetch('order_print.html') .
                    '<div style="PAGE-BREAK-AFTER:always"></div>';
        }

        echo $html;
        exit;
    } elseif (isset($_POST['send'])) {
        $order_id = $_POST['order_id'];
        $operate = $_POST['operate'];
        admin_priv('expr_send_goods');
        $is_install_worker = $db->getOne("SELECT is_install_worker FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);
        if ($is_install_worker == 1)
            sys_msg('你没有设置送货的权限!');
        if ($order_id) {
            $expr_flag = $db->getRow("SELECT info.order_status,info.group_id,info.shipping_status,info.is_received_pay FROM ecs_order_info info WHERE info.order_id = $order_id ");
            if ($expr_flag) {
                $goods_arr = $_POST['goods_id'];
                if (count($goods_arr) < 1)
                    sys_msg('请选择要执行此操作的订单商品!');
                foreach ($goods_arr as $key => $v) {
                    $row = '';
                    $row = $db->getRow("SELECT rec_id,goods_sn FROM ecs_order_goods WHERE rec_id = $key AND (shipping_status = 1 OR shipping_status = 2)");
                    $rec_id = $row['rec_id'];
                    $goods_sn = $row['goods_sn'];
                    if ($row['goods_sn'] == 'MLL体验馆服务费')
                        sys_msg('服务费不允许执行此操作!');
                    if (empty($rec_id))
                        sys_msg($goods_sn . '还未发货,不允许执行此操作!');
                }
                if ($expr_flag['group_id'] == 17 || $expr_flag['group_id'] == 50)
                    $expr_admin_user = $db->getAll("SELECT real_name,user_id FROM ecs_admin_user WHERE group_id in(17,50) AND job_status != '离职' AND is_install_worker = 1");
                else {
                    $expr_admin_user = $db->getAll("SELECT a.real_name,a.user_id
													FROM ecs_admin_user as a 
													join ecs_expr_nature as e on a.group_id = e.group_id
													WHERE job_status != '离职' AND is_install_worker = 1 and city_id in 
													(SELECT city_id FROM ecs_expr_nature where group_id = {$expr_flag['group_id']} 
													 ) group by user_id");
                }
                $smarty->assign('expr_admin_user', $expr_admin_user);
                $smarty->assign('order_id', $order_id);
                $smarty->assign('rec_id_arr', implode(',', array_keys($goods_arr)));
                $smarty->display('expr_order_send.htm');
                exit;
            }
        }
        header("Location:/admin/order.php?act=info&order_id=" . $order_id);
        exit;
    } elseif (isset($_POST['return_expr'])) {
        admin_priv('expr_send_goods');
        $order_id = $_POST['order_id'];
        $operate = $_POST['operate'];

        if ($order_id) {
            $expr_flag = $db->getRow("SELECT info.order_status,info.shipping_status,info.is_received_pay FROM ecs_order_info info WHERE info.order_id = $order_id  AND is_received_pay = 1");
            if ($expr_flag) {
                $goods_arr = $_POST['goods_id'];
                if (count($goods_arr) < 1)
                    sys_msg('请选择要执行此操作的订单商品!');
                foreach ($goods_arr as $key => $v) {
                    $row = '';
                    $row = $db->getRow("SELECT rec_id,goods_sn FROM ecs_order_goods WHERE rec_id = $key AND (shipping_status = 1 OR shipping_status = 2)");
                    $rec_id = $row['rec_id'];
                    $goods_sn = $row['goods_sn'];
                    if (empty($rec_id))
                        sys_msg($goods_sn . '还未发货,不允许执行此操作!');
                }
                foreach ($goods_arr as $key => $v) {
                    $db->query("UPDATE ecs_order_goods SET expr_goods_status = 2 WHERE rec_id = $key");
                    $action .= "设置" . $v . "为已退货,";
                }
                $db->query("INSERT INTO ecs_order_action(order_id,action_user,order_status,shipping_status,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $expr_flag['order_status'] . "','" . $expr_flag['shipping_status'] . "','" . trim($action, ',') . "','" . time() . "')");
            }
        }
        header("Location:/admin/order.php?act=info&order_id=" . $order_id);
        exit;
    } elseif (isset($_POST['service_expr'])) {
        admin_priv('expr_send_goods');
        $order_id = $_POST['order_id'];
        $operate = $_POST['operate'];

        if ($order_id) {
            $expr_flag = $db->getRow("SELECT info.order_status,info.shipping_status,info.is_received_pay FROM ecs_order_info info WHERE info.order_id = $order_id  AND is_received_pay = 1");
            if ($expr_flag) {
                $goods_arr = $_POST['goods_id'];
                if (count($goods_arr) < 1)
                    sys_msg('请选择要执行此操作的订单商品!');
                foreach ($goods_arr as $key => $v) {
                    $row = '';
                    $row = $db->getRow("SELECT rec_id,goods_sn FROM ecs_order_goods WHERE rec_id = $key AND (shipping_status = 1 OR shipping_status = 2)");
                    $rec_id = $row['rec_id'];
                    $goods_sn = $row['goods_sn'];
                    if (empty($rec_id))
                        sys_msg($goods_sn . '还未发货,不允许执行此操作!');
                }
                foreach ($goods_arr as $key => $v) {
                    $db->query("UPDATE ecs_order_goods SET expr_goods_status = 3 WHERE rec_id = $key");
                    $action .= "设置" . $v . "为有售后问题,";
                }
                $db->query("INSERT INTO ecs_order_action(order_id,action_user,order_status,shipping_status,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $expr_flag['order_status'] . "','" . $expr_flag['shipping_status'] . "','" . trim($action, ',') . "','" . time() . "')");
            }
        }
        header("Location:/admin/order.php?act=info&order_id=" . $order_id);
        exit;
    } else if (isset($_POST['invaild'])) {
        $order_info = $db->getRow("SELECT `order_status`,`shipping_status`,`pay_status` FROM ecs_order_info where `order_id` = {$order_id}");
        if ($order_info['pay_status'] == 0) {//订单未付款
            if ($order_info['shipping_status'] == 0) {//订单未发货
                $db->query("UPDATE `ecs_order_info` set order_status = 3 where order_id = {$order_id}");
                if ($db->affected_rows()) {
                    header("Location:/admin/order.php?act=info&order_id=" . $order_id);
                    exit;
                }
            }
            sys_msg('已发货订单无法修改');
        }
        sys_msg('已付款订单无法修改');
    }

    $show_group_id = $db_select->getOne("SELECT `group_id` FROM `ecs_admin_user` WHERE user_id = {$_SESSION['admin_id']}");
    // 是否展示体验馆调货订单修正
    if($show_group_id == 67 && admin_priv('expr_order_allocate'))
        $smarty->assign('show_expr_radio', '1');

    /* 直接处理还是跳到详细页面 */
    if (($require_note && $action_note == '') || isset($show_invoice_no) || isset($show_refund)) {
        /* 模板赋值 */
        $smarty->assign('require_note', $require_note); // 是否要求填写备注
        $smarty->assign('action_note', $action_note);   // 备注
        $smarty->assign('show_cancel_note', isset($show_cancel_note)); // 是否显示取消原因
        $smarty->assign('show_invoice_no', isset($show_invoice_no)); // 是否显示发货单号
        $smarty->assign('show_refund', isset($show_refund)); // 是否显示退款
        $smarty->assign('anonymous', isset($anonymous) ? $anonymous : true); // 是否匿名
        $smarty->assign('order_id', $order_id); // 订单id
        $smarty->assign('batch', $batch);   // 是否批处理
        $smarty->assign('operation', $operation); // 操作

        /* 显示模板 */
        $month_pay = array('0' => '请选择', '1' => '1月份', '2' => '2月份', '3' => '3月份', '4' => '4月份', '5' => '5月份', '6' => '6月份', '7' => '7月份', '8' => '8月份', '9' => '9月份', '10' => '10月份', '11' => '11月份', '12' => '12月份');
        $smarty->assign('month_pay', $month_pay);
        $smarty->assign('month_pay_defalt', 0);
        $smarty->assign('ur_here', $_LANG['order_operate'] . $action);
        assign_query_info();
        $smarty->display('order_operate.htm');
    } else {
        /* 直接处理 */
        if (!$batch) {
            //$smarty->assign('goods_list_str',    $goods_list_str);
            /* 一个订单 */
            header("Location: order.php?act=operate_post&order_id=" . $order_id .
                    "&goods_id_str=" . urlencode($goods_id_str) .
                    "&operation=" . $operation . "&action_note=" . urlencode($action_note) . "\n");
            exit;
        } else {
            /* 多个订单 */
            header("Location: order.php?act=batch_operate_post&order_id=" . $order_id .
                    "&operation=" . $operation . "&action_note=" . urlencode($action_note) . "\n");
            exit;
        }
    }
} else if ($_REQUEST['act'] == 'order_cancel') { //取消订单
    $order_id = $_REQUEST['order_id'];

    if (empty($order_id))
        sys_msg('请选择要取消的订单');
    /*
      $g = $db->getOne("SELECT group_id FROM meilele_group WHERE group_leader_id = ".$_SESSION['admin_id']." AND code = 'is_salesman'");
      if(!$g)
      sys_msg('只有销售组长才能取消订单!');
     */
    $order = $db->getRow("SELECT * FROM ecs_order_info WHERE order_id = $order_id");
    if ($order['pay_status'] != 0 && can_cancel_order($order_id))
        sys_msg('已付款的订单，不能取消');

    if ($order['order_status'] == 2)
        sys_msg('已取消的订单，不能再次取消');
    //检测是否有发货单
    if (checkInvoiceBill($order_id))
        sys_msg('有发货单，不能取消');

    /* 检查是否有限购物品 */
    $goods_info = $db->getAll("SELECT eog.goods_id,sum(eog.goods_number) as goods_number from ecs_order_goods as eog
							   join ecs_goods as eg ON eg.goods_id = eog.goods_id and eg.limit_sale = 2 and eog.goods_number != 0 
							   WHERE order_id = $order_id group by goods_id");

    foreach ($goods_info as $v) {
        updateLimitSale($v['goods_id'], $v['goods_number']);
    }
    /* 检查完毕 */
    $arr = array('order_status' => 2);

    if ($order['order_type'] != 'patch_order') {
        update_order($order_id, $arr);
        order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], $order['pay_status'], '取消订单');
    }
    if (ERP_FLAG == 1) {
        $type = $db->getOne("SELECT order_type FROM ecs_order_info WHERE order_id = $order_id LIMIT 1");
        if ($type == 'patch_order') {
            $ret = http_request1('receivePathchOrderFromPhp', array('class'=>'com.meilele.purchase.vo.PatchOrderVo', 'orderId'=>$order_id, 'mark'=>'cancel'), array('user_name' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));   
        } else {
            $ret = http_request('wsCancelOrder', array('class' => "com.meilele.crmsfa.order.vo.OrderCancelVO", "orderId" => (String) $order_id, "userLoginId" => $_SESSION['admin_name']), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
        }
        $ret = json_decode($ret, TRUE);
        if ($ret['code'] != 1)
            sys_msg($ret['msg']);
    }
    if ($order['order_type'] == 'patch_order') {

        update_order($order_id, $arr);
        $db->query("UPDATE ecs_order_extend SET patch_comfirm = 0 WHERE order_id = $order_id LIMIT 1");
        order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], $order['pay_status'], '取消订单');
    }
    $link[] = array('text' => $_LANG['back_list'], 'href'=>'/admin/order.php?act=info&order_id='.$order_id);
    sys_msg('取消成功!', 0, $link);
}
elseif ($_REQUEST['act'] == 'send_process') {
    admin_priv('expr_send_goods');
    $order_id = $_POST['order_id'];
    if ($order_id) {
        $expr_flag = $db->getRow("SELECT info.order_status,info.pay_status,info.order_sn,info.add_time,info.group_id,info.shipping_status,info.is_received_pay FROM ecs_order_info info WHERE info.order_id = $order_id");
        if ($expr_flag) {
        	if($expr_flag['shipping_status'] !=2)
        	{
        		sys_msg('请先对订单收货确认!');
        	}
			if($expr_flag['pay_status'] !=2)
        	{
        		sys_msg('订单状态不是已付款，不能做此操作!');
        	}
            //$exists = $db->getOne("SELECT salary_order_id FROM meilele_salary_order WHERE order_sn = '".$expr_flag['order_sn']."'");
            //if($exists)
            //	sys_msg('该订单已经报过单，不能执行此操作!');
            $goods_arr = $_POST['goods_id'];
            $goods_arr = explode(',', $goods_arr);
            if (count($goods_arr) < 1)
                sys_msg('请选择要执行此操作的订单商品!');
            if ($expr_flag['add_time'] < strtotime('2011-10-01 00:00:01'))
                sys_msg('只有11月开始的订单才有此设置');
                $db->query("SELECT GET_LOCK('ecs_expr_install_lock_".$order_id."',3)"); //获取控制权
            foreach ($goods_arr as $key => $v) {
                $row = '';
                $row = $db->getRow("SELECT rec_id,goods_sn FROM ecs_order_goods WHERE rec_id = $v AND (shipping_status = 1 OR shipping_status = 2)");
                $rec_id = $row['rec_id'];
                $goods_sn = $row['goods_sn'];
                if ($row['goods_sn'] == 'MLL体验馆服务费')
                    sys_msg('服务费不允许执行此操作!');
                if (empty($rec_id))
                    sys_msg($goods_sn . '还未发货,不允许执行此操作!');
                $install_id = $db->getOne("SELECT install_id FROM ecs_expr_install WHERE order_rec_id = $rec_id");
                if (!empty($install_id))
                    sys_msg('该订单商品已经设置过安装师傅!');
            }
            $db->query("SELECT RELEASE_LOCK('ecs_expr_install_lock_".$order_id."')"); //释放控制权
            foreach ($goods_arr as $key => $v) {
                $db->query("UPDATE ecs_order_goods SET expr_goods_status = 1 WHERE rec_id = $v");
                setExprInstall($v, $order_id);
            }
            $db->query("INSERT INTO ecs_order_action(order_id,action_user,order_status,shipping_status,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $expr_flag['order_status'] . "','" . $expr_flag['shipping_status'] . "','" . trim($action, ',') . "','" . time() . "')");
        }
    }
    header("Location:/admin/order.php?act=info&order_id=" . $order_id);
    exit;
}
/* ------------------------------------------------------ */
//-- 操作订单状态（处理批量提交）
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'batch_operate_post') {
    /* 取得参数 */
    $order_id = $_REQUEST['order_id'];        // 订单id（逗号格开的多个订单id）
    $operation = $_REQUEST['operation'];       // 订单操作
    $action_note = $_REQUEST['action_note'];     // 操作备注

    /* 初始化处理的订单sn */
    $sn_list = array();

    /* 确认 */
    if ('confirm' == $operation) {
        /* 取得未确认的订单 */
        $sql = "SELECT * FROM " . $ecs->table('order_info') .
                " WHERE order_sn " . db_create_in($order_id) .
                " AND order_status = '" . OS_UNCONFIRMED . "'";
        $res = $db->query($sql);
        while ($order = $db->fetchRow($res)) {
            /* 检查能否操作 */
            $operable_list = operable_list($order);
            if (!isset($operable_list[$operation])) {
                continue;
            }

            $order_id = $order['order_id'];

            /* 标记订单为已确认 */
            update_order($order_id, array('order_status' => OS_CONFIRMED, 'confirm_time' => time()));
            update_order_amount($order_id);

            /* 记录log */
            order_action($order['order_sn'], OS_CONFIRMED, SS_UNSHIPPED, PS_UNPAYED, $action_note);

            /* 发送邮件 */
            if ($_CFG['send_confirm_email'] == '1') {
                $tpl = get_mail_template('order_confirm');
                $smarty->assign('order', $order);
                $smarty->assign('shop_name', $_CFG['shop_name']);
                $smarty->assign('send_date', date($_CFG['date_format']));
                $smarty->assign('sent_date', date($_CFG['date_format']));
                $content = $smarty->fetch('str:' . $tpl['template_content']);
                send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html']);
            }

            $sn_list[] = $order['order_sn'];
        }
    }

    /* 无效 */ elseif ('invalid' == $operation) {
        /* 取得未付款、未发货的订单 */
        $sql = "SELECT * FROM " . $ecs->table('order_info') .
                " WHERE order_sn " . db_create_in($order_id) . order_query_sql('unpay_unship');
        $res = $db->query($sql);
        while ($order = $db->fetchRow($res)) {
            /* 检查能否操作 */
            $operable_list = operable_list($order);
            if (!isset($operable_list[$operation])) {
                continue;
            }

            $order_id = $order['order_id'];

            /* 标记订单为“无效” */
            update_order($order_id, array('order_status' => OS_INVALID));

            /* 记录log */
            order_action($order['order_sn'], OS_INVALID, SS_UNSHIPPED, PS_UNPAYED, $action_note);

            /* 如果使用库存，且下订单时减库存，则增加库存 */
            if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE) {
                change_order_goods_storage($order_id, false);
            }

            /* 发送邮件 */
            if ($_CFG['send_invalid_email'] == '1') {
                $tpl = get_mail_template('order_invalid');
                $smarty->assign('order', $order);
                $smarty->assign('shop_name', $_CFG['shop_name']);
                $smarty->assign('send_date', date($_CFG['date_format']));
                $smarty->assign('sent_date', date($_CFG['date_format']));
                $content = $smarty->fetch('str:' . $tpl['template_content']);
                send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html']);
            }

            /* 退还用户余额、积分、红包 */
            return_user_surplus_integral_bonus($order);

            $sn_list[] = $order['order_sn'];
        }
    } elseif ('cancel' == $operation) {
        /* 取得未付款、未发货的订单 */
        $sql = "SELECT * FROM " . $ecs->table('order_info') .
                " WHERE order_sn " . db_create_in($order_id) . order_query_sql('unpay_unship');
        $res = $db->query($sql);
        while ($order = $db->fetchRow($res)) {
            /* 检查能否操作 */
            $operable_list = operable_list($order);
            if (!isset($operable_list[$operation])) {
                continue;
            }

            $order_id = $order['order_id'];

            /* 标记订单为“取消”，记录取消原因 */
            $cancel_note = trim($_REQUEST['cancel_note']);
            update_order($order_id, array('order_status' => OS_CANCELED, 'to_buyer' => $cancel_note));

            /* 记录log */
            order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], PS_UNPAYED, $action_note);

            /* 如果使用库存，且下订单时减库存，则增加库存 */
            if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE) {
                change_order_goods_storage($order_id, false);
            }

            /* 发送邮件 */
            if ($_CFG['send_cancel_email'] == '1') {
                $tpl = get_mail_template('order_cancel');
                $smarty->assign('order', $order);
                $smarty->assign('shop_name', $_CFG['shop_name']);
                $smarty->assign('send_date', date($_CFG['date_format']));
                $smarty->assign('sent_date', date($_CFG['date_format']));
                $content = $smarty->fetch('str:' . $tpl['template_content']);
                send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html']);
            }

            /* 退还用户余额、积分、红包 */
            return_user_surplus_integral_bonus($order);

            $sn_list[] = $order['order_sn'];
        }
    } elseif ('remove' == $operation) {
        $order_id_list = explode(',', $order_id);
        foreach ($order_id_list as $id) {
            /* 检查能否操作 */
            /* 检查能否操作 */
            $is_leader = $db->getOne("SELECT is_leader FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);
            if ($is_leader != 1)
                sys_msg('您没有权限删除此订单!');
            $order = order_info('', $id);
            $operable_list = operable_list($order);
            if (!isset($operable_list['remove'])) {
                continue;
            }
            //备份删除的订单
            backup_del_order($order[order_id]);
            sys_msg('禁止删除订单!');
            /* 删除订单 */
            // $db->query("DELETE FROM ".$ecs->table('order_info'). " WHERE order_id = '$order[order_id]'");
            //$db->query("DELETE FROM ".$ecs->table('order_goods'). " WHERE order_id = '$order[order_id]'");
            // $db->query("DELETE FROM ".$ecs->table('order_action'). " WHERE order_id = '$order[order_id]'");

            /* todo 记录日志 */
            admin_log($order['order_sn'], 'remove', 'order');

            $sn_list[] = $order['order_sn'];
        }
    }
    /* 前台不显示 */ else if ('no_display' == $operation) {
        $order_id_list = explode(',', $order_id);
        foreach ($order_id_list as $id) {
            $db->query("UPDATE " . $ecs->table('order_info') . " SET display_in_front=0 WHERE order_sn='$id'");
            $sn_list[] = $order['order_sn'];
        }
    } else {
        die('invalid params');
    }

    /* 取得备注信息 */
    $action_note = $_REQUEST['action_note'];

    /* 返回信息 */
    $msg = count($sn_list) == 0 ? $_LANG['no_fulfilled_order'] : $_LANG['updated_order'] . join($sn_list, ',');
    $links[] = array('text' => $_LANG['return_list'], 'href' => 'order.php?act=list&' . list_link_postfix());
    sys_msg($msg, 0, $links);
}

/* ------------------------------------------------------ */
//-- 操作订单状态（处理提交）
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'operate_post') {
    /* 取得参数 */
    $order_id = $_REQUEST['order_id'];        // 订单id
    $operation = $_REQUEST['operation'];       // 订单操作
    //$goods_list_str = $_REQUEST['goods_list_str'];   // 订单操作明细商品编号列表
    $goods_id_str = $_REQUEST['goods_id_str'];   // 订单操作明细商品编号列表


    /* 查询订单信息 */
    $order = order_info($order_id);

    /* 检查能否操作 */
    $operable_list = operable_list($order);
    if (!isset($operable_list[$operation])) {
        die('请先确认订单');
    }
    if ($operation != 'confirm' && $order['order_type'] == 'normal' && $order['pre_ship_status'] == 'unsure') {
        $count = $db->getOne("SELECT count(*) from ecs_order_goods where order_id = '{$order_id}'and shipping_status = 0 and (plan_send_time = 0 or plan_send_time is null)");
        if ($count) {
            echo "<script language='javascript'>alert('请先设置订单预计发货时间！');location.href='/admin/order.php?act=set_order_send_time&order_id=" . $order_id . "'</script>";
            exit;
        }
    }
    /* 取得备注信息 */

    $action_note = $_REQUEST['action_note'];

    /* 初始化提示信息 */
    $msg = '';

    /* 确认 */
    if ('confirm' == $operation) {

        //检测是否为装修设计订单,如果是,则给装修设计组发送邮件
        if(chack_fitment_by_id($order_id))
            send_mail_fitment_group($order_id);

        $order_old_data = $db->getROW("SELECT order_status,goods_amount,shipping_fee from ecs_order_info where order_id = {$order_id}");

        /* 标记订单为已确认 */
        if ($order_old_data['order_status'] != OS_CANCELED)
            update_order($order_id, array('order_status' => OS_CONFIRMED, 'confirm_time' => time()));
        else {
            /* 检查是否有限购物品 */
            $goods_info = $db->getAll("SELECT eog.goods_id,sum(eog.goods_number) as goods_number from ecs_order_goods as eog
									   join ecs_goods as eg ON eg.goods_id = eog.goods_id and (eg.limit_sale = 2 or eg.limit_sale = 1) and eog.goods_number != 0 
									   WHERE order_id = $order_id group by goods_id");

            foreach ($goods_info as $v) {
                updateLimitSale($v['goods_id'], $v['goods_number'], 'sub');
            }
            /* 检查完毕 */
            update_order($order_id, array('order_status' => OS_CONFIRMED, 'confirm_time' => time()));
        }
        update_order_amount($order_id);
        expr_auto_create_user($order_id); //判断是否需要自动创建账号
        if (ERP_FLAG == 1) {
            if ($order_old_data['order_status'] != OS_CANCELED)
                $result = http_request('wsApprovedOrder', array('class' => 'com.meilele.crmsfa.order.vo.OrderApprovedVO', 'updateFlag' => 'approvedOrder', 'orderId' => (String) $order_id, 'userLoginId' => $_SESSION['admin_name']), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
            else
                $result = http_request('wsRestoreOrder', array('class' => 'com.meilele.crmsfa.order.vo.OrderRestoreVO', 'orderId' => (String) $order_id, 'userLoginId' => 'admin', 'grandTotal' => $order_old_data['goods_amount']), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
        }
        /* 记录log */
        order_action($order['order_sn'], OS_CONFIRMED, SS_UNSHIPPED, PS_UNPAYED, $action_note);

        /* 如果原来状态不是“未确认”，且使用库存，且下订单时减库存，则减少库存 */
        if ($order['order_status'] != OS_UNCONFIRMED && $_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE) {
            change_order_goods_storage($order_id);
        }
        if ($order['order_type'] == 'patch_order') {
            $db->query("UPDATE ecs_order_info SET pay_status = 2 WHERE order_id = $order_id LIMIT 1");
			$db->query("UPDATE ecs_order_extend SET next_send = 1 WHERE order_id = $order_id LIMIT 1");
            if ($order_old_data['shipping_fee']) {
                $db->query("UPDATE ecs_order_extend SET ship_pay_status = 1 WHERE order_id = $order_id LIMIT 1");
            }
        }        
        /* 发送邮件 */
        $cfg = $_CFG['send_confirm_email'];
        if ($cfg == '1') {
            $tpl = get_mail_template('order_confirm');
            $smarty->assign('order', $order);
            $smarty->assign('shop_name', $_CFG['shop_name']);
            $smarty->assign('send_date', date($_CFG['date_format']));
            $smarty->assign('sent_date', date($_CFG['date_format']));
            $content = $smarty->fetch('str:' . $tpl['template_content']);
            if (!send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
                $msg = $_LANG['send_mail_fail'];
            }
        }
    }
    /* 付款 */ elseif ('pay' == $operation) {
        /* 标记订单为已确认、已付款，更新付款时间和已支付金额，如果是货到付款，同时修改订单为“收货确认” */
        if ($order['order_status'] != OS_CONFIRMED) {
            $arr['order_status'] = OS_CONFIRMED;
            $arr['confirm_time'] = time();
        }
        $arr['pay_status'] = PS_PAYED;
        $arr['pay_time'] = time();
        $arr['money_paid'] = $order['money_paid'] + $order['order_amount'];
        $arr['already_pay'] = $order['money_paid'] + $order['order_amount'];
        $arr['order_amount'] = 0;
        $payment = payment_info($order['pay_id']);
        if ($payment['is_cod']) {
            $arr['shipping_status'] = SS_RECEIVED;
            $order['shipping_status'] = SS_RECEIVED;
        }
        update_order($order_id, $arr);

        /* 记录log */
        order_action($order['order_sn'], OS_CONFIRMED, $order['shipping_status'], PS_PAYED, $action_note);
    }
    /* 设为未付款 */ elseif ('unpay' == $operation) {
        /* 标记订单为未付款，更新付款时间和已付款金额 */
        $arr = array(
            'pay_status' => PS_UNPAYED,
            'pay_time' => 0,
            'money_paid' => 0,
            'order_amount' => $order['money_paid']
        );
        update_order($order_id, $arr);

        /* todo 处理退款 */
        $refund_type = @$_REQUEST['refund'];
        $refund_note = @$_REQUEST['refund_note'];
        order_refund($order, $refund_type, $refund_note);

        /* 记录log */
        order_action($order['order_sn'], OS_CONFIRMED, SS_UNSHIPPED, PS_UNPAYED, $action_note);
    }
    /* 配货 */ elseif ('prepare' == $operation) {
        /* 标记订单为已确认，配货中 */
        if ($order['order_status'] != OS_CONFIRMED) {
            $arr['order_status'] = OS_CONFIRMED;
            $arr['confirm_time'] = time();
        }
        $arr['shipping_status'] = SS_PREPARING;
        //修改商品为配货中
        $goods_id_str = $_REQUEST['goods_id_str'];
        if ($goods_id_str) {
            $sql = "SELECT goods_sn FROM `ecs_order_goods` WHERE rec_id in($goods_id_str) AND shipping_status !='" . SS_SHIPPED . "' AND shipping_status !='" . SS_PREPARING . "'";
            $_goods_sn_str = '';
            $res = $db->query($sql);
            while (($row = $db->fetchRow($res)) !== false) {
                $_goods_sn_str = empty($_goods_sn_str) ? $row['goods_sn'] : $_goods_sn_str . '，' . $row['goods_sn'];
            }
            $sql = "UPDATE ecs_order_goods SET shipping_status = " . SS_PREPARING . " WHERE rec_id in($goods_id_str) AND shipping_status !='" . SS_SHIPPED . "'";
            $db->query($sql);
            if ($db->affected_rows()) {
                $action_note .= " 以下商品被修改：{$_goods_sn_str}";
            } else {
                $action_note = '没有商品被修改！';
            }
        }
        update_order($order_id, $arr);
        /* 记录log */
        $sql = "SELECT count(*) FROM `ecs_order_goods` WHERE order_id = '$order_id'";
        $sum = $db->getOne($sql);
        $sql = "SELECT count(*) FROM `ecs_order_goods` WHERE order_id = '$order_id' AND shipping_status = '3'";
        $_sum = $db->getOne($sql);
        //配货完成
        if ($GLOBALS['_CFG']['sdk_distribution_finished'] == '1' && $sum == $_sum) {
            send_user_sms($order_id, 'distribution_finished');
        }
        order_action($order['order_sn'], OS_CONFIRMED, SS_PREPARING, $order['pay_status'], $action_note);

        /* 清除缓存 */
        clear_cache_files();
    }
    /* 预留 */ elseif ('reserve' == $operation) {

        $ship_sel = $_REQUEST['ship_sel'];

        if ($ship_sel) {
            foreach ($ship_sel AS $item) {
                handle_reserve($item); // 处理一个商品的保留。出库，保留，改状态
            }
        }
    } elseif ('reserve_cancel' == $operation) {  // 取消商品预留
        $goods_arr = split(",", $goods_id_str);
        foreach ($goods_arr AS $key => $value) {
            cancel_reserve($value);
        }
    }




    /* 发货 */ elseif ('ship' == $operation) {

        exit('系统已禁用此功能！');

        $orderinfo = $db->getRow("SELECT order_id, order_type FROM ecs_order_info WHERE order_id = $order_id LIMIT 1");
        //判断是否是仓库管理员操作
        $sql = "SELECT ew.name FROM `ecs_admin_user` AS eau
                LEFT JOIN `ecs_warehouse` AS ew ON eau.warehouse_id=ew.warehouse_id
                WHERE eau.user_id = '{$_SESSION['admin_id']}' AND ew.expr_id=0";
        $wh_name = $db->getOne($sql);

        $sql = "SELECT `group_id` FROM `ecs_admin_user` WHERE user_id = {$_SESSION['admin_id']}";
        $group_id = $db_select->getOne($sql);
        if (!$wh_name && !($orderinfo['order_type'] == 'patch_order' && admin_priv('goods_ship', '', false))) {
            sys_msg('只在佛山仓库管理才能操作！');
        }
        /* 取得发货单号 */
        $invoice_no = $_REQUEST['invoice_no'];
        $car_comp = $_REQUEST['car_comp'];
        $car_tel = $_REQUEST['car_tel'];

        $packages_num = $_REQUEST['packages_num'];
        $car_fee = $_REQUEST['car_fee'];

        $ship_sel = $_REQUEST['ship_sel'];

        $info = array();
        $info['car_comp'] = $car_comp;
        $info['car_tel'] = $car_tel;
        $info['packages_num'] = $packages_num;
        $info['car_fee'] = $car_fee;
        $info['invoice_no'] = $invoice_no;

        //判断有没有已发货的产品
        $sql = "SELECT count(*) FROM `ecs_order_goods` WHERE order_id = '{$order['order_id']}' AND shipping_status = '1'";
        $_sum = $db->getOne($sql);

        /* 对虚拟商品的支持 */
        $virtual_goods = get_virtual_goods($order_id);
        if (!empty($virtual_goods)) {
            if (!virtual_goods_ship($virtual_goods, $msg, $order['order_sn'])) {
                sys_msg($msg);
            }
        }

        /* 标记订单为已确认 “已发货” */


        $goods_id_arr = split(",", $goods_id_str);

        if ($order['order_status'] != OS_CONFIRMED) {
            // $arr['order_status']    = OS_CONFIRMED;
            $arr['confirm_time'] = time();
        }

        $arr['shipping_time'] = time();
        $arr['invoice_no'] = $invoice_no;

        $action_note = "【订单直接出货】" . $action_note;
        set_order_goods_shipping_status($order_id, $goods_id_arr, $operation);
        //订单直接出货，添加到表里进行记录
        add_order_goods_to_ship($goods_id_arr);
        $shipping_status = get_order_ship_status($order_id, $goods_id_arr, $operation);

        $arr['shipping_status'] = $shipping_status;
        $arr['last_shipping'] = time();

        /*
         * 更新订单主表信息：
         */
        update_order($order_id, $arr);


        $order['invoice_no'] = $invoice_no;

        $action_note = $action_note . "\r\n单号：" . $invoice_no .
                "\r\n 物流：" . $car_comp .
                "\r\n查货电话:" . $car_tel .
                "\r\n包装件数:" . $packages_num .
                "\r\n发货费用:" . $car_fee
        ;

        /* 记录log */
        order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], $action_note);

        log_shiping_notices($order['order_id'], $order['order_sn'], $order['consignee'], $order['$tel'], $order['mobile'], $order['province'], $order['city']);









        /* 如果订单用户不为空，计算积分，并发给用户；发红包 */
        if ($order['user_id'] > 0) {
            /* 取得用户信息 */
            $user = user_info($order['user_id']);

            /* 计算并发放积分 */
            $integral = integral_to_give($order);
            log_account_change($order['user_id'], 0, 0, $integral, $integral, sprintf($_LANG['order_gift_integral'], $order['order_sn']));

            /* 发放红包 */
            send_order_bonus($order_id);
        }

        /* 如果使用库存，且发货时减库存，则修改库存 */
        if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_SHIP) {
            change_order_goods_storage($order['order_id']);
        }

        /* 发送邮件 */
        $cfg = $_CFG['send_ship_email'];
        if ($cfg == '1') {
            $tpl = get_mail_template('deliver_notice');
            $smarty->assign('order', $order);
            $smarty->assign('send_time', date($_CFG['time_format']));
            $smarty->assign('shop_name', $_CFG['shop_name']);
            $smarty->assign('send_date', date($_CFG['date_format']));
            $smarty->assign('sent_date', date($_CFG['date_format']));
            $smarty->assign('confirm_url', $ecs->url() . 'receive.php?id=' . $order['order_id'] . '&con=' . rawurlencode($order['consignee']));
            $smarty->assign('send_msg_url', $ecs->url() . 'user.php?message_list&order_id=' . $order['order_id']);
            $content = $smarty->fetch('str:' . $tpl['template_content']);
            if (!send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
                $msg = $_LANG['send_mail_fail'];
            }
        }

        /* 如果需要，发短信 */
        if ($GLOBALS['_CFG']['sms_order_shipped'] == '1' && $order['mobile'] != '') {
            include_once('../includes/cls_sms.php');
            $sms = new sms();
            $sms->send($order['mobile'], sprintf($GLOBALS['_LANG']['order_shipped_sms'], $order['order_sn'], local_time($GLOBALS['_LANG']['sms_time_format']), $GLOBALS['_CFG']['shop_name']), 0);
        }

        //发货时给用户发送短信
        $sql = "SELECT expr_id,send_sms FROM `ecs_order_info` WHERE order_id='{$order['order_id']}'";
        $_order_inf = $db->getRow($sql);
        if ($_order_inf['send_sms'] && $GLOBALS['_CFG']['sdk_shipping'] == '1' || $GLOBALS['_CFG']['sdk_add_shipping'] == '1') {
            //判断是发货还是补发
            if ($_sum == 0 && $GLOBALS['_CFG']['sdk_shipping'] == '1') {
                if ($_order_inf['expr_id'] > 0) {
                    send_user_sms($order['order_id'], 'expr_shipping', $info); //体验馆发货
                } else {
                    send_user_sms($order['order_id'], 'shipping', $info); //发货
                }
            } elseif ($GLOBALS['_CFG']['sdk_add_shipping'] == '1') {
                send_user_sms($order['order_id'], 'add_shipping', $info); //补发
            }
        }

        /* 给销售同事发邮件提醒 */
        @send_shipping_affiche($goods_id_arr, $order['order_id']);
        /* 给客户发邮件提醒 */
        @send_shipping_affiche($goods_id_arr, $order['order_id'], true);

        /* 清除缓存 */
        clear_cache_files();
    } elseif ('transfer_add' == $operation) {
        $transfer_info = $GLOBALS['db']->getOne("SELECT transfer_info FROM ecs_order_info WHERE order_id='$order_id'");
        $transfer_info = $transfer_info . date("Y-m-d H:i:s") . ' ' . $action_note;
        $transfer_info = addslashes($transfer_info) . '\n';
        $sql = "UPDATE ecs_order_info SET transfer_info='$transfer_info' WHERE order_id='$order_id'";
        $GLOBALS['db']->query($sql);
    } elseif ('transfer_update' == $operation) {
        $transfer_info = $action_note;
        $transfer_info = addslashes($transfer_info);
        $sql = "UPDATE ecs_order_info SET transfer_info='$transfer_info' WHERE order_id='$order_id'";
        $GLOBALS['db']->query($sql);
    }

    /* 设为未发货 */ elseif ('unship' == $operation) {
        $goods_id_str = $_REQUEST['goods_id_str'];



        $goods_arr = split(",", $goods_id_str);

        set_order_goods_shipping_status($order_id, $goods_arr, 'unship');

        $shipping_status = get_order_ship_status($order_id, $goods_arr, $operation);

        /* 标记订单为“未发货”，更新发货时间 */
        update_order($order_id, array('shipping_status' => $shipping_status, 'shipping_time' => 0));

        //set_order_goods_shipping_status($order_id, $goods_arr ,$operation );

        /* 记录log */
        order_action($order['order_sn'], $order['order_status'], SS_UNSHIPPED, $order['pay_status'], $action_note);

        /* 如果订单用户不为空，计算积分，并退回 */
        if ($order['user_id'] > 0) {
            /* 取得用户信息 */
            $user = user_info($order['user_id']);

            /* 计算并退回积分 */
            $integral = integral_to_give($order);
            log_account_change($order['user_id'], 0, 0, (-1) * $integral, (-1) * $integral, sprintf($_LANG['return_order_gift_integral'], $order['order_sn']));

            /* todo 计算并退回红包 */
            return_order_bonus($order_id);
        }

        /* 如果使用库存，则增加库存 */
        if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_SHIP) {
            change_order_goods_storage($order['order_id'], false);
        }

        /* 清除缓存 */
        clear_cache_files();
    }
    /* 收货确认 */ elseif ('receive' == $operation) {
        //确认收货修改
        if (!receiveConfirm($order_id)) {
            $result['error'] = 1;
            $result['message'] = '订单发货方向为体验馆，请先收货，再制作发货单发货！';
            die('订单发货方向为体验馆，请先收货，再制作发货单发货！');
        }

        /* 标记订单为“收货确认”，如果是货到付款，同时修改订单为已付款 */
        $arr = array('shipping_status' => SS_RECEIVED);
        $payment = payment_info($order['pay_id']);
        if ($payment['is_cod']) {
            $arr['pay_status'] = PS_PAYED;
            $order['pay_status'] = PS_PAYED;
        }

        update_order($order_id, $arr);
		$order_type = $db_select->getOne("SELECT order_type FROM ecs_order_info WHERE order_id = ".$order_id);
		if($order_type != 'patch_order')
		{
			require_once('includes/lib_custom.php');
			$month_pay_recive_order = trim($_REQUEST['month_pay']);
			
			insertReceiveOrder($order_id, $month_pay_recive_order);
		}
        /* 记录log */
        order_action($order['order_sn'], $order['order_status'], SS_RECEIVED, $order['pay_status'], $action_note);
    }
    /* 取消 */ elseif ('cancel' == $operation) {
        $goods_id_str = $_REQUEST['goods_id_str'];
        $goods_id_arr2 = split(",", $goods_id_str);

        // 只有未发货状态的，才能做订单取消操作，如果其它状态，需要改到"未发货状态"

        $sql = "select rec_id,goods_price,goods_number,goods_id from " . $GLOBALS['ecs']->table('order_goods') . " where  shipping_status =" . SS_UNSHIPPED . " and rec_id " . db_create_in($goods_id_arr2);
        $match_ids = $GLOBALS['db']->getAll($sql);

        $goods_id_arr = array();
        $cp_goods_price = 0;
        foreach ($match_ids AS $key => $value) {
            //updateLimitSale($value['goods_id'],$value['goods_number'],'add');
            $goods_id_arr[count($goods_id_arr)] = $value['rec_id'];
            $cp_goods_price = $cp_goods_price + $value['goods_price'] * $value['goods_number'];
            if (ERP_FLAG == 1) {
                $row = $db->getRow('SELECT order_item_seq_id,goods_number FROM ecs_order_goods WHERE rec_id = ' . $value['rec_id']);
                $_orderItems[] = array('orderItemSeqId' => (String) $row['order_item_seq_id'], 'quantity' => '0');
            }
        }


        set_order_goods_shipping_status($order_id, $goods_id_arr, $operation);

        $os_status = is_order_canceled($order_id, $goods_id_arr, $operation);
        $ss_status = get_order_shipping_status($order_id);

        /* 标记订单为“取消”，记录取消原因 */
        $cancel_note = isset($_REQUEST['cancel_note']) ? trim($_REQUEST['cancel_note']) : '';

        $action_note = $action_note . "\r\n取消原因：" . $cancel_note;
        $cp_order_amount = $order['order_amount'] - ($cp_goods_price - $order['surplus'] - $order['integral_money'] - $order['bonus']);
        $arr = array(
            'order_status' => $os_status,
            'to_buyer' => $cancel_note,
            'shipping_status' => $ss_status,
            'goods_amount' => $order['goods_amount'] - $cp_goods_price,
            // 'pay_time'      => 0,
            //'money_paid'    => 0,
            'order_amount' => $cp_order_amount
        );
        update_order($order_id, $arr);
        if (ERP_FLAG == 1) { //取消订单项
            $_erp_data = $db->getRow("SELECT goods_amount,discount,already_pay,bonus,shipping_fee FROM ecs_order_info WHERE order_id = $order_id");
            $_erp_item['class'] = 'com.meilele.crmsfa.order.vo.UpdateOrderItemQuantityVO';
            $_erp_item['orderId'] = (String) $order_id;
            $_erp_item['grandTotal'] = $_erp_data['goods_amount'];
            $_erp_item['remainingSubTotal'] = $_erp_data['goods_amount'] - $_erp_data['already_pay'] - $_erp_data['bonus'] - $_erp_data['discount'] + $_erp_data['shipping_fee'];
            $_erp_item['orderItems'] = $_orderItems;
            http_request('wsCancelOrderItem', $_erp_item, array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
        }
        /* todo 处理退款 */
        if ($order['money_paid'] > 0) {
            $refund_type = $_REQUEST['refund'];
            $refund_note = $_REQUEST['refund_note'];
            order_refund($order, $refund_type, $refund_note);
        }

        /* 记录log */
        order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], PS_UNPAYED, $action_note);

        /* 如果使用库存，且下订单时减库存，则增加库存 */
        if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE) {
            change_order_goods_storage($order_id, false);
        }

        /* 退还用户余额、积分、红包 */
        return_user_surplus_integral_bonus($order);
        cancelOrderGoods($order_id);
        /* 发送邮件 */
        $cfg = $_CFG['send_cancel_email'];
        if ($cfg == '1') {
            $tpl = get_mail_template('order_cancel');
            $smarty->assign('order', $order);
            $smarty->assign('shop_name', $_CFG['shop_name']);
            $smarty->assign('send_date', date($_CFG['date_format']));
            $smarty->assign('sent_date', date($_CFG['date_format']));
            $content = $smarty->fetch('str:' . $tpl['template_content']);
            if (!send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
                $msg = $_LANG['send_mail_fail'];
            }
        }
    }
    /* 设为无效 */ elseif ('invalid' == $operation) {
        /* 标记订单为“无效”、“未付款” */
        update_order($order_id, array('order_status' => OS_INVALID));

        /* 记录log */
        order_action($order['order_sn'], OS_INVALID, $order['shipping_status'], PS_UNPAYED, $action_note);

        /* 如果使用库存，且下订单时减库存，则增加库存 */
        if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE) {
            change_order_goods_storage($order_id, false);
        }
        $res = $db->getAll("SELECT goods_id,goods_number FROM ecs_order_goods WHERE order_id = " . $order_id);
        /* foreach($res as $value)
          {
          updateLimitSale($value['goods_id'],$value['goods_number'],'add');
          } */
        /* 发送邮件 */
        $cfg = $_CFG['send_invalid_email'];
        if ($cfg == '1') {
            $tpl = get_mail_template('order_invalid');
            $smarty->assign('order', $order);
            $smarty->assign('shop_name', $_CFG['shop_name']);
            $smarty->assign('send_date', date($_CFG['date_format']));
            $smarty->assign('sent_date', date($_CFG['date_format']));
            $content = $smarty->fetch('str:' . $tpl['template_content']);
            if (!send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
                $msg = $_LANG['send_mail_fail'];
            }
        }

        /* 退货用户余额、积分、红包 */
        return_user_surplus_integral_bonus($order);
    }
    /* 退货 */ elseif ('return' == $operation) {
        /* 标记订单为“退货”、“未付款”、“未发货” */
        $arr = array('order_status' => OS_RETURNED,
            'pay_status' => PS_UNPAYED,
            'shipping_status' => SS_UNSHIPPED,
            'money_paid' => 0,
            'order_amount' => $order['money_paid']);
        update_order($order_id, $arr);

        /* todo 处理退款 */
        if ($order['pay_status'] != PS_UNPAYED) {
            $refund_type = $_REQUEST['refund'];
            $refund_note = $_REQUEST['refund_note'];
            order_refund($order, $refund_type, $refund_note);
        }

        /* 记录log */
        order_action($order['order_sn'], OS_RETURNED, SS_UNSHIPPED, PS_UNPAYED, $action_note);

        /* 如果订单用户不为空，计算积分，并退回 */
        if ($order['user_id'] > 0) {
            /* 取得用户信息 */
            $user = user_info($order['user_id']);

            /* 计算并退回积分 */
            $integral = integral_to_give($order);
            log_account_change($order['user_id'], 0, 0, (-1) * $integral, (-1) * $integral, sprintf($_LANG['return_order_gift_integral'], $order['order_sn']));

            /* todo 计算并退回红包 */
            return_order_bonus($order_id);
        }

        /* 如果使用库存，则增加库存（不论何时减库存都需要） */
        if ($_CFG['use_storage'] == '1') {
            change_order_goods_storage($order['order_id'], false);
        }

        /* 退货用户余额、积分、红包 */
        return_user_surplus_integral_bonus($order);

        /* 清除缓存 */
        clear_cache_files();
    } elseif ('after_service' == $operation) {
        /* 记录log */
        $order_status4_upd = $order['order_status'];


        $arr = array('order_status' => OS_AFTER_SRV,
        );
        update_order($order_id, $arr);


        $order_status4_upd = OS_AFTER_SRV;

        order_action($order['order_sn'], $order_status4_upd, $order['shipping_status'], $order['pay_status'], '[' . $_LANG['op_after_service'] . '] ' . $action_note);
    } elseif ('assign_mech' == $operation) {

        $assign_user_id = $_REQUEST['assign_user_id'];
        $sql = "select user_name from ecs_admin_user where user_id = $assign_user_id  ";
        $assign_user_name = $db->getOne($sql);

        $arr = array('assign_status' => 'assigned', 'ship_merch' => $assign_user_id, 'ship_merch_name' => $assign_user_name);

        update_order($order_id, $arr);


        $op_desc = "订单分配";

        order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '[' . $op_desc . '] ' . $action_note);

        // 审计直接跳转,节省时间
        header('Location: order.php?act=info&order_id=' . $order_id);
    } elseif ('audit' == $operation) {
        /* 记录log */
        $order_status4_upd = $order['order_status'];

        $audit_status = $_REQUEST['audit'];

        $audit_amount = $_REQUEST['audit_amount'];
        $audit_amount = intval($audit_amount);

        $cost_amount = $_REQUEST['cost_amount'];
        $cost_amount = intval($cost_amount);


        if ($audit_status == "audit") {
            if ($audit_amount > 0) {


                $arr = array('audit_status' => $audit_status, 'audit_amount' => $audit_amount);
            } else {

                die("请录入审计金额!");
            }
            $op_desc = "财务审核通过 $audit_amount ";

            if ($cost_amount > 0) { //如果更新了成本，就更新成本
                $arr["cost_amount"] = $cost_amount;
                $op_desc .= " 更新基本成本： $cost_amount ";
            } else {

                $sql = "select sum(if (b.factory_price <=5 or isnull(b.factory_price) ,b.goods_price/1.3,b.factory_price) * b.goods_number )  from " . $ecs->table('order_goods') . "  b where b.order_id =$order_id and  (b.shipping_status = " . SS_UNSHIPPED . " or b.shipping_status = " . SS_SHIPPED . " )";

                $cost_sum = $db->getOne($sql);


                $arr["cost_amount"] = $cost_sum;
            }
        } else {
            $arr = array('audit_status' => $audit_status,
            );

            $op_desc = "财务审核拒绝 ";
        }

        update_order($order_id, $arr);


        order_action($order['order_sn'], $order_status4_upd, $order['shipping_status'], $order['pay_status'], '[' . $op_desc . '] ' . $action_note);

        // 审计直接跳转,节省时间
        header('Location: order.php?act=info&order_id=' . $order_id);
    } elseif ('ch_order_type' == $operation) {
        /* 记录log */
        $order_status4_upd = $order['order_status'];
        $new_order_type = $_REQUEST['order_type'];

        if($new_order_type == 'expr_order')
        {
            $show_group_id = $db->getOne("SELECT `group_id` FROM `ecs_admin_user` WHERE user_id = {$_SESSION['admin_id']}");
            if($show_group_id != 67 || !admin_priv('expr_order_allocate'))
                sys_msg('没有权限修改为此类型的订单!');
        }

        $is_dealer_order = $_REQUEST['set_dealer_order'];
        if (empty($is_dealer_order))
            $is_dealer_order = 0;
        //检测是否有发货单
        if (checkInvoiceBill($_REQUEST['order_id']))
            sys_msg('该订单已经有发货单，不允许更改订单类型!');
        $arr = array('order_type' => $new_order_type,
            'is_dealer_order' => $is_dealer_order);
        update_order($order_id, $arr);
        order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '[更改订单类型 --' . $new_order_type . '] ' . $action_note);
    }



    elseif ('close_service' == $operation) {
        /* 记录log */
        $order_status4_upd = $order['order_status'];


        $arr = array('order_status' => OS_CONFIRMED,
        );
        update_order($order_id, $arr);


        $order_status4_upd = OS_CONFIRMED;

        order_action($order['order_sn'], $order_status4_upd, $order['shipping_status'], $order['pay_status'], '[' . $_LANG['op_after_service'] . '] ' . $action_note);
    } else {
        die('invalid params');
    }

    /* 操作成功 */
    $links[] = array('text' => $_LANG['order_info'], 'href' => 'order.php?act=info&order_id=' . $order_id);
    sys_msg($_LANG['act_ok'] . $msg, 0, $links);
} elseif ($_REQUEST['act'] == 'json') {
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON();

    $func = $_REQUEST['func'];
    $out_type = $_REQUEST['out_type'];
    $out_id = $_REQUEST['out_id'];
    if ($func == 'get_goods_info') {
        /* 取得商品信息 */
        $goods_id = $_REQUEST['goods_id'];
        if (preg_match("/([A-Za-z])/", $goods_id)) {
            $goods_id = $db->getOne("SELECT goods_id FROM ecs_goods WHERE goods_sn = '".$goods_id."' LIMIT 1");
        }
        $sql = "SELECT goods_id,limit_sale,g.is_delete, c.cat_name, goods_sn, goods_name,goods_spec,factory_price,goods_sn_ori,goods_name_ori, b.brand_name, " .
                "goods_number, market_price, shop_price, goods_brief, goods_type, is_promote " .
                "FROM " . $ecs->table('goods') . " AS g " .
                "LEFT JOIN " . $ecs->table('brand') . " AS b ON g.brand_id = b.brand_id " .
                "LEFT JOIN " . $ecs->table('category') . " AS c ON g.cat_id = c.cat_id " .
                " WHERE goods_id = '$goods_id'";
        $goods = $db->getRow($sql);
        $today = time();


        $_goods_info = getGoodsPrice_type($goods['goods_id']);
        $goods['out_type'] = $out_type;
        $goods['out_id'] = $out_id;
        $goods['goods_price'] = $_goods_info['show_price'];
        $goods['action'] = $_goods_info['action'];
        $goods['discount_price'] = $_goods_info['discount_price'];


        if ($_goods_info['is_logistics_info'] && $_GET['ship_type'] == 2) {
            $goods['goods_price'] = $_goods_info['is_logistics_info']['show_price'];
            $goods['action'] = $_goods_info['is_logistics_info']['action'];
        }


        /* 取得会员价格 */
        $sql = "SELECT p.user_price, r.rank_name " .
                "FROM " . $ecs->table('member_price') . " AS p, " .
                $ecs->table('user_rank') . " AS r " .
                "WHERE p.user_rank = r.rank_id " .
                "AND p.goods_id = '$goods_id' ";
        $goods['user_price'] = $db->getAll($sql);

        //包件数
        $sql = "select count(*) AS package_sum FROM `ecs_stock_goods` AS esg LEFT JOIN `ecs_stock_goods_package_info` AS esgpi ON esg.stock_id=esgpi.stock_id " .
                "where esg.goods_sn='{$goods['goods_sn']}'";
        $goods['package_sum'] = $GLOBALS['db']->getOne($sql);
        /* 限购信息 */
        $_g_num = getGoodsStockInfoLimit($goods_id, $goods['limit_sale']);
        if ($goods['limit_sale'] == 2) {

            $goods['stock_number'] = $_g_num['stock_number']; //人工限购
        } else if ($goods['limit_sale'] == 1) {

            $goods['stock_number'] = $_g_num['stock_number'] - $_g_num['order_number']; //系统限购
        }
        $goods['stock_number'] = (int) $goods['stock_number'];
        /* 取得商品属性 */
        $sql = "SELECT a.attr_id, a.attr_name, g.goods_attr_id, g.attr_value, g.attr_price " .
                "FROM " . $ecs->table('goods_attr') . " AS g, " .
                $ecs->table('attribute') . " AS a " .
                "WHERE g.attr_id = a.attr_id " .
                "AND g.goods_id = '$goods_id' ";
        $goods['attr_list'] = array();
        $res = $db->query($sql);
        while ($row = $db->fetchRow($res)) {
            $goods['attr_list'][$row['attr_id']][] = $row;
        }
        $goods['attr_list'] = array_values($goods['attr_list']);

        if(chack_fitment_by_id($goods_id, 2))
            $goods['decorate'] = '1';

        echo $json->encode($goods);
    }
}

/* ------------------------------------------------------ */
//-- 合并订单
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'ajax_merge_order') {
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON();

    $from_order_sn = empty($_POST['from_order_sn']) ? '' : substr($_POST['from_order_sn'], 1);
    $to_order_sn = empty($_POST['to_order_sn']) ? '' : substr($_POST['to_order_sn'], 1);

    $m_result = merge_order($from_order_sn, $to_order_sn);
    $result = array('error' => 0, 'content' => '');
    if ($m_result === true) {
        $result['message'] = $GLOBALS['_LANG']['act_ok'];
    } else {
        $result['error'] = 1;
        $result['message'] = $m_result;
    }
    die($json->encode($result));
}

/* ------------------------------------------------------ */
//-- 删除订单
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'remove_order') {
    $order_id = intval($_REQUEST['id']);

    /* 检查权限 */
    check_authz_json('order_edit');

    /* 检查订单是否允许删除操作 */
    /* 检查能否操作 */
    $is_leader = $db->getOne("SELECT is_leader FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);
    if ($is_leader != 1)
        sys_msg('您没有权限删除此订单!');
    $order = order_info($order_id);
    $operable_list = operable_list($order);
    if (!isset($operable_list['remove'])) {
        make_json_error('Hacking attempt');
        exit;
    }
    if ($order['money_paid'] > 0) {
        make_json_error('不能删除，有付款');
        exit;
    }

    //备份删除的订单
    backup_del_order($order_id);
    sys_msg('禁止删除订单');
    // $GLOBALS['db']->query("DELETE FROM ".$GLOBALS['ecs']->table('order_info'). " WHERE order_id = '$order_id'");
    // $GLOBALS['db']->query("DELETE FROM ".$GLOBALS['ecs']->table('order_goods'). " WHERE order_id = '$order_id'");
    // $GLOBALS['db']->query("DELETE FROM ".$GLOBALS['ecs']->table('order_action'). " WHERE order_id = '$order_id'");

    if ($GLOBALS['db']->errno() == 0) {
        $url = 'order.php?act=query&' . str_replace('act=remove_order', '', $_SERVER['QUERY_STRING']);

        header("Location: $url\n");
        exit;
    } else {
        make_json_error($GLOBALS['db']->errorMsg());
    }
}

/* ------------------------------------------------------ */
//-- 根据关键字和id搜索用户
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'search_users') {
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON();

    $id_name = empty($_GET['id_name']) ? '' : trim($_GET['id_name']);

    $result = array('error' => 0, 'message' => '', 'content' => '');
    if ($id_name != '') {
        $sql = "SELECT user_id, user_name FROM " . $GLOBALS['ecs']->table('users') .
                " WHERE user_id LIKE '%" . mysql_like_quote($id_name) . "%'" .
                " OR user_name LIKE '%" . mysql_like_quote($id_name) . "%'" .
                " LIMIT 20";
        $res = $GLOBALS['db']->query($sql);

        $result['userlist'] = array();
        while ($row = $GLOBALS['db']->fetchRow($res)) {
            $result['userlist'][] = array('user_id' => $row['user_id'], 'user_name' => $row['user_name']);
        }
    } else {
        $result['error'] = 1;
        $result['message'] = 'NO KEYWORDS!';
    }

    die($json->encode($result));
}

/* ------------------------------------------------------ */
//-- 根据关键字搜索商品
/* ------------------------------------------------------ */ 
elseif ($_REQUEST['act'] == 'search_goods') {
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON();

    $keyword = empty($_GET['keyword']) ? '' : trim($_GET['keyword']);
    $keyword = urldecode($keyword);

    $all = empty($_GET['all']) ? '' : trim($_GET['all']);
    if ($all != '') {
        $extra = "";
    }


    $result = array('error' => 0, 'message' => '', 'content' => '');
    $keyword = trim($keyword);
    if ($keyword != '') {
        $sql = "SELECT a.goods_id ,b.ship_type, a.goods_name, a.goods_sn FROM " . $GLOBALS['ecs']->table('goods') .
                " as a LEFT join ecs_goods_extend as b ON a.goods_id = b.parent_id WHERE 1 " .
                $extra .
                // " AND is_delete = 0 " .
                // " AND is_on_sale = 1" .
                //  " AND is_alone_sale = 1" .

                " AND  (a.goods_id LIKE '%" . mysql_like_quote($keyword) . "%'" .
                " OR a.goods_name LIKE '%" . mysql_like_quote($keyword) . "%'" .
                " OR a.goods_sn LIKE '%" . mysql_like_quote($keyword) . "%') " .
                " LIMIT 50";

        $res = $GLOBALS['db']->query($sql);
        $result['goodslist'] = array();
        while ($row = $GLOBALS['db']->fetchRow($res)) {
            $result['goodslist'][] = array('goods_id' => $row['goods_id'], 'name' => $row['goods_id'] . '  ' . $row['goods_name'] . '  ' . $row['goods_sn']);
        }
    } else {
        $result['error'] = 1;
        $result['message'] = 'NO KEYWORDS';
    }


    die($json->encode($result));
}

/* ------------------------------------------------------ */
//-- 根据关键字搜索商品
/* ------------------------------------------------------ */ 
elseif ($_REQUEST['act'] == 'search_goods_without_delete') {
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON();

    $keyword = empty($_GET['keyword']) ? '' : trim($_GET['keyword']);
    $keyword = urldecode($keyword);
    
    $extra = "  AND is_delete = 0  AND is_on_sale = 1 " ;
    if($_REQUEST['ship_type'] == 2){
    	$extra .= 'AND b.ship_type = 2';
    }
    
    $all = empty($_GET['all']) ? '' : trim($_GET['all']);
    //$extra = "  AND is_delete = 0  AND is_on_sale = 1 " ;
    if ($all != '') {
        $extra = "";
    }


    $result = array('error' => 0, 'message' => '', 'content' => '');
    $keyword = trim($keyword);
    if ($keyword != '') {
        $sql = "SELECT a.goods_id, a.goods_name, a.goods_sn FROM " . $GLOBALS['ecs']->table('goods') .
                " as a LEFT join ecs_goods_extend as b ON a.goods_id = b.parent_id WHERE 1 " .
                $extra .
                " AND is_delete = 0 " .
                // " AND is_on_sale = 1" .
                //  " AND is_alone_sale = 1" .

                " AND (a.goods_id LIKE '%" . mysql_like_quote($keyword) . "%'" .
                " OR a.goods_name LIKE '%" . mysql_like_quote($keyword) . "%'" .
                " OR a.goods_sn LIKE '%" . mysql_like_quote($keyword) . "%') " .
                " LIMIT 50";
                
        $res = $GLOBALS['db']->query($sql);
        $result['goodslist'] = array();
        while ($row = $GLOBALS['db']->fetchRow($res)) {
            $result['goodslist'][] = array('goods_id' => $row['goods_id'], 'name' => $row['goods_id'] . '  ' . $row['goods_name'] . '  ' . $row['goods_sn']);
        }
    } else {
        $result['error'] = 1;
        $result['message'] = 'NO KEYWORDS';
    }
    die($json->encode($result));
}


/* ------------------------------------------------------ */
//-- 编辑收货单号
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'edit_invoice_no') {
    /* 检查权限 */
    check_authz_json('order_edit');

    $no = empty($_POST['val']) ? 'N/A' : trim($_POST['val']);
    $no = $no == 'N/A' ? '' : $no;
    $order_id = empty($_POST['id']) ? 0 : intval($_POST['id']);

    if ($order_id == 0) {
        make_json_error('NO ORDER ID');
        exit;
    }

    $sql = 'UPDATE ' . $GLOBALS['ecs']->table('order_info') . " SET invoice_no='$no' WHERE order_id = '$order_id'";
    if ($GLOBALS['db']->query($sql)) {
        if (empty($no)) {
            make_json_result('N/A');
        } else {
            make_json_result(stripcslashes($no));
        }
    } else {
        make_json_error($GLOBALS['db']->errorMsg());
    }
}

/* ------------------------------------------------------ */
//-- 编辑付款备注
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'edit_pay_note') {
    /* 检查权限 */
    check_authz_json('order_edit');

    $no = empty($_POST['val']) ? 'N/A' : trim($_POST['val']);
    $no = $no == 'N/A' ? '' : $no;
    $order_id = empty($_POST['id']) ? 0 : intval($_POST['id']);

    if ($order_id == 0) {
        make_json_error('NO ORDER ID');
        exit;
    }

    $sql = 'UPDATE ' . $GLOBALS['ecs']->table('order_info') . " SET pay_note='$no' WHERE order_id = '$order_id'";
    if ($GLOBALS['db']->query($sql)) {
        if (empty($no)) {
            make_json_result('N/A');
        } else {
            make_json_result(stripcslashes($no));
        }
    } else {
        make_json_error($GLOBALS['db']->errorMsg());
    }
} elseif ($_REQUEST['act'] == 'order_from') { //修改订单来源
    $order_id = $_REQUEST['order_id'];
    $store_type = $_REQUEST['store_type'];
    $is_leader = $db->getOne("SELECT is_leader FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);
    if (!$is_leader)
        sys_msg('只有店长有权更改此设置!');
    if ($order_id && $store_type) {
        if ($store_type == 2) {
            $store_type = 1;
            $log = '修改订单来源为直属店';
        } else {
            $store_type = 2;
            $log = '修改订单来源为加盟店';
        }
        $db->query("UPDATE ecs_order_info SET store_type = $store_type WHERE order_id = $order_id");
        $row = $db->getRow("SELECT order_status,pay_status,shipping_status FROM ecs_order_info WHERE order_id = $order_id");
        $db->query("INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . $log . "','" . time() . "')");
        sys_msg('处理成功!');
    }
}
/* ------------------------------------------------------ */
//-- 显示所有待发货的订单商品 tatezhou
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'wait_ship_goods') {
    // echo " 显示所有待发货的订单商品 tatezhou";

    $brand_id = empty($_GET['brand_id']) ? '' : trim($_GET['brand_id']);



    $brand_list_sql = "select brand_id, brand_name from ecs_brand order by brand_name ";

    $brand_list = $GLOBALS['db']->getAll($brand_list_sql);




    $goods4order_sql = "select a.order_id,a.order_sn,a.order_status,a.shipping_status,a.pay_status,a.consignee,a.wangwang,
							b.goods_sn,b.goods_sn,b.goods_name,b.goods_number,b.market_price,b.goods_price,b.factory_price ,b.goods_attr,  b.factory_price * b.goods_number AS total_price, b.extension_code
						from  ecs_order_info a join ecs_order_goods b on a.order_id = b.order_id 
                       		  join ecs_goods c on b.goods_sn = c.goods_sn  
                              join ecs_brand d on c.brand_id  = d.brand_id
 						where a.order_status = 1 
  								and ( a.shipping_status = 0 or a.shipping_status =  4) 
 								and b.shipping_status =  0 ";
    if ($brand_id <> '') {

        $goods4order_sql = $goods4order_sql . " and d.brand_name = \"$brand_id\" order by b.goods_sn";
    }



    include_once(ROOT_PATH . 'includes/lib_order.php');
    // echo $goods4order_sql;

    $all_goods_row = $GLOBALS['db']->getAll($goods4order_sql);



    $smarty->assign('goods_list', $all_goods_row);
    $smarty->assign('row_count', count($all_goods_row));
    $smarty->assign('brand_list', $brand_list);

    if ($_REQUEST['type'] == 'print')
        $smarty->display('wait_ship_goods_print.htm');
    else
        $smarty->display('wait_ship_goods.htm');
}
elseif ($_REQUEST['act'] == 'print_express_bill') {

    $order_id = $_REQUEST['order_id'];


    $sql = " select consignee , address, mobile, tel from " . $GLOBALS['ecs']->table('order_info') . " where order_id = $order_id";
    $order_info = $GLOBALS['db']->getRow($sql);

    $express_list = array();
    $express_list[] = $order_info;

    $smarty->assign('express_list', $express_list); // 操作

    $smarty->display('patch_express_print.html');
}

/* ------------------------------------------------------ */
//-- 修改经销单标记
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'toggle_setdealer') {
    check_authz_json('order_edit');

    $order_id = intval($_POST['id']);
    $is_dealer_order = intval($_POST['val']);

    if ($exc->edit("is_dealer_order = '$is_dealer_order'", $order_id)) {
        clear_cache_files();
        make_json_result($is_dealer_order);
    }
} elseif ($_REQUEST['act'] == 'owner_order') { //订单归属者
    $order_id = $_REQUEST['order_id'];
    $_row = $db->getRow("SELECT order_ship_type,admin_id,order_status,order_type,pre_ship_status FROM ecs_order_info WHERE order_id = " . $order_id);
    $admin_id = $_row['admin_id'];

    if ($_row['order_status'] == 0)
        sys_msg('请先确认订单!');

    if ($admin_id && strpos($admin_id, '|' . $_SESSION['admin_id'] . '|') === false && !checkOwnerOrder('owner_order')) {
        $is_leader = $db->getOne("SELECT is_leader FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);
        if ($is_leader == 0)
            sys_msg('您没有权限修改此订单信息!');
    }

    $check_result = check_order_plan_send_time($order_id);

    if ($check_result && $_row['order_type'] == 'normal' && $_row['pre_ship_status'] == 'unsure') {//$check_result 暂时屏蔽掉
        $error_msg = '设置订单归属之前请设置以下商品预计发货时间:';
        foreach ($check_result as $v) {
            $error_msg .= "<br/>商品名：{$v['goods_name']} 商品编号: {$v['goods_sn']} 数量：{$v['goods_number']}";
        }
        $link[0]['text'] = "设置预计发货时间";
        $link[0]['href'] = "/admin/order.php?act=set_order_send_time&order_id=$order_id";
        sys_msg($error_msg, 0, $link);
    }

    $nocheck = $db->getOne('SELECT order_type FROM ecs_order_info WHERE order_id=' . $order_id);
    if($nocheck == 'patch_order')
        if(empty($_POST['group_id']))
            $_POST['group_id'] = 8;

    if ($_POST['group_id'] && $_POST['user_id']) {
        $group_id = $_POST['group_id'];
        $user_id = $_POST['user_id'];
        
        
        
        
        /*归属体验馆之间有权限判断*/
        $check_group = $db->getOne("SELECT group_id from ecs_order_info where group_id != {$group_id} and order_id = {$order_id}");
       	if($check_group){
       		$tb = $db->getOne("SELECT group_id from ecs_admin_user where (user_name = 'MLL_TB' and user_id = {$_SESSION['admin_id']}) or (action_list = 'all' and user_id = {$_SESSION['admin_id']})");
       		if(!$tb){
       			sys_msg('订单归属不允许变更销售组,没有归属的订单不允许自己归属。如果确实有这种需要，请联系网站销售组负责人帮助处理!');
       		}
       	}
        $admin_name = $db->getOne("SELECT user_name FROM ecs_admin_user WHERE user_id = $user_id");
        $leader_id = $db->getOne("SELECT group_leader_id FROM meilele_group WHERE group_id = " . $group_id);
        $partner_name = $_POST['partner_name'];
        $admin_user_list = array();
        if (!empty($partner_name)) {
            $arr = explode('|', $partner_name);
            foreach ($arr as $v) {
                if ($v) {
                    $row = $db->getRow("SELECT user_id,user_name FROM ecs_admin_user WHERE real_name = '" . $v . "' AND job_status != '离职'");
                    $uid[] = $row['user_id'];
                    $admin_user_list[]['userLoginId'] = $row['user_name'];
                }
            }
            $admin_id = '|' . implode('|', $uid) . '|';
        } else {
            $admin_id = '|' . $user_id . '|';
            $user_name = $db->getOne("SELECT user_name FROM ecs_admin_user WHERE user_id = '" . $user_id . "'");
            $admin_user_list[]['userLoginId'] = $user_name;
        }

        if (checkInvoiceBill($_REQUEST['order_id'])) {
            $db->query("UPDATE ecs_order_info SET group_id = " . $group_id . ",admin_id='" . $admin_id . "',leader_id = " . $leader_id . " WHERE order_id = $order_id");
        } else {
            $is_expr = $db->getRow("SELECT expr_name,expr_id from ecs_expr_nature where group_id = {$group_id}");
            if ($is_expr) {
            if($_row['order_ship_type'] == 1){
                $db->query("UPDATE ecs_order_info SET ship_direction = {$is_expr['expr_id']}, group_id = " . $group_id . ",admin_id='" . $admin_id . "',leader_id = " . $leader_id . " WHERE order_id = $order_id");
                $notes = "{$_REQUEST['notes']} (设置订单归属时自动设置发货方向为:{$is_expr['expr_name']})";
            }else{
                $db->query("UPDATE ecs_order_info SET  group_id = " . $group_id . ",admin_id='" . $admin_id . "',leader_id = " . $leader_id . " WHERE order_id = $order_id");
            }
                $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $_row['order_status'] . "','" . $_row['shipping_status'] . "','" . $_row['pay_status'] . "','" . time() . "','" . $notes . "','" . time() . "')";
                $db->query($sql);
            }else
                $db->query("UPDATE ecs_order_info SET group_id = " . $group_id . ",admin_id='" . $admin_id . "',leader_id = " . $leader_id . " WHERE order_id = $order_id");
        }

        /*
          `mll_order_belonging`、`mll_order_amount_stat` 表操作 wyd
         */
        if ($_POST['partner_name']) {
            $users = explode('|', $_POST['partner_name']);
            $order_id = $_GET['order_id'];
            $order_sn = $db->getOne("select `order_sn` from `ecs_order_info` where `order_id`='$order_id'");
            $db->query("delete from `mll_order_belonging` where `order_id`='$order_id'");
            foreach ($users as $user) {
                $user_info = $db->getRow("select `user_id`,`group_id` from `ecs_admin_user` where `real_name`='$user'");
                $user_id = $user_info['user_id'];
                $group_id = $user_info['group_id'];
                $insert_sql = "insert into `mll_order_belonging` set `order_id`='$order_id',`order_sn`='$order_sn',`user_id`='$user_id',`group_id`='$group_id'";
                $db->query($insert_sql);
            }
        } else {
            $order_id = $_GET['order_id'];
            $order_sn = $db->getOne("select `order_sn` from `ecs_order_info` where `order_id`='$order_id'");
            $db->query("delete from `mll_order_belonging` where `order_id`='$order_id'");
            $user_id = $_POST['user_id'];
            $group_id = $_POST['group_id'];
            $insert_sql = "insert into `mll_order_belonging` set `order_id`='$order_id',`order_sn`='$order_sn',`user_id`='$user_id',`group_id`='$group_id'";
            $db->query($insert_sql);
        }
        $sql = "select count(*) from `mll_order_belonging` where `order_id`='$order_id'";
        $num = $db->getOne($sql);
        $upd_sql = "update `mll_order_amount_stat` set `user_num`=$num WHERE `order_id`='$order_id'";
        $db->query($upd_sql);
        //Array ( [group_id] => 95 [user_id] => 1857 [partner_name] => xuhao|wangyidong )
        //Array ( [act] => owner_order [order_id] => 106716 )
        //print_r($_POST);
        //print_r($_GET);
        if (ERP_FLAG == 1)
            http_request('wsOrderAttribution', array('orderId' => 'mllo_' . $order_id, 'userLoginId' => $admin_user_list), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
        $info = $db->getRow("SELECT order_status,shipping_status,pay_status FROM ecs_order_info WHERE order_id = " . $order_id);
        $db->query("INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $info['order_status'] . "','" . $info['shipping_status'] . "','" . $info['pay_status'] . "','修改订单归属者为$admin_name 订单归属组" . ".{$_POST['group_id']}','" . time() . "')");
        header("Location:/admin/order.php?act=list");
        exit;
    }
    if ($order_id) {
        $info = $db->getRow("SELECT order_sn,user_id,add_time FROM ecs_order_info WHERE order_id = " . $order_id);
        $cut_flag = strtotime("2012-05-30 09:00:00");
        if ($info['add_time'] >= $cut_flag)
            $group_list = $db->getAll("SELECT group_id,group_name FROM meilele_group WHERE code = 'is_salesman' AND group_id NOT IN(3,4,5,6)");
        else {
            $info['flag'] = true;
            $group_list = $db->getAll("SELECT group_id,group_name FROM meilele_group WHERE code = 'is_salesman' AND group_id NOT IN(94)");
        }
        $sort_tmp = array();
        $temp_array = array();
        foreach ($group_list as $k => $v) {
            $group_list[$k]['pinyin'] = Pinyin(sub_str($v['group_name'], 2), 'utf-8');
            $sort_tmp[$v['group_id']] = $group_list[$k]['pinyin'];
            $temp_array[$v['group_id']] = $group_list[$k];
        }
        $group_list_two = array();
        asort($sort_tmp);

        foreach ($sort_tmp as $k => $v) {
            $group_list_two[] = $temp_array[$k];
        }
        $smarty->assign('group_list', $group_list_two);
        $group_id = $db->getOne("SELECT group_id FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);

        //$sales_list = $db->getAll("SELECT user_id,real_name,user_name FROM ecs_admin_user  WHERE group_id in(SELECT group_id FROM meilele_group WHERE code = 'is_salesman')");
        $sales_list = $db->getAll("SELECT user_id,real_name,user_name FROM ecs_admin_user WHERE group_id = $group_id AND job_status != '离职' order by user_id asc");
        $smarty->assign('sales_list', $sales_list);
    }
    $smarty->assign('info', $info);
    $smarty->assign('user_id', $_SESSION['admin_id']);
    $smarty->assign('group_id', $group_id);
    $smarty->assign('order_id', $order_id);
    $smarty->display('owner_order.htm');
    exit;
} else if ($_REQUEST['act'] == 'get_saler') {
    $group_id = $_REQUEST['group_id'];
    if ($group_id) {
        $is_partner = $db->getOne("SELECT `is_partner` FROM `meilele_group` WHERE group_id = {$group_id}");
        if ($is_partner) {
            $res = $db->getAll("SELECT user_id,real_name,user_name FROM ecs_admin_user WHERE group_id = $group_id AND job_status != '离职' order by user_id asc");
        } else {
            $res = $db->getAll("SELECT user_id,real_name,user_name FROM ecs_admin_user WHERE group_id = $group_id AND is_personal =1 AND job_status != '离职' order by user_id asc");
        }
        foreach ($res as $v) {
            $arr[] = $v['user_name'] . '-' . $v['real_name'] . '_' . $v['user_id'];
        }
        die(json_encode($arr));
    }
} elseif ($_REQUEST['act'] == 'partpay') {
    /* 检查权限 */
    admin_priv('order_view');
    if ($_REQUEST['type'] != 'expr_quick')
        checkOrderAuth($_REQUEST['order_id']);
    $order_id = $_REQUEST['order_id'];
    if ($order_id) {
        $sql = "SELECT order_sn,goods_amount,already_pay,discount,consignee,order_status FROM ecs_order_info WHERE order_id = $order_id";
        $info = $db->getRow($sql);
        $info['total_fee'] = $info['goods_amount'] - $info['discount'];
        $the_reduce = getOrderShouldPay($order_id) - getOrder_receive_pay_goods($order_id);
        $trans_type = $db->getOne("SELECT trans_type from ecs_order_extend where order_id = {$order_id}");
        if ($_POST['already_pay']) {
        	
        	if($trans_type == 9){
        	$the_reduce = getOrderShouldPay($order_id) - getOrder_receive_pay_goods($order_id);
        	if($_POST['already_pay'] != $the_reduce){
        		sys_msg("第三方订单只能收款一次，并且一次付清！ 该订单应付 {$the_reduce} 实际付款 {$_POST['already_pay']} 请检查 谢谢");
        	}
        	}
            $way = $_POST['way']; //收款方式
            
            if($way == '现金'){
            	$admin_id = $db->getOne("SELECT user_id FROM ecs_admin_user where ((job_type = '财务助理') or (job_type = '店长' and is_leader = 1)) and user_id = {$_SESSION['admin_id']}");
            	if(!$admin_id){
            		sys_msg('现金收款只能是体验馆店长或则店长助理进行操作，请其他导购联系店长和店助。!');
            	}
            }
            $already_pay = $_POST['already_pay']; //收款金额

            if (empty($way) || empty($already_pay))
                sys_msg('收款金额或收款方式不允许为空!');
            $trade_no = trim($_POST['trade_no']);
            $this_pay = $already_pay;
            if ($trade_no) {
                $db->query("SELECT GET_LOCK('order_trade_no_lock',10)"); //获取控制权
                $sql = "SELECT count(audit_id) FROM ecs_audit_withdraw WHERE trade_no = '$trade_no' AND (audit_status = 'un_audit' OR audit_status = 'audit_ok' OR audit_status = 'auto_audit')";
                $num = $db->getOne($sql);
                unset($sql);
                if ($num >= 1)
                    sys_msg('收款交易号重复提交！');
            }
            $sql = "SELECT pay_status,user_id,already_pay,confirm_time,goods_amount,order_status,bonus,discount,shipping_status,order_amount,money_paid FROM ecs_order_info WHERE order_id = $order_id";
            $row = $db->getRow($sql);
            $pay_status = $row['pay_status'];
            if ($pay_status == 0 || $pay_status == 1 || $pay_status == 2) {
                $already_pay = $already_pay + $row['already_pay'];
                /* if($already_pay+$row['discount'] >= $row['goods_amount'])
                  {
                  $where = " already_pay = '$already_pay',order_amount = 0,money_paid = '$already_pay' ";
                  $note = ",已支付的金额大于等于订单金额，系统自动设为已付款";
                  }
                  else
                  {
                  $order_amount = $row['goods_amount'] - $_POST['already_pay'] - $row['bonus'] - $row['discount'];
                  $money_paid = $row['already_pay'] + $_POST['already_pay'];
                  $where = "order_status = 1,already_pay = '$already_pay',order_amount = '$order_amount',money_paid = '$money_paid'";
                  }
                  if($row['confirm_time'] == 0)$where .= " ,confirm_time = '".time."'"; */
                if ($row['order_status'] == 0) {
                    $db->query("UPDATE ecs_order_info SET order_status = 1,confirm_time = '" . time() . "' WHERE order_id = $order_id");
                    $db->query("INSERT INTO ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time,log_level) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','','确认订单','" . time() . "','0')");
                    expr_auto_create_user($order_id); //判断是否需要自动创建账号
                    if (ERP_FLAG == 1)
                        http_request('wsApprovedOrder', array('class' => 'com.meilele.crmsfa.order.vo.OrderApprovedVO', 'updateFlag' => 'approvedOrder', 'orderId' => (String) $order_id, 'userLoginId' => $_SESSION['admin_name']), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
                    $row['order_status'] = 1;
                }
                $audit_id = new_audit_withdraw($order_id, $this_pay, $_REQUEST['way'], $_POST['notes'], $trade_no);
                if ($trade_no) {
                    $db->query("SELECT RELEASE_LOCK('order_trade_no_lock')"); //释放控制权
                }
                if ($audit_id) {
                    $db->query("UPDATE ecs_order_info SET already_pay = already_pay+'" . $already_pay . "',pay_time='" . time() . "' WHERE order_id = $order_id");
                    $notes = '订单收款' . $_POST['already_pay'] . '元(待审核),流水号[' . $audit_id . ']';
                    $sql = "INSERT INTO ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','$notes','" . time() . "')";
                    $db->query($sql);
                    $order_type = $db->getOne("SELECT order_type FROM ecs_order_info WHERE order_id = $order_id LIMIT 1");
                    if ($order_type != 'patch_order') {
                        modifyOrderPayStatus($order_id);
                    }
                }
                if (strpos($_REQUEST['way'], '支付宝') !== FALSE)
                    $_pay_type = 'ALIPAY';
                else if (strpos($_REQUEST['way'], '网银在线') !== FALSE)
                    $_pay_type = 'BANK_UNION';
                else if (strpos($_REQUEST['way'], 'POS') !== FALSE)
                    $_pay_type = 'POS';
                else if (strpos($_REQUEST['way'], '加盟商预付款扣款') !== FALSE)
                    $_pay_type = 'CHARGEBACK';
                else if (strpos($_REQUEST['way'], '快钱') !== FALSE)
                    $_pay_type = 'POS';
                else if (strpos($_REQUEST['way'], '京东') !== FALSE)
                    $_pay_type = '360_BUY';
                else
                    $_pay_type = 'CASH';
                $params = array('class' => 'com.meilele.crmsfa.order.vo.SaleOrderPaymentsVO', 'auditId' => (String) $audit_id, 'orderId' => 'mllo_' . $order_id, 'paymentVO' => array('manualRefNum' => $trade_no, 'amount' => (String) $_POST['already_pay'], 'payType' => $_pay_type));
                if (ERP_FLAG == 1) {
                    $trade_no = empty($trade_no) ? "" : $trade_no;
                    $return = http_request("wsOrderPayment", $params, array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
                    $ret = json_decode($return, true);
                    /*
                      if(isset($return) && $ret['code'] == 1){
                      $db->query("UPDATE ecs_audit_withdraw SET paymentId = {$ret['successMessage']} WHERE audit_id = {$audit_id}");//新功能paymentID
                      } */
                }
            } else {
                echo "该订单状态不允许您在执行此操作";
                exit;
            }
            /*
              在这里先提示了再跳转 王宜东 2012-08-30
             */
            if ($_REQUEST['type'] == 'expr_quick') {
                $href = "/admin/expr.php?act=order_info&order_id=$order_id&md5=" . md5('mll_' . $row['user_id'] . $order_id);
                //header("Location:/admin/expr.php?act=order_info&order_id=$order_id&md5=".md5('mll_'.$row['user_id'].$order_id));
            } else {
                $href = "/admin/order.php?act=info&order_id=$order_id";
                //header("Location:/admin/order.php?act=info&order_id=$order_id");
            }
            $msg = '';
            if ($audit_id) {
                $trade_no = $db->getOne("SELECT `trade_no` FROM `ecs_audit_withdraw` WHERE `audit_id` = $audit_id");
                $msg = "操作成功!<br>本次操作的订单号是:" . $info['order_sn'] . ",交易流水号为:$audit_id,收款交易号是:$trade_no.";
            }
            sys_msg($msg, 0, array(array('href' => $href, 'text' => '订单信息')));
            unset($msg);
            exit;
        }
        $sql = "SELECT order_sn,goods_amount,already_pay,discount,consignee,order_status,shipping_fee,bonus FROM ecs_order_info WHERE order_id = $order_id";
        $info = $db->getRow($sql);
        $info['total_fee'] = $info['goods_amount'] - $info['discount'] - $info['bonus'] + $info['shipping_fee'];
        $receive_fee = getOrder_receive_pay_goods($order_id);
        
        
        
        
        $smarty->assign('trans_type', $trans_type);
        $smarty->assign('receive_fee', $receive_fee);
        $new_should_pay = $info['total_fee'] - $receive_fee;
        $smarty->assign('new_should_pay', $new_should_pay);
        $smarty->assign('order_id', $order_id);
        $smarty->assign('info', $info);
        $smarty->assign('type', $_REQUEST['type']);
        $smarty->display('order_part_pay.htm');
    }
} else if ($_REQUEST['act'] == 'discount') {
    $order_id = $_REQUEST['order_id'];
    $order = $db->getRow("SELECT * FROM ecs_order_info where order_id = {$order_id}");
    $tb = $db->getOne("SELECT group_id from ecs_admin_user where user_name = 'MLL_TB' and user_id = {$_SESSION['admin_id']}");
    if (!$tb && $order['add_time'] >= 1049704909 && $order['order_type'] != 'patch_order')
        sys_msg("2012年10月9日之后的订单目标金额不能修改");

    checkOrderAuth($_REQUEST['order_id']);

    $group_code = $db->getOne("select g.code from ecs_admin_user au left join meilele_group g on au.group_id=g.group_id  where user_id=" . $_SESSION['admin_id']); //售后没权限修改
    if ($group_code == 'is_trace_service') {
        sys_msg("您没有权限修改!");
        exit;
    }
    $sql = "SELECT `shipping_status` FROM ecs_order_info WHERE order_id = $order_id";
    $row = $db->getRow($sql);
    if ($row['shipping_status'] == 1) {
        sys_msg("已发货订单无法修改目标金额！");
        exit;
    }
    if ($_POST) {
        $sql = "SELECT * FROM ecs_order_info WHERE order_id = $order_id";
        $row = $db->getRow($sql);
        if ($row['shipping_status'] == 1) {
            sys_msg("已发货订单无法修改目标金额！");
            exit;
        }
        $discount_money = $_POST['discount_money'];
        if ($row['pay_status'] == 2 && $discount_money > $row['already_pay'])
            $where = ",pay_status = 1";

        $sql = "UPDATE ecs_order_info SET discount = '" . ($row['goods_amount'] - $discount_money) . "' $where WHERE order_id = $order_id";
        $db->query($sql);

        if (ERP_FLAG == 1) {
            if ($row['goods_amount'] - $discount_money >= 0)
                $array = array('orderAdjustmentTypeId' => 'DISCOUNT_ADJUSTMENT', 'orderId' => $row['order_id'], 'amount' => (String) ($row['goods_amount'] - $discount_money));
            else if ($row['goods_amount'] - $discount_money < 0) //服务费
                $array = array('orderAdjustmentTypeId' => 'SURCHARGE_ADJUSTMENT', 'orderId' => $row['order_id'], 'amount' => (String) abs($row['goods_amount'] - $discount_money));
            http_request('wsAddOrderAdjustment', $array, array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
        }

        //插入日志
        $notes = $_REQUEST['notes'] . "(管理员设置订单目标金额为" . $discount_money . ')';
        $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','" . $notes . "','" . time() . "')";
        $db->query($sql);
        if ($where) {
            $sql_u = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','目标金额大于已经支付金额，设置订单为付款中','" . time() . "')";
            $db->query($sql_u);
        }
        if ($_REQUEST['type'] == 1)
            header("Location:/admin/expr.php?act=order_list");
        else
            header("Location:/admin/order.php?act=info&order_id=" . $order_id);
        exit;
    }
    $sql = "SELECT order_sn,goods_amount,already_pay,consignee,discount FROM ecs_order_info WHERE order_id = $order_id";
    $info = $db->getRow($sql);
    $smarty->assign('order_id', $order_id);
    $smarty->assign('info', $info);
    $smarty->assign('expr_quick', $_REQUEST['type']);
    $smarty->display('order_discount.htm');

    //设置发货方向
}else if ($_REQUEST['act'] == 'ship_direction') {
    checkOrderAuth($_REQUEST['order_id']);
    $order_id = intval($_REQUEST['order_id']);
    //检测是否有发货单
    if (checkInvoiceBill($_REQUEST['order_id']))
        sys_msg('该订单已经有发货单，不允许更改订单发货方向!');
    if ($_POST) {
        $expr_id = intval($_REQUEST['ship_direction']);
        if ($expr_id > 0) {
            $sql = "SELECT expr_name FROM `ecs_expr_nature` WHERE expr_id='$expr_id'";
            $expr_name = $db->getOne($sql);

            if (!$expr_name) {
                sys_msg('体验馆不存在');
            }
        } else {
            $expr_name = '客户';
        }
        $sql = "SELECT order_status,shipping_status,pay_status FROM `ecs_order_info` WHERE order_id='$order_id'";
        $row = $db->getRow($sql);
        //更新
        $sql = "UPDATE `ecs_order_info` SET ship_direction='$expr_id',pre_ship_status = 'unsure' WHERE order_id='$order_id'";
        $db->query($sql);
        if ($db->affected_rows()) {
            //插入日志
            $notes = "{$_REQUEST['notes']} (管理员设置发货方向为:{$expr_name}) ";
            if( $expr_name == '客户')
            	$notes .=" 由于发货方向是客户 订单状态自动变成待确定";
            $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','" . $notes . "','" . time() . "')";
            $db->query($sql);
            if ($where) {
                $sql_u = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','目标金额大于已经支付金额，设置订单为付款中','" . time() . "')";
                $db->query($sql_u);
            }
            $orderinfo = $db->getRow("SELECT * FROM ecs_order_info WHERE order_id = $order_id LIMIT 1");
            if ($orderinfo['order_type'] != 'patch_order') {
                if (ERP_FLAG == 1) {
                    $shipTo = $expr_id;
                    $ret = http_request('setOrderShipToByPHP', array('orderId' => (String) $order_id, 'shipTo' => (String) $shipTo));
                    $ret = json_decode($ret, TRUE);
                    if ($ret['code'] != 1)
                        sys_msg('修改发货方向成功,但同步到ERP发生错误！');
                }
            }
        }else {
            sys_msg('修改发货方向失败！');
        }

        if ($_REQUEST['type'] == 1)
            header("Location:/admin/expr.php?act=order_list");
        else
            header("Location:/admin/order.php?act=info&order_id=" . $order_id);
        exit;
    }
    $sql = "SELECT ship_direction,order_sn,consignee,goods_amount FROM `ecs_order_info` WHERE order_id='$order_id'";
    $order_info = $db->getRow($sql);
    $smarty->assign('info', $order_info);
    $sql = "SELECT expr_id,expr_name FROM `ecs_expr_nature`";
    $expr_list = $db->getAll($sql);
    $smarty->assign('order_id', $order_id);
    $smarty->assign('expr_list', $expr_list);
    $smarty->display('order_ship_direction.htm');
}else if ($_REQUEST['act'] == 'export') {
    include('includes/cls_phpzip.php');
    $zip = new PHPzip();

    $order_id = $_REQUEST['order_id'];
    require(dirname(__FILE__) . '/PHPExcel.php'); //加入PHPExcel类
    if (empty($_REQUEST['order_id']) || !is_numeric($_REQUEST['order_id'])) {
        die('Hacking Attemp1');
        exit();
    }


    $info = $db->getRow("SELECT `add_time`,`order_sn`,`postscript`,`consignee` FROM " . $ecs->table("order_info") . " WHERE `order_id`=$order_id");

    $_row = $db->getAll("SELECT `brand_id` FROM " . $ecs->table("order_goods") . " WHERE `order_id`=$order_id group by `brand_id`");
    $sum = count($_row);
    //多个品牌

    if ($sum > 1) {
        header("Content-Disposition: attachment; filename=Procurement_roder.zip");
        header("Content-Type: application/unknown");
        for ($_i = 0; $_i < $sum; $_i++) {
            //$row = $db->getAll("SELECT a.*,b.goods_img FROM ". $ecs->table ( "order_goods" ) ."AS a LEFT JOIN " .$ecs->table ( "goods" ). "AS b ON a.goods_id=b.goods_id WHERE a.`order_id`=$order_id");
            $sql = "SELECT o.*, g.goods_number AS storage,g.goods_img as img_url,g.goods_spec ,o.goods_attr, IFNULL(b.brand_name, '') AS brand_name , g.goods_sn_ori,ifnull( f.number,0) AS stock_number " .
                    "FROM " . $ecs->table('order_goods') . " AS o " .
                    "LEFT JOIN " . $ecs->table('goods') . " AS g ON o.goods_id = g.goods_id " .
                    "LEFT JOIN " . $ecs->table('brand') . " AS b ON g.brand_id = b.brand_id " .
                    "LEFT JOIN " . $ecs->table('stock_goods') . " AS f ON o.goods_sn = f.goods_sn " .
                    "WHERE o.order_id = '$order_id' AND o.brand_id = '{$_row[$_i][brand_id]}' order by brand_name ";
            $res = $db->query($sql);
            $goods_list = null;
            unset($goods_list);
            while ($row = $db->fetchRow($res)) {
                if ($current_brands["brand_name"] <> $row['brand_name']) {

                    $current_brands["brand_name"] = $row['brand_name'];
                    $current_brands["amount"] = $row['goods_price'] * $row['goods_number'];
                    $current_brands["factory_amount"] = $row['factory_amount'] * $row['goods_number'];

                    //$brands_group = array();

                    $brands_list[] = $current_brands;
                } else {
                    $brand_count = count($brands_list);

                    $brands_list[$brand_count - 1]["amount"] = $brands_list[$brand_count - 1]["amount"] + $row['goods_price'] * $row['goods_number'];
                    $brands_list[$brand_count - 1]["factory_amount"] = $brands_list[$brand_count - 1]["factory_amount"] + $row['factory_price'] * $row['goods_number'];
                }


                /* 虚拟商品支持 */
                if ($row['is_real'] == 0) {
                    /* 取得语言项 */
                    $filename = ROOT_PATH . 'plugins/' . $row['extension_code'] . '/languages/common_' . $_CFG['lang'] . '.php';
                    if (file_exists($filename)) {
                        include_once($filename);
                        if (!empty($_LANG[$row['extension_code'] . '_link'])) {
                            $row['goods_name'] = $row['goods_name'] . sprintf($_LANG[$row['extension_code'] . '_link'], $row['goods_id'], $order['order_sn']);
                        }
                    }
                }
                if ($row['cloth_goods_id']) {
                    if (is_numeric($row['cloth_goods_id'])) {  //兼容以前的数据
                        $sql = "SELECT goods_name FROM ecs_goods WHERE goods_id = " . $row['cloth_goods_id'];
                        $goods_name = $GLOBALS['db']->getOne($sql);
                        $row['cloth_goods_name'] .= $goods_name;
                    } else {
                        $arr_bb = explode(":", $row['cloth_goods_id']);
                        $row['cloth_goods_name'] .= $arr_bb[1];
                    }
                }
                $row['formated_subtotal'] = price_format($row['goods_price'] * $row['goods_number'] - $row['discount_amount']);
                $row['formated_goods_price'] = price_format($row['goods_price']);

                $row['formated_factory_subtotal'] = price_format($row['factory_price'] * $row['goods_number']);
                $row['formated_factory_price'] = price_format($row['factory_price']);

                $row['formated_shipping_status'] = $_LANG['ss'][$row['shipping_status']];

                $goods_attr[] = explode(' ', trim($row['goods_attr'])); //将商品属性拆分为一个数组
                $goods_list[] = $row;
            }
            set_excel_info($goods_list, 1);
        }
        die($zip->file());
        exit();
    } else {
        //$row = $db->getAll("SELECT a.*,b.goods_img FROM ". $ecs->table ( "order_goods" ) ."AS a LEFT JOIN " .$ecs->table ( "goods" ). "AS b ON a.goods_id=b.goods_id WHERE a.`order_id`=$order_id");
        $sql = "SELECT o.*, g.goods_number AS storage,g.goods_img as img_url,g.goods_spec ,o.goods_attr, IFNULL(b.brand_name, '') AS brand_name , g.goods_sn_ori,ifnull( f.number,0) AS stock_number " .
                "FROM " . $ecs->table('order_goods') . " AS o " .
                "LEFT JOIN " . $ecs->table('goods') . " AS g ON o.goods_id = g.goods_id " .
                "LEFT JOIN " . $ecs->table('brand') . " AS b ON g.brand_id = b.brand_id " .
                "LEFT JOIN " . $ecs->table('stock_goods') . " AS f ON o.goods_sn = f.goods_sn " .
                "WHERE o.order_id = '$order_id' order by brand_name ";
        $res = $db->query($sql);
        while ($row = $db->fetchRow($res)) {
            if ($current_brands["brand_name"] <> $row['brand_name']) {

                $current_brands["brand_name"] = $row['brand_name'];
                $current_brands["amount"] = $row['goods_price'] * $row['goods_number'];
                $current_brands["factory_amount"] = $row['factory_amount'] * $row['goods_number'];

                //$brands_group = array();

                $brands_list[] = $current_brands;
            } else {
                $brand_count = count($brands_list);

                $brands_list[$brand_count - 1]["amount"] = $brands_list[$brand_count - 1]["amount"] + $row['goods_price'] * $row['goods_number'];
                $brands_list[$brand_count - 1]["factory_amount"] = $brands_list[$brand_count - 1]["factory_amount"] + $row['factory_price'] * $row['goods_number'];
            }


            /* 虚拟商品支持 */
            if ($row['is_real'] == 0) {
                /* 取得语言项 */
                $filename = ROOT_PATH . 'plugins/' . $row['extension_code'] . '/languages/common_' . $_CFG['lang'] . '.php';
                if (file_exists($filename)) {
                    include_once($filename);
                    if (!empty($_LANG[$row['extension_code'] . '_link'])) {
                        $row['goods_name'] = $row['goods_name'] . sprintf($_LANG[$row['extension_code'] . '_link'], $row['goods_id'], $order['order_sn']);
                    }
                }
            }
            if ($row['cloth_goods_id']) {
                if (is_numeric($row['cloth_goods_id'])) {  //兼容以前的数据
                    $sql = "SELECT goods_name FROM ecs_goods WHERE goods_id = " . $row['cloth_goods_id'];
                    $goods_name = $GLOBALS['db']->getOne($sql);
                    $row['cloth_goods_name'] .= $goods_name;
                } else {
                    $arr_bb = explode(":", $row['cloth_goods_id']);
                    $row['cloth_goods_name'] .= $arr_bb[1];
                }
            }
            $row['formated_subtotal'] = price_format($row['goods_price'] * $row['goods_number'] - $row['discount_amount']);
            $row['formated_goods_price'] = price_format($row['goods_price']);

            $row['formated_factory_subtotal'] = price_format($row['factory_price'] * $row['goods_number']);
            $row['formated_factory_price'] = price_format($row['factory_price']);

            $row['formated_shipping_status'] = $_LANG['ss'][$row['shipping_status']];
            $goods_attr[] = explode(' ', trim($row['goods_attr'])); //将商品属性拆分为一个数组
            $goods_list[] = $row;
        }
        header("Content-type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=Procurement_roder.xls");
        set_excel_info($goods_list);
    }
}
//设置为尽快发货
else if ($_REQUEST['act'] == 'ship_hurry') {
    checkOrderAuth($_REQUEST['order_id']);
    $order_id = $_REQUEST['order_id'];
    $sql = "SELECT * FROM ecs_order_info WHERE order_id=$order_id";
    $row = $db->getRow($sql);

    if ($row['order_status'] != OS_CONFIRMED || ($row['shipping_status'] != SS_UNSHIPPED && $row['shipping_status'] != SS_PART_SHIPPED && $row['shipping_status'] != SS_SHIPPED && $row['shipping_status'] != SS_PREPARING)) {
        sys_msg('确认的订单和未发货/部分发货的才能修改为此状态!');
        exit;
    }
    if (!$row['is_received_pay'] && ($row['pay_status'] != PS_PAYED && $row['pay_status'] != 1)) {
        sys_msg('该单未付完全款并且不是货到付款,不能修改为尽快发货!');
        exit;
    }
    $flag = checkShipHurry($order_id);

    if (!$flag) {
        $is_parnet = $db->getOne("SELECT is_partner FROM meilele_group WHERE group_id = {$row['group_id']}");
        if ($is_parnet == 1) { //is_parnet =1 加盟 0直属
            $group_id = $row['group_id'];
        } else {
            $group_id = 0;
        }
        if ($row['ship_direction'] == 0) {
            $percent = $db->getOne("SELECT custom_percent FROM ecs_franchise_fee WHERE group_id = $group_id");
        } else {
            $percent = $db->getOne("SELECT expre_percent FROM ecs_franchise_fee WHERE group_id = $group_id");
        }
        $percent = empty($percent) ? 0 : $percent;
        sys_msg('该单的付款比例没有达到订单发货下限[' . $percent . '%],不能设置尽快发货!');
    }
    
    $group_id = $db->getOne("SELECT group_id FROM ecs_admin_user where user_id = {$_SESSION['admin_id']}");
    $can_set = $db->getOne("SELECT user_id FROM ecs_admin_user WHERE (action_list like '%pre_picking%' or action_list = 'all') AND user_id = ".$_SESSION['admin_id']);
    if($can_set){
    	$check_time = abs($row['pre_ship_time'] - time());
    	$seven_day = 7 * 3600 * 24;
    	if($check_time > $seven_day && $row['order_type'] != 'patch_order'){
    		$status = check_order_goods_status($order_id);
    	}
    
    	if($status['error']){
    		sys_msg("由于你的预计发货时间在7天之外并且".$status['smg']."仓库数量不足，所以你不能设置成尽快发货，急单请联系供应商调配中心
");
    	}
    }
    
    $time = time();
    $sql = "UPDATE ecs_order_info SET pre_ship_status='hurry',`Shipping_status_time`=$time WHERE order_id=$order_id";
    $db->query($sql);

    order_action($row['order_sn'], $row['order_status'], $row['shipping_status'], $row['pay_status'], '修改订单为尽快发货状态.');
    if (ERP_FLAG == 1) {
        $ret = http_request('setSoonByPHP', array('orderId' => (String) $order_id), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
        $ret = json_decode($ret, TRUE);
        if ($ret['code'] != 1)
            sys_msg('设置成功,同步ERP出现异常!');
    }
    header('Location: /admin/order.php?act=info&order_id=' . $order_id);
}
else if ($_REQUEST['act'] == 'ship_unsure') {
    checkOrderAuth($_REQUEST['order_id']);
    $order_id = $_REQUEST['order_id'];
    $sql = "SELECT * FROM ecs_order_info WHERE order_id=$order_id";
    $row = $db->getRow($sql);
    if ($row['order_status'] != OS_CONFIRMED || ($row['shipping_status'] != SS_UNSHIPPED && $row['shipping_status'] != SS_PART_SHIPPED)) {
        sys_msg('确认的订单和未发货/部分发货的才能修改为此状态!');
        exit;
    }

    /* $sql = "SELECT COUNT(expr_id)
      FROM ecs_expr_nature
      WHERE manager_front_id='" . $row['user_id'] . "'";
      $cnt = $db->getOne($sql);
      if(!empty($cnt) && $row['order_status'] && $row['pay_status'])
      {
      sys_msg('体验馆的已确认订单总是立即发货状态!');
      exit;
      } */
    if ($_REQUEST['prepare_shipping_time'] != '') {
        $sql = "UPDATE ecs_order_info SET pre_ship_status='unsure',prepare_shipping_time='{$_REQUEST['prepare_shipping_time']}' WHERE order_id=$order_id";
    }else
        $sql = "UPDATE ecs_order_info SET pre_ship_status='unsure',prepare_shipping_time='0000-00-00 00:00:00' WHERE order_id=$order_id";
    $db->query($sql);
    order_action($row['order_sn'], $row['order_status'], $row['shipping_status'], $row['pay_status'], '修改订单为待发货状态.');
    if (ERP_FLAG == 1) {
        $ret = http_request('cancelSoonByPHP', array('orderId' => (String) $order_id), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
        $ret = json_decode($ret, TRUE);
        if ($ret['code'] != 1)
            sys_msg('设置成功,同步ERP出现异常!');
    }
    header('Location: /admin/order.php?act=info&order_id=' . $order_id);
}
else if ($_REQUEST['act'] == 'is_received_pay') {
    checkOrderAuth($_REQUEST['order_id']);
    $order_id = $_REQUEST['order_id'];
    $received_pay = $_REQUEST['received_pay'];
    $sql = "UPDATE ecs_order_info SET is_received_pay=$received_pay WHERE order_id=$order_id";
    $db->query($sql);
    $sql = "SELECT * FROM ecs_order_info WHERE order_id=$order_id";
    $row = $db->getRow($sql);
    $action_note = "修改为" . ($received_pay ? '是货到付款' : '不是货到付款');
    order_action($row['order_sn'], $row['order_status'], $row['shipping_status'], $row['pay_status'], $action_note);
    header('Location: /admin/order.php?act=info&order_id=' . $order_id);
} else if ($_REQUEST['act'] == 'audit_check') {
    admin_priv('audit_check');

    $audit_id = $_REQUEST['audit_id'];
    $order_id = $_REQUEST['order_id'];
    $audit_ok = $_REQUEST['audit_ok'];

    if ($audit_ok) {
        $audit_status = 'audit_ok';
    } else {
        $audit_status = 'audit_bad';

        $sql = "SELECT audit_money FROM ecs_audit_withdraw WHERE audit_id=$audit_id";
        $audit_money = $db->getOne($sql);

        $sql = "SELECT goods_amount,already_pay,discount,shipping_fee FROM ecs_order_info WHERE order_id = $order_id";
        $money = $db->getRow($sql);

        if ($money['goods_amount'] + $money['shipping_fee'] <= ($money['already_pay'] + $bonus + $money['discount']) && ($money['already_pay'] + $bonus)) {
            // 已付款
            $pay_status = PS_PAYED;
        } else if ($money['already_pay'] > 0) {
            // 付款中
            $pay_status = PS_PAYING;
        } else {
            // 未付款
            $pay_status = PS_UNPAYED;
        }

        $sql = "UPDATE ecs_order_info SET
				money_paid=money_paid-$audit_money,
				already_pay=already_pay-$audit_money,
				order_amount=order_amount+$audit_money,
				pay_status=$pay_status
				WHERE order_id=$order_id";
        // die($sql);
        $db->query($sql);
    }

    $admin_name = $_SESSION['admin_name'];
    $audit_time = time();
    $sql = "UPDATE ecs_audit_withdraw SET audit_status='$audit_status',audit_name='$admin_name',audit_time='$audit_time' WHERE audit_id = $audit_id";
    $db->query($sql);

    $sql = "SELECT SUM(audit_money) FROM ecs_audit_withdraw WHERE order_id='$order_id' AND (audit_status='audit_ok' OR audit_status='auto_audit')";
    $total_audit_money = $db->getOne($sql);

    $sql = "UPDATE ecs_order_info SET financial_got_pay='$total_audit_money' WHERE order_id=$order_id";
    $db->query($sql);
    header('Location: /admin/order.php?act=info&order_id=' . $order_id . '#audit');
}
//设置发货是否短信通过
elseif ($_REQUEST['act'] == 'toggle_send_sms') {
    $order_id = intval($_POST['id']);
    $send_sms = intval($_POST['val']);

    $sql = "UPDATE `ecs_order_info` SET `send_sms`='$send_sms' WHERE order_id='$order_id'";
    $db->query($sql);
    if ($db->affected_rows()) {
        make_json_result($send_sms);
    }
} elseif ($_REQUEST['act'] == 'ship_need') {
    $order_id = $_REQUEST['order_id'];
    $db->query("UPDATE ecs_order_info SET pre_ship_status = 'ship_need' WHERE order_id = $order_id"); //设置为有余款，需备货

    $sql = "SELECT * FROM ecs_order_info WHERE order_id=$order_id";
    $row = $db->getRow($sql);

    $action_note = "修改为有余款，需备货";
    order_action($row['order_sn'], $row['order_status'], $row['shipping_status'], $row['pay_status'], $action_note);
    if (ERP_FLAG == 1) {
        $ret = http_request('cancelSoonByPHP', array('orderId' => (String) $order_id), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
        $ret = json_decode($ret, TRUE);
        if ($ret['code'] != 1)
            sys_msg('设置成功,同步ERP出现异常!');
    }
    header('Location: /admin/order.php?act=info&order_id=' . $order_id);
}
elseif ($_REQUEST['act'] == 'revert_order') { //恢复被删除的订单
    $order_sn = $_GET['order_sn'];
    $one = $db->getOne("SELECT order_id FROM ecs_order_info WHERE order_sn = '" . $order_sn . "'");
    if (!$one) {
        $row = $db->getRow("SELECT * FROM ecs_order_info_del WHERE order_sn = '" . $order_sn . "'");
        if ($row['id']) {
            $info = $row['order_goods'];
            unset($row['id']);
            unset($row['order_goods']);
            unset($row['del_admin_id']);
            unset($row['del_time']);
            $db->autoExecute('ecs_order_info', $row, 'INSERT');
            $arr = unserialize($info);
            foreach ($arr as $v) {
                $db->autoExecute('ecs_order_goods', $v, 'INSERT');
            }
            echo 'chenggong';
        }
    }
} elseif ($_REQUEST['act'] == 'erp_order_bonus') { //使用ERP红包
    if (ERP_FLAG == 1) {
        $order_id = $_REQUEST['order_id'];

        if (!$order_id)
            sys_msg('参数非法');
        if ($_POST) {
            $row = $db->getRow("SELECT shipping_status,pay_status,order_status FROM ecs_order_info WHERE order_id = $order_id");
            $erp_bonus_money = trim($_POST['erp_bonus_money']);
            $notes = $_POST['notes'];
            $ret = http_request('mllWscreateRedShareHttp', array('order_id' => (String) $order_id, 'bonusAmount' => (String) $erp_bonus_money, 'type' => ''), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));

            $ret = json_decode($ret, TRUE);
            if ($ret['code'] == 1) {
                $db->query("UPDATE ecs_order_info SET discount=discount+" . $erp_bonus_money . " WHERE order_id = $order_id");

                $db->query("INSERT INTO ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_note,log_time) VALUES('" . $ordre_id . "','" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','[使用ERP红包" . $erp_bonus_money . "元]" . $notes . "','" . time() . "')");
                header('Location:/admin/order.php?act=info&order_id=' . $order_id);
            } else {
                sys_msg($ret['msg']);
            }

            exit;
        }
        $smarty->assign('order_id', $order_id);
        $smarty->display('order_bonus.htm');
        exit;
    }
    else
        sys_msg('接口未开放!');
}
elseif ($_REQUEST['act'] == 'cancel_erp_order_bonus') { //取消ERP红包
    if (ERP_FLAG == 1) {
        $order_id = $_REQUEST['order_id'];
        if (!$order_id)
            sys_msg('参数非法');

        $row = $db->getRow("SELECT shipping_status,pay_status,order_status FROM ecs_order_info WHERE order_id = $order_id");
        $ret = http_request('mllWscreateRedShareHttp', array('order_id' => (String) $order_id, 'bonusAmount' => '', 'type' => 'CANCELED'), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
        $ret = json_decode($ret, TRUE);
        if ($ret['code'] == 1) {
            $erp_bonus_money = trim($ret['successMessage']);
            $db->query("UPDATE ecs_order_info SET discount=discount-" . $erp_bonus_money . " WHERE order_id = $order_id");
            $db->query("INSERT INTO ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_note,log_time) VALUES('" . $ordre_id . "','" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','[取消ERP红包]" . $notes . "','" . time() . "')");
            header('Location:/admin/order.php?act=info&order_id=' . $order_id);
        } else {
            sys_msg($ret['msg']);
        }

        exit;
    }
    else
        sys_msg('接口未开放!');
}elseif ($_REQUEST['act'] == 'special_order') {
    /* 检查权限 */
    admin_priv('special_order');
    $order_id = intval($_REQUEST['order_id']);
    $result = special_order($order_id);
    if ($result) {
        sys_msg('特殊审核成功', 0, array(array('text' => '订单详情', 'href' => "order.php?act=info&order_id=$order_id")));
    } else {
        sys_msg('特殊审核失败，你稍后再操作');
    }
    //体验馆收货确认
}elseif ($_REQUEST['act'] == 'audit_special_order') {
    /* 检查权限 */
    admin_priv('special_order');
    $order_id = intval($_REQUEST['order_id']);
    $id		  = $db_select->getOne("SELECT id FROM ecs_order_extend WHERE order_id = $order_id");
	if($id)
		$db->query("UPDATE ecs_order_extend SET audit_status = 1 WHERE id = $id");
	else
		$db->query("INSERT INTO ecs_order_extend(order_id,audit_status) VALUES($order_id,1)");
	sys_msg('财务审核成功', 0, array(array('text' => '订单详情', 'href' => "order.php?act=info&order_id=$order_id")));
    //体验馆收货确认
}
 elseif ($_REQUEST['act'] == 'orderReceive') {
    $order_id = intval($_REQUEST['order_id']);
    $package_number = intval($_REQUEST['package_number']);
    $receive_time = trim($_REQUEST['receive_time']);


    $sql = "SELECT ship_direction FROM `ecs_order_info` WHERE  `order_id` = '" . $order_id . "';";
    $ship_direction_this = $db->getOne($sql);

    if ($ship_direction_this == '0') {
        sys_msg("发货方向是客户，不能进行收货操作");
    }
    $sql = "SELECT een.`expr_id` FROM `ecs_admin_user` AS eau
JOIN `ecs_warehouse` AS ew ON ew.`warehouse_id` = eau.`warehouse_id`
JOIN `ecs_expr_nature` AS een ON een.`expr_id` = ew.`expr_id`
 WHERE eau.user_id = '" . $_SESSION['admin_id'] . "';";
    $expr_id_this = $db->getOne($sql);

    if ($ship_direction_this != $expr_id_this) {
        sys_msg("你不是发货方向体验馆仓库的管理员，不能进行收货操作");
    }

    $sql = "SELECT warehouse_id FROM `ecs_warehouse` where expr_id='{$ship_direction_this}'";
    $ship_wh_id = $db->getOne($sql);

    if (empty($receive_time)) {
        $receive_time = time();
    } else {
        $receive_time = strtotime($receive_time);
    }
    if ($receive_time > (time() + 10)) {
        sys_msg('实际收货时间不能大于当天！');
    }

    if ($package_number < 1) {
        sys_msg('收货件数必须大于0');
    }
    //判断当前操作是员是否是仓库管理员
    $sql = "SELECT eau.warehouse_id,ew.expr_id FROM `ecs_admin_user` AS eau LEFT JOIN `ecs_warehouse` AS ew ON eau.warehouse_id=ew.warehouse_id WHERE eau.user_id='{$_SESSION['admin_id']}'";
    $op_info = $db->getRow($sql);
    if (!is_array($op_info) || $op_info['expr_id'] == 0 || $op_info['warehouse_id'] == 0) {
        sys_msg('只有体验馆仓库管理员才能操作！');
    }
    $wh_id = $op_info['warehouse_id'];
    $expr_id = $op_info['expr_id'];

    $sql = "SELECT order_id,order_status,shipping_status,pay_status,ship_direction FROM `ecs_order_info` WHERE order_id = '$order_id'";
    $order_info = $db->getRow($sql);
    if (!$order_info) {
        sys_msg('订单不存在!');
    }
    if (!$order_info['ship_direction']) {
        sys_msg('只有发向体验馆的订单才能收货！');
    }
    if (!in_array($order_info['shipping_status'], array(1, 2, 4))) {
        sys_msg('订单当前发货状态不能收货！');
    }
    //入库操作
    $sql = "SELECT sum(package_number) FROM `ecs_order_receive` WHERE order_id='$order_id'";
    $package_number_total = $db->getOne($sql);
    
    //$order_invoice = get_order_invoice($order_id);
    $order_invoice = getInvoiceList($order_id, $ship_wh_id);
    
    $invoice_package_total = 0;
    if (count($order_invoice) > 0) {
        foreach ($order_invoice AS $_val) {
            $invoice_package_total += $_val['total_package_num'];
        }
    }
    if (($package_number_total + $package_number) > $invoice_package_total) {
        sys_msg("收货件数大于已发货件数：{$invoice_package_total}");
    }
    $order_info['package_number'] = $package_number;
    $order_info['operate_user'] = $_SESSION['admin_name'];
    $order_info['add_time'] = time();
    $order_info['receive_time'] = $receive_time; //实际收货时间
    $db->autoExecute('ecs_order_receive', $order_info);
    if ($db->affected_rows()) {
        $sql = "SELECT sum(package_number) FROM `ecs_order_receive` WHERE order_id='$order_id'";
        $package_number_total = $db->getOne($sql);
        $id = $db->insert_id();
        $receivePackageNumber = 0;
        $totalinfo = '';
        foreach ($order_invoice AS $val) {
            if ($val['is_receiving'] == 1) {
                $receivePackageNumber += $val['total_package_num'];
            }
        }
        $current_time = time();
        foreach ($order_invoice AS $val) {
            $_package = $package_number_total - $receivePackageNumber;
            if ($val['is_receiving'] == 0 && $_package >= $val['total_package_num']) {
                //入库操作
                $sql = "UPDATE `ecs_stock_invoice_info` SET is_receiving=1 WHERE invoice_id='{$val['invoice_id']}'";
                $db->query($sql);
                if ($db->affected_rows()) {
                    $sql = "SELECT order_rec_id,goods_id,goods_name,goods_sn,goods_number FROM `ecs_stock_invoice_goods` WHERE invoice_id='{$val['invoice_id']}'";
                    $invoce_goods = $db->getAll($sql);
                    foreach ($invoce_goods AS $_val) {
                        //修改订单发货状态
                        $sql = "UPDATE `ecs_order_goods` SET shipping_status='" . SS_UNSHIPPED . "', expr_id='{$expr_id}', is_receiving=1,ship_time=0,receive_time='$current_time',actual_receive_time='$receive_time' WHERE rec_id='{$_val['order_rec_id']}'";
                        $db->query($sql);
                        if ($db->affected_rows()) {
                            stock_in($_val['goods_sn'], $_val['goods_number'], 'expr_add', $val['consignee'], $val['invoice_sn']);
                            $totalinfo .= "{$_val['goods_sn']}:入库数量:{$_val['goods_number']}:成功<br/>";
                        }
                    }
                }

                $receivePackageNumber += $val['total_package_num'];
            }
        }
        if (!empty($totalinfo)) {
            $db->autoExecute('ecs_order_receive', array('note' => $totalinfo), 'UPDATE', "id=$id");
        }
        sys_msg('收货成功!', 0, array(array('text' => '订单信息', 'href' => "order.php?act=info&order_id=$order_id")));
    } else {
        sys_msg('收货失败,请重试！');
    }
}

/* * ***
 * 修改最佳送货时间
 *
 * *** */ elseif ($_REQUEST['act'] == 'set_best_ship_time') {
    //check_authz_json('goods_manage');

    $rec_id = intval($_REQUEST['id']);
    $best_time = $_REQUEST['val'];

    $best_time = strtotime($best_time);
    if (strlen($best_time) != 10) {
        make_json_error("格式错误");
    }


    $GLOBALS['db']->query("UPDATE ecs_order_goods SET best_ship_time = '{$best_time}' where rec_id = {$rec_id}");

    $order_info = $GLOBALS['db']->getRow("SELECT order_id,order_item_seq_id from `ecs_order_goods` where rec_id = {$rec_id}");
    $order = $GLOBALS['db']->getRow("SELECT order_sn,pay_status,order_status,shipping_status from `ecs_order_info` where order_id = {$order_info['order_id']}");
    order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], "修改了最佳送货时间为：{$_REQUEST['val']}");
    //clear_cache_files();
    if (ERP_FLAG == 1) {
        //$ret = http_request('WsMllUpdateItemPlanBestTime',array('orderId'=>(String)$order_info['order_id'],'itemSeqId'=>(String)$order_info['order_item_seq_id'],'bestShipTime'=>(String)$best_time),array('username'=>$_SESSION['admin_name'],'password'=>$_SESSION['password']));
        //$ret = json_decode($ret,TRUE);
        //if($ret['code'] != 1)
        //make_json_error("设置成功,同步ERP出现异常!");
    }

    make_json_result($best_time);
}
/* 订单发货时间 */ else if ($_REQUEST['act'] == 'set_order_send_time') {
    $order_id = intval($_REQUEST['order_id']);
    $act = $_REQUEST['act'];
    $smarty->assign('action_link', array('href' => 'order.php?act=info&order_id=' . $order_id, 'text' => '订单详情'));


    $smarty->assign('act', $act);
    $smarty->assign('step', $act);
    $smarty->assign('order_id', $order_id);
    $smarty->display('order_step.htm');
}

/* 指定订单发货时间 */ else if ($_REQUEST['act'] == 'set_need_ship_time') {
    $order_id = intval($_REQUEST['order_id']);
    //check_group($order_id);
    $gourp_id = $db->getOne("SELECT group_id FROM `ecs_order_info` WHERE order_id = {$order_id}");
    $order = $db->getRow("SELECT pay_status,admin_id FROM ecs_order_info where order_id = $order_id");
    $taobao_team = array(1, 3, 4, 5, 6, 94);
    $is_taobao = false;
    if (in_array($gourp_id, $taobao_team)) {
        $is_taobao = true;
    }
    $admin_id = trim($order['admin_id'], "|");
    $owner = false;
    if ($admin_id == $_SESSION['admin_id']) {
        $owner = true;
    } elseif (strpos($admin_id, '|') === false) {
        $owner = true;
    } elseif (strpos($admin_id, '|') !== false) {
        $admin_array = explode("|", $admin_id);

        if (in_array($_SESSION['admin_id'], $admin_array)) {
            $owner = true;
        }
    }
    if ($is_taobao) {
        $result = web_order_check_per($order_id);
    } else {
        $result = expr_order_check_per($order_id);
    }

    if (!$result && $order['pay_status'] != 0 && !$owner) {
        echo "你没有权限修改此订单";
        exit;
    }

    $act = $_REQUEST['act'];
    $smarty->assign('action_link', array('href' => 'order.php?act=info&order_id=' . $order_id, 'text' => '订单详情'));
    $temp = $db->getRow("SELECT need_ship_time,ship_all from ecs_order_info where order_id = {$order_id}");
    $need_ship_time = $temp['need_ship_time'];
    $ship_all = $temp['ship_all'];
    if ($need_ship_time) {
        $smarty->assign('need_ship_time', date('Y-m-d', $need_ship_time));
    }

    if ($ship_all == 0) {
        $smarty->assign('ship_all', 1);
    }
    $smarty->assign('act', $act);
    $smarty->assign('step', $act);
    $smarty->assign('order_id', $order_id);
    $smarty->display('order_step.htm');
}
/* * ***
 * 修改预计发货时间
 *
 * *** */ elseif ($_REQUEST['act'] == 'plan_send_time') {
    //check_authz_json('goods_manage');
    $rec_id = intval($_REQUEST['id']);
    $plan_send_time = $_REQUEST['val'];

    if (strlen($plan_send_time) == 0) {
        make_json_error("请输入正确的发货时间");
    }

    $date = strtotime($plan_send_time);
    if ($date == 0)
        $date = '';
    $GLOBALS['db']->query("UPDATE ecs_order_goods SET plan_send_time = '{$date}' where rec_id = {$rec_id}");

    $order_info = $GLOBALS['db']->getRow("SELECT order_id,order_item_seq_id from `ecs_order_goods` where rec_id = {$rec_id}");
    $order = $GLOBALS['db']->getRow("SELECT order_sn,pay_status,order_status,shipping_status from `ecs_order_info` where order_id = {$order_info['order_id']}");
    order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], "修改了预计发货时间为：{$_REQUEST['val']}");

    if (ERP_FLAG == 1) {
        //$ret = http_request('WsMllUpdateItemPlanBestTime',array('orderId'=>(String)$order_info['order_id'],'itemSeqId'=>(String)$order_info['order_item_seq_id'],'planSendTime'=>(String)$date),array('username'=>$_SESSION['admin_name'],'password'=>$_SESSION['password']));
        //$ret = json_decode($ret,TRUE);
        //if($ret['code'] != 1)
        //make_json_error("设置成功,同步ERP出现异常!");
    }

    //clear_cache_files();
    make_json_result($plan_send_time);
} elseif ($_REQUEST['act'] == 'toggle_function') {
    $order_id = $_GET['orderid'];
    $action = $_GET['action'];


    $gourp_id = $db->getOne("SELECT group_id FROM `ecs_order_info` WHERE order_id = {$order_id}");
    $order = $db->getRow("SELECT pay_status,admin_id FROM ecs_order_info where order_id = $order_id");
    $taobao_team = array(1, 3, 4, 5, 6, 94);
    $is_taobao = false;
    if (in_array($gourp_id, $taobao_team)) {
        $is_taobao = true;
    }
    $admin_id = trim($order['admin_id'], "|");
    $owner = false;
    if ($admin_id == $_SESSION['admin_id']) {
        $owner = true;
    } elseif (strpos($admin_id, '|') === false) {
        $owner = true;
    } elseif (strpos($admin_id, '|') !== false) {
        $admin_array = explode("|", $admin_id);

        if (in_array($_SESSION['admin_id'], $admin_array)) {
            $owner = true;
        }
    }
    if ($is_taobao) {
        $result = web_order_check_per($order_id);
    } else {
        $result = expr_order_check_per($order_id);
    }

    if (!$result && $order['pay_status'] != 0 && !$owner) {
        echo "你没有权限修改此订单";
        exit;
    }

    $db->query("UPDATE ecs_order_info SET ship_all = {$action}  where order_id = {$order_id}");
    if (ERP_FLAG == 1) {
        $ret = http_request('wsOrderShipAll', array('orderId' => (String) $order_id, 'shipAll' => $action), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
        $ret = json_decode($ret, TRUE);
        if ($ret['code'] != 1)
            sys_msg('设置成功,同步ERP出现异常!');
    }
    /* 日志 */
    $row = $db->getRow("SELECT * FROM ecs_order_info WHERE order_id = $order_id");
    if ($action == 0)
        $str = "允许";
    else if ($action == 1)
        $str = "不允许";
    else {
        die("未知错误");
    }
    $notes = "修改了为 {$str} 部分发货{$_POST['plan_send_time']}(重要)";
    $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES('" . $order_id . "','" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','" . $notes . "','" . time() . "')";
    $db->query($sql);

    if ($action == 0)
        echo 'yes';
    else
        echo 'no';
    exit;

    //设置订单运输方式
}elseif ($_REQUEST['act'] == 'change_transport_type') {
    $sql = "SELECT expr_id,expr_name FROM `ecs_expr_nature` WHERE leader_id = '{$_SESSION['admin_id']}'";
    $expr_info = $db->getRow($sql);
    if (!$expr_info) {
        sys_msg('只有店长才能操作！');
    }

    $order_id = isset($_REQUEST['order_id']) ? intval($_REQUEST['order_id']) : 0;
    $transportType = isset($_REQUEST['transport_type']) ? trim($_REQUEST['transport_type']) : '';
    $orderInfo = order_info($order_id);

    if (!$orderInfo) {
        sys_msg('订单不存在！');
    } elseif ($orderInfo['shipping_status'] == '1') {
        sys_msg('已发货的订单不能修改，运输方式！');
    } elseif ($orderInfo['order_status'] == '2') {
        sys_msg('取消的订单不能修改，运输方式！');
    }

    $sql = "SELECT count(*) FROM `ecs_stock_invoice_info` WHERE order_id='$order_id' AND fstatus IN ('new','printed','reserv')";
    $invoice_total = $db->getOne($sql);
    if ($invoice_total > 0) {
        sys_msg('你的订单存在未发货的发货单，不允许修改送货方式，如果要修改请联系仓库！');
    }

    if ($_POST) {
        if (!array_key_exists($transportType, $_LANG['transport_type'])) {
            sys_msg('你选择的运输方式不存在！');
        }
        $sql = "UPDATE `ecs_order_info` set transport_type='{$transportType}' WHERE order_id='$order_id'";
        $db->query($sql);
        if ($db->affected_rows()) {
            //添加日志
            $note = "运输方式由：{$_LANG['transport_type'][$orderInfo['transport_type']]}，改为：{$_LANG['transport_type'][$transportType]}";
            $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time)
					VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $orderInfo['order_status'] . "','" . $orderInfo['shipping_status'] . "','" . $orderInfo['pay_status'] . "','" . time() . "','$note','" . time() . "')";
            $db->query($sql);
            header("Location:?act=info&order_id={$order_id}");
        } else {
            sys_msg('修改运输方式失败！');
        }
    } else {
        $smarty->assign('ur_here', '修改订单运输方式');
        $smarty->assign('step', 'change_transport_type');
        $smarty->assign('order', $orderInfo);
        $smarty->assign('lang', $_LANG);
        $smarty->display('order_step.htm');
    }
} elseif ($_REQUEST['act'] == 'change_shipping_fee') {
    $order_id = isset($_REQUEST['order_id']) ? intval($_REQUEST['order_id']) : 0;
    $orderInfo = order_info($order_id);
    $trans_type = $db->getOne("SELECT trans_type from ecs_order_extend where order_id = {$order_id}");
    
    $tb = $db->getOne("SELECT group_id from ecs_admin_user where (user_name = 'MLL_TB' and user_id = {$_SESSION['admin_id']}) or (action_list = 'all' and user_id = {$_SESSION['admin_id']})");
    if(!$tb && ( $orderInfo['order_type'] == 'normal' && $orderInfo['order_ship_type'] == 1 && ($trans_type == 1 || $trans_type == 6 || $trans_type == 10 || $trans_type == 9))){
    	die("普通订单和秒杀订单无法修改物流费！");
    }
    
    if ($_POST) {
        $shipping_fee = $_POST['shipping_fee'] + 0;
        if(!$tb)
        $sql = "UPDATE `ecs_order_info` set `shipping_fee`='{$shipping_fee}' WHERE $shipping_fee >= shipping_fee and  order_id='$order_id'";
        else
        $sql = "UPDATE `ecs_order_info` set `shipping_fee`='{$shipping_fee}' WHERE order_id='$order_id'";
        $db->query($sql);
        if ($db->affected_rows()) {
            //$sql = "UPDATE `ecs_order_extend` SET `ship_pay_status`=1 WHERE `order_id`={$order_id}";
            //$db->query($sql);
            //添加日志
            $note = "将配送费用修改为:{$shipping_fee}";
            $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time)
                    VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $orderInfo['order_status'] . "','" . $orderInfo['shipping_status'] . "','" . $orderInfo['pay_status'] . "','" . time() . "','$note','" . time() . "')";
            $db->query($sql);
            header("Location:?act=info&order_id={$order_id}");
        }else{
        	die("无法修改物流费或则数据异常");
        }
    } else {
        $smarty->assign('ur_here', '修改配送费用');
        $smarty->assign('step', 'change_shipping_fee');
        $smarty->assign('tb', $tb);
        $smarty->assign('order', $orderInfo);
        $smarty->display('order_step.htm');
    }
} elseif ($_REQUEST['act'] == 'ship_pay_status') {
    $order_id = $_REQUEST['order_id'];
    /* 东哥要求家的 */
    $sql = "SELECT count(*) FROM `ecs_stock_invoice_info` WHERE order_id='$order_id' AND fstatus IN ('new','printed','reserv')";
    $invoice_total = $db->getOne($sql);
    if ($invoice_total > 0) {
        sys_msg('你的订单存在未发货的发货单，不允许设置为已付运费，如果要修改请联系仓库！');
    }
    $orderInfo = order_info($order_id);
    $sql = "UPDATE `ecs_order_extend` SET `ship_pay_status`=1 WHERE `order_id`=$order_id";
    $db->query($sql);
    if ($db->affected_rows()) {
        //添加日志
        $note = "点击了【已收运费】";
        $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time)
            VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $orderInfo['order_status'] . "','" . $orderInfo['shipping_status'] . "','" . $orderInfo['pay_status'] . "','" . time() . "','$note','" . time() . "')";
        $db->query($sql);
        header("Location:?act=info&order_id={$order_id}");
    }
} else if ($_REQUEST['act'] == 'touch_activity') {
	if($_SESSION['admin_id'] == 1592 && $_REQUEST['debug'] == 2){
		error_reporting(E_ALL);
	}
	ini_set('memory_limit', '512M');
    $order_id = $_REQUEST['order_id'];

    $chengdu = $db->getOne("SELECT group_id from ecs_admin_user where group_id in (108,14,106) and user_id = {$_SESSION['admin_id']}");

    $chengdu = $db->getOne("SELECT group_id from ecs_admin_user where group_id in (108,14,106) and user_id = {$_SESSION['admin_id']}");

    $order = $db->getRow("SELECT * FROM ecs_order_info where order_id = {$order_id}");
    if ($order['add_time'] < 1349704909 && !in_array($order['group_id'], array(108, 14, 106))) {
        header("Location:/admin/order.php?act=info&order_id={$order_id}");
        exit;
    }
    /*
      if(in_array($order['group_id'],array(108,14,106)) && $order['add_time'] < 1349704909 ){

      } */
    $order_extend = $db->getRow("SELECT * FROM ecs_order_extend where order_id = {$order_id}");
    $_result = get_avt_info($order);
    $_result['expr'] = floor($_result['expr']);
    if ($_result['expr'] || $_result['expr'] == 0) {
    	if($_result['expr'] == 0)
 			$db->query("update ecs_order_goods SET goods_number = 0 ,shipping_status = 5  where goods_id = 20659 and order_id = {$order_id}");
        
 		$expr_number = $db->getOne("SELECT goods_number from ecs_order_goods where goods_id = 20659 AND shipping_status !=5	and order_id = {$order_id}");
        $expr_number = (float) $expr_number;
        if ($expr_number != $_result['expr']) {
            $new_number = $_result['expr'] - $expr_number;
            //需要日志
            order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '修改了服务费为' . $_result['expr']);
            $have_expr = $db->getone("SELECT 1 from ecs_order_goods where goods_id = 20659 and shipping_status != 5 and order_id = $order_id");

            if (!$have_expr) {
                $order_item_seq_id = $db->getOne("SELECT max(order_item_seq_id) from ecs_order_goods where order_id = {$order_id}");
                $order_item_seq_id++;
                $sql = "INSERT INTO " . $ecs->table('order_goods') .
                        " (order_id, goods_id, goods_name, goods_sn, " .
                        "goods_number, market_price, goods_price, factory_price, " .
                        "is_real, extension_code, parent_id, is_gift,brand_id,order_item_seq_id,goods_type,og_add_time)" .
                        "SELECT '$order_id', goods_id, goods_name, goods_sn, " .
                        "'{$new_number}', market_price, '1', '1',  " .
                        "is_real, extension_code, 0, 0,brand_id,$order_item_seq_id,0 ," . time() .
                        " FROM " . $ecs->table('goods') .
                        " WHERE goods_id = 20659 LIMIT 1";
                $db->query($sql);
            } else {
                if ($_result['expr'] > 0)
                    $db->query("update ecs_order_goods SET goods_number = ({$_result['expr']})  where goods_id = 20659 and order_id = {$order_id}");
                else {
                    $db->query("update ecs_order_goods SET goods_number = 0 ,shipping_status = 5  where goods_id = 20659 and order_id = {$order_id}");
                }
            }
        }
    }
    /*赠品处理开始*/
    $list_gift = array();//所有的赠品编号
    if ($_result['gift']) {
        $order_item_seq_id = $db->getOne("SELECT max(order_item_seq_id) from ecs_order_goods where order_id = {$order_id}");
        foreach ($_result['gift'] as $v) {
        	$list_gift[] = $v['goods'];
            $order_item_seq_id++;
			$rec_id = $db->getOne("SELECT rec_id FROM ecs_order_goods where goods_sn = '{$v['goods']}' and goods_type =1 and shipping_status != 5 and is_gift = 1 and order_id = {$order_id} ");            
			if ($rec_id) {
                $db->query("UPDATE ecs_order_goods SET goods_number = {$v['count']}  where goods_sn = '{$v['goods']}' and shipping_status != 5 and rec_id = {$rec_id} and order_id = {$order_id}");
                continue;
			}
        
	       if (!$rec_id) {
	            $sql = "INSERT INTO " . $ecs->table('order_goods') .
	                    " (order_id, goods_id, goods_name, goods_sn, " .
	                    "goods_number, market_price, goods_price, factory_price, " .
	                    "is_real, extension_code, parent_id, is_gift,brand_id,order_item_seq_id,goods_type,og_add_time)" .
	                    "SELECT '$order_id', goods_id, goods_name, goods_sn, " .
	                    "'{$v['count']}', market_price, '0', '1',  " .
	                    "is_real, extension_code, 0, 1,brand_id,$order_item_seq_id,1 ," . time() .
	                    " FROM " . $ecs->table('goods') .
	                    " WHERE goods_sn = '{$v['goods']}' LIMIT 1";
	             $db->query($sql);
	        }
        }
        order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '增加订单赠品' . $v['goods']);
    }else{
		if($db->getOne("SELECT 1 FROM ecs_order_goods WHERE goods_sn = '{$_gift}' and order_id = {$order_id}")){
		$db->getOne("UPDATE ecs_order_goods SET shipping_status = 5 , goods_number = 0 where shipping_status  = 0 and goods_type = 1 and is_gift = 1 and order_id = {$order_id}");
		 order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '取消所有活动赠品！');
		}
	}
	$order_gift_list = db_get_list('ecs_order_goods',"order_id = {$order_id} and shipping_status != 5 and goods_type = 1",'rec_id','goods_sn');
	foreach($order_gift_list as $_rec_id =>$_goods_sn){
		if(!in_array($_goods_sn,$list_gift)){
			$db->query("UPDATE ecs_order_goods SET goods_number = 0 , shipping_status = 5  where goods_sn = '{$_goods_sn}' and goods_type = 1 and is_gift = 1 and order_id = {$order_id}");
			continue;
		}
	}
	/*赠品处理结束*/
    $_result['reduce_product_fee'] = (float) $_result['reduce_product_fee'];
    $order_extend['add_discount'] = (float) $order_extend['add_discount'];
    if (((float) $_result['reduce_product_fee'] != (float) $order_extend['add_discount'])) {
        $reduce = $_result['reduce_product_fee'] - $order_extend['add_discount'];
        order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '活动满减从' . $order_extend['add_discount'] . '改为' . $_result['reduce_product_fee']);
        $db->query("UPDATE ecs_order_info SET discount = discount +$reduce where order_id = {$order_id}");
        $db->query("UPDATE ecs_order_extend SET add_discount = {$_result['reduce_product_fee']} where order_id = {$order_id}");
    }

    if ($_result['shipping_fee'] === -1) {
        order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '添加了额外商品但是此商品物流费无法计算');
    }
    $_result['shipping_fee'] = (int) $_result['shipping_fee'];
    $order['shipping_fee'] = (int) $order['shipping_fee'];

    if ($_result['shipping_fee'] != $order['shipping_fee']) {
        $db->query("UPDATE ecs_order_info SET shipping_fee = {$_result['shipping_fee']} where order_id = {$order_id}");
        order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '物流费从' . $order['shipping_fee'] . '改为' . $_result['shipping_fee']);
    }
    updateOrderAmount($order_id);

    if(!$order_extend['activity_id'])
    $activety 	 = Promotional_Activitie($order_id,array(),$order_extend['activity_id']);
	if($activety){
		$html_str = '';
		foreach($activety as $v){
			$html_str .= "<option value={$v['id']}>{$v['subject']}</option>";
		}
		echo 
<<<EOF
<form action="order.php?act=choose_activety&order_id={$order_id}" method ="POST" />
<select name="activity_id">
{$html_str}
</select>

<input type="submit" value="选择活动"   />活动一旦选择 无法更换
</form>
EOF;
exit;
	}
   if ($_REQUEST['patch']) {
        header("Location:/admin/order.php?act=edit&order_id={$order_id}&step=patch_goods");
    } else {
        header("Location:/admin/order.php?act=edit&order_id={$order_id}&step=goods");
    }   
    exit;
} else if ($_REQUEST['act'] == 'choose_activety') {
    $chengdu = $db->getOne("SELECT group_id from ecs_admin_user where group_id in (108,14,106) and user_id = {$_SESSION['admin_id']}");
    $var_str = getDBVariable('test_varchar');
    $var_str = explode(',', $var_str);
    if (!$chengdu && !in_array($_SESSION['admin_id'], $var_str)) {
        //sys_msg('测试功能！，暂不开放');
    }
    $order = $db->getRow("SELECT * FROM ecs_order_info where order_id = {$_GET['order_id']}");
    order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '修改了活动选择活动ID' . $_POST['activity_id']);

    $extend = $db->getOne("SELECT 1 FROM  `ecs_order_extend` WHERE `order_id`='" . $_GET['order_id'] . "'");
    $sql = '';
    if ($extend) {
        $db->query("UPDATE ecs_order_extend SET activity_id = {$_POST['activity_id']} where order_id = {$_GET['order_id']} ");
    } else {
        $sql = "INSERT INTO `ecs_order_extend` SET activity_id = {$_POST['activity_id']},`custom_district`='0',`order_id`='" . $_GET['order_id'] . "'";
        $db->query($sql);
    }
    //$db->query("UPDATE ecs_order_extend SET activity_id = {$_POST['activity_id']} where order_id = {$_GET['order_id']} ");
    touch_activity($_GET['order_id']);
    exit;
}else if($_REQUEST['act'] == 'get_assign_group'){
	
	//die(json_encode(array('A','B','C','D')));
	$order_id = $_REQUEST['order_id'];
	$rec_id = $_REQUEST['rec_id'];
	$value = $_REQUEST['value'];
	
	$_temp = $db->getOne("SELECT 1 from ecs_order_goods where rec_id = {$rec_id} and shipping_status  = 0");
	if($_temp){
		$result = getAssignGroup($order_id,$rec_id,$value);
	}else{
		$result = array('error'=>1);
	}
	//var_dump($result);
	//exit;
	$result = array_values( $result );
	
	die(json_encode($result));
}else if($_REQUEST['act'] == 'set_assign_group'){
	$order_id = $_REQUEST['order_id'];
	$rec_id = $_REQUEST['rec_id'];
	$value = $_REQUEST['value'];
	$goods_info = $db->getROW("SELECT goods_sn,goods_id from ecs_order_goods where rec_id = $rec_id");
    $order = $db->getRow("SELECT * FROM ecs_order_info where order_id = {$_GET['order_id']}");
    order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], "商品 {$goods_info['goods_sn']} 选择商品组为 {$value} （{$rec_id}）");
	$update = $db->getOne("SELECT 1 from ecs_order_goods_extend where rec_id = $rec_id");
	if(!$update){
    	$db->query("INSERT ecs_order_goods_extend (rec_id,order_id,goods_id,assign_group) values($rec_id,$order_id,{$goods_info['goods_id']},'$value')");
    }else{
    	$db->query("UPDATE ecs_order_goods_extend set assign_group = '$value' where rec_id = $rec_id");
    }
    
    if($db->affected_rows()){
    	echo 1;
    }else{
    	echo 0;
    }
}
else if ($_REQUEST['act']=='cancel_order_pri'){
	
	admin_priv('cancel_order_pri');
	
	$order_id = (int)$_GET['order_id'];
	$order = $db->getRow("SELECT * FROM ecs_order_info where order_id = {$order_id}");
	order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], "使用超级权限取消订单");
	$db->Query("UPDATE ecs_order_info SET order_status = 2,pre_ship_status = 'unsure' where order_id = {$order_id}");
	
	sys_msg('成功使用超级权限取消订单', 0, array(array('text'=>'返回查看','href'=>'order.php?act=info&order_id=' . $order_id)));
}
else if($_REQUEST['act'] == 'virtual_consign') { // 修改虚拟商品为已发货状态
    $order_id = $_REQUEST['order_id'];
    $db->query('UPDATE ecs_order_info set shipping_status=1 WHERE order_id=' . $order_id); // 修正订单为已发货状态
    $db->query("UPDATE ecs_order_goods set shipping_status=1 WHERE order_id=" . $order_id); // 修正商品为已发货状态
    $order = $db->getRow("SELECT * FROM ecs_order_info where order_id = $order_id");
    order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], "修改订单为已发货状态");
    sys_msg('成功修改订单为已发货状态', 0, array(array('text'=>'返回查看','href'=>'order.php?act=info&order_id=' . $order_id)));
}

/**
 * 设置导出采购中的数据信息
 * @param $array
 *
 */
function set_excel_info($goods_list, $path = 0) {
    global $info, $zip;
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

    $objPHPExcel->getActiveSheet()->mergeCells('A1:H1'); //合并单元格
    $objPHPExcel->setActiveSheetIndex(0); //选择工作薄
    $objRichText = new PHPExcel_RichText();
    $objRichText->createText('');
    $objPayable = $objRichText->createTextRun('美乐乐采购订单');
    $objPayable->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED));
    $objPayable->getFont()->setBold(true);
    $objPayable->getFont()->setSize(24);
    $objPHPExcel->getActiveSheet()->getCell('A1')->setValue($objRichText);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);       // 加粗
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(24);         // 字体大小
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED); // 文本颜色
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER); //设置对其方式
    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(40); //行高
    // 列宽
    //$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    // 行高
    for ($i = 2; $i <= 50; $i++) {
        $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
    }
    $objPHPExcel->getActiveSheet()->mergeCells('A2:B2'); //合并单元格
    $objPHPExcel->getActiveSheet()->setCellValue('A2', '供货方:');
    $objPHPExcel->getActiveSheet()->mergeCells('C2:D2'); //合并单元格
    $objPHPExcel->getActiveSheet()->setCellValue('C2', '联系方式：');
    $objPHPExcel->getActiveSheet()->mergeCells('E2:H2'); //合并单元格
    $objPHPExcel->getActiveSheet()->setCellValue('E2', '定单编号：' . $info['order_sn']);

    $objPHPExcel->getActiveSheet()->mergeCells('A3:B3'); //合并单元格
    $objPHPExcel->getActiveSheet()->setCellValue('A3', '订购方:');
    $objPHPExcel->getActiveSheet()->mergeCells('C3:D3'); //合并单元格
    $objPHPExcel->getActiveSheet()->setCellValue('C3', '联系方式：');
    $objPHPExcel->getActiveSheet()->mergeCells('E3:H3'); //合并单元格
    $objPHPExcel->getActiveSheet()->setCellValue('E3', '订单日期：' . date('Y年m月d日', $info['add_time']));

    $objPHPExcel->getActiveSheet()->mergeCells('A4:H4'); //合并单元格
    $objPHPExcel->getActiveSheet()->setCellValue('A4', '订购产品信息：');
    $title = array('序号', '商品名称', '原始编号', '属性', '色板编号', '成本价', '数量', '小计');
    $titlelen = count($title);
    for ($i = 0; $i < $titlelen; $i++) {
        $objPHPExcel->getActiveSheet()->setCellValue(chr(65 + $i) . '5', $title[$i]);
        //$objPHPExcel->getActiveSheet()->getStyle(chr(65+$i).'5')->getBorders()->getLeft()->getColor()->setARGB(’FF993300′);//设置边框颜色
    }
    $line = 6;
    //商品信息
    $goodscount = count($goods_list);
    $_sum = 0;
    for ($i = 0; $i < $goodscount; $i++) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $line, $i + 1);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $line, $goods_list[$i]['goods_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $line, $goods_list[$i]['goods_sn_ori']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $line, $goods_list[$i]['goods_spec']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $line, $goods_list[$i]['cloth_goods_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $line, $goods_list[$i]['formated_factory_price']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $line, $goods_list[$i]['goods_number']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $line, $goods_list[$i]['formated_factory_price']);
        $line++;
        $_sum += $goods_list[$i]['factory_price'];
    }
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $line, '合计');
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $line, price_format($_sum));
    $line++;
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $line, '备注');
    $objPHPExcel->getActiveSheet()->mergeCells('B' . $line . ':H' . $line); //合并单元格
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $line, $info['postscript'] . ' 此订单为: ' . $info['consignee'] . ' 的,谢谢!');
    $line+=2; //空一行
    $objPHPExcel->getActiveSheet()->mergeCells('A' . $line . ':H' . $line); //合并单元格
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $line, '美乐乐家具有限公司收货地址（仓库）：广东省佛山市南海区九江镇沙头工业园A区（福得旺家具背面) 电话：0757-63360308/63365532/63365530');
    $line++;
    //商品图片和面板信息
    $objPHPExcel->getActiveSheet()->mergeCells('F' . $line . ':H' . $line); //合并单元格
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $line, '颜色要求');
    $objPHPExcel->getActiveSheet()->mergeCells('A' . $line . ':D' . $line); //合并单元格
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $line, '要下图中的');
    for ($i = 0; $i < $goodscount; $i++) {
        $objPHPExcel->getActiveSheet()->mergeCells('F' . $line . ':H' . $line); //合并单元格
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $line, '颜色要求');
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $line . ':D' . $line); //合并单元格
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $line, '要下图中的 ' . $goods_list[$i]['goods_sn_ori'] . ' 的 ' . $goods_list[$i]['goods_name'] . ' ' . $goods_list[$i]['goods_number'] . '个,' . $bb[1]);
        //图片信息
        $line++;
        if (file_exists(ROOT_PATH . $goods_list[$i]['img_url'])) {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Photo' . $i);
            $objDrawing->setDescription('Photo' . $i);
            $objDrawing->setPath(ROOT_PATH . $goods_list[$i]['img_url']);
            $objDrawing->setHeight(500);
            $objDrawing->setWidth(500);
            $objDrawing->setCoordinates('A' . $line); //图片地址
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        }
        //面板信息
        $_tmp = explode(':', $goods_list[$i]['cloth_goods_id']);
        $filename = ROOT_PATH . $_tmp['2'];
        if ($goods_list[$i]['cloth_goods_id'] && file_exists($filename)) {
            $line++;
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Photo' . $i);
            $objDrawing->setDescription('Photo' . $i);
            /*
              $pos = strrpos($goods_list[$i]['img_url'], '.');
              $kuozhanming = substr($goods_list[$i]['img_url'], $pos);
             */
            $objDrawing->setPath($filename);
            $objDrawing->setHeight(500);
            $objDrawing->setWidth(500);
            $objDrawing->setCoordinates('F' . $line); //图片地址
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        }
        $line+=10;
    }

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('美乐乐采购订单');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    if ($path) {
        $objWriter->save('mll.xls');
        $str = file_get_contents('mll.xls');
        $rand = mt_rand(5, 1000);
        $zip->add_file($str, 'pinpai' . $rand . '.xls');
        @unlink('mll.xls');
    } else {
        $objWriter->save('php://output');
    }
}

/**
 * 取得状态列表
 * @param   string  $type   类型：all | order | shipping | payment
 */
function get_status_list($type = 'all') {
    global $_LANG;

    $list = array();

    if ($type == 'all' || $type == 'order') {
        $pre = $type == 'all' ? 'os_' : '';
        foreach ($_LANG['os'] AS $key => $value) {
            $list[$pre . $key] = $value;
        }
    }

    if ($type == 'all' || $type == 'shipping') {
        $pre = $type == 'all' ? 'ss_' : '';
        foreach ($_LANG['ss'] AS $key => $value) {
            $list[$pre . $key] = $value;
        }
    }

    if ($type == 'all' || $type == 'payment') {
        $pre = $type == 'all' ? 'ps_' : '';
        foreach ($_LANG['ps'] AS $key => $value) {
            $list[$pre . $key] = $value;
        }
    }
    return $list;
}

/**
 * 退回余额、积分、红包（取消、无效、退货时），把订单使用余额、积分、红包设为0
 * @param   array   $order  订单信息
 */
function return_user_surplus_integral_bonus($order) {
    /* 处理余额、积分、红包 */
    if ($order['user_id'] > 0 && $order['surplus'] > 0) {
        log_account_change($order['user_id'], $order['surplus'], 0, 0, 0, sprintf($GLOBALS['_LANG']['return_order_surplus'], $order['order_sn']));
    }

    if ($order['user_id'] > 0 && $order['integral'] > 0) {
        log_account_change($order['user_id'], 0, 0, 0, $order['integral'], sprintf($GLOBALS['_LANG']['return_order_integral'], $order['order_sn']));
    }

    if ($order['bonus_id'] > 0) {
        unuse_bonus($order['bonus_id']);
    }

    /* 修改订单 */
    $arr = array(
        'bonus_id' => 0,
        'bonus' => 0,
        'integral' => 0,
        'integral_money' => 0,
        'surplus' => 0
    );
    update_order($order['order_id'], $arr);
}

/**
 * 取得订单应该发放的红包
 * @param   int     $order_id   订单id
 * @return  array
 */
function order_bonus($order_id) {
    /* 查询按商品发的红包 */
    $day = getdate();
    $today = local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);

    $sql = "SELECT b.type_id, b.type_money, SUM(o.goods_number) AS number " .
            "FROM " . $GLOBALS['ecs']->table('order_goods') . " AS o, " .
            $GLOBALS['ecs']->table('goods') . " AS g, " .
            $GLOBALS['ecs']->table('bonus_type') . " AS b " .
            " WHERE o.order_id = '$order_id' " .
            " AND o.is_gift = 0 " .
            " AND o.goods_id = g.goods_id " .
            " AND g.bonus_type_id = b.type_id " .
            " AND b.send_type = '" . SEND_BY_GOODS . "' " .
            " AND b.send_start_date <= '$today' " .
            " AND b.send_end_date >= '$today' " .
            " GROUP BY b.type_id ";
    $list = $GLOBALS['db']->getAll($sql);

    /* 查询定单中非赠品总金额 */
    $amount = order_amount($order_id, false);

    /* 查询订单日期 */
    $sql = "SELECT add_time " .
            " FROM " . $GLOBALS['ecs']->table('order_info') .
            " WHERE order_id = '$order_id' LIMIT 1";
    $order_time = $GLOBALS['db']->getOne($sql);

    /* 查询按订单发的红包 */
    $sql = "SELECT type_id, type_money, IFNULL(ROUND('$amount' / min_amount), 1) AS number " .
            "FROM " . $GLOBALS['ecs']->table('bonus_type') .
            "WHERE send_type = '" . SEND_BY_ORDER . "' " .
            "AND send_start_date <= '$order_time' " .
            "AND send_end_date >= '$order_time' ";
    $list = array_merge($list, $GLOBALS['db']->getAll($sql));

    return $list;
}

/**
 * 发红包：发货时发红包
 * @param   int     $order_id   订单号
 * @return  bool
 */
function send_order_bonus($order_id) {
    /* 取得订单应该发放的红包 */
    $bonus_list = order_bonus($order_id);

    /* 如果有红包，统计并发送 */
    if ($bonus_list) {
        /* 用户信息 */
        $sql = "SELECT u.user_id, u.user_name, u.email " .
                "FROM " . $GLOBALS['ecs']->table('order_info') . " AS o, " .
                $GLOBALS['ecs']->table('users') . " AS u " .
                "WHERE o.order_id = '$order_id' " .
                "AND o.user_id = u.user_id ";
        $user = $GLOBALS['db']->getRow($sql);

        /* 统计 */
        $count = 0;
        $money = '';
        foreach ($bonus_list AS $bonus) {
            $count += $bonus['number'];
            $money .= price_format($bonus['type_money']) . ' [' . $bonus['number'] . '], ';

            /* 修改用户红包 */
            $sql = "INSERT INTO " . $GLOBALS['ecs']->table('user_bonus') . " (bonus_type_id, user_id) " .
                    "VALUES('$bonus[type_id]', '$user[user_id]')";
            for ($i = 0; $i < $bonus['number']; $i++) {
                if (!$GLOBALS['db']->query($sql)) {
                    return $GLOBALS['db']->errorMsg();
                }
            }
        }

        /* 如果有红包，发送邮件 */
        if ($count > 0) {
            $tpl = get_mail_template('send_bonus');
            $GLOBALS['smarty']->assign('count', $count);
            $GLOBALS['smarty']->assign('money', $money);
            $GLOBALS['smarty']->assign('shop_name', $GLOBALS['_CFG']['shop_name']);
            $GLOBALS['smarty']->assign('send_date', date($GLOBALS['_CFG']['date_format']));
            $GLOBALS['smarty']->assign('sent_date', date($GLOBALS['_CFG']['date_format']));
            $content = $GLOBALS['smarty']->fetch('str:' . $tpl['template_content']);
            send_mail($user['user_name'], $user['email'], $tpl['template_subject'], $content, $tpl['is_html']);
        }
    }

    return true;
}

/**
 * 返回订单发放的红包
 * @param   int     $order_id   订单id
 */
function return_order_bonus($order_id) {
    /* 取得订单应该发放的红包 */
    $bonus_list = order_bonus($order_id);

    /* 删除 */
    if ($bonus_list) {
        /* 取得订单信息 */
        $order = order_info($order_id);
        $user_id = $order['user_id'];

        foreach ($bonus_list AS $bonus) {
            $sql = "DELETE FROM " . $GLOBALS['ecs']->table('user_bonus') .
                    " WHERE bonus_type_id = '$bonus[type_id]' " .
                    "AND user_id = '$user_id' " .
                    "AND order_id = '0' LIMIT " . $bonus['number'];
            $GLOBALS['db']->query($sql);
        }
    }
}

/**
 * 更新订单总金额
 * @param   int     $order_id   订单id
 * @return  bool
 */
function update_order_amount($order_id) {
    include_once(ROOT_PATH . 'includes/lib_order.php');
    $sql = "UPDATE " . $GLOBALS['ecs']->table('order_info') .
            " SET order_amount = " . order_due_field() .
            " WHERE order_id = '$order_id' LIMIT 1";

    return $GLOBALS['db']->query($sql);
}

/**
 * 返回某个订单可执行的操作列表，包括权限判断
 * @param   array   $order      订单信息 order_status, shipping_status, pay_status
 * @param   bool    $is_cod     支付方式是否货到付款
 * @return  array   可执行的操作  confirm, pay, unpay, prepare, ship, unship, receive, cancel, invalid, return, drop
 * 格式 array('confirm' => true, 'pay' => true)
 */
function operable_list($order) {
    /* 取得订单状态、发货状态、付款状态 */
    $os = $order['order_status'];
    $ss = $order['shipping_status'];
    $ps = $order['pay_status'];

    /* 取得订单操作权限 */
    $actions = $_SESSION['action_list'];
    if ($actions == 'all') {
        $priv_list = array('os' => true, 'ss' => true, 'ps' => true, 'edit' => true);
    } else {
        $actions = ',' . $actions . ',';
        $priv_list = array(
            'os' => strpos($actions, ',order_os_edit,') !== false,
            'ss' => strpos($actions, ',order_ss_edit,') !== false,
            'ps' => strpos($actions, ',order_ps_edit,') !== false,
            'edit' => strpos($actions, ',order_edit,') !== false
        );
    }

    /* 取得订单支付方式是否货到付款 */
    $payment = payment_info($order['pay_id']);
    $is_cod = $payment['is_cod'] == 1;

    /* 根据状态返回可执行操作 */
    $list = array();
    if (OS_UNCONFIRMED == $os) {
        /* 状态：未确认 => 未付款、未发货 */
        if ($priv_list['os']) {
            $list['confirm'] = true; // 确认
            $list['invalid'] = true; // 无效
            $list['cancel'] = true; // 取消
            if ($is_cod) {
                /* 货到付款 */
                if ($priv_list['ss']) {
                    $list['prepare'] = true; // 配货
                    $list['ship'] = true; // 发货
                    $list['reserve'] = true; // 发货
                    $list['reserve_cancel'] = true; // 发货
                }
            } else {
                /* 不是货到付款 */
                if ($priv_list['ps']) {
                    $list['pay'] = true;  // 付款
                }
            }
        }
    } elseif (OS_CONFIRMED == $os || OS_AFTER_SRV == $os) {

        $list['audit'] = true;
        $list['ch_order_type'] = true;
        $list['assign_mech'] = true;
        /* 如果有售后，可以关售后 */
        if (OS_AFTER_SRV == $os) {
            $list['close_service'] = true;
        }


        /* 状态：已确认 */
        if (PS_UNPAYED == $ps) {
            /* 状态：已确认、未付款 */
            if (SS_UNSHIPPED == $ss || SS_PREPARING == $ss) {
                /* 状态：已确认、未付款、未发货（或配货中） */
                if ($priv_list['os']) {
                    $list['cancel'] = true; // 取消
                    $list['invalid'] = true; // 无效
                }
                if ($is_cod) {
                    /* 货到付款 */
                    if ($priv_list['ss']) {
                        if (SS_UNSHIPPED == $ss) {
                            $list['prepare'] = true; // 配货
                        }
                        $list['ship'] = true; // 发货
                        $list['reserve'] = true; // 发货
                        $list['reserve_cancel'] = true; // 发货
                    }
                } else {
                    /* 不是货到付款 */
                    if ($priv_list['ps']) {
                        $list['pay'] = true; // 付款
                    }
                }
            } else {
                // var_dump($ss);
                if (SS_PART_SHIPPED == $ss || SS_SHIPPED == $ss) {
                    $list['transfer_add'] = true;
                }

                /* 状态：已确认、未付款、已发货或已收货 => 货到付款 */
                if ($priv_list['ps']) {
                    $list['pay'] = true; // 付款
                }
                if ($priv_list['ss']) {
                    if (SS_SHIPPED == $ss) {
                        $list['receive'] = true; // 收货确认
                    }
                    //$list['unship'] = true; // 设为未发货 2012-8-3
                    if ($priv_list['os']) {
                        $list['return'] = true; // 退货
                    }
                }
            }
        } else {
            /* 状态：已确认、已付款和付款中 */
            if (SS_UNSHIPPED == $ss || SS_PREPARING == $ss || SS_PART_SHIPPED == $ss) {
                /* 状态：已确认、已付款和付款中、未发货（配货中） => 不是货到付款 */
                if ($priv_list['ss']) {
                    //if (SS_UNSHIPPED == $ss)
                    //{
                    $list['prepare'] = true; // 配货
                    //}
                    $list['ship'] = true; // 发货
                    $list['reserve'] = true; // 发货
                    $list['reserve_cancel'] = true; // 发货
                }
                if ($priv_list['ps']) {
                    $list['unpay'] = true; // 设为未付款
                    if ($priv_list['os']) {
                        $list['cancel'] = true; // 取消
                    }
                }
            } else {
                // var_dump($ss);
                if (SS_PART_SHIPPED == $ss || SS_SHIPPED == $ss) {
                    $list['transfer_add'] = true;
                }

                /* 状态：已确认、已付款和付款中、已发货或已收货 */
                if ($priv_list['ss']) {
                    if (SS_SHIPPED == $ss && $ps == PS_PAYED) {
                        $list['receive'] = true; // 收货确认
                    }
                    if (!$is_cod) {
                        $list['unship'] = true; // 设为未发货
                    }
                }
                if ($priv_list['ps'] && $is_cod) {
                    $list['unpay'] = true; // 设为未付款
                }
                if ($priv_list['os'] && $priv_list['ss'] && $priv_list['ps']) {
                    $list['return'] = true; // 退货（包括退款）
                }
            }
        }
    } elseif (OS_CANCELED == $os) {
        /* 状态：取消 */
        if ($priv_list['os']) {
            $list['confirm'] = true;
        }
        if ($priv_list['edit']) {
            $list['remove'] = true;
        }
    } elseif (OS_INVALID == $os) {
        /* 状态：无效 */
        if ($priv_list['os']) {
            $list['confirm'] = true;
        }
        if ($priv_list['edit']) {
            $list['remove'] = true;
        }
    } elseif (OS_RETURNED == $os) {
        /* 状态：退货 */
        if ($priv_list['os']) {
            $list['confirm'] = true;
        }
    }

    /* 修正发货操作 */
    if (!empty($list['ship'])) {
        /* 如果是团购活动且未处理成功，不能发货 */
        if ($order['extension_code'] == 'group_buy') {
            include_once(ROOT_PATH . 'includes/lib_goods.php');
            $group_buy = group_buy_info(intval($order['extension_id']));
            if ($group_buy['status'] != GBS_SUCCEED) {
                unset($list['ship']);
            }
        }
    }

    /* 售后 */
    if (check_authz('order_after_service'))
        $list['after_service'] = true;
    else
        $list['after_service'] = false;

    //判断是否为付款中，如果是，$list['pay'] = true;
    if ($order['pay_status'] == PS_PAYING)
        $list['pay'] = true;
    return $list;
}

/**
 * 处理编辑订单时订单金额变动
 * @param   array   $order  订单信息
 * @param   array   $msgs   提示信息
 * @param   array   $links  链接信息
 */
function handle_order_money_change($order, &$msgs, &$links) {
    $order_id = $order['order_id'];
    if (($order['pay_status'] == PS_PAYED || $order['pay_status'] == PS_PAYING) && $order['order_type'] != 'patch_order') {
        /* 应付款金额 */
        $money_dues = $order['order_amount'];
        $money_pay = $order['money_paid'];
        if ($money_pay <= 0) {
            /* 修改订单为未付款 */
            update_order($order_id, array('pay_status' => PS_UNPAYED, 'pay_time' => 0));
            $msgs[] = $GLOBALS['_LANG']['amount_increase'];
            $links[] = array('text' => $GLOBALS['_LANG']['order_info'], 'href' => 'order.php?act=info&order_id=' . $order_id);
        } elseif ($money_pay > 0 and $money_pay < $money_dues) {
            /* 修改订单为付款中 */
            update_order($order_id, array('pay_status' => PS_PAYING));
            $msgs[] = $GLOBALS['_LANG']['amount_increase'];
            $links[] = array('text' => $GLOBALS['_LANG']['order_info'], 'href' => 'order.php?act=info&order_id=' . $order_id);
        } elseif ($money_pay >= $money_dues) {
            /* 修改订单为已付款 */
            update_order($order_id, array('pay_status' => PS_PAYED));
            $msgs[] = $GLOBALS['_LANG']['amount_decrease'];
            $links[] = array('text' => $GLOBALS['_LANG']['order_info'], 'href' => 'order.php?act=info&order_id=' . $order_id);
        }
        /*
          elseif ($money_pay >= $money_dues)
          {
          update_order($order_id, array('pay_status' => PS_PAYED));
          $anonymous  = $order['user_id'] > 0 ? 0 : 1;
          $msgs[]     = $GLOBALS['_LANG']['amount_decrease'];
          $links[]    = array('text' => $GLOBALS['_LANG']['refund'], 'href' => 'order.php?act=process&func=load_refund&anonymous=' .
          $anonymous . '&order_id=' . $order_id . '&refund_amount=' . abs($money_dues));
          }
         */
    }
}

/**
 *  获取订单列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function order_list() {
    global $cache, $db_select;
    $result = get_filter();
    if ($result === false) {
        /* 过滤信息 */
        $filter['third_part'] = empty($_REQUEST['third_part']) ? '' : trim($_REQUEST['third_part']);
        $filter['delivery_party'] = empty($_REQUEST['delivery_party']) ? '' : trim($_REQUEST['delivery_party']);
        $filter['order_sn'] = empty($_REQUEST['order_sn']) ? '' : trim($_REQUEST['order_sn']);
        $filter['consignee'] = empty($_REQUEST['consignee']) ? '' : trim($_REQUEST['consignee']);
        $filter['email'] = empty($_REQUEST['email']) ? '' : trim($_REQUEST['email']);
        $filter['address'] = empty($_REQUEST['address']) ? '' : trim($_REQUEST['address']);
        $filter['zipcode'] = empty($_REQUEST['zipcode']) ? '' : trim($_REQUEST['zipcode']);
        $filter['tel'] = empty($_REQUEST['tel']) ? '' : trim($_REQUEST['tel']);
        $filter['mobile'] = empty($_REQUEST['mobile']) ? 0 : trim($_REQUEST['mobile']);
        $filter['country'] = empty($_REQUEST['country']) ? 0 : intval($_REQUEST['country']);
        $filter['province'] = empty($_REQUEST['province']) ? 0 : intval($_REQUEST['province']);
        $filter['city'] = empty($_REQUEST['city']) ? 0 : intval($_REQUEST['city']);
        $filter['district'] = empty($_REQUEST['district']) ? 0 : intval($_REQUEST['district']);
        $filter['shipping_id'] = empty($_REQUEST['shipping_id']) ? 0 : intval($_REQUEST['shipping_id']);
        $filter['pay_id'] = empty($_REQUEST['pay_id']) ? 0 : intval($_REQUEST['pay_id']);
        $filter['order_status'] = isset($_REQUEST['order_status']) ? intval($_REQUEST['order_status']) : -1;
        $filter['shipping_status'] = isset($_REQUEST['shipping_status']) ? intval($_REQUEST['shipping_status']) : -1;
        $filter['pay_status'] = isset($_REQUEST['pay_status']) ? intval($_REQUEST['pay_status']) : -1;
        $filter['user_id'] = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
        $filter['user_name'] = empty($_REQUEST['user_name']) ? '' : trim($_REQUEST['user_name']);
        $filter['composite_status'] = isset($_REQUEST['composite_status']) ? $_REQUEST['composite_status'] : -1;
        $filter['saleman_group'] = empty($_REQUEST['saleman_group']) ? 0 : $_REQUEST['saleman_group'];
        $filter['stranstype'] = empty($_REQUEST['stranstype']) ? '' : $_REQUEST['stranstype'];

        if ($filter['composite_status'] == '-2') {
            $filter['admin_id'] = 0;
        }
        $filter['group_buy_id'] = isset($_REQUEST['group_buy_id']) ? intval($_REQUEST['group_buy_id']) : 0;
        $filter['sales_name'] = $_REQUEST['sales_name'];
        $filter['assign_status'] = empty($_REQUEST['assign_status']) ? '' : trim($_REQUEST['assign_status']);
        $filter['mech_user'] = empty($_REQUEST['mech_user']) ? '' : trim($_REQUEST['mech_user']);


        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'add_time' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $filter['expr'] = !empty($_REQUEST['expr']) ? $_REQUEST['expr'] : 0;

        $start_time = $_REQUEST['start_time'] ? $_REQUEST['start_time'] : 0;
        $end_time = $_REQUEST['end_time'] ? $_REQUEST['end_time'] : time();


        $filter['start_time'] = $_REQUEST['start_date'] ? strtotime($_REQUEST['start_date']) : $start_time;
        $filter['end_time'] = $_REQUEST['end_date'] ? strtotime($_REQUEST['end_date']) : $end_time;

        $filter['add_start_time'] = $_REQUEST['add_start_time'] ? $_REQUEST['add_start_time'] : '';
        $filter['add_end_time'] = $_REQUEST['add_end_time'] ? $_REQUEST['add_end_time'] : '';
        $filter['saler_time'] = $_REQUEST['saler_time'] ? $_REQUEST['saler_time'] : '';

        $filter['profit_min'] = !empty($_REQUEST['profit_min']) && is_numeric($_REQUEST['profit_min']) ? $_REQUEST['profit_min'] : 0;
        $filter['profit_max'] = !empty($_REQUEST['profit_max']) && is_numeric($_REQUEST['profit_max']) ? $_REQUEST['profit_max'] : 0;

        $filter['discount_min'] = !empty($_REQUEST['discount_min']) && is_numeric($_REQUEST['discount_min']) ? $_REQUEST['discount_min'] : 0;
        $filter['discount_max'] = !empty($_REQUEST['discount_max']) && is_numeric($_REQUEST['discount_max']) ? $_REQUEST['discount_max'] : 0;

        $filter['order_type'] = $_REQUEST['order_type'];

        $filter['user_name'] = empty($_REQUEST['user_name']) ? '' : trim($_REQUEST['user_name']);
        $filter['pre_ship_status'] = empty($_REQUEST['pre_ship_status']) ? '' : trim($_REQUEST['pre_ship_status']);
        $where = 'WHERE 1 ';

        if ($filter['discount_max'] > 0 && $filter['discount_max'] > $filter['discount_min']) {
            $discount_max = $filter['discount_max'] / 100;
            $discount_min = $filter['discount_min'] / 100;
            $where .= " AND (o.discount/o.goods_amount)>={$discount_min} AND (o.discount/o.goods_amount)<{$discount_max}";
        }

        if (!empty($filter['user_name'])) {
            $user_id = $GLOBALS['db']->getOne("SELECT user_id FROM `ecs_users` WHERE user_name='{$filter['user_name']}'");
            $where .= " AND o.user_id='$user_id'";
        }

        if ($filter['expr'] == -1) {
            $where .= " AND o.expr_id > 0 ";
        }
        if (!empty($filter['order_type'])) {
            $where .= " AND o.order_type = '{$filter['order_type']}'";
        }
        if ($filter['expr'] > 0) {
            $where .= " AND o.expr_id = {$filter['expr']} ";
        }

        if ($filter['start_time'] > 0 && $filter['start_time'] < $filter['end_time']) {
            $where .= " AND o.shipping_time >= {$filter['start_time']}  AND o.shipping_time < {$filter['end_time']}";
        }

        if ($filter['delivery_party']) {
            $table_plus = " INNER JOIN ecs_order_extend e ON o.order_id = e.order_id ";
            $where .= " AND e.delivery_party = '{$filter['delivery_party']}' ";
        }
        if ($filter['third_part']) {
            $table_plus = " INNER JOIN ecs_order_extend e ON o.order_id = e.order_id ";
            $where .= " AND e.shop_id = '{$filter['third_part']}' ";
        }

        if ($filter['order_sn']) {
            $where .= " AND o.order_sn LIKE '" . mysql_like_quote($filter['order_sn']) . "%'";
        }

        if ($filter['assign_status']) {
            $where .= " AND o.assign_status ='" . mysql_like_quote($filter['assign_status']) . "'";
        }

        if ($filter['mech_user']) {
            $where .= " AND o.ship_merch_name ='" . mysql_like_quote($filter['mech_user']) . "'";
        }
        if ($filter['add_start_time'] && $filter['saler_time'] == 1) {
            $where .= " AND o.add_time >=" . strtotime($filter['add_start_time']);
        }
        if ($filter['add_end_time'] && $filter['saler_time'] == 1) {
            $where .= " AND o.add_time <=" . (strtotime($filter['add_end_time']) + 86400);
        }
        if ($filter['sales_name']) {
            $admin_name = explode('|', $filter['sales_name']);
            if (count($admin_name) !== 1) {//防止重名
                foreach ($admin_name as $a) {
                    if ($a) {
                        $user_id = $GLOBALS['db']->getOne("SELECT user_id FROM ecs_admin_user WHERE real_name = '" . $a . "'");
                        if ($user_id)
                            $admin_id .= '|' . $user_id;
                    }
                }

                if ($admin_id) {
                    $admin_id = $admin_id . '|';
                    $where .= " AND admin_id = '" . $admin_id . "'";
                }
            } else {
                $table_plus .= ' JOIN mll_order_belonging mob ON o.order_id=mob.order_id ';
                $user_id_tmp = $db_select->getAll("SELECT user_id FROM ecs_admin_user WHERE real_name = '" . $admin_name[0] . "'");
                $where_str = '';
                foreach ($user_id_tmp as $v) {
                    if ($where_str) {
                        $where_str .= " or mob.user_id = '" . $v['user_id'] . "' ";
                    } else {
                        $where_str = " mob.user_id = '" . $v['user_id'] . "' ";
                    }
                }
                $where .= " and ({$where_str}) ";
            }
        }
        if ($filter['pre_ship_status']) {
            $where .= " AND (o.pre_ship_status = '{$filter['pre_ship_status']}')";
        }
        if($filter['stranstype'])
        {
            // $sexpressid = $GLOBALS['db']->getCol('SELECT order_id FROM ecs_order_extend where trans_type=' . $filter['stranstype']);
            // if(!empty($sexpressid))
            // {
            //     $expressidsql = implode(',', $sexpressid);
            //     $where .= "AND o.order_id in ($expressidsql)";    
            // }
            $table_plus = " INNER JOIN ecs_order_extend e ON o.order_id = e.order_id ";
            $where .= "AND e.trans_type={$filter['stranstype']}";
        }
        if ($filter['consignee']) {
            $where .= " AND (o.consignee LIKE '" . mysql_like_quote($filter['consignee']) . "%' )";
        }
        if ($filter['email']) {
            $where .= " AND o.email LIKE '%" . mysql_like_quote($filter['email']) . "%'";
        }
        if ($filter['address']) {
            $where .= " AND o.address LIKE '%" . mysql_like_quote($filter['address']) . "%'";
        }
        if ($filter['zipcode']) {
            $where .= " AND o.zipcode LIKE '%" . mysql_like_quote($filter['zipcode']) . "%'";
        }
        if ($filter['tel']) {
            $where .= " AND o.tel LIKE '%" . mysql_like_quote($filter['tel']) . "%'";
        }
        if ($filter['mobile']) {
            $where .= " AND o.mobile = '" . $filter['mobile'] . "'";
        }
        if ($filter['country']) {
            $where .= " AND o.country = '$filter[country]'";
        }
        if ($filter['province']) {
            $where .= " AND o.province = '$filter[province]'";
        }
        if ($filter['city']) {
            $where .= " AND o.city = '$filter[city]'";
        }
        if ($filter['district']) {
            $where .= " AND o.district = '$filter[district]'";
        }
        if ($filter['shipping_id']) {
            $where .= " AND o.shipping_id  = '$filter[shipping_id]'";
        }
        if ($filter['pay_id']) {
            $where .= " AND o.pay_id  = '$filter[pay_id]'";
        }
        if ($filter['order_status'] != -1) {
            $where .= " AND o.order_status  = '$filter[order_status]'";
        }
        if ($filter['shipping_status'] != -1) {
            $where .= " AND o.shipping_status = '$filter[shipping_status]'";
        }
        if ($filter['pay_status'] != -1) {
            $where .= " AND o.pay_status = '$filter[pay_status]'";
        }
        if ($filter['user_id']) {
            $where .= " AND o.user_id = '$filter[user_id]'";
        }
        if ($filter['user_name']) {
            $where .= " AND u.user_name LIKE '%" . mysql_like_quote($filter['user_name']) . "%'";
        }
        if ($_REQUEST['limit_sale'] == 1 || $_REQUEST['limit_sale'] == 2) {
            $where .= " AND o.limit_sale = " . $_REQUEST['limit_sale'];
        }
        if (isset($filter['admin_id'])) {
            $where .= " AND (o.admin_id = '0') ";
        }
        if (!empty($filter['saleman_group'])) {
            $where .= " AND (o.group_id = {$filter['saleman_group']}) ";
        }
        /* 预计发货时间排序时候有问题 如果为空就会ASC到最前面 有问题 */
        if ($filter['sort_by'] == 'pre_ship_time' && $filter['sort_order'] == "ASC")
            $pre_ship_time = "if(o.pre_ship_time > 0,o.pre_ship_time,2000000000) as pre_ship_time";
        else
            $pre_ship_time = "o.pre_ship_time";
        /* 2012-7-5 赵君平需求双条件排序 */
        $sort_by_ext = '';
        if ($filter['sort_by'] == 'pre_ship_time') {
            if ($_SESSION['order_by_field'] != '' && $_SESSION['order_by_field']) {
                $sort_by_ext = " , {$_SESSION['order_by_field']} {$filter['sort_order'] } ";
            }
        } else {
            $_SESSION['order_by_field'] = $filter['sort_by'];
        }

        //综合状态
        switch ($filter['composite_status']) {
            case CS_AWAIT_PAY :
                $where .= order_query_sql('await_pay');
                break;

            case CS_AWAIT_SHIP :
                $where .= " AND o.order_status = 1 AND o.order_type != 'inside_trade' AND o.shipping_status in(0,3,4) AND (o.pay_status in(1,2) OR o.is_received_pay=1)";
                break;

            case CS_FINISHED :
                $where .= order_query_sql('finished');
                break;
            case CS_SERV:
                $where .= order_query_sql('services');
                break;
            case CS_SHIIPED_NO_REC:
                $where .= order_query_sql('shipped_no_rec');
                break;
            case 11:
                $where .= " AND o.pay_status=1 AND o.shipping_status=1";
                break;
            case CS_AUDIT_NEW:
                $where .= " AND o.audit_status = 'new'";
                break;
            case CS_AUDIT_AUDIT:
                $where .= " AND o.audit_status = 'audit'";
                break;
            case CS_AUDIT_REJECT:
                $where .= " AND o.audit_status = 'reject'";
                break;
            case "inside_trade":
                $where .= " AND o.order_type = 'inside_trade'";
                break;
            case "photo_order":
                $where .= " AND o.order_type = 'photo_order'";
                break;
            case "expr_order":
                $where .= " AND o.order_type = 'expr_order'";
                break;
            case "expr_gift":
                $where .= " AND o.order_type = 'expr_gift'";
                break;
			case "patch_order":
                $where .= " AND o.order_type = 'patch_order'";
                break;
            case "ship_hurry":
                $where .= " AND o.pre_ship_status = 'hurry' AND o.order_type !='inside_trade' AND o.order_status = 1 AND o.shipping_status in(0,3,4) AND (pay_status in(1,2) OR is_received_pay=1)";
                break;
            case "unsure":
                $where .= " AND o.pre_ship_status = 'unsure' AND o.order_type !='inside_trade' AND o.order_status = 1 AND o.shipping_status in(0,3,4) AND (pay_status in(1,2) OR is_received_pay=1)";
                break;
            case "ship_need":
                $where .= " AND o.pre_ship_status = 'ship_need' AND o.order_type !='inside_trade' AND o.order_status = 1 AND o.shipping_status in(0,3,4) AND (pay_status in(1,2) OR is_received_pay=1)";
                break;
            case 'seckill_order':
                $expressid = $GLOBALS['db']->getCol("SELECT order_id FROM ecs_order_extend where trans_type=6");
                if(!empty($expressid))
                {
                    $expressidsql = implode(',', $expressid);
                    $where .= "AND o.order_id in ($expressidsql)";    
                }
                break;
            case 'groupbuy_order':
                $groupbuyid = $GLOBALS['db']->getCol('SELECT order_id FROM ecs_order_goods WHERE goods_type=10');
                if(!empty($groupbuyid))
                {
                    $groupbuysql = implode(',', $groupbuyid);
                    $where .= "AND o.order_id in ($groupbuysql)";    
                }
                break;
            case CS_NORMAL_AWAIT_SHIP:
                $where .= order_query_sql('normal_await_ship');
                break;

            case "express_order":
                $expressid = $GLOBALS['db']->getCol("SELECT order_id FROM ecs_order_extend where trans_type=2");
                if(!empty($expressid))
                {
                    $expressidsql = implode(',', $expressid);
                    $where .= "AND o.order_id in ($expressidsql)";    
                }
                break;
            case "expr_special_order":
            	$expressid = $GLOBALS['db']->getCol("SELECT order_id FROM ecs_order_extend where trans_type=4");
            	if(!empty($expressid))
            	{
            		$expressidsql = implode(',', $expressid);
            		$where .= "AND o.order_id in ($expressidsql)";
            	}
            	break;
            default:
                if ($filter['composite_status'] != -1 && $filter['composite_status'] != -2) {
                    $where .= " AND o.order_status = '$filter[composite_status]' ";
                }
        }
        // 如果收货人和订单号，都为空，则不显示信用记录订单 tatezhou 2010.10.28
        if (!$filter['order_sn'] && !$filter['consignee'] && $filter['composite_status'] == -1 && empty($filter['order_type'])) {
            if($_REQUEST['delivery_party'])
				$where .= " AND o.order_type IN ('normal', 'patch_order')";
			else
				$where .= " AND o.order_type = 'normal'";
        }

        /* 团购订单 */
        if ($filter['group_buy_id']) {
            $where .= " AND o.extension_code = 'group_buy' AND o.extension_id = '$filter[group_buy_id]' ";
        }
        /* 如果管理员属于某个办事处，只列出这个办事处管辖的订单 */
        $sql = "SELECT agency_id FROM " . $GLOBALS['ecs']->table('admin_user') . " WHERE user_id = '$_SESSION[admin_id]'";
        $agency_id = $db_select->getOne($sql);
        if ($agency_id > 0) {
            $where .= " AND o.agency_id = '$agency_id' ";
        }

        /* 分页大小 */
        $filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

        if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0) {
            $filter['page_size'] = intval($_REQUEST['page_size']);
        } elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0) {
            $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
        } else {
            $filter['page_size'] = 15;
        }
        if ($filter['profit_max'] > 0 && $filter['profit_max'] > $filter['profit_min']) {
            $profit_min = $filter['profit_min'] / 100;
            $profit_max = $filter['profit_max'] / 100;
            //判断利润
            /* 记录总数 */
            if ($filter['user_name']) {
                $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " AS o " .
                        " LEFT JOIN (select order_id,sum(IF (factory_price <= 5 OR ISNULL(factory_price), goods_price/1.3, factory_price) * goods_number ) as pro from `ecs_order_goods` GROUP BY order_id) AS og ON o.order_id=og.order_id ," .
                        $GLOBALS['ecs']->table('users') . " AS u ".$table_plus . $where . " AND (o.goods_amount-o.discount-og.pro)/og.pro>={$profit_min} AND (o.goods_amount-o.discount-og.pro)/og.pro<{$profit_max}";
            } else {
                $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " AS o " .
                        " LEFT JOIN (select order_id,sum(IF (factory_price <= 5 OR ISNULL(factory_price), goods_price/1.3, factory_price) * goods_number ) as pro from `ecs_order_goods` GROUP BY order_id) AS og ON o.order_id=og.order_id ".$table_plus .
                        $where . "  AND (o.goods_amount-o.discount-og.pro)/og.pro>={$profit_min} AND (o.goods_amount-o.discount-og.pro)/og.pro<{$profit_max}";
            }
            $filter['record_count'] = $cache->getMem('admin_order_' . md5($sql));
            if (!$filter['record_count']) {
                $filter['record_count'] = $GLOBALS['db']->getOne($sql);
                $cache->setMem('admin_order_' . md5($sql), $filter['record_count'], TRUE, 300);
            }
            $filter['page_count'] = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

            /* 查询 */
            $sql = "SELECT {$pre_ship_time},o.send_sms,o.order_id, o.order_sn,o.admin_id, o.pre_ship_status, o.is_received_pay, o.financial_got_pay, o.add_time,o.already_pay, o.order_status, o.shipping_status, o.order_amount, o.money_paid,o.trade_no,o.buyer_id,o.buyer_email,  o.audit_amount,o.cost_amount,o.audit_status ,  " .
                    "o.pay_status, o.consignee,o.ship_all, o.address, o.email, o.tel, o.extension_code, o.order_type, o.is_dealer_order, o.extension_id, " .
                    "(" . order_amount_field('o.') . " - o.discount) AS total_fee, o.wangwang ,  o.assign_status , o.ship_merch , o.ship_merch_name ,  " .
                    "IFNULL(u.user_name, '" . $GLOBALS['_LANG']['anonymous'] . "') AS buyer " .
                    " FROM " . $GLOBALS['ecs']->table('order_info') . " AS o " .
                    " LEFT JOIN(select order_id,sum(IF (factory_price <= 5 OR ISNULL(factory_price), goods_price/1.3, factory_price) * goods_number ) as pro from `ecs_order_goods` GROUP BY order_id) AS og ON o.order_id=og.order_id" .
                    " LEFT JOIN " . $GLOBALS['ecs']->table('users') . " AS u ON u.user_id=o.user_id ".$table_plus . $where . "  AND (o.goods_amount-o.discount-og.pro)/og.pro>={$profit_min} AND (o.goods_amount-o.discount-og.pro)/og.pro<{$profit_max}" .
                    " ORDER BY $filter[sort_by] $filter[sort_order] {$sort_by_ext}" .
                    " LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ",$filter[page_size]";
        } else {
            /* 记录总数 */
            if ($filter['user_name']) {
                if (empty($admin_id)) {
                    $sql = "SELECT COUNT(o.order_id) as num,sum(if(order_type = 'expr_order',1,0)) as expr_order_count,sum(if(order_type = 'expr_order',goods_amount,0)) as expr_goods_amount,sum(goods_amount) as _total,sum(bonus) as _bonus,sum(discount) as _discount,sum(already_pay+bonus) as _already FROM " . $GLOBALS['ecs']->table('order_info') . " AS o ," .
                            $GLOBALS['ecs']->table('users') . " AS u ".$table_plus . $where;
                } else {
                    $sql = "SELECT COUNT(o.order_id) as num,sum(if(order_type = 'expr_order',1,0)) as expr_order_count,sum(if(order_type = 'expr_order',goods_amount,0)) as expr_goods_amount,sum(goods_amount*(1/(char_length(admin_id)-char_length( replace(admin_id, '|', '') ) - (char_length('{$admin_id}')-char_length( replace('{$admin_id}', '|', '') )) + 1))) as _total,sum(discount*(1/(char_length(admin_id)-char_length( replace(admin_id, '|', '') ) - (char_length('{$admin_id}')-char_length( replace('{$admin_id}', '|', '') )) + 1))) as _discount,sum(bonus) as _bonus,sum(already_pay+bonus) as _already FROM " . $GLOBALS['ecs']->table('order_info') . " AS o ," .
                            $GLOBALS['ecs']->table('users') . " AS u ".$table_plus . $where;
                }
            } else {
                if (empty($admin_id)) {
                    $sql = "SELECT COUNT(o.order_id) as num,sum(bonus) as _bonus,sum(if(order_type = 'expr_order',1,0)) as expr_order_count,sum(if(order_type = 'expr_order',goods_amount,0)) as expr_goods_amount,sum(goods_amount) as _total,sum(discount) as _discount,sum(already_pay+bonus) as _already FROM " . $GLOBALS['ecs']->table('order_info') . " AS o ".$table_plus . $where;
                    $sql_invaild = "SELECT COUNT(t.order_id) as num FROM " . $GLOBALS['ecs']->table('order_info') . " AS o JOIN tmp_invalid_order t on t.order_id = o.order_id ".$table_plus . $where;
                    $invaild_num = $GLOBALS['db']->getOne($sql_invaild);
                } else {
                    $sql = "SELECT COUNT(o.order_id) as num,sum(bonus) as _bonus,sum(if(order_type = 'expr_order',1,0)) as expr_order_count,sum(if(order_type = 'expr_order',goods_amount,0)) as expr_goods_amount,sum(goods_amount*(1/(char_length(admin_id)-char_length( replace(admin_id, '|', '') ) - (char_length('{$admin_id}')-char_length( replace('{$admin_id}', '|', '') )) + 1))) as _total,sum(discount*(1/(char_length(admin_id)-char_length( replace(admin_id, '|', '') ) - (char_length('{$admin_id}')-char_length( replace('{$admin_id}', '|', '') )) + 1))) as _discount,sum(already_pay+bonus) as _already" .
                            " FROM " . $GLOBALS['ecs']->table('order_info') . " AS o ".$table_plus . $where;
                }
            }
            $mem_key = 'order_' . md5($sql);
            $_row = $cache->getMem($mem_key);
            if (!$_row) {
                $_row = $GLOBALS['db']->getRow($sql);
                $cache->setMem($mem_key, $_row, FALSE, 300);
            }
            if ($_REQUEST['export']) {
                if ($_row['num'] > 2000)
                    die("导出数据大于2000 请重新筛选条件");
            }

            $filter['record_count'] = $_row['num'];
            $filter['_total'] = number_format($_row['_total'], 2, '.', '');
            $filter['_expr_goods_amount'] = number_format($_row['expr_goods_amount'], 2, '.', '');
            $filter['_expr_order_count'] = $_row['expr_order_count'];
            $filter['_discount'] = number_format($_row['_discount'], 2, '.', '');
            $filter['_goodsamount'] = number_format($_row['_total'] - $_row['_discount'], 2, '.', '');
            $filter['_already'] = $_row['_already'];
            $filter['page_count'] = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

            /* 查询 */
            if ($_REQUEST['export']) {
                $sql = "SELECT {$pre_ship_time},o.send_sms,o.order_id, o.order_sn,o.admin_id,  o.pre_ship_status, o.is_received_pay, o.financial_got_pay, o.add_time,o.already_pay, o.order_status, o.shipping_status, o.order_amount, o.money_paid,o.trade_no,o.buyer_id,o.buyer_email,  o.audit_amount,o.cost_amount,o.audit_status ,  " .
                        "o.pay_status, o.consignee, o.ship_all, o.address, o.email, o.tel, o.extension_code, o.order_type, o.is_dealer_order, o.extension_id, " .
                        "(" . order_amount_field('o.') . " - o.discount) AS total_fee, o.wangwang ,  o.assign_status , o.ship_merch , o.ship_merch_name ,  " .
                        "u.user_name AS buyer " .
                        " FROM " . $GLOBALS['ecs']->table('order_info') . " AS o " .
                        " LEFT JOIN " . $GLOBALS['ecs']->table('users') . " AS u ON u.user_id=o.user_id ".$table_plus . $where .
                        " ORDER BY $filter[sort_by] $filter[sort_order] {$sort_by_ext}";
            } else {
                $sql = "SELECT {$pre_ship_time},o.send_sms,o.order_id, o.order_sn,o.admin_id,  o.pre_ship_status, o.is_received_pay, o.financial_got_pay, o.add_time,o.already_pay, o.order_status, o.shipping_status, o.order_amount, o.money_paid,o.trade_no,o.buyer_id,o.buyer_email,  o.audit_amount,o.cost_amount,o.audit_status ,  " .
                        "o.pay_status, o.consignee, o.ship_all, o.address, o.email, o.tel, o.extension_code, o.order_type, o.is_dealer_order, o.extension_id, " .
                        "(" . order_amount_field('o.') . " - o.discount) AS total_fee, o.wangwang ,  o.assign_status , o.ship_merch , o.ship_merch_name ,  " .
                        "u.user_name AS buyer " .
                        " FROM " . $GLOBALS['ecs']->table('order_info') . " AS o " .
                        " LEFT JOIN " . $GLOBALS['ecs']->table('users') . " AS u ON u.user_id=o.user_id ".$table_plus . $where .
                        " ORDER BY $filter[sort_by] $filter[sort_order] {$sort_by_ext}" .
                        " LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ",$filter[page_size]";
            }
        }
        foreach (array('order_sn', 'consignee', 'email', 'address', 'zipcode', 'tel', 'user_name') AS $val) {
            $filter[$val] = stripslashes($filter[$val]);
        }

        set_filter($filter, $sql);
    } else {
        $sql = $result['sql'];
        $filter = $result['filter'];
    }
    if (!$sql) {
        header("Location:/admin/order.php?act=list");
        exit;
    }
    //$row = $cache->getMem('admin_order_list'.md5($sql));
    //if(!$row)
    //{
    $row = $db_select->getAll($sql);
    //	$cache->setMem('admin_order_list'.md5($sql),$row,0,60);
    //}
    /* 格式话数据 */
    foreach ($row AS $key => $value) {
        $row[$key]['formated_audit_amount'] = price_format($value['audit_amount']);
        $row[$key]['formated_cost_amount'] = price_format($value['cost_amount']);
        $row[$key]['admin_id'] = $value['admin_id'];
        $row[$key]['formated_order_amount'] = price_format($value['order_amount']);
        $row[$key]['formated_money_paid'] = price_format($value['money_paid']);
        $row[$key]['formated_total_fee'] = price_format($value['total_fee']);
        $row[$key]['short_order_time'] = date('m-d H:i', $value['add_time']);
        if (2000000000 == $row[$key]['pre_ship_time'])
            $row[$key]['pre_ship_time'] = '';
        else
            $row[$key]['pre_ship_time'] = $value['pre_ship_time'] ? date('Y-m-d', $value['pre_ship_time']) : '';
        if ($row['pay_status'] == PS_PAYED)
            $row[$key]['already_pay'] = $value['goods_mount'];
        else
            $row[$key]['already_pay'] = $value['already_pay'];
        if ($value['order_status'] == OS_INVALID || $value['order_status'] == OS_CANCELED) {
            /* 如果该订单为无效或取消则显示删除链接 */
            $row[$key]['can_remove'] = 1;
        } else {
            $row[$key]['can_remove'] = 0;
        }
    }
    if ($_REQUEST['export']) {
        include('includes/cls.excelwriter.php');
        $title[] = array('订单编号', '货到付款', '下单时间', '总金额', '已付款',
            '已结算', '订单状态', "支付状态", "发货状态", "是否发货", '订单类型', '订单预计发货时间');
        $pre_ship_status = array('unsure' => "待确定", 'ship_need' => "有余款，需备货", 'hurry' => "尽快发货");
        $result = array();
        global $_LANG;
        foreach ($row as $k => $v) {
            $result[$k]['order_sn'] = $v['order_sn'];
            $result[$k]['is_received_pay'] = $v['is_received_pay'] == 0 ? "否" : "是";
            $result[$k]['add_time'] = date("Y-m-d H:i", $v['add_time']);
            $result[$k]['formated_total_fee'] = $v['formated_total_fee'];
            $result[$k]['already_pay'] = $v['already_pay'];
            $result[$k]['financial_got_pay'] = $v['financial_got_pay'];
            $result[$k]['order_status'] = $_LANG['os'][$v['order_status']];
            $result[$k]['pay_status'] = $_LANG['ps'][$v['pay_status']];
            $result[$k]['shipping_status'] = $_LANG['ss'][$v['shipping_status']];
            $result[$k]['pre_ship_status'] = $pre_ship_status[$v['pre_ship_status']];
            $result[$k]['order_type'] = $_LANG['ot'][$v['order_type']];
            $result[$k]['pre_ship_time'] = $v['pre_ship_time'];
        }
        $all = array_merge($title, $result);
        $xls = new ExcelWriter('utf-8', 'order_export');
        $xls->add_array($all);
        $xls->output();
        exit();
    }
    if ($invaild_num)
        $filter['invaild_num'] = $invaild_num;
    $arr = array('orders' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
    //echo $sql,"<hr>";
    return $arr;
}

/**
 * 更新订单对应的 pay_log
 * 如果未支付，修改支付金额；否则，生成新的支付log
 * @param   int     $order_id   订单id
 */
function update_pay_log($order_id) {
    $order_id = intval($order_id);
    if ($order_id > 0) {
        $sql = "SELECT order_amount FROM " . $GLOBALS['ecs']->table('order_info') .
                " WHERE order_id = '$order_id'";
        $order_amount = $GLOBALS['db']->getOne($sql);
        if (!is_null($order_amount)) {
            $sql = "SELECT log_id FROM " . $GLOBALS['ecs']->table('pay_log') .
                    " WHERE order_id = '$order_id'" .
                    " AND order_type = '" . PAY_ORDER . "'" .
                    " AND is_paid = 0";
            $log_id = intval($GLOBALS['db']->getOne($sql));
            if ($log_id > 0) {
                /* 未付款，更新支付金额 */
                $sql = "UPDATE " . $GLOBALS['ecs']->table('pay_log') .
                        " SET order_amount = '$order_amount' " .
                        "WHERE log_id = '$log_id' LIMIT 1";
            } else {
                /* 已付款，生成新的pay_log */
                $sql = "INSERT INTO " . $GLOBALS['ecs']->table('pay_log') .
                        " (order_id, order_amount, order_type, is_paid)" .
                        "VALUES('$order_id', '$order_amount', '" . PAY_ORDER . "', 0)";
            }
            $GLOBALS['db']->query($sql);
        }
    }
}

/**
 * 取得某订单应该赠送的积分数
 * @param   array   $order  订单
 * @return  int     积分数
 */
function integral_to_give($order) {
    /* 判断是否团购 */
    if ($order['extension_code'] == 'group_buy') {
        include_once(ROOT_PATH . 'includes/lib_goods.php');
        $group_buy = group_buy_info(intval($order['extension_id']));

        return $group_buy['gift_integral'];
    } else {
        $sql = "SELECT SUM(og.goods_number * g.give_integral)" .
                "FROM " . $GLOBALS['ecs']->table('order_goods') . " AS og, " .
                $GLOBALS['ecs']->table('goods') . " AS g " .
                "WHERE og.goods_id = g.goods_id " .
                "AND og.order_id = '$order[order_id]' " .
                "AND og.goods_id > 0 " .
                "AND og.parent_id = 0 " .
                "AND og.is_gift = 0";

        return intval($GLOBALS['db']->getOne($sql));
    }
}

function update_stock_or_debit() {


    /*  更新库存，对于没有请款或是请款未到货的情况，我们需要出库存。 */

    $ship_sel = $_REQUEST['ship_sel'];

    if ($ship_sel) {
        foreach ($ship_sel AS $item) {

            $item_info = split(",", $item);
            $ship_type = $item_info[0];

            $id = $item_info[1];



            $order_rec_id = $item_info[2];

            $sql = " select goods_number , goods_name,goods_sn from " . $GLOBALS['ecs']->table('order_goods') .
                    " where rec_id = " . $order_rec_id . " limit 1";

            $order_item_info2 = $GLOBALS['db']->getAll($sql);
            $order_item_info = $order_item_info2[0];


            if ($ship_type == 'stock') {

                $action_note = "$order[order_sn]    $order[consignee] 出库存";

                $sql = " select note from " . $GLOBALS['ecs']->table('stock_goods_detail') . " where id = $id ";
                $ori_note = $GLOBALS['db']->getOne($sql);

                $action_note = $action_note . "\r\n=============================================\r\n" . $ori_note;

                $sql = " update " . $GLOBALS['ecs']->table('stock_goods_detail') .
                        " set fstatus = 'off'  , note = '$action_note', ship_time =" . time() .
                        " where id = $id ";

                $GLOBALS['db']->query($sql);

                $sql = " select stock_id from " . $GLOBALS['ecs']->table('stock_goods_detail') . " where id = $id  ";
                $stock_id = $GLOBALS['db']->getOne($sql);



                $sql = "update " . $GLOBALS['ecs']->table('stock_goods') .
                        " set number = number - 1  where stock_id = $stock_id";

                $GLOBALS['db']->query($sql);
            } elseif ($ship_type == 'debit') {

                // 更新请款单
                $sql = " update   " . $ecs->table('debit_detail') . " set fstatus = 'shiped'
					         where  id = $id and  fstatus = 'recv' ";

                //echo "$sql";

                $GLOBALS['db']->query($sql);


                // 取得第三方信息。
                $sql = " select rec_id from " . $GLOBALS['ecs']->table("debit_detail") .
                        " where id = $id";

                $third_rec_id = $GLOBALS['db']->getOne($sql);



                $sql = " select goods_number , goods_name,goods_sn ," .
                        " consignee , order_sn , order_status, b.shipping_status AS  shipping_status , pay_status from " .
                        $GLOBALS['ecs']->table('order_goods') . " a  join " .
                        $GLOBALS['ecs']->table('order_info') . " b  on  a.order_id = b.order_id" .
                        " where rec_id = " . $third_rec_id . " limit 1";

                $thrid_reco = $GLOBALS['db']->getAll($sql);

                $third_order_item_info = $thrid_reco[0];


                /* 给本条订单写一个记录，记录挪用了别人的货 */
                $action_note = " 商品 " . $third_order_item_info['goods_sn'] . "   " .
                        $third_order_item_info['goods_name'] . " 挪用了 " .
                        $third_order_item_info['consignee'] . "   " .
                        $third_order_item_info['order_sn'] . " 的货";



                order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], $action_note);


                /*  更新另一张订单 */
                $sql = " update " . $GLOBALS['ecs']->table('order_goods') .
                        " set shipping_status =" . SS_UNSHIPPED .
                        " where rec_id = $third_rec_id and shipping_status = " . SS_PREPARING;

                $GLOBALS['db']->query($sql);

                /* 给被挪用方，也写一条日志 */
                $action_note = " 商品 " . $third_order_item_info['goods_sn'] . "   " .
                        $third_order_item_info['goods_name'] . " 被挪用给了 " .
                        $order['consignee'] . "   " . $order['order_sn'];

                order_action($third_order_item_info['order_sn'], OS_CONFIRMED, $third_order_item_info['shipping_status'], $third_order_item_info['pay_status'], $action_note);
            } else {
                die("unkonw ship type.");
            }
        }
    }
}

/**
 * 为某个订单记录进行商品预留。
 * @info_str   string   format "ship_type,batch_id,order_rec_id"
 * @return  int     积分数
 */
function handle_reserve($info_str) {
    $item_info = split(",", $info_str);
    $ship_type = $item_info[0];
    $batch_id = $item_info[1];
    $order_rec_id = $item_info[2];

    $sql = " select a.rec_id, a.goods_number , a.goods_name,a.goods_sn,a.shipping_status,b.order_sn, b.consignee,b.wangwang ,c.goods_name_ori from " . $GLOBALS['ecs']->table('order_goods') . " a " .
            "join " . $GLOBALS['ecs']->table('order_info') . " b on a.order_id = b.order_id " .
            "left join " . $GLOBALS['ecs']->table('goods') . " c on a.goods_sn = c.goods_sn " .
            " where rec_id = " . $order_rec_id;

    $order_item_info = $GLOBALS['db']->getRow($sql);



    $need_number = $order_item_info['goods_number'];

    if ($order_item_info['shipping_status'] == SS_P_RESERVE) {
        $sql = " select sum(number) from " . $GLOBALS['ecs']->table('reserve_goods') .
                " where frec_id = $order_rec_id and fbill_sn =  '$order_item_info[order_sn]' and fstatus = 'on'";
        $reserved_number = $GLOBALS['db']->getOne($sql);

        $need_number = $need_number - $reserved_number;
    }

    $sql = " select * from " . $GLOBALS['ecs']->table('stock_batch') . " where batch_id = $batch_id";
    $batch_info = $GLOBALS['db']->getRow($sql);

    $reserve_sn = gen_bill_sn("RESV");


    if ($batch_info ['number'] >= $need_number) {
        $resv_number = $need_number;
        $order_detail_status = SS_RESERVE;
    } else {
        $resv_number = $batch_info ['number'];
        $order_detail_status = SS_P_RESERVE;
    }

    $goods_name = $order_item_info['goods_name'];

    if ($order_item_info['goods_name_ori']) {
        $goods_name = $order_item_info['goods_name_ori'];
    }
    // 生成一条保留单记录:  $order_item_info['consignee'] . "[" $order_item_info['wangwang'] . "]"
    $fdesc = $order_item_info['consignee'] . "[" . $order_item_info['wangwang'] . "]";
    $reserve = array(
        'reserve_sn' => $reserve_sn,
        'goods_sn' => $order_item_info['goods_sn'],
        'goods_name' => $goods_name,
        'action_user' => $_SESSION['admin_name'],
        'add_time' => time(),
        'reason' => 'order',
        'fbill_sn' => $order_item_info['order_sn'],
        'frec_id' => $order_item_info['rec_id'],
        'fdesc' => $fdesc,
        'stock_batch_id' => $batch_info['batch_id'],
        'stock_batch_sn' => $batch_info['batch_sn'],
        'number' => $resv_number,
        'fstatus' => 'on');

    $resv_ret = $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('reserve_goods'), $reserve, 'INSERT');


    if ($resv_ret == false)
        return false;

    $action_type = 'dec_resrv';

    $action_note = "订单预留出库." . $order_item_info['order_sn'] .
            "   &nbsp;&nbsp;&nbsp;&nbsp;" . $reserve_sn . "   &nbsp;&nbsp;&nbsp;&nbsp;" . $fdesc;




    // 更改相关的库存信息
    stock_out($batch_info['batch_id'], $batch_info['stock_id'], $resv_number, $action_type, $action_note, $reserve_sn);

    //更改订单明细的状态：



    $sql = " update " . $GLOBALS['ecs']->table('order_goods') . " set shipping_status =  $order_detail_status " .
            " where rec_id = $order_rec_id ";
    $GLOBALS['db']->query($sql);
}

/**
 * 为某个订单记取消商品预留。
 * @order_rec_id   integer
 * @return  void
 */
function cancel_reserve($order_rec_id) {

    $order_rec_id = intval($order_rec_id);
    if ($order_rec_id < 0)
        return;  // 无效的ID号


    $sql = " select * from " . $GLOBALS['ecs']->table('order_goods') . " where rec_id = $order_rec_id";

    $order_item_info = $GLOBALS['db']->getRow($sql);


    if (!$order_item_info)
        return false; // 记录号不存在

    if ($order_item_info['shipping_status'] == SS_RESERVE || $order_item_info['shipping_status'] == SS_P_RESERVE) {
        
    } else {
        return; // 如果记录的状态不是保留或是部分保留，则不处理
    }


    // 记录状态改为“未发货”状态
    $order_detail_status = SS_UNSHIPPED;
    $sql = " update " . $GLOBALS['ecs']->table('order_goods') . " set shipping_status =  $order_detail_status where rec_id = " . $order_rec_id;

    $GLOBALS['db']->query($sql);


    $sql = "select id,reserve_sn,stock_batch_id,number,fbill_sn,fdesc from " . $GLOBALS['ecs']->table('reserve_goods') . " where frec_id = $order_rec_id and fstatus = 'on' and reason = 'order'";
    $reserve_item_info = $GLOBALS['db']->getAll($sql);



    foreach ($reserve_item_info AS $index => $item_info) {


        $sql = " select stock_id from " . $GLOBALS['ecs']->table('stock_batch') . " where batch_id = $item_info[stock_batch_id] ";
        $stock_id = $GLOBALS['db']->getOne($sql);

        if ($item_info['number'] > 0) {
            $sql = " update " . $GLOBALS['ecs']->table('stock_batch') . " set fstatus = 'on' ,
			         number = number +  $item_info[number]  where batch_id = $item_info[stock_batch_id] ";
            $GLOBALS['db']->query($sql);

            $sql = " update " . $GLOBALS['ecs']->table('stock_goods') .
                    " set number = number +  $item_info[number] where stock_id = $stock_id ";
            $GLOBALS['db']->query($sql);
        }

        $action_note = " 订单商品保留取消!" . "<br>" . $item_info['reserve_sn'] . "----" . $item_info['fbill_sn'] . "<br>" . $item_info['fdesc'];
        stock_action_log($item_info['stock_batch_id'], $action_note, 'inc_resrv', $item_info['number'], $item_info['reserve_sn']);
    }

    $sql = " update " . $GLOBALS['ecs']->table('reserve_goods') . " set  fstatus = 'off' where  frec_id = $order_rec_id and reason = 'order' ";
    $GLOBALS['db']->query($sql);
}

function send_shipping_affiche($goods_ids, $order_id, $custom_mode = false) {

    global $db, $smarty;

    if (empty($goods_ids) || empty($order_id))
        return false;

    $recs = db_create_in($goods_ids, "rec_id");
    $goods_ids = $db->getCol("SELECT goods_id FROM ecs_order_goods WHERE $recs");
    $goods_id_string = '0';

    if ($goods_ids) {
        foreach ($goods_ids as $val) {
            $goods_id_string .= "," . $val;
        }
    } else {
        return false;
    }

    $goods_id_string = trim($goods_id_string, ",");
    // var_dump($goods_id_string);

    if (!$custom_mode)
        $template = get_mail_template('shipping_affiche');
    else
        $template = get_mail_template('shipping_affiche_for_custom');

    $sql = "SELECT u.user_id,u.user_name, o.consignee, o.shipping_email, u.email as custom_email FROM
						ecs_order_info o,ecs_users u 
						WHERE o.user_id=u.user_id AND o.order_id='$order_id'";

    $order = $db->getRow($sql);
    if (strpos($order['user_name'], 'meilele') !== false) {
        return false;
    }

    if (empty($order)) {
        // var_dump($sql);
        // die(debugger);
        return false;
    }

    $sql = "SELECT goods_id, goods_sn,goods_name FROM ecs_goods WHERE goods_id IN (" . $goods_id_string . ")";
    $goods = $db->getAll($sql);

    if (empty($goods)) {
        // var_dump($sql);
        // die(debugger);
        return false;
    }

    foreach ($goods as $key => $val) {
        $goods[$key]['url'] = "http://www.meilele.com" . build_uri("goods", array("gid" => $val['goods_id']));
    }

    $admin_email = $order['shipping_email'];
    $admin_name = substr($admin_email, 0, strpos($admin_email, '@'));
    $user_id = $order['user_id'];

    $smarty->assign('admin_name', $admin_name);
    // 客户注册名
    $smarty->assign('client_uid', $order['user_name']);
    // 客户收货人名称
    $smarty->assign('client_name', $order['consignee']);
    // 客户资料
    $smarty->assign('client_url', "http://help.meilele.com/admin/users.php?act=edit&id=$user_id");
    // 订单详情
    $smarty->assign('order_url', "http://help.meilele.com/admin/order.php?act=info&order_id=$order_id");
    // 本次发货的商品
    $smarty->assign('goods', $goods);
    // 发送时间
    $smarty->assign('send_date', date($_CFG['date_format']));

    $content = $smarty->fetch('str:' . $template['template_content']);
    $subject = $smarty->fetch('str:' . $template['template_subject']);

    $mail_address = !$custom_mode ? $admin_email : $order['custom_email'];
    if (!empty($mail_address))
        return send_mail($admin_name, $mail_address, $subject, $content, $template['is_html']) ? true : false;
    return true;
}

//二维数组按指定键值排序
function array_sortbykey($arr, $keys, $type = 'asc') {
    $keysvalue = $new_array = array();
    foreach ($arr as $k => $v) {
        $keysvalue[$k] = $v[$keys];
    }
    if ($type == 'asc') {
        asort($keysvalue);
    } else {
        arsort($keysvalue);
    }
    reset($keysvalue);
    foreach ($keysvalue as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}

//修改了订单商品的价格后。
function setOrderPayStatus($order_id = '') {
    global $db;
    if (!empty($order_id)) {
        $sql = "SELECT pay_status,goods_amount,bonus,already_pay,shipping_status,order_status FROM ecs_order_info WHERE order_id  = " . $order_id;
        $row = $db->getRow($sql);
        if ($row['pay_status'] == PS_PAYED) { //对于部分付款和未付款的，不做任何处理。
            if ($row['already_pay'] + $row['bonus'] < $row['goods_amount']) {  //已经支付的小于订单金额，设为付款中
                $db->query("UPDATE ecs_order_info SET pay_status = " . PS_PAYING . " WHERE order_id = $order_id");
                //插入日志
                $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','管理员修改了订单产品信息，系统自动更新订单状态为部分付款','" . time() . "')";
                $db->query($sql);
            }
        } else if ($row['pay_status'] == PS_PAYING) {   //部分付款的
            if ($row['already_pay'] + $row['bonus'] >= $row['goods_amount']) {  //已经支付的大于订单金额，设为付款
                $db->query("UPDATE ecs_order_info SET pay_status = " . PS_PAYED . " WHERE order_id = $order_id");
                //插入日志
                $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','管理员修改了订单产品信息，系统自动更新订单状态为已付款','" . time() . "')";
                $db->query($sql);
            }
        }
    }
}

//删除订单商品操作,如果为部分付款，且付款金额大于订单金额，修改订单状态为已付款状态
function delOrderGoods($rec_id = '') {
    global $db;
    if (!empty($rec_id)) {
        $order_id = $db->getOne("SELECT order_id FROM ecs_order_goods WHERE rec_id = $rec_id");
        $row = $db->getRow("SELECT * FROM ecs_order_info WHERE order_id = " . $order_id);
        $already_pay = getOrderAlreadyPay($order_id);
        //插入日志
        $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES('" . $row['order_id'] . "','" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','管理员删除了商品" . $row['goods_sn'] . "','" . time() . "')";
        $db->query($sql);
        if ($row['pay_status'] == PS_PAYING && $row['bonus'] + $row['already_pay'] >= $row['goods_amount'] - $row['goods_price']) { //部分支付，则看支付金额是否已经大于订单金额
            $db->query("UPDATE ecs_order_info SET pay_status = " . PS_PAYED . " WHERE order_id = " . $row['order_id']);
            $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES('" . $row['order_id'] . "','" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . PS_PAYED . "','" . time() . "','管理员删除了商品,已付金额大于订单金额，系统自动将其设为付款状态为已付款','" . time() . "')";
            $db->query($sql);
        }
    }
}

//取消订单商品,对于部分付款订单，如果订单金额小于已经付款的金额，则修改订单状态为已付款
function cancelOrderGoods($order_id = '') {
    global $db;
    if (!empty($order_id)) {
        $sql = "SELECT pay_status,goods_amount,bonus,already_pay,shipping_status,order_status FROM ecs_order_info WHERE order_id  = " . $order_id;
        $row = $db->getRow($sql);
        if ($row['pay_status'] == PS_PAYING) { //如果为部分支付，则判断已经支付的是否大于订单金额
            if ($row['already_pay'] + $row['bonus'] >= $row['goods_amount']) {  //已经支付的大于订单金额，设为付款
                $db->query("UPDATE ecs_order_info SET pay_status = " . PS_PAYED . " WHERE order_id = $order_id");
                //插入日志
                $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','管理员取消了订单产品，系统自动更新订单状态为已付款','" . time() . "')";
                $db->query($sql);
            }
        }
    }
}

//新加商品到订单，修改已付款订单为部分付款
function addGoodsToOrder($order_id, $goods_id) {
    global $db;
    if (!empty($order_id) && !empty($goods_id)) {
        $sql = "SELECT pay_status,goods_amount,bonus,already_pay,shipping_status,order_status FROM ecs_order_info WHERE order_id  = " . $order_id;
        $row = $db->getRow($sql);

        $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','管理员新加了订单产品$goods_id','" . time() . "')";
        $db->query($sql);
        if ($row['pay_status'] == PS_PAYED) { //如果为已经支付，则修改为部分支付
            if ($row['already_pay'] + $row['bonus'] < $row['goods_amount']) {  //已经支付的小于订单金额，设为部分支付
                $db->query("UPDATE ecs_order_info SET pay_status = " . PS_PAYING . " WHERE order_id = $order_id");
                //插入日志
                $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','管理员新加了订单产品，系统自动更新订单状态为部分付款','" . time() . "')";
                $db->query($sql);
            }
        }
    }
}

function new_audit_withdraw($order_id, $already_pay, $way, $notes, $trade_no = '') {
    global $db;

    if (empty($order_id))
        return;

    $time = time();
    $admin_name = $_SESSION['admin_name'];

    if ($way == '现金') {
        $is_posted = 0;
        /*
          生成订单交易号
         */
        while (true) {
            $trade_no = 'mll' . date('Ymd', time()) . rand(10000, 99999);
            //判断此交易号是否已经存在
            $exist_trade_no = $db->getOne("SELECT `trade_no` FROM `ecs_audit_withdraw` WHERE trade_no = '$trade_no'");
            if ($exist_trade_no) {
                continue;
            }//存在则重新生成
            else {
                break;
            }                         //不存在则跳出循环-正常情况下一般都会走这里
        }
    } else {
        $is_posted = 1;
    }
    $sql = "INSERT INTO ecs_audit_withdraw(audit_id,order_id,request_name,audit_money,way,trade_no,audit_name,create_time,audit_time,audit_status,is_posted,notes,file_name) VALUES(NULL, $order_id, '$admin_name', $already_pay, '$way','$trade_no', '', $time, 0, 'un_audit', $is_posted, '$notes','')";
    $db->query($sql);
    return $db->insert_id();
}

function order_audit_list($order_id) {
    global $db;

    if (empty($order_id))
        return;

    $sql = "SELECT * FROM ecs_audit_withdraw WHERE order_id=$order_id ORDER BY create_time ASC";
    $audit_list = $db->getAll($sql);

    foreach ($audit_list as $key => $value) {
        $audit_list[$key]['create_time'] = date("Y-m-d H:i:s", $value['create_time']);
        if (!empty($value['audit_time']))
            $audit_list[$key]['audit_time'] = date("Y-m-d H:i:s", $value['audit_time']);
        else
            $audit_list[$key]['audit_time'] = '-';

        if (empty($value['audit_name']))
            $audit_list[$key]['audit_name'] = '-';

        if ($value['audit_status'] == 'un_audit')
            $audit_list[$key]['audit_status'] = '等待审核';
        else if ($value['audit_status'] == 'audit_ok')
            $audit_list[$key]['audit_status'] = '审核通过';
        else if ($value['audit_status'] == 'audit_bad')
            $audit_list[$key]['audit_status'] = '审核失败';
        else if ($value['audit_status'] == 'auto_audit')
            $audit_list[$key]['audit_status'] = '<font color="#369">[程序自动审核]</font>';
    }

    return $audit_list;
}

/*
 *
 * 发送单条短信
 * Author:zzd Data:2011.7.12
 */

function send_user_sms($order_sn, $tpl, $shipping_info = array()) {
    global $_CFG;
    $sql = "SELECT expr_id,order_sn,tel,mobile,u.* FROM " . $GLOBALS['ecs']->table('order_info') . "AS oi LEFT JOIN " . $GLOBALS['ecs']->table('users') . " AS u ON oi.user_id=u.user_id WHERE `order_sn`='$order_sn' OR `order_id`='$order_sn'";
    $info = $GLOBALS['db']->getRow($sql);
    if (!is_array($info) || strlen($info['order_sn']) != 13) {
        return false;
    }

    $mobile = $info['mobile'];
    if (!preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/", $mobile)) {
        $mobile = $info['tel'];
        if (!preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/", $mobile)) {
            return false;
        }
    }
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('sms_templates') . " WHERE `template_code` = '$tpl' AND `type`='template'";
    $template = $GLOBALS['db']->getRow($sql);
    if (!is_array($template)) {
        return false;
    }
    if ($info['expr_id'] > 0) {
        $sql = "SELECT expr_name from `ecs_expr_nature` WHERE expr_id='{$info['expr_id']}'";
        $expr_name = $GLOBALS['db']->getOne($sql);
        $GLOBALS['smarty']->assign('expr_name', $expr_name);
    }
    $GLOBALS['smarty']->assign($shipping_info);
    $GLOBALS['smarty']->assign(array('user_name' => $info['user_name'], 'order_sn' => $info['order_sn']));
    $content = $GLOBALS['smarty']->fetch("str:$template[template_content]");
    include_once(ROOT_PATH . 'includes/HttpClient.class.php');

    $params = array
        (
        'Sn' => $_CFG['sdk_user_name'],
        'Pwd' => $_CFG['sdk_user_pwd'],
        'Mobile' => $mobile,
        'content' => $content . '[美乐乐家具网]'
    ); //发送短信
    $_params = array();
    foreach ($params as $k => $v) {
        $_params[$k] = ecs_iconv('UTF-8', 'GB2312', $v);
    }
    $pageContents = HttpClient::quickPost($_CFG['sdk_url'], $_params);
}

/**
 *  新未发货订单列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function order_delivery_list() {
    $result = get_filter();
    if ($result === false) {
        /* 过滤信息 */
        $filter['delivery'] = 1;
        $filter['composite_status'] = isset($_REQUEST['composite_status']) ? $_REQUEST['composite_status'] : -1;

        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'add_time' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = "WHERE 1 AND o.order_type != 'inside_trade' AND o.shipping_status in(0,4)";

        $where .= "AND o.order_status = 1 AND o.pay_status >0 AND o.order_id not in(SELECT DISTINCT order_id FROM ecs_stock_invoice_info WHERE fstatus='new' OR fstatus='printed')";


        /* 分页大小 */
        $filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

        if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0) {
            $filter['page_size'] = intval($_REQUEST['page_size']);
        } elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0) {
            $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
        } else {
            $filter['page_size'] = 15;
        }
        /* 记录总数 */
        $sql = "SELECT COUNT(distinct o.order_id) FROM " . $GLOBALS['ecs']->table('order_info') . " AS o " .
                "LEFT JOIN ecs_users AS u ON  u.user_id=o.user_id JOIN ecs_order_goods as eog on o.order_id=eog.order_id " . $where;
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);
        $filter['page_count'] = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* 查询 */
        $sql = "SELECT o.send_sms,o.order_id, o.order_sn, o.pre_ship_status, o.is_received_pay, o.financial_got_pay, o.add_time,o.already_pay, o.order_status, o.shipping_status, o.order_amount, o.money_paid,o.trade_no,o.buyer_id,o.buyer_email,  o.audit_amount,o.cost_amount,o.audit_status ,  " .
                "o.pay_status, o.consignee, o.address, o.email, o.tel, o.extension_code, o.order_type, o.is_dealer_order, o.extension_id, " .
                "(" . order_amount_field('o.') . " - o.discount) AS total_fee, o.wangwang ,  o.assign_status , o.ship_merch , o.ship_merch_name , o.prepare_shipping_time, " .
                "IFNULL(u.user_name, '" . $GLOBALS['_LANG']['anonymous'] . "') AS buyer " .
                " FROM " . $GLOBALS['ecs']->table('order_info') . " AS o " .
                " LEFT JOIN " . $GLOBALS['ecs']->table('users') . " AS u ON u.user_id=o.user_id " . $where .
                " ORDER BY $filter[sort_by] $filter[sort_order] " .
                " LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ",$filter[page_size]";

        foreach (array('order_sn', 'consignee', 'email', 'address', 'zipcode', 'tel', 'user_name') AS $val) {
            $filter[$val] = stripslashes($filter[$val]);
        }
        set_filter($filter, $sql);
    } else {
        $sql = $result['sql'];
        $filter = $result['filter'];
    }
    $row = $GLOBALS['db']->getAll($sql);

    /* 格式话数据 */
    foreach ($row AS $key => $value) {
        if ($value['prepare_shipping_time'] == '0000-00-00 00:00:00')
            $row[$key]['prepare_shipping_time'] = '';
        else
            $row[$key]['prepare_shipping_time'] = date('Y-m-d', strtotime($value['prepare_shipping_time']));
        if ($row[$key]['shipping_time'])
            $row[$key]['shipping_time'] = date('Y-m-d H:i:s', $row[$key]['shipping_time']);

        $row[$key]['formated_audit_amount'] = price_format($value['audit_amount']);
        $row[$key]['formated_cost_amount'] = price_format($value['cost_amount']);

        $row[$key]['formated_order_amount'] = price_format($value['order_amount']);
        $row[$key]['formated_money_paid'] = price_format($value['money_paid']);
        $row[$key]['formated_total_fee'] = price_format($value['total_fee']);
        $row[$key]['short_order_time'] = date('m-d H:i', $value['add_time']);
        if ($row['pay_status'] == PS_PAYED)
            $row[$key]['already_pay'] = $value['goods_mount'];
        else
            $row[$key]['already_pay'] = $value['already_pay'];
        if ($value['order_status'] == OS_INVALID || $value['order_status'] == OS_CANCELED) {
            /* 如果该订单为无效或取消则显示删除链接 */
            $row[$key]['can_remove'] = 1;
        } else {
            $row[$key]['can_remove'] = 0;
        }

        // 缺货信息
        $sql = 'SELECT og.goods_id, og.goods_number, og.goods_sn, IFNULL(sg.number, 0) AS goods_stock
                FROM ' . $GLOBALS['ecs']->table('order_goods') . ' og 
                LEFT JOIN ' . $GLOBALS['ecs']->table('stock_goods') . ' sg ON og.goods_sn=sg.goods_sn 
                WHERE og.order_id=' . $value['order_id'];
        $goods = $GLOBALS['db']->getAll($sql);
        $row[$key]['out_of_stock'] = '';
        if ($value['pre_ship_status'] != 'unsure' && $value['pre_ship_status'] != 'ship_need') {
            $out_of_stock_flag = 0; // 缺多少件货品
            $is_full = 0; // 是否完全缺货
            foreach ($goods as $k => $v) {
                if ($row[$key]['out_of_stock'] != '')
                    $row[$key]['out_of_stock'] .= '， ';

                if ($v['goods_stock'] >= $v['goods_number']) {
                    // 不缺货
                    $row[$key]['out_of_stock'] .= '<span style="color:green">' . $v['goods_sn'] . '库存' . $v['goods_stock'] . '件</span>';
                } elseif ($v['goods_stock'] == 0) {
                    // 缺货
                    $out_of_stock_flag -= $v['goods_number'] - $v['goods_stock'];
                    $row[$key]['out_of_stock'] .= '<span style="color:#ff0000">' . $v['goods_sn'] . '缺货' . ($v['goods_number'] - $v['goods_stock']) . '件</span>';
                    $is_full = 1;
                } else {
                    // 部分缺货
                    $out_of_stock_flag -= $v['goods_number'] - $v['goods_stock'];
                    $row[$key]['out_of_stock'] .= '<span style="color:#aa00aa">' . $v['goods_sn'] . '部分缺货' . ($v['goods_number'] - $v['goods_stock']) . '件(' . $v['goods_stock'] . ':' . $v['goods_number'] . ')</span>';
                }
            }
            if ($out_of_stock_flag < 0) {
                if ($is_full == 0) {
                    // 部分缺货
                    $row[$key]['out_of_stock'] = '<span style="color:#aa00aa">部分缺货' . (0 - $out_of_stock_flag) . '件</span>。' . $row[$key]['out_of_stock'];
                    $row[$key]['is_out_of_stock'] = '<span style="color:#aa00aa">部分缺货</span>';
                } else {
                    // 缺货
                    $row[$key]['out_of_stock'] = '<span style="color:#ff0000">缺货' . (0 - $out_of_stock_flag) . '件</span>。' . $row[$key]['out_of_stock'];
                    $row[$key]['is_out_of_stock'] = '<span style="color:#ff0000">缺货</span>';
                }
            } else {
                // 不缺货
                $row[$key]['out_of_stock'] = '<span style="color:green">不缺货。</span>' . $row[$key]['out_of_stock'];
                $row[$key]['is_out_of_stock'] = '不缺货';
            }
        }
    }
    $arr = array('orders' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

function backup_del_order($order_id) {
    $sql = "SELECT * FROM `ecs_order_info` WHERE order_id = '$order_id'";
    $order_info = $GLOBALS['db']->getRow($sql);
    $order_info['del_admin_id'] = $_SESSION['admin_id'];
    $order_info['del_time'] = time();
    if (is_array($order_info)) {
        $sql = "SELECT * FROM `ecs_order_goods` WHERE order_id = '$order_id'";
        $order_info['order_goods'] = serialize($GLOBALS['db']->getAll($sql));
        $GLOBALS['db']->autoExecute('ecs_order_info_del', $order_info, 'INSERT');
    }
}

function checkOrderAuth($order_id = '') {  //淘宝订单只有归属者、组长和跟单有权限
    global $db;
    if ($order_id) {
        $info = $db->getRow("SELECT * FROM ecs_order_info WHERE order_id = " . $order_id);
        $row = $db->getRow("SELECT group_id,is_leader FROM ecs_admin_user WHERE user_id = " . $_SESSION['admin_id']);
        $group_id = $row['group_id'];
        if ($info['order_status'] == 0 && $group_id != 8 && $group_id != 48 && $group_id != 32 && $info['order_type'] == 'normal') {
            echo "<script language='javascript'>alert('请先确认订单');location.href='/admin/order.php?act=info&order_id=" . $order_id . "'</script>";
            exit;
        }

        if ($group_id != 8 && $group_id != 48 && $group_id != 32 && $info['order_type'] == 'normal' && $info['pre_ship_status'] == 'unsure') {
            $check_result = check_order_plan_send_time($order_id);

            if ($check_result) {//$check_result 暂时屏蔽掉
                $error_msg = '请先设置以下商品预计发货时间:';
                foreach ($check_result as $v) {
                    $error_msg .= "<br/>商品名：{$v['goods_name']} 商品编号: {$v['goods_sn']} 数量：{$v['goods_number']}";
                }
                $link[0]['text'] = "设置预计发货时间";
                $link[0]['href'] = "/admin/order.php?act=set_order_send_time&order_id=$order_id";
                sys_msg($error_msg, 0, $link);
            }
        }
        if (!$info['admin_id'] && $group_id != 8 && $group_id != 48 && $group_id != 32 && $info['order_type'] == 'normal') {
            echo "<script language='javascript'>alert('请先设置订单归属！');location.href='/admin/order.php?act=owner_order&order_id=" . $order_id . "'</script>";
            exit;
        }
        /*
          $pre  = substr($info['order_sn'],0,3);
          if($pre == 'KSH' || $pre == 'KFY' || $pre == 'DXS' || $pre == 'HFE')
          {
          if(strpos($info['admin_id'],'|'.$_SESSION['admin_id'].'|')===false && $group_id != 32 && $row['is_leader'] != 1 && $group_id != 8 && $group_id != 48 && $info['order_type'] == 'normal' && $_SESSION['action_list'] != 'all')
          sys_msg('您没有权限修改此订单!');
          }
          else		//网站和体验馆的订单有权限
         */
        return TRUE;
    }
}

function checkOwnerOrder($str = '') {
    if (strpos($_SESSION['action_list'], $str))
        return true;
    else
        return false;
}

function setExprInstall($rec_id = '', $order_id = '') {
    global $db;
    $install_percent = '0.015';
    $install_user = $_POST['install_user'];
    if (count($install_user) == 0)
        return TRUE;
    if ($rec_id && $order_id) {
        $row = $db->getRow("SELECT goods_id,goods_number,goods_price FROM ecs_order_goods WHERE rec_id = " . $rec_id);
        if (count($install_user) == 1)
            $belong_to_ids = $install_user[0];
        else
            $belong_to_ids = '|' . implode('|', $install_user) . '|';
        $info = $db->getRow("SELECT goods_amount,discount,bonus FROM ecs_order_info WHERE order_id = $order_id");
        $amount = $row['goods_price'] * $row['goods_number'];
        $amount = ($info['goods_amount'] - $info['discount'] - $info['bonus']) * $amount / $info['goods_amount'];
        $install_money = ($amount * $install_percent) / count($install_user);
        $is_valid =$db->getOne("select order_rec_id from ecs_expr_install where order_id =$order_id and order_rec_id =$rec_id and goods_id='".$row['goods_id']."'");
        if(!$is_valid)
        {
        	$db->query("INSERT INTO ecs_expr_install(order_rec_id,order_id,goods_id,goods_number,goods_price,amount,status,add_time,belong_to_count,belong_to_ids,install_money)
						VALUES($rec_id," . $order_id . "," . $row['goods_id'] . "," . $row['goods_number'] . "," . $row['goods_price'] . "," . $amount . ",1,'" . time() . "'," . count($install_user) . ",'" . $belong_to_ids . "','" . $install_money . "')");
        }
    }
}

/**
 * 订单特殊审核
 * @param Int $order_id
 * @return boolean
 */
function special_order($order_id) {
    global $db;
    $sql = "SELECT order_id,order_sn,order_status,shipping_status,pay_status,goods_amount,already_pay,bonus,discount,goods_discount " .
            "FROM `ecs_order_info` WHERE order_id='$order_id'";
    $order_info = $db->getRow($sql);
    $sql = "SELECT * FROM `ecs_order_goods` WHERE order_id='$order_id'";
    $order_info['goods_list'] = serialize($db->getAll($sql));
    $order_info['add_time'] = time();
    $order_info['status'] = 'confirm';
    $db->autoExecute('ecs_special_order', $order_info);
    if ($db->affected_rows()) {
        $action_note = '财务特殊审核';
        $sql = "INSERT INTO ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time,log_level) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $order_info['order_status'] . "','" . $order_info['shipping_status'] . "','" . $order_info['pay_status'] . "','','$action_note','" . time() . "','0')";
        $db->query("$sql");
        return true;
    } else {
        return false;
    }
}

/**
 * 取得订单的所有发货单状态为发向体验馆的发货单
 * @param Int $order_id
 * @return Array
 */
function get_order_invoice($order_id) {
    global $db;
    $sql = "SELECT invoice_sn,invoice_id,order_sn,order_id,total_package_num,is_receiving,inventorymoveid,consignee FROM `ecs_stock_invoice_info` WHERE order_id='$order_id' AND fstatus='shipped_expr' ORDER BY ship_time";
    return $db->getAll($sql);
}

/**
 * 获取收货信息
 * @param Int $order_id
 */
function get_order_receive($order_id) {
    global $db, $_LANG;
    $list = array();
    $sql = "SELECT * FROM `ecs_order_receive` WHERE order_id='$order_id'";
    $res = $db->query($sql);
    while (($row = $db->fetchRow($res)) !== false) {
        $row['format_add_time'] = date('Y-m-d H:i', $row['add_time']);
        $row['pay_status'] = $_LANG['ps'][$row['pay_status']];
        $row['shipping_status'] = $_LANG['ss'][$row['shipping_status']];
        $row['order_status'] = $_LANG['os'][$row['order_status']];
        $list[] = $row;
    }
    return $list;
}

/**
 * 更新数据到ERP
 * @param String $goods_id 商品ID
 * @param Int $wh_id 仓库ID
 * @param Int $goods_number 入库数量，正数表示盘赢，负数表示盘亏
 * @return Bool
 */
function ERP_stock_update($goods_id, $wh_id, $goods_number) {
    global $is_open_erp;
    if (!$is_open_erp) {
        return true;
    }
    $sql = "SELECT user_name AS username,password FROM `ecs_admin_user` where user_id='{$_SESSION['admin_id']}'";
    $user = $GLOBALS['db']->getRow($sql);
    $user['username'] = $user['username'];
    if ($goods_number < 1) {
        $param = Array(
            'inventoryVO' => Array(
                'productId' => (string) $goods_id, //商品编号
                'facilityId' => (string) $wh_id, //仓库
                'varianceNum' => (string) $goods_number, //正数表示盘赢，负数表示盘亏
            ),
            'type' => 'inventory'
        );
    } else {
        $factory_price = $GLOBALS['db']->getOne("SELECT factory_price FROM `ecs_goods` WHERE goods_id='$goods_id'");
        $param = Array(
            'productInStockVO' => Array(
                'productId' => (string) $goods_id, //产品编号
                'facilityId' => (string) $wh_id, //仓库标识
                'lotId' => '', //批次标识
                'quantityAccepted' => (string) $goods_number, //接收数量
                'unitCost' => (string) $factory_price, //产品单价
            ),
            'type' => 'productInStock' //接口类型
        );
    }

    http_request('wareHouse', $param, $user);
}

/**
 * ERP调拨收货
 * @param String $id 调拨单ID
 * @return Bool
 */
function ERP_Inventory($id) {
    global $is_open_erp;
    if (!$is_open_erp) {
        return true;
    }
    $sql = "SELECT user_name AS username,password FROM `ecs_admin_user` where user_id='{$_SESSION['admin_id']}'";
    $user = $GLOBALS['db']->getRow($sql);
    $user['username'] = $user['username'];
    //ERP创建调拨单
    $param = Array(
        'updateFlag' => 'intoInventoryMove', //商品尖
        'backFlag' => 'request',
        'inventoryMoveId' => (string) $id,
    );

    $res = http_request('inventoryMoveIntoInventory', $param, $user); //ERP创建调拨单
    $json = json_decode($res, true);
    $params = json_decode($json['params'], true);
    if ($params['backFlag'] != 'success') {
        return false;
    } else {
        return true;
    }
}

//检查是否有传入参数属于需要检查的ID 有就返回需要检查的ID
function get_check_brand($rec_str) {
    //杰鑫=>21 馨美艺饰品=>278 尼享佳=>276 莎尔馨=>262 品牌定制写死
    return false;
    $sql = "SELECT `rec_id`,`goods_name` FROM `ecs_order_goods` as g JOIN `ecs_order_info` as i ON i.order_id = g.order_id  WHERE `brand_id` IN ('278','276','21','262') and rec_id in ({$rec_str}) AND pay_status != 0 ORDER BY brand_id;";
    return $GLOBALS['db']->getAll($sql);
}

//检测是否有发货单,有则返回TURE
function checkInvoiceBill($order_id, $rec_id = '') {
    global $db, $db_select;
    if ($rec_id) {
        $invoice_id = $db_select->getOne("SELECT esii.invoice_id FROM ecs_stock_invoice_goods esig JOIN ecs_stock_invoice_info esii ON esii.invoice_id = esig.invoice_id WHERE esig.order_rec_id = $rec_id AND esii.fstatus != 'cancel' AND esii.fstatus != 'merged' ORDER BY invoice_id DESC limit 1");
        if ($invoice_id)
            return TRUE;
        $shipping_status = $db_select->getOne("SELECT shipping_status FROM ecs_order_goods WHERE rec_id = $rec_id");
        if ($shipping_status == 1 OR $shipping_status == 3 OR $shipping_status == 4)
            return TRUE;
    }
    else {
        $res = $db_select->getAll("SELECT eog.rec_id,eoi.order_id FROM ecs_order_goods eog JOIN ecs_order_info eoi ON eoi.order_id = eog.order_id WHERE eoi.order_id = '" . $order_id . "'");
        foreach ($res as $v) {
            $rec_id = $v['rec_id'];
            $order_id = $v['order_id'];
            $invoice_id = $db_select->getOne("SELECT esii.invoice_id FROM ecs_stock_invoice_goods esig JOIN ecs_stock_invoice_info esii ON esii.invoice_id = esig.invoice_id WHERE esig.order_rec_id = $rec_id AND esii.fstatus != 'cancel' AND esii.fstatus != 'merged' ORDER BY invoice_id DESC limit 1");
            if ($invoice_id)
                return TRUE;
        }
    }
}

function check_group($order_id) {
    global $db_select;
    $sql = "SELECT admin_id,group_id,pay_status,order_type FROM `ecs_order_info` where order_id = '{$order_id}'";
    $result = $db_select->getRow($sql);
    $order_group_id = $result['group_id'];
    $pay_status = $result['pay_status'];
    $admin_ids = $result['admin_id'];

    //未支付的订单可以修改并且直接跳过所有验证
    $type = $_REQUEST['type'];
    if ($type == 1) {
        return true;
    }

    if ($pay_status == 0) {
        /* 需求变更 未付款之前不做任何限制
          //未付款的只有自己才可以修改自己的
          $in_admin = false;
          if(!empty($admin_ids)){
          //检查是否在admin_id里
          $admin_str = trim($admin_ids,"|");
          if(strrchr($admin_str, '|')){
          $admin_array = explode('|', $admin_str);
          if(in_array($_SESSION['admin_id'], $admin_array))
          $in_admin = true;
          }else{
          if($admin_str == $_SESSION['admin_id'])
          $in_admin = true;
          }
          }
          //admin_id 中有当前用户自己的名字
          if($in_admin)
         */
        return true;
    }
    //1=>网站销售 3=>韩菲尔销售 4=>软床销售 5=>凯撒销售 6=>帝轩销售
    $taobao_team = array(1, 3, 4, 5, 6, 94);
    $is_taobao = false;
    if (in_array($order_group_id, $taobao_team)) {
        $is_taobao = true;
    }
    $taobao_str = implode(',', $taobao_team);
    if ($is_taobao) {
        //淘宝 店长 归属 跟单
        /*
          $tmp_group_id = $GLOBALS['db']->getAll("select `group_leader_id` from meilele_group where group_id in ({$taobao_str})");
          $group_id = array();
          foreach($tmp_group_id as $v){
          $group_id[] = $v['group_leader_id'];
          }
          if(in_array($_SESSION['admin_id'],$group_id)){
          $is_leader = true;
          }else{
          $is_leader = false;
          } */
        $admin_ids = $db_select->getOne("SELECT admin_id FROM `ecs_order_info` WHERE `order_id` = {$order_id}");

        $group_id = getLeaderByuser($admin_ids);
        if (in_array($_SESSION['admin_id'], $group_id)) {
            $is_leader = true;
        } else {
            $is_leader = false;
        }

        $in_admin = false;
        if (!empty($admin_ids)) {
            //检查是否在admin_id里
            $admin_str = trim($admin_ids, "|");
            if (strrchr($admin_str, '|')) {
                $admin_array = explode('|', $admin_str);
                if (in_array($_SESSION['admin_id'], $admin_array))
                    $in_admin = true;
            }else {
                if ($admin_str == $_SESSION['admin_id'])
                    $in_admin = true;
            }
        }
    }else {
        //体验馆 店长 助理
        $group_id = $db_select->getOne("select `group_leader_id` from meilele_group where group_id = {$order_group_id}");

        if ($group_id == $_SESSION['admin_id']) {
            $is_leader = true;
        } else {
            $is_leader = false;
        }
        //获取助理信息
        $sql = "SELECT `user_id` FROM ecs_admin_user WHERE job_type = '财务助理' AND group_id = {$order_group_id}";
        $admin_list_tmp = $db_select->getALL($sql);
        $in_admin = false;
        if (!empty($admin_list_tmp)) {
            $admin_list = array();
            foreach ($admin_list_tmp as $v) {
                $admin_list[] = $v['user_id'];
            }
            if (in_array($_SESSION['admin_id'], $admin_list)) {
                $in_admin = true;
            }
        }
    }
    $sql = "SELECT `group_id` FROM `ecs_admin_user` WHERE group_id = 48 || group_id = 8 and user_id = {$_SESSION['admin_id']}";
    $group_id = $db_select->getOne($sql);
    //跟单组 48 超级权限
    if ($group_id == 48 || $in_admin === true || $is_leader === true || ($result['order_type'] == 'patch_order' && $group_id == 8)) {
        //return true;
    } else {
        //return false;
        sys_msg('你没有权限修改此订单，请联系跟单组！');
        exit;
    }
}

/**
 * 如果添加或是修改商品后，检查订单状态是否可以设置成为尽快发货,如果不可以则修改订单尽快发货为空;
 * @param Int $order_id
 */
function check_hurry_now($order_id) {
    global $db, $db_select;
    $sql = "SELECT order_sn,order_status,shipping_status,pay_status,pre_ship_status FROM `ecs_order_info` WHERE order_id='$order_id'";
    $row = $db_select->getRow($sql);
    if ($row['pre_ship_status'] == 'hurry') {
        $flag = checkShipHurry($order_id);
        if (!$flag) {
            //修改订单尽快发货为空
            $sql = "UPDATE ecs_order_info SET pre_ship_status='unsure' WHERE order_id=$order_id";
            $db->query($sql);
            if ($db->affected_rows()) {
                order_action($row['order_sn'], $row['order_status'], $row['shipping_status'], $row['pay_status'], '修改订单状态从“尽快发货”改为待确定');
                if (ERP_FLAG == 1) {
                    $ret = http_request('cancelSoonByPHP', array('orderId' => (String) $order_id), array('username' => $_SESSION['admin_name'], 'password' => $_SESSION['password']));
                    $ret = json_decode($ret, TRUE);
                    if ($ret['code'] != 1)
                        sys_msg('设置成功,同步ERP出现异常!');
                }
            }
        }
    }
}

//检查web组的权限
function web_order_check_per($order_id) {
    global $db_select;
    $sql = "SELECT admin_id,group_id,pay_status FROM `ecs_order_info` where order_id = '{$order_id}'";
    $result = $db_select->getRow($sql);
    $order_group_id = $result['group_id'];
    $pay_status = $result['pay_status'];
    $admin_ids = $result['admin_id'];
    /*
      $taobao_team = array(1,3,4,5,6);
      $taobao_ids = implode(',',$taobao_team);
      $tmp_group_id = $GLOBALS['db']->getAll("select `group_leader_id` from meilele_group where group_id in ({$taobao_ids})");

      foreach($tmp_group_id as $v){
      $group_id[] = $v['group_leader_id'];
      }
      if(in_array($_SESSION['admin_id'],$group_id)){
      $is_leader = true;
      }else{
      $is_leader = false;
      }
     */
    $admin_ids = $db_select->getOne("SELECT admin_id FROM `ecs_order_info` WHERE `order_id` = {$order_id}");
    $group_id = getLeaderByuser($admin_ids); //通过admin_id 获取ID
    if (in_array($_SESSION['admin_id'], $group_id)) {
        $is_leader = true;
    } else {
        $is_leader = false;
    }

    $in_admin = false;
    if (!empty($admin_ids)) {
        //检查是否在admin_id里
        if (strrchr($admin_ids, '|')) {
            $admin_array = explode('|', $admin_ids);
            if (in_array($_SESSION['admin_id'], $admin_array))
                $in_admin = true;
        }else {
            if (trim($admin_ids, "|") == $_SESSION['admin_id'])
                $in_admin = true;
        }
    }
    if ($is_leader || $in_admin)
        return true;
    else
        return false;
    return $result;
}

//体验馆权限
function expr_order_check_per($order_id) {
    global $db_select;
    $sql = "SELECT admin_id,group_id,pay_status FROM `ecs_order_info` where order_id = '{$order_id}'";
    $result = $db_select->getRow($sql);
    $order_group_id = $result['group_id'];
    $pay_status = $result['pay_status'];
    $admin_ids = $result['admin_id'];
    //体验馆 店长 助理
    $group_id = $db_select->getOne("select `group_leader_id` from meilele_group where group_id = {$order_group_id}");
    if ($group_id == $_SESSION['admin_id']) {
        $is_leader = true;
    } else {
        $is_leader = false;
    }
    //获取助理信息
    $sql = "SELECT `user_id` FROM ecs_admin_user WHERE job_type = '财务助理' AND group_id = {$order_group_id}";
    $admin_list_tmp = $db_select->getALL($sql);
    $in_admin = false;
    if (!empty($admin_list_tmp)) {
        $admin_list = array();
        foreach ($admin_list_tmp as $v) {
            $admin_list[] = $v['user_id'];
        }
        if (in_array($_SESSION['admin_id'], $admin_list)) {
            $in_admin = true;
        }
    }
    if ($in_admin || $is_leader)
        return true;
    else
        return false;
}

/**
 * 根据$refund_id获取该订单退款详情
 * @param Int $refund_id
 * @param type=0 除4项的退款 1 虚拟退款 -1 4项的付款
 */
function refund_details($refund_id, $status = '', $type='0') {
    $refund_id = intval($refund_id);

    $other_sql = $type == -1 ? ' IN ' : ' NOT IN ';
    $database = $type == 1 ? 'ecs_refund_detail_virtual' : 'ecs_refund_detail';

    if(!empty($status) && is_array($status))
        $where = ' AND rd.type ' . $other_sql . ' (' . implode(',', $status) . ')';

    if ($refund_id > 0) {
        $sql = "SELECT rd.*,id.contact_name FROM $database rd
                LEFT JOIN ecs_install_data id ON id.install_id = rd.install_id
                WHERE 1 $where AND refund_id = '$refund_id'";
    } else {
        die('refund_id  does not exist, invaild parameters.');
    }

    $refund_details = $GLOBALS['db']->getALL($sql);

    /* 格式化金额字段 */
    foreach ($refund_details as $key => $value) {
        //退货单id
        if ($value['type'] == 'return') {
            if (strpos($value['source_sn'], 'RTS') === 0) {
                $refund_details[$key]['return_type'] = 1;
                $refund_details[$key]['return_id'] = $GLOBALS['db']->getOne("SELECT returns_id FROM `ecs_returns_info` WHERE returns_sn='{$value['source_sn']}'");
            } else {
                $refund_details[$key]['return_type'] = 2;
                $refund_details[$key]['return_id'] = $GLOBALS['db']->getOne("SELECT returns_id FROM `ecs_returns` WHERE returns_sn='{$value['source_sn']}'");
            }
        }

        // 付款状态
        if ($value['finish_time'] > 0)
            $refund_details[$key]['finish_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['finish_time']);
        else
            $refund_details[$key]['finish_time'] = '等待处理';

        // 事件状态,不是付款状态
        if ($value['detail_status'] == 'new')
            $refund_details[$key]['detail_status'] = '新项';

        else if ($value['detail_status'] == 'cancel')
            $refund_details[$key]['detail_status'] = '已取消';

        else if ($value['detail_status'] == 'confirmed')
            $refund_details[$key]['detail_status'] = '已确认';

        else if ($value['detail_status'] == 'finish')
            $refund_details[$key]['detail_status'] = '已完成';

        // 打款状态
        // transfer_status
        if ($value['transfer_status'] == 0)
            $refund_details[$key]['transfer_status'] = '未打款';
        else if ($value['transfer_status'] == 1)
            $refund_details[$key]['transfer_status'] = '打款中 </br> （已提交快钱批量打款）';
        else if ($value['transfer_status'] == 2)
            $refund_details[$key]['transfer_status'] = '已打款';
        else if ($value['transfer_status'] == 3)
            $refund_details[$key]['transfer_status'] = '打款失败';
        
        //取消商品
        if ($value['cancel_goods_sn']) {
            $refund_details[$key]['cancel_goods_sn'] = explode("||", $value['cancel_goods_sn']);
        }
    }

    return $refund_details;
}

//退款详情合计
function refund_info($refund_id) {
    $refund_id = intval($refund_id);

    if ($refund_id > 0) {
        $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('refund') . " WHERE refund_id = '$refund_id'";
    } else {
        die(" invaild parameter . item not found. -- $stock_id");
    }

    $refund_info = $GLOBALS['db']->getRow($sql);

    /* 格式化金额字段 */

    if ($refund_info) {
        $refund_info['formated_log_time'] = local_date($GLOBALS['_CFG']['time_format'], $refund_info['log_time']);
        $refund_info['refund_amount_format'] = price_format($refund_info['refund_amount'], false);
    }

    return $refund_info;
}

//确认收货检测
function receiveConfirm($order_id) {
    global $db;
    $_time = strtotime('2012-05-21 23:59:59');
    $sql = "SELECT shipping_status,ship_direction FROM `ecs_order_info` WHERE order_id='$order_id'";
    $order_info = $db->getRow($sql);
    if (!$order_info) {
        return false;
    } else if ($order_info['shipping_status'] == 2 || $order_info['ship_direction'] == 0) {
        return true;
    }
    //发向体验馆的货
    $sql = "SELECT esig.order_rec_id,esig.goods_sn,esig.goods_name FROM `ecs_stock_invoice_info` AS esii
    LEFT JOIN `ecs_stock_invoice_goods` AS esig ON esii.invoice_id=esig.invoice_id
    WHERE esii.order_id='$order_id' AND esii.fstatus='shipped_expr' AND esii.add_time>'$_time' AND esig.goods_id <> 20659";
    $res = $db->query($sql);
    $invoice_goods_list = array();
    while (($row = $db->fetchRow($res)) !== false) {
        $invoice_goods_list[$row['order_rec_id']] = $row;
    }
    if (count($invoice_goods_list) == 0) {
        return true;
    }
    //体验馆制作发货单发出的货
    $sql = "SELECT warehouse_id FROM `ecs_warehouse` WHERE expr_id='{$order_info['ship_direction']}'";
    $warehouse_id = $db->getOne($sql);
    $sql = "SELECT esig.order_rec_id,esig.goods_sn,esig.goods_name FROM `ecs_stock_invoice_info` AS esii
            LEFT JOIN `ecs_stock_invoice_goods` AS esig ON esii.invoice_id=esig.invoice_id
            WHERE esii.order_id='$order_id' AND esii.fstatus='shipped' AND esii.warehouse_id='$warehouse_id' AND esig.goods_id <> 20659";
    $res = $db->query($sql);
    $expr_invoice_goods_list = array();
    while (($row = $db->fetchRow($res)) !== false) {
        $expr_invoice_goods_list[$row['order_rec_id']] = $row;
    }
    foreach ($invoice_goods_list AS $key => $value) {
        if (!array_key_exists($key, $expr_invoice_goods_list)) {
            return false;
        }
    }
    return true;
}

function getLeaderByuser($admin_id) {
    global $db_select;
    $admin_id = trim($admin_id, '|');
    $admin_ids = str_replace("|", ",", $admin_id);
    if (!$admin_id)
        return array();
    $tmp_result = $db_select->getAll("SELECT g.group_id,g.group_leader_id FROM meilele_group as g
							join ecs_admin_user as a on a.group_id = g.group_id 
							where a.group_id != 0 and user_id in ($admin_ids) ");
    $group_id = array();
    if (!empty($tmp_result)) {
        foreach ($tmp_result as $v) {
            $group_id[] = $v['group_leader_id'];
        }
    }
    return $group_id;
}

/**
 * 订单直接出货添加到ecs_order_goods_ship里进行记录
 *
 * @param Array $goods_id_arr
 * @return boolean
 */
function add_order_goods_to_ship($goods_id_arr) {
    if (count($goods_id_arr) == 0) {
        return false;
    }
    $time = time();
    $sql = "INSERT INTO `ecs_order_goods_ship` (order_rec_id,order_id,goods_id,goods_name,goods_sn,goods_number,ship_time,order_type)
            (SELECT eog.rec_id,eog.order_id,eog.goods_id,eog.goods_name,eog.goods_sn,eog.goods_number,$time,eoi.order_type 
            FROM `ecs_order_goods` AS eog
            LEFT JOIN `ecs_order_info` AS eoi ON eog.order_id=eoi.order_id
            WHERE eog.rec_id " . db_create_in($goods_id_arr) . ")";
    $GLOBALS['db']->query($sql);
    if ($GLOBALS['db']->affected_rows()) {
        return true;
    } else {
        return false;
    }
}

function check_order_plan_send_time($order_id) {

    $result = $GLOBALS['db']->getAll("SELECT * FROM ecs_order_goods
									where order_id = {$order_id} and goods_number > 0 and (plan_send_time = '' or plan_send_time is null) and shipping_status = 0");

    return $result;
}

function get_center_stock() {
    global $db;

    $result = db_get_list('ecs_warehouse', "warehouse_type = 'center'", 'warehouse_id', 'warehouse_id');
    return implode(",", $result);
}

function get_transit_stock() {
    global $db;

    $sql = "SELECT warehouse_id FROM ecs_warehouse where warehouse_type = 'transit'";
    $tmp_result = $db->getAll($sql);
    $result = array();
    foreach ($tmp_result as $k => $v) {
        $result[] = $v['warehouse_id'];
    }
    return implode(',', $result);
}

// 获取订单中商品的排单数量
function get_wait_order_number($order_id, $goods_list)
{
    if(empty($goods_list)) return false;
    global $db;
    $ship_info = $db->getRow("SELECT
            eoi.order_id ,if(ew.parent_id=0,ew.warehouse_id,ew.parent_id) as warehoues_id
            from ecs_order_info eoi
            join ecs_warehouse_unload ewu on eoi.city=ewu.city
            join ecs_warehouse ew on ewu.warehouse_id=ew.warehouse_id
            where eoi.order_id={$order_id}");
    $parent_warehourse_id = $ship_info['warehoues_id'];

    $goods_id_all = array();
    foreach($goods_list as $v)
        $goods_id_all[] = $v['goods_id'];
    if(!empty($parent_warehourse_id))
    {
        $ret = array();
        $goods_wait_num_temp = $db->getAll('SELECT goods_id,wait_num FROM tmp_goods_stock WHERE 1 AND warehouse_id=' . $parent_warehourse_id . ' AND goods_id IN (' . implode(',', $goods_id_all) .')');
        foreach ($goods_wait_num_temp as $k => $v)
            $ret[$v['goods_id']] = $v['wait_num'];
        return $ret;
    }
        
    return false;
}

/**
 * 获取传入订单的商品的预计入库时间
 *
 * @param int $order_id ,Array $goods_sn
 * @return Array
 * 传入order_id就直接直接检查整个order_id的 不走goods_sn 流程
 */
function get_plan_arrive_info($order_id, $goods_sn = array()) {
    global $db;

    //2012-9-21 plan_end_time 改为 plan_arrive_time
    if (empty($goods_sn)) {
        $ship_info = $db->getRow("SELECT
            eoi.order_id ,if(ew.parent_id=0,ew.warehouse_id,ew.parent_id) as warehoues_id
            from ecs_order_info eoi
            join ecs_warehouse_unload ewu on eoi.city=ewu.city
            join ecs_warehouse ew on ewu.warehouse_id=ew.warehouse_id
            where eoi.order_id={$order_id}");
    
        $parent_warehourse_id = $ship_info['warehoues_id'];
        if(!empty($parent_warehourse_id))
            $tmp_goods_sum = $db->getAll("
                SELECT eog.goods_sn,
                sum(eog.goods_number) - num  as sum 
                from ecs_order_goods  eog
                join tmp_goods_stock  tgs on eog.goods_id=tgs.goods_id where eog.order_id = {$order_id}
                and shipping_status = 0 and tgs.warehouse_id = {$parent_warehourse_id} GROUP BY eog.goods_id");

        /* 取上一级仓库 */
       /* $group_id = $db->getOne("select group_id from ecs_order_info where order_id = {$order_id}");
        $group_id = $group_id ? $group_id : 0;
        if ($group_id) {
            $parent_id = $db->getOne("SELECT parent_id from ecs_expr_nature as a join ecs_warehouse as b on a.expr_id = b.expr_id where group_id = {$group_id} ");
        }
        if (!$parent_id)
            $warehouse_ids = get_center_stock();
        else
            $warehouse_ids = $parent_id;
        $sql = "	SELECT aa.goods_sn,(order_goods_sum - ifnull(sum(esb.number),0)) as sum
					FROM ecs_stock_goods as esg right JOIN 
					(
						SELECT goods_sn,sum(goods_number) as order_goods_sum FROM ecs_order_goods 
						WHERE shipping_status = 0 and goods_number > 0 AND order_id = {$order_id} GROUP BY goods_sn
					) as aa ON aa.goods_sn = esg.goods_sn 
					LEFT JOIN ecs_stock_batch as esb 
					ON esb.stock_id = esg.stock_id and warehouse_id in ({$warehouse_ids})  GROUP BY goods_sn";*/
        // $tmp_goods_sum = $db->getAll($sql); //
        $goods_sn_str = '';
        foreach ($tmp_goods_sum as $k => $v) {
            $tmp_goods_sum[$k]['sum'] = (int) $v['sum'];

            if ($v['sum'] <= 0) {
                unset($tmp_goods_sum[$k]);
            } else {
                if ($goods_sn_str) {
                    $goods_sn_str .= ",{$v['goods_sn']}";
                } else {
                    $goods_sn_str = "{$v['goods_sn']}";
                }
            }
        }
    } else {
        $goods_sn_str = implode(',', $goods_sn);
        /* 获取订单goods需要的数量 */
        $sql = "SELECT goods_sn,sum(goods_number) as sum from ecs_order_goods
				where order_id = {$order_id} and shipping_status = 0 and goods_sn " . db_create_in($goods_sn_str) . " group by goods_sn";
        $tmp_goods_sum = $db->getAll($sql);
        /* 需要再上面求出需要取商品订单里面查询的总数量 */
    }
    $goods_sum = array(); //商品在订单里面的总数量
    foreach ($tmp_goods_sum as $v) {
        $goods_sum[$v['goods_sn']] = $v['sum'];
    }
    $today = strtotime("today") - 1;
    /* 获取采购订单的数量 */
    $sql = "SELECT id,order_sn,goods_sn,plan_arrive_time,(goods_num - goods_in_num) as arrive_num
	FROM ecs_supplier_purchase where goods_sn " . db_create_in($goods_sn_str) . " and order_state = 0 and plan_arrive_time > {$today} 
			order by plan_arrive_time asc ,goods_sn desc";
    $tmp_goods_arrive = $db->getAll($sql);
    $goods_arrive = array();
    foreach ($tmp_goods_arrive as $v) {
        $goods_arrive[$v['goods_sn']][] = $v;
    }
    $result = array();
    foreach ($goods_sum as $single_goods_sn => $sum) {
        unset($tmp);
        if ($goods_arrive[$single_goods_sn]) {
            $tmp = current($goods_arrive[$single_goods_sn]);
            $arrive_num = 0;
            $purchase_order_sn = '';
            $plan_arrive_time = '';
            while ($arrive_num < $sum && $tmp) {
                $arrive_num += $tmp['arrive_num'];

                $purchase_order_sn .= "<a href='supplier_purchase.php?act=info&purchase_id={$tmp['id']}'>" . $tmp['order_sn'] . "</a><br/>";
                $plan_arrive_time = $tmp['plan_arrive_time'];

                $tmp = next($goods_arrive[$single_goods_sn]);
            }
            if ($arrive_num < $sum) {
                //循环跑完了但是任然不够 $tmp = false;
                $result[$single_goods_sn]['plan_arrive_time'] = "采购订单不足";
                $result[$single_goods_sn]['purchase_order_sn'] = $purchase_order_sn;
            } else {
                $result[$single_goods_sn]['plan_arrive_time'] = $plan_arrive_time;
                $result[$single_goods_sn]['purchase_order_sn'] = $purchase_order_sn;
            }
        } else {
            $sql = "SELECT id,order_sn,goods_sn,plan_arrive_time,(goods_num - goods_in_num) as arrive_num
				FROM ecs_supplier_purchase where goods_sn = '$single_goods_sn' and order_state = 0 and plan_arrive_time < {$today} 
				order by plan_arrive_time asc ,goods_sn desc";
            $flag = $db->getOne($sql);
            if ($flag) {
                $result[$single_goods_sn]['plan_arrive_time'] = "采购订单交货期已超期";
            } else {
                $result[$single_goods_sn]['plan_arrive_time'] = "无采购订单";
            }
        }
        //if()
    }

    $max_time = 0;
    foreach ($result as $v) {

        if ($max_time === "不确定") {
            continue;
        }
        if ($v['plan_arrive_time'] === "不确定" || $v['plan_arrive_time'] === "采购订单不足" || $v['plan_arrive_time'] === "采购订单交货期已超期" || $v['plan_arrive_time'] === "无采购订单") {
            $max_time = "不确定";
        } else {
            if ($v['plan_arrive_time'] > $max_time) {
                $max_time = (int) $v['plan_arrive_time'];
            }
        }
    }
    if ($max_time != "不确定" && $max_time != 0) {
        $max_time = date('Y-m-d', $max_time);
    }
    return array('item_list' => $result, 'order_plan_end_time' => $max_time);
}

function stock_invoice_detail($invoice_id) {

    $sql = "select a.*,b.name AS warehouse_name from " . $GLOBALS['ecs']->table('stock_invoice_goods') . " a left join ecs_warehouse b on a.warehouse_id = b.warehouse_id where invoice_id= $invoice_id order by a.goods_sn";

    $invoice_detail = $GLOBALS['db']->getALL($sql);

    foreach ($invoice_detail as $key => $value) {
        if ($value['stock_goods_amount'] <= 0) {
            $sql = "SELECT order_id FROM ecs_stock_invoice_info WHERE invoice_id=" . $value['invoice_id'];
            $order_id = $GLOBALS['db']->getOne($sql);
            $sql = "SELECT goods_price FROM ecs_order_goods WHERE order_id='$order_id' AND goods_id=" . $value['goods_id'];
            $stock_goods_amount = $GLOBALS['db']->getOne($sql);
            if (empty($stock_goods_amount))
                $stock_goods_amount = 0;
            $sql = "UPDATE ecs_stock_invoice_goods SET stock_goods_amount=$stock_goods_amount WHERE rec_id=" . $value['rec_id'];
            $GLOBALS['db']->query($sql);
            $invoice_detail[$key]['stock_goods_amount'] = $stock_goods_amount;
        }
    }

    return $invoice_detail;
}

//服务比例的获取
function getServiceScale($goods_amount,$order_id){
    global $db,$cache;
    
    $region_id=$GLOBALS['db']->getOne('SELECT custom_district FROM ecs_order_extend WHERE order_id =' . $order_id);
    if($region_id){
        //$region_type = $cache->getMem('getServiceFee_'.$region_id);
        if(!$region_type)
        {
            $region_type = $db->getOne("SELECT region_type FROM ecs_region_edit where region_id = {$region_id} ");
            $cache->setMem('getServiceFee_'.$region_id,$region_type);
        }
    }else{
        if($region_id){
            //$region_type = $cache->getMem('getServiceFee_'.$region_id);
            if(!$region_type)
            {
                $region_type = $db->getOne("SELECT region_type FROM ecs_region_edit where region_id = {$region_id} ");
                $cache->setMem('getServiceFee_'.$region_id,$region_type);
            }
        }

    }
    //$result  = $cache->getMem('getServiceFee_res_'.$region_type);
    if(!$result)
    {
        if($region_type == 2){
            $result = $db->getRow("SELECT percent,min_fee  FROM ecs_expr_service_manage where city = $region_id and district = 0");
        }else if ($region_type == 3){
            
            /*服务费必须设置到区 此部分为满足1W取百分之多少的功能，2012年9月18日 网站策划需求 下面是默认的设置*/
            if($goods_amount && $goods_amount != '0.00'){
                $result = $db->getRow("SELECT min_fee,percent from ecs_expr_service_manage_extend where {$goods_amount} >= amount_more_than and region_edit_id = {$region_id} order by amount_more_than desc limit 1");
            }
            /*end*/
            if(!$result)
                $result = $db->getRow("SELECT percent,min_fee FROM ecs_expr_service_manage where district = $region_id");
                
            if(!$result){
                $child_id = $db->getOne("SELECT parent_id FROM ecs_region_edit where region_id = {$region_id} ");
                $result = $db->getRow("SELECT percent,min_fee  FROM ecs_expr_service_manage where city = $child_id and district = 0");
            }
        }
        $cache->setMem('getServiceFee_res_'.$region_type,$result);
    }
    
    return $result;
}


function getservicePriceInfo($order_id,$region_id, $goods)
{

    $sql = "SELECT sum(g.goods_weight * o.goods_number) AS weight, SUM(g.stock_volumn* o.goods_number) AS volumn from ecs_order_goods AS o , ecs_goods AS g WHERE o.goods_id = g.goods_id AND o.order_id = '$order_id'";
    $row = $GLOBALS['db']->getRow($sql);
    $row['weight'] = floatval($row['weight']);
    $row['volumn'] = floatval($row['volumn']);
    $row['formated_weight'] = formated_weight($row['weight']);

    $ret['thing_bulk']  = $row['volumn'];
    $ret['thing_weight']  = $row['formated_weight'];
    $ret['bulk_unitprice']  = get_transfer_unit_fee($region_id);
    $ret['weight_unitprice']  = get_transfer_unit_fee_weight($region_id);

    return $ret;
}


function get_extend($file_name){
    $extend =explode("." , $file_name);
    $va=count($extend)-1;
    //FLASH传过来的文件类型为application/octet-stream
    if($extend[$va] != 'jpg')
    return $extend[$va];
    else
    return 'jpeg';
}

function get_deliver_fee($province,$weight){
    global $db; 
    $province = (int)$province;
    $weight = ceil($weight);
    
    if($weight <= 0 || $province == 0)
        return 0;
    if(empty($province))
        return 0;
    
    $info = $db->getRow("SELECT lifting,lifting_price,add_heavy_price from ecs_express_price where province = {$province}");
    if($weight > $info['lifting']){
        $fee = ceil($weight - $info['lifting']) * $info['add_heavy_price'] + $info['lifting_price'];
    }else{
        $fee = $info['lifting_price'];
    }

    $ret['lifting'] = $info['lifting'];
    $ret['lifting_price'] = $info['lifting_price'];
    $ret['add_heavy_price'] = $info['add_heavy_price'];
    $ret['weight'] = $weight;
    $ret['fee'] = $fee;

    return $ret;
}
function get_trans_type($order_id)
{
    return $GLOBALS['db']->getOne('SELECT trans_type FROM ecs_order_extend WHERE order_id=' . $order_id);
}

function order_log_sqlin($order_id)
{
    $note = '包含商品的体积均不为0,自动将ship_pay_statusd的状态设为0.';
    $row = $GLOBALS['db']->getRow("SELECT order_status, shipping_status, pay_status FROM ecs_order_action WHERE order_id='$order_id' ORDER BY log_time desc limit 1");
    $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','$note','" . time() . "')";
    $GLOBALS['db']->query($sql);
}

function order_log_sqlinnote($order_id, $note)
{
    $row = $GLOBALS['db']->getRow("SELECT order_status, shipping_status, pay_status FROM ecs_order_action WHERE order_id='$order_id' ORDER BY log_time desc limit 1");
    $sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES($order_id,'" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','$note','" . time() . "')";
    $GLOBALS['db']->query($sql);
}

//判断订单中的商品是否含有装修商品
//type = 1 by orderid; 2 by goodsid
function chack_fitment_by_id($id, $type = 1)
{
    if(empty($id))
        return false;
    if($type == 1)
    {
        $goodsid = $GLOBALS['db']->getCol('SELECT goods_id FROM ecs_order_goods WHERE order_id =' . $id);
        foreach ($goodsid as $goods_id) {
            $fitment_chack = $GLOBALS['db']->getRow("SELECT show_type, cat_id FROM ecs_goods WHERE goods_id=" . $goods_id);
            if($fitment_chack['show_type'] == '1')
            {
                $fitment_chack['fitment_name'] = $GLOBALS['db']->getOne("SELECT b.cat_name FROM ecs_category a JOIN ecs_category b ON a.parent_id=b.cat_id WHERE a.cat_id=" . $fitment_chack['cat_id']);
                if($fitment_chack['fitment_name'] == '装修设计')
                    return TRUE;
            }
        }  
    }
    if($type == 2)
    {
        $fitment_chack = $GLOBALS['db']->getRow("SELECT show_type, cat_id FROM ecs_goods WHERE goods_id=" . $id);
        if($fitment_chack['show_type'] == '1')
        {
            $fitment_chack['fitment_name'] = $GLOBALS['db']->getOne("SELECT b.cat_name FROM ecs_category a JOIN ecs_category b ON a.parent_id=b.cat_id WHERE a.cat_id=" . $fitment_chack['cat_id']);
            if($fitment_chack['fitment_name'] == '装修设计')
                return TRUE;
        }
    }
    
    return FALSE;
}

function send_mail_fitment_group($order_id)
{
    $orderdetails = $GLOBALS['db']->getRow('SELECT order_sn, consignee, address, mobile FROM ecs_order_info WHERE order_id=' . $order_id);
    $name = $orderdetails['consignee'];
    $email = 'project_zhuangxiu@meilele.com';
    $subject = '订单-' . $orderdetails['order_sn'];
    $content = $orderdetails['consignee'] . '的订单[' . $orderdetails['order_sn'] . ']' .'为装修设计订单,住址为[' . $orderdetails['address'] . ']联系方式为[' . $orderdetails['mobile'] . '],请前往订单页查询详细信息.';
    $type = '0';
    $notification = FALSE;

    if(send_mail($name, $email, $subject, $content, $type, $notification))
        return TRUE;
    else
        return FALSE;
}

function backusebonusinfo($order_id)
{
    $db = $GLOBALS['db'];

    $goods = $db->getAll('SELECT * FROM ecs_order_goods WHERE shipping_status!=5 AND order_id=' . $order_id);


    $ret = array('uselimit' =>0);
    foreach ($goods as $v) 
        if($v['goods_price'] > MINBONUSUSE )
            $ret['uselimit'] += $v['goods_number'];
    $bonus = $db->getAll("SELECT a.bonus_id,a.order_id,b.type_id,b.type_money FROM ecs_user_bonus a JOIN ecs_bonus_type b ON a.bonus_type_id=b.type_id WHERE a.is_backuse=1 AND a.order_id=$order_id ORDER BY b.type_id ASC");
    $ret['usetime'] = count($bonus);
    $ret['bonus_info'] = $bonus;

    return $ret;
}

function check_unset_bonus($order_id)
{
    $db = $GLOBALS['db'];

    $backuse = $db->getOne("SELECT order_id FROM ecs_user_bonus WHERE is_backuse=1 AND order_id=" . $order_id);
    if(!empty($backuse))
    {
        $backusebonusinfo = backusebonusinfo($order_id);
        $usetime = $backusebonusinfo['usetime'];
        $uselimit = $backusebonusinfo['uselimit'];
        $bonusinfo = $backusebonusinfo['bonus_info'];
        $now = time();
        foreach($bonusinfo as $v) 
        {
            if($uselimit < $usetime--)
            {
                $db->query("UPDATE ecs_user_bonus SET used_time='',order_id='',is_backuse=0 WHERE bonus_id='$v[bonus_id]'"); // 使用红包
                $db->query("UPDATE ecs_order_info SET bonus=bonus-$v[type_money] WHERE order_id=$order_id"); // 修改订单红包金额
            }
        }
        $chackmoney = $db->getOne('SELECT bonus FROM ecs_order_info WHERE order_id=' . $order_id);
        if($chackmoney < 0) $db->query('UPDATE ecs_order_info SET bonus=0  WHERE order_id=' . $order_id);
        return;
    }

    $bonus = $GLOBALS['db']->getAll("SELECT * FROM ecs_user_bonus a JOIN ecs_bonus_type b ON a.bonus_type_id = b.type_id WHERE a.order_id=" . $order_id);
    foreach($bonus as &$v)
    {
        if($v['check_money'])
            $v['check_money_flag'] = '1';
    }
    if(!empty($bonus))
    {
        $order_info = $GLOBALS['db']->getRow('SELECT goods_amount,bonus FROM ecs_order_info WHERE order_id=' . $order_id);
        $real_price_nocheck = get_realgoods_price($order_id);
        $real_price_check = get_realgoods_price_normal($order_id);
        foreach($bonus as $v)
        {
            if($v['check_money_flag'] == 1)
                $real_price = $real_price_check;
            else
                $real_price = $real_price_nocheck;
            if(!empty($v['min_goods_amount']) && ($real_price < $v['min_goods_amount'] || $real_price=='0'))
            {
                //取消红包
                $GLOBALS['db']->query('UPDATE ecs_user_bonus SET used_time=NULL, order_id=NULL WHERE bonus_id=' . $v['bonus_id']);
                $GLOBALS['db']->query('UPDATE ecs_order_info SET bonus=bonus-' . $v['type_money'] . ' WHERE order_id=' . $order_id);
                $chackmoney = $GLOBALS['db']->getOne('SELECT bonus FROM ecs_order_info WHERE order_id=' . $order_id);
                if($chackmoney < 0)
                    $GLOBALS['db']->query('UPDATE ecs_order_info SET bonus=0  WHERE order_id=' . $order_id);
                if($check_money_flag)
                    $normalprice = '正价';
                $note = "因$_SESSION[admin_name]修改订单[ID:$order_id]的商品后,{$normalprice}商品的实际总价为$real_price,小于ID:$v[bonus_id]的红包所规定的最小价格$v[min_goods_amount],故红包使用被取消.";
                order_log_sqlinnote($order_id, $note);
            }
        }
    }
}

// 红包中没有正价红包:红包判断商品总价=订单中总价-套装价格-下单返现-服务费
function get_realgoods_price($order_id)
{
    // 订单总价
    $order_amount = $GLOBALS['db']->getOne('SELECT goods_amount FROM ecs_order_info WHERE order_id=' . $order_id);
    // 套装价格
    $suit_price = get_suit_bouns_discount_fee($order_id);
    // 下单返现
    $discount_amount_total = $GLOBALS['db']->getOne("SELECT SUM(discount_amount * goods_number) as total from ecs_order_goods where order_id = {$order_id}");
    // 服务费
    $order_service_fee = $GLOBALS['db']->getOne("SELECT goods_price * goods_number from ecs_order_goods where goods_id = 20659 and order_id = {$order_id} and shipping_status != 5");

    $ret = $order_amount - $suit_price - $discount_amount_total - $order_service_fee;

    return $ret;
}


// 红包中有正价红包:红包判断商品总价=本站价所有商品之和-本站价套装商品折扣
function get_realgoods_price_normal($order_id)
{
    // 订单中所有正价商品之和
    $order_amount = $GLOBALS['db']->getOne('SELECT SUM(goods_price * goods_number) FROM ecs_order_goods WHERE goods_type in (0, 4) AND order_id=' . $order_id);
    // 本站价套装商品折扣
    $suit_price = get_suit_bouns_discount_fee($order_id);
    
    return $order_amount - $suit_price;
}

function get_suit_bouns_discount_fee($order_id)
{
    $suit_id = $GLOBALS['db']->getAll('SELECT suit_id FROM ecs_order_goods WHERE goods_type=0 AND order_id=' . $order_id);
    $suit_str = $GLOBALS['db']->getOne("SELECT suit_str from ecs_order_extend where order_id = {$order_id} ");
    if($suit_str)
        $suit = get_suit_str_to_array($suit_str);
    $discount = 0;
    foreach($suit_id as $v)
    {
        foreach ($suit as $key => $value) {
            if($value['suit_id'] == $v['suit_id'])
            {
                $discount += $value['discount'];
            }
        }
    }
    return $discount;
}

function get_suit_str_to_array($str)
{
    $suit_str = trim($str,'@@');
    $suit_array = explode('@@',$suit_str);
    foreach($suit_array as $v)
        $tmpsuit[] = explode('#',$v); 
    foreach($tmpsuit as $k => $v)
    {
        $tmp = explode('_', $v['0']);
        $ret[$k]['suit_id'] = $tmp['0'];
        $ret[$k]['number'] = $tmp['1'];
        $ret[$k]['discount'] = $v['1'];
    }

    return $ret;
}

function getorderContactInfo()
{
	global $db_select;
	return $db_select->getOne("SELECT user_id FROM ecs_admin_user WHERE (action_list like '%order_contact_info%' or action_list = 'all') AND user_id = ".$_SESSION['admin_id']);
}


function touch_activity($order_id,$patch = 0 ){
	global $db,$ecs;
	if(!$_REQUEST['order_id'])
		$_REQUEST['order_id'] = $order_id;
		
	if($_REQUEST['patch'] !== 0 ){
		$_REQUEST['patch'] = $patch;
	}
	if($_SESSION['admin_id'] == 1592 && $_REQUEST['debug'] == 2){
		error_reporting(E_ALL);
	}
	ini_set('memory_limit', '726M');
    $order_id = $_REQUEST['order_id'];

    $chengdu = $db->getOne("SELECT group_id from ecs_admin_user where group_id in (108,14,106) and user_id = {$_SESSION['admin_id']}");

    $chengdu = $db->getOne("SELECT group_id from ecs_admin_user where group_id in (108,14,106) and user_id = {$_SESSION['admin_id']}");

    $order = $db->getRow("SELECT * FROM ecs_order_info where order_id = {$order_id}");
    if ($order['add_time'] < 1349704909 && !in_array($order['group_id'], array(108, 14, 106))) {
        header("Location:/admin/order.php?act=info&order_id={$order_id}");
        exit;
    }
    /*
      if(in_array($order['group_id'],array(108,14,106)) && $order['add_time'] < 1349704909 ){

      } */
    $order_extend = $db->getRow("SELECT * FROM ecs_order_extend where order_id = {$order_id}");
    $_result = get_avt_info($order);
    $_result['expr'] = floor($_result['expr']);
    if ($_result['expr'] || $_result['expr'] == 0) {
    	if($_result['expr'] == 0)
 			$db->query("update ecs_order_goods SET goods_number = 0 ,shipping_status = 5  where goods_id = 20659 and order_id = {$order_id}");
        
 		$expr_number = $db->getOne("SELECT goods_number from ecs_order_goods where goods_id = 20659 AND shipping_status !=5	and order_id = {$order_id}");
        $expr_number = (float) $expr_number;
        if ($expr_number != $_result['expr']) {
            $new_number = $_result['expr'] - $expr_number;
            //需要日志
            order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '修改了服务费为' . $_result['expr']);
            $have_expr = $db->getone("SELECT 1 from ecs_order_goods where goods_id = 20659 and shipping_status != 5 and order_id = $order_id");

            if (!$have_expr) {
                $order_item_seq_id = $db->getOne("SELECT max(order_item_seq_id) from ecs_order_goods where order_id = {$order_id}");
                $order_item_seq_id++;
                $sql = "INSERT INTO " . $ecs->table('order_goods') .
                        " (order_id, goods_id, goods_name, goods_sn, " .
                        "goods_number, market_price, goods_price, factory_price, " .
                        "is_real, extension_code, parent_id, is_gift,brand_id,order_item_seq_id,goods_type,og_add_time)" .
                        "SELECT '$order_id', goods_id, goods_name, goods_sn, " .
                        "'{$new_number}', market_price, '1', '1',  " .
                        "is_real, extension_code, 0, 0,brand_id,$order_item_seq_id,0 ," . time() .
                        " FROM " . $ecs->table('goods') .
                        " WHERE goods_id = 20659 LIMIT 1";
                $db->query($sql);
            } else {
                if ($_result['expr'] > 0)
                    $db->query("update ecs_order_goods SET goods_number = ({$_result['expr']})  where goods_id = 20659 and order_id = {$order_id}");
                else {
                    $db->query("update ecs_order_goods SET goods_number = 0 ,shipping_status = 5  where goods_id = 20659 and order_id = {$order_id}");
                }
            }
        }
    }
    /*赠品处理开始*/
    $list_gift = array();//所有的赠品编号
    if ($_result['gift']) {
        $order_item_seq_id = $db->getOne("SELECT max(order_item_seq_id) from ecs_order_goods where order_id = {$order_id}");
        foreach ($_result['gift'] as $v) {
        	$list_gift[] = $v['goods'];
            $order_item_seq_id++;
			$rec_id = $db->getOne("SELECT rec_id FROM ecs_order_goods where goods_sn = '{$v['goods']}' and goods_type =1 and shipping_status != 5 and is_gift = 1 and order_id = {$order_id} ");            
			if ($rec_id) {
                $db->query("UPDATE ecs_order_goods SET goods_number = {$v['count']}  where goods_sn = '{$v['goods']}' and shipping_status != 5 and rec_id = {$rec_id} and order_id = {$order_id}");
                continue;
			}
        
	       if (!$rec_id) {
	            $sql = "INSERT INTO " . $ecs->table('order_goods') .
	                    " (order_id, goods_id, goods_name, goods_sn, " .
	                    "goods_number, market_price, goods_price, factory_price, " .
	                    "is_real, extension_code, parent_id, is_gift,brand_id,order_item_seq_id,goods_type,og_add_time)" .
	                    "SELECT '$order_id', goods_id, goods_name, goods_sn, " .
	                    "'{$v['count']}', market_price, '0', '1',  " .
	                    "is_real, extension_code, 0, 1,brand_id,$order_item_seq_id,1 ," . time() .
	                    " FROM " . $ecs->table('goods') .
	                    " WHERE goods_sn = '{$v['goods']}' LIMIT 1";
	             $db->query($sql);
	        }
        }
        order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '增加订单赠品' . $v['goods']);
    }else{
		if($db->getOne("SELECT 1 FROM ecs_order_goods WHERE goods_sn = '{$_gift}' and order_id = {$order_id}")){
		$db->getOne("UPDATE ecs_order_goods SET shipping_status = 5 , goods_number = 0 where shipping_status  = 0 and is_receiving = 0 and goods_type = 1 and is_gift = 1 and order_id = {$order_id}");
		 order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '取消所有活动赠品！');
		}
	}
	$order_gift_list = db_get_list('ecs_order_goods',"order_id = {$order_id} and shipping_status != 5 and goods_type = 1",'rec_id','goods_sn');
	foreach($order_gift_list as $_rec_id =>$_goods_sn){
		if(!in_array($_goods_sn,$list_gift)){
			$db->query("UPDATE ecs_order_goods SET goods_number = 0 , shipping_status = 5  where goods_sn = '{$_goods_sn}' and is_receiving = 0  and goods_type = 1 and is_gift = 1 and order_id = {$order_id}");
			continue;
		}
	}
	/*赠品处理结束*/
    $_result['reduce_product_fee'] = (float) $_result['reduce_product_fee'];
    $order_extend['add_discount'] = (float) $order_extend['add_discount'];
    if (((float) $_result['reduce_product_fee'] != (float) $order_extend['add_discount'])) {
        $reduce = $_result['reduce_product_fee'] - $order_extend['add_discount'];
        $db->query("UPDATE ecs_order_info SET discount = discount +$reduce where order_id = {$order_id}");
        $db->query("UPDATE ecs_order_extend SET add_discount = {$_result['reduce_product_fee']} where order_id = {$order_id}");
        order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '活动满减从' . $order_extend['add_discount'] . '改为' . $_result['reduce_product_fee']);
    }

    if ($_result['shipping_fee'] === -1) {
        order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '添加了额外商品但是此商品物流费无法计算');
    }
    $_result['shipping_fee'] = (int) $_result['shipping_fee'];
    $order['shipping_fee'] = (int) $order['shipping_fee'];

    if ($_result['shipping_fee'] != $order['shipping_fee']) {
        $db->query("UPDATE ecs_order_info SET shipping_fee = {$_result['shipping_fee']} where order_id = {$order_id}");
        order_action($order['order_sn'], $order['order_status'], $order['shipping_status'], $order['pay_status'], '物流费从' . $order['shipping_fee'] . '改为' . $_result['shipping_fee']);
    }
    updateOrderAmount($order_id);
    if(checkDiscount($order_id)){
        	$notes = "订单金额为0 设置目标金额和物流费为0";
        	$sql = "INSERT ecs_order_action(order_id,action_user,order_status,shipping_status,pay_status,action_time,action_note,log_time) VALUES('" . $order_id . "','" . $_SESSION['admin_name'] . "','" . $row['order_status'] . "','" . $row['shipping_status'] . "','" . $row['pay_status'] . "','" . time() . "','" . $notes . "','" . time() . "')";
        	$db->query($sql);
    }
    if(!$order_extend['activity_id'])
    $activety 	 = Promotional_Activitie($order_id,array(),$order_extend['activity_id']);
	if($activety){
		$html_str = '';
		foreach($activety as $v){
			$html_str .= "<option value={$v['id']}>{$v['subject']}</option>";
		}
		echo 
<<<EOF
<form action="order.php?act=choose_activety&order_id={$order_id}" method ="POST" />
<select name="activity_id">
{$html_str}
</select>

<input type="submit" value="选择活动"   />活动一旦选择 无法更换
</form>
EOF;
exit;
	}
   if ($_REQUEST['patch']) {
        header("Location:/admin/order.php?act=edit&order_id={$order_id}&step=patch_goods");
    } else {
        header("Location:/admin/order.php?act=edit&order_id={$order_id}&step=goods");
    }   
    exit;
}

// 获取应付款金额.
// order中包含order_id和order_sn,total_fee,bonus
function indexshowshouldpay($order)
{
    $db = $GLOBALS['db'];
    $count_order_refund_info = order_refund_getinfo($order['order_sn']);
    $count_order_refund_info = $count_order_refund_info['count_order_refund_info'];
    $order_amount = $order['total_fee'] - $order['bonus'];
    $ret = $order_amount + $count_order_refund_info;
    $virtual_amount = getVirtualAmount_new($order['order_sn'], 'other'); //虚拟退款尾款
    $ret -= $virtual_amount;
    $already_receive = get_order_audit_list_show($order['order_id']); 
    $already_receive = $already_receive['already_receive']; // 审核到帐金额
    $ret -= $already_receive;
    $virtual_amount_order_sn = $db->getAll("select rv.order_sn,rdv.refund_amount from ecs_refund_detail_virtual  rdv left join ecs_refund_virtual rv on rdv.refund_id =rv.refund_id where rdv.into_order_sn='" . $order['order_sn'] . "' and rdv.detail_status ='confirmed' and (rdv.type='into_order_fee' or rdv.item_type='into_order_fee_type')");
    $total_virtual_amount_order_money = 0;
    foreach ($virtual_amount_order_sn as $v) $total_virtual_amount_order_money += $v['refund_amount']; // 虚拟退款(转入订单金额)
    $ret -= $total_virtual_amount_order_money; 
    $virtual_amount_out = getVirtualAmount_new($order['order_sn']); // 虚拟退款(转出订单金额)
    $ret += $virtual_amount_out; 

    return $ret;
}

function order_refund_getinfo($order_sn = '')
{
    $db = $GLOBALS['db'];
    if(empty($order_sn)) return false;
    $order_refund_info = $db->getAll("SELECT * FROM ecs_refund_detail a JOIN ecs_refund b ON b.refund_id=a.refund_id WHERE b.order_sn='$order_sn'");

    $order_refund_type_list = array(
        'instead_setup'   => '客户垫付安装费',
        'instead_repair'  => '客户垫付维修费',
        'factory'         => '工厂赔偿金额',
        'company'         => '我司赔偿金额',
        'setup'           => '安装费',
        'repair'          => '维修费',
        'damage'          => '赔偿金',
        'cancel'          => '取消商品',
        'change'          => '换货差价',
        'return'          => '退货返款',
        'delivery'        => '运费补偿',
        'delivery_fee'    =>'送货费',
        'into_order_fee'  =>'转订单金额',
        'no_after_sale'   =>'无售后问题补偿',
        'join_insured'   =>'参加保价',
        'prize_refund'   =>'抽奖退款',
        'handing_fee'   =>'装卸费',
        'activity_book_refund'=>'退活动定金'
        # 'other'           => '其它'
    );

    $detail_status_array=array(
            'new'=>'新项 ',
            'confirmed'=>'确认',    
            'cancel'=>'取消',    
            'finish'=>'完成',    
    );

    $nocount = array('setup','repair','delivery_fee','handing_fee');

    $count_order_refund_info= 0;

    foreach($order_refund_info as $k=>$v)
    {
        if(in_array($v['type'], $nocount))
            $v['nocount'] = '1';
        else
            if($v['detail_status'] != 'cancel')
                $count_order_refund_info+=$v['refund_amount'];
        $v['type'] = $order_refund_type_list[$v['type']];
        $v['detail_status'] = $detail_status_array[$v['detail_status']];
        $v['format_refund_amount'] = price_format($v['refund_amount'], false);
        if($v['finish_time'] > 0) $v['formated_log_time'] =  local_date($GLOBALS['_CFG']['time_format'], $v['finish_time']);
        else $v['formated_log_time'] = '-';

        if($v['batchout_time'] == 0) $v['batchout_time'] = '-';
        else $v['batchout_time'] = date('Y-m-d H:s' ,$v['batchout_time']);
        $order_refund_info[$k] = $v;
    }

    $ret['order_refund_info'] = $order_refund_info;
    $ret['count_order_refund_info'] = $count_order_refund_info;

    return $ret;
}

function get_order_audit_list_show($order_id)
{
    $order_audit_list = order_audit_list($order_id);
    $order_audit_list_show = array('receive'=>0,'already_receive'=>0);
    foreach($order_audit_list as $v)
    {
        if(($v['audit_status'] == '审核通过' || $v['audit_status'] == '<font color="#369">[程序自动审核]</font>') && $v['is_receive'] == 1)
        {
            $order_audit_list_show['already_receive'] += $v['audit_money'];
            $order_audit_list_show['receive'] += $v['audit_money'];
        }
        elseif($v['audit_status'] != '审核失败')
        {
            $order_audit_list_show['receive'] += $v['audit_money'];
        }
    }

    return $order_audit_list_show;
}
////////////////////////////////////////////////////很重要的代码//////////////////////////////////////////////
/**
     * 获取指定发货单的费用信息
     * @param int $invoice_id 发货单id
     */
    function get_invoice_fee_by_invoice_id($install_id,&$is_merge=false,$merge=FALSE) {
        $master_type = array(1 => '职工', 2 => '临时', 3 => '外包');
        $pay_way = array(1 => '月结', 2 => '次付', 3 => '职工提成', 4 => '按点提');
        $pay_type = array(/* 1 => '现金', */ 2 => '银行');
        $cost_type = array(1 => '送货费', 2 => '安装费', 3 => '装货费', 4 => '卸货费', 5 => '一至三上楼费', 6 => '提货费', 7 => '外包费', 8 => '体验馆摆场费');
       $status = array(
        0 => '未请款',
        1 => '已请款',
        2 => '打款拒绝',
        3 => '请款中',
        4 => '已取消',
        5 => '财务审核失败',
        6 => '财务审核通过',
    );
        //查询订单对应的发货单信息
        
        
        $array = array();
        $sql = "SELECT `id`, `invoice_sn`, `master_type`, `combile_fee_type`, `combile_total_fee`, `pay_way`, `percent`, `pay_type`, `workers`, `remark`, `status`, `add_time`, `billing_time`, `oprator` FROM `ecs_stock_invoice_installs_fee` WHERE  `invoice_sn` = '{$install_id}'";
        $list = $GLOBALS['db']->getAll($sql);
        
        if(!$list){
            //如果单据不存在费用表中,在查询单据是否存在合并的单据中
            $i_id =$GLOBALS['db']->getOne("SELECT `invoice_id` FROM `ecs_stock_invoice_info` WHERE `invoice_sn`= '{$install_id}'");
             $bool =is_merged($i_id);
             if(!$bool){
                 return array();
             }else{
                 //如果单据存在合并单据中
                 $sub = trim(get_merge_set($bool),',');
                 return get_invoice_fee_by_invoice_id($bool,$is_merge=true,$sub);
             }
        } 
        else{
          foreach ($list as $key => $value) {
            $value['invoice_sn_str'] = $merge ? $value['invoice_sn'].'【'.$merge.'】' : $value['invoice_sn'];
            $value['master_type_name'] = $master_type[$value['master_type']];
            $value['pay_way_name'] = $pay_way[$value['pay_way']];
            $value['pay_type_name'] = $pay_type[$value['pay_type']];
            $value['fee_string'] = set_fee_type($value['combile_fee_type'], $value['master_type'], $cost_type, TRUE);
            $value['master'] = get_show_master_name($value['workers'], $value['master_type']);
            $value['billing_time'] = $value['billing_time'] == '0000-00-00 00:00:00' ? '' : $value['billing_time'];
            $value['add_time'] = $value['add_time'] == '0000-00-00 00:00:00' ? '' : $value['add_time'];
            $value['percent'] = $value['percent'] == '0.000' ? '' : $value['percent'];
            $value['status'] = $status[$value['status']];
            $value['invoice_id'] = $GLOBALS['db']->getOne('SELECT `invoice_id` FROM ecs_stock_invoice_info WHERE invoice_sn =\''.$value['invoice_sn'].'\'');
            $array[$key] = $value;
            }
            return $array;  
        }
        
    }
    function get_merge_set($merge){
        $list = $GLOBALS['db']->getOne("SELECT  `merge_id`  FROM `ecs_stock_invoice_extend` WHERE `invoice_sn` = '{$merge}'");
        $array = explode(',', $list);
        foreach ($array as $value) {
            $sn = $GLOBALS['db']->getOne("SELECT  `invoice_sn` FROM `ecs_stock_invoice_extend` WHERE `invoice_id` = {$value}");
            $string .=$sn.',';
        }
        return $string;
    }
     /**
     * 发货单已经被合并过
     * @param int $id 发货单id
     * @return 合并过返回真，否则返回false
     */
    function is_merged($id) {
        $sql = "SELECT `invoice_sn`  FROM `ecs_stock_invoice_extend` WHERE  FIND_IN_SET('{$id}',merge_id)";
        $is_merge = $GLOBALS['db']->getOne($sql);
        return empty($is_merge) ? FALSE : $is_merge;
    }
    /**
     * 费用显示
     * @param string $fee_type
     * @return string
     */
     function set_fee_type($fee_type, $type = '', $array = '', $is_show = FALSE) {
          $cost_type = array(1 => '送货费', 2 => '安装费', 3 => '装货费', 4 => '卸货费', 5 => '一至三上楼费', 6 => '提货费', 7 => '外包费', 8 => '体验馆摆场费');
        if (strpos($fee_type, ',') === FALSE) {
            $fee_type = $fee_type . ',';
        }
        $arr = explode(',', $fee_type);
        switch ($type) {
            case 1:
                foreach ($arr as $fee_id) {
                    if (in_array($fee_id, array_flip($array))) {
                        $string .='<input type="checkbox" name="left_sel_combile_type[]" disabled  value="' . $fee_id . '" checked ><span class="unused">' . $cost_type[$fee_id] . '</span>';
                        unset($array[$fee_id]);
                    }
                }
                if ($is_show) {
                    return $string;
                }
                foreach ($array as $key => $value) {
                    $string .='<input type="checkbox" name="left_sel_combile_type[]" value="' . $key . '">' . $value;
                }
                break;
            case 2:
                foreach ($arr as $fee_id) {
                    if (in_array($fee_id, array_flip($array))) {
                        $string .='<input type="checkbox" name="right_sel_combile_type[]" disabled  value="' . $fee_id . '" checked ><span class="unused">' . $cost_type[$fee_id] . '</span>';
                        unset($array[$fee_id]);
                    }
                }
                if ($is_show) {
                    return $string;
                }
                foreach ($array as $key => $value) {
                    $string .='<input type="checkbox" name="right_sel_combile_type[]" value="' . $key . '">' . $value;
                }
                break;
            case 3:
                foreach ($arr as $fee_id) {
                    if (in_array($fee_id, array_flip($array))) {
                        $string .='<input type="checkbox" name="middle_sel_combile_type[]" disabled  value="' . $fee_id . '" checked ><span class="unused">' . $cost_type[$fee_id] . '</span>';
                        unset($array[$fee_id]);
                    }
                }
                if ($is_show) {
                    return $string;
                }
                foreach ($array as $key => $value) {
                    $string .='<input type="checkbox" name="middle_sel_combile_type[]" value="' . $key . '">' . $value;
                }
                break;
        }
        return $string;
    }
    
    /**
     * 格式化显示存在的师傅名称
     * @param string $master 师傅id字符串
     * @return string 格式
     */
    function get_show_master_name($master, $type = '') {
        if (strpos($master, ',') === FALSE) {
            $string = '<input type="checkbox" name="zhigong[]" value="' . $master . '" checked disabled><span class="unused">' . get_master_name($master) . '</span>';
        } else {
            $arr = explode(',', $master);
            foreach ($arr as $value) {
                if ($value) {
                    $string .= '<input type="checkbox" name="zhigong[]" value="' . $value . '" checked disabled><span class="unused">' . get_master_name($value) . '</font>';
                }
            }
        }
        return $string;
    }
    /**
     * 获取师傅名称
     * @param int $id id
     * @return string 名称
     */
    function get_master_name($id) {
        return $GLOBALS['db']->getOne("SELECT `contact_name` FROM `ecs_install_data` WHERE `install_id` = {$id} ");
    }
?>
