<?php

class ClientTestModel extends Model {
    public $url;
    function ClientTestModel() {
    	parent::__construct();
    	$this->url="http://localhost:8585/PureService/services/VioQuery?wsdl";
    }
    function query(){
		$param = array(
					"in0"=>"1389b9fb8-6f6c-4438-b076-7b8d781acb60",
					"in1"=>"hphm=云AAZ678&hpzl=02&fdjh=8600&phone=13608811110",
		);
		$rs=$this->getWsClientResult('vehvioQuery2',$param);
		print_r($rs);
    }
}
?>