<?php  
(empty($intr))?($intr=""):("");
(empty($inendtr))?($inendtr=""):("");
(empty($style))?($style=""):("");
(empty($head))?($head=""):("");
(empty($arrayvalues))?($arrayvalues=array()):("");
(empty($arryLead))?($arryLead=array()):(""); 
(empty($json_response2))?($json_response2 = ''):("");
(empty($none))?($none=""):("");


$labelArray = array('LeadSource'=>'lead_source','LeadStatus'=>'lead_status','LeadIndustry'=>'Industry','SalesStage'=>'SalesStage','Type'=>'OpportunityType',
    'TicketStatus'=> 'Status','Priority'=>'priority','TicketCategory'=>'category','PaymentMethod'=>'PaymentMethod',
    'ShippingMethod'=>'carrier','ActivityStatus'=> 'status','ActivityType'=>'activityType','expectedresponse'=>'expectedresponse','campaigntype'=>'campaigntype','campaignstatus'=>'campaignstatus');
$j=1;
foreach($arryField as $key=>$values){
    
    $mand='';
    if($values['mandatory']==1){
        $mand='<span class="red">*</span>';
        $inputmand = 'y' ;
    }else{
         $inputmand = 'n' ;
    }
   
  if($head==1 && $j==1){
     echo '<tr>';
  }elseif($head=='')
  {
     $intr ='<tr>';$inendtr='<tr/>';
  }
        $dis = ($values['fieldname'] == 'location' || $values['fieldname'] == 'activityType' || $values['fieldname'] == 'Notification' || $values['fieldname'] == 'visibility' || $values['fieldname'] == 'EmpID' || $values['fieldname'] == 'RelatedType')?  $none : '';

    $carr = array('budgetcost','actualcost','expectedrevenue','expectedroi','actualroi','sell_price');
    $currDis = (in_array($values['fieldname'],$carr)? '('.$Config['Currency'].')' : '');
    if($values['type']=='text'){
            
            echo ''.$intr.'
                    <td width="25%"  align="right" valign="top" '.$dis.'  class="blackbold">'.$values['fieldlabel'].''.$currDis.':'.$mand.' </td>
                    <td width="25%" align="left" valign="top" '.$dis.'  >';
		 if($values['fieldname'] == 'EmpID')
            {?>       <input type="text" class="inputbox" id="demo-input-facebook-theme" name="EmpID" />
               <?php if ($_GET['edit'] > 0 && $json_response2 != '') { ?>
                                
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#demo-input-facebook-theme").tokenInput("multiSelectAll.php", {
                                            theme: "facebook",
                                            preventDuplicates: true,
                                            prePopulate: <?= $json_response2 ?>,
                                            propertyToSearch: "name",
                                            resultsFormatter: function(item) {
                                                return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                            },
                                            //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                            tokenFormatter: function(item) {
                                                return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " ' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                            },
                                        });
                                    });
                                </script>


                                    <?php }else{?>
                                
                                 <script type="text/javascript">
                        $(document).ready(function() {
                            $("#demo-input-facebook-theme").tokenInput("multiSelectAll.php", {
                                theme: "facebook",
                                preventDuplicates: true,
                                propertyToSearch: "name",
                                resultsFormatter: function(item) {
                                    return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                },
                                //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                tokenFormatter: function(item) {
                                    return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                },
                            });
                        });
                        </script>
                                    <?php }?>

                
            <?php }else{
            echo '<input maxlength="'.$values['maximumlength'].'" data-mand="'.$inputmand.'" type="text" class="inputbox" name="'.$values['fieldname'].'" id="'.$values['fieldname'].'" value="'.stripslashes($arrayvalues[$values['fieldname']]).'" />'.$currDis;
             }   
            echo '<div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;

    }
    
    if($values['type']=='select'){
            if($values['fieldname'] == 'country_id'){ $java = 'onChange="Javascript: StateListSend();"';}elseif($values['fieldname'] == 'RelatedType'){$java = 'onchange="selModule()";';}else{ $java = '';}

                echo ''.$intr.'
                                <td width="25%"  align="right" valign="top" '.$dis.'  class="blackbold">'.$values['fieldlabel'].''.$currDis.':'.$mand.'</td>
                                <td width="25%"  align="left" valign="top" '.$dis.' >';
                                echo '<select data-mand="'.$inputmand.'" name="'.$values['fieldname'].'" class="inputbox" id="'.$values['fieldname'].'" '.$java.' >
                                        <option value="" >--- Select ---</option>';
                                
                                if($values['fieldname'] == 'Currency' || $values['fieldname'] == 'CustomerCurrency')
                                {
                                    if(empty($arryCompany[0]['AdditionalCurrency']))
                                    $arryCompany[0]['AdditionalCurrency'] = $Config['Currency'];
                                    $arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

                                    if(!empty($arryLead[0]['Currency']) && !in_array($arryLead[0]['Currency'],$arrySelCurrency))
                                    {
                                            $arrySelCurrency[]=$arryLead[0]['Currency'];
                                    }
                                    for ($i = 0; $i < sizeof($arrySelCurrency); $i++) 
                                    { $select ='';
                                        if($arrayvalues[$values['fieldname']] == $arrySelCurrency[$i]) { $select = "selected=selected";}  
                                        echo '<option value="'.$arrySelCurrency[$i].'" '.$select.'>'.$arrySelCurrency[$i].'</option>'; 
                                    }
                                }
                                elseif($values['fieldname'] == 'country_id')
                                {
                                    for ($i = 0; $i < sizeof($arryCountry); $i++) 
                                    { $select ='';
                                        if($arrayvalues[$values['fieldname']] == $arryCountry[$i]['country_id'] || ($arrayvalues[$values['fieldname']] == '' && $arryCountry[$i]['country_id'] == $arryCurrentLocation[0]['country_id'])) { $select = "selected=selected";}  
                                        echo '<option value="'.$arryCountry[$i]['country_id'].'" '.$select.'> '.$arryCountry[$i]['name'].'</option>';
                                    }
                                }
                                elseif((in_array($values['fieldname'],$labelArray) || $values['fieldname'] == 'LeadSource' || $values['fieldname'] == 'ShippingMethod') && ((($_GET['module']!=='Activty')&&($values['fieldname']!=='priority'))||$_GET['module']==='Ticket') )
                                {
                                        if($values['fieldname'] == 'LeadSource'){$fld = 'lead_source'; }elseif($values['fieldname'] == 'ShippingMethod'){$fld = 'carrier';}else{$fld = $values['fieldname'];}
                                        $key = array_search($fld, $labelArray); 
                                        if($key == 'PaymentMethod')
                                        {
                                            $arryVal = $objConfigure->GetAttribFinance($key,'');
                                        }elseif($key == 'ShippingMethod')
                                        {
                                            $arryVal = $objConfigure->GetAttribValue($key,'');
                                        }
                                        else{    
                                            $arryVal = $objCommon->GetCrmAttribute($key, '');
                                        }      
                                        
                                        for ($i = 0; $i < sizeof($arryVal); $i++) 
                                        { 
                                          $select ='';   
                                          if($arrayvalues[$values['fieldname']] == $arryVal[$i]['attribute_value']) { $select = "selected=selected";}
                                          if($values['fieldname'] == 'campaigntype' && $i=='0'){
                                              
                                              echo '<option value="Mass Email Campaign" '.(($arrayvalues[$values['fieldname']] == MassEmailCampaign)? "selected=selected" :'').'>Mass Email Campaign</option>';
                                              
                                          }
                                          echo '<option value="'.$arryVal[$i]['attribute_value'].'" '.$select.'>'.$arryVal[$i]['attribute_value'].'</option>'; 
                                        }
                                }
                                elseif($values['fieldname'] == 'CustID')
                                {
                                    for($i=0;$i<sizeof($arryCustomer);$i++) 
                                    {
                                        $select ='';
                                        if($arryCustomer[$i]['Cid'] == $arrayvalues[$values['fieldname']]){$select = "selected=selected";}
                                        echo '<option value="'.$arryCustomer[$i]['Cid'].'" '.$select.'>'.stripslashes($arryCustomer[$i]['FullName']).'</option>';
                                     } 
                                
                                }
                                elseif($values['fieldname'] == 'AssignTo' || $values['fieldname'] == 'assignedTo')
                                {
                                     for($i=0;$i<sizeof($arryEmployee);$i++) 
                                     {
                                        $select ='';
                                        if($arryEmployee[$i]['EmpID'] == $arrayvalues[$values['fieldname']]){$select = "selected=selected";}
                                       echo '<option value="'.$arryEmployee[$i]['EmpID'].'" '.$select.'>'.stripslashes($arryEmployee[$i]['UserName']).'</option>';
                                      } 
                                    
                                }elseif($values['fieldname'] == 'PaymentTerm')
                                {
                                    $arryPaymentTerm = $objConfigure->GetTerm('','1');
                                    for($i=0;$i<sizeof($arryPaymentTerm);$i++) 
                                     {
                                        $select ='';
                                        $PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
                                        if($PaymentTerm == $arrayvalues[$values['fieldname']]){$select = "selected=selected";}
                                       echo '<option value="'.$PaymentTerm.'" '.$select.'>'.$PaymentTerm.'</option>';
                                      } 
                                }elseif($values['fieldname'] == 'CustType'){ 
                                    
                                    echo '<option value="o" '.(($arrayvalues[$values['fieldname']] == 'o')? 'selected=selected' : '' ).'> Opportunity </option>
                                          <option value="c" '.(($arrayvalues[$values['fieldname']] == 'c')? 'selected=selected' : '') .'> Customer </option>';
                                }elseif($values['fieldname'] == 'product'){
                                    
                                    for($i=0;$i<sizeof($arryProduct);$i++) {
                                        $select ='';
                                        if($arryProduct[$i]['ItemID']==$arrayvalues[$values['fieldname']]){$select = "selected=selected";}
                                        echo '<option value="'.$arryProduct[$i]['ItemID'].'" '.$select.'>'.stripslashes($arryProduct[$i]['description']).'[Sku: '.stripslashes($arryProduct[$i]['Sku']).'] 
							</option>';
                                    }
                                 }elseif($values['fieldname'] == 'RelatedType'){?>
                    	
                        <option value="Lead" <?
                            if ($arrayvalues[$values['fieldname']] == "Lead" || $_GET['parent_type']== "lead") {
                                echo "selected";
                            }
                           ?>>Lead</option>
                        <option value="Opportunity" <?
                            if ($arrayvalues[$values['fieldname']] == "Opportunity" || $_GET['parent_type']== "Opportunity") {
                                echo "selected";
                            }
                           ?>>Opportunity</option>
                        <option value="Campaign" <?
                            if ($arrayvalues[$values['fieldname']] == "Campaign" || $_GET['parent_type']== "Campaign") {
                                echo "selected";
                            }
                            ?>>Campaign</option>

			  <?php if($_GET['module']!='Ticket'){?>
			 <option value="Ticket" <?
                            if ($arrayvalues[$values['fieldname']] == "Ticket" || $_GET['parent_type']== "Ticket") {
                                echo "selected";
                            }
                            ?>>Ticket</option>
                        <?php }?>
			 <option value="Quote" <?
                            if ($arrayvalues[$values['fieldname']] == "Quote" || $_GET['parent_type']== "Quote") {
                                echo "selected";
                            }
                            ?>>Quote</option>
               
                             <?php   
				
				 }
                                elseif($values['fieldname'] == 'FolderID')
                                {
                                    for($k=0;$k<sizeof($arryFolder);$k++) {
                                       echo '<option value="'.$arryFolder[$k]['FolderID'].'" '.(($arryFolder[$i]['FolderID']==$arrayvalues['FolderID'])? "selected":'').'>'.stripslashes($arryFolder[$k]['FolderName']).'</option>';
                                    }

                                }else{
                                    
                                     
                                    if($values['dropvalue']){
                                        $Dval = preg_replace('/\s+/', '', $values['dropvalue']);
                                        $val=explode(',',$Dval);
                                        for($x=0;$x<sizeof($val);$x++) {
                                              $select ='';  
                                              if($arrayvalues[$values['fieldname']] == $val[$x]) { $select = "selected=selected";} 
                                              echo '<option value="'.$val[$x].'" '.$select.'> '.$val[$x].' </option>';
                                          } 
                                    }
                                } 
                                
                                
                           echo '</select>'; 
                           echo '<div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>';

			 if($values['fieldname'] == 'RelatedType')
                            {?>
                            
                            <td colspan="2" width="30%">
                    <div id="Lead" style="display:none; ">
                        <span>Lead : </span>
                        <select id="LeadID" class="inputbox"  name ="LeadID" >  
                            <option value="" >--Select Lead--</option>
                            <?php 
                            $arryLead = $objLead->ListLead($id = 0, $SearchKey, $SortBy, $AscDesc);
                            $LId='';
                            if($arrayvalues['RelatedTo'] || $arrayvalues['LeadID']){
                                
                                $LId = ($arrayvalues['RelatedTo']) ? $arrayvalues['RelatedTo'] : $arrayvalues['LeadID'];
                            }
                            for ($i = 0; $i < sizeof($arryLead); $i++) {$Selected ='';
if(($arryLead[$i]['leadID'] == $LId) && $arrayvalues['RelatedType'] == "Lead" && $LId!=''){ $Selected = "selected"; }

                                echo '<option value="' . $arryLead[$i]['leadID'] . '" '.$Selected.'>' . $arryLead[$i]['FirstName'] . ' ' . $arryLead[$i]['LastName'] . '</option>';
                            }
                            ?>

                        </select>
                    </div>	

                    <div id="Opportunity" style="display:none; ">
                        <span>Opportunity :  </span>
                        <select id="OpprtunityID" class="inputbox"  name ="OpprtunityID" >  
                            <option value="" >--Select Opportunity--</option>
<?php
if($arrayvalues['RelatedTo'] || $arrayvalues['OpprtunityID']){

    $OId = ($arrayvalues['RelatedTo']) ? $arrayvalues['RelatedTo'] : $arrayvalues['OpprtunityID'];
}
for ($i = 0; $i < sizeof($arryOpportunity); $i++) {$Selected ='';
if($arryOpportunity[$i]['OpportunityID'] == $OId && $arrayvalues['RelatedType'] == "Opportunity" ){ $Selected = "selected"; }
    echo '<option value="' . $arryOpportunity[$i]['OpportunityID'] . '" '.$Selected.'>' . $arryOpportunity[$i]['OpportunityName'] . '</option>';
}
?>

                        </select>
                    </div>	

                    <div id="Campaign" style="display:none; ">
                        <span>Campaign :  </span>
                        <select id="CampaignID"  class="inputbox" name ="CampaignID" >  
                            <option value="" >--Select Campaign--</option>
<?php
$CId='';
if($arrayvalues['RelatedTo'] || $arrayvalues['campaignID']){

    $CId = ($arrayvalues['RelatedTo']) ? $arrayvalues['RelatedTo'] : $arrayvalues['campaignID'];
}
for ($i = 0; $i < sizeof($arryCampaign); $i++) {$Selected ='';
if($arryCampaign[$i]['campaignID'] == $CId && $arrayvalues['RelatedType'] == "Campaign"){ $Selected = "selected"; }
    echo '<option value="' . $arryCampaign[$i]['campaignID'] . '" '.$Selected.'>' . $arryCampaign[$i]['campaignname'] . '</option>';
}
?>

                        </select>
                    </div>	

 <?php if($_GET['module']!='Ticket'){?>
<div id="Ticket" style="display:none; ">
                        <span>Ticket :  </span>
                        <select id="TicketID"  class="inputbox" name ="TicketID" >  
                            <option value="" >--Select Ticket--</option>
<?php
$TId='';
if($arrayvalues['RelatedTo'] || $arrayvalues['TicketID']){

    $TId = ($arrayvalues['RelatedTo']) ? $arrayvalues['RelatedTo'] : $arrayvalues['TicketID'];
}
for ($i = 0; $i < sizeof($arryTicket); $i++) {$Selected ='';
    if($arryTicket[$i]['TicketID'] == $TId && $arrayvalues['RelatedType'] == "Ticket" ){ $Selected = "selected"; }
    echo '<option value="' . $arryTicket[$i]['TicketID'] . '" '.$Selected.'>' . stripslashes($arryTicket[$i]['title']) . '</option>';
}
?>

                        </select>
                    </div>
<?php }?>

<div id="Quote" style="display:none; ">
                        <span>Quote :  </span>
                        <select id="QuoteID"  class="inputbox" name ="QuoteID" >  
                            <option value="" >--Select Quote--</option>
<?php
$QId='';
if($arrayvalues['RelatedTo'] || $arrayvalues['QuoteID']){

    $QId = ($arrayvalues['RelatedTo']) ? $arrayvalues['RelatedTo'] : $arrayvalues['QuoteID'];
   
}
for ($i = 0; $i < sizeof($arryQuote); $i++) {$Selected ='';
if($arryQuote[$i]['quoteid'] == $QId && $arrayvalues['RelatedType'] == "Quote"){ $Selected = "selected"; }
    echo '<option value="' . $arryQuote[$i]['quoteid'] . '" '.$Selected.'>' . stripslashes($arryQuote[$i]['subject']) . '</option>';
}
?>

                        </select>
                    </div>
                </td>
                         
                            
                          <?php  } $inendtr?>   



                
               <?php  if($values['fieldname'] == 'country_id')
                {                
                    if($_GET['module'] != "contact" && $inputmand =='y') {
                        
                        $star = '<span class="red">*</span>';
                        $datamand = 'data-mand="y"';
                    }
                    echo '<tr>
                                    <td width="25%"  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :'.$star.'</td>
                                    <td width="25%" align="left" id="state_td" class="blacknormal">&nbsp;</td>
                                
                                    <td width="25%"  align="right" class="blackbold"><div id="StateTitleDiv">Other State  :'.$star.'</div> </td>
                                    <td width="25%"  align="left" ><div id="StateValueDiv"><input '.$datamand.' name="OtherState" type="text" class="inputbox" id="OtherState" value="'.((!empty($arryLead) && isset($arryLead[0]['OtherState']) && $arryLead[0]['OtherState']!='') ? $arryLead[0]['OtherState'] : '').'"  maxlength="30" /> 
                                    <div class="red" id="OtherStateerr" style="margin-left:5px;"></div></div> </td>
                         </tr>

                         <tr>
                                    <td width="25%"  align="right" class="blackbold"><div id="MainCityTitleDiv"> City   :'.$star.'</div></td>
                                    <td width="25%"  align="left" ><div id="city_td"></div></td>
                                
                                    <td width="25%" align="right" class="blackbold"><div id="CityTitleDiv"> Other City :'.$star.'</div>  </td>
                            <td width="25%" align="left"><div id="CityValueDiv"><input '.$datamand.' name="OtherCity" type="text" class="inputbox" id="OtherCity" value="'.((!empty($arryLead) && isset($arryLead[0]['OtherCity']) && $arryLead[0]['OtherCity']!='') ? $arryLead[0]['OtherCity'] : '').'"  maxlength="30" />   
                                    <div class="red" id="OtherCityerr" style="margin-left:5px;"></div></div></td>
                        </tr>';

                }
                              
                
    } 
      
    if($values['type']=='checkbox'){


            echo ''.$intr.'
                        <td width="25%"  align="right" '.$dis.' valign="top"  class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td>
                        <td width="25%" '.$dis.'   align="left" valign="top" >';
                                 
            echo '<input '.($arrayvalues[$values['fieldname']] ? 'checked=""' : "").' data-mand="'.$inputmand.'" type="checkbox" name="'.$values['fieldname'].'" id="'.$values['fieldname'].'" value="'.stripslashes($values['defaultvalue']).'"  />';

            echo '<div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;

    }
    
    if($values['type']=='radio'){  

	$fval = preg_replace('/\s+/', ' ', $values['RadioValue']);
        $valRadio=explode(' ',$fval);
	
	    echo ''.$intr.'
		            <td width="25%"  align="right"  valign="top"  class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td>
		            <td width="25%"  align="left" valign="top" >';
            if($values['fieldname'] == 'assign')
            {
           
            echo '<input name="assign" data-mand="'.$inputmand.'" type="radio" id="assign" '.(($arrayvalues['AssignType'] == 'Users' || $arrayvalues['AssignType'] == '' ) ? 'checked=""' : "").'  value="Users"  maxlength="50" />&nbsp; Users &nbsp;&nbsp; <input name="assign" '.(($arrayvalues['AssignType']  == "Group") ? "checked" : "").' type="radio" id="assign" value="Group"  maxlength="50" />&nbsp; Group'; ?>


                        
                       
<br />
                            <div id="group" <?= $classGroup ?>>
                                <select name="AssignToGroup" class="inputbox" id="AssignToGroup" >
                                    <option value="">--- Select ---</option>	   
                                    <optgroup label="Groups">
                                    <?php if (!empty($arryGroup)) { ?>
                                        <?php for ($i = 0; $i < sizeof($arryGroup); $i++) { ?>
                                                <option value="<?= $arryGroup[$i]['group_user'] ?>:<?= $arryGroup[$i]['GroupID'] ?>" <?php
                                    if ($arryGroup[$i]['group_user'] == $arryTicket[0]['AssignedTo']) {
                                        echo "selected";
                                    }
                                    ?>>
        <?= stripslashes($arryGroup[$i]['group_name']); ?> 
                                                </option>
                                    <?php }
                                } else {
                                    ?>

                                        <div class="redmsg">No Group exist.</div>
<?php } ?>
                                    </optgroup>
                                </select>

                            </div>

                            <div id="user" <?= $classUser ?>>
                                <input type="text" class="inputbox" id="AssignToUser" name="AssignToUser" />
<?php if ($_GET['edit'] > 0 && $json_response2 != '') {?>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#AssignToUser").tokenInput("multiSelectAll.php", {
                                                theme: "facebook",
                                                preventDuplicates: true,
                                                prePopulate: <?= $json_response2 ?>,
                                                propertyToSearch: "name",
                                                resultsFormatter: function(item) {
                                                    return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>" + item.department + "</div></div></li>"
                                                },
                                                //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                                tokenFormatter: function(item) {
                                                    return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " ' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " </div><div class='email'>" + item.department + "</div></div></li>"
                                                },
                                            });
                                        });
                                    </script>
<?php } else { ?>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $("#AssignToUser").tokenInput("multiSelectAll.php", {
                                                theme: "facebook",
                                                preventDuplicates: true,
                                                propertyToSearch: "name",
                                                resultsFormatter: function(item) {
                                                    return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>" + item.department + "</div></div></li>"
                                                },
                                                //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                                tokenFormatter: function(item) {
                                                    return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>" + item.department + "</div></div></li>"
                                                },
                                            });
                                        });
                                    </script>
<?php } ?>
                            </div>
                 




<?php

            }elseif($values['fieldname'] == 'Status'){
            
                if(strstr($_SERVER['PHP_SELF'],'addCustomer') || strstr($_SERVER['PHP_SELF'],'editCustomer'))
                {
                    echo '<input name="Status" data-mand="'.$inputmand.'" type="radio" id="Status" '.(($arrayvalues['Status'] == 'Yes' || $arrayvalues['Status']=='') ? 'checked=""' : "").'  value="Yes"  maxlength="50" />&nbsp; Active &nbsp;&nbsp; <input name="Status" '.(($arrayvalues['Status']  == 'No') ? "checked" : "").' type="radio" id="Status" value="No"  maxlength="50" />&nbsp; Inactive';

                }else{
        
                    echo '<input name="Status" data-mand="'.$inputmand.'" type="radio" id="Status" '.(($arrayvalues['Status'] == '1' || $arrayvalues['Status']=='') ? 'checked=""' : "").'  value="1"  maxlength="50" />&nbsp; Active &nbsp;&nbsp; <input name="Status" '.(($arrayvalues['Status']  == '0') ? "checked" : "").' type="radio" id="Status" value="0"  maxlength="50" />&nbsp; Inactive';
                }
            }else{
            
                for($i=0;$i<sizeof($valRadio);$i++){
                    echo '<input '.(($arrayvalues[$values['fieldname']] == $valRadio[$i]) ? 'checked=""' : "").' data-mand="'.$inputmand.'" type="radio" class="inputbox" style="width:24px !important;" name="'.$values['fieldname'].'" id="'.$values['fieldname'].'" value="'.$valRadio[$i].'" />'.$valRadio[$i].'';
                }
            } 
	    echo '<div class="red"  id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;
            
      
	}

    if($values['type']=='date'){
	
     echo ''.$intr.'
       <td width="25%"  align="right" valign="top"   class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td> 	
        <td width="25%" valign="top" align="left">';?>
                <script>
                    $(function() {
                        $("#<?=$values['fieldname']?>").datepicker({
                            showOn: "both",
                            yearRange: '<?php if($values['fieldname'] == 'CloseDate' || $values['fieldname'] == 'validtill' || $values['fieldname'] == 'closingdate') echo date("Y"); else echo date("Y") - 20;  ?>:<?php  if($values['fieldname'] == 'CustomerSince') echo date("Y"); else echo date("Y")+20; ?>',
                            dateFormat: 'yy-mm-dd',
                            maxDate: "<?php if($values['fieldname'] == 'LeadDate' ||  $values['fieldname'] == 'LastContactDate')  echo '+0D';elseif($values['fieldname'] == 'CustomerSince') echo "-1D"; else echo ''; ?>",
                            minDate:"<?php if($values['fieldname'] == 'validtill' || $values['fieldname'] == 'closingdate') echo '-D'; else echo "";?>",
                            changeMonth: true,
                            changeYear: true
                    
                        });
                    });
                    <?php //if($values['fieldname'] == 'CloseDate' || $values['fieldname'] == 'validtill') echo date("Y")+20; else echo date("Y"); ?>
                </script>

    <?php  
        
         if($values['fieldname'] == 'startDate')
         {
             echo '<input id="startDate" name="startDate" readonly="" data-mand="'.$inputmand.'" class="datebox" size="12" value="'.(($arrayvalues[$values['fieldname']] > 0)? $arrayvalues[$values['fieldname']] : "").'" placeholder="Start Date"  type="text" />   
                   <input type="text" name="startTime" size="10" data-mand="'.$inputmand.'" class="disabled time" id="startTime"  value="'.((strtotime($arrayvalues['startTime']) > 0)? $arrayvalues['startTime'] : "").'" placeholder="Start Time"/>
                   <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div>';
         }elseif($values['fieldname'] == 'closeDate')
         {   
             echo '<input id="'.$values['fieldname'].'" name="'.$values['fieldname'].'" data-mand="'.$inputmand.'" readonly="" class="datebox" value="'.(($arrayvalues[$values['fieldname']] > 0)? $arrayvalues[$values['fieldname']] : "").'"  type="text" placeholder="Close Date">         
                    &nbsp;&nbsp; <input type="text" name="closeTime" size="10" data-mand="'.$inputmand.'" class="disabled time" id="closeTime"  value="'.((strtotime($arrayvalues['closeTime']) > 0)? $arrayvalues['closeTime'] : "").'" placeholder="Close Time"/> 
                    <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;
         }
         elseif($values['fieldname'] == 'CloseDate')
         {   
             $date_time= explode(" ",$arrayvalues[$values['fieldname']]);
             echo '<input id="'.$values['fieldname'].'" name="'.$values['fieldname'].'" data-mand="'.$inputmand.'" readonly="" class="datebox" value="'.(($date_time[0] > 0)? $date_time[0] : "").'"  type="text" placeholder="Close Date">         
                    &nbsp;&nbsp; <input type="text" name="CloseTime" size="10" data-mand="'.$inputmand.'" class="disabled time" id="CloseTime"  value="'.(($date_time[1] > 0)? $date_time[1] : "").'" placeholder="Close Time"/> 
                    <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div><div class="red" id="CloseTimeerr" style="margin-left:5px;"></div></td>'.$inendtr;
         }else{

            echo  '<input id="'.$values['fieldname'].'" name="'.$values['fieldname'].'" data-mand="'.$inputmand.'" readonly="" class="datebox" value="'.(($arrayvalues[$values['fieldname']] > 0)? $arrayvalues[$values['fieldname']] : "").'"  type="text" >         
           <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;
         }

   } 
   
    if($values['type']=='textarea'){ 

           echo ''.$intr.'
                    <td width="25%"  align="right" valign="top"  class="blackbold">'.$values['fieldlabel'].$mand.' </td>
                    <td width="25%"  align="left" valign="top" >

            <textarea class="inputbox" name="'.$values['fieldname'].'" data-mand="'.$inputmand.'" id="'.$values['fieldname'].'" style="width:300px;height:100px">'.trim(nl2br(stripslashes($arrayvalues[$values['fieldname']]))).'</textarea>

            <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;
            
    } 
	
	  if($values['type'] == 'Image')
    {
        echo ''.$intr.'<td width="25%" align="right" valign="top" class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td>
              <td width="25%" align="left" valign="top"  ><input type="file" class="inputbox" name="'.$values['fieldname'].'" data-mand="'.$inputmand.'" id="'.$values['fieldname'].'" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;
              <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div>';
              
              if($values['fieldname'] == 'Image' && $arryItem[0]['Image']){            
                $MainDir = $Config['UploadPrefix']."upload/items/images/".$_SESSION['CmpID']."/";	
                if($arryItem[0]['Image'] != '' && file_exists($MainDir.$arryItem[0]['Image'])) {

                $OldImage = $MainDir.$arryItem[0]['Image'];

                echo '<br><br>
		<span id="DeleteSpan">
                <input type="hidden" name="OldImage" value="'.$OldImage.'">
                <a class="fancybox" href="'.$MainDir.$arryItem[0]['Image'].'" title="'.stripslashes($arryItem[0]['description']).'" data-fancybox-group="gallery">
                <img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryItem[0]['Image'].'" border=0 id="ImageV"></a>
                <a href="Javascript:void(0);" onclick="Javascript:DeleteFile(\''.$MainDir.$arryItem[0]['Image'].'\',\'DeleteSpan\');" onmouseout="hideddrivetip();">
                '.$delete.'</a>
                </span>
                <br><br>';
                    }     
              }
              
              if($values['fieldname'] == 'FileName')
              {
                    $MainDir = "upload/Document/".$_SESSION['CmpID']."/";
                    $document = stripslashes($arryDocument[0]['FileName']);
                    if($document !='' && file_exists($MainDir.$document))
                    {			
                        echo '<div  id="DocDiv" style="padding:10px 0 10px 0;">'.$document.'&nbsp;&nbsp;&nbsp;
                                <a href="dwn.php?file='.$MainDir.$document.'" class="download">Download</a> 
                                <a href="Javascript:void(0);" onclick="Javascript:DeleteFile(\''.$MainDir.$document.'\',\'DocDiv\')">'.$delete.'</a>
                                <input type="hidden" name="OldFile" value="'.$MainDir.$document.'">
                                </div>';			
                    }	
              }
               
               
              echo '</td>'.$inendtr;	
   
              
    }
	
     if($values['type'] == 'hidden')
    {
         echo ''.$intr.'<td width="25%" align="right" valign="top" class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td>
              <td width="25%" align="left" valign="top">';
        
        if($values['fieldname']=='Rating')
        {
            echo '<script src="../js/jRate.min.js"></script>        
                <script type="text/javascript">
		$(function () {
			var that = this;
			$("#jRate").jRate({
				rating: "'.stripslashes($arryLead[0]['Rating']).'",
				strokeColor: "black",
				width: 20,
				height: 20,
				precision: 0.1,
				minSelected: 1,
				onChange: function(rating) {
					$("#Rating").val(rating);
				},
				onSet: function(rating) {
					$("#Rating").val(rating);
				}
			});
			
		});
	</script>
        <div id="jRate" style="height:30px;width: 100px;"></div>';
       } 
       if($values['fieldname']=='TaxRate')
       {
         echo '<div id="TaxRateVal">None</div>';
       }
       echo '<input maxlength="'.$values['maximumlength'].'" data-mand="'.$inputmand.'" type="hidden" class="inputbox" name="'.$values['fieldname'].'" id="'.$values['fieldname'].'" value="'.stripslashes($arrayvalues[$values['fieldname']]).'" />    
       </td>'.$inendtr;	
    }
    
if($head==1 && $j>1 && $j%2==0){
      
     echo '<tr/>';
  }
 if($values['fieldname'] == 'CustType')
                {
                   echo '<tr>
                        <td width="25%" align="right" class="blackbold"></td>
                        <td width="25%"  align="left"></td>

                        <td id="ctyp" align="right" class="blackbold">
                        <div id="OppTitleDiv">Opportunity :</div>
                        <div id="CustTitleDiv">Customer :</div></td>
                        <td  align="left" >
                        <div id="OppValDiv"><input name="opportunityName" id="opportunityName"  readonly class="disabled_inputbox"   value="'.$OpportunityName.'" type="text">
                        <input name="opportunityID" id="opportunityID" value="'.$arrayvalues['OpportunityID'].'" type="hidden">
                        <a class="fancybox fancybox.iframe" href="OpportunityList.php?pop=1" >'.$search.'</a>
                        </div>

                        <div id="CustValDiv"><input name="CustomerName" type="text" class="disabled_inputbox" id="CustomerName" value="'.$CustomerName.'"  maxlength="40" readonly />
                        <input name="CustID" id="CustID" type="hidden" value="'.$arrayvalues['CustID'].'">
                        <input name="CustCode" id="CustCode" type="hidden" value="'.$arrayvalues['CustCode'].'">
                        <input name="Taxable" id="Taxable" type="hidden" value="'.stripslashes($arrayvalues[0]['Taxable']).'">
                            <a class="fancybox fancybox.iframe" href="CustomerList.php" >'.$search.'</a>
                        </div>
                        <div class="red" id="typeerr" style="margin-left:5px;"></div>
                        </td></tr>';
                }
$j++;} ?>
