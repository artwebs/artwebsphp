<?php

class excelAction extends Action{

	/**
	 * 列表查询接口
	 * 性别  eg: http://localhost/artwebsphp/index.php?mod=excel&act=export
	 */
    function export()
    {
//		$obj=new DownloadModel();
//		$obj->download("UpFiles/dwz-team.xls","111.xls");
		ob_start();
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-Disposition: attachment; filename=EmplList.xls" );
		header ("Content-Description: PHP/INTERBASE Generated Data" );

		$this->xlsBOF();    // begin Excel stream
		$this->xlsWriteLabel(0,0,"This is a label");   // write a label in A1, use for dates too
		$this->xlsWriteNumber(0,1,9999);   // write a number B1
		$this->xlsEOF(); // close the stream
    }


    function xlsBOF() {
	     echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
	     return;
	}
	// Excel end of file footer
	function xlsEOF() {
	     echo pack("ss", 0x0A, 0x00);
	     return;
	}
	// Function to write a Number (double) into Row, Col
	function xlsWriteNumber($Row, $Col, $Value) {
	     echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
	     echo pack("d", $Value);
	     return;
	}
	// Function to write a label (text) into Row, Col
	function xlsWriteLabel($Row, $Col, $Value ) {
	     $L = strlen($Value);
	     echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	     echo $Value;
		return;
	}

}
?>