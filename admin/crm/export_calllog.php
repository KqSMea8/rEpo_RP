<?php  	
	include_once("../includes/settings.php");
	
   require_once($Prefix."classes/employee.class.php"); 
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objEmployee=new employee();
	$objphone=new phone();
	$getcallsetting=$objphone->GetcallSetting();
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	$server_data=$objphone->getServerUrl($getcallsetting[0]->server_id);
	$server_id	= $getcallsetting[0]->server_id;
	$objphone->server_id	= $server_data[0]->server_ip;
	$Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	$agents=$empDetailByid=$saveagents=$AgentByEmp=$empByAgent=$AnameByAid=$allagentdata=$allemployeedata=$allcalldetail=$empQuota=array();
	$agents=$objphone->api('acl_extention.php',array());	
	$saveagents=$objphone->getCallRegiUserid($server_id,true);	
	//$saveemp=$objphone->getCallRegiUserid($server_id);	
	$regisData=$objphone->getCallRegisData($server_id);
	$saveemp=array();

	$showadmin=0;  // for show admin in select box
	if(!empty($regisData)){
		foreach($regisData as $regisDat){
			if($regisDat->type=='employee'){
					$saveemp[]	= $regisDat->user_id;
				$AgentByEmp[$regisDat->user_id]=$regisDat->agent_id;
				$empByAgent[$regisDat->agent_id]=$regisDat->user_id;
			}elseif($regisDat->type=='admin'){
				$showadmin=1;
				$AgentByEmp['admin-'.$regisDat->user_id]=$regisDat->agent_id;
				$empByAgent[$regisDat->agent_id]='admin-'.$regisDat->user_id;
			}			
		}
	}
	
	/************************* Start Get Employee****************************/
	  $_GET['Status']=1; 
	  $arryEmployee =  $objphone->GetEmployeeListByIds($_GET,$saveemp);	
	  $num6         =	$objphone->numRows();
	  $arryAdmin=array();
	  if($_SESSION['AdminType'] == "admin" AND !empty($showadmin)){
		$empid=$_GET['empId'];		
	 		$arryAdmin['EmpID']='admin-'.$_SESSION['AdminID'];
			$arryAdmin['EmpCode']='admin';
			$arryAdmin['UserName']=$_SESSION['DisplayName'];
			$arryAdmin['Email']=$_SESSION['Email'];
			$arryAdmin['JobTitle']='admin';
			$arryAdmin['Department']='admin';			
			if(!empty($arryAdmin)){		
				array_unshift($arryEmployee,$arryAdmin);
				$num6=$num6+1;
			}
		}	
		if(!empty($arryEmployee)){
		foreach($arryEmployee as $emp){
			$empDetailByid[$emp['EmpID']]=$emp['UserName'];		
		}
		
		}
	 /************************* End ****************************/
	  
	  
	/************************* Start Get Agent****************************/
	if(!empty($agents)){
		foreach($agents as $agen){	
			$AnameByAid[$agen[0]]=$agen[1];
			$allagentdata[$agen[0]]=$agen;
		}	
	}
	 /************************* End ****************************/	
	//$extesion=!empty($_GET['uid'])?$_GET['uid']:0;		
	$url='acl_cdr.php?1=1';
	$paramFiltro=array();
	 		
	if(!empty($_GET['from'])){
         $url .= '&date_start='.date('Y-m-d',strtotime($_GET['from']));
	}
	if(!empty($_GET['to'])){
	      $url .= '&date_end='.date('Y-m-d',strtotime($_GET['to']));
	}
	

	//if(!empty($extesion))
	// $url .= '&extension='.$extesion;
		//$paramFiltro['extension']=$extesion;	
	//echo urlencode($url);
	//	$allcalldetailBond=$objphone->api($url);
		
	if(!empty($_GET['empId'])){
		
		$extensions =  $objphone->getEmpExtenstion(base64_decode($_GET['empId']));
		
		
		$results =  array();
		$extension_array = array();
		foreach($extensions as $ext){
			
			 $extension_array[] = $ext->agent_id;
			 $url .= '&extension='.$ext->agent_id;
			 $allcalldetailBond=$objphone->api($url);
				if(count($allcalldetailBond)>0){
				 $total = $total+ $allcalldetailBond->total;	
				 $results = array_merge($results, $allcalldetailBond->cdrs);
				
				 } 
		}	
		
	}	
		
		
		
		
		
		$empQuota =	$objphone->getEmpQuota($server_id,$empid);	
$filename = "Call_Log_".date('d-m-Y').".xls";
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "Date\tTime\tCall Duration\tCall Type\tFrom\tSource\tStatus";

	$data = '';
if (count($results)>0) {
                            $flag = true;
                            $Line = 0;
                            $i=0;
                            foreach ($results as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                               
                                if(in_array($values[1],$extension_array) OR in_array($values[2],$extension_array)){
								if(in_array($values[1],$extension_array) && in_array($values[2],$extension_array)){
									$from =$values[1];
									$bond='Self';
									$source=$values[1].'-->'.$values[2];
								}	
                                elseif(in_array($values[1],$extension_array)){
                                $from=$values[1];
                                $bond='Outgoing';
                                $source=$values[2];
                                }
                                elseif(in_array($values[2],$extension_array)){
                                $bond='Incoming';
                                $source=$values[1];
                                 $from=$values[2];
                                }else {
                                 $bond='--';
                                 $source='--';
                                }
                            	$min = gmdate("i",  $values[7]); 
                                $sec = gmdate("s",  $values[7]);   
                                $du='';
                                if(!empty($min) AND $min!='00')
                                  $du .=$min.' min ';
                                  $du .= $sec .' sec';                                 
                            	 
		 
		$line = date('m-d-Y',strtotime($values[0]))."\t". date('H:i:s',strtotime($values[0]))."\t".$du."\t".$bond."\t".$empDetailByid[$empByAgent[$from]]."\t".$source."\t".$values[5]."\n";

		$data .= trim($line)."\n";
	  $i++;} }

	$data = str_replace("\r","",$data);

	print "$header\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

