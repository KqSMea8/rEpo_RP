		<? require_once("includes/html/box/pop_loader.php"); ?>

	<? require_once("includes/html/".$SelfPage); ?>
		
<? 
$FooterStyle ='';
if($LoginPage!=1){ ?>	
	
		<? 
				echo '</div>';
				
				$RightFile = 'includes/html/box/right_'.$SelfPage;
				if(file_exists($RightFile)){
					include($RightFile);
				}else{	
					$SetInnerWidth=1;
				}
				
				if(!empty($SetInnerWidth)){			
					echo '<script>SetInnerWidthSuper();</script>';
				}
				
		
		 ?>
	
	</div>
	<div class="clear"></div>
 </div>
<? }else{ $FooterStyle = 'style="background:none"'; } ?>




  <? if($HideNavigation!=1){ ?>
  <div id="footer" class="footer-container clearfix" <?=$FooterStyle?>>
    	<div class="footer">
        	 <div class="copyright">Copyright &copy; <?=$arrayConfig[0]['SiteName']?>. All Rights Reserved. <br />Powered By: <span><a href="http://www.virtualstacks.com" target="_blank">Virtual Stacks</a></span></div>
        </div>
    </div>

	<div id="dialog-modal" style="display: none;"></div>
  <? } ?>

	
</div>

</body>
</HTML>

<SCRIPT LANGUAGE=JAVASCRIPT>
var MainPrefix = "";
$(document).ready(function () {	
	$("#ZipCode").on("click", function () { 
		autozipcode();
	});

	$("#ZipCode").on("blur", function () { 	
		SetCountyByZip();

	});	 
});

</SCRIPT>


<script language="javascript" src="includes/js/<?=$SelfPage?>.js"></script>


<script language="javascript1.2" type="text/javascript">

if(document.getElementById("load_div") != null){
	document.getElementById("load_div").style.display = 'none';

	var TitleBar = remove_tags($('.had')[0].innerHTML);
	/*TitleBar = TitleBar.replace("<span>",""); 
	TitleBar = TitleBar.replace("</span>",""); 
	TitleBar = TitleBar.replace("<SPAN>",""); 
	TitleBar = TitleBar.replace("</SPAN>",""); */
	window.document.title = TitleBar;
}
</script>

