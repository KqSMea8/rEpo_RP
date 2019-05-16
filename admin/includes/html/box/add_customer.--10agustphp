<?php
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/sales.class.php");
	require_once($Prefix."classes/function.class.php");
        require_once($Prefix."classes/field.class.php"); //By Chetan//
        
	$objFunction=new functions();        
	$objCustomer=new Customer();
	$objCommon=new common();         
         $objField = new field();	//By Chetan//

	$CustId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
	$ListUrl = "editCustomer.php?curP=".$_GET['curP'];
	$ListTitle = "Customers";
	$ModuleTitle = "Add Customer";
	$ModuleName = "Customer";
              
         //By Chetan//
        $ArrCustomFields = $objField->getAllCustomFieldByModule('Customer');
        $ArrField = array_map(function($a) {
                                                  return $a['fieldid'];
                                                }, $ArrCustomFields);
        $ArrFieldName = array_map(function($a) {
                                                  return $a['fieldname'];
                                                }, $ArrCustomFields);

        $StrField = join(',',  $ArrField);
        $StrFieldName = join(',',  $ArrFieldName);
        
        $arryHead=$objField->getHead('',$ModuleParentID,1);
        
        //End//
        
        

	if ($_POST) {
		CleanPost();

		/*************************/
		$ValidateData = array(  
			array("name" => "CustomerType", "label" => "Customer Type", "select" => "1"),      
			array("name" => "Email", "label" => "Email" , "type" => "email", "opt" => "1")
				
		);

		$ValidateErrorMsg = $objFunction->ValidatePostData($ValidateData);
		if(!empty($_POST['Email'])){	
			/********Connecting to main database*********/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/					
			$_GET['ref_id'] = $_POST['CustId'];
			$_GET['user_type'] = 'Customer';
			$_GET['CmpID'] = $_SESSION['CmpID'];
			$_GET['Email'] = $_POST['Email'];	
				
			if($objConfig->isUserEmailDuplicate($_GET)){	
				$ValidateErrorMsg .= '<br>'.EMAIL_ALREADY_REGISTERED;
			}								
		}
		if(!empty($ValidateErrorMsg)){							
			$_SESSION['mess_cust'] = $ValidateErrorMsg;	
			$ActionUrl = 'addCustomer.php';		
			header("Location:".$ActionUrl);
			exit;
		}					
		/********Connecting to main database*********/
		$Config['DbName'] = $_SESSION['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/







		$_SESSION['mess_cust'] = CUSTOMER_ADDED;
		$addCustId =  $objCustomer->addCustomer($_POST);
                
                   //By Chetan//
               $fieldIDs = explode(',',$_POST['fieldIds']);
                $fieldNames = explode(',',$_POST['fields']);
                if($addCustId>0){
                $objField->updateModuleForm($_POST,$addCustId,$fieldIDs,$fieldNames);
                }
                //End//
                
		$_POST['PrimaryContact']=1;
		$AddID = $objCustomer->AddContactByCustomer($_POST,$addCustId,'contact');
	
			/*****ADD COUNTRY/STATE/CITY NAME****/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/***********************************/

			$arryCountry = $objRegion->GetCountryName($_POST['Country']);
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
			/**************END COUNTRY NAME*********************/

			$_POST['PrimaryContact']=0;
			$billingID = $objCustomer->AddContactByCustomer($_POST,$addCustId,'billing');	
			$objCustomer->UpdateCountryStateCity($arryRgn,$billingID);

			$shippingID = $objCustomer->AddContactByCustomer($_POST,$addCustId,'shipping');	
			$objCustomer->UpdateCountryStateCity($arryRgn,$shippingID);




		
		if($_FILES['Image']['name'] != ''){
	
			$FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");
			if(empty($FileArray['ErrorMsg'])){
				$ImageExtension = GetExtension($_FILES['Image']['name']); 

			$imageName = $addCustId.".".$ImageExtension;				
			$MainDir = "../upload/customer/".$_SESSION['CmpID']."/";						
			if (!is_dir($MainDir)) {
			mkdir($MainDir);
			chmod($MainDir,0777);
			}
			$ImageDestination = $MainDir.$imageName;						
			if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
			$objCustomer->UpdateImage($imageName,$addCustId);
			$objConfigure->UpdateStorage($ImageDestination,$OldImageSize,0);
			}
		  }
	      else{
			$ErrorMsg = $FileArray['ErrorMsg'];
		  }
	
		if(!empty($ErrorMsg)){
			if(!empty($_SESSION['mess_cust'])) $ErrorPrefix = '<br><br>';
			$_SESSION['mess_cust'] .= $ErrorPrefix.$ErrorMsg;
		}		
		  
	 }          
		$_SESSION['mess_cust'] .= ' Create Login Detail Here';			
        $ListUrl = "editCustomer.php?edit=".$addCustId."&curP=".$_GET['curP']."&tab=LoginPermission";
        header("location:".$ListUrl);
        exit;
   }
				

	 
$arryPaymentTerm = $objConfigure->GetTerm('','1');
$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','');
 
 ?>

<script language="JavaScript1.2" type="text/javascript">



$(document).ready(function(){
//Company Hide Show
 $("#CustomerType").change(function(){
    
    var str = $(this).val();
    if(str == "Company"){
        $("#showCompany").show();
		$("#Company").show();
		$("#fred").hide();  $("#lred").hide();
		$("#custnametr").show();
	 } else if(str == "Individual"){
		 $("#showCompany").hide();
		$("#Company").hide();
		$("#fred").show();  $("#lred").show();
		$("#custnametr").show();
    }else{
        $("#showCompany").hide();
		$("#Company").hide();
		$("#fred").show();  $("#lred").show();
		$("#custnametr").hide();
    }
     
 });
 
var custType = $("#CustomerType").val();
	if(custType == "Company"){
		$("#showCompany").show();
		$("#Company").show();
		$("#fred").hide();  $("#lred").hide();
		$("#custnametr").show();
	}else if(custType == "Individual"){
		 $("#showCompany").hide();
		$("#Company").hide();
		$("#fred").show();  $("#lred").show();
		$("#custnametr").show();
    }else{
		$("#showCompany").hide();
		$("#Company").hide();
		$("#fred").show();  $("#lred").show();
		$("#custnametr").hide();
	
    }
//End



$("#SaveCustomer").click(function(){

		    var frm = document.form1;
                    var FirstName = $.trim($("#FirstName").val());
                    var LastName = $.trim($("#LastName").val());
                    var Mobile = $.trim($("#Mobile").val());
                    var email = $.trim($("#Email").val());
                    var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    var gender = $.trim($("#Gender").val());
                    var CustomerType = $.trim($("#CustomerType").val());
                    var Company = $.trim($("#Company").val());
                    var CustID = $.trim($("#CustId").val());
                    var Address = $.trim($("#Address").val());
                    var main_state_id = $.trim($("#main_state_id").val());
                    var main_city_id = $.trim($("#main_city_id").val());
                    var OtherState = $.trim($("#OtherState").val());
                    var OtherCity = $.trim($("#OtherCity").val());
                    var ZipCode = $.trim($("#ZipCode").val());
                    var CustCode = $.trim($("#CustCode").val());
					var ImageName = $("#Image").val();
					
					if(CustCode!=''){
						if(!ValidateMandRange(document.getElementById("CustCode"), "Customer Code",3,20)){
							return false;
						}
						DataExist = CheckExistingData("isRecordExists.php","&CustCode="+escape(CustCode), "CustCode","Customer Code");
						if(DataExist==1)  return false;

					}
	
                   if(CustomerType == "")
                    {
                        alert("Please Select Customer Type.");
                        $("#CustomerType").focus();
                        return false;
                    }
				   if(!ValidateOptionalUpload(frm.Image, "Image")){
				        $("#Image").focus();
						return false;
					} 
				   if(Company == "" && CustomerType == "Company")
                    {
                        alert("Please Enter Company.");
                        $("#Company").focus();
                        return false;
                    }
                    if(FirstName == "" && CustomerType == "Individual")
                    {
                        alert("Please Enter First Name.");
                        $("#FirstName").focus();
                        return false;
                    }

                    if(LastName == "" && CustomerType == "Individual")
                    {
                        alert("Please Enter Last Name.");
                        $("#LastName").focus();
                        return false;
                    }
                                       
                   
                   if(email != "")
                    {
                     
                    if(!emailRegister.test(email))
                    {
                        alert("Please Enter Valid Email Address.");
                        $("#Email").focus();
                        return false;

                    } 
                    
                     DataExist = CheckExistingData("isRecordExists.php", "&Type=Customer&Email="+email+"&editID="+CustID, "Email","Email Address");
	             if(DataExist==1)return false;
                     
					}
					 
					 
					 
                    if(Address == "")
                    {
                        alert("Please Enter Address.");
                        $("#Address").focus();
                        return false;
                    }
                    if((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
                    {
                        alert("Please Enter State.");
                        $("#OtherState").focus();
                        return false;
                    }

                    if((main_city_id == "" || main_city_id== "0") && (OtherCity == ""))
                    {
                        alert("Please Enter City.");
                        $("#OtherCity").focus();
                        return false;
                    }

                    if(ZipCode == "")
                    {
                        alert("Please Enter Zip Code.");
                        $("#ZipCode").focus();
                        return false;
                    } 
                    
                   /*if(Mobile == "")
                    {
                        alert("Please Enter Mobile Number.");
                        $("#Mobile").focus();
                        return false;
                    }*/
                  
             

                    ShowHideLoader('1','S');
                });


 });

</script>

<a href="viewCustomer.php" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>
    <span>&raquo;
	<?php 	echo "Add ".$ModuleName; ?>
   </span>
</div>

 <div  align="center"  class="message"  >
          <?php if(!empty($_SESSION['mess_cust'])) {echo $_SESSION['mess_cust']; unset($_SESSION['mess_cust']); }?>	
        </div>
              <form name="form1" action="" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="tab" value="<?=$_REQUEST['tab']?>">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                           
                                        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
										<tr>
										 <td colspan="4" align="left" class="head"><?=$arryHead[0]['head_value']?></td>
										</tr>

											 <tr>
                                                <td  align="right" valign="top"  class="blackbold"> 
                                                    Customer Code : </td>
                                                <td  colspan="3" align="left" valign="top">
                                                    <input  name="CustCode" id="CustCode" value="" type="text" class="datebox" maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SuppCode');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_SuppCode','CustCode','');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
													<span id="MsgSpan_SuppCode"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td width="20%" align="right" class="blackbold"> Customer Type  :<span class="red">*</span> </td>
                                            <td width="30%" align="left">
                                                     <select id="CustomerType" class="inputbox" name="CustomerType">
                                                    <option value="">--- Select ---</option>
                                                            <option value="Individual">Individual</option>
                                                            <option value="Company" selected>Company</option>
                                                     </select>
                                               </td>
                                       
                                                <td width="20%" align="right" valign="top"   class="blackbold"> 
                                                  <div style="display: none;" id="showCompany">Company : <span class="red">*</span></div></td>
                                                <td   align="left" valign="top">
                                                    <input  name="Company" id="Company" value="" type="text" class="inputbox"  maxlength="60" />
                                                </td>
                                             </tr>

 <tr style="display:none">
													<td  align="right"   class="blackbold"> Currency  :</td>
													<td   align="left" >
													<?
													$Config['DbName'] = $Config['DbMain'];
													$objConfig->dbName = $Config['DbName'];
													$objConfig->connect();
													$arryCurrency = $objRegion->getCurrency('',1);

													if(!empty($arrySupplier[0]['Currency'])){
														$CurrencySelected = $arrySupplier[0]['Currency']; 
													}else{
														$CurrencySelected = 'USD';
													}
													?>
														<select name="Currency" class="inputbox" id="Currency">
														  <? for($i=0;$i<sizeof($arryCurrency);$i++) {?>
														  <option value="<?=$arryCurrency[$i]['code']?>" <?  if($arryCurrency[$i]['code']==$CurrencySelected){echo "selected";}?>>
														  <?=$arryCurrency[$i]['name']?>
														  </option>
														  <? } ?>
														</select>       
													</td>
											


<tr id="custnametr" style="display:none">
                                                <td  align="right" valign="top"  class="blackbold"> 
                                                    First Name : <span class="red" id="fred">*</span> </td>
                                                <td   align="left" valign="top">
                                                    <input  name="FirstName" id="FirstName" value="" type="text" class="inputbox"  maxlength="40" />
                                                </td>
                                           
                                                <td  align="right" valign="top"   class="blackbold"> 
                                                    Last Name :<span class="red" id="lred">*</span> </td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="LastName" id="LastName" value="" type="text" class="inputbox"  maxlength="40" />
                                                </td>
                                            </tr>
                                             <tr>
                                                <td  align="right" valign="top"   class="blackbold"> 
                                                    Gender : </td>
                                                <td  align="left" valign="top"  class="blacknormal">
                                                    <select name="Gender" class="inputbox" id="Gender">
                                                        <option value="">---Select---</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>        
                                                </td>
                                           
                                                <td  align="right" valign="top" class="blackbold"> 
                                                    Email :  </td>
                                                <td   align="left" valign="top">
                                                    <input  name="Email" id="Email"  value="" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Customer','<?=$_GET['edit']?>');" type="text" class="inputbox"  maxlength="80" />
                                                     <div id="MsgSpan_Email"></div>
                                                </td>
                                            </tr>




</tr>


											<tr>
												<td  align="right"   class="blackbold" >Customer Since :</td>
												<td   align="left" >

											<script type="text/javascript">
											$(function() {
											$('#CustomerSince').datepicker(
												{
												showOn: "both",
												yearRange: '<?=date("Y")-50?>:<?=date("Y")?>', 
												maxDate: "-1D", 
												dateFormat: 'yy-mm-dd',
												changeMonth: true,
												changeYear: true

												}
											);
											});
											</script>

											
											<input id="CustomerSince" name="CustomerSince" readonly="" class="datebox" value=""  type="text" > 


											</td>
										
											<td  align="right" class="blackbold">Payment Term  :</td>
											<td   align="left">
											  <select name="PaymentTerm" class="inputbox" id="PaymentTerm">
												<option value="">--- None ---</option>
													<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
															$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
													?>
														<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arrySupplier[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
													<? } ?>
											</select> 
											</td>
									</tr>
									

									<tr>
											<td  align="right" class="blackbold">Payment Method  :</td>
											<td   align="left">
											  <select name="PaymentMethod" class="inputbox" id="PaymentMethod">
												<option value="">--- None ---</option>
													<? for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
														<option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arrySupplier[0]['PaymentMethod']){echo "selected";}?>>
														<?=$arryPaymentMethod[$i]['attribute_value']?>
												</option>
													<? } ?>
											</select> 
											</td>
									


		<td  align="right" class="blackbold">Shipping Method  :</td>
		<td   align="left">
		  <select name="ShippingMethod" class="inputbox" id="ShippingMethod">
			<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
					<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arryCustomer[0]['ShippingMethod']){echo "selected";}?>>
					<?=$arryShippingMethod[$i]['attribute_value']?>
			</option>
				<? } ?>
		</select> 
		</td>
</tr>






									<tr>
										<td  align="right"    class="blackbold" valign="top"> Upload Photo  :</td>
										<td  align="left"  >
										
										<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	

								
										</td>
									   
 


		<td  align="right" class="blackbold">Taxable  :</td>
		<td   align="left">

<input type="checkbox" name="Taxable" id="Taxable" value="Yes" <?  if($arryCustomer[0]['Taxable']=='Yes'){echo "checked";}?>>
	
		</td>
</tr>


		<tr>





											<td  align="right"   class="blackbold">Status  : </td>
											<td   align="left"  >
											 
											  <input type="radio" name="Status" id="Status" value="Yes" checked />
											  Active&nbsp;&nbsp;&nbsp;&nbsp;
											  <input type="radio" name="Status" id="Status" value="No"  />
											  InActive </td>
										</tr>
										</tr>
<?php
//By chetan//
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/******************** Code ****************************/
 $arryField = $objField->getFormField('',$arryHead[0]['head_id'],'1'); 

include("includes/html/box/customfields.php");

//////////End ////////////////////////////

?>    										  
                                                                                   
										  
                                            <tr>
                                                <td colspan="4" align="left" class="head">Contact Information </td>
                                            </tr>
											  
                                            
                                            <tr>
                                                <td valign="top" align="right" class="blackbold">Address  :<span class="red">*</span></td>
                                                <td align="left">
                                                  <textarea id="Address" class="textarea" type="text" name="Address" maxlength="250"></textarea></td>
                                             </tr>
                                              <tr>
                                                <td  align="right"   class="blackbold"> Country : <span class="red">*</span></td>
                                                <td   align="left" >
                                                    <?php
                             $CountrySelected = $arryCurrentLocation[0]['country_id'];
                                                    ?>
                                                    <select name="Country" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
                                                        <?php for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                                            <option value="<?= $arryCountry[$i]['country_id'] ?>" <?php if ($arryCountry[$i]['country_id'] == $CountrySelected) {
                                                            echo "selected";
                                                        } ?>>
                                                            <?= $arryCountry[$i]['name'] ?>
                                                            </option>
                                                            <?php } ?>
                                                    </select>        
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State : <span class="red">*</span></td>
                                             <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State : <span class="red">*</span></div> </td>
                                                <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value=""  maxlength="30" /> </div>           </td>
                                            </tr>
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City : <span class="red">*</span></div></td>
                                                <td  align="left"  ><div id="city_td"></div></td>
                                            </tr> 
                                            <tr>
                                                <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City : <span class="red">*</span></div>  </td>
                                                <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value=""  maxlength="30" />  </div>          </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top" class="blackbold">Zip Code : <span class="red">*</span> </td>
                                                <td   align="left" valign="top">
                                                    <input  name="ZipCode" id="ZipCode" value="<?= stripslashes($arryCustomer[0]['ZipCode']) ?>" type="text" class="inputbox"  maxlength="20" />
                                                </td>
                                            </tr>
                                              <tr>
                                                <td  align="right" valign="top" class="blackbold"> 
                                                    Mobile :  </td>
                                                <td   align="left" valign="top">
 <input  name="Mobile" id="Mobile" value=""  type="text" class="inputbox" maxlength="20"  onkeypress="return isNumberKey(event);"/>
                                                   
                                                </td>
                                             </tr>
                                              <tr>
                                                <td align="right" valign="top"   class="blackbold"> 
                                                    Landline  : </td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="Landline" id="Landline" value="" type="text"  class="inputbox"   maxlength="20"  onkeypress="return isNumberKey(event);"/>
                                                  
                                                </td>
                                             </tr>
                                            
                                          
                                             <tr>
                                                <td  align="right" valign="top"   class="blackbold"> 
                                                    Fax :</td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="Fax" id="Fax" value="<?= stripslashes($arryCustomer[0]['Fax']) ?>" type="text" class="inputbox"  maxlength="20" />
                                                </td>
                                            </tr>
                                           
                                          
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> 
                                                    Website :  </td>
                                                <td   align="left" valign="top">
                                                    <input  name="Website" id="Website" value="" type="text" class="inputbox"  maxlength="200"/>
                                                </td>
                                            </tr>
<?php      
/******************** Code ****************************/

 for($head=1;$head<sizeof($arryHead);$head++){?>
                
                    <tr>
                        <td colspan="4" align="left" class="head"><?=$arryHead[$head]['head_value']?></td>
                    </tr>

<?php $arryField = $objField->getFormField('',$arryHead[$head]['head_id'],'1'); 


include("includes/html/box/customfields.php"); 

 }
//head close?>  
                                            
                                            
                                        </table>
                                   
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top">
                            <input type="hidden" value="" id="main_state_id" name="main_state_id">		
                            <input type="hidden" name="main_city_id" id="main_city_id"  value="" />
                            <input name="Submit" type="submit" class="button" id="SaveCustomer" value="Submit" />&nbsp;
                            <!--By Chetan-->
                                <input type="hidden" name="fieldIds" value="<?=$StrField?>">
                                <input type="hidden" name="fields" value="<?=$StrFieldName?>">
                          <!--End-->
                        </td>    
                    </tr>

                </table>
               </form>
           



