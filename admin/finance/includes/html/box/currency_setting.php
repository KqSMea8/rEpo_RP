<?
$rateIcon = '<img src="'.$Config['Url'].'admin/images/calcul.png" border="0"  onMouseover="ddrivetip(\'<center>Get Current Rate</center>\', 100,\'\')"; onMouseout="hideddrivetip()" style="margin-left:-25px;  vertical-align: sub;">';
$Config['RealTime']=1;

if(empty($_SESSION['CurrencyIndex'])){
		$_SESSION['CurrencyIndex']=0;
	}

$history = '<img src="'.$Config['Url'].'admin/images/history.png" border="0"  onMouseover="ddrivetip(\'<center>Currency Log</center>\', 80,\'\')"; onMouseout="hideddrivetip()" >';

?>
<script language="JavaScript1.2" type="text/javascript">
function GetCurrencyRateMultiple(x,y){	
	var IDSuffix = x+'_'+y;
	$("#ConversionRate"+IDSuffix).val('');
 	var ConversionRate = $("#ConversionRate"+IDSuffix).val();
 	var FromCurrency = $("#FromCurrency"+IDSuffix).val();
	var ConfigCurrency = $("#ConfigCurrency").val();
	$("#ConversionRate"+IDSuffix).addClass('loaderbox');
	if(ConfigCurrency!=FromCurrency){
		var SendUrl ='action=getRealCurrencyRate&FromCurrency='+FromCurrency+'&r='+Math.random(); 
		$.ajax({
			type: "GET",
			async:false,
			url: 'ajax.php',
			data: SendUrl,
			success: function (data) { 	
			$("#ConversionRate"+IDSuffix).val(data);
				$("#currencymsg"+IDSuffix).html('');
				$("#ConversionRate"+IDSuffix).removeClass('loaderbox');
			}

		});
	}else{
		$("#ConversionRate"+IDSuffix).val('1');
		$("#ConversionRate"+IDSuffix).removeClass('loaderbox');
			
	}

	
}



function DateRangeTo(x,y){

    var IDSuffix = x+'_'+y;
    var DateRangeVal = $("#DateRange"+IDSuffix).val();

     $("#CurrencyFromDate"+IDSuffix).next(".ui-datepicker-trigger").hide();


    if(DateRangeVal==1){  
	$("#CurrencyFromDate"+IDSuffix).show();    	
	$("#CurrencyToDate"+IDSuffix).hide();
	$("#CurrencyFromDate"+IDSuffix).attr("placeholder","");   

	$("#CurrencyFromDate"+IDSuffix).next(".ui-datepicker-trigger").show();
	$("#CurrencyToDate"+IDSuffix).next(".ui-datepicker-trigger").hide(); 	
    }else if(DateRangeVal==2){  
	$("#CurrencyFromDate"+IDSuffix).show();  	
    	$("#CurrencyToDate"+IDSuffix).show();
	$("#CurrencyFromDate"+IDSuffix).attr("placeholder","Start");

	$("#CurrencyFromDate"+IDSuffix).next(".ui-datepicker-trigger").show();
	$("#CurrencyToDate"+IDSuffix).next(".ui-datepicker-trigger").show();
    }else{
	$("#CurrencyFromDate"+IDSuffix).hide();
    	$("#CurrencyToDate"+IDSuffix).hide();
	$("#CurrencyFromDate"+IDSuffix).attr("placeholder","");
 
	$("#CurrencyFromDate"+IDSuffix).next(".ui-datepicker-trigger").hide();
	$("#CurrencyToDate"+IDSuffix).next(".ui-datepicker-trigger").hide();
    }

}

function SetCurrencyIndex(SelID){
	document.getElementById("CurrencyIndex").value=SelID;
}


  $(function() {
        $( "#accordionCurrency" ).accordion({
		heightStyle: "content",
		duration: 'fast',
		active: <?=$_SESSION["CurrencyIndex"]?>
	});

	//$("#accordionCurrency .ui-accordion-content").hide();
  });

</script>

<style>
 .ui-accordion .ui-accordion-content{padding:4px !important}
</style>
<input type="hidden" name="ConfigCurrency" id="ConfigCurrency" value="<?=$Config['Currency']?>"  readonly />
<input type="hidden" name="CurrencyIndex" id="CurrencyIndex" value="<?=$_SESSION['CurrencyIndex']?>">
	
<? 
if(!empty($arryCompany[0]['AdditionalCurrency']) && $arryCompany[0]['AdditionalCurrency']!=$Config['Currency']){
	$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

	echo '<div  class="heading">Currency Settings [Base Currency: '.$Config['Currency'].']</div>';
							
	echo '<div id="accordionCurrency" >';
	for($x = 0; $x < sizeof($arrayModule); $x++) { //Start Module Loop
		$CountC=0;
		unset($arrySettingCValue); unset($arrySettingCurrencyVAl);
		$arrySettingCurrencyVAl = $objCommon->GetConversionValue($arrayModule[$x]); //Get from DB

		foreach ($arrySettingCurrencyVAl as $key => $values) {
			$Currency  = $values['FromCurrency'];
			$arrySettingCValue[$Currency]['ConversionRate'] = $values['ConversionRate'];
			$arrySettingCValue[$Currency]['FromDate'] = $values['FromDate'];
			$arrySettingCValue[$Currency]['ToDate'] = $values['ToDate'];
		}


		echo '<h3 onclick="javascript:SetCurrencyIndex('.$x.');">'.$arrayModule[$x].'<input type="hidden" name="Module'.$x.'"  readonly id="Module'.$x.'" value="'.$arrayModule[$x].'"></h3>';		
		echo '<table width="100%"  border="0" cellpadding="0" cellspacing="0">';
		for($y=0;$y<sizeof($arrySelCurrency);$y++) { //Start Currency Loop

			$Currency = $arrySelCurrency[$y];

			if($Currency!=$Config['Currency']){

			$CurrencyVal = $arrySettingCValue[$Currency]['ConversionRate'];
			$CurrencyFromDate = $arrySettingCValue[$Currency]['FromDate']; 	 
			$CurrencyToDate = $arrySettingCValue[$Currency]['ToDate'];


			if(!empty($CurrencyVal)){
				$ConversionRate=$CurrencyVal;
			}else{
				if(!empty($arryConversion[$Currency])){
					$ConversionRate = $arryConversion[$Currency];
				}else{
					$ConversionRate=CurrencyConvertor(1,$Currency,$Config['Currency']);
					$arryConversion[$Currency]=$ConversionRate;
				}
			}			
		     		 
			
			 

			$CurrencyFromDate = ($CurrencyFromDate>0)?($CurrencyFromDate):('');
			$CurrencyToDate = ($CurrencyToDate>0)?($CurrencyToDate):('');	
			/*if($CurrencyFromDate>0 && $CurrencyToDate>0){
				$CurrencyStatus = 'Range';
			}else*/ if($CurrencyFromDate>0){
				$CurrencyStatus = 'Date';
			}else{
				$CurrencyStatus = 'Open';
			}





     
			$CountC++;

			$ConversionRateName = 'ConversionRate'.$x.'_'.$y;
			$FromCurrencyName = 'FromCurrency'.$x.'_'.$y;
			$DateRangeName = 'DateRange'.$x.'_'.$y;

			$FromDateName = 'CurrencyFromDate'.$x.'_'.$y;
			$ToDateName = 'CurrencyToDate'.$x.'_'.$y;
			


			if($CountC=='1') echo '<tr>';
			/*************************************/
			/*************************************/


			
				

?>


<td align="right" class="blackbold" width="5%" valign="top"><?=$arrySelCurrency[$y]?> :

</td>
<td>
<input type="text" name="<?=$ConversionRateName?>" size="10" maxlength="10" onkeypress="return isDecimalKey(event);" class="textbox" id="<?=$ConversionRateName?>" value="<?=$ConversionRate?>">

<input type="hidden" name="<?=$FromCurrencyName?>"  readonly id="<?=$FromCurrencyName?>"  value="<?=$arrySelCurrency[$y]?>">
<a href="Javascript:GetCurrencyRateMultiple(<?=$x?>,<?=$y?>);"><?=$rateIcon?></a>
    

<select name="<?=$DateRangeName?>"  id="<?=$DateRangeName?>" style="width:65px;" class="textbox" onchange="DateRangeTo(<?=$x?>,<?=$y?>);">
<option value="0" <?=($CurrencyStatus=='Open')?("Selected"):("")?>>Open</option>
<option value="1" <?=($CurrencyStatus=='Date')?("Selected"):("")?>>Date</option>
<!--option value="2" <?=($CurrencyStatus=='Range')?("Selected"):("")?>>Range</option-->
</select>

<input type="text" <?=($CurrencyStatus=='Open')?('style="display:none"'):('')?>  <?=($CurrencyStatus=='Date')?('placeholder="Start"'):('')?> name="<?=$FromDateName?>" maxlength="30" class="datebox" readonly id="<?=$FromDateName?>" value="<?=$CurrencyFromDate?>">
	    
<input type="text" placeholder="End" <?=($CurrencyStatus=='Range')?(''):('style="display:none"')?> name="<?=$ToDateName?>" maxlength="30" class="datebox" readonly id="<?=$ToDateName?>" value="<?=$CurrencyToDate?>">

<a class="fancybox fancybig fancybox.iframe" href="vCurrencyLog.php?cur=<?=$arrySelCurrency[$y]?>&mod=<?=$arrayModule[$x]?>" ><?=$history?></a>

<script type="text/javascript">
$(function() {
	$('#<?=$FromDateName?>').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-2?>:<?=date("Y")+2?>', 
		changeMonth: true,
		changeYear: true

		}
	);

	$('#<?=$FromDateName?>').on("click", function () { 
			 $(this).val("");
		}
	);

	$('#<?=$ToDateName?>').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-2?>:<?=date("Y")+2?>', 
		changeMonth: true,
		changeYear: true

		}
	);

	$('#<?=$ToDateName?>').on("click", function () { 
			 $(this).val("");
		}
	);

	DateRangeTo('<?=$x?>','<?=$y?>');

});




</script>
          
          
	     
        <?
		$NotSaved = (!empty($CurrencyVal))?(''):('&nbsp;Not Saved');
		echo '<span class=red id="currencymsg'.$y.'"> '.$NotSaved.'</span>';
	    ?>
       </td>





<?
			

			/*************************************/
			/*************************************/
			if($CountC%2==0) echo '</tr><tr>';

			}
		} //End Currency Loop
		echo '</table>';
			

	} //End Module Loop


	echo '</div>';  

}
							
?>






