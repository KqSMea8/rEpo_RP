
<div class="had">Global Settings</div>
<TABLE WIDTH="80%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	 <form name="form1" action="" method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
	 <TR>
	  <TD  align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle">
		
		  <div class="message"><? if(!empty($_SESSION['mess_setting'])) {echo $_SESSION['mess_setting']; unset($_SESSION['mess_setting']); }?></div>
		    <table width="100%" height="110" border="0" cellpadding="0" cellspacing="0" class="borderall">
             
              
                <tr>
                  <td align="center" valign="top" ><table width="100%"  border="0" align="right" cellpadding="4" cellspacing="1">
                      
         <tr>
       		 <td colspan="2" align="left"   class="head">General Information</td>
        </tr>
                      <tr>
                        <td width="38%" align="right" valign="middle"  class="blackbold">Site Name :<span class="red">*</span>  </td>
                        <td align="left" valign="middle">
   <input name="SiteName" type="text" class="inputbox" id="SiteName"  value="<?=stripslashes($arryAdmin[0]['SiteName'])?>" maxlength="100">                        </td>
                      </tr>
					    <tr>
                          <td align="right" valign="middle"  class="blackbold">Site Title :<span class="red">*</span>  </td>
					      <td align="left" valign="middle"><input name="SiteTitle" type="text" class="inputbox" id="SiteTitle"  value="<?=stripslashes($arryAdmin[0]['SiteTitle'])?>" maxlength="200"/></td>
				      </tr>

 <tr>
                          <td align="right" valign="middle"  class="blackbold">Site Email :<span class="red">*</span>  </td>
					      <td align="left" valign="middle"><input name="SiteEmail" type="text" class="inputbox" id="SiteEmail"  value="<?=stripslashes($arryAdmin[0]['SiteEmail'])?>" maxlength="80"/></td>
				      </tr>

					  
	   <tr>
                    <td  class="blackbold" valign="top"   align="right"> Site Logo :</td>
                    <td  height="40" align="left" valign="top"  class="blacknormal">
					<input name="SiteLogo" id="SiteLogo" type="file" class="inputbox"    onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />&nbsp;<?=$MSG[201]?>


<?
if(IsFileExist($Config['SiteLogoDir'],$arryAdmin[0]['SiteLogo'])){ 
	$OldImage =  $arryAdmin[0]['SiteLogo'];

	$PreviewArray['Folder'] = $Config['SiteLogoDir'];
	$PreviewArray['FileName'] = $arryAdmin[0]['SiteLogo']; 
	$PreviewArray['FileTitle'] = stripslashes($arryAdmin[0]['SiteName']);
	$PreviewArray['Width'] = "150";
	$PreviewArray['Height'] = "150";
	$PreviewArray['Link'] = "1";

	echo '<br><br><div id="ImageDiv">'.PreviewImage($PreviewArray).'
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:RemoveFile(\''.$Config['SiteLogoDir'].'\',\''.$arryAdmin[0]['SiteLogo'].'\',\'ImageDiv\')">'.$delete.'</a><input type="hidden" name="OldImage" value="'.$OldImage.'"></div>';

}
?>


			 
			
					
						
					
					
					
                  				</td>
                  </tr>
			 <tr>
					      <td align="right" valign="middle"  class="blackbold">Records Per Page :</td>
					      <td align="left" valign="middle">
						  
	<select name="RecordsPerPage" id="RecordsPerPage" class="textbox">
        <option value="5" <? if($arryAdmin[0]['RecordsPerPage'] == 5) echo 'selected';?>> 5 </option>
        <option value="10" <? if($arryAdmin[0]['RecordsPerPage'] == 10) echo 'selected';?>> 10 </option>
        <option value="15" <? if($arryAdmin[0]['RecordsPerPage'] == 15) echo 'selected';?>> 15 </option>
        <option value="20" <? if($arryAdmin[0]['RecordsPerPage'] == 20) echo 'selected';?>> 20 </option>
        <option value="25" <? if($arryAdmin[0]['RecordsPerPage'] == 25) echo 'selected';?>> 25 </option>
        <option value="30" <? if($arryAdmin[0]['RecordsPerPage'] == 30) echo 'selected';?>> 30 </option>
        <option value="40" <? if($arryAdmin[0]['RecordsPerPage'] == 40) echo 'selected';?>> 40 </option>
        <option value="50" <? if($arryAdmin[0]['RecordsPerPage'] == 50) echo 'selected';?>> 50 </option>
        <option value="75" <? if($arryAdmin[0]['RecordsPerPage'] == 75) echo 'selected';?>> 75 </option>
        <option value="100" <? if($arryAdmin[0]['RecordsPerPage'] == 100) echo 'selected';?>> 100 </option>
        <option value="150" <? if($arryAdmin[0]['RecordsPerPage'] == 150) echo 'selected';?>> 150 </option>
        <option value="200" <? if($arryAdmin[0]['RecordsPerPage'] == 200) echo 'selected';?>> 200 </option>
     </select>                          </td>
				      </tr>
	
	<!--
	<tr>
                    <td  class="blackbold" valign="top"   align="right"> Body Background Image :<span class="red"> &nbsp;</span></td>
                    <td  height="40" align="left" valign="top"  class="blacknormal">
					
				
					
					
					<input name="BodyBg" id="BodyBg" type="file" class="inputbox"    onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />&nbsp;<?=$MSG[201]?>
				
					
					
		 <? if($arryAdmin[0]['BodyBg'] !='' && file_exists('../images/'.$arryAdmin[0]['BodyBg']) ){ ?>
			<br>	<br> 
			
<a href="#" onclick="OpenNewPopUp('../showimage.php?img=images/<?=$arryAdmin[0]['BodyBg']?>', 150, 150, 'yes' );">		
				<strong>View Current Image</strong>
				</a> <br><br> 
			<input type="checkbox" name="DelBodyBg" value="../images/<?=$arryAdmin[0]['BodyBg']?>">Delete<br>
					   <? }?>					
					
					
					 <br> <br> 
                  				</td>
                  </tr>		
			
					  
	 <tr>
                    <td  class="blackbold" valign="top"   align="right"> Home Page Image :</td>
                    <td  height="40" align="left" valign="top"  class="blacknormal">
					
				
					
					
					<input name="HomeImage" id="HomeImage" type="file" class="inputbox"    onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />&nbsp;<?=$MSG[201]?>
					<br> 	
Maximum width: 990px<br>Maximum height: 500px

					
					
		 <? if($arryAdmin[0]['HomeImage'] !='' && file_exists('../images/'.$arryAdmin[0]['HomeImage']) ){ ?>
			<br>	<br> 
			
<a href="#" onclick="OpenNewPopUp('../showimage.php?img=images/<?=$arryAdmin[0]['HomeImage']?>', 150, 150, 'yes' );">		
				<strong>View Current Image</strong>
				</a> <br><br> 
			<input type="checkbox" name="DelHomeImage" value="../images/<?=$arryAdmin[0]['HomeImage']?>">Delete<br>
					   <? }?>					
					
					
					 <br> <br> 
                  				</td>
                  </tr>				  
			 <tr>
                    <td  class="blackbold" valign="top"   align="right"> Home Page Flash :</td>
                    <td  height="40" align="left" valign="top"  class="blacknormal">
					
					<input name="HomeFlash" id="HomeFlash" type="file" class="inputbox"    onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />&nbsp;(Supported image file type: .swf) 
					<br> 	
Maximum width: 990px<br>

		 <? if($arryAdmin[0]['HomeFlash'] !='' && file_exists('../flash/'.$arryAdmin[0]['HomeFlash']) ){ ?>
 <br> 				 
<a href="../flash/<?=$arryAdmin[0]['HomeFlash']?>" target="_blank">		
				<strong>View Current Flash</strong></a> 
			<input type="hidden" name="OldFlash" value="<?=$arryAdmin[0]['HomeFlash']?>" />
					   <? }?>					
					
					
                  				</td>
                  </tr>		  
					  
					
					
					  
  <tr >
 		                <td align="right" valign="middle"  class="blackbold">Flash Width :</td>
 		                <td align="left" valign="middle" class="blacknormal"><input name="FlashWidth" type="text" class="textbox" id="FlashWidth" size="3" value="<? if($arryAdmin[0]['FlashWidth']>0) echo $arryAdmin[0]['FlashWidth']; ?>" maxlength="3" /> </td>
	                  </tr>					  
	  <tr >
 		                <td align="right" valign="middle"  class="blackbold">Flash Height :</td>
 		                <td align="left" valign="middle" class="blacknormal"><input name="FlashHeight" type="text" class="textbox" id="FlashHeight" size="3" value="<? if($arryAdmin[0]['FlashHeight']>0) echo $arryAdmin[0]['FlashHeight']; ?>" maxlength="3" /> <br> <br>  </td>
	                  </tr>					  
					  
					   
					  -->
					  <!--
					   
					    <tr>
                          <td align="right" valign="middle"  class="blackbold">Turn Off Shopping Cart :</td>
					      <td align="left" valign="middle" class="blacknormal"><select name="CartStatus" id="CartStatus" class="inputbox">
                              <option value="1" <? if($arryAdmin[0]['CartStatus'] == '1') echo 'selected';?>> No </option>
                              <option value="0" <? if($arryAdmin[0]['CartStatus'] == '0') echo 'selected';?>> Yes </option>
                          </select></td>
				      </tr>
					 
					   
					  
					  
 		              <tr >
 		                <td align="right" valign="middle"  class="blackbold">Tax :</td>
 		                <td align="left" valign="middle" class="blacknormal"><input name="Tax" type="text" class="textbox" id="Tax" size="3" value="<?=stripslashes($arryAdmin[0]['Tax'])?>" maxlength="4" /> %</td>
	                  </tr>
					   <tr style="display:none">
 		                <td align="right" valign="middle"  class="blackbold">Shipping :</td>
 		                <td align="left" valign="middle" class="blacknormal"><input name="Shipping" type="text" class="textbox" id="Shipping"  size="3"  value="<?=stripslashes($arryAdmin[0]['Shipping'])?>" maxlength="4" /> %</td>
	                  </tr>
 		              <tr style="display:none">
		  <td align="right" valign="middle"  class="blackbold">Product Posting Approval :</td>
		  <td align="left" valign="middle" class="blacknormal">
			<select name="PostingApproval" id="PostingApproval" class="textbox">
				<option value="Admin" <? if($arryAdmin[0]['PostingApproval'] == 'Admin') echo 'selected';?>> Admin </option>
				<option value="Auto" <? if($arryAdmin[0]['PostingApproval'] == 'Auto') echo 'selected';?>> Auto </option>
			 </select>	 	</td>
	  </tr>		
	  			  
	  <tr style="display:none">
			  <td align="right" valign="middle"  class="blackbold">Member Approval :</td>
			  <td align="left" valign="middle" class="blacknormal">
						  
	<select name="MemberApproval" id="MemberApproval" class="textbox">
        <option value="Admin" <? if($arryAdmin[0]['MemberApproval'] == 'Admin') echo 'selected';?>> Admin </option>
        <option value="Auto" <? if($arryAdmin[0]['MemberApproval'] == 'Auto') echo 'selected';?>> Auto </option>
        <option value="Email" <? if($arryAdmin[0]['MemberApproval'] == 'Email') echo 'selected';?>> Email Verification </option>
     </select>				  </td>
	  </tr>
	   <tr style="display:none">
	    <td align="right" valign="middle"  class="blackbold">Recieve Signup Email :</td>
	    <td align="left" valign="middle" class="blacknormal"><select name="RecieveSignEmail" id="RecieveSignEmail" class="textbox">
          <option value="y" <? if($arryAdmin[0]['RecieveSignEmail'] == 'y') echo 'selected';?>> Yes </option>
          <option value="n" <? if($arryAdmin[0]['RecieveSignEmail'] == 'n') echo 'selected';?>> No </option>
        </select></td>
	    </tr>
	  <tr style="display:none">
					      <td align="right" valign="middle"  class="blackbold">Maximum Partner Posting :</td>
					      <td align="left" valign="middle" class="blacknormal">
						  <select name="MaxPartnerLimit" id="MaxPartnerLimit" class="textbox">
						  	<? for($i=1;$i<=10;$i++){ ?>
               <option value="<?=$i?>" <? if($arryAdmin[0]['MaxPartnerLimit'] == $i) echo 'selected';?>> <?=$i?> </option>
							<? } ?>
                          </select></td>
				      </tr>	
	  
			
									  

			<tr style="display:none">
			  <td align="right" valign="middle"  class="blackbold">Home Page Banner :</td>
			  <td align="left" valign="middle" class="blacknormal"><select name="BannerHome" id="BannerHome" class="textbox">
                <? for($i=1;$i<=3;$i++){ ?>
                <option value="<?=$i?>" <? if($arryAdmin[0]['BannerHome'] == $i) echo 'selected';?>>
                <?=$i?>
                </option>
                <? } ?>
              </select></td>
			  </tr>
			
			<tr style="display:none">
			  <td align="right" valign="middle"  class="blackbold">Other Pages Banner :</td>
			  <td align="left" valign="middle" class="blacknormal"><select name="BannerRight" id="BannerRight" class="textbox">
                <? for($i=1;$i<=5;$i++){ ?>
                <option value="<?=$i?>" <? if($arryAdmin[0]['BannerRight'] == $i) echo 'selected';?>>
                <?=$i?>
                </option>
                <? } ?>
              </select></td>
			  </tr>
			 <tr style="display:none">
			  <td align="right" valign="top"  class="blackbold">Blog Abuse Words :</td>
			  <td align="left" valign="top" class="blacknormal"><textarea name="BlogAbuseWords" type="text" class="inputbox" id="BlogAbuseWords"  rows="4" cols="40" /><? echo stripslashes($arryAdmin[0]['BlogAbuseWords']); ?></textarea>	
			  
			  <br> (separate the entries with comma)			  	  </td>
			  </tr>
			  
		  <tr style="display:none">
       		 <td colspan="2" align="left"   class="head1">Meta Data :</td>
        </tr>	  
			
				  <tr style="display:none">
			  <td align="right" valign="top"  class="blackbold">Keywords :</td>
			  <td align="left" valign="top" class="blacknormal"><textarea name="MetaKeywords" type="text" class="inputbox" id="MetaKeywords"  rows="8" cols="40" /><? echo stripslashes($arryAdmin[0]['MetaKeywords']); ?></textarea>	
			  
			  <br> (separate the entries with comma)			  	  </td>
			  </tr>	
			  <tr style="display:none">
			  <td align="right" valign="top"  class="blackbold">Description :</td>
			  <td align="left" valign="top" class="blacknormal"><textarea name="MetaDescription" type="text" class="inputbox" id="MetaDescription"  rows="12" cols="40" /><? echo stripslashes($arryAdmin[0]['MetaDescription']); ?></textarea>	
			  
			  <br> (separate the entries with comma)			  	  </td>
			  </tr>		    
		 <tr style="display:none">
       		 <td colspan="2" align="left"   class="head1">Website-Store Pricing :</td>
        </tr >	
		  <tr style="display:none">
           <td  height="30" align="right" valign="middle"  class="blackbold">Website Price :</td>
           <td height="30" align="left" valign="middle"><input name="WebsitePrice" type="text" class="inputbox" id="WebsitePrice" value="<? echo stripslashes($arryAdmin[0]['WebsitePrice']); ?>"  maxlength="5" size="5" /> <?=$Config['Currency']?></td>
         </tr>
		 <tr style="display:none">
           <td  height="30" align="right" valign="middle"  class="blackbold">Online Store Price :</td>
           <td height="30" align="left" valign="middle"><input name="StorePrice" type="text" class="inputbox" id="StorePrice" value="<? echo stripslashes($arryAdmin[0]['StorePrice']); ?>"  maxlength="5" size="5" /> <?=$Config['Currency']?></td>
         </tr>
		  <tr style="display:none">
           <td  height="30" align="right" valign="middle"  class="blackbold">Website with Online-Store Price :</td>
           <td height="30" align="left" valign="middle"><input name="WebsiteStorePrice" type="text" class="inputbox" id="WebsiteStorePrice" value="<? echo stripslashes($arryAdmin[0]['WebsiteStorePrice']); ?>"  maxlength="5" size="5" /> <?=$Config['Currency']?></td>
         </tr>  
		 -->
		 <!--
		 <tr>
       		 <td colspan="2" align="left"   class="head">Payment Information </td>
        </tr>
			 
		  <tr>
			  <td align="right" valign="middle"  class="blackbold">Payment Type :</td>
			  <td align="left" valign="middle" class="blacknormal">
			  
			  <? if(!empty($arrayPaymentGateways)){
				for($i=0;$i<sizeof($arrayPaymentGateways);$i++){
				$Line = $i+1;
				
				if($Line==2 || $Line==3){
				
					$fieldname = $arrayPaymentGateways[$i]['fieldname'];
					if($Line==4) { 
						$Line=3; 
					}
			?>
		<input type="checkbox" name="<?=$arrayPaymentGateways[$i]['fieldname']?>" id="<?=$arrayPaymentGateways[$i]['fieldname']?>" onclick="Javascript:ShowPayDiv('<?=$Line?>','<?=$fieldname?>');" value="1"  <? if($arryAdmin[0][$arrayPaymentGateways[$i]['fieldname']] == '1') echo 'checked';?>><?=$arrayPaymentGateways[$i]['name']?>&nbsp;&nbsp;&nbsp;&nbsp;		
			<? } 
			
			} 
		}
		?>		
			
			
				  </td>
			  </tr>	  
			  -->
			    <tr>
			      <td colspan="2" valign="top" >
			
			
				  
<table width="100%" border="0" cellspacing="0" cellpadding="0">

			
<tr>
              <td align="center" valign="top"  >
			  <Div id="PaymentDiv1" <? if($arryAdmin[0]['MyGatePayment'] != 1) echo 'style="display:none"';?>>
			  <table width="100%" border="0" cellspacing="1" cellpadding="4" >
                 
					
					    <tr>
                          <td width="42%" height="30" align="right" valign="middle"  class="blackbold">MyGate Mode :<span class="red">*</span>                              </td>
                          <td  height="30" align="left" valign="middle">
						  <select name="MyGate_Mode" id="MyGate_Mode" class="inputbox" style="width: 180px;">
                            <option value="0" <? if($arryAdmin[0]['MyGate_Mode'] == '0') echo 'selected';?>> Test Mode </option>
                            <option value="1" <? if($arryAdmin[0]['MyGate_Mode'] == '1') echo 'selected';?>> Live Mode </option>
                          </select>						  </td>
                        </tr>
				
						<tr>
                          <td  height="30" align="right" valign="middle"  class="blackbold" ="">MyGate MerchantID :<span class="red">*</span>       </td>
                          <td  height="30" align="left" valign="middle"><input name="MyGate_MerchantID" type="text" class="inputbox" id="MyGate_MerchantID" value="<? echo $arryAdmin[0]['MyGate_MerchantID']; ?>"  maxlength="50"  /></td>
                        </tr>
						
                      
						 <tr>
                          <td w height="30" align="right" valign="middle"  class="blackbold">MyGate ApplicationID<span class="red">*</span>                              </td>
                          <td height="30" align="left" valign="middle"><input name="MyGate_ApplicationID" type="text" class="inputbox" id="MyGate_ApplicationID" value="<? echo stripslashes($arryAdmin[0]['MyGate_ApplicationID']); ?>"  maxlength="50"  /></td>
                        </tr>
                    </table>
			  </Div>
			  
			  
	<Div id="PaymentDiv2" <? if($arryAdmin[0]['PaypalPayment'] != 1) echo 'style="display:none"';?>>
			<table width="100%" border="0" cellspacing="1" cellpadding="4" >
				    
				
						<tr>
                          <td  width="38%"  align="right" valign="top"  class="blackbold" ="">PayPal ID<span class="red">*</span>       </td>
                          <td align="left" valign="top"><input name="PaypalID" type="text" class="inputbox" id="PaypalID" value="<? echo stripslashes($arryAdmin[0]['PaypalID']); ?>"  maxlength="80"  /></td>
                        </tr>
                    </table>
			  </Div>		  
			  
	 <Div id="PaymentDiv3" <? if($arryAdmin[0]['EftPayment'] != 1) echo 'style="display:none"';?>>
	   <table width="100%" border="0" cellspacing="1" cellpadding="4" >
           
             
		 
		
         <tr>
           <td  height="30" width="38%"  align="right" valign="middle"  class="blackbold" ="">
		  Account Holder :<span class="red">*</span> </td>
           <td  height="30" align="left" valign="middle"><input name="AccountHolder" type="text" class="inputbox" id="AccountHolder" value="<? echo stripslashes($arryAdmin[0]['AccountHolder']); ?>"  maxlength="50"  /></td>
         </tr>
         <tr>
           <td  height="30"  align="right" valign="middle"  class="blackbold" ="">Account Number :<span class="red">*</span> </td>
           <td  height="30" align="left" valign="middle"><input name="AccountNumber" type="text" class="inputbox" id="AccountNumber" value="<? echo stripslashes($arryAdmin[0]['AccountNumber']); ?>"  maxlength="40"  /></td>
         </tr>
         <tr>
           <td  height="30" align="right" valign="middle"  class="blackbold">Bank Name :<span class="red">*</span> </td>
           <td height="30" align="left" valign="middle"><input name="BankName" type="text" class="inputbox" id="BankName" value="<? echo stripslashes($arryAdmin[0]['BankName']); ?>"  maxlength="40"  /></td>
         </tr>
		<tr>
           <td  height="30" align="right" valign="middle"  class="blackbold">Branch Code :<span class="red">*</span> </td>
           <td height="30" align="left" valign="middle"><input name="BranchCode" type="text" class="inputbox"id="BranchCode" value="<? echo stripslashes($arryAdmin[0]['BranchCode']); ?>"  maxlength="30"  /></td>
         </tr>
		  <tr>
           <td  height="30" align="right" valign="middle"  class="blackbold">Swift Number :</td>
           <td height="30" align="left" valign="middle"><input name="SwiftNumber" type="text" class="inputbox"id="SwiftNumber" value="<? echo stripslashes($arryAdmin[0]['SwiftNumber']); ?>"  maxlength="30"  /></td>
         </tr>
       </table>
	 </Div>			  </td>
            </tr>	           
</table>				  </td>
			      </tr>
				  
		<!--		  
		  <tr>
			  <td align="right" valign="middle"  class="blackbold">MyGate Mode <span class="red">*</span></td>
			  <td align="left" valign="middle" class="blacknormal"><select name="MyGate_Mode" id="MyGate_Mode" class="inputbox" style="width: 180px;">
                <option value="0" <? if($arryAdmin[0]['MyGate_Mode'] == '0') echo 'selected';?>> Test Mode </option>
                <option value="1" <? if($arryAdmin[0]['MyGate_Mode'] == '1') echo 'selected';?>> Live Mode </option>
              </select></td>
			  </tr>
			<tr>
			  <td align="right" valign="middle"  class="blackbold">MyGate MerchantID <span class="red">*</span></td>
			  <td align="left" valign="middle" class="blacknormal"><input name="MyGate_MerchantID" type="text" class="inputbox" id="MyGate_MerchantID" value="<? echo $arryAdmin[0]['MyGate_MerchantID']; ?>"  maxlength="50"  /></td>
			  </tr>
			<tr>
			  <td align="right" valign="middle"  class="blackbold">MyGate ApplicationID <span class="red">*</span></td>
			  <td align="left" valign="middle" class="blacknormal"><input name="MyGate_ApplicationID" type="text" class="inputbox" id="MyGate_ApplicationID" value="<? echo stripslashes($arryAdmin[0]['MyGate_ApplicationID']); ?>"  maxlength="50"  /></td>
			  </tr>
			  -->
   
                     
                  </table></td>
                </tr>
          </table></td>
        </tr>
      </table></TD>
  </TR>
   <tr>
   						
      <td   align="center">

<?if($arrayPageDt[0]['ModifyLabel']==1){ ?>
	<table width="100%" border="0" cellspacing="3" cellpadding="5">
  <tr>
  	 <td width="38%">&nbsp;</td>
    <td><input name="Submit" type="submit" value="Update" class="button" />
      <input  type="hidden" name="ConfigID" id="ConfigID" value="1" /></td>
  </tr>
</table>
<? } ?>
			
						
						</td>
                      </tr>
	</form>
</TABLE>

