<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <a href="advertise-with-us.php"><?=ADVERTISE_WITH_US?></a> </span> <?=POST_YOUR_BANNER?> </td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=POST_YOUR_BANNER?> </td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" >
		
		
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" >
        
          <tr>
            <td  valign="top" >
			
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="blacktxt1">
	<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td class="blacktxt1" id="MainTD" >
		</td>
  </tr>
  
   <tr>
         <td align="center" valign="bottom" ><Div id="MsgDiv_Contact" class="redtxt"><?=$errorMsg?></Div></td>
    </tr>
</table>	</td>
  </tr>
</table>		    </td>
          </tr>
	
	
   <tr>
    <td  height="200"  >
	
	<? 	if(sizeof($arryDuration)<=0 && sizeof($arryImpression)<=0){	?>
		<div class="redtxt" align="center"><?=NO_PACKAGE_FOUND?></div>
	<? }else{ ?>	
	
	
	
	<Div id="MainTable" >
			   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                
                
                 <tr>
                   <td align="left" valign="top" >
				    <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
				   <table width="100%" border="0" align="right" cellpadding="5" cellspacing="1"  class="generaltxt_inner">
                     <tr>
                       <td width="20%"  valign="middle" nowrap="nowrap"  > <?=BANNER_TITLE?> <span class="bluestar">*</span></td>
                       <td  align="left" ><input value="<?=stripslashes($_SESSION['Title'])?>" name="Title" type="text" class="txtfield_contact" id="Title" size="50" maxlength="30" /></td>
                     </tr>
					
                     <tr>
                       <td  valign="top"  ><?=WEBSITE_STORE?>  <span class="bluestar">*</span> </td>
                       <td height="50" valign="top" align="left" class="blacktxt"><input name="webUrl" type="text" class="txtfield_contact" id="webUrl" size="50" value="<?=(!empty($_SESSION['WebsiteUrl']))?($_SESSION['WebsiteUrl']):("http://")?>" maxlength="200" />
					 <br> <?=WEBSITE_FORMAT?> 
					   </td>
                     </tr>
                     <tr>
                       <td height="50"  valign="top"   > <?=BANNER_IMAGE?> <span class="bluestar">*</span></td>
                       <td height="50" align="left" valign="top" class="blacktxt"  ><input name="Image" type="file" class="txtfield_contact" id="Image" size="17"  onchange="ClearBannerUrl()" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
                       <br> <?=SUPPORTED_IMAGE_TYPES?>
<br> (Recommended Dimensions:  <span id="WidthSpan2"><?=$WidthLimit?></span> by <?=$HeightMax?> pixels)

                         <div id="divHidden" style="position:absolute; visibility:hidden; width:auto"></div></td>
                       </tr>
                     <tr style="display:none;">
                       <td   valign="top" ><?=BANNER_URL?>  </td>
                       <td height="30" align="left" ><input name="BannerUrl" type="text" class="txtfield_contact" id="BannerUrl" size="50" 
		  value="<?=$_SESSION['BannerUrl']?>" maxlength="200" /></td>
                     </tr>
                    
                    <tr style="display:none">
                       <td><?=DISPLAY_ZONE?>  </td>
                       <td align="left" >
					   
					   <select name="Position" id="Position" class="txtfield_contact" onchange="Javascript:ShowDisplayDiv();" style="width:120px;">
                           <option value="Right" <? if($_SESSION['Position'] == 'Right') echo 'selected';?>> Right </option>
                           <option value="Top" <? if($_SESSION['Position'] == 'Top') echo 'selected';?>> Top </option>
                       </select>
					   </td>
                     </tr> 
					
					 <tr>
                       <td><?=DISPLAY_WIDTH?><span class="bluestar"> *</span> </td>
                       <td height="30" align="left" class="blacktxt">
                         <input type="text" class="txtfield_contact" size="7" maxlength="3" name="DisplayWidth" id="DisplayWidth" value="<?=$_SESSION['DisplayWidth']?>"/> 
                        (<?=$WidthMin?> - <span id="WidthSpan"><?=$WidthLimit?></span>)                       </td>
                     </tr>
                     <tr>
                       <td    ><?=DISPLAY_HEIGHT?> <span class="bluestar">*</span> </td>
                       <td height="30" align="left" class="blacktxt"><span >
                         <input type="text" class="txtfield_contact" size="7" maxlength="3" name="DisplayHeight" id="DisplayHeight" value="<?=$_SESSION['DisplayHeight']?>"/>
                        (<?=$HeightMin?> - <?=$HeightMax?>)
                        
                       </span></td>
                     </tr>
                     <tr >
                       <td  valign="top" nowrap="nowrap"   >
					    <Div id="DisplayTitleDiv" <? if($Position == 'Top') echo 'style="display:none"';?> >
					   <?=DISPLAY_PAGES?> <span class="bluestar">*</span> 
					   </Div>
					   </td>
                       <td align="left" >
					    <Div id="DisplayValueDiv" <? if($Position == 'Top') echo 'style="display:none"';?>>  
					   
					   <? 
					   if(!empty($_SESSION['ShowOn'])){
					   		$ShowOn=explode(',',$_SESSION['ShowOn']);
					   }
					   
					   ?>
                         <span class="blacknormal">
 <select name="DisplayOn" id="DisplayOn" class="txtfield_contact" size="10" multiple="multiple" style="width:180px;">
	<? for($b=0;$b<sizeof($arryPage);$b++){ ?>
		<option value="<?=$arryPage[$b]['PageUrl']?>" <?  if(!empty($_SESSION['ShowOn'])){ if(in_array($arryPage[$b]['PageUrl'],$ShowOn)) echo 'selected'; } ?>> <?=$arryPage[$b]['PageName']?> </option>
	<? } ?>
  </select>
                        
						<br>
						<?=SHIFT_CONTROL_MSG?>

						 </span>
						 </Div>
						 </td>
                     </tr>
					
                    
			

                     
                     
					 <!--
					 <tr>
                       <td  valign="top" ><?=IMPRESSION?> <span class="bluestar">*</span></td>
                       <td align="left" valign="top" >
					   
<input type="radio" name="Impression" id="Impression" value="5" <? if($_SESSION['Impression']==5) echo 'checked';?> /> 
<span class="red12"><?=$Config['Currency']?> <?=$arrayConfig[0]['Banner5']?></span> for <strong>5000</strong> Impressions
<br />
<input type="radio" name="Impression" id="Impression" value="4" <? if($_SESSION['Impression']==4) echo 'checked';?>/> 
<span class="red12"><?=$Config['Currency']?> <?=$arrayConfig[0]['Banner4']?></span> for <strong>4000</strong> Impressions
<br />
<input type="radio" name="Impression" id="Impression" value="3" <? if($_SESSION['Impression']==3) echo 'checked';?>/> 
<span class="red12"><?=$Config['Currency']?> <?=$arrayConfig[0]['Banner3']?></span> for <strong>3000</strong> Impressions
<br />
<input type="radio" name="Impression" id="Impression" value="2" <? if($_SESSION['Impression']==2) echo 'checked';?>/>
<span class="red12"><?=$Config['Currency']?> <?=$arrayConfig[0]['Banner2']?></span> for <strong>2000</strong> Impressions
<br />
<input type="radio" name="Impression" id="Impression" value="1" <? if($_SESSION['Impression']==1) echo 'checked';?>/>
<span class="red12"><?=$Config['Currency']?> <?=$arrayConfig[0]['Banner1']?></span> for <strong>1000</strong> Impressions
					   
					   
					   
					   </td>
                     </tr>
					 --->
                     <tr>
                       <td  valign="middle" height="60" >&nbsp;</td>
                       <td align="left" valign="middle" ><input type="hidden" name="BannerID" id="BannerID"  value="<?=$_GET['edit']?>" />
                           <input type="hidden" name="BannerHidden" id="BannerHidden"  value="<?=$_SESSION['BannerUrl']?>" />
                           <input type="hidden" name="ShowOn" id="ShowOn"  value="<?=$_SESSION['ShowOn']?>" />
						   
						     <input type="hidden" name="MemberID" id="MemberID"  value="<?=$_SESSION['MemberID']?>" />
						   
                           <table width="100%" border="0" cellspacing="0" cellpadding="0">
                             <tr>
                               <td width="80" align="left"><input name="image" type="image" value=" " src="images/submit_contact.jpg" width="72" height="24"></td>
                               <td align="left"><input type="reset" name="Reset"  width="72" height="24" value=" " class="ResetContact"></td>
                             </tr>
                           </table></td>
                     </tr>
                   </table>
				   </form>
				   </td>
                 </tr>
				  <tr>
            <td height="35" colspan="2" align="left" valign="middle" class="generaltxt_inner"><span class="bluestar">*</span> Required.</td>
          </tr>
				 
				 
               </table> </div>
			   
			   <? } ?>
			   	</td>
  </tr>	  
		  
		  
		  
          <tr>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td height="6" ></td>
          </tr>
          <tr>
            <td align="center"></td>
          </tr>
        </table>	
		
		
		</td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
