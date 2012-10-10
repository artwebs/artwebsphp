 var treedata=[{"id":"0","text":"中国1","value":"86","showcheck":false,"isexpand":true,"checkstate":0,"hasChildren":true,"ChildNodes":[{"id":"1","text":"北京","value":"11","showcheck":true,"isexpand":false,"checkstate":0,"hasChildren":false,"ChildNodes":null,"complete":false}],"complete":false}];
 $(document).ready(function() {
            var o = {
                showcheck: true,
                method: "POST", //默认采用POST提交数据
                datatype: "json", //数据类型是json
                url: "http://localhost/LHBSystem_1/index.php?mod=page&act=tree2",
                theme: "bbit-tree-lines", //bbit-tree-lines ,bbit-tree-no-lines,bbit-tree-arrows
                showcheck: true,
                theme: "bbit-tree-no-lines", //bbit-tree-lines ,bbit-tree-no-lines,bbit-tree-arrows
                onnodeclick:function(item){alert(item.text);}
            };
            o.data = treedata;
            $("#tree").treeview(o);
            $("#showchecked").click(function(e){
                var s=$("#tree").getTSVs();
                if(s !=null)
                alert(s.join(","));
                else
                alert("NULL");
            });
             $("#showcurrent").click(function(e){
                var s=$("#tree").getTCT();
                if(s !=null)
                    alert(s.text);
                else
                    alert("NULL");
             });
        });