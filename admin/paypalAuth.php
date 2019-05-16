<?php 
	$HideNavigation = 1;
	
	include_once("includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
	$ModuleName = "Vendor";
	$objSupplier=new supplier();
	
	 $url='https://www.sandbox.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize?scope=https://uri.paypal.com/services/invoicing&response_type=code&redirect_uri=https://www.eznetcrm.com/&client_id=AeltrsAaLhkq_ENX_XqyJc3Xo5USwg7mBb9I2_xvmYL8GRp51q6Bd8PlyO5C5J6jksdboR1Rz7I73zRe';

	
	
	?>
	<script>window.location="<?php echo $url?>";</script>
	
	<?php 

	
	
 
	require_once("includes/footer.php"); 	
?>