<script language="JavaScript1.2" type="text/javascript">

function ValidateSearch(frm){	

	  if(document.getElementById("CustCode").value == "")
	  {
		alert('Please select customer.');
		document.getElementById("CustCode").focus();
		return false;
	  }

	return true;	
}

function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SelectSO(OrderID,InvoiceID){
	ResetSearch();
	window.parent.location.href = document.getElementById("link").value+"?Inv="+OrderID;
	//window.parent.location.href = document.getElementById("link").value+"?InvoiceID="+InvoiceID+"";
}

function GetInvoices(str){
	ResetSearch();
	location.href = "ShowRmaList.php?CustCode="+str;   	
}


 

</script>

<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<div class="had">Search Invoice by Customer</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>

	<tr>
		<td valign="top" >
		<table border="0" cellpadding="3" cellspacing="0" id="search_table" style="margin: 0">

			<tr>
				<td valign="bottom"> 
				<select id="CustCode" class="inputbox" name="CustCode" onChange="Javascript: GetInvoices(this.value);">
					<option value="">--- Select Customer ---</option>
					<?php foreach($arryCustomer as $customer){?>
					<option value="<?=$customer['CustCode'];?>"
					<?php if($_GET['CustCode'] == $customer['CustCode']){echo "selected";}?>><?=$customer['CustomerName'];?></option>
					<?php }?>
				</select></td>
<script>
$("#CustCode").select2();
</script> 

				
			</tr>
		</table>
		
		</td>

	</tr>

	<tr>
		<td align="right" valign="bottom" height="40">
	<? if(!empty($_GET['CustCode'])){?>
		<form name="frmSrch" id="frmSrch" action="ShowRmaList.php" method="get"
			onSubmit="return ResetSearch();">

		<table   border="0" cellpadding="3" cellspacing="0" id="search_table" style="margin: 0">			
			<tr>
			<td >
			<select name="sortby" id="sortby" class="textbox">
			<option value=""> All </option>
			<option value="o.InvoiceID" <? if($_GET['sortby']=='o.InvoiceID') echo 'selected';?>>Invoice Number</option>
			<option value="vo.sku" <? if($_GET['sortby']=='vo.sku') echo 'selected';?>>Sku Number</option>
			<option value="o.SalesPerson" <? if($_GET['sortby']=='o.SalesPerson') echo 'selected';?>>Sales Person</option>
			</select>
			</td>
			 
			
			<td >
			<input type="text" name="key"
			id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20"
			maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit"
			name="sbt" value="Go" class="search_button"> <input type="hidden"
			name="CustCode" id="CustCode" value="<?=$_GET['CustCode']?>">
			</td>
			
			</tr>

		</table>


	    </form>
	<? } ?></td>
	</tr>

</table>

			

<div class="message" align="center"><? if(!empty($_SESSION['mess_salr'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>
<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>


	<tr>
		<td valign="top" height="400">

		
		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none; padding: 50px;"><img
			src="../images/ajaxloader.gif"></div>
		<div id="preview_div">
		<?php if(!empty($_GET['CustCode'])){?>
		<table <?=$table_bg?>>
			<tr align="left">
				<td width="12%" class="head1">Invoice Number</td>
				<td width="12%" class="head1">Invoice Date</td>
				<td class="head1">Customer Name</td>
				<td class="head1">Sales Person</td>
				<td width="10%" align="center" class="head1">Amount</td>
				<td width="10%" align="center" class="head1">Currency</td>
				<td width="10%" align="center" class="head1">Status</td>
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
			<tr align="left" bgcolor="<?=$bgcolor?>">
				<td><a href="Javascript:void(0);"
					onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"
					; onMouseout="hideddrivetip()"
					onclick="Javascript:SelectSO('<?=$values['OrderID']?>','<?=$values['InvoiceID']?>')"><?=$values['InvoiceID']?></a></td>
				<td><? /*if($values['InvoiceDate']>0) 
					echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));*/
					echo $values['InvoiceDate'];
					?></td>
					
						
				<td><?=stripslashes($values["CustomerName"])?></td>
				<td><?=stripslashes($values['SalesPerson'])?></td>
				<td align="center"><?=$values['TotalInvoiceAmount']?></td>
				<td align="center"><?=$values['CustomerCurrency']?></td>
				<td align="center">
				<?  
					 if($values['InvoicePaid'] =='Paid'){
					 $StatusCls = 'green';
					 }else{
					 $StatusCls = 'red';
					 }
					
					echo '<span class="'.$StatusCls.'">'.$values['InvoicePaid'].'</span>';
         ?></td>




			</tr>
			<?php } // foreach end //?>

			<?php }else{?>
			<tr align="center">
				<td colspan="8" class="no_record"><?=NO_INVOICE?></td>
			</tr>
			<?php } ?>

			<tr>
				<td colspan="8" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>
				<?php if(count($arrySale)>0){?> &nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink;
				}?></td>
			</tr>
		</table>
		<?php }?>
		</div>

		<input type="hidden" name="link" id="link" value="editRma.php">
			
		</form>
		
		</td>
	</tr>
</table>
	




