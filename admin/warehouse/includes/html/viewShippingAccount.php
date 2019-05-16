<div class="had"><?=$MainModuleName;?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_ship_account'])) {echo $_SESSION['mess_ship_account']; unset($_SESSION['mess_ship_account']); }?></div>

<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	?>

<script>
    $(function(){
      // bind change event to select
      $('#dynamic_select').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
		ShowHideLoader('1','F');
              window.location = 'viewShippingAccount.php?type='+url; // redirect
          }
          return false;
      });
    });
</script>

<table id="search_table" cellspacing="0" cellpadding="0" border="0"
	style="margin: 0">
	<?php if($arryCompany[0]['ShippingCareer']==1 && $arryCompany[0]['ShippingCareerVal']!=''){?>
	<form name="frmSrch" id="frmSrch" action="accountHistory.php"
		method="get">
	<tr>
		<td align="left"><select id="dynamic_select" class="textbox"
			style="width: 82px;">
			<?php
			$ShipCareers = explode(',', $arryCompany[0]['ShippingCareerVal']);
			foreach($ShipCareers as $ShipCareer){?>
			<option value="<?=$ShipCareer;?>"
			<?php if($ShipCareer==$_GET['type']){echo "selected";}?>><?=$ShipCareer;?></option>
			<?php } ?>
		</select></td>
	</tr>
	</form>
	<?php } ?>
</table>

<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>

	<tr>
		<td align="right"><a
			href="editShippingAccount.php?type=<?php echo $_GET['type'];?>"
			class="add">Add Shipping Account</a></td>
	</tr>
	<tr>
		<td valign="top">


		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none"><img
			src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

<?
 
if($_GET['type']=='UPS'){ //UPS
	$MeterLable = 'Account Number';
	$Username = 'Username';
}else{ //Fedex
	$MeterLable = 'Meter Number';
	$Username = 'Account Number';
}


if($_GET['type']=='DHL'){ //DHL
 	$ApiKeyLable = 'Site ID';
	$HideMeter = 'Style="display:none"';
}else{ //Other
	$ApiKeyLable = 'API Key';
	$HideMeter ='';
}

?>


		<table <?=$table_bg?>>

			<tr align="left">
				<td class="head1"><?=$Username?></td>
				<td class="head1">Password</td>
				<td class="head1"><?=$ApiKeyLable?></td>
				<td class="head1" <?=$HideMeter?>><?=$MeterLable?></td>
				<td class="head1">Shipping Carrier</td>
				<td class="head1">Default Ship Account</td>
				<td align="center" class="head1 head1_action">Action</td>
			</tr>

			<?php
			if(is_array($ListShipAccount) && $num>0){
				$flag=true;
				$Line=0;
				foreach($ListShipAccount as $key=>$values){
					$flag=!$flag;
					$Line++;

					?>
			<tr align="left">

				<td><?=$values["api_account_number"]?></td>
				<td><?=$values["api_password"]?></td>
				<td><?=$values["api_key"]?></td>
				<td <?=$HideMeter?>><?=$values["api_meter_number"]?></td>
				<td><?=$values["api_name"]?></td>
				<td><?=($values['defaultVal']=='1')?('Yes'):('')?></td>
				<td align="center" class="head1_inner"><a
					href="editShippingAccount.php?edit=<?=$values['id']?>&curP=<?=$_GET['curP']?>&type=<?=$values['api_name']?>"><?=$edit?>

				</a>
				<?php if($values['defaultVal']!=1){?>
				 <a href="editShippingAccount.php?del_id=<?=$values['id']?>&curP=<?=$_GET['curP']?>&type=<?=$values['api_name']?>"
					onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a>
				<?php }?>
                                <?php if($values['defaultVal']==1){?>
				 <a href="apiDemo.php?apiType=<?=$values["api_name"]?>" target="_blank">Instruction</a> 
				<?php }?>
				</td>

			</tr>
			<?php } // foreach end //?>

			<?php }else{?>
			<tr align="center">
				<td colspan="16" class="no_record"><?=NO_RECORD?></td>
			</tr>
			<?php } ?>

			<tr>
				<td colspan="16" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>
				<?php if(count($ListShipAccount)>0){?> &nbsp;&nbsp;&nbsp; Page(s) :&nbsp;
				<?php echo $pagerLink;
				}?></td>
			</tr>
		</table>

		</div>
		<? if(sizeof($ListShipAccount)){ ?> <? } ?> <input type="hidden"
			name="CurrentPage" id="CurrentPage"
			value="<?php echo $_GET['curP']; ?>"> <input type="hidden" name="opt"
			id="opt" value="<?php echo $ModuleName; ?>"></form>
		</td>
	</tr>
</table>


<? } ?>
