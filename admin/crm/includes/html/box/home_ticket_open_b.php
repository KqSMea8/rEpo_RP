<? //$arryTicket=$objLead->GetDashboardTicket(50); ?>
<div class="block" style="<?=$WidthRow2?>">
<?
echo '<select name="ticketType" id="ticketType" class="blockselect" onchange="Javascript:loadTicket();" >';
foreach($OptionArray as $opt){
	echo '<option value="'.$opt.'">'.$opt.'</option>';
}
echo '</select>';
?>
<h3><?=$BlockHeading?></h3>
<div class="bgwhite blockscroll" id="contentTicket" style="<?=$scrollStyle?>">
 </div>

		
          </div>
<script type="text/javascript">
function loadTicket(){
	var sendParam = 'ticketType='+ $("#ticketType").val() + '&action=ticketListing';
	$("#contentTicket").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#contentTicket").html(theResponse);
	});
}
loadTicket();
</script>

