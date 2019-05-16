
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />

<a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
<a class="fancybox add_quick" href="mailChimpSetting.php">Create Mail Chimp Account</a>
<!--a class="fancybox add_quick" href="constContactSetting.php">Create Constant Contact Account</a-->
<!--a href="viewConstContactUser.php" class="fancybox add_quick">List User</a-->
<div class="had">Mass Mail Setting</div>

<div>
<TABLE WIDTH="100%"   BORDER=0 align="center"  >
	
  
<tr>
<td align="left" valign="top">
<form id="form1" name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

    <?php if (!empty($_SESSION['message'])) {?>
    <tr>
        <td  align="center"  class="message"  >
        <?php if(!empty($_SESSION['message'])) {echo $_SESSION['message']; unset($_SESSION['message']); }?>	
        </td>
    </tr>
    <?php } ?>
  
    <tr>
        <td  align="center" valign="top" >
        
        </td>
    </tr>

<tr>
        <td  align="center" >
        
        </td>
</tr>
   
   
</table>
</form>
</td>
</tr>
 
</table>
</div>
