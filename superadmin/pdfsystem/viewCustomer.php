<?php  
require_once("includes/settings.php"); 
require_once("classes/syncdb.class.php");
//$Config['DbHost'] =  $Config['chatdbhost'];
//$Config['DbUser'] =  $Config['chatdbuser'];     
//$Config['DbPassword'] = $Config['chatdbpassword'];    
$Config['DbName'] =  $Config['chatdbname'];
$objUser=new user();
$userID = $_REQUEST['userId']; 
$arryUser=$objUser->getUser($_REQUEST,$_REQUEST['userId']);
$compcod=$arryUser->company_code;
$objOrder=new syncdb();
$arryOrder=$objOrder->FindPdfCompUsers($_REQUEST['id'], $compcod);
?>
<style>
.had{
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 15px;
    padding-left: 3px;
    text-align: left;
    text-decoration: none;
}
.textclass{
    color: #000000;
    font-size: 12px;
    font-weight: normal;
    text-decoration: none;
    font-family:Lato,Arial,Helvetica,sans-serif;
    border-bottom:1px solid #e1e1e1;
    padding-left:20px;
    
}

.blackbold{
    font-size: 12px;
    font-weight: normal;
    padding-left: 4px;
    font-family:Lato,Arial,Helvetica,sans-serif;
    height:30px;
    font-weight:bold;
    border-bottom:1px solid #e1e1e1;
    border-right:1px solid #e1e1e1;

}
</style>


<div class="had">Customer Detail</div>
<table cellspacing="0" cellpadding="5" border="0" width="100%" class="borderall" style="border:1px solid #e1e1e1;">

  <?php  if(!empty($arryOrder)){ 
                        
                        foreach($arryOrder as $val){   ?>
<tr >
    <td align="right" valign="top" class="blackbold">Name : </td>                   
    <td align="left" style="width:100px" colspan="2" class="textclass"><?=$val['firstName'] . " " . $val['lastName'] ?></td>
</tr>

<tr >
    <td align="right" valign="top" class="blackbold">Email : </td>                   
    <td align="left" style="width:100px" colspan="2" class="textclass"><?=$val['username']; ?></td>
</tr>

    <tr>
    <td align="right" valign="top" class="blackbold">Phone : </td>                   
    <td align="left" style="width:100px" colspan="2" class="textclass"><?=$val['phone']; ?></td>
</tr>
<tr>
    <td align="right" valign="top" class="blackbold">Address : </td>                   
    <td align="left" style="width:100px" colspan="2" class="textclass"><?=$val['address']; ?></td>
</tr>
<tr>
    <td align="right" valign="top" class="blackbold">Country : </td>                   
    <td align="left" style="width:100px" colspan="2" class="textclass"><?=$val['country']; ?></td>
</tr>
<tr>
    <td align="right" valign="top" class="blackbold">State : </td>                   
    <td align="left" style="width:100px" colspan="2" class="textclass"><?=$val['state']; ?></td>
</tr>

<tr>
    <td align="right" valign="top" class="blackbold">City : </td>                   
    <td align="left" style="width:100px" colspan="2" class="textclass"><?= $val['city']; ?></td>
</tr>

<?php }
}?>
</table>

