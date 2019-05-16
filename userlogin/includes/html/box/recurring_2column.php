<script language="JavaScript1.2" type="text/javascript">
   $(document).ready(function(){
        
        $("#EntryType").change(function(){

	var TypeVal = $(this).val();
	if(TypeVal == "recurring"){
                $("#dInterval").show(1000);
		$("#dFrom").show(1000);
		$("#dTo").show(1000);
		$("#dStart").show(1000);
                $("#EntryDate").show(1000);
                
	}else{
                $("#dInterval").hide(1000);
		$("#dFrom").hide(1000);
		$("#dTo").hide(1000);
		$("#dStart").hide(1000);
                $("#EntryDate").hide(1000);
		
	}

});


	var TypeVal = $("#EntryType").val();
	if(TypeVal == "recurring"){
                $("#dInterval").show(1000);
                $("#dFrom").show(1000);
                $("#dTo").show(1000);
                $("#dStart").show(1000);
                $("#EntryDate").show(1000);
	}else{
                $("#dInterval").hide(1000);
                $("#dFrom").hide(1000);
                $("#dTo").hide(1000);
                $("#dStart").hide(1000);
                $("#EntryDate").hide(1000);
                
	}
        
        
        $("#EntryInterval").change(function(){

                var TypeInterval = $(this).val();
                if(TypeInterval == "yearly"){
                        $("#dEveryText").show(1000);
                        $("#dEveryField").show(1000);	
                }else{
                        $("#dEveryText").hide(1000);
                        $("#dEveryField").hide(1000);
                       
                }

            });


	var TypeInterval = $("#EntryInterval").val();
	if(TypeInterval == "yearly"){
		$("#dEveryText").show(1000);
                $("#dEveryField").show(1000);	
	}else{
	        $("#dEveryText").hide(1000);
                $("#dEveryField").hide(1000);
	}
});


  
        

</script>

  <tr>
		<td  align="right" class="blackbold">Entry Type  :</td>
		<td   align="left">
		  <select name="EntryType" class="inputbox" id="EntryType" style="width:100px;">
				<option value="one_time" <?php if($arryRecurr[0]['EntryType'] == "one_time"){echo "selected";}?>>One Time</option>
				<option value="recurring" <?php if($arryRecurr[0]['EntryType'] == "recurring"){echo "selected";}?>>Recurring</option>	 
			</select> 
		</td>
                
                
           
                <td  align="right"   class="blackbold"><span style="display:none;" id="dStart">Entry Date :</span></td>
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

		</td>

		<td  align="right"   class="blackbold">Entry To :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
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
                            });
		</script>


</td>
	</tr>	
	
	
	