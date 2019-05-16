<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
	}	
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_warehouse'])) {echo $_SESSION['mess_warehouse']; unset($_SESSION['mess_warehouse']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
     <tr>         
	  <td  valign="top" align="right">	  
		   <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_stockin.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
      
      <a href="PoList.php?link=editStockIn.php" class="add fancybox fancybox.iframe" >Add StockIn</a>
      
        <? if($_GET['key']!='') {?>
		  <a class="grey_bt"  href="viewStockIn.php">View All</a>
		<? }?>
         </td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>  
	<tr align="left"  >      
		<td width="15%"  class="head1" >Receiving Number</td>		
		<td class="head1" width="12%">PO Number</td>		
		<td class="head1" width="12%">Currency</td>
		<td class="head1" width="12%">Status</td> 	 
		<td class="head1" width="12%"> Approvied</td> 
		<td width="10%"  align="center" class="head1 head1_action" >Action</td>
    	</tr>   
    	<?php 
  	$stockin = $objWarehouse->ListInStock('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num1=$objWarehouse->numRows();
  if(is_array($stockin) && $num1>0){
  	$flag=true;
	$Line=0;

  	foreach($stockin as $key=>$values){
	$flag=!$flag;	
	$Line++;

  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	<td ><?php echo $values['receiving_number'];?></td>      
	<td ><a href="../purchasing/vPO.php?module=Order&pop=1&po=<?php echo $values['purchase_id'];?>" class="fancybox testadd"><?php echo $values['purchase_id'];?></a></td> 
	<td ><?php echo $values['currency'];?></td> 
     
	 
       
    <td align="center"><? 
		
		
		if($values['status']==1){
			  $status = "Active";
			  }else{
			  $status = "InActive";
			  }
		
	?>
	 
<a href="editStockIn.php?active_id=<?php echo $values['OrderID'];?>&amp;curP=<?php echo $_GET['curP'];?>" class="<?=$status?>" ><?=$status?></a>		
	 </td>
<td ><?php if($values['Approved']==1){
			  $status = "Yes";
                          echo  $status;
			  }else{
			  $status = "No";
                          echo  $status;
			  }?></td>
<!--onclick="Javascript:window.location='export_stockin.php?<?=$QueryString?>';" -->
 <td  align="center"  ><a href="vStockIn.php?module=Order&po=<?php echo $values['PurchaseID'];?>&orderid=<?php echo $values['OrderID'];?>"><input type="button" name="exp" value="Adjust"  /></a>
<a href="editStockIn.php?edit=<?php echo $values['OrderID'];?>&amp;curP=<?php echo $_GET['curP'];?>&amp;tab=StockIn" ><?=$edit?></a>
	  	    </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($stockin)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
 
  </div> 
 <? if(sizeof($stockin)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','WID','editPurchaseOrder.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','WID','editPurchaseOrder.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','WID','editPurchaseOrder.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
