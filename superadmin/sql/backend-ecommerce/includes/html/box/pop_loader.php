<div id="light_home" class="white_content" style="width:240px;" >
 <!--a href="Javascript:ShowHideLoader(0);"><img src="<?=$MainPrefix?>images/delete.gif" style="float:right"></a-->
 
 
	<div style="width:75px;float:left;padding:5px;"><img src="<?=$MainPrefix?>../images/ajaxloader.gif"></div>
	
	<div style="width:155px;float:left;padding-top:15px;">
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
			/*if(opt==2){
				opt = 1; 
				document.getElementById('PopLoader_P').innerHTML = '<?=LOADER_MSG_O?>';
			}*/

			if(opt==1){
					document.getElementById('PopLoader_L').style.display='none';
					document.getElementById('PopLoader_F').style.display='none';
					document.getElementById('PopLoader_S').style.display='none';
					document.getElementById('PopLoader_P').style.display='none';


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
