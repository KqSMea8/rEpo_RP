<?php
session_start();
require_once("../includes/function.php"); 
ValidateAdminSession('adminSalesCommChart.php');
$empId=$_GET['empId'];
$y=$_GET['y'];
$salesPerson = $_GET['salesPerson'];
if($_SESSION['AdminType'] == "employee") {
	$salesPerson =1;
}
if($salesPerson==0) {
	$urlToSend ="empId=$empId&y=$y&salesPerson=$salesPerson";
}
elseif($salesPerson==1) {
	$urlToSend ="SuppID=$empId&y=$y&salesPerson=$salesPerson";
}
?> 
<div id="adminChart">
<select name="commSale" id="commSale" class="chartselect"
	onchange="Javascript:showChart(this);" style="float:right; margin-top:10px;">
	<option value="pComm2:bComm2">Pie Chart</option>
	<option value="bComm2:pComm2">Bar Chart</option>
</select> 
<img src="../barComm.php?<?php echo $urlToSend;?>" id="bComm2"
	style="display: none;padding:20px 114px;"> <img src="../pieComm.php?<?php echo $urlToSend;?>" id="pComm2"
	style="padding:20px 114px;"></div>
</div>
