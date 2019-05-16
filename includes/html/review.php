<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <a href="Javascript:window.history.go(-1)"><?=SEARCH_PRODUCTS?></a> </span> <?=BUYERS_REVIEWS?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=BUYERS_REVIEWS?>		</td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	  
 <tr>
            <td align="right">
			<a href="ranking.php?mId=<?=$_GET['mId']?>&pId=<?=$_GET['pId']?>" ><img src="images/write_review.jpg" border="0"></a>
              
            </td>
          </tr>	  
	  
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
                        <? if(sizeof($arryRankingDetails)){?>
                        <tr align="left" valign="middle" bgcolor="#F5F5F5" style="border-bottom:1px solid #CCCCCC;">
                          <td width="15%" align="left"  > Rating </td>
                          <td width="25%" height="20"   >Buyer</td>
                          <td width="60%"  >Comments</td>
                          </tr>
  <? 
  	foreach($arryRankingDetails as $key=>$Values){
	
  ?>
                        
						<tr><td colspan="3" height="1px" bgcolor="#DFEBD5" style="padding:0px; margin:0px;"></td></tr>
						
						<tr align="left" valign="top"  >
                          <td align="left" class="verdan11" ><img src="images_small/<?=$Values['Points']?>star.png"></td>
                          <td height="20" class="verdan11" valign="top">
						  
	<? 	echo stripslashes($Values['UserName']); ?>                          </td>
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
                          <td height="30" colspan="3" class="redtxt"><?=NO_REVIEW_FOUND?></td>
                        </tr>
                        <? } ?>
                      </table>
                    <input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>" />
                  </form></td>
                </tr>
                <? 	if($num>count($arryRankingDetails)){ ?>
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
