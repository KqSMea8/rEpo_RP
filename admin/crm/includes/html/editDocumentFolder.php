
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
 
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript">
	var ew_DHTMLEditors = [];

</script>
<script src="javascript/jquery-1.2.6.min"></script>
<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){


		if( ValidateForSimpleBlank(frm.FolderName, "Folder Name")
		//&& ValidateForSimpleBlank(frm.AssignTo,"Assign To")

		){
	
			
var Url = "isRecordExists.php?FolderName="+escape(document.getElementById("FolderName").value)+"&editID="+document.getElementById("FolderID").value;
			SendExistRequest(Url,"FolderName","Folder Name");
			return false;
		}else{
			return false;	
		}
}

/*function validate(frm)
					{	
	
	               if( document.form1.name.value == "" )
				 {
					 alert( "Please select Name!" );
					 document.form1.name.focus() ;
					 return false;
				 }
return ( true );		
			}

*/
function SelectAllRecord()
{	
	for(i=1; i<=document.FolderName.Line.value; i++){
		document.getElementById("EmpID"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.FolderName.Line.value; i++){
		document.getElementById("EmpID"+i).checked=false;
	}
}

 function getval(sel) {
 
       //alert(sel.value);
	   document.getElementById("activity_type").value = sel.value;
    }
</SCRIPT>
  
<a class="back" href="<?=$RedirectURL?>">Back</a>


<div class="had">
Manage <?=(isset($_GET["parent_type"])) ? ucfirst($_GET["parent_type"]) : '';?>Folder  <span> &raquo; 
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?></span>
		
		
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
<form name="FolderName" action="<?php //echo $ActionUrl?>"  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
  
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
	<td  align="right" width="40%"   class="blackbold"> Folder Name :<span class="red">*</span> </td>
	<td   align="left" >
	<input name="FolderName" type="text" class="inputbox" id="FolderName" value="<?php echo (!empty($arryuser) ?  stripslashes($arryuser[0]['FolderName']) : ''); ?>"  maxlength="50"  />    
</td>
	</tr>


	 <tr>

	     <td align="right"  valign="middle"  class="blackbold">Status :</td>
                      <td align="left" class="blacknormal">
       <input name="Status" type="radio" value="1" <?=($DocumentStatus==1)?"checked":""?> />Active &nbsp;&nbsp;&nbsp;&nbsp;<input name="Status" type="radio" <?=($DocumentStatus==0)?"checked":""?> value="0" />Inactive</td>
           
                      
		<?php   
//print_r($DocumentStatus);

?>
	
	  </tr>
    
	<?php /*?><?php print_r($arryuser);?><?php */?>
</table>	
  
	</td>
   </tr>

   <tr>
    <td  align="center" >	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
</div>
<input type="hidden" name="FolderID" id="FolderID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminID']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />	


</td>
   </tr>
   </form>
</table>

	
	</td>
    </tr>
 
</table>
