<? //$arryCompaign=$objLead->GetDashboardCompaign(50); ?>

 <div class="block" style="<?=(isset($WidthRow2)) ? $WidthRow2 : '';?>">

<? 
echo '<select name="campType" id="campType" class="blockselect" onchange="Javascript:loadCamp();" >';
foreach($OptionArray as $opt){
	echo '<option value="'.$opt.'">'.$opt.'</option>';
}
echo '</select>';
?>



              <h3><?=$BlockHeading?></h3>
              <div class="bgwhite blockscroll" id="contentCamp" style="<?=$scrollStyle?>">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <?php  
	if(isset($arryCompaign) && sizeof($arryCompaign)>0){
		$flag=true;
		$Line=0;
		foreach($arryCompaign as $key=>$Compaign){
		$flag=!$flag;
		#$bgcolor=($flag)?("#FDFBFB"):("");
		$Line++;
		?>
                <tr>
                  <td><a class="fancybox fancybox.iframe"  href="vCampaign.php?view=<?=$Compaign['campaignID']?>&module=Campaign&pop=1"><?=substr(stripslashes($Compaign['campaignname']),0,50)?></a></td>
                </tr>
<? }?>

<tr>
                  <td><a href="viewCampaign.php?module=Campaign">More..</a></td>
                </tr>

<?}else{?>
                <tr>
                  <td><font color="darkred" >No Compaign Found.</font></td>
                </tr>
<? }?>
          
                
              </table>

              </div>
            </div>

<script type="text/javascript">
function loadCamp(){

	var sendParam = 'campType='+ $("#campType").val()+ '&action=campListing';
	$("#contentCamp").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#contentCamp").html(theResponse);
	});
}
loadCamp();
</script>

