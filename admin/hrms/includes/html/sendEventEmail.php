<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

 <SCRIPT LANGUAGE=JAVASCRIPT>
function ChangePage(){
	ShowHideLoader('1','S');
	var SendUrl = 'sendEventEmail.php?cat='+document.getElementById("cat").value+'&EmpID='+document.getElementById("EmpID").value;
	location.href = SendUrl;
}
function validate(frm)
{	
	ShowHideLoader('1','S');

	/*if (typeof ew_UpdateTextArea == 'function'){
		ew_UpdateTextArea();
	}
	
	if (!ew_ValidateForm(frm,"PageContent","Page Content")){
		return false;
	}*/
	
}
</SCRIPT>

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.subject, "Subject")
		//&& ValidateMandRange(frm.TemplateContent, "Template Content ",1,200)
		
		){
			
				ShowHideLoader('1','P');

			
		}else{
			return false;	
		}
		
}



</SCRIPT>


<div><a href="<?=$RedirectUrl?>" class="back">Back</a></div>

<div class="had"><?=$MainModuleName?> &raquo; <span>Send Email</span>
</div>
	<div class="message" align="center"><? if(!empty($_SESSION['mess_template'])) {echo $_SESSION['mess_vac']; unset($_SESSION['mess_template']); }?></div>

		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
				   <tr>
                      <td width="20%" align="right" valign="top"   class="blackbold">
					   Email Template Category :<span class="red">*</span> </td>
                      <td align="left" valign="top">
					<select name="cat"  id="cat" class="inputbox" onchange="Javascript:ChangePage();" >
						<? for($i=0;$i<sizeof($arrayCat);$i++) {?>
						<option value="<?=$arrayCat[$i]['CatID']?>" <?  if($arrayCat[$i]['CatID']==$_GET['cat']){echo "selected";}?>>
						<?=$arrayCat[$i]['Name']?>
						</option>
						<? } ?>
					 </select> 
					    </td>
                    </tr>

					
                    <tr>
                      <td width="20%" align="right" valign="top"   class="blackbold">
					   Subject: :<span class="red">*</span> </td>
                      <td align="left" valign="top">
					<input  name="subject" id="subject" value="<?=stripslashes($arrayContents[0]['subject'])?>" type="text" class="textbox"  size="80" maxlength="100" />  
					    </td>
                    </tr>
                	
                  	
			<tr >
                      <td align="right" valign="top"  class="blackbold" > Email Template : </td>
                      <td align="left" valign="top">
<? $Content =  str_replace("[NAME]",$arryEmployee[0]["UserName"], $arrayContents[0]['Content']); ?>
<textarea name="TemplateContent" id="TemplateContent" ><?=htmlentities(stripslashes($Content))?></textarea>
<script type="text/javascript">

var editorName = 'TemplateContent';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 380, 'custom');
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
			  <br>
			  <input name="Submit" type="submit" class="button" value="Send" />
			  <input type="hidden" name="TemplateID" id="TemplateID" value="<?=$arrayContents[0]['TemplateID']?>" />
			   <input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['EmpID']?>" />
				  
				  </td></tr> 
				
              </form>
          </table>
