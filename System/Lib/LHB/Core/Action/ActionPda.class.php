<?php

class ActionPda extends Action {
	protected $tpl=null;
	protected $tplpart=null;
	public function __construct($modobject=null)
	{
		parent::__construct($modobject);
		$this->tpl_instance();
	}

	function tpl_instance($tpl=null)
	{
		if($tpl==null)$tpl=$this->action;
		$this->tpl=TMPL_PATH.'default/'.$this->model.'/'.$tpl.C('TMPL_TEMPLATE_SUFFIX');
	}


	function setTpl($tpl){
		if($this->tpl==null)$this->tpl=LHB_PATH.'/Tpl/pda_tpl/'.$tpl.C('TMPL_TEMPLATE_SUFFIX');
	}

	function setTplpart($tpl){
		if($this->tplpart==null)$this->tplpart=LHB_PATH.'/Tpl/pda_tpl/'.$tpl.C('TMPL_TEMPLATE_SUFFIX');
	}


	/**
	 *$para=array('return'=>'00','returnflag'=>'成功','message'=>'成功')
	 */
	function pda_rs($para=array(),$args=array()){
		$this->setTpl("pda_return");
		if(!array_key_exists("return",$para))array_push_hash($para,"return","00");
		if(!array_key_exists("returnflag",$para))array_push_hash($para,"returnflag","提交成功");
		if(!array_key_exists("message",$para))array_push_hash($para,"message",false);

		$this->smarty->assign("para",$para);
	}

	/**
	 *$para=array('xm'=>'姓名','xb'=>'性别','nl'=>'年龄')
	 *
	 */
	function pda_info($rows,$para,$args=array()){
		$this->get_para($para);
		$this->createArgsElement($args);
		$this->setTpl("pda_info");
		$this->smarty->assign("count",count($rows));
		$this->smarty->assign("return","00");
		$this->smarty->assign("rows",$rows);
		$this->smarty->assign("para",$para);
		$this->smarty->assignByRef("self",$this);
		$this->smarty->assign("session",null);
	}

	/**
	 *$para=array('xm'=>'姓名','xb'=>'性别','nl'=>'年龄')
	 *
	 */
	function pda_sessioninfo($inarr=array()){
		$rows=array();
		$para=array();
		$separa=array();
		$args=array();

		if(array_key_exists("rows",$inarr))$rows=$inarr["rows"];
		if(array_key_exists("para",$inarr))$para=$inarr["para"];
		if(array_key_exists("separa",$inarr))$separa=$inarr["separa"];
		if(array_key_exists("args",$inarr))$args=$inarr["args"];
		$this->createArgsElement($args);
		$this->get_para($para);
		$this->setTpl("pda_info");
		$this->smarty->assign("count",count($rows));
		$this->smarty->assign("return","00");
		$this->smarty->assign("rows",$rows);
		$this->smarty->assign("para",$para);
		$this->smarty->assignByRef('self',$this);
		$this->setSessionContent($rows,$separa);
		$filename=$this->setSession();
		$this->smarty->assign("session",$filename);
	}


	function pda_list($rows,$para,$args=array()){
		$this->get_para($para);
		$this->get_singlelist($rows,$para,$args);
		$this->setTpl("pda_list");
		$this->smarty->assign("count",count($rows));
		$this->smarty->assign("return","00");
		$this->smarty->assign("rows",$rows);
		$this->smarty->assign("para",$para);
	}

	function pda_diclist($rows,$para,$args=array()){
		$this->get_para($para);
		array_push_hash($args,'type','dic');
		$this->get_singlelist($rows,$para,$args);
		$this->setTpl("pda_list");
		$this->smarty->assign("count",count($rows));
		$this->smarty->assign("return","00");
		$this->smarty->assign("rows",$rows);
		$this->smarty->assign("para",$para);
	}

	function pda_pagelist($rows,$para,$args=array()){
		$this->get_para($para);
		$this->get_singlelist($rows["page_rows"],$para,$args);
		$this->setTpl("pda_list");
		$this->smarty->assign("count",$rows["page_count"]);
		$this->smarty->assign("return","00");
		$this->smarty->assign("rows",$rows["page_rows"]);
		$this->smarty->assign("para",$para);
	}


	function pda_ui($para,$args=array()){
		$this->get_dealui($para);
		$this->setTpl("pda_ui");
		$this->smarty->assign("count",'0');
		$this->smarty->assign("return","00");
		$this->smarty->assign("para",$para);
	}

	function pda_pageui($para,$args=array()){

		$this->setTpl("pda_pageui");
		$this->setTplpart('pda_pageui_part');
		$this->smarty->assign("count",'0');
		$this->smarty->assign("return","00");

		$content="";
		foreach($para as $item){
			$content.="<value>";
			$this->get_dealui($item);
			$this->smarty->assign("para",$item);
			$content.=$this->smarty->display($this->tplpart);
			$content.="</value>";
		}

	}

	public function createArgsElement($args)
	{
		$argsstr="";
		foreach($args as $key=>$value)
		{
			if(!in_array($key,C('XMLDEFAULTFIELD')))
			{

				$argsstr.="<".$key.">".$value."</".$key.">";
			}
		}
		$this->smarty->assign("args",$argsstr);
		if(array_key_exists("dicobject",$args))$this->dicobject=$args['dicobject'];
	}


	public function response()
	{
		if($this->tplpart!=null)
		{
			$content=$this->smarty->display($this->tplpart);
			$this->smarty->assign('part',$content);
			$this->tplpart=null;
		}
		$content=$this->smarty->display($this->tpl);
		$this->tpl=null;
		return $content;
	}

}
?>