<?php

class Model extends LHB {
   protected $db;
   protected $tableName="";
   protected $top="";
   private $xml;
   public $url;
   private $wsclient;
   protected $keyid="";
   public function __construct($tblname="",$Top="",$child=""){
   		if($tblname!="")$this->tableName=$tblname;
   		if($Top!="")$this->top=$Top;
   		$dbtype=C($this->top."DB_TYPE");
   		$dbtype=ucwords($dbtype)."Model";
//   		log_debug("数据库类:".$dbtype);
   		if($child=="")$child=get_class($this);
//   		log_debug("模型类:".$child);
//		$this->db=new $dbtype($this->tableName,$this->top,$child);
		$class=new ReflectionClass($dbtype);
		$this->db=$class->newInstance($this->tableName,$this->top,$child);
		$this->xml=new XmlModel();
		$this->wsclient=new WebServiceClient($this->url);
   }

	public function query($sql){
    	return $this->db->query($sql);
	}
	public function execute($sql){
		return $this->db->execute($sql);
	}

	public function getSelectResult($inpara=array(),$where="",$tblname=""){
		return $this->db->getSelectResult($inpara,$where,$tblname);
    }

    public function getSelectResultToPage($inpara,$page=0,$pagesize=5,$where="",$tblname=""){
    	$rows=$this->db->getSelectResult($inpara,$where,$tblname);
    	$out=rows_page($rows,$page,$pagesize);
		return $out;
    }
    public function getDeleteResult($where,$tblname=""){
		return $this->db->getDeleteResult($where,$tblname);
    }
    public function getInsertResult($inpara,$tblname=""){
		return $this->db->getInsertResult($inpara,$tblname);
    }
    public function getUpdateResult($inpara,$where="",$tblname=""){
		return $this->db->getUpdateResult($inpara,$where,$tblname);

    }

    public function callProcedure($procName,$inarr=array(),&$outarr=array()){
		return $this->db->callProcedure($procName,$inarr,$outarr);
    }

    public function callTransaction($trans){
    	return $this->db->callTransaction($trans);
    }

    public function getSelectXmlResult($inarr,$f=1,$d=2,$path="",$url=""){
    	if($url!="")$this->url=$url;
		return $this->xml->getSelectXmlResult($inarr,$f,$d,$path,$this->url);
    }



    /**
     *据xml数据对象获得查询结果
     */
    public function getSelectXmlResultI($inarr,$xmlutil,$fieldrow=1,$datastart=2){
        $rows=(array)$xmlutil->getRowFieldRowData($fieldrow,$datastart);
        $rsarr=array();
        if(count($inarr)>0){
        	for($i=0;$i<count($rows);$i++){
        		$temparr=array();
				foreach($inarr as $key=>$value){
					if(preg_match("/\s+as\s+/i",$key)>0)
					{
						$farr=array();
						preg_match_all("/(\w+)\s+as\s+(\w+)/i",$key,$farr);
						$temparr[$farr[2][0]]=$rows[$i][$farr[1][0]];
					}
					else
					{
						$temparr[$key]=$rows[$i][$key];
					}
				}
				//print_r($inarr);
				array_push($rsarr,$temparr);
        	}
        }
        else
        {
        	  $rsarr=$rows;
        }

		return $rsarr;
    }



    /**
     *据xml数据对象获得查询结果
     */
    public function getSelectXmlResultII($inarr,$xmlutil){
        $rows=(array)$xmlutil->getRowData();
        $rsarr=array();
        if(count($inarr)>0){
        	for($i=0;$i<count($rows);$i++){
        		$temparr=array();
				foreach($inarr as $key=>$value){
					if(preg_match("/\s+as\s+/i",$key)>0)
					{
						$farr=array();
						preg_match_all("/(\w+)\s+as\s+(\w+)/i",$key,$farr);
						$temparr[$farr[2][0]]=$rows[$i][$farr[1][0]];
					}
					else
					{
						$temparr[$key]=$rows[$i][$key];
					}
				}
				array_push($rsarr,$temparr);
	        }
        }
        else
        {
        	  $rsarr=$rows;
        }

		return $rsarr;
    }

    /**
     *据xml数据对象获得查询结果
     */
    public function getSelectXmlResultIII($inarr,$xmlutil,$fieldrow=1,$datastart=2,$pnode="Row",$node="Data"){
        $rows=(array)$xmlutil->getRowFieldRowDataI($fieldrow,$datastart,$pnode,$node);
        $rsarr=array();
		if(count($inarr)>0){
			for($i=0;$i<count($rows);$i++){
				$temparr=array();
				foreach($inarr as $key=>$value){
					if(preg_match("/\s+as\s+/i",$key)>0)
					{
						$farr=array();
						preg_match_all("/(\w+)\s+as\s+(\w+)/i",$key,$farr);
						$temparr[$farr[2][0]]=$rows[$i][$farr[1][0]];
					}
					else
					{
						$temparr[$key]=$rows[$i][$key];
					}
				}
				array_push($rsarr,$temparr);
	        }
		}
		else
        {
        	  $rsarr=$rows;
        }
		return $rsarr;
    }

    public function getWsClientResult($method,$para,$url=""){
        if($url!="")$this->url=$url;
		return $this->wsclient->getResult($method,$para,$this->url);
    }

    function getWsClientSoapResult($method,$para,$url=""){
    	 if($url!="")$this->url=$url;
		 return $this->wsclient->getSoapResult($method,$para,$this->url);
    }

	/**
	 * 据flagxml返回数据集
	 *  $url="http://localhost:8686/LHBSystem/index.php?act=test";
    	$xml=submit_post($url);
     	//$row=$this->getReturn_FlageRow("http://localhost:8686/LHBSystem/index.php?act=test");
		$row=$this->getReturn_FlageRow("",$xml);
	 */
	public function getReturn_FlageRow($xmlurl="",$xml=""){
		$xmlutil=new XmlDbUtil();
		if($xml!="")$xmlutil->setXmlContent($xml);
		if($xmlurl!="")$xmlutil->setXmlPath($xmlurl);
		$xmlutil->setRoot("/root");
		$inarr=array("count"=>"","return"=>"","returnflag"=>"","message"=>"");
		$row=@$this->getSelectXmlResultII($inarr,$xmlutil);
		return $row;
	}

	/**
	 * 返回错误row
	 */
	function flag_row($return="",$flag="",$count="0",$message=""){
	    $rsrow=array();
	    $rsrow["count"]=$count;
		$rsrow["flag"]=$flag;
		$rsrow["return"]=$return;
		$rsrow["message"]=$message;
		return $rsrow;
	}


	/**
	 * 设置单个值
	 */

	function set_para($id,$key,$value){
		$flag=false;
		$para=array($key=>$value);
		if(preg_match("/\./i",$id)>0){
			$idarr=explode(".",$id);
			$w=$this->keyid."=";
			if($idarr[1]=="string"){
				$w.=$this->keyid."='".$idarr[0]."'";
			}else {
                $w.=$this->keyid."=".$idarr[0]."";
			}
		}else{
			$w.=$this->keyid."='".$id."'";
		}
		$flag=$this->getUpdateResult($para,$w);
		return $flag;

	}


	/**
	 * 设置多个值
	 */

	function set_paras($id,$para){
		$flag=false;
		if(preg_match("/\./i",$id)>0){
			$idarr=explode(".",$id);
			$w=$this->keyid."=";
			if($idarr[1]=="string"){
				$w.=$this->keyid."='".$idarr[0]."'";
			}else {
                $w.=$this->keyid."=".$idarr[0]."";
			}
		}else{
			$w.=$this->keyid."='".$id."'";
		}
		$flag=$this->getUpdateResult($para,$w);
		return $flag;
	}
}
?>