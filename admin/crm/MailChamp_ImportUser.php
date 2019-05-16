<?php
session_start();
/* * *********************************************** */
$FancyBox = 1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;
/* * *********************************************** */


require_once("../../define.php");
require_once("../includes/header.php");
//ini_set('display_errors',1);
require_once(_ROOT . "/lib/mailchamp/src/config.php");

$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);

$RedirectURL = $ThisPageName;

//ini_set('display_errors', '1');
if(isset($_POST['Submit']))
{	
   CleanPost(); 
	if ($_FILES["inputfile"]["error"] > 0)
	{
		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
	else 
	{
		if (file_exists($_FILES["inputfile"]["name"]))
		{
			//unlink($_FILES["inputfile"]["name"]);
		}
		$storagename = _ROOT . '/lib/mailchamp/Mail_Champ_excel/upload/mailchaimpexcel.xlsx';
                //print_r($storagename);die('hhh');
                
		//copy($_FILES["inputfile"]["tmp_name"],  $storagename);
		move_uploaded_file($_FILES["inputfile"]["tmp_name"],  $storagename);
		$uploadedStatus = 1;
		$inputFileName = $storagename;
		set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
                //$filepathrss=_ROOT . '/lib/mailchamp/Mail_Champ_excel/Classes/PHPExcel/IOFactory.php';
                //echo $filepathrss;
                
                //die('enddddddddd');
                
		include _ROOT . '/lib/mailchamp/Mail_Champ_excel/Classes/PHPExcel/IOFactory.php';
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
		$resutlsMess=$filter=$rename=array();
                $filter=array('firstname','lastname','email');
                $rename=array('FirstName','LastName','Email');
                $moddata=$massmail->filterExcelArray($allDataInSheet,$filter,$rename);
                //echo '<pre>'; print_r($moddata);die('kiilll');
                foreach($moddata as $values){
                    
                    $fname=$values['FirstName'];
                    $lname=$values['LastName'];
                    $email=$values['Email'];
                    
                    $MsgUserInsert=$massmail->InsertUserMailChamp($MailchimSetting,$fname,$lname,$email,$group_Name,$cmpId,$Mailchimp_Lists,'');
                    array_push($resutlsMess,$MsgUserInsert);
                    
                }
                $success=$failed=0;
                        foreach($resutlsMess as $values){

                            if($values==1){
                                ++$success;
                                }
                            else{
                                ++$failed;
                            }     
                        }
                           //echo "<h1> $success record inserted <br/> $failed record already exist</h1>";
                           $_SESSION['message'] = "<div class='success'>$success record inserted <br/> $failed record already exist</div>";
                               }
}

//include("../includes/html/box/import_lead_form.php");
include_once("../includes/footer.php"); 
?>
