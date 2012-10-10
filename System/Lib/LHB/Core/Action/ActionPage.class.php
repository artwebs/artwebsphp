<?php

class ActionPage extends Action {
	protected $header;
	protected $scriptContent='';
	protected $cssContent='';

	public function __construct()
	{
    	parent::__construct();
    	$this->init();
    }

   	public function init()
   	{
		$this->init_header();
   	}

	public function init_header()
	{
		$this->include_css("./System/Css/jquery-ui-1.8.13.custom.css");
		$this->include_js("./System/Js/jquery-1.5.1.min.js");
		$this->include_js("./System/Js/jquery-ui-1.8.13.custom.min.js");
		$this->include_css("./Css/style.css");
	}

	public function include_txt($txt)
	{
		$this->header.=$txt;
	}
   	public function include_js($file)
   	{

   		if(!strpos($file,'/'))$file="./Js/".$file;
		if(file_exists($file))$this->header.="<script src=\"".$file."\" type=\"text/javascript\"></script>\n";
   	}

   	public function include_css($file,$media="")
   	{
   		if(!strpos($file,'/'))$file="./Css/".$file;
   		if($media!='')$media="media=\"$media\"";
		if(file_exists($file))$this->header.="<link href=\"".$file."\"  rel=stylesheet type=\"text/css\" $media />\n";
   	}

   	public function assign_js($name,$file)
   	{
		if(!strpos($file,'/'))$file="./Js/".$file;
		if(file_exists($file))$content="<script src=\"".$file."\" type=\"text/javascript\"></script>";
   		$this->assign($name,$content);
   	}

   	public function assign_css($name,$file)
   	{
		if(!strpos($file,'/'))$file="./Js/".$file;
		if(file_exists($file))$content="<link href=\"".$file."\" rel=stylesheet type=\"text/css\"/>";
   		$this->assign($name,$content);
   	}

	public function include_tree()
	{
		$this->include_css('./System/Css/jquery.tree.css');
		$this->include_js('./System/Js/jquery.tree.js');
	}

	public function appendScript($content)
	{
		$this->scriptContent.=$content;
	}

	public function appendCss($content)
	{
		$this->cssContent.=$content;
	}

 	public function display($templateFile='')
 	{
 		$this->include_js($this->model.'.js');
		$this->include_js($this->model.'.'.$this->action.'.js');
		$this->include_css($this->model.'.css');
		$this->include_css($this->model.'.'.$this->action.'.css');
		if($this->cssContent!='')
		{
			$this->header.=<<<EOT
			<style type="text/css">
				{$this->cssContent}
			</style>
EOT;
		}

		if($this->scriptContent!='')
		{
			$this->header.=<<<EOT
			<script type="text/javascript">
				{$this->scriptContent}
			</script>
EOT;
		}
		$this->assign('header',$this->header);
 		parent::display($templateFile);
 	}
   	public function response()
	{
		return $this->smarty->display($this->templateFile);
	}





}
?>