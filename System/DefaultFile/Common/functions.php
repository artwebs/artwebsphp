<?php
 function App_init(){
//	echo "App_init function";
 }

 function App_distruct($rs,$rsflag)
 {
	if(is_string($rs)&&!$rsflag){
        echo $rs;
     }elseif(!$rsflag){
        print_r($rs);
     }else{
     	return $rs;
     }
 }
 function App_add(){
	    $m=new MessageModel();
	    $page=0;
	    $inarr=array("MESSAGEID"=>'');
		$rows=$m->getSelectResult($inarr);
		$rs=rows_page($rows,$page);
		return $rs;
 }


?>
