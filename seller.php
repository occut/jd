<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('APP_DEBUG',true);
define('COMMON_PATH','./WebCommonInc/');
define('APP_PATH','./SellerApps/');
define('RUNTIME_PATH','./SellerRuntime/');
define('TMPL_PATH','./SellerTemplate/');
define('BUILD_DIR_SECURE', false);
define('BIND_MODULE','Seller');
require './ThinkPHPFrame/ThinkPHP.php';