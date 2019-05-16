<div class="had"><?=CHART_OF_ACCOUNTS?></div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
        <td align="right" valign="top">
<div class="accountBox" style=" float: left;width: 310px; padding-bottom: 5px;">
<form name="frmSrch" id="frmSrch" action="accountHistory.php" method="get" onSubmit="return ResetSearch();">


 Select Account Type&nbsp;&nbsp;&nbsp;<select name="AccountTypeID" class="inputbox" id="AccountTypeID" onChange="Javascript: SetAccountType(this.value);">
					 <option value="">---Select All---</option>
					<? for($i=0;$i<sizeof($arryAccountType);$i++) {?>
						<option value="<?=$arryAccountType[$i]['AccountTypeID']?>" <?php if($arryAccountType[$i]['AccountTypeID'] == $_GET['AccountTypeID']){ echo "selected";}?>>
						<?=stripslashes(ucwords(strtolower($arryAccountType[$i]['AccountType'])));?>
						 
				   </option>
					<? } ?>
			</select> 



	
</form>

</div>

  <div class="dateBox" style=" float: right;width: 570px;">
		<?php  if (is_array($arryBankAccount) && $num > 0) {?>
		<!--<input type="button" class="export_button" style="float: right;"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_account.php?<?=$QueryString?>';" />-->
		<?php }?>
		<!--<a href="editTransfer.php" class="fancybox po fancybox.iframe add">Transfer</a>-->
		<a href="editAccount.php" class="add">Add Account</a>
		 <? if($_GET['search']!='' || $_GET['AccountTypeID']!='') {?>
	  	<a href="viewAccount.php" class="grey_bt">View All</a>
		<? }?>
</div>
		</td>
      </tr>
  
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_bank_account'])) {  echo stripslashes($_SESSION['mess_bank_account']);   unset($_SESSION['mess_bank_account']);} ?></div>
            <div style="overflow-y:scroll; max-height:450px;">
            <table <?= $table_bg ?>>

		 <?php
		if (is_array($arryBankAccountType) && $num > 0) {
                  
                    foreach ($arryBankAccountType as $key => $values) {
			
			
			
		?> 
                 <tr>
		   <td  colspan="7" height="30" style="background-color:#FFFFFF;" valign="bottom"><b><?=$values['AccountType']?><b></td>
		  </tr>

		<?php 
		
		if(!empty($_GET['AccountTypeID'])){ $AccountTypeID = $_GET['AccountTypeID'];}else{$AccountTypeID = $values['AccountTypeID'];}
		
		 $arryBankAccount=$objBankAccount->getBankAccount($AccountTypeID,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);	
		 $num=$objBankAccount->numRows();   
		?>

		<tr align="left">
			<td width="15%" height="20"  class="head1">Account Name</td>
			<td width="15%" height="20"  class="head1">Account Number</td> 
			<td width="12%" height="20"  class="head1">Account Code</td>  	
			<td width="10%" height="20"  align="right" class="head1">Balance (<?=$Config['Currency']?>)</td>
			<!--<td width="8%" height="20"  align="center" class="head1">Currency</td>--> 				
			<td width="8%" height="20"  class="head1" align="center">Status</td>    
			<td width="10%" height="20" align="center" class="head1">Action</td>
		</tr>
		<?php
		$history = '<img src="'.$Config['Url'].'admin/images/history.png" border="0"  onMouseover="ddrivetip(\'<center>View History</center>\', 80,\'\')"; onMouseout="hideddrivetip()" >';
		$Config['editImg'] = $edit;
		$Config['deleteImg'] = $delete;
		$Config['viewImg'] = $view;
		if (is_array($arryBankAccount) && $num > 0) {
		foreach ($arryBankAccount as $key => $values) {
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");

		$ReceivedAmnt = $values['ReceivedAmnt'];
		$PaidAmnt = $values['PaidAmnt'];
		$Balance = $ReceivedAmnt-$PaidAmnt;
						
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
			    <td><?= $values['AccountName'];?></td>
                            <td><?= $values['AccountNumber'];?></td>
                            <td><?= $values['AccountCode'];?></td>
							<td align="right"><strong><?= number_format($Balance,2,'.',',');?></strong></td>
							<!--<td align="center"><//?= $values['Currency'];?></td>-->
							  <td align="center" >
							 <?php
								if ($values['Status'] == 'Yes') {
									$status = 'Active';
								} else {
									$status = 'InActive';
								}


                                            echo '<a href="editAccount.php?active_id=' . $values["BankAccountID"] . '&curP=' . $_GET["curP"] . '" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                   
                            <td height="26" align="center" class="head1_inner">
				
                                   <a href="vAccount.php?view=<?=$values['BankAccountID']?>&curP=<?=$_GET['curP']?>"><?=$view?></a>

                              <?php if($Balance == 0) {?>
                                   <a href="editAccount.php?edit=<?php echo $values['BankAccountID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>

                                   <a href="editAccount.php?del_id=<?php echo $values['BankAccountID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Account')" class="Blue" ><?= $delete ?></a><?php }?>

				<a href="accountHistory.php?accountID=<?=$values['BankAccountID']?>" target="_blank"><?=$history;?></a>								   
                                &nbsp;
                            </td>
                        </tr>
                    <?php 

          $objBankAccount->GetSubAccountTree($values['BankAccountID'],0);
?>

<?php } // foreach end //?>

<?php } else {?>

	<tr align="center">
	<td height="20" colspan="6"  class="no_record"><?=NO_RECORD;?></td>
	</tr>

<?php }?>

		 
		<?php } } else {?>

	<tr align="center">
	<td height="20" colspan="6"  class="no_record"><?=NO_RECORD;?></td>
	</tr>

<?php }?>

               
            </table>
            </div>
        </td>
    </tr>
</table>
 
<script type="text/javascript">

function SetAccountType(AccountTypeID){
		ShowHideLoader('1','S');
		if(AccountTypeID > 0){
		 window.location = 'viewAccount.php?AccountTypeID='+AccountTypeID;
		}else{
		 window.location = 'viewAccount.php';
		}
		 
	}
</script>
