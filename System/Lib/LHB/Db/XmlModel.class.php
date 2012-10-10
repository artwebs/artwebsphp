<?php

class XmlModel extends Xml{
    protected $url;
    protected $xml;
    public function __construct() {

    }
    public function getSelectXmlResult($inarr,$f=1,$d=2,$path="",$url=""){
		$rsarr=array();
		if($url!="")$this->url=$url;
		$rows=$this->getRowValues($f,$d,$path,$url);
		//print_r($rows);
        for($i=0;$i<count($rows);$i++){
			foreach($inarr as $key=>$value){
				$inarr[$key]=$rows[$i][$key];
			}
			//print_r($inarr);
			array_push($rsarr,$inarr);
        }
		return $rsarr;

    }
}
?>