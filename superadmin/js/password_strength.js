
$(document).ready(function() {
	var password1 		= $('#Password'); //id of first password field
	var password2		= $('#ConfirmPassword'); //id of second password field
	var passwordsInfo 	= $('#pass-info'); //id of indicator element
        //var isValid = 1;
	
	passwordStrengthCheck(password1,password2,passwordsInfo); //call password check function
        //validate();
	
});


var isValid = 1;
function passwordStrengthCheck(password1, password2, passwordsInfo)
{
       
        
	var WeakPass = /(?=.{5,10}).*/; 
	//Must contain lower case letters and at least one digit.
        
	var MediumPass = /^(?=\S*?[a-z])/; 
	//Must contain at least one upper case letter, one lower case letter and one digit.
        
	var StrongPass = /^(?=\S*?[A-Z])/;
        
        var onedigit = /^(?=.*\d).{1,}$/;
	//Must contain at least one upper case letter, one lower case letter and one digit.
	
        var VryStrongPass = /^(?=.*[!@#$%^&*])/; 
        
	//var percentage = 0;
	$(password1).on('keyup', function(e) {
             var isValid = 1;
		if(VryStrongPass.test(password1.val()))
		{
			
                        jQuery("#pswd_info_symbol").removeClass().addClass('pswd_info_valid');
                  
		}
                else{
                     isValid=0;
                    jQuery("#pswd_info_symbol").removeClass('pswd_info_valid').addClass('pswd_info_invalid');
                    
                }
		if(StrongPass.test(password1.val()))
		{
			
                        jQuery("#pswd_info_capital").removeClass().addClass('pswd_info_valid');
                        
		}
                else{
                      isValid=0;
                    jQuery("#pswd_info_capital").removeClass('pswd_info_valid').addClass('pswd_info_invalid');
                  
                }
		if(MediumPass.test(password1.val()))
		{
			
                        jQuery("#pswd_info_lower").removeClass().addClass('pswd_info_valid');
                        
		}
                else{
                      isValid=0;
                    jQuery("#pswd_info_lower").removeClass('pswd_info_valid').addClass('pswd_info_invalid');
                    
                   
                }
		if(WeakPass.test(password1.val()))
                {
			
                        jQuery("#pswd_info_length").removeClass().addClass('pswd_info_valid');
                        
                }
                else{
                      isValid=0;
                    jQuery("#pswd_info_length").removeClass('pswd_info_valid').addClass('pswd_info_invalid');
                    
                }
                if(onedigit.test(password1.val()))
		{
			
                        jQuery("#pswd_info_number").removeClass().addClass('pswd_info_valid');
                        
		}
                else {
                      isValid=0;
                    jQuery("#pswd_info_number").removeClass().addClass('pswd_info_invalid');
                    
                }
            //else if(password1.val().match(jQuery('#username').val()))
            
               $('#isvalidate').val(isValid);
	});  
}

$(document).ready(function () 
{
    $("#Password").focus(function () {
        $("#pswd-info-wrap").css('display', 'block');
    });
    $("#Password").focusout(function(){
        $("#pswd-info-wrap").css('display','none');
        var isvaldd=$('#isvalidate').val();
        if(isvaldd==1){
            $('.passmsg').css('display','none');
            if($('#Password').parents('.blacknormal').find('.passverified').length==0){
                $('.passnotverified').css('display','none');

                $('#Password').parents('.blacknormal').append('<span class="passverified"></span>');
                $('.passverified').css('display','inline-block');
            }
            else{
                $('.passnotverified').css('display','none');
                $('#Password').parents('.blacknormal').find('.passverified').html('');
                $('.passverified').css('display','inline-block');
            }
        }
        else{
            $('.passmsg').css('display','none');
            if($('#Password').parents('.blacknormal').find('.passnotverified').length==0){
                $('.passverified').css('display','none');
                
                $('#Password').parents('.blacknormal').append('<span class="passnotverified">Please Enter Valid Password</span>');
                $('.passnotverified').css('display','inline-block');
            }
            else{
                $('.passverified').css('display','none');
                $('#Password').parents('.blacknormal').find('.passnotverified').html('Please Enter Valid Password');
                $('.passnotverified').css('display','inline-block');
            }
        }
});
});
   
