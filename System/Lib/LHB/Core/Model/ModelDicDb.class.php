<?php

class ModelDicDb extends Model {
	private	$dicDb;
	protected $keyfield="";
	protected $valuefield="";
	protected $groupfield="";
	function ModelDicDb($tblname="",$Top="")
	{
		parent::__construct($tblname,$Top);
		$this->dicDb=new ModelApp();
	}

    function dicout($groupname,$key,$flag=true){
		$this->dic($groupname);
		$rows=$this->selectDic($groupname,$key);
		if(count($rows)>0){
			return $rows[0]['DICVALUE'];
		}else{
			return $flag?$key:"";
		}
    }

    function dicin($groupname,$value,$flag=true){
		$this->dic($groupname);
		$rows=$this->selectDic($groupname,'',$value);
		if(count($rows)>0){
			return $rows[0]['DICKEY'];
		}else{
			return $flag?$value:"";
		}
    }

    function diclist($groupname){
		$this->dic($groupname);
		$rows=$this->selectDic($groupname);
		return $rows;
    }

    function selectDic($groupname,$key="",$value="")
    {
		$w="GROUPNAME='$groupname' and ";
		if($key!="")$w.="DICKEY='$key' and ";
		if($value!="")$w.="DICVALUE='$value' and ";
		$w.="1=1";
		$rows=$this->dicDb->getSelectResult(array(),$w);
		return $rows;
    }

    function dic($groupname){
		$row=$this->dicDb->getSelectResult(array('count(*) as tcount'=>''),"groupname='$groupname' and dicversion='".C('DICVERSION')."'");
		if($row[0]['TCOUNT']==0){
			$rows=$this->select_rows($groupname);
//			$this->dicDb->getDeleteResult("groupname='$groupname'");
			$sql="BEGIN;";
			$sql.="delete from ".$this->dicDb->tableName." where groupname='$groupname';";
			$i=1;
			foreach($rows as $row)
			{
				$sql.="insert into ".$this->dicDb->tableName." (groupname,dickey,dicvalue,dicversion) values ('".$groupname."','".$row[$this->keyfield]."','".$row[$this->valuefield]."','".C('DICVERSION')."');";
				$i++;
				if($i%100==0)
				{
					$sql.="COMMIT;";
					$this->dicDb->execute($sql);
					$sql="BEGIN;";
				}
			}
			$sql.="COMMIT;";
			$this->dicDb->execute($sql);
		}
	}

	function select_rows($groupname){
		$para=array(
					$this->keyfield=>"",
					$this->valuefield=>"",
					$this->groupfield=>"",
					);
		$w=$this->groupfield."='".$groupname."'";
		$rows=$this->getSelectResult($para,$w,$this->tableName);
		return $rows;
	}

}
?>