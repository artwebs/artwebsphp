<?php

class xmlAction extends ActionXml {
	/**
	 *http://localhost/LHBSystem_1/index.php?mod=xml&act=getreturn
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
	 *http://localhost/LHBSystem_1/index.php?mod=xml&act=getinfo
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
	 *http://localhost/LHBSystem_1/index.php?mod=xml&act=getsissoninfo
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
		$xml=$this->response();
		return$xml;
	}


	/**
	 *http://localhost/LHBSystem_1/index.php?mod=xml&act=getlist
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
	 *http://localhost/LHBSystem_1/index.php?mod=xml&act=getui
	 */
	function getui()
	{
		$para=array(
					array('name'=>'XM','cname'=>'姓名'),
					array('name'=>'XB','cname'=>'性别','conurl'=>'index.php&&'),
				);
		$this->xml_ui($para,array('title'=>'录入界面'));
		$xml=$this->response();
		return $xml;

	}

	/**
	 *http://localhost/LHBSystem_1/index.php?mod=xml&act=getpageui
	 */
	function getpageui()
	{
		$para=array(
	  				array(	"name"=>"标题",
	  					array("name"=>"","cname"=>"","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	  					array("name"=>"","cname"=>"","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	  					),
	  				array(	"name"=>"标题1",
	  					array("name"=>"","cname"=>"","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	  					array("name"=>"","cname"=>"","value"=>"","display"=>"","match"=>"","conmethod"=>"","conurl"=>"act=index","readonly"=>"","ttt"=>'ho'),
	  					),
	  			);

		$this->xml_pageui($para);
		$xml=$this->response();
		return $xml;

	}


	/**
	 *http://localhost/LHBSystem_1/index.php?mod=xml&act=getdataI
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
	 *http://localhost/LHBSystem_1/index.php?mod=xml&act=getdataII
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

    function query($model,$action,$var=array())
    {
    	$modelact=$model."Action";
		$class=new ReflectionClass($modelact);
		$act=$class->newInstance();
		$act->set_model($model);
		$act->set_action($action);

		$rs=call_user_func_array(array($act,$action),$var);
		return $rs;
    }

}
?>