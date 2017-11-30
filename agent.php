<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('APP_DEBUG',true);
define('COMMON_PATH','./WebCommonInc/');
define('APP_PATH','./AgentApps/');
define('RUNTIME_PATH','./AgentRuntime/');
define('TMPL_PATH','./AgentTemplate/');
define('BUILD_DIR_SECURE', false);
define('BIND_MODULE','Agent'); 
require './ThinkPHPFrame/ThinkPHP.php';