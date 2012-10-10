<?php

class Curl {

    function Curl() {
    }
    /**
	 *curl post提交数据
	 *$var=array("in"=>"好的");
	 *$out=curl_post("http://localhost:8686/LHBSystem/post.php",$var);
	 */

	function curl_post($url, $vars=array(),$timeout=2) {

		if(preg_match("/\?/i",$url)>0){
			$urlarr=parse_url($url);
			$url=$urlarr["scheme"]."://".$urlarr["host"].":".$urlarr["port"]."/".$urlarr["path"];
			$vartemp=array();
			preg_match_all("/(\w+?)\=(.+?)\&/i","&".$urlarr["query"]."&",$vartemp);
        	$vartemp=preg_rows($vartemp);
        	for($i=0;$i<count($vartemp);$i++){
        		$vars=array_push_hash($vars,$vartemp[$i][0],$vartemp[$i][1]);
        	}
		}
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    //设置要采集的URL
	    curl_setopt($ch, CURLOPT_POST, 1 );
	    //设置形式为POST
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
	    //设置Post参数
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	    //用字符串打印出来。
	    $data = curl_exec($ch);
	    curl_close($ch);
	    if ($data)
	        return $data;
	    else{
//	     echo 'Post null';
	        return false;
	    }
	}


	/**
	 *curl get提交数据
	 *function curl_get($url)
	 */

	function curl_get($url,$vars=array(),$timeout=2)
	{
		if(preg_match("/\?/i",$url)>0){
			foreach($vars as $key=>$value){
				$url.="&".$vars[$key]."=".$vars[$value];
			}
		}else{
			$url.="?";
			foreach($vars as $key=>$value){
				$url.="&".$vars[$key]."=".$vars[$value];
			}
		}

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	    $data = curl_exec($ch);
	    curl_close($ch);
	    if ($data)
	         return $data;
	    else{
//	     	echo 'curl_get null';
	     	return false;
	 	}
	}

}
?>