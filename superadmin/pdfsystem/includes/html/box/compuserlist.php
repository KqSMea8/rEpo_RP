
<?php // print_r($arrycompUser);?>
<!--<div class="had">Manage Company</div>
--><div class="message" align="center"><? if(!empty($_SESSION['mess_company1'])) {echo $_SESSION['mess_company1']; unset($_SESSION['mess_user1']); }?></div>
<!--<div><a href="#" class="back">Back</a></div>
--><TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
	<tr>
		<td valign="top">
		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none"><img
			src="images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>

			<tr align="left">
				<td width="15%" class="head1">User Name</td>
				<td width="15%" class="head1">User Contact</td>
				<td class="head1" width="8%">Email</td>
                                <td class="head1" width="8%">User Type</td>
				<td width="6%" align="center" class="head1">Company Code</td>
			</tr>

			<?php

			if(!empty($arrycompUser)){

				$num =0;
				foreach($arrycompUser as $key=>$values){
					$num++;
					//print_r($arrycompUser);?>
					
			<tr align="left" bgcolor="<?=$bgcolor?>">
				<td height="50"><strong><?=$values['firstName'];?></strong></td>
				<td><?=$values['phone'];?></td>
				<td><?  echo '<a href="mailto:'.$values['username'].'">'.$values['username'].'</a>'; ?></td>
                               <td><?=$values['role'];?></td>
				<td><?=$values['company_code'];?></td>
				
			</tr>
			<?php } // foreach end //?>

			<?php }else{?>
			<tr align="center">
				<td colspan="9" class="no_record">No record found.</td>
			</tr>
			<?php } ?>

			<tr>
				<td colspan="9">Total Record(s) : &nbsp;<?php echo $totalrecords;?> <?php if(count($arrycompUser)>0){?>
				&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink;
				}?></td>
			</tr>
		</table>

		</div>
		<? if(sizeof($arryUser)){ ?>
		<table width="100%" align="center" cellpadding="3" cellspacing="0"
			style="display: none">
			<tr align="center">
				<td height="30" align="left"><input type="button"
					name="DeleteButton" class="button" value="Delete"
					onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','userID','addCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
				<input type="button" name="ActiveButton" class="button"
					value="Active"
					onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','userID','addCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
				<input type="button" name="InActiveButton" class="button"
					value="InActive"
					onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','userID','addCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
			</tr>
		</table>
		<? } ?> <input type="hidden" name="CurrentPage" id="CurrentPage"
			value="<?php echo $_REQUEST['curP']; ?>"> <input type="hidden" name="opt"
			id="opt" value="<?php echo $ModuleName; ?>"></form>
		</td>
	</tr>
</table>
