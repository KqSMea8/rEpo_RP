<script language="JavaScript1.2" type="text/javascript">
  /*$(document).ready(function(){
        
        $("#EntryTypeGL").change(function(){

	var TypeValGL = $(this).val();
	if(TypeValGL == "recurring"){
                $("#dIntervalGL").show(1000);
		$("#dFromGL").show(1000);
		$("#dToGL").show(1000);
		$("#EntryDateGL").show(1000);
                $("#dStartGL").show(1000);
	}else{
                $("#dIntervalGL").hide(1000);
                $("#dFromGL").hide(1000);
                $("#dToGL").hide(1000);
                $("#EntryDateGL").hide(1000);
                $("#dStartGL").hide(1000);
               
		
	}

});


	var TypeValGL = $("#EntryTypeGL").val();
	if(TypeValGL == "recurring"){
                    $("#dIntervalGL").show(1000);
                    $("#dFromGL").show(1000);
                    $("#dToGL").show(1000);
                    $("#EntryDateGL").show(1000);	
                    $("#dStartGL").show(1000);
	}else{
                    $("#dIntervalGL").hide(1000);
                    $("#dFromGL").hide(1000);
                    $("#dToGL").hide(1000);
                    $("#EntryDateGL").hide(1000);
                    $("#dStartGL").hide(1000);
                
	}
        
        
        
        
          $("#EntryIntervalGL").change(function(){

                var TypeInterval = $(this).val();
                if(TypeInterval == "yearly"){
                        $("#dEveryTextGL").show(1000);
                        $("#dEveryFieldGL").show(1000);	
                }else{
                        $("#dEveryTextGL").hide(1000);
                        $("#dEveryFieldGL").hide(1000);
                       
                }

            });


	var TypeInterval = $("#EntryIntervalGL").val();
	if(TypeInterval == "yearly"){
		$("#dEveryTextGL").show(1000);
                $("#dEveryFieldGL").show(1000);	
	}else{
	        $("#dEveryTextGL").hide(1000);
                $("#dEveryFieldGL").hide(1000);
	}
});*/
    
    $(document).ready(function(){
        
        $("#EntryTypeGL").change(function(){

	var TypeVal = $(this).val();
	if(TypeVal == "recurring"){
                $("#dIntervalGL").show(1000);
		$("#dFromGL").show(1000);
		$("#dToGL").show(1000);
		
                
	}else{
                $("#dIntervalGL").hide(1000);
		$("#dFromGL").hide(1000);
		$("#dToGL").hide(1000);
		 
		
	}

});


	var TypeVal = $("#EntryTypeGL").val();
	if(TypeVal == "recurring"){
                $("#dIntervalGL").show(1000);
                $("#dFromGL").show(1000);
                $("#dToGL").show(1000);
                
	}else{
                $("#dIntervalGL").hide(1000);
                $("#dFromGL").hide(1000);
                $("#dToGL").hide(1000);
               
                
	}
        
        
        $("#EntryIntervalGL").change(function(){

                var TypeInterval = $(this).val();
                if(TypeInterval == "yearly"){
                        $("#dEveryTextGL").show(1000);
                        $("#dEveryFieldGL").show(1000);
                        $("#dStartGL").show(1000);
                        $("#EntryDateGL").show(1000);
                        $("#dWeeklyFieldGL").hide(1000);
                }else if(TypeInterval == "monthly"){
                       $("#dStartGL").show(1000);
                       $("#EntryDateGL").show(1000);
                       $("#dEveryTextGL").hide(1000);
                       $("#dEveryFieldGL").hide(1000);
                       $("#dWeeklyFieldGL").hide(1000);
                } 
                else if(TypeInterval == "biweekly"){
                       $("#dEveryTextGL").show(1000);
                       $("#dWeeklyFieldGL").show(1000);
                       $("#dEveryFieldGL").hide(1000);
                       $("#dStartGL").hide(1000);
                       $("#EntryDateGL").hide(1000);
                } 
                else{
                        $("#dEveryTextGL").hide(1000);
                        $("#dEveryFieldGL").hide(1000);
                        $("#dStartGL").hide(1000);
                        $("#EntryDateGL").hide(1000);
                        $("#dWeeklyFieldGL").hide(1000);
                       
                }
                
            
                

            });


	var TypeInterval = $("#EntryIntervalGL").val();
       
               if(TypeInterval == "yearly"){
                    $("#dEveryTextGL").show(1000);
                    $("#dEveryFieldGL").show(1000);
                    $("#dStartGL").show(1000);
                    $("#EntryDateGL").show(1000);
                    $("#dWeeklyFieldGL").hide(1000);
                } 
               else if(TypeInterval == "monthly"){
                    $("#dStartGL").show(1000);
                    $("#EntryDateGL").show(1000);
                }
                else if(TypeInterval == "biweekly"){
                    $("#dEveryTextGL").show(1000);
                    $("#dWeeklyFieldGL").show(1000);
                }
                else{
                    $("#dEveryTextGL").hide(1000);
                    $("#dEveryFieldGL").hide(1000);
                    $("#dStartGL").hide(1000);
                    $("#EntryDateGL").hide(1000);
                    $("#dWeeklyFieldGL").hide(1000);
                }
        
});

</script>
<?php

for($i=1;$i<8;$i++)
$weekdaysGl [] = date("l",mktime(0,0,0,3,28,2009)+$i * (3600*24));
 
?>
  <tr>
		<td  align="right" class="blackbold">Entry Type  :</td>
		<td   align="left">
		  <select name="EntryTypeGL" class="inputbox" id="EntryTypeGL" style="width:100px;">
				<option value="one_time" <?php if($arryRecurr[0]['EntryType'] == "one_time"){echo "selected";}?>>One Time</option>
				<option value="recurring" <?php if($arryRecurr[0]['EntryType'] == "recurring"){echo "selected";}?>>Recurring</option>	 
			</select> 
		</td>
                
                <td  align="right"   class="blackbold"><span style="display:none;" id="dStartGL">Entry Date :</span></td>
		<td   align="left">
		<select name="EntryDateGL" class="inputbox" id="EntryDateGL" style="width:100px;display:none;">
				<?php		
				 for($i=1;$i<=31;$i++){?>
				<?php if($i<10){$prefix = '0';}else{$prefix='';}?>
				<option value="<?=$prefix.$i;?>" <?php if($arryRecurr[0]['EntryDate'] == $prefix.$i){echo "selected";}?>><?=$prefix.$i;?></option>
				<?php }?>
			</select> 
		
		</td>
	</tr>	
        
        <tr style="display:none;" id="dIntervalGL">
		<td  align="right" class="blackbold">Interval :</td>
		<td  align="left" class="blacknormal">
                     <select name="EntryIntervalGL" class="inputbox" id="EntryIntervalGL" style="width:100px;">
                         <option value="biweekly" <?php if($arryRecurr[0]['EntryInterval'] == "biweekly"){echo "selected";}?>>Biweekly</option>
                         <option value="semi_monthly" <?php if($arryRecurr[0]['EntryInterval'] == "semi_monthly"){echo "selected";}?>>Semi Monthly</option>
			 <option value="monthly" <?php if($arryRecurr[0]['EntryInterval'] == "monthly"){echo "selected";}?>>Monthly</option>
			 <option value="yearly" <?php if($arryRecurr[0]['EntryInterval'] == "yearly"){echo "selected";}?>>Yearly</option>
			</select> 
		 

		</td>
                 
                <td  align="right" class="blackbold"><span style="display:none;" id="dEveryTextGL">Every :</span></td>
		<td  align="left" class="blacknormal">
                    <span style="display:none;" id="dEveryFieldGL">
                     <select name="EntryMonthGL" class="inputbox" id="EntryMonthGL" style="width:100px;">
                        <?php
                        for ($m=1; $m<=12; $m++) {
                           $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                           if($m < 10) $m = '0'.$m;
                           ?>

                        <option value="<?=$m;?>"><?=$month?></option>
                        <?php } ?>
			</select> 
		 </span>
                    
                  <span style="display:none;" id="dWeeklyFieldGL">
                     <select name="EntryWeeklyGL" class="inputbox" id="EntryWeeklyGL" style="width:100px;">
                        <?php
                       foreach($weekdaysGl as $day) {
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

    <tr style="display:none;" id="dFromGL">
		<td  align="right" class="blackbold">Entry From :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
                    <?php $EntryFrom = $arryRecurr[0]['EntryFrom'] > 0?$arryRecurr[0]['EntryFrom']:"";?>
                    <input id="EntryFromGL" name="EntryFromGL" readonly="" class="datebox" value="<?=$EntryFrom;?>"  type="text" >
		<script type="text/javascript">
			$(function() {
                                $('#EntryFromGL').datepicker(
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

		</td>
	
		<td  align="right"   class="blackbold">Entry To :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
                      <?php $EntryTo = $arryRecurr[0]['EntryTo'] > 0?$arryRecurr[0]['EntryTo']:"";?>
                    <input id="EntryToGL" name="EntryToGL" readonly="" class="datebox" value="<?=$EntryTo;?>"  type="text" > 
                <script type="text/javascript">
                            $(function() {
                            $('#EntryToGL').datepicker(
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
                            });
		</script>


</td>
	</tr>	
	
	
 