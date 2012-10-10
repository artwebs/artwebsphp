<?php

class sysAction extends ActionXmlI {
	/**
	 *http://localhost/artwebsphp/index.php?mod=sys&act=test
	 */
	function test()
	{
		$sys=new SystemDataTestModel();
		$rows=$sys->getSelectResult();
		$json_string = json_encode($rows);
		$obj = json_decode($json_string,true);
		print_r($obj);
	}

}
?>