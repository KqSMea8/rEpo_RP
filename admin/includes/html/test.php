<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD align="center" height="500">
	  <!-- <img src="images/erp.jpg" />-->
  
  <TABLE WIDTH="70%"   BORDER=0 align="center" CELLPADDING=20 CELLSPACING=10 >
	<TR>
<? for($i=0;$i<sizeof($arryDepartment);$i++) {

	$Department = strtolower($arryDepartment[$i]['Department']);
	
	$FullUrl = $Department.'/'.$arryDepartment[$i]['Link'];
?>
	<td width="50%" align="center">
		<div class="dashmenu">
		
		<a class="fancybox" href="#location_div" onclick="Javascript:SetContinueUrl('<?=$FullUrl?>');"><img src="../images/<?=$Department?>.jpg" border="0"><br /><?=$arryDepartment[$i]['Department']?></a> </div>
	</td>
  <? 	if (($i+1) % 3 == 0) {
			echo "</tr><tr>";
		}
  } ?>
  </TR>
	
</TABLE>
<a class="fancybox fancybox.iframe" href="iframe.php">Change Photo</a>





  <?  //include("includes/html/box/select_location.php"); ?>
 <!-- 
 <br><br>
 
	<a class="fancybox" href="#inline1" title="Lorem ipsum dolor sit amet">Inline</a></li>  
	<div id="inline1" style="width:400px;display: none;">
		<h3>Etiam quis mi eu elit</h3>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis mi eu elit tempor facilisis id et neque. Nulla sit amet sem sapien. Vestibulum imperdiet porta ante ac ornare. Nulla et lorem eu nibh adipiscing ultricies nec at lacus. Cras laoreet ultricies sem, at blandit mi eleifend aliquam. Nunc enim ipsum, vehicula non pretium varius, cursus ac tortor. Vivamus fringilla congue laoreet. Quisque ultrices sodales orci, quis rhoncus justo auctor in. Phasellus dui eros, bibendum eu feugiat ornare, faucibus eu mi. Nunc aliquet tempus sem, id aliquam diam varius ac. Maecenas nisl nunc, molestie vitae eleifend vel, iaculis sed magna. Aenean tempus lacus vitae orci posuere porttitor eget non felis. Donec lectus elit, aliquam nec eleifend sit amet, vestibulum sed nunc.
		</p>
	</div>
-->	
	
	  </TD>
  </TR>
	
</TABLE>


<script language="javascript1.2" type="text/javascript">
function ShowIframe(PdfSrc){
	document.getElementById("PdfIframe").src = PdfSrc;
	document.getElementById("FrameDiv").style.display = 'block';

}
</script>

<a class="fancybox" href="#FrameDiv" onclick="Javascript:ShowIframe('Radius2K.pdf');">Radius2K</a>
<br>
<a class="fancybox" href="#FrameDiv" onclick="Javascript:ShowIframe('readme.pdf');">readme</a>





<div style="display:none; width:900px;" id="FrameDiv">
	<iframe src="" id="PdfIframe" width="100%" style="height:500px"></iframe>
</div>

