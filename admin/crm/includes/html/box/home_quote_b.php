
           
            <div class="block" style="<?=$WidthRow3?>">
		<select name="quote" id="quote" class="blockselect" onchange="Javascript:showChart(this);" >
					<option value="pQuote:bQuote">Pie Chart</option>
					<option value="bQuote:pQuote">Bar Chart</option>
				</select>
              <h3><?=$BlockHeading?></h3>
			<div class="chartdiv">
								
				<img src="barQuote.php" id="bQuote" style="display:none">
				<img src="pieQuote.php" id="pQuote" style="padding:10px;">
			</div>

            </div>

