<?php

abstract class Control {
	protected $obj;
	protected $ctltype;
	protected $ctlpara;
    function Control($obj) {
    	$this->obj=$obj;
    }

    public function getObj()
    {
		return $this->obj;
    }

    public function setContoleType($ctltype)
    {
		$this->ctltype=$ctltype;
    }

    public function setContolePara($ctlpara,$rowline=null)
    {
		$this->ctlpara=$ctlpara;
		$this->rowline=$rowline;
		if(is_string($this->ctlpara))return;
		if(!array_key_exists("name",$this->ctlpara))array_push_hash($this->ctlpara,'name','');
    	if(!array_key_exists("cname",$this->ctlpara))array_push_hash($this->ctlpara,'cname','');
    	if(!array_key_exists("value",$this->ctlpara))array_push_hash($this->ctlpara,'value','');
    	if(!array_key_exists("display",$this->ctlpara))array_push_hash($this->ctlpara,'display',"true");
    	if(!array_key_exists("matche",$this->ctlpara))array_push_hash($this->ctlpara,'matche','');
    	if(!array_key_exists("conmethod",$this->ctlpara))array_push_hash($this->ctlpara,'conmethod','TEXTBOX');
    	if(!array_key_exists("conurl",$this->ctlpara))array_push_hash($this->ctlpara,'conurl','');
    	if(!array_key_exists("readonly",$this->ctlpara))array_push_hash($this->ctlpara,'readonly',false);
    	if(!array_key_exists("dicvalue",$this->ctlpara))array_push_hash($this->ctlpara,'dicvalue','');
    	if(!array_key_exists("nexturl",$this->ctlpara))array_push_hash($this->ctlpara,'nexturl',false);
    	if(!array_key_exists("checkboxurl",$this->ctlpara))array_push_hash($this->ctlpara,'checkboxurl',false);
    	if(!array_key_exists("getvalue",$this->ctlpara))array_push_hash($this->ctlpara,'getvalue',false);
    	if(!array_key_exists("maxcount",$this->ctlpara))array_push_hash($this->ctlpara,'maxcount',false);


    }

    public abstract function draw();

}
?>