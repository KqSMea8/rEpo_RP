  <div class="third_col" style="<?=$WidthRow3?>">
           
              <div class="block alerts">

 <h3> # of Ticket by Priority</h3>

			<div class="chartdiv">
				<select name="ticket" id="ticket" class="chartselect" onchange="Javascript:showChart(this);" >
					<option value="pTicket:bTicket">Pie Chart</option>
					<option value="bTicket:pTicket">Bar Chart</option>
				</select>				
				<img src="barTicketPriority.php" id="bTicket" style="display:none">
				<img src="pieTicketPriority.php" id="pTicket" style="padding:10px;">
			</div>







 </div>
          </div>
