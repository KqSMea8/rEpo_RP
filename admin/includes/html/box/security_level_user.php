<?php   
if($arryCompany[0]['SecurityLevel'] == "2" && $EmpID>0){ 
	$arryUserInfo = $objConfig->GetEmployeeBasic($EmpID);
	$EnableSecurityUser = $arryUserInfo[0]['UserSecurity'];

 	$SecUserArray = explode(",",$arryUserInfo[0]['AllowSecurityUser']);

	/***************/
	if($EnableSecurityUser==1){
		$radioSec1 = "checked"; $radioSec2 = ""; $disAuth = '';
	}else{
		$radioSec1 = ""; $radioSec2 = "checked"; $disAuth = 'style="display:none";';
		
	}
	$SecurityTitleText = '<b><span>Status :</span></b>&nbsp;&nbsp;&nbsp;<label><input id="SecurityStatusEmp1" name="SecurityStatusEmp" type="radio" value="1" onclick="Javascript:SetAuthUserDiv(1)" '.$radioSec1.'><span>On</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input id="SecurityStatusEmp2" name="SecurityStatusEmp" type="radio" value="0"  onclick="Javascript:SetAuthUserDiv(0)" '.$radioSec2.'><span>Off</span></label><br><br>';

	
	$SecurityTitleText .= '<div id="AuthDivUser" '.$disAuth.'><b>Available authentication :</b>';
	if(substr_count($arryCompany[0]['AllowSecurity'],"1")){
		$checkedSec = (in_array("1",$SecUserArray))?("checked"):("");	
		$SecurityTitleText .= '<br><label><input id="AllowSecurityEmp1" type="checkbox" name="AllowSecurityEmp[]" value="1" '.$checkedSec.'> <span>Security Question</span></label>';
	}
	if(substr_count($arryCompany[0]['AllowSecurity'],"2")){
		$checkedSec = (in_array("2",$SecUserArray))?("checked"):("");	
		$SecurityTitleText .= '<br><label><input id="AllowSecurityEmp2" type="checkbox" name="AllowSecurityEmp[]" value="2" '.$checkedSec.'> <span>Google Authentication</span></label>';
	}
	if(substr_count($arryCompany[0]['AllowSecurity'],"3")){
		$checkedSec = (in_array("3",$SecUserArray))?("checked"):("");	
		$SecurityTitleText .= '<br><label><input id="AllowSecurityEmp3" type="checkbox" name="AllowSecurityEmp[]" value="3" '.$checkedSec.'> <span>Email Verification</span></label>';
	}
	if(substr_count($arryCompany[0]['AllowSecurity'],"4")){
		$checkedSec = (in_array("4",$SecUserArray))?("checked"):("");	
		$SecurityTitleText .= '<br><label><input id="AllowSecurityEmp4" type="checkbox" name="AllowSecurityEmp[]" value="4" '.$checkedSec.'> <span>SMS Verification</span></label>';
	}
	$SecurityTitleText .= '</div>';
		
	 
     	/***************/
 	 
?>
<style>
#securitydialog-confirm span {
    vertical-align: top;
    margin-left: 3px;
}
</style>
<script language="JavaScript1.2" type="text/javascript">
 
function securityUserDialog(EnableSecurityUser,EmpID,UserID){  
	var  TitleText = '<?=$SecurityTitleText?>';     
	var UserSecurity = 0;	
	var MainPrefix = '<?=$MainPrefix?>';
	var CurrentDepID = '<?=$Config["CurrentDepID"]?>';   
	var HomeUrl = "editUser.php?edit="+EmpID;
	if(CurrentDepID=='1'){
		 HomeUrl = "editEmployee.php?edit="+EmpID;
	} 
 

     $("#securitydialog-confirm").html(TitleText);
     $("#securitydialog-confirm" ).dialog({
      resizable: false,
      height:300,
      width:430,
      modal: true,
      buttons: {
        "Update": function() { 
  
		var AllowSecurityEmp ='';     
		for(var i=1;i<=4;i++){		 
			if($('#AllowSecurityEmp'+i).is(':checked')){
				AllowSecurityEmp +=  $('#AllowSecurityEmp'+i).val() + ',';
			}
		}
		 
		if($('#SecurityStatusEmp1').is(':checked')){
			UserSecurity = 1;
		}
 
            	$.ajax({
			type: "POST",
			url: MainPrefix+"ajax_post.php",
		
			data:{
				action:'EmpSecurityLevel', EnableSecurityUser:EnableSecurityUser, AllowSecurityEmp:AllowSecurityEmp, UserSecurity:UserSecurity ,UserID:UserID
			}, 
			
		   	success: function(data){ 

				ShowHideLoader(1,'S');
				
	 			window.location.href = HomeUrl;
				return data;
			}
		});
	
	

		$( this ).dialog( "close" );

        },
       
      }
    });
	
	 
}



function SetAuthUserDiv(opt){
	if(opt==1){
		$('#AuthDivUser').show(500);
	}else{
		$('#AuthDivUser').hide(500);
	}
}
 
</script>


<div id="securitydialog-confirm" title="2-Step Authentication"></div>


<li class="secure" ><a href="Javascript:securityUserDialog(<?=$EnableSecurityUser?>,<?=$EmpID?>,<?=$arryEmployee[0]['UserID']?>);">2-Step Authentication</a></li>

<style>
 #dhtmltooltip{ 
	background-color: <?=$ToolColor?>;
}
</style>


<? }?>
