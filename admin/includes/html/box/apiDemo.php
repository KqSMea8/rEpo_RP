<?php
/**************************************************/
$ThisPageName = 'apiDemo.php';
/**************************************************/
include_once("../includes/header.php");

?>
 
 <style>
 
td {
    padding: 11px 0 10px;
}

#infotable img { margin:10px auto;display:table; border:2px solid #666; border-radius:8px; }


.wrap_head {
    border-bottom: 1px solid #f4af1a;
}
strong {
     text-align: center;
}
#Help_Desk {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    display: table;
    padding: 20px;
    width: 94.5%;
    text
}

 </style>
 <div class="back"><a class="back" href="apiGlobalSetting.php">Back</a></div>

 <div id="Help_Desk">
<table align="left" cellspacing="0" cellpadding="0" border="0" width="100%" >
  </table><div class="wrap_head">
     <div align="left" class="blackbold"><strong><h1><?php echo $_GET['apiType'];?>&nbsp;Instructions</h1></strong></div>
    </div>

</div>

<table align="left" cellspacing="0" cellpadding="0" border="0" width="100%" id="infotable">
 <?php if($_GET['apiType']=='FedEx'){?>

<tr>
 <td> <strong><h1>Step 1 : Login to FedEx Account</h1></strong> </td>
</tr>


<tr>
<td><img src="image/f1.png" alt="Note"></td>
</tr>

<tr>
 <td> <strong><h1>Step 2 :  Go to url <a href="https://www.fedex.com/us/developer/web-services/process.html?tab=tab2#tab4" target="_blank">https://www.fedex.com/us/developer/web-services/process.html?tab=tab2#tab4</a></h1></strong> </td>

</tr>


<tr>
<td><img src="image/f2.png" alt="Note"></td>
</tr>



<tr>
 <td><strong><h1>Step 3 : Click on fedex web service link in left side menu. </h1></strong> </td>
</tr>


<tr>
<td><img src="image/f3.png" alt="Note"></td>
</tr>


<tr>
 <td> <strong><h1>Step 4 : Click on  move to production server link and fill the information and continue. </h1></strong> </td>
</tr>


<tr>

<td><img src="image/f4.png" alt="Note"></td>
</tr>

<?php } ?>


<?php if($_GET['apiType']=='UPS'){?>
<tr>
 <td><strong><h1>Step 1 : Login to UPS account. </h1></strong></td>
</tr>


<tr>
<td><img src="image/ups1.png" alt="Note"></td>
</tr>

<tr>
 <td><strong><h1>Step 2 :  Go to step 3 in below image to Access the UPS Developer Kit </h1></strong></td>
</tr>


<tr>
<td><img src="image/ups2.png" alt="Note"></td>
</tr>


<tr>
 <td><strong><h1>Step 3 : Click on Request an access key. </h1></strong></td>
</tr>


<tr>
<td><img src="image/ups3.png" alt="Note"></td>
</tr>

<tr>
 <td><strong><h1>Step 4 :  Fill the form to get access key and continue.</h1></strong></td>
</tr>


<tr>
<td><img src="image/ups4.png" alt="Note"></td>
</tr>


<?php } ?>



<?php if($_GET['apiType']=='DHL' || $_GET['apiType']=='USPS'){?>

<tr>
<td><strong><h1>Not Available. </h1></strong> </td>
</tr>



<?php } ?>
</table>

<?


require_once("../includes/footer.php");


?>
