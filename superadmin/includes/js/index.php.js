function validateSuperLogin(frm)
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
