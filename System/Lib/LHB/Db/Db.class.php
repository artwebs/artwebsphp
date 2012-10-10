<?php

class Db extends LHB {
	private $dbTop="";
	protected $dbType="";
	protected $dbConnStr="";
	protected $dbUser="";
	protected $dbPwd="";
	protected $conn;

   public function __construct($Top=""){
	   $this->dbTop=$Top;
       $this->dbType=C($this->dbTop."DB_TYPE");
       $this->dbConnStr=C($this->dbTop."DB_CONNSTR");
       $this->dbUser=C($this->dbTop."DB_USER");
       $this->dbPwd=C($this->dbTop."DB_PWD");
   }
   public function getConnection($para=array()){
   		try{
   			//echo $this->dbTop;
			$this->conn = new PDO($this->dbConnStr,$this->dbUser,$this->dbPwd,$para);
			switch(C('PDO_CASE'))
			{
				case 'LOWER':
					$this->conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
					break;
				case 'UPPER':
					$this->conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);
					break;
				default:
					$this->conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			}
   		}catch(PDOException $e){
			echo $e->getMessage();
			die();
   		}
    }
    public function closeConn(){
		if(!empty($this->conn))$this->conn=null;
    }
	public function query($sql){
		log_debug($sql);
		$this->getConnection();
    	$rs = $this->conn->query($sql);
    	$row=$rs->fetchall(PDO::FETCH_ASSOC);
    	$this->closeConn();
    	return $row;
	}
	public function execute($sql){
		log_debug($sql);
		$flag=false;
		$this->getConnection();
		$count = $this->conn->exec($sql);
		if($count>0)$flag=true;
		$this->closeConn();
		return $flag;
	}

	public function startprepare($sql){
		log_debug($sql);
		$this->getConnection();
		return $this->conn->prepare($sql);
	}

	public function endprepare(&$stmt){
		$stmt->execute();
		$this->closeConn();
	}


}
?>