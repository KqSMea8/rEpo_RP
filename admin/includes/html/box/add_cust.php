<?
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/sales.class.php");
	require_once($Prefix."classes/function.class.php"); 	
	$objCustomer=new Customer();
	$objCommon=new common();         
       	$objFunction=new functions(); 

        $RedirectURL = "viewCustomer.php?curP=".$_GET['curP'];
        $ListTitle = "Customers";
        $ModuleTitle = "Add Customer";
        $ModuleName = "Customer"; 

	if($_POST) {
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
			$ActionUrl = 'addCust.php';		
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

		$_POST['PrimaryContact']=1;
		$AddID = $objCustomer->AddContactByCustomer($_POST,$addCustId,'contact');

		$_POST['PrimaryContact']=0;
		$billingID = $objCustomer->AddContactByCustomer($_POST,$addCustId,'billing');	
		$shippingID = $objCustomer->AddContactByCustomer($_POST,$addCustId,'shipping');

		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;
	}		

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





 	$("#addCust").click(function(){
                    var FirstName = $.trim($("#FirstName").val());
                    var LastName = $.trim($("#LastName").val());
                    var Mobile = $.trim($("#Mobile").val());
                    var email = $.trim($("#Email").val());
                    var emailRegister = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    var CustomerType = $.trim($("#CustomerType").val());
                    var Company = $.trim($("#Company").val());
                    var CustID = $.trim($("#CustId").val());
                    var CustCode = $.trim($("#CustCode").val());
					
					
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
				  
				   if(Company == "" && CustomerType == "Company")
                    {
                        alert("Please Enter Company");
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

                    
                    
                     
                     
                   /*if(Mobile == "")
                    {
                        alert("Please Enter Mobile Number.");
                        $("#Mobile").focus();
                        return false;
                    }*/
                  

			$("#prv_msg_div").show();			
			$("#preview_div").hide();

                });


 });
</script>

 <div  align="center"  class="message"  >
          <?php if(!empty($_SESSION['mess_cust'])) {echo $_SESSION['mess_cust']; unset($_SESSION['mess_cust']); }?>	
        </div>
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<div class="had">&nbsp;&nbsp;Add Customer</div>
<div >
              <form name="form1" action="" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="tab" value="<?=((!empty($_GET) && $_GET['tab']!='') ? $_GET['tab'] : '');?>">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" valign="top" >
                                        <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall">
										
											 <tr>
                                                <td align="right" valign="top"  class="blackbold"> 
                                                    Customer Code : </td>
                                                <td colspan="3" align="left" valign="top">
                                                    <input  name="CustCode" id="CustCode" value="" type="text" class="datebox" maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SuppCode');return isUniqueKey(event);" oncontextmenu="return false" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_SuppCode','CustCode','');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
													<span id="MsgSpan_SuppCode"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td  align="right" class="blackbold"> Customer Type  :<span class="red">*</span> </td>
                                            <td align="left">
                                                     <select id="CustomerType" class="inputbox" name="CustomerType">
                                                    <option value="">--- Select ---</option>
                                                            <option value="Individual">Individual</option>
                                                            <option value="Company" selected>Company</option>
                                                     </select>
                                               </td>
                                          
                                         
                                                <td align="right" valign="top"   class="blackbold" > 
                                                    <div style="display: none;" id="showCompany">Company : <span class="red">*</span></div></td>
                                                <td  align="left" valign="top">
                                                   

 <input  name="Company" id="Company" value="" type="text" class="inputbox"  maxlength="60" />
                                                </td>
                                             </tr>

 
								    
                                       
                                           <tr id="custnametr" style="display:none">
                                                <td  align="right" valign="top"  class="blackbold"> 
                                                    First Name : <span class="red" id="fred">*</span> </td>
                                                <td   align="left" valign="top">
                                                    <input  name="FirstName" id="FirstName" value="" type="text" class="inputbox"  maxlength="40" />
                                                </td>
                                           
                                                <td   align="right" valign="top"   class="blackbold"> 
                                                    Last Name :<span class="red" id="lred">*</span> </td>
                                                <td  align="left"  class="blacknormal">
                                                    <input  name="LastName" id="LastName" value="" type="text" class="inputbox"  maxlength="40" />
                                                </td>
                                            </tr>
                                            
                                            
                                          
                                             <tr>
                                                <td width="15%" align="right" valign="top" class="blackbold"> 
                                                    Email : </td>
                                                <td width="48%" align="left" valign="top">
                                                    <input  name="Email" id="Email"  value="" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Customer','<?=$_GET['edit']?>');" type="text" class="inputbox"  maxlength="80" />
                                                     <span id="MsgSpan_Email"></span>
                                                </td>
                                           
                                                <td  width="15%" align="right" valign="top" class="blackbold"> 
                                                    Mobile :  </td>
                                                <td  align="left" valign="top">
                                                    <input  name="Mobile" id="Mobile" onkeyup="keyup(this);" value=""  type="text" class="inputbox" maxlength="20"  onkeypress="return isNumberKey(event);"/>
                                                   
                                                </td>
                                             </tr>

 <tr>
                                                <td align="right" valign="top" class="blackbold"> 
                                                    Landline :  </td>
                                                <td  align="left" valign="top">
                                                     <input  name="Landline" id="Landline" value="" type="text"  class="inputbox" maxlength="20"  onkeypress="return isNumberKey(event);"/>
                                                   
                                                </td>
                                            
											<td align="right"   class="blackbold">Status  : </td>
											<td align="left">
											 
											  <input type="radio" name="Status" id="Status" value="Yes" checked  />
											  Active&nbsp;&nbsp;&nbsp;&nbsp;
											  <input type="radio" name="Status" id="Status" value="No"  />
											  Inactive </td>
										</tr>
										  
                                        </table>
                                    </td>
                                </tr>


                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <input name="Submit" type="submit" class="button" id="addCust" value="Submit" />&nbsp;
                        </td>    
                    </tr>

                </table>
               </form>
          
</div>

</div>
