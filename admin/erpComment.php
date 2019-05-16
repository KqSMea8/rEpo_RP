<?php 
	/**************************************************/
	//$ThisPageName = 'viewSalesQuoteOrder.php';  if($_GET['pop'] == 1){  $HideNavigation = 1;  $hide = 1;} if($_GET['popLead'] == 1){  $HideNavigation = 1; $hide = 1; }
	/**************************************************/
$HideNavigation = 1;$hide = 1;
	/**************************************************/
	$ThisPageName = 'viewItem.php';
	include_once("includes/header.php");
	require_once($Prefix."classes/employee.class.php");
  require_once($Prefix."classes/sales.quote.order.class.php");
	

	$ModuleName = "Sales";
	$objSale = new sale();
	$objEmployee=new employee();
	$Module="Sales";
	$_GET['view'] = (int)$_GET['view'];

(empty($_GET['AP']))?($_GET['AP']=""):(""); 
(empty($_GET['AR']))?($_GET['AR']=""):(""); 
(empty($_GET['po']))?($_GET['po']=""):(""); 
(empty($_GET['qo']))?($_GET['qo']=""):(""); 
(empty($_GET['so']))?($_GET['so']=""):(""); 
(empty($_GET['sq']))?($_GET['sq']=""):(""); 

	/************************/
	if($_POST){
		
		CleanPost(); 
		if($_POST['Comment']!=''){
			$_POST['parentID']=$_GET['view'];
			$_POST['parent_type']=$_GET['module'];
			$_POST['commented_by']=$_SESSION['AdminType'];
			$_POST['commented_id']=$_SESSION['AdminID'];
			$LastID = $objSale->AddComment($_POST);
			header("location:".$ViewUrl."Comments");
			exit;
	       }
	/************************/

}
	if (!empty($_GET['view'])) {
		
			$arrySales = $objSale->GetCommentListBySaleOrderId($_GET['view'],'');
           // $PageHeading = 'View lead Detail for: '.stripslashes($arryLead[0]['FirstName']);
			$OrderID   = $_GET['view'];	
			
		}

		

	require_once("includes/html/erpComment.php"); 	 
?>


