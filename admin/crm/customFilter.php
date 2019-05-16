<?php


        (empty($_GET["type"])) ?($_GET["type"]="") :("");

	$pageNames = array('lead' =>'viewLead.php?module=lead',
                            'Opportunity' =>'viewOpportunity.php?module=Opportunity',
            'Ticket'=>'viewTicket.php?module=Ticket',
            'Campaign' =>'viewCampaign.php?module=Campaign',
            'Customer'=>'viewCustomer.php',
            'Activity'=>'viewActivity.php?module=Activity',
            'Quote' => 'viewQuote.php?module=Quote',
            'contact' =>'viewContact.php?module=contact');


	if(isset($pageNames[$_GET['type']])){
            $ThisPageName = $pageNames[$_GET['type']];
	}




 	include_once("../includes/header.php");
         require_once("../../classes/field.class.php");
        /* * *********************************************** */
	include_once("../includes/FieldArrayCrm.php");
	/* * *********************************************** */
        include("../editCustomFilter.php");
	include("../includes/html/editCustomFilter.php");

   	require_once("../includes/footer.php"); 
 ?>
