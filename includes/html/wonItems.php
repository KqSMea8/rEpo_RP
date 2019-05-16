<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr>
          <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>
            </span> <?=$ModTitle?></td>
        </tr>
        <tr>
          <td  align="left" valign="middle" class="heading"><?=$ModTitle?></td>
        </tr>
        <tr>
          <td height="15"></td>
        </tr>
        <tr>
          <td height="32" class="generaltxt_inner" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
           
			 
            <tr>
              <td colspan="2" align="center" valign="top" class="redtxt"><? if(!empty($_SESSION['mess_bid'])) {echo $_SESSION['mess_bid']; unset($_SESSION['mess_bid']); }?></td>
            </tr>
            <tr>
              <td align="left"  height="280"  valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" >
                  <tr>
                    <td width="100%" align="center" valign="top" >
					<form action="" method="post" name="formList" id="formList">
                        <table width="100%" align="center" cellpadding="3" cellspacing="0" class="outline" >
                          <? if(is_array($arryBid) && $num>0){?>
                          <tr align="left" valign="middle" bgcolor="#F5F5F5" >
                           
							 <td width="15%"  ><?=BID_STATUS?></td>
                             <td width="15%"  ><?=PRODUCT_NAME?></td>
                             <td width="10%"  ><?=CURRENCY?></td>
							 <td width="7%"  ><?=BID_AMOUNT?></td>
                             <td width="18%"  ><?=BUYER_REFERENCE_NUM?></td>
                            <td width="35%"  ><?=COMMENTS?></td>
                         </tr>
                          <? 
 
 	 $Today = date("Y-m-d");
  	foreach($arryBid as $key=>$Values){
		
		
		
		if($Values['BidBidStatus']=='Purchased'){
			$Status = "<span class=red12>".$Values['BidBidStatus']."</span>";
		}else{

			if(($_GET['tp']=='Won')){
				#$Status = '<a href="'.$Config['StorePrefix'].$Values['SellerName'].'/buyProduct.php?BidID='.$Values['BidID'].'&id='.$Values['ProductID'].'&StoreID='.$Values['SellerID'].'" >Buy Now</a> | <a href="'.$Config['StorePrefix'].$Values['SellerName'].'/buyProduct.php?declineID='.$Values['BidID'].'&id='.$Values['ProductID'].'&StoreID='.$Values['SellerID'].'">Decline</a>';
				$Status = '<a href="'.$Config['StorePrefix'].$Values['SellerName'].'/buyProduct.php?BidID='.$Values['BidID'].'&id='.$Values['ProductID'].'&StoreID='.$Values['SellerID'].'" >Buy Now</a>';
			}else{
				$Status = "Not Assigned";
			}


		}
		
  ?>
                         
				<tr><td colspan="7" height="1" bgcolor="#DFEBD5" style="padding:0px; margin:0px;"></td></tr>		 
						 
						 
						  <tr align="left"  bgcolor="#FFFFFF"  >
                            
                            <td class="greentxt" valign="top">
							<?=$Status?>							</td>
							
							<td class="verdan11" valign="top"><span class="greentxt">
							  <? 	
	echo '<a href="'.$Config['StorePrefix'].$Values['SellerName'].'/productDetails.php?id='.$Values['ProductID'].'" target="_blank"><strong>'.stripslashes($Values['Name']) .' </strong></a>'; ?>
							</span></td>
							<td class="verdan11" valign="top"><?=$Values['symbol_left']?><?=$Values['symbol_right']?></td>
							<td class="verdan11" valign="top"><?=$Values['Amount']?></td>
                            
                            <td class="verdan11" valign="top">
							<? 	echo stripslashes($Values['MemberID']); ?>		</td>					
                            <td class="verdan11" valign="top">
						 <? if(!empty($Values['Message'])){ 
							echo '"'.nl2br(stripslashes($Values['Message'])).'"<br><br>';
							echo '<i>Date: '.$Values['Date'].'</i>';
							}
						?> </td>
                          </tr>
                          <? } // foreach end //?>
                          <? }else{?>
                          <tr align="center" >
                            <td height="30" colspan="7" class="redtxt"><?=NO_RECORD_FOUND?></td>
                          </tr>
                          <? } ?>
                        </table>
                      <input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>" />
                    </form></td>
                  </tr>
				  
				   <? 	if($num>count($arryBid)){ ?>
                          <tr >
                            <td height="20"  >&nbsp;<? echo $pagerLink; ?> </td>
                          </tr>
                          <? } ?>
              </table></td>
            </tr>
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
