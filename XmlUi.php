<?php
	define("SYSTEM_PATH","System");
	define("APP_NAME","车驾管客户端");
	define("APP_PATH",".");

    require(SYSTEM_PATH."/System.class.php");

	$App=new App();
	$rs=$App->run('','',array(),true);

	$obj=new XmlUi($App->getModel(),$App->getAction());
	$obj->setDocString($rs);
	$rs=$obj->run(R('uitype'));
	print_r($rs);
?>
