<table width="80%" id="myTable" class="order-list-gl"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td  class="heading"> GL Account</td>
		<td width="25%" class="heading">Amount</td>
		<td width="25%" class="heading">Notes</td>
    </tr>
</thead>
<tbody>
	<?php
	for($Line=0;$Line<=sizeof($arryMultiAccount)-1;$Line++) { 
		
		
	?>
     <tr class='itembg'>
		<td>
			<?=$arryMultiAccount[$Line]['AccountName'].' ['.$arryMultiAccount[$Line]['AccountNumber'].']'?>
		</td>
                <td><?=number_format($arryMultiAccount[$Line]['Amount'],2)?></td>
      
      		  <td><?=stripslashes($arryMultiAccount[$Line]['Notes'])?></td>
       
    </tr>
	<?php } ?>

 
</tbody>

</table>

<? echo '<script>SetInnerWidth();</script>'; ?>
