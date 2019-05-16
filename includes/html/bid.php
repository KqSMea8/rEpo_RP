<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		
		</td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=BIDDINGS?>		</td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
		 <? if(!empty($errMsg)){ ?>
          <tr>
            <td colspan="2" height="50" align="center" valign="middle"  class="red12"><?=$errMsg?></td>
          </tr>
          <? }else{ ?>
		  <tr>
            <td align="right" >
			
			<input onclick="location.href='bidding.php?mId=<?=$_GET[mId]?>&pId=<?=$_GET[pId]?>';" type="button" name="ppp" alt="<?=PLACE_BID?>" value="<?=PLACE_BID?>" class="button_blue" />
               <? if(!empty($errMsg2)){ ?>
			   <div style="text-align:center"><?=$errMsg2?></div>
			    <? } ?>	
            </td>
          </tr>
		  <? } ?>	  
	  
	   <tr>
        <td valign="top">
		
	  	<? include("includes/html/box/review_top.php");?>
	  
 		</td>
      </tr>
	  
	  
	  
      <tr>
        <td height="32" class="generaltxt_inner"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
		 
          <tr>
            <td align="left"  height="280"  valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" >
                <tr>
                  <td width="100%" align="center" valign="top" ><form action="" method="post" name="formList" id="formList">
                      <table width="100%" align="center" cellpadding="3" cellspacing="0" class="outline" >
                        <? if(sizeof($arryBidDetails)){?>
                        <tr align="left" valign="middle" bgcolor="#F5F5F5" >
                          <td width="15%" align="left"  > <?=BID_AMOUNT?> </td>
                          <td width="25%" height="20"   ><?=BUYER_REFERENCE_NUM?></td>
                          <td width="60%"  ><?=COMMENTS?></td>
                          </tr>
  <? 
  	foreach($arryBidDetails as $key=>$Values){
	
  ?>
                        
						<tr><td colspan="3" height="1" bgcolor="#DFEBD5" style="padding:0px; margin:0px;"></td></tr>
						
						<tr align="left" valign="top" bgcolor="#FFFFFF"  >
                          <td align="left" class="verdan11" ><?=$Values['symbol_left']?> <?=$Values['Amount']?><?=$Values['symbol_right']?> </td>
                          <td height="20" class="verdan11" valign="top">
						  
	<? 	echo stripslashes($Values['MemberID']); ?>                          </td>
                          <td class="verdan11">
						  
						  <? if(!empty($Values['Message'])){ 
							echo '"'.nl2br(stripslashes($Values['Message'])).'"<br><br>';
							echo '<i>Date: '.$Values['Date'].'</i>';
							}
						?>
					
						
						  </td>
                          </tr>
						  
						  
						  
                        <? } // foreach end //?>
                        <? }else{?>
                        <tr align="center" >
                          <td height="30" colspan="3" class="redtxt"><?=NO_BID_FOUND?></td>
                        </tr>
                        <? } ?>
                      </table>
                    <input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>" />
                  </form></td>
                </tr>
                <? 	if($num>count($arryBidDetails)){ ?>
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
