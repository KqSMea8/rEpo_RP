<?php

(empty($intr))?($intr=""):("");
(empty($inendtr))?($inendtr=""):("");


if(!empty($viewId))
{
    $VId = $viewId;
}else{
    $VId = $_GET['view'];
}

$j=1;

if(is_array($arryField)){

    foreach($arryField as $key=>$values){
       
    if($head==1 && $j==1){
        echo '<tr>';
    }/*elseif($head=='')
    {
        $intr ='<tr>';$inendtr='<tr/>';
    }*/
    $farray = array('budgetcost','actualcost','expectedrevenue','expectedroi','actualroi','sell_price','CreditLimit');   
    if($values['fieldname'] == 'AnnualRevenue' || $values['fieldname'] == 'Amount' || $values['fieldname'] == 'forecast_amount'){if($arrayVal['Currency']) $Exttitle = '('.$arrayVal['Currency'].')';}
      elseif(in_array($values['fieldname'],$farray)){
        $Exttitle = '('.$Config['Currency'].')'; 
    }elseif($values['fieldname'] == 'TaxRate'){
        $Exttitle = $TaxName;
    }else{$Exttitle ='';}
    if($values['fieldname'] == 'CustType'){
        if($arrayVal['CustType']=='o'){$flabel = 'Opportunity'; $cusVal = $OpportunityName;}
        if($arrayVal['CustType']=='c'){$flabel = 'Customer'; $cusVal = $CustomerName;}
        }else{$flabel = $values['fieldlabel'];}
    
    
        
            echo ''.$intr.'
                     <td  align="right" class="blackbold" valign="top">'.$flabel.' '.$Exttitle.': </td>
                    <td  align="left" colspan="2" valign="top" style="width:100px">';
                    
                    if($values['fieldname'] == 'assign')
                    {
                        if (!empty($arryTicket) && $arryTicket[0]['AssignType'] == 'Group') { 
                         echo ($AssignName)? $AssignName : '<span class="red">Not specified.</span>';
                        }
						if(!empty($arryAssignee)){
                        foreach ($arryAssignee as $val) {

                            echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$val['EmpID'].'" >'.$val['UserName'].'</a> &nbsp; &nbsp; &nbsp;';
                        } }
            
                    }elseif($values['fieldname'] == 'LandlineNumber' || $values['fieldname'] == 'Landline')
                    {
                        $res = $arrayVal[$values['fieldname']];
                        echo ($res)? $res.'<a href="javascript:void(0);" onclick=\"call_connect("call_form","to","'.$arrayVal[$values['fieldname']].'","'.$VId.'","'.$country_code.'","'.$country_prefix.'","'.$callfor.'");\" class="call_icon">
                        <span class="phone_img"></span></a>'
                        : '<span class="red">Not specified.</span>';        
                    }elseif($values['fieldname'] == 'Mobile')
                    {
                        $res = $arrayVal[$values['fieldname']];
                        echo ($res)? $res.'<a href="javascript:void(0);" onclick=\"call_connect("call_form","to","'.$arrayVal[$values['fieldname']].'","'.$VId.'","'.$country_code.'","'.$country_prefix.'","'.$callfor.'")\" class="call_icon">
                        <span class="phone_img"></span></a>'
                        : '<span class="red">Not specified.</span>'; 
                    }elseif($values['fieldname'] == 'CustID')
                    {
                       echo  (!empty($arryCustomer[0]['FullName']))? '<a class="fancybox fancybox.iframe" href="../custInfo.php?view='.$arryCustomer[0]['CustCode'].'">'.(stripslashes($arryCustomer[0]['FullName'])) .' </a>': '<span class="red">Not specified.</span>';
                    }elseif($values['fieldname'] == 'country_id')
                    {   
                        echo (isset($CountryName))? $CountryName : '<span class="red">Not specified.</span>';
                    }elseif($values['type']=='date') { 

                        if($values['fieldname'] == 'startDate' || $values['fieldname'] == 'closeDate' || $values['fieldname'] == 'CloseDate')
                        {    
                            if($values['fieldname'] == 'startDate'){ $sD = 'startDate'; $sT = 'startTime';
								$dateTime = $arrayVal[$sD]." ".$arrayVal[$sT]; 
                            }elseif($values['fieldname'] == 'closeDate'){ $sD = 'closeDate'; $sT = 'closeTime';        			$dateTime = $arrayVal[$sD]." ".$arrayVal[$sT];
                            }else{ $sD = 'CloseDate'; $dateTime = $arrayVal[$sD];}
                           
                               
                            $res =  (($arrayVal[$values['fieldname']] > 0)? date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($dateTime)) : '' );
                        }else{
                            $res =  (($arrayVal[$values['fieldname']] > 0)? date($Config['DateFormat'], strtotime($arrayVal[$values['fieldname']])) : '' );    
                        } 
                        echo ($res)? $res : '<span class="red">Not specified.</span>';  
                    }
                    elseif($values['fieldname'] == 'AssignTo' || $values['fieldname'] == 'assignedTo')
                    {
                        if((!empty($arryContact[0]['AssignTo']) || !empty($arrayVal['assignedTo'])) && !empty($arryEmployee[0]['EmpID'])){

                        echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arryEmployee[0]['EmpID'].'">'.stripslashes($arryEmployee[0]['UserName']).'</a>';
                        } else { echo '<span class="red">Not specified.</span>';  }

                    }
                    elseif($values['fieldname'] == 'Status')
                    {
                        if($arrayVal['Status'] == 1 || $arrayVal['Status']==''  || $arrayVal['Status'] == 'Yes'){ echo "Active";}else{echo "InActive";}
                    }elseif($values['fieldname'] == 'Notification' || $values['fieldname'] == 'reminder' || $values['fieldname'] == 'sendnotification' || $values['fieldname'] == 'Taxable')
                    {
                        if($values['fieldname'] == 'Notification' && $arrayVal['Notification'] == 1 ){ echo "Yes";}
                        elseif($values['fieldname'] == 'reminder' && $arrayVal['reminder'] == 1 ){ echo "Yes";}
                        elseif($values['fieldname'] == 'sendnotification' && $arrayVal['sendnotification'] == 1 ){ echo "Yes";}
                        elseif($values['fieldname'] == 'Taxable' && $arrayVal['Taxable'] == 'Yes' ){echo "Yes";}else{echo "No";}
                        
                    }
  		
                    elseif($values['fieldname'] == 'DefaultAccount'){
                       $DefaultAccountId=($arrayVal[$values['fieldname']]);
			if($DefaultAccountId>0){
                       		$arryDefaultAccount = $objBankAccount->getBankAccountById($DefaultAccountId);
			}
                      if(!empty($arryDefaultAccount[0]['AccountName']) || !empty($arryDefaultAccount[0]['AccountNumber']) ){
                      	 $DefaultAccount = stripslashes($arryDefaultAccount[0]['AccountName']).' [ '.stripslashes($arryDefaultAccount[0]['AccountNumber']).']';
                         echo $DefaultAccount;                     
                      }else{
                      	echo '<span class="red">Not specified.</span>';
                      }

			


                    }
                   
                    elseif($values['fieldname'] == 'product')
                    {
                        echo (!empty($arryProduct[0]['description']))?(stripslashes($arryProduct[0]['description']).' [Sku: '.stripslashes($arryProduct[0]['Sku']).']'):(NOT_SPECIFIED);

                    }
		    elseif($values['fieldname'] == 'Image')
                    {
                        $MainDir = $Config['UploadPrefix']."upload/items/images/".$_SESSION['CmpID']."/";
                        if($arryItem[0]['Image'] != '' && file_exists($MainDir.$arryItem[0]['Image'])) {

                       echo '<span id="DeleteSpan">
                        <a class="fancybox" href="'.$MainDir.$arryItem[0]['Image'].'" title="'.stripslashes($arryItem[0]['description']).'" data-fancybox-group="gallery">
                        <img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryItem[0]['Image'].'" border=0 id="ImageV"></a>
                        </span>';

                         }else{ echo NOT_UPLOADED; }

                     }
		elseif($values['fieldname'] == 'Rating')
                    {?>
                        <script src="../js/jRate.min.js"></script>        
                        <script type="text/javascript">
                                        $(function () {
                                                var that = this;
                                                $("#jRate").jRate({
                                                        rating: "<?=stripslashes($arryLead[0]['Rating'])?>",
                                                        strokeColor: 'black',
                                                        readOnly: true,
                                                        width: 20,
                                                        height: 20,
                                                        precision: 0.1,
                                                        minSelected: 0,
                                                        isDisabled : true

                                                });

                                        });
                                </script>
                    <div id="jRate" style="height:30px;width: 100px;disabled"></div>
                    <?php
                    }elseif($values['fieldname'] == 'TaxRate')
                    {
                        echo $TaxVal.'<input type="hidden" name="TaxRate" id="TaxRate" value="'.$arryQuote[0]['TaxRate'].'">';
                    }elseif($values['fieldname'] == 'EmpID'){
                        echo (!empty($ActUrl))?($ActUrl):(NOT_SPECIFIED);
                    }elseif($values['fieldname'] == 'FolderID'){
                        echo (!empty($arryDocument[0]['FolderName']))?(stripslashes($arryDocument[0]['FolderName'])):(NOT_SPECIFIED);
                    } 
                    elseif($values['fieldname'] == 'FileName'){
                        
                            $document = stripslashes($arryDocument[0]['FileName']);
			     

                            if($document !='' && IsFileExist($Config['C_DocumentDir'], $document))
                            { 		
                                echo '<div id="DocDiv">'.$document.'<br><a href="../download.php?file='.$document.'&folder='.$Config['C_DocumentDir'].'" class="download">Download</a> </div>';			
                            
                            }else{ echo NOT_UPLOADED;}

                    } 
                    else{
                        
                        if($values['fieldname'] == 'CustType'){ echo $cusVal;}else{
 //echo (!empty($arrayVal[$values['fieldname']]))?($arrayVal[$values['fieldname']]).' ['.$arrayVal[$values['fieldlabel']].': '.stripslashes($arrayVal[$values['fieldname']]]).']'):(NOT_SPECIFIED);

                       echo ($arrayVal[$values['fieldname']])? stripslashes($arrayVal[$values['fieldname']]) : NOT_SPECIFIED; 
                        }    
                    } 
                    
            echo  '</td>'.$inendtr;
   
    

/*****************/ 
if($values['fieldname'] == 'CreditLimit' && $arrayVal["Currency"]!='' && $arrayVal["Currency"]!=$Config["Currency"] && !empty($arrayVal["CreditLimitCurrency"])){
	echo '</tr><tr><td align="right">Credit Limit ('.$arrayVal["Currency"].') : </td><td>'.$arrayVal["CreditLimitCurrency"].'</td></tr>';
}
/*****************/ 

             if($values['fieldname'] == 'RelatedType' && $arrayVal['RelatedType']!='')
                    {  
            
                         if($arrayVal['RelatedType']=='Lead'){
                            $relatedToValue = $arrayVal['RelatedTo'];
                            if($relatedToValue>0)$arryLead = $objLead->GetLeadBrief($relatedToValue);
                            $final = $arryLead[0]['FirstName'].' '.$arryLead[0]['LastName'];

                          }else if($arrayVal['RelatedType']=='Opportunity'){
                            $relatedToValue = $arrayVal['RelatedTo'];
                            if($relatedToValue>0)$arryOpportunity = $objLead->GetOpportunity($relatedToValue);
                            $final=$arryOpportunity[0]['OpportunityName'];

                          }else if($arrayVal['RelatedType']=='Campaign'){
                            $relatedToValue = $arrayVal['RelatedTo'];
                            if($relatedToValue>0)$arryCampaign = $objLead->GetCampaign($relatedToValue);
                            $final=$arryCampaign[0]['campaignname'];

                          }else if($arrayVal['RelatedType']=='Quote'){
                            $relatedToValue = $arrayVal['RelatedTo'];
                            if($relatedToValue>0)$arryQuote = $objLead->GetQuoteBrief($relatedToValue);
                            $final=$arryQuote[0]['subject'];

                          }
                          
                          echo '<td align="right"   class="blackbold">'.$arrayVal['RelatedType'].' :</td>
                                <td align="left" colspan="3">'.$final.'</td>';
                        
                    }    
            
            
            
            
            
    if($head==1 && $j>1 && $j%2==0){

        echo '<tr/>';
    }
     
    ?>
    <?php if($values['fieldlabel'] == 'Country')
    {?>
    

	<? if(!empty($StateName)){?>
        <tr>
                <td  align="right" valign="middle"   class="blackbold"> State :</td>
                <td  align="left" colspan="2"  class="blacknormal"> <?=$StateName?> </td>
              </tr>
		<? } ?>
	    
                <tr>
                <td  align="right"   class="blackbold"> City   :</td>
                <td  align="left"  > <?=(!empty($CityName))?(stripslashes($CityName)):(NOT_SPECIFIED)?>   </td>
              </tr>
    <?php }
    
            
    $j++;} 
    
   
 } 
 ?>

