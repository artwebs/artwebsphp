<?php

class WebServiceServer {
	private	$server;

    function WebServiceServer() {
		$this->server = new soap_server;
    }
	function addMethod($method){
		$this->server->register($method,array("str1"=>"xsd:string","str2"=>"xsd:string",array("return"=>"xsd:string")));
	}
	function display(){
		$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
		$soap->service($HTTP_RAW_POST_DATA);

	}
}
?>