<?php
include_once("../includes/settings.php");
$Config['vAllRecord'] = $_SESSION['vAllRecord'];
require_once($Prefix."classes/custom_reports.class.php");
require_once($Prefix . "classes/field.class.php");
include_once("includes/FieldArray.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/sales.customer.class.php");
require_once($Prefix.  "classes/item.class.php");
require_once($Prefix . "classes/region.class.php");

$objLead = new lead();
$objCustomer = new Customer();
$objItems = new items();
$objregion  = new region(); 
$objcusreport = new customreports();
$GLOBALS['useMainDB'] = $Config;

if (!empty($_SESSION['post']) && $_GET['editID']==''){
	$num ='1';
	$arrycusreport = $objcusreport->generateReportData($_SESSION['post']);
  	
}else{

	$fetchRes = $objcusreport->GetReportLists($_GET['editID']);
	$num = $objcusreport->numRows();
	
        $fetchRes = $objcusreport->setFormat($fetchRes[0]);
	$arrycusreport = $objcusreport->generateReportData($fetchRes);
 	
}

if($_GET['flage']==1)
{
$filename = "CustomReport_".date('d-m-Y').".xls";	
$contanttype="application/vnd.ms-excel";
$del="\t";
$delm="\t"; 
}
else if($_GET['flage']==2)
{
	$filename = "CustomReport_".date('d-m-Y').".csv";
	$contanttype="text/csv; charset=utf-8'";
	$del=",";
	$delm=","; 
}

if($num>0)
{
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: $contanttype");
	header('Content-Disposition: attachment; filename="' . $filename .'"');
        //********************************** Statically defined **********************************/;
   
	$header = implode($arrycusreport['colLabel'], $delm);
	
         $assigneeName='';
        
        $data = '';
        
	foreach($arrycusreport['res'] as $key=>$value){
		
		 
           $j=0;    foreach($arrycusreport['colName'] as $colname){
		
			if($colname == 'AssignTo' || $colname == 'AssignedTo'  || $colname == 'assignedTo') { 
            
                       if($value['AssignType']!='Group')
                       {
                            $assignee = $objLead->GetAssigneeUser($value[$colname]);

			   if(!empty($assignee)){
				$assigneeName = implode(array_map(function($arr){
				    return $arr['UserName'];

				},$assignee),',');
			  }


				 
                       }else{
                           $val = ($value['GroupID'] == '1') ? 'General' : 'Marketing';
                       }                
                $val =  $assigneeName;
        }elseif($colname == 'CustID'){
            
                $customer = $objCustomer->getCustomerById($value[$colname]);
                $val =  (!empty($customer[0]['FullName']))?($customer[0]['FullName']):('');
                
        
        }elseif($colname == 'Status'){        
                
                if($value[$colname] == 1 || $value[$colname] == 'Yes' ){ $val =  "Active";}elseif($value[$colname] == 0 || $value[$colname] == 'No' ){$val =  "Inactive";}else{$val =  $value[$colname];}
        }elseif($colname == 'product'){
            
                $arryProduct=$objItems->GetItems($value[$colname],'',1);
                $val =  (!empty($arryProduct[0]['Sku']))?($arryProduct[0]['Sku']):(''); 
                
        }elseif($colname == 'country_id'){
        			/********Connecting to main database*********/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
        	
        	   $arrycountry = $objregion->GetCountryName($value[$colname]);
        	   $val =  (!empty($arrycountry[0]['name']))?($arrycountry[0]['name']):(''); 
        	   /********Connecting to Company database*********/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();

	}elseif($colname == 'state_id'){
        			/********Connecting to main database*********/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
        	
        	   $arrystate = $objregion->getStateName($value[$colname]);
        	   $val =  (!empty($arrystate[0]['name']))?($arrystate[0]['name']):(''); 
        	   /********Connecting to Company database*********/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				
	}elseif($colname == 'city_id'){
        			/********Connecting to main database*********/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
        	
        	   $arrycity = $objregion->getCityName($value[$colname]);
        	   $val =  (!empty($arrycity[0]['name']))?($arrycity[0]['name']):('');
        	   /********Connecting to Company database*********/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
	}elseif($colname == 'CustType' &&  $arrycusreport['post']['moduleID'] == '108' ){ 	
			if($value['CustType'] == 'c'){ 
				 $val =  "Customer" ;
			}elseif ($value['CustType'] == 'o'){
				 $val =  "Opportunity" ;
			}else{
				$val = "";
			}				

	}elseif($arrycusreport['type'][$j] =='date'){
		      
		  $val = (($value[$colname] > 0)? date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($value[$colname])) : '' ); 
		 
        }else{                 
                $val =  $value[$colname];
        }  $j++;        	

		$val = str_replace('\r\n',"\n", $val);
		$val = ($val) ? $val : 'N/A';
                $line .= "\"".stripslashes(strip_tags($val))."\"".$delm;
                
               }
                $Line =    $line."\n";
				$data .=    trim($Line)."\n";
				$line ='';
	}

	$data = str_replace("\r","",$data);
    
	echo "Report Name".$delm.stripcslashes($arrycusreport['post']['report_name'])."\nReport Desc".$delm.stripcslashes($arrycusreport['post']['report_desc'])."\n";
	
	print "$header\n$data"; 
	
}
?>	
	



	
