<?php

class XmlUiInfo extends XmlUiObj{
     function draw()
     {
		$items=$this->docXml->queryElement('/root/value/row');
		$this->content_center->setAttribute('style','padding:10px');
		foreach ($items as $item)
		{
	        if($item->childNodes->length) {
	            foreach($item->childNodes as $i) {
	                $textarea=$this->appendChild('textarea','',$this->content_center);
	                $textarea->setAttribute('style','width:200px;height:350px');
					$textarea->nodeValue=$i->nodeValue;
	            }
	        }

		}

		$this->displayEast();
     }

     function getData(){}
}
?>