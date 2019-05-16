
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
 
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">



function validate(frm){
		if( ValidateForSimpleBlank(frm.title, "Document Title")
		//&& ValidateForSimpleBlank(frm.AssignTo,"Assign To")
		    && ValidateOptionalDoc(frm.FileName, "Document")
		){
		
		
		

			var Url = "isRecordExists.php?DocumentTitle="+escape(document.getElementById("title").value)+"&editID="+document.getElementById("documentID").value;
			SendExistRequest(Url,"title","Document Title");
			return false;
		}else{
			return false;	
		}
		
}
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
</SCRIPT>
  <script>
$(document).ready(function() {
        $('#assign1').click(function() {
                $('#group').hide();
                $('#user').show();

        });
       $('#assign2').click(function() {
                 $('#user').hide();
                $('#group').show();
                
        });
    });
       

    </script>

<a class="back" href="<?=$RedirectURL?>">Back</a>


<div class="had">
Manage <?=ucfirst($_GET["parent_type"])?> Document  <span> &raquo; 
	<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($_GET["parent_type"])." Details") :("Add ".ucfirst($_GET["parent_type"])." ".$ModuleName); ?></span>
		
		
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
  
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


  


<tr>
	 <td colspan="2" align="left"  class="head" >Basic Information</td>
     
</tr>
	<tr>
	<td  align="right" width="40%"   class="blackbold"> Title  :<span class="red">*</span> </td>
	<td   align="left" >
	<input name="title" type="text" class="inputbox" id="title" value="<?php echo stripslashes($arryDocument[0]['title']); ?>"  maxlength="50" />            </td>
	</tr>

<tr>
<td align="right"   class="blackbold"> Assigned To  : </td>
<td   align="left" >
<input name="assign" type="radio" id="assign1"  <?=($arryDocument[0]['AssignType'] == "User")?"checked":""?> checked  value="User"  maxlength="50" />&nbsp; Users &nbsp;&nbsp; <input name="assign" <?=($arryDocument[0]['AssignType'] == "Group")?"checked":""?> type="radio" id="assign2" value="Group"  maxlength="50" />&nbsp; Group       </td>
</tr>

	 
<tr >
  <td align="right"   class="blackbold"> &nbsp;&nbsp; </td>
        <td  align="left" >

		<div id="group" <?=$classGroup?>>
               <select name="AssignToGroup" class="inputbox" id="AssignToGroup" >
		<option value="">--- Select ---</option>	   

<optgroup label="Groups">
		<? if(!empty($arryGroup)){?>
		
			<? for($i=0;$i<sizeof($arryGroup);$i++) {?>
			<option value="<?=$arryGroup[$i]['group_user']?>:<?=$arryGroup[$i]['GroupID']?>" <?  if($arryGroup[$i]['group_user']==$arryDocument[0]['AssignTo']){echo "selected";}?>>
			<?=stripslashes($arryGroup[$i]['group_name']);?> 
		</option>
						<? }  }else{ ?>

						<div class="redmsg">No Group exist.</div>
					<? } ?>
</optgroup>
		</select>

	</div>
        
        <div id="user" <?=$classUser?>>
        <input type="text" class="inputbox" id="AssignToUser" name="AssignToUser" />
       <? if($_GET['edit']>0 && $json_response2!=''){ ?>
        <script type="text/javascript">
         $(document).ready(function() {
            $("#AssignToUser").tokenInput("multiSelect.php", {
                theme: "facebook",
				preventDuplicates: true,
				prePopulate: <?=$json_response2?>,
				
			propertyToSearch: "name",
              resultsFormatter: function(item){ return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>" },
              //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
			  tokenFormatter: function(item){ return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " ' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>" },

				
            });
        });
        </script>
        <? }else{?>
         <script type="text/javascript">
        $(document).ready(function() {
            $("#AssignToUser").tokenInput("multiSelect.php", {
                theme: "facebook",
				preventDuplicates: true,
				
					propertyToSearch: "name",
              resultsFormatter: function(item){ return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>" },
              //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
			  tokenFormatter: function(item){ return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>" },

				
            });
        });
        </script>
         <? }?>
        </div>
		
          </td>
      </tr>




 <tr>
        <td  align="right"   class="blackbold">  Customer  : </td>
        <td   align="left" >
		
	<? if(sizeof($arryCustomer)>0){?>
	<select name="CustID" class="inputbox" id="CustID" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryCustomer);$i++) {?>
			<option value="<?=$arryCustomer[$i]['Cid']?>" <?  if($arryCustomer[$i]['Cid']==$arryDocument[0]['CustID']){echo "selected";}?>>
			<?=stripslashes($arryCustomer[$i]['FullName']);?> 
			</option>
		<? } ?>
	</select>

	<? }else{ 
		echo NO_CUSTOMER_EXIST;
	} ?>


            </td>
 </tr>








	  <tr>

	     <td align="right"  valign="middle"  class="blackbold">Status :</td>
                      <td align="left" class="blacknormal">
       <input name="Status" type="radio" value="1" <?=($DocumentStatus==1)?"checked":""?> />Active &nbsp;&nbsp;&nbsp;&nbsp;<input name="Status" type="radio" <?=($DocumentStatus==0)?"checked":""?> value="0" />Inactive</td>
           
                      
		
	
	  </tr>
      
	  <tr>
	 <td colspan="2" align="left" class="head">File Details</td>
</tr>

	 
	   <tr style="display:none;">
        <td  align="right"   class="blackbold"> Download Type  : </td>
        <td   align="left" >
        <select name="DownloadType" id="DownloadType" class="inputbox">
		<option value="">--Select--</option>
		<option value="Internal" <? if($arryDocument[0]['DownloadType']=="Internal"){ echo "Selected"; }?>>Internal</option>
		<option value="External" <? if($arryDocument[0]['DownloadType']=="External"){ echo "Selected"; }?>>External</option>
		</select>
           </td>
           </tr>
           <tr>
		    <td  class="blackbold" valign="top"   align="right"> Upload Document :</td>
                    <td  align="left"   class="blacknormal" valign="top"><input name="FileName" type="file" class="inputbox"  id="FileName"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />

 <? $MainDir = "upload/Document/".$_SESSION['CmpID']."/";
   $document = stripslashes($arryDocument[0]['FileName']);
 if($document !='' && file_exists($MainDir.$document) ){ ?>			
			
<div  id="DocDiv" style="padding:10px 0 10px 0;">	
<?=$document?>&nbsp;&nbsp;&nbsp;
<a href="dwn.php?file=<?=$MainDir.$document?>" class="download">Download</a> 
	<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$document?>','DocDiv')">
	<?=$delete?></a>

<input type="hidden" name="OldFile" value="<?=$MainDir.$document?>">

</div>			
		 <? }?>	

   </td>
      </tr>
  <tr>
	 <td colspan="2" align="left" class="head">Description</td>
</tr>
 
	  
	   <tr>

	      <td  align="right"   class="blackbold" valign="top"> Description :</td>
        <td   align="left" > <Textarea name="description" id="description" class="inputbox"  ><? echo stripslashes($arryDocument[0]['description']); ?></Textarea>
<script type="text/javascript">

var editorName = 'description';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '410', 200, 'Basic');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor(); 


</script>	
           </td>
           </tr>
  
	   


	
	
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
<input type="hidden" name="linkID" id="linkID"  value="<?=$_GET['linkID']?>" />
<input type="hidden" name="parent_type" id="parent_type"  value="<?=$_GET['parent_type']?>" />	
<input type="hidden" name="parentID" id="parentID"  value="<?=$_GET['parentID']?>" />
<input type="hidden" name="module" id="module"  value="<?=$_GET['module']?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminID']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />	


</td>
   </tr>
   </form>
</table>

	
	</td>
    </tr>
 
</table>
