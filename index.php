<?php
	define("SYSTEM_PATH","System");
	define("APP_NAME","系统名称");
	define("APP_PATH",".");

    require(SYSTEM_PATH."/System.class.php");

	$App=new App();
	$rs=$App->run();
?>
