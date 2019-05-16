<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>jQuery UI Datepicker - Display month &amp; year menus</title>

<!--
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
-->

<link rel="stylesheet" href="jquery-ui.css" />
<script src="jquery-1.9.1.js"></script>
<script src="jquery-ui.js"></script>


</head>
<body>
<p>Date Year Month: <input type="text" id="datepicker" />
<script>
$(function() {
$( "#datepicker" ).datepicker({
changeMonth: true,
changeYear: true,
dateFormat: 'yy-mm-dd'
});
});
</script>
</p>

<p>Normal Date: <input type="text" id="datepicker2" />
 <script>
$(function() {
$( "#datepicker2" ).datepicker();
});
</script>
</p>

<p>Other Months Date: <input type="text" id="datepicker3" />
 <script>
$(function() {
$( "#datepicker3" ).datepicker({
showOtherMonths: true,
selectOtherMonths: true
});
});
</script>
</p>

<p>Button Bar: <input type="text" id="datepicker4" />
 <script>
$(function() {
$( "#datepicker4" ).datepicker({
showButtonPanel: true
});
});
</script>
</p>

<p>Multiple Months: <input type="text" id="datepicker6" />
 <script>
$(function() {
$( "#datepicker6" ).datepicker({
numberOfMonths: 3,
showButtonPanel: true
});
});
</script>
</p>



<p>Date Format: <input type="text" id="datepicker7" />
 <script>
$(function() {
	$( "#datepicker7" ).datepicker();
	$( "#format" ).change(function() {
	$( "#datepicker7" ).datepicker( "option", "dateFormat", $( this ).val() );
	});
});
</script>

 <select id="format">
<option value="mm/dd/yy">Default - mm/dd/yy</option>
<option value="yy-mm-dd">ISO 8601 - yy-mm-dd</option>
<option value="d M, y">Short - d M, y</option>
<option value="d MM, y">Medium - d MM, y</option>
<option value="DD, d MM, yy">Full - DD, d MM, yy</option>
<option value="'day' d 'of' MM 'in the year' yy">With text - 'day' d 'of' MM 'in the year' yy</option>
</select>


</p>


<p>Icon: <input type="text" id="datepicker8" />
 <script>
$(function() {
$( "#datepicker8" ).datepicker({
showOn: "button",
buttonImage: "images/calendar.gif",
buttonImageOnly: true
});
});
</script>
</p>



<p>Date: <input type="text" id="datepicker9" />&nbsp;<input type="text" id="alternate" size="30" />
 <script>
	$(function() {
	$( "#datepicker9" ).datepicker({
	altField: "#alternate",
	altFormat: "DD, d MM, yy"
	});
	});
</script>
</p>


<p>Date Range: <input type="text" id="datepicker10" />
 <script>
$(function() {
$( "#datepicker10" ).datepicker({ 
	minDate: -10, 
	maxDate: "+1M +10D",
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd'

	});
});
</script>
</p>




<p>Display Inline: <div id="datepicker5"></div>
 <script>
$(function() {
$( "#datepicker5" ).datepicker();
});
</script>
</p>



<p>Main Datee: <input type="text" id="datepicker11" />
 <script>
$(function() {
$( "#datepicker11" ).datepicker({ 
	minDate: "-10Y",
	maxDate: "+10Y",
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd'

	});
});
</script>
</p>

</body>
</html>