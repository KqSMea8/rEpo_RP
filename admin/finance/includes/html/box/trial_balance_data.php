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
$content ='<table cellspacing="1" cellpadding="3" width="600" align="center">';
      if($num > 0){   
      $content .='<tr align="left">
        <td    align="center" colspan="3" >
           
            <span class="font18">'.strtoupper($Config['SiteName']).'</span><br>
            <span class="font16">Trial Balance</span><br>
            <span class="font16">';
                 /*if($_GET['TransactionDate'] == "All"){
                 $content .='For All Dates';
             } else if($_GET['TransactionDate'] == "Today"){                  
                $content .='For '.date($Config['DateFormat'], strtotime($FromDate)).'';
		 } else if($_GET['TransactionDate'] == "Monthly"){                  
                 $content .='For '.date("F, Y", strtotime($FromDate)).'';
             } else { */
			
		if($Config['TransactionType']=="B"){
			$content .=' 
            		'.date($Config['DateFormat'], strtotime($FromDate));
		}else if($Config['TransactionType']=="E"){
			$content .=' 
            		'.date($Config['DateFormat'], strtotime($ToDate));
            	}else{
                  $content .=' From
            '.date($Config['DateFormat'], strtotime($FromDate)).' To '.date($Config['DateFormat'], strtotime($ToDate));
		}



            //}
           
            $content .='</span>
           
               </td>
		
		
    </tr>
    
    <tr><td class="border_bottom" colspan="3">&nbsp;</td></tr>'; 
      } else { 
    	$content .='<tr><td class="red" colspan="3">This report contains no data.</td></tr>';  
      }
  


  if($num > 0){  



 $content .='<tr>
        <td colspan="3" height="30" align="right"><b>All amounts stated in '.$Config['Currency'].'</b></td>
 </tr>
 <tr>
        <td align="right" width="300"> &nbsp;</td>
        <td align="right" style="padding-top: 10px;" ><b>Debit</b></td>
        <td align="right" style="padding-top: 10px;"><b>Credit</b></td>
 </tr>';
         }     
        
 

  if(is_array($arryAccountType) && $num>0){
      
      $netDebitAmt=0;
      $netCreditAmt=0;
      
  	foreach($arryAccountType as $key=>$values){
            
            

         $AccountTypeID = $values['AccountTypeID']; 
         $Rangefromm=$values['RangeFrom'];
         //$ArryDbtCrdAmount=$objBankAccount->TotalDebitCreditByAccountType($AccountTypeID,$FromDate,$ToDate);
         
         $ArryDbtCrdAmount=$objBankAccount->NetDebitCreditByAccountTypeTrial($Rangefromm,$FromDate,$ToDate);

	$DbAmnt = $ArryDbtCrdAmount["DbAmnt"];
	$CrAmnt = $ArryDbtCrdAmount["CrAmnt"];

	/***********************/
	if($DbAmnt<0){
		$DbAmnt = str_replace("-","",$DbAmnt);	 
		$DbAmnt = "(".number_format($DbAmnt, 2).")";	 	
	}else{
		$DbAmnt = number_format($DbAmnt, 2);
	}
	if($CrAmnt<0){
		$CrAmnt = str_replace("-","",$CrAmnt);	 
		$CrAmnt = "(".number_format($CrAmnt, 2).")";	 	
	}else{
		$CrAmnt = number_format($CrAmnt, 2);
	}
	/***********************/

	 
	  


	if($values['RangeFrom']!=1000) $content .='<tr><td>&nbsp;</td></tr>';


   	if($DbAmnt != "0.00" || $CrAmnt != "0.00" ){

		//Total Equity & Total Credit
		if($values['AccountTypeID']==3 && $Config['TransactionType']!='A' && $RetainedEarning>0 && !empty($CurrentPeriod) && !empty($ReNettBalance)){
 
			 /****Calculate New Equity Amount*********/
			  $OldEquityAmount = $ArryDbtCrdAmount["CrAmnt"];
 
 

	  		  #$NewEquityAmount = ($OldEquityAmount+$ReNettBalance)-$ReBeginningBalance;   //old

			  $NewEquityAmount = ($OldEquityAmount-$CreditAmtRE) + $OriginalReBalance;

			 $netCreditAmt = ($netCreditAmt - $OldEquityAmount)+$NewEquityAmount; //Total Credit
			 if($NewEquityAmount<0){
				$NewEquityAmountVal = str_replace("-","",$NewEquityAmount);
				$NewEquityAmountDis = "(".number_format($NewEquityAmountVal, 2).")";	 			 
			  }else{
				$NewEquityAmountDis = number_format($NewEquityAmount, 2);
			 }
			
			 
		  	$DbAmnt = '';	$CrAmnt = $NewEquityAmountDis;
			  	
			 /*************************/ 
		}


		$content .='<tr align="left"> 
		<td height="20" class="border_top font13"><b>'.stripslashes($values['AccountType']).'</b></td>
		<td align="right" class="border_top font13"><b>'.$DbAmnt.'</b></td>
		<td align="right" class="border_top font13" id="AccountTypeIDCredit'.$values['AccountTypeID'].'"><b>'.$CrAmnt.'</b></td>
		</tr>';
	}
  

      $netDebitAmt+=$ArryDbtCrdAmount["DbAmnt"];
      $netCreditAmt+=$ArryDbtCrdAmount["CrAmnt"];
      $rootBankAccountName=$objBankAccount->getBankAccountWithRoot($Rangefromm);
      
       foreach($rootBankAccountName as $key=>$values){
                  

	$arrayDC=$objBankAccount->GetDebitCreditTrail($values['BankAccountID'], $values['RangeFrom'] ,$FromDate,$ToDate);	
	

	/**********Current Retained Earnings************/
	/***********************************************/
	$ReFlag=0;

	if($Config['TransactionType']!='A' && $RetainedEarning>0 && $values['BankAccountID']==$RetainedEarning && !empty($CurrentPeriod) && !empty($ReNettBalance)){ 

		$content .= ' <tr align="left"> 
				<td height="20"> '.$AccPrefix3.strtoupper($values['AccountName']).'</td>
				 <td align="right" >0.00</td>				 
				<td align="right">'.$NettBalanceREDis.'</td> 
				<td></td>
				</tr>';

		$ReFlag=1;
	}

	/********************************/
       /********************************/
       if($ReFlag=="0" && ($arrayDC['DebitAmt'] != "0.00" || $arrayDC['CreditAmt'] != "0.00") ){
	   $content .='<tr align="left"> 
		<td height="20" >'.$AccPrefix3.strtoupper($values['AccountName']).'</td>
		
		<td align="right"  >  '.$arrayDC['DebitAmt'].'</td>
		<td align="right" >'.$arrayDC['CreditAmt'].'</td>
	    </tr>';
	}



        }
    
       $groupAccountName=$objBankAccount->getGroupByAccountType($AccountTypeID);
       foreach($groupAccountName as $key=>$values){
           #$ArryDbtCrdAmount=$objBankAccount->NetDebitCreditByGroup($values['GroupID'],$FromDate,$ToDate);
    
    $content .='<tr align="left"> 
        <td height="20"  colspan="3"><b>'.$AccPrefix3.ucwords($values['GroupName']).'</b></td>
       
    </tr>
	';
    
  
     $AccountNamee1=$objBankAccount->getBankAccountWithGroupID($values['GroupID']);
     
     foreach($AccountNamee1 as $key=>$values4){
        /****pk***********/
	$arrayDC=$objBankAccount->GetDebitCreditTrail($values4['BankAccountID'], $values4['RangeFrom'] ,$FromDate,$ToDate);	
	/***************/
       
    	if($arrayDC['DebitAmt'] != "0.00" || $arrayDC['CreditAmt'] != "0.00" ){
	    $content .='<tr align="left"> 
		<td height="20" >'.$AccPrefix6.strtoupper($values4['AccountName']).'</td>
	       <td align="right"  > '.$arrayDC['DebitAmt'].'</td>
		<td align="right" >'.$arrayDC['CreditAmt'].'</td>
	    </tr>';
	}



      }
     $objBankAccount->getSubGroupAccountTrial($values['GroupID'],0,$FromDate,$ToDate);    
   	 $content .= $Config['ExportContent'];

               }    
    
     } // foreach end //
    

 
 $netCreditAmt += $CurrentReNettBalance;
 
 


    $content .='<tr><td  colspan="3">&nbsp;</td></tr>
    <tr>
    <td height="20" align="left"  class="border_top_bottom font15"><b>Grand Total</b></td>
    <td align="right" class="border_top_bottom font15"><b>'.number_format($netDebitAmt,2).'</b></td>
    <td align="right" class="border_top_bottom font15"><b>'.number_format($netCreditAmt,2).'</b></td>
    </tr>';
    } 
  
  $content .='</table>';
//echo $content;exit;
if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}

//echo $content; exit;
