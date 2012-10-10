<?php

class XmlControl extends Control{
    function XmlControl($obj) {
    	parent::__construct($obj);
    }

    public function draw()
    {
    	$para=$this->ctlpara;
    	if($para['name']=='button')
    		$this->rowline=$this->obj->appendChild('button',null,$this->rowline);
    	else
    		$this->rowline=$this->obj->appendChild('row',null,$this->rowline);

    	foreach ($para as $key=>$value)
    	{
    		if(substr($key,-3)=="url")$this->obj->deal_url($value);
    		if(is_string($value))
    		if(method_exists($this,'draw'.ucwords(strtolower($key)).ucwords(strtolower($value))))
				call_user_func_array(array($this,'draw'.ucwords(strtolower($key)).ucwords(strtolower($value))),array($key,$value));
			else if(method_exists($this,'draw'.ucwords(strtolower($key))))
				call_user_func_array(array($this,'draw'.ucwords(strtolower($key))),array($key,$value));
			else
				$this->appendNode($key,$value);
    	}

    }

    public function drawConurl($key,$value)
    {
    	$para=$this->ctlpara;
    	if(in_array($para['conmethod'],C('UiItemControl')))
			$this->getUrlItems($value);
		else
			$this->appendNode($key,$value);
    }

    public function drawValue($key,$value)
    {
    	$item=$this->obj->allcache;
    	$para=$this->ctlpara;

    	if(array_key_exists($para['name'],$item))
	    	switch($para['conmethod'])
			{
				case 'MELTILINE':
					if($item[$para['name']]['dicvalue']!='')
						$value=$item[$para['name']]['dicvalue'];
					break;
				case 'TEXTBOX':
					if($item[$para['name']]['dicvalue']!='')
						$value=$item[$para['name']]['dicvalue'];
					break;
				default:
					if($item[$para['name']]['dicvalue']!='')
						$value=$item[$para['name']]['value'];
			}
		$this->appendNode($key,$value);
    }

    public function drawDicvalue($key,$value)
    {
    	$item=$this->obj->allcache;
    	$para=$this->ctlpara;
    	if(array_key_exists($para['name'],$item))
    		if($item[$para['name']]['dicvalue']!='')
				$value=$item[$para['name']]['dicvalue'];
		$this->appendNode($key,$value);
    }

    public function drawDisplayNull($key,$value)
    {
    	$item=$this->obj->allcache;
    	$para=$this->ctlpara;
		if(array_key_exists($para['name'],$item))
			if($item[$para['name']]['value']!='')
				$value='false';else $value='true';
		$this->appendNode($key,$value);
    }

    protected function appendNode($key,$value)
    {
    	$this->obj->appendChild(strtoupper($key),str_replace('&','#and',$value),$this->rowline);
    }

   	protected function getUrlItems($value)
   	{
   		$dicEmelent=$this->obj->getDicUiList($value);
		$items=$this->obj->appendChild('ITEMS','',$this->rowline);
		if($dicEmelent!=null)
		foreach($dicEmelent as $item)
		{
			$children = $item->childNodes;
			$itemNode=$this->obj->appendChild('ITEM','',$items);
			foreach($children as $child)
			{
				$newNode = $this->obj->doc->importNode($child,true);
				$itemNode->appendChild($newNode);
			}
		}
   	}



}
?>