<?php

class WebServiceClient {
    private $ws_url="";
    private $ws_utf8="";
    private $client="";
    private $soapclient="";
    function WebServiceClient($ws_url="",$ws_utf8=false) {
		$this->ws_url=$ws_url;
		$this->ws_utf8=$ws_utf8;
    }
    public function getClient($url=""){
		if($url!="")$this->ws_url=$url;
		$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
		$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
		$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
		$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
		$this->client = new nusoap_client($this->ws_url, 'wsdl',
							$proxyhost, $proxyport, $proxyusername, $proxypassword);
		$this->client->decode_utf8=$this->ws_utf8;
    }
    public function getResult($method,$para,$url=""){
    	$this->getClient($url);
		$result=$this->client->call($method, array('parameters' => $para), '', '', false, true);
		if(!$err=$this->client->getError()){
            $rsarr=array("flag"=>"00",0=>"00","result"=>$result,1=>$result);
		}else{
            $rsarr=array("flag"=>"-1",0=>"-1","result"=>$err,1=>$err);
		}

		return $result;
    }

    public function getSoapClient($url=""){
    	if($url!="")$this->ws_url=$url;
		ini_set("soap.wsdl_cache_enabled", 0);
		set_time_limit(0);
		$this->soapclient=new SoapClient($this->ws_url,array('trace' => true));
		log_debug($this->soapclient->__getFunctions());
    }

    public function getSoapResult($method,$para,$url=""){
    	$this->getSoapClient($url);
		$result="";
		$rsarr=array();
		try {
		    $result=call_user_func_array(array($this->soapclient,$method), $para);
		} catch (SoapFault $fault){
		         log_error("Fault! code:",$fault->faultcode,", string: ",$fault->faultstring);
		}
		$rsarr=array_push_hash($rsarr,"out",$result);
		return $rsarr;
    }
}

//$para=array("in0"=>"mobile",
//            "in1"=>"mobile",
//			"in2"=>"530111198407182016",
//			"in3"=>"null",
//			"in4"=>"null",
//			"in5"=>"0",
//			"in6"=>"1000");
//$ws=new WebServiceClient("http://10.167.74.4:8080/unidata/services/UniDataService?wsdl");
//$rsarr=$ws->getResult("GetFqiDrvBaseInfo",$para);
//header("Content-Type:text/html; charset=gbk");
////print_r($rsarr);
//echo dirname(__FILE__);


//$client=new soapclient("http://10.167.74.4:8080/unidata/services/UniDataService?wsdl");
////print_r($client->__getTypes());
//print_r($client->GetFqiDrvBaseInfo($para));
?>