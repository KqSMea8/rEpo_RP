<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="top">
		
	 <? if($num>0 && !empty($_REQUEST['key'])){?>
            <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_return.php?<?=$QueryString?>';" />

	    <? } ?>


		</td>
      </tr>
	 <tr>
	  <td  valign="top">
	  <table border="" cellpadding="0" cellsapcing="0" align="left">
	  <tr><td><b>Select Customer&nbsp;&nbsp;</b></td>
	  <td> <form action="" method="get" name="form1">
			<select id="key" method="get" class="inputbox" name="key">
			   <option value="">--- Please select ---</option>
			     <?php foreach($arryCustomer as $customer){?>
				 <option value="<?=$customer['CustCode'];?>" <?php if($_REQUEST['key'] == $customer['CustCode']){echo "selected";}?>><?php echo $customer['FirstName']." ".$customer['LastName']; ?></option>
				<?php }?>
			</select>
			<input type="hidden" value="<?=$module?>" name="module" id="module">
	        <input type="submit" value="GO" id="GoSubmitButton" class="button" name="search">
		  </form></td>
	  </tr>
	  </table>
	  </td>
      </tr>
<?php if(!empty($_REQUEST['key'])){?>	  
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>

		<tr align="left">
		<td width="13%" class="head1" ><?=$module?> Date</td>
		<td width="12%"  align="center" class="head1" ><?=$module?> Number</td>
		<td width="12%"  class="head1" >Invoice Number</td>
		<td width="9%"  class="head1" align="center" >SO Number</td>
		<td class="head1">Customer Name</td>
		<td class="head1">Sales Person</td>
		<td width="8%" align="center" class="head1" >Amount</td>
		<td width="8%" align="center" class="head1" >Currency</td>
		<td width="5%"  align="center" class="head1">Paid</td>
		<td width="10%"  align="center" class="head1 head1_action" >Action</td>
		</tr>

		<?php 
		if(is_array($arrySale) && $num>0){
		$flag=true;
		$Line=0;
		foreach($arrySale as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;

		?>
		<tr align="left"  bgcolor="<?=$bgcolor?>">
		<td height="20">
		<? 
		  $ddate = $module.'Date';
		if($values[$ddate]>0) 
		echo date($Config['DateFormat'], strtotime($values[$ddate]));
		?>

		</td>
		<td align="center"><?=$values[$ModuleID]?></td>
		<td align="center"><?=$values["InvoiceID"]?></td>
		<td align="center"><a class="fancybox fancybox.iframe" href="vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$values['SaleID']?>" ><?=$values["SaleID"]?></a></td>
		<td><a class="fancybox fancybox.iframe" href="custInfo.php?view=<?=$values['CustCode']?>" ><?=stripslashes($values["CustomerName"])?></a></td> 
		 <td><?=stripslashes($values['SalesPerson'])?></td>
		<td align="center"><?=$values['TotalAmount']?></td>
		<td align="center"><?=$values['CustomerCurrency']?></td>
		<td align="center">
			<?php 		
			 if($values['ReturnPaid'] == "Yes"){
				  $Paid = 'Yes';  $PaidCls = 'green';
			 }else{
				  $Paid = 'No';  $PaidCls = 'red';
			 }

			echo '<span class="'.$PaidCls.'">'.$Paid.'</span>';
			
		 ?>
		</td>


		<td  align="center" class="head1_inner">

		<a href="<?=$ViewUrl.'&view='.$values['OrderID'].'&rtn='.$values['ReturnID']?>" target="_blank"><?=$view?></a>
		<a href="<?=$EditUrl.'&edit='.$values['OrderID'].'&rtn='.$values['ReturnID']?>" target="_blank"><?=$edit?></a>
		<a href="<?=$EditUrl.'&del_id='.$values['OrderID'].'&rtn='.$values['ReturnID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a> 

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
<tr><td style=" border-top: 1px solid #DDDDDD;font-weight: bold; padding-left: 123px;text-align: left;" class="no_record">Please Select Customer.</td></tr>
<?php }?>
</table>

