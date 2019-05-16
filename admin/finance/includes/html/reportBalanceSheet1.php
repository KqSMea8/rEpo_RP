<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1','L');
}


function SetDate(str)
{
    
    if(str == "Specific Date"){
        $(".specificdaterange").show(1000);
        
    }else{
        
        $(".specificdaterange").hide(1000);
    }
}
   
   

</script>
<style>
.hidetr{
	display:none;
}
</style>


<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
<?php if($num777 > 0){?>
<a href="<?=$EmailUrl?>" target="_blank" class="fancybox fancybox.iframe add" style="float:right;margin-left:5px;">Email</a>

<a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
<input type="button" onclick="Javascript:window.location = '<?=$ExportUrl?>';" value="Export To Excel" name="exp" class="export_button">
    <?php }?>
<div class="had"><?=$MainModuleName?> Report</div>

<div class="message" align="center">
 
<? if(!empty($_SESSION['mess_report_email'])) {echo $_SESSION['mess_report_email']; unset($_SESSION['mess_report_email']); }?>
</div>


<table width="100%" border=0 align="center" cellpadding=0 cellspacing=0>
    <?php if($num > 0){?>
	<tr>
        <td align="left" valign="top">
         <form onsubmit="return ValidateSearch();" name="form3" method="get" action="">
	<table cellspacing="0" cellpadding="0" border="0" style="margin:0" id="search_table">
	<tbody>
            <tr>
            <td align="left">Transaction Date:</td>
             <td align="left">
            <select onchange="Javascript: SetDate(this.value);" id="TransactionDate" class="inputbox" name="TransactionDate">
                                    <option value="All" <?php if($_GET['TransactionDate'] == "All"){echo "selected";}?>>All</option>
                                    <option value="Today" <?php if($_GET['TransactionDate'] == "Today"){echo "selected";}?>>Today</option>
                                    <option value="Last Week" <?php if($_GET['TransactionDate'] == "Last Week"){echo "selected";}?>>Last Week</option>
                                    <option value="Last Month" <?php if($_GET['TransactionDate'] == "Last Month"){echo "selected";}?>>Last Month</option>
                                    <option value="Last Three Month" <?php if($_GET['TransactionDate'] == "Last Three Month"){echo "selected";}?>>Last Three Month</option>
                                    <option value="Specific Date" <?php if($_GET['TransactionDate'] == "Specific Date" || $_GET['TransactionDate'] == ""){echo "selected";}?>>Specific Date</option>
                                   </select>
             </td>
             
             <td>
                 
                 <table cellspacing="0" cellpadding="0" border="0" <?php if($_GET['TransactionDate'] == "Specific Date" || $_GET['TransactionDate'] == "") {?> style="display: block;" <?php } else{?> style="display: none;" <?php }?> class="specificdaterange">
                     <tr>
                         <td align="left">From:</td>
             <td align="left">
                     <?php
                     if(!empty($_GET['FromDate'])  && $SpecificDate==1){
                      $FromDate = $_GET['FromDate'];
                     }
                     
                     ?>
		<script type="text/javascript">
					$(function() {
						$('#FromDate').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#FromDate").on("click", function () { 
								 $(this).val("");
							}
						);
					});
					</script>
					<input id="FromDate" name="FromDate" readonly="" value="<?=$FromDate?>" class="inputbox" style="width: 120px;" type="text" maxlength="10" > 
		</td>
		
		 
		 <td align="left">To:</td>
                  <?php
                     if(!empty($_GET['ToDate'])  && $SpecificDate==1){
                      $ToDate = $_GET['ToDate'];
                     }
                     
                     ?>
		 <td> <script type="text/javascript">
					$(function() {
						$('#ToDate').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#ToDate").on("click", function () { 
								 $(this).val("");
							}
						);

					});
					</script>
					<input id="ToDate" name="ToDate" readonly="" value="<?=$ToDate?>" class="inputbox" style="width: 120px;" type="text" maxlength="10" > 
                 </td>
                         
                     </tr>
                     
                 </table>
                 
             </td>
        
             
                 <td>
		 <input type="submit" value="Go" class="search_button" name="s">
		 
		
		 </td>
	 
		
	</tr>
			

</tbody>
        </table>
                 </form>
	
		</td>
      </tr>
      <?php }?>
	 <tr>
             <td  valign="top">&nbsp;</td>
         </tr>
	<tr>
	  <td  valign="top">
	


<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
    <table cellspacing="1" cellpadding="3"  width="70%" align="center">
     <?php if($num > 0){?>    
      <tr align="left">
        <td width="10%"  align="center">
         
            <span class="font18"><?=strtoupper($Config['SiteName']);?></span><br>
            <span class="font16">Balance Sheet</span><br>
            <span class="font16">Balance as on <?=date($Config['DateFormat'], strtotime(date('Y-m-d')));?></span><br>
            <span class="font16">
                <?php if($_GET['TransactionDate'] == "All"){?>
                 For All Dates
            <?php } else if($_GET['TransactionDate'] == "Today"){?>
                  
                 For <?=date($Config['DateFormat'], strtotime($FromDate));?>
            <?php } else {?>  
                 For the period From
            <?=date($Config['DateFormat'], strtotime($FromDate));?> To <?=date($Config['DateFormat'], strtotime($ToDate));?>
            <?php }?>
           
           </span>
            
        </td>
		
		
    </tr>
    
    <tr><td class="border_bottom">&nbsp;</td></tr>  
     <?php } else { ?>
    <tr><td class="red">This report contains no data.</td></tr>  
     <?php }?>
    </table>
<table cellspacing="1" cellpadding="3" width="70%" align="center">
  <?php if($num > 0){?>   
 <tr>
	 <td>&nbsp;</td>       
        <td colspan="3" height="30" align="left" ><b>All amounts stated in <?=$Config['Currency']?></b></td>
 </tr>
 <tr>
        <td  width="10%">&nbsp;</td>       
        <td align="right" colspan="2"><b>Net Balance</b></td>
	<td  width="20%">&nbsp;</td>
 </tr>
        <?php } 
        
$HeadAsset = "Assets";
$HeadLiability = "Liabilities";
$HeadEquity = "Stockholders' Equity";  
$HeadLiabilityEquity = $HeadLiability." and ".$HeadEquity;

   
//$PreviousDbtCrd=$objBankAccount->PreviousDebtCrdAmount($FromDate);
     

  if(is_array($arryAccountType) && $num>0){
      
     /* $netDebitAmt="";
      $netCreditAmt="";
      */
  	foreach($arryAccountType as $key=>$values){

		$AccountTypeID = $values['AccountTypeID']; 
		$RangeFromm = $values['RangeFrom']; 

		//$ArryDbtCrdAmount=$objBankAccount->NetDebitCreditByAccountType($RangeFromm,$FromDate,$ToDate);


	 if($RangeFromm==1000){  $AccountType = $HeadAsset; $align = 'align="center"'; $font='font15';}
	 else  if($RangeFromm==2000) { $AccountType = $HeadLiability; $align = ''; $font='font13 hidetr';}
	  else  if($RangeFromm==3000) {  $AccountType = $HeadEquity; $align = ''; $font='font13';}
  ?>
   
  <tr align="left"> 
	 <td>&nbsp;</td>
    <td height="30" class="<?=$font?>" colspan="3" <?=$align55?> ><b><?=$AccountType?> </b></td>
      
  </tr>
    <?php


      /*$netDebitAmt+=$ArryDbtCrdAmount["DbAmnt"];
      $netCreditAmt+=$ArryDbtCrdAmount["CrAmnt"];*/
      $rootBankAccountName=$objBankAccount->getBankAccountWithRoot($RangeFromm);
      $TotalAccountBalance=0;
       foreach($rootBankAccountName as $key=>$values){

		$ReFlag=0;
		/**********Current Retained Earnings************/
		if($RetainedEarning>0 && $values['BankAccountID']==$RetainedEarning && $CurrentPeriod!=''){
			

			//Reset for Retained Earnings
			$NettBalance=0;
			$BeginningBalance=$objBankAccount->getBeginningBalance($values['BankAccountID'],$CurrentPeriod);
			$NettBalance = $BeginningBalance + $PnLAmount_RE;			
			$TotalAccountBalance+=$NettBalance;

			/************************/

			$accountdataRE =$objBankAccount->getTotalDebitCreditAmount($values['BankAccountID'],'',$FromDate,$ToDate);
			$NettBalanceRE=($accountdataRE[0]['CrAmnt']-$accountdataRE[0]['DbAmnt']) + $PnLAmount_CurrentRE ;// -  $NettBalance;
			$TotalAccountBalance+=$NettBalanceRE;
			if($NettBalanceRE<0){
				$NettBalanceREVal = str_replace("-","",$NettBalanceRE);
				//$NettBalanceREVal = number_format($NettBalanceREVal, 2);
				$NettBalanceREVal = "(".number_format($NettBalanceREVal, 2).")";
			}else{
				$NettBalanceREVal = number_format($NettBalanceRE, 2);
			}
			 echo ' <tr align="left"> 
				<td height="20"> '.$values['AccountNumber'].'</td>
				<td>CURRENT YEAR RETAINED EARNINGS</td>
				<td align="right">'.$NettBalanceREVal.'</td> 
				<td></td>
				</tr>';

			$ReFlag=1;

			
		}
		/*************************************/

		if($ReFlag==0){
			$BeginningBalance=$objBankAccount->getBeginningBalance($values['BankAccountID'],$FromDate);
			$NettBalance = $BeginningBalance;

			$account_data=$objBankAccount->getTotalDebitCreditAmount($values['BankAccountID'],'',$FromDate,$ToDate);
			 
			$NettBalance+=round(($account_data[0]['DbAmnt']-$account_data[0]['CrAmnt']),2);
			//$TotalAccountBalance+=$NettBalance; //pk7
		}


     ?>
    
    <tr align="left"> 
        <td height="20"><?=$values['AccountNumber']?> </td>
        <td><? echo strtoupper($values['AccountName']); ?></td>
 
        <td align="right"> 
<?  

if($NettBalance<0){
	$NettBalanceVal = str_replace("-","",$NettBalance); 
	if($AccountTypeID==2 || $AccountTypeID==3){
		echo number_format($NettBalanceVal, 2);
		if($ReFlag==0){ $NettBalance = -$NettBalance;}
	}else{
		echo "(".number_format($NettBalanceVal, 2).")";
	}
	//echo "(".number_format($NettBalanceVal, 2).")";
}else{
	echo number_format($NettBalance, 2);
}

$TotalAccountBalance+=$NettBalance; 

?>
</td>
	<td>&nbsp;</td>
    </tr>
       <?php }

	$groupAccountName=$objBankAccount->getGroupByAccountType($AccountTypeID);
       foreach($groupAccountName as $key_gr=>$values_gr){  //start group  
		$grBankAccountName=$objBankAccount->getBankAccountWithGroupID($values_gr['GroupID']);      
     ?>
     <tr align="left"> 
	<td>&nbsp;</td>
        <td height="20" ><b><?=ucwords($values_gr['GroupName'])?></b></td>
       <td colspan="2">&nbsp;</td>
    </tr>
    <? 
	$GroupTotal = 0;
	foreach($grBankAccountName as $key2=>$values2){ //start inner account group

		$BeginningBalance=$objBankAccount->getBeginningBalance($values2['BankAccountID'],$FromDate);
		$NettBalance = $BeginningBalance;

		$account_data=$objBankAccount->getTotalDebitCreditAmount($values2['BankAccountID'],'',$FromDate,$ToDate);
		$NettBalance+=round(($account_data[0]['DbAmnt']-$account_data[0]['CrAmnt']),2);
		//$TotalAccountBalance+=$NettBalance; //pk7
		//$GroupTotal+=$NettBalance; //pk7
	?>
		<tr align="left"> 

		<td height="20" ><?=$values2['AccountNumber']?></td>
		<td><? echo strtoupper($values2['AccountName']); ?></td>


		<td align="right">  
		<?  
		if($NettBalance<0){
			$NettBalanceVal = str_replace("-","",$NettBalance);
			
			if($AccountTypeID==2 || $AccountTypeID==3){
				echo number_format($NettBalanceVal, 2);
				$NettBalance = -$NettBalance;
			}else{
				echo "(".number_format($NettBalanceVal, 2).")";
			}
		
		}else{
			echo number_format($NettBalance, 2);
		}

		$TotalAccountBalance+=$NettBalance;
		$GroupTotal+=$NettBalance;


		?>
		</td>
		<td colspan="2">&nbsp;</td>
		</tr>


   <? 	}//end inner account group 

?>
    <tr>
	<td class="border_top_bottom">&nbsp;</td>
        <td height="20"  class="border_top_bottom"><b>Total <?=ucwords($values_gr['GroupName'])?></b></td>
       <td class="border_top_bottom">&nbsp;</td>
        <td align="right" class="border_top_bottom">
<b>
<?

if($GroupTotal<0){
	$GroupTotalVal = str_replace("-","",$GroupTotal);
	
	if($AccountTypeID==2 || $AccountTypeID==3){
		echo number_format($GroupTotalVal, 2);
	}else{
		echo "(".number_format($GroupTotalVal, 2).")";
	}

}else{
	echo number_format($GroupTotal, 2);
}





?>
</b>
	</td>
    </tr>

 <tr><td colspan="4">&nbsp;</td></tr>

<? } //end group  

  ?>
       
    <tr>
	<td class="border_top_bottom">&nbsp;</td>
        <td height="20"  class="border_top_bottom font15"  ><b>Total <?=$AccountType?></b></td>
        <td class="border_top_bottom">&nbsp;</td>
        <td align="right" class="border_top_bottom font15">

<b><?=$Config['CurrencySymbol']?> 
<?
$arryAssetTotal[] = $TotalAccountBalance;
if($TotalAccountBalance<0){
	$TotalAccountBalanceVal = str_replace("-","",$TotalAccountBalance);
	
	if($AccountTypeID==2 ){
		echo number_format($TotalAccountBalanceVal, 2);
	}else{
		echo "(".number_format($TotalAccountBalanceVal, 2).")";
	}

	
}else{
	echo number_format($TotalAccountBalance, 2);
}

?>
</b>


</td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>

	
   <? 
if($RangeFromm==1000){?>
    <tr>
	<td>&nbsp;</td>
        <td height="30"  class="font15" colspan="3" align="left"><b><?=$HeadLiabilityEquity?></b></td>
     
    </tr>

   <? } ?>

    
    
<?php
    } // foreach end //


?>
    
    <tr style="padding-bottom: 30px;">
	<td class="border_top_bottom">&nbsp;</td>
        <td height="20"  class="border_top_bottom font15"><b>Total <?=$HeadLiabilityEquity?></b></td>
       <td class="border_top_bottom">&nbsp;</td>
        <td align="right" class="border_top_bottom font15">

<b><?=$Config['CurrencySymbol']?>  
<?

$AssetTotal = $arryAssetTotal[1]+$arryAssetTotal[2];
if($AssetTotal<0){
	$AssetTotalVal = str_replace("-","",$AssetTotal);
	//echo "(".number_format($AssetTotalVal, 2).")";
	echo number_format($AssetTotalVal, 2);
}else{
	echo number_format($AssetTotal, 2);
}

?>
</b>


</td>
    </tr>



    
    <?php } ?>
    
  
   
  </table>
  </div> 

</td>
</tr>
</table>
