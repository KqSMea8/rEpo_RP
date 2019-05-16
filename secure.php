<?php
session_start();
require_once("includes/function.php"); 
ValidateMemberSession('secure.php');


$_POST['account_id']='14300';
$_POST['reference_no']='45645645';
$_POST['return_url']='http://www.gotgapp.com/webservices/response.php?DR={DR}';
$_POST['mode']='LIVE';
$_POST['amount'] = 100;
$_POST['description'] = 'Mobile';
$_POST['name'] = 'Parwez';


$hash = "4ee3f3b8e0d355a06d79589754759ab1"."|".$_POST['account_id']."|".$_POST['amount']."|".$_POST['reference_no']."|".$_POST['return_url']."|".$_POST['mode'];

$secure_hash = md5($hash);


?>
<form  method="post" action="https://secure.ebs.in/pg/ma/sale/pay" name="frmTransaction" id="frmTransaction" onSubmit="return validate()">
<input name="account_id" type="text" value="<?php echo $_POST['account_id'] ?>">
     
 <input name="return_url" type="text" size="60" value="<?php echo $_POST['return_url'] ?>" />
 <input name="mode" type="text" size="60" value="<?php echo $_POST['mode']?>" />
  <input name="reference_no" type="text" value="<?php echo  $_POST['reference_no'] ?>" />
  <input name="amount" type="text" value="<?php echo $_POST['amount']?>"/>
  <input name="description" type="text" value="<?php echo $_POST['description'] ?>" /> 
 <input name="name" type="text" maxlength="255" value="<?php echo $_POST['name'] ?>" />
<input name="address" type="text" maxlength="255" value="<?php echo $_POST['address'] ?>" />
<input name="city" type="text" maxlength="255" value="<?php echo $_POST['city'] ?>" />
<input name="state" type="text" maxlength="255" value="<?php echo $_POST['state'] ?>" />
<input name="postal_code" type="text" maxlength="255" value="<?php echo $_POST['postal_code'] ?>" />
<input name="country" type="text" maxlength="255" value="<?php echo $_POST['country'] ?>" />
 <input name="phone" type="text" maxlength="255" value="<?php echo $_POST['phone'] ?>" />
   <input name="email" type="text" size="60" value="<?php echo $_POST['email']?>" />
<input name="ship_name" type="text" maxlength="255" value="<?php echo $_POST['ship_name'] ?>" />
<input name="ship_address" type="text" maxlength="255" value="<?php echo $_POST['ship_address'] ?>" />
<input name="ship_city" type="text" maxlength="255" value="<?php echo $_POST['ship_city'] ?>" />
<input name="ship_state" type="text" maxlength="255" value="<?php echo $_POST['ship_state'] ?>" />
<input name="ship_postal_code" type="text" maxlength="255" value="<?php echo $_POST['ship_postal_code'] ?>" />
<input name="ship_country" type="text" maxlength="255" value="<?php echo $_POST['ship_country'] ?>" />
 <input name="ship_phone" type="text" maxlength="255" value="<?php echo $_POST['ship_phone'] ?>" />
    <input name="secure_hash" type="text" size="60" value="<?php echo $secure_hash;?>" />
 <input name="submitted" value="Submit" type="submit" />
 
</form>

