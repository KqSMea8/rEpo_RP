<?php
		require_once($Prefix."classes/sales.customer.class.php");
		require_once($Prefix."classes/sales.class.php");
		require_once($Prefix."classes/function.class.php");
		require_once($Prefix."classes/field.class.php"); //By Chetan//
		require_once($Prefix."classes/finance.account.class.php");	
		require_once($Prefix."classes/sales.quote.order.class.php");//added by nisha on 13 sept 2018
		  

	$objFunction=new functions();        
	$objCustomer=new Customer();
	$objCommon=new common();         
  $objField = new field();	//By Chetan//
	$objBankAccount= new BankAccount();
  $objSale = new sale();

	$CustId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
	$ListUrl = "editCustomer.php?curP=".$_GET['curP'];
	$ListTitle = "Customers";
	$ModuleTitle = "Add Customer";
	$ModuleName = "Customer";
    if ($_POST) {
    $_SESSION['mess_cust'] = CUSTOMER_ADDED;
    $addCustId =  $objCustomer->addCustomer($_POST);
    //added by nisha on 13 sept for employee login.
    if($_SESSION['AdminType']=='employee'){
      $isCommisionExist = $objSale->GetUserCommision($_SESSION['AdminID']);
      if(!empty($isCommisionExist)){
        $arrayDetails = [];
        $arrayDetails['SalesPersonID']   = $isCommisionExist[0]['EmpID'];
        $arrayDetails['SalesPerson']     = $_SESSION['UserName'];
        $arrayDetails['SalesPersonType'] = 0;
        $arrayDetails['CustId'] = $addCustId;
        $objCustomer->UpdateSalesPerson($arrayDetails);
        $objCustomer->UpdateSalesPersonCommission($arrayDetails);
      }
    }
    //end code by nisha on 3sept 2018
    $_POST['PrimaryContact']=1;
    $AddID = $objCustomer->addCustomerAddress($_POST,$addCustId,'contact');
  
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
      $billingID = $objCustomer->addCustomerAddress($_POST,$addCustId,'billing'); 
      $objCustomer->UpdateCountryStateCity($arryRgn,$billingID);

      $shippingID = $objCustomer->addCustomerAddress($_POST,$addCustId,'shipping'); 
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
          
        $ListUrl = "editCustomer.php?edit=".$addCustId."&curP=".$_GET['curP']."&tab=general";
        header("location:".$ListUrl);
        exit;
   }
        

   
$arryPaymentTerm = $objConfigure->GetTerm('','1');
$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','');
          //By Chetan18Aug//
        $arryHead=$objField->getHead('','2015',1);
        $arryContHead=$objField->getHead('16',107,1);
        //End//
        
        //By Suneel custom array for vendor//update by chetan 28Feb  //

	if(!empty($_GET['vender'])) {
		require_once($Prefix."classes/supplier.class.php");
	           $objSupplier=new supplier();

		$arrySupplier = $objSupplier->GetSupplierforCustomer($_GET['vender'],'','');
		$SuppID   = $_GET['vender'];
		$SuppCode = $arrySupplier[0]['SuppCode'];	
		//print_r($arrySupplier);
		/********** User Detail **********/	
	
 	if($arrySupplier[0]['SuppType']=='Business')
		{
		$CustomerType='Company';
		}
	else 	{
		$CustomerType='Individual';
		}
		if($arrySupplier[0]['Status']=='1' || $arrySupplier[0]['Status']=='Active'){
		$Status='Yes';
		} else {
		$Status='No';
		}
		 
	$arryvender=array('CustomerType'=>$CustomerType, 'Company'=>$arrySupplier[0]['CompanyName'], 'FirstName'=>$arrySupplier[0]['FirstName'], 'LastName'=>$arrySupplier[0]['LastName'], 'Email'=>$arrySupplier[0]['Email'], 'CustomerSince'=>$arrySupplier[0]['SupplierSince'], 'PaymentTerm'=>$arrySupplier[0]['PaymentTerm'], 'PaymentMethod'=>$arrySupplier[0]['PaymentMethod'], 'ShippingMethod'=>$arrySupplier[0]['ShippingMethod'], 'Taxable'=>$arrySupplier[0]['TaxNumber'], 'Status'=>$Status, 'Address'=>$arrySupplier[0]['Address'],'country_id'=>$arrySupplier[0]['country_id'], 'state_id'=>$arrySupplier[0]['state_id'], 'city_id'=>$arrySupplier[0]['city_id'], 'OtherState'=>$arrySupplier[0]['OtherState'], 'OtherCity'=>$arrySupplier[0]['OtherCity'], 'ZipCode'=>$arrySupplier[0]['ZipCode'],'Mobile'=>$arrySupplier[0]['Mobile'], 'Landline'=>$arrySupplier[0]['Landline'], 'Website' => $arrySupplier[0]['Website'], 'CreditLimit'=>$arrySupplier[0]['CreditLimit'], 'DefaultAccount'=>$arrySupplier[0]['AccountID'],'Currency'=>$arrySupplier[0]['Currency']);

$arrayvalues = $arryvender; /*by suneel*/
	}
	


			

 ?>

<script language="JavaScript1.2" type="text/javascript">



//By Chetan5Aug//
$(function(){
    
    $('#Email').keypress(function(){  ClearAvail('MsgSpan_Email');});
    $('#Email').blur(function(){
        
        CheckAvail('MsgSpan_Email','Customer','<?=$_GET['edit']?>');
        
    });
    $('#Email').after('<div id="MsgSpan_Email"></div>');
    $('#CustCode').attr('maxlength', 20);
    $('#CustCode').keypress(function(e){  ClearAvail('MsgSpan_SuppCode');return isUniqueKey(e);});
    $('#CustCode').blur(function(){
        
        CheckAvailField('MsgSpan_SuppCode','CustCode','');
        
    });
      if($('#CustCode').attr('data-mand') == 'y'){
        $('#CustCode').mouseover(function(){  hideddrivetip(); });
    }else{
        $('#CustCode').mouseover(function(){  ddrivetip("<?=BLANK_ASSIGN_AUTO?>", 220,'');});
    }
    $('#CustCode').mouseout(function(){  hideddrivetip();});
    $('#CustCode').after('<span id="MsgSpan_SuppCode"></span>');
    
    //Company Hide Show  8Dec//updated by chetan on 1Mar2017//
    $("#CustomerType").change(function(e,param){

	var str = $(this).val();
	if(param =='' || typeof param === 'undefined')
	{  
		$('#Company').val('');
		$('#FirstName').val('');
		$('#LastName').val('');
		$("#Gender option").removeAttr("selected");
	}

        if(str == "Company"){
           $('#Company').closest('td').show().prev().show();
           $('#FirstName').closest('td').hide().prev().hide();
           $('#LastName').closest('td').hide().prev().hide();
           $('#Gender').closest('td').hide().prev().hide();
           $('#FirstName').attr('data-mand','n');
	   $('#LastName').attr('data-mand','n');
           $('#Gender').attr('data-mand','n');
       }else{
           $('#Company').closest('td').hide().prev().hide();
           $('#FirstName').closest('td').show().prev().show();
           $('#LastName').closest('td').show().prev().show();
           $('#Gender').closest('td').show().prev().show();
	   $('#FirstName').attr('data-mand','y');
	   $('#LastName').attr('data-mand','y');
           $('#Gender').attr('data-mand','y');
       }
    });
    
    $('#Company').closest('td').hide().prev().hide();
    
    $('#CustomerType').trigger('change', ["<?=$arrayvalues['Company']?>"]);// by suneel 7DEc//updated by chetan on 1Mar2017//


 $("#Taxable").click(function(){

       var str = $(this).val(); 
       $('#c_taxRate').val('');
	
//$('.coupon_question').is(":checked")
        if($(this).is(":checked")){
           $('#c_taxRate').closest('td').show().prev().show();
           
       }else{
           $('#c_taxRate').closest('td').hide().prev().hide();
          
       }
    });



var BaseCurrency = '<?=$Config["Currency"]?>';

$("#Currency").change(function(){
	var SelCurrency = $(this).val(); 	
	if(SelCurrency!='' && SelCurrency!=BaseCurrency && document.getElementById("CreditLimit") != null){			 
			jQuery('.creditlimittr').remove();			
			var html='<tr class="creditlimittr"><td align="right" class="blackbold">Credit Limit('+SelCurrency+'): </td><td class="creditlimittd"><input type="text" class="inputbox" name="CreditLimitCurrency" id="CreditLimitCurrency" maxlength="50" onkeypress="return isDecimalKey(event);"></td></tr>';				 			
			jQuery(this).parent('td').parent('tr').after(html);
	}else{
		jQuery('.creditlimittr').remove();
	}
});

 //$('#Currency').trigger('change');






    
     $("#form1").submit(function(){
        var err;
        $('div.red').html('');
	var stateDisplay = $("#state_td").css('display');
        $("#form1  :input[data-mand^=\'y\']").each(function(){
            
            $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
            $fldname = $(this).attr('name');
						$fldname = $fldname.replace('[]',''); //by niraj for multicheckbox
            if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
            {
              if( $.trim($(this).val()) == "")
              {
                if(($fldname == "OtherState" && ($('#state_id').val()!='' && typeof($('#state_id').val())!="undefined")) || 
                    ($fldname == "OtherCity" && ($('#city_id').val()!='' &&  typeof($('#city_id').val())!="undefined"))  ||
                     ($fldname == "Company" && ($.trim($('#CustomerType').val())=="" ||  $.trim($('#CustomerType').val())=="Individual") && $('#Company').closest('td').css('display')=="none")
                    ){}else{
                        
                        if($fldname == "OtherState" || $fldname == "OtherCity")
                        {
                            $input = ($(this).closest('td').prev('td').clone().children().remove().text()).replace(':*','');
                        }
                	if($fldname == "tel_ext"){  $input = 'Extension(Ext)'; } //by chetan 3Mar//

			if($fldname == "OtherState" && stateDisplay=='none'){
				//alert('hi');
			}else{
		                $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
		                err = 1;
			}
                }    
              }
              
             }/*else{
                 
                if($('#'+$fldname+':checked').length < 1)
                {
                     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                     err = 1;
                }
            }  */
else{//by niraj for checkbox 11feb16
                if($('input[name^="'+$fldname+'"]').length == 1)
		{ 
			if($('#'+$fldname+':checked').length < 1)
			{
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}
		}else{
			if($('input[name^="'+$fldname+'"]:checked').length < 1)
			{  
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}

		}
             }  
            
            
             if($fldname == "Email" && $(this).val()!= "")
               {    
                    emailID = $(this).val();

 		/* By Rajan 08 feb 
                    atpos = emailID.indexOf("@");
                    dotpos = emailID.lastIndexOf(".");
                    if (atpos < 1 || ( dotpos - atpos < 2 )) 
                 */ 

		// Added By Rajan 085 feb 2016 
                    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		    if(regex.test(emailID) == false)  
                    {
                        $("#"+$fldname+"err").html("Please enter correct email.");
                        err = 1; 
                    }
               }
               
          });
          

// BY Rajan 08 feb 2016
    	
    	if( $("#form1  :input[data-mand^=\'n\']") && $("#Email").val()!="" )
	{ 
		emailID =  $("#Email").val();
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(regex.test(emailID) == false)
		{ 
		$("#Email"+"err").html("Please enter correct email.");
		err = 1; 
		}
	}
    // End by Rajan 08 feb 2016
        if(err == 1){ return false; }else{ 
                    
            file = document.getElementById("Image");
            if(!ValidateOptionalUpload(file, "Image"))
            {
                $("#Image").focus();
                return false;
            } 
            if($('#CustCode').val()!=''){
                if(!ValidateMandRange(document.getElementById("CustCode"), "Customer Code",3,20)){
                    return false;
                }
                
                DataExist = CheckExistingData("isRecordExists.php","&CustCode="+escape($('#CustCode').val()), "CustCode","Customer Code");
                if(DataExist==1)  return false;
            }
            
            var email = $.trim($("#Email").val());
            var CustID = $.trim($("#CustId").val());
            DataExist = CheckExistingData("isRecordExists.php", "&Type=Customer&Email="+email+"&editID="+CustID, "Email","Email Address");
	    if(DataExist==1)return false;
        
            //return true;
            }
       });
    
        $dcarry = ['CreditLimit'];
          $('input').keypress(function(e){

             if($.inArray($(this).attr('name'),$dcarry ) != -1)
             {
                 return isDecimalKey(e);        
             }
          });


	 $farr = ['ZipCode','Landline','Mobile','Fax'];
          $('input').keypress(function(e){

             if($.inArray($(this).attr('name'),$farr ) != -1)
             {
                 return isNumberKey(e);        
             }
          });

    
        if($('#form1 input:checkbox').length>0){
         
        $('#form1 input:checkbox').click(function(){
            
          fldname = $(this).attr('name');
          if(!$(this).is(':checked'))
          { 
                $('<input>').attr({
                        type: 'hidden',
                        id: fldname,
                        name: fldname,
                        value:''
                }).appendTo('#form1');
          }else{
                $('input[name="'+fldname+'"][type="hidden"]').remove();
          }
            
        });
          
      }  
          
          
          
})

//End//

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
<form name="form1" id="form1" action="" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="tab" value="<?=$_REQUEST['tab']?>">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                           
                          <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                                

<?php
 
//By chetan27Aug//
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();

require_once($Prefix."classes/inv_tax.class.php");
$objTax = new tax();
$none ='style = "display:none;"' ;

$arryPurchaseTax = $objTax->GetTaxAll(1,'','');
//if($_GET['test']==1)  echo "<pre>"; print_r($arryPurchaseTax);
$head = 1;
for($h=0;$h<sizeof($arryHead);$h++){?>                 
                                
    <tr>
        <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
    </tr>

<?php 

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 

if($arryCurrentLocation[0]['country_id']!=106){
$arryField = array_map(function($arr){
            if($arr['fieldname'] == 'CST' || $arr['fieldname'] == 'PAN')       
            {
                unset($arr);
            }else{
                return $arr;
            }
        },$arryField);	
	
}
if($h == 0)
{
     //8DEc//
    $Narry = array_map(function($arr){
            //if($arr['fieldname'] == 'Website' || $arr['fieldname'] == 'Landline' || $arr['fieldname'] == 'Mobile')
            if($arr['fieldname'] == 'Landline' || $arr['fieldname'] == 'Mobile'  || $arr['fieldname'] == 'tel_ext')       
            {
                unset($arr);
            }else{
                return $arr;
            }
        },$arryField);
    $Addarry = array_map(function($arr){
            
            if($arr['fieldname'] == 'Landline' || $arr['fieldname'] == 'Mobile'  || $arr['fieldname'] == 'tel_ext')
            {
                return $arr;
            }else{
                 unset($arr);
            }
        },$arryField);  
    //End//    
    $arryField = array_values(array_filter($Narry));
}

include("includes/html/box/CustomFieldsNew.php"); 

?>

<?php

        if(count($arryContHead) > 0 && $h==0){?>

            <tr>
                <td colspan="8" align="left" class="head"><?=$arryContHead[0]['head_value']?></td>
            </tr>

    <?php
	
 
        $arryField = $objField->getFormField('',$arryContHead[0]['head_id'],'1'); 
	//8DEc//
        $Narry = array_map(function($arr){
            if($arr['fieldname'] == 'Landline' || $arr['fieldname'] == 'Mobile' || $arr['fieldname'] == 'contact')
            {
                unset($arr);
            }else{
                return $arr;
            }
        },$arryField);
        $arryField = array_values(array_filter($Narry)); 
        $arryField = array_merge($arryField, $Addarry);
        
         //End//
        include("includes/html/box/CustomFieldsNew.php");
        }
    ?>   

<?php 
}
//End//
?>
                                            
                                        </table>
                                   
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top">
                            <input type="hidden" value="<?php echo $arrayvalues['state_id']?>" id="main_state_id" name="main_state_id">		
                            <input type="hidden" name="main_city_id" id="main_city_id" value="<?php echo $arrayvalues['city_id']?>" />
                            <input name="Submit" type="submit" class="button" id="SaveCustomer" value="Submit" />&nbsp;
                        </td>    
                    </tr>

                </table>
               </form>
<!--By chetan 1Mar 2017--->           
<?php if($_GET['vender']!=''){?>
<script>
$(window).load(function(){  
	StateListSend();
});
</script>
<?php }?>
<!--End--->

