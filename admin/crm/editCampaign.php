<?php $FancyBox=1;

 /**************************************************/
    $ThisPageName = 'viewCampaign.php'; $EditPage = 1;
    /**************************************************/
   
        require_once("../includes/header.php");
        require_once($Prefix."classes/lead.class.php");
        require_once($Prefix."classes/region.class.php");
        require_once($Prefix."classes/employee.class.php");
        require_once($Prefix."classes/crm.class.php");

        require_once($Prefix."classes/item.class.php");
           /*mass mail code */
	//if(empty($_GET['del_id'])){   //Added by chetan 23feb//
        /*require_once( "../../lib/mailchamp/src/config.php");
        
        $Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
        $Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
        $Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
        $Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);
        $Mailchimp_Reports = new Mailchimp_Reports($MailChimp);
        $Campaignfolder = $MailchimSetting['0']['campaign_folder_id'];*/
       //}
        /*mass mail code */
	
	
	$ModuleName = "Campaign";
	$RedirectURL = "viewCampaign.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	if(empty($_GET['tab'])) $_GET['tab']="Summary";

	$EditUrl = "editCampaign.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&module=".$_GET["module"]."&tab="; 
	
        //By chetan3Aug//
        require_once($Prefix."classes/field.class.php");	
        $objField=new field();          
        $arryHead=$objField->getHead('',$ModuleParentID,1); 
        //End//

	$objLead=new lead();
	$objRegion=new region();
	$objEmployee=new employee();
        $objCommon=new common();
        $objitems=new items();
        
     
	
	/*********  Multiple Actions To Perform *********
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objLead->RemoveLead($del_id);
					}
					$_SESSION['mess_opp'] = COM_REMOVE;
					break;
			case 'active':
					$objLead->MultipleLeadStatus($multiple_action_id,1);
					$_SESSION['mess_opp'] = COM_STATUS;
					break;
			case 'inactive':
					$objLead->MultipleLeadStatus($multiple_action_id,0);
					$_SESSION['mess_opp'] = COM_STATUS;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }
	
	/************************  End Multiple Actions ***************/	
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_comp'] = COM_REMOVE;
		$objLead->RemoveCampaign($_GET['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_comp'] = COM_STATUS;
		$objLead->changeCampaignStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
	}
	
	/***************************************************************/
	  //die('fff'); 
        
	 if ($_POST) {


			/*******************/
			CleanPost(); 
			/*******************/
			 
			//For array to string conversion by niraj 10feb16
				array_walk($_POST,function(&$value,$key){$value=is_array($value)?implode(',',$value):$value;});
      //End array to string conversion by niraj


				if (!empty($_POST['campaignID'])) {
					$ImageId = $_POST['campaignID'];
					
					/***************************/
							$objLead->UpdateCampaign($_POST);
 /*$MailChimpCmp=array("ID"=>$_POST['mailchimpCmpId'],"parentID"=>$_POST['campaignID'],"parent_type"=>'Campaign',"mode_type"=>$_POST['MassEmailCampaigntype']);
                                                        $massmail->UpdateMultipleCompaign($MailChimpCmp);*/
							$_SESSION['mess_comp'] = COM_UPDATED; //'Campaign details has been updated successfully.';
							header("Location:".$RedirectURL);
							exit;
						
					/***************************/
				} else {	
					//if($objLead->isEmailExists($_POST['Email'],'')){
						//$_SESSION['mess_opp'] = $MSG[105];
					//}else{	
						$ImageId = $objLead->AddCampaign($_POST); 
/*$MailChimpCmp=array("ID"=>$_POST['mailchimpCmpId'],"parentID"=>$ImageId,"parent_type"=>'Campaign',"mode_type"=>$_POST['MassEmailCampaigntype']);*/
                                                //echo '<pre>';print_r($MailChimpCmp);die('rr');
                                                $objLead->AddMultipleCompaign($MailChimpCmp);
						$_SESSION['mess_comp'] = COM_ADDED;

						if(!empty($ImageId)){
						$objLead->UpdateCreater($_POST,"c_campaign","campaignID",$ImageId);
						}
					//}
				}
				
				$_POST['leadID'] = $ImageId;

				
				if (!empty($_GET['edit'])) {
					header("Location:".$ActionUrl);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}


				
			
		}
		

	if (!empty($_GET['edit'])) {
		$arryCampaign = $objLead->ListCampaign($_GET['edit'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
                $PageHeading = 'Edit Campaign for: '.stripslashes($arryCampaign[0]['campaignname']);
		$leadID   = $_GET['edit'];


		if(empty($arryCampaign[0]['campaignID'])) {
			header('location:'.$RedirectURL);
			exit;
		}		
		/*****************/
		if($Config['vAllRecord']!=1){
			if($arryCampaign[0]['assignedTo'] != $_SESSION['AdminID'] && $arryCampaign[0]['created_id'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/
			
	}



				
	/*if($arryCampaign[0]['Status'] != ''){
		$CampaignStatus = $arryCampaign[0]['Status'];
	}else{
		$CampaignStatus = 1;
	}*/
    $arryDepartment = $objConfigure->GetDepartment();
	$_GET['Status']=1;$_GET['Division']=5;
	$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	$arryCampaignType = $objCommon->GetCrmAttribute('campaigntype','');
	$arryExpectedResponse = $objCommon->GetCrmAttribute('expectedresponse','');
	$arryCampaignStatus = $objCommon->GetCrmAttribute('campaignstatus','');

	$arryProduct= $objitems->GetItemForDrop('');
	
	//print_r($arrySalesStage);


/*Start Delete Code For Mass Mail Campain*/
                
                if(!empty($_GET['Mdel_id'])) {
                     $module=$_GET['module'];
                     $parentID=$_GET['parentID'];
                     $modtype=$_GET['mode_type'];
                     $MCmpId=$_GET['Mdel_id'];
                     //$DeleteMassCampign=$massmail->DeleteMassMAilFromCrmCampaign($MCmpId,$module,$modtype,$parentID);
                     $_SESSION['mess_comp'] = COM_REMOVE;
                    
                     //header("Location:".$RedirectURL);
                     header("Location:vCampaign.php?view=$parentID&module=Campaign&curP=1&tab=MCampaign");
    //echo 'delete';die;vCampaign.php?view=88&module=Campaign&curP=1&tab=MCampaign
    
}
/*End Delete Code For Mass Mail Campain*/

/*******************************************/

	//$arryCountry = $objRegion->getCountry('','');

	require_once("../includes/footer.php"); 
?>


