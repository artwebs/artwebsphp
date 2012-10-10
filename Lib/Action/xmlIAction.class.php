<?php

class xmlIAction extends ActionXmlI {
	/**
	 *http://localhost/artwebsphp/index.php?mod=xml&act=getreturn
	 */
	function getreturn()
	{

		$this->xml_rs();
//		$keyvalue=$this->appendChild('keyvalue');
//		$key=$this->appendChild('key','00001',$keyvalue);
//		$this->createAttribute("titles", "Titles",$keyvalue);
//		$this->appendChildbyName('test','5686');
//		$this->createAttributebyName('test','5686','/root/test');
//		$key->setAttribute('id','1');
//		$key->nodeValue='12334';
		$xml=$this->response();
		return$xml;
	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=xmlI&act=getinfo
	 */
	function getinfo()
	{
		$inarr=array("MESSAGEID"=>'短信编号',
					 "MESSAGECONTENT.string"=>"短信内容",
					 "to_char(MESSAGEINDATE,'YYYY-mm-dd hh24:mi:ss') as MESSAGEINDATE"=>"入库时间",
					 "TYPE"=>'信息类型',
					 "XXLY"=>'信息来源'
		);
		$m=new MessageModel();
		$w="";
//		$w="MESSAGEID='SMSOUT00000000000055'";
		$rows=$m->getSelectResult($inarr,$w);
//		$para=array("first"=>"[MESSAGEID]","py"=>"[MESSAGECONTENT]");
//		$inarr=array("first.py"=>"[MESSAGECONTENT] [MESSAGEID]","second"=>"[MESSAGEID]");
		$args=array('dicobject'=>array(
						'TYPE'=>'DicModel#dicout#信息类型',
						'XXLY'=>'DicModel#dicout#信息来源',
					),
					'keyvalue'=>'SMSOUT00000000000055'
				);
		$this->xml_info($rows,$inarr,$args);
		$xml=$this->response();
		return$xml;
	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=xmlI&act=getsissoninfo
	 */
	function getsissoninfo()
	{
		$inarr=array("MESSAGEID"=>'短信编号',
					 "MESSAGECONTENT.string"=>"短信内容",
					 "to_char(MESSAGEINDATE,'YYYY-mm-dd hh24:mi:ss') as MESSAGEINDATE"=>"入库时间",
					 "TYPE"=>'信息类型',
					 "XXLY"=>'信息来源'
		);
		$m=new MessageModel();
		$w="MESSAGEID='SMSOUT00000000000055'";
		$rows=$m->getSelectResult($inarr,$w);
		$separa=array('key'=>'[TYPE]','xxly'=>'[XXLY]');
		$args=array('dicobject'=>array(
						'TYPE'=>'DicModel#dicout#信息类型',
						'XXLY'=>'DicModel#dicout#信息来源',
					),
					'keyvalue'=>'SMSOUT00000000000055',
					'rowsonlyone'=>true,
				);
		$this->xml_sessioninfo(array('rows'=>$rows,'para'=>$inarr,'separa'=>$separa,'args'=>$args));
		$this->setSession();
		$xml=$this->response();
		return$xml;
	}


	/**
	 *http://localhost/artwebsphp/index.php?mod=xml&act=getlist
	 */
	function getlist()
	{
		$inarr=array("MESSAGEID"=>'短信编号',
					 "MESSAGECONTENT.string"=>"短信内容",
					 "to_char(MESSAGEINDATE,'YYYY-mm-dd hh24:mi:ss') as MESSAGEINDATE"=>"入库时间",
					 "TYPE"=>'信息类型',
					 "XXLY"=>'信息来源'
		);
		$m=new MessageModel();
		$w="";
//		$w="MESSAGEID='SMSOUT00000000000055'";
		$rows=$m->getSelectResult($inarr,$w);
//		$para=array("first"=>"[MESSAGEID]","py"=>"[MESSAGECONTENT]");
		$inarr=array("first"=>"[MESSAGECONTENT] [MESSAGEID] [TYPE] [XXLY]","second"=>"[MESSAGEID]");
		$dic= new DicModel();
		$args=array('dicobject'=>array(
						'TYPE'=>'DicModel#dicout#信息类型',
						'XXLY'=>'DicModel#dicout#信息来源',
					),
					'keyvalue'=>'SMSOUT00000000000055'
				);
		$this->xml_list($rows,$inarr,$args);
//		$this->xml_diclist($rows,$inarr,array('keyvalue'=>'SMSOUT00000000000055'));
		$xml=$this->response();
		return$xml;
	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=xmlI&act=getui&session=session20110602131904140820
	 */
	function getui()
	{
		$para=array(
					array('name'=>'XM','cname'=>'姓名'),
					array('name'=>'key','cname'=>'姓名'),
					array('name'=>'xxly','cname'=>'姓名'),
					array('name'=>'xb','cname'=>'性别','conmethod'=>'DROPDOWNLIST','conurl'=>'mod=Dic&act=diclist&groupname=%E6%80%A7%E5%88%AB'),
					array('name'=>'xb','cname'=>'性别','conmethod'=>'DATETIMEPICKER','conurl'=>'yyyy-MM-dd HH:mm'),
					array('name'=>'button','cname'=>'提交2',"conmethod"=>"POST","conurl"=>"act=index"),
				);
		$this->appandSession('XM','1','刘洪彬');
		$this->includeCache('runcache');
		$this->xml_ui($para);
		$xml=$this->response();
		return $xml;
	}


	/**
	 *http://localhost/artwebsphp/index.php?mod=xmlI&act=getpageui
	 */
	function getpageui()
	{
		$para=array(
	  				array(	"name"=>"标题",
	  					array("name"=>"xm","cname"=>"姓名","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	  					array("name"=>"xb","cname"=>"性别","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	  					array('name'=>'button','cname'=>'提交1',"conmethod"=>"GET","conurl"=>"act=index"),
	  					),
	  				array(	"name"=>"标题1",
	  					array("name"=>"","cname"=>"","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	  					array("name"=>"","cname"=>"","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"act=index","readonly"=>"","ttt"=>'ho'),
	  					array('name'=>'button','cname'=>'提交2',"conmethod"=>"POST","conurl"=>"act=index"),
	  					),
	  			);
		$this->includeCache('runcache');
		$this->xml_pageui($para);
		$xml=$this->response();
		return $xml;

	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=xmlI&act=getdataui
	 */
	function getdataui()
	{
		$rows=array(
					array('XM'=>'刘洪彬','XB'=>'1'),
				);
		$separa=array('xm'=>'[XM]','xb'=>'[XB]');
		$args=array('dicobject'=>array(
						'TYPE'=>'DicModel#dicout#信息类型',
						'XXLX'=>'DicModel#dicout#信息来源',
						'XB'=>'DicModel#dicout#xb',
					)
				);
		$para=array(
					array('name'=>'XM','cname'=>'姓名'),
					array('name'=>'key','cname'=>'姓名'),
					array('name'=>'xxly','cname'=>'姓名'),
					array('name'=>'xb','cname'=>'性别','conmethod'=>'DROPDOWNLIST','conurl'=>'mod=Dic&act=diclist&groupname=xb'),
					array('name'=>'xb','cname'=>'性别','conmethod'=>'DATETIMEPICKER','conurl'=>'yyyy-MM-dd HH:mm'),
					array('name'=>'button','cname'=>'提交2',"conmethod"=>"POST","conurl"=>"act=index"),
				);
		$this->xml_dataui(array('rows'=>$rows,'para'=>$para,'separa'=>$separa,'args'=>$args));
		$xml=$this->response();
		return $xml;

	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=xmlI&act=getpagedataui
	 */
	function getpagedataui()
	{
		$rows=array(
					array('XM'=>'刘洪彬','XB'=>'1'),
				);
		$separa=array('xm'=>'[XM]','xb'=>'[XB]');
		$args=array('dicobject'=>array(
						'TYPE'=>'DicModel#dicout#信息类型',
						'XXLX'=>'DicModel#dicout#信息来源',
						'XB'=>'DicModel#dicout#性别',
					)
				);
		$para=array(
	  				array(	"name"=>"标题",
	  					array("name"=>"xm","cname"=>"姓名","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	  					array("name"=>"xb","cname"=>"性别","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	  					array('name'=>'button','cname'=>'提交1',"conmethod"=>"GET","conurl"=>"act=index"),
	  					),
	  				array(	"name"=>"标题1",
	  					array("name"=>"","cname"=>"","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	  					array("name"=>"","cname"=>"","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"act=index","readonly"=>"","ttt"=>'ho'),
	  					array('name'=>'button','cname'=>'提交2',"conmethod"=>"POST","conurl"=>"act=index"),
	  					),
	  			);
		$this->xml_pagedataui(array('rows'=>$rows,'para'=>$para,'separa'=>$separa,'args'=>$args));
		$xml=$this->response();
		return $xml;

	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=xmlI&act=saveData&login_name=user8
	 */
	function saveData()
	{
		$this->xml_rs();
		$xml=$this->response();
		return $xml;
	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=xml&act=getdataI
	 */
	function getdataI()
	{
		$inarr=array("MESSAGEID"=>'短信编号',
					 "MESSAGECONTENT.string"=>"短信内容",
					 "to_char(MESSAGEINDATE,'YYYY-mm-dd hh24:mi:ss') as MESSAGEINDATE"=>"入库时间"
		);
		$m=new MessageModel();
		$w="";
		$rows=$m->getSelectResult($inarr,$w);
		$this->xml_dataI($rows,$inarr,array('efield'=>'E','cfield'=>'C','dpfield'=>''));
		$xml=$this->response();
		return$xml;
	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=xml&act=getdataII
	 */
	function getdataII()
	{
		$inarr=array("MESSAGEID"=>'短信编号',
					 "MESSAGECONTENT.string"=>"短信内容",
					 "to_char(MESSAGEINDATE,'YYYY-mm-dd hh24:mi:ss') as MESSAGEINDATE"=>"入库时间"
		);
		$m=new MessageModel();
		$w="";
		$rows=$m->getSelectResult($inarr,$w);
		$this->xml_dataII($rows,$inarr);
		$xml=$this->response();
		return$xml;
	}


	/**
	 * http://localhost/artwebsphp/index.php?mod=xmlI&act=runcache
	 */
	function runcache()
	{
		$this->appandCache('xb','1','男');
		$this->appandCache('xm','张三','张三1');
		$this->createCache('runcache');
//		$this->includeCache('runcache');
//		print_r($this->cache);
		return '测试';
	}

	/**
	 * http://localhost/artwebsphp/index.php?mod=xmlI&act=getlocalconfig
	 */
	function getlocalconfig()
	{
		var_dump($this->getConfig());
	}

	/**
	 * http://localhost/artwebsphp/index.php?mod=xmlI&act=rs
	 */
	function rs()
	{
		return $this->xml_return();
	}



}
?>