<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
       
	   <tr>
        <td  align="left" valign="middle" class="heading">
		<?=VIEW_COMPANY_PROFILE?></td>
      </tr>
	   <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span>  <?=VIEW_COMPANY_PROFILE?></td>
      </tr>
      
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" class="generaltxt_inner"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
                <form action=""  method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return validate(this);">

  <? if(sizeof($arryMember)>0){ ?>
				  

				  
	<tr>
		<td  height="10"></td>
	</tr>
                  <tr>
                    <td align="center" valign="top"  ><table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
                        <tr>
                          <td>
                              <table width="100%" border="0" cellpadding="0" cellspacing="0"  >
                                <tr>
                                  <td  valign="top" height="110" ><table  width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
     <? if($arryMember[0]['Image'] !='' && file_exists('upload/company/'.$arryMember[0]['Image']) ){ ?>
                                        <td align="left" valign="top" class="imgborder_prd22" ><?
			$ImagePath = 'resizeimage.php?img=upload/company/'.$arryMember[0]['Image'].'&w=150&h=150'; 
			
			$ImagePath = '<a href="upload/company/'.$arryMember[0]['Image'].'" rel="lightbox"><img src="'.$ImagePath.'"  border="0" class="imgborder_prd"/></a>';
			echo $ImagePath;
			
		
	?>   
		   
		   </td>
		   <td width="16"> </td>
     <? } ?>
                                        <td valign="top" >
										
										
										
                                            <table  border="0" align="center" cellpadding="3" cellspacing="1" style="display:none"  >
                                            
											  <tr style="display:none">
                                                <td align="left"  valign="top"  ><?=STORE_RATING?>: </td>
                                                <td align="left" ><?=$RatingHTML?>                                                </td>
                                              </tr>
                                              <tr>
                                                <td  align="left" valign="top"  width="170" ><?=COUNTRY?>: </td>
                                                <td  align="left" class="generaltxt_inner"><?=stripslashes($arryMember[0]['Country'])?>                                                </td>
                                              </tr>
                                              <? if($arryMember[0]['Website'] != ''){ ?>
                                              <!--<tr>
                                                <td align="left" valign="top"  ><?=WEBSITE?>: </td>
                                                <td align="left" class="skytxt"><a href="<?=$arryMember[0]['Website']?>" target="_blank">
                                                  <?=$arryMember[0]['Website']?>
                                                </a></td>
                                              </tr>-->
                                              <? } ?>
									<tr>
                                          <td align="left"  valign="top"><?=SUBSCRIBE_EMAIL?>:
                                             </td>
                                          <td height="30" align="left" class="generaltxt_inner" valign="top">
										  
										  <?  if($arryMember[0]['EmailSubscribe'] == 1) { echo 'Yes';}else echo 'No';?>
										  </td>
                                        </tr>
									  <tr style="display:none">
                                          <td align="left"  valign="top"><?=SUBSCRIBE_SMS?>:
                                             </td>
                                          <td height="30" align="left" class="generaltxt_inner" valign="top">
										  
										  <?  if($arryMember[0]['SmsSubscribe'] == 1) { echo 'Yes';}else echo 'No';?>
										  </td>
                                        </tr>	
										
	   <!--								
	  <tr >
     <td ><?=EMAIL_CREDITS?>:</td>
     <td class="generaltxt_inner"><?=$arryMember[0]['MaxEmail']?></td>
   </tr>
    <tr >
     <td ><?=SMS_CREDITS?>:</td>
     <td class="generaltxt_inner"><?=$arryMember[0]['MaxSms']?></td>
   </tr> 

   <? 
   $WebUrl = $Config['Url'].$Config['StorePrefix'].$_SESSION['UserName'].'/';
   $StoreUrl = $Config['Url'].$Config['StorePrefix'].$_SESSION['UserName'].'/store.php';
   ?>
   <? if($_SESSION['WebsiteStoreOption']=='w'){ ?>
 <tr>  <td ><?=WEBSITE?>:</td>
<td class="skytxt"><a href="<?=$WebUrl?>"><?=$WebUrl?></a></td></tr>
  <? }else if($_SESSION['WebsiteStoreOption']=='s'){ ?>
 <tr> <td ><?=ONLINE_STORE?>:</td>
  <td class="skytxt"><a href="<?=$StoreUrl?>"><?=$StoreUrl?></a></td></tr>
  <? }else if($_SESSION['WebsiteStoreOption']=='ws'){ ?>
 <tr>  <td ><?=WEBSITE?>:</td>
<td class="skytxt"><a href="<?=$WebUrl?>"><?=$WebUrl?></a></td></tr>
 <tr> <td ><?=ONLINE_STORE?>:</td>
  <td class="skytxt"><a href="<?=$StoreUrl?>"><?=$StoreUrl?></a></td></tr>
  <? } ?>
  	-->	
											  
                                          </table>
										  
								<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1"  >
                                        
		<tr>
		<td  height="24" class="graybox"><? echo stripslashes($arryMember[0]['CompanyName']); ?> </td>
	</tr>	
										
								
		 <? if($arryMember[0]['TagLine'] != ''){ ?>
											  <tr>
                                                <td align="left" valign="top"  >
												<?=COMPANY_TAG_LINE?>: </td>
                                                <td align="left" class="generaltxt_inner"><? echo nl2br(stripslashes($arryMember[0]['TagLine'])); ?>                                               </td>
                                              </tr>
											   <? }?>								
										
										<tr>
                                          <td  width="170" align="left" ><?=FIRST_NAME?>: </td>
                                          <td  height="30" align="left" class="generaltxt_inner"><? echo stripslashes($arryMember[0]['FirstName']); ?></td>
                                        </tr>
                                       <tr>
                                          <td  align="left" ><?=LAST_NAME?>: </td>
                                          <td  height="30" align="left" class="generaltxt_inner"><? echo stripslashes($arryMember[0]['LastName']); ?></td>
                                        </tr>
									   
									   
									   
									
										  <tr>
                                          <td  align="left" ><?=CONTACT_PERSON?>: </td>
                                          <td  height="30" align="left" class="generaltxt_inner"><? echo $arryMember[0]['ContactPerson']; ?></td>
                                        </tr>  <tr>
                                          <td  align="left" ><?=CONTACT_NUMBER?>: </td>
                                          <td  height="30" align="left" class="generaltxt_inner"><? echo $arryMember[0]['ContactNumber']; ?></td>
                                        </tr> 
										
									
									
									   
									   
                                        <tr>
                                          <td align="left"  valign="top"><?=ADDRESS?>: </td>
                                          <td height="30" align="left" class="generaltxt_inner"><?=nl2br(stripslashes($arryMember[0]['Address']))?></td>
                                        </tr>
                                        <tr>
                                          <td  align="left" ><?=COUNTRY?>: </td>
                                          <td  height="30" align="left" class="generaltxt_inner"><?=$arryMember[0]['Country']?></td>
                                        </tr>
                                        <tr>
                                          <td  align="left" valign="middle" nowrap="nowrap" ><?=STATE?>: </td>
                                          <td  align="left" class="generaltxt_inner"><?=$arryMember[0]['State']?></td>
                                        </tr>
                                        <tr>
                                          <td  align="left" ><?=CITY?>: </td>
                                          <td  height="30" align="left" class="generaltxt_inner"><?=$arryMember[0]['City']?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td  align="left" ><?=POSTAL_CODE?>: </td>
                                          <td  height="30" align="left" class="generaltxt_inner"><? echo $arryMember[0]['PostCode']; ?></td>
                                        </tr>
										
									 <tr>
                                          <td  align="left" ><?=LANDLINE_NUMBER?>: </td>
                                          <td  height="30" align="left" class="generaltxt_inner">
										  <? echo $arryMember[0]['LandlineNumber']; ?></td>
                                        </tr>
											
										
                                        <tr>
                                          <td  align="left" ><?=MOBILE_NUMBER?>: </td>
                                          <td  height="30" align="left" class="generaltxt_inner"><? echo $arryMember[0]['Phone']; ?></td>
                                        </tr>
										
                                        <tr>
                                          <td align="left" ><?=FAX?>: </td>
                                          <td height="30" align="left" class="generaltxt_inner"><? echo $arryMember[0]['Fax']; ?></td>
                                        </tr>
										
										
										
										
										
										
                                    </table>		  
										  
										  
										  </td>
                                      
									  
                                  </table></td>
                                </tr>
                              </table>
                              <? if($_SESSION['MemberID'] != $_GET['view']) { ?>
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
                                <tr>
                                  <td height="10" colspan="2"></td>
                                </tr>
                                <tr>
                                  <td align="right">
								  
							<a href="ranking.php?mId=<?=$_GET['view']?>" ><img src="images/write_review.jpg" border="0"></a>	  
								  </td>
								  <!--
                                  <td width="75"><input  class="button" type="button" name="Submit2" value="<?=SEND_EMAIL?>" alt="<?=SEND_EMAIL?>" title="<?=SEND_EMAIL?>" onclick="Javascript: location.href='send-email.php?cmp=<?=$_GET[view]?>';"/></td>
								  -->
                                </tr>
                                <tr>
                                  <td height="10" colspan="2"></td>
                                </tr>
                              </table>
                            <? } ?>
                          </td>
                        </tr>
                      </table>
                       
                      <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
                          <tr>
                            <td>
                               
                                <? if($_SESSION['MemberID'] != $_GET['view']) { ?>
<!--
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
                                  <tr>
                                    <td height="10" colspan="2"></td>
                                  </tr>
                                  <tr>
                                    <td  align="right">
				<a href="ranking.php?mId=<?=$_GET['view']?>" ><img src="images/write_review.jpg" border="0"></a>					
									
									</td>
                                    <td width="75">
									
									<input  class="button" type="button" name="Submit2" value="<?=SEND_EMAIL?>" alt="<?=SEND_EMAIL?>" title="<?=SEND_EMAIL?>" onclick="Javascript: location.href='send-email.php?cmp=<?=$_GET[view]?>';"/>
									
									</td>
                                  </tr>
                                  <tr>
                                    <td height="10" colspan="2"></td>
                                  </tr>
                                </table>
-->
                              <? } ?>
                            </td>
                          </tr>
                      </table></td>
                  </tr>
                  <? }else{ ?>
                  <tr>
                    <td height="130" valign="middle" align="center" class="redtxt" ><?=NO_RECORD_FOUND?></td>
                  </tr>
                  <? } ?>
                  <tr>
                    <td  height="1"></td>
                  </tr>
                  <tr>
                    <td height="6" ></td>
                  </tr>
                  <tr>
                    <td align="center"></td>
                  </tr>
                </form>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>

