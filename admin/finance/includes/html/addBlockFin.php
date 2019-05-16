<script language="javascript1.2" type="text/javascript">
	$('#main_menu').hide();

	function validateBlock(frm) {
		$('#homeload').show();
		$('.had').hide();
		$('#dashboarddrag').hide();
		//parent.jQuery.fancybox.close();
		
	}

</script>
<div class="main-container clearfix">
    <div class="main">
	
<h4 class="had">Add Block To Workspace</h4>    
      
<link href="../includes/drag.css" rel="stylesheet" type="text/css">

<div align="center" id="homeload" style="display:none"><img src="../images/load.gif"></div>



  <form name="formBlock" action=""  method="post" onSubmit="return validateBlock(this);">
<div id="dashboarddrag" >
	<ul class="dragul addblockul">
<?
/****************************/
$Line=0;
foreach($arryBlock as $keyBlock=>$valueBlock){ 
	include("includes/html/box/block_condition_Fin.php");
	/**************/
	if($ShowBlock==1){
		$Line++;
		$BlockHeading = stripslashes($valueBlock['BlockHeading']);
		echo '<li id="recordsArray_'.$valueBlock['id'].'" class="dragli addblock">';
		echo '<input type="checkbox" class="checkid" name="idToShow[]" id="idToShow'.$Line.'" value="'.$valueBlock['id'].'">';
		echo '<div class="block"><h3 style="cursor:auto;">'.$BlockHeading.'</h3></div>';
		echo '</li>';
	}
	/**************/
}



if(!empty($BlockHeading)){
	echo '<div style="clear:both" ><input name="Submit" type="submit" class="bigbutton" id="SubmitButton" value=" Save "  onclick="javascript: return ValidateMultiple(\'block\', \'save\', \'NumField\', \'idToShow\');" />
  <input type="hidden" name="NumField" id="NumField" value="'.$Line.'">
</div>';
}else{	
	echo '<div class="redmsg" align="center">No blocks to add.</div>';
}
?>

	</ul>
</div>

</form>

        




    </div>
  </div>
  


