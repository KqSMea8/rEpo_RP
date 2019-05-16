<?php 

    /**************************************************/
    $ThisPageName = 'upgradePackages.php'; $EditPage = 1; 
    /**************************************************/
    
	include_once("includes/header.php");
	include ('includes/function.php');
	require_once("../../classes/company.class.php");
	require_once("../../classes/user.class.php");
	$objCompany=new company();

	$objUser=new user();
	/****************************/
	function time_diff_total($s){
		$m=0;$hr=0;$d=0; $td=$s." sec";

		if($s>59) {
			$m = (int)($s/60);
			$s = $s-($m*60); // sec left over
			$td = "$m min";
		}
		if($m>59){
			$hr = (int)($m/60);
			$m = $m-($hr*60); // min left over
			$td = "$hr hr"; if($hr>1) $td .= "s";
			if($m>0) $td .= ", $m min";
		}
		if($hr>23){
			$d = (int)($hr/24);
			$hr = $hr-($d*24); // hr left over
			//$td = "$d day"; 
			if($d>1) $td .= "s";
			if($d<3){
				//if($hr>0) $td .= ", $hr hr"; if($hr>1) $td .= "s";
			}
		}

		//if($s>0) $td .=  " $s sec";

		return $td;
	} 
	/****************************/


	if($_GET['cmp']>0){
		$arryCompany = $objCompany->GetCompany($_GET['cmp'],'');
		$CmpID   = $arryCompany[0]['CmpID'];
		$RedirectUrl = 'viewPackageLog.php?cmp='.$CmpID.'&curP='.$_GET['curP'].'&mode='.$_GET['mode'];	
		if($CmpID>0){
			/********Connecting to main database*********/
			$CmpDatabase = $Config['DbName']."_".$arryCompany[0]['DisplayName'];
			$Config['DbName2'] = $CmpDatabase;
			if(!$objConfig->connect_check()){
				$ErrorMsg = ERROR_NO_DB;
			}else{
				$Config['DbName'] = $CmpDatabase;
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
			
				/*******************************************/			
				if(sizeof($_POST['loginID'])>0){
					$loginIDs = implode(",",$_POST['loginID']);
					$_SESSION['mess_log'] = USER_KICKED;
					$objUser->KickUser($loginIDs);
					header("location:".$RedirectUrl);
					exit;
				}
				/*******************************************/		
				$arryUserLog=$objUser->GetUserLog($_GET);
				$num=$objUser->numRows();
				$RecordsPerPage = 100;
				$pagerLink=$objPager->getPager($arryUserLog,$RecordsPerPage,$_GET['curP']);
				(count($arryUserLog)>0)?($arryUserLog=$objPager->getPageRecords()):("");

			}			
		}
	}

	
	$viewAll = 'viewPackageLog.php?cmp='.$CmpID.'&curP='.$_GET['curP'];
	require_once("includes/footer.php"); 	 
?>


