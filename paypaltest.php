<?php 


  			require_once("/var/www/html/erp/lib/paypal/paypal_pro.inc.php");
			  $nvpRecurring = '';
              $methodToCall = 'TransactionSearch';
			  $tid='2016-06-01T05:38:48Z';
			  $nvpstr = '&STARTDATE=' . $tid . $nvpRecurring;
			  $Username = 'admin_api1.virtualstacks.com';
              $APIPassword = 'LFVHZUKECP9LUTTP';
              $APISignature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AkcWpUe5S.hEq6uDlWHv5umDiMF4';
              $paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', true, FALSE);
              $resArray = $paypalPro->hash_call($methodToCall, $nvpstr);
                echo '<pre>';
	        //  print_r($resArray);
	         $newarray=$filterarray=array();
	         $i=0;
	       if(!empty($resArray))  {
		       foreach($resArray as $k=>$res){
		       if(strpos($k, 'L_TIMESTAMP')!==false){
		       $i++;
		       
		       }
		       
		       
		       }
	       
	       } 
	       echo  $i;;
	       
	      
	       for($j=0; $j<$i;$j++){
	       $filterarray[$j]['L_TIMESTAMP']=$resArray['L_TIMESTAMP'.$j];
	       $filterarray[$j]['L_TIMEZONE']=$resArray['L_TIMEZONE'.$j];
	       $filterarray[$j]['L_TYPE']=$resArray['L_TYPE'.$j];
	       $filterarray[$j]['L_EMAIL']=$resArray['L_EMAIL'.$j];
	       $filterarray[$j]['L_NAME']=$resArray['L_NAME'.$j];
	       $filterarray[$j]['L_TRANSACTIONID']=$resArray['L_TRANSACTIONID'.$j];
	       $filterarray[$j]['L_STATUS']=$resArray['L_STATUS'.$j];
	       $filterarray[$j]['L_AMT']=$resArray['L_AMT'.$j];
	       $filterarray[$j]['L_CURRENCYCODE']=$resArray['L_CURRENCYCODE'.$j];
	       $filterarray[$j]['L_FEEAMT']=$resArray['L_FEEAMT'.$j];
	       $filterarray[$j]['L_NETAMT']=$resArray['L_NETAMT'.$j];
	      
	       		$nvpRecurring = '';
              $methodToCall = 'GetTransactionDetails';
			  $tid=$resArray['L_TRANSACTIONID'.$j];
			  $nvpstr = '&TRANSACTIONID=' . $tid . $nvpRecurring;
			 
              $paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', true, FALSE);
              $resArray1 = $paypalPro->hash_call($methodToCall, $nvpstr);
	        
	       
	       	if($resArray1['TRANSACTIONTYPE']=='webaccept'){
	      			$filterarray[$j]['invoice_id']=substr($resArray1['INVNUM'],5);
	       	}else{
	       	
	       	$filterarray[$j]['invoice_id']=null;
	       	}
	        $filterarray[$j]['detail']=$resArray1;
	       
	       }
	       print_r($filterarray);
			/* $Username = 'admin_api1.virtualstacks.com';
              $APIPassword = 'LFVHZUKECP9LUTTP';
              $APISignature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AkcWpUe5S.hEq6uDlWHv5umDiMF4';

  require_once("/var/www/html/erp/lib/paypal/paypal_pro.inc.php");
			  $nvpRecurring = '';
              $methodToCall = 'GetTransactionDetails';
			  $tid='72G80468S7095380J';
			  $nvpstr = '&TRANSACTIONID=' . $tid . $nvpRecurring;
			 
              $paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', true, FALSE);
              $resArray = $paypalPro->hash_call($methodToCall, $nvpstr);
	          echo '<pre>';
	         
	         print_r($resArray);
*/

	          
//72G80468S7095380J
?>