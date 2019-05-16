<?php  
	include_once("../includes/settings.php");
	require_once($Prefix . "classes/item.class.php");
	
	
	$objItem = new items();
	$arrySale=$objItem->GetSerialValuationReport($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['c']);
$num=$objItem->numRows();


$ExportFile = "ValuationReport_".date('d-m-Y').".xls";
if($num>0){


		   foreach($arrySale as $key=>$values){
		        $checkProduct=$objItem->checkItemSku($values['Sku']);
             $arryCat =$objItem->GetMainCategory($checkProduct[0]['CategoryID']);
              $Unitcost = ($values['srQt']>0)?($values['conAmt']/$values['srQt']):(0) ;
              $qtyonhand = $values['srQt'];
             $totalamount = $Unitcost * $qtyonhand; 
                if($arryCat[0]['Name']!=''){
                $newarray2[] = array('CatID'=>$arryCat[0]['CategoryID'],'Name' => $arryCat[0]['Name'],  'qtyonhand' => $qtyonhand, 'totalamount' => $totalamount);
                }
               
            }
         

	
	////////////////////////////////////////////////////
	
	
	
	
		$result =array();
foreach($newarray2 as $key=>$val){
if(array_key_exists($val['CatID'], $result)){
$result[$val['CatID']]['qtyonhand'] += $val['qtyonhand'];
$result[$val['CatID']]['totalamount'] += $val['totalamount'];
}else{
$result[$val['CatID']]=$val;
}
}
	
	
	
	
	
$content ='<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable" >
<tr align="left" class="RowFirst">';
$content .= '<td class="head1" nowrap ><strong>Sku</strong></td>';
$content .= '<td class="head1" nowrap ><strong>Condition</strong></td>';
$content .= '<td class="head1" nowrap ><strong>Quantity</strong></td>';
$content .= '<td class="head1" align="right" nowrap ><strong>Cost</strong></td>';
$content .= '<td class="head1" align="right" nowrap ><strong>Total Cost</strong></td>';
$content .= '</tr>';

	
	
		//$num = sizeof($result);
		if(is_array($result)){
		$flag=true;
		//$Line=0;
		$Unitcost=0.00;
		$qtyonhand =0;
		$totalCost =0.00;
		foreach($result as $key=>$values){
		
    $Unitcost = ($values['qtyonhand']>0)?($values['totalamount']/$values['qtyonhand']):(0) ;
    $qtyonhand = $values['qtyonhand'];
    $totalamount = $Unitcost * $qtyonhand;
    $totalCost +=$totalamount;		
   
    $_GET['Status']=1;
    $arryCat=$objItem->categoryChild($values['CatID']);
    $result =array(); 
    $_GET['InData'] = $arryCat.$values['CatID'];
    $_GET['InData'] = preg_replace('/^,+|,+$/', '', $_GET['InData']);
    $_GET['CatID'] ='';     
        $arryQuant=$objItem->GetSerialqtyAvg($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['c'],$values["Sku"],$_GET['InData']);    
	//$line2 = " \t Sku\tCondition\tQuantity\tCost\tTotal Cost";
       $data .= trim($line2)."\n";
         if (is_array($arryQuant)) {
                $flag = true;
                //$Line = 0;
                   foreach ($arryQuant as $key => $val) {
                   $Unitcostamt = ($val['srQt']>0)?($val['conAmt']/$val['srQt']):(0) ;
                   $qtyonhand2 = $val['srQt'];
                   $totalamt = $Unitcostamt * $qtyonhand2; 
                   $totalValue +=$totalamt; 
                   $toalQty += $qtyonhand2;   
                   
                   $content .='<tr align="left" class="'.$bgclass.'">';
                   $content .='<td >'.$val['Sku'].'</td>';
                   $content .='<td >'.$val['Condition'].'</td>';
                   $content .='<td >'.$qtyonhand2.'</td>';
                   //$content .='<td align="right">'.$Config['Currency'].'  '.number_format($Unitcostamt,2,'.','').'</td>';
                   //$content .='<td align="right">'.$Config['Currency'].'  '.number_format($totalamt,2,'.','').'</td>';
                   $content .='<td align="right"> '.number_format($Unitcostamt,2,'.','').'</td>';
                   $content .='<td align="right">'.number_format($totalamt,2,'.','').'</td>';
                   $content .='</tr>';
                                                                                   
                }
      
         }  
         	$content .='<tr >
<td  colspan="5" class="no_record"></td>
</tr>';
         
         
                   $content .='<tr align="left" class="'.$bgclass.'">';
                   $content .='<td ><strong>'.$values['Name'].'</strong></td>';
                   $content .='<td colspan="3" ></td>';
                   $content .='<td align="right"><strong>'.$Config['Currency'].' '.number_format($totalValue,2,'.','').'</strong></td>';
                   $content .='</tr>';
        
     	$content .='<tr >
<td  colspan="5" class="no_record"></td>
</tr>';
        
		 } // foreach end
		 
			$content .='<tr align="right" bgcolor="#FFF">
		<td  colspan="4"><strong>Total Amount :</strong></td>
		<td  ><strong> '.$Config['Currency'].'  '.number_format($totalCost,2).' </strong></td>
		</tr>';


		 }else{
	$content .='<tr >
<td  colspan="4" class="no_record">'.NO_RECORD.'</td>
</tr>';
		
	 } 

	
	
	
	
	
	

/****************** START SECOND ROW *****************/
/*****************************************************/

$content .='</table>';

if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}

	
	}
	
	
	
	?>
	
	
	

