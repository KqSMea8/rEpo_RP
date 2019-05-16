<?php 
$lis=$objchat->getChatLicence($_SESSION['CmpID']);
if($_SESSION['AdminType']=='admin' && empty($_GET['empid'])){
	/*************************/
$arryEmployee=array();
if(!empty($lis)){
	$teamlist=$objchat->chatCurl('api/getemplist',array('lis'=>$lis));	
	if(!empty($teamlist)){
	$teamlist=json_decode($teamlist);	
	
if(array_search('admin-'.$_SESSION['AdminID'],$teamlist->emplist)!==false){
	
$k =	array_search('admin-'.$_SESSION['AdminID'],$teamlist->emplist);
unset($teamlist->emplist[$k]);
}
		if(!empty($teamlist->emplist)){
			$arryEmployee=$objphone->GetEmployeeListByIds($_GET,$teamlist->emplist,'');
		
			$num=$objphone->numRows();
		
			$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
			(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
		}
	}
}
		/*************************/			
			require_once(_ROOT.'/admin/crm/includes/html/box/chat_support.php');
	}else{
		if(!empty($_GET['empid']) && $_SESSION['AdminType']=='admin')
			$empid=$_GET['empid'];
		else if($_SESSION['AdminType']=='employee')
			$empid=$_SESSION['AdminID'];
	
		if(!empty($empid) && !empty($lis)){
			$server_output=$objchat->chatCurl('api/talklist',array('empid'=>$empid,'lis'=>$lis));
			
		}
		$responce=array();
		if(!empty($server_output)){
		$responce=json_decode($server_output);
		}
		$responce->talkslist;
		require_once(_ROOT.'/admin/crm/includes/html/box/chat_list.php');
		
	}
?>

