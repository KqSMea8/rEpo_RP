<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#preview_div").hide();
	$("#frmSrch").hide();
	
}

function SetAddress(SuppID,AddID){
	ResetSearch();

window.parent.document.getElementById("SuppCode").value='';
window.parent.document.getElementById("SuppCompany").value='';
window.parent.document.getElementById("SuppContact").value='';
window.parent.document.getElementById("SuppCurrency").value='';
window.parent.document.getElementById("Address").value='';
window.parent.document.getElementById("City").value='';
window.parent.document.getElementById("State").value='';
window.parent.document.getElementById("Country").value='';
window.parent.document.getElementById("ZipCode").value='';
window.parent.document.getElementById("Mobile").value='';
window.parent.document.getElementById("Landline").value='';
window.parent.document.getElementById("Email").value='';


	var SendUrl = "&action=SupplierAddress&SuppID="+escape(SuppID)+"&AddID="+escape(AddID)+"&r="+Math.random();
		
	$.ajax({
		type: "GET",
		url: "ajax.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText) {

window.parent.document.getElementById("SuppCode").value=responseText["SuppCode"];
window.parent.document.getElementById("SuppCompany").value=responseText["CompanyName"];
window.parent.document.getElementById("SuppContact").value=responseText["Name"];
window.parent.document.getElementById("SuppCurrency").value=responseText["Currency"];
window.parent.document.getElementById("Address").value=responseText["Address"];
window.parent.document.getElementById("City").value=responseText["City"];
window.parent.document.getElementById("State").value=responseText["State"];
window.parent.document.getElementById("Country").value=responseText["Country"];
window.parent.document.getElementById("ZipCode").value=responseText["ZipCode"];
window.parent.document.getElementById("Mobile").value=responseText["Mobile"];
window.parent.document.getElementById("Landline").value=responseText["Landline"];
window.parent.document.getElementById("Email").value=responseText["Email"];
		
		
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
<? if($_GET['SuppID']>0){ ?>
<tr>
	<td colspan="2" align="right" valign="top" > 
	<a class="back" href="SelectVendor.php" onclick="Javascript:ResetSearch();">Back</a> 
	</td>
</tr>

<tr>
	<td width="14%"  align="right" valign="top"  class="blackbold"> 
	Vendor Code : </td>
	<td   align="left" valign="top">
		<?=stripslashes($arrySupplier[0]['SuppCode'])?>
	</td>
</tr>
 <tr>
                <td  align="right" valign="top"  class="blackbold"> 
                    Company Name :  </td>
                 <td align="left"><?=stripslashes($arrySupplier[0]['CompanyName'])?></td>
                
            </tr>
 <tr>
                <td  align="right" valign="top"  class="blackbold"> 
                    Contact Name :  </td>
                 <td align="left"><?=stripslashes($arrySupplier[0]['UserName'])?></td>
                
            </tr>
	

        <tr>
                <td align="right" valign="top" class="blackbold"> 
                  Vendor  Email :  </td>
                <td align="left"><?=stripslashes($arrySupplier[0]['Email'])?></td>
            </tr>

<tr>
		<td colspan="2" align="left" class="head">Vendor Contacts </td>
	</tr>	
	<tr>
		<td colspan="2" align="left">
	<? 
	$SuppID = $_GET['SuppID'];
	include("includes/html/box/vendor_contact_sel.php");
	?>
	</td>
	</tr>



<? }else{ ?>

<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="SelectVendor.php" method="get" onSubmit="return ResetSearch();">
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
      <td width="15%"  class="head1" >Vendor Code</td>
     <td class="head1" >Company Name</td>
       <td width="14%" class="head1" >Country</td>
       <td width="14%" class="head1" >State</td>
       <td width="14%" class="head1" >City</td>
      <!--td width="10%"  class="head1" >Currency</td-->
    </tr>
   
    <?php 
  if(is_array($arrySupplier) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arrySupplier as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	<td>
	<a href="SelectVendor.php?SuppID=<?=$values['SuppID']?>" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:ResetSearch();"><?=stripslashes($values["SuppCode"])?></a>
	</td> 
	<td><?=stripslashes($values["CompanyName"])?></td>    
	<td><?=stripslashes($values["Country"])?></td> 
	<td><?=stripslashes($values["State"])?></td> 
	<td><?=stripslashes($values["City"])?></td> 
	<!--td><?=$values["Currency"]?></td-->
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_SUPPLIER?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arrySupplier)>0){?>
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
