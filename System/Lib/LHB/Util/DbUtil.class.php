<?php

class DbUtil  {
    public function DbUtil() {
    }
	public function getSelectPart($inarr){
		$rs="";
		foreach($inarr as $key=>$value){
			if(preg_match("/\./i",$key)>0&&preg_match("/\s+as\s+/i",$key)<=0){
				$keyarr=explode(".",$key);
				$rs.=$keyarr[0].",";
			}else{
				$rs.=$key.",";
			}
		}
		$rs=substr($rs,0,strlen($rs)-1);
		return $rs;
	}

    public function getUpdatePart($inarr){
		$rs="";
		foreach($inarr as $key=>$value){
			if(preg_match("/\./i",$key)>0){
				$keyarr=explode(".",$key);
				$rs.=$keyarr[0]."=";
				if($keyarr[1]=="string"){
					$rs.="'".$value."',";
				}else {
                     $rs.=$value.",";
				}

			}else{
				$rs.=$key."='".$value."',";
			}
		}
		$rs=substr($rs,0,strlen($rs)-1);
		return $rs;
	}

    public function getInsertPart($inarr){
		$rs="";
		$f="";
		$v="";
		foreach($inarr as $key=>$value){
			if(preg_match("/\./i",$key)>0){
				$keyarr=explode(".",$key);
				$f.=$keyarr[0].",";
				if($keyarr[1]=="string"){
					$v.="'".$value."',";
				}else {
                     $v.=$value.",";
				}

			}else{

				$f.=$key.",";
				$v.="'".$value."',";
			}
		}
		$f=substr($f,0,strlen($f)-1);
		$v=substr($v,0,strlen($v)-1);
		$rs="(".$f.") values (".$v.")";
		return $rs;
	}


	function getProdurceParam(&$stmt,$inarr,&$outarr){
		$rslog="(";
		$i=1;
		foreach($inarr as $key=>$value){
			if(preg_match("/\./i",$key)>0){
				$keyarr=explode(".",$key);
				if($keyarr[1]=="string"){
					$stmt->bindValue($i, $value);
				}else {
                    $stmt->bindValue($i, $value);
				}

			}else{
				$stmt->bindValue($i, $value);
			}
			$rslog.=$i.'=>'.$value.',';
			$i++;
		}

		foreach($outarr as $key=>$value){
			if($value=="")$value=100;
			if(preg_match("/\./i",$key)>0){
				$keyarr=explode(".",$key);
				if($keyarr[1]=="string"){
					$stmt->bindParam($i,$outarr[$keyarr[0]], PDO::PARAM_STR, $value);
				}else if($keyarr[1]=="cursor"){
//					$stmt->bindParam($i,$outarr[$keyarr[0]], PDO::PARAM_LOB,$value);
//					$stmt->bindParam($i,$outarr[$keyarr[0]], PDO::PARAM_INPUT_OUTPUT, $value);
				}else {
                    $stmt->bindParam($i,$outarr[$keyarr[0]],  PDO::PARAM_INT, $value);
				}
				$rslog.=$i.'=>'.$outarr[$keyarr[0]].',';
				array_splice($outarr,$key,1);

			}else{
				$stmt->bindParam($i,$outarr[$key],  PDO::PARAM_STR, $value);
				$rslog.=$i.'=>'.$outarr[$key].',';
			}
			$i++;
		}
		$rslog.=')';
		log_debug($rslog);
	}

}

//$arr=array("in"=>"1111111","in2.string"=>"1111111");
//print_r($arr);
//$du=new DbUtil();
//echo $du->getInsertPart($arr);

?>