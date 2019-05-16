
function ShowPayDiv(opt,fieldname){
	if(document.getElementById(fieldname).checked == true){
		document.getElementById("PaymentDiv"+opt).style.display = 'inline';
	}else{
		
		if(opt==3){
			//if(document.getElementById('EftPayment').checked == true || document.getElementById('DepositPayment').checked == true){
			if(document.getElementById('EftPayment').checked == true){
				document.getElementById("PaymentDiv"+opt).style.display = 'inline';
			}else{
				document.getElementById("PaymentDiv"+opt).style.display = 'none';
			}
		}else{
			document.getElementById("PaymentDiv"+opt).style.display = 'none';
		}


	}
	

}

function validate(frm)
{	
	/*
	var paymentSelected = 0;
	for(var i=1;i<=3;i++){
		if(document.getElementById("PaymentDiv"+i).style.display != 'none' ) {
			paymentSelected = 1;
			break;
		}
	}*/
	
	
	if(  ValidateForSimpleBlank(frm.SiteName, "Site Name")
		&& ValidateForSimpleBlank(frm.SiteTitle, "Site Title")
		&& ValidateForSimpleBlank(frm.SiteEmail, "Site Email")
		&& isEmail(frm.SiteEmail)
		&& ValidateOptionalUpload(frm.SiteLogo, "Site Logo")
		//&& ValidateOptionalUpload(frm.BodyBg, "Body Background Image")
		//&& ValidateOptionalUpload(frm.HomeImage, "Home Page Image")
		//&& ValidateOptFlash(frm.HomeFlash, "Home Page Flash")
		//&& ValidateOptNumField2(frm.FlashWidth,"Flash Width",50,999)
		//&& ValidateOptNumField2(frm.FlashHeight,"Flash Height",50,999)
		//&& ValidateOptDecimalField(frm.Tax, "Tax")
		//&& ValidateOptDecimalField(frm.Shipping, "Shipping")
	){
		/*
		if(paymentSelected==0){
			alert('Please select atleast one payment type.');
			return false;
		}
	

		if(document.getElementById("PaymentDiv1").style.display != 'none'){
			
			if(!ValidateForSimpleBlank(frm.MyGate_MerchantID, "MyGate MerchantID")){
				return false;
			}
			
			if(!ValidateForSimpleBlank(frm.MyGate_ApplicationID, "MyGate ApplicationID")){
				return false;
			}
			
		}
		
		
		if(document.getElementById("PaymentDiv2").style.display != 'none'){
			
			if(!ValidateForSimpleBlank(frm.PaypalID, "PayPal ID")){
				return false;
			}
			
			if(!isEmail(frm.PaypalID)){
				return false;	
			}

		}


		if(document.getElementById("PaymentDiv3").style.display != 'none'){
			
			if(!ValidateForSimpleBlank(frm.AccountHolder, "Account Holder Name")){
				return false;
			}
			
			if(!ValidateMandNumField(frm.AccountNumber, "Account Number")){
				return false;
			}
			
			if(!ValidateForSimpleBlank(frm.BankName,"Bank Name")){
				return false;	
			}
			if(!ValidateForSimpleBlank(frm.BranchCode,"Branch Code")){
				return false;	
			}
		}
		
		*/


		return true;	
	}else{
		return false;	
	}
}
