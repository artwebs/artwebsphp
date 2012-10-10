<?php
		$ob_before=ob_list_handlers();
		 if (count($ob_before)>0)
		 {
		 	$doc_before=ob_get_contents();
		 	ob_end_clean();

		 }
		 if (function_exists('handle_fatal')==false)
		 {

		 	function handle_fatal($output_try)
		 	{

		 		if (preg_match("/<b>(.+?)\serror<\/b>:(.*?)<br/i", $output_try, $match))
		 		{
		 			return flag_xml($match[2].query_url(),"-1");
		 		}
		 		else
				{
				 	return $output_try;
				}
		 	}

		 }
		ob_start('handle_fatal');

		function __autoload($classname) {
		     if(substr($classname,-5)=="Model") {
		     		if(is_file(APP_PATH.'/Lib/Model/'.$classname.'.class.php'))
		            	require_once(APP_PATH.'/Lib/Model/'.$classname.'.class.php');
		            else
		            	require_once(LHB_PATH.'/Lib/Model/'.$classname.'.class.php');
		        }elseif(substr($classname,-6)=="Action"){
		        	if(is_file(APP_PATH.'/Lib/Action/'.$classname.'.class.php'))
		            	require_once(APP_PATH.'/Lib/Action/'.$classname.'.class.php');
		            else
		            	require_once(LHB_PATH.'/Lib/Action/'.$classname.'.class.php');
		        }else if(substr($classname,-6)=="Plugin"){
		        	if(is_file(APP_PATH.'/Plugin/'.$classname.'.class.php'))
						require_once( APP_PATH.'/Lib/Plugin/'.$classname.'.class.php');
					else
						require_once( LHB_PATH.'/Lib/Plugin/'.$classname.'.class.php');
		        }
		        else {
		            if(is_file($classname. '.class.php'))require_once $classname. '.class.php';
		        }
		   }

		// 优化的require_once
		function require_cache($filename)
		{
		    static $_importFiles = array();
		    $filename   =  realpath($filename);
		    if (!isset($_importFiles[$filename])) {
		        if(file_exists_case($filename)){
		            require $filename;
		            $_importFiles[$filename] = true;
		        }
		        else
		        {
		            $_importFiles[$filename] = false;
		        }
		    }
		    return $_importFiles[$filename];
		}
		// 区分大小写的文件存在判断
		function file_exists_case($filename) {
		    if(is_file($filename)) {
		        if(IS_WIN && C('APP_FILE_CASE')) {
		            if(basename(realpath($filename)) != basename($filename))
		                return false;
		        }
		        return true;
		    }
		    return false;
		}

		function create_define(){
			$confarray=require(APP_PATH."/Conf/config.php");
			$contarray=require("convention.php");
			$define=$confarray+$contarray;
		    return $define;
		}


		// 获取配置值
		function C($name=null,$value=null)
		{
			static $define=null;
			if(empty($define))$define=create_define();

		    if(!empty($name))return $define[$name];
		    return;
		}

		function selfConf($config,$name=null)
		{
			$confarray=require(APP_PATH."/Conf/".$config.".config.php");
			if($confarray)
			{
				if($name!=null&&array_key_exists($name,$confarray))return $confarray[$name];
			}
			return $confarray;
		}

		function R($name,$decode=true){
			$value="";
			if(is_array($_REQUEST)&&count($_REQUEST)>0&&isset($_REQUEST[$name]))$value=$_REQUEST[$name];
			if($decode)$value=urldecode($value);
			return $value;
		}

		function RR(&$row=array(),$nopara=array(),$para=array()){
			if(is_array($_REQUEST)&&count($_REQUEST)>0)
			{
				$nopara=array_merge($nopara,C('RR_DEFAULTNOPARA'));
				if(count($para)>0)
				{
					foreach($para as $key)
					{
						array_push_hash($row,$key,R($key));
					}
				}
				else
				{
					foreach($_REQUEST as $key=>$value)
					{
						if(in_array($key,$nopara))continue;
						if(count($para)>0&&!in_array($key,$para))continue;
						$value=urldecode($value);
						array_push_hash($row,$key,$value);
					}
				}

			}

			return $row;
		}

		function array_replace_art(&$row,$oldkey,$newkey,$value=null)
		{
			if($value==null)$value=$row[$oldkey];
			unset($row[$oldkey]);
			array_push_hash($row,$newkey,$value);
			return $row;
		}


		/**
		 * 如果存在请求参数时，将请求参数赋到变量上
		 */
		function SR(&$var,$name){
			if(R($name)!=null)$var=R($name);
		}

		function request_log($dir="",$stxt=""){
		    if($dir=="")$dir=APP_PATH."/Log";
		    if(!is_dir($dir)){
		        mkdir($dir, 0700);
		    }
		    $file=$dir."/query_log".date("Ymd").".php";
		    $fileData="";
		    if(!file_exists($file))$fileData.="<?php exit('no direct access allowed');?>\r\n";
		    @$fp = fopen($file,"a+");
		    if(!$fp){
		        echo "system error";
		        exit();
		    }

		    $fileData.= date("Y-m-d H:i:s")." [".$stxt."]"." ";
		    $fileData.=query_url();
		    $fileData.= "\r\n";
		    fwrite($fp,$fileData);
		    fclose($fp);
		}

		function response_log($rs="",$dir="")
		{
			if(!C('RESPONSE_SAVEFLAG'))return;
			$content=query_url();
			if($dir=="")$dir=APP_PATH."/Log/response".date('Ymd');
			$last=date('Ymd',strtotime("-".C('RESPONSE_SAVEDAY')." day", time()));
			if(is_dir(APP_PATH."/Log/response".$last))deldir(APP_PATH."/Log/response".$last);
		    if(!is_dir($dir)){
		        mkdir($dir, 0700);
		    }
		    $file=$dir."/".date("Hi").".php";
		    $fileData="";
		    if(!file_exists($file))$fileData.="<?php exit('no direct access allowed');?>\r\n";
		    @$fp = fopen($file,"a+");
		    if(!$fp){
		        echo "system error";
		        exit();
		    }

		    $fileData.= date("Y-m-d H:i:s")." "." ";
		    $fileData.=query_url();
		    $fileData.= "\r\n";
		    $fileData.=$rs;
		    $fileData.= "\r\n";
		    fwrite($fp,$fileData);
		    fclose($fp);
		}


		function query_url(){
			 $rs="http://";
			 $raw_post_data = file_get_contents('php://input', 'r');
			 $rs.=$_SERVER['SERVER_NAME'].":";
		     $rs.= $_SERVER['SERVER_PORT']."";
		     $rs.=$_SERVER["PHP_SELF"];
		     if($_SERVER['QUERY_STRING']!=""||$raw_post_data!="")$rs.="?";
		     $rs.=$_SERVER['QUERY_STRING'];
		     if($_SERVER['QUERY_STRING']!=""&&$raw_post_data!="")$rs.="&";
		     if($raw_post_data!="")$rs.=$raw_post_data;
		     return $rs;

		}

		function write_log($text,$dir=""){
		    if($dir=="")$dir=APP_PATH."/Log";
		    if(!is_dir($dir)){
		        mkdir($dir, 0700);

		    }
		    $file=$dir."/console_log".date("Ymd").".php";
		    $fileData="";
		    if(!file_exists($file))$fileData.="<?php exit('no direct access allowed');?>\r\n";
		    @$fp = fopen($file,"a+");
		    if(!$fp){
		        echo "system error";
		        exit();
		    }
		     $raw_post_data = file_get_contents('php://input', 'r');
		     $fileData.= date("Y-m-d H:i:s")."  ";
		     $fileData.=$text;
		     $fileData.= "\r\n";
		     fwrite($fp,$fileData);
		     fclose($fp);
		}

		function gerEnoughLenStr($str,$len){
			$baselen=strlen($str);
			if($baselen<$len){
				for($i=0;$i<$len-$baselen;$i++){
					$str="0".$str;
				}
			}
			return $str;
		}
		/**
		 *给数据中添加或修改值
		 */
		function array_push_hash(&$arr,$key,$value){
			if(array_key_exists($key,$arr)){
				$arr[$key]=$value;
			}else{
				end($arr);
				$arr[$key]=$value;
			}
			return $arr;
		}
		/**
		 * 分割字符串
		 */
		function mbstr_arr ($string,$recharset='utf-8') {
		    $strlen = mb_strlen($string);
		    while ($strlen) {
		        $array[] = mb_substr($string,0,1,$recharset);
		        $string = mb_substr($string,1,$strlen,$recharset);
		        $strlen = mb_strlen($string);
		    }
		    return $array;
		}


		/**
		 * 调用类的方法
		 *$class 类名
		 *$method 方法名
		 *$param 参数array()
		 */

		function call_func($class,$method,$param){
			$tclass=new $class;
			$rs=call_user_func_array(array($tclass,$method), $param);
			return $rs;
		}

		/**
		 *数据分页
		 */
		 function rows_page($rows,$page=1,$pagesize=5){
		    	$len=count($rows);
		    	$page_count=0;
		    	$current_page_rows=array();
		    	$out=array("page_count"=>"","page_rows"=>"");
		    	if($len%$pagesize==0){
					$page_count=(int)$len/$pagesize;
		    	}else{
					$page_count=(int)($len/$pagesize)+1;
		    	}

				$lcount=0;
				$rcount=0;
				if($page<=$page_count&&$page>0)
				{
					$lcount=($page-1)*$pagesize;
					if($page*$pagesize<=$len)
					{
						$rcount=$page*$pagesize;
					}
					else
					{
						$rcount=$len;
					}
				}

				for($i=$lcount;$i<$rcount;$i++){
						array_push($current_page_rows,$rows[$i]);
				}

				$out=array_push_hash($out,"page_count",$len);
				$out=array_push_hash($out,"page_rows",$current_page_rows);
				array_push($out,$len,$current_page_rows);
				return $out;
		    }

		/**
		 * 正则表达式数据集转换为通用数据集
		 */
		 function preg_rows($rows){
			$rsrows=array();
			for($i=0;$i<count($rows[0]);$i++){
				$temp=array();
				for($j=1;$j<count($rows);$j++){
					if(count($rows[0])==1){
						$temp[]=$rows[$j];
					}else{
						$temp[]=$rows[$j][$i];
					}
				}
				array_push($rsrows,$temp);
			}
			return $rsrows;

		 }

		 /**
		  * get提交
		  */

		  function submit_get($url,$vars=array(),$timeout=2){
		  	$urlobject=new Curl();
		  	$rs=$urlobject->curl_get($url,$vars,$timeout);
		  	return $rs;
		  }

		  /**
		  * post提交
		  */

		  function submit_post($url,$vars=array(),$timeout=2){
		  	$urlobject=new Curl();
		  	$rs=$urlobject->curl_post($url,$vars,$timeout);
		  	return $rs;
		  }

		/**
		 * 身份证升级15到18位
		 */

		 function idcard_15to18($idcard){
		 	$idobject=new IdCard();
		 	$rs=$idobject->idcard_15to18($idcard);
		 	return $rs;
		 }

		 /**
		  * 中文翻译为全拼
		  * 	$id=fullspell("中国-;昆明");
				//$id=initspell("中国昆明");
		  */
		 function fullspell($str,$_Code='utf-8',$keepother=true){
			$pin=new PinYin();
			$rs=$pin->Pin($str,$_Code,$keepother);
			return $rs;
		 }
		 /**
		  * 中文翻译为首拼
		  */
		 function initspell($str,$_Code='utf-8',$keepother=true){
		 	$pin=new PinYin();
			$rs=$pin->Pin($str,$_Code,"init",$keepother);
			return $rs;
		 }


		function rad($d)
		{
		    return $d * 3.1415926535898 / 180.0;
		}

		/**
		 * 计算经纬度
		 */
		function GetDistance($lat1, $lng1, $lat2, $lng2)
		{
		    $EARTH_RADIUS = 6378.137;
		    $radLat1 = rad($lat1);
		    //echo $radLat1;
		   $radLat2 = rad($lat2);
		   $a = $radLat1 - $radLat2;
		   $b = rad($lng1) - rad($lng2);
		   $s = 2 * asin(sqrt(pow(sin($a/2),2) +
		    cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
		   $s = $s *$EARTH_RADIUS;
		   $s = round($s * 10000) / 10000;
		   return $s;
		}

		/**
		 * 项目日志记录
		 */

		 function log_debug($text){
		 	$log=new Log4j();
			$log->log_debug($text);
		 }
		 function log_info($text){
		 	$log=new Log4j();
			$log->log_info($text);
		 }
		 function log_warn($text){
		 	$log=new Log4j();
			$log->log_warn($text);
		 }
		 function log_error($text){
		 	$log=new Log4j();
			$log->log_error($text);
		 }
		 function log_fatal($text){
		 	$log=new Log4j();
			$log->log_fatal($text);
		 }

		/**
		 * 返回错误xml
		 */

		function flag_xml($return="",$flag="",$message=""){
			$rs="";
			$rs.="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\r\n";
	        $rs.="<root>\r\n";
	        $rs.="<count>0</count>\r\n";
	        $rs.="<return>$flag</return>\r\n";
	        $rs.="<returnflag>$return</returnflag>\r\n";
	        if($message!="")$rs.="<message>$message</message>\r\n";
	        $rs.="</root>\r\n";
	        return $rs;
		}

		/**
		 * 返回访问根目录
		 */
		function http_root(){
			 $httproot="http://";
		     $httproot.=$_SERVER['SERVER_NAME'].":";
		     $httproot.= $_SERVER['SERVER_PORT']."";
		     $httproot.=$_SERVER["PHP_SELF"];
		     return $httproot;
		}


		/**
		 * 获取客户端ip
		 */
		function get_client_ip(){
		   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		           $ip = getenv("HTTP_CLIENT_IP");
		       else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		           $ip = getenv("HTTP_X_FORWARDED_FOR");
		       else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		           $ip = getenv("REMOTE_ADDR");
		       else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		           $ip = $_SERVER['REMOTE_ADDR'];
		       else
		           $ip = "unknown";
		   return $ip;
		}


		/**
		 * 将base64编码转换为图片
		 */
		function base64_pic($data,$imname,$impath="./UpFiles/",$ex=".jpg"){
			$type=get_content_type($ex);
			$data=base64_decode($data);
			$im=imagecreatefromstring($data);
			$rs="";
			if($im!==false)
			{
			    header('Content-type:'.$type);
			   	imagejpeg($im,$impath.$imname);
			   	$rs=$impath.$imname;
			   	header("Content-Type:text/html; charset=utf-8;");
			}
			return $rs;
		}

		/**
		 * 将图片转换为base64编码
		 */
		 function pic_base64($imgname,$imgPath="./UpFiles/"){
			$rs= file_get_contents($imgPath.$imgname) ;
			$rs=base64_encode($rs);

			return $rs;
		 }

		/**
		 * 在线输出图片
		 */
		function base64_pic_online($data,$ex=".jpg"){
			$type=get_content_type($ex);
			header("Content-Type: ".$type);  //这里根据图片类型修改
			header("Content-Disposition: inline");
			return base64_decode($data);  //解码并输出
		}
		/**
		 * 根据扩展名获取对应的Content_type
		 */
		function get_content_type($ex){
			$http=new HttpObject();
			$rs=$http->get_content_type($ex);
			return $rs;
		}

		/*
		 * 使用Java初始化
		 *
		 */
		function java_init(){
			require_once(C("PHP_JAVA_BRIDGE"));
		}

		function maptoarray($map){
			$count=java_values($map->size());
			$rs=array();
			for($i=0;$i<$count;$i++){
				$rs=array_push_hash($rs,java_values($map->getKey($i)),java_values($map->getValue($i)));
			}
			return $rs;
		}

		function arraytomap($arr){
			$rs=new Java("com.lhb.object.LHBMap");
			foreach($arr as $key=>$value){
				$rs->put($key,$value);

			}
			return $rs;
		}

		function java_factory($class,$var1=null){
			$java=new JavaObject();
			return $java->intance($class,$var1);
		}

		function getMarkString($str,$leftstr,$rightstr){
			$temp=$str;
			$rsstr=false;
			if(!is_bool(strpos($temp,$leftstr))){
				$lp=strpos($temp,$leftstr)+strlen($leftstr);
				$rp=strpos($temp,$rightstr,$lp);
				if(!is_bool($rp)){
					$vl=$rp-$lp;
					$rsstr=substr($temp,$lp,$vl);
				}
			}

			return $rsstr;
		}

		function getMarkStringList($str,$leftstr,$rightstr){
			$rsrows=array();
			$temp=$str;
			$tempv="";
			while(!is_bool(getMarkString($temp,$leftstr,$rightstr))){

				$tempv=getMarkString($temp,$leftstr,$rightstr);
				array_push($rsrows,$tempv);
				$temp=preg_replace("{".preg_quote($leftstr.$tempv.$rightstr)."}","",$temp,1);
			}

			return $rsrows;
		}


		/**
		 * 页面跳转
		 */
		function send_dir($url){
			header("Location: ".$url);
			exit;
		}

		function session_init(){
			if(!isset($_SESSION)) {
				 session_start();
			}
		}


		/**
		 * 设置session
		 */
		function session_set($key,$value){
			session_init();
			$_SESSION[$key]=$value;
		}

		/**
		 * 获得session
		 */
		function session_get($key){
			session_init();
			return $_SESSION[$key];
		}

		/**
		 * 删除session
		 */
		function session_del($key=array()){
			session_init();
			if(is_string($key)){
				unset($_SESSION[$key]);
			}else if(is_array($key)){
				$_SESSION=array();
			}
		}

		/**
		 *是否存在session
		 */
		 function session_flage($key,$value){
		 	$rs=false;
		 	session_init();
			if(isset($_SESSION[$key])&&$_SESSION[$key]==$value){
				$rs=true;
			}
			return $rs;
		 }

		/**
		 *session访问控制
		 */
		function session_control(){
			if(C("SESSION_FLAGE")){
				$mod=R(C("OPER_MODULE"));
				$act=R(C("OPER_ACTION"));
				$control=C("SESSION_CONTROL");
				$url=C("SESSION_FAILURL");
				$query=$_SERVER['REQUEST_URI'];
				$flage=false;
				session_init();
				if($act=="")$act="index";
				if($mod=="")$mod="index";
				if(array_key_exists($mod,$control[0])){
					if(!isset($_SESSION[C("SESSION_KEY")])&&!array_key_exists($act,$control[0][$mod]))$flage=true;
				}else if(array_key_exists($act,$control[1])){
					if(!isset($_SESSION[C("SESSION_KEY")]))$flage=true;
				}else{

				}
				if($flage){
//					send_dir($query);
					send_dir(str_replace('[error]',urlencode(R('error')),C("SESSION_FAILURL")));
				}

			}

		}

		/**
		 * 目录拷贝
		 */
		function path_copy($source, $destination, $child=1){
		    //用法：
		    // xCopy("feiy","feiy2",1):拷贝feiy下的文件到 feiy2,包括子目录
		    // xCopy("feiy","feiy2",0):拷贝feiy下的文件到 feiy2,不包括子目录

		    if(!is_dir($source)){
		    	echo "Error:the $source is not a direction!";
//		    	write_log("Error:the $source is not a direction!");
		    return 0;
		    }
		    if(!is_dir($destination)){
		    	mkdir($destination,0777);
		    }
		    $handle=dir($source);
		    while($entry=$handle->read()) {
		        if(($entry!=".")&&($entry!="..")){
		            if(is_dir($source."/".$entry)){
		                if($child)path_copy($source."/".$entry,$destination."/".$entry,$child);
		            }else{
		                copy($source."/".$entry,$destination."/".$entry);
						$str=file_get_contents($destination."/".$entry);
						$str = str_replace("/LHBSystem_1/index.php",$_SERVER["PHP_SELF"],$str);
						file_put_contents($destination."/".$entry,$str);

		            }
		        }
		    }
		    return true;
		}

		/**
		 * 系统文件准备
		 */
		function init_createpath(){
			$dirs=array('Common','Conf','Images','Lib','Log','Runtime','Tpl','UpFiles','Tpl_c','Css','Js','Data');
			if(is_file(APP_PATH."/Config/config.php")&&!C("DEFAULTFILE_CREAT"))return;
			foreach($dirs as $dir){
				if(!is_dir(APP_PATH."/$dir/")){
					path_copy(LHB_PATH."/DefaultFile/".$dir,APP_PATH."/$dir/");
				}
			}
		}



		function getmicrotime(){
			list($usec, $sec) = explode(" ",microtime());
			return ((float)$usec + (float)$sec);

		}

		class runtime{
			public $stime;
			public $etime;
			public $exectime;
			public function runtime(){
				$this->getstime();
			}
			public function getstime(){
				return $this->stime=getmicrotime();
			}
			public function getetime(){
				return $this->etime=getmicrotime();
			}
			public function getexectime(){
				if($this->etime=="")$this->getetime();
				return $this->exectime=($this->etime - $this->stime)*1000;
			}
		}

		function catch_error(){
    		$error = error_get_last();
    		if($error!=null){
    			$log=query_url();
    			$log.="\r\n".$error["message"]." in ".$error["file"]." ".$error["line"];
    			log_warn($log);
    		}

		}


		function create_runtime($content,$filename,$dir=""){
			$file=get_runtime_file($filename,$dir);
		    if(file_exists($file)){
				 $str=file_get_contents($file);
				 $str = str_replace("//[new]",$content."\r\n//[new]",$str);
				 file_put_contents($file,$str);
		    }else{
		    	cover_runtime($content,$filename,$dir);
		    }
		}

		function cover_runtime($content,$filename,$dir="")
		{
			$file=get_runtime_file($filename,$dir);
			@$fp = fopen($file,"w");
		    if(!$fp){
		        echo "system error";
		        exit();
		    }else {
		    		$fileData="";
		    	    $fileData.= "<?php\r\n";
		    	    $fileData.= "return array(\r\n";
		    	    $group=false;
		    	   	$fileData.=$content;

		    	    $fileData.="\r\n//[new]\r\n";
		    	    $fileData.= ");\r\n";
					$fileData.= "?>\r\n";
		            fwrite($fp,$fileData);
		            fclose($fp);
		    }
		}

		function get_runtime_file($filename,$dir="",$flag=true)
		{
			if($dir=="")$dir="/Runtime/Data";
			$fdir=APP_PATH.$dir;
		    if(!is_dir($fdir)&&$flag){
		        mkdir($fdir, 0700);
		    }
		    $file=$fdir."/~".$filename.'.php';
		    return $file;
		}
		function get_runtime($filename,$dir=""){
			$file=get_runtime_file($filename,$dir,false);
			if(is_file($file)){
				return require($file);
			}else{
				return array();
			}
		}

		/**
		 * 将数据集合的键大小写进行转换
		 * CASE_UPPER
		 * CASE_LOWER
		 */
		function rows_key_case(&$rows,$case=CASE_UPPER)
		{
			$rsrows=array();
			foreach($rows as $row)
			{
				$rsrows[]=array_change_key_case($row, $case);
			}
			$rows=$rsrows;
		}

		/**
		 * 将单行数据集合的键大小写进行转换
		 * CASE_UPPER
		 * CASE_LOWER
		 */
		function row_key_case(&$row,$case=CASE_UPPER)
		{
			$rsrow=array();
			$rsrow[]=array_change_key_case($row, $case);
			$row=$rsrow;
		}

		function deldir($dir) {
			if(!is_dir($dir))return false;
		    $dh=opendir($dir);
		    while ($file=readdir($dh)) {
		        if($file!="." && $file!="..") {
		            $fullpath=$dir."/".$file;
		            if(!is_dir($fullpath)) {
		                unlink($fullpath);
		            } else {
		                deldir($fullpath);
		            }
		        }
		    }
		    closedir($dh);
		    if(rmdir($dir)) {
		        return true;
		    } else {
		        return false;
		    }
		}

?>
