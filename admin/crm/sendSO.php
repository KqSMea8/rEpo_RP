<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewQuote.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/quote.class.php");
        require_once($Prefix."classes/email.class.php");

 	/**********added by sanjiv *********************/    
    	require_once($Prefix."classes/sales.customer.class.php");
    	require_once($Prefix."classes/lead.class.php"); 
	$objCustomer=new Customer(); 
	$objLead=new lead(); 
	/********** end *********************/

	$objQuote=new quote();
	$ModuleDepName = "Quote";
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	$ModuleName = "Sales ".$_GET['module'];

	$RedirectURL = "viewQuote.php?module=".$module."&curP=".$_GET['curP'];

	if($_GET['module']=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "quoteid"; $PrefixPO = "QT";  $NotExist = NOT_EXIST_QUOTE;  $MailSend = SO_QUOTE_SEND;
	}else{
		$ModuleIDTitle = "Sales Order Number"; $ModuleID = "SaleID"; $PrefixPO = "PO";  $NotExist = NOT_EXIST_ORDER; $MailSend = SO_ORDER_SEND;
	}

     if(!empty($_GET['view'])){
		$arrySale = $objQuote->GetQuote($_GET['view'],'','');
		
		$quoteid   = $arrySale[0]['quoteid'];	
		if($quoteid>0){
			//$arrySaleItem = $objQuote->GetQuoteItem($quoteid);
			//$NumLine = sizeof($arrySaleItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}   
        
	
	if(!empty($_POST["ToEmail"]) && !empty($_GET["view"])){
            
              
            
                $objConfigure=new configure();
                
                if($_SESSION['AdminType']!='admin')
                {
                    $_POST["OwnerEmailId"]=$_SESSION['EmpEmail'];
                }
                else{
                   $_POST["OwnerEmailId"]=$_SESSION['AdminEmail'];  
                }
                
                $newDefaultEmail=$objConfigure->GetEmailListId($_SESSION[AdminID],$_SESSION[CmpID]);
		
                // default email id is changed for sending email(from)
                if(!empty($newDefaultEmail[0][EmailId])) $Config[AdminEmail]= $newDefaultEmail[0][EmailId];
     
                $_POST['quoteid'] = $_GET["view"];
		/***********/
		$AttachFlag = 1; $_GET['o'] = $_GET["view"];
		//include_once("pdfQuote.php");
		//$_POST['Attachment'] = $file_path;
                $PdfFolder = $Config['C_Quote'];
		$PdfDir = $Config['FilePreviewDir'].$PdfFolder;
		//$file_path= $PdfDir.$_GET["view"].'.pdf';

		//updated for dynamic template attachment in mail on 23Mar2018 by chetan//	
		if(isset($_POST['tempidd']) && $_POST['tempidd']!=''){
			$file_name = $ModuleDepName.'-'.stripslashes($arrySale[0][$ModuleID]).'-temp'.$_POST['tempidd'].'.pdf';
			$file_path = $PdfDir.$file_name;
			$ConvetFilename = $ModuleDepName . '-' . stripslashes($arrySale[0][$ModuleID]) . '-temp'.$_POST['tempidd']. $time . '.pdf';
		}else{
			$file_name = $ModuleDepName.'-'.stripslashes($arrySale[0][$ModuleID]).'.pdf'; 
			$file_path = $PdfDir.$file_name;
			$ConvetFilename = $ModuleDepName . '-' . stripslashes($arrySale[0][$ModuleID]) . '' . $time . '.pdf';
		}
	  	//End//


		if($Config['ObjectStorage']=="1"){

			copy($Config['OsUploadUrl'].$Config['OsDir']."/".$PdfFolder.$file_name, $file_path);
		}	



		  $_POST['Attachment'] = $file_path;
                //echo $_POST['Attachment'];die;
		/***********/
		$MainDir = "upload/temp/";		
		$documentDestination = $MainDir.$_FILES['document']['name'];				
		if(@move_uploaded_file($_FILES['document']['tmp_name'], $documentDestination)){
			$_POST['AttachDocument'] = $documentDestination;
		}
                
                
                $countarray = count($_FILES['documentss']['name']);
                for($i=0;$i<$countarray;$i++){
                    
                    if(!empty($_FILES['documentss']['name'][$i]))
                    {
                        $documentDestination1 = $MainDir.$_FILES['documentss']['name'][$i];				
                        if(@move_uploaded_file($_FILES['documentss']['tmp_name'][$i], $documentDestination1)){
                                $_POST['AttachDocument1'][$i] = $documentDestination1;
                        }
                        
                    }
                }
                  
                $countDocarray=count($_POST['fromDocument']);
                for($j=0;$j<$countDocarray;$j++){
                    
                    if(!empty($_POST['fromDocument'][$j]))
                    { 
                                $_POST['AttachDocument2'][$j] = $_POST['fromDocument'][$j];  
                    }
                }
                
               
			
		$objQuote->sendOrderToCustomer($_POST);
		if($Config['ObjectStorage']=="1"){
			unlink($file_path);
		}
		$_SESSION['mess_quote'] = $MailSend;	
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;				
	}


	
				
	if(!isset($_GET['newEmail']))
	$arryCustomer = $objQuote->GetLeadCustomer('');
	
	
    /* added by saiyed on 8May2018    * **start code for get tempalte name for dynamic pdf by sachin** */
	$_GET['ModuleName'] = $ModuleDepName;
	$_GET['Module'] = $ModuleDepName;
	$_GET['ModuleId'] = $_GET['view'];
	$GetPFdTempalteNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	$_GET['setDefautTem']='1';
	$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);
    /*     * **end code for get tempalte name for dynamic pdf by sachin** */


	require_once("../includes/footer.php"); 	 
?>


