<?php

class XmlUiDefault extends XmlUiObj{
     function draw()
     {
     	$this->content_center->setAttribute('style','padding:10px');
     	$this->content_center->nodeValue="欢迎使用";
     	$this->displayEast();
     }

     function getData(){}

     function displayEast()
     {
     	$textarea=$this->appendChild('textarea','',$this->content_east);
		$textarea->setAttribute('style','width:350px;height:350px');
		$textarea->nodeValue=$this->docXmlString;
     }
}
?>