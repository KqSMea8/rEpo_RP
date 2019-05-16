<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_credit'])) {echo $_SESSION['mess_credit']; unset($_SESSION['mess_credit']); }?></div>


<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="top">
			<a href="<?=$AddUrl?>" class="add">Add <?=$ModuleName?></a>
	
		   <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_credit_note.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
	 
		

		 <? if($_GET['search']!='') {?>
	  	<a href="viewCreditNote.php" class="grey_bt">View All</a>
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
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arryPurchase)?>');" /></td>-->
       <td width="13%" class="head1" >Posted Date</td>
     <td width="12%"  class="head1" >Credit Note ID</td>
        <td width="13%" class="head1" >Expiry Date</td>
    <td class="head1" >Vendor</td>
      <td width="8%" align="center" class="head1" >Amount</td>
      <td width="8%" align="center" class="head1" >Currency</td>
     <td width="8%"  align="center" class="head1" >Status</td>
       <td width="8%"  align="center" class="head1" >Approved</td>
      <td width="15%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryPurchase) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryPurchase as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	   <td height="20">
	   <? if($values['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?>
	   
	   </td>
      <td><?=$values["CreditID"]?></td>
	  <td>
	   <? if($values['ClosedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ClosedDate']));
		?>
	   
	   </td>
      <td><a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$values['SuppCode']?>" ><?=stripslashes($values["SuppCompany"])?></a></td> 
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>
     <td align="center">
	 <? 
		 if($values['Status'] =='Open'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = 'red';
		 }

		echo '<span class="'.$StatusCls.'">'.$values['Status'].'</span>';
		
	 ?>
	 
	</td>


    <td align="center"><? 
		 if($values['Approved'] ==1){
			  $Approved = 'Yes';  $ApprovedCls = 'green';
		 }else{
			  $Approved = 'No';  $ApprovedCls = 'red';
		 }

		echo '<span class="'.$ApprovedCls.'">'.$Approved.'</span>';
		
	 ?></td>
      <td  align="center" class="head1_inner">

<a href="<?=$ViewUrl.'&view='.$values['OrderID']?>" ><?=$view?></a>
<a href="<?=$EditUrl.'&edit='.$values['OrderID']?>" ><?=$edit?></a>
<a href="<?=$EditUrl.'&del_id='.$values['OrderID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a> 
<a href="pdfCreditNote.php?o=<?=$values['OrderID']?>" ><?=$download?></a>

<?
if($module=="Order"){ 
	$TotalInvoice=$objPurchase->CountInvoices($values['PurchaseID']);
	if($TotalInvoice>0)
		echo '<br><a href="viewInvoice.php?po='.$values['PurchaseID'].'" target="_blank">Invoices</a>';
	if($values['Status'] =='Open' && $values['Approved'] ==1)
		echo '<br><a href="recieveOrder.php?po='.$values['OrderID'].'" target="_blank">Receive</a>';
}
?>

	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPurchase)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryPurchase)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td  align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>

<? } ?>