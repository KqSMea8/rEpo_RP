<script language="JavaScript1.2" type="text/javascript">
   $(document).ready(function(){
        
        $("#EntryType").change(function(){

	var TypeVal = $(this).val();
	if(TypeVal == "recurring"){
		$("#dFrom").show(1000);
		$("#dTo").show(1000);
		$("#dStart").show(1000);		
	}else{
		$("#dFrom").hide(1000);
		$("#dTo").hide(1000);
		$("#dStart").hide(1000);
               
		
	}

});


	var TypeVal = $("#EntryType").val();
	if(TypeVal == "recurring"){
		$("#dFrom").show(1000);
		$("#dTo").show(1000);
		$("#dStart").show(1000);		
	}else{
		$("#dFrom").hide(1000);
		$("#dTo").hide(1000);
		$("#dStart").hide(1000);
                
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
	</tr>	

    <tr style="display:none;" id="dTo">
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
	
	
	<tr style="display:none;" id="dStart">
		<td  align="right"   class="blackbold">Entry Date :</td>
		<td   align="left">
		<select name="EntryDate" class="inputbox" id="EntryDate" style="width:100px;">
				<?php		
				 for($i=1;$i<=31;$i++){?>
				<?php if($i<10){$prefix = '0';}else{$prefix='';}?>
				<option value="<?=$prefix.$i;?>" <?php if($arryRecurr[0]['EntryDate'] == $prefix.$i){echo "selected";}?>><?=$prefix.$i;?></option>
				<?php }?>
			</select> 
		
		</td>
	</tr>	