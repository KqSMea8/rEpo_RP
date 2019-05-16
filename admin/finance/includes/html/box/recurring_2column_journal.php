 
<script language="JavaScript1.2" type="text/javascript">

function SetForInfinite(){
	if(document.getElementById("Infinite").checked){
		$("#EntryToLabel").hide();
		$("#EntryToVal").hide();
		$("#JournalDateTo").val("");
	}else{
		$("#EntryToLabel").show();
		$("#EntryToVal").show();
	}
	 
}


   $(document).ready(function(){
        
        $("#JournalType").change(function(){
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
                $("#JournalStartDate").hide(1000);
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


	var TypeVal = $("#JournalType").val();
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
        
        
        $("#JournalInterval").change(function(){

                var TypeInterval = $(this).val();
                if(TypeInterval == "yearly"){
                        $("#dEveryText").show(1000);
                        $("#dEveryField").show(1000);
                        $("#dStart").show(1000);
                        $("#JournalStartDate").show(1000);
                        $("#dWeeklyField").hide(1000);
                }else if(TypeInterval == "monthly"){
                       $("#dStart").show(1000);
                       $("#JournalStartDate").show(1000);
                       $("#dEveryText").hide(1000);
                       $("#dEveryField").hide(1000);
                       $("#dWeeklyField").hide(1000);
                } 
                else if(TypeInterval == "biweekly"){
                       $("#dEveryText").show(1000);
                       $("#dWeeklyField").show(1000);
                       $("#dEveryField").hide(1000);
                       $("#dStart").hide(1000);
                       $("#JournalStartDate").hide(1000);
                } 
                else{
                        $("#dEveryText").hide(1000);
                        $("#dEveryField").hide(1000);
                        $("#dStart").hide(1000);
                        $("#JournalStartDate").hide(1000);
                        $("#dWeeklyField").hide(1000);
                       
                }
                
            
                

            });


	var TypeInterval = $("#JournalInterval").val();
       
               if(TypeInterval == "yearly"){
                    $("#dEveryText").show(1000);
                    $("#dEveryField").show(1000);
                    $("#dStart").show(1000);
                    $("#JournalStartDate").show(1000);
                    $("#dWeeklyField").hide(1000);
                } 
               else if(TypeInterval == "monthly"){
                    $("#dStart").show(1000);
                    $("#JournalStartDate").show(1000);
                }
                else if(TypeInterval == "biweekly"){
                    $("#dEveryText").show(1000);
                    $("#dWeeklyField").show(1000);
                }
                else{
                    $("#dEveryText").hide(1000);
                    $("#dEveryField").hide(1000);
                    $("#dStart").hide(1000);
                    $("#JournalStartDate").hide(1000);
                    $("#dWeeklyField").hide(1000);
                }

	SetForInfinite();


	$('#Infinite').click(function(){
		SetForInfinite();
	});
	
        
});

    

</script>

<?php
if(empty($arryRecurr[0]['JournalInterval'])){ 
	$arryRecurr[0]['JournalInterval'] = "monthly";
}


 

for($i=1;$i<8;$i++)
$weekdays [] = date("l",mktime(0,0,0,3,28,2009)+$i * (3600*24));

?>

  <tr>
		<td  align="right" class="blackbold" width="20%">Entry Type  :</td>
		<td   align="left" width="30%">
		  <select name="JournalType" class="inputbox" id="JournalType" style="width:100px;">
				<option value="one_time" <?php if($arryRecurr[0]['JournalType'] == "one_time"){echo "selected";}?>>One Time</option>
				<option value="recurring" <?php if($arryRecurr[0]['JournalType'] == "recurring"){echo "selected";}?>>Recurring</option>	 
			</select> 
		</td>
                
                
           
                <td  align="right" width="20%"  class="blackbold"><span style="display:none;" id="dStart">Entry Date :</span></td>
		<td   align="left">
		<select name="JournalStartDate" class="inputbox" id="JournalStartDate" style="width:100px;display:none;">
				<?php		
				 for($i=1;$i<=31;$i++){?>
				<?php if($i<10){$prefix = '0';}else{$prefix='';}?>
				<option value="<?=$prefix.$i;?>" <?php if($arryRecurr[0]['JournalStartDate'] == $prefix.$i){echo "selected";}?>><?=$prefix.$i;?></option>
				<?php }?>
			</select> 
		
		</td>
	</tr>	
                
        <tr style="display:none;" id="dInterval">
		<td  align="right" class="blackbold">Interval :</td>
		<td  align="left" class="blacknormal">
 
                     <select name="JournalInterval" class="inputbox" id="JournalInterval" style="width:100px;">
                       
                         <option value="biweekly" <?php if($arryRecurr[0]['JournalInterval'] == "biweekly"){echo "selected";}?>>Biweekly</option>
                         <option value="semi_monthly" <?php if($arryRecurr[0]['JournalInterval'] == "semi_monthly"){echo "selected";}?>>Semi Monthly</option>
			 <option value="monthly" <?php if($arryRecurr[0]['JournalInterval'] == "monthly"){echo "selected";}?>>Monthly</option>
			 <option value="yearly" <?php if($arryRecurr[0]['JournalInterval'] == "yearly"){echo "selected";}?>>Yearly</option>	 
			</select> 
		 

		</td>
                 
                <td  align="right" class="blackbold"><span style="display:none;" id="dEveryText">Every :</span></td>
		<td  align="left" class="blacknormal">
                    <span style="display:none;" id="dEveryField">
                     <select name="JournalMonth" class="inputbox" id="JournalMonth" style="width:100px;">
                        <?php
                        for ($m=1; $m<=12; $m++) {
                           $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                           if($m < 10) $m = '0'.$m;
                           ?>

                        <option value="<?=$m;?>" <?php if($arryRecurr[0]['JournalMonth'] == $m){echo "selected";}?>><?=$month?></option>
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
                    <?php $JournalDateFrom = $arryRecurr[0]['JournalDateFrom'] > 0?$arryRecurr[0]['JournalDateFrom']:"";?>
                    <input id="JournalDateFrom" name="JournalDateFrom" readonly="" class="datebox" value="<?=$JournalDateFrom;?>"  type="text" >
		<script type="text/javascript">
			$(function() {
                                $('#JournalDateFrom').datepicker(
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
<label><input id="Infinite" type="checkbox" value="1" name="Infinite" <?=($arryRecurr[0]['JournalDateTo']>0)?(""):("checked")?>>&nbsp;Infinite</label> 


                                 <div class="red" id="EntryFromerr" style="margin-left:5px;"></div>
		</td>

		<td  align="right"   class="blackbold"   id="EntryToLabel">Entry To : </td>
		<td  align="left" class="blacknormal"   id="EntryToVal">
                      <?php $JournalDateTo = $arryRecurr[0]['JournalDateTo'] > 0?$arryRecurr[0]['JournalDateTo']:"";?>
                    <input id="JournalDateTo" name="JournalDateTo" readonly="" class="datebox" value="<?=$JournalDateTo;?>"  type="text" > 
                <script type="text/javascript">
                            $(function() {
                            $('#JournalDateTo').datepicker(
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

				$("#JournalDateTo").on("click", function () { 
								 $(this).val("");
							}
						);
                            });
		</script>
                <div class="red" id="EntryToerr" style="margin-left:5px;"></div>

</td>
	</tr>	
	
	
