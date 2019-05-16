<?php $HideNavigation = 1;

include_once("includes/header.php");
require_once($Prefix."classes/sales.quote.order.class.php");
$objSale = new sale();
ini_set('display_errors', '1');
if(!empty($_POST)){
//PR($_POST);die;
if($_POST['id']>0){

	$objConfig->UpdateEmailSignature($_POST);
	$_SESSION['mess_sing']='Updated Signature successfully';
}
else{
	$objConfig->AddEmailSignature($_POST);
	$_SESSION['mess_sing']='Added Signature successfully';
}
	
	echo '<script language="JavaScript1.2" type="text/javascript">
	parent.location.reload(true);
	parent.$.fancybox.close();
          </script>';
             exit;
}
if(!empty($_SESSION['AdminID'])){
$listSignatureArry=$objConfig->GetEmailSignature();
//PR($listSignatureArry);

}
require_once("includes/footer.php"); 	
?>