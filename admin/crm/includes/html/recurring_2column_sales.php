 
<script language="JavaScript1.2" type="text/javascript">


function SetCardCharge(){	 
	if($('#CardCharge1').is(':checked')) { 
		$("#ChargeDateTD").show(500);
		$("#ChargeDateTDVal").show(500); 
	}else{
		$("#ChargeDateTD").hide(500);
		$("#ChargeDateTDVal").hide(500);
	}	
}





function SetForInfinite(){
	if(document.getElementById("Infinite").checked){
		$("#EntryToLabel").hide();
		$("#EntryToVal").hide();
		$("#EntryTo").val("");
	}else{
		$("#EntryToLabel").show();
		$("#EntryToVal").show();
	}
	 
}


   $(document).ready(function(){
        
        $("#EntryType").change(function(){

	var TypeVal = $(this).val();
	if(TypeVal == "recurring"){
                $("#dInterval").show(1000);
		$("#dFrom").show(1000);
		$("#dTo").show(1000);
		$(".calenderDiv").show(1000); 
                $(".FTdate").show(500); 
		$("#dAmount").show(1000);
		$("#poGlAmount").show(1000);
                
	}else{
                $("#dInterval").hide(1000);
		$("#dFrom").hide(1000);
		$("#dTo").hide(1000);
                $("#dStart").hide(1000);
                $("#EntryDate").hide(1000);
$(".calenderDiv").hide(1000); 
                $(".FTdate").hide(500); 
                //$("#calenderDiv").css("color", "#000"); 
		$("#dAmount").hide(1000);
		$("#poGlAmount").hide(1000);


		$('input[name="FTDateLine[]"]').each(function(index,value) {
                    $('#PFromDate'+this.value).val(null);
                    $('#PToDate'+this.value).val(null);
                    $('#PDateDiv'+this.value).hide();
                    
                    console.log($('#PFromDate'+this.value).val()); 
		});
		 
		
	}

});


	var TypeVal = $("#EntryType").val();
	if(TypeVal == "recurring"){
                $("#dInterval").show(1000);
                $("#dFrom").show(1000);
                $("#dTo").show(1000);
 $(".calenderDiv").show(1000); 
                $(".FTdate").show(500); 
		$("#dAmount").show(1000);
		$("#poGlAmount").show(1000);

 $('input[name="FTDateLine[]"]').each(function(index,value) {
                   
                    $('#PDateDiv'+this.value).show();
                });
                
	}else{
                $("#dInterval").hide(1000);
                $("#dFrom").hide(1000);
                $("#dTo").hide(1000);
		$("#dAmount").hide(1000);
		$("#poGlAmount").hide(1000);
 $(".calenderDiv").hide(1000);//Amit Singh
               $(".FTdate").hide(500);//Amit Singh
               
                
	}
        
        
        $("#EntryInterval").change(function(){

                var TypeInterval = $(this).val();
                if(TypeInterval == "yearly"){
                        $("#dEveryText").show(1000);
                        $("#dEveryField").show(1000);
                        $("#dStart").show(1000);
                        $("#EntryDate").show(1000);
                        $("#dWeeklyField").hide(1000);
                }else if(TypeInterval == "monthly"){
                       $("#dStart").show(1000);
                       $("#EntryDate").show(1000);
                       $("#dEveryText").hide(1000);
                       $("#dEveryField").hide(1000);
                       $("#dWeeklyField").hide(1000);
                } 
                else if(TypeInterval == "biweekly"){
                       $("#dEveryText").show(1000);
                       $("#dWeeklyField").show(1000);
                       $("#dEveryField").hide(1000);
                       $("#dStart").hide(1000);
                       $("#EntryDate").hide(1000);
                } 
                else{
                        $("#dEveryText").hide(1000);
                        $("#dEveryField").hide(1000);
                        $("#dStart").hide(1000);
                        $("#EntryDate").hide(1000);
                        $("#dWeeklyField").hide(1000);
                       
                }
                
            
                

            });


	var TypeInterval = $("#EntryInterval").val();
       
               if(TypeInterval == "yearly"){
                    $("#dEveryText").show(1000);
                    $("#dEveryField").show(1000);
                    $("#dStart").show(1000);
                    $("#EntryDate").show(1000);
                    $("#dWeeklyField").hide(1000);
                } 
               else if(TypeInterval == "monthly"){
                    $("#dStart").show(1000);
                    $("#EntryDate").show(1000);
                }
                else if(TypeInterval == "biweekly"){
                    $("#dEveryText").show(1000);
                    $("#dWeeklyField").show(1000);
                }
                else{
                    $("#dEveryText").hide(1000);
                    $("#dEveryField").hide(1000);
                    $("#dStart").hide(1000);
                    $("#EntryDate").hide(1000);
                    $("#dWeeklyField").hide(1000);
                }

	SetCardCharge();
	SetForInfinite();

	$('#CardCharge1').click(function(){
		SetCardCharge();
	});
	$('#CardCharge2').click(function(){
		SetCardCharge();
	});


	$('#Infinite').click(function(){
		SetForInfinite();
	});



	$("table.order-list").on("keyup", 'input[name^="RecurringPrice"],input[name^="RecurringQty"]', function (event) {
		
                calculateRow($(this).closest("tr"));
		 
	});


	function calculateRow(row) { 
		var price = row.find('input[name^="RecurringPrice"]').val();
		var qty = row.find('input[name^="RecurringQty"]').val();
		var SubTotal = price*qty;	
		row.find('input[name^="RecurringAmount"]').val(SubTotal.toFixed(2));
	}

        
});


  
        

</script>

<?php
 
for($i=1;$i<8;$i++)
$weekdays [] = date("l",mktime(0,0,0,3,28,2009)+$i * (3600*24));
 
?>

  <tr>
		<td  align="right" class="blackbold" width="20%">Entry Type  :</td>
		<td   align="left" width="30%">
		  <select name="EntryType" class="inputbox" id="EntryType" style="width:100px;">
				<option value="one_time" <?php if($arryRecurr[0]['EntryType'] == "one_time"){echo "selected";}?>>One Time</option>
				<option value="recurring" <?php if($arryRecurr[0]['EntryType'] == "recurring"){echo "selected";}?>>Recurring</option>	 
			</select> 
		</td>
                
                
           
                <td  align="right" width="20%"  class="blackbold"><span style="display:none;" id="dStart">Entry Date :</span></td>
		<td   align="left">
		<select name="EntryDate" class="inputbox" id="EntryDate" style="width:100px;display:none;">
				<?php		
				 for($i=1;$i<=31;$i++){?>
				<?php if($i<10){$prefix = '0';}else{$prefix='';}?>
				<option value="<?=$prefix.$i;?>" <?php if($arryRecurr[0]['EntryDate'] == $prefix.$i){echo "selected";}?>><?=$prefix.$i;?></option>
				<?php }?>
			</select> 
		
		</td>
	</tr>	
                
        <tr style="display:none;" id="dInterval">
		<td  align="right" class="blackbold">Interval :</td>
		<td  align="left" class="blacknormal">
                     <select name="EntryInterval" class="inputbox" id="EntryInterval" style="width:100px;">
                       
                         <option value="biweekly" <?php if($arryRecurr[0]['EntryInterval'] == "biweekly"){echo "selected";}?>>Biweekly</option>
                         <option value="semi_monthly" <?php if($arryRecurr[0]['EntryInterval'] == "semi_monthly"){echo "selected";}?>>Semi Monthly</option>
			 <option value="monthly" <?php if($arryRecurr[0]['EntryInterval'] == "monthly"){echo "selected";}?>>Monthly</option>
			 <option value="yearly" <?php if($arryRecurr[0]['EntryInterval'] == "yearly"){echo "selected";}?>>Yearly</option>	 
			</select> 
		 

		</td>
                 
                <td  align="right" class="blackbold"><span style="display:none;" id="dEveryText">Every :</span></td>
		<td  align="left" class="blacknormal">
                    <span style="display:none;" id="dEveryField">
                     <select name="EntryMonth" class="inputbox" id="EntryMonth" style="width:100px;">
                        <?php
                        for ($m=1; $m<=12; $m++) {
                           $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                           if($m < 10) $m = '0'.$m;
                           ?>

                        <option value="<?=$m;?>" <?php if($arryRecurr[0]['EntryMonth'] == $m){echo "selected";}?>><?=$month?></option>
                        <?php } ?>
			</select> 
		 </span>
                  <span style="display:none;" id="dWeeklyField">
                     <select name="EntryWeekly" class="inputbox" id="EntryWeekly" style="width:100px;">
                        <?php
                       foreach($weekdays as $day) {
                           if(!empty($arryRecurr[0]['EntryWeekly'])){
                            $EntryWeek = $arryRecurr[0]['EntryWeekly'];
                           }else{
                               $EntryWeek = "Monday";
                           }
                            
                          
                           ?>

                        <option value="<?=$day;?>" <?php if($EntryWeek == $day){echo "selected";}?>><?=$day?></option>
                        <?php } ?>
			</select> 
		 </span>  

		</td>
	 
	
	</tr>	

    <tr style="display:none;" id="dFrom">
		<td  align="right" class="blackbold">Entry From :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
                    <?php $EntryFrom = $arryRecurr[0]['EntryFrom'] > 0?$arryRecurr[0]['EntryFrom']:"";?>
                    <input id="EntryFrom" name="EntryFrom" readonly="" class="datebox" value="<?=$EntryFrom;?>"  type="text" >
		<script type="text/javascript">
			$(function() {
                                $('#EntryFrom').datepicker(
                                        {
                                        showOn: "both",
                                        //yearRange: '<?=date("Y")+10?>:<?=date("Y")?>', 
                                        //maxDate: "-1D", 
                                        dateFormat: 'yy-mm-dd',
                                        changeMonth: true,
                                        changeYear: true,
                                        minDate:'0d'

                                        }
                                );
                                });
                                </script>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label><input id="Infinite" type="checkbox" value="1" name="Infinite" <?=($arryRecurr[0]['EntryTo']>0)?(""):("checked")?>>&nbsp;Infinite</label> 


                                 <div class="red" id="EntryFromerr" style="margin-left:5px;"></div>
		</td>

		<td  align="right"   class="blackbold"   id="EntryToLabel">Entry To : </td>
		<td  align="left" class="blacknormal"   id="EntryToVal">
                      <?php $EntryTo = $arryRecurr[0]['EntryTo'] > 0?$arryRecurr[0]['EntryTo']:"";?>
                    <input id="EntryTo" name="EntryTo" readonly="" class="datebox" value="<?=$EntryTo;?>"  type="text" > 
                <script type="text/javascript">
                            $(function() {
                            $('#EntryTo').datepicker(
                                    {
                                    showOn: "both",
                                    //yearRange: '<?=date("Y")+50?>:<?=date("Y")?>', 
                                    //maxDate: "-1D", 
                                    dateFormat: 'yy-mm-dd',
                                    changeMonth: true,
                                    changeYear: true,
                                    minDate:'0d'

                                    }
                            );

				$("#EntryTo").on("click", function () { 
								 $(this).val("");
							}
						);
                            });
		</script>
                <div class="red" id="EntryToerr" style="margin-left:5px;"></div>

</td>
	</tr>	
	
		
<? 
if(empty($arryRecurr[0]['CrmQuote']) && strtolower(trim($arryRecurr[0]['PaymentTerm']))=="credit card") { 

	$CardCharge = !empty($arryRecurr[0]['CardCharge'])?$arryRecurr[0]['CardCharge']:"";
	$CardChargeDate = !empty($arryRecurr[0]['CardChargeDate'])?$arryRecurr[0]['CardChargeDate']:"";
?>

 <tr>
		<td  align="right"   class="blackbold">Credit Card Charge :</td>
		<td align="left">
 
		<label><input id="CardCharge1" type="radio" value="1" name="CardCharge" <?=($CardCharge==1)?("checked"):("")?>>&nbsp;Yes</label> 
 		&nbsp;&nbsp;&nbsp;&nbsp;
		<label><input id="CardCharge2" type="radio" value="0" name="CardCharge" <?=($CardCharge!=1)?("checked"):("")?>>&nbsp;No</label> 


		</td>

		<td  align="right" class="blackbold" id="ChargeDateTD">Credit Card Charge Date :</td>
		<td  align="left" class="blacknormal" id="ChargeDateTDVal">

                 
                    

<select name="CardChargeDate" class="inputbox" id="CardChargeDate" style="width:100px;">
	<?php		
	 for($i=1;$i<=31;$i++){?>
	<?php if($i<10){$prefix = '0';}else{$prefix='';}?>
	<option value="<?=$prefix.$i;?>" <?php if($CardChargeDate == $prefix.$i){echo "selected";}?>><?=$prefix.$i;?></option>
	<?php }?>
</select> 
                   
		</td>

		
		
	</tr>
<? } ?>


    <tr style="display:none;" id="dAmount">
		<? 

(empty($EditRecurringAmount))?($EditRecurringAmount=""):("");

if($EditRecurringAmount==1){?>

	<td colspan="4">
	<table class="order-list" width="100%" border="0" cellpadding="0" cellspacing="0"  >

	<tr>  <td align="left" colspan="6" class="head">
		SKU : <?=$arryRecurr[0]['sku']?>
		</td>
	</tr>
	
	<tr>
	 	 <td  align="right" class="blackbold">Quantity :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
                    <?php $RecurringQty = $arryRecurr[0]['RecurringAmount'] > 0?$arryRecurr[0]['RecurringQty']:$arryRecurr[0]['qty_invoiced'];?>
                    <input id="RecurringQty" name="RecurringQty"  class="datebox" value="<?=$RecurringQty;?>"  type="text" autocomplete="Off" maxlenght="10" onkeypress="return isNumberKey(event,this);" >
		 
		</td>

		 <td  align="right" class="blackbold">Unit Price :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
                    <?php $RecurringPrice = $arryRecurr[0]['RecurringAmount'] > 0?$arryRecurr[0]['RecurringPrice']:$arryRecurr[0]['price'];?>
                    <input id="RecurringPrice" name="RecurringPrice"  class="datebox" value="<?=$RecurringPrice;?>"  type="text" autocomplete="Off" maxlenght="10" onkeypress="return isDecimalKey(event,this);" >
		 
		</td>

		<td  align="right" class="blackbold">Recurring Amount :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
                    <?php $RecurringAmount = $arryRecurr[0]['RecurringAmount'] > 0?$arryRecurr[0]['RecurringAmount']:$arryRecurr[0]['amount'];?>
                    <input id="RecurringAmount" name="RecurringAmount" readonly  class="disabled" value="<?=$RecurringAmount;?>"  type="text" autocomplete="Off" maxlenght="10" onkeypress="return isDecimalKey(event,this);" style="width:90px;" >
		 
		</td>
	</tr>	
	</table>
	</td>

<input type="hidden" value="<?=$EditRecurringAmount?>" readonly id="EditRecurringAmount" name="EditRecurringAmount">


 		<? } ?>

		
	</tr>






 <tr style="display:none;" id="poGlAmount">

	<? 
(empty($EditPoRecurringAmountGL))?($EditPoRecurringAmountGL=""):("");
if($EditPoRecurringAmountGL==1){
	?>

	<td colspan="4">
	<table class="order-list" width="100%" border="0" cellpadding="0" cellspacing="0"  >
 	<tr> 	
		<td  align="right" class="blackbold" width="20%">Recurring Amount : </td>
		<td  align="left" class="blacknormal">
                    <?php $RecurringAmount = $arryRecurr[0]['RecurringAmount'] > 0?$arryRecurr[0]['RecurringAmount']:$arryRecurr[0]['TotalAmount'];?>
                    <input id="RecurringAmount" name="RecurringAmount"  class="textbox" value="<?=$RecurringAmount;?>"  type="text" autocomplete="Off" maxlenght="10" onkeypress="return isDecimalKey(event,this);" style="width:90px;" >
		 
		</td>
	</tr>	
	</table>
	</td>

	<input type="hidden" value="<?=$EditPoRecurringAmountGL?>" readonly id="EditPoRecurringAmountGL" name="EditPoRecurringAmountGL">

 		<? } ?>

		

</tr>	
	
