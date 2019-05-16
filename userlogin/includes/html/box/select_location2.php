<div id="location_div">
<? $arryLocationMenu = $objConfigure->getLocation('',1); 
$NumLocation = sizeof($arryLocationMenu); 
?>

	<strong><?=SELECT_LOCATION?>:</strong><br> <? if($NumLocation>0) { ?>
		
			<? for($i=0;$i<sizeof($arryLocationMenu);$i++) {?>
			<a href="Javascript:void(0)" onclick="Javascript:ContinueToSection(<?=$arryLocationMenu[$i]['locationID']?>);" <?  if($arryLocationMenu[$i]['locationID']==$_SESSION['locationID']){echo "selected";}?>>
			<? echo stripslashes($arryLocationMenu[$i]['City']).", ".stripslashes($arryLocationMenu[$i]['State']).", ".stripslashes($arryLocationMenu[$i]['Country']); ?>
			</a>
			<br>
			<? } ?>
		
	
	<? } else{ ?>	  
		<span class="red"><?=NO_LOCATION?></span>
	<? } ?>
		<input type="hidden" name="ContinueUrl" id="ContinueUrl" value="">
</div>	

<script language="JavaScript1.2" type="text/javascript">
function SetContinueUrl(url){	
	document.getElementById("ContinueUrl").value = url;
}
function ContinueToSection(loc){	
	var url = document.getElementById("ContinueUrl").value;
	location.href = url+"?locationID="+loc;
}
</script>

