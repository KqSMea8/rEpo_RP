 <div class="had">Transaction Summary for Invoice : <strong><?=$arrySale[0]['InvoiceID']?></strong></div>
 
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
  
	</td>
      </tr>	
	<tr>
        <td align="right" valign="top">
		
	 <? if($num>0){?>
	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
              <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_recurring_history.php?<?=$QueryString?>';" >

	    <? } ?>


		</td>
      </tr>
	 	
	<tr>
	  <td  valign="top"> 
   	 <? include_once("includes/html/box/recurring_history_data.php"); ?>
	  
	</td>
	</tr>


  
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 900
		 });

});

</script>
