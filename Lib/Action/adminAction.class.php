<?php

class adminAction extends AseSiteUi {
	/**
	 * http://localhost/LHBSystem_1/index.php?mod=admin&act=content
	 */
	public function content()
	{
		$this->initMain();
		return $this->response();
	}
}
?>