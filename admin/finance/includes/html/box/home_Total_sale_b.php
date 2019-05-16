 

 <div class="block" style="<?=$WidthRow2?>">





              <h3><?=$BlockHeading?></h3>
              <div class="bgwhite blockscroll" id="contentCamp" style="<?=$scrollStyle?>">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <?php  
	if(!empty($arryCompaign)){
		$flag=true;
		$Line=0;
		foreach($arryCompaign as $key=>$Compaign){
		$flag=!$flag;
		#$bgcolor=($flag)?("#FDFBFB"):("");
		$Line++;
		?>
                <tr>
                  <td><b>Total Sales Value  :</b>  <?=(stripslashes($Compaign['TotalOrder']))?> <?=(stripslashes($Compaign['CustomerCurrency']))?></td>
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

	var sendParam = 'action=SalesListing';
	$("#contentCamp").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#contentCamp").html(theResponse);
	});
}
loadCamp();
</script>

