<div id="location_div">
<? $arryLocationMenu = $objConfigure->getLocation('',1); 
$NumLocation = sizeof($arryLocationMenu); 
?>
	<form name="topForm" action="<?=$SelfPage?>" method="get">
	<br>
	<strong><?=SELECT_LOCATION?>:</strong>&nbsp; <? if($NumLocation>0) { ?>
		<select name="loc" class="inputbox" id="loc" >
			<? for($i=0;$i<sizeof($arryLocationMenu);$i++) {?>
			<option value="<?=$arryLocationMenu[$i]['locationID']?>" <?  if($arryLocationMenu[$i]['locationID']==$_SESSION['locationID']){echo "selected";}?>>
			<? echo stripslashes($arryLocationMenu[$i]['City']).", ".stripslashes($arryLocationMenu[$i]['State']).", ".stripslashes($arryLocationMenu[$i]['Country']); ?>
			</option>
			<? } ?>
		</select>
		<br><br>
		 <input name="ContinueButton" type="button" class="button" id="ContinueButton" value="Continue &raquo;" onclick="Javascript:ContinueToSection();"  />
	<? } else{ ?>	  
		<span class="red"><?=NO_LOCATION?></span>
	<? } ?>
		<input type="hidden" name="ContinueUrl" id="ContinueUrl" value="">
	</form>
</div>	

<script language="JavaScript1.2" type="text/javascript">
function SetContinueUrl(url){	
	document.getElementById("ContinueUrl").value = url;
}
function ContinueToSection(){	
	var url = document.getElementById("ContinueUrl").value;
	var loc = document.getElementById("loc").value;
	location.href = url+"?locationID="+loc;
}
</script>

