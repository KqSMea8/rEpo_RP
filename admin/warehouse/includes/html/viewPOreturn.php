<script language="JavaScript1.2" type="text/javascript">

function ShowDateField(){	
	 if(document.getElementById("fby").value=='Year'){
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else if(document.getElementById("fby").value=='Month'){
	    document.getElementById("monthDiv").style.display = 'block';
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else{
	   document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("yearDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'block';
		document.getElementById("toDiv").style.display = 'block';	
	 }
}



function ValidateSearch(frm){	
	

	  if(document.getElementById("key").value == "")
	  {
		alert("Please Enter Order Number.");
		document.getElementById("key").focus();
		return false;
	  }else{

	ShowHideLoader(1,'F');
	return true;	

	  }

	
}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td valign="bottom">
		Order Number :<span class="red">*</span><br> <input type="text" name="key"  id="key" class="textbox" size="10"  />
			  
		</td>

		<td>&nbsp;</td>
		<td valign="bottom">

		Invoice Number :<br> <input type="text" name="InvoiceID" id="InvoiceID" class="textbox" size="10"  />
			  
		</td>
		
	   <td>&nbsp;</td>
		<td valign="bottom">
		Order Status :<br> <select name="st" class="textbox" id="st" style="width:100px;">
		<option value="">--- All ---</option>
		<option value="Open" <?  if($_GET['st'] == "Open"){echo "selected";}?>>Open</option>
		<option value="Completed" <?  if($_GET['st'] == "Completed"){echo "selected";}?>>Completed</option>
		<option value="Cancelled" <?  if($_GET['st'] == "Cancelled"){echo "selected";}?>>Cancelled</option>
		</select> 
		</td>
	   <td>&nbsp;</td>

		
	 

	

	  <td align="right" valign="bottom">   <input name="search" type="submit" class="search_button" value="Go"  />	  
	  <script>
	  ShowDateField();
	  </script>
	  
	  </td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>	
	<tr>
        <td align="right" valign="top">
		
	 <? if($num>0 && !empty($_REQUEST['c'])){?>
	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
          <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_so_report.php?<?=$QueryString?>&module=Order';" />

	    <? } ?>


		</td>
      </tr>
	 
<?php if(!empty($_REQUEST['key'])){?>	  
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		
<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arryReturn)?>');" /></td>-->
       <td width="10%" class="head1" >Return Date</td>
      <td width="13%"  class="head1" >Return Number</td>
      <td width="10%"  class="head1" >PO Number</td>
	  <td width="10%" class="head1" >Order Date</td>
	  <td class="head1" >Vendor</td>
      <td width="8%" align="center" class="head1" >Amount</td>
      <td width="8%" align="center" class="head1" >Currency</td>
       <td width="12%"  align="center" class="head1" >Amount Paid</td>
      <td width="13%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryReturn) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryReturn as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	   <td height="20">
	   <? if($values['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?>
	   
	   </td>
       <td><a  class="fancybox fancybox.iframe" href="../purchasing/vReturn.php?view=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&pop=1<?=$_GET['po']?>"><?=$values["ReturnID"]?></td>
       <td><a class="fancybox fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$values['PurchaseID']?>" ><?=$values["PurchaseID"]?></a></td>
	   	<td>
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>	   
	   </td>
      <td> <a class="fancybox fancybox.iframe" href="../purchasing/suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($values["SuppCompany"])?></a> </td> 
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>


    <td align="center"><? 
		 if($values['InvoicePaid'] ==1){
			  $Paid = 'Yes';  $PaidCls = 'green';
		 }else{
			  $Paid = 'No';  $PaidCls = 'red';
		 }

		echo '<span class="'.$PaidCls.'">'.$Paid.'</span>';
		
	 ?></td>
      <td  align="center" class="head1_inner">

<a href="../purchasing/vReturn.php?view=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>"><?=$view?></a>
<a href="../purchasing/editReturn.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>"><?=$edit?></a>
<a href="../purchasing/editReturn.php?del_id=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a> 
<a href="../purchasing/pdfReturn.php?o=<?=$values['OrderID']?>" ><?=$download?></a>

	</td>
    </tr>
    <?php } // foreach end //?>
		
		

		<?php }else{?>
		<tr align="center" >
		<td  colspan="10" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		<tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arrySale)>0){?>
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
<?php } else {?>
<!--<tr><td style=" border-top: 1px solid #DDDDDD;font-weight: bold; padding-left: 123px;text-align: left;" class="no_record">Please Select Customer.</td></tr>-->
<?php }?>
</table>

