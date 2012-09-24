<?php

class MessageModel extends Model {
	//public $top="21OCI";
    public $tableName="T_OUTMESSAGES";


    function getRow(){
    	$url="http://localhost:8686/LHBSystem/index.php?act=test";
    	$xml=submit_post($url);
//    	$row=$this->getReturn_FlageRow("http://localhost:8686/LHBSystem/index.php?act=test");
		$row=$this->getReturn_FlageRow("",$xml);
    	return $row;
    }
    function getTableName(){
		echo __CLASS__;
    }
}
?>