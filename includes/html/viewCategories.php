<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr>
          <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>
            </span>
                <?=MANAGE_CATAGORIES?></td>
        </tr>
        <tr>
          <td  align="left" valign="middle" class="heading"><?=MANAGE_CATAGORIES?></td>
        </tr>
        <tr>
          <td height="15"></td>
        </tr>
        <tr>
          <td height="32" class="generaltxt_inner" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right" ><a href="editCategory.php" class="skytxt"><?=ADD_CATEGORY?></a>
                
               &nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="top" class="redtxt" height="35"><? if(!empty($_SESSION['mess_category'])) {echo $_SESSION['mess_category']; unset($_SESSION['mess_category']); }?></td>
            </tr>
            <tr>
              <td align="left"  height="280"  valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" >
                  <tr>
                    <td width="100%" align="center" valign="top" >
					<form action="" method="post" name="formList" id="formList">
                        <table width="100%" align="center" cellpadding="3" cellspacing="0" class="outline verdan11" >
                          <? if(is_array($arryCategory) && $num>0){?>
                          <tr align="left" valign="middle" bgcolor="#F5F5F5" >
                            <td align="left"  ><?=EDIT?></td>
                            <td align="left"  ><?=DELETE?></td>
                            <td width="30%" height="20"   ><?=CATEGORY_NAME?></td>
                            <td width="25%"  ><?=CATEGORY_NEW_TITLE?></td>
                            <td width="25%"  ><?=CATEGORY_SUB_NEW_TITLE?></td>
                            <td width="10%" height="20"  ><?=STATUS?></td>
                          </tr>
                          <? 
 
  
  	foreach($arryCategory as $key=>$values){
  ?>
                          <tr align="left" valign="middle" bgcolor="#FFFFFF"  >
                            <td align="left"><a href="editCategory.php?edit=<? echo $values['StoreCategoryID'];?>&amp;curP=<? echo $_GET['curP'];?>"><img src="images/edit.png" border="0" alt="<?=EDIT?>" title="<?=EDIT?>" /></a></td>
                            <td align="left"><a href="editCategory.php?del_id=<? echo $values['StoreCategoryID'];?>&amp;curP=<? echo $_GET['curP'];?>" onclick="return confDel('<?=DELETE_CATEGORY_ALERT?>')" ><img src="images/delete.png" border="0" alt="<?=DELETE?>" title="<?=DELETE?>"/></a> </td>
                            <td height="20" >
<? echo stripslashes($values['Name']);  ?>                        </td>
                            <td ><? echo stripslashes($values['Category']);  ?></td>
                            <td ><? echo stripslashes($values['SubCategory']);  ?></td>
                            <td height="20" >
	<? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = '<span class="red12">InActive</span>';
		 }
		echo $status;
	 ?>	 </td>
                          </tr>
						  <tr>
				  <td colspan=6 class="borderListing"></td>
			</tr>
						  
                          <? } // foreach end //?>
                          <? }else{?>
                          <tr align="center" >
                            <td height="30" colspan="6" class="redtxt"><?=NO_CATEGORY_FOUND?></td>
                          </tr>
                          <? } ?>
                        </table>
                      <input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>" />
                    </form></td>
                  </tr>
				  
				   <? 	if($num>count($arryCategory)){ ?>
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
