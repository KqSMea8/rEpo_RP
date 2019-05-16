
<div class="block alerts" style="<?=(isset($WidthRow3)) ? $WidthRow3 : '';?>">


	<select name="ticket" id="ticket" class="blockselect" onchange="Javascript:showChart(this);" >
		<option value="pTicket:bTicket">Pie Chart</option>
		<option value="bTicket:pTicket">Bar Chart</option>
	</select>

<h3><?=$BlockHeading?></h3>
<div class="chartdiv">
				
	<img src="barTicketPriority.php" id="bTicket" style="display:none">
	<img src="pieTicketPriority.php" id="pTicket" style="padding:10px;">
</div>

</div>

