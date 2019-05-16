 <div class="block" style="<?=$WidthRow2?>">


              <h3><?=$BlockHeading?></h3>
              <div class="bgwhite blockscroll" id="contentSale" style="<?=$scrollStyle?>">
              
              </div>
            </div>

<script type="text/javascript">
function loadSales(){

	var sendParam = 'action=SalesOrder';
	$("#contentSale").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#contentSale").html(theResponse);
	});
}
loadSales();
</script>
