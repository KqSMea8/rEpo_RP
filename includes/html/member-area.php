<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
     
      <tr>
        <td  align="left" valign="middle" class="heading"><?=MEMBER_PORTAL?></td>
      </tr>
	   <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> <?=MEMBER_PORTAL?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" ><table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
		
		
          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="outline33" >
                  <tr>
                    <td height="6" ></td>
                  </tr>
                  <tr>
                    <td  valign="top" height="110" ><table  border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <? if($arryMember[0]['Image'] !='' && file_exists('upload/company/'.$arryMember[0]['Image']) ){ ?>
						 
                          <td  align="center"  class="imgborder_prd22" valign="top" ><?
			$ImagePath = 'resizeimage.php?img=upload/company/'.$arryMember[0]['Image'].'&w=150&h=150'; 

			//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/company/'.$arryMember[0]['Image'].'\', 150, 100, \'yes\' );"  href="#"><img src="'.$ImagePath.'"  border="0"/></a>';
			
			$ImagePath = '<a href="upload/company/'.$arryMember[0]['Image'].'" rel="lightbox"><img src="'.$ImagePath.'"  border="0" class="imgborder_prd"/></a>';
			
			
			echo $ImagePath;
			
		
		   ?>
                          </td>
						   <td width="16"> </td>
                          <? } ?>
                          <td valign="top"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1"  >
						  
						   <tr>
                                <td align="left" valign="top"  width="90" ><?=USER_NAME?>: </td>
                                <td align="left" class="generaltxt_inner"><?=$arryMember[0]['UserName']?>
                                </td>
                              </tr>
							   <tr>
                                <td align="left" valign="top"  width="90" nowrap="nowrap" ><?=EMAIL?>: </td>
                                <td align="left" class="generaltxt_inner"><?=$arryMember[0]['Email']?>
                                </td>
                              </tr>
							 <tr>
                                <td align="left" valign="top" width="90" ><?=NAME?>: </td>
                                <td align="left" class="generaltxt_inner"><?=$arryMember[0]['FirstName']?> <?=$arryMember[0]['LastName']?>
                                </td>
                              </tr>
							    
							  
						  <? if($_SESSION['MemberType']=="Seller") { ?>

                              <tr>
                                <td align="left" valign="top" width="90" ><?=MEMBERSHIP?>: </td>
                                <td align="left"  class="generaltxt_inner"><?=stripslashes($arryMember[0]['Membership'])?></td>
                              </tr>
	<!--	 <tr>
     <td ><?=EMAIL_CREDITS?>:</td>
     <td class="generaltxt_inner"><?=$arryMember[0]['MaxEmail']?></td>
   </tr>
   <tr>
     <td ><?=SMS_CREDITS?>:</td>
     <td class="generaltxt_inner"><?=$arryMember[0]['MaxSms']?></td>
   </tr>-->
							  
                              <tr>
                                <td align="left" valign="top"   nowrap="nowrap"><?=COMPANY_NAME?>: </td>
                                <td align="left"  class="generaltxt_inner"><?=$arryMember[0]['CompanyName']?>
                                </td>
                              </tr>
                              <tr>
                                <td width="19%" align="left" valign="top"  ><?=JOINING_DATE?>: </td>
                                <td width="81%" align="left" class="generaltxt_inner"><?=date("jS F,  Y", strtotime($arryMember[0]['JoiningDate']))?>
                                </td>
                              </tr>
                              <tr>
                                <td align="left" valign="top" ><?=EXPIRY_DATE?>: </td>
                                <td align="left" class="generaltxt_inner"><?=date("jS F,  Y", strtotime($arryMember[0]['ExpiryDate']))?>
                                </td>
                              </tr>
							  <? }?>
							  
							 
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
                </table>
              </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td align="right" valign="top" ><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>

