<script language="JavaScript1.2" type="text/javascript">
//By Chetan18Aug//
$(function(){
    
$("#form1").submit(function(){
        document.getElementById("CurrentDivision").value = window.parent.document.getElementById("CurrentDivision").value;
        var err;
        $('div.red').html('');
	var stateDisplay = $("#state_td").css('display');
        $("#form1  :input[data-mand^=\'y\']").each(function(){
            
            $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
            $fldname = $(this).attr('name');
            if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
            {
              if( $.trim($(this).val()) == "")
              {
                if(($fldname == "OtherState" && ($('#state_id').val()!='' && typeof($('#state_id').val())!="undefined")) || 
                    ($fldname == "OtherCity" && ($('#city_id').val()!='' &&  typeof($('#city_id').val())!="undefined")) ){}else{
                        
                        if($fldname == "OtherState" || $fldname == "OtherCity")
                        {
                            $input = ($(this).closest('td').prev('td').clone().children().remove().text()).replace(':*','');
                        }

			if($fldname == "OtherState" && stateDisplay=='none'){
				//alert('hi');
			}else{                
		                $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
		                err = 1;
			}
                }    
              }
              
             }else{
                 
                if($('#'+$fldname+':checked').length < 1)
                {
                     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                     err = 1;
                }
            }  
            
            
            if($fldname == "Email" && $(this).val()!= "")
               {    
                    emailID = $(this).val();
                    atpos = emailID.indexOf("@");
                    dotpos = emailID.lastIndexOf(".");
                    if (atpos < 1 || ( dotpos - atpos < 2 )) 
                    {
                        $("#"+$fldname+"err").html("Please enter correct email.");
                        err = 1; 
                    }
               }
               
          });
          
        if(err == 1){ return false; }else{ return true;}
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
      
        // sanjiv
		$("#ContactAcc").click(function(){
	        if ($('#ContactAcc').is(':checked')) {
		        $(".cp-settings").show(100);
	        }else{
	        	if(parseInt($("input[name='company_userid']").val())) {alert("Contact Login will be removed as well!!");}
	        	$(".cp-settings").hide(100);
	        }
		});
		
		
		 $("#billCopy").click(function(){
          
          //alert("aadd");
          var CustID = $("#CustID").val();
          var billing = 'billing';
          var dataString = "CustID="+CustID+"&AddType="+billing+"&action=GetBillingAddress";
          
            $.ajax({
                type: "POST",
                url: "ajax.php",
                dataType: 'json',
                data: dataString,
                async:false,
                success: function(data){
                //alert(data['Address']);
                    //$("#angkatan").html(data);
                    
                    $("#Address").val(data['Address']);
                    $("#country_id").val(data['country_id']);
                    $("#state_id").val(data['state_id']);
                    $("#OtherState").val(data['OtherState']);
                    $("#CountryName").val(data['CountryName']);
                    $("#StateName").val(data['StateName']);
                    $("#CityName").val(data['CityName']);
                    
                    $("#city_id").val(data['city_id']);
                    //$("#OtherCity").val(data['OtherCity']);
                    $("#ZipCode").val(data['ZipCode']);
                    $("#Mobile").val(data['Mobile']);
                    $("#Landline").val(data['Landline']);
                    $("#main_state_id").val(data['state_id']);
                    $("#main_city_id").val(data['city_id']);
                    SetMainStateId();
                }
            });
             });

})      

function randomPassword(length) {
		    var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
		    var pass = "";
		    for (var x = 0; x < length; x++) {
		        var i = Math.floor(Math.random() * chars.length);
		        pass += chars.charAt(i);
		    }
		    return pass;
		}

		function generate() { 
			form1.ContactPassword.value = randomPassword(10);
		}
		// end sanjiv code
//End//


</script>

<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div" style="height:550px;" >

<? if(empty($ErrorExist)){ ?>
	<div class="had" style="margin-bottom:5px;">

<? if($_GET['tab']=="shipping") echo $PageAction." Address";else echo $PageAction." Contact";?>   </div>


<form name="form1" id="form1" action=""  method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td align="left" valign="top">


<table width="100%" border="0" cellpadding="3" cellspacing="0" class="borderall">

 	  
<?php 
if($_GET['tab'] == 'contacts'){

/*********************Added by Sanjiv ******************************/
	$depids=array();
	if(!empty($arryDepartment)){
		foreach($arryDepartment as $arryDepartm){
			$depids[]=$arryDepartm['depID'];
	
		}
	}
	/********** Contact Login Detail **********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	$data=array();
	$userlogindetail=array();
	//$userlogindetail=$objCustomerSupplier->GetCustomerNewLogindetail($arryCustAddress[0]['Email']);
	$userlogindetail=$objCustomerSupplier->GetCustomerLogindetail($_SESSION['CmpID'],$arryCustAddress[0]['Email'],'customerContact');
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	
	/********** Contact Login Detail **********/

	/* menu rename start from here*/
	
	$arryRM8 = $objConfigure->getRightMenuByDepId(8,$MainModuleID,1);
	$arryRM0 = $objConfigure->getRightMenuByDepId(0,$MainModuleID,1);
	
	function is_in_array($array, $key, $key_value){
		$within_array = 'no';
		foreach( $array as $k=>$v ){
			if( is_array($v) ){
				$within_array = is_in_array($v, $key, $key_value);
				if( $within_array == 'yes' ){
					break;
				}
			} else {
				if( $v == $key_value && $k == $key ){
					$within_array = 'yes';
					break;
				}
			}
		}
		return $within_array;
	}
	
	
	if(is_in_array($arryRM0, 'Link', 'contacts')=='yes'){
		$arr = $objConfigure->getRightMenuByLink('contacts');
		$vcontacts=$arr[0]['Module'];
	}else{
		$vcontacts='Contacts';
	}
	
	if(is_in_array($arryRM0, 'Link', 'bank')=='yes'){
		$arr1 = $objConfigure->getRightMenuByLink('bank');
		$vbank=$arr1[0]['Module'];
	}else{
		$vbank='Bank Details';
	}
	
	if(is_in_array($arryRM0, 'Link', 'billing')=='yes'){
		$arr2 = $objConfigure->getRightMenuByLink('billing');
		$vbilling=$arr2[0]['Module'];
	}else{
		$vbilling='Billing Address';
	}
	
	
	if(is_in_array($arryRM0, 'Link', 'shipping')=='yes'){
	
		$arr3 = $objConfigure->getRightMenuByLink('shipping');
		$vshipping=$arr3[0]['Module'];
	}else{
		$vshipping='Shipping Address';
	}
	
	
	if(is_in_array($arryRM0, 'Link', 'purchase')=='yes'){
		$arr6 = $objConfigure->getRightMenuByLink('contacts');
		$vpurchase=$arr6[0]['Module'];
	}else{
		$vpurchase='Purchase History';
	}
	
	
	if(is_in_array($arryRM8, 'Link', 'so')=='yes'){
		$arr4 = $objConfigure->getRightMenuByLink('so');
		$vso=$arr4[0]['Module'];
	}else{
		$vso='Sales Orders';
	}
	
	
	if(is_in_array($arryRM8, 'Link', 'invoice')=='yes'){
		$arr5 = $objConfigure->getRightMenuByLink('invoice');
		$vinvoice=$arr5[0]['Module'];
	}else{
		$vinvoice='Invoice';
	}
	/* menu rename end here*/
/*********************End of code Sanjiv ******************************/

 //By chetan 30sep//
/******************** Code ****************************/

/********* By Karishma for MultiStore 22 Dec 2015******/
if($_REQUEST['tab']=='shipping' || $_REQUEST['tab']=='contacts')  $arrayvalues = $arryCustAddress[0];
else $arrayvalues = $arryCustomer[0];
/*****End By Karishma for MultiStore 22 Dec 2015**********/
$arrayvalues = $arryCustAddress[0];
for($h=0;$h<sizeof($arryHead);$h++){
if($arryHead[$h]['head_value']== 'Basic Information'){    
    
    $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
    $Narry = array_map(function($arr){
            if($arr['fieldname'] == 'FirstName' || $arr['fieldname'] == 'LastName' || $arr['fieldname'] == 'Email')
            {
                return $arr;
            }else{
                unset($arr);
            }
        },$arryField);

    $arryField = array_values(array_filter($Narry)); 
    include("crm/includes/html/box/CustomFieldsNew.php");
    
}

	
	
/*********************Added by Sanjiv ******************************/
if($arryHead[$h]['head_value']== 'Address Details'){    
    
   
    	$permissionmenu=array(	)	;
    	if(in_array(5,$depids)){
    		$permissionmenu['quote']='Quotes';
    		$permissionmenu['document']='Documents';
    		//$permissionmenu['contact']= $vcontacts;
    		$permissionmenu['bank']= $vbank;
    	}
    	 if(in_array(6,$depids)){
    		$permissionmenu['invoice']= $vinvoice;
    		$permissionmenu['purchaseorder']= $vpurchase;
    		$permissionmenu['salesorder']= $vso;
    		$permissionmenu['shipping']= $vshipping;
    		$permissionmenu['billing']= $vbilling;
    		$permissionmenu['items']='Items';
    	}
    	if(in_array(9,$depids) ){
    		$permissionmenu['website']='Website Management';
    
    	} 
    	if(!empty($userlogindetail)){
    		$cDis= "";
    	}else{
    		$cDis= "none";
    	}
    	?>
    
    		<tr>
			<td  >
			</td>
    			<td  align="left" class="blackbold"> 										
 
    			<input type="checkbox" id="ContactAcc" name="ContactAcc" value="1" <?php if(!empty($userlogindetail)) {echo 'checked="checked"';} ?> /> Generate Contact Login
    		 
    			</td>
    		</tr>
    
    	<? //if(!empty($userlogindetail)){				
    		?>
    		<tr class="cp-settings" style="display:<?=$cDis?>;">
    			<td  align="right"   class="blackbold"> Password  :</td>
    			<td   align="left" >
    			<input maxlength="100" data-mand="n" type="text" class="inputbox" name="ContactPassword" id="ContactPassword" value="" size="40" <?php if(!empty($userlogindetail)) echo 'placeholder="********"';?>>
    			 <?php if(empty($userlogindetail)){ ?>
    			 <input type="button" class="button search_button" style="height: 22px;padding: 0px 5px;background-color: black;" value="Generate" onClick="generate();" tabindex="2">
    			 <!--  <br/>
    			 <input type="checkbox" name="sendEmail" value="1" style="margin-top: 3px;">  Send Email Notification
    			 <br/> -->
    			  <?php }?>
    			</td>
    		</tr>
    		
      <tr class="cp-settings" style="display:<?=$cDis?>;">
    	<td  align="right"   class="blackbold" valign="top">Permission :<span class="red">*</span> </td>
    	<td   align="left" >
    	<?php
    	$mypermision=$arryMypermision=array();

    	if(!empty($userlogindetail->permission))
    	$arryMypermision=unserialize($userlogindetail->permission);
    	
    	//$arryMypermision = explode(",",$mypermision);
    	if(!empty($permissionmenu)){			
    										
    	foreach($permissionmenu as $k=>$permission){
			$chek='';

			if(in_array($k,$arryMypermision))
			$chek='checked="checked"';
			/**********Added by karishma for MultiStore 22 dec 2015**********/

$exclusivehtml='';
		$onlickaction='';
		if($k=='items'){
	
			$is_exclusive = (!empty($userlogindetail->is_exclusive)?($userlogindetail->is_exclusive):('No'));
			
			$onlickaction='onclick="showexclusive(this.checked);"';

			$displayExlusive='style="display:none;"';
			if($chek!='') $displayExlusive='';	
			$exclusivehtml='<div id="itemsType" '.$displayExlusive.'>
			<input type="radio" name="is_exclusive" value="Yes" ';
			 if($is_exclusive=='Yes')
			 $exclusivehtml .='checked="checked"';
			$exclusivehtml .='> Exclusive
			<input type="radio" name="is_exclusive" value="No" ';
			 if($is_exclusive=='No')
			 $exclusivehtml .='checked="checked"';
			$exclusivehtml .='> All
			</div>';
		}

						/**********End by karishma for MultiStore 22 dec 2015**********/
			echo '<div class="permission-box"><span class="input check"><input type="checkbox" '.$chek.' value="'.$k.'" name="permission[]" '.$onlickaction.'/></span><label>'.$permission.'</label>'.$exclusivehtml.'</div>';
			}	
    	}

	$userloginid = (!empty($userlogindetail->id)?($userlogindetail->id):(''));

?>
    	<input type="hidden" name="company_userid" value="<?php echo $userloginid;?>">
    		 </td>
      </tr>
    		
    <? /*}else{
    									  	
    	echo _("<div style='font-size:15px'>Customer has no login account.</div> <div><input type='hidden' name='ganeratelogin' value='ganerate'><br> <input type='hidden' name='CustId' id='CustId' value='".$CustId."' /><input type='checkbox' name='sendEmail' value='1'> Send Email Notification<br><input type='submit' name='ganerate' value='Generate' class='button'></div>");
    	$HideSubmit=1;
    } */
    ?>
    
<?php }
/*******************************************************************/



if($arryHead[$h]['head_value']== 'Address Details')
{  
/********* By Karishma for MultiStore 22 Dec 2015******/	
   $arrayvalues = $arryCustAddress[0];
/*****End By Karishma for MultiStore 22 Dec 2015**********/
   $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
   include("crm/includes/html/box/CustomFieldsNew.php");
}

if($arryHead[$h]['head_value']== 'Assign Role')
{  
   $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
   include("crm/includes/html/box/CustomFieldsNew.php");
}

}

//End//

}else{
?> 
<?php if($_GET['tab'] =='shipping'){?>
<tr>
	<td colspan="2"   align="right" valign="top"   class="blackbold"> <a id="billCopy" style="text-decoration:none;"class="button">Copy billing address</a> </td>
	
 <tr/>
 <? }?>
<tr>
	<td width="25%"  align="right" valign="top"   class="blackbold">Company Name:<span class="red">*</span> </td>
	<td width="25%" align="left" valign="top"   >
		<input maxlength="100" data-mand="y" type="text" class="inputbox" name="Company" id="Company" value="<?php echo $arryCustAddress[0]['Company']?>" />
                <div class="red" id="Companyerr" style="margin-left:5px;"></div>
	</td><tr/>
	<tr style="display:none;">
	<td width="25%"  align="right" valign="top"   class="blackbold">Email:<span class="red">*</span> </td>
	<td width="25%" align="left" valign="top"   >
		<input maxlength="100" data-mand="n" type="text" class="inputbox" name="Email" id="Email" value="<?php echo $arryCustAddress[0]['Email']?>" />
		<div class="red" id="Emailerr" style="margin-left:5px;"></div>
	</td><tr/>
	<tr>
	<td width="25%"  align="right" valign="top"  class="blackbold">Address:<span class="red">*</span> </td>
	<td width="25%"  align="left" valign="top" >

		<textarea class="inputbox" name="Address" data-mand="y" id="Address" style="width:300px;height:100px"><?php echo $arryCustAddress[0]['Address']?></textarea>
		<div class="red" id="Addresserr" style="margin-left:5px;"></div>
	</td><tr/>
	<!--<tr>
	<td width="25%"  align="right" valign="top"   class="blackbold">Country:<span class="red">*</span></td>
	<td width="25%"  align="left" valign="top"  >
		<select data-mand="y" name="country_id" class="inputbox" id="country_id" onChange="Javascript: StateListSend();" >
                
		<?php
		for ($i = 0; $i < sizeof($arryCountry); $i++) 
		{ $select='';
			if($arryCustAddress[0]['country_id'] == $arryCountry[$i]['country_id'] || ($arryCustAddress[0]['country_id'] == '' && $arryCountry[$i]['country_id'] == $arryCurrentLocation[0]['country_id'])) { $select = "selected=selected";}  
			echo '<option value="'.$arryCountry[$i]['country_id'].'" '.$select.'> '.$arryCountry[$i]['name'].'</option>';
		}
		?>
		<div class="red" id="country_iderr" style="margin-left:5px;"></div>
	</td>   
	<tr>
	    <td width="25%"  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :</td>
	    <td width="25%" align="left" id="state_td" class="blacknormal">&nbsp;</td>		   
	</tr>
	<tr>
		<td width="25%"  align="right" class="blackbold"><div id="StateTitleDiv">Other State:<span class="red">*</span></div> </td>
		<td width="25%"  align="left" ><div id="StateValueDiv">
		<input  name="OtherState" data-mand="y" type="text" class="inputbox" id="OtherState" value=""  maxlength="100" /> 
		<div class="red" id="OtherStateerr" style="margin-left:5px;"></div></div> </td>
	<tr/>

         <tr>
		<td width="25%"  align="right" class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
		<td width="25%"  align="left" ><div id="city_td"></div></td>
        </tr>
	<tr>
		<td width="25%" align="right" class="blackbold"><div id="CityTitleDiv"> Other City:<span class="red">*</span></div>  </td>
		<td width="25%" align="left"><div id="CityValueDiv">
		<input  name="OtherCity" data-mand="y" type="text" class="inputbox" id="OtherCity" value=""  maxlength="100" />   
		<div class="red" id="OtherCityerr" style="margin-left:5px;"></div></div></td>
	</tr>
-->

  <?/***********************************************/?>    
  
  <?php if($arryCustAddress[0]['country_id'] == '') { $CurrentLocationName = $arryCurrentLocation[0]['Country'];  $CurrentLocationID = $arryCurrentLocation[0]['country_id'];} else{
  
  $CurrentLocationName = $arryCustAddress[0]['CountryName'];
  $CurrentLocationID = $arryCurrentLocation[0]['country_id'];
  
  }
  
  /*****ADD COUNTRY/STATE/CITY NAME****/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
		/***********************************/
  
  $arryBillCountryID = $objRegion->GetCountryByIDCode($CurrentLocationName);
  
  $UsedState  =$arryBillCountryID[0]['used_state'];
  
  	/***********************************/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
  /***********************************/
  ?>
                                           
                                           <tr>
			<td  align="right"   class="blackbold" > Country  :<span class="red">*</span> </td>
			<td   align="left" >
		
	<input name="CountryName" data-mand="y" type="text"  class="inputbox"  id="CountryName" value="<?php echo stripslashes($CurrentLocationName); ?>" onblur="SetCountryInfo(this.value);"  maxlength="60"  autocomplete="off"  onclick="Javascript:AutoCompleteCountry(this);"/>
	
	<input name="country_id" type="hidden" class="inputbox"    value="<?php echo stripslashes($CurrentLocationID); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="country_id"/>
		<input name="UsedState" type="hidden"  value="<?=$UsedState?>"  id="UsedState"/>
	
	<div class="red" id="country_iderr" style="margin-left:5px;"></div>
	
		</td>
		 </tr>
		 
		 	<?php 
		
		#pr($arryCurrentLocation);
		
		
		
		
		$Billstatedis='';
		//$UsedState =0;
		//$errortext ='';
	
		if(!empty($_GET['AddID'])){
		 if(!empty($UsedState)){
		 
		 $Billstatedis = '';
		 //$UsedState =1;
		 $datamand = 'data-mand="y"';
		 $errortext = '<div class="red" id="state_iderr" style="margin-left:5px;"></div>';
		 
		 }
		 }else{
		 
		 //$UsedState =1;
		
		$datamand = 'data-mand="y"';
		$errortext = '<div class="red" id="state_iderr" style="margin-left:5px;"></div>';
		 
		 
		 }?>

	<tr id="state_tr" <?=$Billstatedis?>>
			<td  align="right"   class="blackbold" > State  :<span class="red">*</span> </td>
			<td   align="left" >
		
	<input name="StateName" type="text"  class="inputbox"  id="StateName" value="<?php echo stripslashes($arryCustAddress[0]['StateName']); ?>" onblur="SetSateInfo(this.value);"  maxlength="60"  autocomplete="off"  onclick="Javascript:AutoCompleteState(this);"/>
	
		<input name="state_id" type="hidden"  class="inputbox"    value="<?php echo stripslashes($arryCustAddress[0]['state_id']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="state_id"/>
	
	
		</td>
		 </tr>
		 	<tr>
			<td  align="right"   class="blackbold" > City  :<span class="red">*</span> </td>
			<td   align="left" >
		
	<input name="CityName" type="text"   class="inputbox"  id="CityName" value="<?php echo stripslashes($arryCustAddress[0]['CityName']); ?>" onblur="SetCityInfo(this.value);"  maxlength="60"  autocomplete="off"  onclick="Javascript:AutoCompleteCity(this);"/>
	
	<input name="city_id" type="hidden" class="inputbox"     value="<?php echo stripslashes($arryCustAddress[0]['city_id']); ?>"  maxlength="30" onkeypress="return isCharKey(event);" id="city_id"/>
	<input name="UsedState" type="hidden"  value="<?=$UsedState?>"  id="UsedState"/>
	
	 
	
		</td>
		 </tr>
                                           
                                           
      <? /***********************************************/?>   

	<tr>
		<td width="25%"  align="right" valign="top"   class="blackbold">Zip Code: </td>
		<td width="25%" align="left" valign="top"   >
		<input maxlength="100" data-mand="n" type="text" class="inputbox" name="ZipCode" id="ZipCode" value="<?php echo $arryCustAddress[0]['ZipCode']?>" />
		<div class="red" id="ZipCodeerr" style="margin-left:5px;"></div></td>
	<tr/>
	<tr>
		<td width="25%"  align="right" valign="top"   class="blackbold">Mobile: </td>
		<td width="25%" align="left" valign="top"   >
		<input maxlength="100" data-mand="n" type="text" class="inputbox" name="Mobile" id="Mobile" value="<?php echo $arryCustAddress[0]['Mobile']?>" />
		<div class="red" id="Mobileerr" style="margin-left:5px;"></div></td>
	<tr/>
	<tr>
		<td width="25%"  align="right" valign="top"   class="blackbold">Landline: </td>
		<td width="25%" align="left" valign="top"   >
		<input maxlength="100" data-mand="n" type="text" class="inputbox" name="Landline" id="Landline" value="<?php echo $arryCustAddress[0]['Landline']?>" />
		<div class="red" id="Landlineerr" style="margin-left:5px;"></div></td>
	<tr/>
<? }?>
</table>		
	
	</td>
	
  </tr>

	<tr>
    <td align="center">
<input type="Submit" class="button" name="SubmitContact" id="SubmitContact" value="<?=$ButtonAction?>">
<input type="hidden" name="CustID" id="CustID" value="<?=$_GET['CustID']?>" />
<input type="hidden" name="AddID" id="AddID" value="<?=$_GET['AddID']?>" />
<input type="hidden" name="CurrentDivision" id="CurrentDivision" value="">
<!----By Karishma for MultiStore 22 Dec 2015--->
<input type="hidden" name="tab" id="tab" value="<?=$_GET['tab']?>" />
<!----End By Karishma for MultiStore 22 Dec 2015--->
<input type="hidden" value="<?php echo $arryCustAddress[0]['state_id']; ?>" id="main_state_id" name="main_state_id">		
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCustAddress[0]['city_id']; ?>" />


</td>	
  </tr>


</table>
</form>
</div>

<SCRIPT LANGUAGE=JAVASCRIPT>
	//StateListSend();

	/**********Added by karishma for MultiStore 22 dec 2015**********/
	function showexclusive(isChecked){
		if(isChecked){
			$('#itemsType').show();
		}else{
			$('#itemsType').hide();
		}
	}

	/**********End by karishma for MultiStore 22 dec 2015**********/
	
		 
function AutoCompleteCountry(elm){	

	$(elm).autocomplete({
		source: "jsonCountry.php",
		minLength: 1,select: function( event, ui ) {
		//console.log(ui.item.hold);
		     jQuery('#state_id').val('');
       jQuery('#main_state_id').val('');
       jQuery('#StateName').val('');

       jQuery('#main_city_id').val('');
       jQuery('#CityName').val('');	
       jQuery('#city_id').val('');
				if(ui.item.id>0){
					 event.preventDefault();
					 jQuery('#country_id').val(ui.item.id);
					 jQuery('#CountryName').val(ui.item.label);
					 //alert(ui.item.used_state);
					 jQuery('#UsedState').val(ui.item.used_state);
					 
       
					 if(ui.item.used_state=='1'){
					 document.getElementById("state_tr").style.display = ''; 
					 }else{
					 document.getElementById("state_tr").style.display = 'none';
					 }
					//alert(ui.item.id);
					
					
					//return false;
					//
					}
		}
	});

}
function AutoCompleteCity(elm){		
var state_id = jQuery('#state_id').val();
var country_id = jQuery('#country_id').val();
var stateName = jQuery('#StateName').val();
var countryname = jQuery('#CountryName').val();
var UsedState = jQuery('#UsedState').val();

//alert(stateName);
if(UsedState==1){
if(stateName=='' || state_id=='' ){

alert("Please select state first.");
//jQuery('#StateName').focus();
return false;
}
} if(countryname=='' || country_id==''){

alert("Please select country first.");
//jQuery('#StateName').focus();
return false;
}
	$(elm).autocomplete({
		source: "jsonCity.php?state_id="+state_id+"&country_id="+country_id,
		minLength: 1,select: function( event, ui ) {
		console.log(ui.item.hold);
				if(ui.item.id>0){
					 event.preventDefault();
					 jQuery('#city_id').val(ui.item.id);
					 jQuery('#CityName').val(ui.item.label);
					 jQuery('#main_city_id').val(ui.item.id);
					
					 
					//alert(ui.item.id);
					
					
					//return false;
					//
					}
		}
	});

}
function AutoCompleteState(elm){		
jQuery('#main_city_id').val('');
					 jQuery('#CityName').val('');	
					 jQuery('#city_id').val('');
var country_id = jQuery('#country_id').val();
//alert (country_id);
	$(elm).autocomplete({
		source: "jsonState.php?country_id="+country_id,
		minLength: 1,select: function( event, ui ) {
		console.log(ui.item.hold);
				if(ui.item.id>0){
					 event.preventDefault();
					 jQuery('#state_id').val(ui.item.id);
					 jQuery('#StateName').val(ui.item.label);
					 jQuery('#main_state_id').val(ui.item.id);
					 
					//alert(ui.item.id);
					
					
					//return false;
					//
					}
		}
	});

}
</SCRIPT>




<? } ?>
