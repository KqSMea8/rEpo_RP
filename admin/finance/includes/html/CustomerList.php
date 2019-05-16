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
	//var SendUrl = "&action=CustomerInfo&CustCode="+escape(CustCode)+"&r="+Math.random();
   	$.ajax({
	type: "GET",
	url: "../sales/ajax.php",
	data: SendUrl,
	dataType : "JSON",
	success: function (responseText)
	 {
		//alert(responseText);
		window.parent.document.getElementById("CustCode").value=CustCode;
		window.parent.document.getElementById("CustID").value=CustId;
		window.parent.document.getElementById("CustomerName").value=responseText["CustomerName"];
		window.parent.document.getElementById("Taxable").value=responseText["Taxable"];
		
if(responseText["MDType"]){
		  if(responseText["MDType"] == 'Discount'){
                        
			//window.parent.document.getElementById("DisType").style.display  = "block";
                        //window.parent.document.getElementById("LevelType").innerHTML = responseText["MDType"];
			window.parent.document.getElementById("CustDisType").value=responseText["DiscountType"];
			window.parent.document.getElementById("MDAmount").value=responseText["MDAmount"];
			window.parent.document.getElementById("MDType").value=responseText["MDType"];
                        window.parent.document.getElementById("MDiscount").value=responseText["MDiscount"];
//if(responseText["MDType"]=="Markup")
//Markup


		}else{

                        //window.parent.document.getElementById("DisType").style.display  = "block";
                       // window.parent.document.getElementById("LevelType").innerHTML = responseText["MDType"];
			window.parent.document.getElementById("CustDisType").value='Percentage';
			window.parent.document.getElementById("MDAmount").value=responseText["MDAmount"];
		        window.parent.document.getElementById("MDType").value=responseText["MDType"];
                        window.parent.document.getElementById("MDiscount").value=responseText["MDiscount"];
		}


	}else{
         //window.parent.document.getElementById("DisType").style.display  = "none";
	 window.parent.document.getElementById("CustDisType").value='';
	 window.parent.document.getElementById("MDAmount").value='';
	 window.parent.document.getElementById("MDType").value='';
window.parent.document.getElementById("MDiscount").value='';
	}
		//Order Quote
	if(creditnote == ""){
			
		window.parent.document.getElementById("PaymentTerm").value=responseText["PaymentTerm"];
		//window.parent.document.getElementById("PaymentMethod").value=responseText["PaymentMethod"];
		window.parent.document.getElementById("ShippingMethod").value=responseText["ShippingMethod"];
		
		if(responseText["SalesPerson"])
			{
			//modifeied by nisha on 19 sept 2018
			window.parent.document.getElementById("SalesPerson").value=responseText["SalesPerson"];
			window.parent.document.getElementById("SalesPersonID").value=responseText["SalesPersonID"];
			window.parent.document.getElementById("vendorSalesPersonID").value=responseText["VendorSalesPerson"];
			window.parent.document.getElementById("vendorSalesPersonName").value=responseText["vendorSalesPersonName"];
			window.parent.document.getElementById("SalesPersonName").value=responseText["SalesPersonName"];
	    window.parent.document.getElementById("SalesPersonType").value=responseText["SalesPersonType"];
		}else{
			window.parent.document.getElementById("SalesPerson").value='';
			window.parent.document.getElementById("SalesPersonID").value='';
			window.parent.document.getElementById("vendorSalesPersonID").value='';
	     window.parent.document.getElementById("SalesPersonType").value='';
	     window.parent.document.getElementById("SalesPersonName").value='';
	     window.parent.document.getElementById("vendorSalesPersonName").value='';
		
		}
	}
		 
	
	window.parent.document.getElementById("CustomerCompany").value=responseText["CustomerCompany"];
	window.parent.document.getElementById("BillingName").value=responseText["Name"];
	window.parent.document.getElementById("Address").value=responseText["Address"];
	window.parent.document.getElementById("City").value=responseText["CityName"];
	window.parent.document.getElementById("State").value=responseText["StateName"];
	window.parent.document.getElementById("Country").value=responseText["CountryName"];
	window.parent.document.getElementById("ZipCode").value=responseText["ZipCode"];
	window.parent.document.getElementById("Mobile").value=responseText["Mobile"];
	window.parent.document.getElementById("Landline").value=responseText["Landline"];
	window.parent.document.getElementById("Fax").value=responseText["Fax"];
	window.parent.document.getElementById("Email").value=responseText["Email"];	

	window.parent.document.getElementById("ShippingCompany").value=responseText["CustomerCompany"];
	window.parent.document.getElementById("ShippingName").value=responseText["sName"];
	window.parent.document.getElementById("ShippingAddress").value=responseText["sAddress"];
	window.parent.document.getElementById("ShippingCity").value=responseText["sCityName"];
	window.parent.document.getElementById("ShippingState").value=responseText["sStateName"];
	window.parent.document.getElementById("ShippingCountry").value=responseText["sCountryName"];
	window.parent.document.getElementById("ShippingZipCode").value=responseText["sZipCode"];
	window.parent.document.getElementById("ShippingMobile").value=responseText["sMobile"];
	window.parent.document.getElementById("ShippingLandline").value=responseText["sLandline"];
	window.parent.document.getElementById("ShippingFax").value=responseText["sFax"];
	window.parent.document.getElementById("ShippingEmail").value=responseText["sEmail"];
	if(window.parent.document.getElementById("CustomerCurrency") != null){
		window.parent.document.getElementById("CustomerCurrency").value=responseText["Currency"];
	}
	if(window.parent.document.getElementById("AccountID") != null){
		window.parent.document.getElementById("AccountID").value=responseText["DefaultAccount"]; 
		parent.$("#AccountID").select2();
	}
// By Rajan 07 Dec	
	window.parent.document.getElementById("shipTR").style.display = "";
	window.parent.document.getElementById("shipTD").innerHTML =responseText["shipList"] 
	// End 
	parent.ProcessTotal();


	if(creditnote == ""){
		parent.shipCarrier();
		parent.SelectCreditCard();
	}else{
		parent.SetGLAccount();
	}

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
<input type="hidden" name="creditnote" id="creditnote" value="<?=$_GET['creditnote']?>">

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
 <td class="head1" >Customer Name</td>
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
    <td><?=$values["CustCode"]?> </td> 
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
