<?php

abstract class DbModel extends Db {
	private $dbutil;
	protected $tableName="";
	protected $top="";
	protected static $cols;
    public function __construct($tblname="",$Top="",$child=""){
    	if($Top!="")$this->top=$Top;
    	parent::__construct($this->top);
    	$this->dbutil=new DbUtil();
    	if($tblname!="")$this->tableName=$tblname;
//    	log_debug("模型类2:".$child);
		if($this->tableName=="")$this->tableName=$this->getTableName($child);
//		if(count(self::$cols)==0)self::$cols=$this->getTableCols();
    }

	abstract function getTableName($child="");

	abstract function getTableCols();

    public function getSelectResult($inpara=array(),$where="",$tblname=""){
    	$w="";
    	if($tblname!="")$this->tableName=$tblname;
    	if(count($inpara)==0)$inpara=$this->getTableCols();
    	if($where!=null)$w=" where ".$where;
		$fpart=$this->dbutil->getSelectPart($inpara);
		if($fpart=="")$fpart="*";
		$sql="select ".$fpart." from ".$this->tableName.$w;
		$rs=$this->query($sql);
		return $rs;
    }
    public function getDeleteResult($where,$tblname=""){
    	if($tblname!="")$this->tableName=$tblname;
		$sql="delete from ".$this->tableName." where ".$where;
		$rs=$this->execute($sql);
		return $rs;
    }

    public function getInsertResult($inpara,$tblname=""){
    	if($tblname!="")$this->tableName=$tblname;
		$sql="insert into ".$this->tableName." ".$this->dbutil->getInsertPart($inpara);
		$rs=$this->execute($sql);
		return $rs;
    }

    public function getUpdateResult($inpara,$where="",$tblname=""){
		$w="";
    	if($tblname!="")$this->tableName=$tblname;
    	if($where!="")$w=" where ".$where;
    	//write_log($inpara);
    	//write_log($this->dbutil->getUpdatePart($inpara));
		$sql="update ".$this->tableName." set ".$this->dbutil->getUpdatePart($inpara).$w;
		$rs=$this->execute($sql);
		return $rs;

    }

    public function callProcedure($procName,$inarr=array(),&$outarr=array()){
    	$wh="";
    	$mcount=count($inarr)+count($outarr);
    	for($i=0;$i<$mcount;$i++){
			$wh.="?";
			if($i!=$mcount-1)$wh.=",";
    	}
    	$stmt=$this->startprepare("CALL ".$procName."(".$wh.")");
		log_debug("CALL ".$procName."(".$wh.")");
		$this->dbutil->getProdurceParam($stmt,$inarr,$outarr);

		$this->endprepare($stmt);
		$stmt->execute();

    }

    public function callTransaction($trans){
    	$rs=false;
		try {
		  $this->getConnection();
		  $this->conn->beginTransaction();
		  foreach($trans as $key=>$value){
			  $this->conn->exec($value);
		  }
		  $rs=$this->conn->commit();
		} catch (Exception $e) {
		  $this->conn->rollBack();
		  $rs=$e->getMessage();
		}
		return $rs;
    }

}
?>