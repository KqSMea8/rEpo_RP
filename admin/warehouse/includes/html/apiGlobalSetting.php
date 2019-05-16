<div class="had"><?=$MainModuleName;?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_shipment_profile'])) {echo $_SESSION['mess_shipment_profile']; unset($_SESSION['mess_shipment_profile']); }?></div>

<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	?>

<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
	<tr>
		<td valign="top">


		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none"><img
			src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>

			<tr align="left">

				<td width="10%" class="head1" align="center">API Key</td>
				<td width="13%" class="head1" align="center">Password</td>
				<!--td width="10%" class="head1" align="center">Account Number</td>
				<td width="10%" class="head1" align="center">Meter Number</td-->
				<td width="10%" class="head1" align="center">Master Zip Code</td>
				<td width="13%" class="head1" align="center">API Name</td>
				<td width="7%" align="center" class="head1 head1_action">Action</td>
			</tr>

			<?php
			if(is_array($arryReturn) && $num>0){
				$flag=true;
				$Line=0;
				foreach($arryReturn as $key=>$values){
					$flag=!$flag;
					$Line++;

					?>
			<tr align="left">

				<td align="center"><?=$values["api_key"]?></td>
				<td align="center"><?=$values["api_password"]?></td>
				<!--td align="center"><?=$values["api_account_number"]?></td>
				<td align="center"><?=$values["api_meter_number"]?></td-->
				
				<td align="center"><?=$values["SourceZipcode"]?></td>
				
				<td align="center"><?=$values["api_name"]?></td>
				<td align="center" class="head1_inner"><a
					href="editApiGlobalSetting.php?edit=<?=$values['id']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>

 <a href="apiDemo.php?apiType=<?=$values["api_name"]?>" target="_blank">Instruction</a> 

				</td>
			</tr>
			<?php } // foreach end //?>

			<?php }else{?>
			<tr align="center">
				<td colspan="9" class="no_record"><?=NO_RECORD?></td>
			</tr>
			<?php } ?>

			<tr>
				<td colspan="9" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>
				<?php if(count($arryReturn)>0){?> &nbsp;&nbsp;&nbsp; Page(s) :&nbsp;
				<?php echo $pagerLink;
				}?></td>
			</tr>
		</table>

		</div>

		</form>
		</td>
	</tr>
</table>


				<? } ?>
