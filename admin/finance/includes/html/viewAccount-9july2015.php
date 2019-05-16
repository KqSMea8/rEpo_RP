<div class="had"><?=CHART_OF_ACCOUNTS?></div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
        <td align="right" valign="top">
		<?php  if (is_array($arryBankAccount) && $num > 0) {?>
		<input type="button" class="export_button" style="float: right;"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_account.php?<?=$QueryString?>';" />
		<?php }?>
		<a href="editTransfer.php" class="fancybox po fancybox.iframe add">Transfer</a>
		<a href="editAccount.php" class="add">Add Account</a>
		 <? if($_GET['search']!='') {?>
	  	<a href="viewAccount.php" class="grey_bt">View All</a>
		<? }?>

		</td>
      </tr>
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_bank_account'])) {  echo stripslashes($_SESSION['mess_bank_account']);   unset($_SESSION['mess_bank_account']);} ?></div>
            <table <?= $table_bg ?>>
                <tr align="left">
				<td width="15%" height="20"  class="head1">Account Name</td>
				<td width="12%" height="20"  class="head1">Account Type</td>    
				<td width="15%" height="20"  class="head1">Account Number</td> 
				<td width="12%" height="20"  class="head1">Account Code</td>  	
				<td width="10%" height="20"  align="right" class="head1">Balance</td>
				<td width="8%" height="20"  align="center" class="head1">Currency</td> 				
				<td width="8%" height="20"  class="head1" align="center">Status</td>    
				<td width="10%" height="20" align="center" class="head1">Action</td>
                </tr>
                <?php
                 $Config['editImg'] = $edit;
                 $Config['deleteImg'] = $delete;
                $pagerLink = $objPager->getPager($arryBankAccount, $RecordsPerPage, $_GET['curP']);
                (count($arryBankAccount) > 0) ? ($arryBankAccount = $objPager->getPageRecords()) : ("");
                if (is_array($arryBankAccount) && $num > 0) {
                    $flag=true;
                   
				   $Balance = 0;
				   
                    foreach ($arryBankAccount as $key => $values) {
                        $flag=!$flag;
	                    $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
						
						$ReceivedAmnt = $values['ReceivedAmnt'];
						$PaidAmnt = $values['PaidAmnt'];
						$Balance = $ReceivedAmnt-$PaidAmnt;
						
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
						    <td><?= $values['AccountName'];?></td>
                            <td height="26"><?= $values['AccountType'];?></td>
                            <td><?= $values['AccountNumber'];?></td>
                            <td><?= $values['AccountCode'];?></td>
							<td align="right"><strong><?= number_format($Balance,2,'.','');?></strong></td>
							<td align="center"><?= $values['Currency'];?></td>
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
							<?php if($values['CashFlag'] != 1) {?>
                                   <a href="vAccount.php?view=<?=$values['BankAccountID']?>&curP=<?=$_GET['curP']?>"><?=$view?></a>
                                   <a href="editAccount.php?edit=<?php echo $values['BankAccountID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                   <a href="editAccount.php?del_id=<?php echo $values['BankAccountID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Account')" class="Blue" ><?= $delete ?></a> <br><?php }?>
									<a href="accountTransaction.php?accountID=<?=$values['BankAccountID']?>" class="fancybox account fancybox.iframe">Transaction</a>								   
                                &nbsp;
                            </td>
                        </tr>
                    <?php 

          $objBankAccount->GetSubAccountTree($values['BankAccountID'],0);

} // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="8"  class="no_record"><?=NO_RECORD;?></td>
                    </tr>
                <?php } ?>

                <tr >  <td height="20" colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryBankAccount) > 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                }
                ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
 
