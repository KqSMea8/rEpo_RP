<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
        <tr>
          <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>
            </span>
                <?=VIEW_ORDERS?></td>
        </tr>
        <tr>
          <td  align="left" valign="middle" class="heading"><?=VIEW_ORDERS?></td>
        </tr>
        <tr>
          <td height="15"></td>
        </tr>
        <tr>
          <td height="32" class="generaltxt_inner" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            
            <tr>
              <td colspan="2" align="center" valign="top" class="redtxt"><? if(!empty($_SESSION['mess_order'])) {echo $_SESSION['mess_order']; unset($_SESSION['mess_order']); }?></td>
            </tr>
            <tr>
              <td align="left"  height="280"  valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" >
                  <tr>
                    <td width="100%" align="center" valign="top" >
					<form action="" method="post" name="formList" id="formList">
					    <table width="100%" align="center" cellpadding="3" cellspacing="0" class="outline" >
                        <tr bgcolor="#F5F5F5">
                          <td align="left"></td>
                          <td align="left" >Order Date </td>
                          <td align="left" >Order Number</td>
                          <td width="21%" align="left" >Customer</td>
                          <td width="15%" align="left" >Amount</td>
                          <td width="16%" align="left" >Payment Status </td>
                          <td width="15%" align="left" >Delivery Status</td>
                          </tr>
                        <? 
						
  					  if(sizeof($arryOrders)>0){
							$i=(($_GET['curP']-1)*10)+1;
							foreach($arryOrders as $key=>$values){
								$flag=!$flag;
  ?>
                        <tr >
                          <td width="2%" height="30" align="left" valign="top"><a href="viewOrders.php?del_id=<? echo $values['OrderID'];?>&curP=<? echo $_GET['curP'];?>" onclick="return confDel('<?=DELETE_ORDER_ALERT?>')" ><img src="images/delete.png" border="0" alt="<?=DELETE?>" title="<?=DELETE?>"/></a></td>
                        
                          <td width="12%" align="left" valign="top" class="greentxt"><a href="#" onclick="popitup('OrderDetails.php?OrderID=<?=$values['OrderID']?>',800,650);" ><strong>
                            <?=date('d-m-Y',strtotime($values['OrderDate']))?>
                          </strong></a>  
						  <? if(!empty($values['payment_gateway'])) echo '<span class="red">('.$values['payment_gateway'].')</span>'; ?>
						  </td>
                          <td width="14%" height="24" align="left" valign="top" class="verdan11"><?=$values['OrderID']?></td>
                          <td  align="left"  class="verdan11" valign="top"><?=$values['BillingName']?></td>
                          <td align="left" class="verdan11" valign="top"><?=display_price($values['TotalPrice'],'',$TaxType,$values['symbol_left'],$values['symbol_right'])?></td>
                          <td align="left"  valign="top" >
 <span class="verdan11"><? if($values['PaymentStatus']==1) echo "Received"; else echo "Not Received";?></span>
						  
		<? if($values['BankTransfer']==1 && $values['PaymentStatus']!=1){ 
			echo '<br><a href="viewOrders.php?curP='.$_GET['curP'].'&payment_status_id='.$values['OrderID'].'" class="greentxt">(Change Status)</a>';
		}?>				  
						  
						  </td>
                          <td valign="top" align="left">
						  	
				<span class="verdan11"><? 
				if($values['Status']==1) {
					$statVal = 0;
					echo "Delivered";
				} else {
					$statVal = 1;
					echo "Pending";
				}
				
				?></span>
		<br><a href="viewOrders.php?curP=<?=$_GET['curP']?>&status_id=<?=$values['OrderID']?>&statVal=<?=$statVal?>" class="greentxt">(Change Status)</a>			  
					
							
							<!--
                              <select name="status" id="status" class="txtfield_contact" onchange="changeStatus(this.value,<?=$values['OrderID']?>);" style="width:100">
                                <option value="1" <? if($values['Status']==1) echo 'Selected';?>>Delivered</option>
                                <option value="0" <? if($values['Status']==0) echo 'Selected';?>>Pending</option>
                              </select>  -->                        </td>
                          </tr>
				<tr>
				  <td colspan=7 class="borderListing"></td>
			</tr>	 
					    <? $i++;
							  }?>
                      
                        <? }else{?>
                        <tr align="center" >
                          <td height="20" colspan="7" class=redtxt >No order found.</td>
                        </tr>
                        <? } ?>
                      </table>
					  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>" />
                    </form></td>
                  </tr>
				  
				   <? 	if($num>count($arryOrders)){ ?>
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
