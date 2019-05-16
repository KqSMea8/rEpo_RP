<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.heading, "Announcement Heading")
		&& ValidateMandRange(frm.heading, "Announcement Heading",5,100)
		&& ValidateForSimpleBlank(frm.newsDate, "Announcement Date")
		&& ValidateOptionalUpload(frm.Image, "Image")
		){
			
			var Url = "isRecordExists.php?AnnouncementHeading="+escape(document.getElementById("heading").value)+"&editID="+document.getElementById("newsID").value;
			SendExistRequest(Url,"heading","Announcement Heading");
			
			return false;
			
		}else{
			return false;	
		}
		
}



</SCRIPT>
<a href="<?=$RedirectUrl?>" class="back">Back</a>


<div class="had"><?=$MainModuleName?> <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$PageTitle;
?>
</span>
</div>
	
<? if(!empty($_SESSION['mess_news'])) {echo '<div class="message">'.$_SESSION['mess_news'].'</div>'; unset($_SESSION['mess_news']); }?>

<?
if($_GET['tab']=='document' && $_GET['edit']>0){
	include("includes/html/box/news_doc.php");
	include("../includes/html/box/upload_doc.php");
}else{
?>

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="20%" align="right" valign="top"   class="blackbold">
					   Heading :<span class="red">*</span> </td>
                      <td align="left" valign="top">
					<input  name="heading" id="heading" value="<?=stripslashes($arryNews[0]['heading'])?>" type="text" class="textbox"  size="80" maxlength="100" />  
					    </td>
                    </tr>
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Announcement Date :<span class="red">*</span></td>
                      <td align="left" >
					  
<? 
$newsDate='';
if($arryNews[0]['newsDate']>0) $newsDate = $arryNews[0]['newsDate'];  ?>				
<script type="text/javascript">
$(function() {
	$('#newsDate').datepicker(
		{
			showOn: "both",
	dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="newsDate" name="newsDate" readonly="" class="datebox" value="<?=$newsDate?>"  type="text" > 
		  
					  
					  
					  </td>
                    </tr>
					
	<tr>
    <td  align="right" valign="top"   class="blackbold"> Upload Image : </td>
    <td  align="left" valign="top" >
	<input name="Image" type="file" class="inputbox" id="Image" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false"><br>
	
	
<?  
if($arryNews[0]['Image'] !='' && IsFileExist($Config['NewsDir'], $arryNews[0]['Image']) ){ 
	$OldImage = $arryNews[0]['Image'];
 
	$PreviewArray['Folder'] = $Config['NewsDir'];
	$PreviewArray['FileName'] = $arryNews[0]['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($arryNews[0]['heading']);
	$PreviewArray['Width'] = "120";
	$PreviewArray['Height'] = "120";
	$PreviewArray['Link'] = "1";
	echo '<div  id="ImageDiv">'.PreviewImage($PreviewArray).'&nbsp;<a href="Javascript:void(0);" onclick="Javascript:RemoveFile(\''.$Config['NewsDir'].'\',\''.$arryNews[0]['Image'].'\',\'ImageDiv\')">'.$delete.'</a><input type="hidden" name="OldImage" value="'.$OldImage.'" /></div>';

} ?>
	
	
	 	</td>
  </tr>
		
					
					
					
                  	
									 <tr >
                      <td align="right" valign="top"  class="blackbold" > Detail : </td>
                      <td align="left" valign="top">

<textarea name="detail" id="detail" ><?=htmlentities(stripslashes($arryNews[0]['detail']))?></textarea>
<script type="text/javascript">

var editorName = 'detail';

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


		  <tr >
                      <td align="right" valign="top"  class="blackbold">Status : </td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                                            </td>
                    </tr>


                 
                  </table></td>
                </tr>
				
		
				
				
				
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="newsID" id="newsID"  value="<?=$_GET['edit']?>" />
				  
				  </td></tr> 
				
              </form>
          </table>
<? } ?>
