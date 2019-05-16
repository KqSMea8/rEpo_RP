<?php $FancyBox=1;
$HideNavigation = 1;
 /**************************************************/
    $ThisPageName = 'viewDocument.php';

    /**************************************************/
	require_once("../includes/header.php");
		require_once($Prefix."classes/lead.class.php");
	
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/group.class.php");
        require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$ModuleName = "Document";
	if($_GET['parent_type']!='' && $_GET['parentID']!=''){
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
	


	
		

if (!empty($_GET['view'])) {
	$arryDocument = $objLead->GetDocument($_GET['view'],'');
        $PageHeading = 'view document for: '.stripslashes($arryDocument[0]['title']);

	if(!empty($arryDocument[0]['CustID'])){
		$arryCustomer = $objCustomer->GetCustomer($arryDocument[0]['CustID'],'','');
	}


	if($arryDocument[0]['AssignType'] == "User"){
		$classUser = 'style="display:block;"';
		$classGroup = 'style="display:none;"';
               $Name = "User";
		if($arryDocument[0]['AssignTo']!=''){
		$arryEmp=$objLead->GetAssigneeUser($arryDocument[0]['AssignTo']);
		}
	}elseif($arryDocument[0]['AssignType'] == "Group"){
		$arryGroup = $objGroup->getGroup($arryDocument[0]['GroupID'],1);
                $Name = $arryGroup[0]['group_name'];
		if($arryDocument[0]['AssignTo']!=''){
		$arryEmp=$objLead->GetAssigneeUser($arryDocument[0]['AssignTo']);
	}

}else{
$Name = "Not Selected";
}
	$Emp='';

	if(!empty($arryEmp)){
		foreach($arryEmp as $values)
		{
		$Emp .= '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['EmpID'].'">'.$values['UserName'].'</a>,';
		}
		$Emp = rtrim($Emp,",");
	}
	
	$documentID   = $_GET['edit'];			
	}
				

		
	if($arryDocument[0]['Status'] != ''){
		$DocumentStatus = $arryDocument[0]['Status'];
	}else{
		$DocumentStatus = 1;
	}
				
	$_GET['Status']=1;$_GET['Division']=5;
	
	
	
	require_once("../includes/footer.php"); 
?>


