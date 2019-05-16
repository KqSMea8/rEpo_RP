<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SetCustCode(CustCode,CustId,creditnote){
	ResetSearch();
	window.parent.document.getElementById("CustomerCompany").value='';
	window.parent.document.getElementById("CustomerName").value='';
 	window.parent.document.getElementById("Taxable").value='';
	window.parent.document.getElementById("Address").value='';
	window.parent.document.getElementById("City").value='';
	window.parent.document.getElementById("State").value='';
	window.parent.document.getElementById("Country").value='';
	window.parent.document.getElementById("ZipCode").value='';
	window.parent.document.getElementById("Mobile").value='';
	window.parent.document.getElementById("Landline").value='';
	window.parent.document.getElementById("Fax").value='';
	window.parent.document.getElementById("Email").value='';
	
	window.parent.document.getElementById("ShippingCompany").value='';
	window.parent.document.getElementById("ShippingName").value='';
	window.parent.document.getElementById("ShippingAddress").value='';
	window.parent.document.getElementById("ShippingCity").value='';
	window.parent.document.getElementById("ShippingState").value='';
	window.parent.document.getElementById("ShippingCountry").value='';
	window.parent.document.getElementById("ShippingZipCode").value='';
	window.parent.document.getElementById("ShippingMobile").value='';
	window.parent.document.getElementById("ShippingLandline").value='';
	window.parent.document.getElementById("ShippingFax").value='';
	window.parent.document.getElementById("ShippingEmail").value='';	        
			
var SendUrl = "&action=CustomerInfo&CustId="+CustId+"&CustCode="+escape(CustCode)+"&r="+Math.random();
//alert(SendUrl);
	//var SendUrl = "&action=CustomerInfo&CustCode="+escape(CustCode)+"&r="+Math.random();
   	$.ajax({
	type: "GET",
	url: "ajax.php",
	data: SendUrl,
	dataType : "JSON",
	success: function (responseText) {
		//alert(responseText);
		window.parent.document.getElementById("CustCode").value=CustCode;
		window.parent.document.getElementById("CustID").value=CustId;
		window.parent.document.getElementById("CustomerName").value=responseText["CustomerName"];
		window.parent.document.getElementById("tax_auths").value=responseText["Taxable"];


if(responseText["Taxable"] =='Yes' ){
//SetTaxable(1);
	//document.getElementById("TaxRate").value=responseText["TaxRate"];
window.parent.document.getElementById("MainTaxRate").value=responseText["c_taxRate"];
parent.SetTaxable();

}

// added by bhoodev for EDI 14 Feb 2018
		window.parent.document.getElementById("EDICompId").value=responseText["EDICompId"];
		window.parent.document.getElementById("EDIPurchaseCompName").value=responseText["EDICompName"];
// End by bhoodev for EDI 14 Feb 2018
        if(responseText["MDType"]){
		  if(responseText["MDType"] == 'Discount'){
                        
			window.parent.document.getElementById("CustDisType").value=responseText["DiscountType"];
			window.parent.document.getElementById("MDAmount").value=responseText["MDAmount"];
			window.parent.document.getElementById("MDType").value=responseText["MDType"];
                        window.parent.document.getElementById("MDiscount").value=responseText["MDiscount"];


		}else{

				window.parent.document.getElementById("CustDisType").value='Percentage';
				window.parent.document.getElementById("MDAmount").value=responseText["MDAmount"];
				window.parent.document.getElementById("MDType").value=responseText["MDType"];
				window.parent.document.getElementById("MDiscount").value=responseText["MDiscount"];
		}


	}else{
				window.parent.document.getElementById("CustDisType").value='';
				window.parent.document.getElementById("MDAmount").value='';
				window.parent.document.getElementById("MDType").value='';
				window.parent.document.getElementById("MDiscount").value='';
	}
		
		//modified by nisha 		
		if(responseText["SalesPerson"]){
			window.parent.document.getElementById("SalesPerson").value=responseText["SalesPerson"];
			window.parent.document.getElementById("SalesPersonID").value=responseText["SalesPersonID"];
			window.parent.document.getElementById("vendorSalesPersonID").value=responseText["VendorSalesPerson"];
			window.parent.document.getElementById("SalesPersonName").value=responseText["SalesPersonName"];
			window.parent.document.getElementById("vendorSalesPersonName").value=responseText["vendorSalesPersonName"];
window.parent.document.getElementById("SalesPersonType").value=responseText["SalesPersonType"];
		}else{
			window.parent.document.getElementById("SalesPerson").value='';
			window.parent.document.getElementById("SalesPersonID").value='';
			window.parent.document.getElementById("vendorSalesPersonID").value='';
      window.parent.document.getElementById("SalesPersonType").value='';
      window.parent.document.getElementById("SalesPersonName").value='';
      window.parent.document.getElementById("vendorSalesPersonName").value='';
			
		}
		

		//Order Quote
		//if(creditnote == ""){
		window.parent.document.getElementById("PaymentTerm").value=responseText["PaymentTerm"];
		//window.parent.document.getElementById("PaymentMethod").value=responseText["PaymentMethod"];
		window.parent.document.getElementById("ShippingMethod").value=responseText["ShippingMethod"];
		//}
		
	
	window.parent.document.getElementById("CustomerCompany").value=responseText["CustomerCompany"];
	window.parent.document.getElementById("BillingName").value=responseText["Name"];
	window.parent.document.getElementById("Address").value=responseText["Address"];
	window.parent.document.getElementById("City").value=responseText["CityName"];
	window.parent.document.getElementById("State").value=responseText["StateName"];
	window.parent.document.getElementById("Country").value=responseText["CountryName"];

var select =  window.parent.document.getElementById("CountryName");
	var length = select.options.length;
     for(i = length - 1 ; i >= 0 ; i--)
    {
        select.remove(i);
    }
    option = window.parent.document.createElement( 'option' );

    if((responseText["country_id"]=="0") || (responseText["country_id"]==null)) {
    	option.value = "";
        option.text = "---Select---";
    } else {
    	option.value = responseText["country_id"];
        option.text = responseText["CountryName"];
    }
   
    select.add( option );

    window.parent.document.getElementById("State").value=responseText["StateName"]; 
     //added by nisha for State dropdown
	var selectState =  window.parent.document.getElementById("StateName");
	var lengthState = selectState.options.length;
     for(i = lengthState - 1 ; i >= 0 ; i--)
    {
        selectState.remove(i);
    }
    optionState = window.parent.document.createElement( 'option' );
    if((responseText["state_id"]=="0") || (responseText["state_id"]==null)) {
    	optionState.value = "";
        optionState.text = "---Select---";
    } else {
    	optionState.value = responseText["state_id"];
        optionState.text = responseText["StateName"];
    }
    selectState.add( optionState );

	window.parent.document.getElementById("City").value=responseText["CityName"]; 
   //added by nisha for City dropdown
    var selectCity =  window.parent.document.getElementById("CityName");
    var lengthCity = selectCity.options.length;
     for(i = lengthCity - 1 ; i >= 0 ; i--)
    {
        selectCity.remove(i);
    }
    optionCity = window.parent.document.createElement( 'option' );
    if((responseText["city_id"]=="0") || (responseText["city_id"]==null)) {
    	optionCity.value = "";
        optionCity.text = "---Select---";
    } else {
    	optionCity.value = responseText["city_id"];
        optionCity.text = responseText["CityName"];
    }
    selectCity.add( optionCity );






	window.parent.document.getElementById("ZipCode").value=responseText["ZipCode"];
	window.parent.document.getElementById("Mobile").value=responseText["Mobile"];
	window.parent.document.getElementById("Landline").value=responseText["Landline"];
	window.parent.document.getElementById("Fax").value=responseText["Fax"];
	window.parent.document.getElementById("Email").value=responseText["Email"];	
	window.parent.document.getElementById("ShippingCompany").value=responseText["CustomerCompany"];
	window.parent.document.getElementById("ShippingName").value=responseText["sName"];
	window.parent.document.getElementById("ShippingAddress").value=responseText["sAddress"];
	//window.parent.document.getElementById("ShippingCity").value=responseText["sCityName"];






window.parent.document.getElementById("ShippingCountry").value=responseText["sCountryName"];
window.parent.document.getElementById("ShippingCountryName").value=responseText["sCountryid"];
window.parent.loadState(responseText["sCountryid"],responseText["sStateid"]);
window.parent.document.getElementById("ShippingState").value=responseText["sStateName"];
window.parent.document.getElementById("ShippingStateName").value=responseText["sStateid"];
window.parent.loadCity(responseText["sStateid"],responseText["sCityid"]);
window.parent.document.getElementById("ShippingCity").value=responseText["sCityName"];
window.parent.document.getElementById("ShippingCityName").value=responseText["sCityid"];




	window.parent.document.getElementById("ShippingZipCode").value=responseText["sZipCode"];
	window.parent.document.getElementById("ShippingMobile").value=responseText["sMobile"];
	window.parent.document.getElementById("ShippingLandline").value=responseText["sLandline"];
	window.parent.document.getElementById("ShippingFax").value=responseText["sFax"];
	window.parent.document.getElementById("ShippingEmail").value=responseText["sEmail"];
	if(window.parent.document.getElementById("CustomerCurrency") != null){
		window.parent.document.getElementById("CustomerCurrency").value=responseText["Currency"];
	}




	if(window.parent.document.getElementById("paypalemailSearch") != null){
			window.parent.document.getElementById("paypalemailSearch").setAttribute("href", "paypalemail.php?cid="+CustId);
	}
	if(window.parent.document.getElementById("paypa-email-tr")!= null && ! window.parent.document.getElementById("paypalemailSearch")){
		var hh='<a href="paypalemail.php?cid='+CustId+'" class="fancybox fancybox.iframe" id="paypalemailSearch"><img src="../images/search.png"></a>';

		window.parent.document.getElementById("paypal-email-input-td").appendChild(hh);

		//window.parent.document.getElementById("paypalemail").insertAfter(hh);
	}










	/***/
	if(window.parent.document.getElementById("contact_link") != null){
		window.parent.document.getElementById("ContactDiv").innerHTML='';	
		window.parent.document.getElementById("SpiffContact").value='';	
		var contact_link = window.parent.document.getElementById("contact_link");
		contact_link.setAttribute("href", 'CustomerContact.php?CustID='+CustId);
	}
	/***/
 
	if(window.parent.document.getElementById("shipTD") != null){
		window.parent.document.getElementById("shipTR").style.display = "";
		window.parent.document.getElementById("shipTD").innerHTML =responseText["shipList"]; 
	}

	if(window.parent.document.getElementById("OrderSource") != null){
		window.parent.document.getElementById("OrderSource").value=responseText["OrderSource"];
	}

	parent.SetTaxable();
	parent.ProcessTotal();
	parent.shipCarrier();
	//parent.SelectCreditCard();
	parent.$("#PaymentTerm").trigger("change");
	/************************************/
	


		parent.jQuery.fancybox.close();
		ShowHideLoader('1','P');
	
		   
	}

   });
				


}




</script>
<style type="text/css">	
.customer-disable {
    opacity: 0.6;
}


.customer-hold {
    background: rgba(0, 0, 0, 0) url("../images/customer-hold.png") no-repeat scroll 0 0 / 20px 20px;
    display: inline-block;
    float: right;
    height: 20px;
    width: 20px;
}

</style>
<div class="had">Select Customer</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="CustomerList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
</form>



		</td>
      </tr>
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left"  >
 <td class="head1" >Customer</td>
      <td width="15%"  class="head1" >Customer Code</td>
    
       <td width="15%" class="head1" >Country</td>
       <td width="18%" class="head1" >State</td>
       <td width="14%" class="head1" >City</td>
      <td width="10%"  class="head1" >Taxable</td>
    </tr>
   
    <?php 
  if(is_array($arryCustomer) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCustomer as $key=>$values){
  	$class="";
  	$class=!empty($values['customerHold'])?'customer-disable':'';
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	if(empty($values["Taxable"])) $values["Taxable"]="No";
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>" class="<?=$class?>">
    <td>
     <?php if(empty($values['customerHold'])){?>
	<a href="Javascript:void(0)" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SetCustCode('<?=$values["CustCode"]?>','<?=$values["Cid"]?>','<?=$_GET['creditnote']?>');"><?=stripslashes($values["CustomerName"])?></a>
	<?php }else{
echo stripslashes($values["CustomerName"]);
echo '<span class="customer-hold" title="On Hold"></span>';

		}?>
	</td>
    <td><?=$values["CustCode"]?></td> 
    <td><?=stripslashes($values["CountryName"])?></td> 
    <td><?=stripslashes($values["StateName"])?></td> 
    <td><?=stripslashes($values["CityName"])?></td> 
    <td><?=$values["Taxable"]?></td>
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_CUSTOMER?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCustomer)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

  
</form>
</td>
	</tr>
</table>
