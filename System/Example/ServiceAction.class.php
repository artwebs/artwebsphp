<?php

class ServiceAction extends Action {
	function services(){
		$this->service_instance("violationAction");
    }
	function services_wsdl(){
		$para=array(
					array("method"=>"vehvioQuery2","vars"=>array("userkey"=>"string","phone"=>"string","hphm"=>"string","hpzl"=>"string","fdjh"=>"string"),"return"=>"string"),
					array("method"=>"vehvioQuery4","vars"=>array("userkey"=>"string","phone"=>"string"),"return"=>"string"),
					array("method"=>"vehovertimeQuery2","vars"=>array("userkey"=>"string","phone"=>"string","hphm"=>"string","hpzl"=>"string","fdjh"=>"string"),"return"=>"string"),
					array("method"=>"vehovertimeQuery4","vars"=>array("userkey"=>"string","phone"=>"string"),"return"=>"string"),

					array("method"=>"drvvioQuery2","vars"=>array("userkey"=>"string","phone"=>"string","sfzh"=>"string","xm"=>"string"),"return"=>"string"),
					array("method"=>"drvvioQuery4","vars"=>array("userkey"=>"string","phone"=>"string","sfzh"=>"string"),"return"=>"string"),
					array("method"=>"drvcodeQuery2","vars"=>array("userkey"=>"string","phone"=>"string","sfzh"=>"string","xm"=>"string"),"return"=>"string"),
					array("method"=>"drvcodeQuery4","vars"=>array("userkey"=>"string","phone"=>"string","sfzh"=>"string"),"return"=>"string")

		);


		$xml=$this->return_wsdl($para);
		echo $xml;

    }
}
?>