<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_return'])) {echo $_SESSION['mess_return']; unset($_SESSION['mess_return']); }?></div>

<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>
<form action="" method="post" name="form1"> 
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
		<td align="right" height="22" valign="bottom">

		 
		<a href="ShowRmaList.php" class="fancybox addrma add fancybox.iframe">Add RMA</a>
	 

		<? if($_GET['search']!='') {?>
		<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? } ?>



		<? if($num>0){?>

		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_rma.php?<?=$QueryString?>';" />
		
		<? } ?>

<input type="button" onclick="Javascript:window.print();" value="Print" name="exp" class="print_button">

		<?php if($_SESSION['MarketPlace']==1 || $_GET['sanjiv']=='sanjiv'){?>
		<ul style="margin-right:5px;" class="export_menu">
		<li><a style="background:#d40503 !important; width: 96px;" class="hide" href="#">Sync RMA</a>
		<ul>
		<li><a style="background:#d40503 !important; margin-bottom:2px; margin-top:2px; width: 96px;" href="viewRma.php?synctype=sync_amazon&curP=<?=$_GET['curP']?>">Sync Amazon</a></li>
		<!-- <li> <a style="background:#d40503 !important;width: 96px; " href="viewRma.php?synctype=sync_ebay&curP=<?=$_GET['curP']?>" >Sync Ebay</a></li>	-->

		</ul>
		</li>
		</ul>
		<? }?>

		</td>
	</tr>
		<? if ($num > 0 ) { ?>
			<tr>
			<td align="right" height="40" valign="bottom">


			<?//added by nisha forrow color
				$ToSelect = 'OrderID';
				include_once("../includes/FieldArrayRow.php");
				echo $RowColorDropDown;
			?>
			</td>
			</tr>
       <? }?>
	<tr>
	  <td  valign="top">
	

<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
			<td width="10%" class="head1" >RMA Date</td>
			<!-- <td width="9%"  class="head1" align="center" >RMA Type</td>-->
			<td width="8%"  class="head1" >RMA #</td>
			<td width="8%"  class="head1">Invoice #</td>
			<!--<td width="9%"  class="head1" align="center" >SO Number</td>-->
			<td width="14%" class="head1" >Customer Name</td>
			<td width="8%" class="head1" >Sales Person</td>
			<td width="10%"   class="head1" >Posted By</td>
			<td width="6%" align="center"  class="head1" >Amount</td>
			<td width="5%" align="center"  class="head1" >Currency</td>
			<td width="8%"  align="center" class="head1" >RMA Status</td>
			<td width="8%"  align="center" class="head1 head1_action" >Action</td>
			<td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'OrderID', '<?= sizeof($arryReturn) ?>');" /></td>
    </tr>
   
    <?php

  if(is_array($arryReturn) && $num>0){
  	$flag=true;
	$Line=0;

	$PdfFolder = $Config['S_Rma'];	 	 
	$ModuleDepName = "SalesRMA";
	$module = "RMA";

  	foreach($arryReturn as $key=>$values){
	$flag=!$flag;
 
	$Line++;
  
	/********************/
	$PdfResArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $values["ReturnID"], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $values['OrderID'], 'PdfFolder' => $PdfFolder, 'PdfFile' => $values['PdfFile']));
	/********************/
  ?>
   <tr align="left"  bgcolor="<?= $bgcolor ?>" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?> >
	   <td height="20">
	   <? if($values['ReturnDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ReturnDate']));
		?>
	   
	   </td>
	   <!-- <td align="center"><?=$values["Module"]?></td> -->
       <td ><?=$values["ReturnID"]?></td>
	   <td><?=$values["InvoiceID"]?></td>
      <!-- <td align="center"><a class="fancybox po fancybox.iframe" href="vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$values['SaleID']?>" ><?=$values["SaleID"]?></a></td>-->
       <td> <a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>"><?=stripslashes($values["CustomerName"])?></a> </td> 
	 <td><!--<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values['SalesPersonID'] ?>" ><?= $values['SalesPerson'] ?></a>-->

<? if($values['SalesPersonType']=='1') {?>
		 <a class="fancybox fancybox.iframe" href="../vendorInfo.php?SuppID=<?= $values['SalesPersonID'] ?>" ><?= $values['SalesPerson'] ?></a>
		 <? } else { ?>
		  <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values['SalesPersonID'] ?>" ><?= $values['SalesPerson'] ?></a>
		 <? } ?>
</td>
<td >
<?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  
</td>

       <td align="center" ><?=$values['TotalAmount']?></td>
     <td align="center" ><?=$values['CustomerCurrency']?></td>

 <td align="center"><?  
		 if($values['Status'] == "Closed"){
			echo '<span class=green>'.$values['Status'].'</span>';			
		 }else{
if(!empty($values['Status']))echo $values['Status'];
		 	//if(!empty($values['Status']))echo $values['Status'].'<br>';
		  	//echo '<a href="editRma.php?active_id='.$values["OrderID"].'&curP='.$_GET['curP'].'" class="InActive" onclick="return confirmAction(this,\'RMA Close\',\'Are you sure you want to close this RMA?\' )">Close</a>';
		 }
		
	 ?></td>
    
      <td  align="center" class="head1_inner">

		<a href="vRma.php?view=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&rtn=<?=$values['ReturnID'];?>&Module=RMA"><?=$view?></a>
		
		<?  if($values['Status'] == "Parked"){?>
		<a href="editRma.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>

		<a href="editRma.php?del_id=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&rtn=<?=$values['ReturnID'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a> 
		<? } ?>
               <a href="<?=$PdfResArray['DownloadUrl']?>" ><?=$download?></a>
		<?php 
     //  echo $ModuleName.'this is module name' - line 118; 
       $EmailIcon = ($values['MailSend']!=1)?('emailgreen.png'):('emailred.png');
	   
       $sendemail = '<img src="' . $Config['Url'] . 'admin/images/'.$EmailIcon.'" border="0"  onMouseover="ddrivetip(\'<center>Send '.$module.'</center>\', 120,\'\')"; onMouseout="hideddrivetip()" >'; ;?>
        
     <a <?=$PdfResArray['MakePdfLink']?> class="fancybox fancybox.iframe" href="<?=$SendUrl.'&view='.$values['OrderID']?>" ><?=$sendemail?></a>

	</td>
	<td ><input type="checkbox" name="OrderID[]" id="OrderID<?= $Line ?>" value="<?= $values['OrderID'] ?>" /></td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="11" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="11"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryReturn)>0){?>
&nbsp;&nbsp;&nbsp;Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arryReturn) ?>">

</td>
	</tr>
</table>
</form>
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".addrma").fancybox({
			'width'         : 900
		 });

});
function makepdffile(url){
            $.ajax({
            url: url,
        });
    }
</script>

<? } ?>
