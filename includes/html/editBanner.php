<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		
		<? $ModuleTitle = (!empty($_GET['edit']))?(EDIT_BANNER) :(ADD_BANNER);?>
		
		<span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span> <?=$ModuleTitle?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=$ModuleTitle?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" class="generaltxt_inner" align="center">
		
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" >
         
          <tr>
            <td colspan="2" height="30" align="center" valign="top"  class="red12"><?=$errorMsg?></td>
          </tr>
          
        
          <tr>
            <td colspan="2"  align="right"  height="50" valign="top"  class="skytxt"><a href="viewBanners.php">
              <? echo MY_BANNERS; ?>
            </a></td>
          </tr> 
		  
		   <tr>
            <td colspan="2"  valign="top" >
			
			
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="55%" valign="top">
	
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
				    <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
              
                <tr>
                  <td valign="top" bgcolor="#ffffff"><table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" class="generaltxt_inner">
                    <? if(!empty($_GET['edit'])){ ?>

                    <? } ?>
                    <tr>
                      <td width="32%"  valign="middle" nowrap="nowrap" > <?=BANNER_TITLE?> <span class="bluestar">*</span></td>
                      <td align="left"><input value="<?=stripslashes($Title)?>" name="Title" type="text" class="txtfield_normal" id="Title" size="30" maxlength="30" /></td>
                    </tr>
                    <!--
                    <tr>
                      <td width="32%"  valign="middle" nowrap="nowrap" > Company Name <span class="bluestar">*</span></td>
                      <td colspan="2" align="left"><input value="<?=stripslashes($CompanyName)?>" name="CompanyName" type="text" class="txtfield_normal" id="CompanyName" size="30" maxlength="100" /></td>
                    </tr>
                    <tr>
                      <td    >Email <span class="bluestar">*</span> </td>
                      <td  height="30" align="left" colspan="2" bgcolor="#FFFFFF"><input name="Email" type="text" class="txtfield_normal" id="Email" value="<?=$Email?>" size="30" maxlength="80" /></td>
                    </tr>
                    <tr>
                      <td    >Phone : </td>
                      <td  height="30" colspan="2" align="left" bgcolor="#FFFFFF"><input name="Phone" type="text" class="txtfield_normal" id="Phone" value="<?=$Phone?>" size="30" maxlength="20" /></td>
                    </tr>
                    <tr>
                      <td    >Fax : </td>
                      <td height="30" align="left" colspan="2" bgcolor="#FFFFFF"><input name="Fax" type="text" class="txtfield_normal" id="Fax" value="<?=$Fax?>" size="30" maxlength="20" /></td>
                    </tr>
					--->
                    <tr>
                      <td>Website Url<span class="bluestar">*</span> </td>
                      <td height="30" align="left"><input name="webUrl" type="text" class="txtfield_normal" id="webUrl" size="50" 
		  value="<?=$WebsiteUrl?>" maxlength="200" /></td>
                    </tr>
                    <tr>
                      <td height="50"  valign="top"  > <?=BANNER_IMAGE?>  </td>
                      <td  height="50" align="left" valign="top" ><input name="Image" type="file" class="txtfield_normal" id="Image" size="17"  onchange="ClearBannerUrl()" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
<br> <?=SUPPORTED_IMAGE_TYPES?>
<br> (Recommended Dimensions:  <span id="WidthSpan2"><?=$WidthLimit?></span> by <?=$HeightMax?> pixels)
                        				  </td>
                      </tr>
                    <tr style="display:none;">
                      <td   valign="top" ><?=BANNER_URL?></td>
                      <td height="30" align="left"><input name="BannerUrl" type="text" class="txtfield_normal" id="BannerUrl" size="50" 
		  value="<?=$BannerUrl?>" maxlength="200" /></td>
                    </tr>
                   <!--
                   <tr >
                      <td  valign="middle" ><?=DISPLAY_ZONE?></td>
                      <td colspan="2" align="left" > <?=$Position?>
					  <input type="hidden" name="Position" id="Position" value="<?=$Position?>">
					  </td>
                    </tr> 
					-->
				    <tr>
                      <td nowrap="nowrap" ><?=DISPLAY_WIDTH?> <span class="bluestar"> *</span> </td>
                      <td height="30" align="left"><span >
                        <input type="text" class="txtfield_normal" size="7" maxlength="3" name="DisplayWidth" id="DisplayWidth" value="<?=$DisplayWidth?>"/>
                        <?=$WidthMin?>
                        to
                        <span id="WidthSpan"><?=$WidthLimit?></span>
                      </span></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap"><?=DISPLAY_HEIGHT?> <span class="bluestar">*</span> </td>
                      <td height="30" align="left"><span >
                        <input type="text" class="txtfield_normal" size="7" maxlength="3" name="DisplayHeight" id="DisplayHeight" value="<?=$DisplayHeight?>"/>
                        <?=$HeightMin?>
                        to
                        <?=$HeightMax?>
                      </span></td>
                    </tr>
                    <tr <? if($Position == 'Top') echo 'style="display:none"';?>>
                      <td  valign="top" nowrap="nowrap"  >
					   <Div id="DisplayTitleDiv" <? if($Position == 'Top') echo 'style="display:none"';?> >
					  <?=DISPLAY_PAGES?> 
					  </Div>
					  </td>
                      <td align="left" class="outline"  >
					   <Div id="DisplayValueDiv" >  
					  <? 
					  
					 
					 $ShowOnPages =  $ShowOn;
					  
					 $ShowOn=explode(',',$ShowOn);
					  
					  
					 for($b=0;$b<sizeof($arryPage);$b++){
					 	if(in_array($arryPage[$b]['PageUrl'],$ShowOn)) 
							echo stripslashes($arryPage[$b]['PageName']).'<br>';
					 }
					  
					  ?>
					  
					  	<!--
                          <select name="DisplayOn" id="DisplayOn" class="txtfield_normal" size="3" multiple="multiple" style="width:170px;" >
                            <? for($b=0;$b<sizeof($arryPage);$b++){ ?>
                            <option value="<?=$arryPage[$b]['PageUrl']?>" <? if(in_array($arryPage[$b]['PageUrl'],$ShowOn)) echo 'selected';?>>
                            <?=$arryPage[$b]['PageName']?>
                            </option>
                            <? } ?>
                          </select>
                         <!-- <br />
                          <input type="checkbox" name="c1" value="1" id="c1" onclick="checkAll();" />
                        Select	All--> 
						
						</Div>
						</td>
                    </tr>
                 
                   
					
					
					
		<tr>
      <td>Payment Status</td>
    <td align="left">
	<input type="hidden" name="Payment" id="Payment" value="<?=$Payment?>">
	<? if($Payment==1) echo '<strong>Received</strong>'; else echo 'Pending'; ?> 	</td>
  </tr>
					 <tr >
                      <td  valign="middle" >Amount</td>
                      <td align="left" ><input type="hidden" class="txtfield_normal" name="TotalAmount" id="TotalAmount" value="<?=$TotalAmount?>" size="7" maxlength="8"/>
                          <?=$Config['Currency']?> <?=$TotalAmount?></td>
                    </tr>
					
					<? if(!empty($BannerType)){?>
                     <tr >
                      <td  valign="middle" nowrap="nowrap" >Banner Type </td>
                      <td align="left" ><?=$BannerType?></td>
                    </tr>
					
                    <tr >
                      <td  valign="middle" >Clicks  </td>
                      <td align="left" ><?=$Clicks?></td>
                    </tr><? } ?>

	<? if($BannerType=='Impression'){ ?>
				   <tr >
                      <td  valign="middle" nowrap="nowrap" >Total Impressions </td>
                      <td align="left" > <?=$TotalImpressions?></td>
                    </tr>
					
					<? if($TotalImpressions>0){ ?>
                    <tr >
                      <td >Impressions Shown </td>
                      <td ><?=$Impressions?></td>
                    </tr>
					 <tr >
                      <td nowrap="nowrap" >Remaining Impressions </td>
                      <td><? echo $rem = $TotalImpressions-$Impressions; ?></td>
                    </tr>
					<? } ?>
	<? } ?>

	<? if($BannerType=='Duration'){ ?>
                  
                    <tr >
                      <td  valign="middle" >Activation Date</td>
                      <td align="left" ><span class="greentxt"><? echo $ActDate;?></span>
                                             </td>
                    </tr>
                    <tr >
                      <td  valign="middle" >Expiration Date</td>
                      <td align="left" ><span class="greentxt"> <? echo $ExpDate;?></span>
                                              </td>
                    </tr>
   <? } ?>
                    <tr >
                      <td  valign="middle" >Status</td>
                      <td align="left"  >
					  <?
		if($Status ==1){
			  $status = '&nbsp;<span class=greentxt>Active</span>';
		 }else{
			  $status = '&nbsp;<span class=red12>InActive</span>';
		 }	

		echo  $status			  
					  ?>					  </td>
                    </tr>
                    <tr >
                      <td  valign="middle" >&nbsp;</td>
                      <td align="left" >&nbsp;
                        <table  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td ><input name="SubmitButton" id="SubmitButton" type="Submit" value="Update" class="button" ></td>
							<td>&nbsp;</td>
                            <td ><input type="reset" name="Reset"  value="Reset" class="button" /></td>
                          </tr>
                        </table>
                        <input type="hidden" name="BannerID" id="BannerID"  value="<?=$_GET['edit']?>" />
                        <input type="hidden" name="BannerHidden" id="BannerHidden"  value="<?=$BannerUrl?>" />
                        <input type="hidden" name="ShowOn" id="ShowOn"  value="<?=$ShowOnPages?>" />
                          
						 <input type="hidden" name="MemberID" id="MemberID" value="<?php echo $_SESSION['MemberID']?>" />
						 
                        <input type="hidden" name="Status" id="Status"  value="<?=$Status?>" />	
						      <input type="hidden" name="BannerType" id="BannerType"  value="<?=$BannerType?>" />	
		 <input type="hidden" name="ActDate" id="ActDate" value="<? echo $ActDate;?>" />				
<input type="hidden" name="TotalImpressions" id="TotalImpressions" value="<?=$TotalImpressions?>"/>		
<input type="hidden" name="Impressions" id="Impressions" value="<?=$Impressions?>"/>
  <input type="hidden" name="ExpDate" id="ExpDate" value="<? echo $ExpDate; ?>" /> 
  
    </td> 
  
               </tr>
                  </table></td>
                </tr> 
              </form>
          </table>	
	
	</td>
    <td valign="top" align="right" style="padding-top:10px;">
	
	<? 
		if($arryBanner[0]['Image'] !='' && file_exists('banner/'.$arryBanner[0]['Image']) ){ 
			$ImagePath = 'resizeimage.php?img=banner/'.$arryBanner[0]['Image'].'&w=180&h=190'; 

			$ImagePath = '<a href="banner/'.$arryBanner[0]['Image'].'" rel="lightbox"><img src="'.$ImagePath.'"  border="0" class="imgborder_prd"/></a>';
			//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img='.$arryBanner[0]['BannerUrl'].'\', 150, 100, \'yes\' );"  href="#"><img src="'.$ImagePath.'"  border="0" class="imgborder_prd"/></a>';
			
			echo $ImagePath;
			$ImageExist = 1;
		}
	
	?>
	
	<input type="hidden" name="ImageExist" id="ImageExist" value="<?=$ImageExist?>" >
	
	</td>
  </tr>
</table>
	
			
			
			
			
			
			
			</td>
          </tr>
         
        </table>
		

		
		
		</td>
      </tr>
    </table></td>
     <td align="right"  valign="top"><? require_once("includes/html/box/right.php"); ?>    </td>

  </tr>
</table>
</td>
  </tr>
</table>
