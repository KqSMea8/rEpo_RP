<?php
	require_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/quote.class.php");
	require_once($Prefix."classes/employee.class.php");        
	require_once($Prefix."classes/event.class.php"); 
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	require_once($Prefix."classes/crm.class.php");
	$objCommon=new common();  
	$objphone=new phone();  
	$objLead=new lead();
	$objQuote=new quote();
	$objActivity=new activity();
  	$objEmployee=new employee();
	$ModuleName = "Dashboard";

	$OptionArray = array("Top","Daily","Weekly","Monthly","Yearly");

	require_once("../includes/footer.php"); 
?>
