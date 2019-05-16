<script language="JavaScript1.2" type="text/javascript">

function ShowDateField(){	
	 if(document.getElementById("fby").value=='Year'){
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else{
		document.getElementById("yearDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'block';
		document.getElementById("toDiv").style.display = 'block';	
	 }
}

function ValidateSearchForm(frm){	

	ShowHideLoader(1,'F');
	return true;	

}

function ValidateSearch(frm){	

	if(document.getElementById("fby").value=='Year'){
		if(!ValidateForSelect(frm.y, "Year")){
			return false;	
		}
	}else{
		/*if(!ValidateForSelect(frm.w1, "From Warehouse")){
			return false;	
		}
		if(!ValidateForSelect(frm.w2, "To Warehouse")){
			return false;	
		}*/
		if(frm.w1.value!='' && frm.w1.value==frm.w2.value){
			alert("From warehouse and To warehouse should not be same.");
			return false;	
		}
		if(!ValidateForSelect(frm.f, "From Date")){
			return false;	
		}
		if(!ValidateForSelect(frm.t, "To Date")){
			return false;	
		}

		if(frm.f.value>frm.t.value){
			alert("From Date should not be greater than To Date.");
			return false;	
		}

		

	}

	ShowHideLoader(1,'F');
	return true;	



	
}
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearchForm(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>


<td valign="bottom">
		<input id="keyword" name="keyword" size="15"  class="textbox" value="<?=$_GET['keyword']?>"  type="text" placeholder="Search by Keyword" > 	
		</td>


		<td valign="bottom">
		<select style="width: 120px;" name="CatID" class="inputbox" id="CatID" >
		  <option value="">--- Category ---</option>
		 
	<?php
	$objCategory->getCategories(0, 0, $_GET['CatID']);
	?>
		</select>		
		</td>
		
	   <td>&nbsp;</td>
<td valign="bottom">
		<select style="width: 120px;" name="Genration" class="inputbox" id="Genration" >
		  <option value="">--- Generation ---</option>
		  <? for($i=0;$i<sizeof($arryGeneration);$i++) {?>
		  <option value="<?=$arryGeneration[$i]['attribute_value']?>" <?  if($arryGeneration[$i]['attribute_value']==$_GET['Genration']){echo "selected";}?>>
		  <?=stripslashes($arryGeneration[$i]['attribute_value'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>

	   <td>&nbsp;</td>

		<td valign="bottom">
		
		  <select name="Manufacturer" class="textbox" id="Manufacturer" style="width:140px;" >
<option value="" <?  if(empty($_GET['Manufacturer'])){echo "selected";}?>>--- Manufacturer ---</option>
					 <? for($i=0;$i<sizeof($arryManufacture);$i++) {?>
		  <option value="<?=$arryManufacture[$i]['attribute_value']?>" <?  if($arryManufacture[$i]['attribute_value']==$_GET['Manufacturer']){echo "selected";}?>>
		  <?=stripslashes($arryManufacture[$i]['attribute_value'])?>
		  </option>
		  <? } ?>
		</select> 
		</td>
<td valign="bottom">
		
		  <select name="Model" class="textbox" id="Model" style="width:120px;" >
                              <option value="" <?  if(empty($_GET['Model'])){echo "selected";}?>>--- Model ---</option>
					  <? for($i=0;$i<sizeof($arryModel);$i++) {?>
		  <option value="<?=$arryModel[$i]['id']?>" <?  if($arryModel[$i]['id']==$_GET['Model']){echo "selected";}?>>
		  <?=stripslashes($arryModel[$i]['Model'])?>
		  </option>
		  <? } ?>
		</select> 
		</td>
	   <td>&nbsp;</td>


		

	  <td align="right" valign="bottom"> <input name="sb" type="submit" class="search_button" value="Go"  />
	  
	  
	  
	  </td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>	
	
	
	
	
	
	<? if($num>0){?>
	<tr>
        <td align="right" valign="bottom">
<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_transfer_report.php?<?=$QueryString?>';"/-->
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
		</td>
      </tr>
	 <? } ?>

	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<? if($ShowData == 1){ ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
	<td width="8%"  class="head1" >SKU</td>
	<td width="20%"  class="head1" >Description</td>
	<td width="9%" class="head1" >Condition</td>
	<td width="8%" class="head1" >Stock</td>
	<td width="8%" class="head1" >Cost</td>
	<td width="8%" class="head1" >Price</td>
	
	<td width="8%" align="center" class="head1" >On PO</td>
	<td  width="8%" align="center" class="head1" >PO History</td>
	<td   align="center" class="head1" >Sales History</td>
<!--td width="6%"  align="center" class="head1" >Other</td-->

    </tr>
   
    <?php 

	
  if(is_array($arryStockItem) && $num>0){
  	$flag=true;
	$Line=0;

  	foreach($arryStockItem as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

$TotalPo = $objItem-> CountPo($values["Sku"]);
$SumPo = $objItem-> GetSumPo($values["Sku"]);

	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
       <td><?=$values["Sku"]?></td>
	   <td><?=stripslashes($values["description"])?> </td>
	   <td height="20"><?=stripslashes($values["Condition"])?>	   </td>
      <td><?=$values['qty_on_hand']?></td>
<td><?=$values['sell_price']?></td>
<td><?=$values['sell_price']?></td>
      <!--td><a class="fancybox fancybox.iframe" href="../warehouse/vWarehouse.php?view=<?=$values['from_WID']?>&pop=1" ><?=stripslashes($values['from_warehouse_name'])?> [<?=stripslashes($values["from_warehouse"])?>]</a></td--> 
	  <!--td><a class="fancybox fancybox.iframe" href="../warehouse/vWarehouse.php?view=<?=$values['to_WID']?>&pop=1" ><?=stripslashes($values['to_warehouse_name'])?> [<?=stripslashes($values["to_warehouse"])?>]</a></td--> 
	  
       <td align="center"> <?=$SumPo?></td>
    
     <td align="center"><a class="fancybox fancybox.iframe" href="viewPOHistory.php?sku=<?=$values['Sku']?>">View</a></td>
<td align="center"><table><tr><td><a class="fancybox fancybox.iframe" href="viewSaleHistory.php?sku=<?=$values['Sku']?>&numHistory=7d">7d</a>| <a class="fancybox fancybox.iframe" href="viewSaleHistory.php?sku=<?=$values['Sku']?>&numHistory=30d">30d</a> | <a class="fancybox fancybox.iframe" href="viewSaleHistory.php?sku=<?=$values['Sku']?>&numHistory=7m">6m</a>| <a class="fancybox fancybox.iframe" href="viewSaleHistory.php?sku=<?=$values['Sku']?>&numHistory=1year">1 year</a> </td></tr></table></td>
<!--td align="center"><a href="">More</a></td-->

   
    
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No Records Found</td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryStockItem)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
<? } ?>

  </div> 
 

<?  //if($num>0){
	//echo '<div style="text-align:center;padding-top:30px;" >';
	//echo '<img src="barPO.php?module=Order&f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&y='.$_GET['y'].'&s='.$_GET['s'].'&st='.$_GET['st'].'" >';
	//echo '</div>';
//}
?>

  
</form><!--a class="fancybox fancybox.iframe" href="custInfo.php?view=<?=$values['CustCode']?>"-->
</td>
	</tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});
$(document).ready(function() {
	$(".fancybox").fancybox({
	  
          'height'         : 800
	 });

});
</script>

<? echo '<script>SetInnerWidth();</script>'; ?>
