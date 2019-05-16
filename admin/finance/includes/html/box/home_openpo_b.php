 <div class="block" style="<?=$WidthRow2?>">


              <h3><?=$BlockHeading?></h3>
              <div class="bgwhite blockscroll" id="contentopenpo" style="<?=$scrollStyle?>">
              
              </div>
            </div>

<script type="text/javascript">
function loadopenpo(){

	var sendParam = 'action=openpo';
	$("#contentSale").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#contentopenpo").html(theResponse);
	});
}
loadopenpo();
</script>
