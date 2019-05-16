<?
        $pdf->ezText("<b>All amounts stated in ".$_SESSION['Currency']."</b>",9,array('justification'=>'right', 'spacing'=>'3'));

	foreach($arryAccountType as $key=>$values){
   
         $AccountTypeID = $values['AccountTypeID'];   
         $pdf->ezSetDy(-10);
        
         $pdf->ezText("<b>".stripslashes($values['AccountType'])."</b>",9,array('justification'=>'left', 'spacing'=>'1'));
          
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
         
      if($values['AccountType'] == "INCOME"){
      
          $totalIncome = $objReport->getTotalAmount(15,$_GET);
          
          $arryDef[$i][$Head1] = "\n<b>TOTAL INCOME</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalIncome,2,'.',',')."</b>";
          
           
             
            //$YCordLine = $pdf->y-$lineCount; 
            //$pdf->line(530,$YCordLine,69,$YCordLine);
           
            
         $data[] = $arryDef[$i];
         $i++;
      }
      
       if($values['AccountType'] == "COST OF GOODS SOLD"){
      
          $totalGoodSold = $objReport->getTotalAmount(17,$_GET);
          $grossProfit = $totalIncome-$totalGoodSold;
         
          $arryDef[$i][$Head1] = "\n<b>TOTAL COST OF GOODS SOLD</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalGoodSold,2,'.',',')."</b>";
      
           //$YCordLine = $pdf->y-$lineCount; 
          // $pdf->line(530,$YCordLine,69,$YCordLine);
          
         $data[] = $arryDef[$i];
         $i++;
         
          $arryDef[$i][$Head1] = "\n<b>GROSS PROFIT</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($grossProfit,2,'.',',')."</b>";
        
         $data[] = $arryDef[$i];
         $i++;
      }
      
       if($values['AccountType'] == "EXPENSES"){
      
        $totalExpense = $objReport->getTotalAmount(13,$_GET);
        $netIncome = $grossProfit-$totalExpense;
        
          $arryDef[$i][$Head1] = "\n<b>TOTAL EXPENSE</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($totalExpense,2,'.',',')."</b>";
        
          //$YCordLine = $pdf->y-$lineCount; 
          //$pdf->line(530,$YCordLine,69,$YCordLine);
            
         $data[] = $arryDef[$i];
         $i++;
         
          $arryDef[$i][$Head1] = "\n<b>NET INCOME</b>";
          $arryDef[$i][$Head2] = "\n";
          $arryDef[$i][$Head3] = "\n<b>".number_format($netIncome,2,'.',',')."</b>";
        
         $data[] = $arryDef[$i];
         $i++;
      
       }
         //echo "<pre>";
         //print_r($data);
         //exit;
         
        $pdf->ezSetDy(-5);
        $pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'150'),$Head2=>array('justification'=>'left','width'=>'250'),$Head3=>array('justification'=>'right','width'=>'60')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);
       
        }


  
        
        


?>