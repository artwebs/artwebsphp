<?php

class adminAction extends AseSiteUi {
	/**
	 * http://localhost/artwebsphp/index.php?mod=admin&act=content
	 */
	public function content()
	{
		$this->initMain();
		return $this->response();
	}
}
?>