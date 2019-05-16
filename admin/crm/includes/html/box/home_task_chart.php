 <div class="third_col" style="<?=$WidthRow3?>">
           
            <div class="block alerts">
              <h3> # of Task and Activities</h3>

		<div class="chartdiv">
			<select name="event" id="event" class="chartselect" onchange="Javascript:showChart(this);" >
				<option value="pEvent:bEvent">Pie Chart</option>
				<option value="bEvent:pEvent">Bar Chart</option>
			</select>				
			<img src="barE.php" id="bEvent" style="display:none">
			<img src="pieE.php" id="pEvent" style="padding:10px;">
		</div>

			
            </div>
          </div>
