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
	$CmpImage = (!empty($arryCompany[0]['Image']))?($arryCompany[0]['Image']):('');
 	
	if(IsFileExist($Config['CmpDir'],$CmpImage)){//cmp logo 
		$arrayFileInfo = GetFileInfo($Config['CmpDir'],$arryCompany[0]['Image']);
		if($arrayFileInfo[0]>350 || $arrayFileInfo[1]>80){	
			$PreviewArray['Width'] = "80";
			$PreviewArray['Height'] = "80"; 			 
		} 
		$PreviewArray['Folder'] = $Config['CmpDir'];
		$PreviewArray['FileName'] = $arryCompany[0]['Image']; 
		$PreviewArray['FileTitle'] = stripslashes($Config['SiteName']); 
		$SiteLogo = PreviewImage($PreviewArray); 
	}else if($_GET['crm']==1){ 
		$SiteLogo = '<img src="'.$Config['DefaultLogoCrm'].'" border="0" alt="'.$Config['SiteName'].'" title="'.$Config['SiteName'].'" >';	
	}else{
		$Config['CmpID'] = $Config['SuperCmpID'];
		if(IsFileExist($Config['SiteLogoDir'],$arrayConfig[0]['SiteLogo'])){ 
			$PreviewArray['Folder'] = $Config['SiteLogoDir'];
			$PreviewArray['FileName'] = $arrayConfig[0]['SiteLogo']; 
			$PreviewArray['FileTitle'] = stripslashes($Config['SiteName']);
			$PreviewArray['Width'] = "80";
			$PreviewArray['Height'] = "80"; 
			$SiteLogo = PreviewImage($PreviewArray); 			
		}else{ 
			$SiteLogo = '<img src="'.$Config['DefaultLogo'].'" border="0" alt="'.$Config['SiteName'].'" title="'.$Config['SiteName'].'" >';
		}
		if(!empty($_SESSION['CmpID']))$Config['CmpID'] = $_SESSION['CmpID']; 
	}
	
	
		
?>

<div class="main_login">

	<div class="login_box">
    	<div class="logo" >

		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" height="80"><?=$SiteLogo?></td>
		</tr> 
		</table>
		
		</div>
		<? if(empty($ErrorMsg)){ ?>
			<div id="msg_div" align="center" class="login_msg" ><?=$mess?></div>
		 <form class="admin_login_form" action="" method="post" name="form1" id="form1" onsubmit="return validate(this);" target="_parent">
          	<!--fieldset>
            	<label>Login Type</label>
				<div class="sel-wrap-login"><select name="UserType" id="UserType">
					<option value="admin"  >Administrator</option>
					<option value="employee"  >Employee</option>
				</select></div>
            </fieldset-->
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
<? if(!empty($_GET['ref'])){?>
<input type="hidden" name="ContinueUrl" id="ContinueUrl" value="<?=$_GET['ref']?>" />	
<? } ?>
				<input type="hidden" name="CmpID" id="CmpID" value="" />	

<input type="hidden" name="crm" id="crm" value="<?=$_GET["crm"]?>" />	

            </fieldset>
          <!--  <fieldset>
            	<input name="" class="checkbox" type="checkbox" value="" /> <span class="keepme">Keep me logged in</span>
            </fieldset>-->
        </form>
			<? }else{ ?>
				<div class="login_error_msg" ><?=$ErrorMsg?></div>
			<? } ?>
    </div>
   
</div>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
	$("#forgot").fancybox({
		'width'  : 350
	 });

	 $("#LoginEmail").focus();

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
