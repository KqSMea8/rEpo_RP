<div class="third_col" style="<?=$WidthRow3?>">
           
            <div class="block alerts">
		
              <h3> # of Quotes</h3>
			<div class="chartdiv">
				<select name="quote" id="quote" class="chartselect" onchange="Javascript:showChart(this);" >
					<option value="pQuote:bQuote">Pie Chart</option>
					<option value="bQuote:pQuote">Bar Chart</option>
				</select>				
				<img src="barQuote.php" id="bQuote" style="display:none">
				<img src="pieQuote.php" id="pQuote" style="padding:10px;">
			</div>

            </div>
          </div>
