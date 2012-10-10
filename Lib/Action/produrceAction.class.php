<?php

class produrceAction extends ActionXmlI {

	/**
	 * http://localhost/artwebsphp/index.php?mod=produrce&act=rsstring
	 */
 	function rsstring()
 	{
		$pro=new ProdurceModel();
		$outarr=array("rs.string"=>"");
		$pro->callProcedure("getrecodes",array(),$outarr);
		print_r($outarr);
 	}

 	/**
	 * http://localhost/artwebsphp/index.php?mod=produrce&act=addstring
	 */
 	function addstring()
 	{
		$pro=new ProdurceModel();
		$inarr=array('a'=>'11','b'=>'22');
		$outarr=array("rs.string"=>"");
		$pro->callProcedure("addstr",$inarr,$outarr);
		print_r($outarr);
 	}

 	/**
	 * http://localhost/artwebsphp/index.php?mod=produrce&act=addint
	 */
 	function addint()
 	{
		$pro=new ProdurceModel();
		$inarr=array('a'=>'11','b'=>'22');
		$outarr=array("rs.integer"=>"");
		$pro->callProcedure("addpro",$inarr,$outarr);
		print_r($outarr);
 	}

	/**
	 * http://localhost/artwebsphp/index.php?mod=produrce&act=rsrow
	 */
 	function rsrow()
 	{
		$pro=new ProdurceModel();
		$inarr=array();
		$outarr=array("query_result.cursor"=>"");
		$pro->callProcedure("getcur",$inarr,$outarr);
		print_r($outarr);
 	}

 	/**
	 * http://localhost/artwebsphp/index.php?mod=produrce&act=addint2
	 */
 	function addint2()
 	{
		$pro=new ProdurceModel();
		$inarr=array('a1'=>'abc','a2'=>'1','a3'=>'2','a4'=>'2011-11-25 12:00:00');
		$outarr=array("code"=>"","message"=>"");
		$pro->callProcedure("insert_aab",$inarr,$outarr);
		print_r($outarr);
 	}

}
?>