<div class="first_col" style="display:block;<?=$WidthRow1?>">
            <div class="block status_updates">
              <h3>Task and Activities</h3>
              <div class="bgwhite" >
		
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
			<?php  
			$arryActivity=$objActivity->GetActivityDeshboard('');

			if(sizeof($arryActivity)>0){
			$flag=true;
			$Line=0; 
			foreach($arryActivity as $key=>$Activity){
			$flag=!$flag;
			#$bgcolor=($flag)?("#FDFBFB"):("");
			$Line++;
			?>
                           
                           <? echo '<tr>
                              <td><a href="vActivity.php?view='.$Activity['activityID'].'&curP=1&module=Activity&mode='.$Activity['activityType'].'">'.substr(stripslashes($Activity['subject']),0,35).' </a></td>
                             
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
          </div> 
