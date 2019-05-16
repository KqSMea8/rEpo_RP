<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <a href="stories.php">Success Stories</a> </span> <?=SUBMIT_AN_ARTICLE?> </td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=SUBMIT_AN_ARTICLE?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
   
      <tr>
       <td ><table width="90%" border="0" align="left" cellpadding="0" cellspacing="0">
         <form action=""  method="post" name="StoryForm" id="StoryForm" onsubmit="return validateStory(this);">
           <tr>
             <td width="21%" height="30" align="left" valign="middle" class="generaltxt_inner">Story Heading <span class="bluestar">*</span></td>
             <td width="79%" height="30" align="left" valign="middle" class="generaltxt_inner">
               <input name="heading" id="heading" maxlength="200" type="text"  class="txtfield_contact" size="50" />
               
				
		
			
				
			                </td>
           </tr>

           <tr>
             <td height="30" colspan="2" align="left" valign="middle" class="generaltxt_inner">Story Detail <span class="bluestar">*</span></td>
           </tr>
           <tr>
             <td height="30" colspan="2" align="left" valign="middle" class="generaltxt_inner">
		 
	<textarea name="detail" id="detail" cols="35" rows="4"></textarea>
<script type="text/javascript">

var editorName = 'detail';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 380, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>			 
		<br>
		<?=POST_STORY_MSG?>
			 </td>
           </tr>
           <tr>
             <td height="35" colspan="2" align="right" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                   <td width="87%" align="right">
		<input  name="SpeakerName" id="SpeakerName" value="<?=stripslashes($_SESSION['Name'])?>" type="hidden" />
			     <input  name="MemberID" id="MemberID" value="<?=$_SESSION['MemberID']?>" type="hidden" />
			   <input  name="SpeakerEmail" id="SpeakerEmail" value="<?=stripslashes($_SESSION['Email'])?>" type="hidden" />
			    <input type="hidden" name="storyID" id="storyID"  value="<?=$_GET['edit']?>" />
			    <input type="hidden" name="Front" id="Front"  value="1" />
				
			    <input  name="Designation" id="Designation" value="<?=$_SESSION['MemberType']?>, Webo" type="hidden" />		   
				   
				   <input name="image" type="image" value=" " src="images/submit_contact.jpg" width="72" height="24"></td>
                   <td width="13%" align="right"><input type="reset" name="Reset"  width="72" height="24" value=" " class="ResetContact"></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td height="35" colspan="2" align="left" valign="middle" class="generaltxt_inner"><span class="bluestar">*</span> Required.</td>
           </tr>
         </form>
       </table></td>
	
      </tr>
	  
	
	  
	  
     
      
    
     
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
