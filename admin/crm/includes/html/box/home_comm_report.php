<?php session_start();
if($_SESSION['AdminType'] == "employee") {
	$salesPerson =1;
}

?>  <div class="third_col" style="<?=$WidthRow3?>">
           
              <div class="block alerts">


<h3>Sales Commission Report</h3>
			<div class="chartdiv" style="width:380px;">
			<select name="comm" id="comm" class="chartselect" onchange="Javascript:showChart(this);" >
				<option value="pComm:bComm">Pie Chart</option>
				<option value="bComm:pComm">Bar Chart</option>
			</select>				
			<img src="../barComm.php?salesPerson=<?php echo $salesPerson;?>" id="bComm" style="display:none;">
			<img src="../pieComm.php?salesPerson=<?php echo $salesPerson;?>" id="pComm" style="padding:10px;">
			</div>






 </div>
          </div>
