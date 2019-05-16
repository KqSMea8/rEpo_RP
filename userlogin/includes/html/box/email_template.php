<?
	if($_POST['templateID']>0){		
		$objConfigure->updateEmailTemplate($_POST);
		$_SESSION['mess_template'] =  EMAIL_TEMPLATE_UPDATED;
		$RedirectUrl = "emailTemplate.php?t=".$_POST['templateID'];
		header("location: ".$RedirectUrl);
		exit;		
	}

	$arryEmailTitle = $objConfigure->GetEmailTitle('',$Config['CurrentDepID']);

	(!$_GET['t'])?($_GET['t']=$arryEmailTitle[0]['templateID']):(""); 

	
	$arrayContents = $objConfigure->GetEmailTemplate($_GET['t'],'');
?>


<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

 <SCRIPT LANGUAGE=JAVASCRIPT>
function ChangePage(){
	ShowHideLoader('1','L');
	location.href = 'emailTemplate.php?t='+document.getElementById("templateID").value;
}

function validateForm(frm){
	if( ValidateForSelect(frm.templateID, "Template Category")
	  && ValidateForSimpleBlank(frm.Subject, "Subject")
	//&& ValidateMandRange(frm.TemplateContent, "Template Content ",1,200)
	
	){
		
		ShowHideLoader('1','S');
		
	}else{
		return false;	
	}
		
}
</SCRIPT>



<div class="had">Manage <?=$MainModuleName?></div>
	<div class="message" align="center"><? if(!empty($_SESSION['mess_template'])) {echo $_SESSION['mess_template']; unset($_SESSION['mess_template']); }?></div>

		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
              

<tr>
                      <td align="left" valign="top">

 	<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">
	<tr>
                      <td align="left" valign="top">
			Template Category : <select name="templateID"  id="templateID" class="inputbox" onchange="Javascript:ChangePage();" >
				<? for($i=0;$i<sizeof($arryEmailTitle);$i++) {?>
				<option value="<?=$arryEmailTitle[$i]['templateID']?>" <?  if($arryEmailTitle[$i]['templateID']==$_GET['t']){echo "selected";}?>>
				<?=stripslashes($arryEmailTitle[$i]['Title'])?>
				</option>
				<? } ?>
			 </select> 
			 </td>
    		</tr>

	</table>

	 </td>
    </tr>

<tr>
    <td align="left" valign="top">
	  <b>Note:</b>	<?=stripslashes($arrayContents[0]['Note']			
)?>	 </td>
  </tr>

<tr>
    <td align="left" valign="top">
	  <b>Important:</b>	<?=stripslashes($arrayContents[0]['Important']			
)?>	 </td>
  </tr>




                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
				   


		
                    <tr>
                      <td  align="right" valign="top"   class="blackbold">
					   Subject : <span class="red">*</span> </td>
                      <td align="left" valign="top">
					<input  name="Subject" id="Subject" value="<?=stripslashes($arrayContents[0]['Subject'])?>" type="text" class="textbox"  size="60" maxlength="100" />  
					    </td>
                    </tr>
                 	
                  	
<tr >
                      <td align="right" valign="top"  class="blackbold" > Email Template : </td>
			<td></td>

</tr>

                    <tr >  <td align="left" valign="top" colspan="2">

<textarea name="TemplateContent" id="TemplateContent" ><?=htmlentities(stripslashes($arrayContents[0]['Content']))?></textarea>
<script type="text/javascript">

var editorName = 'TemplateContent';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 600, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>	
					  
					  </td>
                    </tr>


		


                 
                  </table></td>
                </tr>
				
		
				
				
				
				 <tr><td align="center">
			
			  <input name="Submit" type="submit" class="button" value="Update" />
			 		  
				  
			 </td></tr> 
				
              </form>
          </table>

