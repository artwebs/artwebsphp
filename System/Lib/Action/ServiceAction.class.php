<?php

class ServiceAction extends Action {
	protected $wsdl;
	/**
	 *http://localhost/LHBSystem_1/index.php?services.wsdl
	 */
	function services(){
		$this->service_instance("ServiceAction");
    }

	function services_wsdl(){
		$para=array(
					array("method"=>"query","vars"=>array("userkey"=>"string","mod"=>"string","act"=>"string","var"=>"array"),"return"=>"object"),
					array("method"=>"queryjson","vars"=>array("userkey"=>"string","mod"=>"string","act"=>"string","var"=>"string"),"return"=>"string"),
		);
		$xml=$this->return_wsdl($para);
		return $xml;

    }

    function query($userkey,$model,$action,$var=array())
    {
    	if(!array_key_exists($userkey,C('WSDL_SERVER_KEY')))return flag_xml('无权访问'.$userkey,'-1',$message="");
    	if(substr($model,-5)=="Model")
    	{
    		$modelact=$model;
    		$model=substr($model,0,-5);
    	}
    	else if(substr($model,-6)=="Action")
    	{
			$modelact=$model;
    		$model=substr($model,0,-6);
    	}else
    	{
    		$modelact=$model."Action";
    	}
		$class=new ReflectionClass($modelact);
		$act=$class->newInstance();
		$act->set_model($model);
		$act->set_action($action);
		$rs=call_user_func_array(array($act,$action),$var);
		return $rs;
    }

    function queryjson($userkey,$model,$action,$var="")
    {
    	if(!array_key_exists($userkey,C('WSDL_SERVER_KEY')))return flag_xml('无权访问_'.$userkey,'-1',$message="");
		if($var=="")
			$var=array();
		else
			$var=json_decode($var,true);
		$rs=$this->query($userkey,$model,$action,$var);
		$rs_string=json_encode($rs);
		return $rs_string;
    }
}
?>