<script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<div class="had">Manage Static Contents &raquo; <?=$arrayCat[0]['Name']?> Pages</div>

<form name="form1" action="" method="post" onSubmit="return validate(this);">
<br>
<div class="message"><? if(!empty($_SESSION['mess'])) {echo $_SESSION['mess']; unset($_SESSION['mess']); }?></div>
<br>
<? if(sizeof($arryPages) >0){ ?>
 <TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=2 CELLSPACING=0 >
	
	<TR <? if(sizeof($arryPages)<=1) echo 'style="display:none;"'; ?>>
	  <TD  align="left" valign="top" height="35" class="blackbold"> 

	  
	  
	  <select name="PageID" class="blacknormal" id="PageID" onchange="Javascript:ChangePage();" >
        <? for($i=0;$i<sizeof($arryPages);$i++) {?>
        <option value="<?=$arryPages[$i]['PageID']?>" <?  if($arryPages[$i]['PageID']==$PageID){echo "selected";}?>>
        <?=$arryPages[$i]['PageTitle']?>
        </option>
        <? } ?>
      </select>
	
	  </TD>
    </TR> 
	
	<TR>
	  <TD  align="center" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="borderall">
	 
        <tr>
          <td width="12%" height="33"   align="right"  class="blackbold">&nbsp;Current Page : &nbsp;</td>
          <td width="88%" align="left" >&nbsp;&nbsp;<strong><?=stripslashes($arrayContents[0]['PageTitle'])?></strong></td>
          </tr>
		 <tr>
          <td width="12%" height="36"   align="right" valign="top" class="blackbold">&nbsp;Status :&nbsp; </td>
          <td width="88%" valign="top" class="blacknormal">
		    <? 
		  	 $ActiveChecked = ' checked';
			 if($PageID > 0){
				 if($arrayContents[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arrayContents[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
		  <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?>>Active&nbsp;&nbsp;&nbsp;&nbsp;
		  <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?>>InActive		  </td>
          </tr>
         <tr>
          <td height="5" align="right"   valign="top" class="blackbold">&nbsp;Page Content : &nbsp;</td>
          <td height="5" align="left"  valign="top" class="blacknormal">
		  
		  

<Div class="red" id="LoadingDiv"><img src="images/loading.gif"> Loading editor...</Div>	
	
<Div class="red" id="EditorDiv" style="display:none" align="center" >

<table border="0"  width="100%" cellspacing="0" cellpadding="2" align="center" >
  <tr>
    <td >
	
	<textarea name="PageContent" id="PageContent" cols="35" rows="4"><?php echo htmlentities(stripslashes($arrayContents[0]['PageContent']));?></textarea>
<script type="text/javascript">

var editorName = 'PageContent';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 480, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor(); 


</script>
		  
		  </td>
         </tr>
      
        <tr>
          <td colspan="2" align="center" valign="top">
		 </td>
  </tr>
</table>
	
</Div>			</td>
        </tr>
		
		
		 <tr>
          <td height="45" colspan="2" align="center" >
		  
		  <input type="submit" name="Submit" value="Update Content" class="button">
		    <input type="hidden" name="CatID" id="CatID" value="<?=$_GET['CatID']?>" />
		  </td>
        </tr>
      </table></TD>
  </TR>

</TABLE>
<? }else{ ?>
No Pages Found.
<? } ?>
</form>
<? require_once("includes/footer.php"); ?>
<script language="javascript1.2">
	ShowAfterLoading('EditorDiv');
</script>

<SCRIPT LANGUAGE=JAVASCRIPT>
function ChangePage(){
	var SendUrl = 'cms.php?CatID='+document.getElementById("CatID").value+'&PageID='+document.getElementById("PageID").value;
	location.href = SendUrl;
}
function validate(frm)
{	

	if (typeof ew_UpdateTextArea == 'function'){
		ew_UpdateTextArea();
	}
	
	if (!ew_ValidateForm(frm,"PageContent","Page Content")){
		return false;
	}
	
}
</SCRIPT>
