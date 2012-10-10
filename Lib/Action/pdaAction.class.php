<?php

class pdaAction extends ActionPda {
	function pdaAction(){
		parent::__construct();
		$this->smarty_init();
	}
	/**
	 *http://localhost/artwebsphp/index.php?mod=pda&act=getreturn
	 */
	function getreturn(){
		$inarr=array("MESSAGEID"=>'短信编号',
					 "MESSAGECONTENT.string"=>"短信内容",
					 "to_char(MESSAGEINDATE,'YYYY-mm-dd hh24:mi:ss') as MESSAGEINDATE"=>"入库时间"
		);
		$m=new MessageModel();
		$w="";
//		$w="MESSAGEID='SMSOUT00000000000055'";
		$rows=$m->getSelectResult($inarr,$w);
//		$para=array("first"=>"[MESSAGEID]","py"=>"[MESSAGECONTENT]");
		$inarr=array("first.py"=>"[MESSAGECONTENT] [MESSAGEID]","second"=>"[MESSAGEID]");
		$this->pda_list($rows,$inarr);
		$txt=$this->response();
		return $txt;
	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=pda&act=get_info
	 */
	function get_info(){
		$inarr=array(
					'name'=>'姓名',
					'xb'=>'性别',
				);

		$rows=array(
					array('name'=>'李安','xb'=>'1')
				);
		$args=array('dicobject'=>array(
						'xb'=>'DicModel#dicout#性别',
					),
					'keyvalue'=>'10000'
					);
		$this->pda_info($rows,$inarr,$args);
		$txt=$this->response();
		return $txt;
	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=pda&act=get_sessioninfo
	 */
	function get_sessioninfo(){
		$inarr=array(
					'name'=>'姓名',
					'xb'=>'性别',
				);

		$rows=array(
					array('name'=>'李安','xb'=>'1')
				);
		$args=array('dicobject'=>array(
						'xb'=>'DicModel#dicout#性别',
					),
					);
		$separa=array('xb'=>'[xb]');
		$this->tpl_instance();
		$this->pda_sessioninfo(array('rows'=>$rows,'para'=>$inarr,'separa'=>$separa,'args'=>$args));
		$this->smarty->assign("count",'00');
		$txt=$this->response();
		return $txt;
	}


	/**
	 *http://localhost/artwebsphp/index.php?mod=pda&act=get_list
	 */
	function get_list(){
		$inarr=array(
					'first'=>'[name]',
					'seconc'=>'[xb]',
				);

		$rows=array(
					array('name'=>'李安','xb'=>'1'),
					array('name'=>'李宁','xb'=>'1')
				);
		$args=array('dicobject'=>array(
						'xb'=>'DicModel#dicout#性别',
					),
					);
		$this->pda_list($rows,$inarr,$args);
		$txt=$this->response();
		return $txt;
	}


	/**
	 *http://localhost/artwebsphp/index.php?mod=pda&act=getui
	 */
	function getui(){
		$para=array(
					array('name'=>'XM','cname'=>'姓名'),
					array('name'=>'XB','cname'=>'性别','conurl'=>'index.php&&'),
				);
		$this->pda_ui($para);
		$txt=$this->response();
		return $txt;
	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=pda&act=getpageui
	 */
	function getpageui(){
		$para=array(
	  				array(	"name"=>"标题",
	  					array('name'=>'button','cname'=>'提交1',"conmethod"=>"GET","conurl"=>"act=index"),
	  					),
	  				array(	"name"=>"标题1",
	  					array("name"=>"","cname"=>"","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	  					array("name"=>"","cname"=>"","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"act=index","readonly"=>"","ttt"=>'ho'),
	  					array('name'=>'button','cname'=>'提交2',"conmethod"=>"POST","conurl"=>"act=index"),
	  					),
	  			);
		$this->pda_pageui($para);
		$txt=$this->response();
		return $txt;
	}
}
?>