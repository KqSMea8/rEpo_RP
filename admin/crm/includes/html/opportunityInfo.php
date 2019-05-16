<div class="had">Opportunity Details </div>

<? 
if (!empty($_GET['view'])) {?>


<div class="right_box">
    <table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <form name="form1" action=""  method="post">


            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">




<? if ($_GET["tab"] == "Opportunity") { ?>
                        

                            <tr>
                                <td  align="right"   class="blackbold"> Created Date : </td>
                                <td   align="left" >
                                    <?
                                    if ($arryOpportunity[0]['AddedDate'] > 0)
                                        echo date($Config['DateFormat'], strtotime($arryOpportunity[0]['AddedDate']));
                                    else
                                        echo NOT_SPECIFIED;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td  align="right"   class="blackbold" width="25%">Opportunity Name  : </td>
                                <td   align="left" width="20%">
    <?= (!empty($arryOpportunity[0]['OpportunityName'])) ? ($arryOpportunity[0]['OpportunityName']) : (NOT_SPECIFIED) ?>
                                </td>

                                <td  align="right"   class="blackbold" width="25%"> Organization Name : </td>
                                <td   align="left" >
    <?= (!empty($arryOpportunity[0]['OrgName'])) ? ($arryOpportunity[0]['OrgName']) : (NOT_SPECIFIED) ?>
                                </td>
                            </tr>


                </tr>

                <tr>
                    <td  align="right"   class="blackbold"> Amount (<?=$arryOpportunity[0]['Currency']?>) :</td>
                    <td   align="left" >
<?= (!empty($arryOpportunity[0]['Amount'])) ? ($arryOpportunity[0]['Amount']) : (NOT_SPECIFIED) ?>

                    </td>

                    <td  align="right"   class="blackbold">  Expected Close Date : </td>
                    <td   align="left" >
                        <?php //echo date($Config['DateFormat'] , strtotime($arryOpportunity[0]["CloseDate"])); ?>   
    <?= (!empty($arryOpportunity[0]['CloseDate'])) ? (date($Config['DateFormat'], strtotime($arryOpportunity[0]["CloseDate"]))) : (NOT_SPECIFIED) ?></td>
                </tr>

                <tr>
                    <td  align="right"   class="blackbold"> Sales Stage : </td>
                    <td   align="left" >

    <?= (!empty($arryOpportunity[0]['SalesStage'])) ? ($arryOpportunity[0]['SalesStage']) : (NOT_SPECIFIED) ?>
                    </td>

                     <td  align="right"   class="blackbold"> Assigned To  : </td>
            <td   align="left" > 
		<? if (!empty($arryTicket[0]['AssignType']) && $arryTicket[0]['AssignType'] == 'Group') { ?>
                        <?= $AssignName ?> <br>
                    <? } ?>
                <div> <? 
		if(!empty($arryAssignee)){
		foreach ($arryAssignee as $values) {
                    ?>
                        <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values['EmpID'] ?>" ><?= $values['UserName'] ?></a>,
    <? } } ?>
            </td>
                </tr>

                <tr>
                    <td  align="right"   class="blackbold">  Customer : </td>
                    <td   align="left" >
    <? if (!empty($arryCustomer[0]['FullName'])) { ?><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?= $arryCustomer[0]['CustCode'] ?>"><?= (stripslashes($arryCustomer[0]['FullName'])) ?> </a> <? } else {
        echo NOT_SPECIFIED; ?> <? } ?>	     

                    </td>

                    <td  align="right"   class="blackbold"> Lead Source  : </td>
                    <td   align="left" >
    <?= (!empty($arryOpportunity[0]['lead_source'])) ? ($arryOpportunity[0]['lead_source']) : (NOT_SPECIFIED) ?>


                    </td>
                </tr>
                <tr>
                    <td  align="right"   class="blackbold"> Next Step : </td>
                    <td   align="left" >
    <?= (!empty($arryOpportunity[0]['NextStep'])) ? ($arryOpportunity[0]['NextStep']) : (NOT_SPECIFIED) ?>
                    </td>

                    <td  align="right"   class="blackbold">Opportunity Type  : </td>
                    <td   align="left" >
    <?= (!empty($arryOpportunity[0]['OpportunityType'])) ? ($arryOpportunity[0]['OpportunityType']) : (NOT_SPECIFIED) ?>

                    </td>
                </tr>

                <tr>
                    <td  align="right"   class="blackbold">Probability (%): </td>
                    <td   align="left" ><?= (!empty($arryOpportunity[0]['Probability'])) ? ($arryOpportunity[0]['Probability']) : (NOT_SPECIFIED) ?>
                    </td>

                    <td  align="right"   class="blackbold">Campaign Source : </td>
                    <td   align="left" ><?= (!empty($arryOpportunity[0]['Campaign_Source'])) ? ($arryOpportunity[0]['Campaign_Source']) : (NOT_SPECIFIED) ?>
                    </td>
                </tr>

                <tr>
                    <td  align="right"   class="blackbold">Forecast Amount (<?=$arryOpportunity[0]['Currency']?>) : </td>
                    <td   align="left" ><?= (!empty($arryOpportunity[0]['forecast_amount'])) ? ($arryOpportunity[0]['forecast_amount']) : (NOT_SPECIFIED) ?>
                    </td>

                    <td  align="right"   class="blackbold">Contact Name : </td>
                    <td   align="left" ><?= (!empty($arryOpportunity[0]['ContactName'])) ? ($arryOpportunity[0]['ContactName']) : (NOT_SPECIFIED) ?>
                    </td>
                </tr>

                <tr>
                    <td  align="right"   class="blackbold">Website : </td>
                    <td   align="left" ><?= (!empty($arryOpportunity[0]['oppsite'])) ? ($arryOpportunity[0]['oppsite']) : (NOT_SPECIFIED) ?>
                    </td>

                    <td  align="right"   class="blackbold" 
                         >Status  : </td>
                    <td   align="left"  >
                        <?
                        if ($_REQUEST['view'] > 0) {
                            if ($arryOpportunity[0]['Status'] == 1) {
                                $ActiveChecked = ' Active';
                                $InActiveChecked = '';
                            }
                            if ($arryOpportunity[0]['Status'] == 0) {
                                $ActiveChecked = '';
                                $InActiveChecked = ' Inactive';
                            }
                        }
                        ?>
                <?= $ActiveChecked ?>

    <?= $InActiveChecked ?>

                </tr>
                
                                <tr>
                        <td  align="right"   class="blackbold"> Lead Date : </td>
                        <td   align="left" >
                            <?
                            if (isset($arryLead[0]['LeadDate']) && $arryLead[0]['LeadDate'] > 0)
                                echo date($Config['DateFormat'], strtotime($arryLead[0]['LeadDate']));
                            else
                                echo NOT_SPECIFIED;
                            ?>
                        </td>
                        <td  align="right"   class="blackbold"> Last Contact Date : </td>
                        <td   align="left" >
        <?
        if (isset($arryLead[0]['LeadDate']) &&  $arryLead[0]['LastContactDate'] > 0)
            echo date($Config['DateFormat'], strtotime($arryLead[0]['LastContactDate']));
        else
            echo NOT_SPECIFIED;
        ?>
                        </td>

                    </tr>
                    
                    
                    <tr>
                        <td  align="right"   class="blackbold"> Industry : </td>
                        <td   align="left" >
                            
                            <?= (!empty($arryLead[0]['Industry'])) ? (stripslashes($arryLead[0]['Industry'])) : (NOT_SPECIFIED) ?>
                            
                        </td>
</tr>



<? } ?>


    </table>	


</td>
</tr>

</form>
</table>
</div>
<?php } ?>

