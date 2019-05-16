<?php 	
if(!empty($_GET['custompopup'])){
$HideNavigation=1;
$ModifyLabel=1;
	/**************************************************/
	$ThisPageName = 'call.php'; 
	/**************************************************/
}

	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objEmployee=new employee();
	$objphone=new phone();
	
	if(isset($_GET['from'])){
		$getComment=$objphone->GetCommentByID($_SESSION['AdminID'], 'call', $_GET['from'], $_GET['to']);
	}else{
		$getComment=$objphone->GetCommentByID($_SESSION['AdminID'], 'call');		
	}
	/*************************/
	
	if($_GET['action']=='delete'){
		 $objphone->delete('c_comments', array('CommentID'=>$_GET['cid'],'commented_id'=>$_SESSION['AdminID']));
		 $_SESSION['mess_phone'] = "Comment successfully delete";
		 header('Location: call.php');
		 exit;
	}
 
	
	require_once("../includes/footer.php"); 	
?>


