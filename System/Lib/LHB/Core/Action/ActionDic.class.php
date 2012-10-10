<?php

class ActionDic extends ActionXml {
	protected $dicmodel;
    function ActionDic($dicmodel="") {
    	parent::__construct();
    	if($dicmodel!="")$this->dicmodel=$dicmodel;
    }
    function diclist($groupname=""){
    	SR($groupname,"groupname");
    	$para=array("first"=>"[DICVALUE]","second"=>"[DICKEY]","findkey"=>"[DICVALUE]");
		$rows=$this->dicmodel->diclist($groupname);
		$this->xml_list($rows,$para);
		$xml=$this->response();
		return $xml;
    }
}
?>