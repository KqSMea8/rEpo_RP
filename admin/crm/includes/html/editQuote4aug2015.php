<link rel="stylesheet" href="css/crm.css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
 <script>
$(document).ready(function() {
        $('#assign1').click(function() {
                $('#group').hide();
                $('#user').show();

        });
       $('#assign2').click(function() {
                 $('#user').hide();
                $('#group').show();
                
        });
    });
       

    </script>
<script type="text/javascript">


function CustTypeOption(){
	if(document.getElementById("CustType").value=='o'){
		$("#OppTitleDiv").show();
		$("#OppValDiv").show();
		$("#CustTitleDiv").hide();
		$("#CustValDiv").hide();			
	}else if(document.getElementById("CustType").value=='c'){
		$("#OppTitleDiv").hide();
		$("#OppValDiv").hide();
		$("#CustTitleDiv").show();
		$("#CustValDiv").show();
	}else{
		$("#OppTitleDiv").hide();
		$("#OppValDiv").hide();
		$("#CustTitleDiv").hide();
		$("#CustValDiv").hide();
	}
	
}







	var ew_DHTMLEditors = [];

function copyAddressRight(form) {

	if(typeof(form.bill_street) != 'undefined' && typeof(form.ship_street) != 'undefined')
		form.ship_street.value = form.bill_street.value;

	if(typeof(form.bill_city) != 'undefined' && typeof(form.ship_city) != 'undefined')
		form.ship_city.value = form.bill_city.value;

	if(typeof(form.bill_state) != 'undefined' && typeof(form.ship_state) != 'undefined')
		form.ship_state.value = form.bill_state.value;

	if(typeof(form.bill_code) != 'undefined' && typeof(form.ship_code) != 'undefined')
		form.ship_code.value = form.bill_code.value;

	if(typeof(form.bill_country) != 'undefined' && typeof(form.ship_country) != 'undefined')
		form.ship_country.value = form.bill_country.value;

	if(typeof(form.bill_pobox) != 'undefined' && typeof(form.ship_pobox) != 'undefined')
		form.ship_pobox.value = form.bill_pobox.value;
	
	return true;

}

function copyAddressLeft(form) {

	if(typeof(form.bill_street) != 'undefined' && typeof(form.ship_street) != 'undefined')
		form.bill_street.value = form.ship_street.value;
	
	if(typeof(form.bill_city) != 'undefined' && typeof(form.ship_city) != 'undefined')
		form.bill_city.value = form.ship_city.value;

	if(typeof(form.bill_state) != 'undefined' && typeof(form.ship_state) != 'undefined')
		form.bill_state.value = form.ship_state.value;

	if(typeof(form.bill_code) != 'undefined' && typeof(form.ship_code) != 'undefined')
		form.bill_code.value =	form.ship_code.value;

	if(typeof(form.bill_country) != 'undefined' && typeof(form.ship_country) != 'undefined')
		form.bill_country.value = form.ship_country.value;

	if(typeof(form.bill_pobox) != 'undefined' && typeof(form.ship_pobox) != 'undefined')
		form.bill_pobox.value = form.ship_pobox.value;

	return true;

}

function validateQuote(frm){

	if(document.getElementById("TaxRate") != null){
		document.getElementById("MainTaxRate").value = document.getElementById("TaxRate").value;
	}


	var NumLine = parseInt($("#NumLine").val());
        var EntryType = Trim(document.getElementById("EntryType")).value;
        var EntryFrom = Trim(document.getElementById("EntryFrom")).value;
        var EntryTo = Trim(document.getElementById("EntryTo")).value;	
	//var ModuleField = '<?=$ModuleID?>';
	
	//var ModuleVal = Trim(document.getElementById(ModuleField)).value;
	var OrderID = Trim(document.getElementById("quoteid")).value;
//alert(OrderID);

        if(EntryType == "recurring")
		{
                    if(!ValidateForSelect(frm.EntryFrom, "Entry From")){        
                      return false;
                    }

                    if(!ValidateForSelect(frm.EntryTo, "Entry To")){        
                        return false;
                    }
                    
                     if(EntryFrom >= EntryTo) {
                      document.getElementById("EntryFrom").focus();   
                      alert("End Date Should be Greater Than Start Date.");
                      return false;
                     }
                }

	if( ValidateForSimpleBlank(frm.subject, "Quote subject")
		&& ValidateForSelect(frm.CustType, "Type")
		&& ValidateForSelect(frm.quotestage, "Quote Stage")
		//&& ValidateForSelect(frm.assign,"Assign To")
		&& ValidateForTextareaMand(frm.bill_street,"Billing Address",10,300)
		&& ValidateForTextareaMand(frm.ship_street,"Shipping Address",10,300)
		//&& ValidateForSimpleBlank(frm.productName1, " Item Line")
		
		
		
		){
		
		for(var i=1;i<=NumLine;i++){
		 
			if(document.getElementById("sku"+i).value == ""){

				if(!ValidateForSelect(document.getElementById("sku"+i), "SKU")){
					return false;
				}
				if(!ValidateForSimpleBlank(document.getElementById("description"+i), "Item Description")){
					return false;
				}
				if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}
				if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
					return false;
				}	
			}
                     if(parseFloat(document.getElementById("discount"+i).value) > parseFloat(document.getElementById("price"+i).value))
			{
			   alert("Discount Should be Less Than Unit Price!");
			   return false;
			}
		}
					
		if( OrderID==''){		
	
                  var Url = "isRecordExists.php?QuoteSubject="+escape(document.getElementById("subject").value)+"&editID="+document.getElementById("quoteid").value+"&Type=Quote";
					SendExistRequest(Url,"subject", "Quote Subject");

					return false;	
					
			}else{
			ShowHideLoader('1','S');
			return true;	
		}

	}else{
		return false;	
	}	
		
}

</script>





<div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div>

<?

	if($arryQuote[0]['quotestage']=='Accepted' && $_GET['edit']>0){ 
		if(empty($arryCompany[0]["Department"]) || substr_count($arryCompany[0]['Department'],6)>0){
			echo '<a class="fancybox edit" href="#convert_form" >'.CONVERT_TO_SALE_ORDER.'</a>';
			include("includes/html/box/quote_convert_form.php");
		}
	}
 

?>









<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}


?>
  
<form name="form1" id="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validateQuote(this);  validateInventory('Products');" enctype="multipart/form-data">
<table  border="0" class="borderall" cellpadding="0" cellspacing="0" width="100%">
									   <tbody>

<tr>
<td colspan="4" class="head" align="left" >	<?=$arryHead[0]['head_value']?>	</td>
</tr>

<!---Recurring Start-->
        <?php   
        $arryRecurr = $arryQuote;
        include("../includes/html/box/recurring_2column_sales.php");?>

        <!--Recurring End-->
<tr>
		
<td  align="right" class="blackbold" >Subject :<span class="red">*</span> </td>
<td  align="left" >
<input name="subject" id="subject" class="inputbox" value="<?=$arryQuote[0]['subject']?>" type="text" maxlength="80">
</td>
</tr>

<tr>
	<td  align="right" class="blackbold" width="25%" > Type :<span class="red">*</span></td>
	<td align="left" width="25%">

	<select name="CustType" class="inputbox" id="CustType" onChange="Javascript:CustTypeOption();">
		<option value="">--- Select ---</option>
		 <option value="o" <? if($arryQuote[0]['CustType'] == "o") echo 'selected';?>> Opportunity </option>
        <option value="c" <? if($arryQuote[0]['CustType'] == "c") echo 'selected';?>> Customer </option>

	</select> 	

	</td>
				
	<td  align="right" class="blackbold"  width="25%">
		<div id="OppTitleDiv">Opportunity :</div>
		<div id="CustTitleDiv">Customer :</div>

	</td>

	<td  align="left" >

	<div id="OppValDiv"><input name="opportunityName" id="opportunityName"  readonly class="disabled_inputbox"   value="<?=$OpportunityName?>" type="text">
	<input name="opportunityID" id="opportunityID" value="<?=$arryQuote[0]['OpportunityID']?>" type="hidden">
	<a class="fancybox fancybox.iframe" href="OpportunityList.php?pop=1" ><?=$search?></a>
	</div>

	<div id="CustValDiv"><input name="CustomerName" type="text" class="disabled_inputbox" id="CustomerName" value="<?=$CustomerName?>"  maxlength="40" readonly />
<input name="CustID" id="CustID" type="hidden" value="<?=$arryQuote[0]['CustID']?>">
<input name="CustCode" id="CustCode" type="hidden" value="<?=$arryQuote[0]['CustCode']?>">
<input name="Taxable" id="Taxable" type="hidden" value="<?php echo stripslashes($arryQuote[0]['Taxable']); ?>">


			<a class="fancybox fancybox.iframe" href="CustomerList.php" ><?=$search?></a>
	</div>

		<SCRIPT LANGUAGE=JAVASCRIPT>
			CustTypeOption();
		</SCRIPT>

	</td>
</tr>




<tr style="display:none;" >
<td  align="right" class="blackbold" >Quote No :</td>
<td  align="left" ><input  class="inputbox" name="quote_no" id="quote_no" value="AUTO GEN ON SAVE"   type="text"></td>																	 	
</tr>		
						<tr>				
							<td  align="right" class="blackbold" >
				
				Quote Stage 	:	<span class="red">*</span> 	</td>
			<td  align="left" >
							   		<select name="quotestage" class="inputbox" >
                                    <option value="" > --Select-- </option>
			   						<option value="Created" <? if($arryQuote[0]['quotestage']=='Created'){ echo "selected"; }?>> Created </option>
						             <option value="Delivered" <? if($arryQuote[0]['quotestage']=='Delivered'){ echo "selected"; }?>>Delivered</option>
									<option value="Reviewed" <? if($arryQuote[0]['quotestage']=='Reviewed'){ echo "selected"; }?>>Reviewed</option>
									<option value="Accepted" <? if($arryQuote[0]['quotestage']=='Accepted'){ echo "selected"; }?>>Accepted</option>
									<option value="Rejected" <? if($arryQuote[0]['quotestage']=='Rejected'){ echo "selected"; }?>>Rejected</option>									
												   </select>
			</td>
			 
																									 	
							
										
							<td  align="right" class="blackbold" >
				Valid Till 	:		</td>
			<td  align="left" >
		<script type="text/javascript">
     $(function() {


	$('#validtill').datepicker(
		{
		
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")?>:<?=date("Y")+20?>', 
		minDate: "-D", 
        changeMonth: true,
		changeYear: true
		}
	);
});
</script>													
				<input name="validtill" class="disabled" id="validtill"  size="11" readonly="readonly" maxlength="10" value="<? if($arryQuote[0]['validtill']>0) echo$arryQuote[0]['validtill'];?>" type="date">
			
			</td>
</tr>
																										 	
							
					<tr style="display:none;">					
							<td  align="right" class="blackbold" >
				Contact Name 	:		</td>
			<td  align="left" >
									
                                    
                                    <input  name="contact_name" id="single_accountid" value="" class="inputbox" type="text"><input name="contact_id" value="" type="hidden">&nbsp;<img src="images/select.gif" alt="Select" title="Select" language="javascript" onclick="return window.open(&quot;index.php?module=Accounts&amp;action=Popup&amp;popuptype=specific_account_address&amp;form=TasksEditView&amp;form_submit=false&amp;fromlink=&quot;,&quot;test&quot;,&quot;width=640,height=602,resizable=0,scrollbars=0&quot;);" style="cursor:hand;cursor:pointer" align="absmiddle">

				<input src="images/clear_field.gif" alt="Clear" title="Clear" language="javascript" onclick="this.form.contact_id.value=''; this.form.contact_name.value='';return false;" style="cursor:hand;cursor:pointer" align="absmiddle" type="image">
							</td>

			   </tr>
               


<tr>

        <td  align="right" class="blackbold">Payment Term  :</td>
        <td   align="left">
		  <select name="PaymentTerm" class="inputbox" id="PaymentTerm">
		  	<option value="">--- None ---</option>
				<? for($i=0;$i<sizeof($arryPaymentTerm);$i++) {
						$PaymentTerm = stripslashes($arryPaymentTerm[$i]['termName']).' - '.$arryPaymentTerm[$i]['Day'];
				?>
					<option value="<?=$PaymentTerm?>" <?  if($PaymentTerm==$arryQuote[0]['PaymentTerm']){echo "selected";}?>><?=$PaymentTerm?></option>
				<? } ?>
		</select> 
		</td>

		<td  align="right" class="blackbold">Payment Method  :</td>
                 <td align="left">
		  <select name="PaymentMethod" class="inputbox" id="PaymentMethod">
		  	<option value="">--- None ---</option>
				<?php for($i=0;$i<sizeof($arryPaymentMethod);$i++) {?>
                                    <option value="<?=$arryPaymentMethod[$i]['attribute_value']?>" <?  if($arryPaymentMethod[$i]['attribute_value']==$arryQuote[0]['PaymentMethod']){echo "selected";}?>>
					<?=$arryPaymentMethod[$i]['attribute_value']?>
                                    </option>
			<? } ?>
		</select> 
		</td>



</tr>




			<tr >
																									 	
							
										
<td  align="right" class="blackbold" >Shipping Mode 	:</td>
<td  align="left" >
<select name="carrier" class="inputbox" id="carrier">
  	<option value="">--- None ---</option>
		<? for($i=0;$i<sizeof($arryShippingMethod);$i++) {?>
			<option value="<?=$arryShippingMethod[$i]['attribute_value']?>" <?  if($arryShippingMethod[$i]['attribute_value']==$arryQuote[0]['carrier']){echo "selected";}?>>
			<?=$arryShippingMethod[$i]['attribute_value']?>
	</option>
		<? } ?>
</select> 

</td>
								
							<td  align="right" class="blackbold" >Shipping : </td>

							<td  align="left" ><input class="inputbox" name="shipping" id="shipping" value="<?=$arryQuote[0]['shipping']?>"   type="text"></td>
						   </tr>
			 <tr>
<td align="right"   class="blackbold"> Assigned To  : </td>
<td   align="left" >
<input name="assign" type="radio" id="assign1"  <?=($arryQuote[0]['AssignType'] == "User")?"checked":""?> checked  value="User"  maxlength="50" />&nbsp; Users &nbsp;&nbsp; <input name="assign" <?=($arryQuote[0]['AssignType'] == "Group")?"checked":""?> type="radio" id="assign2" value="Group"  maxlength="50" />&nbsp; Group       </td>
</tr>

	 
<tr >
  <td align="right"   class="blackbold"> &nbsp;&nbsp; </td>
        <td  align="left" colspan="3">

		<div id="group" <?=$classGroup?>>
               <select name="AssignToGroup" class="inputbox" id="AssignToGroup" >
		<option value="">--- Select ---</option>	   

<optgroup label="Groups">
		<? if(!empty($arryGroup)){?>
		
			<? for($i=0;$i<sizeof($arryGroup);$i++) {?>
			<option value="<?=$arryGroup[$i]['group_user']?>:<?=$arryGroup[$i]['GroupID']?>" <?  if($arryGroup[$i]['group_user']==$arryQuote[0]['assignTo']){echo "selected";}?>>
			<?=stripslashes($arryGroup[$i]['group_name']);?> 
		</option>
						<? }  }else{ ?>

						<div class="redmsg">No Group exist.</div>
					<? } ?>
</optgroup>
		</select>

	</div>
        
        <div id="user" <?=$classUser?>>
        <input type="text" class="inputbox" id="AssignToUser" name="AssignToUser" />
       <? if($_GET['edit']>0 && $json_response2!=''){ ?>
        <script type="text/javascript">
         $(document).ready(function() {
            $("#AssignToUser").tokenInput("multiSelect.php", {
                theme: "facebook",
				preventDuplicates: true,
				prePopulate: <?=$json_response2?>,
				
			propertyToSearch: "name",
              resultsFormatter: function(item){ return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " </div><div class='email'>" + item.department + "</div></div></li>" },
              //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
			  tokenFormatter: function(item){ return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " ' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " </div><div class='email'>" + item.department + "</div></div></li>" },

				
            });
        });
        </script>
        <? }else{?>
         <script type="text/javascript">
        $(document).ready(function() {
            $("#AssignToUser").tokenInput("multiSelect.php", {
                theme: "facebook",
				preventDuplicates: true,
				
					propertyToSearch: "name",
              resultsFormatter: function(item){ return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>" + item.department + "</div></div></li>" },
              //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
			  tokenFormatter: function(item){ return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " </div><div class='email'>" + item.department + "</div></div></li>" },

				
            });
        });
        </script>
         <? }?>
        </div>
		
          </td>
      </tr>																					 	
</tr>


<tr>					
<td  align="right" class="blackbold" valign="top">
	Notes : 		
	</td>
<td  align="left" >
<textarea name="Comment" id="Comment" class="textarea" maxlength="200"><?=stripslashes($arryQuote[0]['Comment'])?></textarea>
</td>


</tr>


<tr>
	<td  align="right"   class="blackbold" > Currency  : </td>
	<td   align="left" >
<?
//unset($arryCompany[0]['AdditionalCurrency']);
if(empty($arryCompany[0]['AdditionalCurrency']))$arryCompany[0]['AdditionalCurrency'] = $Config['Currency'];
$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arryQuote[0]['CustomerCurrency']) && !in_array($arryQuote[0]['CustomerCurrency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arryQuote[0]['CustomerCurrency'];
}

 ?>
<select name="CustomerCurrency" class="inputbox" id="CustomerCurrency">
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arryQuote[0]['CustomerCurrency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>


</td>
</tr>

<?php


/******************** Code ****************************/
 $arryField = $objField->getFormField('',$arryHead[0]['head_id'],''); 
 
include("includes/html/box/customfields.php");
?>


<tr style="display:none;">					
							<td  align="right" class="blackbold" >
				Organization Name 	:		</td>
			<td  align="left" >
				<input  name="account_name" id="single_accountid" value="" class="inputbox" type="text"><input name="account_id" value="" type="hidden">&nbsp;<img src="images/select.gif" alt="Select" title="Select" language="javascript" onclick="return window.open(&quot;index.php?module=Accounts&amp;action=Popup&amp;popuptype=specific_account_address&amp;form=TasksEditView&amp;form_submit=false&amp;fromlink=&quot;,&quot;test&quot;,&quot;width=640,height=602,resizable=0,scrollbars=0&quot;);" style="cursor:hand;cursor:pointer" align="absmiddle">
				<input src="images/clear_field.gif" alt="Clear" title="Clear" language="javascript" onclick="this.form.account_id.value=''; this.form.account_name.value='';return false;" style="cursor:hand;cursor:pointer" align="absmiddle" type="image">
			</td>


			   </tr>

	<tr> 
		<td colspan="2" class="head" align="left" ><?=$arryHead[1]['head_value']?>  </td>
		<td class="head" align="right"><?=$arryHead[2]['head_value']?></td>
		<td class="head" align="left" >    
		&nbsp;&nbsp;&nbsp;<input name="cpy" onclick="return copyAddressRight(form1)" type="radio"><b>Copy Billing address</b>
		</td>    										
	</tr>


<tr>
<td colspan="2" align="left" valign="top">	

<table  border="0" cellpadding="0" cellspacing="0" width="100%">
<tr ><td  align="right" class="blackbold" valign="top" width="50%">
					
				Billing Address 	:	<span class="red">*</span> 	</td>
			<td  align="left" >
				<textarea name="bill_street" id="bill_street" class="textarea"><?=stripslashes($arryQuoteAdd[0]['bill_street'])?></textarea>
			</td>
          <tr style="display:none;"><td  align="right" class="blackbold" >Billing PO Box :</td>
							<td  align="left" ><input class="inputbox" name="bill_pobox" id="bill_pobox" value="<?=stripslashes($arryQuoteAdd[0]['bill_pobox'])?>"   type="text"></td>
								</tr>	
                      <tr >
										
							<td  align="right" class="blackbold" >Billing City :</td>

							<td  align="left" ><input class="inputbox" name="bill_city" id="bill_city" value="<?=stripslashes($arryQuoteAdd[0]['bill_city'])?>"   type="text"></td>
																													 	
							</tr>	             
			         <tr >
						<td  align="right" class="blackbold" >Billing State :</td>

							<td  align="left" ><input class="inputbox" name="bill_state" id="bill_state" value="<?=stripslashes($arryQuoteAdd[0]['bill_state'])?>"   type="text"></td>
																													 	
							</tr>
                           
																									 	
							
										
							<td  align="right" class="blackbold" >Billing Country :</td>

							<td  align="left" ><input class="inputbox" name="bill_country" id="bill_country" value="<?=stripslashes($arryQuoteAdd[0]['bill_country'])?>"   type="text"></td>
																													 	
							</tr>


 <tr >			
							<td  align="right" class="blackbold" >Billing Postal Code :</td>

							<td  align="left" ><input class="inputbox" name="bill_code" id="bill_code" value="<?=stripslashes($arryQuoteAdd[0]['bill_code'])?>"   type="text"></td>
																													 	
							</tr>	
                            <tr >


<?php


/******************** Code ****************************/
 $arryField = $objField->getFormField('',$arryHead[1]['head_id'],''); 
 
include("includes/html/box/customfields.php");
/*********************************/
?>                                
                                
                                
</table>
</td>









<td colspan="2" align="left" valign="top">
<table  border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>				
		<td  align="right" class="blackbold" valign="top" width="50%">
					
				Shipping Address 		:	<span class="red">*</span> </td>
			<td  align="left" >
				<textarea name="ship_street" id="ship_street" class="textarea" ><?=stripslashes($arryQuoteAdd[0]['ship_street'])?></textarea>
			</td>
			   </tr>
																								 	
							
							<tr style="display:none;">			
							<td  align="right" class="blackbold" >Shipping PO Box :</td>

							<td  align="left" ><input class="inputbox" name="ship_pobox" id="ship_pobox" value="<?=stripslashes($arryQuoteAdd[0]['ship_pobox'])?>"   type="text"></td>
						   </tr>
			
							<tr>			
							<td  align="right" class="blackbold" >Shipping City :</td>

							<td  align="left" ><input class="inputbox" name="ship_city" id="ship_city" value="<?=stripslashes($arryQuoteAdd[0]['ship_city'])?>"   type="text"></td>
						   </tr>
                           
             		
							<tr>			
							<td  align="right" class="blackbold" >Shipping State : </td>

							<td  align="left" ><input class="inputbox" name="ship_state" id="ship_state" value="<?=stripslashes($arryQuoteAdd[0]['ship_state'])?>"   type="text" onblur="Javascript:SetTaxable(1);"></td>
						   </tr>
                           
			
								
			
	<tr>			
	<td  align="right" class="blackbold" >Shipping Country :</td>

	<td  align="left" ><input class="inputbox" name="ship_country" id="ship_country" value="<?=stripslashes($arryQuoteAdd[0]['ship_country'])?>"   type="text" onblur="Javascript:SetTaxable(1);"></td>
   </tr>

<tr>		
							<td  align="right" class="blackbold" >Shipping Postal Code :</td>

							<td  align="left" ><input class="inputbox" name="ship_code" id="ship_code" value="<?=stripslashes($arryQuoteAdd[0]['ship_code'])?>"   type="text"></td>
						   </tr>


<tr>
	<td align="right"   class="blackbold">Reseller  : </td>
	<td  align="left" >
<label><input name="Reseller" type="radio" id="Reseller1" value="Yes" <?=($arryQuote[0]['Reseller']=="Yes")?("checked"):("")?> onclick="Javascript:SetReseller(1);" />&nbsp;Yes</label>
&nbsp;&nbsp;&nbsp;&nbsp;
<label><input name="Reseller" type="radio" id="Reseller2" value="No" <?=($arryQuote[0]['Reseller']!="Yes")?("checked"):("")?> onclick="Javascript:SetReseller(1);" />&nbsp;No </label>

</td>
  </tr>
<tr>
	<td align="right"   class="blackbold"><div id="ResellerTitleDiv">Reseller No  :</div> </td>
	<td  align="left" ><div id="ResellerValDiv"><input name="ResellerNo" type="text" class="inputbox" id="ResellerNo" value="<?=stripslashes($arryQuote[0]['ResellerNo'])?>"  maxlength="30" /></div> </td>
  </tr>

<tr>
			<td align="right"   class="blackbold">Taxable  : </td>
			<td  align="left">
                            
                        <select style="width:100px;" id="tax_auths" class="textbox" name="tax_auths" onchange="Javascript:SetTaxable(1);">
                            <option value="No" <?php if($arryQuote[0]['tax_auths']=="No"){echo "selected";}?>>No</option>
                            <option value="Yes" <?php if($arryQuote[0]['tax_auths']=="Yes"){echo "selected";}?>>Yes</option>
                             </select>
                        </td>
		  </tr>


		<tr>
			<td align="right"   class="blackbold">Tax Rate  :</td>
			<td  align="left">  

                         
                      		<div id="TaxRateVal">None</div>
<input type="hidden" name="MainTaxRate" id="MainTaxRate" value="<?=$arryQuote[0]['TaxRate']?>">


                        </td>
		  </tr>	


		  </tr>	
<?php
/******************** Code ****************************/
 $arryField = $objField->getFormField('',$arryHead[2]['head_id'],''); 
 
include("includes/html/box/customfields.php");
?>

<script language="JavaScript1.2" type="text/javascript">
SetReseller();
SetTaxable();
function SetReseller(ProcessCal){
	if(document.getElementById("Reseller2").checked){
		$("#ResellerTitleDiv").hide();
		$("#ResellerValDiv").hide();
	}else{
		$("#ResellerTitleDiv").show();
		$("#ResellerValDiv").show();
	}
	/*if(ProcessCal==1){
		ProcessTotal();
	}*/
}




function SetTaxable(ProcessCal){
	if(document.getElementById("tax_auths").value=='Yes' && document.getElementById("ship_country").value!=''){
		$("#TaxRateVal").html('<img src="../images/loading.gif">');
		var SendUrl = "&action=TaxRateAddress&State="+escape(document.getElementById("ship_state").value)+"&Country="+escape(document.getElementById("ship_country").value)+"&OldTaxRate="+escape(document.getElementById("MainTaxRate").value)+"&r="+Math.random();

	   	$.ajax({
		type: "GET",
		url: "ajax.php",
		data: SendUrl,
		success: function (responseText) {			
			if(responseText!=''){		
				$("#TaxRateVal").html(responseText);
			}else{
				$("#TaxRateVal").html("No tax class.");
			}
		   
		}

	   	});
	}else{
		$("#TaxRateVal").html("None");
	}


	if(ProcessCal==1){
		ProcessTotal();
	}
}


</script>
</table>
</td>


<?php      
/******************** Code ****************************/

 for($head=3;$head<sizeof($arryHead);$head++){?>
                
                    <tr>
                        <td colspan="4" align="left" class="head"><?=$arryHead[$head]['head_value']?></td>
                    </tr>

<?php $arryField = $objField->getFormField('',$arryHead[$head]['head_id'],'1'); 


include("includes/html/box/customfields.php"); 

 }
//head close?>





</tr>







			
																										 	
						  	
						




<tr>
			 <td colspan="4"  align="right">
		<?
		
		$Currency = (!empty($arryQuote[0]['CustomerCurrency']))?($arryQuote[0]['CustomerCurrency']):($Config['Currency']); 
		//echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
		?>	 
			 </td>
		</tr>

<tr>
	<td colspan="4"  align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" >Line Item</td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/sale_quote_item_form.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>

 <tr>
    <td  colspan="4"  align="center">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
<!--By Chetan-->
      <input type="hidden" name="fieldIds" value="<?=$StrField?>">
      <input type="hidden" name="fields" value="<?=$StrFieldName?>">
        <!--End-->

		<input name="quoteid" value="<?=$quoteid?>" id="quoteid" type="hidden">

		<input type="hidden" name="Module" id="Module" value="<?=$module?>" />

		<input type="hidden" name="ModuleID" id="ModuleID" value="<?=$ModuleID?>" />
		<input type="hidden" name="PrefixSale" id="PrefixSale" value="<?=$PrefixSale?>" />

	</td>
   </tr>
									  
</table>
</form>

	

	
 
