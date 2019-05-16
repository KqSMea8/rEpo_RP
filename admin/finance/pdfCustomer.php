<?	require_once("../includes/pdf_comman.php");
require_once($Prefix."classes/sales.customer.class.php");
	    include_once("includes/FieldArray.php");
	
	$objCustomer=new Customer();
	
	$id = (!empty($id)) ? $id :'';  
	(empty($_GET['status']))?($_GET['status']=""):(""); 
	

	  $arryCustomer=$objCustomer->getCustomers($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
	  
	  
	  
	// echo "<pre>";print_r($arryCustomer);exit;
	  
	

	$NumLine = sizeof($arryCustomer);

	$ModuleName =$_GET['module'];

  /*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	
	 $Title ="Customer";
	HeaderTextBox($pdf,$Title,$arryCompany);
      
	$YCordLine='';
	//$YCordLine = $pdf->y-5; 
      
	$pdf->line(50,$YCordLine,92,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0)
    {
   
        $Head1 ='<b>Customer Code</b>';$Head2 ='<b>Customer Name</b>'; $Head3 = '<b>Email Address</b>'; $Head4 = '<b>Phone</b>';  $Head5 = '<b>Country</b>';$Head6 = '<b>State</b>';$Head7 = '<b>Status</b>';; 
       
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3]=$Head3;  $arryDef[$i][$Head4]=$Head4;$arryDef[$i][$Head5]=$Head5;$arryDef[$i][$Head6]=$Head6; $arryDef[$i][$Head7]=$Head7;
        $data[] = $arryDef[$i];
        $i++;
	
 
		for($Line=1;$Line<=$NumLine;$Line++) 
		{ 
		
			$Count=$Line-1;	
			
                     
           	$arryDef[$i][$Head1] = stripslashes($arryCustomer[$Count]["CustCode"]);
			$arryDef[$i][$Head2] = stripslashes($arryCustomer[$Count]["CustomerName"]);
			$arryDef[$i] [$Head3]= stripslashes($arryCustomer[$Count]["Email"]);
			$arryDef[$i][$Head4] = stripslashes($arryCustomer[$Count]["Landline"]);
					
			$arryDef[$i][$Head5] = stripslashes($arryCustomer[$Count]["CountryName"]);
			$arryDef[$i][$Head6] = stripslashes($arryCustomer[$Count]["StateName"]);
			
			$arryDef[$i][$Head7] = stripslashes($arryCustomer[$Count]["Status"]);
			
			
			$data[] = $arryDef[$i];
           	 $i++;
			
        }
        $pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'70'),$Head2=>array('justification'=>'left','width'=>'60'),$Head3=>array('justification'=>'left','width'=>'60'),$Head4=>array('justification'=>'left','width'=>'90'),$Head5=>array('justification'=>'left','width'=>'95'),$Head6=>array('justification'=>'left','width'=>'60'),$Head7=>array('justification'=>'right','width'=>'65')), 'shaded'=>0,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>2 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);
     
                $pdf->ezSetMargins(0,0,0,14);
		
		$pdf->ezText('','',array('justification'=>'right', 'spacing'=>'1.5'));

    }


	/***********************************/
	#$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/'."Customerpdf.pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	//ECHO $file_path;EXIT;
	fwrite($fp,$pdfcode);
	fclose($fp);

	if($AttachFlag!=1)
	{
		header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
		exit;
	}

?>
