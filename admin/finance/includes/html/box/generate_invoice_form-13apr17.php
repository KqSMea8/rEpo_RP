<?
if($objConfigure->getSettingVariable('SO_SOURCE')==1){
	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
		$OrderSourceFlag = 1;
	}
}


?>
<script type="text/javascript">
function shipCarrier(){
	var method = document.getElementById("ShippingMethod").value;
	var spval = document.getElementById("spval").value;
	 
	var countryCode= '';
	var SendParam = 'action='+method+'&countryCode='+countryCode+'&shippval='+spval; 

	if(method==''){
		 document.getElementById("spmethod").style.display = 'none'; 
		document.getElementById("ShippingMethodVal").value=''; 
	}else{

		 $.ajax({
			type: "GET",
			url: '../ajax.php',
			data: SendParam,
			success: function (responseText) {
				if(responseText!=''){
					document.getElementById("spmethod").style.display = 'table-row';
					document.getElementById("ShippingMethodVal").innerHTML=responseText; 
				}else{
					 document.getElementById("spmethod").style.display = 'none'; 
					document.getElementById("ShippingMethodVal").value=''; 
				}
		
			}
		});	
 	}

}
</script>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	<tr>
	 <td colspan="4" align="left" class="head">Invoice Information <a class="fancybox fancybox.iframe" style="float:right;" href="../sales/order_log.php?OrderID=<?=$_GET['edit']?>&module=SalesInvoice" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()"></a></td>
	</tr>
        
        <!---Recurring Start-->
        <?php   
        //$arryRecurr = $arrySale;
        //include("../includes/html/box/recurring_2column_sales.php");?>

        <!--Recurring End-->
	<tr>
        <td  align="right"   class="blackbold" width="20%" valign="top"> Invoice Number # : </td>
        <td   align="left" width="30%" valign="top">
<? if(!empty($_GET['edit'])) {?>

 <input name="SaleInvoiceID" type="text" <?=$inputBoxClass?> id="SaleInvoiceID" value="<?php echo stripslashes($arrySale[0]['InvoiceID']); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SaleInvoiceID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_SaleInvoiceID','SaleInvoiceID','<?=$_GET['edit']?>');" />
		<div id="MsgSpan_SaleInvoiceID"></div>
<? }else{?>

		 <input name="SaleInvoiceID" type="text" class="datebox" id="SaleInvoiceID" value="<?=$NextModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SaleInvoiceID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_SaleInvoiceID','SaleInvoiceID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
		<div id="MsgSpan_SaleInvoiceID"></div>
<? } ?>


		</td>
 
	 <td  align="right"   class="blackbold" width="20%" valign="top"> Invoice Date  : </td>
		<td  align="left" valign="top">

	<script type="text/javascript">
	$(function() {
	$('#InvoiceDate').datepicker(
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
		$InvoiceDate = ($arrySale[0]['InvoiceDate']>0)?($arrySale[0]['InvoiceDate']):($arryTime[0]); 
		?>
		<input id="InvoiceDate" name="InvoiceDate" readonly="" class="datebox" value="<?=$InvoiceDate?>"  type="text" > 






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
	
        <td  align="right" class="blackbold">Ship From :</td>
        <td   align="left">
		<input name="wCode" type="text" class="disabled" style="width:90px;" id="wCode" value="<?php echo stripslashes($arrySale[0]['wCode']); ?>"  maxlength="40" readonly />
	     <a class="fancybox fancybox.iframe" href="../warehouse/warehouseList.php" ><?=$search?></a>
		</td>
    </tr>
	<tr>
        <td  align="right" class="blackbold" valign="top">Ship From (Warehouse) :</td>
        <td   align="left" valign="top">
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

		<td valign="top" align="right" class="blackbold">Invoice Comment :</td>
		<td align="left">
			<?php // added by sanjiv
 		$MultiComment = explode("##",$InvoiceComment); 
 		if(empty($MultiComment[1]) && !empty($MultiComment[0])){ ?>
 			 <input type="text" id="InvoiceComment" class="inputbox" name="InvoiceComment" maxlength="200" value="<?=$InvoiceComment?>">
 		<?php }else{ 
 			$module_type = 'sales';
 			$arrComments = $InvoiceComment;
 			include("../includes/html/box/PO_SO_Comments.php"); ?>
 			<input type="hidden" name="InvoiceComment" id="InvoiceComment" value="<?php echo stripslashes($InvoiceComment); ?>"/>	
 		<?php }
		 ?>
		<!-- <input type="text" id="InvoiceComment" class="inputbox" name="InvoiceComment" maxlength="200" value="<?php //$InvoiceComment?>"> -->
                </td>
		</tr>
	<?php if(basename($_SERVER['PHP_SELF']) == "editInvoiceEntry.php") {?>
     <tr>
		<td valign="top" align="right" class="blackbold">Reference No#  :</td>
		<td align="left">
		<input type="text" value="" id="ReferenceNo" class="inputbox" name="ReferenceNo" maxlength="40">
                </td>
		</tr>
    <?php }?>
	

<? if(!empty($arrySale[0]['SaleID'])){ ?>
	 <tr>
		<td  align="right"   class="blackbold" > SO Number # : </td>
		<td   align="left" >

 <a href="../sales/vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?=$arrySale[0]['SaleID'] ?>" class="fancybox po fancybox.iframe"><?=$arrySale[0]['SaleID'] ?></a>



</td>
<td  align="right"   class="blackbold" width="20%"> Customer : </td>
        <td   align="left" width="30%">
<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>

 <input name="CustID" id="CustID" type="hidden" value="<?php echo stripslashes($arrySale[0]['CustID']); ?>">

</td>
	  </tr>
	<?  if($arrySale[0]['OrderPaid']>0) { ?>
	<tr>
	 <td  align="right"   class="blackbold" >SO Payment Status  : </td>
        <td   align="left" >
		<?=($arrySale[0]['OrderPaid']==1)?('<span class=greenmsg>Paid</span>'):('<span class=redmsg>Refunded</span>')?>
	</td>
	</tr>
	<? } ?>

<tr>
			<td  align="right"   class="blackbold" > Payment Term  : </td>
			<td   align="left" >


<?
if(!empty($_GET['edit']) && empty($TotalCharge) && empty($TotalChargeAllInvoice) && empty($PaymentInvoice)){ ?>
<select name="PaymentTerm" class="inputbox" id="PaymentTerm">
  	<option value="">--- None ---</option>
		<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
				if($arryPaymentTerm[$i]['termType']==1){
					$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']);
				}else{
					$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
				}
		?>
			<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arrySale[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
		<? } ?>
</select> 
<select name="SelectCard" class="textbox" id="SelectCard"  style="display:none;">
  	<option value="">--- Select ---</option>
	<option value="New">New Card</option>
	<option value="Existing">Existing</option>	 	 
</select> 	 
<?}else{?>
	<input type="text" name="PaymentTerm" id="PaymentTerm" maxlength="30" readonly class="disabled_inputbox"  value="<?=stripslashes($arrySale[0]['PaymentTerm'])?>">
<? } ?>
 
			</td>
	
			 
	</tr>

	
	<? if(!empty($BankAccount)){ ?>
	<tr>
			<td  align="right"   class="blackbold" > Bank Account : </td>
			<td   align="left" >
	        	 <?=$BankAccount?>
			</td>

			 
	</tr>
	<? } ?>



<? } ?>
	<tr>
	<td align="center" valign="top">
	
	</td>
	</tr>

 
<!--tr>
			<td  align="right" class="blackbold">Shipping Carrier  : </td>
  
        <td   align="left">
		  <select name="ShippingMethod" class="inputbox" id="ShippingMethod" onchange="Javascript:shipCarrier();">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arrySale[0]['ShippingMethod']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
</tr>
<? if($arrySale[0]['ShippingMethodVal']!=''){ $MethodDis ='';} else{ $MethodDis ='display:none;';}?>
<tr id="spmethod" style="<?=$MethodDis?>">
	<td align="right" class="blackbold">Shipping Method : </td>
	<td align="left">
	<select name="ShippingMethodVal" class="inputbox" id="ShippingMethodVal">
	</select>
	<input type="hidden" name="spval" id="spval" value="<?=$arrySale[0]['ShippingMethodVal'];?>">

	</td>
</tr-->

		

<tr>


	<td  align="right"   class="blackbold"  >  Tracking #  : </td>
	<td   align="left"   >
 
	<input name="TrackingNo" type="text" class="inputbox"   id="TrackingNo" value="<?php echo stripslashes($arrySale[0]['TrackingNo']); ?>"  maxlength="50" />
	          
	</td>


<td  align="right"   class="blackbold" > Shipping Account  : </td>
	<td   align="left" >
	<input name="ShipAccount" type="text" class="inputbox" id="ShipAccount" value="<?php echo stripslashes($arrySale[0]['ShipAccount']); ?>"  maxlength="50" />          
	</td>

</tr>
<tr>


	<td  align="right"   class="blackbold" > Customer PO#  : </td>
	<td   align="left" >
	<input name="CustomerPO" type="text" class="inputbox"  id="CustomerPO" value="<?php echo stripslashes($arrySale[0]['CustomerPO']); ?>"  maxlength="50" />          
	</td>
<td  align="right"   class="blackbold" > Fees  : </td>
	<td   align="left" >

	 <input name="Fee" type="text" class="disabled" readonly id="Fee" value="<?php echo stripslashes($arrySale[0]['Fee']); ?>"  maxlength="50" />        
	</td>


</tr>
 
<tr>
 <? if($OrderSourceFlag==1){ ?>
<td  align="right"   class="blackbold" > Order Source : </td>
	<td   align="left" >
	<input name="OrderSource" type="text" class="inputbox"  id="OrderSource" value="<?php echo stripslashes($arrySale[0]['OrderSource']); ?>"  maxlength="50" />          
	</td>
<? } ?>



</tr>
<?php if($arryCurrentLocation[0]['country_id']==106){ ?>
<tr>

<td valign="top" align="right" class="blackbold">Upload Document :</td>
		<td  align="left" valign="top" >
	<input name="UploadDocuments" type="file" class="inputbox" id="UploadDocuments" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
               	<?=SUPPORTED_SCAN_DOC?>
	<? 
        $MainDir = "upload/AR/".$_SESSION['CmpID']."/";
        if($arrySale[0]['UploadDocuments'] !='' && file_exists($MainDir.$arrySale[0]['UploadDocuments']) ){

	$OldUploadDocuments = $MainDir.$arrySale[0]['UploadDocuments'];
 ?>
	<br><br>
	<input type="hidden" name="OldUploadDocuments" value="<?=$OldUploadDocuments?>">
	<div id="UploadDocumentsDiv">
	<?=$arrySale[0]['UploadDocuments']?>&nbsp;&nbsp;&nbsp;
	<a href="dwn.php?file=<?=$MainDir.$arrySale[0]['UploadDocuments']?>" class="download">Download</a> 

	<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arrySale[0]['UploadDocuments']?>','UploadDocumentsDiv')"><?=$delete?></a>
	</div>
<?	} ?>
               
                </td>
<?php //} ?>	
</tr>
<? } else{

echo '<input name="UploadDocuments" id="UploadDocuments" type="hidden" class="disabled" readonly style="width:90px;"  value=""  maxlength="20" />';


}?>


	
	</table>



<? 
 
	$BoxPrefix = '../sales/'; include($BoxPrefix."includes/html/box/sale_card.php");
 
?>

<script language="JavaScript1.2" type="text/javascript">
shipCarrier();
</script>


<script>
	
	function SelectCreditCard(){

		var PaymentTerm = $("#PaymentTerm").val().toLowerCase();
		/**********************/
		if(PaymentTerm == 'credit card'){
			$('#SelectCard').show(); 
			if($("#CreditCardNumber").val()!='' && $("#CreditCardType").val()!=''){
				$('#CreditCardInfo').show(); 
			}else{
				$('#CreditCardInfo').hide();  
			}
		}else{
			$('#SelectCard').hide();
			$('#CreditCardInfo').hide();  
		}
		/**********************/
		 
		if(PaymentTerm == 'prepayment'){
			 $("#BankAccountTR").show();	
		}else{
			 $("#BankAccountTR").hide();	  
		}
	}

	jQuery('document').ready(function(){


		$('#SelectCard').change(function(){
			var CustID = $("#CustID").val();
			if(CustID>0){
				var url = '';
				if($(this).val()=='New'){
					url = '../editCustCard.php?CustID='+CustID+'&SaveSelect=1';
				}else{
					url = '../selectCustCard.php?CustID='+CustID;
				}
				 
				$.fancybox({
					 'href' : url,
					 'type' : 'iframe',
					 'width': '800',
					 'height': '800'
				});
			}else{
				alert("Please select customer first.");
			}
		});



		  jQuery("#PaymentTerm").change(function(){
			
			SelectCreditCard();
		  });










	});

	SelectCreditCard();
	
	</script>
