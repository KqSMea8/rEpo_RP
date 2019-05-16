<?php
/**************************************************/
           $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/finance.report.class.php");
	
	$objCommon = new common();
        $objReport = new report();
	
          $depID = 8;
          $ModuleName = 'Period End Setting';
          $ListUrl = "periodEndSetting.php";
        
         /* echo "<pre>";
          print_r($_POST);
          exit;*/
          
          //GET CURRENT PERIOD
          
          $ARCurrentPeriod =  $objReport->getCurrentPeriod('AR'); 
          $APCurrentPeriod =  $objReport->getCurrentPeriod('AP'); 
          $GLCurrentPeriod =  $objReport->getCurrentPeriod('GL');
          $IECurrentPeriod =  $objReport->getCurrentPeriod('IE'); 
          //END
        
            if (is_object($objReport)) {	

                     if(!empty($_POST)){
                                  /******************************/
				 CleanPost();
			        /******************************/
                                $objReport->AddUpdatePeriodSetting($_POST);
                                $_SESSION['mess_setting'] = $ModuleName.$MSG[102];
                                header("location:".$ListUrl);
                                exit;
                               
                    }	
            }
            
           /***************************************************************************/ 
           $arryPeriodFields = $objReport->getPeriodFields($depID,$group_id=2);   
           $num=$objReport->numRows();

	 $pagerLink=$objPager->getPager($arryPeriodFields,$RecordsPerPage,$_GET['curP']);
	 (count($arryPeriodFields)>0)?($arryPeriodFields=$objPager->getPageRecords()):("");


 require_once("../includes/footer.php"); 
 
 
 ?>
