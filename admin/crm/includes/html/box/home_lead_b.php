<?
#$arryMyLead=$objLead->GetDashboardLead(50);
?>
<div class="block"  style="<?=$WidthRow1?>;">
<?
echo '<select name="leadType" id="leadType" class="blockselect" onchange="Javascript:loadLead();" >';
foreach($OptionArray as $opt){
	echo '<option value="'.$opt.'">'.$opt.'</option>';
}
echo '</select>';
?>	


<h3><?=$BlockHeading?></h3>
<div class="bgwhite blockscroll" id="contentLead" style="<?=$scrollStyle?>">
</div>
</div>

<script type="text/javascript">
function loadLead(){
	var sendParam = 'leadType='+ $("#leadType").val() + '&action=leadListing';
	$("#contentLead").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#contentLead").html(theResponse);
	});
}
loadLead();
</script>
