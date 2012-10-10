<?php

class easyuiAction extends ActionEasyUi {

	/**
	 * http://localhost/artwebsphp/index.php?mod=easyui&act=layout1
	 */
	function layout1()
	{
		$this->display();
		$txt=$this->response();
		return $txt;
	}
}
?>