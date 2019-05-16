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
  }else if($head=='')
  {
     $intr ='<tr>';$inendtr='<tr/>';
  }

//$none ='style = "display:none;"' ;
        $dis = ($values['fieldname'] == 'location' || $values['fieldname'] == 'activityType' || $values['fieldname'] == 'Notification' || $values['fieldname'] == 'visibility' || $values['fieldname'] == 'EmpID' || $values['fieldname'] == 'RelatedType' || $values['fieldname'] == 'c_taxRate') ?  $none : '';

//if($_GET['test']=1)  echo $dis; die("sssss");
    $carr = array('budgetcost','actualcost','expectedrevenue','expectedroi','actualroi','sell_price','CreditLimit');
    $currDis = (in_array($values['fieldname'],$carr)? '('.$Config['Currency'].')' : '');
    if($values['type']=='text' && ($values['fieldname'] !='tel_ext')){
            
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

		if($values['fieldname'] == 'Landline' || $values['fieldname'] == 'tel_ext')
            {   
                $IsShLand = array_values(array_filter(array_map(function($arr){ if($arr['fieldname'] == 'Landline'){ return $arr;} },$arryField)));
                $IsShExt = array_values(array_filter(array_map(function($arr){ if($arr['fieldname'] == 'tel_ext'){ return $arr;} },$arryField)));
                if($IsShExt && $IsShExt[0]['Status'] == 1)
                {
                    $style = 'style = "width:117px;margin-left:2px"';
                    echo '<input style="width:70px" placeholder="EXT" maxlength="'.$values['maximumlength'].'" data-mand="'.(($IsShExt[0]['mandatory'] == '1') ? 'y' : 'n').'" type="text" class="inputbox" name="tel_ext" id="tel_ext" value="'.((isset($arrayvalues['tel_ext']) && $arrayvalues['tel_ext']!='') ? stripslashes($arrayvalues['tel_ext']) : '').'" />';
                }
                if($IsShLand && $IsShLand[0]['Status'] == 1)
                {
                    
                    echo '<input '.$style.' maxlength="'.$values['maximumlength'].'" data-mand="'.(($IsShLand[0]['mandatory'] == '1') ? 'y' : 'n').'" type="text" class="inputbox" name="Landline" id="Landline" value="'.(( !empty($arrayvalues) && isset($arrayvalues['Landline']) ) ? stripslashes($arrayvalues['Landline']) : '').'" />';
 
                }
                if($IsShExt && $IsShExt[0]['Status'] == 1)
                {echo '<div class="red" id="tel_exterr" style="margin-left:5px;"></div>';}
            }else{


            echo '<input maxlength="100" data-mand="'.$inputmand.'" type="text" class="inputbox" name="'.$values['fieldname'].'" id="'.$values['fieldname'].'" value="'.(( !empty($arrayvalues) && isset($arrayvalues[$values['fieldname']]) ) ? stripslashes($arrayvalues[$values['fieldname']]) : '').'" />';
             }   }
            echo '<div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;

    }
    
    if($values['type']=='select'){
            if($values['fieldname'] == 'country_id'){ $java = 'onChange="Javascript: StateListSend();"';}elseif($values['fieldname'] == 'RelatedType'){$java = 'onchange="selModule()";';}else{ $java = '';}

            echo ''.$intr.'
                <td width="25%"  align="right" valign="top" '.$dis.'  class="blackbold">'.$values['fieldlabel'].''.$currDis.':'.$mand.'</td>
                <td width="25%"  align="left" valign="top" '.$dis.' >';


                echo '<select data-mand="'.$inputmand.'" name="'.$values['fieldname'].'" class="inputbox" id="'.$values['fieldname'].'" '.$java.' >';

                if($values['fieldname'] != 'country_id'){  echo '<option value="" >--- Select ---</option>'; }
                
                if($values['fieldname'] == 'Currency' || $values['fieldname'] == 'CustomerCurrency')
                {									                                 

				$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

				if(!empty($arryLead[0]['Currency']) && !in_array($arryLead[0]['Currency'],$arrySelCurrency)){
					$arrySelCurrency[]=$arryLead[0]['Currency'];
				}

				if(!in_array($Config['Currency'],$arrySelCurrency)){
					$arrySelCurrency[] = $Config['Currency'];
				}
				sort($arrySelCurrency);

                    for ($i = 0; $i < sizeof($arrySelCurrency); $i++) 
                    { 	
						$select ='';
                        if(!empty($arrayvalues) &&  ((isset($arrayvalues[$values['fieldname']]) && ($arrayvalues[$values['fieldname']] == $arrySelCurrency[$i])) || (empty($arrayvalues[$values['fieldname']]) && $arrySelCurrency[$i] == $Config['Currency']))) { $select = "selected=selected";}  
                        echo '<option value="'.$arrySelCurrency[$i].'" '.$select.'>'.$arrySelCurrency[$i].'</option>'; 
                    }
                }
                elseif($values['fieldname'] == 'country_id')
                {
                    for ($i = 0; $i < sizeof($arryCountry); $i++) 
                    { $select ='';
                        if(!empty($arrayvalues) && (isset($arrayvalues[$values['fieldname']]) && $arrayvalues[$values['fieldname']] == $arryCountry[$i]['country_id'] || (isset($arrayvalues[$values['fieldname']]) && $arrayvalues[$values['fieldname']] == '' && $arryCountry[$i]['country_id'] == $arryCurrentLocation[0]['country_id']))) { $select = "selected=selected";}  
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
                            $arryVal = $objConfigure->GetAttribValue($key,'attribute_value');
                        }
                        else{    
                            $arryVal = $objCommon->GetCrmAttribute($key, '');
                        }      
                        
                        for ($i = 0; $i < sizeof($arryVal); $i++) 
                        { 
                          $select ='';   
                          if((!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']])) && $arrayvalues[$values['fieldname']] == $arryVal[$i]['attribute_value']) { $select = "selected=selected";}
                          if($values['fieldname'] == 'campaigntype' && $i=='0'){
                              $MEC = (defined('MassEmailCampaign')) ? MassEmailCampaign : '';
                              echo '<option value="Mass Email Campaign" '.(((!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']])) && $arrayvalues[$values['fieldname']] == $MEC)? "selected=selected" :'').'>Mass Email Campaign</option>';
                              
                          }
                          echo '<option value="'.$arryVal[$i]['attribute_value'].'" '.$select.'>'.$arryVal[$i]['attribute_value'].'</option>'; 
                        }
                }
                elseif($values['fieldname'] == 'CustID')
                {
                    for($cus=0;$cus<sizeof($arryCustomer);$cus++) 
                    {
                        $select ='';
                        if((!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']])) && $arryCustomer[$cus]['Cid'] == $arrayvalues[$values['fieldname']]){$select = "selected=selected";}
                        echo '<option value="'.$arryCustomer[$cus]['Cid'].'" '.$select.'>'.stripslashes($arryCustomer[$cus]['FullName']).'</option>';
                     } 
                
                }
                elseif($values['fieldname'] == 'AssignTo' || $values['fieldname'] == 'assignedTo')
                {
                     //for($asnTo=0;$asnTo<sizeof($arryEmployee);$asnTo++) 
foreach ($arryEmployee as $key => $Empvalues) 
                     {
                        $select ='';
		if((!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']])) && $Empvalues['EmpID'] == $arrayvalues[$values['fieldname']]){$select = "selected=selected";}
                       echo '<option value="'.$Empvalues['EmpID'].'" '.$select.'>'.stripslashes($Empvalues['UserName']).'</option>';
                      } 
                                    
				 }elseif($values['fieldname'] == 'DefaultAccount'){
                                
				   	$Config['NormalAccount']=1;
					if(isset($objBankAccount)){
					$arryBankAccount=$objBankAccount->getBankAccountWithAccountType();
					 
					for($i=0;$i<sizeof($arryBankAccount);$i++) {
						$sel = (!empty($arrayvalues) && $arryBankAccount[$i]['BankAccountID']==$arrayvalues['DefaultAccount'])?("Selected"):("");

						echo '<option value="'.$arryBankAccount[$i]['BankAccountID'].'" '.$sel.'>
					'.ucwords($arryBankAccount[$i]['AccountName']).' ['.$arryBankAccount[$i]['AccountNumber'].']</option>';
					 } }

                                }elseif($values['fieldname'] == 'PaymentTerm')
                                {
                                    $arryPaymentTerm = $objConfigure->GetTerm('','1');
                                    //for($i=0;$i<sizeof($arryPaymentTerm);$i++) 
 foreach ($arryPaymentTerm as $key => $paytmvalues) {
                                     {
                                        $select ='';
                                       if($paytmvalues['termType']==1){
							$PaymentTerm = stripslashes($paytmvalues['termName']);
						}else{
							$PaymentTerm = stripslashes($paytmvalues['termName']).' - '.$paytmvalues['Day'];
						}
                                        if(!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']]) && $PaymentTerm == $arrayvalues[$values['fieldname']]){$select = "selected=selected";}
                                       echo '<option value="'.$PaymentTerm.'" '.$select.'>'.$PaymentTerm.'</option>';
                                      } 
}
                                }elseif($values['fieldname'] == 'CustType'){ 
                                    
                                    echo '<option value="o" '.((isset($arrayvalues[$values['fieldname']]) && $arrayvalues[$values['fieldname']] == 'o')? 'selected=selected' : '' ).'> Opportunity </option>
                                          <option value="c" '.((isset($arrayvalues[$values['fieldname']]) && $arrayvalues[$values['fieldname']] == 'c')? 'selected=selected' : '') .'> Customer </option>';
                                }elseif($values['fieldname'] == 'product'){
                                    
                                    //for($i=0;$i<sizeof($arryProduct);$i++) {
if(isset($arryProduct)){
foreach ($arryProduct as $key => $ProductValues) {
                                        $select ='';
                                        if((!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']])) && $ProductValues['ItemID']==$arrayvalues[$values['fieldname']]){$select = "selected=selected";}
                                        echo '<option value="'.$ProductValues['ItemID'].'" '.$select.'>'.stripslashes($ProductValues['description']).'[Sku: '.stripslashes($ProductValues['Sku']).'] 
							</option>';
                                    }}
                                 }elseif($values['fieldname'] == 'RelatedType'){?>
                    	
                        <option value="Lead" <?
                            if((isset($arrayvalues[$values['fieldname']]) && $arrayvalues[$values['fieldname']] == "Lead") || (!empty($_GET['parent_type']) && $_GET['parent_type']== "lead")) {
                                echo "selected";
                            }
                           ?>>Lead</option>
                        <option value="Opportunity" <?
                            if ((isset($arrayvalues[$values['fieldname']]) && $arrayvalues[$values['fieldname']] == "Opportunity") || (!empty($_GET['parent_type']) && $_GET['parent_type']== "Opportunity")) {
                                echo "selected";
                            }
                           ?>>Opportunity</option>
                        <option value="Campaign" <?
                            if ((isset($arrayvalues[$values['fieldname']]) &&  $arrayvalues[$values['fieldname']] == "Campaign") || (!empty($_GET['parent_type']) && $_GET['parent_type']== "Campaign")) {
                                echo "selected";
                            }
                            ?>>Campaign</option>

			  <?php if($_GET['module']!='Ticket'){?>
			 <option value="Ticket" <?
                            if ((isset($arrayvalues[$values['fieldname']]) &&  $arrayvalues[$values['fieldname']] == "Ticket") || (!empty($_GET['parent_type']) && $_GET['parent_type']== "Ticket")) {
                                echo "selected";
                            }
                            ?>>Ticket</option>
                        <?php }?>
			 <option value="Quote" <?
                            if ((isset($arrayvalues[$values['fieldname']]) &&  $arrayvalues[$values['fieldname']] == "Quote") || (!empty($_GET['parent_type']) && $_GET['parent_type']== "Quote")) {
                                echo "selected";
                            }
                            ?>>Quote</option>
               
                             <?php   
				
				 }
                                elseif($values['fieldname'] == 'FolderID' && isset($arryFolder))
                                {	
                                    for($k=0;$k<sizeof($arryFolder);$k++) {
                                       echo '<option value="'.$arryFolder[$k]['FolderID'].'" '.(((!empty($arrayvalues) && isset($arrayvalues['FolderID'])) && $arryFolder[$k]['FolderID']==$arrayvalues['FolderID'])? "selected":'').'>'.stripslashes($arryFolder[$k]['FolderName']).'</option>';
                                    }

                                }else if($values['fieldname'] == 'c_taxRate'){

if(isset($arryPurchaseTax)){
for($i=0;$i<sizeof($arryPurchaseTax);$i++) {

								$Selected = (!empty($arrRate) && $arrRate[0] == $arryPurchaseTax[$i]['RateId'] && $arrRate[2] == $arryPurchaseTax[$i]['TaxRate'])?(" Selected"):("");		

								$taxRateVal = "".$arryPurchaseTax[$i]['RateId'].":".$arryPurchaseTax[$i]['RateDescription'].":".$arryPurchaseTax[$i]['TaxRate']."";
								$taxRateName = "".$arryPurchaseTax[$i]['RateDescription'].":".$arryPurchaseTax[$i]['TaxRate']."";
							             
								echo '<option value="'.$taxRateVal.'" '.$Selected.'> '.$taxRateName.' </option>';
               } 
     

}

}else{
                                    
                                     
                                    if($values['dropvalue']){
                                        //$Dval = preg_replace('/\s+/', '', $values['dropvalue']);
                                          $Dval =  $values['dropvalue'];
                                        $val=explode(',',$Dval);
                                        for($x=0;$x<sizeof($val);$x++) {
                                              $select ='';  
                                              if((!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']])) && $arrayvalues[$values['fieldname']] == $val[$x]) { $select = "selected=selected";} 
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
                            $arryLead = $objLead->GetLeadBrief('','');
                            $LId='';
                            if((isset($arrayvalues['RelatedTo']) && $arrayvalues['RelatedTo']) || (isset($arrayvalues['LeadID']) && $arrayvalues['LeadID'])){
                                
                                $LId = (isset($arrayvalues['RelatedTo'])) ? $arrayvalues['RelatedTo'] : $arrayvalues['LeadID'];
                            }
                            //for ($i = 0; $i < sizeof($arryLead); $i++) {
foreach ($arryLead as $key => $Ledvalues) {
$Selected ='';
if(($Ledvalues['leadID'] == $LId) && $arrayvalues['RelatedType'] == "Lead" && $LId!=''){ $Selected = "selected"; }

                                echo '<option value="' . $Ledvalues['leadID'] . '" '.$Selected.'>' . $Ledvalues['FirstName'] . ' ' . $Ledvalues['LastName'] . '</option>';
                            }
                            ?>

                        </select>
                    </div>	

                    <div id="Opportunity" style="display:none; ">
                        <span>Opportunity :  </span>
                        <select id="OpprtunityID" class="inputbox"  name ="OpprtunityID" >  
                            <option value="" >--Select Opportunity--</option>
<?php
$OId = '';
if((isset($arrayvalues['RelatedTo']) &&  $arrayvalues['RelatedTo']) || (isset($arrayvalues['LeadID']) && $arrayvalues['OpprtunityID'])){

    $OId = ($arrayvalues['RelatedTo']) ? $arrayvalues['RelatedTo'] : $arrayvalues['OpprtunityID'];
}
//for ($i = 0; $i < sizeof($arryOpportunity); $i++) {
if(isset($arryOpportunity)){
foreach ($arryOpportunity as $key => $Oppvalues) {

$Selected ='';
if(!empty($arrayvalues) && ($Oppvalues['OpportunityID'] == $OId && $arrayvalues['RelatedType'] == "Opportunity" )){ $Selected = "selected"; }
    echo '<option value="' . $Oppvalues['OpportunityID'] . '" '.$Selected.'>' . $Oppvalues['OpportunityName'] . '</option>';
}}
?>

                        </select>
                    </div>	

                    <div id="Campaign" style="display:none; ">
                        <span>Campaign :  </span>
                        <select id="CampaignID"  class="inputbox" name ="CampaignID" >  
                            <option value="" >--Select Campaign--</option>
<?php
$CId='';
if((isset($arrayvalues['RelatedTo']) &&  $arrayvalues['RelatedTo']) || (isset($arrayvalues['campaignID']) && $arrayvalues['campaignID'])){

    $CId = ($arrayvalues['RelatedTo']) ? $arrayvalues['RelatedTo'] : $arrayvalues['campaignID'];
}
if(isset($arryCampaign)){
for ($i = 0; $i < sizeof($arryCampaign); $i++) {$Selected ='';
if(!empty($arrayvalues) && ($arryCampaign[$i]['campaignID'] == $CId && $arrayvalues['RelatedType'] == "Campaign")){ $Selected = "selected"; }
    echo '<option value="' . $arryCampaign[$i]['campaignID'] . '" '.$Selected.'>' . $arryCampaign[$i]['campaignname'] . '</option>';
}}
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
if(isset($arrayvalues['RelatedTo']) || isset($arrayvalues['TicketID'])){

    $TId = (isset($arrayvalues['RelatedTo'])) ? $arrayvalues['RelatedTo'] : $arrayvalues['TicketID'];
}
//for ($i = 0; $i < sizeof($arryTicket); $i++) {
if(isset($arryTicket)){
foreach ($arryTicket as $key => $Tickvalues) {

$Selected ='';
    if($Tickvalues['TicketID'] == $TId && $arrayvalues['RelatedType'] == "Ticket" ){ $Selected = "selected"; }
    echo '<option value="' . $Tickvalues['TicketID'] . '" '.$Selected.'>' . stripslashes($Tickvalues['title']) . '</option>';
}}
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
if((isset($arrayvalues['RelatedTo']) && $arrayvalues['RelatedTo']) || (isset($arrayvalues['QuoteID']) && $arrayvalues['QuoteID'])){

    $QId = ($arrayvalues['RelatedTo']) ? $arrayvalues['RelatedTo'] : $arrayvalues['QuoteID'];
   
}
if(isset($arryQuote)){
for ($i = 0; $i < sizeof($arryQuote); $i++) {$Selected ='';
if(!empty($arrayvalues) && ($arryQuote[$i]['quoteid'] == $QId && $arrayvalues['RelatedType'] == "Quote")){ $Selected = "selected"; }
    echo '<option value="' . $arryQuote[$i]['quoteid'] . '" '.$Selected.'>' . stripslashes($arryQuote[$i]['subject']) . '</option>';
}}
?>

                        </select>
                    </div>
                </td>
                         
                            
                          <?php  } $inendtr?>   



                
               <?php  if($values['fieldname'] == 'country_id')
                {      $star = $datamand = '';    	      
                    if($_GET['module'] != "contact" && $inputmand =='y') {
                        
                        //$star = '<span class="red">*</span>';
												$star = '';
                        $datamand = 'data-mand="n"';
                    }
                    echo '<tr>
                                    <td width="25%"  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :'.$star.'</td>
                                    <td width="25%" align="left" id="state_td" class="blacknormal">&nbsp;</td>';
                                
                    echo $inendtr.$intr.'<td width="25%"  align="right" class="blackbold"><div id="StateTitleDiv">Other State  :'.$star.'</div> </td>
                                    <td width="25%"  align="left" ><div id="StateValueDiv"><input '.$datamand.' name="OtherState" type="text" class="inputbox" id="OtherState" value="'.((!empty($arryLead) && isset($arryLead[0]['OtherState']) && $arryLead[0]['OtherState']!='') ? $arryLead[0]['OtherState'] : '').'"  maxlength="100" /> 
                                    <div class="red" id="OtherStateerr" style="margin-left:5px;"></div></div> </td>
                         </tr>

                         <tr>
                                    <td width="25%"  align="right" class="blackbold"><div id="MainCityTitleDiv"> City   :'.$star.'</div></td>
                                    <td width="25%"  align="left" ><div id="city_td"></div></td>';
                                
                   echo $inendtr.$intr.'<td width="25%" align="right" class="blackbold"><div id="CityTitleDiv"> Other City :'.$star.'</div>  </td>
                            <td width="25%" align="left"><div id="CityValueDiv"><input '.$datamand.' name="OtherCity" type="text" class="inputbox" id="OtherCity" value="'.((!empty($arryLead) && isset($arryLead[0]['OtherCity'])  && $arryLead[0]['OtherCity']!='') ? $arryLead[0]['OtherCity'] : '').'"  maxlength="100" />   
                                    <div class="red" id="OtherCityerr" style="margin-left:5px;"></div></div></td>
                        </tr>';

                }
                              
                
    } 
      
    if($values['type']=='checkbox'){


            echo ''.$intr.'
                        <td width="25%"  align="right" '.$dis.' valign="top"  class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td>
                        <td width="25%" '.$dis.'   align="left" valign="top" >';
                                 
            echo '<input '.((isset($arrayvalues[$values['fieldname']]) && $arrayvalues[$values['fieldname']]) ? 'checked=""' : "").' data-mand="'.$inputmand.'" type="checkbox" name="'.$values['fieldname'].'" id="'.$values['fieldname'].'" value="'.stripslashes($values['defaultvalue']).'"  />';

            echo '<div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;

    }
    
if($values['type']=='multicheckbox'){
        //$fval = preg_replace('/\s+/',',', $values['dropvalue']);

        $valMulticheck=explode(',',$values['dropvalue']);
	if(!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']]))
	{
        	$arrayvalues[$values['fieldname']] = explode(',',$arrayvalues[$values['fieldname']]);
	}else{
		$arrayvalues[$values['fieldname']] = array();
	}
            echo ''.$intr.'
            <td width="25%"  align="right" '.$dis.' valign="top"  class="blackbold">'.stripslashes($values['fieldlabel']).':'.$mand.' </td>
            <td width="25%" '.$dis.'   align="left" valign="top" >';
             for($i=0;$i<sizeof($valMulticheck);$i++){ 
        echo '<input '.(in_array($valMulticheck[$i],$arrayvalues[$values['fieldname']]) ? 'checked=""' : "").' data-mand="'.$inputmand.'" type="checkbox" class="inputbox" style="width:24px !important;" name="'.$values['fieldname'].'[]" id="'.$values['fieldname'].'" value="'.$valMulticheck[$i].'" />'.stripslashes($valMulticheck[$i]).'';
    }
          
    echo '<div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;

    }




    if($values['type']=='radio'){  

	$fval = preg_replace('/\s+/', ' ', $values['RadioValue']);
        $valRadio=explode(' ',$fval);
	
	    echo ''.$intr.'
		            <td width="25%"  align="right"  valign="top"  class="blackbold">'.stripslashes($values['fieldlabel']).':'.$mand.' </td>
		            <td width="25%"  align="left" valign="top" >';
            if($values['fieldname'] == 'assign')
            {
           	if(empty($arrayvalues)){$arrayvalues['AssignType'] = '';}
            echo '<input name="assign" data-mand="'.$inputmand.'" type="radio" id="assign" '.(($arrayvalues['AssignType'] == 'Users' || $arrayvalues['AssignType'] == '') ? 'checked=""' : "").'  value="Users"  maxlength="50" />&nbsp; Users &nbsp;&nbsp; <input name="assign" '.(($arrayvalues['AssignType']  == "Group") ? "checked" : "").' type="radio" id="assign" value="Group"  maxlength="50" />&nbsp; Group'; ?>


                        
                       
<br />
                            <div id="group" <?= $classGroup ?>>
                                <select name="AssignToGroup" class="inputbox" id="AssignToGroup" >
                                    <option value="">--- Select ---</option>	   
                                    <optgroup label="Groups">
                                    <?php if (!empty($arryGroup)) { ?>
                                        <?php for ($i = 0; $i < sizeof($arryGroup); $i++) { ?>
                                                <option value="<?= $arryGroup[$i]['group_user'] ?>:<?= $arryGroup[$i]['GroupID'] ?>" <?php
if($_GET['module'] == 'Ticket'){
$asval = isset($arrayvalues['AssignedTo']) ? $arrayvalues['AssignedTo'] : ''; 
}elseif($_GET['module'] == 'Quote'){
$asval = isset($arrayvalues['assignTo']) ? $arrayvalues['assignTo'] : ''; 
}elseif($_GET['module'] == 'Activity'){
$asval = isset($arrayvalues['assignedTo']) ? $arrayvalues['assignedTo'] : ''; 
}else{
$asval= isset($arrayvalues['AssignTo']) ? $arrayvalues['AssignTo'] : ''; 
}		
                                    if ($arryGroup[$i]['group_user'] == $asval) {
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
                    echo '<input name="Status" data-mand="'.$inputmand.'" type="radio" id="Status" '.((empty($arrayvalues) || ($arrayvalues['Status'] == 'Yes' && $arrayvalues['Status']!='')) ? 'checked=""' : "").'  value="Yes"  maxlength="50" />&nbsp; Active &nbsp;&nbsp; <input name="Status" '.((!empty($arrayvalues) && $arrayvalues['Status']  == 'No') ? "checked" : "").' type="radio" id="Status" value="No"  maxlength="50" />&nbsp; Inactive';

                }else{
        
                    echo '<input name="Status" data-mand="'.$inputmand.'" type="radio" id="Status" '.((empty($arrayvalues) || (!isset($arrayvalues['Status']) || $arrayvalues['Status'] == '1' )) ? 'checked=""' : "").'  value="1"  maxlength="50" />&nbsp; Active &nbsp;&nbsp; <input name="Status" '.(((!empty($arrayvalues) && isset($arrayvalues['Status'])) && $arrayvalues['Status']  == '0') ? "checked" : "").' type="radio" id="Status" value="0"  maxlength="50" />&nbsp; Inactive';
                }
            }else{
            
                for($i=0;$i<sizeof($valRadio);$i++){
                    echo '<input '.(( (!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']])) && $arrayvalues[$values['fieldname']] == $valRadio[$i]) ? 'checked=""' : "").' data-mand="'.$inputmand.'" type="radio" class="inputbox" style="width:24px !important;" name="'.$values['fieldname'].'" id="'.$values['fieldname'].'" value="'.$valRadio[$i].'" />'.$valRadio[$i].'';
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
             echo '<input id="startDate" name="startDate" readonly="" data-mand="'.$inputmand.'" class="datebox" size="12" value="'.((isset($arrayvalues[$values['fieldname']]) && $arrayvalues[$values['fieldname']] > 0)? $arrayvalues[$values['fieldname']] : "").'" placeholder="Start Date"  type="text" />   
                   <input type="text" name="startTime" size="10" data-mand="'.$inputmand.'" class="disabled time" id="startTime"  value="'.((isset($arrayvalues['startTime']) && strtotime($arrayvalues['startTime']) > 0)? $arrayvalues['startTime'] : "").'" placeholder="Start Time"/>
                   <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div>';
         }elseif($values['fieldname'] == 'closeDate')
         {   
             echo '<input id="'.$values['fieldname'].'" name="'.$values['fieldname'].'" data-mand="'.$inputmand.'" readonly="" class="datebox" value="'.((isset($arrayvalues[$values['fieldname']]) && $arrayvalues[$values['fieldname']] > 0)? $arrayvalues[$values['fieldname']] : "").'"  type="text" placeholder="Close Date">         
                    &nbsp;&nbsp; <input type="text" name="closeTime" size="10" data-mand="'.$inputmand.'" class="disabled time" id="closeTime"  value="'.((isset($arrayvalues['closeTime']) && strtotime($arrayvalues['closeTime']) > 0)? $arrayvalues['closeTime'] : "").'" placeholder="Close Time"/> 
                    <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;
         }
         elseif($values['fieldname'] == 'CloseDate')
         {   
             $date_time = (!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']])) ? explode(" ",$arrayvalues[$values['fieldname']]) : '';
             echo '<input id="'.$values['fieldname'].'" name="'.$values['fieldname'].'" data-mand="'.$inputmand.'" readonly="" class="datebox" value="'.((is_array($date_time) && $date_time[0] > 0)? $date_time[0] : "").'"  type="text" placeholder="Close Date">         
                    &nbsp;&nbsp; <input type="text" name="CloseTime" size="10" data-mand="'.$inputmand.'" class="disabled time" id="CloseTime"  value="'.((is_array($date_time) && $date_time[1] > 0)? $date_time[1] : "").'" placeholder="Close Time"/> 
                    <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div><div class="red" id="CloseTimeerr" style="margin-left:5px;"></div></td>'.$inendtr;
         }else{

            echo  '<input id="'.$values['fieldname'].'" name="'.$values['fieldname'].'" data-mand="'.$inputmand.'" readonly="" class="datebox" value="'.((!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']]) && $arrayvalues[$values['fieldname']] > 0)? $arrayvalues[$values['fieldname']] : "").'"  type="text" >         
           <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;
         }

   } 
   
    if($values['type']=='textarea'){ 


//echo '<textarea class="inputbox" name="'.$values['fieldname'].'" data-mand="'.$inputmand.'" id="'.$values['fieldname'].'" style="width:300px;height:100px">'.((!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']])) ? trim(stripslashes(preg_replace('/\s+/', ' ', $arrayvalues[$values['fieldname']]))) : '').'</textarea>';

           echo ''.$intr.'
                    <td width="25%"  align="right" valign="top"  class="blackbold">'.$values['fieldlabel'].$mand.' </td>
                    <td width="25%"  align="left" valign="top" >

            <textarea class="inputbox" name="'.$values['fieldname'].'" data-mand="'.$inputmand.'" id="'.$values['fieldname'].'" style="width:300px;height:100px">'.((!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']])) ? stripslashes($arrayvalues[$values['fieldname']]) : '').'</textarea>

            <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div></td>'.$inendtr;
            
    } 
	
	  if($values['type'] == 'Image')
    {
        echo ''.$intr.'<td width="25%" align="right" valign="top" class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td>
              <td width="25%" align="left" valign="top"  ><input type="file" class="inputbox" name="'.$values['fieldname'].'" data-mand="'.$inputmand.'" id="'.$values['fieldname'].'" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;
              <div class="red" id="'.$values['fieldname'].'err" style="margin-left:5px;"></div>';
              
              if(!empty($arryItem) && $values['fieldname'] == 'Image' && $arryItem[0]['Image']){            
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

									/******************Google drive code ***********************/
										echo '<script src="https://www.google.com/jsapi?key=AIzaSyB1kqIZfHmSkSdmi8zfBuYlmFZk4S2LrTc"></script>
										<script src="https://apis.google.com/js/client.js?onload=initPicker"></script>';
									/**************************************/

                    #$MainDir = "upload/Document/".$_SESSION['CmpID']."/";
		   

                    $document = (!empty($arryDocument) ? stripslashes($arryDocument[0]['FileName']) : '');
                    if($document !='' && IsFileExist($Config['C_DocumentDir'],$document))
                    {			
                        echo '<div  id="DocDiv" style="padding:10px 0 10px 0;">'.$document.'&nbsp;&nbsp;&nbsp;
                                <a href="../download.php?file='.$document.'&folder='.$Config['C_DocumentDir'].'" class="download">Download</a> 
                                <a href="Javascript:void(0);" onclick="Javascript:RemoveFileRefresh(\''.$Config['C_DocumentDir'].'\', \''.$document.'\', \'DocDiv\')">'.$delete.'</a>
                                <input type="hidden" name="OldFile" value="'.$document.'">
                                </div>';			
                    }	
//drop box link added by sanjeev 4feb 2016
								echo '<a id="pick" type="button" href="javascript:;" style="float:left;margin:5px 0;" class="add">Google Drive</a>
					  <a style="float:left;margin:5px 0 5px 5px;" class="add" href="javascript:;" drop-box-picker dbpicker-files="dpfiles"> Dropbox </a>';

              }
               
               
              echo '</td>'.$inendtr;	
   
              
    }
	
     if($values['type'] == 'hidden')
    {
         echo ''.$intr.'<td width="25%" align="right" valign="top" class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td>
              <td width="25%" align="left" valign="top">';
        
        if($values['fieldname']=='Rating')
        {  $rting = '';	
	   if(!empty($arryLead) && $arryLead[0]['Rating']){ $rting = stripslashes($arryLead[0]['Rating']); }
            echo '<script src="../js/jRate.min.js"></script>        
                <script type="text/javascript">
		$(function () {
			var that = this;
			$("#jRate").jRate({
				rating: "'.$rting.'",
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

	$fieldname = $values['fieldname'];
       if($values['fieldname']=='Taxable')
       {
         echo '<div id="TaxRateVal">None</div>';
	 $fieldname = 'MainTaxRate';
       }
	//by chetan 20JAn2017//
       if($values['fieldname']=='TaxRate')
       {
         echo '<div id="TaxRateVal">None</div>';
       }
	//End//
       echo '<input maxlength="'.$values['maximumlength'].'" data-mand="'.$inputmand.'" type="hidden" class="inputbox" name="'.$fieldname.'" id="'.$fieldname.'" value="'.((!empty($arrayvalues) && isset($arrayvalues[$values['fieldname']])) ? stripslashes($arrayvalues[$values['fieldname']]) : '' ).'" />    
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
                        <div id="OppValDiv"><input name="opportunityName" id="opportunityName"  readonly class="disabled_inputbox"   value="'.((isset($OpportunityName)) ? $OpportunityName : '').'" type="text">
                        <input name="opportunityID" id="opportunityID" value="'.((!empty($arrayvalues) && isset($arrayvalues['OpportunityID'])) ? $arrayvalues['OpportunityID'] : '').'" type="hidden">
                        <a class="fancybox fancybox.iframe" href="OpportunityList.php?pop=1" >'.$search.'</a>
                        </div>

                        <div id="CustValDiv"><input name="CustomerName" type="text" class="disabled_inputbox" id="CustomerName" value="'.((isset($CustomerName)) ? $CustomerName : '').'"  maxlength="80" readonly />
                        <input name="CustID" id="CustID" type="hidden" value="'.((!empty($arrayvalues) && isset($arrayvalues['CustID'])) ? $arrayvalues['CustID'] : '').'">
                        <input name="CustCode" id="CustCode" type="hidden" value="'.((!empty($arrayvalues) && isset($arrayvalues['CustCode'])) ? $arrayvalues['CustCode'] : '').'">
                        <input name="Taxable" id="Taxable" type="hidden" value="'.((!empty($arrayvalues) && isset($arrayvalues[0]['Taxable'])) ? stripslashes($arrayvalues[0]['Taxable']) : '').'">
                            <a class="fancybox fancybox.iframe" href="CustomerList.php" >'.$search.'</a>
                        </div>
                        <div class="red" id="typeerr" style="margin-left:5px;"></div>
                        </td></tr>';
                }
$j++;} ?>
