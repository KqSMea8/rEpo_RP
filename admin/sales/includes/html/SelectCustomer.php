<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#preview_div").hide();
	$("#frmSrch").hide();
	
}

function SetAddress(CustID,AddID){
	ResetSearch();
	window.parent.document.getElementById("CustomerCompany").value='';
	window.parent.document.getElementById("CustomerName").value='';
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


	var SendUrl = "&action=CustomerAddress&CustID="+escape(CustID)+"&AddID="+escape(AddID)+"&r="+Math.random();
		
	$.ajax({
		type: "GET",
		url: "ajax.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText) {

window.parent.document.getElementById("CustCode").value=responseText["CustCode"];
window.parent.document.getElementById("CustID").value=CustID;
window.parent.document.getElementById("CustomerName").value=responseText["CustomerName"];	

/*
if(creditnote == ""){
window.parent.document.getElementById("PaymentTerm").value=responseText["PaymentTerm"];
window.parent.document.getElementById("PaymentMethod").value=responseText["PaymentMethod"];
window.parent.document.getElementById("ShippingMethod").value=responseText["ShippingMethod"];
}*/


window.parent.document.getElementById("CustomerCompany").value=responseText["CustomerCompany"];
window.parent.document.getElementById("BillingName").value=responseText["FullName"];
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
window.parent.document.getElementById("ShippingName").value=responseText["FullName"];
window.parent.document.getElementById("ShippingAddress").value=responseText["Address"];
window.parent.document.getElementById("ShippingCity").value=responseText["CityName"];
window.parent.document.getElementById("ShippingState").value=responseText["StateName"];
window.parent.document.getElementById("ShippingCountry").value=responseText["CountryName"];
window.parent.document.getElementById("ShippingZipCode").value=responseText["ZipCode"];
window.parent.document.getElementById("ShippingMobile").value=responseText["Mobile"];
window.parent.document.getElementById("ShippingLandline").value=responseText["Landline"];
window.parent.document.getElementById("ShippingFax").value=responseText["Fax"];
window.parent.document.getElementById("ShippingEmail").value=responseText["Email"];
		
		
		parent.jQuery.fancybox.close();
		//ShowHideLoader('1','P');
					
					
						   
		}
	});


}



</script>

<div class="had"><?=$PageTitle?></div>
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div" style="height:600px;">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<? if($_GET['Cid']>0){ ?>
<tr>
	<td colspan="2" align="right" valign="top" > 
	<a class="back" href="SelectCustomer.php" onclick="Javascript:ResetSearch();">Back</a> 
	</td>
</tr>

 <tr>
                <td  align="right" valign="top"  class="blackbold"> 
                    Customer Name :  </td>
                 <td align="left"><?=stripslashes($arryCustomer[0]['FullName'])?></td>
                
            </tr>
	
<tr>
	<td width="14%"  align="right" valign="top"  class="blackbold"> 
	Customer Code : </td>
	<td   align="left" valign="top">
		<?=stripslashes($arryCustomer[0]['CustCode'])?>
	</td>
</tr>


        <tr>
                <td align="right" valign="top" class="blackbold"> 
                  Customer  Email :  </td>
                <td align="left"><?=stripslashes($arryCustomer[0]['Email'])?></td>
            </tr>

<tr>
		<td colspan="2" align="left" class="head">Contacts </td>
	</tr>	
	<tr>
		<td colspan="2" align="left">
	<? 
	$CustID = $_GET['Cid'];
	include("../includes/html/box/customer_contact_sel.php");
	?>
	</td>
	</tr>



<? }else{ ?>

<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="SelectCustomer.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
</form>



		</td>
      </tr>
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">


<table <?=$table_bg?>>
    <tr align="left"  >
     
     <td class="head1" >Customer Name</td>
 <td width="15%"  class="head1" >Customer Code</td>
       <td width="14%" class="head1" >Country</td>
       <td width="14%" class="head1" >State</td>
       <td width="14%" class="head1" >City</td>
      <!--td width="10%"  class="head1" >Currency</td-->
    </tr>
   
    <?php 
  if(is_array($arryCustomer) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCustomer as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	 <td>

<!--a href="Javascript:void(0)" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SetCustCode('<?=$values["CustCode"]?>','<?=$values["Cid"]?>');"><?=stripslashes($values["FullName"])?></a-->

<a href="SelectCustomer.php?Cid=<?=$values['Cid']?>" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:ResetSearch();"><?=stripslashes($values["FullName"])?></a>

</td> 
    <td><?=$values["CustCode"]?>
	
	</td>
   
    <td><?=stripslashes($values["CountryName"])?></td> 
    <td><?=stripslashes($values["StateName"])?></td> 
    <td><?=stripslashes($values["CityName"])?></td> 
    <!--td><?=$values["Currency"]?></td-->
      
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



  
</form>
</td>
	</tr>
<? } ?>
</table>
</div>
