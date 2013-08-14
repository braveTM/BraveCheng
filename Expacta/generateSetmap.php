<?php

define('SF_ROOT_DIR', realpath(dirname(__FILE__) . '/../..'));
define('SF_APP', 'backend');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG', false);


require_once(SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . SF_APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');
require_once(SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'class.phpmailer.php');

$pidFile = SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR;
define("PID_FILE", $pidFile);
if (!isset($_SERVER['argv'][1]) || empty($_SERVER['argv'][1])) {
    $_SERVER['argv'][1] = 'admin';
}
$_SERVER['DB_CONNECT_NAME'] = $_SERVER['argv'][1];
$pidFile .= strtolower($_SERVER['argv'][1]) . "_";

$pidFile .= 'generateSetmap.pid';
echo "PID file: {$pidFile} \n";
start();


$propelDB = rapidManagerUtil::defineDBFromRunTimeSettings();
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();

try {
    $setmap = new setmapQueue();
    $setmap->dequeue();
} catch (Exception $ex) {
    echo $ex->getMessage(), "\n";
}

function shutdown() {
    @unlink(PID_FILE);
}

function start() {
    $processNumber = getProcessNumber();
    echo "current processor number: {$processNumber} \n";
    if (file_exists(PID_FILE) && $processNumber > 1) {
        echo "\nCache builder is running...\n";
        echo "The pid file of cache builder is exist: " . PID_FILE, " ,if you can sure the builder is not running , please delete the pid file and try again.\n";
        die();
    } else {
        file_put_contents(PID_FILE, date("Y-m-d H:i:s"));
        register_shutdown_function("shutdown");
    }
}

function getProcessNumber() {
    $processName = basename(__FILE__);
    $cmd = "ps aux | grep '" . $processName . "'";
    if (!isset($_SERVER['argv'][1]) || empty($_SERVER['argv'][1])) {
        $_SERVER['argv'][1] = 'admin';
        $dbname = trim($_SERVER['argv'][1]);
    } else {
        $dbname = trim($_SERVER['argv'][1]);
        $cmd .= " | grep '" . $dbname . "'";
    }

    $cmd = $cmd . " | grep -v 'grep' | wc -l";
    echo $cmd, "\n";
    $processNumber = exec($cmd);
    $processNumber = intval($processNumber);
    return $processNumber;
}

