<?
if(!empty($ExportFile)){
	$Config['AccPrefix'] = '&#160;';
}else{
	$Config['AccPrefix'] = '&nbsp;';
}
$AccPrefix3='';
for($i=0;$i<3;$i++){
	$AccPrefix3 .= $Config['AccPrefix'];
}
$AccPrefix6 ='';
for($i=0;$i<6;$i++){
	$AccPrefix6 .= $Config['AccPrefix'];
}
/********************/
(empty($align55))?($align55=""):("");

 /********************/ 
$content = '<table cellspacing="1" cellpadding="3"  width="70%" align="center">';
      if($num > 0){
      $content .= '<tr>
        <td  colspan = "4" align="center">
         
            <span class="font18" >'.strtoupper($Config['SiteName']).'</span><br>
            <span class="font16">Balance Sheet</span><br>
            <span class="font16">';
                if($_GET['TransactionDate'] == "All"){
                  $content .= 'For All Dates';
             } else if($_GET['TransactionDate'] == "Today"){
                  
                 $content .= 'For '.date($Config['DateFormat'], strtotime($FromDate)).'';
	         } else if($_GET['TransactionDate'] == "Monthly"){
                  
                 $content .= 'For '.date("F, Y", strtotime($FromDate)).'';
             } else {
                 $content .= 'For the period From
                '.date($Config['DateFormat'], strtotime($FromDate)).' To '.date($Config['DateFormat'], strtotime($ToDate)).'';
             }
           
            $content .= '</span>
            
         </td>		
    </tr>
    
    <tr><td class="border_bottom" colspan = "4">&nbsp;</td></tr>';  
     } else { 
    $content .= '<tr><td class="red" colspan = "4">This report contains no data.</td></tr>'; 
      }
    


   if($num > 0){   
 $content .= '<tr>
	 <td>&nbsp;</td>       
        <td colspan="3" height="30" align="left" ><b>All amounts stated in '.$Config['Currency'].'</b></td>
 </tr>
 <tr>
        <td  width="10%">&nbsp;</td>       
        <td align="right" colspan="2"><b>Net Balance</b></td>
	<td  width="20%">&nbsp;</td>
 </tr>';
   } 
        
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
  
   
	$AccountTypeVal = $AccountType;
	if($RangeFromm==2000) $AccountTypeVal = ''; 


  $content .= '<tr align="left"> 
	 <td>&nbsp;</td>
    <td height="30" class="'.$font.'" colspan="3" '.$align55.' ><b>'.$AccountTypeVal.' </b></td>
      
  </tr>';

	 /*$netDebitAmt+=$ArryDbtCrdAmount["DbAmnt"];
      $netCreditAmt+=$ArryDbtCrdAmount["CrAmnt"];*/
      $rootBankAccountName=$objBankAccount->getBankAccountWithRoot($RangeFromm);
      $TotalAccountBalance=0;
       foreach($rootBankAccountName as $key=>$values){

		$ReFlag=0;
		/**********Current Retained Earnings************/
		if($RetainedEarning>0 && $values['BankAccountID']==$RetainedEarning && $CurrentPeriod!=''){
			
			 
			//Reset for Retained Earnings
			$Config['CreditMinusDebit'] = 1;
			$NettBalance=0;
			$BeginningBalance=0;
			$BeginningBalance=$objBankAccount->getBeginningBalance($values['BankAccountID'],$ReFromDate);
			$NettBalance = round($BeginningBalance,2) + $PnLAmount_RE;			
			 
	
			/************************/
			$BeginningBalance=0;
			//$BeginningBalance=$objBankAccount->getBeginningBalance($values['BankAccountID'],$FromDate);
			$accountdataRE = $objBankAccount->getTotalDebitCreditAmount($values['BankAccountID'],'',$ReFromDate,$ToDate);
			$NettBalanceRE = round(($accountdataRE[0]['CrAmnt']-$accountdataRE[0]['DbAmnt']),2) + $PnLAmount_CurrentRE  ;// + $BeginningBalance55 -  $NettBalance;
			$TotalAccountBalance+=$NettBalanceRE;
			if($NettBalanceRE<0){
				$NettBalanceREVal = str_replace("-","",$NettBalanceRE);
				//$NettBalanceREVal = number_format($NettBalanceREVal, 2);
				$NettBalanceREVal = "(".number_format($NettBalanceREVal, 2).")";
			}else{
				$NettBalanceREVal = number_format($NettBalanceRE, 2);
			}

			//if($_GET['pk']==1){ $NettBalanceREVal .= "#".$NettBalanceRE."#"; }

			 $content .= ' <tr align="left"> 
				<td height="20"> '.$values['AccountNumber'].'</td>
				<td>CURRENT YEAR RETAINED EARNINGS</td>
				<td align="right">'.$NettBalanceREVal.'</td> 
				<td></td>
				</tr>';

			$ReFlag=1;

			
		}
		/*************************************/

		if($ReFlag==0){
			$Config['CreditMinusDebit'] = 0;
			if($RangeFromm=='2000' || $RangeFromm=='3000' || $RangeFromm=='4000' || $RangeFromm=='7000'){
				$Config['CreditMinusDebit'] = 1;
			}

			$BeginningBalance=0;
			if($RangeFromm<4000){
				$BeginningBalance=$objBankAccount->getBeginningBalance($values['BankAccountID'],$FromDate);
			}



			$NettBalance = round($BeginningBalance,2);

			$account_data=$objBankAccount->getTotalDebitCreditAmount($values['BankAccountID'],'',$FromDate,$ToDate);
			
			if($Config['CreditMinusDebit']==1){
				$NettBalance+=round(($account_data[0]['CrAmnt']-$account_data[0]['DbAmnt']),2);
			}else{
				$NettBalance+=round(($account_data[0]['DbAmnt']-$account_data[0]['CrAmnt']),2);
			}
			//$TotalAccountBalance+=$NettBalance; //pk7
		}


    
    $content .= '<tr align="left"> 
        <td height="20">'.$values['AccountNumber'].'  </td>
        <td>'.strtoupper($values['AccountName']).'</td>
 
        <td align="right">'; 

if($NettBalance<0){
	$NettBalanceVal = str_replace("-","",$NettBalance); 
	/*if($AccountTypeID==3){
		echo number_format($NettBalanceVal, 2);
		if($ReFlag==0){ $NettBalance = -$NettBalance;}
	}else{*/
		$content .= "(".number_format($NettBalanceVal, 2).")";
	//}	
}else{
	$content .= number_format($NettBalance, 2);
}

$TotalAccountBalance+=$NettBalance; 

//echo ' # '.$TotalAccountBalance ;


$content .= '</td>
	<td>&nbsp;</td>
    </tr>';
       }

	$groupAccountName=$objBankAccount->getGroupByAccountType($AccountTypeID);

       foreach($groupAccountName as $key_gr=>$values_gr){  //start group  
		$grBankAccountName=$objBankAccount->getBankAccountWithGroupID($values_gr['GroupID']);      
  //  pr($groupAccountName);
     $content .= '<tr align="left"> 
	<td>&nbsp;</td>
        <td height="20" ><b>'.ucwords($values_gr['GroupName']).'</b></td>
       <td colspan="2">&nbsp;</td>
    </tr>';

	$GroupTotal = 0;
	foreach($grBankAccountName as $key2=>$values2){ //start inner account group
		
		if($RangeFromm=='2000' || $RangeFromm=='3000' || $RangeFromm=='4000' || $RangeFromm=='7000'){
			$Config['CreditMinusDebit']=1;
		}else{
			$Config['CreditMinusDebit']=0;
		}


		$BeginningBalance=0;
		if($RangeFromm<4000){
			$BeginningBalance=$objBankAccount->getBeginningBalance($values2['BankAccountID'],$FromDate);
		}


		$NettBalance = round($BeginningBalance,2);

		$account_data=$objBankAccount->getTotalDebitCreditAmount($values2['BankAccountID'],'',$FromDate,$ToDate);


		if($Config['CreditMinusDebit']==1){
			$NettBalance+=round(($account_data[0]['CrAmnt']-$account_data[0]['DbAmnt']),2);
		}else{
			$NettBalance+=round(($account_data[0]['DbAmnt']-$account_data[0]['CrAmnt']),2);			
		}

		//$TotalAccountBalance+=$NettBalance; //pk7
		//$GroupTotal+=$NettBalance; //pk7

		$content .= '<tr align="left"> 

		<td height="20" >'.$values2['AccountNumber'].'</td>
		<td>'. strtoupper($values2['AccountName']).'</td>


		<td align="right">';  
		 
		
		if($NettBalance<0){
			$NettBalanceVal = str_replace("-","",$NettBalance);
			
			/*if($AccountTypeID==3){			
				echo number_format($NettBalanceVal, 2);
				$NettBalance = -$NettBalance;
			}else{*/
				$content .= "(".number_format($NettBalanceVal, 2).")";
			//}
		
		}else{
			$content .= number_format($NettBalance, 2);
		}

		$TotalAccountBalance+=$NettBalance;
		$GroupTotal+=$NettBalance;

//echo ' # '.$TotalAccountBalance .' #'.$GroupTotal5 ;
		
		$content .= '</td>
		<td colspan="2">&nbsp;</td>
		</tr>';


    	}//end inner account group 
    $content .= '<tr>
	<td class="border_top_bottom">&nbsp;</td>
        <td height="20" align="left" class="border_top_bottom"><b>Total '.ucwords($values_gr['GroupName']).'</b></td>
       <td class="border_top_bottom">&nbsp;</td>
        <td align="right" class="border_top_bottom">
<b>';

$GroupTotal =  round($GroupTotal,2);
if($GroupTotal<0){
	$GroupTotalVal = str_replace("-","",$GroupTotal);
	
	/*if($AccountTypeID==3){	
		echo number_format($GroupTotalVal, 2);
	}else{*/
		$content .= "(".number_format($GroupTotalVal, 2).")";
	//}

}else{
	$content .= number_format($GroupTotal, 2);
}

$content .= '</b>
	</td>
    </tr>

 <tr><td colspan="4">&nbsp;</td></tr>';

} //end group  

       
    $content .= '<tr>
	<td class="border_top_bottom">&nbsp;</td>
        <td height="20" align="left"  class="border_top_bottom font15"  ><b>Total '.$AccountType.'</b></td>
        <td class="border_top_bottom">&nbsp;</td>
        <td align="right" class="border_top_bottom font15">
 
<b>'.$Config['CurrencySymbol'].'';
$arryAssetTotal[] = round($TotalAccountBalance,2);
if($TotalAccountBalance<0){
	$TotalAccountBalanceVal = str_replace("-","",$TotalAccountBalance);
	
	$content .=  "(".number_format($TotalAccountBalanceVal, 2).")";

	/*if($AccountTypeID==2 ){
		echo number_format($TotalAccountBalanceVal, 2);
	}else{
		echo "(".number_format($TotalAccountBalanceVal, 2).")";
	}*/

	
}else{
	$content .=  number_format($TotalAccountBalance, 2);
}

$content .= '</b>


</td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>';
 
if($RangeFromm==1000){
    $content .= '<tr>
	<td>&nbsp;</td>
        <td height="30"  class="font15" colspan="3" align="left"><b>'.$HeadLiabilityEquity.'</b></td>
     
    </tr>';

   } 


    } // foreach end //

 
    $content .= '<tr style="padding-bottom: 30px;">
	<td class="border_top_bottom">&nbsp;</td>
        <td height="20" align="left" class="border_top_bottom font15"><b>Total '.$HeadLiabilityEquity.'</b></td>
       <td class="border_top_bottom">&nbsp;</td>
        <td align="right" class="border_top_bottom font15">

<b>'.$Config['CurrencySymbol'].'';

$AssetTotal = round(($arryAssetTotal[1]+$arryAssetTotal[2]),2);
if($AssetTotal<0){
	$AssetTotalVal = str_replace("-","",$AssetTotal);
	//echo "(".number_format($AssetTotalVal, 2).")";
	$content .= number_format($AssetTotalVal, 2);
}else{
	$content .= number_format($AssetTotal, 2);
}

 $content .= '</b>


</td>
    </tr>';



    
     } 
    
  
   
   $content .= '</table>';
		 
if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}



?>
