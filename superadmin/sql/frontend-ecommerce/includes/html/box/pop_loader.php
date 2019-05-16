<div id="light_home" class="white_content" style="width: 100%; text-align:center;display:none;" >

 
 
	<div style="text-align: center; width: 100%; padding: 7px;"><img src="../images/ajaxloader.gif"></div>
	
	<div style="">
		<div id="PopLoader_L" style="display:none"><?=LOADER_MSG_L?></div>
		<div id="PopLoader_F" style="display:none"><?=LOADER_MSG_F?></div>
		<div id="PopLoader_S" style="display:none"><?=LOADER_MSG_S?></div>
		<div id="PopLoader_P" style="display:none"><?=LOADER_MSG_P?></div>
                <div id="PopLoader_A" style="display:none"><?=LOADER_MSG_A?></div>
	</div>
	
	
	
</div>

<div id="fade_home" class="black_overlay"></div>


<script language="javascript1.2" type="text/javascript">

function ShowHideLoader(opt,DivID){
	if(document.getElementById("footer") != null){
			if(opt==1){
					document.getElementById('PopLoader_L').style.display='none';
					document.getElementById('PopLoader_F').style.display='none';
					document.getElementById('PopLoader_S').style.display='none';
					document.getElementById('PopLoader_P').style.display='none';
                                        document.getElementById('PopLoader_A').style.display='none';


					document.getElementById('PopLoader_'+DivID).style.display='block';
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
