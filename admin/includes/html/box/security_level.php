<?php  
if($arryCompany[0]['SecurityLevel'] == "2"){ 

	/***************/
	if($EnableSecurity==1){
		$radioSec1 = "checked"; $radioSec2 = ""; $disAuth = '';
	}else{
		$radioSec1 = ""; $radioSec2 = "checked"; $disAuth = 'style="display:none";';
		
	}
	$SecurityTitleText = '<b><span>Status :</span></b>&nbsp;&nbsp;&nbsp;<label><input id="SecurityStatus1" name="SecurityStatus" type="radio" value="1" onclick="Javascript:SetAuthDiv(1)" '.$radioSec1.'><span>On</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input id="SecurityStatus2" name="SecurityStatus" type="radio" value="0"  onclick="Javascript:SetAuthDiv(0)" '.$radioSec2.'><span>Off</span></label><br><br>';

	
	$SecurityTitleText .= '<div id="AuthDiv" '.$disAuth.'><b>Available authentication :</b>';
	if(substr_count($arryCompany[0]['AllowSecurity'],"1")){
		$checkedSec = (in_array("1",$SecurityUserArray))?("checked"):("");	
		$SecurityTitleText .= '<br><label><input id="AllowSecurityUser1" type="checkbox" name="AllowSecurityUser[]" value="1" '.$checkedSec.'> <span>Security Question</span></label>';
	}
	if(substr_count($arryCompany[0]['AllowSecurity'],"2")){
		$checkedSec = (in_array("2",$SecurityUserArray))?("checked"):("");	
		$SecurityTitleText .= '<br><label><input id="AllowSecurityUser2" type="checkbox" name="AllowSecurityUser[]" value="2" '.$checkedSec.'> <span>Google Authentication</span></label>';
	}
	if(substr_count($arryCompany[0]['AllowSecurity'],"3")){
		$checkedSec = (in_array("3",$SecurityUserArray))?("checked"):("");	
		$SecurityTitleText .= '<br><label><input id="AllowSecurityUser3" type="checkbox" name="AllowSecurityUser[]" value="3" '.$checkedSec.'> <span>Email Verification</span></label>';
	}
	if(substr_count($arryCompany[0]['AllowSecurity'],"4")){
		$checkedSec = (in_array("4",$SecurityUserArray))?("checked"):("");	
		$SecurityTitleText .= '<br><label><input id="AllowSecurityUser4" type="checkbox" name="AllowSecurityUser[]" value="4" '.$checkedSec.'> <span>SMS Verification</span></label>';
	}
	$SecurityTitleText .= '</div>';
		
	

 	$SecurityTitleText .= "<br><b>Do you want to continue ?</b>";	 
     	/***************/
 	 
?>
<style>
#securitydialog-confirm span {
    vertical-align: top;
    margin-left: 3px;
}
</style>
<script language="JavaScript1.2" type="text/javascript">
 
function securityDialog(EnableSecurity){
     var  TitleText = '<?=$SecurityTitleText?>';     
     var UserSecurity = 0;
     $("#securitydialog-confirm").html(TitleText);
     $("#securitydialog-confirm" ).dialog({
      resizable: false,
      height:300,
      width:430,
      modal: true,
      buttons: {
        "Yes": function() { 
  
		var AllowSecurityUser ='';     
		for(var i=1;i<=4;i++){		 
			if($('#AllowSecurityUser'+i).is(':checked')){
				AllowSecurityUser +=  $('#AllowSecurityUser'+i).val() + ',';
			}
		}
		 
		if($('#SecurityStatus1').is(':checked')){
			UserSecurity = 1;
		}


               	$.ajax({
			type: "POST",
			url: "ajax_post.php",
			data:{
				action:'SecurityLevel', EnableSecurity:EnableSecurity, AllowSecurityUser:AllowSecurityUser, UserSecurity:UserSecurity
			}, 
		   	success: function(data){ 
				ShowHideLoader(1,'S');
	 			window.location.href = "dashboard.php";
				return data;
			}
		});
	

		$( this ).dialog( "close" );

        },
        "No": function() { 
		$( this ).dialog( "close" );

        }
      }
    });
	
	 
}



function SetAuthDiv(opt){
	if(opt==1){
		$('#AuthDiv').show(500);
	}else{
		$('#AuthDiv').hide(500);
	}
}
 
</script>


<div id="securitydialog-confirm" title="<?=$EnableSecurityTitle?>"></div>
<style>
 #dhtmltooltip{ 
	background-color: <?=$ToolColor?>;
}
</style>


<? }?>
