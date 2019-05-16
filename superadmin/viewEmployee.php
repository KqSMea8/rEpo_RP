<?php 
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/user.class.php");
    require_once("../classes/employee.class.php");
	$objCompany=new company();
    $objEmployee=new employee();
	$objUser=new user();
	/****************************/
	
	require_once("userInfoConnection.php");
    $_SESSION['locationID']=1;
	/****************************/
         
    if($CmpID>0){			    	
	$arryEmployee=$objEmployee->ListEmployee($_GET);
	$num=$objEmployee->numRows();

	$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
	(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
    $viewAll = 'viewEmployee.php?cmp='.$CmpID.'&curP='.$_GET['curP'];
	}else{
		echo $ErrorMsg;
	}
	require_once("includes/footer.php"); 	 
?>


