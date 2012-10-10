<?php



class App{
	private $model;
	private $action;
	function setModel($model)
	{

		$this->model=$model;
	}

	function setAction($action)
	{
		$this->action=$action;
	}

	function getModel()
	{
		return $this->model;
	}

	function getAction()
	{
		return $this->action;
	}

    function run($model="",$action="",$var=array(),$rsflag=false){

    	$this->init($model,$action);
		$runtime=new runtime();
    	try{
		    if(C('SHOW_ERROR')){
		    	$rs=$this->exec($model,$action,$var);
		    }else{
		    	$rs=@$this->exec($model,$action,$var);
		    }
    	}catch (Exception $e){
			log_error($e);
			$rs=flag_xml("后台系统正在升级00","-1");
    	}
    	if(C('CATCH_ERROR'))catch_error();
    	request_log("",number_format($runtime->getexectime())."\t毫秒");
    	$rs=App_distruct($rs,$rsflag);
    	return $rs;
    }

    function init(&$model="",&$action=""){
		//初始化文件夹
		require_once(LHB_PATH.'/Common/functions.php');
		init_createpath();

    	$arr=require(LHB_PATH.'/Common/core.php');
        foreach ($arr as $key=>$value) {
          if(is_file($value))require_once($value);
        }

		if(!defined ('LIB_PATH'))define('LIB_PATH','Lib');
		if($model=="")$model=C("DEFAULT_MODULE");
		if($action=="")$action=C("DEFAULT_ACTION");
		if(R(C("OPER_MODULE"))!=null)$model=R(C("OPER_MODULE"));
		if(R(C("OPER_ACTION"))!=null)$action=R(C("OPER_ACTION"));
        $this->setModel($model);
        $this->setAction($action);

        //接收wsdl
        $qwsdl=$_SERVER['QUERY_STRING'];
		if(preg_match("/\.wsdl/i",$qwsdl)>0){
			if(C("WSDL_Model")!="")$model=C("WSDL_Model");
			$wsdl=C("WSDL_File");
			for($i=0;$i<count($wsdl);$i++){
				if($wsdl[$i]==$qwsdl)$action=str_replace(".wsdl","",$qwsdl)."_wsdl";
			}
		}

		//接收wl
		$qwd=$_SERVER['QUERY_STRING'];
		if(preg_match("/\.wd/i",$qwd)>0){
			if(C("WSDL_Model")!="")$model=C("WSDL_Model");
			$wd=C("WSDL_Server");
			for($i=0;$i<count($wd);$i++){
				if($wd[$i]==$qwd)$action=str_replace(".wd","",$qwd);
			}
		}


		App_init();
		session_control();
    }
    function exec($model,$action,$var=array()){
    	    $modelact=$model."Action";
			try{
				$class=new ReflectionClass($modelact);
				$act=$class->newInstance(null,$model,$action);
				$act->set_model($model);
				$act->set_action($action);
				$methodrows=get_class_methods($act);
				if(in_array($action,$methodrows))
					$rs=call_user_func_array(array($act,$action),$var);
				else if($act->wsdl!=null&&$act->severmodel!=null)
				{
					if(count($var)==0)
					{
						if(array_key_exists($action,$act->queryvar))
							foreach($act->queryvar[$action] as $item)$var[]=R($item);
						else
						{
							$rvar=array();
							RR($rvar,array(C('OPER_MODULE'),C('OPER_ACTION')));
							$var=array_merge($var,array_values($rvar));
						}

					}
					$mvar=array($action,$var);
					$rs=call_user_func_array(array($act,"query"),$mvar);
					$rs=$rs['out'];
				}
				else
				{
					$rs=flag_xml("调用的方法不存在","-1");
					return $rs;
				}

			}catch(Exception $e){
				log_debug($e->getMessage());
			    $rs=flag_xml($e->getMessage(),"-1");
			    return $rs;
			}

			return $rs;
    }
}
?>