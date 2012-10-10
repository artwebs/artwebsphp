<?php

class ActionEasyUi extends ActionPage {
	public function __construct()
	{
    	parent::__construct();
    }

    public function init_header()
	{
		$this->include_css("./System/Vendor/EasyUi/themes/default/easyui.css");
		$this->include_css("./System/Vendor/EasyUi/themes/icon.css");
		$this->include_js("./System/Vendor/EasyUi/jquery-1.6.min.js");
		$this->include_js("./System/Vendor/EasyUi/jquery.easyui.min.js");
		$this->include_js("./System/Vendor/EasyUi/locale/easyui-lang-zh_CN.js");
		$this->include_css("./Css/style.css");
	}
}
?>