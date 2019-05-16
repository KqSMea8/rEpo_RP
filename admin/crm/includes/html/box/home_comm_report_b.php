
           
              <div class="block alerts" style="<?=$WidthRow3?>">
		<select name="comm" id="comm" class="blockselect" onchange="Javascript:showChart(this);" >
				<option value="pComm:bComm">Pie Chart</option>
				<option value="bComm:pComm">Bar Chart</option>
			</select>

<h3><?=$BlockHeading?></h3>
			<div class="chartdiv">
					
			<img src="../barComm.php" id="bComm" style="display:none;">
			<img src="../pieComm.php" id="pComm" style="padding:10px;">
			</div>






 </div>

