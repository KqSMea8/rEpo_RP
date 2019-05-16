<?
	/********* Lead Detail **************/
	/*************************************/
require_once("../includes/pdf_comman.php");
	

		require_once($Prefix."classes/lead.class.php");
		require_once($Prefix . "classes/group.class.php");
	require_once($Prefix."classes/sales.customer.class.php");


		$objLead=new lead();
		$objGroup = new group();
		
		$objCustomer=new  Customer();

if(!empty($_GET['view'])){
	$arryCustomer = $objCustomer->getCustomerById($_GET['view']);
}

if(empty($arryCustomer[0]['Cid'])){
	echo '<div class="message">Error : Invalid Request !</div>';
	exit;
}
	
		//$arryCustomer = $objCustomer->GetCustomer($arryDocument[0]['Cid'],'','');
	
	//echo "<pre>";print_r($arryCustomer);exit;
	
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	
	$AssignType = (!empty($arryCustomer[0]['AssignType']))?($arryCustomer[0]['AssignType']):('');

	$salesPerson="";
			if($AssignType=="User")
			{
				$arryAssignee = $objLead->GetAssigneeUser($arryCustomer[0]['AssignTo']);
	
			  
                                                    foreach ($arryAssignee as $key => $values)
                                                    { 
                                                   
                                                  
                                                    $salesPerson .= $values['UserName']. ", ";
                                                        
                                                    }
                                    
				$arryDef[$i][$Head5] =$salesPerson;
				
			}
			else if($AssignType=='Group')
                                           {
                                       

                                            $arryGrp = $objGroup->getGroup($arryCustomer[0]['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];
                                               $salesPerson=$AssignName;
		}
			else 
			{
			$salesPerson= stripslashes($arryCustomer[0]["CustomerName"]);
			}
	
		if(!empty($arryCustomer[0]['Status']))
		{
		$Status="Active";	
		}
		else 
		{
		$Status="Inactive";	
		}
	
	
	 $Title ="Customer # ".$arryCustomer[0]['CustomerName'];
	 HeaderTextBox($pdf,$Title,$arryCompany);
	
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => "Customer Code:", $Head2 => $arryCustomer[0]['CustCode']),
		array($Head1 => "Company:", $Head2 =>$arryCustomer[0]['Company']),
		array($Head1 => "Customer Type :", $Head2 => $arryCustomer[0]['CustomerType']),
		array($Head1 => "First Name:", $Head2 => $arryCustomer[0]['FirstName']),
		array($Head1 => "Last Name :", $Head2 =>$arryCustomer[0]['LastName']),
		array($Head1 => "Gender:", $Head2 => $arryCustomer[0]['Gender']),
		
		
		array($Head1 => "Email:", $Head2 => $arryCustomer[0]['Email']),
		array($Head1 => "Mobile :", $Head2 => $arryCustomer[0]['Mobile']),
		array($Head1 => "Landline :", $Head2 => $arryCustomer[0]['Landline']),
		
		array($Head1 => "Website:", $Head2 => $arryCustomer[0]['Website']),
		array($Head1 => "Customer Sinc:", $Head2 =>$arryCustomer[0]['CustomerSince']),
		array($Head1 => "Payment Term:", $Head2 => $arryCustomer[0]['PaymentTerm']),
	
		
		array($Head1 => "Payment Method:", $Head2 => $arryCustomer[0]['PaymentMethod']),
		array($Head1 => "Shipping Method:", $Head2 =>$arryCustomer[0]['ShippingMethod']),
		array($Head1 => "Taxable:", $Head2 => $arryCustomer[0]['Taxable']),
	
	
		array($Head1 => "Status :", $Head2 =>$Status),
		
		
		
		
		
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'120')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	
	
	$file_path = 'upload/pdf/'.$arryCustomer[0]['Cid'].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	if(empty($AttachFlag))
	{
		header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
		exit;
	}

?>


