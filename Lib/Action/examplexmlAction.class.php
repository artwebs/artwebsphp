<?php

class examplexmlAction extends ActionXmlI {

	/**
	 * 列表查询接口
	 * 性别 sex  eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=glist&sex=1
	 * 来源 source eg:http://localhost/artwebsphp/index.php?mod=examplexml&act=glist&source=1
	 */
	function glist($sex='',$source='')
	{
		SR($sex,'sex');
		SR($source,'source');
		$inarr=array('ID'=>'人员编号','NAME'=>'姓名','GXSJ'=>'更新时间','SEX'=>'性别');
		$eg=new ExampleModel();
		$rows=$eg->users($sex,$source);
		$inarr=array("first"=>"[NAME] [SEX]\n[GXSJ]","second"=>"id=[ID],sex=[SEX].realstring");
		$args=array('dicobject'=>array(
						'SEX'=>'ExampleDModel->dicout(xb,[SEX])',
						'SOURCE'=>'ExampleDModel#dicout#xxly',
					)
				);

		$this->xml_list($rows,$inarr,$args);
		$this->appendRedirect('info','详细查询','act=info');
		$xml=$this->response();
		return$xml;
	}

	/**
	 * 列表查询接口(带搜索节点)
	 * 性别 sex  eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=gdlist&sex=1
	 * 来源 source eg:http://localhost/artwebsphp/index.php?mod=examplexml&act=gdlist&source=1
	 */
	function gdlist($sex='',$source='')
	{
		SR($sex,'sex');
		SR($source,'source');
		$inarr=array('ID'=>'人员编号','NAME'=>'姓名','GXSJ'=>'更新时间','SEX'=>'性别');
		$eg=new ExampleModel();
		$rows=$eg->users($sex,$source);
//		$inarr=array("first.findkey"=>"[NAME] [SEX]\n[GXSJ]","second"=>"[ID]");
		$inarr=array("first"=>"[NAME] [SEX]\n[GXSJ]","second"=>"[ID]","findkey"=>"[NAME] [SEX]");
		$args=array('dicobject'=>array(
						'SEX'=>'ExampleDModel#dicout#xb',
						'SOURCE'=>'ExampleDModel#dicout#xxly',
					)
				);
		$this->xml_list($rows,$inarr,$args);
		$xml=$this->response();
		return$xml;
	}

	/**
	 * 详细查询接口
	 * 传入编号 id eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=info&id=3
	 */
	function info($id='')
	{
		SR($id,'id');
		$inarr=array('ID'=>'人员编号','NAME'=>'姓名','SEX'=>'性别','SOURCE'=>'来源',
					'JLLX'=>'记录类型','COMMENTS'=>'备注','LRSJ'=>'录入时间','GXSJ'=>'更新时间');
		$eg=new ExampleModel();
		$rows=$eg->userinfo($id);
		$args=array('dicobject'=>array(
						'SEX'=>'ExampleDModel#dicout#xb',
						'SOURCE'=>'ExampleDModel#dicout#xxly',
						'JLLX'=>'ExampleDModel#dicout#jllx',
					),
					'keyvalue'=>$id
				);
		$this->xml_info($rows,$inarr,$args);
		$xml=$this->response();
		return$xml;
	}

	/**
	 * 带session的详细查询接口
	 * 传入编号 id eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=sissoninfo&id=2
	 */
	function sissoninfo($id='')
	{
		SR($id,'id');
		$inarr=array('ID'=>'人员编号','NAME'=>'姓名','SEX'=>'性别','SOURCE'=>'来源',
					'JLLX'=>'记录类型','COMMENTS'=>'备注','LRSJ'=>'录入时间','GXSJ'=>'更新时间');
		$eg=new ExampleModel();
		$rows=$eg->userinfo($id);
		$args=array('dicobject'=>array(
						'SEX'=>'ExampleDModel->composeString(xb,[SEX],[SOURCE])',
						'SOURCE'=>'ExampleDModel#dicout#xxly',
						'JLLX'=>'ExampleDModel#dicout#jllx',
					),
					'keyvalue'=>$id
				);
		$separa=array('name'=>'[NAME]','sex'=>'[SEX]');
		$this->xml_sessioninfo(array('rows'=>$rows,'para'=>$inarr,'separa'=>$separa,'args'=>$args));
		$this->setSession();
		$xml=$this->response();
		return$xml;
	}

	/**
	 * 表单界面接口
	 * 无session session eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=ui
	 * session session eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=ui&session=session20120318162222983415
	 */
	function ui()
	{
		$para=array(
					array('name'=>'name','cname'=>'姓名'),
					array('name'=>'sex','cname'=>'性别','conmethod'=>'DROPDOWNLIST','conurl'=>'mod=exampled&act=diclist&groupname=xb'),
					array('name'=>'source','cname'=>'来源','conmethod'=>'BUTTON','conurl'=>'mod=exampled&act=diclist&groupname=xxly'),
					array('name'=>'comments','cname'=>'备注','conmethod'=>'MELTILINE'),
					array('name'=>'button','cname'=>'保存',"conmethod"=>"SUBMIT","conurl"=>"act=saveData"),
				);
//		$this->appandSession('name','刘洪彬','刘洪彬');
//		$this->includeCache('user_source');
		$this->xml_ui($para);
		$xml=$this->response();
		return $xml;
	}


	/**
	 * 分页表单界面接口
	 * 无session session eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=pageui
	 * session session eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=pageui&session=session20120317005115893040
	 */
	function pageui()
	{
		$para=array(
	  				array(	"name"=>"基本信息",
	  					array('name'=>'name','cname'=>'姓名'),
						array('name'=>'sex','cname'=>'性别','conmethod'=>'DROPDOWNLIST','conurl'=>'mod=exampled&act=diclist&groupname=xb'),
						array('name'=>'source','cname'=>'来源','conmethod'=>'BUTTON','conurl'=>'mod=exampled&act=diclist&groupname=xxly'),
	  					),
	  				array(	"name"=>"备注",
	  					array('name'=>'comments','cname'=>'备注','conmethod'=>'MELTILINE'),
						array('name'=>'button','cname'=>'保存',"conmethod"=>"SUBMIT","conurl"=>"act=insert"),
	  					)
	  			);
//		$this->includeCache('runcache');
		$this->xml_pageui($para);
		$xml=$this->response();
		return $xml;

	}

	/**
	 * 表单界面接口（修改信息）
	 * 人员编号 id eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=dataui&id=1
	 */
	function dataui($id='')
	{
		SR($id,'id');
		$inarr=array('ID'=>'人员编号','NAME'=>'姓名','SEX'=>'性别','SOURCE'=>'来源',
					'JLLX'=>'记录类型','COMMENTS'=>'备注','LRSJ'=>'录入时间','GXSJ'=>'更新时间');
		$eg=new ExampleModel();
		$rows=$eg->userinfo($id);
		$args=array('dicobject'=>array(
						'SEX'=>'ExampleDModel#dicout#xb',
						'SOURCE'=>'ExampleDModel#dicout#xxly',
						'JLLX'=>'ExampleDModel#dicout#jllx',
					)
				);
		$separa=array('name'=>'[NAME]','sex'=>'[SEX]','source'=>'[SOURCE][SEX]','comments'=>'[COMMENTS]');
		$para=array(
					array('name'=>'name','cname'=>'姓名'),
					array('name'=>'sex','cname'=>'性别','conmethod'=>'DROPDOWNLIST','conurl'=>'mod=exampled&act=diclist&groupname=xb'),
					array('name'=>'source','cname'=>'来源','conmethod'=>'BUTTON','conurl'=>'mod=exampled&act=diclist&groupname=xxly'),
					array('name'=>'comments','cname'=>'备注','conmethod'=>'MELTILINE'),
					array('name'=>'button','cname'=>'保存',"conmethod"=>"SUBMIT","conurl"=>"act=save"),
				);
		$this->xml_dataui(array('rows'=>$rows,'para'=>$para,'separa'=>$separa,'args'=>$args));
		$xml=$this->response();
		return $xml;
	}


	/**
	 * 分页表单界面接口（修改信息）
	 *人员编号 id eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=pagedataui&id=1
	 */
	function pagedataui($id='')
	{
		SR($id,'id');
		$inarr=array('ID'=>'人员编号','NAME'=>'姓名','SEX'=>'性别','SOURCE'=>'来源',
					'JLLX'=>'记录类型','COMMENTS'=>'备注','LRSJ'=>'录入时间','GXSJ'=>'更新时间');
		$eg=new ExampleModel();
		$rows=$eg->userinfo($id);
		$args=array('dicobject'=>array(
						'SEX'=>'ExampleDModel#dicout#xb',
						'SOURCE'=>'ExampleDModel#dicout#xxly',
						'JLLX'=>'ExampleDModel#dicout#jllx',
					)
				);
		$separa=array('name'=>'[NAME]','sex'=>'[SEX]','source'=>'SOURCE','comments'=>'COMMENTS');
		$para=array(
	  				array(	"name"=>"基本信息",
	  					array('name'=>'name','cname'=>'姓名'),
						array('name'=>'sex','cname'=>'性别','conmethod'=>'DROPDOWNLIST','conurl'=>'mod=exampled&act=diclist&groupname=xb'),
						array('name'=>'source','cname'=>'来源','conmethod'=>'BUTTON','conurl'=>'mod=exampled&act=diclist&groupname=xxly'),
	  					),
	  				array(	"name"=>"备注",
	  					array('name'=>'comments','cname'=>'备注','conmethod'=>'MELTILINE'),
						array('name'=>'button','cname'=>'保存',"conmethod"=>"SUBMIT","conurl"=>"act=insert"),
	  					)
	  			);
		$this->xml_pagedataui(array('rows'=>$rows,'para'=>$para,'separa'=>$separa,'args'=>$args));
		$xml=$this->response();
		return $xml;

	}


	/**
	 * 返回成功接口
	 *http://localhost/artwebsphp/index.php?mod=examplexml&act=rstrue
	 */
	function rstrue()
	{

		$this->xml_crs();
		$xml=$this->response();
		return$xml;
	}

	/**
	 * 返回失败及添加其他节点接口
	 *http://localhost/artwebsphp/index.php?mod=examplexml&act=rsfalse
	 */
	function rsfalse()
	{
		$this->xml_crs('-1','错误');

		/**添加其他节点*/
		$keyvalue=$this->appendChild('keyvalue');
		$key=$this->appendChild('key','00001',$keyvalue);
		$this->createAttribute("titles", "Titles",$keyvalue);
		$this->appendChildbyName('test','5686');
		$this->createAttributebyName('test','5686','/root/test');
		$key->setAttribute('id','1');
		$key->nodeValue='12334';
		$xml=$this->response();
		return$xml;
	}


	/**
	 * 数据查询返回样式一
	 * 性别 sex  eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=dataI&sex=1
	 * 来源 source eg:http://localhost/artwebsphp/index.php?mod=examplexml&act=dataI&source=1
	 */
	function dataI($sex='',$source='')
	{
		SR($sex,'sex');
		SR($source,'source');
		$inarr=array('ID'=>'人员编号','NAME'=>'姓名','GXSJ'=>'更新时间','SEX'=>'性别');
		$eg=new ExampleModel();
		$rows=$eg->users($sex,$source);
		$this->xml_dataI($rows,$inarr,array('efield'=>'E','cfield'=>'C','dpfield'=>''));
		$xml=$this->response();
		return$xml;
	}

	/**
	 * 数据查询返回样式二
	 * 性别 sex  eg: http://localhost/artwebsphp/index.php?mod=examplexml&act=dataII&sex=1
	 * 来源 source eg:http://localhost/artwebsphp/index.php?mod=examplexml&act=dataII&source=1
	 */
	function dataII($sex='',$source='')
	{
		SR($sex,'sex');
		SR($source,'source');
		$inarr=array('ID'=>'人员编号','NAME'=>'姓名','GXSJ'=>'更新时间','SEX'=>'性别');
		$eg=new ExampleModel();
		$rows=$eg->users($sex,$source);
		$this->xml_dataII($rows,$inarr);
		$xml=$this->response();
		return$xml;
	}

	/**
	 *http://localhost/artwebsphp/index.php?mod=examplexmlI&act=saveData&login_name=user8
	 */
	function saveData()
	{
		$this->xml_rs();
		$xml=$this->response();
		return $xml;
	}

	/**
	 * 设置（获取）缓存数据
	 * http://localhost/artwebsphp/index.php?mod=examplexml&act=setcache
	 */
	function setcache()
	{
		$this->appandCache('sex','1','男');
		$this->appandCache('name','张三','张三1');
		$this->createCache('examplecache');
//		$this->includeCache('examplecache');
//		print_r($this->cache);
		return '测试';
	}


	/**
	 * 获取自己定义参数
	 * http://localhost/artwebsphp/index.php?mod=examplexml&act=getlocalconfig
	 */
	function getlocalconfig()
	{
		var_dump(selfConf('examplexml','xm'));
		//var_dump($this->getConfig());
	}

}
?>