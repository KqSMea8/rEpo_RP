<? #$arryDEmail=$objConfig->ListImportEmailsDash(); ?>
<div class="block" style="<?=$WidthRow2?>">

<?
echo '<select name="emailType" id="emailType" class="blockselect" onchange="Javascript:loadEmail();" >';
foreach($OptionArray as $opt){
	echo '<option value="'.$opt.'">'.$opt.'</option>';
}
echo '</select>';
?>

<h3><?=$BlockHeading?></h3>
<div class="bgwhite blockscroll" id="contentEmail" style="<?=$scrollStyle?>">
              
              </div>

		
          </div>

<script type="text/javascript">
function loadEmail(){
	var sendParam = 'emailType='+ $("#emailType").val() + '&action=emailListing';
	$("#contentEmail").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#contentEmail").html(theResponse);
	});
}
function SetUnbold(elm){
	$(elm).css('font-weight', 'normal');
}

loadEmail();
</script>
