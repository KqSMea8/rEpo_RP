<?php $FancyBox=1;
 /**************************************************/
    $ThisPageName = 'viewDocument.php';
if(!empty($_GET['pop']))$HideNavigation = 1;
    /**************************************************/
	require_once("../includes/header.php");
		require_once($Prefix."classes/lead.class.php");
	
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/group.class.php");
        require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix."classes/field.class.php");//By Chetan//
        
	$ModuleName = "Document";
	if((isset($_GET['parent_type'])  && $_GET['parent_type']!='') && (isset($_GET['parentID'])  && $_GET['parentID']!='')){
	if($_GET["module"] == 'lead'){

	$BackUrl = "vLead.php?view=".$_GET['parentID']."&module=".$_GET["module"]."&tab=Document&curP=".$_GET["curP"];
	$RedirectURL = "vLead.php?view=".$_GET['parentID']."&module=".$_GET["module"]."&tab=Document&curP=".$_GET["curP"];
	$EditUrl = "editDocument.php?edit=".$_GET["edit"]."&module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&tab=Document&curP=".$_GET["curP"]; 
	$ActionUrl = $EditUrl;
	}else{

	$BackUrl = "v".$_GET["module"].".php?view=".$_GET['parentID']."&module=".$_GET["module"]."&tab=Document&curP=".$_GET["curP"];
	$RedirectURL = "v".$_GET["module"].".php?view=".$_GET['parentID']."&module=".$_GET["module"]."&tab=Document&curP=".$_GET["curP"];
	$EditUrl = "editDocument.php?edit=".$_GET["edit"]."&module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&tab=Document&curP=".$_GET["curP"]; 
	$ActionUrl = $EditUrl;
	}
	}else{
	$RedirectURL = "viewDocument.php?module=".$_GET["module"]."&curP=".$_GET['curP'];


	$EditUrl = "editDocument.php?edit=".$_GET["edit"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]; 
	$ActionUrl = $EditUrl;
	}

	$objLead=new lead();
	
	$objEmployee=new employee();
	$objGroup=new group();
        $objFunction=new functions();
	$objCustomer=new Customer(); 
        $objField = new field();//By Chetan//

	
        $arryHead=$objField->getHead('',$ModuleParentID,1);//By Chetan//
	


	
		

if (!empty($_GET['view'])) {
	$arryDocument = $objLead->GetDocument($_GET['view'],'');
        $PageHeading = 'view document for: '.stripslashes($arryDocument[0]['title']);

	if(!empty($arryDocument[0]['CustID'])){
		$arryCustomer = $objCustomer->GetCustomer($arryDocument[0]['CustID'],'','');
	}


	 //By Chetan22July//    
        if($arryDocument[0]['AssignTo']  >0){  
            if($arryDocument[0]['AssignType'] == 'Group'){ 
                    $assignee = $arryDocument[0]['AssignTo']; 
                    $arryGrp = $objGroup->getGroup($arryDocument[0]['GroupID'],1);

                    $AssignName = $arryGrp[0]['group_name'];
                    $arryAssignee = $objLead->GetAssigneeUser($arryDocument[0]['AssignTo']);
            } else{ 
                    $assignee = $arryDocument[0]['AssignTo'];
                    $arryAssignee = $objLead->GetAssigneeUser($arryDocument[0]['AssignTo']);
                    $AssignName = $arryAssignee[0]['UserName'];
            }
        }
	$documentID   = $_GET['edit'];			
	}
				
		

if(empty($arryDocument[0]['documentID'])) {
	header('location:'.$RedirectURL);
	exit;
}		
/*****************/
if($Config['vAllRecord']!=1){
	if($arryDocument[0]['AssignTo'] !=''){
		$arrAssigned = explode(",",$arryDocument[0]['AssignTo']);
	}
	if(!in_array($_SESSION['AdminID'],$arrAssigned) && $arryDocument[0]['AddedBy'] != $_SESSION['AdminID']){				
	header('location:'.$RedirectURL);
	exit;
	}
}
/*****************/

		
	if($arryDocument[0]['Status'] != ''){
		$DocumentStatus = $arryDocument[0]['Status'];
	}else{
		$DocumentStatus = 1;
	}
				
	$_GET['Status']=1;$_GET['Division']=5;
	
	
	
	require_once("../includes/footer.php"); 
?>


