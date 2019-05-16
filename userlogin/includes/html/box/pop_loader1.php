<div id="light_home" class="white_content" style="width:230px;padding:5px;" >
 <!--a href="Javascript:ShowHideLoader(0);"><img src="<?=$MainPrefix?>images/delete.gif" style="float:right"></a-->
 
 
	<div style="width:80px;float:left"><img src="<?=$MainPrefix?>images/ajaxloader.gif"></div>
	
	<div style="float:left;padding-top:15px;">
		<div id="PopLoader_L" style="display:none"><?=LOADER_MSG_L?></div>
		<div id="PopLoader_F" style="display:none"><?=LOADER_MSG_F?></div>
		<div id="PopLoader_S" style="display:none"><?=LOADER_MSG_S?></div>
		<div id="PopLoader_P" style="display:none"><?=LOADER_MSG_P?></div>
	</div>
	
	
	
</div>

<div id="fade_home" class="black_overlay"></div>


<script language="javascript1.2" type="text/javascript">

function ShowHideLoader(opt,DivID){
	
	if(document.getElementById("footer") != null){
			if(opt==1){
					document.getElementById('PopLoader_'+DivID).style.display='block';

					/****** these function are defined in global.js *****
					var arrayPageSize = getPageBodySize();
					var arrayPageScroll = getPageBodyScroll();
					/*PopLeft = (arrayPageSize[0] / 2)-465;
					PopTop = arrayPageScroll[1] + (arrayPageSize[3] / 2) - 50;*/

					/*
					var PopUpWidth = 450;
					var PopUpHeight = 400;
					PopTop = arrayPageScroll[1] + ((arrayPageSize[3] - 35 - PopUpHeight) / 2);
					PopLeft = (arrayPageSize[0] - 20 - PopUpWidth) / 2;
					
					PopTop = 250;
					var ScreenWidth = screen.width-18;
					/******************/
					
					var FooterTop = FindYPosition(document.getElementById("footer"))+200;
					document.getElementById('fade_home').style.height = FooterTop+'px';

					document.getElementById('fade_home').style.width = '100%';
					
					document.getElementById('light_home').style.left = '40%';
					document.getElementById('light_home').style.top = '40%';



					document.getElementById('light_home').style.display='block';
					document.getElementById('fade_home').style.display='block';
			}else{
				document.getElementById('light_home').style.display='none';
				document.getElementById('fade_home').style.display='none';
			}

	}


}
</script>
