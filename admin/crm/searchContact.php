<?php 
$HideNavigation=1;
include_once("../includes/header.php");

//require_once($Prefix."classes/contact.class.php");
require_once($Prefix."classes/sales.customer.class.php");	
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix."classes/socialCrm.class.php");
$objsocialcrm=new socialcrm();

$socialData=array();

# start save data in contact if user want to existing contact ##&& !empty($_GET['contactid'])
if(!empty($_GET['type'])){
	 switch($_GET['type']){
		 case 'facebook':
		  $data = '&FirstName='.$_GET['FirstName'].'&LastName='.$_GET['LastName'].'&FullName='.$_GET['FullName'].'&sid='.$_GET['sid'].'&Gender='.$_GET['Gender'].'&type=facebook';
		  break;
		 case 'twitter':
		 $data = '&FullName='.$_GET['FullName'].'&sid='.$_GET['sid'].'&Location='.$_GET['Location'].'&type=twitter';
		  break;
		 case 'linkedin':
		  $data = '&FullName='.$_GET['FullName'].'&sid='.$_GET['sid'].'&Location='.$_GET['Location'].'&type=linkedin';
		  break;
                 case 'googleplus':
		  $data = '&sid='.$_GET['sid'].'&type=googleplus';
		  break;
                 case 'instagram':
		  $data = '&sid='.$_GET['sid'].'&type=instagram';
		  break;
		 default:
        $_SESSION['mess_contact']='<div class="error">Update Failed</div>';
	 }

}


if(!empty($_GET['type']) && !empty($_GET['contactid'])){
	 switch($_GET['type']){
		 case 'facebook':
		  $socialData['Id']=$_GET['sid'];
		  $socialData['FirstName']= $_GET['FirstName'];
		  $socialData['LastName']=$_GET['LastName'];
		  $socialData['FullName']=$_GET['FullName'];
		  $socialData['Gender']=$_GET['Gender'];
		  $socialstr = serialize($socialData);
          $objsocialcrm->SaveSocialfield(array('AddID'=>$_GET['contactid']), 'FacebookInfo', $socialstr, array('field'=>'FacebookID','value'=>$_GET['sid']), 's_address_book');
		  $_SESSION['mess_social']='<div class="success">Update Successfully</div>';	
		  break;
		 case 'twitter':
		  $socialData['Id']=$_GET['sid'];
		  $socialData['FullName']=$_GET['FullName'];
		  $socialData['Location']=$_GET['Location'];
		  $socialstr=serialize($socialData);
		  $objsocialcrm->SaveSocialfield(array('AddID'=>$_GET['contactid']), 'TwitterInfo', $socialstr, array('field'=>'TwitterID','value'=>$_GET['sid']), 's_address_book');
		  $_SESSION['mess_social']='<div class="success">Update Successfully</div>';
		  break;
		 case 'linkedin':
		  $socialData['Id']=$_GET['sid'];
		  $socialData['FirstName']=$_GET['FirstName'];
		  $socialData['LastName']=$_GET['LastName'];
		  $socialData['FullName']=$_GET['FullName'];
		  $socialData['Location']=$_GET['Location'];
		  $socialstr=serialize($socialData);
		  $objsocialcrm->SaveSocialfield(array('AddID'=>$_GET['contactid']), 'LinkedinInfo', $socialstr, array('field'=>'LinkedinID','value'=>$_GET['sid']), 's_address_book');
		  $_SESSION['mess_social']='<div class="success">Update Successfully</div>';
		  break;
		 default:
                 $_SESSION['mess_contact']='<div class="error">Update Failed</div>';
                 case 'googleplus':
                     //echo 'hello';
		  $socialData['Id']=$_GET['sid'];
		  $socialstr=serialize($socialData);
		  $objsocialcrm->SaveSocialfield(array('AddID'=>$_GET['contactid']), '', '', array('field'=>'GoogleID','value'=>$_GET['sid']), 's_address_book');
                  //print_r($objsocialcrm);die;
		  $_SESSION['mess_social']='<div class="success">Update Successfully</div>';
		  break;
                case 'instagram':
                     //echo 'hello';
		  $socialData['Id']=$_GET['sid'];
		  $socialstr=serialize($socialData);
		  $objsocialcrm->SaveSocialfield(array('AddID'=>$_GET['contactid']), '', '', array('field'=>'InstagramID','value'=>$_GET['sid']), 's_address_book');
                  //print_r($objsocialcrm);die;
		  $_SESSION['mess_social']='<div class="success">Update Successfully</div>';
		  break;
		 default:
                 $_SESSION['mess_contact']='<div class="error">Update Failed</div>';
	 }

}












# end save data in contact if user want to existing contact


        $objFilter = new filter();
        (empty($_GET['module'])) ? ($_GET['module'] = "Contact") : ("");
	$ModuleName = "Contact";
	//$objContact=new contact();
	$objCustomer=new Customer(); 

/* * *******************Custom Filter *********** */
if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:" . $ThisPageName);
    exit;
}



/* * *******************Set Defult *********** */
$arryDefult = $objFilter->getDefultView($_GET['module']);

if ($arryDefult[0]['setdefault'] == 1 && $_GET['customview'] == "") {

    $_GET['customview'] = $arryDefult[0]['cvid'];
} elseif ($_GET['customview'] != "All" && $_GET['customview'] > 0) {

    $_GET['customview'] = $_GET['customview'];
} else {

    $_GET["customview"] = 'All';
}



if (!empty($_GET["customview"])) {
    #$arryLead = $objLead->ListLead('', $_GET['key'], $_GET['sortby'], $_GET['asc']);


    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);
#echo $arryfilter[0]['status']; exit;
    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);


    if (!empty($arryColVal)) {
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");


        foreach ($arryQuery as $colRul) {



            if ($colRul['comparator'] == 'e') {

                $comparator = '=';
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }


            if ($colRul['comparator'] == 'l') {
                $comparator = '<';
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
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
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
                }
            }
        }
        $colRule = rtrim($colRule, "  and");

        $_GET['rule'] = $colRule;
        // $arryLead = $objLead->CustomLead($colValue, $colRule);
    }
}



/* * **************************End Custom Filter*************************************** */

	$arryContact=$objCustomer->ListCrmContact($_GET);
	
	$num=$objCustomer->numRows();

	$pagerLink=$objPager->getPager($arryContact,$RecordsPerPage,$_GET['curP']);
	(count($arryContact)>0)?($arryContact=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php"); 	 
?>


