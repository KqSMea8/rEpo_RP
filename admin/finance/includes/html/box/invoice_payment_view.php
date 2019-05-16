<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	<tr>
	 <td colspan="2" align="left" class="head">Payment Information</td>
	</tr>	
	 <tr>
        <td  align="right"  class="blackbold" width="20%">Invoice Paid :</td>
        <td  align="left">
			<?php
				if($arrySale[0]['InvoicePaid'] == "No"){ echo "No";}else{echo "Yes";}
			
			?>
		</td>
    </tr>
	
	<tr>
	 <td  align="right"   class="blackbold"> Invoice Paid Date  : </td>
		<td   align="left" >

		 
		<?=($arrySale[0]['InvoicePaidDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['InvoicePaidDate']))):(NOT_SPECIFIED)?>

		</td>
	</tr>
	<tr>
        <td  align="right" class="blackbold">Invoice Paid Method :</td>
        <td   align="left">
		  <?=($arrySale[0]['InvoicePaidMethod'])?($arrySale[0]['InvoicePaidMethod']):NOT_SPECIFIED;?>
		</td>
  </tr>
	 <tr>
        <td  align="right"   class="blackbold" width="20%">Paid Reference No#  : </td>
        <td   align="left">
		
		  <?=($arrySale[0]['InvoicePaidReferenceNo'])?($arrySale[0]['InvoicePaidReferenceNo']):NOT_SPECIFIED;?>
		</td>
    </tr>
	 <tr>
		<td valign="top" align="right" class="blackbold">Invoice Paid Comment :</td>
		<td align="left"><?=($arrySale[0]['InvoicePaidComment'])?($arrySale[0]['InvoicePaidComment']):NOT_SPECIFIED;?></td>
	</tr>
	
	<tr>
	<td  colspan="2" valign="top" style="padding-left:208px;">
		
	</td>
	</tr>
	</table>

