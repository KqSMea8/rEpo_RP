<?php $FancyBox=1;
 /**************************************************/
   if($_GET['module'] == 'Campaign'){
       $ThisPageName = 'viewCampaign.php'; 
    }else{  
        $ThisPageName = 'viewDocument.php';
     } $EditPage = 1;
     
     #echo $ThisPageName;
    /**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/region.class.php");
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
	$objRegion=new region();
	$objEmployee=new employee();
	$objGroup=new group();
        $objFunction=new functions();
	$objCustomer=new Customer();  
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objLead->RemoveDocument($del_id);
					}
					$_SESSION['mess_Document'] = DOC_REMOVED;
					break;
			case 'active':
					$objLead->MultipleDocumentStatus($multiple_action_id,1);
					$_SESSION['mess_Document'] = DOC_REMOVED;
					break;
			case 'inactive':
					$objLead->MultipleDocumentStatus($multiple_action_id,0);
					$_SESSION['mess_Document'] = DOC_REMOVED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/*********  End Multiple Actions **********/	
	
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
                #echo $RedirectURL; exit;
		$_SESSION['mess_Document'] = DOC_REMOVED;
		$objLead->RemoveDocument($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_Document'] = DOC_STATUS;
		$objLead->changeDocumentStatus($_REQUEST['active_id']);
		header("Location:".$RedirectURL);
	}
	

	
	 if ($_POST) {
	
			 //if (empty($_POST['Email']) && empty($_POST['contactID'])) {
				//$errMsg = $MSG[10];
			// } else {
				if (!empty($_POST['documentID'])) {
					$ImageId = $_POST['documentID'];
					$objLead->UpdateDocument($_POST);
					$objLead->addDocAssign($_POST);
					$_SESSION['mess_Document'] = DOC_UPDATED;
				} else {	
					//if($objLead->isDocumentExists($_POST['title'],'')){
						//$_SESSION['mess_Document'] = $MSG[105];
						
					//}else{	
						$ImageId = $objLead->AddDocument($_POST); 
						$_SESSION['mess_Document'] = DOC_ADDED;
					//}
				}
				
				$_POST['documentID'] = $ImageId;

				if($ImageId){

					$objLead->addDocAssign($_POST);
				}

				

		   	if($_FILES['FileName']['name'] != ''){

					$FileArray = $objFunction->CheckUploadedFile($_FILES['FileName'],"Document");			

					if(empty($FileArray['ErrorMsg'])){
						$documentExtension = GetExtension($_FILES['FileName']['name']);
						$heading = escapeSpecial($_POST['title']);
						$documentName = $heading."_".$ImageId.".".$documentExtension;	

						$MainDir = "upload/Document/".$_SESSION['CmpID']."/";						
						if (!is_dir($MainDir)) {
							mkdir($MainDir);
							chmod($MainDir,0777);
						}
						$documentDestination = $MainDir.$documentName;	
	
if(!empty($_POST['OldFile']) && file_exists($_POST['OldFile'])){
	$OldFileSize = filesize($_POST['OldFile'])/1024; //KB
	unlink($_POST['OldFile']);		
}



					if(@move_uploaded_file($_FILES['FileName']['tmp_name'], $documentDestination)){
				            $objLead->UpdateDoc($documentName,$ImageId);
					    $objConfigure->UpdateStorage($documentDestination,$OldFileSize,0);
			             	} else{
						$ErrorMsg = $_FILES["Image"]["error"];
					}
				}else{
					$ErrorMsg = $FileArray['ErrorMsg'];
				}

				if(!empty($_SESSION['mess_Document'])) $ErrorPrefix = '<br><br>';


				$_SESSION['mess_Document'] .= $ErrorPrefix.$ErrorMsg;

			}

		/*		
         if($_FILES['FileName']['name'] != ''){
			$documentExtension = GetExtension($_FILES['FileName']['name']);
			$heading = escapeSpecial($_POST['title']);
			$documentName = $heading."_".$ImageId.".".$documentExtension;	
		 	$documentDestination = "upload/Document/".$documentName;
			if(@move_uploaded_file($_FILES['FileName']['tmp_name'], $documentDestination)){
				$objLead->UpdateDoc($documentName,$ImageId);
				
			}
		}
*/
				
					header("Location:".$RedirectURL);
					exit;
				


				
			
		}
		

	if (!empty($_GET['edit'])) {
		$arryDocument = $objLead->GetDocument($_GET['edit'],'');
		



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




if($arryDocument[0]['AssignType'] == "User"){
                $classUser = 'style="display:block;"';
$classGroup = 'style="display:none;"';
if($arryDocument[0]['AssignTo']!=''){
$arryEmp=$objLead->GetAssigneeUser($arryDocument[0]['AssignTo']);
}
$return_array = array();
		for ($i=0;$i<sizeof($arryEmp);$i++) {
			

             $row_array2['id'] = $arryEmp[$i]['EmpID'];
             $row_array2['name'] =$arryEmp[$i]['UserName'];
	        $row_array2['department'] =$arryEmp[$i]['emp_dep'];
	       $row_array2['designation'] = $arryEmp[$i]['JobTitle'];
		   if($arryEmp[$i]['Image']==''){
              $row_array2['url']= "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";
	       }else{
	         $row_array2['url'] ="resizeimage.php?w=50&h=50&img=../hrms/upload/employee/".$_SESSION['CmpID']."/".$arryEmp[$i]['Image']."";
		   }
		
			array_push($return_array,$row_array2);
          }
		
$json_response2= json_encode($return_array);
}elseif($arryDocument[0]['AssignType'] == "Group"){
$classUser = 'style="display:none;"';
$classGroup = 'style="display:block;"';
}else{
$classUser = 'style="display:block;"';
$classGroup = 'style="display:none;"';
}
		/*echo "<pre>";
		print_r($arryEmp);
		echo "</pre>";
		*/
		
		 
		
		$documentID   = $_REQUEST['edit'];			
	}else{
$classUser = 'style="display:block;"';
$classGroup = 'style="display:none;"';
}
				
	if($arryDocument[0]['Status'] != ''){
		$DocumentStatus = $arryDocument[0]['Status'];
	}else{
		$DocumentStatus = 1;
	}
				
	$_GET['Status']=1;$_GET['Division']=5;
	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	$arryGroup = $objGroup->getGroup("",1);
	$arryCustomer = $objCustomer->GetCustomer('','','Yes');
	require_once("../includes/footer.php"); 
?>


