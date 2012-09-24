<?php

class QueryKMDriverModel extends Model {
    public $url;
    function QueryKMDriverModel() {
    	parent::__construct();
    	$this->url=C("Query_KmWsUrl");
    }
    public function queryInfo(){
		$param = array(
					"moduleID"=>"1",
					"pageArticleNumber"=>"1",
					"webserverUrl"=>"1",
		);
//		//echo $jszh;
//	    if($jszh!="")$param=array_push_hash($param,"in2",$jszh);
//	    if($dabh!="")$param=array_push_hash($param,"in3",$dabh);
//	    if($xm!="")$param=array_push_hash($param,"in4",$xm);
		$rs=$this->getWsClientResult('savaNetData',$param);
//        $xdu=new XmlDbUtil();
//        $xdu->setXmlContent($rs[out]);
//        $xdu->setRoot("/udai/dataTable/dataRow");
//        $rows=$this->getSelectXmlResultII($inarr,$xdu);
		//return $rows;
		echo $rs;
    }
}
?>