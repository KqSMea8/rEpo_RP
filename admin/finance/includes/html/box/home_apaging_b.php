 <div class="block" style="<?=$WidthRow2?>">


              <h3><?=$BlockHeading?></h3>
              <div class="bgwhite blockscroll" id="contentApAging" style="<?=$scrollStyle?>">
              
              </div>
            </div>

<script type="text/javascript">
function loadApAging(){

	var sendParam = 'action=ApAging';
	$("#contentSale").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#contentApAging").html(theResponse);
	});
}
loadApAging();
</script>
