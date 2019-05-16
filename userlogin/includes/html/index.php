<script language="javascript" src="<?=$Prefix?>includes/md5.js"></script>
<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm)
{	
	ClearMsg();
	if( ValidateLoginEmail(frm.LoginEmail, '<?=ENTER_EMAIL?>', '<?=VALID_EMAIL?>')
	   && ValidateForLogin(frm.LoginPassword, '<?=ENTER_PASSWORD?>')
	){
		document.getElementById("msg_div").innerHTML = '<span class=normalmsg><?=PLEASE_WAIT?></span>';
		/*
		var passhash = CryptoJS.MD5(frm.LoginPassword.value).toString();
		frm.LoginPassword.value = passhash;
		*/

		return true;	
	}else{
		return false;	
	}
}
</SCRIPT>
<?

	if($arryCompany[0]['Image'] !='' && file_exists($Prefix.'upload/company/'.$arryCompany[0]['Image']) ){
		$SiteLogo = $Prefix.'upload/company/'.$arryCompany[0]['Image'];
		list($LogoWidth, $LogoHeight) = getimagesize($SiteLogo);
		if($LogoWidth>350 || $LogoHeight>80){	
			$SiteLogo = $Prefix.'resizeimage.php?w=80&h=80&img=upload/company/'.$arryCompany[0]['Image'];
		}
	}else if($_GET['crm']==1){
		$SiteLogo = $Prefix.'images/logo_crm.png';	
	}else{
		$SiteLogo = $Prefix.'images/logo.png';

	}
		
?>

<div class="main_login">

	<div class="login_box">
    	<div class="logo" >

		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" height="80"><img src="<?=$SiteLogo?>" border="0" alt="<?=$Config['SiteName']?>" title="<?=$Config['SiteName']?>" /></td>
		</tr> 
		</table>
		
		</div>
		<? if(empty($ErrorMsg)){ ?>
			<div id="msg_div" align="center" class="redmsg" style="height:20px;padding-top:15px;"><?=$mess?></div>
		 <form class="admin_login_form" action="" method="post" name="form1" id="form1" onsubmit="return validate(this);" target="_parent">
          	<!-- <fieldset>
            	<label>Login Type</label>
				<div class="sel-wrap-login"><select name="UserType" id="UserType">
					<option value="customer" <? if($_POST['UserType']=="customer") echo "Selected"; ?>>Customer</option>
					<option value="vendor" <? if($_POST['UserType']=="vendor") echo "Selected"; ?>>Vendor</option>
				</select></div>
            </fieldset>-->
      		<fieldset>
            	<label>Email</label>
				<input name="LoginEmail" type="text" class="usname_icon" id="LoginEmail"  maxlength="60" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  autocomplete="off" /> 
            </fieldset>
            <fieldset>
            	<label>Password</label>
				<input name="LoginPassword" type="password" class="pass_icon" id="LoginPassword"  maxlength="25" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  autocomplete="off"/>
            </fieldset>
            <fieldset>
                <input class="button_btn" type="submit" value=" Sign In" />
				<a id="forgot" href="forgot.php" class="fancybox fancybox.iframe">Forgot Password ?</a>
				<input type="hidden" name="ContinueUrl" id="ContinueUrl" value="<?=$_GET['ref']?>" />	
				<input type="hidden" name="CmpID" id="CmpID" value="<?=$arryCompany[0]["CmpID"]?>" />	

<input type="hidden" name="crm" id="crm" value="<?=$_GET["crm"]?>" />	

            </fieldset>
          <!--  <fieldset>
            	<input name="" class="checkbox" type="checkbox" value="" /> <span class="keepme">Keep me logged in</span>
            </fieldset>-->
        </form>
			<? }else{ ?>
				<div class="redmsg" style="text-align:center; padding-top:100px;"><?=$ErrorMsg?></div>
			<? } ?>
    </div>
   
</div>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
	$("#forgot").fancybox({
		'width'  : 350
	 });
	/*
	$("#forgot").on("click", function () { 
		var UserType = $("#UserType").val();
		var href_val = $("#forgot").attr("href");
		if(UserType == 'employee'){
			$("#forgot").attr("href", href_val+"&t=e");
		}else{
			$("#forgot").attr("href", href_val+"&t=a");
		}

	});
	*/

});

</script>
