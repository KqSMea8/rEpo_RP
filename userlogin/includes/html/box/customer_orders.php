<? 
if($arryCustomer[0]['CustCode']!=''){
	$_GET['module']='Order'; $module = $_GET['module'];
	$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID"; 
	$ViewDetailUrl = "../sales/vSalesQuoteOrder.php?module=".$_GET['module']."&pop=1";

	$_GET['CustCode'] = $arryCustomer[0]['CustCode'];		
	$arrySale=$objSale->ListSale($_GET);
?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="5" width="100%" align="center">
<? if(sizeof($arrySale)>0){ ?>
<tr align="left"  >
	<td width="15%" class="head1" ><?=$module?> Date</td>
	<td width="15%"class="head1" ><?=$module?> Number</td>
	<td class="head1">Sales Person</td>
	<td width="15%" class="head1" align="center">Amount</td>
	<td width="10%" class="head1" align="center">Currency</td>
	<td width="20%" align="center" class="head1" >Status</td>
</tr>
<?
  	$flag=true;
	$Line=0;
  	foreach($arrySale as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;	
  ?>
<tr align="left"  class="<?=$class?>">
 
<td height="20">
		<? 
		  $ddate = $module.'Date';
		if($values[$ddate]>0) 
		echo date($Config['DateFormat'], strtotime($values[$ddate]));
		?>

		</td>
		<td>
<a class="fancybox fancybig fancybox.iframe" href="../admin/sales/<?=$ViewDetailUrl.'&view='.$values['OrderID']?>" ><?=$values[$ModuleID]?></a>

</td>
	<td><a class="fancybox fancybox.iframe" href="../admin/userInfo.php?view=<?=$values['SalesPersonID']?>"><?=stripslashes($values["SalesPerson"])?></a> </td>
		<td align="center"><?=$values['TotalAmount']?></td>
		<td align="center"><?=$values['CustomerCurrency']?></td>
		
		<td align="center">
	 <? 
		 if($values['Status'] =='Completed'){
			 $Status = ST_CLR_CREDIT;
			 $StatusCls = 'green';
		 }else{
			$StatusCls = 'red';

			 if($values['Status'] =='Open'){
				if($values['tax_auths'] =='Yes'){
					$Status = ST_TAX_APP_HOLD;			
				}else{
					$Status = ST_CREDIT_HOLD;
				}
			}else{
				$Status = $values['Status'];		
			}	
		 }

		echo '<span class="'.$StatusCls.'">'.$Status.'</span>';
		
	 ?>
	 
	</td>


 
</tr>

 <?
} // foreach end //

?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
	 
		 </td>
	</tr>	
	

</table>
<? } ?>
