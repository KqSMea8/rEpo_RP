<?
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/user.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/territory.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/meeting.class.php");
	$objFunction=new functions();
	$objCommon=new common();

	$objEmployee=new employee();
	$objUser=new user();
	$objTerritory=new territory();
	$objMeeting=new Meeting();
	$ModuleName = "User";
 
	(empty($Division))?($Division=""):(""); 

	if($Config['CurrentDepID']>0 && $Config['CurrentDepID']<10){
		$RedirectURL = "viewUser.php?curP=".$_GET['curP'];
		$Config['UploadPrefix'] = '../hrms/';
	}else{
		$RedirectURL = "viewUsers.php?curP=".$_GET['curP'];
		$Config['UploadPrefix'] = 'hrms/';
	}
	

	if(empty($_GET['tab'])) $_GET['tab']="personal";

	$EditUrl = "editUser.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];
	
	
	
	
	/*********  Multiple Actions To Perform **********/
	/*
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objEmployee->RemoveEmployee($del_id);
					}
					$_SESSION['mess_user'] = USER_REMOVED;
					break;
			case 'active':
					$objEmployee->MultipleEmployeeStatus($multiple_action_id,1);
					$_SESSION['mess_user'] = USER_STATUS_CHANGED;
					break;
			case 'inactive':
					$objEmployee->MultipleEmployeeStatus($multiple_action_id,0);
					$_SESSION['mess_user'] = USER_STATUS_CHANGED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }*/
	
	

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_user'] = USER_REMOVED;
		$objEmployee->RemoveEmployee($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_user'] = USER_STATUS_CHANGED;
		$objEmployee->changeEmployeeStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if ($_POST) {
			CleanPost();
			$_POST['catID'] = 4;
		
			 if($_POST['tab']=="image"){
				$_GET['tab'] = $_POST['tab'];
				$LastInsertId = $_GET['edit']; 
				$_POST['EmpID'] = $LastInsertId;
			 }

			 $_POST['Email'] = strtolower($_POST['Email']);

			 if (empty($_POST['Email']) && empty($_POST['EmpID'])) {
				$errMsg = ENTER_EMAIL;
			 } else {
				if (!empty($_POST['EmpID'])) {
					$LastInsertId = $_POST['EmpID'];
					/*
					$objEmployee->UpdateEmployee($_POST);
					$_SESSION['mess_user'] = USER_UPDATED;
					*/
					/***************************/
					switch($_GET['tab']){
						case 'personal':

						/*************************/
						$ValidateData = array(  
							array("name" => "EmpCode", "label" => "User Code" , "opt" => "1" ,"type" => "unique"),
							array("name" => "FirstName", "label" => "First Name" , "min" => "3")							 
						);	

						$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData); 
						if(!empty($ValidateErrorMsg)){
							$_SESSION['mess_user'] = $ValidateErrorMsg; 
							header("Location:".$ActionUrl);
							exit;
						}
						/*************************/


							$objEmployee->UpdatePersonal($_POST);
							$objUser->UpdatePersonal($_POST);
							$_SESSION['mess_user'] = PERSONAL_UPDATED;
							break;
						case 'contact':
							$objEmployee->UpdateContact($_POST);
							$_SESSION['mess_user'] = CONTACT_UPDATED;
							
							break;
											
						case 'account':
							$objEmployee->UpdateAccount($_POST);
							$objUser->UpdateAccount($_POST);
							$_SESSION['mess_user'] = ACCOUNT_UPDATED;
							break;
						case 'role':
							$_SESSION['mess_user'] = ROLE_UPDATED;
							break;
						case 'sales':
							$objEmployee->UpdateSalesCommission($_POST);	
							$_SESSION['mess_user'] = SALE_COMM_UPDATED;
							break;
						case 'territory':
							$objTerritory->UpdateTerritoryAssign($_POST);	
							$_SESSION['mess_user'] = TERRITORY_ASSIGN_UPDATED;
							break;
						case 'vendor':
							$objEmployee->UpdateRestrictedVedor($_POST);	
							$_SESSION['mess_user'] = RES_VENDOR_UPDATED;
							break;
						case 'chat': // BY Ravi
							$chatpr=array();						
							if(!empty($_POST['chatpermission']) AND is_array($_POST['chatpermission'])){
							$chatpr['permission']=serialize($_POST['chatpermission']);
							}
							$objchat->SavePermission($chatpr,$_POST['EmpID']);						
							if(!empty($_POST['chatrole'])){							
								$objchat->Savechatrole($_POST['chatrole'],$_POST['EmpID']);
							}

							$_SESSION['mess_user'] = 'Save Chat Permission';						
						break;
						/******************* Sanjiv Zoom Meeting ****************************/
						case 'zoom': // BY Sanjiv
							$zoompr=array();
							$zoompr['permission'] = '';
							if(!empty($_POST['zoompermission']) AND is_array($_POST['zoompermission'])){
								$zoompr['permission']=serialize($_POST['zoompermission']);
							}
						
							if($objMeeting->SavePermission($zoompr,$_POST['EmpID']))
							$_SESSION['mess_user'] = 'Zoom Meeting Permission is saved.';
							
							break;
					/***************************/

					}
					/***************************/
				} else {


					/*************************/
					$ValidateData = array(  
						array("name" => "EmpCode", "label" => "User Code" , "opt" => "1" ,"type" => "unique"),
						array("name" => "FirstName", "label" => "First Name" , "min" => "3"),			
						array("name" => "Email", "label" => "Email" , "type" => "email"),
						array("name" => "Password", "label" => "Password", "min" => "5"),
						array("name" => "ConfirmPassword", "label" => "Confirm Password")			
					);		

					$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);

					if(!empty($_POST['Password']) && $_POST['Password']!=$_POST['ConfirmPassword']){
						$ValidateErrorMsg .= '<br>'.CONFIRM_PASSWORD_NOT_MATCH;
					}

					if(!empty($ValidateErrorMsg)){
						$_SESSION['mess_user'] = $ValidateErrorMsg;
						$ActionUrl = 'editUser.php';			
						header("Location:".$ActionUrl);
						exit;
					}
					/*************************/


	
					if($objEmployee->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_user'] = EMAIL_ALREADY_REGISTERED;
					}else{	
						$LastInsertId = $objEmployee->AddEmployee($_POST); 


						/****** Add To User Table******/
						/*******************************/
						$_POST['UserName'] = trim($_POST['FirstName'].' '.$_POST['LastName']);
						$_POST['UserType'] = "employee";
						$UserID = $objUser->AddUser($_POST);
						$objEmployee->query("update h_employee set UserID=".$UserID." where EmpID=".$LastInsertId, 0);
						$_POST['UserID'] = $UserID;
						/*******************************/
						/*******************************/


						$_SESSION['mess_user'] = USER_ADDED;
						$_GET['tab']="role";
						$RedirectURL = "editUser.php?edit=".$LastInsertId."&tab=role";

					}
				}
				
				if($LastInsertId>0)$_POST['EmpID'] = $LastInsertId; 


				/****** Add To User Table******/
				/*******************************/
				if($_POST['UserID']>0 && $_GET['tab']=="role"){
					$objEmployee->UpdateEmpRole($_POST);
					if(empty($_POST['GroupID'])){
						$objUser->UpdateRolePermissionNew($_POST);
					}
				}
				/***********************************/

				/****** Else to Employee Table******
				if($_POST['EmpID']>0 && $_GET['tab']=="role"){
					$objEmployee->UpdateRoleModules($_POST);
				}
				/***********************************/
				

				/************************************/
				if($_FILES['Image']['name'] != ''){
					$FileInfoArray['FileType'] = "Image";
					$FileInfoArray['FileDir'] = $Config['EmployeeDir'];
					$FileInfoArray['FileID'] = $LastInsertId;
					$FileInfoArray['OldFile'] = $_POST['OldImage'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){
						$objEmployee->UpdateImage($ResponseArray['FileName'],$LastInsertId);						
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}

					 

					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_user'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_user'] .= $ErrorPrefix.$ErrorMsg;
					}

				}
				
				/************************************/

				if (!empty($_GET['edit'])) {
					header("Location:".$ActionUrl);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}


				
			}
		}
		

	if(!empty($_GET['edit'])) {
		$arryEmployee = $objEmployee->GetEmployee($_GET['edit'],'');
		$EmpID   = $_GET['edit'];	
		
		$arrySupervisor = $objEmployee->GetEmployeeBrief('');

		if(substr_count("5,6,7", $arryEmployee[0]['Division'])==0){
			$Config['SalesCommission']=0;
		}

		if($arryEmployee[0]['EmpID']<=0){
			header("Location:".$RedirectURL);
			exit;
		}


	}else{

		/*$arryNumEmp = $objEmployee->CountEmployee();
		if($arryNumEmp[0]['TotalEmployee']>=$MaxAllowedUser){
			$errMsg = LIMIT_USER_REACHED.$MaxAllowedUser;
			$HideForm = 1;
		}*/
		$arryEmployee = $objConfigure->GetDefaultArrayValue('h_employee');
	}
				
	if($arryEmployee[0]['Status'] != ''){
		$EmployeeStatus = $arryEmployee[0]['Status'];
	}else{
		$EmployeeStatus = 1;
	}				
		
	
	$arryRoleGroup = $objCommon->getAllRoleGroup();

	if($_GET['tab']=='role'){
		$SubHeading = 'Role/Permission';
	}else if($_GET['tab']=='account'){
		$SubHeading = 'Account / Login Details';
	}else if($_GET['tab']=='sales'){
		$SubHeading = 'Sales Commission';
	}else if($_GET['tab']=='territory'){
		$SubHeading = 'Territory';	
	}else if($_GET['tab']=='vendor'){
		$SubHeading = 'Restricted Vendor';
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Details";
	}
?>

<script language="JavaScript1.2" type="text/javascript">
 function EmployeeShow(){		
	if(document.getElementById('ExistingEmployee').value == 0){
		$('#EmpDiv').hide();
	}else{
		$('#EmpDiv').show();
		
	}
}


function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=false;
	}
}

function SelectDeselect(AllCheck,InnerCheck)
{	
	var Checked = false;
	if(document.getElementById(AllCheck).checked){
		Checked = true;
	}
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById(InnerCheck+i).checked=Checked;
	}

}


function ShowOther(FieldId){
	if(document.getElementById(FieldId).value=='Other'){
		document.getElementById(FieldId+'Span').style.display = 'inline'; 
	}else{
		document.getElementById(FieldId+'Span').style.display = 'none'; 
	}
}



function ShowPermission(){
	if(document.getElementById("Role").value=='Admin'){
		document.getElementById('PermissionTitle').style.display = 'block'; 
		document.getElementById('PermissionValueNew').style.display = 'block'; 
	}else{
		document.getElementById('PermissionTitle').style.display = 'none'; 
		document.getElementById('PermissionValueNew').style.display = 'none'; 
	}
}
</script>


<a href="<?=$RedirectURL?>" class="back">Back</a>






<div class="had">
<?=$MainModuleName?>   <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$SubHeading) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  


	if(!empty($_GET['edit'])) {	
		if($_GET["tab"]=="sales"){
			include($MainPrefix."includes/html/box/commission_form.php");
		}else if($_GET["tab"]=="territory"){
			include($MainPrefix."includes/html/box/territory_form.php");
		}else if($_GET["tab"]=="vendor"){
			include($MainPrefix."includes/html/box/vendor_form.php");
		}else{
			include($MainPrefix."includes/html/box/user_edit.php");	
		}
			
		 
	}else{
		if($HideForm!=1){ 
			include($MainPrefix."includes/html/box/user_form.php");
		}
	}



?>
	










