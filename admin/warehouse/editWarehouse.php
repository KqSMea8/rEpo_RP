<?php $FancyBox=1;
 /**************************************************/
    $ThisPageName = 'viewWarehouse.php'; $EditPage = 1;
    /**************************************************/
   
	    require_once("../includes/header.php");
        require_once($Prefix."classes/warehouse.class.php");
             
		
		include_once("language/english.php");
	
	
			$ModuleName = "Warehouse";

			$RedirectURL = "viewWarehouse.php?curP=".$_GET['curP'];

			if(empty($_GET['tab'])) $_GET['tab']="Summary";

			$EditUrl = "editWarehouse.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&module=".$_GET["module"]."&tab="; 
	


		$objWarehouse=new warehouse();
		
	
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objWarehouse->RemoveWarehouse($del_id);
					}
					$_SESSION['mess_warehouse'] = WAREHOUSE_REMOVE;
					break;
			case 'active':
					$objWarehouse->MultipleWarehouseStatus($multiple_action_id,1);
					$_SESSION['mess_warehouse'] = WAREHOUSE_REMOVE;
					break;
			case 'inactive':
					$objWarehouse->MultipleWarehouseStatus($multiple_action_id,0);
					$_SESSION['mess_warehouse'] = WAREHOUSE_REMOVE;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/************************  End Multiple Actions ***************/	
	
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_warehouse'] = WAREHOUSE_REMOVE;
		$objWarehouse->RemoveWarehouse($_GET['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_warehouse'] = WAREHOUSE_STATUS;
		$objWarehouse->changeWarehouseStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
	}
	
	/***************************************************************/
	
	 if ($_POST) {

		if (!empty($_POST['WID']))
		{
				  $ImageId = $_POST['WID'];	
				/***************************/		
				$objWarehouse->UpdateWarehouse($_POST);
				            // $objField->updateModuleForm($_POST,$ImageId);		
					$_SESSION['mess_warehouse'] = WAREHOUSE_UPDATED;
					//header("Location:".$RedirectURL);
					//exit;
						
				/***************************/
		}
		 else {	
		//if($objWarehouse->isEmailExists($_POST['Email'],'')){
		//$_SESSION['mess_warehouse'] = $MSG[105];
		//}else{	
		$ImageId = $objWarehouse->AddWarehouse($_POST); 
		$_SESSION['mess_warehouse'] = WAREHOUSE_ADDED;
						
		//}
		}
					
 		$_POST['WID'] = $ImageId;

		       if($_POST['WID']>0)
			{
				                   
				                   
				                       $Config['DbName'] = $Config['DbMain'];
				                       $objConfig->dbName = $Config['DbName'];
				                       $objConfig->connect();
				                       /*********************************/

				                       $arryCountry = $objRegion->GetCountryName($_POST['country_id']);
				                       $arryRgn['Country']= stripslashes($arryCountry[0]["name"]);

				                       if(!empty($_POST['main_state_id'])) {
				                               $arryState = $objRegion->getStateName($_POST['main_state_id']);
				                               $arryRgn['State']= stripslashes($arryState[0]["name"]);
				                       }else if(!empty($_POST['OtherState'])){
				                                $arryRgn['State']=$_POST['OtherState'];
				                       }

				                       if(!empty($_POST['main_city_id'])) {
				                               $arryCity = $objRegion->getCityName($_POST['main_city_id']);
				                               $arryRgn['City']= stripslashes($arryCity[0]["name"]);
				                       }else if(!empty($_POST['OtherCity'])){
				                                $arryRgn['City']=$_POST['OtherCity'];
				                       }

				                       /*********************************/
				                       $Config['DbName'] = $_SESSION['CmpDatabase'];
				                       $objConfig->dbName = $Config['DbName'];
				                       $objConfig->connect();

				                       $objWarehouse->UpdateCountyStateCity($arryRgn,$_POST['WID']);

				               }
				               
				               /*********************************/
				               /*********************************/                        
			     
				           if (!empty($_GET['edit'])) {
							header("Location:".$RedirectURL);
							exit;
						}else{
							header("Location:".$RedirectURL);
							exit;
						}
		 


			
				}
		

				if (!empty($_GET['edit'])) {
					$arryWarehouse = $objWarehouse->GetWarehouse($_GET['edit']);
					$arryWarehouseDetail=$objWarehouse->GetWarehouseDetail($_GET['edit'],'');
					$WID   = $_GET['edit'];	

					if($WID >0){
		
				       }
	
			
				}
				
				if($arryWarehouse[0]['Status'] != ''){
					$WarehouseStatus = $arryWarehouse[0]['Status'];
				}else{
					$WarehouseStatus = 1;
				}				
		

		


   

 /******Connecting to main database********/
 $Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
/******************************************/


 

 

	

	require_once("../includes/footer.php"); 
?>


