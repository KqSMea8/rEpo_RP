 <script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if(  ValidateForBlank(frm.heading, "Story Heading")
		&& ValidateMandRange(frm.heading, "Story Heading",5,200)
		&& ValidateForSimpleBlank(frm.SpeakerName, "Speaker Name")
		&& ValidateForSimpleBlank(frm.Designation, "Speaker Designation")
		){
			
			if (typeof ew_UpdateTextArea == 'function'){
				ew_UpdateTextArea();
			}
			
			if (!ew_ValidateForm(frm,"detail","Story Detail")){
				return false;
			}
		
			var Url = "isRecordExists.php?StoryHeading="+document.getElementById("heading").value+"&editID="+document.getElementById("storyID").value;
			SendExistRequest(Url,"heading","Story Heading");
			
			
			return false;
			
		}else{
			return false;	
		}
		
}



</SCRIPT>


<div class="had"> <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?></div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD  align="center" valign="top"><table width="100%"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
	
		  <div  align="right"><a href="viewStories.php" class="Blue">List Stories</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="98%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="12%" align="right" valign="top" =""  class="blackbold">
					   Story Heading <span class="red">*</span> </td>
                      <td width="88%" align="left" valign="top">
					<input  name="heading" id="heading" value="<?=stripslashes($arryStory[0]['heading'])?>" type="text" class="inputbox"  size="120" maxlength="250" />					    </td>
                    </tr><!--
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Posted Date <span class="red">*</span></td>
                      <td align="left" class="blacknormal"><span class="green-normaltext">
                        <? //if($storyDate < 1) $storyDate = ''; echo date_picker($storyDate,'storyDate');?>
                      </span></td>
                    </tr>
					
	<tr>
    <td  align="right" valign="top"   class="blackbold"> Image  </td>
    <td  align="left" valign="top" class="blacknormal">
	<input name="Image" type="file" class="inputbox" id="Image" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false"><br>
	(Note : Supported file types for image are:  jpg and gif.)	</td>
  </tr>-->
<?php //if($arryStory[0]['Image'] !='' && file_exists('../upload/bulletins/'.$arryStory[0]['Image']) ){ ?>
<!--
<tr>
  <td  align="right"   class="blackbold">Current Image </td>
    <td  align="left">
				<?php /*echo '<a href="../upload/bulletins/'.$arryStory[0]['Image'].'" target="_blank"  align="right">
				<img src="../upload/bulletins/'.$arryStory[0]['Image'].'" height="50" width="50" border=1 ></a>';*/
				?>	  </td>
  </tr>  
  -->
<?
	//}
?>				
					
	 <tr>
                      <td width="12%" align="right" valign="top" =""  class="blackbold">
					  Submitted By <span class="red">*</span> </td>
                      <td width="88%" align="left" valign="top">
					<input  name="SpeakerName" id="SpeakerName" value="<?=stripslashes($arryStory[0]['SpeakerName'])?>" type="text" class="inputbox"  size="27" maxlength="50" />					    </td>
                    </tr>
					
					 <tr>
                      <td width="12%" align="right" valign="top" =""  class="blackbold">
					  Speaker Designation <span class="red">*</span> </td>
                      <td width="88%" align="left" valign="top">
					<input  name="Designation" id="Designation" value="<?=stripslashes($arryStory[0]['Designation'])?>" type="text" class="inputbox"  size="27" maxlength="50" />					    </td>
                    </tr>				
					
                  
                    <tr >
                      <td align="right" valign="top"  class="blackbold">Status  </td>
                      <td align="left" class="blacknormal">
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                                            </td>
                    </tr>	
									 <tr >
                      <td align="right" valign="top"  class="blackbold" >Story Detail <span class="red">*</span> </td>
                      <td align="left" class="blacknormal"  valign="top"></td>
                    </tr>

                    <tr>
                      <td colspan="2" align="left" valign="middle" >

	
<Div class="red" id="LoadingDiv"><img src="images/loading.gif"> Loading editor...</Div>
<Div class="red" id="EditorDiv" style="display:none">

<textarea name="detail" id="detail" cols="35" rows="4"><?=htmlentities(stripslashes($arryStory[0]['detail']))?></textarea>
<script type="text/javascript">

var editorName = 'detail';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 380, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>	
</Div>	
<br><span class="blacknormal">(Recommended Image Width: 700 pixels)</span><br><br>


				  </td>
                      </tr>
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ;?> <?=$ModuleName?>" />
			  <input type="hidden" name="storyID" id="storyID"  value="<?=$_GET['edit']?>" />
			  
			  <input type="hidden" name="OldStatus" id="OldStatus"  value="<?=$Status?>" />
			  
			  <input type="reset" name="Reset" value="Reset" class="button" />
				    <br>  <br>  <br>
				  
				  </td></tr> 
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
<script language="javascript1.2">
	ShowAfterLoading('EditorDiv');
</script>