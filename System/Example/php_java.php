<?php
		java_init();
		$arr=array(
				"url1"=>"http://localhost:8686/LHBSystem/index.php?a=1",
				"url2"=>"http://localhost:8686/LHBSystem/index.php?a=2",
				"url3"=>"http://localhost:8686/LHBSystem/index.php?a=3",
				);
		$call=java_factory("CallPages", arraytomap($arr));
		$call->run();
		$rs=java_factory("LHBMap");
		$rs=$call->getResult();
		$row=maptoarray($rs);
		print_r($row);
?>
