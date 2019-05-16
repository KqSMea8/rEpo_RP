<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader(1,'F');
	return true;	
	
}




$(document).ready(function(){

$( ".textbox" ).selectmenu({});


$("#CloseYearSettings").click(function(){
	ShowHideLoader(1,'S');
        document.getElementById("PeriodEndSettingform").submit();
        return true;
});



$("#SavePeriodSettings").click(function(){
     
     var NumLine = $("#NumLine").val();
     var PeriodYearLen = 0;
     var PeriodMonthLen = 0;
     var PeriodStatusLen = 0;
     
     for(var i=1;i<=NumLine;i++)
         {
              PeriodYearLen += $("#PeriodYear"+i).val().length;
              PeriodMonthLen += $("#PeriodMonth"+i).val().length;
              PeriodStatusLen += $("#PeriodStatus"+i).val().length;
           
         }
        // alert(PeriodStatusLen);
         //return false;
          if(PeriodYearLen == 0 || PeriodMonthLen == 0 || PeriodStatusLen == 0)
                 {
                     alert("Please select atleast one module for month close.");
                     return false;
                 }
           else{
                         
              /********AJAX CODE START*************************************************************************************/
             var ww = 0;
             var qq = 0;
               for(var j=1;j<=NumLine;j++)
                {
                     var PeriodYear = $("#PeriodYear"+j).val();
                     var PeriodMonth = $("#PeriodMonth"+j).val();
                     var PeriodStatus = $("#PeriodStatus"+j).val();
                     var PeriodModule = $("#PeriodModule"+j).val();
                     
                        var data = 'action=CheckPeriodSettings&PeriodYear='+PeriodYear+'&PeriodMonth='+PeriodMonth+'&PeriodStatus='+PeriodStatus+'&PeriodModule='+PeriodModule;
                        
                           if(PeriodYear != '' && PeriodMonth != '' && PeriodStatus != '')
                            { 
                                $.ajax({
                                        type: "GET",
                                        url: "ajax.php",
                                        data: data,
                                        success: function (msg) {
                                           ww += parseFloat(msg);
                                           
                                            if(msg != 1)
                                            { 
                                                alert(msg);
                                                return false;
                                              
                                            }
                                            if(ww == qq){
                                                
                                                ShowHideLoader(1,'S');
                                                document.getElementById("PeriodEndSettingform").submit();
                                                return true;
                                            }
                                            
                                              
                                        }
                                     
                                    });
                                         
                                    qq = qq+1;
                     }
                    
                    
                  
                    
                }
              
             /***************************AJAX CODE END************************************************************************************/
                    
         }
     
 });
        
});
    
 
 
</script>
<div class="had"><?=$MainModuleName?> Settings</div>
 
<?  if (!empty($ErrorMsg)) {   ?>
<div class="redmsg" align="center"><?=$ErrorMsg?></div>
<?php } else {?>

<div class="message"> <?php 
	if(!empty($_SESSION['mess_setting'])) { 
		echo $_SESSION['mess_setting'];
		unset($_SESSION['mess_setting']);
	} ?>
</div>
 

  <table cellspacing="0" cellpadding="0" border="0" width="100%" >
        <tr>
            <td>

  <form name="PeriodEndSettingform" id="PeriodEndSettingform" action="" method="post"  enctype="multipart/form-data"> 
  <table cellspacing="1" cellpadding="0" border="0" width="100%" class="borderall">
    <tr>
	<td width="10%" align="right">
	<?php
	$Year_String = '<select name="PeriodYear1" id="PeriodYear1" class="textbox" style="width: 120px;">
			<option value="">Select Year</option>';
	$c_year = $CurrentYearFiscal;
	$start_year = $CurrentYearFiscal;	
	for($y=$c_year;$y<=$start_year;$y++){        
		$Year_String .= '<option value="'.$y.'" > '.$y.' </option>';
	}
	$Year_String .= ' </select>';
	echo $Year_String;
	?>

	</td>
    <td width="10%">
	<?
	$Month_String = '<select name="PeriodMonth1" id="PeriodMonth1" class="textbox" style="width: 120px;">
			<option value="">Select Month</option>';
	$Month_String .=  getMonthOption($MinMonth,$arryARPeriod[1]);	
	$Month_String .= ' </select>';
	echo $Month_String;
	?>

        
    </td>
    <td align="right" width="5%">AR</td>
    <td width="10%"><select name="PeriodStatus1" id="PeriodStatus1" class="textbox" style="width: 90px;">
              <option value="">Select</option>
                <!--<option value="Open">Open</option>-->
                <option value="Closed">Closed</option>
            </select>
        <input type="hidden" name="PeriodModule1" id="PeriodModule1" value="AR">
       
    </td>
  <td class="red">Current Period : <?=date("F Y",strtotime($ARCurrentPeriod))?></td>
<td width="40%"></td>
</tr>
                                                
    <tr>
    <td  align="right">
        <?php
        $Year_String = '<select name="PeriodYear2" id="PeriodYear2" class="textbox" style="width: 120px;">
		<option value="">Select Year</option>';
	$c_year = $CurrentYearFiscal;
	$start_year = $CurrentYearFiscal;
        for($y=$c_year;$y<=$start_year;$y++){
        	$Year_String .= '<option value="'.$y.'"> '.$y.' </option>';
        }
        $Year_String .= ' </select>';
        echo $Year_String;
        ?>
        
    </td>
    <td>
	<?
	$Month_String = '<select name="PeriodMonth2" id="PeriodMonth2" class="textbox" style="width: 120px;">
			<option value="">Select Month</option>';
	$Month_String .=  getMonthOption($MinMonth,$arryAPPeriod[1]);	
	$Month_String .= ' </select>';
	echo $Month_String;
	?>

  </td>
    <td align="right">AP</td>
    <td>  <select name="PeriodStatus2" id="PeriodStatus2" class="textbox" style="width: 90px;">
            <option value="">Select</option>
               <!--<option value="Open">Open</option>-->
                <option value="Closed">Closed</option>
            </select>
         <input type="hidden" name="PeriodModule2" id="PeriodModule2" value="AP">
         
    </td>
 <td class="red">Current Period : <?=date("F Y",strtotime($APCurrentPeriod))?></td>
   <td></td> 
</tr>
                                                
  <tr>
    <td   align="right">
        <?php
        $Year_String = '<select name="PeriodYear3" id="PeriodYear3" class="textbox" style="width: 120px;">
		<option value="">Select Year</option>';
	$c_year = $CurrentYearFiscal;
	$start_year = $CurrentYearFiscal;      
        for($y=$c_year;$y<=$start_year;$y++){      
       		$Year_String .= '<option value="'.$y.'"> '.$y.' </option>';
        }
        $Year_String .= ' </select>';
        echo $Year_String;
        ?>
        
    </td>
    <td>
       <?
	$Month_String = '<select name="PeriodMonth3" id="PeriodMonth3" class="textbox" style="width: 120px;">
			<option value="">Select Month</option>';	
	$Month_String .=  getMonthOption($MinMonth,$arryGLPeriod[1]);		
	$Month_String .= ' </select>';
	echo $Month_String;
	?>
        
    </td>
    <td align="right">GL</td>
    <td>  <select name="PeriodStatus3" id="PeriodStatus3" class="textbox" style="width: 90px;">
            <option value="">Select</option>
               <!--<option value="Open">Open</option>-->
                <option value="Closed">Closed</option>
            </select>
         <input type="hidden" name="PeriodModule3" id="PeriodModule3" value="GL">
         
    </td>
<td class="red">Current Period : <?=date("F Y",strtotime($GLCurrentPeriod))?></td>
   <td></td> 
</tr>

 <tr>
    <td  align="right">
        <?php
        $Year_String = '<select name="PeriodYear4" id="PeriodYear4" class="textbox" style="width: 120px;">
			<option value="">Select Year</option>';
$c_year = $CurrentYearFiscal;
$start_year = $CurrentYearFiscal;       
        for($y=$c_year;$y<=$start_year;$y++){        
        	$Year_String .= '<option value="'.$y.'" > '.$y.' </option>';
        }
        $Year_String .= ' </select>';
        echo $Year_String;
        ?>
        
    </td>
    <td >
        <?
	$Month_String = '<select name="PeriodMonth4" id="PeriodMonth4" class="textbox" style="width: 120px;">
			<option value="">Select Month</option>';	
	$Month_String .=  getMonthOption($MinMonth,$arryINVPeriod[1]);		
	$Month_String .= ' </select>';
	echo $Month_String;
	?>
        
    </td>
    <td  align="right">INV</td>
    <td>  <select name="PeriodStatus4" id="PeriodStatus4" class="textbox" style="width: 90px;">
            <option value="">Select</option>
               <!--<option value="Open">Open</option>-->
                <option value="Closed">Closed</option>
            </select>
        <input type="hidden" name="PeriodModule4" id="PeriodModule4" value="INV">
         
    </td>

<td class="red">Current Period : <?=date("F Y",strtotime($INVCurrentPeriod))?></td>

   <td align="left">

<? if($PrevMonth==12  && $PeriodMonthExist==1 && $PrevYearStatus!='Closed'){?>
			<input type="hidden" name="PrevYearClose" id="PrevYearClose" value="<?=$PrevYear?>" readonly>
                            <input name="CloseYear" id="CloseYearSettings" type="button" class="button"   value="Close Year : <?=$PrevYear?>" onClick="Javascript: validateYearClose();"/>&nbsp;
			<? }else{ ?>
			  <input type="hidden" name="NumLine" id="NumLine" value="4">
                            <input name="Submit" type="button" class="button" id="SavePeriodSettings" onClick="Javascript: validatePeriodSettings();" value="Save" />&nbsp;
			<? } ?>


</td> 
	 
</tr>

                                 


                            </table>


                        
            </form>
        </td>
    </tr>
<tr>
   <td  valign="top"> &nbsp; </td>  
  </tr>
<tr>
   <td  valign="top"> <? include_once("includes/html/box/period_year_list.php"); ?> </td>  
  </tr>
<tr>
   <td  valign="top"> &nbsp; </td>  
  </tr>
<tr>
   <td  valign="top"> <? include_once("includes/html/box/period_closed_list.php"); ?> </td>  
  </tr>
<tr>
   <td  valign="top"> &nbsp; </td>  
  </tr>

  </table>

   
<? } ?>
