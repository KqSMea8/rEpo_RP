<?	require_once("../includes/pdf_comman.php");

require_once($Prefix . "classes/event.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix . "classes/lead.class.php");
include_once("includes/FieldArray.php");
//require_once("includes/RightFieldArray.php");
$ModuleName = $_GET['module'];
$objActivity = new activity();
$objCommon = new common();
$objFilter = new filter();
$objLead = new lead();

 //$arryActivity = $objActivity->GetActivityList($_GET);
 
 

	 $arryDefult = $objFilter->getDefultView($_GET['module']);

if(!empty($arryDefult[0]['setdefault'])  && $_GET['customview'] == "" && $_GET['key'] == "" && $_GET['FromDate'] == "" && $_GET['ToDate'] == ""){ 
    
  $_GET['customview']=  $arryDefult[0]['cvid']; 
    
}
elseif($_GET['customview'] != "All" && $_GET['customview'] >0 && $_GET['key'] == "" && $_GET['FromDate'] == "" && $_GET['ToDate'] == "")
{
    
    $_GET['customview'] = $_GET['customview'];
    
}
else
{
    
  $_GET["customview"] = 'All';  
}
 
/*********************Set Defult ************/
if ($_GET["customview"] == 'All' )
 {
    
    $arryActivity = $objActivity->GetActivityList($_GET);
    
}
 else 
{
    
    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);
        #echo $arryfilter[0]['status']; exit;
    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);


    if (!empty($arryColVal))
     {
        foreach ($arryColVal as $colVal) 
        {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");

        foreach ($arryQuery as $colRul)
        {

            if ($colRul['comparator'] == 'e')
             {  //echo $colRul['value'];exit;
                if ($colRul['columnname'] == 'AssignTo' || $colRul['columnname'] == 'assignTo' || $colRul['columnname'] == 'assignedTo' || $colRul['columnname'] == 'created_id') {
                    $comparator = 'like';


                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                }
                 else 
                 {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') 
            {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo' || $colRul['columnname'] == 'assignTo' || $colRul['columnname'] == 'assignedTo' || $colRul['columnname'] == 'created_id') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') 
            {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') 
            {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'in') {
                $comparator = 'in';

                $arrVal = explode(",", $colRul['value']);

                $FinalVal = '';
                foreach ($arrVal as $tempVal) {
                    $FinalVal .= "'" . trim($tempVal) . "',";
                }
                $FinalVal = rtrim($FinalVal, ",");
                $setValue = trim($FinalVal);

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");
        $arryActivity = $objActivity->CustomActivity($colValue, $colRule);
       //echo "<pre>";print_r($arryActivity);return ;
     }}

	//echo "<pre>";print_r($arryActivity);exit;

	$NumLine = sizeof($arryActivity);

	$ModuleName =$_GET['module'];

  /*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	
	 $Title = $ModuleName;
	HeaderTextBox($pdf,$Title,$arryCompany);
      
	//$YCordLine = $pdf->y-5; 
      
	$pdf->line(50,$YCordLine,92,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0)
    {
   
        $Head1 ='<b>Title</b>';$Head2 ='<b>Activity Type</b>'; $Head3 = '<b>Priority</b>'; $Head4 = '<b>Created By</b>';  $Head5 = '<b>Start Date</b>';$Head6 = '<b>Close Date</b>';$Head7 = '<b>Status</b>';; 
       
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3]=$Head3;  $arryDef[$i][$Head4]=$Head4;$arryDef[$i][$Head5]=$Head5;$arryDef[$i][$Head6]=$Head6; $arryDef[$i][$Head7]=$Head7;
        $data[] = $arryDef[$i];
        $i++;
	
 
		for($Line=1;$Line<=$NumLine;$Line++) 
		{ 
		
			$Count=$Line-1;	
			
                     
           	$arryDef[$i][$Head1] = stripslashes($arryActivity[$Count]["subject"]);
           		$arryDef[$i] [$Head2]= stripslashes($arryActivity[$Count]["activityType"]);
			$arryDef[$i][$Head3] = stripslashes($arryActivity[$Count]["priority"]);
		
		 if ($arryActivity[$Count]["created_by"]== 'admin') 
                                            {

                                                $created_by = "Admin";
                                                

                                               

                                               
                                            }
                                             else 
                                             {

                                                $created_by =$arryActivity[$Count]['created'];
                                               
                                               
                                                
                                            }
			
			
			$arryDef[$i][$Head4] =$created_by;
					
	       $stdate1=($arryActivity[$Count]["startDate"]>0)?(date($_SESSION['DateFormat'], strtotime($arryActivity[$Count]["startDate"]))):("");
		
            $arryDef[$i][$Head5] =$stdate1." " .$arryActivity[$Count]["startTime"];
            $stdate2=($arryActivity[$Count]["closeDate"]>0)?(date($_SESSION['DateFormat'], strtotime($arryActivity[$Count]["closeDate"]))):("");
			$arryDef[$i][$Head6] =$stdate2." " .$arryActivity[$Count]["closeTime"];;
			$arryDef[$i][$Head7] = stripslashes($arryActivity[$Count]["status"]);
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
	$file_path = 'upload/pdf/'."Activitypdf.pdf";
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

