<?php

class MssqlModel extends DbModel{
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
		$sql="select c.name, t.name as type, c.length
  			 	,(case t.name
   			 	when 'nvarchar' then c.length/2
   			 	when 'nchar' then c.length/2
    			else c.length
  				end)
  				as reallength
				from syscolumns c join systypes t
				on c.xtype=t.xtype
				where t.name <> 'sysname' and c.id=object_id('".$this->tableName."')";
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
			if($rows[$i]["type"]=="datetime"){
				array_push_hash($rsarr,"CONVERT(char(19), ".$rows[$i][$name].", 121) as ".$rows[$i][$name],$rows[$i][$name]);
			}else{
				array_push_hash($rsarr,$rows[$i][$name],$rows[$i][$name]);
			}
		}

		return $rsarr;
	}
}
?>