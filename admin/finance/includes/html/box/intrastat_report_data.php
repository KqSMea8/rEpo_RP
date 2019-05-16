<? 
$content = '<table '.$table_bg.'>
	<tr align="left"  > 
		<td class="head1">Category Name</td>			
		<td width="20%" class="head1">Quantity</td>
		<td width="20%" class="head1">Amount ['.$Config['Currency'].']</td>	
	</tr>';
 
 

if($num>0){
	$flag=true;
	$Line=0;
	$TotalQty = 0;
	$TotalSales = 0;
	foreach($arryData as $key=>$values){
		$flag=!$flag;
		$bgclass = (!$flag)?("oddbg"):("evenbg");
		$Line++;	
		
		unset($_SESSION['CatName']);
		$_SESSION['CatCount']=0;
		if($values['CategoryID']>0){
			$objCategory->GetCategoryTree($values['CategoryID']);
			$CatName = implode(" >> ", array_reverse($_SESSION['CatName']));			 	
		} 
		if(empty($CatName))$CatName = 'Unknown';
		 

		$content .='<tr align="left" class="'.$bgclass.'">
			<td>'.$CatName.'  </td>			
			<td>'.$values['Qty'].'</td>
			<td>'.number_format($values['LineAmount'],2).'</td>	
			</tr>';	 

		$TotalQty += $values['Qty'];
		$TotalSales +=  $values['LineAmount'];
   } 

	$content .='<tr ><td align="right"> <strong>Total :</strong> </td>		
		<td><strong>'.$TotalQty.'</strong></td>
		<td><strong>'.number_format($TotalSales,2).'</strong></td>	
		</tr>';	 
		

	}else{
		$content .= '<tr align="center" >
		<td  colspan="3" class="no_record">'.NO_RECORD.'</td>
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

