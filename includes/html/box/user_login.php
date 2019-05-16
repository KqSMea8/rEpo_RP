<? 


if(($PageID==1)){
	$LoginBoxBG = 'class=register_box1';
	$RegisterImgh = 'reg.png';
	$WelcomeImgh = 'welcome_small';
	$BoxTableWidth = '190';
	
	$LoginGap =  '';
}else{
	$LoginBoxBG = 'class=register_box_inner1';
	$RegisterImgh = 'register_now_ticker_inner.jpg';
	$WelcomeImgh = 'welcome_big';
	$BoxTableWidth = '200';
	$LoginGap =  ' <table width=10><tr>
    		<td height="9"></td>
 		 </tr></table>';
}

if (empty($_SESSION['UserName']) && empty($_SESSION['MemberID'])) {


?>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="signup.php"><img src="images/<?=$RegisterImgh?>" alt="register"  border="0"/></a></td>
  </tr>
 
</table>
</div>
<? if($ThisPage!='login.php'){?>
<?=$LoginGap?>

<div class="register_box" >

			
			
			  <div <?=$LoginBoxBG?> >
			    <table width="<?=$BoxTableWidth?>" border="0" cellspacing="0" cellpadding="0" >
                  <form name="LoginForm" action="login.php"  method="post" onSubmit="return validateLogin(this);">
				
				 
				  <tr>
                    <td height="24" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      
                      <tr>
							<td width="66%" align="left" valign="middle"><img src="images/user_login_txt.jpg" alt="Users"  /></td>
                        <td width="34%" align="left" valign="middle"><a href="account.php" class="darkgreentxt_link"><?=MY_ACCOUNT?></a></td>
                      </tr>
                    </table></td>
                  </tr>
                  
                  <tr>
                    <td class="generaltxt">Email Address:<br />
                      <input name="LoginEmail" id="LoginEmail" type="text"  class="txtfield" size="30" maxlength="70"/><br />
					  Password:<br />
                      <input name="LoginPassword" id="LoginPassword" type="password"  class="txtfield" size="30"/></td>
                  </tr>
                  <tr>
                    <td height="23" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="27%" align="left" valign="middle">
					
						<input type="image" src="images/login_button.jpg" alt="Login" width="48" height="18" value=" " />
						
						</td>
                        <td  align="left" valign="middle"><a href="forgot.php" class="greentxt_link"><?=FORGOT_YOUR_PASSWORD?></a> <input type="hidden" name="LoginType" id="LoginType" value="" /></td>
                      </tr>
					  
                    </table></td>
                  </tr>
				
				  </form>
                </table>
			  </div>  
			  
			  
</div>
<? } ?>
<? }else{



		$arryMemberBox = $objMember->GetMemberDetail($_SESSION['MemberID']);

 ?>



<div class="register_box">

<div class="<?=$WelcomeImgh?>" >
	<?	
		echo '<div style="padding-left:80px;padding-top:13px;"><i>'.WELCOME.'</i></div>';
		echo '<div style="padding-top:15px;margin-left:90px;width:108px;overflow:hidden"><a href="member-area.php" class="white_link16">'.$_SESSION['UserName'].'</a></div>'; 
	?>

</div><div <?=$LoginBoxBG?>  ><table width="94%" border="0" cellspacing="0" cellpadding="1">
  <tr>
					<td align="left"  height="8"></td>
					</tr>
  <tr>
    <td valign="top">
	
<table border="0" cellspacing="0" cellpadding="2">
					
					<tr>
					<td align="left" valign="middle"><a href="member-area.php" class="darkgreentxt_link"><?=MEMBER_PORTAL?></a></td>
					</tr>
					<tr>
					<td align="left" valign="middle"><a href="account.php" class="darkgreentxt_link"><?=MY_ACCOUNT?></a></td>
					</tr>
					<tr>
					<td align="left" valign="middle"><a href="logout.php" class="darkgreentxt_link"><?=LOG_OUT?></a></td>
					</tr>
                </table>	
	
	</td> 
	
	<? if($arryMemberBox[0]['Image'] !='' && file_exists('upload/company/'.$arryMemberBox[0]['Image']) ){ ?>
     <td align="right" valign="top"><?
			$ImagePath = 'resizeimage.php?img=upload/company/'.$arryMemberBox[0]['Image'].'&w=100&h=100'; 
			
			$ImagePath = '<a href="upload/company/'.$arryMemberBox[0]['Image'].'" rel="lightbox"><img src="'.$ImagePath.'"  border="0"/></a>';
			echo $ImagePath;
			
		
	?>   
		   </td>
     <? } ?>
	 
  </tr>
</table></div>  
</div>

<? } ?>




