<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td valign="top" width="17%">
		
		<? if (empty($_SESSION['UserName']) && empty($_SESSION['MemberID'])) {
			 	include('includes/html/box/left.php'); 
	 		}else{
				include('includes/html/box/left_member.php'); 
			}	 
	    ?>
		
		</td>
        <td  width="6"><img src="images/spacer.gif" width="6" height="1" /></td>
        <td align="right" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
		
          <tr>
            <td>
				
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="8" height="26" background="images/bg-blue-left.jpg">&nbsp;</td>
                    <td bgcolor="#15507A" class="heading" ><?=INQUIRY_BASKET?></td>
                    <td width="6" background="images/bg-blue-right.jpg">&nbsp;</td>
                  </tr>
                </table></td>
          </tr>
        
	
   <tr>
    <td   height="150" >
	
	<table width="100%" border="0" align="center" cellpadding="7" cellspacing="1" bgcolor="#FFFFFF" class="blacktxt">
      <tr>
        <td   align="center" class="rightheadingtxt" height="250" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0">
          <form action=""  method="post" name="form1" id="form1" onsubmit="return validate(this);">
           
            <tr>
              <td align="center" class="red12" colspan="2">
			  <? if(!empty($_SESSION['MsgBasket'])) {
			  		
					if($numBasket>0) echo $_SESSION['MsgBasket']; 
					
					unset($_SESSION['MsgBasket']); 
				 }?>              </td>
            </tr>
            <?php   if($numBasket>0){	?>
            <tr>
              <td colspan="2" align="center" valign="top" ><table width="100%" class="blacktxt"  border="0" cellpadding="6" cellspacing="1">
                  <tr bgcolor="#BDD8E8" class="redtxt">
                    <td width="18%" bgcolor="#BDD8E8"><?=COMPANY_NAME?></td>
                    <td width="68%" height="20" bgcolor="#BDD8E8"><?=SUBJECT?></td>
                    <td width="10%" height="20">
                        <?=OFFER_TYPE?>                    </td>
                    <td width="4%" height="20" align="center"> </td>
                  </tr>
                  <?php  
	if(is_array($arryBasket)){
			$Count = 0;
  		foreach($arryBasket as $key=>$values){
			$OfferLink   = 'offerDetails.php?view='.$values['OfferID'];
			$OfferIDs .= $values['OfferID'].",";
			$Count++;
		?>
                  <tr valign="top" bgcolor="#FFFFFF" class="txt">
                    <td width="18%" valign="TOP" bgcolor="#EFEFEF" ><?php echo '<a href="view-company.php?view='.$values['OfferCompanyID'].'" target=_blank >'.stripslashes($values['CompanyName']).'</a>';?></td>
                    <td width="68%" height="18" valign="TOP" bgcolor="#EFEFEF" >
					<?php echo '<a href="'.$OfferLink.'" target=_blank><b>'.stripslashes($values['Name']).'</b></a>';?>
                            <input type="hidden" name="OfferID<?=$Count?>" id="OfferID<?=$Count?>" value="<?php echo $values['OfferID']; ?>" />                   </td>
                    <td width="10%" height="18" valign="TOP" bgcolor="#EFEFEF"><?php echo $values['PostedFor'];?></td>
                    <td width="4%" height="18" valign="TOP" bgcolor="#EFEFEF" align="center">
                        <input type="checkbox" name="DelBasket<?=$Count?>"  id="DelBasket<?=$Count?>"   value="<?php echo $values['OfferID']; ?>"/>                   </td>
                  </tr>
                  <?php }  } 
	?>
                  
              </table></td>
            </tr>
            <tr>
              <td height="15" colspan="2" align="right" class="redtxt">
			  <input type="hidden" name="numBasket" id="numBasket" value="<?php echo $numBasket; ?>" />
                  <input type="hidden" name="MemberID" id="MemberID" value="<?php echo $MemberID; ?>" />
			    <input name="BasketSubmit" type="hidden" id="BasketSubmit" value="1" />
			    <input name="OfferIDs" type="hidden" id="OfferIDs" value="<?php echo rtrim($OfferIDs,","); ?>" />
			    <input name="Submit32" type="button" class="button" value="<?=CONTINUE_BUTTON?>" alt="<?=CONTINUE_BUTTON?>" title="<?=CONTINUE_BUTTON?>" onclick="javascript:location.href='offers-cat.php?opt=Buy';" />
			    <input name="Submit" type="submit" class="button" value="<?=REMOVE?>" /></td>
            </tr>
          
          
            <tr>
              <td colspan="2" align="center" valign="top">&nbsp;</td>
            </tr>
            <?php }else if(empty($_SESSION['MsgBasket'])) {?>
            <tr>
              <td colspan="2"  height="250"  valign="middle" align="center" class="red12"><?=BASKET_EMPTY?></td>
            </tr>
            <?php } ?>
          </form>
        </table></td>
        </tr>
    </table>
	
	
	</td>
  </tr>	  
		
		
				 

		  
          <tr>
            <td bgcolor="#CCCCCC" height="1"></td>
          </tr>
          <tr>
            <td height="6" ></td>
          </tr>
          <tr>
            <td align="center"></td>
          </tr>
        </table></td>
	
				
  </tr>
    </table></td>
  </tr>
</table>
