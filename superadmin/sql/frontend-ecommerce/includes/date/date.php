<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
  <title>My Date Time Picker</title>
  <link rev="made" href="mailto:contact@rainforestnet.com">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="generator" content="NoteTab Light 4.9">
  <meta name="author" content="TengYong Ng">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link rel="stylesheet" href="rfnet.css">
  <style type="text/css">
  <!--
   -->
  </style>
  <script type="text/javascript" language="javascript" src="datetimepicker.js"></script>
  <script language="JavaScript">
	<!--
		if (document.images)
		{
		calimg= new Image(16,16); 
		calimg.src="images/cal.gif"; 
		}
	//-->
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#800080" alink="#FF0000">
<table width="700" cellspacing=0 border="0" cellpadding="0" align="center" summary="">
	<tr>
		<td vAlign="top" align="center">
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
      		<td><img src="images/rfnet1.jpg" width="90" height="72" border="0" alt="rainforest of Pahang, Malayisa"></td>
	      	<td><img src="images/rfnet2.jpg" width="90" height="72" border="0" alt="rainforest of Pahang, Malayisa"></td>
		      <td><img src="images/rfnet3.jpg" width="90" height="72" border="0" alt="rainforest of Pahang, Malayisa"></td>
      		<td><img src="images/rfnet4.jpg" width="90" height="72" border="0" alt="rainforest of Pahang, Malayisa"></td>
	      	<td><img src="images/rfnet5.jpg" width="90" height="72" border="0" alt="rainforest of Pahang, Malayisa"></td>
		      <td><img src="images/rfnet6.jpg" width="90" height="72" border="0" alt="rainforest of Pahang, Malayisa"></td>
      		<td><img src="images/rfnet7.jpg" width="90" height="72" border="0" alt="rainforest of Pahang, Malayisa"></td>
		</tr>
    		</table>
	  	</td>
	  </tr>
	  <tr>
	  	<td>
	  		<div class="title">demo Date Time Picker 1.9</div>	
	  	</td>
	  </tr>
	  <tr>
 	  	<td>
 	  		<div class="subtitle">DropDown Month and Year Selector</div>
 	  	</td>
	  </tr>
	  <tr>
 	  	<td>
 	  		<div class="lineItem">Date Only</div>
 	  	</td>
	  </tr>
	  <!--Date Only-->
			<tr>
	  			<td>
	  				<input type="Text" id="demo1" maxlength="25" size="25"><a href="javascript:NewCal('demo1','ddmmyyyy')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MM/yyyy)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo2" maxlength="25" size="25"><a href="javascript:NewCal('demo2','ddmmmyyyy')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MMM/yyyy)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo3" maxlength="25" size="25"><a href="javascript:NewCal('demo3','yyyymmdd')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MM/dd)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo4" maxlength="25" size="25"><a href="javascript:NewCal('demo4','yyyymmmdd')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MMM/dd)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo5" maxlength="25" size="25"><a href="javascript:NewCal('demo5','mmddyyyy')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MM/dd/yyyy)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo6" maxlength="25" size="25"><a href="javascript:NewCal('demo6','mmmddyyyy')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MMM/dd/yyyy)</span>
	  			</td>
			</tr>
	  
	  
	  <tr>
 	  	<td>
 	  		<div class="lineItem">Date And Time without seconds</div>
 	  	</td>
	  </tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo11" maxlength="25" size="25" name="demo11"><a href="javascript:NewCal('demo11','ddmmyyyy',true,24,'dropdown',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MM/yyyy time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo12" maxlength="25" size="25" name="demo12"><a href="javascript:NewCal('demo12','ddmmmyyyy',true,24,'dropdown',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MMM/yyyy time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo13" maxlength="25" size="25" name="demo13"><a href="javascript:NewCal('demo13','yyyymmdd',true,24,'dropdown',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MM/dd time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo14" maxlength="25" size="25" name="demo14"><a href="javascript:NewCal('demo14','yyyymmmdd',true,12,'dropdown',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MMM/dd time:12hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo15" maxlength="25" size="25" name="demo15"><a href="javascript:NewCal('demo15','mmddyyyy',true,12,'dropdown',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MM/dd/yyyy time:12hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo16" maxlength="25" size="25" name="demo16"><a href="javascript:NewCal('demo16','mmmddyyyy',true,12,'dropdown',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MMM/dd/yyyy time:12hr)</span>
	  			</td>
			</tr>	  
	  <tr>
 	  	<td>
 	  		<div class="lineItem">Date And Time with seconds</div>
 	  	</td>
	  </tr>	
			<tr>
	  			<td>
	  				<input type="Text" id="demo21" maxlength="25" size="25" name="demo21"><a href="javascript:NewCal('demo21','ddmmyyyy',true,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MM/yyyy time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo22" maxlength="25" size="25" name="demo22"><a href="javascript:NewCal('demo22','ddmmmyyyy',true,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MMM/yyyy time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo23" maxlength="25" size="25" name="demo23"><a href="javascript:NewCal('demo23','yyyymmdd',true,24)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MM/dd time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo24" maxlength="25" size="25" name="demo24"><a href="javascript:NewCal('demo24','yyyymmmdd',true,12)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MMM/dd time:12hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo25" maxlength="25" size="25" name="demo25"><a href="javascript:NewCal('demo25','mmddyyyy',true,12)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MM/dd/yyyy time:12hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo26" maxlength="25" size="25" name="demo26"><a href="javascript:NewCal('demo26','mmmddyyyy',true,12)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MMM/dd/yyyy time:12hr)</span>
	  			</td>
			</tr>	    
	<tr>
 	  	<td>
 	  		<div class="subtitle">Arrow Month-Year Selector</div>
 	  	</td>
	  </tr>
	  <tr>
 	  	<td>
 	  		<div class="lineItem">Date Only</div>
 	  	</td>
	  </tr>
	  <!--Date Only-->
			<tr>
	  			<td>
	  				<input type="Text" id="demo31" maxlength="25" size="25" name="demo31"><a href="javascript:NewCal('demo31','ddmmyyyy',false,12,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MM/yyyy)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo32" maxlength="25" size="25" name="demo32"><a href="javascript:NewCal('demo32','ddmmmyyyy',false,12,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MMM/yyyy)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo33" maxlength="25" size="25" name="demo33"><a href="javascript:NewCal('demo33','yyyymmdd',false,12,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MM/dd)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo34" maxlength="25" size="25" name="demo34"><a href="javascript:NewCal('demo34','yyyymmmdd',false,12,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MMM/dd)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo35" maxlength="25" size="25" name="demo35"><a href="javascript:NewCal('demo35','mmddyyyy',false,12,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MM/dd/yyyy)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo36" maxlength="25" size="25" name="demo36"><a href="javascript:NewCal('demo36','mmmddyyyy',false,12,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MMM/dd/yyyy)</span>
	  			</td>
			</tr>
	  
	  
	  <tr>
 	  	<td>
 	  		<div class="lineItem">Date And Time without seconds</div>
 	  	</td>
	  </tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo41" maxlength="25" size="25" name="demo41"><a href="javascript:NewCal('demo41','ddmmyyyy',true,24,'arrow',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MM/yyyy time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo42" maxlength="25" size="25" name="demo42"><a href="javascript:NewCal('demo42','ddmmmyyyy',true,24,'arrow',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MMM/yyyy time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo43" maxlength="25" size="25" name="demo43"><a href="javascript:NewCal('demo43','yyyymmdd',true,24,'arrow',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MM/dd time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo44" maxlength="25" size="25" name="demo44"><a href="javascript:NewCal('demo44','yyyymmmdd',true,12,'arrow',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MMM/dd time:12hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo45" maxlength="25" size="25" name="demo45"><a href="javascript:NewCal('demo45','mmddyyyy',true,12,'arrow',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MM/dd/yyyy time:12hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo46" maxlength="25" size="25" name="demo46"><a href="javascript:NewCal('demo46','mmmddyyyy',true,12,'arrow',true)"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MMM/dd/yyyy time:12hr)</span>
	  			</td>
			</tr>	  
	  <tr>
 	  	<td>
 	  		<div class="lineItem">Date And Time with seconds</div>
 	  	</td>
	  </tr>	
			<tr>
	  			<td>
	  				<input type="Text" id="demo51" maxlength="25" size="25" name="demo51"><a href="javascript:NewCal('demo51','ddmmyyyy',true,24,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MM/yyyy time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo52" maxlength="25" size="25" name="demo52"><a href="javascript:NewCal('demo52','ddmmmyyyy',true,24,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:dd/MMM/yyyy time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo53" maxlength="25" size="25" name="demo53"><a href="javascript:NewCal('demo53','yyyymmdd',true,24,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MM/dd time:24hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo54" maxlength="25" size="25" name="demo54"><a href="javascript:NewCal('demo54','yyyymmmdd',true,12,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:yyyy/MMM/dd time:12hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo55" maxlength="25" size="25" name="demo55"><a href="javascript:NewCal('demo55','mmddyyyy',true,12,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MM/dd/yyyy time:12hr)</span>
	  			</td>
			</tr>
			<tr>
	  			<td>
	  				<input type="Text" id="demo56" maxlength="25" size="25" name="demo56"><a href="javascript:NewCal('demo56','mmmddyyyy',true,12,'arrow')"><img src="images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	  				<span class="descriptions">Format (date:MMM/dd/yyyy time:12hr)</span>
	  			</td>
			</tr> 




 
	  <tr>
	  	<td>  
	  	      <br>
	  		<div class="descriptions">Find user guide and learn how to customise your date time picker at <a href="http://www.rainforestnet.com/datatimepicker.htm">rainforest<font color="red"><b>NET</b></font></a> 
	  	</td>
	  </tr>
        <tr> 
    		<td> 
      		<hr noshade width="100%" align="left" size="1">
	      	<span class="copyright">Copyright&copy; 2002-2003 ng teng-yong. All Rights Reserved.All trademarks are the property of their respective owners</span>
    		</td>
  	  </tr>
</table>

</body>
</html>
