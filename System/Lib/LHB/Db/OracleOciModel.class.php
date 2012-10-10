<?php

class OracleOciModel extends OracleModel {
	public function getConnection($para = array()){
   		try{
   			//echo $this->dbTop;
			$this->conn =oci_connect($this->dbUser,$this->dbPwd,$this->dbConnStr,'UTF8');

   		}catch(Exception $e){
			echo $e->getMessage();
			die();
   		}
    }
	public function query($sql){
		log_debug($sql);
		$row=array();
		$rows=array();
		$this->getConnection();
		$stmt=oci_parse($this->conn,$sql);
		oci_execute ($stmt);
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$rows[]=$row;
		}
		$this->closeConn();
		return $rows;
	}
	public function execute($sql){
		log_debug($sql);
		$rsflag=false;
		$this->getConnection();
		$stmt=oci_parse($this->conn,$sql);
		$flag=oci_execute($stmt,OCI_DEFAULT);
		if($flag){
			if(oci_num_rows($stmt)>0)$rsflag=true;
		}else{
			oci_rollback($flag);
		}
		oci_commit($this->conn);
		$this->closeConn();
		return $rsflag;

	}

	public function callProcedure($procName,$inarr=array(),&$outarr=array()){
    	$this->getConnection();
    	$wh=$this->getProdurceName($inarr,$outarr);
		$sql = "BEGIN ".$procName."(".$wh."); END;";
		log_debug($sql);
		$stmt = oci_parse($this->conn,$sql);
		$rs='';
		$this->getProdurceParam($stmt,$inarr,$outarr);
		oci_execute($stmt);
		$this->getProcedureReult($outarr);
		oci_free_statement($stmt);
		$this->closeConn();

    }

    function getProdurceName($inarr,$outarr)
    {
    	$wh="";
		$ninarr=$this->getNoexParam($inarr);
		$noutarr=$this->getNoexParam($outarr);
		$aarr=array_merge($ninarr,$noutarr);
		foreach($aarr as $key=>$value)
		{
			$wh.=':'.$key.',';
		}
		$wh=substr($wh,0,-1);
		return $wh;
    }

    function getProdurceParam(&$stmt,$inarr,&$outarr){
    	$rslog="(";
		foreach($inarr as $key=>$value){
			if(preg_match("/\./i",$key)>0){
				$keyarr=explode(".",$key);
				oci_bind_by_name($stmt,":".$keyarr[0],$inarr[$key]);
				$rslog.=$keyarr[0].'=>'.$inarr[$key].",";
			}else{
				oci_bind_by_name($stmt,":".$key,$inarr[$key]);
				$rslog.=$key.'=>'.$inarr[$key].",";
			}

		}

		foreach($outarr as $key=>$value){
			if(preg_match("/\./i",$key)>0){
				$keyarr=explode(".",$key);
				if($keyarr[1]=="string"){
					oci_bind_by_name($stmt,":".$keyarr[0],$outarr[$key],40);
				}else if($keyarr[1]=="cursor"){
					$value = oci_new_cursor($this->conn);
					oci_bind_by_name($stmt,":".$keyarr[0],$value, -1, OCI_B_CURSOR);
					$outarr[$key]=$value;
				}else if($keyarr[1]=="integer"){
                    oci_bind_by_name($stmt,":".$keyarr[0],$outarr[$key],32);
				}
				$rslog.=$keyarr[0].",";
			}else{
				oci_bind_by_name($stmt,":".$key,$outarr[$key], 40);
				$rslog.=$key.",";
			}
		}
		$rslog.=');';
		log_debug($rslog);
	}

    function getProcedureReult(&$outarr)
    {
		$rsarr=array();
		foreach($outarr as $key=>$value){
			if(preg_match("/\./i",$key)>0){
				$keyarr=explode(".",$key);
				if($keyarr[1]=="string"){
					$rsarr[$keyarr[0]]=$value;
				}else if($keyarr[1]=="cursor"){
					oci_set_prefetch($value, 200);
					oci_execute($value);
					$rows=array();
					while($row=oci_fetch_array($value,OCI_ASSOC)){
						$rows[]=$row;
					}
					$rsarr[$keyarr[0]]=$rows;
					oci_free_statement($value);
				}else if($keyarr[1]=="integer"){
                    $rsarr[$keyarr[0]]=$value;
				}

			}else{
				$rsarr[$key]=$value;
			}
		}
		$outarr=$rsarr;
    }


	function getNoexParam($inarr)
	{
		$rsarr=array();
		foreach($inarr as $key=>$value){
			if(preg_match("/\./i",$key)>0&&preg_match("/\s+as\s+/i",$key)<=0){
				$keyarr=explode(".",$key);
				$rsarr[$keyarr[0]]=$value;
			}else{
				$rsarr[$key]=$value;
			}
		}
		return $rsarr;
	}

	public function closeConn(){
		if(!empty($this->conn))oci_close($this->conn);
    }

}
?>