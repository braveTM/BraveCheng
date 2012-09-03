<?php
        //define('RUNTIME_ALLINONE', true);  // 开启ALLINONE运行模式
        define('THINK_PATH', './ThinkPHP');
	//定义项目名称和路径
	define('APP_NAME', 'zhixun');
	define('APP_PATH', './zhixun');
	// 加载框架入口文件
	require(THINK_PATH."/ThinkPHP.php");
	require(APP_PATH."/zhixun.php");
        App::run();
?>