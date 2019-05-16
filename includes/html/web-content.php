
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> <span ><?=MEMBER_PORTAL?> </span>  <?=EDIT_WEBSITE_CONTENT?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=EDIT_WEBSITE_CONTENT?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	  
 <? if(!empty($_SESSION['mess_str_content'])) { ?>
	   <tr>
              <td align="center" valign="top" class="redtxt" height="35">
			  		<?
			  		echo $_SESSION['mess_str_content'];
					unset($_SESSION['mess_str_content']); 
					?>
			  </td>
       </tr>
	  <? } ?>   	  
	  
	  
      <tr>
        <td height="32" ><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" >
         		<form name="formContent" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">	
		
		 <tr>
		    <td  align="left" valign="top">
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  align="left"  width="18%" > <?=STORE_LINK_TITLE?>: <span class="bluestar">*</span></td>
            <td  align="left" ><input name="VisitStoreTab" type="text" class="txtfield" size="20" id="VisitStoreTab" value="<? echo stripslashes($arrySite[0]['VisitStoreTab']); ?>"  maxlength="50" />	<span class="small_txt">(for e.g. View Online Store)</span>		  </td>
          </tr>
		  <tr>
		    <td  align="left" >&nbsp;</td>
		    <td  align="left" >&nbsp;</td>
		    </tr>
		 <tr>
		   <td  align="left" > About Us Link Title: <span class="bluestar">*</span></td>
            <td  align="left" ><input name="AboutusTab" type="text" class="txtfield" size="20" id="AboutusTab" value="<? echo stripslashes($arrySite[0]['AboutusTab']); ?>"  maxlength="50" />	  </td>
          </tr>
		 
		 
		 
		  <tr>
		    <td  align="left" >&nbsp;</td>
		    <td  align="left" >&nbsp;</td>
		    </tr>
		<tr>
		  <td  align="left" >Blog Link Title: <span class="bluestar">*</span></td>
            <td  align="left" ><input name="BlogTab" type="text" class="txtfield" size="20" id="BlogTab" value="<? echo stripslashes($arrySite[0]['BlogTab']); ?>"  maxlength="50" />	  </td>
          </tr>
		 
		  <tr>
		    <td  align="left" >&nbsp;</td>
		    <td  align="left" >&nbsp;</td>
		    </tr>
</table>

			</td>
		    </tr>
		
		
			
			
			  <tr>
		    <td  align="left" >
		      <?=STORE_HOME_CONTENT?>: <span class="bluestar">*</span>		   </td>
		    </tr>
		  <tr>
		    <td  align="left" ><?=RECOMMEND_WIDTH_660?></td>
		    </tr>
		  <tr>
            <td  align="left" >
			
<textarea name="WebHomeContent" id="WebHomeContent" cols="35" rows="4"><? echo htmlentities(stripslashes($arrySite[0]['WebHomeContent']));?></textarea>
<script type="text/javascript">

var editorName = 'WebHomeContent';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 260, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>			</td>
          </tr>
		  
	      <tr>
	        <td  align="left" >&nbsp;</td>
	        </tr>
	      <tr>
	        <td  align="left" >
	          <?=STORE_ABOUT_CONTENT?>: <span class="bluestar">*</span>	       </td>
	        </tr>
			 <tr>
		    <td  align="left" ><?=RECOMMEND_WIDTH_660?></td>
		    </tr>
	      <tr>
            <td  align="left" >
			
<textarea name="WebAboutContent" id="WebAboutContent" cols="35" rows="4"><? echo htmlentities(stripslashes($arrySite[0]['WebAboutContent']));?></textarea>
<script type="text/javascript">

var editorName = 'WebAboutContent';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 260, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>			</td>
          </tr>
		  
	
		  
          <tr>
            <td  align="left" >&nbsp;</td>
          </tr>
          <tr>
            <td  align="left" >
              <?=STORE_CONTACT_CONTENT?>:           </td>
          </tr>
		   <tr>
		    <td  align="left" ><?=RECOMMEND_WIDTH_660?></td>
		    </tr>
          <tr>
            <td  align="left" >
			
<textarea name="WebContactContent" id="WebContactContent" cols="35" rows="4"><? echo htmlentities(stripslashes($arrySite[0]['WebContactContent']));?></textarea>
<script type="text/javascript">

var editorName = 'WebContactContent';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 260, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>			</td>
          </tr>		  	  	  
		  

          <tr>
            <td  align="left" >&nbsp;</td>
          </tr>
          <tr>
            <td  align="left" >
              <?=STORE_CONTACT_CONTENT_LEFT?>:           </td>
          </tr>
		   <tr>
		    <td  align="left" ><?=RECOMMEND_WIDTH_215?></td>
		    </tr>
          <tr>
            <td  align="left" >
			
<textarea name="WebContactContentLeft" id="WebContactContentLeft" cols="35" rows="4"><? echo htmlentities(stripslashes($arrySite[0]['WebContactContentLeft']));?></textarea>
<script type="text/javascript">

var editorName = 'WebContactContentLeft';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 260, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>			</td>
          </tr>	

		<? for($Line=1;$Line<=3;$Line++){ 
		
		?>
 	<tr>
            <td  align="left" >&nbsp;</td>
          </tr>
          <tr>
            <td  align="left" >
              <? echo 'Optional Tab-'.$Line ?>:
              <input name="WebTab<?=$Line?>" type="text" class="txtfield" size="20" id="WebTab<?=$Line?>" value="<? echo stripslashes($arrySite[0]['WebTab'.$Line]); ?>"  maxlength="50" />			  </td>
          </tr>
		   <tr>
            <td  align="left" >
              <? echo 'Contents' ?>:			  </td>
          </tr>
		  <tr>
		    <td  align="left" ><?=RECOMMEND_WIDTH_660?></td>
		    </tr>
          <tr>
            <td  align="left" >
			
<textarea name="WebTabContent<?=$Line?>" id="WebTabContent<?=$Line?>" cols="35" rows="4"><? echo htmlentities(stripslashes($arrySite[0]['WebTabContent'.$Line]));?></textarea>
<script type="text/javascript">

var editorName = 'WebTabContent<?=$Line?>';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 260, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>			</td>
          </tr>	
		  <? } ?>
		  		  
          <tr>
            <td  height="65" align="left" >
			
 <? if(empty($_SESSION['SelectedTemplate'])){	  ?>
	  <input name="SubmitButton" alt="Continue" title="Continue" id="SubmitButton" type="image" value=" " src="images/continue.jpg" width="112" height="30" />
	  <? }else{ ?>
	  <input name="SubmitButton" alt="Save" title="Save" id="SubmitButton" type="image" value=" " src="images/submit.jpg" width="88" height="31" />
	  <? } ?>			
			
              <input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID']; ?>" />
              <input type="hidden" name="WebsiteContent" id="WebsiteContent" value="1" />
			  <input type="hidden" name="WebsiteStoreOption" id="WebsiteStoreOption" value="<? echo $_GET['ws']; ?>"  />			  </td>
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
</td>
</tr>
</table>
