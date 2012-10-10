<?php

class XmlUiForm extends XmlUiObj{
	 protected $form;
	 protected $table;
     function draw()
     {
     	$this->form=$this->appendChild('form','',$this->content_center);
     	$this->form->setAttribute('method','post');
     	$this->form->setAttribute('id',$this->model.'_'.$this->action.'_form');
     	$this->table=$this->appendChild('table','',$this->form);
		$items=$this->docXml->queryElement('/root/row');
		$this->content_center->setAttribute('style','padding:10px');
		$rows=array();
		foreach ($items as $item)
		{
        	$tr=$this->appendChild('tr','',$this->table);
        	$row=array();
 			if($item->childNodes->length) {
	            foreach($item->childNodes as $i) {
	            	if($i->nodeName=='ITEMS')
	            		$row[$i->nodeName]=$this->getOptions($i->childNodes);
	            	else
	                	$row[$i->nodeName] = $i->nodeValue;
	            }
	        }
        	if($row['DISPLAY']=='false')$tr->setAttribute('style','display:none');
        	if(method_exists($this,$row['CONMETHOD']))
        		call_user_func_array(array($this,strtolower($row['CONMETHOD'])),array($row,$tr));
        	else
        		call_user_func_array(array($this,'textbox'),array($row,$tr));

		}

		$items=$this->docXml->queryElement('/root/button');
		foreach ($items as $item)
		{
        	$tr=$this->appendChild('tr','',$this->table);
        	$row=array();
 			if($item->childNodes->length) {
	            foreach($item->childNodes as $i) {
	            	if($i->nodeName=='ITEMS')
	            		$row[$i->nodeName]=$this->getOptions($i->childNodes);
	            	else
	                	$row[$i->nodeName] = $i->nodeValue;
	            }
	        }
        	if($row['DISPLAY']=='false')$tr->setAttribute('style','display:none');
        	call_user_func_array(array($this,'submit'),array($row,$tr));
		}

		$this->displayEast();
     }

	 function getData(){}

	 function getOptions($items)
	 {
	 	$rows=array();
	 	foreach ($items as $item)
		{
			$row=array();
		 	if($item->childNodes->length) {
		        foreach($item->childNodes as $i) {
					$row[$i->nodeName] = $i->nodeValue;
				}
			}
			$rows[]=$row;
		}
		return $rows;
	 }

     function textbox($row,$tr)
     {
     	$td=$this->appendChild('td','',$tr);
		$td->nodeValue=$row['CNAME'];

     	$td=$this->appendChild('td','',$tr);
		$control=$this->appendChild('input','',$td);
		$this->setControlAtrr($control,$row);
//		$control->setAttribute('class','easyui-validatebox');
//		$control->setAttribute('required','true');
     }

     function dropdownlist($row,$tr)
     {
     	$td=$this->appendChild('td','',$tr);
		$td->nodeValue=$row['CNAME'];

     	$td=$this->appendChild('td','',$tr);
		$control=$this->appendChild('select','',$td);
		$this->setControlAtrr($control,$row);

        foreach($row['ITEMS'] as $item)
        {
        	$option=$this->appendChild('option','',$control);
        	$option->setAttribute('value',$item['second']);
        	$option->nodeValue=$item['first'];
        	if(!array_key_exists('READONLY',$row)&&$row['VALUE']!=$item['second'])
        	{
				$option->setAttribute('selected','true');
				$control->setAttribute('disabled','true');
        	}
        }
     }

     function button($row,$tr)
     {
     	$td=$this->appendChild('td','',$tr);
		$td->nodeValue=$row['CNAME'];

     	$td=$this->appendChild('td','',$tr);
		$control=$this->appendChild('select','',$td);
		$this->setControlAtrr($control,$row);
		$control->removeAttribute('disabled');
		$control->removeAttribute('type');
		$url=str_replace('#and','&',$row["CONURL"])."&html=data";
		$disable='';
		if(!array_key_exists('READONLY',$row)&&$row['VALUE']!='')$disable="$('#".$row["NAME"]."').combobox('disable');";
		$script=<<<EOT
			$(function(){
				$('#{$row["NAME"]}').combobox({
			        url:'{$url}',
			        valueField:'second',
			        textField:'first',
			        multiple:true
			    });
			    $('#{$row["NAME"]}').combobox('setValue','{$row["VALUE"]}');
			    {$disable}
			});
EOT;
		$this->appendScript($script);
     }

     function meltiline($row,$tr)
     {
     	$td=$this->appendChild('td','',$tr);
		$td->nodeValue=$row['CNAME'];

     	$td=$this->appendChild('td','',$tr);
		$control=$this->appendChild('textarea','',$td);
		$this->setControlAtrr($control,$row);
        $control->setAttribute('style','width:200px;height:80px');
     }

     function submit($row,$tr)
     {
		$td=$this->appendChild('td','',$tr);
		$td->setAttribute('colspan','2');
		$control=$this->appendChild('input','',$td);
		$this->setControlAtrr($control,$row);
		$control->setAttribute('type','submit');
		$control->setAttribute('value',$row['CNAME']);
		$control->setAttribute('onclick',$row['NAME'].'Save()');
		$name=$this->model.'_'.$this->action.'_form';
		$url=str_replace('#and','&',$row["CONURL"])."&html=data";
		$script=<<<EOT
			$(function(){
				$("#{$name}").form({
					url: ''
				});
			});
			function {$row["NAME"]}Save(){
				$("#{$name}").find(':disabled').removeAttr('disabled');
				$("#{$name}").form('submit',{
					url: '{$url}',
					disabled:true,
					onSubmit: function(){
						$.messager.progress();
						return $(this).form('validate');
					},
					success: function(data){
						data = eval('('+data+')');
						$.messager.progress('close');
						$.messager.alert('信息',data.message);
						return data;
					}
				});
			}
EOT;
		$this->appendScript($script);
     }

     function setControlAtrr($control,$row)
     {
		$control->setAttribute('name',$row['NAME']);
		$control->setAttribute('id',$row['NAME']);
		$control->setAttribute('type','text');
		if(!array_key_exists('READONLY',$row)&&$row['VALUE']!='')$control->setAttribute('disabled','true');
        $control->setAttribute('style','width:120px');
        $control->setAttribute('value',$row['VALUE']);
     }


}




?>