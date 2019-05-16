<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}


function SetItemCode(SuppCode){	
	ResetSearch();
	var SendUrl = "&action=SupplierInfo&SuppCode="+escape(SuppCode)+"&r="+Math.random(); 

	var SelID = $("#SelID").val();

	$.ajax({
		type: "GET",
		url: "ajax.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText) {

			window.parent.document.getElementById("sku"+SelID).value=SuppCode;

			window.parent.document.getElementById("description"+SelID).value=responseText["CompanyName"];
			window.parent.document.getElementById("qty"+SelID).value=responseText["UserName"];
			
			window.parent.document.getElementById("price"+SelID).value=responseText["City"];
			window.parent.document.getElementById("tax"+SelID).value=responseText["State"];
			window.parent.document.getElementById("amount"+SelID).value=responseText["Country"];


			parent.jQuery.fancybox.close();
			ShowHideLoader('1','P');


		}
	});

}

</script>

<div class="had">Select Item</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="SupplierList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
</form>



		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left"  >
      <td width="10%"  class="head1" >SKU</td>
     <td width="20%" class="head1" >Description</td>
       <td width="12%" class="head1" >Purchase Cost</td>
       <td width="12%" class="head1" >Tax</td>
       <td width="12%" class="head1" >City</td>
      <td width="18%"  class="head1" >Contact Name</td>
      <td  class="head1" >Email</td>
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
	<a href="Javascript:void(0)" onclick="Javascript:SetItemCode('<?=$values["SuppCode"]?>');"><?=$values["SuppCode"]?></a>
	</td>
    <td ><?=stripslashes($values["CompanyName"])?></td> 
    <td ><?=stripslashes($values["Country"])?></td> 
    <td ><?=stripslashes($values["State"])?></td> 
    <td ><?=stripslashes($values["City"])?></td> 
    <td height="20" ><?=stripslashes($values["UserName"])?></td>
    <td ><?=stripslashes($values["Email"])?></td>
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_SUPPLIER?></td>
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
<input type="hidden" name="SelID" id="SelID" value="<?=$_GET["id"]?>">
