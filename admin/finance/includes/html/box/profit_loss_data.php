<?php
$Config['ExportContent'] = '';
if(!empty($ExportFile)){
	$Config['AccPrefix'] = '&#160;';
}else{
	$Config['AccPrefix'] = '&nbsp;';
}

$AccPrefix3='';
for($i=0;$i<3;$i++){
	$AccPrefix3 .= $Config['AccPrefix'];
}
$AccPrefix6='';
for($i=0;$i<6;$i++){
	$AccPrefix6 .= $Config['AccPrefix'];
}
/********************/
(empty($TotalIncome))?($TotalIncome=""):("");
(empty($TotalIncomeYear))?($TotalIncomeYear=""):("");
(empty($GrossExpense))?($GrossExpense=""):("");
(empty($GrossExpenseYear))?($GrossExpenseYear=""):("");

/********************/

	$content = '<table cellspacing="1" cellpadding="3" width="700" align="center">';
	if ($num > 0) {   
		$content .= '<tr>
		<td colspan="3" align="center">

		<span class="font18">'.strtoupper($Config['SiteName']).'</span><br>
		<span class="font16">Profit and Loss</span><br>
		<span class="font16">';
		if ($_GET['TransactionDate'] == "All") { 
		$content .= 'For All Dates';
		} else if ($_GET['TransactionDate'] == "Today") { 

		$content .= 'For  '.date($Config['DateFormat'], strtotime($FromDate)).'';

		} else if($_GET['TransactionDate'] == "Monthly"){                
		$content .= 'For '.date("F, Y", strtotime($FromDate)).'
		'.$forPeriodHTML.'';

		} else { 
		$content .= 'For the period From
		'.date($Config['DateFormat'], strtotime($FromDate)).' To '.date($Config['DateFormat'], strtotime($ToDate)).'';
		} 

		$content .= '</span>
		</td>
		</tr>

		<tr><td colspan="3" class="border_bottom">&nbsp;</td></tr>';  
	} else { 
		$content .= '<tr><td colspan="3" class="red">This report contains no data.</td></tr>';  
	} 


               
	if ($num > 0) { 
		$content .= '<tr>
		<td colspan="3" valign="top" align="right" height="30"><b>All amounts stated in '.$Config['Currency'] .'</b></td>
		</tr>
		<tr>
		<td align="right" ></td>
		<td align="right" width="200"><b>Period to Date</b></td>
		<td align="right" width="200"><b>Year to Date</b></td>
		</tr>';
	}


   #$PreviousDbtCrd = $objBankAccount->PreviousDebtCrdAmount($FromDate);
                   
       if (is_array($arryAccountType) && $num > 0) {

                        $netDebitAmt = "";
                        $netCreditAmt = "";
                      
                         $content .= '<tr align="left"> 
                            <td height="20" colspan="3" class="font13"><b>INCOME</b></td>                           
                        </tr>';
                        
                        $arryAccountTypePLIncome = $objBankAccount->getAccountTypePLIncome();

		foreach ($arryAccountTypePLIncome as $key => $values) {
			$AccountTypeID = $values['AccountTypeID'];
			$RangeFromm = $values['RangeFrom'];


			$ArryDbtCrdAmount = $objBankAccount->NetDebitCreditByAccountType($RangeFromm, $FromDate, $ToDate);

			$NetIncome = ''; $NetIncomeYear = '';
			$AccountTypeLabel = $values['AccountType'];
                          
                             $content .= '<tr align="left"> 
                                <td height="20" colspan="3">&nbsp;<b>'.$values['AccountType'].'</b></td>
                              
                            </tr>';
                          
                            $netDebitAmt+=$ArryDbtCrdAmount["DbAmnt"];
                            $netCreditAmt+=$ArryDbtCrdAmount["CrAmnt"];
                            $rootBankAccountName = $objBankAccount->getBankAccountWithRoot($RangeFromm);

                            foreach ($rootBankAccountName as $key => $values) {

				$Config['CreditMinusDebit']=0;
				if($RangeFromm=='2000' || $RangeFromm=='3000' || $RangeFromm=='4000' || $RangeFromm=='7000'){
					$Config['CreditMinusDebit'] = 1;
				}				


                                $account_data = $objBankAccount->getTotalDebitCreditAmount($values['BankAccountID'], '', $FromDate, $ToDate);             

				$account_dataYear = $objBankAccount->getBeginningBalanceRange($values['BankAccountID'], '', $YearFromDate, $FromDate);                              
 
				if($Config['CreditMinusDebit']==1){
					$NetAmt = $account_data[0]["CrAmnt"] - $account_data[0]["DbAmnt"];
					$NetAmtYear = $account_dataYear[0]["CrAmnt"] - $account_dataYear[0]["DbAmnt"];
				}else{
					$NetAmt = $account_data[0]["DbAmnt"] - $account_data[0]["CrAmnt"];
					$NetAmtYear = $account_dataYear[0]["DbAmnt"] - $account_dataYear[0]["CrAmnt"];
				}

				$NetAmt = round($NetAmt,2) ;
				$NetAmtYear = round(($NetAmtYear + $NetAmt),2);
				                                
                                $NetIncome += $NetAmt;
				$NetIncomeYear += $NetAmtYear;

				if(!empty($NetAmt) || !empty($NetAmtYear)){ //start row
                               

                                 $content .= '<tr align="left"> 
                                    <td height="20" > '. $AccPrefix3. strtoupper($values['AccountName']).' </td>

                                    <td align="right">';
		
if($NetAmt<0){
	$NetAmtVal = str_replace("-","",$NetAmt);
	$content .= "(".number_format($NetAmtVal, 2).")";
}else{
	$content .= number_format($NetAmt, 2);
} 

 $content .= '</td>
  <td align="right" >';

if($NetAmtYear<0){
	$NetAmtYearVal = str_replace("-","",$NetAmtYear);
	$content .= "(".number_format($NetAmtYearVal, 2).")";
}else{
	$content .= number_format($NetAmtYear, 2);
}  

 $content .= '</td>
                                </tr>';
                          
				} //end row

                            }
                            $groupAccountName = $objBankAccount->getGroupByAccountType($AccountTypeID);
                            foreach ($groupAccountName as $key => $values) {
                                $ArryDbtCrdAmount = $objBankAccount->NetDebitCreditByGroup($values['GroupID'], $FromDate, $ToDate);
                               
                                 $content .= '<tr align="left"> 
                                    <td height="20" colspan="3"><b>'.$AccPrefix3.strtoupper($values['GroupName']).'</b></td>
                                </tr>';

                                $AccountNamee1 = $objBankAccount->getBankAccountWithGroupID($values['GroupID']);
				 
                                foreach ($AccountNamee1 as $key => $values4) {
					

					$Config['CreditMinusDebit']=0;
					if($RangeFromm=='2000' || $RangeFromm=='3000' || $RangeFromm=='4000' || $RangeFromm=='7000'){
						$Config['CreditMinusDebit'] = 1;
					}

					 


                                    $account_data = $objBankAccount->getTotalDebitCreditAmount($values4['BankAccountID'], '', $FromDate, $ToDate);
				    $account_dataYear = $objBankAccount->getBeginningBalanceRange($values4['BankAccountID'], '', $YearFromDate, $FromDate);

                                  

				if($Config['CreditMinusDebit']==1){
					$NetAmt = $account_data[0]["CrAmnt"] - $account_data[0]["DbAmnt"];
					$NetAmtYear = $account_dataYear[0]["CrAmnt"] - $account_dataYear[0]["DbAmnt"];
				}else{
					$NetAmt = $account_data[0]["DbAmnt"] - $account_data[0]["CrAmnt"];
					$NetAmtYear = $account_dataYear[0]["DbAmnt"] - $account_dataYear[0]["CrAmnt"];
				}


				$NetAmt = round($NetAmt,2);
				$NetAmtYear = round(($NetAmtYear + $NetAmt),2);
				

                                    $NetIncome += $NetAmt;
				    $NetIncomeYear += $NetAmtYear;

				     if(!empty($NetAmt) || !empty($NetAmtYear)){ //start row


                                     $content .= '<tr align="left"> 
                                        <td height="20" >'.$AccPrefix6.strtoupper($values4['AccountName']).' </td>
                                        <td align="right">'; 
if($NetAmt<0){
	$NetAmtVal = str_replace("-","",$NetAmt);
	$content .= "(".number_format($NetAmtVal, 2).")";
}else{
	$content .= number_format($NetAmt, 2);
}


 $content .= '</td><td align="right" >';


if($NetAmtYear<0){
	$NetAmtYearVal = str_replace("-","",$NetAmtYear);
	$content .= "(".number_format($NetAmtYearVal, 2).")";
}else{
	$content .= number_format($NetAmtYear, 2);
}
 $content .= '</td>
                                    </tr>';
                                

					} //end row


                                }
				$Config['ExportContent'] = '';
                                $objBankAccount->getSubGroupProftLoss($values['GroupID'], 0, $FromDate, $ToDate, 'INCOME');
				$content .= $Config['ExportContent']; 



                                $Total_sub_amount = $objBankAccount->TotalSubGroupAccount4ProftLoss($values['GroupID'], 0, $FromDate, $ToDate, 'INCOME', '');
				$Total_sub_amountYear = $objBankAccount->TotalSubGroupAccount4ProftLoss($values['GroupID'], 0, $YearFromDate, $ToDate, 'INCOME', '');



                                $NetIncome+=$Total_sub_amount;
				$NetIncomeYear+=$Total_sub_amountYear;
                                

                           }
                           

                            $content .= '<tr style="padding-bottom: 30px;">
                                <td height="20" align="left" class="border_top_bottom"><b>'.$AccPrefix3.'Total '.(str_replace("Account","",$AccountTypeLabel)).'</b></td>
                               
                                <td align="right" class="border_top_bottom"><b>';


if($NetIncome<0){
	$NetIncomeVal = str_replace("-","",$NetIncome);
	$content .=  "(".number_format($NetIncomeVal, 2).")";
}else{
	$content .=  number_format($NetIncome, 2);
}

if($RangeFromm == '5000') {
	$CostOfGood = $NetIncome;
	$CostOfGood = round($CostOfGood,2);
}


$content .= '</b></td>



<td align="right" class="border_top_bottom">
<b>';

if($NetIncomeYear<0){
	$NetIncomeYearVal = str_replace("-","",$NetIncomeYear);
	$content .= "(".number_format($NetIncomeYearVal, 2).")";
}else{
	$content .= number_format($NetIncomeYear, 2);
}

if($RangeFromm == '5000') {
	$CostOfGoodYear = $NetIncomeYear;
	$CostOfGoodYear = round($CostOfGoodYear,2);
}

$content .= '</b>
</td>
                            </tr>
                            <tr><td colspan="3" height="10"></td></tr>';




	if($RangeFromm != '5000'){		
		$TotalIncome+=$NetIncome;
		$TotalIncomeYear+=$NetIncomeYear;
	}



 if ($RangeFromm == '7000') {
	$content .= '<tr align="left" > 
	    <td height="20" class="border_top_bottom font13"><b>Total Income</b></td>
	    <td align="right" class="border_top_bottom font13">
<b>';


$TotalIncome = round($TotalIncome,2);
if($TotalIncome<0){
	$TotalIncomeVal = str_replace("-","",$TotalIncome);
	$content .= "(".number_format($TotalIncomeVal, 2).")";
}else{
	$content .= number_format($TotalIncome, 2);
}


$content .= '</b></td>
	    <td align="right" class="border_top_bottom">
<b>';


$TotalIncomeYear = round($TotalIncomeYear,2);
if($TotalIncomeYear<0){
	$TotalIncomeYearVal = str_replace("-","",$TotalIncomeYear);
	$content .= "(".number_format($TotalIncomeYearVal, 2).")";
}else{
	$content .= number_format($TotalIncomeYear, 2);
}

$content .= '</b>



 </td>
	</tr>
<tr><td colspan="3" height="10"></td></tr>';
	 } 
       
    } // PL Income foreach end 
   


   $content .= '<tr align="left" > 
	    <td height="20" class="border_top_bottom font13"><b>GROSS PROFIT</b></td>
	    <td align="right" class="border_top_bottom font13"><b>';


$GrossIncome = $TotalIncome - $CostOfGood;
$GrossIncome = round($GrossIncome,2);

if($GrossIncome<0){
	$GrossIncomeVal = str_replace("-","",$GrossIncome);
	$content .= "(".number_format($GrossIncomeVal, 2).")";
}else{
	$content .= number_format($GrossIncome, 2);
}

$content .= '</b></td>
	    <td align="right" class="border_top_bottom"><b>';

$GrossIncomeYear = $TotalIncomeYear - $CostOfGoodYear;
$GrossIncomeYear = round($GrossIncomeYear,2);

if($GrossIncomeYear<0){
	$GrossIncomeYearVal = str_replace("-","",$GrossIncomeYear);
	$content .= "(".number_format($GrossIncomeYearVal, 2).")";
}else{
	$content .= number_format($GrossIncomeYear, 2);
}


$content .= '</b></td>
	</tr>
<tr><td colspan="3" height="10"  ></td></tr>             


                        <tr align="left"> 
                            <td height="20" class="font13"><b>EXPENSE</b></td>
                            <td align="right" > </td>
                            <td align="right" > </td>
                        </tr>';
                       
                        $arryAccountTypePLExpense = $objBankAccount->getAccountTypePLExpense();

                        foreach ($arryAccountTypePLExpense as $key => $values) {
                            $AccountTypeID = $values['AccountTypeID'];
                            $RangeFromm = $values['RangeFrom'];
                         
                            $ArryDbtCrdAmount = $objBankAccount->NetDebitCreditByAccountType($RangeFromm, $FromDate, $ToDate);

                            $NetExpense = ''; $NetExpenseYear = '';

				$AccountTypeLabel = $values['AccountType'];
                             
                            $content .= '<tr align="left"> 
                                <td height="20" colspan="3"><b>'.$Config['AccPrefix'].$values['AccountType'].'</b></td>
                            </tr>';
                            
                            $netDebitAmt+=$ArryDbtCrdAmount["DbAmnt"];
                            $netCreditAmt+=$ArryDbtCrdAmount["CrAmnt"];
                            $rootBankAccountName = $objBankAccount->getBankAccountWithRoot($RangeFromm);

                            foreach ($rootBankAccountName as $key => $values) {

				

                                $account_data = $objBankAccount->getTotalDebitCreditAmount($values['BankAccountID'], '', $FromDate, $ToDate);
				$account_dataYear = $objBankAccount->getBeginningBalanceRange($values['BankAccountID'], '', $YearFromDate, $FromDate);
				
                                $NetAmt = $account_data[0]["DbAmnt"] - $account_data[0]["CrAmnt"];
				$NetAmtYear = $account_dataYear[0]["DbAmnt"] - $account_dataYear[0]["CrAmnt"];


				$NetAmt = round($NetAmt,2) ;
				$NetAmtYear = round(($NetAmtYear + $NetAmt),2);
				
                                $NetExpense+=$NetAmt;
				$NetExpenseYear+=$NetAmtYear;

				 if(!empty($NetAmt) || !empty($NetAmtYear)){ //start row
                               

                                $content .= '<tr align="left"> 
                                    <td height="20" >'.$AccPrefix3.strtoupper($values['AccountName']).'</td> 

                                    <td align="right" >';

if($NetAmt<0){
	$NetAmtVal = str_replace("-","",$NetAmt);
	$content .= "(".number_format($NetAmtVal, 2).")";
}else{
	$content .= number_format($NetAmt, 2);
}



$content .= '</td>
                                    <td align="right" >';


if($NetAmtYear<0){
	$NetAmtYearVal = str_replace("-","",$NetAmtYear);
	$content .= "(".number_format($NetAmtYearVal, 2).")";
}else{
	$content .= number_format($NetAmtYear, 2);
}



$content .= '</td>
                                </tr>';
                            
				}//end row



                            }



                            $groupAccountName = $objBankAccount->getGroupByAccountType($AccountTypeID);
                            foreach ($groupAccountName as $key => $values) {
                                $ArryDbtCrdAmount = $objBankAccount->NetDebitCreditByGroup($values['GroupID'], $FromDate, $ToDate);
                               
                                $content .= '<tr align="left"> 
                                    <td height="20" colspan="3" ><b>'.$AccPrefix3. strtoupper($values['GroupName']).'</b></td>
                                </tr>';

                                
                                $AccountNamee1 = $objBankAccount->getBankAccountWithGroupID($values['GroupID']);

                                foreach ($AccountNamee1 as $key => $values4) {

				


                                    $account_data = $objBankAccount->getTotalDebitCreditAmount($values4['BankAccountID'], '', $FromDate, $ToDate);
                                   $account_dataYear = $objBankAccount->getBeginningBalanceRange($values4['BankAccountID'], '', $YearFromDate, $FromDate);


                $NetAmt = $account_data[0]["DbAmnt"] - $account_data[0]["CrAmnt"];
		$NetAmtYear = $account_dataYear[0]["DbAmnt"] - $account_dataYear[0]["CrAmnt"];


		$NetAmt = round($NetAmt,2) ;
		$NetAmtYear = round(($NetAmtYear + $NetAmt),2);

                $NetExpense+=$NetAmt;
		$NetExpenseYear+=$NetAmtYear;

		 if(!empty($NetAmt) || !empty($NetAmtYear)){ //start row
                
                                    $content .= '<tr align="left"> 
                                        <td height="20" >'.$AccPrefix6.strtoupper($values4['AccountName']).'</td>
                                        <td width="" align="right">';

				
				if($NetAmt<0){
					$NetAmtVal = str_replace("-","",$NetAmt);
					$content .= "(".number_format($NetAmtVal, 2).")";
				}else {
					$content .= number_format($NetAmt, 2);
				}
				


				$content .= '</td>
                                        <td align="right" >';
				
				if($NetAmtYear<0){
					$NetAmtYearVal = str_replace("-","",$NetAmtYear);
					$content .= "(".number_format($NetAmtYearVal, 2).")";
				}else {
					$content .= number_format($NetAmtYear, 2);
				}
				



$content .= '</td>
                                    </tr>';
                              
					}//end row



                                }
				$Config['ExportContent'] = '';
                                $objBankAccount->getSubGroupProftLoss($values['GroupID'], 0, $FromDate, $ToDate, 'EXPENSES');
				$content .= $Config['ExportContent']; 


                                $Total_sub_amount = $objBankAccount->TotalSubGroupAccount4ProftLoss($values['GroupID'], 0, $FromDate, $ToDate, 'EXPENSES', '');

				$Total_sub_amountYear = $objBankAccount->TotalSubGroupAccount4ProftLoss($values['GroupID'], 0, $YearFromDate, $ToDate, 'EXPENSES', '');


                                $NetExpense+=$Total_sub_amount;
				 $NetExpenseYear+=$Total_sub_amountYear;
                              

        
        }


                            $content .= '<tr style="padding-bottom: 30px;">
                                <td height="20"  align="left" class="border_top_bottom font13"><b>'.$AccPrefix3.'Total '.(str_replace("Account","",$AccountTypeLabel)).'</b>
 

</td>
                             
                                <td align="right" class="border_top_bottom font13"><b>';

if($NetExpense<0){
	$NetExpenseVal = str_replace("-","",$NetExpense);
	$content .= "(".number_format($NetExpenseVal, 2).")";
}else{
	$content .= number_format($NetExpense, 2);
}

                           
   $content .= '</b></td>
                <td align="right" class="border_top_bottom"><b>';

if($NetExpenseYear<0){
	$NetExpenseYearVal = str_replace("-","",$NetExpenseYear);
	$content .= "(".number_format($NetExpenseYearVal, 2).")";
}else{
	$content .= number_format($NetExpenseYear, 2);
}


$content .= '</b>
 </td>
                            </tr>
                            <tr><td colspan="3">&nbsp;</td></tr>';

  
       $GrossExpense+=$NetExpense;
       $GrossExpenseYear+=$NetExpenseYear; 
    } // PL Expense foreach end 
    
}

                    $content .= '<br><br>';


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

 
                    $content .= '<br><br>
                    <tr >
                        <td height="20"  align="left" class="font15"><b>'.$PLText.'</b></td>
                        <td align="right" class="font15"><b>'.$DifferAmountTxt.'</b></td>
                        <td align="right" class="font15"><b>'.$DifferAmountTxtYear.'</b></td>
                    </tr> 

                </table>';

if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}



?>
