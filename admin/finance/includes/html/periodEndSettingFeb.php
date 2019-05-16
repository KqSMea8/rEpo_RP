<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader(1,'F');
	return true;	
	
}

$(document).ready(function(){

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
<div class="had"><?= $ModuleName; ?></div>
 
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valign="top">
            <form name="PeriodEndSettingform" id="PeriodEndSettingform" action="" method="post"  enctype="multipart/form-data"> 
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding-left: 100px; text-align: left;" class="message">
                            <?php if ($_SESSION['mess_setting'] != "") { ?><?=
                                $_SESSION['mess_setting'];
                                unset($_SESSION['mess_setting']);
                                ?><?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" >

                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">

                                <tr>
                                    <td align="center" valign="top" >

                                        <table cellspacing="1" cellpadding="5" border="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td width="15%" align="right">
                                                        <?php
                                                        $Year_String = '<select name="PeriodYear1" id="PeriodYear1" class="textbox" style="width: 110px;">';
                                                        $c_year = date('Y')-2;
                                                        $start_year = $c_year+3;
                                                        $Year_String .= '<option value="">Select Year</option>';
                                                        for($y=$c_year;$y<$start_year;$y++){
                                                        //if($arrySettingFields[1]['setting_value'] == $y) $y_selected=' Selected'; else $y_selected='';
                                                        $Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
                                                        }
                                                        $Year_String .= ' </select>';
                                                        echo $Year_String;
                                                        ?>
                                                        
                                                    </td>
                                                    <td width="10%">
                                                        <select name="PeriodMonth1" id="PeriodMonth1" class="textbox" style="width: 110px;">
                                                        <option value="">Select Month</option>
                                                        <?php
                                                         for ($m=1; $m<=12; $m++) {
                                                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                                            if($m < 10) $m = '0'.$m;
                                                            ?>
                                                            
                                                         <option value="<?=$m;?>"><?=$month?></option>
                                                         <?php } ?>
                                                        </select>
                                                        
                                                    </td>
                                                    <td align="right" width="30px">AR</td>
                                                    <td><select name="PeriodStatus1" id="PeriodStatus1" class="inputbox" style="width: 90px;">
                                                              <option value="">Select</option>
                                                                <!--<option value="Open">Open</option>-->
                                                                <option value="Closed">Closed</option>
                                                            </select>
                                                        <input type="hidden" name="PeriodModule1" id="PeriodModule1" value="AR">
                                                        &nbsp;<span class="red"><?=$ARCurrentPeriod;?></span>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td  align="right">
                                                        <?php
                                                        $Year_String = '<select name="PeriodYear2" id="PeriodYear2" class="textbox" style="width: 110px;">';
                                                        $c_year = date('Y')-2;
                                                        $start_year = $c_year+3;
                                                        $Year_String .= '<option value="">Select Year</option>';
                                                        for($y=$c_year;$y<$start_year;$y++){
                                                        //if($arrySettingFields[4]['setting_value'] == $y) $y_selected=' Selected'; else $y_selected='';
                                                        $Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
                                                        }
                                                        $Year_String .= ' </select>';
                                                        echo $Year_String;
                                                        ?>
                                                        
                                                    </td>
                                                    <td width="10%">
                                                        <select name="PeriodMonth2" id="PeriodMonth2" class="textbox" style="width: 110px;">
                                                        <option value="">Select Month</option>
                                                          <?php
                                                         for ($m=1; $m<=12; $m++) {
                                                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                                            if($m < 10) $m = '0'.$m;
                                                            ?>
                                                            
                                                         <option value="<?=$m;?>"><?=$month?></option>
                                                         <?php } ?>
                                                        </select>
                                                        
                                                    </td>
                                                    <td align="right">AP</td>
                                                    <td>  <select name="PeriodStatus2" id="PeriodStatus2" class="inputbox" style="width: 90px;">
                                                            <option value="">Select</option>
                                                               <!--<option value="Open">Open</option>-->
                                                                <option value="Closed">Closed</option>
                                                            </select>
                                                         <input type="hidden" name="PeriodModule2" id="PeriodModule2" value="AP">
                                                         &nbsp;<span class="red"><?=$APCurrentPeriod;?></span>
                                                    </td>
                                                </tr>
                                                
                                                  <tr>
                                                    <td   align="right">
                                                        <?php
                                                        $Year_String = '<select name="PeriodYear3" id="PeriodYear3" class="textbox" style="width: 110px;">';
                                                        $c_year = date('Y')-2;
                                                        $start_year = $c_year+3;
                                                        $Year_String .= '<option value="">Select Year</option>';
                                                        for($y=$c_year;$y<$start_year;$y++){
                                                        //if($arrySettingFields[7]['setting_value'] == $y) $y_selected=' Selected'; else $y_selected='';
                                                        $Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
                                                        }
                                                        $Year_String .= ' </select>';
                                                        echo $Year_String;
                                                        ?>
                                                        
                                                    </td>
                                                    <td width="10%">
                                                        <select name="PeriodMonth3" id="PeriodMonth3" class="textbox" style="width: 110px;">
                                                        <option value="">Select Month</option>
                                                          <?php
                                                         for ($m=1; $m<=12; $m++) {
                                                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                                            if($m < 10) $m = '0'.$m;
                                                            ?>
                                                            
                                                         <option value="<?=$m;?>"><?=$month?></option>
                                                         <?php } ?>
                                                        </select>
                                                        
                                                    </td>
                                                    <td align="right">GL</td>
                                                    <td>  <select name="PeriodStatus3" id="PeriodStatus3" class="inputbox" style="width: 90px;">
                                                            <option value="">Select</option>
                                                               <!--<option value="Open">Open</option>-->
                                                                <option value="Closed">Closed</option>
                                                            </select>
                                                         <input type="hidden" name="PeriodModule3" id="PeriodModule3" value="GL">
                                                         &nbsp;<span class="red"><?=$GLCurrentPeriod;?></span>
                                                    </td>
                                                </tr>
                                                
                                                 <tr>
                                                    <td  align="right">
                                                        <?php
                                                        $Year_String = '<select name="PeriodYear4" id="PeriodYear4" class="textbox" style="width: 110px;">';
                                                        $c_year = date('Y')-2;
                                                        $start_year = $c_year+3;
                                                        $Year_String .= '<option value="">Select Year</option>';
                                                        for($y=$c_year;$y<$start_year;$y++){
                                                        //if($arrySettingFields[10]['setting_value'] == $y) $y_selected=' Selected'; else $y_selected='';
                                                        $Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
                                                        }
                                                        $Year_String .= ' </select>';
                                                        echo $Year_String;
                                                        ?>
                                                        
                                                    </td>
                                                    <td width="10%">
                                                        <select name="PeriodMonth4" id="PeriodMonth4" class="textbox" style="width: 110px;">
                                                        <option value="">Select Month</option>
                                                          <?php
                                                         for ($m=1; $m<=12; $m++) {
                                                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                                            if($m < 10) $m = '0'.$m;
                                                            ?>
                                                            
                                                         <option value="<?=$m;?>"><?=$month?></option>
                                                         <?php } ?>
                                                        </select>
                                                        
                                                    </td>
                                                    <td  align="right">IE</td>
                                                    <td>  <select name="PeriodStatus4" id="PeriodStatus4" class="inputbox" style="width: 90px;">
                                                            <option value="">Select</option>
                                                               <!--<option value="Open">Open</option>-->
                                                                <option value="Closed">Closed</option>
                                                            </select>
                                                        <input type="hidden" name="PeriodModule4" id="PeriodModule4" value="IE">
                                                        &nbsp;<span class="red"><?=$IECurrentPeriod;?></span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>


                        </td>
                    </tr>
                    <tr>
                        <td height="50" valign="top" style="padding-left: 180px;"><br>
                            <input type="hidden" name="NumLine" id="NumLine" value="4">
                            <input name="Submit" type="button" class="button" id="SavePeriodSettings" onClick="Javascript: validatePeriodSettings();" value="Save" />&nbsp;
                        </td>   
                    </tr>

                </table>
            </form>
        </td>
    </tr>
  <tr>
      <td  valign="top" class="had">Period Closed List</td>  
  </tr>
    <tr>
      <td  valign="top">
          <form name="frmSrch" id="frmSrch" action="periodEndSetting.php" method="get" onSubmit="return ValidateSearch();">
                 Module<select style="width: 90px;" class="inputbox" id="PeriodModule" name="PeriodModule">
                    <option value="">All</option>
                    <option value="AR" <?php if($_GET['PeriodModule'] == "AR"){echo "selected";}?>>AR</option>
                     <option value="AP" <?php if($_GET['PeriodModule'] == "AP"){echo "selected";}?>>AP</option>
                      <option value="GL" <?php if($_GET['PeriodModule'] == "GL"){echo "selected";}?>>GL</option>
                     <option value="IE" <?php if($_GET['PeriodModule'] == "IE"){echo "selected";}?>>IE</option>
                 </select>&nbsp;&nbsp;
                  Year <?php
                                $Year_String = '<select name="PeriodYear" id="PeriodYear" class="textbox" style="width: 110px;">';
                                $c_year = date('Y')-2;
                                $start_year = $c_year+3;
                                $Year_String .= '<option value="">All</option>';
                                for($y=$c_year;$y<$start_year;$y++){
                                if($_GET['PeriodYear'] == $y) $y_selected=' Selected'; else $y_selected='';
                                $Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
                                }
                                $Year_String .= ' </select>';
                                echo $Year_String;
                        ?>&nbsp;&nbsp;
                     Month <select name="PeriodMonth" id="PeriodMonth" class="textbox" style="width: 110px;">
                                                        <option value="">All</option>
                                                          <?php
                                                         for ($m=1; $m<=12; $m++) {
                                                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                                            if($m < 10) $m = '0'.$m;
                                                            ?>
                                                            
                                                         <option value="<?=$m;?>" <?php if($_GET['PeriodMonth'] == $m){ echo "selected";}?>><?=$month?></option>
                                                         <?php } ?>
                                                        </select>
               <input type="hidden" name="search" id="search" value="Search">
               <input type="submit" name="sbt" value="Go" class="search_button">
            </form>  
      </td>  
  </tr>
<tr>
   <td  valign="top">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
		<!--<td width="10%" class="head1">Date</td>-->
		<td width="10%" align="center" class="head1">Year</td>
		<td width="10%" align="center" class="head1">Month</td>
		<td width="10%"  align="center" class="head1">Module</td>
		<td width="10%" align="center" class="head1">Status</td>
                <td width="30%" class="head1">Action</td>
    </tr>
   
  <?php if(is_array($arryPeriodFields) && $num>0){
	  	$flag=true;
		$Line=0;
		$invAmnt=0;
  	foreach($arryPeriodFields as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;
	       
            $monthNum  = $values['PeriodMonth'];
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F'); // March
	
  ?>

		
    <tr align="left"  bgcolor="<?=$bgcolor?>">
       
	  <!-- <td height="20">
	   <? if($values['PeriodCreatedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PeriodCreatedDate']));
		?>
	   
	   </td>-->
      <td align="center"><?=$values['PeriodYear']?></td>
      <td align="center"><?=$monthName;?></td>
      <td align="center"><?=$values['PeriodModule']?></td>
      <td align="center"><?=$values['PeriodStatus']?></td>
      <td>
          &nbsp;<a href="editPeriodEndSetting.php?edit=<?php echo $values['PeriodID']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>&nbsp;
         <!--<a href="editPeriodEndSetting.php?del_id=<//?php echo $values['PeriodID']; ?>&curP=<//?php echo $_GET['curP']; ?>" onclick="return confDel('Period')" class="Blue" ><//?= $delete ?></a>-->
         </td>
	  

    </tr>
	

	
        <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  <td  colspan="5"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPeriodFields)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

   <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">

</td>
	</tr>
</table>
