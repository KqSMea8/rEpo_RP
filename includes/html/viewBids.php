<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr>
          <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>
            
                <a href="viewAutions.php"><?=MY_BIDDING_ITEMS?></a>  </span>  <?=BIDDING_DETAIL?></td>
        </tr>
        <tr>
          <td  align="left" valign="middle" class="heading"><?=BIDDING_DETAIL?></td>
        </tr>
        <tr>
          <td height="15"></td>
        </tr>
        <tr>
          <td height="32" class="generaltxt_inner" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right"   >
			  <a href="viewAutions.php" class="skytxt">
                <?=MY_BIDDING_ITEMS?>
              </a> &nbsp; </td>
            </tr>
			 <tr>
        <td valign="top">
		
	  	<? include("includes/html/box/review_top.php");?>
	  
 		</td>
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
                            <td width="3%" height="20" align="left"  ></td>
							 <td width="15%"  ><?=BID_STATUS?></td>
                             <td width="15%"  ><?=CURRENCY?></td>
                             <td width="15%"  ><?=BID_AMOUNT?></td>
                            <td width="15%"  ><?=BUYER?></td>
                            <td width="37%"  ><?=COMMENTS?></td>
                         </tr>
                          <? 
 
 	 $Today = date("Y-m-d H:i:s");
  	foreach($arryBid as $key=>$Values){
		$BidAssignLink = 'bidAssign.php?BidID='.$Values['BidID'];
		$Status = ($Values['endDate']<$Today)?("<span class=red12>".BID_CLOSED."</span><div class=greentxt><a href='".$BidAssignLink."' onclick='return confDel(\"".ASSIGN_BID."\")' >".ASSIGN_TO_BUYER."</a></div>"):(BID_OPEN);
		
		if($Values['BidStatus']=='Assigned' || $Values['BidStatus']=='Purchased'){
			$Status = "<span class=red12>".$Values['BidStatus']."</span>";
		}else if($Values['Status']=='Purchased'){
			$Status = "<span class=red12>".$Values['Status']."</span>";
		}
		
  ?>
                         
				<tr><td colspan="6" height="1" bgcolor="#DFEBD5" style="padding:0px; margin:0px;"></td></tr>		 
						 
						 
						  <tr align="left"  bgcolor="#FFFFFF"  >
                            <td height="20" align="left" valign="top"><a href="viewBids.php?del_id=<?=$Values['BidID']?>&PrdID=<?=$Values['ProductID']?>&curP=<?=$_GET['curP']?>" onclick="return confDel('<?=DELETE_BID?>')" ><img src="images/delete.png" border="0" alt="<?=DELETE?>" title="<?=DELETE?>"/></a> </td>
                            <td class="verdan11" valign="top">
							<?=$Status?>						</td>
							
							<td class="verdan11" valign="top"><?=$Values['symbol_left']?><?=$Values['symbol_right']?></td>
							<td class="verdan11" valign="top"><?=$Values['Amount']?></td>
                            <td class="verdan11" valign="top">
							<? 	echo stripslashes($Values['UserName']); ?>		</td>					
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
                            <td height="30" colspan="6" class="redtxt"><?=NO_RECORD_FOUND?></td>
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
