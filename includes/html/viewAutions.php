<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr>
          <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>
            </span>
                <?=MY_BIDDING_ITEMS?></td>
        </tr>
        <tr>
          <td  align="left" valign="middle" class="heading"><?=MY_BIDDING_ITEMS?></td>
        </tr>
        <tr>
          <td height="15"></td>
        </tr>
        <tr>
          <td height="32" class="generaltxt_inner" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right"   >&nbsp; </td>
            </tr>
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
                            <td width="15%" align="left"  ><?=NUMBER_BIDDINGS?></td>
							 <td width="15%"  ><?=BID_STATUS?></td>
                            <td width="20%" height="20"   ><?=PRODUCT_NAME?></td>
                            <td width="25%"  ><?=CURRENCY?></td>
                            <td width="25%"  >Max <?=BID_AMOUNT?></td>
                            </tr>
                          <? 
 
 	 $Today = date("Y-m-d H:i:s");
	 
	// print_r($arryBid); exit;
  	foreach($arryBid as $key=>$Values){
		$BidAssignLink = 'bidAssign.php?BidID='.$Values['BidID'];
		$Status = ($Values['endDate']<$Today)?("<span class=red12>".BID_CLOSED."</span>"):(BID_OPEN);
		
		if($Values['BidStatus']=='Assigned'){
			$Status = '<span class=red12>'.$Values['BidStatus'].'</span>';
		}
		
		if($Values['BidStatus']=='Assigned' || $Values['LatestStatus']=='Purchased'){
			$Status = "<span class=red12>".$Values['LatestStatus']."</span>";
		}
		
		
		
  ?>
                         
				<tr><td colspan="5" height="1" bgcolor="#DFEBD5" style="padding:0px; margin:0px;"></td></tr>		 
						 
						 
						  <tr align="left"  bgcolor="#FFFFFF"  >
                            <td align="left" valign="top" class="greentxt">

                              <?
							   echo '<span class="verdan11">('.$Values['NumBids'].')</span>&nbsp;';
							  	
								if($Values['NumBids']>0){
								echo '<a href="viewBids.php?PrdID='.$Values['ProductID'].'&curP='.$_GET['curP'].'" >View Details</a> ';	
								}
							  
							   ?>							</td>
                            <td class="verdan11" valign="top">
							<?=$Status?>						</td>
							
							<td height="20" class="greentxt" valign="top"><? 	 
	echo '<a href="editProduct.php?edit='.$Values['ProductID'].'&curP='.$_GET['curP'].'" target="_blank"><strong>'.stripslashes($Values['Name']) .' </strong></a>'; ?>                            </td>
                            <td class="verdan11" valign="top"><?=$Values['symbol_left']?><?=$Values['symbol_right']?></td>
                            <td class="verdan11" valign="top"><?=$Values['MaxAmount']?></td>
                            </tr>
                          <? } // foreach end //?>
                          <? }else{?>
                          <tr align="center" >
                            <td height="30" colspan="5" class="redtxt"><?=NO_RECORD_FOUND?></td>
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
