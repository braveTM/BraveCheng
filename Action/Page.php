<?php

require_once dirname(dirname(__FILE__)) . '/Library/Page.class.php';

$pagenum = isset($_REQUEST ['page']) ? $_REQUEST ['page'] : 1;
$page_row = 5; //每页显示条数
$count = 1000; //总数

$p = new Page($count, $page_row, 7);

$p->AjaxType = true;
$p->isJumpPage = true;

//$p->setConfig('theme', '%totalRow% %header% %nowPage%/%totalPage% 页%first% %upPage% %linkPage% %downPage% %end% %jump%');


$return_data['page'] = $p->show();

//echo json_encode($return_data);
print_r($return_data);