<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Complex Layout - jQuery EasyUI Demo</title>
{$header}
</head>
<body class="easyui-layout">
	<div id="mymenu" style="width:150px;">
		<div>item1</div>
		<div>item2</div>
	</div>
		<div region="north" title="North Title" split="true" style="height:100px;padding:10px;">
			<p>n1</p>
			<p>n2</p>
			<p>n3</p>
			<p>n4</p>
			<p>n5</p>
		</div>
		<div region="south" title="South Title" split="true" style="height:100px;padding:10px;background:#efefef;">
			<div class="easyui-layout" fit="true" style="background:#ccc;">
				<div region="center">sub center</div>
				<div region="east" split="true" style="width:200px;">sub center</div>
			</div>
		</div>
		<div region="east" iconCls="icon-reload" title="Tree Menu" split="true" style="width:180px;">
			<ul class="easyui-tree" url="tree_data.json"></ul>
		</div>
		<div region="west" split="true" title="West Menu" style="width:280px;padding1:1px;overflow:hidden;">
			<div class="easyui-accordion" fit="true" border="false">
				<div title="Title1" style="overflow:auto;">
					<p>content1</p>
					<p>content1</p>
					<p>content1</p>
					<p>content1</p>
					<p>content1</p>
					<p>content1</p>
					<p>content1</p>
					<p>content12</p>
				</div>
				<div title="Title2" selected="true" style="padding:10px;">
					content2
					<a href="#" onclick="addmenu()">addmenu</a>
				</div>
				<div title="Title3">
					content3
				</div>
			</div>
		</div>
		<div region="center" title="Main Title" style="overflow:hidden;">
			<div class="easyui-tabs" fit="true" border="false">
				<div title="Tab1" style="padding:20px;overflow:hidden;">
					<div style="margin-top:20px;">
						<h3>jQuery EasyUI framework help you build your web page easily.</h3>
						<li>easyui is a collection of user-interface plugin based on jQuery.</li>
						<li>using easyui you don't write many javascript code, instead you defines user-interface by writing some HTML markup.</li>
						<li>easyui is very easy but powerful.</li>
					</div>
				</div>
				<div title="Tab2" closable="true" style="padding:20px;">This is Tab2 width close button.</div>
				<div title="Tab3" iconCls="icon-reload" closable="true" style="overflow:hidden;padding:5px;">
					<table id="tt2"></table>
				</div>
			</div>
		</div>
</body>
</html>