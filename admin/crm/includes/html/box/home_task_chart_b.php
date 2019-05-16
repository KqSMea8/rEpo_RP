<div class="block alerts" style="<?=(isset($WidthRow3)) ? $WidthRow3 : '';?>">
<select name="event" id="event" class="blockselect" onchange="Javascript:showChart(this);" >
		<option value="pEvent:bEvent">Pie Chart</option>
		<option value="bEvent:pEvent">Bar Chart</option>
	</select>
<h3><?=$BlockHeading?></h3>

<div class="chartdiv">
					
	<img src="barE.php" id="bEvent" style="display:none">
	<img src="pieE.php" id="pEvent" style="padding:10px;">
</div>

	
</div>

