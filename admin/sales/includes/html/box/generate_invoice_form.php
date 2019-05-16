<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	<tr>
	 <td colspan="2" align="left" class="head">Invoice Information</td>
	</tr>	
	 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice Number # : </td>
        <td   align="left">
		 <input name="SaleInvoiceID" type="text" class="datebox" id="SaleInvoiceID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SaleInvoiceID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_SaleInvoiceID','SaleInvoiceID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
		 &nbsp;&nbsp;<span id="MsgSpan_SaleInvoiceID"></span>
		</td>
    </tr>
	 
	<tr>
	 <td  align="right"   class="blackbold"> Invoice Date  : </td>
		<td  align="left">
		<? 	
		$arryTime = explode(" ",$Config['TodayDate']);
		echo $arryTime[0];
		?>
		<input id="InvoiceDate" name="InvoiceDate" value="<?=$arryTime[0]?>"  type="hidden"> 
		</td>
	</tr>
	<tr>
	 <td  align="right"   class="blackbold"> Ship Date  : </td>
		<td   align="left" >

			<script type="text/javascript">
			$(function() {
			$('#ShippedDate').datepicker(
			{
			showOn: "both",
			yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true

			}
			);
			});
			</script>

		<? 	
		$arryTime = explode(" ",$Config['TodayDate']);
		$ShippedDate = ($arrySale[0]['ShippedDate']>0)?($arrySale[0]['ShippedDate']):($arryTime[0]); 
		?>
		<input id="ShippedDate" name="ShippedDate" readonly="" class="datebox" value="<?=$ShippedDate?>"  type="text" > 


		</td>
	</tr>
	<tr>
        <td  align="right" class="blackbold">Ship From :</td>
        <td   align="left">
		<input name="wCode" type="text" class="disabled" style="width:90px;" id="wCode" value="<?php echo stripslashes($arrySale[0]['wCode']); ?>"  maxlength="40" readonly />
	     <a class="fancybox fancybox.iframe" href="../warehouse/warehouseList.php" ><?=$search?></a>
		</td>
    </tr>
	<tr>
        <td  align="right" class="blackbold">Ship From(Warehouse) :</td>
        <td   align="left">
		<input name="wName" type="text" class="inputbox" id="wName" value="<?php echo stripslashes($arrySale[0]['wName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>          
		
			<input name="wContact" type="hidden" class="inputbox" id="wContact" value="">
			<input name="wAddress" type="hidden" class="inputbox" id="wAddress" value="">
			<input name="wCity" type="hidden" class="inputbox" id="wCity" value="">
			<input name="wState" type="hidden" class="inputbox" id="wState" value="">
			<input name="wCountry" type="hidden" class="inputbox" id="wCountry" value="">
			<input name="wZipCode" type="hidden" class="inputbox" id="wZipCode" value="">
			<input name="wMobile" type="hidden" class="inputbox" id="wMobile" value="">
			<input name="wLandline" type="hidden" class="inputbox" id="wLandline" value="">
			<input name="wEmail" type="hidden" class="inputbox" id="wEmail" value="">
		</td>
    </tr>
	
		<tr>
		<td valign="top" align="right" class="blackbold">Invoice Comment :</td>
		<td align="left">
		<textarea id="InvoiceComment" class="textarea" type="text" name="InvoiceComment"></textarea></td>
		</tr>
	
	
	<tr>
	<td align="center" valign="top">
	
	</td>
	</tr>


	</table>
