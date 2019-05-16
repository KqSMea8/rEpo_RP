<?
$content ='<table '.$table_bg.'>
		<tr align="left"  >
			<td class="head1" width="10%">Customer Code</td>  
			<td class="head1" >Customer Name</td> 
			<td class="head1" width="15%">Sales Person</td>       
			<td class="head1" width="13%">Phone</td>    
			<td class="head1" width="15%">Contact</td>
			<td class="head1" width="13%">Credit Limit</td>               
			<td class="head1" width="13%">VAT</td> 
			             
		</tr>';
		
		if(is_array($arryRecord) && $num>0){
			$flag=true;
			$Line=0;
			foreach($arryRecord as $key=>$values){
				$flag=!$flag;
				$bgclass = (!$flag)?("oddbg"):("evenbg");
				$Line++;

				$SalesPerson = '';
				if(!empty($ExportFile)){
					$CustCode =  $values['CustCode'];
					$SalesPerson =  stripslashes($values['SalesPerson']);
				}else{
					$CustCode = '<a class="fancybox fancybox.iframe" href="../custInfo.php?CustID='.$values['CustID'].'" >'.$values['CustCode'].'</a>';
					 if(!empty($values['SalesPerson'])){
						$SalesPerson = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['SalesPersonID'].'" >'.stripslashes($values['SalesPerson']).'</a>';
					} 
				}


				$CreditLimit = (!empty($values['CreditLimitCurrency']) && !empty($values['CustCurrency']) && $values['CustCurrency']!=$Config['Currency'])?($values['CreditLimitCurrency'].' '.$values['CustCurrency']):($values['CreditLimit']); 


				$content .='<tr>
					<td height="20" >'.$CustCode.'</td>
					<td>'.stripslashes($values["Customer"]).'</td>
					<td>'.$SalesPerson.'</td>
					<td>'.$values['Landline'].'</td>
					<td>'.stripslashes($values['ContactPerson']).'</td>				 
					<td>'.$CreditLimit.'</td>
					<td>'.$values['VAT'].'</td>
				</tr>';

			}
		}else{
				$content .='<tr align="center" >
				<td  colspan="7" class="no_record">'.NO_RECORD.'</td>
				</tr>';
		}   

		
		if(empty($ExportFile)){
			$PageLink='';
			if(count($arryRecord)>0){ $PageLink = '&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp;  '.$pagerLink; }
			$content .= '<tr>  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;'.$num.'	'.$PageLink.'	
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

//echo $content; exit;
?>

