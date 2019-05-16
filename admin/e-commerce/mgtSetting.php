<?php
/**************************************************/
           $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/mgt.class.php");
	
	$ModuleName  ="Magento Setting";
	$objMgt = new mgt();
	$arrymgtCredentials= $objMgt->Getdata('magneto_setting');
	
	if($_POST){ 
		if(count($arrymgtCredentials)==0)
		{
			$objMgt->adddata($_POST);
			$_SESSION['mess_cart'] ='Setting add successfully.';
		}
		else
		{
		   $arrydata=$objMgt->Updatedata($_POST);	
		   $_SESSION['mess_cart'] ='Setting update successfully.';
		}
		
		
	    header("location:mgtSetting.php");
	}
	
	if(count($arrymgtCredentials)>0){
		$data =  unserialize(base64_decode($arrymgtCredentials[0]['data']));
		$SiteUrl  = $data['SiteUrl']; 
		$status  = $data['status']; 
	}	

 require_once("../includes/footer.php"); 
 
 
 ?>
