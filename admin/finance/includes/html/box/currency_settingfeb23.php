
<script language="JavaScript1.2" type="text/javascript">
function GetCurrencyRate(Line){	
	$("#ConversionRate"+Line).val('');
	$("#ConversionRate"+Line).addClass('loaderbox');
 	//$("#currencymsg"+Line).html('<img src="../images/loading.gif">');	
	var FromCurrency = $("#FromCurrency"+Line).val();
	var ConfigCurrency = $("#ConfigCurrency").val();
	if(ConfigCurrency!=FromCurrency){
		var SendUrl ='action=getRealCurrencyRate&FromCurrency='+FromCurrency+'&r='+Math.random(); 
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax.php',
			data: SendUrl,
			success: function (responseText) { 	
				$("#ConversionRate"+Line).val(responseText);
				//$("#currencymsg"+Line).html('');
				$("#ConversionRate"+Line).removeClass('loaderbox');
			}

		});
	}else{
		$("#ConversionRateGl"+Line).val('1');
		//$("#currencymsg"+Line).html('');
		$("#ConversionRate"+Line).removeClass('loaderbox');
			
	}

	
}


  $(function() {
        $( "#accordionCurrency" ).accordion({
		heightStyle: "content",
		duration: 'fast'
		
	});

	$("#accordionCurrency .ui-accordion-content").hide();
  });

</script>
<input type="hidden" name="ConfigCurrency" id="ConfigCurrency" value="<?=$Config['Currency']?>"  readonly />

	
<? 
/*
$ai=0;								
echo '<div id="accordionCurrency" >';
	echo '<h2>abc</h2>';		
   	echo '<table width="100%"  border="0" cellpadding="0" cellspacing="0">
		<tr>
       	 <td  align="left"   class="heading" colspan="4">General Setting</td>
      
      	</tr></table>';
	echo '<h2>pqr</h2>';		
   	echo '<table width="100%"  border="0" cellpadding="0" cellspacing="0">
		<tr>
       	 <td  align="left"   class="heading" colspan="4">General Setting</td>
      
      	</tr></table>';
$ai++;

echo '</div>';  
*/							
?>



<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<?
/****************************/
$arrySettingCurrency = $objCommon->getCurrencySetting();
foreach ($arrySettingCurrency as $key => $values) {
	$arryCurrencyVal[$values['FromCurrency'].'-'.$values['ToCurrency']] = $values['ConversionRate'];
}
/****************************/

//////currency settings
$rateIcon = '<img src="'.$Config['Url'].'admin/images/calcul.png" border="0"  onMouseover="ddrivetip(\'<center>Get Current Rate</center>\', 100,\'\')"; onMouseout="hideddrivetip()" style="margin-left:-25px;  vertical-align: sub;">';
$Config['RealTime']=1;
if(!empty($arryCompany[0]['AdditionalCurrency']) && $arryCompany[0]['AdditionalCurrency']!=$Config['Currency']){	
	$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

	echo '<tr><td  align="left"  class="heading" colspan="4">Currency Settings [Base Currency: '.$Config['Currency'].']</td></tr>';


	if($arrySettingCurrency[0]['FromDate']>0) $CurrencyFromDate=$arrySettingCurrency[0]['FromDate'];
	if($arrySettingCurrency[0]['ToDate']>0) $CurrencyToDate=$arrySettingCurrency[0]['ToDate'];
?>


<tr>
				<td align="right" class="blackbold">Currency Period :</td>
				 <td   >
                                                            Start :
                                                            <input type="text" name="CurrencyFromDate" maxlength="30" class="datebox" id="CurrencyFromDate" value="<?=$CurrencyFromDate?>">

                                                            <script type="text/javascript">
                                                                $(function() {
                                                                    $('#CurrencyFromDate').datepicker(
                                                                            {
                                                                                showOn: "both",
                                                                                yearRange: '<?=date("Y")-2 ?>:<?= date("Y")+2 ?>', 
                                                                                //maxDate: "-1D", 
                                                                                dateFormat: 'yy-mm-dd',
                                                                                changeMonth: true,
                                                                                changeYear: true,
                                                                                //minDate:'0d'

                                                                            }
                                                                    );

$("#CurrencyFromDate").on("click", function () { 
			 $(this).val("");
		}
	);				




                                                                });
                                                            </script>
                                                        &nbsp;&nbsp;&nbsp;End :
                                                            <input type="text" name="CurrencyToDate" maxlength="30" class="datebox" id="CurrencyToDate" value="<?=$CurrencyToDate?>">

                                                            <script type="text/javascript">
                                                                $(function() {
                                                                    $('#CurrencyToDate').datepicker(
                                                                            {
                                                                                showOn: "both",
                                                                                yearRange: '<?= date("Y")-2 ?>:<?= date("Y")+2 ?>', 
                                                                                //maxDate: "-1D", 
                                                                                dateFormat: 'yy-mm-dd',
                                                                                changeMonth: true,
                                                                                changeYear: true,
                                                                                //minDate:'0d'

                                                                            }
                                                                    );

$("#CurrencyToDate").on("click", function () { 
			 $(this).val("");
		}
	);



                                                                });
                                                            </script>
                                                        </td>
</tr>

<?  
$CountC=0;

for($i=0;$i<sizeof($arrySelCurrency);$i++) {
	if($arrySelCurrency[$i]!=$Config['Currency']){
 
		$CurrencyVal = $arryCurrencyVal[$arrySelCurrency[$i]."-".$Config['Currency']];
		if(!empty($CurrencyVal)){
			$ConversionRate=$CurrencyVal;
		}else{
			$ConversionRate=CurrencyConvertor(1,$arrySelCurrency[$i],$Config['Currency']);
		}

	$CountC++;


	if($CountC=='1') echo '<tr>';
?>

	<td align="right" class="blackbold"   > 
	<?=$arrySelCurrency[$i]?>   :
	</td>
	<td align="left">
	 <input type="text" name="ConversionRate[]" size="20" maxlength="10" onkeypress="return isDecimalKey(event);" class="textbox" id="ConversionRate<?=$i?>" value="<?=$ConversionRate?>">

	  <input type="hidden" name="FromCurrency[]"  readonly id="FromCurrency<?=$i?>" value="<?=$arrySelCurrency[$i]?>">	
	
	<a href="Javascript:GetCurrencyRate(<?=$i?>);"><?=$rateIcon?></a>

	<?
		$NotSaved = (!empty($CurrencyVal))?(''):('Not Saved');
		echo '<span class=red id="currencymsg'.$i.'"> '.$NotSaved.'</span>';
	?>

 </td>

<? 	
	if($CountC%2==0) echo '</tr><tr>';


	} 
	} 

}

?>
</table> 



