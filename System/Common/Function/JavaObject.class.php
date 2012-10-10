<?php

class JavaObject {

    function JavaObject() {
    }


    function intance($class,$var1=null){
    	$rs=null;
    	$data=C('JAVA_OBJECT');
		$class=$data[$class];
		if($var1==null){
			$class=new Java($class);
		}else{
			$class=new Java($class,$var1);
		}
		return $class;
    }

}
?>