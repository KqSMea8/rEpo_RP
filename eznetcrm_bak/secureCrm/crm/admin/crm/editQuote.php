<?php $FancyBox=1;
 /**************************************************/
    $ThisPageName = 'viewQuote.php'; $EditPage = 1;
    /**************************************************/
   
	require_once("../includes/header.php");
	require_once($Prefix."classes/quote.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
        require_once($Prefix."classes/group.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	
	
	$ModuleName = "Quotes";
	$RedirectURL = "viewQuote.php?curP=".$_GET['curP']."&module=".$_GET["module"]."&search_Status=All";
	if(empty($_GET['tab'])) $_GET['tab']="Summary";

	$EditUrl = "editQuote.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&module=".$_GET["module"]."&tab="; 
	
        $objTax=new tax();
        $objLead=new lead();
	$objQuote=new quote();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCommon=new common();
        $objGroup=new group();
	$objCustomer=new Customer(); 
	$objSale = new sale();
	/*********  Multiple Actions To Perform **********/
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
				foreach($mulArray as $del_id){
					$objQuote->RemoveQuote($del_id);
				}
				$_SESSION['mess_quote'] = QUOTE_REMOVE;
				break;
			case 'active':
				$objQuote->MultipleQuoteStatus($multiple_action_id,1);
				$_SESSION['mess_quote'] = QUOTE_REMOVE;
				break;
			case 'inactive':
				$objQuote->MultipleQuoteStatus($multiple_action_id,0);
				$_SESSION['mess_quote'] = QUOTE_REMOVE;
				break;				
		   }
			header("location: ".$RedirectURL);
			exit;
		
	 }
/************************  End Multiple Actions ***************/

	
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_quote'] = QUOTE_REMOVE;
		$objQuote->RemoveQuote($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_quote'] = QUOTE_STATUS;
		$objQuote->changeQuoteStatus($_REQUEST['active_id']);
		header("Location:".$RedirectURL);
	}

/***************************************************************/
	
	        if ($_POST) {



			if(!empty($_POST['ConvertOrderID'])) {
				$objQuote->CrmQuoteToSaleOrder($_POST['ConvertOrderID'],$_POST['SaleID']);
				$_SESSION['mess_quote'] = QUOTE_TO_SO_CONVERTED;
				header("Location:".$RedirectURL);
				exit;
			 } 



				if($_POST['CustType']=='o'){
					$_POST['CustID']='';
					$_POST['CustCode']='';
					$_POST['CustomerName']='';
				}else if($_POST['CustType']=='c'){
					$_POST['opportunityID']='';					
					$_POST['opportunityName']='';
				}
				
				//echo '<pre>';print_r($_POST);exit;




				if (!empty($_POST['quoteid'])) {
					$ImageId = $_POST['quoteid'];
					$objQuote->UpdateQuote($_POST);
					$_SESSION['mess_quote'] = QUOTE_UPDATED;
					//header("Location:".$RedirectURL);
					//exit;
					//break;
				} else {	

					$ImageId = $objQuote->addQuote($_POST); 
					$_SESSION['mess_quote'] = QUOTE_ADDED;
					if(!empty($ImageId)){

                                            $objQuote->SendEmailToAdmin($ImageId);
                                            $objQuote->SendAssignEmail($ImageId);

						//$objLead->UpdateCreater($_POST,"c_quotes","quoteid",$ImageId);

					}

				}
				
				$_POST['quoteid'] = $ImageId;

                                $objQuote-> AddUpdateQuoteItem($ImageId,$_POST);

                                   

				
				if (!empty($_GET['edit'])) {
					header("Location:".$RedirectURL);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}


				
			
		}
		

	if (!empty($_GET['edit'])) {
		$arryQuote = $objQuote->GetQuote($_GET['edit'],'');


		if(empty($arryQuote[0]['quoteid'])) {
			header('location:'.$RedirectURL);
			exit;
		}		
		/*****************/
		if($Config['vAllRecord']!=1){
			if($arryQuote[0]['assignTo'] !=''){
				$arrAssigned = explode(",",$arryQuote[0]['assignTo']);
			}
			if(!in_array($_SESSION['AdminID'],$arrAssigned) && $arryQuote[0]['AdminID'] != $_SESSION['AdminID']){				
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/



		if($arryQuote[0]['OpportunityID']>0){
			$arryOpp = $objLead->GetOpportunity($arryQuote[0]['OpportunityID'],'');
		}
		$OpportunityName = (!empty($arryOpp[0]['OpportunityName']))?(stripslashes($arryOpp[0]['OpportunityName'])):(stripslashes($arryQuote[0]['opportunityName']));


		if($arryQuote[0]['CustID']>0){
			$arryCustomer = $objCustomer->GetCustomer($arryQuote[0]['CustID'],'','');
		}
		$CustomerName = (!empty($arryCustomer[0]['FullName']))?(stripslashes($arryCustomer[0]['FullName'])):(stripslashes($arryQuote[0]['CustomerName']));



		


		if($arryQuote[0]['AssignType'] == 'Group'){ 
		   $assignee = $arryQuote[0]['assignTo']; 

                $classUser = 'style="display:none;"';
                $classGroup = 'style="display:block;"';

		} else { 
		  $assignee = $arryQuote[0]['assignTo'];
		/********************************************/
		$classUser = 'style="display:block;"';
		$classGroup = 'style="display:none;"';

		if(!empty($arryQuote[0]['assignTo'])){ 
		$arryEmp=$objLead->GetAssigneeUser($assignee);
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


	}
/*********************************************/





		}
		$arryQuoteAdd = $objQuote->GetQuoteAddress($_GET['edit'],'');

                $OrderID = $arryQuote[0]['quoteid'];
		if($OrderID>0){
			$arryQuoteProduct = $objQuote->GetQuoteItem($OrderID);

			$NumLine = sizeof($arryQuoteProduct);
		}else{
			$ErrorMSG = $NotExist;
		}
		//$arryQuoteProduct = $objQuote->GetQuoteProduct($_GET['edit'],'');
		

       // $arryQuoteDetail=$objQuote->GetQuoteDetail($_GET['edit'],'');

		$quoteid   = $_REQUEST['edit'];			
	}else{
$classUser = 'style="display:block;"';
$classGroup = 'style="display:none;"';
}


if(empty($NumLine)) $NumLine = 1;	
				
	if($arryQuote[0]['Status'] != ''){
		$QuoteStatus = $arryQuote[0]['Status'];
	}else{
		$QuoteStatus = 1;
	}				
		
	
  	//if(substr_count($Config['CmpDepartment'],6)==1){
		//$arrySaleTax = $objTax->GetTaxRate('1');
	//}

        $arrySaleTax = $objTax->GetTaxByLocation('1',$arryCurrentLocation[0]['country_id'],$arryCurrentLocation[0]['state_id']);
	$_GET['Status']=1;$_GET['Division']=5;
	$arryEmployee = $objEmployee->GetEmployeeList('');
         $arryGroup = $objGroup->getGroup("",1);
	

	require_once("../includes/footer.php"); 
?>


