<?php

class ManageAction extends Action {

    function index() {
		if(R("username")=="test"&&R("userpwd")=="123")
		session_set("username",R("username"));
		send_dir("index.php?mod=Manage&act=content");
		return "";
    }

    function content(){
		$txt="有权访问<a href='index.php?mod=Manage&act=loginout'>退出</a>";
		return $txt;
    }

    function loginout(){
		session_del();
		send_dir('index.php?mod=page&act=login');
    }
}
?>