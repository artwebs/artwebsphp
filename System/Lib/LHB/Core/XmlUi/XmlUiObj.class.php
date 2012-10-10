<?php

abstract class XmlUiObj extends LHB {
	 protected $name;
	 protected $docXmlString;
	 protected $docXml;
	 protected $docHtml;
	 protected $html;
	 protected $head;
	 protected $body;
	 protected $north;
	 protected $south;
	 protected $east;
	 protected $west;
	 protected $center;
	 protected $tabs;

	 protected $singletab;
	 protected $content_center;
	 protected $content_east;

	 protected $script;

	 protected $type;
	 protected $data=array();



     public function __construct($model=null,$action=null)
     {
		parent::__construct($model,$action);
		$this->name=$model."_".$action;
     }

     public function setXmlObj($xml)
     {
		$this->docXml=$xml;
     }

     public function setDocString($doc)
     {
		$this->docXml=new ActionXml();
		$this->docXml->xmlinstance($doc);
		$this->docXmlString=$doc;
     }

	 public function htmlInstance($type)
	 {
	 	$this->type=$type;
		switch($type)
		{
			case 'data':
				$this->getData();
				break;
			case 'part':
				$this->layoutInstance();
				$this->content_center=$this->appendChild('div','',$this->body);
				$this->content_center->setAttribute('region','center');
				$this->content_center->setAttribute('title','模拟终端');
				$this->content_center->setAttribute('split','true');

				$this->content_east=$this->appendChild('div','',$this->body);
				$this->content_east->setAttribute('region','east');
				$this->content_east->setAttribute('title','返回数据');
				$this->content_east->setAttribute('split','true');
				$this->content_east->setAttribute('style','padding:10px;width:400px');

				$this->draw();
				break;

			default:
				$this->layoutInstance();
				$this->south=$this->appendChild('div');
				$this->south->setAttribute('region','south');
				$this->south->setAttribute('title','备注');
				$this->south->setAttribute('id','south');
				$this->south->setAttribute('split','true');
				$this->south->setAttribute('style','height:100px;padding:10px;background:#efefef;');

				$this->west=$this->appendChild('div');
				$this->west->setAttribute('region','west');
				$this->west->setAttribute('title','模拟终端');
				$this->west->setAttribute('split','true');
				$this->west->setAttribute('style','width:180px;padding:1px;overflow:hidden;');

				$this->center=$this->appendChild('div');
				$this->center->setAttribute('region','center');
				$this->center->setAttribute('split','true');
				$this->center->setAttribute('style','overflow:hidden;');

				$this->tabs=$this->appendChild('div','',$this->center);
				$this->tabs->setAttribute('class','easyui-tabs');
				$this->tabs->setAttribute('fit','true');
				$this->tabs->setAttribute('border','false');
				$this->tabs->setAttribute('id','tabs');

				$this->singletab=$this->appendChild('div','',$this->tabs);

				$this->singletab->setAttribute('title',$this->model.'_'.$this->action);
				$this->singletab->setAttribute('style','overflow:hidden;');
				$this->singletab->setAttribute('class','easyui-layout');
				$this->singletab->setAttribute('split','true');
				$this->singletab->setAttribute('style','height:400px');

				$this->content_center=$this->appendChild('div','',$this->singletab);
				$this->content_center->setAttribute('region','center');
				$this->content_center->setAttribute('title','模拟终端');
				$this->content_center->setAttribute('split','true');

				$this->content_east=$this->appendChild('div','',$this->singletab);
				$this->content_east->setAttribute('region','east');
				$this->content_east->setAttribute('title','返回数据');
				$this->content_east->setAttribute('split','true');
				$this->content_east->setAttribute('style','padding:10px;width:400px');

				$this->setMenu();

				$this->draw();
				break;
		}



	 }

	 public function layoutInstance()
	 {
	 	$domimpl=new DOMImplementation();
	 	$doctype=$domimpl->createDocumentType("html","-//W3C//DTD XHTML 1.1//EN","http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd");
		$this->docHtml=$domimpl->createDocument('','',$doctype);
	    $this->html = $this->docHtml->createElement('html');
	    $this->head = $this->docHtml->createElement('head');
	    $this->body = $this->docHtml->createElement('body');
		$this->docHtml->appendChild($this->html);
		$this->html->setAttribute('xmlns','http://www.w3.org/1999/xhtml');
		$this->html->setAttribute('xml:lang','zh-CN');
		$this->html->appendChild($this->head);
		$this->html->appendChild($this->body);

		$this->appendLink('./System/Vendor/EasyUi/themes/default/easyui.css');
		$this->appendLink('./System/Vendor/EasyUi/themes/icon.css');
		$this->appendJavaScript('./System/Vendor/EasyUi/jquery-1.6.min.js');
		$this->appendJavaScript("./System/Vendor/EasyUi/jquery.easyui.min.js");
		$this->appendJavaScript("./System/Vendor/EasyUi/locale/easyui-lang-zh_CN.js");

		$this->body->setAttribute('class','easyui-layout');
	 }


	 public function response()
	 {
	 	$rs='';
	 	switch($this->type)
	 	{
	 		case 'data':
				$rs=json_encode($this->data);
	 			break;
	 		default:
				$this->script=$this->appendChild('script',$this->fun.$this->script,$this->head);
				$rs=$this->docHtml->saveHTML();
	 			break;

	 	}

		return $rs;
	 }

	 public function appendChild($child,$text=null,$parent=null)
	 {
		if($parent==null)$parent=$this->body;
		$child=$this->docHtml->createElement($child);
		if($text!=null)
		{
			$text = $this->docHtml->createTextNode($text);
			$child->appendChild($text);
		}
		$parent->appendChild($child);
		return $child;
	}


	public function appendJavaScript($path)
	{
		$js=$this->appendChild('script','',$this->head);
		$js->setAttribute('language','JavaScript');
		$js->setAttribute('type','text/javascript');
		$js->setAttribute('src',$path);
	}

	public function appendLink($path)
	{
		$js=$this->appendChild('link','',$this->head);
		$js->setAttribute('rel','stylesheet');
		$js->setAttribute('type','text/css');
		$js->setAttribute('href',$path);
	}

	public function saveJsonData($rows)
	{
		$data=json_encode($rows);
		$filename='session'.date('YmdHis').(microtime()*1000000);
		create_runtime($data,$filename,'/Runtime/Cache/json'.date('Ymd'));
		$file=get_runtime_file($filename,'/Runtime/Cache/json'.date('Ymd'));
		@$fp = fopen($file,"w");
	    if(!$fp){
	        echo "system error";
	        exit();
	    }else {
	    		$fileData="";
	    	   	$fileData.=$data;
	            fwrite($fp,$fileData);
	            fclose($fp);
	    }
		return $filename;
	}

	public function appendScript($script)
	{
		$this->script.=$script."\n";
	}


	public function setMenu()
	{
		$filename=C('XMLUIFILENAME');
		$menu=$this->appendChild('ul','',$this->west);
		$menu->setAttribute('id','menu');
		$filename=C('XMLUIFILENAME');
		$tabs=$this->tabs->getAttribute("id");
		if($rows=get_runtime($filename)){
			$data=json_encode(array_values($rows));
			$script=<<<EOT
			$(function(){
				var menudata=$data;
				$('#menu').tree({
					onClick:function(node){
						if(node.id!='')opentab(node.text,node.id);
					}
				});
				$('#menu').tree('loadData', menudata);
			});
			function opentab(title,url){
				if ($("#$tabs").tabs('exists',title)){
					$("#$tabs").tabs('select', title);
				} else {
					$("#$tabs").tabs('add',{
						title:title,
						content:'<iframe scrolling="yes" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>',
						closable:true
					});
				}
				$("#south").html($("#south").html()+"<br/>"+url.replace('XmlUi.php','index.php'));
			}
EOT;
			$this->appendScript($script);
		}
	}

	abstract function draw();

	abstract function getData();

	function displayEast()
	{
		$textarea=$this->appendChild('textarea','',$this->content_east);
		$textarea->setAttribute('style','width:350px;height:350px');
		$textarea->nodeValue=preg_replace('/\>\</i',">\n<",$this->docXml->response());
	}

}
?>