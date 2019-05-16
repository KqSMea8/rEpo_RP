<?php 
$HideNavigation=1;
include_once("../includes/header.php");
//require_once($Prefix."classes/contact.class.php");
require_once($Prefix."classes/sales.customer.class.php");	
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix."classes/socialCrm.class.php");
$objsocialcrm=new socialcrm();
$objCustomer=new Customer(); 


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


if(!empty($_GET['type']) && !empty($_GET['customerid'])){
	 switch($_GET['type']){
		 case 'facebook':
		  $socialData['Id']=$_GET['sid'];
		  $socialData['FirstName']= $_GET['FirstName'];
		  $socialData['LastName']=$_GET['LastName'];
		  $socialData['FullName']=$_GET['FullName'];
		  $socialData['Gender']=$_GET['Gender'];
		  $socialstr = serialize($socialData);
          $objsocialcrm->SaveSocialfield(array('Cid'=>$_GET['customerid']), 'FacebookInfo', $socialstr, array('field'=>'FacebookID','value'=>$_GET['sid']), 's_customers');
		  $_SESSION['mess_social']='<div class="success">Update Successfully</div>';	
		  break;
		 case 'twitter':
		  $socialData['Id']=$_GET['sid'];
		  $socialData['FullName']=$_GET['FullName'];
		  $socialData['Location']=$_GET['Location'];
		  $socialstr=serialize($socialData);
		  $objsocialcrm->SaveSocialfield(array('Cid'=>$_GET['customerid']), 'TwitterInfo', $socialstr, array('field'=>'TwitterID','value'=>$_GET['sid']), 's_customers');
		  $_SESSION['mess_social']='<div class="success">Update Successfully</div>';
		  break;
		 case 'linkedin':
		  $socialData['Id']=$_GET['sid'];
		  $socialData['FirstName']=$_GET['FirstName'];
		  $socialData['LastName']=$_GET['LastName'];
		  $socialData['FullName']=$_GET['FullName'];
		  $socialData['Location']=$_GET['Location'];
		  $socialstr=serialize($socialData);
		  $objsocialcrm->SaveSocialfield(array('Cid'=>$_GET['customerid']), 'LinkedinInfo', $socialstr, array('field'=>'LinkedinID','value'=>$_GET['sid']), 's_customers');
		  $_SESSION['mess_social']='<div class="success">Update Successfully</div>';
		  break;
		 default:
        $_SESSION['mess_contact']='<div class="error">Update Failed</div>';
                 case 'googleplus':
		  $socialData['Id']=$_GET['sid'];
		  
		  $objsocialcrm->SaveSocialfield(array('Cid'=>$_GET['customerid']), '', '', array('field'=>'GoogleID','value'=>$_GET['sid']), 's_customers');
		  $_SESSION['mess_social']='<div class="success">Update Successfully</div>';
		  break;
              case 'instagram':
		  $socialData['Id']=$_GET['sid'];
		  
		  $objsocialcrm->SaveSocialfield(array('Cid'=>$_GET['customerid']), '', '', array('field'=>'InstagramID','value'=>$_GET['sid']), 's_customers');
		  $_SESSION['mess_social']='<div class="success">Update Successfully</div>';
		  break;
		 default:
        $_SESSION['mess_contact']='<div class="error">Update Failed</div>';
	 }

}









/*************************/
	$arryContact = $objCustomer->ListCustomer($_GET);
	//echo "<pre>";print_r($arryContact);die;
	$num=$objCustomer->numRows();

	$pagerLink=$objPager->getPager($arryContact,$RecordsPerPage,$_GET['curP']);
	(count($arryContact)>0)?($arryContact=$objPager->getPageRecords()):("");
	/*************************/

require_once("../includes/footer.php"); 	 
?>


