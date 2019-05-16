<?php
	
	require_once($Prefix."classes/supplier.class.php");
	$objSupplier=new supplier();
	
	$ModuleName = "Vendor";
	$RedirectURL = "dashboard.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="general";

	$EditUrl = "dashboard.php?curP=".$_GET["curP"]."&tab=".$_GET['tab'];
	$ViewUrl = "dashboard.php?curP=".$_GET["curP"]."&tab="; 
			
			if(!empty($_GET['tab']) AND !empty($_POST)){					
					switch($_GET['tab']){
						case 'shipping':
						case 'billing':
							$data=array();							
							$data['Name']=$_POST['Name'];
							$data['Address']=$_POST['Address'];
							$data['city_id']=$_POST['main_city_id'];
							$data['state_id']=$_POST['main_state_id'];
							$data['ZipCode']=$_POST['ZipCode'];
							$data['country_id']=$_POST['country_id'];
							$data['Mobile']=$_POST['Mobile'];
							$data['Email']=$_POST['Email'];
							$data['Landline']=$_POST['Landline'];
							$data['Fax']=$_POST['Fax'];
							$data['OtherState']=$_POST['OtherState'];
							$data['OtherCity']=$_POST['OtherCity'];
							$data['SuppID']=$_POST['SuppID'];
							$data['AddType']=$_GET['tab'];							
						  	$AddID =  $objCustomerSupplier->AddVendorShipping($data);
							$Config['DbName'] = $Config['DbMain'];
							$objConfig->dbName = $Config['DbName'];
							$objConfig->connect();
						/***********************************/
				
							$arryCountry = $objRegion->GetCountryName($_POST['country_id']);
							$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);
			
							if(!empty($_POST['main_state_id'])) {
							$arryState = $objRegion->getStateName($_POST['main_state_id']);
							$arryRgn['State']= stripslashes($arryState[0]["name"]);
							}else if(!empty($_POST['OtherState'])){
							 $arryRgn['State']=$_POST['OtherState'];
							}
			
							if(!empty($_POST['main_city_id'])) {
							$arryCity = $objRegion->getCityName($_POST['main_city_id']);
							$arryRgn['City']= stripslashes($arryCity[0]["name"]);
							}else if(!empty($_POST['OtherCity'])){
							 $arryRgn['City']=$_POST['OtherCity'];
							}

							/***********************************/
							$Config['DbName'] = $_SESSION['CmpDatabase'];
							$objConfig->dbName = $Config['DbName'];
							$objConfig->connect();
							if(!empty($arryRgn))
							$AddID = $objCustomerSupplier->update('p_address_book',$arryRgn,array('AddID'=>$AddID));
							if($_GET['tab']=='shipping')
							$_SESSION['mess_supplier'] = SHIPPING_UPDATED;
							elseif($_GET['tab']=='billing')
							$_SESSION['mess_supplier'] = BILLING_UPDATED;
							$taburl='&tab='.$_GET['tab'];
							break;										
						case 'bank':
							$objSupplier->UpdateBankDetail($_POST);	
							$_SESSION['mess_supplier'] = BANK_UPDATED;
							$taburl='&tab=bank';
							break;
					
					}		
					header('Location:dashboard.php?curP=1'.$taburl) ;
					die;		
				}

	if (!empty($Customer_ID)) {
		$arrySupplier = $objSupplier->GetSupplier($Customer_ID,'','');		
		
		$_GET['view']=$SuppID   = $Customer_ID;	
		if(empty($arrySupplier[0]['SuppID'])){
			$ErrorMSG = NOT_EXIST_SUPP;
		}

	}else{
		header('location:'.$RedirectURL);
		exit;
	}



	if($_GET['tab']=='shipping'){
		$SubHeading = 'Shipping Address';
	}else if($_GET['tab']=='billing'){
		$SubHeading = 'Billing Address';
	}else if($_GET['tab']=='bank'){
		$SubHeading = 'Bank Details';
	}else if($_GET['tab']=='contacts'){
		$SubHeading = 'Contacts'; 
	}else if($_GET['tab']=='currency'){
		$SubHeading = 'Currency';
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Information";
		
	}
?>

<a class="back" href="<?=$RedirectURL?>">Back</a> 

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>

		<!-- <a href="<?=$EditUrl?>" class="edit">Edit</a> 


		<a href="viewSuppReturn.php?sc=<?=$arrySupplier[0]['SuppCode']?>" target="_blank" class="grey_bt">Returns</a> 
		<a href="viewSuppInvoice.php?sc=<?=$arrySupplier[0]['SuppCode']?>" target="_blank" class="grey_bt">Invoices</a> 
		<a href="viewSuppPO.php?sc=<?=$arrySupplier[0]['SuppCode']?>" target="_blank" class="grey_bt">Purchases</a> 
-->
		<div class="had"><?=$MainModuleName?>   <span> &raquo;
			<? 	echo $SubHeading; ?>
				</span>
		</div>

		  
	<? 
	include("supplier_view.php");


}
?>

