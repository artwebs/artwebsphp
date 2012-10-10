<?php

class dwzuiAction extends ActionDwzUi {

  	/**
	 * http://localhost/artwebsphp/index.php?mod=dwzui&act=layout1
	 */
	function layout1()
	{
		$initscript=<<<EOT
			$(function(){
				DWZ.init("dwz.frag.xml", {
					loginUrl:"login_dialog.html", loginTitle:"登录",	// 弹出登录对话框
			//		loginUrl:"login.html",	// 跳到登录页面
					statusCode:{ok:200, error:300, timeout:301}, //【可选】
					pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
					debug:false,	// 调试模式 【true|false】
					callback:function(){
						initEnv();
						$("#themeList").theme({themeBase:"themes"});
						$("#sidebar .toggleCollapse div").trigger("click");
					}
				});
			});
EOT;

		$initcss=<<<EOT
			#header{height:85px}
			#leftside, #container, #splitBar, #splitBarProxy{top:90px}
			#navMenu ul{float:right;}
EOT;
		$this->appendScript($initscript);
		$this->appendCss($initcss);
		$this->display();
		$txt=$this->response();
		return $txt;
	}


	/**
	 * http://localhost/artwebsphp/index.php?mod=dwzui&act=layout2
	 */
	function layout2()
	{
		$initscript=<<<EOT
			$(function(){
				DWZ.init("dwz.frag.xml", {
					loginUrl:"login_dialog.html", loginTitle:"登录",	// 弹出登录对话框
			//		loginUrl:"login.html",	// 跳到登录页面
					statusCode:{ok:200, error:300, timeout:301}, //【可选】
					pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
					debug:false,	// 调试模式 【true|false】
					callback:function(){
						initEnv();
						$("#themeList").theme({themeBase:"themes"});
						$("#sidebar .toggleCollapse div").trigger("click");
					}
				});
			});
EOT;

		$this->appendScript($initscript);
		$this->display();
		$txt=$this->response();
		return $txt;
	}
}
?>