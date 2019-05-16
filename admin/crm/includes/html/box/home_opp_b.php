<? //$arryTopOpp = $objLead->GetDashboardOpportunity(50);
  $arrySalesStage = $objCommon->GetCrmAttribute('SalesStage', '');
 ?>
             <div class="block" style="<?=(isset($WidthRow2)) ? $WidthRow2 : '';?>">   

	<?
echo '<select name="oppType" id="oppType" class="blockselect" onchange="Javascript:loadOpp();" >';
foreach($OptionArray as $opt){
	echo '<option value="'.$opt.'">'.$opt.'</option>';
}
echo '</select>';

echo '<select name="SalesStage" id="SalesStage" class="blockselect" onchange="Javascript:loadOpp();" >';
for($i=0;$i<sizeof($arrySalesStage);$i++) {
	echo '<option value="'.$arrySalesStage[$i]['attribute_value'].'">'.$arrySalesStage[$i]['attribute_value'].'</option>';
}
echo '</select>';
?>	
          
<h3><?=$BlockHeading?></h3>

<div class="bgwhite blockscroll" id="contentOpp" style="<?=$scrollStyle?>">
</div>


 </div>
 <script type="text/javascript">
function loadOpp(){
	var sendParam = 'oppType='+ $("#oppType").val() + '&SalesStage='+ $("#SalesStage").val() + '&action=oppListing';
	$("#contentOpp").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#contentOpp").html(theResponse);
	});
}
loadOpp();
</script>
