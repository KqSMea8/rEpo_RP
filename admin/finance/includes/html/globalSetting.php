<script src="<?=$Prefix?>js/jquery.switchButton.js"></script>
<link rel="stylesheet" href="<?=$Prefix?>css/jquery.switchButton.css">
<div class="had"><?=$MainModuleName?></div>


<? if (!empty($_SESSION['mess_setting'])) {  ?>

                        <div align="center" class="message">
                            <?  	echo $_SESSION['mess_setting'];
					unset($_SESSION['mess_setting']);  
					
					
			  ?>
                        </div>
  
<? } ?>


              <form name="form1" action="" method="post"  enctype="multipart/form-data" onSubmit="return ValidateForm(this);"> 


                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                   


 <tr id="CollapseExpand">
        <td   align="right" valign="bottom" >

<a href="javascript:void(0);" id="collapseAll">Collapse All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);"  id="expandAll">Expand All</a>


	 </td>
      </tr> 


 <tr id="PermissionsVal">
       <td align="left">
				   
	
<? 
$ci=0;								
echo '<div id="accordion" >';
foreach($arryDepartmentSet as $key=>$valuesDept){		
	echo '<h2 onclick="javascript:SetIndex('.$ci.');">'.$valuesDept['Department'].'</h2>';		
   	include("includes/html/box/".strtolower($valuesDept['Department'])."_setting.php");
$ci++;
} 
echo '</div>';   
							
?>
  
	   
	   </td>
</tr> 




                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <input name="Submit" type="submit" class="button" id="SaveSettings" value="Save" />&nbsp;

<input type="hidden" name="SettingIndex" id="SettingIndex" value="<?=$_SESSION['SettingIndex']?>">

                        </td>   
                    </tr>

                </table>
               </form>
           

<SCRIPT LANGUAGE=JAVASCRIPT>


      $(function() { 
	
	 $("#OpeningStock").switchButton({ 
		on_label: 'On',
          	off_label: 'Off' 
	});  

	 $("#SO_APPROVE").switchButton({ 
		on_label: 'Yes',
          	off_label: 'No' ,
		on_callback: SoApproveRequired,
		off_callback: SoApproveRequired
	});
	
	$("#SO_APPROVE_REQUIRED").switchButton({ 
		on_label: 'Yes',
          	off_label: 'No' 
	}); 

	$("#PO_APPROVE").switchButton({ 
		on_label: 'Yes',
          	off_label: 'No' 
	}); 

	 $("#SO_SOURCE").switchButton({ 
		on_label: 'On',
          	off_label: 'Off' 
	});

        $("#AutoPostToGlAr").switchButton({ 
		on_label: 'Yes',
          	off_label: 'No' 
	}); 

	$("#AutoPostToGlAp").switchButton({ 
		on_label: 'Yes',
          	off_label: 'No' 
	}); 
  


	 $("#AutoPostToGlArCredit").switchButton({ 
		on_label: 'Yes',
          	off_label: 'No' 
	}); 

	$("#AutoPostToGlApCredit").switchButton({ 
		on_label: 'Yes',
          	off_label: 'No' 
	});  

	 $("#AutoFreightBilling").switchButton({ 
		on_label: 'Yes',
          	off_label: 'No' 
	}); 

	 $("#CommissionAp").switchButton({ 
		on_label: 'Yes',
          	off_label: 'No',
		on_callback: ShowCommissionFeeAccount,
		off_callback: ShowCommissionFeeAccount 
	}); 

	 $("#TaxableBilling").switchButton({ 
		on_label: 'Billing',
          	off_label: 'Shipping' 
	});

	 $("#TaxableBillingAp").switchButton({ 
		on_label: 'Vendor Address',
          	off_label: 'Shipping' 
	});
 
	 $("#SpiffDisplay").switchButton({ 
		on_label: 'Yes',
          	off_label: 'No' 
	}); 

      })



function ValidateForm(frm){
	$("#FiscalYearStartDate").attr("disabled",false);
	$("#FiscalYearEndDate").attr("disabled",false);
	ShowHideLoader('1','S');
	return true;
}

function ClearHead(SelID){
	document.getElementById("GlAccountID"+SelID).value='';
	document.getElementById("GlAccount_"+SelID).value='';
}

function SetIndex(SelID){
	document.getElementById("SettingIndex").value=SelID;
}

function SoApproveRequired(){	
	if(document.getElementById("SO_APPROVE").checked){
		$("#SO_APPROVE_REQUIRED").closest('td').show();
		$("#SO_APPROVE_REQUIRED").closest('td').prev('td').show();
	}else{
		$("#SO_APPROVE_REQUIRED").closest('td').hide();
		$("#SO_APPROVE_REQUIRED").closest('td').prev('td').hide();
	}
	 
}

function ShowCommissionFeeAccount(){	
 
	if(document.getElementById("CommissionAp").checked){
		$("[name=Account_CommissionFeeAccount]").closest('td').show();
		$("[name=Account_CommissionFeeAccount]").closest('td').prev('td').show();
	}else{
		$("[name=Account_CommissionFeeAccount]").closest('td').hide();
		$("[name=Account_CommissionFeeAccount]").closest('td').prev('td').hide();
	}
	 
}


$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 1000
		 });

		$(".fancysmall").fancybox({
			'width'         : 500
		 });
	

});

$("#accordion").accordion({
	heightStyle: "content",
	duration: 'fast',
	active: <?=$_SESSION["SettingIndex"]?>
});



$("#collapseAll").click(function(){
    $("#accordion .ui-accordion-content").hide()
});


$("#expandAll").click(function(){
    $("#accordion .ui-accordion-content").show()
});


 

function ShowHideEdit(Line,opt){	
	if(opt==1){		
		$("#rename"+Line).show();
	}else{
		$("#rename"+Line).hide();
	}
}


function SetAutoCompleteGL(elm){	 
	$(elm).autocomplete({
		source: "../jsonGL.php",
		minLength: 2
	});
}



function SetGlAccount(GL,line){
	if(GL == ''){
		document.getElementById("GlAccountID"+line).value='';
		document.getElementById("GlAccount_"+line).value='';
		return false;
	}       
			
	var SendUrl = "&action=SetttingGlAccount&GL="+escape(GL)+"&r="+Math.random();
	
   	$.ajax({
		type: "GET",
		url: "../ajax.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText) {
			
			if(responseText["BankAccountID"]>0){		 		 		 
				document.getElementById("GlAccountID"+line).value=responseText["BankAccountID"];
			}else{
				document.getElementById("GlAccountID"+line).value='';
				document.getElementById("GlAccount_"+line).value='';
			}
			   
		}

   	});			

}
</SCRIPT>


