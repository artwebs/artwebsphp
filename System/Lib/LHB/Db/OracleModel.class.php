<?php

class OracleModel extends DbModel {
	public function getTableName($child=""){
		$rs="";
		if($child=="")$child=get_class($this);
		if(preg_match("/Model/i",$child)==1)$child=substr($child,0,strrpos($child,"Model"));
		if(preg_match("/Plugin/i",$child)==1)$child=substr($child,0,strrpos($child,"Plugin"));
		$arr=array();
		preg_match_all("([A-Z][a-z]*)",$child,$arr);
		for($i=0;$i<count($arr[0]);$i++){
			$rs.=strtoupper($arr[0][$i]);
			if($i!=count($arr[0])-1)$rs.="_";
		}
		return $rs;
	}
	public function getTableCols(){
		$rsarr=array();
		$sql="select column_name,data_type,data_length,data_precision,data_scale from user_tab_columns where table_name='".$this->tableName."'";
		$rows=$this->query($sql);
		$name='';
		switch(C('PDO_CASE'))
			{
				case 'LOWER':
					$name='column_name';
					break;
				case 'UPPER':
					$name='COLUMN_NAME';
					break;
				default:
				 	$name='column_name';
			}
		for($i=0;$i<count($rows);$i++){
			if($rows[$i]["DATA_TYPE"]=="DATE"){
				array_push_hash($rsarr,"to_char(".$rows[$i][$name].",'yyyy-mm-dd hh24:mi:ss') as ".$rows[$i][$name],$rows[$i][$name]);
			}else{
				array_push_hash($rsarr,$rows[$i][$name],$rows[$i][$name]);
			}
		}

		return $rsarr;
	}
}
?>