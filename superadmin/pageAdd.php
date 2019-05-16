<?php 
	/**************************************************/
	$ThisPageName = 'pageList.php'; $EditPage = 1; 
	/**************************************************/

	include_once("includes/header.php");

	require_once("../classes/superAdminCms.class.php");
	require_once("../classes/class.validation.php");

	$supercms=new supercms();

	$_GET['edit'] = (int)$_GET['edit'];
  	$id = (int)$_GET['edit'];
	$_GET['active_id'] = (int)$_GET['active_id'];
	$_GET['del_id'] = (int)$_GET['del_id'];
	$ModuleName = 'Page';
	$ListTitle  = 'Pages';
	$ListUrl    = "pageList.php?curP=".$_GET['curP'];

  	if(!empty($_GET['active_id'])){
		$_SESSION['mess_pg'] = PAGE_STATUS_CHANGED;
		$supercms->changePageStatus($_GET['active_id']);
		header("location:".$ListUrl);
		exit;
	 }
	

	 if(!empty($_GET['del_id'])){             
                $_SESSION['mess_pg'] = PAGE_REMOVED;
                $supercms->deletePage($_GET['del_id']);
		$supercms->deleteMenuPage($_GET['del_id']);
                header("location:".$ListUrl);
                exit;
	}



	
		 
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
			$supercms->updatePage($_POST);
			$LstID = $_GET['edit'];
		
			if(empty($_POST['parent_id']) && !empty($_POST['page_id'][0])){
				$supercms->addSubMenu('',$_POST['page_id'][0],$LstID);
			}else if($_POST['parent_id']!= $_POST['page_id'][0] && !empty($_POST['page_id'][0]) ){ 
				$supercms->updateParentPage('',$_POST['page_id'][0],$LstID);                                           	
			}else if(empty($_POST['page_id'][0]) && !empty($_POST['parent_id']) ){ 

				$supercms->deleteMenuPage($_GET['edit']);
			}

			header("location:".$ListUrl);
			exit;
                                        
	    } else {
			$chkslug=$supercms->getPageSlug();
			//print_r($reshgj);

			if (in_array($data['UrlCustom'],$chkslug)) {
			   $_POST['UrlCustom']=$_POST['UrlCustom'].'-1';
			}
						                    


		            $_SESSION['mess_pg'] = PAGE_ADDED;
		            $lastShipId = $supercms->addPage($_POST);	


			if($_POST['page_id'][0] >0 ){
                             $saveData=array();
                             $saveData['Title']= $_POST['Title'];
                             $saveData['UrlCustom']= $_POST['UrlCustom'];
                           
                            	foreach ($_POST['page_id'] as $result){

                            		$saveData['page_id']=$result;
                            		
                            		$parentmenu = $supercms->addSubMenu('',$result,$lastShipId);	
                            		
                            	}
                            }



                                   header("location:".$ListUrl);
				   exit;
                            }

                                         
		
		}
		
                                     
			
		}
		



	/**************************
	if($Config['localhost']==1){
		$dir = "../../eznetcrm";
	}else{
		$dir = "../../";
	}
	$dh  = opendir($dir);
	$files[]='default';
	while (false !== ($filename = readdir($dh))) {
		if (strpos($filename,'template') !== false) {
		    $files[$filename] = $filename;
		}

	}
	
	/**************************/
	$arryTemplate=$supercms->getCrmTemplate();

	//echo '<pre>';print_r($arryTemplate);exit;


	$parentDta=$supercms->showParentPage($id);

	if (!empty($id)){
		$arryPage = $supercms->getPageById($id);
		
		$parentMenuDta=$supercms->showParentMenu($id);
	}

	
	if($arryPage[0]['Status'] == "No"){
		$PageStatus = "No";
	}else{
		$PageStatus = "Yes";
	}                           

	
		
	require_once("includes/footer.php"); 	 
?>


