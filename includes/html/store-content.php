
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> <span ><?=MEMBER_PORTAL?> </span>  <?=EDIT_STORE_CONTENT?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=EDIT_STORE_CONTENT?></td>
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
    <td  align="left" width="18%" ><?=WEBSITE_LINK_TITLE?>: <span class="bluestar">*</span></td>
            <td  align="left" > <input name="VisitWebsiteTab" type="text" class="txtfield" size="20" id="VisitWebsiteTab" value="<? echo stripslashes($arrySite[0]['VisitWebsiteTab']); ?>"  maxlength="50" />	<span class="small_txt">(for e.g. Visit Our Website)</span>		  </td>
          </tr>
		 
		  <tr>
		    <td  align="left" >&nbsp;</td>
		    <td  align="left" >&nbsp;</td>
		    </tr>
			
			 <tr>
			   <td  align="left" > About Us Link Title: <span class="bluestar">*</span></td>
            <td  align="left" ><input name="AboutusStoreTab" type="text" class="txtfield" size="20" id="AboutusStoreTab" value="<? echo stripslashes($arrySite[0]['AboutusStoreTab']); ?>"  maxlength="50" />	  </td>
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
		      <?=STORE_ABOUT_CONTENT?>:	<span class="bluestar">*</span> 	    </td>
		    </tr>
			<tr>
		    <td  align="left" ><?=RECOMMEND_WIDTH_660?></td>
		    </tr>
		  <tr>
            <td  align="left" >
			
<textarea name="AboutContent" id="AboutContent" cols="35" rows="4"><? echo htmlentities(stripslashes($arrySite[0]['AboutContent']));?></textarea>
<script type="text/javascript">

var editorName = 'AboutContent';

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
	          <?=STORE_SHIPPING_CONTENT?> Title:	 <input name="ShippingContentTab" type="text" class="txtfield" size="20" id="ShippingContentTab" value="<? echo stripslashes($arrySite[0]['ShippingContentTab']); ?>"  maxlength="50" /> <input type="checkbox" name="ShippingContentActive" value="1" 
<? if($arrySite[0]['ShippingContentActive'] == '1') echo 'checked';?>>        </td>
	        </tr>
			<tr>
		    <td  align="left" ><?=RECOMMEND_WIDTH_660?></td>
		    </tr>
	      <tr>
            <td  align="left" >
			
<textarea name="ShippingContent" id="ShippingContent" cols="35" rows="4"><? echo htmlentities(stripslashes($arrySite[0]['ShippingContent']));?></textarea>
<script type="text/javascript">

var editorName = 'ShippingContent';

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
	          <?=STORE_POLICY_CONTENT?> Title:  <input name="PolicyContentTab" type="text" class="txtfield" size="20" id="PolicyContentTab" value="<? echo stripslashes($arrySite[0]['PolicyContentTab']); ?>"  maxlength="50" /> <input type="checkbox" name="PolicyContentActive" value="1" 
<? if($arrySite[0]['PolicyContentActive'] == '1') echo 'checked';?>> 	       </td>
	        </tr>
			<tr>
		    <td  align="left" ><?=RECOMMEND_WIDTH_660_POLICY?></td>
		    </tr>
	      <tr>
            <td  align="left" >
			
<textarea name="PolicyContent" id="PolicyContent" cols="35" rows="4"><? echo htmlentities(stripslashes($arrySite[0]['PolicyContent']));?></textarea>
<script type="text/javascript">

var editorName = 'PolicyContent';

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
			
<textarea name="ContactContent" id="ContactContent" cols="35" rows="4"><? echo htmlentities(stripslashes($arrySite[0]['ContactContent']));?></textarea>
<script type="text/javascript">

var editorName = 'ContactContent';

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
			
<textarea name="ContactContentLeft" id="ContactContentLeft" cols="35" rows="4"><? echo htmlentities(stripslashes($arrySite[0]['ContactContentLeft']));?></textarea>
<script type="text/javascript">

var editorName = 'ContactContentLeft';

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
            <td  height="65" align="left" >
			
 <? if(empty($_SESSION['SelectedTemplate'])){	  ?>
	  <input name="SubmitButton" alt="Continue" title="Continue" id="SubmitButton" type="image" value=" " src="images/continue.jpg" width="112" height="30" />
	  <? }else{ ?>
	  <input name="SubmitButton" alt="Save" title="Save" id="SubmitButton" type="image" value=" " src="images/submit.jpg" width="88" height="31" />
	  <? } ?>			
			
              <input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID']; ?>" />
			  <input type="hidden" name="WebsiteStoreOption" id="WebsiteStoreOption" value="<? echo $_GET['ws']; ?>"  />
              <input type="hidden" name="StoreContent" id="StoreContent" value="1" /></td>
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
