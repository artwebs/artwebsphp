<?php

class pageAction extends ActionPage {
	/**
	 *http://localhost/artwebsphp/index.php?mod=page&act=index
	 */
	function index()
	{
		$txt="你好";
//		$txt=$this->display("login");

		return $txt;
	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=page&act=login
	 */
	function login(){
		$txt="你好";
		$txt=$this->display();
		$txt=$this->response();
		return $txt;
	}


	/**
	 *http://localhost/artwebsphp/index.php?mod=page&act=content
	 */
	function content(){
		$txt="你好";
		$this->assign_js('alert',"page.content1.js");
		$this->display();
		$txt=$this->response();
		return $txt;
	}

	/**
	 * http://localhost/artwebsphp/index.php?mod=page&act=accordion
	 */
	function accordion()
	{
		$this->display();
		$txt=$this->response();
		return $txt;
	}


	/**
	 * http://localhost/artwebsphp/index.php?mod=page&act=Tabs
	 */
	function Tabs()
	{
		$this->display();
		$txt=$this->response();
		return $txt;
	}

	/**
	 * http://localhost/artwebsphp/index.php?mod=page&act=dialog
	 */
	function dialog()
	{
		$this->display();
		$txt=$this->response();
		return $txt;
	}

	/**
	 * http://localhost/artwebsphp/index.php?mod=page&act=tree
	 */
	function tree()
	{
		$this->include_tree();
		$this->display();
		$txt=$this->response();
		return $txt;
	}

	function tree2()
	{
		$data='[{"id":"0","text":"中国","value":"86","showcheck":false,"isexpand":true,"checkstate":0,"hasChildren":true,"ChildNodes":[{"id":"1","text":"北京","value":"11","showcheck":true,"isexpand":false,"checkstate":0,"hasChildren":false,"ChildNodes":null,"complete":false}],"complete":false}]';
		return  $data;
	}


}
?>