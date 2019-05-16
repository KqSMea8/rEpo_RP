 <div class="had"><?=$MainModuleName?> [ <?=$salesPersonName?> ]</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_sale'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
  
      <? if($num>0){?>
	<tr>
        <td align="right" valign="bottom">
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_comm_report_data.php?<?=$QueryString?>';" />
		</td>
      </tr>
	 <? } ?>


	<tr>
		<td  valign="top">
		<? if(!empty($_GET['s'])){
			include_once("includes/html/box/comm_report_data.php");  
		}
		?>
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
