<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0"  width="100%" align="center">
               

	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span>  <?=EDIT_TEMPLATE?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=EDIT_TEMPLATE?>
		
		</td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
       <? if($_SESSION['WebsiteStoreOption']=='ws'){ ?>
		   <tr>
            <td  style="text-align:right"class="generaltxt_inner" height="35"><?=CHANGE_REFLECT_MSG?></td>
          </tr>
		 <? } ?> 
		 <!--
		  <tr>
            <td  style="text-align:right"class="generaltxt_inner" >Recommended Dimensions for Image: 75*75 - 1000*1000</td>
          </tr> -->
		         
  		<tr>
        <td  align="left" valign="top" class="green_outline">
		
  <form name="formTemplate" action=""  method="post" onSubmit="return validateTemplate(this);">		
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="blacktxt" id="BodyTopID" >
  <tr>
    <td colspan="8" valign="top" class="greenbox">
	<?=STORE_BODY_SECTION?>	</td>
    </tr>
	 <tr>
	  
    <td width="15%" valign="top" >
	<input type="radio" name="BodyBgOption" id="BodyBgOption1" value="color" <? if($arrySite[0]['BodyBgOption']=='color') echo 'checked'; ?>> Background Color: </td>
    <td width="12%" valign="top" ><input name="BodyBgColor" type="text" class="txtfield" id="BodyBgColor" value="<?=$BodyBgColor?>" style="width:50px" maxlength="8"  readonly=""/>
                   <a href="Javascript: OpenNewPopUp('ColorPicker/color_pick.htm?inputbox=BodyBgColor&sample=sample1','800','800','Yes')">
				    <img src="images/sel.gif" alt="select color" width="15" height="13" border="0" style="cursor:pointer" title="Select Color" /></a>
				    <!--<img src="images/sel.gif" alt="select color" width="15" height="13" border="0" style="cursor:pointer" title="Select Color" onClick="Javascript: showColorGrid3('BodyBgColor','sample1');" />-->
					<input name="sample1" type="text" readonly id="sample1" style="background-color: <?=$BodyBgColor?>" value="" size="1" maxlength="0" class="txtfield"/>  
						  
				<div id="colorpicker301" style="position:absolute;left:300;top:400;"></div>	</td>
    <td width="16%"  ><input type="radio" name="BodyBgOption" id="BodyBgOption2" value="image" <? if($arrySite[0]['BodyBgOption']=='image') echo 'checked'; ?>> Background Image: </td>
	 <td colspan="3"  class="skytxt" >
	 <a href="Javascript: UploadImage('uploadBodyImage.php','300','300','Yes')">Upload Image</a>
	<input type="hidden" name="BodyBgImage" id="BodyBgImage" value="<?=$BodyBgImage?>" /><span id="BodyBgImageSpan" <?=$BodyBgImageStyle?>> | <a onclick="OpenNewPopUp('showimage.php?LastBodyBg=1&img=templates/temp/<?=$BodyBgImage?>', 150, 100, 'yes' );"  href="#">View Uploaded Image</a>
	</span>	
	
		<span class="blacktxt">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="BodyImageRepeate" id="BodyImageRepeate" value="1" <? if($arrySite[0]['BodyImageRepeate']=='1') echo 'checked'; ?> > <?=REPEATE_BG_IMAGE?></span>
	  	</td>
	 </tr>
	 <tr>
	   <td valign="top" >&nbsp;&nbsp;Template Panel:</td>
	   <td valign="top" > <select name="TemplatePanel" class="txtfield" id="TemplatePanel" style="width: 90px;" >
       <option value="Left" <? if($arrySite[0]['TemplatePanel']=='Left') echo 'selected';?>>Left</option>
       <option value="Right" <? if($arrySite[0]['TemplatePanel']=='Right') echo 'selected';?>>Right</option>
     </select></td>
	   <td valign="top" >&nbsp;</td>
	   <td width="29%" nowrap="nowrap"  class="skytxt" >&nbsp;</td>
	   <td width="11%" align="right"  >&nbsp;</td>
	   <td width="17%"  >&nbsp;</td>
	   </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="5" class="blacktxt">
  <tr>
    <td colspan="4" valign="top" class="greenbox">
	<?=STORE_HEADER_BG_SECTION?>	</td>
    </tr>
<tr>
    <td width="15%" valign="top"><input type="radio" name="HeaderBgOption" id="HeaderBgOption1" value="color" <? if($arrySite[0]['HeaderBgOption']=='color') echo 'checked'; ?>> Background Color:</td>
    <td width="12%" valign="top"> <input name="HeaderBgColor" type="text" class="txtfield" id="HeaderBgColor" value="<?=$HeaderBgColor?>" style="width:50px" maxlength="8"  readonly=""/>
                   
				   <a href="Javascript: OpenNewPopUp('ColorPicker/color_pick.htm?inputbox=HeaderBgColor&sample=sampleHD','800','800','Yes')"><img src="images/sel.gif" alt="select color" width="15" height="13" border="0" style="cursor:pointer" title="Select Color" /></a>
				   
				   <!-- <img src="images/sel.gif" alt="select color" width="15" height="13" border="0" style="cursor:pointer" title="Select Color" onClick="Javascript: showColorGrid3('HeaderBgColor','sampleHD');" />-->
					<input name="sampleHD" type="text" readonly id="sampleHD" style="background-color: <?=$HeaderBgColor?>" value="" size="1" maxlength="0" class="txtfield"/>  
						  
				<div id="colorpicker301" style="position:absolute;left:300;top:400;"></div>  </td>
    <td width="16%" valign="top"><input type="radio" name="HeaderBgOption" id="HeaderBgOption2" value="image" <? if($arrySite[0]['HeaderBgOption']=='image') echo 'checked'; ?> />
      Background Image:</td>
    <td width="57%" nowrap="nowrap" class="skytxt" valign="top">
	
	<a href="Javascript: UploadImage('uploadImage.php','300','300','Yes')">Upload Image</a>
	<input type="hidden" name="HeaderBgImage" id="HeaderBgImage" value="<?=$HeaderBgImage?>" /><span id="HeaderBgSpan" <?=$HeaderBgStyle?>> | <a onclick="OpenNewPopUp('showimage.php?LastHeaderBg=1&img=templates/temp/<?=$HeaderBgImage?>', 150, 100, 'yes' );"  href="#">View Uploaded Image</a></span>
	
	<span class="blacktxt">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="HeaderBgRepeate" id="HeaderBgRepeate" value="1" <? if($arrySite[0]['HeaderBgRepeate']=='1') echo 'checked'; ?> > <?=REPEATE_BG_IMAGE?> 
</span>		 </td>
    </tr>
<tr>
  <td colspan="4" valign="top">&nbsp;&nbsp;<span class="blacktxt">(Recommended Dimensions: 900 pixels by 120 pixels | GIF, JPG or PNG)</span>	</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="5" class="blacktxt" >
    <tr>
    <td valign="top" class="greenbox">
		<input type="checkbox" name="HeaderTitleOption" id="HeaderTitleOption" value="1" <? if($arrySite[0]['HeaderTitleOption']=='1') echo 'checked'; ?> onclick="Javascript:ShowHideDiv('HeaderTitleDiv');"> <?=STORE_HEADER_TITLE_SECTION?></td>
    </tr>
 <tr>
    <td>
	
	<Div id="HeaderTitleDiv" <? if($arrySite[0]['HeaderTitleOption']!='1') echo 'style="visibility:hidden"'; ?>>
	
	Header Title:
	
      <input name="HeaderTitle" type="text" class="txtfield" id="HeaderTitle" value="<?=stripslashes($HeaderTitle)?>" size="20" maxlength="90" />  &nbsp;&nbsp; &nbsp;&nbsp;
      <?
	
	if($arrySite[0]['HeaderTextAlign']=='left'){
		$ImgStyleLeft = 'class="ImgTemplateSel"';
	}else if($arrySite[0]['HeaderTextAlign']=='center'){
		$ImgStyleCenter = 'class="ImgTemplateSel"';
	}else if($arrySite[0]['HeaderTextAlign']=='right'){
		$ImgStyleRight = 'class="ImgTemplateSel"';
	}

	?>
      <input type="hidden" name="HeaderTextAlign" id="HeaderTextAlign" value="<?=$arrySite[0]['HeaderTextAlign']?>"   />
<a href="#BodyTopID" class="alignsel"><img src="images/align_left.gif" onclick="SetHeaderTextAlign('left');" id="HeaderImgLeft" <?=$ImgStyleLeft?> border="0"  /></a>

<a href="#BodyTopID" class="alignsel"><img src="images/align_center.gif" onclick="SetHeaderTextAlign('center')" id="HeaderImgCenter" <?=$ImgStyleCenter?> border="0" /></a>

<a href="#BodyTopID" class="alignsel"><img src="images/align_right.gif"  onclick="SetHeaderTextAlign('right')" id="HeaderImgRight" <?=$ImgStyleRight?> border="0" /></a> 



&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;Color:
<input name="HeaderFontColor" type="text" class="txtfield" id="HeaderFontColor" value="<?=$HeaderFontColor?>" style="width:50px" maxlength="8"  readonly=""/>
            
	   <a href="Javascript: OpenNewPopUp('ColorPicker/color_pick.htm?inputbox=HeaderFontColor&sample=sample2','800','800','Yes')"><img src="images/sel.gif" alt="select color" width="15" height="13" border="0" style="cursor:pointer" title="Select Color" /></a>		
			
		<!--	       
	 <img src="images/sel.gif" alt="select color" width="15" height="13" border="0" style="cursor:pointer" title="Select Color" onClick="Javascript: showColorGrid3('HeaderFontColor','sample2');" />-->
	 
					<input name="sample2" type="text" readonly id="sample2" style="background-color: <?=$HeaderFontColor?>" value="" size="1" maxlength="0" class="txtfield"/>  
						  
				    <div id="colorpicker301" style="position:absolute;left:300;top:400;"></div>
				             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Size:
                    <select name="HeaderFontSize" class="txtfield" id="HeaderFontSize" style="width: 90px;" >
                      <option value="">-- Font Size -- </option>
                      <? for($i=0;$i<sizeof($arryFontSize);$i++) {?>
                      <option value="<?=$arryFontSize[$i]['FontSize']?>"   <? if($arryFontSize[$i]['FontSize']==$arrySite[0]['HeaderFontSize']) echo 'selected';?>>
                      <?=$arryFontSize[$i]['FontSize']?>
                      </option>
                      <? } ?>
                    </select>
&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;Font:
<select name="HeaderFontType" class="txtfield" id="HeaderFontType" style="width: 90px;" >
  <option value="">-- Font Type-- </option>
  <? for($i=0;$i<sizeof($arryFont);$i++) {?>
  <option value="<?=$arryFont[$i]['font']?>"   <? if($arryFont[$i]['font']==$arrySite[0]['HeaderFontType']) echo 'selected';?>>
  <?=$arryFont[$i]['font']?>
  </option>
  <? } ?>
</select>
</Div></td>
    </tr>
 </table>
 
<table width="100%" border="0" cellspacing="0" cellpadding="5" >
  <tr>
    <td valign="top" class="greenbox">
		<input  type="checkbox" name="HeaderLogoOption" id="HeaderLogoOption" value="1" <? if($arrySite[0]['HeaderLogoOption']=='1') echo 'checked'; ?> onclick="Javascript:ShowHideDiv('HeaderLogoDiv');"/> <?=STORE_LOGO_SECTION?></td>
    </tr>
  <tr>
  	<td valign="top" >
	
	
		<Div id="HeaderLogoDiv" <? if($arrySite[0]['HeaderLogoOption']!='1') echo 'style="visibility:hidden"'; ?>>

		<table width="100%" cellpadding="0" cellspacing="0" class="blacktxt"><tr>
		
	
    <td width="6%"> Logo:</td>
    <td class="skytxt" nowrap>
	
	<a href="Javascript: UploadImage('uploadLogo.php','300','300','Yes')">Upload Logo</a>
	<input type="hidden" name="HeaderLogo" id="HeaderLogo" value="<?=$HeaderLogo?>" /><span id="HeaderLogoSpan" <?=$HeaderLogoStyle?>> | <a onclick="OpenNewPopUp('showimage.php?LastHeaderLogo=1&img=templates/temp/<?=$HeaderLogo?>', 150, 100, 'yes' );"  href="#">View Uploaded Logo</a></span>	</td>
    <td width="23%" align="left">
	<?
	
	if($arrySite[0]['LogoAlign']=='left'){
		$LogoAlignLeft = 'class="ImgTemplateSel"';
	}else if($arrySite[0]['LogoAlign']=='center'){
		$LogoAlignCenter = 'class="ImgTemplateSel"';
	}else if($arrySite[0]['LogoAlign']=='right'){
		$LogoAlignRight = 'class="ImgTemplateSel"';
	}

	?>
	
<input type="hidden" name="LogoAlign" id="LogoAlign" value="<?=$arrySite[0]['LogoAlign']?>"   />
<a href="#BodyTopID" class="alignsel"><img src="images/align_left.gif" onclick="SetLogoAlign('left');" id="LogoImgLeft" <?=$LogoAlignLeft?> border="0"  /></a>

<a href="#BodyTopID" class="alignsel"><img src="images/align_center.gif" onclick="SetLogoAlign('center')" id="LogoImgCenter" <?=$LogoAlignCenter?> border="0" /></a>

<a href="#BodyTopID" class="alignsel"><img src="images/align_right.gif"  onclick="SetLogoAlign('right')" id="LogoImgRight" <?=$LogoAlignRight?> border="0" /></a> 		</td>
    <td width="40%"> Width: 
      <input type="text" name="LogoWidth" id="LogoWidth" class="txtfield" maxlength="4" size="4" value="<?=$arrySite[0]['LogoWidth']?>"> 
	 &nbsp;&nbsp;Height: 
	 <input type="text" name="LogoHeight" id="LogoHeight" class="txtfield" maxlength="4" size="4" value="<?=$arrySite[0]['LogoHeight']?>">	</td>
    <td width="5%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
	
	</tr>
		  <tr>
		    <td colspan="6"><span class="blacktxt">(Maximum Dimensions: 900 pixels by 120 pixels | GIF, JPG or PNG)</span></td>
		    </tr>
		</table>
	</Div>
	
	
	</td>
	
  </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="5" class="blacktxt">
  <tr>
    <td colspan="6" valign="top" class="greenbox">
		<input  type="checkbox" name="BannerOption" id="BannerOption" value="1" <? if($arrySite[0]['BannerOption']=='1') echo 'checked'; ?>  onclick="Javascript:ShowHideDiv('BannerDiv');"/><?=STORE_BANNER_SECTION?></td>
    </tr>
	
 <tr>
  	<td valign="top" >
	
	
		<Div id="BannerDiv" <? if($arrySite[0]['BannerOption']!='1') echo 'style="visibility:hidden"'; ?>>

		<table width="100%" cellpadding="0" cellspacing="0" class="blacktxt">
		  
 
 
 
    <td colspan="4" height="30"> Image:
		
	   <span class="skytxt"> <a href="Javascript: UploadImage('uploadBanner.php','300','300','Yes')">Upload Image</a></span>
	    <input type="hidden" name="BannerBgImage" id="BannerBgImage" value="<?=$BannerBgImage?>" />	    
		<span id="BannerBgImageSpan" <?=$BannerBgImageStyle?> class="skytxt"> | <a onclick="OpenNewPopUp('showimage.php?LastBanner=1&img=templates/temp/<?=$BannerBgImage?>', 150, 100, 'yes' );"  href="#">View Uploaded Image</a></span>	
	<span class="blacktxt">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="BannerBgRepeate" id="BannerBgRepeate" value="1" <? if($arrySite[0]['BannerBgRepeate']=='1') echo 'checked'; ?> > <?=REPEATE_IMAGE?></span>	
	 &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;	
	Width: 
      <input type="text" name="BannerWidth" id="BannerWidth" class="txtfield" maxlength="4" size="4" value="<?=$arrySite[0]['BannerWidth']?>"> 
	 &nbsp;&nbsp;Height: 
	 <input type="text" name="BannerHeight" id="BannerHeight" class="txtfield" maxlength="4" size="4" value="<?=$arrySite[0]['BannerHeight']?>">			</td>
	 
	 <td colspan="2" align="left">
	 Banner Link:  <input type="text" name="BannerLink" id="BannerLink" class="txtfield" maxlength="150" size="40" value="<?=stripslashes($arrySite[0]['BannerLink'])?>">	
	 </td>
	 
    </tr>
		
     <tr>
		    <td colspan="6" height="22"><span class="blacktxt">(Recommended Dimensions: 650 pixels by 140 pixels | GIF, JPG or PNG)</span></td>
		    </tr>
    <tr>
		    <td width="11%"><input type="checkbox" name="BannerTextOption" id="BannerTextOption" value="1" <? if($arrySite[0]['BannerTextOption']=='1') echo 'checked'; ?> />
Banner Text:	  </td>
		    <td width="24%"><!--  <input name="BannerText" type="text" class="txtfield" id="BannerText" value="<?=stripslashes($arrySite[0]['BannerText'])?>" size="20" maxlength="90" />-->
 <textarea name="BannerText" class="txtfield_contact" rows="2" id="BannerText" style="width:200px;resize: none;" /><?=stripslashes($arrySite[0]['BannerText'])?></textarea></td>
		    <td width="15%" nowrap="nowrap" align="center" >
<?
	if($arrySite[0]['BannerTextAlign']=='left'){
		$BnStyleLeft = 'class="ImgTemplateSel"';
	}else if($arrySite[0]['BannerTextAlign']=='center'){
		$BnStyleCenter = 'class="ImgTemplateSel"';
	}else if($arrySite[0]['BannerTextAlign']=='right'){
		$BnStyleRight = 'class="ImgTemplateSel"';
	}

?>			
<input type="hidden" name="BannerTextAlign" id="BannerTextAlign" value="<?=$arrySite[0]['BannerTextAlign']?>"   />
<a href="#BodyTopID" class="alignsel"><img src="images/align_left.gif" onclick="SetBannerTextAlign('left');" id="BannerImgLeft" <?=$BnStyleLeft?> border="0"  /></a>

<a href="#BodyTopID" class="alignsel"><img src="images/align_center.gif" onclick="SetBannerTextAlign('center')" id="BannerImgCenter" <?=$BnStyleCenter?> border="0" /></a>

<a href="#BodyTopID" class="alignsel"><img src="images/align_right.gif"  onclick="SetBannerTextAlign('right')" id="BannerImgRight" <?=$BnStyleRight?> border="0" /></a>			</td>
		    <td width="14%" nowrap="nowrap" align="right"  >Color:
<input name="BannerFontColor" type="text" class="txtfield" id="BannerFontColor" value="<?=$BannerFontColor?>" style="width:50px" maxlength="8"  readonly=""/>
      	   <a href="Javascript: OpenNewPopUp('ColorPicker/color_pick.htm?inputbox=BannerFontColor&sample=sample3','800','800','Yes')"><img src="images/sel.gif" alt="select color" width="15" height="13" border="0" style="cursor:pointer" title="Select Color" /></a>		
             
	 <!--<img src="images/sel.gif" alt="select color" width="15" height="13" border="0" style="cursor:pointer" title="Select Color" onClick="Javascript: showColorGrid3('BannerFontColor','sample3');" />-->
					<input name="sample3" type="text" readonly id="sample3" style="background-color: <?=$BannerFontColor?>" value="" size="1" maxlength="0" class="txtfield"/>  
						  
				    <div id="colorpicker301" style="position:absolute;left:300;top:400;"></div>	</td>
		    <td width="14%" align="right">Size:
              <select name="BannerFontSize" class="txtfield" id="BannerFontSize" style="width: 90px;" >
                <option value="">-- Font Size -- </option>
                <? for($i=0;$i<sizeof($arryFontSize);$i++) {?>
                <option value="<?=$arryFontSize[$i]['FontSize']?>"   <? if($arryFontSize[$i]['FontSize']==$arrySite[0]['BannerFontSize']) echo 'selected';?>>
                <?=$arryFontSize[$i]['FontSize']?>
                </option>
                <? } ?>
              </select></td>
		    <td width="22%" align="right" >Font:
              <select name="BannerFontType" class="txtfield" id="BannerFontType" style="width: 90px;" >
                <option value="">-- Font Type-- </option>
                <? for($i=0;$i<sizeof($arryFont);$i++) {?>
                <option value="<?=$arryFont[$i]['font']?>"   <? if($arryFont[$i]['font']==$arrySite[0]['BannerFontType']) echo 'selected';?>>
                <?=$arryFont[$i]['font']?>
                </option>
                <? } ?>
              </select></td>
		    </tr>
		  </table>
	</Div>
	
	
	</td>

	
	
	
  </tr>	
	
	
	</table>
  <table width="100%" border="0" cellspacing="0" cellpadding="5" >

  <tr>
    <td   style="text-align:right"class="graybox">
	<input type="hidden" name="MemberID" id="MemberID" value="<?=$_SESSION['MemberID']?>" />
	<input type="hidden" name="UserName" id="UserName" value="<?=$_SESSION['UserName']?>" />
	<input type="hidden" name="WebsiteStoreOption" id="WebsiteStoreOption" value="<?=$_GET['ws']?>" />
	
	
	<a href="Javascript: WatchPreview()"><img src="images/preview.jpg" border="0" /></a>      <input name="Send32" src="images/save.jpg" type="image"  value="Save" alt="Click here to save" title="Click here to save" width="58" height="19">
	
	<a href="edit-template.php?reset=true&save=1" onclick="return confDel('<?=RESET_TO_DEFAULT_TEMPLATE?>')" ><img src="images/save_default.jpg" alt="Click here to reset" title="Click here to reset" border="0" /></a>  
	
	</td>
    </tr>
</table>
		
</form>		
		
		</td>
      </tr>
	  <tr>
	  	<td>&nbsp;
		</td>
	  </tr>
	  <tr>
        <td height="32"  valign="top" align="center">
<Div align=center class="redtxt" id="LoadingDiv"><br><br><br><br><br><img src="images/load.gif">Loading your store.....</Div>		
		
<Div style="display:none" id="IframeDiv">		
  <iframe src="" name="StoreIframe" id="StoreIframe" frameborder="0" style="border:none; margin:10px 0 0 0;" width="100%" height="800" scrolling="yes" ></iframe> 		
</Div>	
		</td>
      </tr>
	  
	  <tr>
	  <td align="center"   >
	  
	  </td>
	  </tr>
	  

    </table></td>
    
  </tr>
</table>
</td>
</tr>
</table>
