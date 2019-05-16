<? 
//<td class="head1" width="10%">Due Date</td>  
$content = '<table '.$table_bg.'> 
	<tr align="left">
			<td class="head1" width="11%" >Invoice Date</td>    
			<td class="head1" >Invoice/Credit Memo #</td>   
			<td class="head1" width="16%">Payment Term</td>   
			
			<td class="head1" width="13%">PO #</td>
			<td class="head1" width="13%">Order Source</td>               
			<td class="head1" width="12%" align="right">Invoice Amount</td>  
			<td class="head1" width="15%" align="right">Sales Amount ['.$Config['Currency'].']</td> 		
		</tr>
	</tr>';


	if(is_array($arryData) && $num>0){  
		$flag=true;
		$TotalSalesAmount=0;
		$Line=0;
		foreach($arryData as $key=>$values){
			$flag=!$flag;
			 $bgclass = (!$flag)?("oddbg"):("evenbg");				
 
				$Line++;
				  
			 
 		/***********************/
		$ModuleDate=''; $ModuleLink='';$orginalAmount=0;
		if($values['Module']=='Invoice'){
			$orginalAmount = $values['TotalInvoiceAmount'];
			$ModuleDate=$values['InvoiceDate'];

			if(!empty($ExportFile)){
				$ModuleLink = $values["InvoiceID"];
			}else{	

				if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){
					$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoiceGl.php?view='.$values['OrderID'].'&pop=1">'.$values["InvoiceID"].'</a>';
				}else{
					$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?view='.$values['OrderID'].'&IE='.$values['InvoiceEntry'].'&pop=1">'.$values["InvoiceID"].'</a>';
				}
			}			 

		}else if($values['Module']=='Credit'){
			$orginalAmount = -$values['TotalAmount'];
			$ModuleDate=$values['PostedDate'];

			if(!empty($ExportFile)){
				if($values['OverPaid']=='1'){
					$ModuleLink=$values["InvoiceID"];
				}else{
					$ModuleLink=$values["CreditID"];
				}
			}else{

				if($values['OverPaid']=='1'){
					$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?inv='.$values['InvoiceID'].'&pop=1">'.$values["InvoiceID"].'</a>';
				}else{
					$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vCreditNote.php?view='.$values['OrderID'].'&pop=1">'.$values["CreditID"].'</a>';
				}
			}
			 

		}
		/***********************
		$DueDate = '';
		if(!empty($values["PaymentTerm"])){
			$PaymentTerm = strtolower(trim($values["PaymentTerm"]));
			$arryTerm = explode("-",$values["PaymentTerm"]);
			$arryDate = explode("-",$ModuleDate);
			list($year, $month, $day) = $arryDate;

			if($PaymentTerm=='end of month'){				 
				$TempDate  = mktime(0, 0, 0, $month+1 , 1, $year);	
				$DueDate = date("Y-m-t",$TempDate);
				$DueDate = date($Config['DateFormat'], strtotime($DueDate));
			}else if($arryTerm[1]>0){//term
				$TempDate  = mktime(0, 0, 0, $month , $day+$arryTerm[1], $year);	
				$DueDate = date("Y-m-d",$TempDate);
				$DueDate = date($Config['DateFormat'], strtotime($DueDate));
			}
		} 
		/***********************/

			$SalesAmount = round($values["SalesAmount"],2);
			$TotalSalesAmount +=$values["SalesAmount"];

			$content .=  '<tr align="left" bgclass="'.$bgclass.'">               
				<td>'.date($Config['DateFormat'], strtotime($ModuleDate)).'</td>
				<td>'.$ModuleLink.'</td>
				<td>'.stripslashes($values["PaymentTerm"]).'</td>
				 
				<td>'.$values["CustomerPO"].'</td>
				<td>'.$values["OrderSource"].'</td>
				 <td align="right">'.$orginalAmount. ' '.$values["CustomerCurrency"].'</td>
				<td  align="right">'.number_format($SalesAmount,2).'</td>
		 		</tr>';
				
			}
		}	
		
			$TotalSalesAmount = round($TotalSalesAmount,2);			
			

			$content .= '<tr align="left" bgcolor="'.$bgcolor.'" > 						
					 <td colspan="6" align="right"><b>Total Sales Amount :</b> </td>	
					<td  align="right"><b>'.number_format($TotalSalesAmount,2).'</b></td>		      
				        
				 </tr>';
 		 
	$content .= '</table>';
		 
if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}


?>

