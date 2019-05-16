
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<style>

		
	#loading {
		position: absolute;
		top: 5px;
		
		right: 5px;
		}

	#calendar {
		width: 100%;
		margin: 0 auto;
		}
		.fc-event-title{
		 color:#FFFFFF;
		}
		
		.fc-event-inner .fc-event-time{ color:#FFFFFF;}

</style>

<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>
<body>
<div id="Event" >
<? if($ModifyLabel==1){?>

<div class="redmsg" align="center">Sorry, you are not authorized to access this section. Please contact to administrator </div>

<!--
<form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

	  
	    <tr>
		<td  align="center"  class="message" colspan="2" >
		<? if(!empty($_SESSION['mess_phone'])) {echo $_SESSION['mess_phone']; unset($_SESSION['mess_phone']); }?>	
		</td>
		</tr>
	
	  
	   <?php if(empty($CallSetting)) { ?>
	
		<tr>
		  <td colspan="2" align="left"  class="head" >Create Account in Elastix</td>
		</tr>

		<tr>
		<td  align="right" width="40%"   class="blackbold"> Name : </td>
		<td   align="left" >
		<input name="name" type="text" class="inputbox" id="name">
		</td>
		</tr>
	 
	  <tr>
		<td align="center" colspan="2" >
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit" />
		</td>
	 </tr>
	 
	
	   <?php } ?>
	</table>
	</form>
	-->
<? }else{?>

<div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
<? }?>
</div>




