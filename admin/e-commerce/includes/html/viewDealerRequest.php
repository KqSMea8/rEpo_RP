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
					<option value="">--- Select ---</option>
					<?php for($count=0;$count<count($arryCustomer);$count++){
						echo '<option value="'.$arryCustomer[$count]['Cid'].'" ';
						if($_REQUEST['DealerId'] == $arryCustomer[$count]['Cid'])
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
			<tr align="left">
				<td width="15%" height="20" class="head1">Name</td>
				<td width="16%" height="20" class="head1" align="center">Amount</td>
				<td width="17%" height="20" class="head1" align="center">Message</td>
				<td width="10%" height="20" class="head1" align="center">Date</td>
				<td width="10%" height="20" class="head1" align="center">Status</td>
			</tr>

			<?php
			$pagerLink = $objPager->getPager($arryWalletHistory, $RecordsPerPage, $_GET['curP']);
			(count($arryWalletHistory) > 0) ? ($arryWalletHistory = $objPager->getPageRecords()) : ("");
			if ($num > 0) {
				
				foreach ($arryWalletHistory as $key => $values) {
					

					?>
			<tr align="left" bgcolor="<?= $bgcolor ?>">
				<td height="26"><?= $values['dealerName'];?></td>
				<td align="center"><?= $values['amount'];?></td>
				<td align="center"><?= $values['msg'];?></td>				
				<td><?= date('Y-m-d',strtotime($values['date']));?></td>
				<td><select name="status" class="inputbox" id="status_<?php echo $values['id'].'_'.$values['dealerId'];?>" onchange="updatestatus(this);" 
				<?php if($values['status']=='Approve' || $values['status']=='Reject'){ echo 'disabled';}?>>
				<option value="Pending" <?php if($values['status']=='Pending'){echo 'selected="selected"';}?>>Pending</option>
				<option value="Approve" <?php if($values['status']=='Approve'){echo 'selected="selected"';}?>>Approve</option>
				<option value="Reject" <?php if($values['status']=='Reject'){echo 'selected="selected"';}?>>Reject</option>
				<?= $values['status'];?>
				</select></td>
			</tr>
		
			<?php  } // foreach end //?>
			
			
			
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
<script type="text/javascript">
function updatestatus(obj){
	var Idstring=obj.id;
	var res = Idstring.split("_");
	
	if(obj.value=='Approve'){
		var ahtml='<a style="display:none;" id="pop_'+res[1]+'" href="addAmount.php?id='+res[1]+'&DealerId='+res[2]+'" class="fancybox fancybox.iframe">Open PopUp</a>';

		$('#'+obj.id).after(ahtml);
		//$("#pop_"+res[1]).click(function(){
		    $(".fancybox").trigger('click');  
		 // })
		
	}else if(obj.value=='Reject'){
		 window.location.href="viewDealerRequest.php?id="+res[1]+'&DealerId='+res[2]+'&status='+obj.value;
	} 
}
</script>

