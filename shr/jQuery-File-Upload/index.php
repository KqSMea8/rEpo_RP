<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link href="uploadfile.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="jquery.uploadfile.min.js"></script>z
</head>
<body>
Scroll Issue:

<div id="mulitplefileuploader">Upload</div>

<div id="status"></div>
<script>
$(document).ready(function()
{
var settings = {
    url: "upload.php", 
    dragDrop:true,
    fileName: "myfile",
    allowedTypes:"jpg,png,gif,doc,pdf,zip",	
  
	 onSuccess:function(files,data,xhr)
    {
        //alert(data);
    },
    showDelete:true,
    showDone: false,
    deleteCallback: function(data,pd)
	{
     
      
    for(var i=0;i<1;i++)
    {  
        $.post("delete.php",{op:"delete",name:data},
        function(resp, textStatus, jqXHR)
        {
            $("#status").append("");      
        });
     }      
     pd.statusbar.hide(); //You choice to hide/not.

}
}
var uploadObj = $("#mulitplefileuploader").uploadFile(settings);


});
</script>
</body>

