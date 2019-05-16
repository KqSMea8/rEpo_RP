<link href="<?=$Prefix."css/dashboard.css"?>" rel="stylesheet" type="text/css">

<? 
	function GetClassName($Module){
		$Module = str_replace("&","",$Module);
		$Module = str_replace(" ","_",$Module);
		$Module = str_replace("(","",$Module);
		$Module = str_replace(")","",$Module);
		$Module = str_replace("{","",$Module);
		$Module = str_replace("}","",$Module);
		$Module = str_replace("/","",$Module);
		$Module = str_replace("'","",$Module);

		$Module = preg_replace('/[.,~:>-]/', '_', $Module);
		$Module = strtolower($Module);

		return $Module;
	}


	$arryDashboardIcon = $objConfigure->DashboardIcon($CurrentDepID);
	if(sizeof($arryDashboardIcon)>0){
?>
 <ul class="dashboardul">
 <?	foreach($arryDashboardIcon as $key=>$values){ 
	
		if($values['IframeFancy']=="i"){
			$Iframe = "fancybox fancybox.iframe";
		}else if($values['IframeFancy']=="f"){
			$Iframe = "fancybox";
		}else{
			$Iframe = "";
		}

		($values['Link']=="puching.php")?($Iframe .= " punch"):(""); 


		#$className = GetClassName(stripslashes($values['Module']));
		$className = "icon".$values['IconType'];
	?>
		<li class="<?=$className?>"><a class="<?=$Iframe?>" href="<?=$values['Link']?>"><?=stripslashes($values['Module'])?></a></li>
	 <? } ?>

</ul>
<? } ?>




<!--ul class="dashboardul">
	  <? if($ShowEmp==1){ ?>
		<li class="asign_leave"><a href="applyLeave.php">Apply For Leave</a></li>
		<li class="leave_list"><a href="myLeave.php">Leave List</a></li>
		<li class="timesheets"><a href="myTimesheet.php">My Timesheet</a></li>
		<li class="timesheets"><a href="myAttendence.php">My Attendance</a></li>
		<li class="timesheets"><a class="punch fancybox fancybox.iframe" href="puching.php" >Punch In/Out</a></li>
	  <? }else{ ?>
		<li class="icon0"><a href="assignLeave.php">Assign Leave</a></li>
		<li class="icon1"><a href="viewEmployee.php">Employees</a></li>
		<li class="icon2"><a href="viewLeave.php">Manage Leave</a></li>
		<li class="icon3"><a href="viewTimesheet.php">Timesheet</a></li>
		<li class="icon4"><a href="viewAttendence.php">Attendance</a></li>
		<li class="icon5"><a href="viewCandidates.php">Candidate</a></li>
	  <? } ?>
</ul-->



<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".punch").fancybox({
			'width'         : 500
		 });

});

</script>