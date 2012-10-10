<?php

class ActionXml extends Action {
	protected $doc ;
	protected $root;
	protected $return;
	protected $count;
	protected $returnflag;

	public function __construct()
	{
    	parent::__construct();
    }

	/**
	 *
	 */
	function xml_crs($return='00',$returnflag='正常',$message='')
	{
		$para=array('return'=>$return,'returnflag'=>$returnflag,'message'=>$message);
		$this->xml_rs($para);
	}

	/**
	 *$para=array('return'=>'00','returnflag'=>'成功','message'=>'成功')
	 */
	function xml_rs($para=array(),$args=array())
	{
		$this->xmlinstance();
		$this->setAttributebyName('type','flag');
		if(!array_key_exists("count",$para))array_push_hash($para,"count","0");
		if(!array_key_exists("return",$para))array_push_hash($para,"return","00");
		if(!array_key_exists("returnflag",$para))array_push_hash($para,"returnflag","提交成功");
		$this->createArgsElement($args);
		foreach ($para as $key=>$value)
		{
			$this->appendChild($key,$value);
		}
	}

	function xml_return($code='00',$return='成功',$message='',$args=array())
	{
		$para=array('return'=>$code,'returnflag'=>$return,'message'=>$message);
		$this->xml_rs($para,$args);
		return $this->response();
	}

	function xml_info($rows,$para,$args=array())
	{
		$this->xmlinstance();
		$this->setAttributebyName('type','info');
		$this->get_para($para);
		if(array_key_exists("rowsonlyone",$args))
		{
			if($args["rowsonlyone"]==true&&count($rows)>0)$rows=array($rows[count($rows)-1]);
		}
		$this->appendChild("count",count($rows).'');
		$this->appendChild("return","00");
		$this->createArgsElement($args);
		$value=$this->appendChild("value");

		foreach($rows as $row)
		{
			$rowtext="";
			foreach ($para as $ename=>$cname)
			{
				$txt=$this->get_row_value($row,$ename);
				$txt=$this->dic_out($ename,$txt,$row);
				$rowtext.="【".$cname."】".$txt."\n";
			}
			$this->appendChild("row",$rowtext,$value);
		}

	}

	function xml_sessioninfo($inarr=array())
	{
		$rows=array();
		$para=array();
		$separa=array();
		$args=array();
		if(array_key_exists("rows",$inarr))$rows=$inarr["rows"];
		if(array_key_exists("para",$inarr))$para=$inarr["para"];
		if(array_key_exists("separa",$inarr))$separa=$inarr["separa"];
		if(array_key_exists("args",$inarr))$args=$inarr["args"];
		$this->xml_info($rows,$para,$args);
		$this->setAttributebyName('type','sessioninfo');
		if((count($rows)>0&&count($separa)>0)){
			$session=$this->appendChild('truevalue');
			$s=$rows[0];
			foreach($separa as $key=>$value){
				$oivalue="";
				$dicvalue="";
				if(preg_match("/\./i",$key)>0)
				{
					$keyarr=explode(".",$key);
					preg_match_all("/\[(\w+?)\]/i",$value,$farr);
					$dicvalue=$oivalue=$value;
					for($j=0;$j<count($farr[1]);$j++){
						$tempvalue=$s[$farr[1][$j]];
						$tempdicvalue=$tempvalue;
						$tempdicvalue=$this->dic_out($farr[1][$j],$tempdicvalue);

						switch($farr[1]){
							case "value":
								$tempdicvalue=$tempvalue;
								break;
							case "dicvalue":
								$tempvalue=$tempdicvalue;
								break;
						}
						$dicvalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempdicvalue,$dicvalue);
						$oivalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempvalue,$oivalue);
					}

				}else{
					preg_match_all("/\[(\w+?)\]/i",$value,$farr);
					$dicvalue=$oivalue=$value;
					for($j=0;$j<count($farr[1]);$j++){
						$tempdicvalue=$tempvalue=$s[$farr[1][$j]];
						$tempdicvalue=$this->dic_out($farr[1][$j],$tempdicvalue);
						$dicvalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempdicvalue,$dicvalue);
						$oivalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempvalue,$oivalue);

					}
				}
				$rowline=$this->appendChild('row',null,$session);
				$this->appendChild('name',$key,$rowline);
				$this->appendChild('value',$oivalue,$rowline);
				$this->appendChild('dicvalue',$dicvalue,$rowline);
			}


		}
	}

	function xml_list($rows,$para,$args=array())
	{
		$this->xmlinstance();
		$this->setAttributebyName('type','list');
		$this->appendChild("count",count($rows).'');
		$this->appendChild("return","00");
		$this->createArgsElement($args);
		$this->get_para($para);
		$this->get_singlelist($rows,$para,$args);
		$value=$this->appendChild("value");
		foreach($rows as $row)
		{
			$rowline=$this->appendChild('row',null,$value);
			foreach($row as $key=>$keyvalue)
			{
				$this->appendChild($key,$keyvalue,$rowline);
			}
		}
	}

	function xml_diclist($rows,$para,$args=array())
	{
		$this->xmlinstance();
		$this->setAttributebyName('type','diclist');
		array_push_hash($args,'type','dic');
		$this->xml_list($rows,$para,$args);

	}

	function xml_pagelist($rows,$para,$args=array())
	{
		$this->xmlinstance();
		$this->setAttributebyName('type','pagelist');
		$this->get_para($para);
		$currentrows=$rows["page_rows"];
		$this->appendChild("count",$rows["page_count"].'');
		$this->appendChild("return","00");
		$this->createArgsElement($args);
		$this->get_singlelist($currentrows,$para,$args);
		$value=$this->appendChild("value");
		foreach($currentrows as $row)
		{
			$rowline=$this->appendChild('row',null,$value);
			foreach($row as $key=>$keyvalue)
			{
				$this->appendChild($key,$keyvalue,$rowline);
			}
		}

	}


	function xml_ui($para,$args=array())
	{
		$this->xmlinstance();
		$this->setAttributebyName('type','ui');
		$this->appendChild("count",'0');
		$this->appendChild("return","00");
		$this->createArgsElement($args);
		$this->get_dealui($para);
		foreach($para as $row)
		{
			$ctl=new XmlControl($this);
			$ctl->setContolePara($row);
			$ctl->draw();
		}

	}

 /* array(
	 * 				array(	"name"=>"标题",
	 * 					array("name"=>"","cname"=>"","value"="","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	 * 					array("name"=>"","cname"=>"","value"="","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	 * 					),
	 * 				array(	"name"=>"标题",
	 * 					array("name"=>"","cname"=>"","value"="","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	 * 					array("name"=>"","cname"=>"","value"="","display"=>"","match"=>"","conmethod"=>"","conurl"=>"","readonly"=>""),
	 * 					),
	 * )
	 */
	function xml_pageui($para,$args=array())
	{
		$this->xmlinstance();
		$this->setAttributebyName('type','pageui');
		$this->appendChild("count",'0');
		$this->appendChild("return","00");
		$this->createArgsElement($args);
		foreach ($para as $item)
		{
			$valueline=$this->appendChild('value',null);
			$this->get_dealui($item);
			foreach($item as $row=>$rowvalue)
			{
				if(is_string($rowvalue))
				{
					$this->appendChild($row,$rowvalue,$valueline);
					continue;
				}
				$ctl=new XmlControl($this);
				$ctl->setContolePara($row);
				$ctl->draw();
			}

		}
	}

	/**
	 *输出数据集格式<Data>值</Data>
	 *$inarr=array("MESSAGEID"=>'短信编号',
					 "MESSAGECONTENT.string"=>"短信内容",
					 "to_char(MESSAGEINDATE,'YYYY-mm-dd hh24:mi:ss') as MESSAGEINDATE"=>"入库时间"
		);
		$m=new MessageModel();
		$w="";
		$rows=$m->getSelectResult($inarr,$w);
		$this->pda_dataI($rows,$inarr,array('efield'=>'E','cfield'=>'C','dpfield'=>''));
		$xml=$this->response();
	 */
	function xml_dataI($rows,$para,$args=array())
	{
		$this->xmlinstance();
		$this->setAttributebyName('type','datai');
		$this->get_para($para);
		$this->appendChild("count",count($rows).'');
		$this->appendChild("return","00");
		$this->createArgsElement($args);
		if(!array_key_exists("efield",$args))array_push_hash($args,"efield","Row");
		if(!array_key_exists("cfield",$args))array_push_hash($args,"cfield","Row");
		if(!array_key_exists("dpfield",$args))array_push_hash($args,"dpfield","");
		if(!array_key_exists("dfield",$args))array_push_hash($args,"dfield","Row");
		if(!array_key_exists("rfield",$args))array_push_hash($args,"rfield","Data");
		$name=$this->appendChild($args['efield']);
		$cname=$this->appendChild($args['cfield']);
		$dpfield=$args['dpfield']!=""?$this->appendChild($args['dpfield']):null;
		foreach($para as $key=>$keyvalue)
		{
			$this->appendChild($args['rfield'],$key,$name);
			$this->appendChild($args['rfield'],$keyvalue,$cname);
		}

		foreach ($rows as $row)
		{
			$rowline=$this->appendChild($args['dfield'],null,$dpfield);
			foreach($para as $key=>$keyvalue)
			{
				$this->appendChild($args['rfield'],$this->get_row_value($row,$key),$rowline);
			}
		}

	}

	/**
	 * 输出数据集格式<字段>值</字段>
	 * $inarr=array("MESSAGEID"=>'短信编号',
					 "MESSAGECONTENT.string"=>"短信内容",
					 "to_char(MESSAGEINDATE,'YYYY-mm-dd hh24:mi:ss') as MESSAGEINDATE"=>"入库时间"
		);
		$m=new MessageModel();
		$w="";
		$rows=$m->getSelectResult($inarr,$w);
		$this->pda_dataII($rows,$inarr);
		$xml=$this->response();
	 */
	function xml_dataII($rows,$para,$args=array())
	{
		$this->xmlinstance();
		$this->setAttributebyName('type','dataii');
		$this->get_para($para);
		$this->appendChild("count",count($rows).'');
		$this->appendChild("return","00");
		$this->createArgsElement($args);
		if(!array_key_exists("dpfield",$args))array_push_hash($args,"dpfield","");
		$dpfield=$args['dpfield']!=""?$this->appendChild($args['dpfield']):null;
		foreach ($rows as $row)
		{
			$rowline=$this->appendChild('Row',null,$dpfield);
			foreach($para as $key=>$keyvalue)
			{
				$this->appendChild($key,$this->get_row_value($row,$key),$rowline);
			}
		}
	}

	public function createArgsElement($args)
	{
		foreach($args as $key=>$value)
		{
			if(!in_array($key,C('XMLDEFAULTFIELD')))$this->appendChild($key,$value);
		}
		if(array_key_exists("dicobject",$args))$this->dicobject=$args['dicobject'];

	}


	public function xmlinstance($xml=null)
	{
		if($xml!=null)
		{
			$this->doc=new DOMDocument();
			$this->doc->loadXML($xml);
		}
		else
		{
			$this->doc= new DOMDocument('1.0', C("CHARSET"));
	    	$this->root = $this->doc->createElement('root');
	 		$this->doc->appendChild($this->root);
		}

	}

	function removeChild($child,$parent=null)
	{
		if($parent==null)$parent=$this->root;
		$flag=$parent->removeChild($child);
		return $flag;
	}


	/**
	 * 增加节点或节点内容
	 */
	public function appendChild($child,$text=null,$parent=null)
	{
		if($parent==null)$parent=$this->root;
		$child=$this->doc->createElement($child);
		if($text!=null)
		{
			$text = $this->doc->createTextNode($text);
			$child->appendChild($text);
		}
		$parent->appendChild($child);
		return $child;
	}

	/**
	 * 据路径添加子节点
	 */
	public function appendChildbyName($child,$text=null,$parent=null)
	{
		if($parent==null)$parent='/root';
		$element=$this->queryElement($parent);
		foreach ($element as $item)
		{
			$child=$this->doc->createElement($child);
			if($text!=null)
			{
				$text = $this->doc->createTextNode($text);
				$child->appendChild($text);
			}
			$item->appendChild($child);
		}

		return $element;
	}

	/**
	 * 据路径设置节点值
	 */

	public function setnodeValuebyName($child,$text=null,$parent=null)
	{
		if($parent==null)$parent='/root';
		$element=$this->queryElement($parent);
		foreach ($element as $item)
		{
			if($text!=null)$item->nodeValue=$text;
		}

		return $element;
	}

	/*
	 * 增加节点属性
	 */
	public function createAttribute($attr,$attrValue,$parent=null)
	{
		if($parent==null)$parent=$this->root;
		$attr=$this->doc->createAttribute($attr);
		$attrValue = $this->doc->createTextNode($attrValue);
		$parent->appendChild($attr);
		$attr->appendChild($attrValue);
	}

	/**
	 * 据路径设置创建属性值
	 */
	public function createAttributebyName($attr,$attrValue,$parent=null)
	{
		if($parent==null)$parent='/root';
		$element=$this->queryElement($parent);
		foreach ($element as $item)
		{
			$attr=$this->doc->createAttribute($attr);
			$attrValue = $this->doc->createTextNode($attrValue);
			$item->appendChild($attr);
			$attr->appendChild($attrValue);
		}
	}

	/**
	 * 据路径设置设置属性值
	 */
	public function setAttributebyName($attr,$attrValue,$parent=null)
	{
		if($parent==null)$parent='/root';
		$element=$this->queryElement($parent);
		foreach ($element as $item)
		{
			$item->setAttribute($attr,$attrValue);
		}
	}

	/*
	 * 查询节节点
	 */
	public function queryElement($element)
	{
		$xp=new domxpath($this->doc);
		$element=$xp->query($element);
		return $element;
	}


	public function response()
	{
		$rs=$this->doc->saveXML();
		return $rs;

	}


	public function setInfoSession($rows,$separa)
	{
		if((count($rows)>0&&count($separa)>0)){
			$s=$rows[0];
			foreach($separa as $key=>$value){
				$oivalue="";
				$dicvalue="";
				if(preg_match("/\./i",$key)>0)
				{
					$keyarr=explode(".",$key);
					preg_match_all("/\[(\w+?)\]/i",$value,$farr);
					$dicvalue=$value;
					$oivalue=$value;
					for($j=0;$j<count($farr[1]);$j++){
						$tempvalue=$s[$farr[1][$j]];
						$tempdicvalue=$tempvalue;
						$tempdicvalue=$this->dic_out($farr[1][$j],$tempdicvalue,$s);

						switch($farr[1]){
							case "value":
								$tempdicvalue=$tempvalue;
								break;
							case "dicvalue":
								$tempvalue=$tempdicvalue;
								break;
						}
						$dicvalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempdicvalue,$dicvalue);
						$oivalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempvalue,$oivalue);
					}

				}else{
					preg_match_all("/\[(\w+?)\]/i",$value,$farr);
					$dicvalue=$value;
					$oivalue=$value;
					for($j=0;$j<count($farr[1]);$j++){
						$tempdicvalue=$tempvalue=$s[$farr[1][$j]];
						$tempdicvalue=$this->dic_out($farr[1][$j],$tempdicvalue,$s);
						$dicvalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempdicvalue,$dicvalue);
						$oivalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempvalue,$oivalue);

					}
				}
				array_push_hash($this->session,$key,array('value'=>$oivalue,'dicvalue'=>$dicvalue));
			}
		}
	}

	public function appendRedirect($id,$text,$url)
	{
		$this->deal_url($url);
		$redirct=$this->appendChild('redirect',str_replace('&','#AND',$url));
		$redirct->setAttribute('id',$id);
		$redirct->setAttribute('text',$text);
	}



}
?>