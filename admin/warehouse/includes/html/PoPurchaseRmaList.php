<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SelectPoReturn(ReturnID,OrderID){
	//alert('hello');
	ResetSearch();
	window.parent.location.href = document.getElementById("link").value+"?rtn="+ReturnID+"&edit="+OrderID+"&Return=1";
	//window.parent.location.href = document.getElementById("link2").value+"?edit="+OrderID+"&Return=1";
}

</script>

<div class="had">Select RMA</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="PoPurchaseRmaList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	 <input type="hidden" name="link" id="link" value="editPoRma.php">
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
      <td width="13%"  class="head1" >RMA Number</td>
       <td width="13%" class="head1" >RMA Date</td>
        <td width="13%" class="head1" >Invoice Number</td>
        <td width="13%" class="head1" >Invoice Date</td>
     <td class="head1"  >Vendor</td>
      <td width="10%" align="center" class="head1" >Amount</td>
      <td width="10%" align="center" class="head1" >Currency</td>
     
    </tr>
   
    <?php 
  if(is_array($arryPurchase) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryPurchase as $key=>$values){
	$flag=!$flag;
	$Line++;

	 if(!empty($values["VendorName"])){
		$VendorName = $values["VendorName"];
	}else{
		$VendorName = $values["SuppCompany"];
	}
	
  ?>
    <tr align="left" >
       <td><a href="Javascript:void(0);" onclick="Javascript:SelectPoReturn('<?=$values['ReturnID']?>','<?=$values['OrderID']?>')" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"><?=$values['ReturnID']?></a></td>
	   <td><? if($values['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?></td>
		<td><?=$values["InvoiceID"]?></td>
	  <td>
	   <? if($values['InvoiceDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));
		?>	   
	   </td>
      <td><?=stripslashes($VendorName)?></td> 
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>


    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  
	 <td colspan="8"  id="td_pager">
	 Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPurchase)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	 </tr>
  </table>

  </div> 


  
</form>
</td>
	</tr>
</table>

