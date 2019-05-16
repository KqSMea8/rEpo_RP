
<?php
/* Developer Name: Amit Singh
 * Description: For package list form  user-plan */
//echo "hiiiiiiiiiiiii"." PACKAGE";
//echo '<pre>';
//print_r($arryUser);
?> 
<?php
$arr = array();
$packDetails=array();
$arrPlan = unserialize($arryUser->plan_package_element); //print_r($arrPlan);
/*foreach ($arrPlan as $a) {echo $a[label];
    foreach ($a as $b) {
        //echo $b[label]. '=' . $b[value];
    }
}*/
$packDetails = unserialize($arryUser->package_detail);
//print_r($packDetails);
//print_r(base64_decode($packDetails['Package Description']));
//die('8888888888');
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
                    foreach($packDetails as $k=>$packD){//foreach ($a as $k => $b) {?>
                    <tr>
                        <td align="right" class="blackbold"><?=$k?> :</td>
                        <td align="left"><?php if($k=='Package Description')echo base64_decode($packD);else echo $packD;?></td>
                    </tr>
                    <?php }}else{?>
                    <tr align="center">
                        <td colspan="2" class="no_record">No details found.</td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td colspan="2" align="left" class="head">Package Elements</td>
                    </tr>
                    <?php 
                    //echo '<pre>'; print_r($arrPlan);die;
                    if(!empty($arrPlan)){
                        foreach($arrPlan as $packPlan){
                            //echo $packPlan['value']; die;
                            if(!empty($packPlan['value'])){//foreach ($packPlan as $pp) {?>
                    <tr>
                        <td align="right" class="blackbold" width="35%"><?=$packPlan['label']?> :</td>
                        <td align="left"><?php echo $packPlan['value']?></td>
                    </tr>
                    <?php }}}else{?>
                    <tr align="center">
                        <td colspan="2" class="no_record">No elements found.</td>
                    </tr>
                    <?php }?>
                </table>
            </td>
        </tr>

        
    </form>
</table>