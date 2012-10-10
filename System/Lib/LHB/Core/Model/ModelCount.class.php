<?php

class ModelCount extends Model {
    protected $countNameField;
    protected $countNameValue;
    protected $ranmin=0;
    protected $ranmax=0;
    function ModelCount($tblname="",$Top="") {
    	parent::__construct($tblname,$Top);
    }
    public function getNewId($countName){
		$countvalue="";
		$inarr=array($this->countNameField=>$countName,
					 $this->countNameValue=>"0"
		             );
		$outarr=$this->getSelectResult($inarr,$this->countNameField."='".$countName."'");
		if(count($outarr)>0){
			//print_r($outarr);
			$countvalue=$outarr[0][$this->countNameValue];
		}else{
			$this->getInsertResult($inarr);
			$countvalue="0";
		}

		$inarr=array($this->countNameValue.".realstring"=>$this->countNameValue."+1");
		$this->getUpdateResult($inarr,$this->countNameField."='".$countName."'");
		return $countvalue;
    }

    public function getRanNewId($countName,$len){
    	$rs="";
    	$ran=mt_rand($this->ranmin,$this->ranmax)*5+mt_rand($this->ranmin,$this->ranmax)*5-1;
		$ran=$ran%$this->ranmax;
		$id=$this->getNewId($countName);
		if($len>strlen($id)+Strlen($ran)-1){
			$rs=str_pad($id, $len-strlen($ran)+1, "0", STR_PAD_LEFT)+str_pad($ran, strlen($ran)-1, "0", STR_PAD_LEFT);
		}else{
			$rs=str_pad($id,$len, "0", STR_PAD_LEFT);
		}
		return $rs;
    }

}
?>