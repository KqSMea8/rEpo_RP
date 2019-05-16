<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>
<script language="JavaScript1.2" type="text/javascript">
function ShowActionListVendor(){
    ShowHideLoader(1,'L');
    document.forms["form2"].submit();
}
</script> 
<style>
@media print
{    
    .vendor_drop
    {
        display: none;
    }
}
</style> 

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_return'])) {echo $_SESSION['mess_return']; unset($_SESSION['mess_return']); }?></div>
<?php /*?>
 <form action="" method="get" enctype="multipart/form-data" name="form2" class="vendor_drop">
        <table border="0" cellpadding="3" cellspacing="0" id="search_table"
            style="margin: 0">
            <tr>
                <td valign="bottom">
                    <select id="Module" class="inputbox" name="Module" onChange="Javascript:ShowActionListVendor();">
                    <option value="Return"<?php if($_GET['Module']=='Return' || $_GET['Module']==''){echo "selected='selected'";}?>>Return</option>
                    <option value="Credit"<?php if($_GET['Module']=='Credit'){echo "selected='selected'";}?>>Credit</option>
                    </select>
                </td>
            </tr>

        </table>
</form>
<?php */?>
<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>
<form action="" method="post" name="form1"> <!---moved here for row color by nisha----->
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" height="40"  >
		 
		<a class="fancybox addrma add fancybox.iframe" href="RmaList.php?link=editRma.php" >Add RMA</a> 
		 
		   <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_rma.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
		

		<? if($_GET['search']!='') {?>
			<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? } ?>


		</td>
      </tr>
	  <? if ($num > 0 ) { ?>
            <tr>
                <td align="right" height="40" valign="bottom">


<?
//added by nisha for row color
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
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arryReturn)?>');" /></td>-->
       <td width="10%" class="head1" >RMA Date</td>
 <!--td width="12%"   class="head1" >RMA Expiry Date</td-->
      <td width="8%"  class="head1" >RMA #</td>
      <td width="8%"  class="head1" >Invoice #</td>
	  <td width="12%" class="head1" >Invoice Date</td>
	  <td class="head1" >Vendor</td>
	<td width="10%"   class="head1" >Posted By</td>
      <td width="8%" align="center" class="head1" >Amount</td>
      <td width="6%" align="center" class="head1" >Currency</td>
       <td width="10%" align="center" class="head1" >RMA Status</td>
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
<td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'OrderID', '<?= sizeof($arryReturn) ?>');" /></td>
    </tr>
   
    <?php 
  if(is_array($arryReturn) && $num>0){
  	$flag=true;
	$Line=0;
 
 
	$module = "RMA";


  	foreach($arryReturn as $key=>$values){
  		
	$flag=!$flag;
	$Line++;

	if(!empty($values["VendorName"])){
		$VendorName = $values["VendorName"];
	}else{
		$VendorName = $values["SuppCompany"];
	}
	
	/********************/
	$PdfResArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $values["ReturnID"], 'ModuleDepName' => 'PurchaseRMA', 'OrderID' => $values['OrderID'], 'PdfFolder' => $Config['P_Rma'], 'PdfFile' => $values['PdfFile']));
	/********************/

	 
  ?>
    <tr align="left"  bgcolor="<?= $bgcolor ?>" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?> >
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	   <td height="20">
	   <? if($values['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?>
	   
	   </td>
    	<!--td>
	   <? if($values['ExpiryDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ExpiryDate']));
		?>
	   
	   </td-->
       <td><?=$values["ReturnID"]?></td>
       <td><?=$values["InvoiceID"]?></td>
       <?php /*?><td><a class="fancybox fancybox.iframe" href="vPO.php?module=Invoice&pop=1&po=<?=$values['InvoiceID']?>" ><?=$values["InvoiceID"]?></a></td><?php */?>
	   	<td>
	   <? if($values['InvoiceDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));
		?>	   
	   </td>
      <td> <a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($VendorName)?></a> </td> 
<td >
<?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  
</td>
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>
 <td align="center"><? 
		 if($values['Status'] == "Closed"){
			echo '<span class=green>'.$values['Status'].'</span>';			
		 }else{
			if(!empty($values['Status'])) echo $values['Status'].'<br>';
		  	echo '<a href="editRma.php?active_id='.$values["OrderID"].'&curP='.$_GET['curP'].'" class="InActive" onclick="return confirmAction(this,\'RMA Close\',\'Are you sure you want to close this RMA?\' )">Close</a>';
		 }
	
		
		
	 ?></td>

      <td  align="center" class="head1_inner">

<a href="vRma.php?view=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>"><?=$view?></a>

<?  if($values['Status'] == "Parked"){?>
<a href="editRma.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>

<a href="editRma.php?del_id=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a> 
<? } ?>

 
<a href="<?=$PdfResArray['DownloadUrl']?>" ><?=$download?></a>
<?php 
 
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
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
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
