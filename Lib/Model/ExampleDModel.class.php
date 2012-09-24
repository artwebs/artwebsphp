<?php

class ExampleDModel extends ModelDic {
	public $top="App_";
	protected $keyfield="DICKEY";
	protected $valuefield="DICVALUE";
	protected $groupfield="GROUPNAME";
	public $tableName="example_dic";

	function composeString($groupname,$sex,$source)
	{
		return $this->dicout($groupname,$sex).'_'.$source;
	}
}
?>