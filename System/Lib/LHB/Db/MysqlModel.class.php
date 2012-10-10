<?php

class MysqlModel  extends DbModel {
	public function getConnection($para = array()){
   		try{
   			//echo $this->dbTop;
			$this->conn = new PDO($this->dbConnStr,$this->dbUser,$this->dbPwd);

			switch(C('PDO_CASE'))
			{
				case 'LOWER':
					$this->conn->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
					break;
					break;
				case 'UPPER':
					$this->conn->setAttribute(PDO::ATTR_CASE,PDO::CASE_UPPER);
					break;
			}
			$this->conn->query("set names 'utf8'");
   		}catch(PDOException $e){
			echo $e->getMessage();
			die();
   		}
    }
	public function getTableName($child=""){
		$rs="";
		if($child=="")$child=get_class($this);
		if(preg_match("/Model/i",$child)==1)$child=substr($child,0,strrpos($child,"Model"));
		if(preg_match("/Plugin/i",$child)==1)$child=substr($child,0,strrpos($child,"Plugin"));
		$arr=array();
		preg_match_all("([A-Z][a-z]*)",$child,$arr);
		for($i=0;$i<count($arr[0]);$i++){
			$rs.=strtolower($arr[0][$i]);
			if($i!=count($arr[0])-1)$rs.="_";
		}
		return $rs;
	}
	public function getTableCols(){
		$rsarr=array();
		$sql="SHOW COLUMNS FROM ".$this->tableName;
		$rows=$this->query($sql);
		$name='field';
		switch(C('PDO_CASE'))
			{
				case 'LOWER':
					$name='field';
					break;
				case 'UPPER':
					$name='FIELD';
					break;
				default:
				 	$name='Field';
			}
		for($i=0;$i<count($rows);$i++){
			array_push_hash($rsarr,$rows[$i][$name],$rows[$i][$name]);
		}

		return $rsarr;
	}
}
?>