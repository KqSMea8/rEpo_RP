<?php
/**************************************************/
$ThisPageName = 'apiDemo.php';
/**************************************************/
include_once("../includes/header.php");

if(empty($_GET['apiType'])) $_GET['apiType']='Fedex';

$apiType = strtolower(trim($_GET['apiType']));
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
     
}

h1{
	font-size: 20px;
}
h1 a:link{
	font-size: 18px;
}
h1 .red{
	font-size: 18px;
}
 </style>
 <div class="back"><a class="back" href="viewShippingAccount.php">Back</a></div>

 <div id="Help_Desk">
<table align="left" cellspacing="0" cellpadding="0" border="0" width="100%" >
  </table><div class="wrap_head">
     <div align="left" class="blackbold"><strong><h1>
<?php echo $_GET['apiType']; ?> Instructions</h1></strong></div>
    </div>

</div>

<table align="left" cellspacing="0" cellpadding="0" border="0" width="100%" id="infotable">
 <?php if($apiType=='fedex'){?>

<tr>
 <td> <strong><h1>Step 1 : Login to FedEx Account</h1></strong> </td>
</tr>


<tr>
<td><img src="image/f1.png" alt="Note"></td>
</tr>

<tr>
 <td> <strong><h1 >Step 2 :  Go to url <a href="https://www.fedex.com/us/developer/web-services/process.html?tab=tab2#tab4" target="_blank">https://www.fedex.com/us/developer/web-services/process.html?tab=tab2#tab4</a></h1></strong> </td>

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


<?php if($apiType=='ups'){?>
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
<?php if($apiType=='dhl'){?>

 
<tr>
 <td><strong><h1>Step 1 : Open Url  <a href="http://www.dhl.co.in/en/express/shipping/open_account.html" target="_blank">http://www.dhl.co.in/en/express/shipping/open_account.html</a> </h1></strong></td>
</tr>

<tr>
<td><img src="image/dhl1.png" ></td>
</tr>

<tr>
 <td><strong><h1>Step 2 :  Fill the form & Click Request Account </h1></strong></td>
</tr>

<tr>
<td><img src="image/dhl2.png" ></td>
</tr>



<tr>
 <td><strong><h1>Step 3 : After form submission, You will get a verification call from DHL and They will ask for DHL account number. </h1></strong></td>
</tr>


<tr>
<td><img src="image/dhl3.png"></td>
</tr>

<tr>
 <td><strong><h1>Step 4 : To get a DHL account number. <a href="http://www.dhl.com/en.html" target="_blank"> Contact DHL local office </a> to open a new account, if you don't have one yet.  </h1></strong></td>
</tr>

<tr>
 <td><strong><h1>Step 5 :  Email  <span class=red>xmlrequests@dhl.com</span> with an attached  <a href="https://s3.amazonaws.com/helpscout.net/docs/assets/558a2c29e4b027e1978ea682/attachments/58212f7190336042578d3663/XML-PI--New-User-Request.xls">application form</a> (you must fill in account number)  and cc <br><span class=red>support@postmen.com</span>. Tell DHL you need to obtain DHL XML API credentials.   </h1></strong></td>
</tr>

<tr>
 <td><strong><h1>Step 6 :  DHL will provide DHL XML- PI toolkit (Developer guide), and API credentials for both Sandbox and<br> Production environment:  <span class=red>Site ID</span> and <span class=red>Password</span>. </h1></strong></td>
</tr>

<tr>
 <td><strong><h1>Step 7 :  It takes around 24 hours for the API credentials to be activated.  </h1></strong></td>
</tr>

<?php } ?>


<?php if($apiType=='usps'){?>

<tr>
<td><strong><h1>Not Available. </h1></strong> </td>
</tr>



<?php } ?>
</table>

<?


require_once("../includes/footer.php");


?>
