<div class="had"><?=$MainModuleName;?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_addbook_profile'])) {echo $_SESSION['mess_addbook_profile']; unset($_SESSION['mess_addbook_profile']); }?></div>

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
              window.location = 'addressBook.php?type='+url; // redirect
          }
          return false;
      });
    });
</script>

<table id="search_table" cellspacing="0" cellpadding="0" border="0" style="margin:0">
<form name="frmSrch" id="frmSrch" action="accountHistory.php" method="get" >
<tr>
<td align="left">

<select id="dynamic_select" class="textbox">
	<option value="ShippingTo"<?php if($Type=='ShippingTo'){echo "selected='selected'";}?>>ShippingTo</option>
	<option value="ShippingFrom" <?php if($Type=='ShippingFrom'){echo "selected='selected'";}?>>ShippingFrom</option>
</select>
</td>

</tr>


</form>
</table>

<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>

	<tr>
		<td valign="top">


		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none"><img
			src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?> >

			<tr align="left">
				<td class="head1">Default</td>
				<td class="head1">Country</td>
				<td class="head1">Company</td>
				<td class="head1">First Name</td>
				<td class="head1">Last Name</td>
				<td class="head1">Contact Name</td>
				<td class="head1">Address1</td>
				
				<td class="head1">Address2</td>
				<td class="head1">Country</td>
				<td class="head1">State</td>
				<td class="head1">City</td>	
				<td class="head1">Zip</td>			
				<td class="head1">PhoneNo</td>
				<td class="head1">Department</td>
				<td class="head1">FaxNo</td>
				<td align="center" class="head1 head1_action">Action</td>
			</tr>

			<?php
			if(is_array($arryAddressBook) && $num>0){
				$flag=true;
				$Line=0;
				foreach($arryAddressBook as $key=>$values){
					$flag=!$flag;
					$Line++;

					?>
			<tr align="left">
<td>
<?=($values['defaultAddress']=='1')?('Yes'):('')?>
</td>
				<td><?=$values["Country"]?></td>
				<td><?=$values["Company"]?></td>
				<td><?=$values["Firstname"]?></td>
				<td><?=$values["Lastname"]?></td>
				<td><?=$values["ContactName"]?></td>
				<td><?=$values["Address1"]?></td>
				
				<td><?=$values["Address2"]?></td>
				<td><?=$values["Country"]?></td>
				<td><?=$values["State"]?></td>
				<td><?=$values["City"]?></td>	
				<td><?=$values["Zip"]?></td>			
				<td><?=$values["PhoneNo"]?></td>
				<td><?=$values["Department"]?></td>
				<td><?=$values["FaxNo"]?></td>
				<td align="center" class="head1_inner"><a
					href="editAddressBook.php?edit=<?=$values['adbID']?>&curP=<?=$_GET['curP']?>&type=<?=$_GET['type']?>"><?=$edit?>

</a>
				<a
					href="editAddressBook.php?del_id=<?=$values['adbID']?>&curP=<?=$_GET['curP']?>"
					onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a>
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
				<?php if(count($arryAddressBook)>0){?> &nbsp;&nbsp;&nbsp; Page(s) :&nbsp;
				<?php echo $pagerLink;
				}?></td>
			</tr>
		</table>

		</div>
		<? if(sizeof($arryAddressBook)){ ?> <? } ?> <input type="hidden"
			name="CurrentPage" id="CurrentPage"
			value="<?php echo $_GET['curP']; ?>"> <input type="hidden" name="opt"
			id="opt" value="<?php echo $ModuleName; ?>"></form>
		</td>
	</tr>
</table>


		<? } ?>
