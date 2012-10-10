<?php

class servAction extends ServiceClientAction{
    function servAction() {
		parent::__construct();
		$this->wsdl="http://127.0.0.1/LHBSystem_1/index.php?services.wsdl";
		$this->severmodel='xml';
		$this->userkey='user8';
    }

	/**
	 *http://localhost/artwebsphp/index.php?mod=serv&act=test
	 */
    function test()
    {
    	$inarr=array("MESSAGEID"=>'短信编号',
					 "MESSAGECONTENT.string"=>"短信内容",
					 "to_char(MESSAGEINDATE,'YYYY-mm-dd hh24:mi:ss') as MESSAGEINDATE"=>"入库时间",
					 "TYPE"=>'信息类型',
					 "XXLY"=>'信息来源'
		);
		$rs=$this->query('getarray');
		return $rs;
    }


   /**
	 *http://localhost/artwebsphp/index.php?mod=serv&act=test1
	 */
    function test1()
    {
    	$inarr=array("MESSAGEID"=>'短信编号',
					 "MESSAGECONTENT.string"=>"短信内容",
					 "to_char(MESSAGEINDATE,'YYYY-mm-dd hh24:mi:ss') as MESSAGEINDATE"=>"入库时间",
					 "TYPE"=>'信息类型',
					 "XXLY"=>'信息来源'
		);
		$w="MESSAGEID='SMSOUT00000000000055'";
		$rs=$this->query('getSelectResult',array($inarr,$w),'MessageModel');
		return $rs;
    }

   	/**
	 *http://localhost/artwebsphp/index.php?mod=serv&act=teststring
	 */
    function teststring()
    {
		$rs=$this->queryjson('getarray');
		return $rs;
    }
}
?>