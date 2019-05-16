
<tr>
	 <td valign="top">

	 </td>
	
	
	 <td align="left" valign="top" id="checktd" style="<?=$BoxStyle?>">

<div id="check-wrapper" style="width:650px;height:270px; padding:10px;background-color:#aedfee"  onclick="Javascript:ClearMsg()";>


  

<?
/*************cmp**********************/
$cmpStyle = !empty($arryTemplate[0]['cmpStyle'])?($arryTemplate[0]['cmpStyle']):('width:220px;line-height:15px;min-height:60px;');

echo '<div class="draggable" id="cmp" style="'.$cmpStyle.'" onclick="Javascript:SelectBox(this)"; onblur="Javascript:UnSelectBox()"; tabindex="1">';
	$CmpInfo =  '<strong>'.stripslashes($arryCompany[0]['CompanyName']).'</strong><br>';

	$CountryName = stripslashes($arryCurrentLocation[0]["Country"]);
	$StateName = stripslashes($arryCurrentLocation[0]['State']);
	$StateCode = stripslashes($arryCurrentLocation[0]['StateCode']);
	$CityName = stripslashes($arryCurrentLocation[0]['City']);
	if(!empty($arryCurrentLocation[0]['Address'])) $Address =  stripslashes($arryCurrentLocation[0]['Address']).'<br>';		   
	if(!empty($CityName)) $Address .= htmlentities($CityName, ENT_IGNORE).', ';
	if(!empty($StateCode)) $Address .= $StateCode.',<br>';		   
	else if(!empty($StateName)) $Address .= $StateName.',<br>';		   
	if(!empty($CountryName)) $Address .= $CountryName;		   
	if(!empty($arryCurrentLocation[0]['ZipCode'])) $Address .= ' - '. $arryCurrentLocation[0]['ZipCode'];	
			   
	$CmpInfo .= (!empty($Address))?($Address):('');

	echo $CmpInfo;

echo '</div>';

/***********checknumber********************/
$checknumberStyle = !empty($arryTemplate[0]['checknumberStyle'])?($arryTemplate[0]['checknumberStyle']):("left: 520px;position: relative; top:-60px;width: 120px;font-weight:500;font-size:14px;min-height:25px;");

echo '<div class="draggable" align="right" id="checknumber" style="'.$checknumberStyle.'">'.$CheckNumber.'</div>';


/***********date********************/
$dateStyle = !empty($arryTemplate[0]['dateStyle'])?($arryTemplate[0]['dateStyle']):("left: 460px;position: relative;right: auto;top: -40px;width: 180px;font-weight:bold;");
$LabelDateStyle = !empty($arryTemplate[0]['LabelDateStyle'])?($arryTemplate[0]['LabelDateStyle']):("");

echo '<div class="draggable" id="date" align="right" style="'.$dateStyle.'"><span id="LabelDate" style="'.$LabelDateStyle.'">DATE :</span> <span class="inputtext" style="width:100px;" id="dt">';
if($PaymentDate>0) 
   echo $Date = date($Config['DateFormat'], strtotime($PaymentDate));
echo '</span></div>';


/***********pay********************/
$payStyle = !empty($arryTemplate[0]['payStyle'])?($arryTemplate[0]['payStyle']):("left: 3px;position: relative;right: auto;top: -4px;width: 420px;min-height:30px;font-weight:600;");
$LabelPayStyle = !empty($arryTemplate[0]['LabelPayStyle'])?($arryTemplate[0]['LabelPayStyle']):("");

echo '<div class="draggable" id="pay" style="'.$payStyle.'"><span id="LabelPay" style="'.$LabelPayStyle.'">PAY :</span> '.$VendorName.'
<span class="inputtext" id="py"  style="width:370px;display:block;position:absolute;top:1px;">&nbsp;</span>
</div>';

/***********word********************/
$wordStyle = !empty($arryTemplate[0]['wordStyle'])?($arryTemplate[0]['wordStyle']):("left: 3px;position: relative;right: auto;top: -8px;width: 420px;min-height:30px;font-weight:600;");
echo '<div class="draggable" id="word" style="'.$wordStyle.'">';

echo '<span class="inputtext" id="word1"  style="width:370px;display:block;position: absolute;top:1px;font-weight:500;">';
if($CheckAmount>0){
	if($Config['Currency']=='INR'){
		$AmountInWords = ConvertNumberToWords($CheckAmount);
	}else if($Config['Currency']=='USD'){
		$AmountInWords = ConvertNumberToWordsUS($CheckAmount);
		if(strpos($AmountInWords, 'dollar') == false) {
			$AmountInWords .= ' dollars';	
		}
	}else{
		$AmountInWords = convert_number_to_words($CheckAmount);
	}
	echo ucwords($AmountInWords).' Only';
} 

echo '</span>
<span id="word2"  style="width:30px;display:block;position: absolute;right:10px;top:5px;">'.$Config['Currency'].'</span>
</div>';


/***********currency********************/
$currencyStyle = !empty($arryTemplate[0]['currencyStyle'])?($arryTemplate[0]['currencyStyle']):("left: 460px;position: relative;right: auto;top: -50px;width: 30px;font-weight:bold;");
echo '<div class="draggable" id="currency" align="right" style="'.$currencyStyle.'">  &nbsp;
<span class="inputamnt" style="width:150px;position:absolute;top:-1px;" id="curr">'.number_format($CheckAmount,2).'&nbsp;</span>
</div>';

/***********VendorAddress********************/
$VendorAddressStyle = !empty($arryTemplate[0]['VendorAddressStyle'])?($arryTemplate[0]['VendorAddressStyle']):('left: 3px;width:250px;line-height:16px;min-height:60px;top: -25px;');
echo '<div class="draggable" id="VendorAddress" style="'.$VendorAddressStyle.'">'.$VendorAddress.'</div>';

/***********memo********************/
$memoStyle = !empty($arryTemplate[0]['memoStyle'])?($arryTemplate[0]['memoStyle']):("left: 3px;position: relative;right: auto;top: -10px;width: 630px;min-height:40px;font-weight:bold;");
$LabelMemoStyle = !empty($arryTemplate[0]['LabelMemoStyle'])?($arryTemplate[0]['LabelMemoStyle']):("");

echo '<div class="draggable" id="memo" style="'.$memoStyle.'"><span id="LabelMemo" style="'.$LabelMemoStyle.'">MEMO</span>
<span class="inputtext" id="fr"  style="width:290px; display:block; position:absolute;top:1px;">&nbsp;</span> 
<span class="inputtext" id="fr"  style="width:290px; display:block; position:absolute;left:340px;top:1px;">&nbsp;</span>
 <br>
</div>';

?>

    


 
</div>



 
	 </td>
	
	</tr>
	
