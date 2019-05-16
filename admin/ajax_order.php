<?	session_start();

	date_default_timezone_set('America/New_York');

    	require_once("../includes/config.php");
    	require_once("../includes/function.php");
	require_once("../classes/dbClass.php");
	require_once("../classes/admin.class.php");	
	require_once("../classes/sales.quote.order.class.php");	 
	require_once("../classes/purchase.class.php");
	require_once("../classes/pager.ajax.php");
	require_once("language/english.php");
	$objConfig=new admin();
	$objPager=new pager();

 	(empty($_GET['curP']))?($_GET['curP']=1):(""); 
	(empty($_GET['sortby']))?($_GET['sortby']=""):(""); 
	(empty($_GET['key']))?($_GET['key']=""):(""); 
	(empty($_GET['module']))?($_GET['module']=""):(""); 

	$Config['GetNumRecords'] = '';
	$Config['RecordsPerPage'] = 20;
	$Config['StartPage'] = ($_GET['curP']-1)*$Config['RecordsPerPage'];

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}
	if(empty($_SESSION['CmpID'])){
		echo SESSION_EXPIRED;exit;
	}

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

	switch($_GET['action']){
		/***************************/	
		case 'CustomerInvoice':
			$objSale = new sale();			 
			if(!empty($_GET['CustCode']) && $_GET['module']=='Invoice'){
				$_GET['PostToGL']=1;	
				$arrySale=$objSale->ListSale($_GET);
				$num = sizeof($arrySale);
				/***********Count Records****************/	
				$Config['GetNumRecords'] = 1;
				$arryCount=$objSale->ListSale($_GET);
				$numCount=(!empty($arryCount[0]['NumCount']))?($arryCount[0]['NumCount']):("");	
				$pagerLink=$objPager->getPaging($numCount,$Config['RecordsPerPage'],$_GET['curP'],$_GET['module']);
			}			
			$AjaxHtml  = '<table id="list_table" cellspacing="1" cellpadding="5" width="100%" align="center">';
			if($num>0){ 
				$AjaxHtml  .= '<tr align="left"  >
					<td width="15%" class="head1" >Invoice Date</td>
					<td width="15%"  class="head1" >Invoice Number#</td>
					<td width="12%" class="head1" >SO Number</td>
					<td class="head1">Sales Person</td>
					<td width="15%" align="center" class="head1" >Amount</td>
					<td width="10%" align="center" class="head1" >Currency</td>
					<td width="12%"  align="center" class="head1" >Status</td>
				</tr>';
 
		  	$flag=true;
			$Line=0;
		  	foreach($arrySale as $key=>$values){
				$flag=!$flag;
				$class=($flag)?("oddbg"):("evenbg");
				$Line++;	
 
				$InvoiceDate = ($values["InvoiceDate"]>0)?(date($_SESSION['DateFormat'], strtotime($values["InvoiceDate"]))):("");

				if($values['InvoicePaid'] =='Unpaid'){
					$InvoiceStatus =  '<span class="red">'.$values['InvoicePaid'].'</span>';
				 }else{
					if($values['InvoicePaid'] == 'Paid'){
					  	$StatusCls = 'green';
					}else{
						$StatusCls = 'red';
					}
					$InvoiceStatus = '<a  class="fancybox fancybig fancybox.iframe" href="receiveInvoiceHistory.php?edit='.$values['OrderID'].'&InvoiceID='.$values['InvoiceID'].'&IE='.$values['InvoiceEntry'].'&pop=1" ><span class="'.$StatusCls.'">'.$values['InvoicePaid'].'</a>';
				 }



			if($values['SalesPersonType']=='1') {
				$SalesPerson = '<a class="fancybox fancybox.iframe" href="../vendorInfo.php?SuppID='.$values['SalesPersonID'].'">'.stripslashes($values["SalesPerson"]).'</a>';
			}else{
				$SalesPerson = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['SalesPersonID'].'">'.stripslashes($values["SalesPerson"]).'</a>';
			}


			$AjaxHtml  .= '<tr align="left"  class="'.$class.'">
				<td height="20">'.$InvoiceDate.'</td>
				<td><a class="fancybox fancybig fancybox.iframe" href="../finance/vInvoice.php?pop=1&view='.$values['OrderID'].'" >'.$values["InvoiceID"].'</a></td>
				<td>		 
				<a href="../sales/vSalesQuoteOrder.php?module=Order&pop=1&so='.$values['SaleID'].'" class="fancybox fancybig fancybox.iframe">'.$values['SaleID'].'</a>
				</td>


				<td> '.$SalesPerson.' </td>
				<td align="center">'.$values['TotalAmount'].'</td>
				<td align="center">'.$values['CustomerCurrency'].'</td>		
				<td align="center">'.$InvoiceStatus.'</td>			 
			</tr>';
		} // foreach end //


			if($numCount>$num)$AjaxHtml  .= '<tr align="left"  class="'.$class.'" ><td  colspan="7" id="td_pager" align="left"> Pages: '.$pagerLink.'</td></tr>';
		     }else{
		    	$AjaxHtml  .= '<tr align="center" >
		      		<td  class="no_record">'.NO_INVOICE.'</td>
		    		</tr>';
		     }
			$AjaxHtml  .= '</table>';


			
		break;
		/***************************/	
		case 'CustomerCredit':
			$objSale = new sale();			 
			if(!empty($_GET['CustCode']) && $_GET['module']=='Credit'){	
				$arrySaleCredit=$objSale->ListCreditNote($_GET);
				$num = sizeof($arrySaleCredit);
				/***********Count Records****************/	
				$Config['GetNumRecords'] = 1;
				$arryCount=$objSale->ListCreditNote($_GET);
				$numCount=$arryCount[0]['NumCount'];	
				$pagerLink=$objPager->getPaging($numCount,$Config['RecordsPerPage'],$_GET['curP'],$_GET['module']);
			}			
			
			if($num>0){ 
				$AjaxHtml  = '<br><div class="had2">Credit Memo</div><br><table id="list_table" cellspacing="1" cellpadding="5" width="100%" align="center">';
				$AjaxHtml  .= '<tr align="left"  >
					<td width="15%" class="head1" >Posted Date</td>
					<td class="head1" >Credit Memo ID#</td>
					 

					<td width="20%" align="center" class="head1" >Amount</td>
					<td width="15%" align="center" class="head1" >Currency</td>
					<td width="15%"  align="center" class="head1" >Status</td>
					<td width="15%"  align="center" class="head1" >Approved</td>
				</tr>';
 
		  	$flag=true;
			$Line=0;
		  	foreach($arrySaleCredit as $key=>$values){
				$flag=!$flag;
				$class=($flag)?("oddbg"):("evenbg");
				$Line++;	
 
				$PostedDate = ($values["PostedDate"]>0)?(date($_SESSION['DateFormat'], strtotime($values["PostedDate"]))):("");
				$ClosedDate = ($values["ClosedDate"]>0)?(date($_SESSION['DateFormat'], strtotime($values["ClosedDate"]))):("");

				 if($values['Status'] =='Completed'){
                                    $StatusCls = 'green';
                                } else {
                                    $StatusCls = 'red';
                                }

                                $CreditStatus =  '<span class="' . $StatusCls . '">' . $values['Status'] . '</span>';
				
				if ($values['Approved'] == 1) {
                                    $Approved = 'Yes';
                                    $ApprovedCls = 'green';
                                } else {
                                    $Approved = 'No';
                                    $ApprovedCls = 'red';
                                }

                                 $ApproveStatus = '<span class="' . $ApprovedCls . '">' . $Approved . '</span>';


			$AjaxHtml  .= '<tr align="left"  class="'.$class.'">
				<td height="20">'.$PostedDate.'</td>
				<td><a class="fancybox fancybig fancybox.iframe" href="../finance/vCreditNote.php?pop=1&view='.$values['OrderID'].'" >'.$values["CreditID"].'</a></td>
				 
				<td align="center">'.$values['TotalAmount'].'</td>
				<td align="center">'.$values['CustomerCurrency'].'</td>		
				<td align="center">'.$CreditStatus.'</td>
				<td align="center">'.$ApproveStatus.'</td>			 
			</tr>';
		} // foreach end //


			if($numCount>$num)$AjaxHtml  .= '<tr align="left"  class="'.$class.'" ><td  colspan="7" id="td_pager" align="left"> Pages: '.$pagerLink.'</td></tr>';
		   	
		      
			$AjaxHtml  .= '</table>';
			}

			
			break;


		/***************************/	
		case 'VendorInvoice':
			$objPurchase = new purchase();	 
			if(!empty($_GET['SuppCode']) && $_GET['module']=='Invoice'){	
				$Config['PostToGL']=1;
				$arryInvoice=$objPurchase->InvoiceReport('','',$_GET['SuppCode'],'');
				$num = sizeof($arryInvoice);
				/***********Count Records****************/	
				$Config['GetNumRecords'] = 1;
				$arryCount=$objPurchase->InvoiceReport('','',$_GET['SuppCode'],'');
				$numCount=$arryCount[0]['NumCount'];	
				$pagerLink=$objPager->getPaging($numCount,$Config['RecordsPerPage'],$_GET['curP'],$_GET['module']);
			}			
			$AjaxHtml  = '<table id="list_table" cellspacing="1" cellpadding="5" width="100%" align="center">';
			if($num>0){ 
				$AjaxHtml  .= '<tr align="left"  >
						<td  class="head1" >Invoice Number#</td>
						<td width="18%" class="head1" >Invoice Date</td>
						<td width="15%"  class="head1" >PO Number</td>
						<td width="18%" class="head1" >Order Date</td>
						<td width="15%" align="center" class="head1" >Amount</td>
						<td width="8%" align="center" class="head1" >Currency</td>
						<td width="10%"  align="center" class="head1" >Invoice Paid</td>
				    </tr>';
 
		  	$flag=true;
			$Line=0;
			$Flag=0;
		  	foreach($arryInvoice as $key=>$values){
				$flag=!$flag;
				$class=($flag)?("oddbg"):("evenbg");
				$Line++;	
 
				if($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3') {
					$InvoiceLink = '<a href="vOtherExpense.php?pop=1&amp;Flag='.$Flag.'&amp;view='.$values['ExpenseID'].'" class="fancybox po fancybox.iframe">'.$values["InvoiceID"].'</a>';
				 }else{ 
					$InvoiceLink = '<a class="fancybox fancybig fancybox.iframe" href="vPoInvoice.php?pop=1&view='.$values['OrderID'].'" >'.$values["InvoiceID"].'</a>';
				 } 


				$PostedDate = ($values["PostedDate"]>0)?(date($_SESSION['DateFormat'], strtotime($values["PostedDate"]))):("");
 
				$OrderDate = ($values["OrderDate"]>0)?(date($_SESSION['DateFormat'], strtotime($values["OrderDate"]))):("");
				if($values['InvoicePaid'] ==1){
					  $Paid = 'Paid';  $PaidCls = 'green';
				 }elseif($values['InvoicePaid'] == 2){
					  $Paid = 'Partially Paid';  $PaidCls = 'red';
				 }else{
					  $Paid = 'Unpaid';  $PaidCls = 'red';
				 }

				$InvoiceStatus =  '<span class="'.$PaidCls.'">'.$Paid.'</span>';

			$AjaxHtml  .= '<tr align="left"  class="'.$class.'">
				<td height="20">'.$InvoiceLink.'</td>
				<td>'.$PostedDate.'</td>		 
				<td>'.$values["PurchaseID"].'</a>
				</td>
				<td>'.$OrderDate.' </td>
				<td align="center">'.$values['TotalAmount'].'</td>
				<td align="center">'.$values['Currency'].'</td>		
				<td align="center">'.$InvoiceStatus.'</td>			 
			</tr>';
		} // foreach end //


			if($numCount>$num)$AjaxHtml  .= '<tr align="left"  class="'.$class.'" ><td  colspan="7" id="td_pager" align="left"> Pages: '.$pagerLink.'</td></tr>';
	     }else{
	    	$AjaxHtml  .= '<tr align="center" >
	      		<td  class="no_record">'.NO_INVOICE.'</td>
	    		</tr>';
	     }
		$AjaxHtml  .= '</table>';


			
		break;
		

		/***************************/	
		case 'VendorCredit':
			$objPurchase = new purchase();		 
			if(!empty($_GET['SuppCode']) && $_GET['module']=='Credit'){	
				$arryCredit=$objPurchase->ListCreditNote($_GET);
				$num = sizeof($arryCredit);
				/***********Count Records****************/	
				$Config['GetNumRecords'] = 1;
				$arryCount=$objPurchase->ListCreditNote($_GET);
				$numCount=$arryCount[0]['NumCount'];	
				$pagerLink=$objPager->getPaging($numCount,$Config['RecordsPerPage'],$_GET['curP'],$_GET['module']);
			}			
			
			if($num>0){ 
				$AjaxHtml  = '<br><div class="had2">Credit Memo</div><br><table id="list_table" cellspacing="1" cellpadding="5" width="100%" align="center">';
				$AjaxHtml  .= ' <tr align="left"  >
						<td  class="head1" >Credit Memo ID#</td>
						<td width="18%" class="head1" >Posted Date</td>
						 

						<td width="18%" align="center" class="head1" >Amount</td>
						<td width="15%" align="center" class="head1" >Currency</td>
						<td width="15%"  align="center" class="head1" >Status</td>
						 <td width="15%"  align="center" class="head1" >Approved</td>
				    </tr>';
 
		  	$flag=true;
			$Line=0;
		  	foreach($arryCredit as $key=>$values){
				$flag=!$flag;
				$class=($flag)?("oddbg"):("evenbg");
				$Line++;	
 
				$PostedDate = ($values["PostedDate"]>0)?(date($_SESSION['DateFormat'], strtotime($values["PostedDate"]))):("");
				$ClosedDate = ($values["ClosedDate"]>0)?(date($_SESSION['DateFormat'], strtotime($values["ClosedDate"]))):("");

				if($values['Status'] =='Completed'){
					 $StatusCls = 'green';
				 }else{
					 $StatusCls = 'red';
				 }

				$CreditStatus = '<span class="'.$StatusCls.'">'.$values['Status'].'</span>';

                           			
				if ($values['Approved'] == 1) {
                                    $Approved = 'Yes';
                                    $ApprovedCls = 'green';
                                } else {
                                    $Approved = 'No';
                                    $ApprovedCls = 'red';
                                }

                                 $ApproveStatus = '<span class="' . $ApprovedCls . '">' . $Approved . '</span>';


			$AjaxHtml  .= '<tr align="left"  class="'.$class.'">
				<td><a class="fancybox fancybig fancybox.iframe" href="../finance/vPoCreditNote.php?pop=1&view='.$values['OrderID'].'" >'.$values["CreditID"].'</a></td>
				<td height="20">'.$PostedDate.'</td>
				 
				<td align="center">'.$values['TotalAmount'].'</td>
				<td align="center">'.$values['Currency'].'</td>		

				<td align="center">'.$CreditStatus.'</td>
				<td align="center">'.$ApproveStatus.'</td>			 
			</tr>';
		} // foreach end //


		if($numCount>$num)$AjaxHtml  .= '<tr align="left"  class="'.$class.'" ><td  colspan="7" id="td_pager" align="left"> Pages: '.$pagerLink.'</td></tr>';
	   	
	      
		$AjaxHtml  .= '</table>';
		}

			
		break;


		
	}



	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

	

?>
