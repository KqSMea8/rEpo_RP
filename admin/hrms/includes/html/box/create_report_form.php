<script language="JavaScript1.2" type="text/javascript">
 function validateLeadForm(frm){
   
    var listbox = document.getElementById("columnTo");
    
    var len = listbox.options.length;
    if(len>0){
        for(var count=0; count < len; count++) {
                listbox.options[count].selected = true;
        }
    }else{
        alert('Please Move Fields to Form Fields.');
         return false;
    }
    
    if(!ValidateForSimpleBlank(frm.FormTitle, "Form Title")) {
        return false;
    }
   

if(!ValidateForSelect(frm.FromDate, "From Date")) {
        return false;
    }

if(!ValidateForSelect(frm.ToDate, "To Date")) {
        return false;
    }


		
		
			if(frm.ToDate.value<frm.FromDate.value){
				alert(" To Date should be greater than From Date.");
				return false;
			}
    /*if(!ValidateForSimpleBlank(frm.ActionUrl, "Form Action Url")) {
        return false;
    }*/
    
   ShowHideLoader('1', 'S');
   return true;
        
}
   
function MoveFields() {
     $("#first_div").hide();
     $("#add_all_div").hide();
     $("#move_div").show();
     $("#cancel").show();
     $("#submit").show();
     $("#other_info").show();
     $("#entry_all").val("0");
 }

</script>

 <script type="text/javascript">  
  $().ready(function() { 
      
   $('#fromall').click(function() { 
    return !$('#columnFrom option').remove().appendTo('#columnTo');  
   });  
   $('#add').click(function() { 
    return !$('#columnFrom option:selected').remove().appendTo('#columnTo');  
   });  
   $('#remove').click(function() {  
    return !$('#columnTo option:selected').remove().appendTo('#columnFrom');  
   });  
   $('#removeall').click(function() { 
    return !$('#columnTo option').remove().appendTo('#columnFrom');  
   });
  });  
 </script> 




<div id="preview_div">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    

 

    
 
<form name="form1" action=""  method="post" onSubmit="return validateLeadForm(this);" enctype="multipart/form-data">
  <tr>
    <td  align="center" valign="top" >

<div id="move_div">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
       <td align="center" class="head" width="40%">
    Available Fields
       </td>
       <td class="head"></td>
       <td align="center" class="head" width="40%">
    Form Fields
       </td>
</tr>
<tr>
       <td align="center" >
    <? 


echo '<select name="columnFrom[]" id="columnFrom"  class="inputbox" style="width:300px;height:300px;" multiple>';
for ($j = 1; $j <= sizeof($column); $j++) {
   
    $columnHead = $column[$j - 1]["colum_name"] . ':' .  $column[$j - 1]["colum_value"] . '';

    

	 $sel = '';
    if(!empty($arryColVal[$i - 1]['colvalue'])){
	$sel = ($column[$j - 1]["colum_value"] == $arryColVal[$i - 1]['colvalue']) ? ('selected') : ('');
    }
    echo '<option value="' . $columnHead . '" ' . $sel . '>' . $column[$j - 1]["colum_name"] . '</option>';
}
echo '</select>';   
    
    
    ?>
       </td>
       <td align="center" valign="top">
           <br><br> <br> <br> 
            <input type="button" value=" &raquo; &raquo; " name="fromall" id="fromall" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Move All</center>', 100,'')"; onMouseout="hideddrivetip()"> <br><br> 
           <input type="button" value=" &raquo;  " name="frombt" id="add" class="grey_bt" style="padding:5px;width:40px;"  onMouseover="ddrivetip('<center>Move Selected</center>', 100,'')"; onMouseout="hideddrivetip()">  <br> <br>
           <input type="button" value=" &laquo;  " name="tobt" id="remove" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Remove Selected</center>', 100,'')"; onMouseout="hideddrivetip()"> <br><br> 
           
           <input type="button" value=" &laquo; &laquo; " name="tobt" id="removeall" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Remove All</center>', 100,'')"; onMouseout="hideddrivetip()"> 
       </td>
       <td align="center">
      <? 
echo '<select name="columnTo[]" id="columnTo"  class="inputbox" style="width:300px;height:300px;" multiple>';

echo '</select>';   
    
    
    ?>
       </td>
</tr>

</table>	
</div> 

 
 <br>
<div id="other_div">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
    
<tr>
<td  align="right"   class="blackbold" width="20%">  Title : <span class="red">*</span> </td>
        <td   align="left" >          
                <input name="FormTitle" type="text" class="inputbox" id="FormTitle"   value=" "  maxlength="100" />        
           </td>
</tr>

<tr>
                      <td width="45%" align="right"  class="blackbold">
					 From Date : <span class="red">*</span>
					  </td>
                      <td align="left">
<? if($arrayReport[0]['FromDate']>0) $FromDate = $arrayReport[0]['FromDate'];  ?>				
<script type="text/javascript">
$(function() {
	$('#FromDate').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd', 
		//yearRange: '<?=$YearStart?>:<?=$YearEnd?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="FromDate" name="FromDate" readonly="" class="datebox" value="<?=$FromDate?>"  type="text" > 



					  </td>
                    </tr>
                    <tr>
                      <td  align="right"   class="blackbold"> 
					To Date : <span class="red">*</span>

					  </td>
                      <td  align="left" valign="top">
<? if($arrayReport[0]['ToDate']>0) $ToDate = $arrayReport[0]['ToDate'];  ?>				

<script type="text/javascript">
$(function() {
	$('#ToDate').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd', 
		//yearRange: '<?=$YearStart?>:<?=$YearEnd?>', 
				changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="ToDate" name="ToDate" readonly="" class="datebox" value="<?=$ToDate?>"  type="text" > 

					  </td>
                    </tr>

<tr>
        <td  align="right"   class="blackbold" 
		>Display Punch  : </td>
        <td   align="left"  >
          <? 
		  	 $PunchChecked = ' checked';$NoPunchChecked ='';
			 if($_GET['edit'] > 0){
				 if($PunchCheck == "Yes") {$PunchChecked = ' checked'; $NoPunchChecked ='';}
				 if($PunchCheck == "No") {$PunchChecked = ''; $NoPunchChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="PunchCheck" id="PunchCheck" value="Yes" <?=$PunchChecked?> />
          Yes&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="PunchCheck" id="PunchCheck1" value="No" <?=$NoPunchChecked?> />
          No </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" 
		>Display Breaks  : </td>
        <td   align="left"  >
          <? 
		  	$BreakChecked = ' checked'; $NoBreakChecked = ' checked';
			 if($_GET['edit'] > 0){
				 if($BreakStatus == "Yes") {$BreakChecked = ' checked'; $NoBreakChecked ='';}
				 if($BreakStatus == "No") {$BreakChecked = ''; $NoBreakChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="BreakCheck" id="BreakCheck" value="Yes" <?=$BreakChecked?> />
          Yes&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="BreakCheck" id="BreakCheck" value="No" <?=$NoBreakChecked?> />
          No </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" 
		> Display Duration  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked'; $InActiveChecked ='';
			 if($_GET['edit'] > 0){
				 if($ReportStatus == "Yes") {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($ReportStatus == "No") {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="DurationCheck" id="DurationCheck" value="Yes" <?=$ActiveChecked?> />
          Yes&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="DurationCheck" id="DurationCheck" value="No" <?=$InActiveChecked?> />
          No </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" 
		> Duration Format  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' '; $InActiveChecked =' checked';
			 if($_GET['edit'] > 0){
				 if($ReportDurationFormat == "1") {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($ReportDurationFormat == "0") {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
	 <input type="radio" name="DurationFormat" id="DurationFormat" value="0" <?=$InActiveChecked?> />         
          HH:MM&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="DurationFormat" id="DurationFormat" value="1" <?=$ActiveChecked?> />
          HH.Decimal  </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked'; $InActiveChecked ='';
			 if($_GET['edit'] > 0){
				 if($ReportStatus == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($ReportStatus == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>
      </tr>

</table>
</div>
        

	
        <br>
   
	
	</td>
   </tr>

   
   <tr>
    <td  align="center">
	
<input type="submit" name="submit" id="submit" value="Submit" class="button" >        

<input name="reportID" type="hidden" class="inputbox" id="reportID"   value=""  maxlength="100" /> 

</td>
   </tr>
   </form>

</table>
</div>

