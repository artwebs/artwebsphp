<?php

class Log4j {
	private $loglevel;
	private $logclass=array();

	/**
	 * Debug调试 Info信息 Warn警告 Error错误 Fatal致命错误
	 */
    function Log4j() {
		$this->logclass=C("App_LogClass");
		$this->loglevel=$this->logclass[C("App_LogLevel")];
    }

    function log_debug($text){
		$this->log_flag($text,"debug");
    }

    function log_info($text){
		$this->log_flag($text,"info");
    }

    function log_warn($text){
		$this->log_flag($text,"warn");
    }

    function log_error($text){
		$this->log_flag($text,"error");
    }

    function log_fatal($text){
		$this->log_flag($text,"fatal");
    }

	function log_flag($text,$type){
		if($this->loglevel<=$this->logclass[$type]){
			$this->append_log($text,$type);
		}
	}

    function append_log($text,$type){
	    $dir=C("App_LogFilePath");
	    if(!is_dir($dir)){
	        mkdir("$dir", 0700);
	        mkdir($dir);
	    }
	    $file=$dir."/".str_replace("[date]",date("Ymd"),C("App_LogFileName"));
		$fileData="";
		if(!file_exists($file))$fileData.="<?php exit('no direct access allowed');?>\r\n";
	    @$fp = fopen($file,"a+");
	    if(!$fp){
	        echo "system error";
	        exit();
	    }
	    $raw_post_data = file_get_contents('php://input', 'r');
	    $fileData.= date("Y-m-d H:i:s")." [".$type."] ";
	    $fileData.=$text;
	    $fileData.= "\r\n";
	    fwrite($fp,$fileData);
	    fclose($fp);
    }
}
?>