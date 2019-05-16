<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}

/*$(document).ready(function(){
$("#SelectAll").click(function(){
   var flag,i;
   if($("#SelectAll").prop("checked") == true){
     flag = true;
   }else{
   flag = false;
   }
   var totalCheckboxes = $('input:checkbox').length;
   for(i=1; i<=totalCheckboxes; i++){
		document.getElementById('OrderID'+i).checked=flag;
	}
});
});*/
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Invoice'])) {echo $_SESSION['mess_Invoice']; unset($_SESSION['mess_Invoice']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="top">
		
		   <? if($num>0){?>
<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_invoice.php?<?=$QueryString?>';" / -->
<!--<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>-->
	  <? } ?>
	
		 <? if($_GET['search']!='') {?>
	  	<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arrySale)?>');" /></td>-->
		<td width="13%" class="head1" >Ship Date</td>
		<td width="12%" align="center"  class="head1" >Module</td>
		<td width="12%"  align="center" class="head1" >Ship Number</td>
		<td width="12%" class="head1">Reference</td>
		<td  width="10%" class="head1">Ship Type</td>
		<td width="8%" align="center" class="head1">Transport</td>
		
		<td width="10%" align="center" class="head1">Create By</td>
		
		<!--td width="8%"  align="center" class="head1">Download</td-->
		<td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 


  if(is_array($arryShip) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryShip as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	   <td height="20">
	   <? if($values['ShipDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ShipDate']));
		?>
	   
	   </td>
      <td align="center"><?=$values['Module']?></td>
	  <td align="center"><?=$values['shipID']?></td>
      <td>
	  <? if($values['OrderType']=='Sales'){
         $LinkUrl = '../sales/vInvoice.php?so='.$values['OrderID'].'&invoice='.$values['RefID'].'&module=Invoice';
	   }else if($values['OrderType'] == 'Transfer'){

       $LinkUrl = '../inventory/vTransfer.php?view='.$values['RefID'].'';
	   }else{
     
       $LinkUrl = '../purchase/vInvoice.php?po='.$values['OrderID'].'&invoice='.$values['RefID'].'&module=Invoice';
	   }
	  ?>
	  <!--a href="<?=$LinkUrl?>" class="fancybox po fancybox.iframe"><?=stripslashes($values["RefID"])?></a --><?=stripslashes($values["RefID"])?></td> 
	  <td><?=stripslashes($values['OrderType'])?></td>
      
	  <!--<td align="center"><//?=$values['TotalAmount']?></td>-->
      <td align="center"><?=$values['transport']?></td>
     <td align="center"><? if($values['AdminType']=='admin'){ echo "Admin"; }else{echo $values['CreatedBy']; } ?></td>
    <td  align="center" class="head1_inner">

<!-- a href="../sales/<?=$ViewUrl.'&view='.$values['OrderID']?>" ><?=$view?></a -->
<!--a href="../sales/<?=$EditUrl.'&edit='.$values['OrderID']?>" ><?=$edit?></a-->
<a href="<?=$RedirectURL.'?del_id='.$values['id']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a> 
<?
if($module=="Order"){ 

$TotalGenerateInvoice=$objSale->GetQtyInvoiced($values['OrderID']);


	/*$TotalInvoice=$objSale->CountInvoices($values['SaleID']);
	if($TotalInvoice>0)
		echo '<br><a href="viewInvoice.php?so='.$values['SaleID'].'" target="_blank">Invoices</a>';*/
	if($values['Status'] =='Open' && $values['Approved'] ==1 && $TotalGenerateInvoice[0]['QtyInvoiced'] != $TotalGenerateInvoice[0]['Qty'])
		echo '<br><a href="generateInvoice.php?so='.$values['id'].'&module=Order" target="_blank">'.GENERATE_INVOICE.'</a>';
}
?>

	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryShip)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>

