<?php
	require_once("../includes/header.php");
    require_once($Prefix."classes/lead.class.php");
 require_once($Prefix."classes/quote.class.php");
 require_once($Prefix."classes/employee.class.php");        
      require_once($Prefix."classes/event.class.php"); 
 $objEmployee=new employee();

	$ModuleName = "Dashboard";

	$objLead=new lead();
$objQuote=new quote();
$objActivity=new activity();



/**************My New Lead*************/

      $arryMyLead=$objLead->GetDashboardLead();
	  $num1=$objLead->numRows();

 /**************End New Ticket*************/
$arryTicket=$objLead->GetDashboardTicket();

	  $num2=$objLead->numRows();
 /**************Top Opportunities*************/

      $arryTopOpp=$objLead->GetDashboardOpportunity();
     
	  $num3=$objLead->numRows();

 /**************End New Opportunities*************/
$arryCompaign=$objLead->GetDashboardCompaign();


	  $num4=$objLead->numRows();

$arryQuote=$objQuote->GetDashboardQuote();


	  $num5=$objQuote->numRows();

 /************************************/

$arryActivity=$objActivity->GetActivityDeshboard();


	  $num6=$objActivity->numRows();



	 

	require_once("../includes/footer.php"); 
?>
