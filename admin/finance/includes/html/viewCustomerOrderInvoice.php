<script language="JavaScript1.2" type="text/javascript">
function ValidateFind(frm){	
	if(!ValidateForSelect(frm.CustCode,"Customer")){
		return false;
	}
	ShowHideLoader('1','F');

}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	 <tr>
	  <td  valign="top">
	  <form action="" method="get" name="form1" onSubmit="return ValidateFind(this);">	
	  <table id="search_table" cellpadding="0" cellsapcing="0" align="left">
	  <tr><td><b>Select Customer&nbsp;&nbsp;</b></td>
	  <td> 

			<select id="CustCode" method="get" class="inputbox" name="CustCode">
			   <option value="">--- Please select ---</option>
			     <?php foreach($arryCustomer as $customer){?>
				 <option value="<?=$customer['CustCode'];?>" <?php if($_GET['CustCode'] == $customer['CustCode']){echo "selected";}?>><?php echo $customer['FullName']; ?></option>
				<?php }?>
			</select>
			<input type="hidden" value="<?=$module?>" name="module" id="module">
	</td><td>
	        <input type="submit" value="GO" id="GoSubmitButton" class="button" name="search">
		  </td>
	  </tr>
	  </table>
	  </form>
	  </td>
      </tr>
	  <tr>
        <td align="right" valign="top">
		
	 <? if($num>0 && !empty($_GET['CustCode'])){?>
            <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_so.php?<?=$QueryString?>';" />

	    <? } ?>


		</td>
      </tr>
<?php if(!empty($_GET['CustCode'])){?>	  
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>

		<tr align="left"  >
		<!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arrySale)?>');" /></td>-->
		<td width="13%" class="head1" ><?=$module?> Date</td>
		<td width="12%"  align="center" class="head1" ><?=$module?> Number</td>
		<td class="head1">Customer Name</td>
		<td width="8%" align="center" class="head1" >Amount</td>
		<td width="8%" align="center" class="head1" >Currency</td>
		<td width="8%"  align="center" class="head1" >Status</td>

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
		<!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
		<td height="20">
		<? 
		  $ddate = $module.'Date';
		if($values[$ddate]>0) 
		echo date($Config['DateFormat'], strtotime($values[$ddate]));
		?>

		</td>
		<td align="center"><?=$values[$ModuleID]?></td>
		<td><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>" ><?=stripslashes($values["CustomerName"])?></a></td> 
		<td align="center"><?=$values['TotalAmount']?></td>
		<td align="center"><?=$values['CustomerCurrency']?></td>
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



		<td  align="center" class="head1_inner">

		<a class="fancybox fancybox.iframe" href="<?=$ViewUrl.'&view='.$values['OrderID']?>" ><?=$view?></a>
		<!--a href="<?=$EditUrl.'&edit='.$values['OrderID']?>" target="_blank"><?=$edit?></a>
		<a href="<?=$EditUrl.'&del_id='.$values['OrderID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a--> 
		<?
		if($module=="Order"){ 

		//$TotalGenerateInvoice=$objSale->GetQtyInvoiced($values['OrderID']);


		/*$TotalInvoice=$objSale->CountInvoices($values['SaleID']);
		if($TotalInvoice>0)
		echo '<br><a href="viewInvoice.php?so='.$values['SaleID'].'" target="_blank">Invoices</a>';*/


		/*if($values['Status'] =='Open' && $values['Approved'] ==1 && $TotalGenerateInvoice[0]['QtyInvoiced'] != $TotalGenerateInvoice[0]['Qty'])
		echo '<br><a href="generateInvoice.php?so='.$values['SaleID'].'&invoice='.$values['OrderID'].'&module=Order" target="_blank">'.GENERATE_INVOICE.'</a>';*/


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

		<tr>  <td  colspan="9"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arrySale)>0){?>
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

<?php }?>
</table>

