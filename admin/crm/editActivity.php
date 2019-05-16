<?php $FancyBox=1;
 /**************************************************/
    $ThisPageName = 'viewActivity.php'; $EditPage = 1;
    /**************************************************/
   
	require_once("../includes/header.php");
	require_once($Prefix."classes/event.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/group.class.php");
	require_once($Prefix."classes/sales.customer.class.php");	
        require_once($Prefix."classes/field.class.php");	//By chetan//
        

	$objCommon=new common();
	$objLead=new lead();
        $objGroup=new Group();
	$objCustomer=new Customer(); 
        $objField=new field();//By chetan//
        
             //By Chetan3Aug//
         $arryHead=$objField->getHead('',136,1); //By chetan//
        //End//
        
        
        
        
	$ModuleName = $_GET['module'];
	$RedirectURL = "viewActivity.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	$RedirectURLAdd = "editActivity.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	$RedirectURLEdit = "editActivity.php?edit=".$_GET['edit']."&module=".$_GET["module"]."&curP=".$_GET["curP"].'&tab=Activity&mode=Event';



	if(empty($_GET['tab'])) $_GET['tab']="Summary";

	$EditUrl = "editActivity.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&module=".$_GET["module"]."&tab=Activity"; 

	if(isset($_GET['refrence']) && $_GET['refrence']!=''){

		//view=33&module=lead&curP=1&tab=Task
		$BackLink="v".$_GET['refrence'].".php?view=".$_GET['parentID']."&module=".$_GET['parent_type']."&tab=".$_GET['tabmode'];

	}
	


	$objActivity=new activity();
	$objRegion=new region();
	$objEmployee=new employee();
	
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objActivity->RemoveActivity($del_id);
					}
					$_SESSION['mess_activity'] = ACT_REMOVE;
					break;
			case 'active':
					$objActivity->MultipleActivityStatus($multiple_action_id,1);
					$_SESSION['mess_activity'] = ACT_REMOVE;
					break;
			case 'inactive':
					$objActivity->MultipleActivityStatus($multiple_action_id,0);
					$_SESSION['mess_activity'] = ACT_REMOVE;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/************************  End Multiple Actions ***************/	
	
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_activity'] = ACT_REMOVE;
		$objActivity->deleteActivity($_GET['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_activity'] = ACT_STATUS;
		$objActivity->changeActivityStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
	}
	
	/***************************************************************/
	
	 if ($_POST) {
			 
			/*******************/
			$description = addslashes($_POST['description']);
			//For array to string conversion by niraj 10feb16
					array_walk($_POST,function(&$value,$key){$value=is_array($value)?implode(',',$value):$value;});
      //End array to string conversion by niraj
			CleanPost(); 
			$_POST['description'] = $description;
			/*******************/

             
				if (!empty($_POST['activityID'])) {
					$ImageId = $_POST['activityID'];
					
					/***************************/
					$objActivity->UpdateActivity($_POST);
					$objActivity->addActivityEmp($_POST);
                                        $objActivity->addAssignEmp($_POST);
                                        
                                        
					$_SESSION['mess_activity'] = ACT_UPDATE;

					if($_POST['saveOutlook'])
	                                {    
	                                    $_SESSION['EventLastInsertId'] = $ImageId;
					    $RedirectURL = $RedirectURLEdit;
	                                }



					header("Location:".$RedirectURL);
					exit;	
					
					/***************************/
				} else {	
					if(empty($_POST['activityType'])){
						$_POST['activityType'] = $_POST['activity_type'];
					}

					//if($objActivity->isEmailExists($_POST['Email'],'')){
						//$_SESSION['mess_activity'] = $MSG[105];
					//}else{	
						$ImageId = $objActivity->AddActivity($_POST);
                                            
						$_SESSION['mess_activity'] = ACT_ADD;
						if($_POST['saveOutlook'])
		                                {    
		                                    $_SESSION['EventLastInsertId'] = $ImageId;
						    $RedirectURL = $RedirectURLAdd;
		                                }


                                              $_POST['activityID'] = $ImageId;
						 $objActivity->addActivityEmp($_POST);
                                             $objActivity->addAssignEmp($_POST);
					//}
				}
				
				

				
				
				if (!empty($_GET['edit'])) {
					header("Location:".$ActionUrl);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}


				
			
		}
		

	if (!empty($_GET['edit'])) {

		if($_GET['mode']=="Task"){

			 $detail_head=$_GET['mode'];

			 $none="style='display:none';";
		}else{
			$detail_head="Event";
			$none="";
		}


	$arryActivity = $objActivity->GetActivity($_GET['edit'],'');
        $PageHeading = 'Edit Activity for: '.stripslashes($arryActivity[0]['subject']);




	if(empty($arryActivity[0]['activityID'])) {
		header('location:'.$RedirectURL);
		exit;
	}		
	/*****************/
	if($Config['vAllRecord']!=1){
		if($arryActivity[0]['assignedTo'] !=''){
			$arrAssigned = explode(",",$arryActivity[0]['assignedTo']);
		}
		if(!in_array($_SESSION['AdminID'],$arrAssigned) && $arryActivity[0]['created_id'] != $_SESSION['AdminID']){				
		header('location:'.$RedirectURL);
		exit;
		}
	}
	/*****************/



/********************************************/
                   if($arryActivity[0]['AssignType'] == "User"){
			$classUser = 'style="display:block;"';
			$classGroup = 'style="display:none;"';
			$arryEmp=$objLead->GetAssigneeUser($arryActivity[0]['assignedTo']);
			$return_array = array();
			for ($i=0;$i<sizeof($arryEmp);$i++) {


				$row_array['id'] = $arryEmp[$i]['EmpID'];
				$row_array['name'] =$arryEmp[$i]['UserName'];
				$row_array['department'] =$arryEmp[$i]['emp_dep'];
				$row_array['designation'] = $arryEmp[$i]['JobTitle'];
				$arryEmp[$i]['Image'] = (isset($arryEmp[$i]['Image'])) ? $arryEmp[$i]['Image'] : '';
				if($arryEmp[$i]['Image']==''){
				$row_array['url']= "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";
				}else{
				$row_array['url'] ="resizeimage.php?w=50&h=50&img=../hrms/upload/employee/".$_SESSION['CmpID']."/".$arryEmp[$i]['Image']."";
				}

				array_push($return_array,$row_array);
			}

				$json_response= json_encode($return_array);
		 }elseif($arryActivity[0]['AssignType'] == "Group"){
			$classUser = 'style="display:none;"';
			$classGroup = 'style="display:block;"';
		}else{
                $classUser = 'style="display:block;"';
		$classGroup = 'style="display:none;"';
}

   $arryActEmp=$objActivity->getActivityEmp2($_GET['edit'],'');

            //$arryActivityDetail=$objActivity->GetActivityDetail($_GET['edit'],'');

	  if($arryActEmp)             //By Chetan21July//
        {
                $return_array2 = array();
		for ($i=0;$i<sizeof($arryActEmp);$i++) 
                {
                    $row_array2['id'] = $arryActEmp[$i]['EmpID'];
                    $row_array2['name'] =$arryActEmp[$i]['UserName'];
                    $row_array2['department'] =$arryActEmp[$i]['Department'];
                    $row_array2['designation'] = $arryActEmp[$i]['JobTitle'];
                    if($arryActEmp[$i]['Image']==''){
                    //$MainDir = "upload/employee/".$_SESSION['CmpID']."/";
                    $row_array2['url']= "../../resizeimage.php?w=120&h=120&img=images/nouser.gif";
                    }else{
                    $row_array2['url'] ="resizeimage.php?w=50&h=50&img=../hrms/upload/employee/".$_SESSION['CmpID']."/".$arryActEmp[$i]['Image']."";
                    }
                      array_push($return_array2,$row_array2);
                    }
		
		 $json_response2= json_encode($return_array2);
        }//End//		
		}else{

		$classUser = 'style="display:block;"';
		$classGroup = 'style="display:none;"';
		}
 		
				
	

	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	$arryGroup = $objGroup->getGroup("",1);
	$arryCustomer = $objCustomer->GetCustomerList();
	/***********************/
	$arryOpportunity = $objLead->GetOpportunityBrief('',1);
	$arryCampaign = $objLead->GetCampaignBrief('',1);
	$arryLead = $objLead->GetLeadBrief($id=0,0);

	$arryTicket = $objLead->GetTicketBrief('',1);
	$arryQuote = $objLead->GetQuoteBrief('',1);
	/***********************/
 
        
        
        $arryActivityStatus = $objCommon->GetCrmAttribute('ActivityStatus', '');
        $arryActivityType = $objCommon->GetCrmAttribute('ActivityType', '');
	require_once("../includes/footer.php"); 
?>


