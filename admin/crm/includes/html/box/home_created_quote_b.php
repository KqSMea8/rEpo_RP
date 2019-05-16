<? #$arryQuote=$objQuote->GetDashboardQuote(50); 

?>
<div class="block" style="<?=(isset($WidthRow1)) ? $WidthRow1 : '';?>">




<? 
echo '<select name="quoteType" id="quoteType" class="blockselect" onchange="Javascript:loadQuote();" >';
foreach($OptionArray as $opt){
	echo '<option value="'.$opt.'">'.$opt.'</option>';
}
echo '</select>';
?>
<select name="quotestage" id="quotestage" class="blockselect" onchange="Javascript:loadQuote();" >
<option value="Created">Created</option>
<option value="Delivered">Delivered</option>
<option value="Reviewed">Reviewed</option>
<option value="Accepted">Accepted</option>
<option value="Rejected">Rejected</option>									
</select>

	<h3><?=$BlockHeading?></h3>

	<div class="bgwhite blockscroll" id="contentQuote" style="<?=$scrollStyle?>">
		</div>
</div>
<script type="text/javascript">
function loadQuote(){

	var sendParam = 'quoteType='+ $("#quoteType").val()+ '&quotestage='+ $("#quotestage").val() + '&action=quoteListing';
	$("#contentQuote").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#contentQuote").html(theResponse);
	});
}
loadQuote();
</script>
