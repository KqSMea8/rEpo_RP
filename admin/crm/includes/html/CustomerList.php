<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}

function SetCustCode(CustCode,CustId){
	ResetSearch();
	window.parent.document.getElementById("Taxable").value='';
	window.parent.document.getElementById("bill_street").value='';
	window.parent.document.getElementById("bill_city").value='';
	window.parent.document.getElementById("bill_state").value='';			
	window.parent.document.getElementById("bill_code").value='';
	window.parent.document.getElementById("bill_country").value='';

	window.parent.document.getElementById("ship_street").value='';
	window.parent.document.getElementById("ship_city").value='';
	window.parent.document.getElementById("ship_state").value='';
	window.parent.document.getElementById("ship_code").value='';
	window.parent.document.getElementById("ship_country").value='';
	

	var SendUrl = "&action=CustomerInfo&CustCode="+escape(CustCode)+"&r="+Math.random();
		
	$.ajax({
		type: "GET",
		url: "../sales/ajax.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText) {

window.parent.document.getElementById("CustCode").value=CustCode;
window.parent.document.getElementById("CustID").value=CustId;
if(responseText["CustomerType"] == "Company"){
window.parent.document.getElementById("CustomerName").value=responseText["CustomerCompany"];
}else{
window.parent.document.getElementById("CustomerName").value=responseText["CustomerName"];
}
			
window.parent.document.getElementById("Taxable").value=responseText["Taxable"];

//alert(responseText["MDType"]);
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

window.parent.document.getElementById("bill_street").value=responseText["Address"];
window.parent.document.getElementById("bill_city").value=responseText["CityName"];
window.parent.document.getElementById("bill_state").value=responseText["StateName"];
window.parent.document.getElementById("bill_country").value=responseText["CountryName"];
window.parent.document.getElementById("bill_code").value=responseText["ZipCode"];
				

window.parent.document.getElementById("ship_street").value=responseText["sAddress"];
window.parent.document.getElementById("ship_city").value=responseText["sCityName"];
window.parent.document.getElementById("ship_state").value=responseText["sStateName"];
window.parent.document.getElementById("ship_country").value=responseText["sCountryName"];
window.parent.document.getElementById("ship_code").value=responseText["sZipCode"];

		
	parent.ProcessTotal();
	/************************************/


		parent.jQuery.fancybox.close();
		ShowHideLoader('1','P');
					
					
						   
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
     
     <td class="head1" >Customer</td>
<td width="14%" class="head1" >Customer Type</td>
 <td width="15%"  class="head1" >Customer Code</td>
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
<a href="Javascript:void(0)" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SetCustCode('<?=$values["CustCode"]?>','<?=$values["Cid"]?>');"><?=stripslashes($values["CustomerName"])?></a>


</td> 
<td><?=stripslashes($values["CustomerType"])?></td>
    <td><?=$values["CustCode"]?>
	
	</td>
    
    <td><?=stripslashes($values["CountryName"])?></td> 
    <td><?=stripslashes($values["StateName"])?></td> 
    <td><?=stripslashes($values["CityName"])?></td> 
    <td><?=$values["Taxable"]?></td>
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_CUSTOMER?></td>
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
