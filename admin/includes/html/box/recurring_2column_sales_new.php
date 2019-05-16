 
<script language="JavaScript1.2" type="text/javascript">
   $(document).ready(function(){
        
        $("#EntryType").change(function(){

	var MainModuleID = '';
	var PaymentTerm = '';
	if(window.parent.document.getElementById("PaymentTerm") != null){
		PaymentTerm =  window.parent.document.getElementById("PaymentTerm").value;   
		MainModuleID =  window.parent.document.getElementById("MainModuleID").value; 
	}




	var TypeVal = $(this).val();
	if(TypeVal == "recurring"){
                $("#dInterval").show(1000);
		$("#dFrom").show(1000);
		$("#dTo").show(1000);
		$(".calenderDiv").show(1000); 
                $(".FTdate").show(500); 

		if(PaymentTerm == "Credit Card" && MainModuleID == '865'){ 
			$("#dCardChargeDate").show();		
		}else{
			$("#dCardChargeDate").hide();
		}
                
	}else{
                $("#dInterval").hide(1000);
		$("#dFrom").hide(1000);
		$("#dTo").hide(1000);
                $("#dStart").hide(1000);
                $("#EntryDate").hide(1000);
		$(".calenderDiv").hide(1000); 
                $(".FTdate").hide(500); 
		$("#dCardChargeDate").hide();
                //$("#calenderDiv").css("color", "#000");//Amit Singh
		$('input[name="FTDateLine[]"]').each(function(index,value) {
                    $('#PFromDate'+this.value).val(null);
                    $('#PToDate'+this.value).val(null);
                    $('#PDateDiv'+this.value).hide();
                    
                    console.log($('#PFromDate'+this.value).val()); 
		});
		 
		
	}

	if(TypeVal == "recurring"){
		$("#EntryInterval").trigger("change");
	}

});


	var TypeVal = $("#EntryType").val();
 
	if(TypeVal == "recurring"){
                $("#dInterval").show(1000);
                $("#dFrom").show(1000);
                $("#dTo").show(1000);
 $(".calenderDiv").show(1000); 
                $(".FTdate").show(500); 
		$("#dStart").show(1000);
		 $("#EntryDate").show(1000);
 $('input[name="FTDateLine[]"]').each(function(index,value) {
                   
                    $('#PDateDiv'+this.value).show();
                });
                
	}else{
                $("#dInterval").hide(500);
                $("#dFrom").hide(500);
                $("#dTo").hide(500);
 $(".calenderDiv").hide(1000); 
               $(".FTdate").hide(500); 
               $("#dStart").hide(500);
	       $("#EntryDate").hide(500);
                
	}
        
        
        $("#EntryInterval").change(function(){

                var TypeInterval = $(this).val();
                if(TypeInterval == "yearly"){
                        $("#dEveryText").show(1000);
                        $("#dEveryField").show(1000);
                        $("#dStart").show(1000);
                        $("#EntryDate").show(1000);
                        $("#dWeeklyField").hide(1000);
                }else if(TypeInterval == "monthly" || TypeInterval == "bi_monthly"){
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
       		 	if(TypeVal == "recurring"){
			       if(TypeInterval == "yearly"){
				    $("#dEveryText").show(1000);
				    $("#dEveryField").show(1000);
				    $("#dStart").show(1000);
				    $("#EntryDate").show(1000);
				    $("#dWeeklyField").hide(1000);
				} 
			       else if(TypeInterval == "monthly" || TypeInterval == "bi_monthly"){
				    $("#dStart").show(1000);
				    $("#EntryDate").show(1000);
				}
				else if(TypeInterval == "biweekly"){
				    $("#dEveryText").show(1000);
				    $("#dWeeklyField").show(1000);
				}else{
					$("#dEveryText").hide(1000);
					$("#dEveryField").hide(1000);
					$("#dStart").hide(1000);
					$("#EntryDate").hide(1000);
					$("#dWeeklyField").hide(1000);
				}
			}else{
		            $("#dEveryText").hide(1000);
		            $("#dEveryField").hide(1000);
		            $("#dStart").hide(1000);
		            $("#EntryDate").hide(1000);
		            $("#dWeeklyField").hide(1000);
		        }
		 
        
});


  function submitRecurringForm() {   

	var TypeVal = $("#EntryType").val();
	if(TypeVal == "recurring"){
		if(document.getElementById("EntryFrom").value==''){
			alert("Entry From Date can't be left blank.");
			return false;
		}
	}
	


	var  lineNumber = document.getElementById("line").value;
	window.parent.document.getElementById("EntryType"+lineNumber).value = document.getElementById("EntryType").value;

	window.parent.document.getElementById("EntryDate"+lineNumber).value = document.getElementById("EntryDate").value;
	window.parent.document.getElementById("EntryInterval"+lineNumber).value = document.getElementById("EntryInterval").value;
	window.parent.document.getElementById("EntryMonth"+lineNumber).value = document.getElementById("EntryMonth").value;
	window.parent.document.getElementById("EntryWeekly"+lineNumber).value = document.getElementById("EntryWeekly").value;
	window.parent.document.getElementById("EntryFrom"+lineNumber).value = document.getElementById("EntryFrom").value;
	window.parent.document.getElementById("EntryTo"+lineNumber).value = document.getElementById("EntryTo").value;

	if(window.parent.document.getElementById("CardChargeDate"+lineNumber) != null){
		window.parent.document.getElementById("CardChargeDate"+lineNumber).value = document.getElementById("CardChargeDate").value;
		var CardCharge=0;
	       if(document.getElementById("CardCharge1").checked){
			CardCharge=1
	       }
		window.parent.document.getElementById("CardCharge"+lineNumber).value = CardCharge;
	}

	parent.$.fancybox.close(); // Reset
	return false; // Prevent page refresh
}


function EditRecurringForm() {
	 
	var  lineNumber = document.getElementById("line").value;
 
	var EntryTypeVal = window.parent.document.getElementById("EntryType"+lineNumber).value;
 
	if(EntryTypeVal=='recurring'){
		document.getElementById("EntryType").value = window.parent.document.getElementById("EntryType"+lineNumber).value;
		document.getElementById("EntryDate").value = window.parent.document.getElementById("EntryDate"+lineNumber).value;
		document.getElementById("EntryInterval").value = window.parent.document.getElementById("EntryInterval"+lineNumber).value;
		document.getElementById("EntryMonth").value = window.parent.document.getElementById("EntryMonth"+lineNumber).value;
		document.getElementById("EntryWeekly").value = window.parent.document.getElementById("EntryWeekly"+lineNumber).value ;
		document.getElementById("EntryFrom").value = window.parent.document.getElementById("EntryFrom"+lineNumber).value;
		document.getElementById("EntryTo").value = window.parent.document.getElementById("EntryTo"+lineNumber).value;
	}


	if(window.parent.document.getElementById("CardChargeDate"+lineNumber) != null){	
 	 
		document.getElementById("CardChargeDate").value = window.parent.document.getElementById("CardChargeDate"+lineNumber).value;
		if(window.parent.document.getElementById("CardCharge"+lineNumber).value==1){
			document.getElementById("CardCharge1").checked = true;
			document.getElementById("CardCharge2").checked = false;
		}else{
			document.getElementById("CardCharge1").checked = false;
			document.getElementById("CardCharge2").checked = true;
		}
	}
 
	SetCardCharge();
	SetForInfinite();
	
}     
 


function SetCardCharge(){	
	var TypeVal = $("#EntryType").val();
	var MainModuleID = '';
	var PaymentTerm = '';
	if(window.parent.document.getElementById("PaymentTerm") != null){
		PaymentTerm =  window.parent.document.getElementById("PaymentTerm").value;   
		MainModuleID =  window.parent.document.getElementById("MainModuleID").value; 
	}
	
	 
	if(TypeVal == "recurring" && PaymentTerm == "Credit Card" && MainModuleID == '865'){ 
		$("#dCardChargeDate").show();			 
		if($('#CardCharge1').is(':checked')) { 
			$("#ChargeDateTD").show(500);
			$("#ChargeDateTDVal").show(500); 
		}else{
			$("#ChargeDateTD").hide(500);
			$("#ChargeDateTDVal").hide(500);
		}
	}else{
		$("#dCardChargeDate").hide();	
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


jQuery('document').ready(function(){

	EditRecurringForm();

	$('#CardCharge1').click(function(){
		SetCardCharge();
	});
	$('#CardCharge2').click(function(){
		SetCardCharge();
	});

	$('#Infinite').click(function(){
		SetForInfinite();
	});

});

</script>

<?php

for($i=1;$i<8;$i++)
$weekdays [] = date("l",mktime(0,0,0,3,28,2009)+$i * (3600*24));
 
?>
<form name="form1" id="form1" action=""  method="post"  enctype="multipart/form-data">
<div style="border: 1px; height:270px;">
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
<tr>
	 <td>

<table width="100%"  border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Recurring</td>
</tr>
  <tr>
		<td  align="right" class="blackbold" width="20%">Entry Type  :</td>
		<td   align="left" width="30%">
		  <select name="EntryType" class="inputbox" id="EntryType" style="width:100px;">
				<option value="one_time" <?php if($arryRecurr[0]['EntryType'] == "one_time"){echo "selected";}?>>One Time</option>
				<option value="recurring" <?php if($arryRecurr[0]['EntryType'] == "recurring"){echo "selected";}?>>Recurring</option>	 
			</select> 
		</td>
                
                
           
                <td  align="right"   class="blackbold" width="20%"><span style="display:none;" id="dStart">Entry Date :</span></td>
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
			 <option value="bi_monthly" <?php if($arryRecurr[0]['EntryInterval'] == "bi_monthly"){echo "selected";}?>>Bi Monthly</option>
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
		<td  align="right" class="blackbold"  >Entry From :<span class="red">*</span></td>
		<td  align="left" class="blacknormal" >
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

		<td  align="right"   class="blackbold"    id="EntryToLabel">    Entry To : </td>
		<td  align="left" class="blacknormal" id="EntryToVal">
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
	


	
 <tr style="display:none;" id="dCardChargeDate">
		<td  align="right"   class="blackbold">Credit Card Charge :</td>
		<td align="left">
 
		<label><input id="CardCharge1" type="radio" value="1" name="CardCharge" <?=($arryRecurr[0]['CardCharge']==1)?("checked"):("")?>>&nbsp;Yes</label> 
 		&nbsp;&nbsp;&nbsp;&nbsp;
		<label><input id="CardCharge2" type="radio" value="0" name="CardCharge" <?=($arryRecurr[0]['CardCharge']!=1)?("checked"):("")?>>&nbsp;No</label> 

		</td>

		<td  align="right" style="display:none;" class="blackbold" id="ChargeDateTD">Credit Card Charge Date :</td>
		<td  align="left" style="display:none;" class="blacknormal" id="ChargeDateTDVal">

                    <?php $CardChargeDate = $arryRecurr[0]['CardChargeDate'] > 0?$arryRecurr[0]['CardChargeDate']:"";?>

<select name="CardChargeDate" class="inputbox" id="CardChargeDate" style="width:100px;">
	<?php		
	 for($i=1;$i<=31;$i++){?>
	<?php if($i<10){$prefix = '0';}else{$prefix='';}?>
	<option value="<?=$prefix.$i;?>" <?php if($CardChargeDate == $prefix.$i){echo "selected";}?>><?=$prefix.$i;?></option>
	<?php }?>
</select> 

                   
		</td>

		
		
	</tr>



	</table>
</td>
</tr>
 <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" style="display:none1">
	
<? if($_GET['edit'] >0 ) $btn ='Update'; else $btn ='Submit';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" onclick="return submitRecurringForm();" value="<?=$btn?>"  />


<input type="hidden" name="line" id="line" value="<?=$_GET['line']?>" />



</div>

</td>
   </tr>
</table>
</div>
</form>
	
