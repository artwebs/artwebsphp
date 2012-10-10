<?php

class IndexAction extends Action {
    function index() {
		$txt="<div style='font-weight:normal;color:blue;float:left;width:345px;text-align:center;border:1px solid silver;background:#E8EFFF;padding:8px;font-size:14px;font-family:Tahoma'>欢迎使用<span style='font-weight:bold;color:red'>手机后端数据交互</span>系统开发平台</div>";
		return $txt;
    }

}
?>