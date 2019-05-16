 <div class="block" style="<?=$WidthRow2?>">


              <h3><?=$BlockHeading?></h3>
              <div class="bgwhite blockscroll" id="ArAging" style="<?=$scrollStyle?>">
              
              </div>
            </div>

<script type="text/javascript">
function loadArAging(){

	var sendParam = 'action=ArAging';
	$("#ArAging").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#ArAging").html(theResponse);
	});
}
loadArAging();
</script>
