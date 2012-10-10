<?php

class easyuiAction extends ActionEasyUi {

	/**
	 * http://localhost/LHBSystem_1/index.php?mod=easyui&act=layout1
	 */
	function layout1()
	{
		$this->display();
		$txt=$this->response();
		return $txt;
	}
}
?>