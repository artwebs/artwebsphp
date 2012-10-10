<?php

class Action extends LHB {
	private $wsserver;
	protected $smarty;
	protected $dicobject=array();
	protected $session=array();
	protected $redirect=array();
	protected $cache=array();
	protected $allcache=array();
	protected $modobject=null;
	protected $templateFile=null;


	protected $wsdl;
	protected $severmodel;
	protected $queryvar=array();
	protected $userkey;


    public function __construct($modobject=null,$model=null,$action=null) {
    	parent::__construct($model,$action);
    	$this->wsserver=new WebServiceServer();
    	if(C('CHARSET_FLAG'))header("Content-Type:text/html; charset=".C("CHARSET"));
		$this->smarty_init();
		if($modobject!=null)
		{
			$this->model=$modobject->model;
			$this->action=$modobject->action;
		}
    }



    public function smarty_init(){
		require_once(LHB_PATH.'/Vendor/Smarty/Smarty.class.php');
		$this->smarty = new Smarty(); //建立smarty实例对象$smarty
		$this->smarty->template_dir =TMPL_PATH.'/default/'.$this->model.'/';
		$this->smarty->compile_dir =  APP_PATH.'/Tpl_c/';
		$this->smarty->config_dir = APP_PATH.'/Conf/';
		$this->smarty->cache_dir = APP_PATH.'/Runtime/Cache/';
		$this->smarty->caching = C("SMARTY_CACHE");
		$this->smarty->left_delimiter=C('TMPL_L_DELIM');
		$this->smarty->right_delimiter=C('TMPL_R_DELIM');
		spl_autoload_register("__autoload");

    }
    public function assign($name,$value=''){
		$this->smarty->assign($name,$value);
    }
    public function display($templateFile=''){
    	 if(''==$templateFile) {
            // 如果模板文件名为空 按照默认规则定位
            $templateFile = TMPL_PATH.'default/'.$this->model.'/'.$this->action.C('TMPL_TEMPLATE_SUFFIX');

        }elseif(strpos($templateFile,':')){
            // 引入其它模块的操作模板
            $templateFile   =   TMPL_PATH.'default/'.str_replace(':','/',$templateFile).C('TMPL_TEMPLATE_SUFFIX');
        }elseif(!is_file($templateFile))    {
            // 引入当前模块的其它操作模板
            $templateFile =  TMPL_PATH.'default/'.$this->model.'/'.$templateFile.C('TMPL_TEMPLATE_SUFFIX');
        }
        $this->templateFile=$templateFile;
    }

	/*
	 * 添加webservice接口方法
	 */
	public function wsAddMethod($method){
		$this->wsserver->addMethod($method);
	}

	/**
	 * 显示webservice结果
	 */
	public function wsDisplay(){
		$this->wsserver->display();
	}

	/**
	 * 初始化webservice服务
	 * $this->service_instance("IndexAction");
	 */
	function service_instance($class){
		$soap = new SoapServer(http_root()."?".$this->action.".wsdl");
		$soap->setClass($class);
//		$soap->__construct();
		$soap->handle();
	}

	/**
	 * 过滤过多的配置参数
	 */
	function get_para(&$para){
		$rs=array();
		foreach($para as $key=>$value){
				 if(preg_match("/\s+as\s+/i",$key)>0){
					$farr=array();
					preg_match_all("/\s+as\s+(\w+)/i",$key,$farr);
					array_push_hash($rs,$farr[1][0],$value);
				}else if(preg_match("/\./i",$key)>0){
					$keyarr=explode(".",$key);
					array_push_hash($rs,$keyarr[0],$value);
					if($keyarr[1]=='findkey')array_push_hash($rs,'findkey',$value);

				}else{
					array_push_hash($rs,$key,$value);
				}
		}
		$para=$rs;
	}

	/**
	 * 获取单行列表值
	 */

	function get_singlelist(&$rows,$para,$args=array()){
		$rs=array();
		if(array_key_exists('type',$args)){
			if(!array_key_exists('findkey',$para)&&$args['type']=='dic'){
				foreach($para as $key=>$value){
					array_push_hash($para,'findkey',$value);
					break;
				}
			}
		}
		for($i=0;$i<count($rows);$i++){
			$s=$rows[$i];
			$rsrow=array();
			foreach($para as $key=>$value){
				preg_match_all("/\[(\w+?)\]\.realstring/i",$value,$farr);
				for($j=0;$j<count($farr[1]);$j++){
					$txt=$s[$farr[1][$j]];
					$value=preg_replace("/\[".$farr[1][$j]."\]\.realstring/i",$txt,$value);

				}

				preg_match_all("/\[(\w+?)\]/i",$value,$farr);
				for($j=0;$j<count($farr[1]);$j++){
					$txt=$s[$farr[1][$j]];
					$txt=$this->dic_out($farr[1][$j],$txt,$s);
					$value=preg_replace("/\[".$farr[1][$j]."\]/i",$txt,$value);

				}
				$rsrow[$key]=$key=="findkey"?strtolower(initspell($value)):$value;
			}
			$rs[]=$rsrow;
		}
		$rows=$rs;
	}

	function get_dealui(&$para){
		foreach($para as $key=>$value){
			if(is_string($value))continue;
			if(!array_key_exists("name",$para[$key]))array_push_hash($para[$key],'name','');
        	if(!array_key_exists("cname",$para[$key]))array_push_hash($para[$key],'cname','');
        	if(!array_key_exists("value",$para[$key]))array_push_hash($para[$key],'value','');
        	if(!array_key_exists("display",$para[$key]))array_push_hash($para[$key],'display',"true");
        	if(!array_key_exists("matche",$para[$key]))array_push_hash($para[$key],'matche','');
        	if(!array_key_exists("conmethod",$para[$key]))array_push_hash($para[$key],'conmethod','TEXTBOX');
        	if(!array_key_exists("conurl",$para[$key]))array_push_hash($para[$key],'conurl','');
        	if(!array_key_exists("readonly",$para[$key]))array_push_hash($para[$key],'readonly',false);
        	if(!array_key_exists("dicvalue",$para[$key]))array_push_hash($para[$key],'dicvalue','');
        	if(!array_key_exists("nexturl",$para[$key]))array_push_hash($para[$key],'nexturl',false);
        	if(!array_key_exists("checkboxurl",$para[$key]))array_push_hash($para[$key],'checkboxurl',false);
        	if(!array_key_exists("getvalue",$para[$key]))array_push_hash($para[$key],'getvalue',false);
        	if(!array_key_exists("maxcount",$para[$key]))array_push_hash($para[$key],'maxcount',false);
		}
	}



	function deal_url(&$url)
	{
		if(preg_match("/[^\w]*".C("OPER_ACTION")."=\w+/i",$url)>0)
		if($url!=""&&preg_match("/index\.php\?/i",$url)==0){
			$url=$_SERVER["PHP_SELF"]."?".(substr($url,0)=="&"?"1=1".$url:$url);
			if(preg_match("/[^\w]*".C("OPER_MODULE")."=\w+/i",$url)==0)$url.=(substr($url,-1)=="?"?"":"&").C("OPER_MODULE")."=".$this->model;
		}


	}

	public function get_row_value($row,$key)
	{
		$rs="";
		if($row!=null)$rs=array_key_exists($key,$row)?$row[$key]:'';
		return $rs;
	}

	public function get_dicout($args,$key,&$value)
	{

	}

	/**
	 * 输出wsdl
	 * $para=array(
					array("method"=>"add","vars"=>array("x"=>"string","y"=>"string"),"return"=>"array"),
					array("method"=>"sub","vars"=>array("x"=>"string","y"=>"string"),"return"=>"string"),
		);
		$xml=$this->return_wsdl($para);
	 */
	public function return_wsdl($para,$class="",$namespace="",$encodingStyle="http://schemas.xmlsoap.org/soap/encoding/",$use="encoded"){
		$address=http_root()."?".str_replace("_wsdl","",$this->action).".wd";
		if($class=="")$class=C("WSDL_ClassName");
		if($namespace=="")$namespace=C("WSDL_NameSpace");
		$message="";
		$portType="";
		$binding="";
		$service="";

		$portType.="<wsdl:portType name=\"".$class."\">";

		$binding.="<wsdl:binding name=\"".$class."SOAP\" type=\"tns:".$class."\">";
		$binding.="<soap:binding style=\"rpc\" transport=\"http://schemas.xmlsoap.org/soap/http\"/>";

		$service.="<wsdl:service name=\"".$class."\">";
		$service.="<wsdl:port binding=\"tns:".$class."SOAP\" name=\"".$class."SOAP\">";
		$service.="<soap:address location=\"".$address."\"/>";
		$service.="</wsdl:port>";
		$service.="</wsdl:service>";
		if($encodingStyle!="")$encodingStyle="encodingStyle=\"".$encodingStyle."\"";
		for($i=0;$i<count($para);$i++){
			$message.="<wsdl:message name=\"".$para[$i]["method"]."\">";
			foreach($para[$i]["vars"] as $key=>$value){
					$message.="<wsdl:part name=\"".$key."\" type=\"xsd:".$value."\"/>";
			}
			$message.="</wsdl:message>";
			$message.="<wsdl:message name=\"".$para[$i]["method"]."Response\">";
			$message.="<wsdl:part name=\"".$para[$i]["method"]."Response\" type=\"xsd:".$para[$i]["return"]."\"/>";
			$message.="</wsdl:message>";

			$portType.="<wsdl:operation name=\"".$para[$i]["method"]."\">";
			$portType.="<wsdl:input message=\"tns:".$para[$i]["method"]."\"/>";
			$portType.="<wsdl:output message=\"tns:".$para[$i]["method"]."Response\"/>";
			$portType.="</wsdl:operation>";

			$binding.="<wsdl:operation name=\"".$para[$i]["method"]."\">";
			$binding.="<soap:operation soapAction=\"".$namespace."\"/>";
			$binding.="<wsdl:input>";
			$binding.="<soap:body $encodingStyle namespace=\"".$namespace."\" use=\"".$use."\"/>";
			$binding.="</wsdl:input>";
			$binding.="<wsdl:output>";
			$binding.="<soap:body $encodingStyle namespace=\"".$namespace."\" use=\"".$use."\"/>";
			$binding.="</wsdl:output>";
			$binding.="</wsdl:operation>";
		}
		$portType.="</wsdl:portType>";
		$binding.="</wsdl:binding>";

		$xml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		$xml.="<wsdl:definitions xmlns:soap=\"http://schemas.xmlsoap.org/wsdl/soap/\" xmlns:tns=\"".$namespace."\" xmlns:wsdl=\"http://schemas.xmlsoap.org/wsdl/\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" name=\"".$class."\" targetNamespace=\"".$namespace."\">";
		$xml.=$message;
		$xml.=$portType;
		$xml.=$binding;
		$xml.=$service;
		$xml.="</wsdl:definitions>";
		return $xml;

	}

	function args_put(&$args,$key,$value)
	{
		if(!array_key_exists($key,$args))array_push_hash($args,$key,$value);
	}

	function dic_out($key,$value,$row=array())
	{
		$dic=null;
		$method=null;
		$var=array();
		if(count($this->dicobject)>0&&$value!=""&&array_key_exists($key,$this->dicobject))
		{

			$vartemp=array();
			if(preg_match_all("/(\w+)-\>(\w+)\((.+)\)/i",$this->dicobject[$key],$vartemp)>0)
			{
				$vartemp=preg_rows($vartemp);
				if(count($vartemp)==0) return $value;
				$class=new ReflectionClass($vartemp[0][0][0]);
				$dic=$class->newInstance();
				$method=$vartemp[0][1][0];
				$temparr=explode(',',$vartemp[0][2][0]);
				$tempmarr=array();
				foreach($temparr as $tarr)
				{
					if(preg_match_all("/\[(\w+?)\]/i",$tarr,$tempmarr)>0)
					{
						for($j=0;$j<count($tempmarr[1]);$j++){
							$tempvalue=$tempmarr[1][$j];
							if(array_key_exists($tempmarr[1][$j],$row))
								$tarr=preg_replace("/\[".$tempmarr[1][$j]."\]/i",$row[$tempmarr[1][$j]],$tarr);
							else
								$tarr='';
						}
					}
					array_push($var,$tarr);
				}
			}
			else
			{
				$dicarr=explode('#',$this->dicobject[$key]);
				$class=new ReflectionClass($dicarr[0]);
				$dic=$class->newInstance();
				$method=count($dicarr)>1?$dicarr[1]:'diccout';
				$var=array();
				for($i=2;$i<count($dicarr);$i++)array_push($var,$dicarr[$i]);
				array_push($var,$value);
			}
			if($dic!=null&&$method!=null)$value=call_user_func_array(array($dic,$method),$var);
		}
		return $value;
	}

	function getDicUiList($url)
	{
		$vartemp=array();
		preg_match_all("/(\w+?)\=(.+?)\&/i","&".$url."&",$vartemp);
		$vartemp=preg_rows($vartemp);
		$class=null;
		$mod=null;
		$act=null;
		$var=array();
		foreach($vartemp as $vrow)
		{
			if($vrow[0]==C("OPER_MODULE"))
			{
				$class=new ReflectionClass($vrow[1].'Action');
				$mod=$class->newInstance();
				continue;
			}
			if($vrow[0]==C("OPER_ACTION"))
			{
				$act=$vrow[1];
				continue;
			}

			array_push($var,urldecode($vrow[1]));
		}
		$content=call_user_func_array(array($mod,$act),$var);
		$rs="";
		$element=null;
		if($content)
		{
			$doc=new DOMDocument();
			$doc->loadXML($content);
			$xp=new domxpath($doc);
			$element=$xp->query('/root/value/row');
		}
		return $element;
	}

	function setSessionContent($rows,$separa)
	{
		if((count($rows)>0&&count($separa)>0)){
			$s=$rows[0];
			foreach($separa as $key=>$value){
				$oivalue="";
				$dicvalue="";
				if(preg_match("/\./i",$key)>0)
				{
					$keyarr=explode(".",$key);
					preg_match_all("/\[(\w+?)\]/i",$value,$farr);
					for($j=0;$j<count($farr[1]);$j++){
						$tempvalue=$s[$farr[1][$j]];
						$tempdicvalue=$tempvalue;
						$tempdicvalue=$this->dic_out($farr[1][$j],$tempdicvalue);

						switch($farr[1]){
							case "value":
								$tempdicvalue=$tempvalue;
								break;
							case "dicvalue":
								$tempvalue=$tempdicvalue;
								break;
						}
						$dicvalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempdicvalue,$value);
						$oivalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempvalue,$value);
					}

				}else{
					preg_match_all("/\[(\w+?)\]/i",$value,$farr);
					for($j=0;$j<count($farr[1]);$j++){
						$tempdicvalue=$tempvalue=$s[$farr[1][$j]];
						$tempdicvalue=$this->dic_out($farr[1][$j],$tempdicvalue);
						$dicvalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempdicvalue,$value);
						$oivalue=preg_replace("/\[".$farr[1][$j]."\]/i",$tempvalue,$value);

					}
				}
				if($oivalue!=''||$dicvalue!='')array_push_hash($this->session,$key,array('value'=>$oivalue,'dicvalue'=>$dicvalue));
			}
		}
	}

	public function setSession()
	{
		$filename='session'.date('YmdHis').(microtime()*1000000);
		$part=$this->arrayTostring($this->session);
		create_runtime($part,$filename,'/Runtime/Cache/session'.date('Ymd'));
		return $filename;
	}

	public function appandCache($key,$value,$dicvalue)
	{
		array_push_hash($this->cache,$key,array('value'=>$value,'dicvalue'=>$dicvalue));
	}

	public function createCache($filename)
	{
		$part=$this->arrayTostring($this->cache);
		cover_runtime($part,$filename,'/Runtime/Cache');
	}

	public function includeCache($filename)
	{
		$cache=get_runtime($filename,'/Runtime/Cache');
		$this->cache=$this->cache+$cache;
	}

	public function getAllCache()
	{
		return $this->allcache=$this->session+$this->cache;
	}

	function arrayTostring($rows){

			$rs="";
			foreach($rows as $rkey=>$row)
			{
				$rs.="			'".$rkey."'=>array(";
				foreach($row as $key=>$value)
				{
					$rs.="'".$key."'=>'".$value."',";
				}
				$rs.= "),\r\n";
			}
			return $rs;
	}

	public function getConfig($name=null,$config=null)
	{
		if($config==null)$config=$this->model;
		return selfConf($config,$name);

	}

	public function appandSession($key,$value,$dicvalue)
	{
		array_push_hash($this->session,$key,array('value'=>$value,'dicvalue'=>$dicvalue));
	}

	public function response()
	{
		$content=$this->smarty->display($this->templateFile);
		return $content;
	}

	function query($action="",$var=array(),$model=null,$userkey=null)
    {
    	if($model==null)$model=$this->severmodel;
    	if($userkey==null)$userkey=$this->userkey;
		$client=new Model();
		$client->url=$this->wsdl;
		$rs=$client->getWsClientSoapResult('query',array($userkey,$model,$action,$var));
		return $rs;
    }


    function queryjson($action="",$var=array(),$model=null,$userkey=null,$json_decode=true)
    {
    	if(is_array($var))$var=json_encode($var);
    	if($model==null)$model=$this->severmodel;
    	if($userkey==null)$userkey=$this->userkey;
		$client=new Model();
		$client->url=$this->wsdl;
		$rs=$client->getWsClientSoapResult('queryjson',array($userkey,$model,$action,$var));
		if($json_decode)$rs["out"]=json_decode($rs["out"],true);
		return $rs;
    }


}
?>