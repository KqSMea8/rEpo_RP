<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SetCustCode(CustCode,CustId,creditnote){
	ResetSearch();
	var SendUrl = "&action=CustomerInfo&CustCode="+escape(CustCode)+"&r="+Math.random();
	//window.open(SendUrl);
	//return false;
	
	
   	$.ajax({
	type: "GET",
	url: "ajax.php",
	data: SendUrl,
	dataType : "JSON",
	success: function (responseText) {
		window.parent.document.getElementById("CustCode").value=CustCode;
		window.parent.document.getElementById("CustID").value=CustId;
		window.parent.document.getElementById("CustomerName").value=responseText["CustomerName"];
		window.parent.document.getElementById("Taxable").value=responseText["Taxable"];
		
		//Order Quote
		/*
		if(creditnote == ""){
		//window.parent.document.getElementById("PaymentTerm").value=responseText["PaymentTerm"];
		//window.parent.document.getElementById("PaymentMethod").value=responseText["PaymentMethod"];
		//window.parent.document.getElementById("ShippingMethod").value=responseText["ShippingMethod"];
		}
		*/
		//window.parent.document.getElementById("CustomerCurrency").value=responseText["Currency"];
	/*
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
*/




	
	/***/
	/*
	if(window.parent.document.getElementById("contact_link") != null){
		window.parent.document.getElementById("ContactDiv").innerHTML='';	
		window.parent.document.getElementById("SpiffContact").value='';	
		var contact_link = window.parent.document.getElementById("contact_link");
		contact_link.setAttribute("href", 'CustomerContact.php?CustID='+CustId);
	}
	*/
	/***/





	//alert(responseText);
		//return false;
	//parent.ProcessTotal();
	
	/************************************/
	


		parent.jQuery.fancybox.close();
		ShowHideLoader('1','P');
	
		   
	},
	 error: function(responseText){  
         alert('Error: ' + responseText);  
         }       

   });
				


}




</script>

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
      <td width="15%"  class="head1" >Customer Code</td>
     <td class="head1" >Customer Name</td>
       <td width="14%" class="head1" >Country</td>
       <td width="14%" class="head1" >State</td>
       <td width="14%" class="head1" >City</td>
      <td width="10%"  class="head1" >Taxable</td>
    </tr>
   
    <?php 
  if(is_array($arryCustomer) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCustomer as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	if(empty($values["Taxable"])) $values["Taxable"]="No";
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td>
	<a href="Javascript:void(0)" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SetCustCode('<?=$values["CustCode"]?>','<?=$values["Cid"]?>','<?=$_GET['creditnote']?>');"><?=$values["CustCode"]?></a>
	</td>
    <td><?=stripslashes($values["FirstName"]." ".$values["LastName"])?></td> 
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
