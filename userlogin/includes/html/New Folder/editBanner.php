<div class="had"><? 
			$BannerTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $BannerTitle.$ModuleName;
			 ?></div>

<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD HEIGHT=398 align="center" valign="top"><table width="100%" height="388"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="388" align="center" valign="middle" >
		 <br> <div  align="center" class="red"><?=$errorMsg?></div><br>
		  <div  align="right"><a href="viewBanners.php" class="Blue">List Banners</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
    
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                   <? if(!empty($_GET['edit'])){ ?>
				   <!--
 	<tr >
      <td align="right"   ><u>Posted by</u></td>
    <td  height="30" align="left"  colspan="2">
	<?
	
	if($MemberID > 0 && $UserName!=''){
		echo '<span class="red"><a onclick="OpenNewPopUp(\'vSeller.php?edit='.$MemberID.'\', 550, 500, \'no\' );" href="#" class="Blue">'.$UserName.'</a></span>';
	}else if($MemberID >0){
		echo '<span class="red">'.$UserName.' <span class="red">(Member Removed)</span>';
	}else{
		echo '<span class="red">Admin</span>';
	}
	
	?>	</td>
  </tr>
  
  <tr>
      <td align="right"   class="blackbold">Payment Status</td>
    <td  height="30" align="left" class="blacknormal" colspan="2">
	
	 	<select name="Payment" id="Payment" class="inputbox" style="width:100px;">
          <option value="0" <? if($Payment != '1') echo 'selected';?>> Pending </option>
          <option value="1" <? if($Payment == '1') echo 'selected';?>> Received </option>
        </select>		</td>
  </tr>
  <tr>
      <td align="right"   class="blackbold">Payment Method</td>
    <td  height="30" align="left" class="blacknormal" colspan="2">
	
	 	<?=$payment_gateway?>	</td>
  </tr>
  -->
  <? } ?>
  
  				<tr <? //if(empty($_GET['edit'])){ echo 'style="display:none"';} ?> style="display:none" >
                      <td  align="right"   class="blackbold" >Paid Amount</td>
                      <td align="left" colspan="2" ><input type="text" class="inputbox" name="TotalAmount" id="TotalAmount" value="<?=$TotalAmount?>" size="7" maxlength="8"/>
                          <?=$Config['Currency']?></td>
                    </tr>
  
                    <tr>
                      <td width="40%" align="right" valign="middle" =""  class="blackbold"> Banner Title <span class="red">*</span></td>
                      <td colspan="2" align="left"><input value="<?=stripslashes($Title)?>" name="Title" type="text" class="inputbox" id="Title" size="30" maxlength="30" /></td>
                    </tr>
					<!--
                    <tr>
                      <td width="32%" align="right" valign="middle" =""  class="blackbold"> Company Name <span class="red">*</span></td>
                      <td colspan="2" align="left"><input value="<?=stripslashes($CompanyName)?>" name="CompanyName" type="text" class="inputbox" id="CompanyName" size="30" maxlength="100" /></td>
                    </tr>
                    <tr>
                      <td  align="right"   class="blackbold">Email <span class="red">*</span> </td>
                      <td  height="30" align="left" colspan="2" ><input name="Email" type="text" class="inputbox" id="Email" value="<?=$Email?>" size="30" maxlength="80" /></td>
                    </tr>
                    <tr>
                      <td  align="right"   class="blackbold">Phone : </td>
                      <td  height="30" colspan="2" align="left" ><input name="Phone" type="text" class="inputbox" id="Phone" value="<?=$Phone?>" size="30" maxlength="20" /></td>
                    </tr>
                    <tr>
                      <td  align="right"   class="blackbold">Fax : </td>
                      <td height="30" align="left" colspan="2" ><input name="Fax" type="text" class="inputbox" id="Fax" value="<?=$Fax?>" size="30" maxlength="20" /></td>
                    </tr>
					--->
                    <tr>
                      <td align="right"   class="blackbold" valign="top">Website Url <span class="red">*</span> </td>
                      <td height="50" colspan="2" align="left" valign="top"><input name="webUrl" type="text" class="inputbox" id="webUrl" size="50" 
		  value="<?=(!empty($WebsiteUrl))?($WebsiteUrl):("http://")?>" maxlength="200" />  <?=$MSG[205]?></td>
                    </tr>
                    <tr>
                      <td width="32%" height="50" align="right" valign="top"   class="blackbold"> Banner <span class="red">*</span></td>
                      <td width="24%" height="50" align="left" valign="top" class="blacknormal"><input name="Image" type="file" class="inputbox" id="Image" size="17"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" /></td>
                      <td width="44%" align="left" valign="top" class="blacknormal">
					  
					  (Supported file types are: .jpg & .gif & swf.)  <br>
(Recommended Dimensions: <span id="WidthSpan2"><?=$WidthLimit?></span> by <?=$HeightMax?> pixels)
					  
					 
                       
                        <div id="divHidden" style="position:absolute; visibility:hidden; width:auto"></div></td>
                    </tr>
                    <tr  style="display:none">
                      <td align="right"   valign="top" class="blackbold">Banner Url  </td>
                      <td height="30" colspan="2" align="left"><input name="BannerUrl" type="text" class="inputbox" id="BannerUrl" size="50" 
		  value="<?=$BannerUrl?>" maxlength="200" /></td>
                    </tr>
                    <? if($arryBanner[0]['Image'] !='' && file_exists('../banner/'.$arryBanner[0]['Image']) ){ 
					
					$ImageExist = 1;
					?>
                    <tr>
                      <td width="32%" align="right"   valign="top" class="blackbold">Current Banner  </td>
                      <td height="30" colspan="2" align="left">
					<a href="#" onclick="OpenNewPopUp('../banner/<?=$arryBanner[0][Image]?>', 150, 100, 'yes' );">
					<?php #echo '<img src="../resizeimage.php?w='.$arryBanner[0]['DisplayWidth'].'&h='.$arryBanner[0]['DisplayHeight'].'&img=banner/'.$arryBanner[0]['Image'].'" border=0 >'; 
					echo '<strong>View Banner</strong>';?>
				</a>	
						
						</td>
                    </tr>
                    <? } ?>
					
				<!-- <tr >
	  <td align="right" valign="middle"  class="blackbold">Display Zone  </td>
	  <td colspan="2" align="left" class="blacknormal">
	  <select name="Position" id="Position" class="inputbox" style="width:100px;" onchange="Javascript:ShowDisplayDiv();">
		  <option value="Right" <? if($Position == 'Right') echo 'selected';?>> Right </option>
		  <option value="Top" <? if($Position == 'Top') echo 'selected';?>> Top </option>
	  </select></td>
	</tr>	-->
					
                    <tr>
                      <td align="right"   class="blackbold">Display Width<span class="red"> *</span> </td>
                      <td height="30" colspan="2" align="left"><span class="blacknormal">
                        <input type="text" class="inputbox" size="7" maxlength="3" name="DisplayWidth" id="DisplayWidth" value="<?=$DisplayWidth?>"/> 
                        <?=$WidthMin?> to   <span id="WidthSpan"><?=$WidthLimit?></span>
                       
                     
                      
                        
                      </span></td>
                    </tr>
                    <tr>
                      <td align="right"   class="blackbold">Display Height <span class="red">*</span> </td>
                      <td height="50" colspan="2" align="left"><span class="blacknormal">
                        <input type="text" class="inputbox" size="7" maxlength="3" name="DisplayHeight" id="DisplayHeight" value="<?=$DisplayHeight?>"/>    <?=$HeightMin?> to <?=$HeightMax?>
                      </span></td>
                    </tr>
                    <tr >
                      <td align="right" valign="top"  class="blackbold" >
					  <Div id="DisplayTitleDiv" <? if($Position == 'Top') echo 'style="display:none"';?> >
					  Display on Page(s) <span class="red">*</span> 
					  </Div>
					  </td>
                      <td colspan="2" align="left" class="blacknormal">
 <Div id="DisplayValueDiv" <? if($Position == 'Top') echo 'style="display:none"';?>>  
 
 <? $ShowOn=explode(',',$ShowOn);?>                
<select name="DisplayOn" id="DisplayOn" class="inputbox" size="2" multiple="multiple" style="width:170px;">
	<? for($b=0;$b<sizeof($arryPage);$b++){ ?>
		<option value="<?=$arryPage[$b]['PageUrl']?>" <? if(in_array($arryPage[$b]['PageUrl'],$ShowOn)) echo 'selected';?>> <?=$arryPage[$b]['PageName']?> </option>
	<? } ?>
</select>
	  <br />
	  <input type="checkbox" name="c1" value="1" id="c1" onclick="checkAll();" />
	Select	All 
						
	 </Div>					
						
			</td>
		</tr>
					
                   
					
					 <? if(!empty($_GET['edit'])){ ?>
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Clicks </td>
                      <td colspan="2" align="left" class="blacknormal"><?=$Clicks?></td>
                    </tr>
					<? } ?>
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Status  </td>
                      <td colspan="2" align="left" class="blacknormal"><table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
                          <tr>
                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
                            <td width="48" align="left" valign="middle">Active</td>
                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
                            <td width="63" align="left" valign="middle">Inactive</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr style="display:none" >
                      <td align="right" valign="top"  class="blackbold">Banner Type <span class="red">*</span>  </td>
                      <td colspan="2" align="left" class="blacknormal">
					
                            <input type="radio" name="BannerType" onclick="Javascript:ShowFetDiv(1);" value="Impression"  <? if($BannerType == 'Impression') echo 'checked';?> />
                          Impression<br />
                            <input type="radio" name="BannerType" onclick="Javascript:ShowFetDiv(2);"  value="Duration" <? if($BannerType == 'Duration') echo 'checked';?> />
                          Duration
                                                					  </td>
                    </tr>
                    <tr >
                      <td colspan="3" align="left" valign="top" >
					  
 <div id="DurationDiv" <? if($BannerType == 'Impression' || $BannerType == '') echo 'style="display:none"';?>>
                              <table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                <tr>
                                  <td width="40%" height="30" class="blackbold" align="right" >Activation Date <span class="red">*</span></td>
                                  <td   > <? if($ActDate < 1) $ActDate = ''; echo date_picker($ActDate,'actDate');?></td>
                                </tr>
                                <tr>
                                  <td class="blackbold" height="30"  align="right" >Expiration Date<span class="red">*</span> </td>
                                  <td  >
								   <? if($ExpDate < 1) $ExpDate = ''; echo date_picker($ExpDate,'expDate');?>								  </td>
                                </tr>
                              </table>
                          </div>
                          <div id="ImpressionDiv" <? if($BannerType == 'Duration' || $BannerType == '') echo 'style="display:none"';?>>
                              <table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                <tr>
                                  <td width="40%" height="30"  class="blackbold"  align="right">Total Impressions</td>
                                  <td    ><input type="text" class="inputbox"  size="10" maxlength="10" name="TotalImpressions" id="TotalImpressions" value="<?=$TotalImpressions?>"/></td>
                                </tr>
                                <tr>
                                  <td  height="30"  class="blackbold" align="right" >Impressions Shown</td>
                                  <td  ><input name="Impressions" type="text" class="inputbox" id="Impressions" value="<? echo $Impressions; ?>" size="10" maxlength="10" />                                  </td>
                                </tr>
                              </table>
                          </div> 					  
					  
					  
					  </td>
                    </tr>
                  </table></td>
                </tr>
				
				
			
				 <tr>
                      <td align="center" valign="middle">
					  <br>
					  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />&nbsp;
                          <input type="reset" name="Reset" value="Reset" class="button" />
                          <input type="hidden" name="BannerID" id="BannerID"  value="<?=$_GET['edit']?>" />
                          <input type="hidden" name="BannerHidden" id="BannerHidden"  value="<?=$BannerUrl?>" />
                          <input type="hidden" name="ImageExist" id="ImageExist"  value="<?=$ImageExist?>" />
						   <input type="hidden" name="ShowOn" id="ShowOn"  value="<?=$ShowOn?>" />  
						 <input type="hidden" name="MemberID" id="MemberID"  value="<?=$MemberID?>" />
						 <input type="hidden" name="OldStatus" id="OldStatus"  value="<?=$Status?>" />
						 
						 <br>  
						 <br>  <br>  <br>				   </td>
                    </tr>
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
<SCRIPT LANGUAGE=JAVASCRIPT>


var WidthMin  = '<?=$WidthMin?>';
var HeightMin = '<?=$HeightMin?>';   
var WidthMax  = '<?=$WidthMax?>';
var HeightMax = '<?=$HeightMax?>';   

var WidthMaxTop  = '<?=$WidthMaxTop?>';

function ShowFetDiv(opt){

	if(opt==1){
		document.getElementById("ImpressionDiv").style.display = 'inline';
		document.getElementById("DurationDiv").style.display = 'none';
	}else if(opt==2){
		document.getElementById("ImpressionDiv").style.display = 'none';
		document.getElementById("DurationDiv").style.display = 'inline';
	}
	
}

function ShowDisplayDiv(){
	if(document.getElementById("Position").value=='Top'){
		document.getElementById("DisplayTitleDiv").style.display = 'none';
		document.getElementById("DisplayValueDiv").style.display = 'none';
		document.getElementById("WidthSpan").innerHTML = WidthMaxTop;
		document.getElementById("WidthSpan2").innerHTML = WidthMaxTop;
	}else{
		document.getElementById("DisplayTitleDiv").style.display = 'inline';
		document.getElementById("DisplayValueDiv").style.display = 'inline';
		document.getElementById("WidthSpan").innerHTML = WidthMax;
		document.getElementById("WidthSpan2").innerHTML = WidthMax;
	}
	
}


function ValidateForm(frm)
{

 	var IE = document.all?true:false;
	
	var WidthLimit;
	WidthLimit = WidthMax;

	if(  ValidateForBlank(frm.Title, "Banner Title") 
		/*&& ValidateForBlank(frm.CompanyName, "Company Name")
		&& ValidateForEmail(frm.Email, "Email")
		&& isEmail(frm.Email)
		&& ValidateOptPhoneNumber(frm.Phone,"Phone Number")
		&& ValidateOptFax(frm.Fax,"Fax Number")*/
		&& ValidateOptDecimalField(frm.TotalAmount,"Paid Amount")
		&& isValidLink(frm.webUrl,"Website Url")
		&& SetDisplayPages()
	){
			if(document.getElementById("ImageExist").value == '' || document.getElementById("Image").value != ''){
			
				if(!ValidateMandBanner(frm.Image, "Banner")){
					return false;
				}
				
				/*if(IE == true){
					if(!CheckImageSize("divHidden",WidthMin,HeightMin,WidthMax,HeightMax)){
						return false;
					}
				}*/
				
			}

		/*
		if(document.getElementById("BannerUrl").value != '' && document.getElementById("Image").value != ''){
			alert("You can't choose both options for Banner Image. Please specify only one of them !!");
			document.getElementById("Image").value = '';
			document.getElementById("BannerUrl").select();
			return false;
		}
		
			
		if(document.getElementById("BannerUrl").value != ''){
			if(!isValidLink(frm.BannerUrl, "Banner Url")){
				return false;
			}
		}
		*/
		if(!ValidateMandNumField2(frm.DisplayWidth,"Display Width",WidthMin,WidthLimit)){
			return false;
		}
		
		if(!ValidateMandNumField2(frm.DisplayHeight,"Display Height",HeightMin,HeightMax)){
			return false;
		}
		

		
			if(frm.ShowOn.value==''){
				alert("Please Select the pages to show the banner.");
				frm.DisplayOn.focus();
				return false;
			}
		
		
				if(!ValidateRadioButtons(frm.BannerType,"Banner Type")){
					return false;
				}

				if(document.getElementById("DurationDiv").style.display != 'none'){

					if(!ValidateForSimpleBlank(frm.actDate, "Activation Date")){
						return false;
					}
					if(!ValidateForSimpleBlank(frm.expDate, "Expiration Date")){
						return false;
					}
					
					if(frm.actDate.value>=frm.expDate.value){
						alert("Activation Date should be greater than Expiration Date !!");
						return false;
					}
				
				}


				if(document.getElementById("ImpressionDiv").style.display != 'none'){
					if(!ValidateOptNumField2(frm.TotalImpressions,"Total Impressions",1,1000000)){
						return false;
					}
					if(!ValidateOptNumField2(frm.Impressions,"Impressions Shown",1,1000000)){
						return false;
					}
				}		
		
		
		/*
		if(!ValidateOptNumField(frm.TotalImpressions,"Impressions Booked")){
			return false;
		}
		
		
		if (!ValidateForBlank(frm.actDate, "Activation Date")){
			return false;
		}
		
		if (!ValidateForBlank(frm.expDate, "Expiration Date")){
			return false;
		}
		
		if(frm.actDate.value>frm.expDate.value){
			alert("Expiration Date must be greater than Activation Date !!");
			return false;
		}
		*/
		var Url = "isRecordExists.php?BannerTitle="+document.getElementById("Title").value+"&editID="+document.getElementById("BannerID").value;
		SendExistRequest(Url,"Title","Banner Title");
		return false;
	}else{
		return false;	
	}
	
	
	
}


function ClearBannerUrl(){
	document.getElementById("BannerUrl").value = '';
}

function SetDisplayPages(){
	var ShowOn = '';
	
	for(var i=0;i<document.getElementById("DisplayOn").options.length;i++)
	{
		if(document.getElementById("DisplayOn").options[i].selected == true){
			ShowOn += document.getElementById("DisplayOn").options[i].value+",";
		}
	}
	document.getElementById("ShowOn").value = ShowOn;
	return 1;
}

function checkAll(){	
	if(document.getElementById("c1").checked){
		for(var i = 0;i < document.getElementById("DisplayOn").length;i++){
			document.getElementById("DisplayOn").options[i].selected = true;
		}
		
	}else{
		for(var i = 0;i < document.getElementById("DisplayOn").length;i++){
			document.getElementById("DisplayOn").options[i].selected = false;
		}
	}
}
</SCRIPT>