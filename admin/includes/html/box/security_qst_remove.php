<? if(!empty($arryCompany[0]['SecurityLevel']) && substr_count($arryCompany[0]['AllowSecurity'],"1") ){ 
	
	if($objConfigure->IsSecurityQstAnsExist($arryEmployee[0]['UserID'],'employee')){

 
	
 ?>
<script language="JavaScript1.2" type="text/javascript">
 
function securityQst(){
	
     var TitleText = "Do you want to remove Security Questions & Answers, <br>to Setup again in case of forgotten ?";
     var UserID = '<?=$arryEmployee[0]["UserID"]?>';
     var MainPrefix = '<?=$MainPrefix?>';
 
 
     $("#securityqst-confirm").html(TitleText);
     $("#securityqst-confirm" ).dialog({
      title: "Remove Security Questions & Answers",
      resizable: false,
      height:200,
      width:370,
      modal: true,
      buttons: {
        "Yes": function() { 
		var securitylevel = 'Yes';
 
               	$.ajax({
			type: "POST",
			url: MainPrefix+"ajax_post.php",
			data:{
				action:'RemoveSecurityQuestion',UserID:UserID
			}, 
		   	success: function(data){  				
				return data;
			}
		});
		$("#securityqstli").hide();

		$( this ).dialog( "close" );

        },
        "No": function() {
 
 		$( this ).dialog( "close" );


        }
      }
    });
	
	 
}


</script>


<div id="securityqst-confirm"></div>

<li id="securityqstli"><a href="Javascript:securityQst();">Remove Security Questions</a></li>

<? 
	}
} ?>
 
