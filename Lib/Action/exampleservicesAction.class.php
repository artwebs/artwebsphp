<?php

class exampleservicesAction extends ActionXmlI {
	public $wsdl='http://127.0.0.1/LHBSystem_1/index.php?services.wsdl';
	public $severmodel='examplexml';
	public $userkey='user81';
	/**
	 * 列表查询接口
	 * 性别 sex  eg: http://localhost/artwebsphp/index.php?mod=exampleservices&act=queryservicelist
	 * 来源 source eg:http://localhost/artwebsphp/index.php?mod=exampleservices&act=queryservicelist
	 */
	function queryservicelist()
	{
		$rs=$this->query('examplexmlAction',array('1'));
		die($rs);
	}
}
?>