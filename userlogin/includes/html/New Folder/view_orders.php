<div class="had"><?php echo 'Manage Orders';?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
  <tr>
    <td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="350" align="center" valign="top" ><div align="center"> <strong>
            <? if(!empty($_SESSION['msg'])){echo $_SESSION['msg']; unset($_SESSION['msg']);}?>
            </strong> <br />
            <br />
            <form action="" method="post" enctype="multipart/form-data" name="form2" id="form2" onsubmit="return ValidateSearch();">
              <table width="100%" height="38" border="0" cellpadding="0" cellspacing="4" align="center">
                <tr>
                  <td width="16%">&nbsp;</td>
                  <td width="55%" align="right" >Enter the keyword to search :</td>
                  <td  align="right" =""><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>" />
                      <input name="search" type="submit" class="search_button" value="Go" />
                      <? if($_GET['key']!='') {?>
                      <a href="view_orders.php">View all</a>
                      <? }?></td>
                  <td width="21%" ="" >&nbsp;Search in :
                    <select name="sortby" id="sortby" class="inputbox" onchange="return ValidateSearch(1);">
                        <option value=""> All </option>
                        <option value="OrderDate" <? if($_GET['sortby']=='OrderDate') echo 'selected';?>>Order Date</option>
                        <option value="BillingName" <? if($_GET['sortby']=='BillingName') echo 'selected';?>>Customer</option>
                        <option value="OrderID" <? if($_GET['sortby']=='OrderID') echo 'selected';?>>Order Number</option>
						 <option value="TrackNumber" <? if($_GET['sortby']=='TrackNumber') echo 'selected';?>>Tracking Number</option>
                        <option value="TotalPrice" <? if($_GET['sortby']=='TotalPrice') echo 'selected';?>>Amount</option>
                      </select>
                      <select name="asc" id="asc" class="inputbox" onchange="return ValidateSearch(1);">
                        <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
                        <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
                      </select>
                  </td>
                </tr>
              </table>
            </form>
        </div>
            <form action="" method="post" name="form1" id="form1">
             <table width="100%"  align="center" border="0" cellspacing="0" cellpadding="3" class="borderblue">
                      <tr>
                        <td height="22" align="left"    class="head1">Order Date </td>
                        <td align="left"   class="head1">Customer</td>
                        <td width="11%" align="left"    class="head1">Order Number </td>
                        <td width="12%" align="left"    class="head1">Tracking Number </td>
                        <td width="8%" align="left"    class="head1">Amount</td>
                        <td width="14%" align="left"    class="head1">Payment Method</td>
                        <td width="13%" align="left"    class="head1">Payment Status </td>
                        <td width="12%" align="left"    class="head1">Delivery Status</td>
                        <td align="center"    class="head1">Action</td>
                      </tr>
                      <?php 
					$pagerLink=$objPager->getPager($arryOrders,$RecordsPerPage,$_GET['curP']);
					 (count($arryOrders)>0)?($arryOrders=$objPager->getPageRecords()):("");
  							  if(is_array($arryOrders) && $num>0){
							$i=(($_GET['curP']-1)*10)+1;
							$flag=true;
							foreach($arryOrders as $key=>$values){
								$flag=!$flag;
							//	$bgcolor=($flag)?(""):("#F3F3F3");
							
							
				if($values['PaymentStatus']!=1){
					$Days = (strtotime(date('Y-m-d')) - strtotime($values['OrderDate']))/(3600*24);
					if($values['CancelStatus']!=1 && $Days>=3){
						$objOrders->CancelOrder($values['OrderID']);
					}else if($Days<=1){
						$objOrders->SendPaymentReminder($values['OrderID']);
					}					
				}							
							
							
  ?>
                      <tr bgcolor="<?=$bgcolor?>" valign="top">
                        <!--td width="6%" align="center"  class="tablered_txt"><?=$i?></td-->
                        <td width="10%" height="40"  align="left" class="Blue"><a href="#"  onclick="popitup('../OrderDetails.php?OrderID=<?=$values['OrderID']?>',800,650);" class="Blue"><strong>
                          <?=date('d-m-Y',strtotime($values['OrderDate']))?>
                        </strong></a>
						
						<? if($values['CancelStatus']==1){ echo '<div class="redbig">(Cancelled)</div>';}?>						</td>
                        <td width="11%"   align="left" ><?=$values['BillingName']?></td>
                        <td  align="left"  ><?=$values['OrderID']?></td>
                        <td  align="left" ><?=$values['TrackNumber']?></td>
                        <td  align="left" >
						<?=display_price($values['TotalPrice'],'',$TaxType,$values['symbol_left'],$values['symbol_right'])?>						</td>
                        <td  align="left"   ><span class="tablered_txt">
                          <?=$values['payment_gateway']?>
                        </span></td>
                        <td  align="left"   >
						<? 
						if($values['BankTransfer']==1){
						
							if($values['PaymentStatus']==1) $Received='Selected';
							elseif($values['PaymentStatus']==0) $NotReceived='Selected';
						 ?>
						<select name="PaymentStatus" id="PaymentStatus" class="inputbox" onchange="changePayStatus(this.value,<?=$values['OrderID']?>);" style="width:100">
                          <option value="1" <?=$Received?>>Received</option>
                          <option value="0" <?=$NotReceived?>>Not Received</option>
                        </select>
						<? }else{
							if($values['PaymentStatus']==1) echo "Received"; else echo "Not Received";
						}
						?>						</td>
                        <td  align="left">
                            <select name="status" id="status" class="inputbox" onchange="changeStatus(this.value,<?=$values['OrderID']?>);" style="width:100">
                              <option value="1" <?=($values['Status']==1)?(" selected"):("")?>>Delivered</option>
                              <option value="0" <?=($values['Status']==0)?(" selected"):("")?>>Pending</option>
                            </select> 
							<a href="#"  onclick="popitup('deliverMsg.php?OrderID=<?=$values['OrderID']?>',500,350);" class="tablered_txt">Edit Message</a><br /><br />
							
							                       </td>
                        <td width="9%"  align="center" class="tablered_txt"><a href="#"  onclick="popitup('../OrderDetails.php?OrderID=<?=$values['OrderID']?>',800,650);" class="tablered_txt">View</a> / <a href="view_orders.php?del_id=<?php echo $values['OrderID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confDel('Order')" class="tablered_txt" ><?=$delete?></a></td>
                      </tr>
                    <? $i++;
							  }?>
                      <tr align="center" >
                        <td height="5" colspan="9" ></td>
                      </tr>
                      <? }else{?>
                      <tr align="center" >
                        <td height="20" colspan="9" >No Order Found. </td>
                      </tr>
                      <?php } ?>
                  </table>
				  
				 <table width="100%" border="0" cellpadding="0" cellspacing="0" >
            
                <tr align="center" >
                  <td height="20" colspan="6" >Total Record(s) : &nbsp;<?php echo $num;?>
                      <?php if(count($arryOrders)>0){?>
                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
                </tr>
              </table>
              <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>" />
            </form></td>
      </tr>
    </table></td>
  </tr>
</table>

<script language="javascript">
function changeStatus(val,id){
	window.location.href='view_orders.php?curP=<?=$_GET['curP']?>&ID='+id+'&statVal='+val;
}

function changePayStatus(val,id){
	window.location.href='view_orders.php?curP=<?=$_GET['curP']?>&payID='+id+'&statVal='+val;
}

 function popitup(url,w,h) {
	newwindow=window.open(url,'name','height='+h+',width='+w+',top=20,left=50,scrollbars=yes,resizable=yes');
	if(window.focus) {newwindow.focus();}
	return false;
}

	function ValidateSearch(SearchBy){	
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'view_orders.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'view_orders.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
		}
</script>