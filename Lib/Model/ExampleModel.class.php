<?php

class ExampleModel extends Model {
	public $top="App_";
	public $tableName="example";

	/**
	 * 根据用户编号查询用户信息	 *
	 */
	function userinfo($id)
	{
		$w="id='$id'";
		$rows=$this->getSelectResult(array(),$w);
		return $rows;
	}

	/**
	 * 根据性别或来源查询用户信息
	 */
	function users($sex,$source)
	{
		$w='';
		if($sex!='')$w.="sex='$sex' and ";
		if($source!='')$w.="source='$source' and ";
		$w.='1=1';
		$rows=$this->getSelectResult(array(),$w);
		return $rows;
	}
}
?>