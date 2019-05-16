<? 
$agent= $_SERVER['HTTP_USER_AGENT'];
$ie = strpos($agent, 'MSIE') ? true : false;

$ie = 0; //remove this

if($ie){ // For Internet Exploree
	/******************************/
	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$TodayDate);

	$arryTime2 = explode(":",$arryTime[1]);

?>

<!--<SCRIPT LANGUAGE="JavaScript">var clocksize=100;</SCRIPT>
<SCRIPT SRC="http://gheos.net/js/clock.js"></SCRIPT>-->

<div id="clockdiv" style="float:right;">
	<input type="text" class="textbox" style="width:96px;"  maxlength="10" name="DateBox" id="DateBox" value="<?=$arryTime[0]?>" readonly=""> 
	
	<input type="text" class="textbox"   maxlength="2" name="HourBox" id="HourBox" value="<?=$arryTime2[0]?>" readonly=""> : 
	<input type="text" class="textbox"  maxlength="2" name="MinBox" id="MinBox" value="<?=$arryTime2[1]?>" readonly=""> : 
	<input type="text" class="textbox"  maxlength="2" name="SecBox" id="SecBox" value="<?=$arryTime2[2]?>" readonly=""> 
</div>

<SCRIPT LANGUAGE=JAVASCRIPT>
StartTimer();
function StartTimer(){

	var CurrentDate = document.getElementById("DateBox").value;
	var today = new Date(CurrentDate);
	var tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000));

	var TomYear = tomorrow.getFullYear();
	var TomMonth = parseInt(tomorrow.getMonth())+1;
	var TomDay = tomorrow.getDate();

	if(TomMonth<10){ TomMonth = '0'+TomMonth; }
	if(TomDay<10){ TomDay = '0'+TomDay;}

	var NextDay = TomYear+'-'+TomMonth+'-'+TomDay;
	
	/***********************/

	var Hour = parseInt(document.getElementById("HourBox").value);
	var Minute = parseInt(document.getElementById("MinBox").value);
	var Second = parseInt(document.getElementById("SecBox").value);
	
	if(Second!='' && !isNaN(Second)){
		var Second = parseInt(Second) + 1;
	}else{
		var Second = 1;
	}

	if(Second>59){
		Minute = parseInt(Minute) + 1;
		Second = 0;
	}

	if(Minute>59){
		Hour = parseInt(Hour) + 1;
		Minute = 0;
	}

	if(Hour>23){
		Hour = 0;
	}
	
	/*
	if(Hour > 12){
        Hour = (Hour - 12);
        var ampm = "PM";
    }
    else{
        var ampm = "AM";
    }*/





	if(Second<10){ Second = '0'+Second; }
	if(Minute<10){ Minute = '0'+Minute;}
	if(Hour<10) Hour = '0'+Hour;

	document.getElementById("HourBox").value = Hour;
	document.getElementById("MinBox").value = Minute;
	document.getElementById("SecBox").value = Second;

	//document.getElementById("ampm").value = ampm;

	if(Hour=='00' && Minute=='00' && Second=='00'){
		document.getElementById("DateBox").value = NextDay;
	}

	window.setTimeout(StartTimer,1000);
}
</SCRIPT>


<?


}else{ // For Other Browser


/******************************/
$arryZone = explode(":",$arryCurrentLocation[0]['Timezone']);
$Symbol = substr($arryZone[0], 0,1);
$TimeZoneHour = (int)ltrim($arryZone[0],$Symbol);
$TimeZoneMin = $arryZone[1]/60;
$FinalOffset = $Symbol.($TimeZoneHour+$TimeZoneMin);


if($SelfPage=='home.php' || $SelfPage=='home1.php' || $SelfPage=='workspace.php')$SupPrefx='../';



?>
<link rel="stylesheet" type="text/css" href="<?=$SupPrefx?>clockbig/css/analog.css"> 
<script src="<?=$SupPrefx?>clockbig/js/jquery.js" type="text/javascript"></script>
<script src="<?=$SupPrefx?>clockbig/js/jquery.clock.js" type="text/javascript"></script>


<SCRIPT LANGUAGE=JAVASCRIPT>
var d = new Date();
var str = d.getTimezoneOffset()/ 60;
var offset = str.toString(); 
if(str<0){ 
	var FinalOffset = offset.replace("-", "+"); 
}else{ 
	var FinalOffset = offset.replace("+", "-"); 
}

</SCRIPT>

<script type="text/javascript">
var jq = $.noConflict();
 jq(document).ready(function() {
   jq('#analog-clock').clock({offset: '<?=$FinalOffset?>', type: 'analog'});
 });
</script>


<ul id="analog-clock" class="analog" <?=$analogStyle?>>	
	<li class="hour"></li>
	<li class="min"></li>
	<li class="sec"></li>
	<li class="meridiem"></li>
</ul>

<? } ?>
