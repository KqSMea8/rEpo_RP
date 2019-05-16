<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>jQuery Countdown</title>
<link rel="stylesheet" href="jquery.countdown.css">
<style type="text/css">
#defaultCountdown { width: 240px; height: 45px; }
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="jquery.plugin.js"></script>
<script src="jquery.countdown.js"></script>
<script>
$(function () {
	var austDay = new Date();
	austDay = new Date(austDay.getFullYear(), 4 , 1);
	//austDay.setTime( austDay.getTime() + austDay.getTimezoneOffset()*60*1000 );

	$('#defaultCountdown').countdown({until: austDay});
	$('#year').text(austDay.getFullYear());
});
</script>
</head>
<body>

<div align="center">
	<h2>Offer ends May 1, 2015</h2>
	<div id="defaultCountdown"></div>
</div>

</body>
</html>
