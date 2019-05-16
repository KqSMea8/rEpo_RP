<?php 
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/group.class.php");
	require_once($Prefix."classes/event.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/quote.class.php");	
	require_once($Prefix."classes/quote.class.php");	
	die('s,jdfndfnkjndflknlkdfmn');
	$objCustomer=new Customer();  
	$objLead=new lead();
	$objGroup=new group();
	$objActivity=new activity();
	$objSale = new sale();
	$objQuote=new quote();
	$ModuleName = "Customer";	
	$RedirectURL = "dashboard.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="general";
	

	//$EditUrl = "editCustomer.php?curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$EditUrl = "dashboard.php?curP=".$_GET["curP"]."&tab=".$_GET['tab'];
	$ViewUrl = "dashboard.php?curP=".$_GET["curP"]."&tab="; 
			
			/******* Code For Update Detail***********/
				if(!empty($_GET['tab']) AND !empty($_POST)){					
					switch($_GET['tab']){
					 	case 'bank':
						 	$_SESSION['mess_cust'] = '<div class="success">'.UPDATEDBANKDETAILS.'</div>';
						 	$objCustomer->UpdateBankDetail($_POST);
						 	$taburl='&tab=bank';
					 	break;
					 	case 'shipping':					 			 	
                     //  $AddID = $objCustomer->UpdateShippingBilling($_POST);
	                ini_set('display_errors',1);
	                 	 $data=$_POST;
	                   unset($data['Submit']);
	                   unset($data['country_id']);
	                   unset($data['main_city_id']);
	                   unset($data['main_state_id']);
	                   unset($data['tab']);
	                  die('testt');
                 	  $AddID =  $objCustomerSupplier->AddCustShipping($data);
						/******************ADD COUNTRY/STATE/CITY NAME*****************/
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
		
					$objCustomer->UpdateCountryStateCity($arryRgn,$AddID);
					$_SESSION['mess_cust'] = '<div class="success">'.SHIPPING_UPDATED.'</div>';
					$taburl='&tab=shipping';
					break;
					/**************END COUNTRY NAME*********************/
					 case 'billing':
                    
                      $AddID = $objCustomer->UpdateShippingBilling($_POST);
										 
				 /******************ADD COUNTRY/STATE/CITY NAME*****************/
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
					$objCustomer->UpdateCountryStateCity($arryRgn,$AddID);
			  		$_SESSION['mess_cust'] =  '<div class="success">'.BILLING_UPDATED.'</div>';
			  		$taburl='&tab=billing';
			       /**************END COUNTRY NAME*********************/
				break;	
					
					}		
					header('Location:dashboard.php?curP=1'.$taburl) ;
					die;		
				}
	
	if (!empty($Customer_ID)) {
		$CustID   = $Customer_ID;
		$_GET['CustID'] = $Customer_ID;	
		$arryCustomer = $objCustomer->GetCustomer($Customer_ID,'','');	
                $arryBillShipp = $objCustomer->GetShippingBilling($Customer_ID,$_GET['tab']);	
		if(empty($arryCustomer[0]['Cid'])){
			$ErrorMSG = CUSTOMER_NOT_EXIST;
		}

	}
	/*****************/
      
	if($_GET['tab']=='shipping'){
		$SubHeading = 'Shipping Address';
	}else if($_GET['tab']=='billing'){
		$SubHeading = 'Billing Address';	
  	}else if($_GET['tab']=='bank'){
		$SubHeading = 'Bank Details';	
  	}else if($_GET['tab']=='contact'){
		$SubHeading = 'Contacts'; 
		$IncludePage = 'customer_contacts.php';	
	}else if($_GET['tab']=='ticket'){
		$SubHeading = 'Tickets'; $HideEdit=1; 
		$IncludePage = 'customer_tickets.php';
	}else if($_GET['tab']=='event'){
		$SubHeading = 'Event / Task'; $HideEdit=1; 
		$IncludePage = 'customer_activity.php';
	}else if($_GET['tab']=='document'){
		$SubHeading = 'Documents'; $HideEdit=1; 
		$IncludePage = 'customer_documents.php';
	}else if($_GET['tab']=='quote'){
		$SubHeading = 'Quotes'; $HideEdit=1;
		$IncludePage = 'customer_quote.php';
	}else if($_GET['tab']=='salesorder'){
		$SubHeading = 'Sales Orders'; $HideEdit=1;
		$IncludePage = 'customer_orders.php';
	}else if($_GET['tab']=='invoice'){
		$SubHeading = 'Invoices'; $HideEdit=1;	
		$IncludePage = 'customer_invoice.php';
	}else if($_GET['tab']=='purchaseorder'){
		$SubHeading = 'Purchase History'; $HideEdit=1;
		$IncludePage = 'customer_purchases.php';	
	}else if($_GET['tab']=='comment'){
		$_GET['module'] = 'Customer';
		$SubHeading = 'Comments'; $HideEdit=1;
		$IncludeOtherPage = 'includes/html/box/comment_cust.php';
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Information";
	}
		
	
	
?>


<?
	/*********************/
	/*********************/
	$_GET["module"] = $ModuleName;
	$FullName = stripslashes($arryCustomer[0]['FullName']);
   	$NextID = $objCustomer->NextPrevCustomer($Customer_ID,$FullName,1);
	$PrevID = $objCustomer->NextPrevCustomer($Customer_ID,$FullName,2);
	$NextPrevUrl = "vCustomer.php?tab=general&curP=".$_GET["curP"];
	//include("includes/html/box/next_prev.php");
	/*********************/
	/*********************/
?>


<a class="back" href="<?=$RedirectURL?>">Back</a> 
<?php
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{$HideEdit=1;
?>

		<? if($HideEdit!=1){?><a href="<?=$EditUrl?>" class="edit">Edit</a><?}?>


		<div class="had"><?=$MainModuleName?>  <span> &raquo;	<?php 	echo $SubHeading; ?>	</span>
		</div>




<? 
if(!empty($IncludePage)){
	$Config['vAllRecord']=1;	
	include("includes/html/box/".$IncludePage);
}else if(!empty($IncludeOtherPage)){
	$Config['vAllRecord']=1;	
	include($IncludeOtherPage);
}else{

?>
<form action="" method="POST">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	<tr>
	 <td colspan="4" align="left" class="head"><?=$SubHeading?></td>
	 
	</tr>		
		<?php if(!empty($_SESSION['mess_cust'])) {?>	
		<tr ><td>&nbsp;</td><td><?php echo $_SESSION['mess_cust']; unset($_SESSION['mess_cust']); ?></td></tr>	
		<?php }?>
			

				
		<?php if($_GET['tab'] == "general"){?>  
		 <tr>
		<td   align="right" valign="top"  class="blackbold"> 
		Customer Code : </td>
		<td   align="left" valign="top">
		<?=stripslashes($arryCustomer[0]['CustCode'])?>
		</td>
		</tr>
		<tr>
		<td align="right" class="blackbold"> Customer Type  : </td>
		<td align="left"><?=$arryCustomer[0]['CustomerType']?></td>
		

<? if($arryCustomer[0]['CustomerType']=='Company'){ ?>  
		
		<td  align="right" valign="top"   class="blackbold"> 
		Company : </td>
		<td  align="left">
		<?=(!empty($arryCustomer[0]['Company']))?($arryCustomer[0]['Company']):(NOT_SPECIFIED)?>
		</td>
		
<? } ?>
		</tr>

 <tr>
                <td width="25%" align="right" valign="top"  class="blackbold"> 
                    First Name :  </td>
                 <td align="left" width="25%"><?=stripslashes($arryCustomer[0]['FirstName'])?></td>
                
          
                <td width="25%" align="right" valign="top"   class="blackbold"> 
                    Last Name : </td>
                 <td align="left"><?=stripslashes($arryCustomer[0]['LastName'])?></td>
               
            </tr>
             <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Gender : </td>
               
                 <td align="left"><?=$arryCustomer[0]['Gender'];?></td>
          
                <td align="right" valign="top" class="blackbold"> 
                    Email :  </td>
               
                <td align="left"><?=stripslashes($arryCustomer[0]['Email'])?></td>
            </tr>
<tr>
                <td align="right" valign="top" class="blackbold"> 
                    Mobile :  </td>
                
                 <td  align="left">

  <?=(!empty($arryCustomer[0]['Mobile']))?(stripslashes($arryCustomer[0]['Mobile'])):(NOT_SPECIFIED)?>

</td>
            
                <td  align="right" valign="top"   class="blackbold"> 
                    Landline  : </td>
                <td  align="left"  class="blacknormal">
                    <?=(!empty($arryCustomer[0]['Landline']))?(stripslashes($arryCustomer[0]['Landline'])):(NOT_SPECIFIED)?>
                </td>
            </tr>
                                            
                                      
            <tr style="display:none">
	<td  align="right"   class="blackbold" > Currency :</td>
	<td   align="left" >
		<?=$arryCustomer[0]['Currency']?>
	  </td>
  </tr>
           
           
            <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Website :  </td>
               <td  align="left"><?=(!empty($arryCustomer[0]['Website']))?($arryCustomer[0]['Website']):(NOT_SPECIFIED)?></td>
            
		<td align="right"   class="blackbold" >Customer Since :</td>
		<td  align="left"  >
 <?=($arryCustomer[0]['CustomerSince']>0)?(date($Config['DateFormat'], strtotime($arryCustomer[0]['CustomerSince']))):(NOT_SPECIFIED)?>

				</td>
	  </tr>
	<tr>
			<td  align="right"   class="blackbold" > Payment Term  : </td>
			<td   align="left" >
	<?=(!empty($arryCustomer[0]['PaymentTerm']))?(stripslashes($arryCustomer[0]['PaymentTerm'])):(NOT_SPECIFIED)?>

		</td>
	
			<td  align="right"   class="blackbold" > Payment Method  : </td>
			<td   align="left" >
	<?=(!empty($arryCustomer[0]['PaymentMethod']))?(stripslashes($arryCustomer[0]['PaymentMethod'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

	<tr>
			<td  align="right"   class="blackbold" > Shipping Method  : </td>
			<td   align="left" >
	<?=(!empty($arryCustomer[0]['ShippingMethod']))?(stripslashes($arryCustomer[0]['ShippingMethod'])):(NOT_SPECIFIED)?>

		</td>

			<td  align="right"   class="blackbold" > Taxable : </td>
			<td   align="left" >
	<?=($arryCustomer[0]['Taxable']=='Yes')?("Yes"):("No")?>

		</td>
	</tr>

	<tr>
		<td  align="right"   class="blackbold" >Status  : </td>
		<td   align="left"  >
		<?  echo ($arryCustomer[0]['Status'] == "Yes")?("Active"):(" InActive");
		?>
		</td>
	</tr>		
<?php }?>
 
  <?php if($_GET['tab'] == "contact"){ ?>  
                                       
            <tr>
                <td colspan="4" align="left" class="head">Contact Information </td>
            </tr>
           
            <tr>
                <td align="right" valign="top"  class="blackbold"> 
                    First Name :  </td>
                 <td align="left"><?=stripslashes($arryCustomer[0]['FirstName'])?></td>
                
            </tr>

            <tr>
                <td  align="right" valign="top"   class="blackbold"> 
                    Last Name : </td>
                 <td align="left"><?=stripslashes($arryCustomer[0]['LastName'])?></td>
               
            </tr>
             <tr>
                <td  align="right" valign="top"   class="blackbold"> 
                    Gender : </td>
               
                 <td align="left"><?=$arryCustomer[0]['Gender'];?></td>
            </tr>
             <tr>
                <td align="right" valign="top" class="blackbold"> 
                    Email :  </td>
               
                <td align="left"><?=stripslashes($arryCustomer[0]['Email'])?></td>
            </tr>
             <tr>
                <td valign="top" align="right" class="blackbold">Address  :</td>

                 <td align="left"><?=stripslashes($arryCustomer[0]['Address'])?></td>
             </tr>
              <tr>
                <td  align="right"   class="blackbold"> Country : </td>
                <td   align="left" >
                  <?=stripslashes($arryCustomer[0]['CountryName'])?>
                </td>
            </tr>
            <tr>
                <td  align="right" valign="middle"  class="blackbold"> State : </td>
             <td  align="left" class="blacknormal"><?=stripslashes($arryCustomer[0]['StateName'])?></td>
            </tr>
            
            <tr>
                <td  align="right" class="blackbold"> City : </td>
                <td  align="left"><?=stripslashes($arryCustomer[0]['CityName'])?></td>
            </tr> 
             
            <tr>
                <td align="right" valign="top" class="blackbold">Zip Code :  </td>
                 
                 <td  align="left"><?=stripslashes($arryCustomer[0]['ZipCode'])?></td>
            </tr>
             <tr>
                <td align="right" valign="top" class="blackbold"> 
                    Mobile :  </td>
                
                 <td  align="left"><?=stripslashes($arryCustomer[0]['Mobile'])?></td>
            </tr>
             <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Landline  : </td>
                <td  align="left"  class="blacknormal">
                    <?=(!empty($arryCustomer[0]['Landline']))?(stripslashes($arryCustomer[0]['Landline'])):(NOT_SPECIFIED)?>
                </td>
            </tr>
                                            
                                      
             <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Fax :</td>
               <td  align="left">
                <?=(!empty($arryCustomer[0]['Fax']))?(stripslashes($arryCustomer[0]['Fax'])):(NOT_SPECIFIED)?>
               </td>
            </tr>
           
           
            <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Website :  </td>
               <td  align="left"><?=(!empty($arryCustomer[0]['Website']))?($arryCustomer[0]['Website']):(NOT_SPECIFIED)?></td>
            </tr>
            <?php }?>  
         <?php if($_GET['tab'] == "billing" || $_GET['tab'] == "shipping"){
                                            
                                            $BillShipp = ucfirst($_GET["tab"]);
                                            $NumBillShipp = sizeof($arryBillShipp);
                                            
                                            /********Connecting to main database*********/
                                                $Config['DbName'] = $Config['DbMain'];
                                                $objConfig->dbName = $Config['DbName'];
                                                $objConfig->connect();
                                             if($arryBillShipp[0]['country_id']>0){
                                                        $arryCountryName = $objRegion->GetCountryName($arryBillShipp[0]['country_id']);
                                                        $CountryName = stripslashes($arryCountryName[0]["name"]);
                                                }

                                                if(!empty($arryBillShipp[0]['state_id'])) {
                                                        $arryState = $objRegion->getStateName($arryBillShipp[0]['state_id']);
                                                       
                                                        $StateName = stripslashes($arryState[0]["name"]);
                                                }else if(!empty($arryBillShipp[0]['OtherState'])){
                                                         $StateName = stripslashes($arryBillShipp[0]['OtherState']);
                                                }

                                                if(!empty($arryBillShipp[0]['city_id'])) {
                                                        $arryCity = $objRegion->getCityName($arryBillShipp[0]['city_id']);
                                                        $CityName = stripslashes($arryCity[0]["name"]);
                                                }else if(!empty($arryBillShipp[0]['OtherCity'])){
                                                         $CityName = stripslashes($arryBillShipp[0]['OtherCity']);
                                                }
                                            ?>    
                                           
                                            <?php 
                                            
                                            if($NumBillShipp>0){ 
                                           
                                            	?>
                                             <tr>
												 <td colspan="4">&nbsp;<div style="float:right;"><a href="dashboard.php?curP=1&tab=<?php echo $_GET['tab'];?>&e=1" class="fancybox"><img border="0" src="<?php echo _SiteUrl?>admin/images/edit.png"></a></div></td>
											</tr>
                                            <tr>
                                                <td width="45%" align="right" valign="top" class="blackbold"> <?=$BillShipp?> Name : </td>
                                                <td align="left" valign="top">
                                          		 <?php 
                                          		 if(empty($_GET['e'])){
							 							echo (!empty($arryBillShipp[0]['FullName']))?(stripslashes($arryBillShipp[0]['FullName'])):(NOT_SPECIFIED);
												 	}else{
			 											$v=!empty($arryBillShipp[0]['FullName'])?stripslashes($arryBillShipp[0]['FullName']):"";
												 		echo '<input type="text" name="Name" maxlength="30" class="inputbox" id="Name" value="'.$v.'"> ';
			 										 }?>	
                                                  
                                                </td>
                                            </tr>
                                           <tr>
                                            <td align="right"   class="blackbold"><?=$BillShipp;?> Email  : </td>
                                            <td  align="left" >
                                            <?php if(empty($_GET['e'])){
							 							echo (!empty($arryBillShipp[0]['Email']))?(stripslashes($arryBillShipp[0]['Email'])):(NOT_SPECIFIED);
												 	}else{
			 											$v=!empty($arryBillShipp[0]['Email'])?stripslashes($arryBillShipp[0]['Email']):"";
												 		echo '<input type="text" name="Email" maxlength="30" class="inputbox" id="Email" value="'.$v.'"> ';
			 										 }?>
                                          	</td>
                                           </tr> 
                                            <tr>
                                                <td  align="right" valign="top" class="blackbold">  Address : </td>
                                                <td  align="left" valign="top">
                                                <?php if(empty($_GET['e'])){
							 							echo (!empty($arryBillShipp[0]['Address']))?(stripslashes($arryBillShipp[0]['Address'])):(NOT_SPECIFIED);
												 	}else{
			 											$v=!empty($arryBillShipp[0]['Address'])?stripslashes($arryBillShipp[0]['Address']):"";
												 		echo '<textarea  name="Address" class="textarea" id="Address" >'.$v.'</textarea> ';
			 										 }?>                                                  
                                                </td>
                                            </tr>
                                           

                                            <tr>
                                                <td  align="right"   class="blackbold"> Country : </td>
                                                <td   align="left" >
                                                 <?php if(empty($_GET['e'])){
							 							echo (!empty($CountryName))?(stripslashes($CountryName)):(NOT_SPECIFIED);
												 	}else{
			 											$v=!empty($CountryName)?$CountryName:"";
														 	 if ($arryBillShipp[0]['country_id'] >0) {
		                                                        $CountrySelected = $arryBillShipp[0]['country_id'];
		                                                    } else {
		                                                        $CountrySelected = $arryCurrentLocation[0]['country_id'];
		                                                    }
			 											?>
			 											 <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
                                                        <?php for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                                            <option value="<?= $arryCountry[$i]['country_id'] ?>" <?php if ($arryCountry[$i]['country_id'] == $CountrySelected) {
                                                            echo "selected";
                                                        } ?>>
                                                            <?= $arryCountry[$i]['name'] ?>
                                                            </option>
                                                            <?php } ?>
                                                    </select> <?php }?>                                                      
                                                </td>
                                            </tr>
                                            <tr>
                                              <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State : </td>
                                             <td  align="left"  id="state_td" class="blacknormal">
                                           	  <?php 
                                           	 
                                           	  if(empty($_GET['e'])){
                                           	  
							 							echo (!empty($StateName))?(stripslashes($StateName)):(NOT_SPECIFIED);
												 	}else{
			 											echo	$v=!empty($StateName)?$StateName:"";			 										
												 		//echo '<input type="text" name="Name" maxlength="30" class="inputbox" id="Name" value="'.$v.'"> ';
			 										 }?> 
			 										</td>
                                            </tr>
                                           
                                            <tr>
                                                <td  align="right" class="blackbold"> <div id="MainCityTitleDiv"> City : <span class="red">*</span></div></td>
                                                <td  align="left"><div id="city_td">
                                                  <?php if(empty($_GET['e'])){
							 							echo (!empty($CityName))?(stripslashes($CityName)):(NOT_SPECIFIED);
												 	}else{
			 											echo $v=!empty($CityName)?$CityName:(NOT_SPECIFIED);
												 		//echo '<input type="text" name="Name" maxlength="30" class="inputbox" id="Name" value="'.$v.'"> ';
			 										 }?> </div>
			 										 </td>
                                            </tr> 
                                          
                                            <tr>
                                                <td  align="right" valign="top" class="blackbold">Zip Code : </td>
                                                <td   align="left" valign="top">
                                                    <?php if(empty($_GET['e'])){
							 							echo (!empty($arryBillShipp[0]['ZipCode']))?(stripslashes($arryBillShipp[0]['ZipCode'])):(NOT_SPECIFIED);
												 	}else{
			 											$v=!empty($arryBillShipp[0]['ZipCode'])?stripslashes($arryBillShipp[0]['ZipCode']):"";
												 		echo '<input type="text" name="ZipCode" maxlength="30" class="inputbox" id="ZipCode" value="'.$v.'"> ';
			 										 }?>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td align="right"   class="blackbold" >Mobile  :</td>
                                            <td  align="left"  >
                                            <?php if(empty($_GET['e'])){
							 							echo (!empty($arryBillShipp[0]['Mobile']))?(stripslashes($arryBillShipp[0]['Mobile'])):(NOT_SPECIFIED);
												 	}else{
			 											$v=!empty($arryBillShipp[0]['Mobile'])?stripslashes($arryBillShipp[0]['Mobile']):"";
												 		echo '<input type="text" name="Mobile" maxlength="30" class="inputbox" id="Mobile" value="'.$v.'"> ';
			 										 }?>
                                             </td>
                                          </tr>

                                               <tr>
                                            <td  align="right"   class="blackbold">Landline  :</td>
                                            <td   align="left" >
                                              <?php if(empty($_GET['e'])){
							 							echo (!empty($arryBillShipp[0]['Landline']))?(stripslashes($arryBillShipp[0]['Landline'])):(NOT_SPECIFIED);
												 	}else{
			 											$v=!empty($arryBillShipp[0]['Landline'])?stripslashes($arryBillShipp[0]['Landline']):"";
												 		echo '<input type="text" name="Landline" maxlength="30" class="inputbox" id="Landline" value="'.$v.'"> ';
			 										 }?>
                                              
                                             </td>
                                          </tr>

                                          <tr>
                                            <td align="right"   class="blackbold">Fax  : </td>
                                            <td  align="left" >
                                             <?php if(empty($_GET['e'])){
							 							echo (!empty($arryBillShipp[0]['Fax']))?(stripslashes($arryBillShipp[0]['Fax'])):(NOT_SPECIFIED);
												 	}else{
			 											$v=!empty($arryBillShipp[0]['Fax'])?stripslashes($arryBillShipp[0]['Fax']):"";
												 		echo '<input type="text" name="Fax" maxlength="30" class="inputbox" id="Fax" value="'.$v.'"> ';
			 										 }?>
                                           </td>
                                          </tr> 
                                          
                                          <?php } else{ ?>
                                            <tr>
                                                 <td colspan="4" height="300" align="center"><?=NOT_SPECIFIED?></td>
                                             </tr>
                                            <?php } ?>
                                            <?php if(!empty($_GET['e'])){
											  	echo '<tr><td>&nbsp;</td>  <td align="" height="135" valign="top"><br><input type="hidden" name="CustId" id="CustId" value="'.$Customer_ID.'">
											  	 <input type="hidden" value="'.$arryBillShipp[0]['state_id'].'" id="main_state_id" name="main_state_id">
											  	<input type="hidden" name="main_city_id" id="main_city_id" value="'.$arryBillShipp[0]['city_id'].'">
											    <input type="hidden" name="AddType" value="'.$_GET['tab'].'">
											    <input type="hidden" name="tab" value="'.$_GET['tab'].'">
											  	<input name="Submit" type="submit" class="button" id="updateBilling" value="Update">&nbsp;</td>  </tr>';
											  }?>
                                        <?php }?>
										
  <? if($_REQUEST["tab"]=="bank"){ ?>  

			
		 <tr>
				 <td colspan="4">&nbsp;<div style="float:right;"><a href="dashboard.php?curP=1&tab=bank&e=1" class="fancybox"><img border="0" src="<?php echo _SiteUrl?>admin/images/edit.png"></a></div></td>
			</tr>	
			
		<tr>
			<td  align="right"   class="blackbold"  width="45%"> Bank Name : </td>
			<td   align="left" >
			 <?php if(empty($_GET['e'])){
			 echo (!empty($arryCustomer[0]['BankName']))?(stripslashes($arryCustomer[0]['BankName'])):(NOT_SPECIFIED);
			 }else{
			 	$v=!empty($arryCustomer[0]['BankName'])?stripslashes($arryCustomer[0]['BankName']):"";
			 	echo '<input type="text" name="BankName" maxlength="40" class="inputbox" id="BankName" value="'.$v.'"> ';
			 	
			 }?>
				</td>
		  </tr>	
		 <tr>
			<td  align="right"   class="blackbold"> Account Name  :</td>
			<td   align="left" >
				<?php if(empty($_GET['e'])){
			 echo (!empty($arryCustomer[0]['AccountName']))?(stripslashes($arryCustomer[0]['AccountName'])):(NOT_SPECIFIED);
			 }else{
			 	$v=!empty($arryCustomer[0]['AccountName'])?stripslashes($arryCustomer[0]['AccountName']):"";
			 	echo '<input type="text" name="AccountName" maxlength="30" class="inputbox" id="AccountName" value="'.$v.'"> ';
			 	
			 }?>				
				 </td>
		  </tr>	  
		  <tr>
			<td  align="right"   class="blackbold"> Account Number  : </td>
			<td   align="left" >
				<?php if(empty($_GET['e'])){
				 echo (!empty($arryCustomer[0]['AccountNumber']))?(stripslashes($arryCustomer[0]['AccountNumber'])):(NOT_SPECIFIED);
				 }else{
			 	$v=!empty($arryCustomer[0]['AccountNumber'])?stripslashes($arryCustomer[0]['AccountNumber']):"";
			 	echo '<input type="text" name="AccountNumber" maxlength="30" class="inputbox" id="AccountNumber" value="'.$v.'"> ';
			 	
				 }?>			
				 </td>
		  </tr>	
		   <tr>
			<td  align="right"   class="blackbold">Routing Number : </td>
			<td   align="left" >
				<?php if(empty($_GET['e'])){
				 echo (!empty($arryCustomer[0]['IFSCCode']))?(stripslashes($arryCustomer[0]['IFSCCode'])):(NOT_SPECIFIED);
				 }else{
			 	$v=!empty($arryCustomer[0]['IFSCCode'])?stripslashes($arryCustomer[0]['IFSCCode']):"";
			 	echo '<input type="text" name="IFSCCode" maxlength="30" class="inputbox" id="IFSCCode" value="'.$v.'"> ';
			 	
				 }?>				
				 </td>
		  </tr>	
		  <?php if(!empty($_GET['e'])){
		  	echo '<tr><td>&nbsp;</td>  <td align="" height="135" valign="top"><br><input type="hidden" name="CustId" id="CustId" value="'.$Customer_ID.'">
		  	<input name="Submit" type="submit" class="button" id="UpdateBank" value="Update">&nbsp;</td>  </tr>';
		  }?>
		  
		  <tr>
				 <td colspan="4">&nbsp;</td>
			</tr>
			
	  <? } ?>

</table>
                                  
   </form>        

<?php } } ?>	  
	
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 900
		 });

});

</script>
