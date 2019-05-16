<?

    $ShowBlock=0; $BlockPrefix=''; 
    switch($valueBlock['BlockID']){
	case '1': //home_lead_b.php 
		if(in_array('102',$arryMainMenu)){
			$ShowBlock=1; 
		}
		break; 

	/*case '2': //home_call_quota_b.php 
		if(in_array('176',$arryMainMenu)){
			if($_SESSION['AdminType'] != "admin"){	
				$callFlag=1; $ShowBlock=1;
			}
		}
		break;*/
	case '3':  //home_ticket_open_b.php
		if(in_array('104',$arryMainMenu) && $_SESSION['AdminType'] == "admin"){
		 	$ShowBlock=1;
	        }
		break;

	case '4': //commission_dashboard_b.php
		if($_SESSION['AdminType'] != "admin"){ 
			if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],7)==1){
				$CommFlag=1;
				$BlockPrefix = '../';
				$ShowBlock=1;				
			}
		}
		break; 

	case '5': //home_task_chart_b.php 
		if(in_array('136',$arryMainMenu) && $_SESSION['AdminType'] == "admin"){
			$ShowBlock=1;
		}
		break; 

	case '6': //home_opp_b.php 
		if(in_array('103',$arryMainMenu)){
			$ShowBlock=1; 
		}
		break; 
	case '7': //home_task_b.php
		if(in_array('136',$arryMainMenu)){
			$ShowBlock=1; 
		}
		break; 

	case '8': //home_comm_report_b.php	
		
	    if($_SESSION['AdminType'] != "admin"){ 
		if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],7)==1){		  
			$SalesReportFlag=1;
			$ShowBlock=1; 
		}
	     }
	      break; 

	case '9': //home_ticket_priority_b.php
		if(in_array('104',$arryMainMenu)){
			$ShowBlock=1; 
		}
		break; 

	case '10': //home_created_quote_b.php
		if(in_array('108',$arryMainMenu)){
			$ShowBlock=1; 
		}
		break; 
	case '11': //home_campaign_b.php
		if(in_array('106',$arryMainMenu)){
			$ShowBlock=1; 
		}
		break; 

	case '12': //home_quote_b.php
		if(in_array('108',$arryMainMenu)){
			$ShowBlock=1; 
		}
		break; 
	case '13': //home_sales_comm_chart_admin_b.php
		if(sizeof($arryMainMenu)>=13){
			$ShowBlock=1; 
		}

	case '14': //home_call_quota_admin_b.php
		if(in_array('176',$arryMainMenu)){ 
			if(sizeof($arryMainMenu)>=12){
			//if(in_array('176',$arryMainMenu)){ 
				$ShowBlock=1;  
			}
		}
break; 
	case '15': //home_clock_b.php
		$ShowBlock=1; 
		break; 

	case '16': //home_calendar_b.php
		if(in_array('136',$arryMainMenu)){
			$ShowBlock=1; 
		}
		break; 	

	case '17': //home_email_b.php
		if(in_array('2025',$arryMainMenu)){
			$ShowBlock=1; 
		}
		break; 	

	
    }
?>
