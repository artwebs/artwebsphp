<?php

class XmlUi extends LHB {
	 private $xml;
	 private $xmlString;
	 private $html;
     public function __construct($model=null,$action=null)
     {
		parent::__construct($model,$action);
     }
     public function setDoc($doc)
     {
		$this->xml=$doc;
     }

     public function setDocString($doc)
     {
		$this->xml=new ActionXml();
		$this->xml->xmlinstance($doc);
		$this->xmlString=$doc;
     }

	 public function run($type='')
	 {
		if($type=='')
		{
			$element=$this->xml->queryElement('/root');
			foreach ($element as $item)
			{
				$type=$item->getAttribute('type');
				break;
			}

		}
		try{
			if($type=='')$type='default';
			$class=new ReflectionClass('XmlUi'.ucwords($type));
			$this->html=$class->newInstance($this->model,$this->action);
			$this->html->setDocString($this->xmlString);
			$this->html->htmlInstance(R('html'));
			$this->saveHistory();
			$rs=$this->html->response();

		}catch(Exception $e){
				log_debug($e->getMessage());
			    $rs=flag_xml($e->getMessage(),"-1");
		}
		return $rs;
	 }

	 function saveHistory()
	 {
	 	$key=$this->model."_".$this->action;
	 	$filename=C('XMLUIFILENAME');
	 	if($key==C("DEFAULT_MODULE")."_".C("DEFAULT_ACTION"))return;
	 	if($rows=get_runtime($filename))
	 	{
			if(array_key_exists($key,$rows)){
				return;
			}
	 	}
	 	$content="        '$key'=>array('text'=>'$key','id'=>'".query_url()."&html=part'),";
	 	create_runtime($content,$filename,$dir="");

	 }

}
?>