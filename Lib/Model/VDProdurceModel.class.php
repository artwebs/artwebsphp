<?php

class VDProdurceModel extends Model {
    function VDProdurceModel() {
    	parent::__construct("t_user_info","21");
    }

    function callTrans(){
    	$trans=array();
    	$trans[]="insert into person (userid,username,userpwd) values ('2','nu2','nu2')";
    	$trans[]="insert into person (userid,username,userpwd) values ('3','nu3','nu3')";
    	$trans[]="insert into person (userid,username,userpwd) values ('4','nu4','nu4')";
    	$rs=$this->callTransaction($trans);
    	var_dump($rs);
    }

    function callProc(){
    	$out=array('username.cursor'=>'');
    	$this->callProcedure("getall",array(),$out);
    	var_dump($out);
    }

    function deletedata(){
		$w="userid='1'";
		$this->getDeleteResult($w,"person");
    }


}
?>