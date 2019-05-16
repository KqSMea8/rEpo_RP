<div class="had"><?=CHART_OF_ACCOUNTS?></div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
        <td valign="top">

<table id="search_table" cellspacing="0" cellpadding="0" border="0" style="margin:0">
<form name="frmSrch" id="frmSrch" action="accountHistory2.php" method="get" >
<tr>
<td align="left">


 <select name="AccountTypeID" class="inputbox" id="AccountTypeID" onChange="Javascript: SetAccountType(this.value);">
					 <option value="">--- Account Type ---</option>
					<? for($i=0;$i<sizeof($arryAccountType);$i++) {?>
						<option value="<?=$arryAccountType[$i]['AccountTypeID']?>" <?php if($arryAccountType[$i]['AccountTypeID'] == $_GET['AccountTypeID']){ echo "selected";}?>>
						<?=stripslashes(ucwords(strtolower($arryAccountType[$i]['AccountType'])));?>
						 
				   </option>
					<? } ?>
			</select> 

	<input type="hidden" name="pop" id="pop" value="<?=$_GET['pop']?>">
</td>

</tr>


</form>
</table>
	



<div <?=$Config['HideUnwanted']?> >
		<!--<input type="button" class="export_button" style="float: right;"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_account.php?<?=$QueryString?>';" />-->
		<!--<a href="editTransfer.php" class="fancybox po fancybox.iframe add">Transfer</a>-->
		<a href="editAccount2.php" class="add">Add Account</a>
		<a href="editBankAccount.php" class="add">Add Bank Account</a>
		 <a href="editGroupAccount2.php" class="add">Add Group Account</a>
		 <? if($_GET['search']!='') {?>
	  	<a href="viewAccount2.php" class="grey_bt">View All</a>
		<? }?>
</div>


		</td>
      </tr>
  
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_bank_account'])) {  echo stripslashes($_SESSION['mess_bank_account']);   unset($_SESSION['mess_bank_account']);} ?></div>

            
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/ajaxloader.gif"></div>

<div id="preview_div">

            <table <?= $table_bg ?>>
                <thead>
		<tr align="left">
			<td height="20"  class="head1">Account Name</td>
			<td width="15%"  class="head1">Cash Account Number</td> 
			<td width="15%" align="right" class="head1">Balance (<?=$Config['Currency']?>)</td>
			 				
			<td width="10%" class="head1" align="center" <?=$Config['HideUnwanted']?> >Status</td>    
			<td width="10%" align="center" class="head1" <?=$Config['HideUnwanted']?>>Action</td>
		</tr>
                </thead>
            </table>
            <div style="overflow-y:scroll; max-height:450px;">
                <table <?= $table_bg ?>>
                <tbody>
		 <?php
		if (is_array($arryBankAccountType) && $num > 0) {
                  
                    foreach ($arryBankAccountType as $key => $values) {
			
			
			
		?> 
                 <tr>
		   <td  colspan="6" height="30" style="background-color:#FFFFFF;" valign="bottom"><b><?=$values['AccountType']?><b></td>
		  </tr>

		<?php 
		
		if(!empty($_GET['AccountTypeID']))
                    { 
                     //$AccountTypeID = $_GET['AccountTypeID'];
                      $AccountTypeID=$objBankAccount->getAccountTypeByID($_GET['AccountTypeID']);
                      
                      $RangeFromm=$AccountTypeID[0]["RangeFrom"];
                    
                    }else
                        {
                        
                         //$AccountTypeID = $values['AccountTypeID'];
                          $AccountTypeID=$objBankAccount->getAccountTypeByID($values['AccountTypeID']);
                          $RangeFromm=$AccountTypeID[0]["RangeFrom"];
                        }



		 $Config['RootAccount'] = 1;
		 $arryBankAccount=$objBankAccount->getBankAccount($RangeFromm,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);	
		$numBankAcc = sizeof($arryBankAccount);
		
		unset($Config['RootAccount']);


		$history = '<img src="'.$Config['Url'].'admin/images/history.png" border="0"  onMouseover="ddrivetip(\'<center>View History</center>\', 80,\'\')"; onMouseout="hideddrivetip()" >';
		$Config['editImg'] = $edit;
		$Config['deleteImg'] = $delete;
		$Config['viewImg'] = $view;
                $Config['history'] = $history;

		
		foreach ($arryBankAccount as $key => $values) {
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");

		$ReceivedAmnt = $values['ReceivedAmnt'];
		$PaidAmnt = $values['PaidAmnt'];
                
                $Balance = $ReceivedAmnt-$PaidAmnt;
                
		
						
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
			    <td >



<?
if($Config['pop']==1){
	echo '<a href="Javascript:void(0)" onclick="Javascript:SetAccount(\''.$values["BankAccountID"].'\',\''.ucwords($values["AccountName"]).'\',\''.$values["AccountNumber"].'\');" onMouseover="ddrivetip(\''.CLICK_TO_SELECT.'\', \'\',\'\')"; onMouseout="hideddrivetip()"><b>'.ucwords($values["AccountName"]).'</b></a>';
}else{
	echo ucwords($values['AccountName']);
}




if($values['BankFlag'] == 1){
	echo '<br>[ Bank Acc No: '.$values['BankAccountNumber'].' ]';
}
?>
</td>
                            <td width="15%"><?=$values['AccountNumber']?></td>
                        
			    <td width="15%" align="right"><strong><?= number_format($Balance,2,'.',',');?></strong></td>
							<!--<td align="center"><//?= $values['Currency'];?></td>-->
			     <td width="10%" align="center" <?=$Config['HideUnwanted']?>>
							 <?php
								if ($values['Status'] == 'Yes') {
									$status = 'Active';
								} else {
									$status = 'InActive';
								}
                                                   if($Balance == 0 && $values['CashFlag'] != 1) {                  
                                                       
                                                       $statusLink = 'editAccount2.php?active_id=' . $values["BankAccountID"] . '&curP=' . $_GET["curP"] . '';
                                                   }else{
                                                       $statusLink = "javascript:void();";
                                                   }

                                            echo '<a href="'.$statusLink.'" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                   
                            <td width="10%" height="26" align="center" class="head1_inner" <?=$Config['HideUnwanted']?>>
				
                                   <!--a href="vAccount.php?view=<?=$values['BankAccountID']?>&curP=<?=$_GET['curP']?>"><?=$view?></a-->

                              <?php if($Balance == 0 && $values['CashFlag'] != 1) {?>
                                   <a href="editAccount2.php?edit=<?php echo $values['BankAccountID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>

                                   <a href="editAccount2.php?del_id=<?php echo $values['BankAccountID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Account')" class="Blue" ><?= $delete ?></a>
                                       <?php }?>

				<a href="accountHistory2.php?accountID=<?=$values['BankAccountID']?>&accountType=<?=$values['AccountType']?>" target="_blank"><?=$history;?></a>								   
                                &nbsp;
                            </td>
                        </tr>


                    <?php 

         // $objBankAccount->GetSubChartAccountTree($AccountTypeID,$values['BankAccountID'],0); 
?>

<?php } // foreach end //  



  $groupAccountName=$objBankAccount->getRootGroupAccountByRange($RangeFromm);
$numGrp = sizeof( $groupAccountName);
       foreach($groupAccountName as $key=>$values){
          $AccountNamee1=$objBankAccount->getBankAccountWithGroupID($values['GroupID']);
     ?>
     <tr align="left"> 
        <td   height="20" ><?=ucwords($values['GroupName'])?> [Group]</td>
	<td  width="15%"> </td>    
	<td  width="15%"> </td>  
	<td  width="10%" <?=$Config['HideUnwanted']?>> </td>  

	 <td align="center" width="10%" <?=$Config['HideUnwanted']?>>   <a href="editGroupAccount2.php?edit=<?php echo $values['GroupID']; ?>" class="Blue"><?= $edit ?></a> 

<? if(sizeof($AccountNamee1)<=0){?>
<!--a href="editGroupAccount.php?del_id=<?php echo $values['GroupID']; ?>" class="Blue"><?= $delete ?></a-->
<? } ?>

</td>        
    </tr>
    
    <?php 
     
     $Balance=0;
     foreach($AccountNamee1 as $key=>$values4){       
   
	$ReceivedAmnt = $values4['ReceivedAmnt'];
	$PaidAmnt = $values4['PaidAmnt'];

	$Balance = $ReceivedAmnt-$PaidAmnt;



        ?>
     <tr align="left"> 
        <td   height="20" style="padding-left:20px;">


<?
if($Config['pop']==1){
	echo '<a href="Javascript:void(0)" onclick="Javascript:SetAccount(\''.$values4["BankAccountID"].'\',\''.ucwords($values4["AccountName"]).'\',\''.$values4["AccountNumber"].'\');" onMouseover="ddrivetip(\''.CLICK_TO_SELECT.'\', \'\',\'\')"; onMouseout="hideddrivetip()"><b>'.ucwords($values4["AccountName"]).'</b></a>';
}else{
	echo ucwords($values4['AccountName']);
}




if($values4['BankFlag'] == 1){
	echo '<br>[ Bank Acc No: '.$values4['BankAccountNumber'].' ]';
}

?>



</td>
        <td width="15%"><?=$values4['AccountNumber'];?></td>
         <td width="15%" align="right"><strong><?= number_format($Balance,2,'.',',');?></strong></td>
		
			     <td width="10%" align="center" <?=$Config['HideUnwanted']?>>
							 <?php
								if ($values4['Status'] == 'Yes') {
									$status = 'Active';
								} else {
									$status = 'InActive';
								}
                                                   if($Balance == 0 && $values4['CashFlag'] != 1) {                  
                                                       
                                                       $statusLink = 'editAccount2.php?active_id=' . $values4["BankAccountID"] . '&curP=' . $_GET["curP"] . '';
                                                   }else{
                                                       $statusLink = "javascript:void();";
                                                   }

                                            echo '<a href="'.$statusLink.'" class="'.$status.'">' . $status . '</a>';
                                            ?>
                            </td>
                   
                            <td width="10%" height="26" align="center" class="head1_inner" <?=$Config['HideUnwanted']?>>
				
                                   <!--a href="vAccount.php?view=<?=$values4['BankAccountID']?>&curP=<?=$_GET['curP']?>"><?=$view?></a-->

                              <?php if($Balance == 0 && $values4['CashFlag'] != 1) {?>
                                   <a href="editAccount2.php?edit=<?php echo $values4['BankAccountID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>

                                   <a href="editAccount2.php?del_id=<?php echo $values4['BankAccountID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Account')" class="Blue" ><?= $delete ?></a>
                                       <?php }?>

				<a href="accountHistory2.php?accountID=<?=$values4['BankAccountID']?>&accountType=<?=$values4['AccountType']?>" target="_blank"><?=$history;?></a>								   
                                &nbsp;
                            </td>
    </tr>
     <?php }
    $objBankAccount->getChartSubGroupAccountNew($values['GroupID'],0,$FromDate,$ToDate);
      
    }   ?> 








	<? if(empty($numBankAcc) &&  empty($numGrp)){?>
	<tr align="center">
	<td height="20" colspan="5"  class="no_record"><?=NO_RECORD;?></td>
	</tr>
	<? } ?>

		 
		<?php } 


} else {?>

	<tr align="center">
	<td height="20" colspan="6"  class="no_record"><?=NO_RECORD;?></td>
	</tr>

<?php }?>

           </tbody>    
            </table>
            </div>
</div>


        </td>
    </tr>
</table>
<input type="hidden" name="SelID" id="SelID" value="<?=$_GET["id"]?>">

<script type="text/javascript">
function SetAccount(BankAccountID,AccountName,AccountNumber){		
	ResetSearch();
	var SelID = $("#SelID").val();
	window.parent.document.getElementById("GlAccountID"+SelID).value=BankAccountID;
	window.parent.document.getElementById("GlAccount_"+SelID).value=AccountName+' ['+AccountNumber+']';

	parent.jQuery.fancybox.close();
	

}



function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#preview_div").hide();
}

function SetAccountType(AccountTypeID){
	
	var popv = Trim(document.getElementById("pop")).value;
	var url = 'viewAccount2.php?AccountTypeID='+AccountTypeID;
	if(popv==1){
		var SelID = $("#SelID").val();
		url = url+'&pop=1&id='+SelID;
		ResetSearch();
	}else{
		ShowHideLoader('1','F');
	}
	window.location = url;

}
</script>
