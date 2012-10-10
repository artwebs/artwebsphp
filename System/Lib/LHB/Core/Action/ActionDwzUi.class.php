<?php

class ActionDwzUi extends ActionPage {

    public function __construct()
	{
    	parent::__construct();
    }

    public function init_header()
	{
		$this->include_css("./System/Vendor/Dwz/themes/default/style.css","screen");
		$this->include_css("./System/Vendor/Dwz/themes/css/core.css","screen");
		$this->include_css("./System/Vendor/Dwz/themes/css/print.css","print");
		$this->include_css("./System/Vendor/Dwz/uploadify/css/uploadify.css","screen");
		$this->header.=<<<EOT
			<!--[if IE]>
			<link href="./System/Vendor/Dwz/themes/css/ieHack.css" rel="stylesheet" type="text/css" media="screen" />
			<![endif]-->

EOT;
		$this->include_js("./System/Vendor/Dwz/js/speedup.js");
		$this->include_js("./System/Vendor/Dwz/js/jquery-1.7.1.js");
		$this->include_js("./System/Vendor/Dwz/js/jquery.cookie.js");
		$this->include_js("./System/Vendor/Dwz/js/jquery.validate.js");
		$this->include_js("./System/Vendor/Dwz/js/jquery.bgiframe.js");
		$this->include_js("./System/Vendor/Dwz/xheditor/xheditor-1.1.13-zh-cn.min.js");
		$this->include_js("./System/Vendor/Dwz/uploadify/scripts/swfobject.js");
		$this->include_js("./System/Vendor/Dwz/uploadify/scripts/jquery.uploadify.v2.1.0.js");

		$this->include_js("./System/Vendor/Dwz/bin/dwz.min.js");
		$this->include_js("./System/Vendor/Dwz/js/dwz.regional.zh.js");
	}
}
?>