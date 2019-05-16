<?php 
	$HideNavigation = 1;	
	/**************************************************/
	include_once("includes/header.php");
	require_once("../classes/industry.class.php");
    
	
	$industry = new industry();
	$viewID = explode('@',$_GET['view']);
	
	if($viewID[0] > 0) {
		$arryAccount = $industry->GetAccountIndustry($viewID[0],$viewID[1]);

		$arryIndustry = $industry->getIndustryById($viewID[0]);
	}
/***************paging************/
	$Config['StartPage']=0;
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$num =count($arryAccount);
	$pagerLink=$objPager->getPager($arryAccount,$RecordsPerPage,$_GET['curP']);
	(count($arryAccount)>0)?($arryAccount=$objPager->getPageRecords()):("");
	/***************End*************/
	
	require_once("includes/footer.php"); 	 
?>


