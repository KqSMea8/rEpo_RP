<a href="databaseBackup.php" class="back">Back</a>
<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
    var EntryFrom = Trim(document.getElementById("EntryFrom")).value;
    var EntryTo = Trim(document.getElementById("EntryTo")).value;     
   
                if(!ValidateForSelect(frm.EntryFrom, "Entry From")){        
                  return false;
                }

                if(!ValidateForSelect(frm.EntryTo, "Entry To")){        
                    return false;
                }

                if(EntryFrom >= EntryTo) { 
                    document.getElementById("EntryFrom").focus();   
                    alert("End Date Should be Greater Than Start Date.");
                    return false;
                 }

}
</script>

<script language="JavaScript1.2" type="text/javascript">
   $(document).ready(function(){
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
                else if(TypeInterval == "quaterly"){
                    $("#dStart").show(1000);
                       $("#EntryDate").show(1000);
                       $("#dEveryText").hide(1000);
                       $("#dEveryField").hide(1000);
                       $("#dWeeklyField").hide(1000);
                }
                else if(TypeInterval == "half-yearly"){
                    $("#dStart").show(1000);
                       $("#EntryDate").show(1000);
                       $("#dEveryText").hide(1000);
                       $("#dEveryField").hide(1000);
                       $("#dWeeklyField").hide(1000);
                }
                
                else if(TypeInterval == "weekly"){
                       $("#dEveryText").show(1000);
                       $("#dWeeklyField").show(1000);
                       $("#dEveryField").hide(1000);
                       $("#dStart").hide(1000);
                       $("#EntryDate").hide(1000);
                } else if(TypeInterval == "biweekly"){
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
                else if(TypeInterval == "quaterly"){
                    $("#dStart").show(1000);
                    $("#EntryDate").show(1000);
                }
                else if(TypeInterval == "half-yearly"){
                    $("#dStart").show(1000);
                    $("#EntryDate").show(1000);
                }
                
                else if(TypeInterval == "weekly"){
                    $("#dEveryText").show(1000);
                    $("#dWeeklyField").show(1000);
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
        
});

</script>

<div class="had">Database Cron Setting</div>
   <div class="message"><? if(!empty($_SESSION['mess_cron'])) {echo $_SESSION['mess_cron']; unset($_SESSION['mess_cron']); }?></div>


	 <form name="form1" action="" method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
          <td  align="center" >
&nbsp;
</td>
</tr>
        <tr>
          <td  align="center" >
		<table width="50%"  border="0"   cellpadding="4" cellspacing="1" class="borderall">
                      
       
        
        <?php
for($i=1;$i<8;$i++)
$weekdays [] = date("l",mktime(0,0,0,3,28,2009)+$i * (3600*24));
 
?>

                     
        <tr id="dInterval">
		<td  align="right" class="blackbold" width="45%">Interval :</td>
		<td  align="left" class="blacknormal">
                     <select name="EntryInterval" class="inputbox" id="EntryInterval" style="width:100px;">
                         <option value="daily" <?php if($arryAdmin[0]['EntryInterval'] == "daily"){echo "selected";}?>>Daily</option>
                         <option value="weekly" <?php if($arryAdmin[0]['EntryInterval'] == "weekly"){echo "selected";}?>>Weekly</option>
                         <option value="biweekly" <?php if($arryAdmin[0]['EntryInterval'] == "biweekly"){echo "selected";}?>>Biweekly</option>
                         <option value="semi_monthly" <?php if($arryAdmin[0]['EntryInterval'] == "semi_monthly"){echo "selected";}?>>Semi Monthly</option>
			 <option value="monthly" <?php if($arryAdmin[0]['EntryInterval'] == "monthly"){echo "selected";}?>>Monthly</option>
                         <option value="quaterly" <?php if($arryAdmin[0]['EntryInterval'] == "quaterly"){echo "selected";}?>>Quaterly</option>
                         <option value="half-yearly" <?php if($arryAdmin[0]['EntryInterval'] == "half-yearly"){echo "selected";}?>>Half Yearly</option>
			 <option value="yearly" <?php if($arryAdmin[0]['EntryInterval'] == "yearly"){echo "selected";}?>>Yearly</option>	 
			</select> 
		 
		</td>
		
		</tr>
		
<tr>		
		     
                <td  align="right"   class="blackbold"><span style="display:none;" id="dStart">Entry Date :</span></td>
		<td   align="left">
		<select name="EntryDate" class="inputbox" id="EntryDate" style="width:100px;display:none;">
				<?php		
				 for($i=1;$i<=31;$i++){?>
				<?php if($i<10){$prefix = '0';}else{$prefix='';}?>
				<option value="<?=$prefix.$i;?>" <?php if($arryAdmin[0]['EntryDate'] == $prefix.$i){echo "selected";}?>><?=$prefix.$i;?></option>
				<?php }?>
			</select> 
		
		</td>
               
  </tr>
  
  <tr>
                 
                <td  align="right" class="blackbold"><span  style="display:none;" id="dEveryText">Every :</span></td>
		<td  align="left" class="blacknormal">
                    <span style="display:none;" id="dEveryField">
                     <select name="EntryMonth" class="inputbox" id="EntryMonth" style="width:100px;">
                        <?php
                        for ($m=1; $m<=12; $m++) {
                           $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                           if($m < 10) $m = '0'.$m;
                           ?>

                        <option value="<?=$m;?>" <?php if($arryAdmin[0]['EntryMonth'] == $m){echo "selected";}?>><?=$month?></option>
                        <?php } ?>
			</select> 
		 </span>
                  <span style="display:none;" id="dWeeklyField">
                     <select name="EntryWeekly" class="inputbox" id="EntryWeekly" style="width:100px;">
                        <?php
                       foreach($weekdays as $day) {
                           if(!empty($arryAdmin[0]['EntryWeekly'])){
                            $EntryWeek = $arryAdmin[0]['EntryWeekly'];
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

    <tr  id="dFrom">
		<td  align="right" class="blackbold">Entry From :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
                    <?php $EntryFrom = $arryAdmin[0]['EntryFrom'] > 0?$arryAdmin[0]['EntryFrom']:"";?>
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

<tr>
		<td  align="right"   class="blackbold">Entry To :<span class="red">*</span></td>
		<td  align="left" class="blacknormal">
                      <?php $EntryTo = $arryAdmin[0]['EntryTo'] > 0?$arryAdmin[0]['EntryTo']:"";?>
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
	
	
	 </table>
		 </td>
	 </tr>
				  
		
 <tr>
			      <td align="center">

<input name="Submit" type="submit" value="Update" class="button" />
      <input  type="hidden" name="ConfigID" id="ConfigID" value="1" />
 </td>
			      </tr>


      </table> 
    
      

			
						
						 
	</form>
 
      
	
        
