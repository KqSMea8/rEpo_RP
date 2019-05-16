<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewQuote.php?module=Quote'; 
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	$objLead=new lead();

	$arryOpportunity=$objLead->ListOpportunity('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objLead->numRows();
      if($RecordsPerPage == 10)
        {
            $RecordsPerPage = $RecordsPerPage;
        }
        else{
            $RecordsPerPage = 10;
        }
	$pagerLink=$objPager->getPager($arryOpportunity,$RecordsPerPage,$_GET['curP']);
	(count($arryOpportunity)>0)?($arryOpportunity=$objPager->getPageRecords()):("");

     

	
		  

  require_once("../includes/footer.php");

?>
