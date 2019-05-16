<body>
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<script type="text/javascript" src="../js/jquery.validation.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-en.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="css/validationengine.css" type="text/css" />


<a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
<a href="viewchimpUser.php" class="fancybox add_quick">List User</a>
<div class="had">Create User </div>

<div>
<TABLE WIDTH="100%"   BORDER=0 align="center"  >
	
  
<tr>
<td align="left" valign="top">
 <form id="form1" name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

			<? if (!empty($_SESSION['message'])) {?>
			<tr>
			<td  align="center"  class="message"  >
			<? if(!empty($_SESSION['message'])) {echo $_SESSION['message']; unset($_SESSION['message']); }?>	
			</td>
			</tr>
			<? } ?>
  
		<tr>
			<td  align="center" valign="top" >
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
			<tr>
			<td colspan="2" align="left"  class="head" >User Information</td>
			</tr>
			<tr>
			<td  align="right" width="40%"   class="blackbold"> First Name: </td>
			<td   align="left" >
			<input name="fname" type="text" class="inputbox validate[required] custom[onlyLetterSp]" id="title" value="<?php echo !empty($_POST['fname'])?$_POST['fname']:'';?>"/></td>
			</tr>
			
			<tr>
			<td  align="right" width="40%"   class="blackbold"> Last Name: </td>
			<td   align="left" >
			<input name="lname" type="text" class="inputbox validate[required] custom[onlyLetterSp]" value="<?php echo !empty($_POST['lname'])?$_POST['lname']:'';?>"/></td>
			</tr>
			<tr>
			<td  align="right" width="40%"  class="blackbold">Email  :<span class="red">*</span> </td>
			<td   align="left" >
			<input id="cemail" type="email" name="email" class="inputbox validate[required] custom[email]"/></td>
			</tr>
			</table>	
			</td>
		</tr>

		<tr>
			<td  align="center" >
			<div id="SubmitDiv" style="display:none1">
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit" />
			</div>
			</td>
		</tr>
   
   
</table></form>
	</td>
    </tr>
 
</table>
</div>
<script>
    	$("#form1").validationEngine({promptPosition : "topRight:-2,0"});
  </script>