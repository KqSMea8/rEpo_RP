<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
	ShowHideLoader('1','L');
       }


    function SetDate(str){
        if(str == "Specific Date") {
            	$(".specificdaterange").show();
	     	$(".monthlyyearly").hide();
        }else if(str == "Monthly") {
		$(".specificdaterange").hide()
		$(".monthlyyearly").show();
	}else{
            	$(".specificdaterange").hide();
	    	$(".monthlyyearly").hide();
        }
    }




</script>



<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>

<?php if ($num7777 > 0) { ?>
    <a href="<?= $EmailUrl ?>" target="_blank" class="fancybox fancybox.iframe email_button" style="float:right;margin-left:5px;">Email</a>

    <a href="<?= $DownloadUrl ?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
    <input type="button" onclick="Javascript:window.location = '<?= $ExportUrl ?>';" value="Export To Excel" name="exp" class="export_button">
<?php } ?>
<div class="had"><?= $MainModuleName ?> Report</div>

<div class="message" align="center">

    <? if(!empty($_SESSION['mess_report_email'])) {echo $_SESSION['mess_report_email']; unset($_SESSION['mess_report_email']); }?>
</div>


<table width="100%" border=0 align="center" cellpadding=0 cellspacing=0>
    <?php if ($num > 0) { ?>
        <tr>
            <td align="left" valign="top" >
                <form onsubmit="return ValidateSearch();" name="form3" method="get" action="">
                    <table cellspacing="0" cellpadding="0" border="0" style="margin:0" id="search_table" >
                        <tbody>
                            <tr>
                                <!--td align="left">Transaction Date:</td>
                                <td align="left">
<select onchange="Javascript: SetDate(this.value);" id="TransactionDate" class="textbox" name="TransactionDate">
	<option value="All" <?php if ($_GET['TransactionDate'] == "All") {
	echo "selected";
	} ?>>All</option>
	<option value="Today" <?php if ($_GET['TransactionDate'] == "Today") {
	echo "selected";
	} ?>>Today</option>
	<option value="Last Week" <?php if ($_GET['TransactionDate'] == "Last Week") {
	echo "selected";
	} ?>>Last Week</option>
	<option value="Last Month" <?php if ($_GET['TransactionDate'] == "Last Month") {
	echo "selected";
	} ?>>Last Month</option>
	<option value="Last Three Month" <?php if ($_GET['TransactionDate'] == "Last Three Month") {
	echo "selected";
	} ?>>Last Three Month</option>
	<option value="Specific Date" <?php if ($_GET['TransactionDate'] == "Specific Date") {
	echo "selected";
	} ?>>Specific Date</option>
	<option value="Monthly" <?php if ($_GET['TransactionDate'] == "Monthly") {
	echo "selected";
	} ?>>Monthly</option>
</select>
                                </td-->

                                <td>

                                    <!--table cellspacing="0" cellpadding="0" border="0" class="specificdaterange">
                                        <tr>
                                            <td align="left">From:</td>
                                            <td align="left">
    <?php
    if (!empty($_GET['FromDate']) && $SpecificDate == 1) {
        $FromDate = $_GET['FromDate'];
    }
    ?>
                                                <script type="text/javascript">
                                                    $(function () {
                                                        $('#FromDate').datepicker(
                                                                {
                                                                    showOn: "both", dateFormat: 'yy-mm-dd',
                                                                    yearRange: '<?= date("Y") - 30 ?>:<?= date("Y") + 30 ?>',
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
                                                <input id="FromDate" name="FromDate" readonly="" value="<?= $FromDate ?>" class="inputbox" style="width: 120px;" type="text" maxlength="10" > 
                                            </td>


                                            <td align="left">To:</td>
    <?php
    if (!empty($_GET['ToDate']) && $SpecificDate == 1) {
        $ToDate = $_GET['ToDate'];
    }
    ?>
                                            <td> <script type="text/javascript">
                                                $(function () {
                                                    $('#ToDate').datepicker(
                                                            {
                                                                showOn: "both", dateFormat: 'yy-mm-dd',
                                                                yearRange: '<?= date("Y") - 30 ?>:<?= date("Y") + 30 ?>',
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
                                                <input id="ToDate" name="ToDate" readonly="" value="<?= $ToDate ?>" class="inputbox" style="width: 120px;" type="text" maxlength="10" > 
                                            </td>

                                        </tr>

                                    </table-->

				 



				<table cellspacing="0" cellpadding="0" border="0" class="monthlyyearly">
                                        <tr>
                                            <td align="left"><?=getMonths($_GET['m'],"m","textbox")?></td>
                                            <td align="left"><?=getYears($_GET['y'],"y","textbox")?></td>
                                       </tr>
                                </table>


				<script language="JavaScript1.2" type="text/javascript">
				//SetDate('<?=$_GET["TransactionDate"]?>');
				</script>




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
<?php } ?>
    <tr>
        <td  valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td  valign="top">	
            <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
            <div id="preview_div">
                <table cellspacing="1" cellpadding="3" width="700" align="center">
                                <?php if ($num > 0) { ?>    
                        <tr align="left">
                            <td width="10%"  align="center">

                                <span class="font18"><?= strtoupper($Config['SiteName']); ?></span><br>
                                <span class="font16">Profit and Loss</span><br>
                                <!--span class="font16">Balance as on <?= date($Config['DateFormat'], strtotime(date('Y-m-d'))); ?></span><br-->
                                <span class="font16">
    <?php if ($_GET['TransactionDate'] == "All") { ?>
                For All Dates
    <?php } else if ($_GET['TransactionDate'] == "Today") { ?>

        	For <?= date($Config['DateFormat'], strtotime($FromDate)); ?>

     <?php } else if($_GET['TransactionDate'] == "Monthly"){?>                  
                 For <?=date("F, Y", strtotime($FromDate));?>
		<?=$forPeriodHTML?>

    <?php } else { ?>  
                                        For the period From
                            <?= date($Config['DateFormat'], strtotime($FromDate)); ?> To <?= date($Config['DateFormat'], strtotime($ToDate)); ?>
                        <?php } ?>

                                </span>

                            </td>


                        </tr>

                        <tr><td class="border_bottom">&nbsp;</td></tr>  
<?php } else { ?>
                        <tr><td class="red">This report contains no data.</td></tr>  
<?php } ?>
                </table>
                <table cellspacing="1" cellpadding="3" width="700" align="center" >
                    <?php if ($num > 0) { ?>   
                        <tr>
                            <td colspan="3" valign="top" align="right" height="30"><b>All amounts stated in <?= $Config['Currency'] ?></b></td>
                        </tr>
                        <tr>
                            <td align="right" ></td>
                            <td align="right" width="200"><b>Period to Date</b></td>
                            <td align="right" width="200"><b>Year to Date</b></td>
                        </tr>
                    <?php
                    }


                    $PreviousDbtCrd = $objBankAccount->PreviousDebtCrdAmount($FromDate);
                   
                    if (is_array($arryAccountType) && $num > 0) {

                        $netDebitAmt = "";
                        $netCreditAmt = "";
                        ?>
                        <tr align="left"> 
                            <td height="20" colspan="3" class="font13"><b>INCOME</b></td>                           
                        </tr>
                        <?php
                        $arryAccountTypePLIncome = $objBankAccount->getAccountTypePLIncome();

                        foreach ($arryAccountTypePLIncome as $key => $values) {
                            $AccountTypeID = $values['AccountTypeID'];
                            $RangeFromm = $values['RangeFrom'];
                           

                            $ArryDbtCrdAmount = $objBankAccount->NetDebitCreditByAccountType($RangeFromm, $FromDate, $ToDate);

                            $NetIncome = ''; $NetIncomeYear = '';
			$AccountTypeLabel = $values['AccountType'];
                            ?> 
                            <tr align="left"> 
                                <td height="20" colspan="3">&nbsp;<b><?=$values['AccountType']; ?></b></td>
                              
                            </tr>
                            <?php
                            $netDebitAmt+=$ArryDbtCrdAmount["DbAmnt"];
                            $netCreditAmt+=$ArryDbtCrdAmount["CrAmnt"];
                            $rootBankAccountName = $objBankAccount->getBankAccountWithRoot($RangeFromm);

                            foreach ($rootBankAccountName as $key => $values) {

				$Config['CreditMinusDebit']=0;
				if($RangeFromm=='2000' || $RangeFromm=='3000' || $RangeFromm=='4000' || $RangeFromm=='7000'){
					$Config['CreditMinusDebit'] = 1;
				}				


                                $account_data = $objBankAccount->getTotalDebitCreditAmount($values['BankAccountID'], '', $FromDate, $ToDate);             

				$account_dataYear = $objBankAccount->getTotalDebitCreditAmount($values['BankAccountID'], '', $YearFromDate, $ToDate);                              

				if($Config['CreditMinusDebit']==1){
					$NetAmt = $account_data[0]["CrAmnt"] - $account_data[0]["DbAmnt"];
					$NetAmtYear = $account_dataYear[0]["CrAmnt"] - $account_dataYear[0]["DbAmnt"];
				}else{
					$NetAmt = $account_data[0]["DbAmnt"] - $account_data[0]["CrAmnt"];
					$NetAmtYear = $account_dataYear[0]["DbAmnt"] - $account_dataYear[0]["CrAmnt"];
				}
				$NetAmt = round($NetAmt,2) ;
				$NetAmtYear = round($NetAmtYear,2) ;
				                                 
                                $NetIncome += $NetAmt;
				$NetIncomeYear += $NetAmtYear;

				if(!empty($NetAmt) || !empty($NetAmtYear)){ //start row
                                ?>

                                <tr align="left"> 
                                    <td height="20" >&nbsp;&nbsp;&nbsp; <?= strtoupper($values['AccountName']); ?> </td>

                                    <td align="right">
<? 
if($NetAmt<0){
	$NetAmtVal = str_replace("-","",$NetAmt);
	echo "(".number_format($NetAmtVal, 2).")";
}else{
	echo number_format($NetAmt, 2);
} 
?>


</td>


  <td align="right" >
<? 
if($NetAmtYear<0){
	$NetAmtYearVal = str_replace("-","",$NetAmtYear);
	echo "(".number_format($NetAmtYearVal, 2).")";
}else{
	echo number_format($NetAmtYear, 2);
} 
?>


</td>
                                </tr>
                            <?
				} //end row



                            }
                            $groupAccountName = $objBankAccount->getGroupByAccountType($AccountTypeID);
                            foreach ($groupAccountName as $key => $values) {
                                $ArryDbtCrdAmount = $objBankAccount->NetDebitCreditByGroup($values['GroupID'], $FromDate, $ToDate);
                                ?>
                                <tr align="left"> 
                                    <td height="20" >&nbsp;&nbsp;&nbsp;<?= strtoupper($values['GroupName']); ?></td>
                                    <td align="right"><!--<?= number_format($ArryDbtCrdAmount["DbAmnt"], 2) ?>--></td>
                                    <td align="right" ><!--<?= number_format($ArryDbtCrdAmount["CrAmnt"], 2) ?>--></td>
                                </tr>

                                <?php
                                $AccountNamee1 = $objBankAccount->getBankAccountWithGroupID($values['GroupID']);

                                foreach ($AccountNamee1 as $key => $values4) {
					

					$Config['CreditMinusDebit']=0;
					if($RangeFromm=='2000' || $RangeFromm=='3000' || $RangeFromm=='4000' || $RangeFromm=='7000'){
						$Config['CreditMinusDebit'] = 1;
					}

					 


                                    $account_data = $objBankAccount->getTotalDebitCreditAmount($values4['BankAccountID'], '', $FromDate, $ToDate);
				    $account_dataYear = $objBankAccount->getTotalDebitCreditAmount($values4['BankAccountID'], '', $YearFromDate, $ToDate);

                                  

				if($Config['CreditMinusDebit']==1){
					$NetAmt = $account_data[0]["CrAmnt"] - $account_data[0]["DbAmnt"];
					$NetAmtYear = $account_dataYear[0]["CrAmnt"] - $account_dataYear[0]["DbAmnt"];
				}else{
					$NetAmt = $account_data[0]["DbAmnt"] - $account_data[0]["CrAmnt"];
					$NetAmtYear = $account_dataYear[0]["DbAmnt"] - $account_dataYear[0]["CrAmnt"];
				}


				$NetAmt = round($NetAmt,2);
				$NetAmtYear = round($NetAmtYear,2);
				

                                    $NetIncome += $NetAmt;
				    $NetIncomeYear += $NetAmtYear;

				     if(!empty($NetAmt) || !empty($NetAmtYear)){ //start row
                                    ?>



                                    <tr align="left"> 
                                        <td height="20" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= strtoupper($values4['AccountName']); ?> </td>
                                        <td align="right"> 
<?
if($NetAmt<0){
	$NetAmtVal = str_replace("-","",$NetAmt);
	echo "(".number_format($NetAmtVal, 2).")";
}else{
	echo number_format($NetAmt, 2);
}
?>

</td>
                                        <td align="right" >

<?
if($NetAmtYear<0){
	$NetAmtYearVal = str_replace("-","",$NetAmtYear);
	echo "(".number_format($NetAmtYearVal, 2).")";
}else{
	echo number_format($NetAmtYear, 2);
}
?>


</td>
                                    </tr>
                                <?php

					} //end row


                                }
                                $objBankAccount->getSubGroupAccount4ProftLoss($values['GroupID'], 0, $FromDate, $ToDate, 'INCOME');
                                $Total_sub_amount = $objBankAccount->TotalSubGroupAccount4ProftLoss($values['GroupID'], 0, $FromDate, $ToDate, 'INCOME', '');
				$Total_sub_amountYear = $objBankAccount->TotalSubGroupAccount4ProftLoss($values['GroupID'], 0, $YearFromDate, $ToDate, 'INCOME', '');



                                $NetIncome+=$Total_sub_amount;
				$NetIncomeYear+=$Total_sub_amountYear;
                                

                           }
                            ?> 

                            <tr style="padding-bottom: 30px;">
                                <td height="20"  class="border_top_bottom">&nbsp;&nbsp;&nbsp;<b>Total <?=(str_replace("Account","",$AccountTypeLabel))?></b></td>
                               
                                <td align="right" class="border_top_bottom"><b>

<?
if($NetIncome<0){
	$NetIncomeVal = str_replace("-","",$NetIncome);
	echo "(".number_format($NetIncomeVal, 2).")";
}else{
	echo number_format($NetIncome, 2);
}

if($RangeFromm == '5000') {
	$CostOfGood = $NetIncome;
	$CostOfGood = round($CostOfGood,2);
}

?>
</b></td>



<td align="right" class="border_top_bottom">
<b>
<?
if($NetIncomeYear<0){
	$NetIncomeYearVal = str_replace("-","",$NetIncomeYear);
	echo "(".number_format($NetIncomeYearVal, 2).")";
}else{
	echo number_format($NetIncomeYear, 2);
}

if($RangeFromm == '5000') {
	$CostOfGoodYear = $NetIncomeYear;
	$CostOfGoodYear = round($CostOfGoodYear,2);
}

?>

</b>
</td>
                            </tr>
                            <tr><td colspan="3" height="10"></td></tr>




	<? 
	if($RangeFromm != '5000'){		
		$TotalIncome+=$NetIncome;
		$TotalIncomeYear+=$NetIncomeYear;
	}



 if ($RangeFromm == '7000') {?>
	<tr align="left" > 
	    <td height="20" class="border_top_bottom font13"><b>Total Income</b></td>
	    <td align="right" class="border_top_bottom font13">
<b>

<?
$TotalIncome = round($TotalIncome,2);
if($TotalIncome<0){
	$TotalIncomeVal = str_replace("-","",$TotalIncome);
	echo "(".number_format($TotalIncomeVal, 2).")";
}else{
	echo number_format($TotalIncome, 2);
}
?>

</b></td>
	    <td align="right" class="border_top_bottom">
<b>

<?
$TotalIncomeYear = round($TotalIncomeYear,2);
if($TotalIncomeYear<0){
	$TotalIncomeYearVal = str_replace("-","",$TotalIncomeYear);
	echo "(".number_format($TotalIncomeYearVal, 2).")";
}else{
	echo number_format($TotalIncomeYear, 2);
}
?>


</b>



 </td>
	</tr>
<tr><td colspan="3" height="10"></td></tr>
	<? } 
       
    } // PL Income foreach end 
    ?>


   <tr align="left" > 
	    <td height="20" class="border_top_bottom font13"><b>GROSS PROFIT</b></td>
	    <td align="right" class="border_top_bottom font13"><b>

<?
$GrossIncome = $TotalIncome - $CostOfGood;
$GrossIncome = round($GrossIncome,2);

if($GrossIncome<0){
	$GrossIncomeVal = str_replace("-","",$GrossIncome);
	echo "(".number_format($GrossIncomeVal, 2).")";
}else{
	echo number_format($GrossIncome, 2);
}

?></b></td>
	    <td align="right" class="border_top_bottom"><b>

<?
$GrossIncomeYear = $TotalIncomeYear - $CostOfGoodYear;
$GrossIncomeYear = round($GrossIncomeYear,2);

if($GrossIncomeYear<0){
	$GrossIncomeYearVal = str_replace("-","",$GrossIncomeYear);
	echo "(".number_format($GrossIncomeYearVal, 2).")";
}else{
	echo number_format($GrossIncomeYear, 2);
}

?>



</b></td>
	</tr>
<tr><td colspan="3" height="10"  ></td></tr>             







                        <tr align="left"> 
                            <td height="20" class="font13"><b>EXPENSE</b></td>
                            <td align="right" > </td>
                            <td align="right" > </td>
                        </tr>
                        <?php
                        $arryAccountTypePLExpense = $objBankAccount->getAccountTypePLExpense();

                        foreach ($arryAccountTypePLExpense as $key => $values) {
                            $AccountTypeID = $values['AccountTypeID'];
                            $RangeFromm = $values['RangeFrom'];
                         
                            $ArryDbtCrdAmount = $objBankAccount->NetDebitCreditByAccountType($RangeFromm, $FromDate, $ToDate);

                            $NetExpense = ''; $NetExpenseYear = '';

				$AccountTypeLabel = $values['AccountType'];
                            ?> 
                            <tr align="left"> 
                                <td height="20">&nbsp;<b><?= $values['AccountType']; ?></b></td>
                                <td align="right" > </td>
                                <td align="right" > </td>
                            </tr>
                            <?php
                            $netDebitAmt+=$ArryDbtCrdAmount["DbAmnt"];
                            $netCreditAmt+=$ArryDbtCrdAmount["CrAmnt"];
                            $rootBankAccountName = $objBankAccount->getBankAccountWithRoot($RangeFromm);

                            foreach ($rootBankAccountName as $key => $values) {

				

                                $account_data = $objBankAccount->getTotalDebitCreditAmount($values['BankAccountID'], '', $FromDate, $ToDate);
				$account_dataYear = $objBankAccount->getTotalDebitCreditAmount($values['BankAccountID'], '', $YearFromDate, $ToDate);
				
                                $NetAmt = $account_data[0]["DbAmnt"] - $account_data[0]["CrAmnt"];
				$NetAmtYear = $account_dataYear[0]["DbAmnt"] - $account_dataYear[0]["CrAmnt"];


				$NetAmt = round($NetAmt,2) ;
				$NetAmtYear = round($NetAmtYear,2) ;
				
                                $NetExpense+=$NetAmt;
				$NetExpenseYear+=$NetAmtYear;

				 if(!empty($NetAmt) || !empty($NetAmtYear)){ //start row
                                ?>

                                <tr align="left"> 
                                    <td height="20" >&nbsp;&nbsp;&nbsp;<?= strtoupper($values['AccountName']); ?></td> 

                                    <td align="right" >

<?
if($NetAmt<0){
	$NetAmtVal = str_replace("-","",$NetAmt);
	echo "(".number_format($NetAmtVal, 2).")";
}else{
	echo number_format($NetAmt, 2);
}
?>


</td>
                                    <td align="right" >

<?
if($NetAmtYear<0){
	$NetAmtYearVal = str_replace("-","",$NetAmtYear);
	echo "(".number_format($NetAmtYearVal, 2).")";
}else{
	echo number_format($NetAmtYear, 2);
}
?>


</td>
                                </tr>
                            <?
				}//end row



                            }



 


                            $groupAccountName = $objBankAccount->getGroupByAccountType($AccountTypeID);
                            foreach ($groupAccountName as $key => $values) {
                                $ArryDbtCrdAmount = $objBankAccount->NetDebitCreditByGroup($values['GroupID'], $FromDate, $ToDate);
                                ?>
                                <tr align="left"> 
                                    <td height="20" >&nbsp;&nbsp;&nbsp;<?= strtoupper($values['GroupName']); ?></td>
                                    <td width=""  align="right"><!--<?= number_format($ArryDbtCrdAmount["DbAmnt"], 2) ?>--></td>
                                    <td align="right" ><!--<?= number_format($ArryDbtCrdAmount["CrAmnt"], 2) ?>--></td>
                                </tr>

                                <?php
                                $AccountNamee1 = $objBankAccount->getBankAccountWithGroupID($values['GroupID']);

                                foreach ($AccountNamee1 as $key => $values4) {

				


                                    $account_data = $objBankAccount->getTotalDebitCreditAmount($values4['BankAccountID'], '', $FromDate, $ToDate);
                                   $account_dataYear = $objBankAccount->getTotalDebitCreditAmount($values4['BankAccountID'], '', $YearFromDate, $ToDate);


                $NetAmt = $account_data[0]["DbAmnt"] - $account_data[0]["CrAmnt"];
		$NetAmtYear = $account_dataYear[0]["DbAmnt"] - $account_dataYear[0]["CrAmnt"];


		$NetAmt = round($NetAmt,2) ;
		$NetAmtYear = round($NetAmtYear,2) ;

                $NetExpense+=$NetAmt;
		$NetExpenseYear+=$NetAmtYear;

		 if(!empty($NetAmt) || !empty($NetAmtYear)){ //start row
                ?>
                                    <tr align="left"> 
                                        <td height="20" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= strtoupper($values4['AccountName']); ?></td>
                                        <td width="" align="right">

				<?
				if($NetAmt<0){
					$NetAmtVal = str_replace("-","",$NetAmt);
					echo "(".number_format($NetAmtVal, 2).")";
				}else {
					echo number_format($NetAmt, 2);
				}
				?>


				</td>
                                        <td align="right" >
				<?
				if($NetAmtYear<0){
					$NetAmtYearVal = str_replace("-","",$NetAmtYear);
					echo "(".number_format($NetAmtYearVal, 2).")";
				}else {
					echo number_format($NetAmtYear, 2);
				}
				?>



</td>
                                    </tr>
                                <?php
					}//end row



                                }
                                $objBankAccount->getSubGroupAccount4ProftLoss($values['GroupID'], 0, $FromDate, $ToDate, 'EXPENSES');
                                $Total_sub_amount = $objBankAccount->TotalSubGroupAccount4ProftLoss($values['GroupID'], 0, $FromDate, $ToDate, 'EXPENSES', '');

				$Total_sub_amountYear = $objBankAccount->TotalSubGroupAccount4ProftLoss($values['GroupID'], 0, $YearFromDate, $ToDate, 'EXPENSES', '');


                                $NetExpense+=$Total_sub_amount;
				 $NetExpenseYear+=$Total_sub_amountYear;
                              

        
        }


        
        ?> 




                            <tr style="padding-bottom: 30px;">
                                <td height="20"  class="border_top_bottom font13">&nbsp;&nbsp;&nbsp;<b>Total <?=(str_replace("Account","",$AccountTypeLabel))?></b>
 

</td>
                             
                                <td align="right" class="border_top_bottom font13"><b>

<?
if($NetExpense<0){
	$NetExpenseVal = str_replace("-","",$NetExpense);
	echo "(".number_format($NetExpenseVal, 2).")";
}else{
	echo number_format($NetExpense, 2);
}
?>



                           
                                    </b></td>
                                <td align="right" class="border_top_bottom"><b>
<?
if($NetExpenseYear<0){
	$NetExpenseYearVal = str_replace("-","",$NetExpenseYear);
	echo "(".number_format($NetExpenseYearVal, 2).")";
}else{
	echo number_format($NetExpenseYear, 2);
}
?>

</b>
 </td>
                            </tr>
                            <tr><td colspan="3">&nbsp;</td></tr>

        <?php
        
        
       $GrossExpense+=$NetExpense;
       $GrossExpenseYear+=$NetExpenseYear; 
    } // PL Expense foreach end 
    
}
?>
                    <br><br>

<?php
/*********************************/
if ($GrossIncome > $GrossExpense) {
    $PLText = "NET INCOME";
    $DifferAmount = ($GrossIncome - $GrossExpense);
    $GrossTotal = $GrossIncome;
    $OtherText = 'Total Expense';
    $OtherAmount = $GrossExpense;
    $PrefixSymbol = '';
    $DifferAmountTxt = number_format($DifferAmount, 2);

} else if ($GrossExpense > $GrossIncome) {

    $PLText = "NET INCOME";
    $DifferAmount = ($GrossExpense - $GrossIncome);
    $GrossTotal = $GrossExpense;
    $OtherText = 'Total Income';
    $OtherAmount = $GrossIncome;
    $PrefixSymbol = ''; //$PrefixSymbol = "[-]";
    $DifferAmountTxt = "(".number_format($DifferAmount, 2).")";
    
} else if ($GrossIncome == $GrossExpense) {
    $PLText = "No Profit, No Loss";
    $DifferAmountTxt = '0.00';
    $OtherText = 'Total Income';
    $OtherAmount = $GrossIncome;
    $GrossTotal = $GrossIncome;
    $PrefixSymbol = '';
}
/*********************************/
/*********************************/
if ($GrossIncomeYear > $GrossExpenseYear) { 
    $DifferAmountYear = ($GrossIncomeYear - $GrossExpenseYear);
    $DifferAmountTxtYear = number_format($DifferAmountYear, 2);
} else if ($GrossExpenseYear > $GrossIncomeYear) { 
    $DifferAmountYear = ($GrossExpenseYear - $GrossIncomeYear);
    $DifferAmountTxtYear = "(".number_format($DifferAmountYear, 2).")";
    
} else if ($GrossIncomeYear == $GrossExpenseYear) { 
    $DifferAmountTxtYear = '0.00';
}


?>  
                    <br><br>
                    <tr >
                        <td height="20" class="font15"><b><?= $PLText ?></b></td>
                        <td align="right" class="font15"><b><?=$DifferAmountTxt?></b></td>
                        <td align="right" class="font15"><b><?=$DifferAmountTxtYear?></b></td>
                    </tr> 
                    <!--tr>
                        <td height="20" class="font15"><b><?= $OtherText ?></b></td>
                        <td align="right" class="font15"><b><?= number_format($OtherAmount, 2) ?></b></td>
                        <td align="right" ></td>
                    </tr> 
                    <tr>
                        <td height="20" class="font15"><b>Gross Total</b></td>
                        <td align="right" class="font15"><b><?= number_format($GrossTotal, 2) ?></b></td>
                        <td align="right"></td>
                    </tr--> 
                </table>
            </div> 

        </td>
    </tr>
</table>
