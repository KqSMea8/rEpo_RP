<? #$arryActivity=$objActivity->GetActivityDeshboard('',50); ?>
            <div class="block" style="<?=(isset($WidthRow1)) ? $WidthRow1 : '';?>">


<?
echo '<select name="activityType" id="activityType" class="blockselect" onchange="Javascript:loadActivity();" >';
foreach($OptionArray as $opt){
	echo '<option value="'.$opt.'">'.$opt.'</option>';
}
echo '</select>';
?>

             <h3><?=$BlockHeading?></h3>
              <div class="bgwhite blockscroll" id="contentActivity" style="<?=$scrollStyle?>">
		
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
			<?php  
			
			if(isset($arryActivity) && sizeof($arryActivity)>0){
			$flag=true;
			$Line=0; 
			foreach($arryActivity as $key=>$Activity){
			$flag=!$flag;
			#$bgcolor=($flag)?("#FDFBFB"):("");
			$Line++;
			?>
                           
                           <? echo '<tr>
                              <td><a class="fancybox fancybox.iframe" href="vActivity.php?view='.$Activity['activityID'].'&pop=1&module=Activity&mode='.$Activity['activityType'].'">'.substr(stripslashes($Activity['subject']),0,50).' </a></td>
                             
                            </tr>'; ?>
                           
                           <? } ?>

			<tr>
                    		<td>
                         	<a href="viewActivity.php?module=Activity">More..</a>
                           </td>
                           </tr>
			<? } else{?>
                           <tr>
                                <td  colspan="2">
                           <font color="darkred" >No Activity Found.</font>
                           </td>
                           </tr>
                           <? }?>
                          
              </table>

            </div>
            </div>

<script type="text/javascript">
function loadActivity(){
	var sendParam = 'activityType='+ $("#activityType").val() + '&action=activityListing';
	$("#contentActivity").html('<img src="../images/ajaxloader.gif" class="load">');	
	$.post("ajax_block.php", sendParam, function(theResponse){
		$("#contentActivity").html(theResponse);
	});
}
loadActivity();
</script>
      
