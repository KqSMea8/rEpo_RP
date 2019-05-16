<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SelectSO(OrderID,InvoiceID){	
	ResetSearch();
var bom_Sku = document.getElementById("bom_Sku").value;
	window.parent.location.href = document.getElementById("link").value+"?bc="+OrderID+"&option_code="+InvoiceID+"&option_bill=1&bom_Sku="+bom_Sku;
}

</script>

<div class="had">Option Bill&nbsp;<?=$_GET['key']?>
<a href="bomList.php?link=<?=$_GET['link']?>" class="back">Back</a>
</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_salr'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left">
	    <td width="12%" class="head1">Option Code</td>
	   <td  class="head1">Description</td>
		
    </tr>
   
	<?php 
	if(is_array($arryOption) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryOption as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	?>
	<tr align="left"  bgcolor="<?=$bgcolor?>">
			<td><a href="Javascript:void(0);" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SelectSO('<?=$values['bomID']?>','<?=$values['optionID']?>')"><?=$values['option_code']?></a></td>
			
			<td><?=stripslashes($values["description1"])?></td> 
			

    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No Option Bill Found.</td>
    </tr>
    <?php } ?>
  
	 <tr>  
	 <td colspan="8"  id="td_pager">
	 Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryOption)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	 </tr>
  </table>

  </div> 

<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
<input type="hidden" name="bom_Sku" id="bom_Sku" value="<?=$_GET['bom_Sku']?>">
  
</form>
</td>
	</tr>
</table>

