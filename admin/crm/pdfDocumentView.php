<?
	/********* Lead Detail **************/
	/*************************************/
require_once("../includes/pdf_comman.php");
	

		require_once($Prefix."classes/lead.class.php");
		require_once($Prefix . "classes/group.class.php");
require_once($Prefix . "classes/filter.class.php");
 require_once($Prefix."classes/sales.customer.class.php");


		$objLead=new lead();
		$objGroup = new group();
		
		$objCustomer=new  Customer();

$arryDocument = $objLead->GetDocument($_GET['documentID'],'');
//echo "<pre>";print_r($arryDocument);exit;

if(!empty($arryDocument[0]['CustID']))
	{
		$arryCustomer = $objCustomer->GetCustomer($arryDocument[0]['CustID'],'','');
	}
	//echo "<pre>";print_r($arryCustomer);exit;
	
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	
	
	$salesPerson="";
			if($arryDocument[0]['AssignType']=="User")
			{
				$arryAssignee = $objLead->GetAssigneeUser($arryDocument[0]['AssignTo']);
	
			  
                                                    foreach ($arryAssignee as $key => $values)
                                                    { 
                                                   
                                                  
                                                    $salesPerson .= $values['UserName']. ", ";
                                                        
                                                    }
                                    
				$arryDef[$i][$Head5] =$salesPerson;
				
			}
			else if($arryDocument[0]['AssignType']=='Group')
                                           {
                                       

                                            $arryGrp = $objGroup->getGroup($arryDocument[0]['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];
                                               $salesPerson=$AssignName;
		}
			else 
			{
			$salesPerson= stripslashes($arryDocument[0]["UserName"]);
			}
	
		if(($arryDocument[0]['Status'])=="1")
		{
		$Status="Active";	
		}
		else 
		{
		$Status="Inactive";	
		}
	
	
	 $Title ="Document # ".$arryDocument[0]['title'];
	 HeaderTextBox($pdf,$Title,$arryCompany);
	
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => "Title :", $Head2 => $arryDocument[0]['title']),
		array($Head1 => "Assigned To :", $Head2 =>$salesPerson),
		array($Head1 => "Customer:", $Head2 => $arryCustomer[0]['FullName']),
		
	
		array($Head1 => "Status :", $Head2 =>$Status),
		
		
		
		array($Head1 => "Document :", $Head2 => $arryDocument[0]['FileName']),
		array($Head1 => "Description :", $Head2 => $arryDocument[0]['description']),
		
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'120')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	
	
	$file_path = 'upload/pdf/'.$arryDocument[0]['documentID'].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	if($AttachFlag!=1)
	{
		header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
		exit;
	}

?>

