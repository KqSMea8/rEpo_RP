<?
        $pdf->ezText("<b>All amounts stated in ".$_SESSION['Currency']."</b>",9,array('justification'=>'right', 'spacing'=>'3'));

	foreach($arryAccountType as $key=>$values){
   
         $AccountTypeID = $values['AccountTypeID']; 
         
         $pdf->ezSetDy(-10);
        if($values['AccountType'] == "BANK ACCOUNT") {
          $pdf->ezText("<b>ASSETS:</b>",9,array('justification'=>'left', 'spacing'=>'1'));
           $pdf->ezSetDy(-10);
          $pdf->ezText("<b>Current Assets:</b>",9,array('justification'=>'left', 'spacing'=>'1','left'=>'5'));
        }
        
          if($values['AccountType'] == "CREDIT CARD"){
          $pdf->ezText("<b>LIABILITIES AND EQUITY:</b>",9,array('justification'=>'left', 'spacing'=>'1'));
           $pdf->ezSetDy(-10);
          $pdf->ezText("<b>Current Liabilities:</b>",9,array('justification'=>'left', 'spacing'=>'1','left'=>'5'));
        }
        
         if($values['AccountType'] == "LONG TERM LIABILITIES"){
          $pdf->ezText("<b>Long Term Liabilities:</b>",9,array('justification'=>'left', 'spacing'=>'1'));
          
        }
        
        
          $pdf->ezSetDy(-10);
          
         $pdf->ezText(stripslashes($values['AccountType']),9,array('justification'=>'left', 'spacing'=>'1', 'left'=>'10'));
          
         $arryBankAccount=$objBankAccount->getBankAccount($AccountTypeID,'','','','');
         $NumLine = sizeof($arryBankAccount);
         
         $Head1 = '<b>Account Name</b>'; $Head2 = '<b>Balance</b>';$Head3 = '<b>Dot</b>';
         
        
         
         $i=0;unset($data); unset($arryDef);
         
        $lineCount = 0;
         
         for($Line=1;$Line<=$NumLine;$Line++) {
          $Count=$Line-1;	
          
          $Balance = $objReport->getAccountBalanceForReport($arryBankAccount[$Count]['BankAccountID'],$_GET);
         
          $arryDef[$i][$Head1] = strtoupper($arryBankAccount[$Count]['AccountName']);
          $arryDef[$i][$Head2] = '------------------------------------------------------------------------------';
          $arryDef[$i][$Head3] = number_format($Balance,2,'.',',');
         
          
          
         $data[] = $arryDef[$i];
         $i++;
         $lineCount = $lineCount+16;
         }
         
         
         
      if($values['AccountType'] == "BANK ACCOUNT"){
          
           
      
          $totalBankAccount = $objReport->getTotalAmount(16,$_GET);
          
          $arryDef[$i][$Head1] = "\n<b>TOTAL BANK ACCOUNT</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalBankAccount,2,'.',',')."</b>";
          
         $data[] = $arryDef[$i];
         $i++;
      }
      
       if($values['AccountType'] == "ACCOUNT RECEIVABLES"){
      
        $totalReceivable = $objReport->getTotalAmount(12,$_GET);
         
          $arryDef[$i][$Head1] = "\n<b>TOTAl ACCOUNT RECEIVABLES</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalReceivable,2,'.',',')."</b>";
      
          
         $data[] = $arryDef[$i];
         $i++;
         
       }
       
         if($values['AccountType'] == "OTHER CURRENT ASSETS"){
      
         $totalOtherCurrentAssets = $objReport->getTotalAmount(8,$_GET);
          
          $arryDef[$i][$Head1] = "\n<b>TOTAL OTHER CURRENT ASSETS</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalOtherCurrentAssets,2,'.',',')."</b>";
      
          
         $data[] = $arryDef[$i];
         $i++;
         
       }
      
       if($values['AccountType'] == "FIXED ASSETS"){
      
          $totalFixedAssets = $objReport->getTotalAmount(11,$_GET);
          $arryDef[$i][$Head1] = "\n<b>TOTAL FIXED ASSETS</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalFixedAssets,2,'.',',')."</b>";
        
          $data[] = $arryDef[$i];
          $i++;
         
         
      
       }
       
       if($values['AccountType'] == "OTHER ASSETS"){
      
          $totalOtherAssets = $objReport->getTotalAmount(9,$_GET);
          
          $arryDef[$i][$Head1] = "\n<b>TOTAL OTHER ASSETS</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalOtherAssets,2,'.',',')."</b>";
        
          $data[] = $arryDef[$i];
          $i++;
         
         
      
       }
       
        if($values['AccountType'] == "OTHER ASSETS"){
      
           $totalAssets = $totalBankAccount+$totalReceivable+$totalOtherCurrentAssets+$totalFixedAssets+$totalOtherAssets;
          
           
          $arryDef[$i][$Head1] = "\n<b>TOTAL ASSETS</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalAssets,2,'.',',')."</b>";
        
          $data[] = $arryDef[$i];
          $i++;
         
        
      
       }
      
   
   
       
       if($values['AccountType'] == "CREDIT CARD"){
      
         $totalCreditCard = $objReport->getTotalAmount(19,$_GET);
          
          $arryDef[$i][$Head1] = "\n<b>TOTAL CREDIT CARD</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalCreditCard,2,'.',',')."</b>";
        
          $data[] = $arryDef[$i];
          $i++;
         
         
      
       }
       
        if($values['AccountType'] == "ACCOUNT PAYABLES"){
      
         $totalAccountPayable = $objReport->getTotalAmount(14,$_GET);
          
          $arryDef[$i][$Head1] = "\n<b>TOTAL ACCOUNT PAYABLES</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalAccountPayable,2,'.',',')."</b>";
        
          $data[] = $arryDef[$i];
          $i++;
         
         
      
       }
       
        if($values['AccountType'] == "OTHER CURRENT LIABILITIES"){
      
         $totalOtherCurrentLibilities = $objReport->getTotalAmount(6,$_GET);
          
          $arryDef[$i][$Head1] = "\n<b>TOTAL OTHER CURRENT LIABILITIES</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalOtherCurrentLibilities,2,'.',',')."</b>";
        
          $data[] = $arryDef[$i];
          $i++;
         
         
      
       }
       
        if($values['AccountType'] == "OTHER CURRENT LIABILITIES"){
      
         $totalCurrentLibilities = $totalCreditCard+$totalAccountPayable+$totalOtherCurrentLibilities;
          
          $arryDef[$i][$Head1] = "\n<b>TOTAL CURRENT LIABILITIES</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalCurrentLibilities,2,'.',',')."</b>";
        
          $data[] = $arryDef[$i];
          $i++;
         
        
      
       }
       
        if($values['AccountType'] == "LONG TERM LIABILITIES"){
      
          $totalLongTermLibilities = $objReport->getTotalAmount(7,$_GET);
          
          $arryDef[$i][$Head1] = "\n<b>TOTAL LONG TERM LIABILITIES</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalLongTermLibilities,2,'.',',')."</b>";
        
          $data[] = $arryDef[$i];
          $i++;
         
        
      
       }
       
        if($values['AccountType'] == "LONG TERM LIABILITIES"){
      
         $totalLibilities = $totalCurrentLibilities+$totalLongTermLibilities;
          
          $arryDef[$i][$Head1] = "\n<b>TOTAL LIABILITIES</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalLibilities,2,'.',',')."</b>";
        
          $data[] = $arryDef[$i];
          $i++;
         
        
      
       }
       
       if($values['AccountType'] == "EQUITY"){
      
         $totalIncome = $objReport->getTotalAmount(15,$_GET);
         $totalGoodSold = $objReport->getTotalAmount(17,$_GET);
       $grossProfit = $totalIncome-$totalGoodSold;
        $totalExpense = $objReport->getTotalAmount(13,$_GET);
      $netIncome = $grossProfit-$totalExpense;
      
     $totalEQUITY = $netIncome;
          
          $arryDef[$i][$Head1] = 'NET INCOME';
          $arryDef[$i][$Head2] = '------------------------------------------------------------------------------';
          $arryDef[$i][$Head3] = number_format($netIncome,2,'.',',');
        
          $data[] = $arryDef[$i];
          $i++;
         
         $arryDef[$i][$Head1] = "\n<b>TOTAL EQUITY</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalEQUITY,2,'.',',')."</b>";
        
          $data[] = $arryDef[$i];
          $i++;
          
          $totalLibilitiesAndEquity = $totalLibilities+$totalEQUITY;
          
          
          $arryDef[$i][$Head1] = "\n<b>TOTAL LIABILITIES AND EQUITY</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalLibilitiesAndEquity,2,'.',',')."</b>";
        
          $data[] = $arryDef[$i];
          $i++;
      
       }
         //echo "<pre>";
         //print_r($data);
         //exit;
         
        $pdf->ezSetDy(-5);
        $pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'180'),$Head2=>array('justification'=>'left','width'=>'250'),$Head3=>array('justification'=>'right','width'=>'60')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>0 , 'xPos' =>310 ,'width'=>540,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);
       
        }


  
        
        


?>