<?php

class IndexAction extends ActionXml {
	private $tmp="";
    function index($var="",$var1="") {
    	$xml="";
    	$txt="";
//		$inarr=array("MESSAGEID"=>'短信编号',
//					 "MESSAGECONTENT.string"=>"短信内容",
//					 "to_char(MESSAGEINDATE,'YYYY-mm-dd hh24:mi:ss') as MESSAGEINDATE"=>"入库时间"
//		);
//
//		$inarr=array("MESSAGECONTENT"=>"短信内容113");
//		$w="MESSAGEID='SMSOUT00000000000054'";
//		$m=new MessageModel();
//		$rows=$m->getSelectResult($inarr);
//		print_r($m->getDeleteResult($w));
//		print_r($rows);
//		$para=array("first"=>"[MESSAGEID]","py"=>"[MESSAGECONTENT]");
//		$this->smarty_init();
//		$xml=$this->return_diclist_xml($rows,$para);

//		$xml=$this->return_cx_xml($rows,$inarr);
//		$rootpath="/root";
//		$xml=$this->ruturn_data_xmlI($rows,$inarr,$rootpath,"00","","E","C","D","1");
//		echo $xml;
//		$this->assign("title","好的");
//		$xml=$this->display('',__FUNCTION__);
//		$separa=array("first"=>"[MESSAGEID]","second"=>"[MESSAGECONTENT]");
//		$para=array("rows"=>$rows,"para"=>$inarr,"separa"=>$separa,"oirows"=>$rows);
//		$txt=$this->return_cx_xml_I($para);
//		$txt="你好";
//		$txt=$this->display("login");
//		var_dump($_SERVER);
//		$xml=submit_get("http://localhost:8001/index.php?id=2.txt",array(),1);
//		var_dump($xml);
//		$u=new TUserModel();
//		$rows=$u->getSelectResult();
//		print_r($rows);

//		$pro=new ProdurceModel();
//		$outarr=array("rs.string"=>"");
//		$pro->callProcedure("getrecodes",array(),$outarr);

//		$inarr=array("a"=>2,"b"=>3);
//		$outarr=array("rs.integer"=>"");
//		$pro->callProcedure("abc",$inarr,$outarr);

//		$pro=new VDProdurceModel();
//		$inarr=array("dic_group"=>"Mobile_Part");
//		$outarr=array("query_result.cursor"=>"");
//
//		$pro->callProcedure("QUERY_DATA_DICT",$inarr,$outarr);
//		print_r($outarr);

//		print_r($pro->getSelectResult());

//		echo str_pad(23, 7, "0", STR_PAD_LEFT);
//		$this->assign('title',"好的1".$var.$var1);
//		$txt=$this->display();
//		$txt=$this->return_flag_xml("-1","00");

//		$trans=new VDProdurceModel();
//		$trans->callTrans();
//		$trans->callProc();
//		$trans->deletedata();
//		$dic=new DicModel();
//		var_dump($dic->diclist("xb"));

//		var_dump(__METHOD__);
//		var_dump(is_file('D:\phpwww\LHBSystem_1\System/Vendor/Smart/Smarty.class.php'));
//		$txt="nexturl";
//		echo substr($txt,-3);

//		var_dump(preg_match("/[^\w]*".C("OPER_ACTION")."=\w+/i","http://localhost/artwebsphp/index.php?mod=xml&act=getpageui"));
//		echo date('YmdHis').(microtime()*1000000);
//		echo urlencode('性别');
//		$arr=array('xm'=>'张三','xb'=>'男');
//		$arr='1111';
//		$json_string = json_encode($arr);
//		$obj = json_decode($json_string,true);
//		var_dump($obj);

//		$a=new a();

//		$arr=array(array('xm'=>'abc','xb'=>'男'));
//		rows_key_case($arr,CASE_UPPER);
//		print_r($arr);
//		echo substr("xxxModel",0,-5);
//		return submit_get('http://localhost/artwebsphp/index.php?mod=Dic&act=diclist&groupname=%E6%80%A7%E5%88%AB',array(),20);
		$vartemp=array();
		var_dump(preg_match_all("/(\w+)-\>(\w+)\((.+)\)/i",'ExampleDModel->composeString(xb,[SEX],[SOURCE])',$vartemp));
//    	return '1111';
    }
    function test(){
		java_init();
		$arr=array(
				"url1"=>"http://localhost:8686/LHBSystem/index.php?a=1",
				"url2"=>"http://localhost:8686/LHBSystem/index.php?a=2",
				"url3"=>"http://localhost:8686/LHBSystem/index.php?a=3",
				);
		$call=java_factory("CallPages", arraytomap($arr));
		$call->run();
		$rs=java_factory("LHBMap");
		$rs=$call->getResult();
		$row=maptoarray($rs);
		print_r($row);

		return R("b");
    }

	/**
	 * http://localhost/artwebsphp/index.php?act=getInterface
	 */
    function getInterface(){

		return array('a'=>'1');
    }

}
?>