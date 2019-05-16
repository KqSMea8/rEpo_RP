<?
if(empty($ModuleID)){
	$ModuleIDTitle = "PO Number"; $ModuleID = "SaleID"; $module ='Order';
}
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head"><?=$module?> Information</td>
</tr>
 
 <tr>
        <td  align="right"   class="blackbold" width="20%"> <?=$ModuleIDTitle?> # : </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0][$ModuleID])?></B></td>
  </tr>
  <tr>
        <td  align="right"   class="blackbold" >Invoice Date  : </td>
        <td   align="left" >
         <?=($arrySale[0]['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['InvoiceDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
	  
	  <tr>
        <td  align="right"   class="blackbold" >Ship Date  : </td>
        <td   align="left" >
         <?=($arrySale[0]['ShippedDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['ShippedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
	   <tr>
        <td  align="right"   class="blackbold" width="20%"> Ship From(Warehouse) : </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0]['wName'])?></B></td>
       </tr>
	  <tr>
			<td  align="right"   class="blackbold" width="20%"> Customer : </td>
			<td   align="left" >

<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>
</td>
	  </tr>
	   <tr>
			<td  align="right"   class="blackbold" width="20%"> SO Number # : </td>
			<td   align="left" ><B><?=stripslashes($arrySale[0]['SaleID'])?></B></td>
	  </tr>
	  <tr>
			<td  align="right"   class="blackbold" width="20%"> Sales Person : </td>
			<td   align="left" ><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arrySale[0]['SalesPersonID']?>" ><?=stripslashes($arrySale[0]['SalesPerson'])?></a></td>
	  </tr>
	    <tr>
       <td  align="right" class="blackbold" >Created By  : </td>
       <td   align="left">
               <?
                       if($arrySale[0]['AdminType'] == 'admin'){
                               $CreatedBy = 'Administrator';
                       }else{
                               $CreatedBy = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arrySale[0]['AdminID'].'" >'.stripslashes($arrySale[0]['CreatedBy']).'</a>';
                       }
                       echo $CreatedBy;
               ?>
         </td>
     </tr>
	  <tr>
			<td  align="right"   class="blackbold" width="20%"> Invoice Status : </td>
			<td   align="left" ><?=stripslashes($arrySale[0]['InvoicePaid'])?></td>
	  </tr>
 
</table>
