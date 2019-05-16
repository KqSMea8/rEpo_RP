<?php $FancyBox=1;
 /**************************************************/
   if($_GET['module'] == 'Campaign'){
       $ThisPageName = 'viewCampaign.php'; 
    }else{  
        $ThisPageName = 'viewDocument.php';
     } //$EditPage = 1;
     
    #echo $ThisPageName;exit;
    /**************************************************/
			require_once("../includes/header.php");
			require_once($Prefix."classes/lead.class.php");
			require_once($Prefix."classes/region.class.php");
			require_once($Prefix."classes/employee.class.php");
			require_once($Prefix."classes/group.class.php");
			require_once($Prefix."classes/function.class.php");
			require_once($Prefix."classes/sales.customer.class.php");
			require_once($Prefix."classes/field.class.php"); //By Chetan//

	$ModuleName = "Document";
	$parent_type = (isset($_GET['parent_type'])) ? $_GET['parent_type'] :''; 
	$parentID = (isset($_GET['parentID'])) ? $_GET['parentID'] :''; 
	if($parent_type!='' && $parentID!=''){
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
       

         
        
        //By Chetan3Aug//
 	$objField = new field();	
        $arryHead=$objField->getHead('',105,1);     
        //End//
        
        
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
	
	 if(!empty($_GET['FileExist'])){ 
		$objLead->RemoveDoc($_GET['edit']);
		header("Location:".$EditUrl);
		exit;
	}

	 if(!empty($_GET['del_id'])){
                #echo $RedirectURL; exit;
		$_SESSION['mess_Document'] = DOC_REMOVED;
		$objLead->RemoveDocument($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_Document'] = DOC_STATUS;
		$objLead->changeDocumentStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if ($_POST) {

			CleanPost();
			

			//For array to string conversion by niraj 10feb16
			array_walk($_POST,function(&$value,$key){$value=is_array($value)?implode(',',$value):$value;});
			//End array to string conversion by niraj


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


				$heading = escapeSpecial($_POST['title']);
				$documentName = $heading."_".$ImageId;	

				$FileInfoArray['FileType'] = "Document";
				$FileInfoArray['FileDir'] = $Config['C_DocumentDir'];
				$FileInfoArray['FileID'] =  $documentName;
				$FileInfoArray['OldFile'] = $_POST['OldFile'];
				$FileInfoArray['UpdateStorage'] = '1';
				$ResponseArray = $objFunction->UploadFile($_FILES['FileName'], $FileInfoArray);
				if($ResponseArray['Success']=="1"){  
					$objLead->UpdateDoc($ResponseArray['FileName'],$ImageId);  
				}else{
					$ErrorMsg = $ResponseArray['ErrorMsg'];
				}
  						

				if(!empty($_SESSION['mess_Document'])) $ErrorPrefix = '<br><br>';


				$_SESSION['mess_Document'] .= $ErrorPrefix.$ErrorMsg;

			 /******** Drop box and google drive upload by sanjeev 4feb2015 ***************/
				}elseif(!empty($_SESSION['googleDriveFileName'])){
					if(IsFileExist($Config['C_DocumentDir'],$_POST['OldFile'])){
						$OldFileSize = filesize($_POST['OldFile'])/1024; //KB
						//unlink($_POST['OldFile']);
						$objFunction->DeleteFileStorage($Config['C_DocumentDir'],$_POST['OldFile']);			
					}
					$objLead->UpdateDoc($_SESSION['googleDriveFileName'],$ImageId);
					$objConfigure->UpdateStorage($documentDestination,$OldFileSize,0);
					if($Config['ObjectStorage']=="1"){
						$ResponseArray = $objFunction->MoveObjStorage($Config['FileUploadDir'].$Config['C_DocumentDir'], $Config['C_DocumentDir'], $_SESSION['googleDriveFileName']);
						if($ResponseArray['Success']=="1"){
						 	unlink($Config['FileUploadDir'].$Config['C_DocumentDir'].$_SESSION['googleDriveFileName']);  	
						}
					}
					unset($_SESSION['googleDriveFileName']);
				}elseif(!empty($_SESSION['dropBoxFileName'])){
					if(IsFileExist($Config['C_DocumentDir'],$_POST['OldFile'])){
						$OldFileSize = filesize($_POST['OldFile'])/1024; //KB
						//unlink($_POST['OldFile']);		
						$objFunction->DeleteFileStorage($Config['C_DocumentDir'],$_POST['OldFile']);	
					}
					$objLead->UpdateDoc($_SESSION['dropBoxFileName'],$ImageId);
					$objConfigure->UpdateStorage($documentDestination,$OldFileSize,0);
					if($Config['ObjectStorage']=="1"){
						$ResponseArray = $objFunction->MoveObjStorage($Config['FileUploadDir'].$Config['C_DocumentDir'], $Config['C_DocumentDir'], $_SESSION['dropBoxFileName']);
						if($ResponseArray['Success']=="1"){
						 	unlink($Config['FileUploadDir'].$Config['C_DocumentDir'].$_SESSION['dropBoxFileName']);  	
						}
					}

					unset($_SESSION['dropBoxFileName']);
				}
				/***************End******************/
 
				
					header("Location:".$RedirectURL);
					exit;
				


				
			
		}
		

	if (!empty($_GET['edit'])) {
		$arryDocument = $objLead->GetDocument($_GET['edit'],'');
                $PageHeading = 'Edit document for: '.stripslashes($arryDocument[0]['title']);
		



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




if($arryDocument[0]['AssignType'] == "Users"){
		$classUser = 'style="display:block;"';
		$classGroup = 'style="display:none;"';
		$arryEmp = array();
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
		
		 
		
		$documentID   = $_GET['edit'];			
	}else{
$classUser = 'style="display:block;"';
$classGroup = 'style="display:none;"';
}				
	if(!empty($arryDocument) && $arryDocument[0]['Status'] != ''){
		$DocumentStatus = $arryDocument[0]['Status'];
	}else{
		$DocumentStatus = 1;
	}
				
	$_GET['Status']=1;$_GET['Division']=5;
	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	$arryGroup = $objGroup->getGroup("",1);
	$arryCustomer = $objCustomer->GetCustomerList();
	$arryFolder = $objLead->GetDocumentFolderName(); 
	require_once("../includes/footer.php"); 
?>


