<?php

class ActionXmlNode extends ActionXml {


	public function __construct()
	{
    	parent::__construct();
    	$this->getSession();
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
		$this->setInfoSession($rows,$separa);
	}

	function xml_ui($para,$args=array())
	{
		$this->xmlinstance();
		$this->setAttributebyName('type','form');
		$this->appendChild("count",'0');
		$this->appendChild("return","00");
		$this->createArgsElement($args);
		$this->getAllCache();
		foreach($para as $row)
		{
			$ctl=new XmlControl($this);
			$ctl->setContolePara($row);
			$ctl->draw();
		}

	}

	function xml_dataui($inarr=array())
	{
		$rows=array();
		$para=array();
		$separa=array();
		$args=array();

		if(array_key_exists("rows",$inarr))$rows=$inarr["rows"];
		if(array_key_exists("para",$inarr))$para=$inarr["para"];
		if(array_key_exists("separa",$inarr))$separa=$inarr["separa"];
		if(array_key_exists("args",$inarr))$args=$inarr["args"];

		$this->xmlinstance();
		$this->setAttributebyName('type','form');
		$this->appendChild("count",'0');
		$this->appendChild("return","00");
		$this->createArgsElement($args);
		$this->setInfoSession($rows,$separa);
		$this->getAllCache();
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
		$this->setAttributebyName('type','pageform');
		$this->appendChild("count",'0');
		$this->appendChild("return","00");
		$this->createArgsElement($args);
		$this->getAllCache();
		foreach ($para as $item)
		{
			$valueline=$this->appendChild('value',null);
			foreach($item as $row=>$rowvalue)
			{
				if(is_string($rowvalue))
				{
					$this->appendChild($row,$rowvalue,$valueline);
					continue;
				}
				$ctl=new XmlControl($this);
				$ctl->setContolePara($rowvalue,$valueline);
				$ctl->draw();
			}
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
	function xml_pagedataui($inarr=array())
	{
		$rows=array();
		$para=array();
		$separa=array();
		$args=array();

		if(array_key_exists("rows",$inarr))$rows=$inarr["rows"];
		if(array_key_exists("para",$inarr))$para=$inarr["para"];
		if(array_key_exists("separa",$inarr))$separa=$inarr["separa"];
		if(array_key_exists("args",$inarr))$args=$inarr["args"];

		$this->xmlinstance();
		$this->setAttributebyName('type','pageform');
		$this->appendChild("count",'0');
		$this->appendChild("return","00");
		$this->createArgsElement($args);
		$this->setInfoSession($rows,$separa);
		$this->getAllCache();
		foreach ($para as $item)
		{
			$valueline=$this->appendChild('value',null);
			foreach($item as $row=>$rowvalue)
			{
				if(is_string($rowvalue))
				{
					$this->appendChild($row,$rowvalue,$valueline);
					continue;
				}
				$ctl=new XmlControl($this);
				$ctl->setContolePara($rowvalue,$valueline);
				$ctl->draw();
			}

		}
	}






	public function setSession()
	{
		switch(C('SESSIONTYPE'))
		{
			case 'FILE':
			$filename='session'.date('YmdHis').(microtime()*1000000);
			$part=$this->arrayTostring($this->session);
			create_runtime($part,$filename,'/Runtime/Cache/session'.date('Ymd'));
			$this->appendChild('session',$filename);
			break;
			case 'PART':
			$session=$this->appendChild('truevalue');
			foreach($this->session as $rkey=>$rvalue)
			{
				$rowline=$this->appendChild('row',null,$session);
				$this->appendChild('name',$rkey,$rowline);
				$this->appendChild('value',$rvalue['value'],$rowline);
				$this->appendChild('dicvalue',$rvalue['dicvalue'],$rowline);
			}
			break;
		}

	}




	public  function getSession()
	{
		$filename=R('session');
		if($filename!='')
		$this->session=get_runtime($filename,'/Runtime/Cache/'.substr($filename,0,15));
	}

}
?>