<?php

class XmlUiFlag extends XmlUiObj{
     function draw()
     {
     	$this->content_center->setAttribute('style','padding:10px');
     	$this->content_center->nodeValue="欢迎使用";
     	$this->displayEast();
     }

     function getData(){
		array_push_hash($this->data,'code',"00");
		array_push_hash($this->data,'message',"成功");
     }

     function displayEast()
     {
     	$textarea=$this->appendChild('textarea','',$this->content_east);
		$textarea->setAttribute('style','width:350px;height:350px');
		$textarea->nodeValue=$this->docXmlString;
     }
}
?>