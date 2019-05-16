
<!-- drop box and google drive library by sanjiv -->
<script src="javascript/googleDrive.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
<script src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="nt0tur4k3kifr3d"></script>
<script src="javascript/ng-dropbox.js"></script>
<script src="javascript/dropbox-picker.min.js?var=<?=time()?>"></script>
<!--- End Script ---------->


<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
 
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">

//By chetan 1Sep//
$(function(){
$( "input[name$='assign']" ).click(function() { 
            if(this.value=='Users') //By Chetan//
            {
                $('#group').hide();
                $('#user').show();
            }else{
                $('#user').hide();
                $('#group').show();
            }   

        });
        
       
        
    $("#form1").submit(function(){
        var err;
        $('div.red').html('');
        
        $("#form1  :input[data-mand^=\'y\']").each(function(){
            
            $fldname = $(this).attr('name');
$fldname = $fldname.replace('[]',''); //by niraj for multicheckbox
            $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');  
              if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text' || $(this).attr('type') == 'file')
              {
                 if($(this).attr('type') == 'file')
                {
                    fileinput = $(this).closest('td').find('input[type="hidden"]');
                    if(fileinput.length == 0){
                        if($.trim($(this).val()) == "")
                        {    
                            $("#"+$fldname+"err").html(""+$input+" is mandatory field.");err = 1;
                        }   
                    }else{
                        
                        if(fileinput.val()=='')
                        {
                            $("#"+$fldname+"err").html(""+$input+" is mandatory field.");err = 1;
                        }    
                    }
                }else{
            
            
                    if( $.trim($(this).val()) == "")
                    {
                            $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                            err = 1;
                    }
                }       
              
              }else{//by niraj for checkbox 11feb16
                if($('input[name^="'+$fldname+'"]').length == 1)
		{ 
			if($('#'+$fldname+':checked').length < 1)
			{
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}
		}else{
			if($('input[name^="'+$fldname+'"]:checked').length < 1)
			{  
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}

		}
           }	
          
              if($fldname == 'assign')
              { 
                    if($("#assign:checked").val()=='Users' && $("#AssignToUser").val()=='')
                    {
                        $("#"+$fldname+"err").html("Please Enter Assign User Name.");
                        err = 1;	
                    }else if($("#assign:checked").val()=='Group' && $("#AssignToGroup").val()==''){

                        $("#"+$fldname+"err").html("Please Select Assign Group.");
                        err = 1;
                    }
              }
          
        });
             
        if(err == 1){ return false; }else{
                      
                //file = document.getElementById("FileName");
                //if(!ValidateOptionalDoc(file)){ return false;}
                var Url = "isRecordExists.php?DocumentTitle="+escape(document.getElementById("title").value)+"&editID="+document.getElementById("documentID").value;
                SendExistRequest(Url,"title","Document Title");
                return false;
            }
       
    });
    
    
  
      if($('#form1 input:checkbox').length>0){
         
        $('#form1 input:checkbox').click(function(){
            
          fldname = $(this).attr('name');
          if(!$(this).is(':checked'))
          { 
                  $('<input>').attr({
                        type: 'hidden',
                        id: fldname,
                        name: fldname,
                        value:''
                    }).prependTo('#form1');
          }else{
                $('input[name="'+fldname+'"][type="hidden"]').remove();
          }
            
        });
          
      }
      
      //End//
       
        


});

</script>
<SCRIPT LANGUAGE=JAVASCRIPT>

function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("EmpID"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("EmpID"+i).checked=false;
	}
}

 function getval(sel) {
 
       //alert(sel.value);
	   document.getElementById("activity_type").value = sel.value;
    }



 //added by sanjiv for google drive
 function initPicker() {
		var picker = new FilePicker({
			apiKey: 'AIzaSyB1kqIZfHmSkSdmi8zfBuYlmFZk4S2LrTc',
			clientId: '837804940753-va8ak61tamcaode1vrqnc16vjljocedp',
			buttonEl: document.getElementById('pick'),
			onSelect: function(file) {
				//alert('Selected ' + file.title);
				//console.log(file);
				saveFile(file);
			}
		});	
	}

 function saveFile(file){
		  //document.getElementById("load_div").style.display = 'block';
		  ShowHideLoader('1','P');
	 
         var accessToken = gapi.auth.getToken().access_token;
         var dUrl ='';
         var fExtension = '';
	 	 var oldurl = '';
         if(file.mimeType=="application/vnd.google-apps.spreadsheet"){
         	dUrl = file.exportLinks['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
         	fExtension = 'xlsx';
         }else if(file.mimeType=="application/vnd.google-apps.document") {
         	dUrl = file.exportLinks['application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
         	fExtension = 'docx';
         }else if(file.mimeType=="application/vnd.google-apps.presentation") {
           	dUrl = file.exportLinks['application/vnd.openxmlformats-officedocument.presentationml.presentation'];
             	fExtension = 'pptx';
         }else{
         	dUrl = file.downloadUrl;
         	fExtension = file.fileExtension;
         }
         
			if((typeof dUrl=='undefined') && (typeof file.exportLinks=='undefined')){ 
				 ShowHideLoader('2','P');
				alert('This File format is not supported.Please choose different format!!');
				return false;
			}
			
         if((typeof file.exportLinks != 'undefined') && (typeof dUrl=='undefined')){ 
         	dUrl = file.exportLinks['text/xls']; 
         	fExtension = 'xls';
     	}
	 
	 	oldurl = $("#form1").find("input[name='OldFile']").val();
    	 var newurl = $("#form1").find("input[name='NewFile']").val();

         $.ajax({
             url : "ajax.php",
             type: "POST",
             data : {accessToken:accessToken, title:file.title, drivedownloadUrl:dUrl, fileExtension:fExtension, NewFile:newurl},
             success: function(data)
             {
                 data = $.parseJSON(data);
                 //document.getElementById("load_div").style.display = 'none';
				 ShowHideLoader('2','P');
 				if(data.flag==0){
					 alert(data.msg);
						return false;
				 }
                 if(data.fileName){
                     //alert(data.fileName);
                     $("#DocDiv,#FileNameerr").remove();
                    var downloadLink = '<div  id="DocDiv" style="padding:10px 0 10px 0;">'+ data.fileName +'&nbsp;&nbsp;&nbsp;'+
                     '<a href="dwn.php?file='+ data.fileUrl +'" class="download">Download</a>' + 
                     '<a href="Javascript:void(0);" onclick="Javascript:DeleteFile(\''+ data.fileUrl +'\',\'DocDiv\')"><img src="../images/delete.png" border="0" onmouseover="ddrivetip(<center>Delete</center>, 40)" ></a>'+
                     '<input type="hidden" name="OldFile" value="'+ oldurl +'"><input type="hidden" name="NewFile" value="'+ data.fileUrl +'">' +
                     '</div>';
                    $(downloadLink).insertBefore("#pick");
	                }else{
	                    alert('Error while uploading file. Try again.');
	                }
             }
        });
         //document.getElementById("load_div").style.display = 'none';
     }

  // end



</SCRIPT>
  

<a class="back" href="<?=$RedirectURL?>">Back</a>


<div class="had">
Manage <?=ucfirst($parent_type)?> Document  <span> &raquo; 
	<?php 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($parent_type)." Details") :("Add ".ucfirst($parent_type)." ".$ModuleName); ?></span>
		
		
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 ng-app="DropboxControllers" ng-controller="DropBoxCtrl" >
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">
            <form name="form1" id="form1"  method="post"  enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

  
  <? if (!empty($_SESSION['mess_contact'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_contact'])) {echo $_SESSION['mess_contact']; unset($_SESSION['mess_contact']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  


<?php 
//By Chetan 26Aug//

$head = 1;
$arrayvalues = !empty($arryDocument) ? $arryDocument[0] : array();
for($h=0;$h<sizeof($arryHead);$h++){?>
                
    <tr>
        <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
    </tr>

<?php 

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
include("includes/html/box/CustomFieldsNew.php");


}

//End//
?>


	
	
</table>	
  

<script type="text/javascript">
$('#piGal table').bxGallery({
  maxwidth: 300,
  maxheight: 200,
  thumbwidth: 75,
  thumbcontainer: 300,
  load_image: 'ext/jquery/bxGallery/spinner.gif'
});
</script>


<script type="text/javascript">
$("#piGal a[rel^='fancybox']").fancybox({
  cyclic: true
});
</script>



	
	  
	
	</td>
   </tr>

   

   <tr>
    <td  align="center" >
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


</div>
<input type="hidden" name="documentID" id="documentID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="linkID" id="linkID"  value="<?=isset($_GET['linkID']) ? $_GET['linkID'] : '';?>" />
<input type="hidden" name="parent_type" id="parent_type"  value="<?=$parent_type?>" />	
<input type="hidden" name="parentID" id="parentID"  value="<?=$parentID?>" />
<input type="hidden" name="module" id="module"  value="<?=$_GET['module']?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminID']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />	


</td>
   </tr>
</table>
   </form>

	
	</td>
    </tr>
 
</table>
