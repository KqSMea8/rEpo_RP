 <div class="block" style="<?=$WidthRow2?>">


              <h3><?=$BlockHeading?></h3>
              <div class="bgwhite blockscroll" id="VendorRm" style="<?=$scrollStyle?>">
              
              </div>
            </div>

<script type="text/javascript">
function VendorRm(){

	var sendParam = 'action=VendorRm';
	$("#contentSale").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#VendorRm").html(theResponse);
	});
}
VendorRm();
</script>
