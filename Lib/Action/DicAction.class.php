<?php

class DicAction extends ActionDic{
	/**
	 * http://localhost/LHBSystem_1/index.php?mod=Dic&act=diclist&groupname=xb
	 */
    function DicAction() {
    	parent::__construct(new DicModel());
    }
}
?>