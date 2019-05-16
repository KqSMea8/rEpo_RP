 <div class="block" style="<?=$WidthRow2?>">
		<? if($_SESSION['AdminType'] == "admin"){ ?>
                <h3><?=$BlockHeading?></h3>
		
		<div class="chartdiv" style="width:380px;">
			<select name="chart" id="chart" class="chartselect" onchange="Javascript:showChart(this);" >
				<option value="pChart:bChart">Pie Chart</option>
				<option value="bChart:pChart">Bar Chart</option>
			</select>				
			<img src="barD.php" id="bChart" style="display:none">
			<img src="pieD.php" id="pChart" style="padding:10px;">
		</div>


		<?  }else{
		//$StyleCom = 'style="width:400px;margin-right:10px;"';
		//require_once("../includes/html/box/commission_dashboard.php"); ?>
		<h3><?=$BlockHeading?></h3>
		<div class="chartdiv" style="width:380px;">
			<select name="comm" id="comm" class="chartselect" onchange="Javascript:showChart(this);" >
				<option value="pComm:bComm">Pie Chart</option>
				<option value="bComm:pComm">Bar Chart</option>
			</select>				
			<img src="../barComm.php" id="bComm" style="display:none;">
			<img src="../pieComm.php" id="pComm" style="padding:10px;">
		</div>

		<?  } ?>
            </div>
         
	


          
         
