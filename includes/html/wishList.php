<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr>
          <td  align="left" valign="middle" class="heading">My Wish List</td>
        </tr> 
		
		<tr>
          <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>
            </span>
                My Wish List</td>
        </tr>
       
        <tr>
          <td height="15"></td>
        </tr>
        <tr>
          <td height="32" class="generaltxt_inner" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            
            <tr>
              <td colspan="2" align="center" valign="top" class="redtxt"><? if(!empty($_SESSION['mess_wish'])) {echo $_SESSION['mess_wish']; unset($_SESSION['mess_wish']); }?></td>
            </tr>
            <tr>
              <td align="left"  height="280"  valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" >
                  <tr>
                    <td width="100%" align="center" valign="top" >
					<form action="" method="post" name="formList" id="formList">
					  <table width="100%" align="center" cellpadding="3" cellspacing="0" class="outline" >
                        <? if(is_array($arryWish) && $num>0){?>
                        <tr align="left" valign="middle" bgcolor="#F5F5F5" style="font-weight:bold">
                          <td width="6%" align="left"  >Remove</td>
                          <td width="36%" height="20"   ><?=PRODUCT_NAME?></td>
                          <td width="26%"  ><?=QUANTITY_AVL?></td>
                          <td width="16%"  ><?=STATUS?></td>
                          <td width="16%" height="20"  ></td>
                        </tr>
                        <? 
 
  
  	foreach($arryWish as $key=>$values){
  ?>
                        <tr align="left" valign="middle" bgcolor="#FFFFFF"  >
                          <td align="left"><a href="wishList.php?del_id=<?=$values['WishID']?>&curP=<?=$_GET['curP']?>" onclick="return confDel('Are you sure you want to remove this product from your wish list.')" ><img src="images/delete.png" border="0" alt="Remove" title="Remove"/></a> </td>
                          <td height="20" class="greentxt"><? 	 
echo stripslashes($values['Name']);
  
if(!empty($values['ProductNumber'])){
	echo ' <br><span class="verdan11">('.stripslashes($values['ProductNumber']).')</span>';
}
  ?>                          </td>
                          <td class="verdan11"><?=$values['Quantity']?></td>
                          <td class="verdan11"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = '<span class="red12">InActive</span>';
		 }
		echo $status;
	 ?></td>
                          <td height="20" class="skytxt"><a href="productDetails.php?id=<?=$values['ProductID']?>" target="_blank">View Details</a></td>
                        </tr>
                        <tr>
                          <td colspan="5" class="borderListing"></td>
                        </tr>
                        <? } // foreach end //?>
                        <? }else{?>
                        <tr align="center" >
                          <td height="30" colspan="5" class="redtxt"><?=NO_PRODUCT_FOUND?></td>
                        </tr>
                        <? } ?>
                      </table>
					  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>" />
                    </form></td>
                  </tr>
				  
				   <? 	if($num>count($arryWish)){ ?>
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
