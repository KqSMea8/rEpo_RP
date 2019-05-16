<?
 
//if($arrayConfig[0]['SiteLogo'] !='' && file_exists('../images/'.$arrayConfig[0]['SiteLogo']) ){
	//$SiteLogo = '../resizeimage.php?w=80&h=80&img=images/'.$arrayConfig[0]['SiteLogo'];
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
?>
<div class="main_login">
	<div class="login_box">
      
					<div class="logo">
				
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" height="80"><?=$SiteLogo?></td>
					</tr> 
					</table>

					
					</div>


<? if(empty($ErrorMsg)){ ?>
					<div id="msg_div" class="login_msg"><?=$mess?></div>
                      <form action="" class="admin_login_form" method="post" name="form1" id="form1" onsubmit="return validateLoginBox(this);">                      
                      	
					 <fieldset>
								<label>Email</label>
								<input name="LoginEmail" type="text" class="usname_icon" id="LoginEmail"  maxlength="60" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  /> 
							</fieldset>

						<fieldset>
							<label>Password</label>
							<input name="LoginPassword" type="password" class="usname_icon" id="LoginPassword"  maxlength="25" onkeypress="ClearMsg();" onmousedown="ClearMsg();" />
						</fieldset>

						 <fieldset>
							<input class="button_btn" type="submit" value=" Sign In" />
							
<? if(!empty($_GET['ref'])){?>
<input type="hidden" name="ContinueUrl" id="ContinueUrl" value="<?=$_GET['ref']?>" />	
<? } ?>
						</fieldset>
                             
                             
                            
                      </form>
                 
<? }else{ ?>
				<div class="login_error_msg"><?=$ErrorMsg?></div>
			<? } ?>

                 
      </div>
     
      </div>
<SCRIPT LANGUAGE=JAVASCRIPT>
function validateLoginBox(frm)
{	
	ClearMsg();
	if( ValidateLoginEmail(frm.LoginEmail, 'Please Enter Email Address.', 'Please Enter Valid Email Address.')
	   && ValidateForLogin(frm.LoginPassword, 'Please Enter Password.')
	){
		document.getElementById("msg_div").innerHTML = 'Please Wait.....';
		return true;	
	}else{
		return false;	
	}
}
 $("#LoginEmail").focus();
</SCRIPT>
