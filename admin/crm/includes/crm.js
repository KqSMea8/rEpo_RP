
function getField(tblName, fieldName, ID, IDVal, fieldType, selecttbl,
		selectfield, selectfieldType,relatedField) {
	
	ShowHideLoader('1', 'P');
	SendUrl = 'action=getField&tblName=' + tblName + '&fieldName=' + fieldName
			+ '&ID=' + ID + '&IDVal=' + IDVal + '&fieldType=' + fieldType
			+ '&selecttbl=' + selecttbl + '&selectfield=' + selectfield
			+ '&selectfieldType=' + selectfieldType+ '&relatedField=' + relatedField;
	$.ajax( {
		type : "POST",
		url : "ajax.php",
		data : SendUrl,
		dataType : "JSON",
		success : function(responseText) {
			$("#" + fieldName + IDVal).hide();
			$("#field_" + fieldName + IDVal).html(responseText);
			$("#field_" + fieldName + IDVal).show();
			$("#edit_" + fieldName + IDVal).hide();

			if (fieldType == 'date') {
				var currentYear = new Date();
				var fromdate = currentYear.getFullYear() - 20;
				var todate = currentYear.getFullYear() + 20;

				$("#input_" + fieldName + IDVal).datepicker( {
					showOn : "both",
					yearRange : '' + fromdate + ':' + todate + '',
					dateFormat : 'yy-mm-dd',
					maxDate : "",
					minDate : "",
					changeMonth : true,
					changeYear : true

				});
				if (relatedField!= '' && relatedField!= 'undefined') {
					$("#input_" + relatedField + IDVal).timepicker({'timeFormat': 'H:i:s'});
				}
				
			}
			
			if($('#opentd').val()==''){			
				$('#opentd').val(fieldName + IDVal);
				
			}else{
				
				var valopentd=$('#opentd').val();
				var Curremtopen=fieldName + IDVal;
				if(valopentd!=Curremtopen){
					$("#" + valopentd).show();
					$("#field_" + valopentd).html('').hide();
					$("#edit_" + valopentd).show();
					$('#opentd').val(fieldName + IDVal);
				}
				
			}
			
			// alert(responseText);
			ShowHideLoader('2', 'P');

		}
	});

}
function validateEmail($email) {
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	return emailReg.test($email);
}

function saveField(tblName, fieldName, ID, IDVal, fieldType,relatedField) {

	var fieldNameVal = $("#input_" + fieldName + IDVal).val();
	if(relatedField!=''){
		var relatedFieldVal = $("#input_" + relatedField + IDVal).val();
	}
	var module = $("#opt").val();
	SendUrl = 'action=saveField&tblName=' + tblName + '&fieldName=' + fieldName
			+ '&ID=' + ID + '&IDVal=' + IDVal + '&fieldType=' + fieldType
			+ '&fieldNameVal=' + fieldNameVal+ '&relatedField=' + relatedField+ '&relatedFieldVal=' + relatedFieldVal;
	var is_validted = 1;
	if (fieldType == 'email') {
		if (!validateEmail(fieldNameVal)) {
			is_validted = 0;
		}
	}
	if (is_validted == 1) {
		ShowHideLoader('1', 'P');
		$.ajax( {
			type : "POST",
			url : "ajax.php",
			data : SendUrl,
			dataType : "JSON",
			success : function(responseText) {
				if (responseText['issuccess'] == 1) {
					$("#" + fieldName + IDVal).html(responseText['data'])
							.show();
					$("#field_" + fieldName + IDVal).html('').hide();
					$("#edit_" + fieldName + IDVal).show();
				} else {
					alert('unable to update');
				}

				ShowHideLoader('2', 'P');

			}
		});
	} else {
		alert('Please enter valid data');
	}

}

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	return true;
}
function mouseoverfun(fieldname, id) {
	if (!$('#save_' + fieldname + id).length) {
		$('#edit_' + fieldname + id).show();
	}

}
function mouseoutfun(fieldname, id) {
	if (!$('#save_' + fieldname + id).length) {
		$('#edit_' + fieldname + id).hide();
	}
}