<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>


<?php include('ErpSiteManagementMenu.php');?>
<div class="clear"></div>
<br>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_payment_status'])) {echo $_SESSION['mess_banner']; unset($_SESSION['mess_payment_status']); }?>
</div>
<div class="had">Order History</div>
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	
		<tr>
        <td align="right" >
		
		<? if($_GET['key']!='') {?>
		  <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location='ErpOrderHistory.php';" />
		<? }?>

      </tr>
      
	<tr>
		<td>
			<div class="message">
			<? if (!empty($_SESSION['mess_Page'])) {
				echo stripslashes($_SESSION['mess_Page']);
				unset($_SESSION['mess_Page']);
			} ?>
			</div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				align="center">
			

			</table>

			<table <?= $table_bg ?>>
				<tr align="left">
				
					<td width="10%" height="20" class="head1">Order Date</td>
					<td width="12%" height="20" class="head1">Reseller Name</td>
				    <td width="12%" height="20" class="head1">Company Name</td>
					<td width="5%" height="20" class="head1">CmpID</td>
					<td width="10%" height="20" class="head1">Display Name</td>
					<td width="10%" height="20" class="head1">Start Date</td>
					<td width="10%" height="20" class="head1">Expiry Date</td>
					<td width="10%" height="20" class="head1">Plan</td>
					<td width="8%" height="20" class="head1">Total Amount $ </td>
					<td width="8%" height="20" class="head1">Payment Status</td>
					
                    <td width="5%" height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
				</tr>
				<?php
				if (is_array($arryOrderHistory) && $num > 0) {
					$flag = true;

					foreach ($arryOrderHistory as $key => $values) {
						//print_r($values);
						?>
				<tr align="left" bgcolor="<?= $bgcolor ?>">
					<td height="30"><?  if($values['UpdatedDate']>0){ echo date("j F, Y",strtotime($values['UpdatedDate'])); }?></td>
					<td><?=stripslashes($values['ResellerName'])?></td>
				    	<td><?=stripslashes($values['CompanyName'])?></td>
					<td><?= $values['CmpID']; ?></td>
					<td><?= $values['DisplayName']; ?></td>					
					<td><?  if($values['StartDate']>0){ echo date("j F, Y",strtotime($values['StartDate'])); }?></td>
                    <td ><?  if($values['EndDate']>0){ echo date("j F, Y",strtotime($values['EndDate'])); }?></td>
                    <td ><?= $values['PaymentPlan']; ?></td>
                    <td ><?= $values['TotalAmount']; ?></td>
                     <td ><?php if($values['PaymentStatus']=='1'){echo "<div class='green'>Paid</div>";}else{echo "<div class='red'><a href='ErpOrderHistory.php?active_id=".$values["OrderID"]."&curP=".$_GET["curP"]."'>Pending</a></div>";}?></td>				
					<td  align="right" valign="top">
					<a  class="fancybox fancybox.iframe" href="ErpPaymentHistoryByCmp.php?view=<?php echo $values['OrderID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" ><?= $view ?></a>
					&nbsp;</td>
			
				</tr>
				
				<?php } // foreach end //?>
				<?php } else { ?>
				<tr align="center">
					<td height="20" colspan="10" class="no_record">No Recourd found.</td>
				</tr>
				<?php } ?>
				<tr>
					<td height="20" colspan="4">Total Record(s) : &nbsp;<?php echo $num; ?>
					<?php if (count($arryOrderHistory) > 0) { ?>&nbsp;&nbsp;&nbsp;
						Page(s) :&nbsp; <?php echo $pagerLink;
					} ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>


