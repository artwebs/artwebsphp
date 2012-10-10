<?php

class ModelDic extends Model {
	protected $keyfield="";
	protected $valuefield="";
	protected $groupfield="";
	function ModelDic($tblname="",$Top="") {
    	parent::__construct($tblname,$Top);
    }

    function dicout($groupname,$key,$flag=true){
		$row=$this->dic($groupname);
		if($row!=false&&array_key_exists($key,$row)){
			return $row[$key];
		}else{
			return $flag?$key:"";
		}
    }

    function dicin($groupname,$value,$flag=true){
		$row=$this->dic($groupname);
		if($row!=false&&$key=array_search ($value,$row)){
			return $key;
		}else{
			return $flag?$value:"";
		}
    }

    function diclist($groupname){
		$row=$this->dic($groupname);
		return $this->arrayTorows($row);
    }

	function dic($groupname){
		$flag=false;
		$filename=$this->getFileName($groupname);
		if($rows=get_runtime($filename)){
			return $rows;
		}else{
			$rows=$this->select_rows($groupname);
			if(count($rows)>0){
				$part=$this->arrayTostring($rows,$groupname);
				create_runtime($part,$filename);
				return $this->rowsToarray($rows);
			}
		}
		return $flag;
	}


	function select_rows($groupname){
		$para=array(
					$this->keyfield=>"",
					$this->valuefield=>"",
					$this->groupfield=>"",
					);
		$w=$this->groupfield."='".$groupname."'";
		$rows=$this->getSelectResult($para,$w);
		return $rows;
	}

	function arrayTostring($rows,$groupname){
		   $rs="";
		    for($i=0;$i<count($rows);$i++){
		    	$rs.="          '".$rows[$i][$this->keyfield]."'=>'".$rows[$i][$this->valuefield]."',\n";
		    }
			return $rs;
	}

	function rowsToarray($rows){
		$row=array();
		for($i=0;$i<count($rows);$i++){
			array_push_hash($row,$rows[$i][$this->keyfield],$rows[$i][$this->valuefield]);
		}
		return $row;
	}

	function arrayTorows($row){
		$rows=array();
		if($row)
		foreach($row as $key=>$value){
			$rows[]=array("DICKEY"=>$key,"DICVALUE"=>$value);
		}
		return $rows;
	}

	function getFileName($groupname)
	{
    	return get_class($this).$this->groupfield.$this->keyfield.$this->valuefield.$groupname;
	}
}
?>