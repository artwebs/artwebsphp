<?php

class XmlUiList extends XmlUiObj{
     function draw()
     {
     	$this->getData();
		$data=json_encode($this->data);
		$table=$this->appendChild('table','',$this->content_center);
		$thead=$this->appendChild('thead','',$table);
		$tr=$this->appendChild('tr','',$thead);

		$table->setAttribute('id',$this->name."_datagrid");
		$table->setAttribute('iconCls','icon-edit');
		$table->setAttribute('singleSelect','true');
		$script =<<<EOT
			var data=$data;

			$(function(){
			$("#$this->name"+"_datagrid").datagrid({
				fitColumns: true,
				idField:'second',
				columns:[[
					{field:'first',title:'内容',width:80,
						formatter:function(value,rec){
							return value.replace(/\\n/,'\<br/\>');
						}
					}
				]]
			});
			$("#$this->name"+"_datagrid").datagrid('loadData', data);
		});

EOT;
		$this->appendScript($script);
		$redricts=$this->docXml->queryElement('/root/redrict');
		if(count($redricts)==1)
		{

		}
		else
		{
			foreach ($redricts  as $item)
			{

			}
		}

		$this->displayEast();
     }

     function getData(){
		$items=$this->docXml->queryElement('/root/value/row');
		foreach ($items as $item)
		{
			$row=array();
	        if($item->childNodes->length) {
	            foreach($item->childNodes as $i) {
	                $row[$i->nodeName] = $i->nodeValue;
	            }
	        }
        	$this->data[] = $row;
		}
     }
}
?>