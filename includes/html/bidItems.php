<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr>
          <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> <span >
            <?=$Nav_MemberPortal?>
           </span>
                <?=MANAGE_PRODUCTS?></td>
        </tr>
        <tr>
          <td  align="left" valign="middle" class="heading"><?=MANAGE_PRODUCTS?></td>
        </tr>
        <tr>
          <td height="15"></td>
        </tr>
        <tr>
          <td height="32" class="generaltxt_inner" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right"   ><a href="editProduct.php" class="skytxt">
                <?=ADD_NEW_PRODUCT?>
              </a> &nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="top" class="redtxt"><? if(!empty($_SESSION['mess_product'])) {echo $_SESSION['mess_product']; unset($_SESSION['mess_product']); }?></td>
            </tr>
            <tr>
              <td align="left"  height="280"  valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" >
                  <tr>
                    <td width="100%" align="center" valign="top" >
					<form action="" method="post" name="formList" id="formList">
                        <table width="100%" align="center" cellpadding="3" cellspacing="0" class="outline" >
                          <? if(is_array($arryProduct) && $num>0){?>
                          <tr align="left" valign="middle" bgcolor="#F5F5F5" >
                            <td align="left"  ></td>
                            <td align="left"  ></td>
                            <td width="50%" height="20"   ><?=PRODUCT_NAME?></td>
                            <td width="30%"  ><?=POSTED_DATE?></td>
                            <td width="13%" height="20"  ><?=STATUS?></td>
                          </tr>
                          <? 
 
  
  	foreach($arryProduct as $key=>$values){
  ?>
                          <tr align="left" valign="middle" bgcolor="#FFFFFF"  >
                            <td align="left"><a href="editProduct.php?edit=<? echo $values['ProductID'];?>&amp;curP=<? echo $_GET['curP'];?>"><img src="images/edit.png" border="0" alt="<?=EDIT?>" title="<?=EDIT?>" /></a></td>
                            <td align="left"><a href="editProduct.php?del_id=<? echo $values['ProductID'];?>&amp;CategoryID=<? echo $values['CategoryID'];?>&amp;curP=<? echo $_GET['curP'];?>" onclick="return confDel('<?=DELETE_PRODUCT_ALERT?>')" ><img src="images/delete.png" border="0" alt="<?=DELETE?>" title="<?=DELETE?>"/></a> </td>
                            <td height="20" class="greentxt"><? 	 
	echo '<a href="editProduct.php?edit='.$values['ProductID'].'&curP='.$_GET['curP'].'"><strong>'. $values['Name'] .' </strong></a>'; ?>                            </td>
                            <td class="verdan11"><? 	
	if($values['AddedDate'] > 0){	
		echo date("jS F,  Y", strtotime($values['AddedDate']));
	}
	?></td>
                            <td height="20" >
	<? 
		 if($values['Status'] ==1){
			  $status = '<span class="greentxt">Active</span>';
		 }else{
			  $status = '<span class="red12">InActive</span>';
		 }
		echo $status;
	 ?>
	 </td>
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
				  
				   <? 	if($num>count($arryProduct)){ ?>
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
