<?php

class Xml {
	protected $xml;
	protected $path;
	protected $result;
	protected $url;
    public function __construct($url,$path="") {
    	$this->url=$url;
		$this->path=$path;
    }
    protected function getRoot($path="",$url=""){
    	if($url!="")$this->url=$url;
    	$rs=submit_get($this->url);
    	$this->xml=simplexml_load_string($rs);
    	if($path!=""){
    		$this->path=$path;
			$this->result=$this->xml->xpath($this->path);
    	}else{
           $this->result=$this->xml;
    	}
    }
    public function getRowValues($f=1,$d=2,$path="",$url=""){

		$this->getRoot($path,$url);
		//$this->result[$f]->Data[0]
		$result=$this->result;
		$feilds=$result[$f];
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
		for($i=$d;$i<count($result);$i++){
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
}
//$hphm="云E12345";
//$hphm=iconv("UTF-8","GBK","云E12345");
//$url="http://10.167.1.163:8585/PalmLinkPoliceQuerySerivce/Query?conditions=HPHM='".$hphm."'&requestCol=ZZXZ,SFZH,ZZDZQH,ZZDZXZ,SFZJZL,CLLX,FDJH,CSYS,ZZQH,DJZSBH,HPHM,HPZL,ZZG,ZZAMC,GCJK,CLPP1,CLPP2,CLXH,CLSBDH,JDCSYR,ZZZJLZH,CCDJRQ,ZRRQ,FPJG,JDCZT,FZJG,DJZZXZ,LXFS,FDJXH,RLZL,PL,GL,CCRQ,ZZL,HDZZL,HDZK,ZQYZL,RYID&sendId=S10-00000167";
//
//$xml=new Xml($url);
//$rs=$xml->getRowValues(1,2,"/RBSPMessage/Method/Items/Item/Value/Row");
//var_dump($rs);
//echo $rs;
?>