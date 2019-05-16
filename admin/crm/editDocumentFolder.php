<?php 
 /**************************************************/
   if($_GET['module'] == 'Document'){
       $ThisPageName = 'viewDocumentFolder.php'; 
    }else{  
        $ThisPageName = 'viewDocumentFolder.php';
     } $EditPage = 1;
     
     #echo $ThisPageName;
    /**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	

	$objLead=new lead();
			
	$RedirectURL = "viewDocumentFolder.php?curP=" . $_GET['curP'] . "&module=" . $_GET["module"];
	$ModuleName='Folder';
	
	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_Document'] = FOLDER_STATUS;
		$objLead->changeDocumentFolderStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	


	if ($_POST) { 
		CleanPost(); 

		if(empty($_POST['FolderID'])) {
			$objLead->AddDocumentFolder($_POST);
			$_SESSION['mess_Document'] = FOLDER_ADDED; 
		}else{
			$objLead->UpdateDocumentFolder($_POST,$FolderID); 
			$_SESSION['mess_Document'] = FOLDER_UPDATED; 
		}  
		header("location:".$RedirectURL);
		exit;  
	}
                     
		      

if (!empty($_GET['edit'])) 
{
		$arryuser = $objLead->EditDocumentFolder($_GET['edit']);
		$FolderID   = $_GET['edit'];	
		if(empty($arryuser [0]['FolderID']))
        {                    
			header('location:'.$RedirectURL);
			exit;		
		}
}

if(!empty($arryuser) && $arryuser[0]['Status'] != ''){
		$DocumentStatus = $arryuser[0]['Status'];
	}else{
		$DocumentStatus = 1;
	}


		
	require_once("../includes/footer.php"); 
?>


