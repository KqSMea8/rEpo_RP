
<tr>
	
	 <td valign="top">
<? if($ToolbalShown!=1){  
  
	$ToolbalShown=1;
	
	$StubTD = 'stub-td';
	$StubDivID = 'stub-wrapper';
	$draggablestubClass = 'draggablestub';

 
}else{
	$StubTD = 'stub-td2';
	$StubDivID = 'stub2-wrapper';
	$draggablestubClass = 'draggable2stub';
}
?>
	 </td>
	




	 <td align="left" valign="top" id="<?=$StubTD?>" style="<?=$BoxStyle?>">

<div id="<?=$StubDivID?>" style="width:650px;height:270px; padding:10px;background-color:#aedfee">

<?
/*************cmp**********************/
$cmpStubStyle = !empty($arryTemplate[0]['cmpStubStyle'])?($arryTemplate[0]['cmpStubStyle']):('width:220px;line-height:14px;');
echo  '<div class="'.$draggablestubClass.'" id="cmpStub" style="'.$cmpStubStyle.'"><strong>'.stripslashes($arryCompany[0]['CompanyName']).'</strong></div>';

/***********checknumber********************/
$checknumberStubStyle = !empty($arryTemplate[0]['checknumberStubStyle'])?($arryTemplate[0]['checknumberStubStyle']):('left: 520px;position: relative; top:-20px;width: 120px;font-weight:500;font-size:14px;');
echo '<div class="'.$draggablestubClass.'" align="right" id="checknumberStub" style="'.$checknumberStubStyle.'">'.$_GET['Chk'].'</div>';

/***********date********************/
$dateStubStyle = !empty($arryTemplate[0]['dateStubStyle'])?($arryTemplate[0]['dateStubStyle']):('left: 460px;position: relative;right: auto;top: -15px;width: 180px;font-weight:bold;');
$LabelDateStubStyle = !empty($arryTemplate[0]['LabelDateStubStyle'])?($arryTemplate[0]['LabelDateStubStyle']):("");

echo '<div class="'.$draggablestubClass.'" id="dateStub" align="right" style="'.$dateStubStyle.'"><span id="LabelDateStub" style="'.$LabelDateStubStyle.'">DATE :</span>  <span class="inputtext" style="width:100px;" id="dtStub">';
if($_GET['Date']>0) 
   echo date($Config['DateFormat'], strtotime($_GET['Date']));
echo '</span></div>';

/***********pay********************/
$payStubStyle = !empty($arryTemplate[0]['payStubStyle'])?($arryTemplate[0]['payStubStyle']):('left: 3px;position: relative;right: auto;top: 0px;width: 250px;font-weight:600;');
$LabelPayStubStyle = !empty($arryTemplate[0]['LabelPayStubStyle'])?($arryTemplate[0]['LabelPayStubStyle']):("");

echo '<div class="'.$draggablestubClass.'" id="payStub" style="'.$payStubStyle.'"><span id="LabelPayStub" style="'.$LabelPayStubStyle.'">VENDOR :</span> '.$VendorName.'</div>';

/***********Currency********************/
$currencyStubStyle = !empty($arryTemplate[0]['currencyStubStyle'])?($arryTemplate[0]['currencyStubStyle']):('left: 460px;position: relative;right: auto;top: 35px;width: 30px;font-weight:bold;');

echo '<div class="'.$draggablestubClass.'" id="currencyStub" align="right" style="'.$currencyStubStyle.'">'.$Config['CurrencySymbol'].' &nbsp;
<span class="inputamnt" style="width:150px;position:absolute;top:-1px;" id="currStub">'.number_format($CheckAmount,2).'&nbsp;</span>
</div>';

/*********Invoice**************/
$invoiceStubStyle = !empty($arryTemplate[0]['invoiceStubStyle'])?($arryTemplate[0]['invoiceStubStyle']):('left: 3px;position: relative; top: -10px;width: 400px;font-weight:400; '); 
echo '<div class="'.$draggablestubClass.'" id="invoiceStub" style="'.$invoiceStubStyle.'">';

$invLine=0;
foreach($valuesven as $key=>$values){
	$InvoiceID=''; $InvoiceDate =''; $Ref = '';
	$invLine++;
	if($invLine==11) break;
	if($values['PaymentType']=='Invoice'){				 
		$InvoiceDate = $values['PostedDate'];
		$InvoiceID = $values['InvoiceID'];
		if(!empty($values['PurchaseID'])) $Ref = ', Ref# '.$values['PurchaseID'];
	}else if($values['PaymentType']=='Contra Invoice'){					 
		$InvoiceDate = $values['InvoiceDate'];
		$InvoiceID = $values['InvoiceID'];
		
	}else if($values['PaymentType']=='Credit'){					 
		$InvoiceID = $values['CreditID'];
		$InvoiceDate = $values['PostedDate'];
	}

	echo $InvoiceID.$Ref.', '.date($Config['DateFormat'], strtotime($InvoiceDate)).', '.$Config['CurrencySymbol'].' '.number_format($values['Amount'],2).'<br>';
	
}
echo '</div>';

?>




 
</div>

	</td>

	</tr>	


