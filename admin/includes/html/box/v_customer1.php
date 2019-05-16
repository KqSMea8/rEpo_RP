<?php 
	require_once($Prefix."classes/sales.customer.class.php");
	$objCustomer=new Customer();  
	
	$ModuleName = "Customer";
	$RedirectURL = "viewCustomer.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="contact";

	$EditUrl = "editCustomer.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vCustomer.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&tab="; 


	if (!empty($_GET['view'])) {
		$arryCustomer = $objCustomer->GetCustomer($_GET['view'],'','');
		$CustID   = $_REQUEST['view'];	
                $arryBillShipp = $objCustomer->GetShippingBilling($_GET['view'],$_GET['tab']);
		if(empty($arryCustomer[0]['Cid'])){
			$ErrorMSG = CUSTOMER_NOT_EXIST;
		}

	}else{
		header('location:'.$RedirectURL);
		exit;
	}

      
       

	if($_GET['tab']=='shipping'){
		$SubHeading = 'Shipping Address';
	}else if($_GET['tab']=='billing'){
		$SubHeading = 'Billing Address';	
     	}else{
		$SubHeading = ucfirst($_GET["tab"])." Information";
	}


?>

<a class="back" href="<?=$RedirectURL?>">Back</a> 
<?php
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>

		<a href="<?=$EditUrl?>" class="edit">Edit</a> 
		<div class="had"><?=$MainModuleName?>  <span> &raquo;	<?php 	echo $SubHeading; ?>	</span>
		</div>


                                        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
										
		<?php if($_REQUEST['tab'] == "general"){?>  
		<tr>
		 <td colspan="2" align="left" class="head">General Information</td>
		</tr>

		 <tr>
		<td width="45%"  align="right" valign="top"  class="blackbold"> 
		Customer Code : </td>
		<td   align="left" valign="top">
		<?=stripslashes($arryCustomer[0]['CustCode'])?>
		</td>
		</tr>
		<tr>
		<td align="right" class="blackbold"> Customer Type  : </td>
		<td align="left"><?=$arryCustomer[0]['CustomerType']?></td>
		</tr>

<? if($arryCustomer[0]['CustomerType']=='Company'){ ?>  
		<tr>
		<td  align="right" valign="top"   class="blackbold"> 
		Company : </td>
		<td  align="left">
		<?=(!empty($arryCustomer[0]['Company']))?($arryCustomer[0]['Company']):(NOT_SPECIFIED)?>
		</td>
		</tr>
<? } ?>
 <tr style="display:none">
	<td  align="right"   class="blackbold" > Currency :</td>
	<td   align="left" >
	<?=$arryCustomer[0]['Currency']?>
	  </td>
  </tr>

 <tr>
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
	</tr>

	<tr>
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
	</tr>

	<tr>
		<td  align="right"   class="blackbold" >Status  : </td>
		<td   align="left"  >
		<?  echo ($arryCustomer[0]['Status'] == "Yes")?("Active"):(" InActive");
		?>
		</td>
	</tr>		
<?php }?>
         
  <?php if($_REQUEST['tab'] == "contact"){ ?>  
                                       
            <tr>
                <td colspan="2" align="left" class="head">Contact Information </td>
            </tr>
           
            <tr>
                <td width="45%" align="right" valign="top"  class="blackbold"> 
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
                <td width="30%" align="right" valign="top" class="blackbold">Zip Code :  </td>
                 
                 <td  align="left"><?=stripslashes($arryCustomer[0]['ZipCode'])?></td>
            </tr>
             <tr>
                <td align="right" valign="top" class="blackbold"> 
                    Mobile :  </td>
                
                 <td  align="left"><?=stripslashes($arryCustomer[0]['Mobile'])?></td>
            </tr>
             <tr>
                <td width="30%" align="right" valign="top"   class="blackbold"> 
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
         <?php if($_REQUEST['tab'] == "billing" || $_REQUEST['tab'] == "shipping"){
                                            
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
                                            <tr>
                                                <td colspan="2" align="left" class="head"><?=$SubHeading?> </td>
                                            </tr>
                                            <?php 
                                            
                                            if($NumBillShipp>0){ ?>
                                            <tr>
                                                <td width="45%" align="right" valign="top" class="blackbold"> <?=$BillShipp?> Name : </td>
                                                <td align="left" valign="top">
                                                   <?= stripslashes($arryBillShipp[0]['FullName']) ?>
                                                </td>
                                            </tr>
                                           <tr>
                                            <td align="right"   class="blackbold"><?=$BillShipp;?> Email  : </td>
                                            <td  align="left" ><?=stripslashes($arryBillShipp[0]['Email'])?> </td>
                                           </tr> 
                                            <tr>
                                                <td  align="right" valign="top" class="blackbold">  Address : </td>
                                                <td  align="left" valign="top">
                                                   <?=stripslashes($arryBillShipp[0]['Address']) ?>
                                                </td>
                                            </tr>
                                           

                                            <tr>
                                                <td  align="right"   class="blackbold"> Country : </td>
                                                <td   align="left" >
                                                  <?=$CountryName;?>  
                                                </td>
                                            </tr>
                                            <tr>
                                              <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State : </td>
                                             <td  align="left"  class="blacknormal"><?=$StateName;?></td>
                                            </tr>
                                           
                                            <tr>
                                                <td  align="right" class="blackbold"> City : </td>
                                                <td  align="left"><?=$CityName;?></td>
                                            </tr> 
                                          
                                            <tr>
                                                <td  align="right" valign="top" class="blackbold">Zip Code : </td>
                                                <td   align="left" valign="top">
                                                    <?= stripslashes($arryBillShipp[0]['ZipCode']) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td align="right"   class="blackbold" >Mobile  :</td>
                                            <td  align="left"  >
                                            <?=stripslashes($arryBillShipp[0]['Mobile'])?>

                                             </td>
                                          </tr>

                                               <tr>
                                            <td  align="right"   class="blackbold">Landline  :</td>
                                            <td   align="left" >
                                              <?=(!empty($arryBillShipp[0]['Landline']))?($arryBillShipp[0]['Landline']):(NOT_SPECIFIED)?>
                                             </td>
                                          </tr>

                                          <tr>
                                            <td align="right"   class="blackbold">Fax  : </td>
                                            <td  align="left" > <?=(!empty($arryBillShipp[0]['Fax']))?($arryBillShipp[0]['Fax']):(NOT_SPECIFIED)?></td>
                                          </tr> 
                                          
                                          <?php } else{ ?>
                                            <tr>
                                                 <td colspan="2" height="300" align="center"><?=NOT_SPECIFIED?></td>
                                             </tr>
                                            <?php } ?>

                                         
                                        <?php }?>
										
  <? if($_REQUEST["tab"]=="bank"){ ?>  
		 <tr>
				 <td colspan="2" align="left" class="head">Bank Details</td>
			</tr>
			
		 <tr>
				 <td colspan="2">&nbsp;</td>
			</tr>	
			
		<tr>
			<td  align="right"   class="blackbold"  width="45%"> Bank Name : </td>
			<td   align="left" >
			 
			 <?=(!empty($arryCustomer[0]['BankName']))?(stripslashes($arryCustomer[0]['BankName'])):(NOT_SPECIFIED)?>
				</td>
		  </tr>	
		 <tr>
			<td  align="right"   class="blackbold"> Account Name  :</td>
			<td   align="left" >
				
				 <?=(!empty($arryCustomer[0]['AccountName']))?(stripslashes($arryCustomer[0]['AccountName'])):(NOT_SPECIFIED)?>
				 </td>
		  </tr>	  
		  <tr>
			<td  align="right"   class="blackbold"> Account Number  : </td>
			<td   align="left" >
				
				<?=(!empty($arryCustomer[0]['AccountNumber']))?(stripslashes($arryCustomer[0]['AccountNumber'])):(NOT_SPECIFIED)?>
				 </td>
		  </tr>	
		   <tr>
			<td  align="right"   class="blackbold">Routing Number : </td>
			<td   align="left" >
				
				<?=(!empty($arryCustomer[0]['IFSCCode']))?(stripslashes($arryCustomer[0]['IFSCCode'])):(NOT_SPECIFIED)?>
				 </td>
		  </tr>	
		  
		  <tr>
				 <td colspan="2">&nbsp;</td>
			</tr>
			
	  <? } ?>

</table>
                                  
           

<?php }?>	  
	

