<?php

class serv1Action extends Action {
    public $wsdl='http://127.0.0.1/LHBSystem_1/index.php?services.wsdl';
	public $severmodel='xml';
	public $queryvar=array(
							'gettxt'=>array('b','a')
						);

	function serv1Action(){
		parent::__construct();
		$this->queryvar=array(
							'gettxt'=>array('a','b')
						);
		$this->userkey='user81';
	}
    function index() {
		$txt="<div style='font-weight:normal;color:blue;float:left;width:345px;text-align:center;border:1px solid silver;background:#E8EFFF;padding:8px;font-size:14px;font-family:Tahoma'>欢迎使用<span style='font-weight:bold;color:red'>云南掌联科技有限公司</span>系统开发平台</div>";
		return $txt;
    }

    /**
     * http://localhost/artwebsphp/index.php?mod=serv1&act=getarray
     * http://localhost/artwebsphp/index.php?mod=serv1&act=getdataI
     * http://localhost/artwebsphp/index.php?mod=serv1&act=gettxt&a=1&b=2
     */

     function gettxt()
     {
     	return '1111';
     }

}
?>