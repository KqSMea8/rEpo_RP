<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}



function SetSuppCode(SuppCode){	
	ResetSearch();

	if(document.getElementById("link").value != ''){
		window.parent.location.href= document.getElementById("link").value+"?sc="+SuppCode;
	}else{

				var SendUrl = "&action=SupplierInfo&SuppCode="+escape(SuppCode)+"&r="+Math.random(); 

				$.ajax({
					type: "GET",
					url: "ajax.php",
					data: SendUrl,
					dataType : "JSON",
					success: function (responseText) {

window.parent.document.getElementById("SuppCode").value=SuppCode;
window.parent.document.getElementById("SuppCompany").value=responseText["CompanyName"];
window.parent.document.getElementById("SuppContact").value=responseText["UserName"];
//window.parent.document.getElementById("SuppCurrency").value=responseText["Currency"];
window.parent.document.getElementById("Address").value=responseText["Address"];
window.parent.document.getElementById("City").value=responseText["City"];
window.parent.document.getElementById("State").value=responseText["State"];
window.parent.document.getElementById("Country").value=responseText["Country"];
window.parent.document.getElementById("ZipCode").value=responseText["ZipCode"];
window.parent.document.getElementById("Mobile").value=responseText["Mobile"];
window.parent.document.getElementById("Landline").value=responseText["Landline"];
window.parent.document.getElementById("Email").value=responseText["Email"];
/*if(window.parent.document.getElementById("Currency") != null){
	window.parent.document.getElementById("Currency").value=responseText["Currency"];
}*/



						parent.jQuery.fancybox.close();
						ShowHideLoader('1','P');


					}
				});

	}


}

</script>

<div class="had">Select <?=$ModuleName?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="SupplierList.php" method="get" onSubmit="return ResetSearch();">
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
      <td width="12%"  class="head1" >Vendor Code</td>
     <td class="head1" >Company Name</td>
       <td width="14%" class="head1" >Country</td>
       <td width="14%" class="head1" >State</td>
       <td width="14%" class="head1" >City</td>
      <td width="10%"  class="head1" >Currency</td>
    </tr>
   
    <?php 
  if(is_array($arrySupplier) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arrySupplier as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
    <td>
	<a href="Javascript:void(0)" onclick="Javascript:SetSuppCode('<?=$values["SuppCode"]?>');" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"><?=$values["SuppCode"]?></a>
	</td>
    <td><?=stripslashes($values["CompanyName"])?></td> 
    <td><?=stripslashes($values["Country"])?></td> 
    <td><?=stripslashes($values["State"])?></td> 
    <td><?=stripslashes($values["City"])?></td> 
    <td><?=$values["Currency"]?></td>
      
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

  </div> 

  
</form>
</td>
	</tr>
</table>
