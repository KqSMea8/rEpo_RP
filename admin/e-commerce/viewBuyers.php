<?php  
 	include_once("includes/header.php");
	require_once("../classes/member.class.php");
	
	
	$_GET['opt']="Buyer";
	
	$objMember=new member();
	  
	  
	  if (is_object($objMember)) {
		$arryMember=$objMember->ListMember('',$_GET['key'],$_GET['sortby'],$_GET['asc'],$_GET['opt']);
		$num=$objMember->numRows();
 	 }
	 
	  $pagerLink=$objPager->getPager($arryMember,$RecordsPerPage,$_GET['curP']);
	 (count($arryMember)>0)?($arryMember=$objPager->getPageRecords()):("");
	 
	 require_once("includes/footer.php");
	 
?>



