<?
//date_default_timezone_set('Asia/Calcutta');
//echo $CurrentTime = date("H:i:s");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>jQuery Clock Plugin</title>

<meta name="title" content="jQuery Clock Plugin" />

<link rel="stylesheet" type="text/css" href="css/analog.css"> 
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.clock.js" type="text/javascript"></script>


</head>
<body>

	
display:block;
width:100px;
height:100px;
			behavior:url(-ms-transform.htc);
			-moz-transform:rotate(45deg);
			-webkit-transform:rotate(45deg);
			-o-transform:rotate(45deg);
			-ms-transform:rotate(45deg);

<script type="text/javascript">
 $(document).ready(function() {
   $('#analog-clock').clock({offset: '+5.5', type: 'analog'});
 });
</script>
						
<ul id="analog-clock" class="analog">	
	<li class="hour"></li>
	<li class="min"></li>
	<li class="sec"></li>
	<li class="meridiem"></li>
</ul>


				
	
	</div>
	</body>
	</html>
