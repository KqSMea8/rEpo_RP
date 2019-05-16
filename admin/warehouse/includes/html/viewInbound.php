<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_return'])) {echo $_SESSION['mess_return']; unset($_SESSION['mess_return']); }?></div>


<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" height="40" valign="bottom">
		
		   <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_return.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
		<? if(empty($_GET['po'])){ ?>
			<a class="fancybox add fancybox.iframe" href="PoList.php?link=editInbound.php" >Stock In</a>
		<? } ?>

		<? if($_GET['search']!='') {?>
			<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? } ?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arryReturn)?>');" /></td>-->
      <!--td width="12%" class="head1" >Received Date</td-->
	  <td width="13%"  class="head1" >Receipt No</td>
      <td width="13%"  class="head1" >Transaction Ref</td>
	  <td width="10%" class="head1" >Order Date</td>
	  <td class="head1" width="13%" >Vendor</td>
	  <td width="10%" align="center" class="head1" >Status</td>
      <td width="8%" align="center" class="head1" >Amount</td>
      <td width="8%" align="center" class="head1" >Currency</td>
       
      <td width="14%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 


  if(is_array($arryRecieve) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryRecieve as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	   <!--td height="20">
	   <? if($values['ReceivedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ReceivedDate']));
		?>
	   
	   </td-->
	   <td><?=$values["RecieveID"]?></td>
       <td style="display:none;"><a class="fancybox fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$values['PurchaseID']?>" ><?=$values["PurchaseID"]?></a></td>
       <td ><a class="fancybox fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$values['PurchaseID']?>" ><?=$values["PurchaseID"]?></a></td>
	   	<td>
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>	   
	   </td>
      <td> <a class="fancybox fancybox.iframe" href="../purchasing/suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($values["SuppCompany"])?></a> </td> 
	  
	   <td class="green"  align="center">
	   
	   <?=$values['RecieveStatus']?>

<? if($values['RecieveStatus'] == 'StockIn'){

//echo '<br><a href="editPutway.php?rec='.$values['RecieveID'].'&curP='.$_GET['curP'].'&po='.$values['PurchaseID'].'" class="fancybox action_bt" >Putaway</a>';


}?>

</td>
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>


  
      <td  align="center" class="head1_inner">

<a href="vInbound.php?view=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>"><?=$view?></a>

<!--a href="editInbound.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>"><?=$edit?></a-->
<!--a href="editInbound.php?del_id=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a--> 
<a href="pdfRecieve.php?o=<?=$values['OrderID']?>" ><?=$download?></a>



	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryReturn)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryReturn)){ ?>
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

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
$(".fancybox").fancybox({
'width'         : 900
 });

});

</script>

<? } ?>

<? 
if($module=="StockIn"){
 include("includes/html/box/offer_form.php");

}?>
