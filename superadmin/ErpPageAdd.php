<?php 
    /**************************************************/
    $ThisPageName = 'ErpPageList.php'; $EditPage = 1; 
    /**************************************************/

	include_once("includes/header.php");

require_once("../classes/erp.superAdminCms.class.php");
require_once("../classes/class.validation.php");
	

      $erpsupercmsObj=new erpsupercms();

  CleanGet();	
/*
$dir = "meeting-template";
$dh  = opendir($dir);
$files[]='default';
while (false !== ($filename = readdir($dh))) {
if (strpos($filename,'template') !== false) {
    $files[$filename] = $filename;
}

}
//print_r($files);
*/
$arryTemplate=$erpsupercmsObj->getErpTemplate();

                 $id = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
                  if ($id && !empty($id)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
                        $ModuleName = 'Page';
                        $ListTitle  = 'Pages';
                        $ListUrl    = "ErpPageList.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($id)) 
                    {
                        $arryPage = $erpsupercmsObj->getPageById($id);
                    }

			
		 	 
                  if(!empty($_GET['active_id'])){
		$_SESSION['mess_pg'] = PAGE_STATUS_CHANGED;
		$erpsupercmsObj->changePageStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
	 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_pg'] = PAGE_REMOVED;
                                $erpsupercmsObj->deletePage($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		


 	if (is_object($erpsupercmsObj)) {	
		 
		 if (!empty($_POST)) {
		
		 		$data=array();

	$data=$_POST;
	$errors=array();
	$validatedata=array(	
		'Name'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Name')),
		'Title'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Title')),
	    'UrlCustom'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Slug')),
		)	;
		$objVali->requestvalue=$data;
		$errors  =	$objVali->validate($validatedata);
	
if(empty($errors)){

					if (!empty($id)) {
									$_SESSION['mess_pg'] = PAGE_UPDATED;
									$erpsupercmsObj->updatePage($_POST);
									header("location:".$ListUrl);
					} else {
						$chkslug=$erpsupercmsObj->getPageSlug();
						//print_r($reshgj);
										                                  
					if (in_array($data['UrlCustom'],$chkslug)) {
					$_POST['UrlCustom']=$_POST['UrlCustom'].'-1';
					}
										              


									$_SESSION['mess_pg'] = PAGE_ADDED;
									$lastShipId = $erpsupercmsObj->addPage($_POST);	
								 header("location:".$ListUrl);
					}

exit;

}

                                     
			
		}
		

	
	
		
		if($arryPage[0]['Status'] == "No"){
			$PageStatus = "No";
		}else{
			$PageStatus = "Yes";
		}
                
                              
}
	

	
		
	require_once("includes/footer.php"); 	 
?>


