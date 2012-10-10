<?php

class XmlDbUtil {
	protected $xml;
	protected $result;
    function XmlDbUtil() {
    }
    public function setXmlContent($content){
    	$this->xml=simplexml_load_string($content);
    }
    public function setXmlPath($url){
		$this->xml=simplexml_load_file($url);
    }
    public function setStringContent($content){
		$this->xml=$content;
    }
    public function setStringPath($url){
		$this->xml=file_get_contents($url);
    }
    public function getXmlArray(){
		return $this->xml;
    }
    public function setRoot($path){
    	if($path!=""){
    		$this->path=$path;
			$this->result=$this->xml->xpath($this->path);
    	}else{
           $this->result=$this->xml;
    	}
    }
    public function getXmlResult(){
		return $this->result;
    }
    public function getRowFieldRowData($fieldrow=1,$datastart=2,$node=""){
		$result=$this->result;
		$feilds=$result[$fieldrow];
		$datas=array();
		$rsdata=array();
		$feild=array();
		for($i=0;$i<count($feilds);$i++){
			if(!empty($feilds->Data[$i])){
				array_push($feild,(string)$feilds->Data[$i]);
			}else{
				array_push($feild,"");
			}
		}
		for($i=$datastart;$i<count($result);$i++){
			$row=$result[$i];
			$data=array();
			for($j=0;$j<count($row);$j++){
                array_push($data,(string)$row->Data[$j]);
			}
			$data=array_combine($feild,$data);
			array_push($rsdata,$data);
		}

		return $rsdata;
    }

    public function getRowFieldRowDataI($fieldrow=1,$datastart=2,$pnode="Row",$node="Data"){
		$xml=$this->xml;
		$xml=str_replace("<".$pnode."/>","<".$pnode."></".$pnode.">",$xml);
		$xml=str_replace("<".$node."/>","<".$node."></".$node.">",$xml);
		$rows=getMarkStringList($xml,'<'.$pnode.'>','</'.$pnode.'>');
		$result=array();
		for($i=0;$i<count($rows);$i++){
			$temp=array();
			$temp=getMarkStringList($rows[$i],'<'.$node.'>','</'.$node.'>');
			$result=array_push_hash($result,$i,$temp);
		}
		$feilds=$result[$fieldrow];
		$datas=array();
		$rsdata=array();
		$feild=array();
		for($i=0;$i<count($feilds);$i++){
			array_push($feild,$feilds[$i]);
		}

		for($i=$datastart;$i<count($result);$i++){
			$row=$result[$i];
			$data=array();
			for($j=0;$j<count($row);$j++){
                array_push($data,$row[$j]);
			}
			$data=array_combine($feild,$data);
			array_push($rsdata,$data);
		}

		return $rsdata;
    }

    public function getRowData(){
		$result=$this->result;
		$rows=array();
        for($i=0;$i<count($result);$i++){
            $row=array();
			foreach($result[$i] as $key=>$value){
				$row=array_push_hash($row,$key,(string)$value);
			}
			array_push($rows,$row);
        }
		return $rows;
    }
}
?>