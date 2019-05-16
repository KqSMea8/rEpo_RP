
<?php //print_r($planDetails);
foreach($planDetails as $k=>$packD){
$arr = array();
$packDetails=array();
$arrPlan = unserialize($packD->plandata); 
$packDetails = unserialize($packD->plandata);
//print_r($arrPlan);
}
$packDetails['amount'] = "$ ".$packDetails['amount'];
$packDetails['overageCostPerDoc'] = "$ ".$packDetails['overageCostPerDoc'];
$packDetails['overageCostPerPage'] = "$ ".$packDetails['overageCostPerPage'];
$packDetails['overageCostPerVideo'] = "$ ".$packDetails['overageCostPerVideo'];
$packDetails['overageCostVideoSize'] = "$ ".$packDetails['overageCostVideoSize'];
$packDetails['overageCostPerUser'] = "$ ".$packDetails['overageCostPerUser'];


 $test = new DateTime($packDetails['recordInsertedDate']);
 $packDetails['recordInsertedDate'] = date_format($test, 'D jS \of F Y H:i:s'); 

//echo "<pre>"; print_r($packDetails); die;
$fieldnames=array(
    
    'name'=>'Package Name',
    'allowedDoc'=>'Allowed Doc',
    'allowedPage'=>'Allowed Page',
    'amount'=>'Amount',
    'overageCostPerDoc'=>'Overage Cost Per Doc',
    'overageCostPerPage'=>'Overage Cost Per Page ',
    'allowedVideo'=>'Allowed Video ',
    'allowMaxvideoSize'=>'Allowed Video Size (in MB)',
    'overageCostPerVideo'=>'Overage Cost Per Video',
    'overageCostVideoSize'=>'Overage Cost Per Video Size',
    'allowUser'=>'Allowed User ',
    'overageCostPerUser'=>'Overage Cost Per User',
    'recordInsertedDate'=>'Record Inserted Date',
    'timePeriod'=>'Time Period (in days) ',
    
    
)
?>
<table width="97%" border="0" align="center" cellpadding="0"
       cellspacing="0">
    <form name="form1" action="" method="post" onSubmit="" enctype="multipart/form-data">
        <tr>
            <td align="center" valign="top">

                <table width="80%" border="0" cellpadding="5" cellspacing="0"
                       class="borderall">
                    <tr>
                        <td colspan="2" align="left" class="head">Package Details</td>
                    </tr>
                    <?php 
                    if(!empty($packDetails)){
                        
                        unset($packDetails['id']);
                          unset($packDetails['status']);
                           unset($packDetails['deleted']);
                    foreach($packDetails as $k=>$packD){?>
                    <tr>
                        <td align="right" class="blackbold"><?=$fieldnames[$k]?> :</td>
                        <td align="left"><?php if($k=='Package Description')echo base64_decode($packD);else echo $packD;?></td>
                    </tr>
                    <?php }}else{?>
                    <tr align="center">
                        <td colspan="2" class="no_record">No details found.</td>
                    </tr>
                    <?php }?>
                   
                   
                    
                    
                </table>
            </td>
        </tr>

        
    </form>
</table>
