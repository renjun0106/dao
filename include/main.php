<?php

require('include/function.php');
require('core/core.php');

$router = include('config/router.php');
$action = include('config/action.php');

define('MODULE', 'module');

$path = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:$router['default_url'];
define('PATH', MODULE.(isset($router['url_rules'][$path])?$router['url_rules'][$path]:$path));


$method = isset($_GET['action'])?$_GET['action']:$action['default_action'];
loadClass(PATH)->$method();
