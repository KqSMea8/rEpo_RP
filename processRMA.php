<?php    
	ini_set("display_errors","1"); error_reporting(5);	
	require_once("includes/config.php");	
	require_once("classes/dbClass.php");
        require_once("includes/function.php");
	require_once("classes/MyMailer.php");	
	require_once("classes/admin.class.php");	
	require_once("classes/company.class.php");
        require_once("classes/configure.class.php");
	require_once("classes/rma.sales.class.php");

        require_once("admin/language/english.php");
        
	$objConfig=new admin();	
        
        #$_POST['Cmp'] = 'a5bfc9e07964f8dddeb95fc584cd965d';
  
	if(!empty($_POST['Cmp'])) {  
            $RefererUrl = $_SERVER['HTTP_REFERER'];
            $arryCompany = $objConfig->GetCompanyBySecuredID($_POST['Cmp']);
            if(empty($arryCompany[0]['DisplayName'])){           
                $ErrorMsg =  ERROR_NO_DB;
            }else{
                
                $CmpDatabase = $Config['DbMain']."_".$arryCompany[0]['DisplayName'];
                $Config['DbName2'] = $CmpDatabase;
                if(!$objConfig->connect_check()){
                        $ErrorMsg = ERROR_NO_DB;
                }else {				
                        $Config['DbName'] = $CmpDatabase;
                        $objConfig->dbName = $Config['DbName'];
                        $objConfig->connect();
                        
                }
                               
                
                
		
            }
          
            if(!empty($ErrorMsg)){
                echo $ErrorMsg; exit;
            }else{  



/*$arryItem = $objRmasale->GetSaleItem($OrderID);

$arryDetails['serial_value'.$i]
$arryDetails['Action'.$i]
$arryDetails['Reason'.$i]
$arryDetails['Type'.$i]
$arryDetails['qty'.$i]
$arryDetails['discount'.$i]
$arryDetails['Condition'.$i]
$arryDetails['amount'.$i]
$arryDetails['price'.$i]

*/

 $objRmasale = new rmasale(); 
$InvoiceID = $_POST['InvoceID'];
$Module = 'Invoice';

$arryInvoice = $objRmasale->GetInvoice('',$InvoiceID,$Module);
$_POST['ReturnOrderID']=$arryInvoice[0]['OrderID'];
                           
                $Config['SiteName']  = stripslashes($arryCompany[0]['CompanyName']);	
		$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
		$Config['AdminEmail'] = $arryCompany[0]['Email'];			
		$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';

		$Config['CmpDepartment'] = $arryCompany[0]['Department'];		
		$Config['DateFormat'] = $arryCompany[0]['DateFormat'];
		$Config['TodayDate'] = getLocalTime($arryCompany[0]['Timezone']); 
                $Config['EmailTemplateFolder'] = 'admin/'.$Config['EmailTemplateFolder'];
                
                
                
             	 CleanPost($_POST); 
         $RmaID = $objRmasale->ReturnOrderByForm($_POST);    
                if($RmaID>0){
                    echo "<script>
                        alert('Thanx for submitting your RMA. We will get back to you soon.');
                        location.href='".$RefererUrl."';
                        </script>";
                }
            }
        } 



?>


