$("#btnAlert").bind("click",function(event){$("#divmeg").show();});
$("#btnPrompt").bind("click",function(event){$("#divmeg").hide();});
$("#btnChange").bind("click", function(event) { $("#divmeg").html("Hello World, too!"); });