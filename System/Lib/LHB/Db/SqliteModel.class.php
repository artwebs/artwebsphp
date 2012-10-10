<?php

class SqliteModel extends DbModel{
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
		$sql="PRAGMA table_info(".$this->tableName.")";
		$rows=$this->query($sql);
		$name='';
		switch(C('PDO_CASE'))
			{
				case 'LOWER':
					$name='name';
					break;
				case 'UPPER':
					$name='NAME';
					break;
				default:
				 	$name='name';
			}
		for($i=0;$i<count($rows);$i++){
			array_push_hash($rsarr,$rows[$i][$name],$rows[$i][$name]);
		}

		return $rsarr;
	}
}
?>