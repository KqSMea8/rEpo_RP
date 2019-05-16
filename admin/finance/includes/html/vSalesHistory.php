<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>
<div class="had" style="margin-bottom:5px;"> Customer Sales History</div>

 
	<div align="right"  >
		<? if($num>0){?>
		<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_sales_history.php?<?=$QueryString?>&module=Invoice';" />
		<? } ?>
	</div>
 


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
	  
<tr>
  <td  align="right"   class="blackbold" width="13%"> Customer  Code  :</td>
  <td   align="left" ><?=$arryCustomer[0]['CustCode']?>  </td>
</tr>
<tr>
        <td  align="right"   class="blackbold" > Customer Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryCustomer[0]['CustomerName']); ?>           </td>
  </tr>
  </table>	

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">

  <tr>
    <td align="left" colspan="2">
			
<? include_once("includes/html/box/customer_sales_history.php"); ?>

 
		  </td>
	 </tr>
  </table>

 

<? } ?>
