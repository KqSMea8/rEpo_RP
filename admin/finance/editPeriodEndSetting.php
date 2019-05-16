<?php
	/**************************************************/
	$ThisPageName = 'periodEndSetting.php'; $EditPage = 1; $HideNavigation = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.report.class.php");
	
        $objReport = new report();
        
            
		$PeriodID = isset($_GET['edit'])?$_GET['edit']:"";	
		$ListUrl = "periodEndSetting.php?curP=".$_GET['curP'];
		$ModuleName = "Period";
		
               
                
		if(!empty($PeriodID)){
                    $_GET['PeriodID'] = $PeriodID;
		   $arryPeriodFields = $objReport->getPeriodFields($_GET);
		  
		}
                
            

		if(!empty($_GET['del_id'])){
			$_SESSION['mess_setting'] = $ModuleName.REMOVED;
			$objReport->RemovePeriodField($_GET['del_id']);
			echo '<script>window.parent.location.href="'.$ListUrl.'";</script>';
			//header("location:".$ListUrl);
			exit;
		}
     
		if(!empty($_POST['active_id'])){
			    CleanPost();
			$_SESSION['mess_setting'] = PERIOD_STATUS_CHANGED;
			$objReport->changePeriodFieldStatus($_POST);
			echo '<script>window.parent.location.href="'.$ListUrl.'";</script>';
			//header("location:".$ListUrl);
			exit;
		}
	
		
    
   require_once("../includes/footer.php"); 
 
 
 ?>
