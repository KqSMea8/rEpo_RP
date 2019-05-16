<? 
$content = '<table '.$table_bg.'>
	<tr align="left"  >';

$content .= '<td width="9%" class="head1">Customer Code</td>	
		<td width="10%" class="head1">Customer Name</td>
		<td width="9%" class="head1" align="right">Sales Amount['.$Config['Currency'].']</td>	
	</tr>';


	if(is_array($arryData) && $num>0){  
		$flag=true;
		$Line=0;
		$TotalSales = 0;
		foreach($arryData as $key=>$values){
			$flag=!$flag;
			$bgclass = (!$flag)?("oddbg"):("evenbg");
			$Line++;		 
			$SalesAmount = round($values['SalesAmount'],2); 
			$TotalSales += $SalesAmount;
	       		/**************************/
			if(!empty($ExportFile)){
				$CustomerName = stripslashes($values["CustomerName"]);
				$CustomerCode = stripslashes($values["CustCode"]);
				$SalesAmountShow = number_format($SalesAmount,2); 	 
			}else{ 
				$CustomerCode = '<a class="fancybox fancybox.iframe" href="../custInfo.php?CustID='.$values['CustID'].'" ><b>'.stripslashes($values["CustCode"]).'</b></a>';
				 $SalesAmountShow = '<a class="fancybox fancybig fancybox.iframe"  href="vSalesHistory.php?c='.$values['CustCode'].'&'.$QueryString.'" ><strong>'.number_format($SalesAmount,2).'</strong></a>';
			}			
			/**************************/	
		  	$content .= '<tr align="left" class="'.$bgclass.'">
				<td>'.$CustomerCode.'</td>		
				<td>'.$values['CustomerName'].'</td>
				<td align="right">'.$SalesAmountShow.'</td>	
				</tr>';	 
		
	   } 

		$TotalSales = round($TotalSales,2);
		$content .='<tr> 
		<td align="right" colspan="3"><strong>Total Sales : '.number_format($TotalSales,2).'</strong></td>	
		</tr>';	 
		

	}else{
		$content .= '<tr align="center" >
		<td  colspan="12" class="no_record">'.NO_RECORD.'</td>
		</tr>';
	} 


	if(empty($ExportFile)){

			if($num>0){ $PageLink = '&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp;  '.$pagerLink; 
				$content .= '<tr>  <td  colspan="12"  id="td_pager">Total Record(s) : &nbsp;'.$num.'	'.$PageLink.'	
				</td>
				</tr>';
			}
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

