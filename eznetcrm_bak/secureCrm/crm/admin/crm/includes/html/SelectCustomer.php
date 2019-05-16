<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#preview_div").hide();
	$("#frmSrch").hide();
	
}

function SetAddress(CustID,AddID){
	ResetSearch();
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


	var SendUrl = "&action=CustomerAddress&CustID="+escape(CustID)+"&AddID="+escape(AddID)+"&r="+Math.random();
		
	$.ajax({
		type: "GET",
		url: "../sales/ajax.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText) {

window.parent.document.getElementById("CustCode").value=responseText["CustCode"];
window.parent.document.getElementById("CustID").value=CustID;
window.parent.document.getElementById("CustomerName").value=responseText["CustomerName"];			

window.parent.document.getElementById("bill_street").value=responseText["Address"];
window.parent.document.getElementById("bill_city").value=responseText["CityName"];
window.parent.document.getElementById("bill_state").value=responseText["StateName"];
window.parent.document.getElementById("bill_country").value=responseText["CountryName"];
window.parent.document.getElementById("bill_code").value=responseText["ZipCode"];
				

window.parent.document.getElementById("ship_street").value=responseText["Address"];
window.parent.document.getElementById("ship_city").value=responseText["CityName"];
window.parent.document.getElementById("ship_state").value=responseText["StateName"];
window.parent.document.getElementById("ship_country").value=responseText["CountryName"];
window.parent.document.getElementById("ship_code").value=responseText["ZipCode"];
		
		
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
		<td colspan="2" align="left" class="head">Customer Contacts </td>
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
