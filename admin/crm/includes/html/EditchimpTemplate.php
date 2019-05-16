<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>


<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />

<a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
<a href="viewchimpTemplate.php" class="fancybox add_quick">List Template</a>
<div class="had">Edit Template</div>

<div>
<TABLE WIDTH="100%"   BORDER=0 align="center"  >
	
  
<tr>
<td align="left" valign="top">
 <form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

			<? if (!empty($_SESSION['message'])) {?>
			<tr>
			<td  align="center"  class="message"  >
			<? if(!empty($_SESSION['message'])) {echo $_SESSION['message']; unset($_SESSION['message']); }?>	
			</td>
			</tr>
			<? } ?>
  
		<tr>
			<td  align="center" valign="top" >
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
			<tr>
			<td colspan="2" align="left"  class="head" >Template Information</td>
			</tr>
			<tr>
			<td  align="right" width="20%"   class="blackbold">Name: <span class="red">*</span></td>
			<td   align="left" >
			<input name="name" type="text" value="<?php echo $chimptempname;?>" class="inputbox"/></td>
			</tr>
			
			
			<tr>
			<td  align="right" valign="top" width="20%"  class="blackbold">Design  :<span class="red">*</span> </td>
			<td   align="left" >
			 <!--<Textarea name="description" id="description" class="inputbox"></Textarea>-->
                         <textarea id="description" class="inputbox" name="description" ><?php echo stripslashes($templateList[0]['description']); ?></textarea>
			</tr>
			</table>	
			</td>
		</tr>

		<tr>
			<td  align="center" >
			<div id="SubmitDiv" style="display:none1">
			<input name="Update" type="submit" class="button" id="SubmitButton" value="Update" />
			</div>
			</td>
		</tr>
   
   
</table></form>
	</td>
    </tr>
 
</table>
</div>
<script>
		$('.editor').summernote();
	</script>
<script type="text/javascript">

var editorName = 'description';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '98%', 600, 'EmailCompose');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor(); 


</script>
