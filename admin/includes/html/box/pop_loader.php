<div id="light_home" class="white_content" style="width:240px;" >
 <!--a href="Javascript:ShowHideLoader(0);"><img src="<?=$MainPrefix?>images/delete.gif" style="float:right"></a-->
 
 
	<div style="width:75px;float:left;padding:5px;"><img src="<?=$MainPrefix?>images/ajaxloader.gif"></div>
	
	<div style="width:155px;float:left;padding-top:15px;">
		<div id="PopLoader_L" style="display:none"><?=LOADER_MSG_L?></div>
		<div id="PopLoader_F" style="display:none"><?=LOADER_MSG_F?></div>
		<div id="PopLoader_S" style="display:none"><?=LOADER_MSG_S?></div>
		<div id="PopLoader_P" style="display:none"><?=LOADER_MSG_P?></div>
		<div id="PopLoader_ATT" style="display:none"><?=LOADER_MSG_ATT?></div>
	</div>
	
	
	
</div>

<div id="fade_home" class="black_overlay"></div>
 

<script language="javascript1.2" type="text/javascript">

function ShowHideLoader(opt,DivID){
	if(document.getElementById("footer") != null){
		if(opt==1){
			$("#PopLoader_L").hide();
			$("#PopLoader_F").hide();
			$("#PopLoader_S").hide();
			$("#PopLoader_P").hide();
			$("#PopLoader_ATT").hide();				


				$("#PopLoader_"+DivID).show();
				var FooterTop = FindYPosition(document.getElementById("footer"))+200;
				document.getElementById('fade_home').style.height = FooterTop+'px';

				document.getElementById('fade_home').style.width = '100%';
				
				document.getElementById('light_home').style.left = '40%';
				document.getElementById('light_home').style.top = '40%';
				$("#light_home").show();
				$("#fade_home").show();				
		}else{
			$("#light_home").hide();
			$("#fade_home").hide();	
		}

	}
	
}
</script>
