<?php
	/**
	 * 版本号    v1.0.0
	 * 发布日期  2011-03-28
	 */

	$GLOBALS['_beginTime'] = microtime(TRUE);
	define('IS_WIN',strstr(PHP_OS, 'WIN') ? 1 : 0 );
	if(!defined('APP_PATH')) define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
	if(!defined('RUNTIME_PATH')) define('RUNTIME_PATH',APP_PATH.'/Runtime/');
	if(!defined('TMPL_PATH')) define('TMPL_PATH',APP_PATH.'/Tpl/');

	if(!defined('LHB_PATH')) define('LHB_PATH', dirname(__FILE__));
    if(!defined('APP_NAME')) define('APP_NAME', basename(dirname($_SERVER['SCRIPT_FILENAME'])));
	    if(is_file(RUNTIME_PATH.'~runtime.php')) {
        // 加载框架核心编译缓存
        require RUNTIME_PATH.'~runtime.php';
    }else{
        // 加载编译函数文件
        //require THINK_PATH."/Common/runtime.php";
        // 生成核心编译~runtime缓存
        //build_runtime();
        //echo THINK_PATH."/Common/runtime.php";
    }
//	echo LHB_PATH;
    require LHB_PATH.'/Lib/LHB/Core/App.class.php';


?>