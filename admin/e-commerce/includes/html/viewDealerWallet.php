<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_wallet'])) {echo $_SESSION['mess_wallet']; unset($_SESSION['mess_wallet']); }?></div>
<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>

	<tr>
		<td valign="top">

		<form action="" method="post" enctype="multipart/form-data"
			name="form2">
		<table border="0" cellpadding="3" cellspacing="0" id="search_table"
			style="margin: 0">

			<tr>
				<td valign="bottom">Dealer :<br>
				<select name="DealerId" class="inputbox" id="DealerId">
					
					<?php for($count=0;$count<count($arryCustomer);$count++){
						echo '<option value="'.$arryCustomer[$count]['Cid'].'" ';
						if($_POST['DealerId'] == $arryCustomer[$count]['Cid'])
						echo "selected";
						echo '>'.$arryCustomer[$count]['FirstName'].' '.$arryCustomer[$count]['LastName'].'</option>';
					}?>
				</select></td>

				<td>&nbsp;</td>

				<td align="right" valign="bottom"><input name="search" type="submit"
					class="search_button" value="Go" /></td>
			</tr>


		</table>
		</form>




		</td>
	</tr>





	<tr>
		<td valign="top">


		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none"><img
			src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">
		<table <?=$table_bg?>>
			<tr align="left" bgcolor="<?= $bgcolor ?>">				
				<td ><b>Wallet Limit</b></td>
				<td align="center"><?= $arryWalletHistory[0]['WalletLimit'];?></td>
				<td height="26">&nbsp;</td>
				<td height="26"><b>Balance</b></td>
				<td align="center"><?=$arryWalletHistory[0]['WalletBalance'];?></td>
				

			</tr>
			<tr align="left">
				<td width="15%" height="20" class="head1">Name</td>
				<td width="16%" height="20" class="head1" align="center">Amount</td>
				<td width="17%" height="20" class="head1" align="center">Transaction
				No.</td>
				<td width="12%" height="20" class="head1" align="center">Note</td>
				<td width="10%" height="20" class="head1" align="center">Date</td>

			</tr>

			<?php
			$pagerLink = $objPager->getPager($arryWalletHistory, $RecordsPerPage, $_GET['curP']);
			(count($arryWalletHistory) > 0) ? ($arryWalletHistory = $objPager->getPageRecords()) : ("");
			if ($num > 0) {
				$DebitAmount=0;
				foreach ($arryWalletHistory as $key => $values) {
					$DebitAmount=$DebitAmount+$values['DebitAmount'];
					if($values['DebitAmount']>0){

					?>
			<tr align="left" bgcolor="<?= $bgcolor ?>">
				<td height="26"><?= $values['dealerName'];?></td>
				<td align="center"><?= $values['DebitAmount'];?></td>
				<td align="center"><?= $values['transactionNo'];?></td>
				<td><?= $values['walletNote'];?></td>
				<td><?= date('Y-m-d',strtotime($values['date']));?></td>

			</tr>
		
			<?php } } // foreach end //?>
			<?php if($DebitAmount>0){?>
			<tr align="left" bgcolor="<?= $bgcolor ?>">
				<td height="26"><b>Total</b></td>
				<td align="center"><?=number_format($DebitAmount,2);?></td>
				<td colspan="3">&nbsp;</td>
				

			</tr>
			<?php }?>
			
			
			<?php } else { ?>
			<tr align="center">
				<td height="20" colspan="7" class="no_record">No Records found.</td>
			</tr>
			<?php } ?>

			<tr>
				<td height="20" colspan="7">Total Record(s) : &nbsp;<?php echo $num; ?>
				<?php if (count($arryWalletHistory) > 0) { ?> &nbsp;&nbsp;&nbsp;
				Page(s) :&nbsp; <?php echo $pagerLink;
				}
				?></td>
			</tr>
		</table>
		</div>



		</form>
		</td>
	</tr>
</table>


