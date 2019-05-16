<?php 
	include_once("includes/header.php");
    require_once("../classes/dbfunction.class.php");
	$ModuleName = "Company";
	
	$dbFunction = new dbFunction();
	
	if(!empty($_REQUEST['del_id'])){
	  $objphone->DeleteServer($_REQUEST['del_id']);
	  header('Location: zoomMeetingSetup.php');
	  exit;
	}
	
	$sql = "select * from settings where Module = 'Zoom' and Status =1";
	$zoom = $objConfig->query($sql,1);
	
	if($_POST){
		$array = array();
		foreach($zoom as $field => $val) {
			$val1 = (isset($_POST[$val['S_Key']])) ? $_POST[$val['S_Key']] : 0;
			if($val['S_Key']!='webinar_company_list'){
				$update = "UPDATE settings SET S_Value='".$val1."' WHERE S_Key ='".$val['S_Key']."' ";
				$objConfig->query($update);
			}
		}
		$_SESSION['mess_server'] = 'Successfully updated!';
		header('Location: zoomMeetingSetup.php');
		exit;
	}
	
	$zoomArr = array();
	foreach ($zoom as $field => $val){
		$zoomArr[$val['S_Key']] = $val['S_Value'];
	}

	if($zoomArr['webinar_company_list']>0){
	$sql2 = "SELECT CompanyName FROM `company` where CmpID IN (".$zoomArr['webinar_company_list'].") ";
	$zwebinarlist = $objConfig->query($sql2,1);
	$zoomArr['webinar_company_list'] = explode(",", $zoomArr['webinar_company_list']);
	}
	
	require_once("includes/footer.php"); 

?>


