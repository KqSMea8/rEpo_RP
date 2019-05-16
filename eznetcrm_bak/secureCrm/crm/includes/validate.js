function ClearMsg() {
	document.getElementById("msg_div").innerHTML = '';
}
function ValidateForLogin(p_field,p_Message){
	if(Trim(p_field).value == "" ) {
		document.getElementById("msg_div").innerHTML = p_Message;            
		p_field.focus();
		return 0;
	}else{
		return 1;
	}
}
function ValidateLoginEmail(p_field,p_Message,p_ValidMessage) {

	if(Trim(p_field).value == "" ) {
		document.getElementById("msg_div").innerHTML = p_Message;           
		p_field.focus();
		return 0;
	}else{
		   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		   var address = p_field.value;
		   if(reg.test(address) == false) {
			  document.getElementById("msg_div").innerHTML = p_ValidMessage;               
			  p_field.select();
			  return 0;
		   }
	}

	return 1;
}


function ValidateMandRangeMsg(p_field,p_FieldName,p_Min,p_Max){
	if(Trim(p_field).value == "" ) {
		document.getElementById("msg_div").innerHTML = "Please Enter "+ p_FieldName +".";           
		p_field.focus();
		return 0;
	}else if(p_field.value.length < p_Min || p_field.value.length > p_Max){
				document.getElementById("msg_div").innerHTML = p_FieldName+" should be from "+p_Min+" to "+p_Max+" characters long.";           
				p_field.focus();
				return 0;
	}else{
		return 1;
	}
}

function ValidateForPasswordConfirmMsg(p_Password,p_ConfirmPassword){
	if(Trim(p_ConfirmPassword).value == "" ) {
		document.getElementById("msg_div").innerHTML = "Please Enter Confirm Password.";
		p_ConfirmPassword.focus();
		return 0;
	}else if(p_ConfirmPassword.value != p_Password.value ) {
		document.getElementById("msg_div").innerHTML = "Passwords do not match, Please Confirm Password again.";
		p_ConfirmPassword.select();
		return 0;
	}else{
		return 1;
	}
}

function confirmDialog(obj, moduleName)
{
	$("#dialog-modal").html("Are you sure you want to delete this "+moduleName+"?");
    $("#dialog-modal").dialog(
    {
        title: "Remove "+moduleName,
		modal: true,
		width: 400,
		buttons: {
			"Ok": function() {
				var luink =  $(obj).attr('href');
				location.href = luink;
				 $(this).dialog("close");
				 ShowHideLoader(1,'P');
			},
			"Cancel": function() {
				 $(this).dialog("close");
			}
		}

     });
	
	return false;
}


function AlertMsg(p_field,Msg)
{
	document.getElementById("dialog-modal").innerHTML = Msg;
    $("#dialog-modal").dialog(
    {
        title: "Alert",
		modal: true,
		width: 400,
		buttons: {
			"Ok": function() {
				 $(this).dialog("close");
				 p_field.focus();
			}
		}

     });
	return false;
}

function ValidateForSimpleBlank2(p_field,p_FieldName){
	if(Trim(p_field).value == "" ) {
		AlertMsg(p_field,"Enter "+ p_FieldName +".");            
		return 0;
	}else{
		return 1;
	}
}

function ValidateOptSalary(p_field, p_FieldName){
	if(!p_field.value)
		p_field.value = "";
	else if(isNaN(parseInt(p_field.value))||p_field.value.length!=parseInt(p_field.value).toString().length){
		document.getElementById("msg_div").innerHTML = p_FieldName + " must be a number.";    
		p_field.focus();
		return 0;
	}
	return 1;
}

function confirmAction(obj, module, message)
{
	$("#dialog-modal").html(message);
    $("#dialog-modal").dialog(
    {
        title: module,
		modal: true,
		width: 400,
		buttons: {
			"Ok": function() {
				var luink =  $(obj).attr('href');
				location.href = luink;
				 $(this).dialog("close");
				 ShowHideLoader(1,'P');
			},
			"Cancel": function() {
				 $(this).dialog("close");
			}
		}

     });
	
	return false;
}

function number_format (number, decimals, dec_point, thousands_sep) {
  // http://kevin.vanzonneveld.net
  // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +     bugfix by: Michael White (http://getsprink.com)
  // +     bugfix by: Benjamin Lupton
  // +     bugfix by: Allan Jensen (http://www.winternet.no)
  // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // +     bugfix by: Howard Yeend
  // +    revised by: Luke Smith (http://lucassmith.name)
  // +     bugfix by: Diogo Resende
  // +     bugfix by: Rival
  // +      input by: Kheang Hok Chin (http://www.distantia.ca/)
  // +   improved by: davook
  // +   improved by: Brett Zamir (http://brett-zamir.me)
  // +      input by: Jay Klehr
  // +   improved by: Brett Zamir (http://brett-zamir.me)
  // +      input by: Amir Habibi (http://www.residence-mixte.com/)
  // +     bugfix by: Brett Zamir (http://brett-zamir.me)
  // +   improved by: Theriault
  // +      input by: Amirouche
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // *     example 1: number_format(1234.56);
  // *     returns 1: '1,235'
  // *     example 2: number_format(1234.56, 2, ',', ' ');
  // *     returns 2: '1 234,56'
  // *     example 3: number_format(1234.5678, 2, '.', '');
  // *     returns 3: '1234.57'
  // *     example 4: number_format(67, 2, ',', '.');
  // *     returns 4: '67,00'
  // *     example 5: number_format(1000);
  // *     returns 5: '1,000'
  // *     example 6: number_format(67.311, 2);
  // *     returns 6: '67.31'
  // *     example 7: number_format(1000.55, 1);
  // *     returns 7: '1,000.6'
  // *     example 8: number_format(67000, 5, ',', '.');
  // *     returns 8: '67.000,00000'
  // *     example 9: number_format(0.9, 0);
  // *     returns 9: '1'
  // *    example 10: number_format('1.20', 2);
  // *    returns 10: '1.20'
  // *    example 11: number_format('1.20', 4);
  // *    returns 11: '1.2000'
  // *    example 12: number_format('1.2000', 3);
  // *    returns 12: '1.200'
  // *    example 13: number_format('1 000,50', 2, '.', ' ');
  // *    returns 13: '100 050.00'
  // Strip all characters but numerical ones.
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}






function nl2br (str, is_xhtml) {

  var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>';

  return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}







/************************************/
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function isDecimalKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;

    if (charCode > 31 && (charCode < 46 || charCode > 57 || charCode == 47))
        return false;
    return true;
}

function isCharKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 32 && (charCode < 65 || charCode > 90) &&
          (charCode < 97 || charCode > 122)) {
		return false;
	}
    return true;

}

function isAlphaKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 32 && (charCode < 48 || charCode > 57) && (charCode < 65 || charCode > 90) &&
          (charCode < 97 || charCode > 122)) {
		return false;
	}
    return true;

}


function isUniqueKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 65 || charCode > 90) &&
          (charCode < 97 || charCode > 122)) {
		return false;
	}
    return true;

}


function isVarcharKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 65 || charCode > 90) &&
          (charCode < 97 || charCode > 122)) {
		return false;
	}
    return true;

}

function isNormalKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 32 && (charCode < 48 || charCode > 57) && (charCode < 65 || charCode > 90) &&
          (charCode < 91 || charCode > 222)) {
		return false;
	}
    return true;

}

function LoaderSearch(){	
	ShowHideLoader('1','F');
}