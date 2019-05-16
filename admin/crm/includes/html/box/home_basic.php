<div class="block p_l_request"  style="<?=$WidthRow1?>;">
<h3>New Lead</h3>
<div class="bgwhite">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                <tr class="head"> 	
                  <td class="darkcolor">Lead Name</td>
                  <td class="darkcolor">Lead Type</td>
                </tr>
                </thead>
            <?php  
			if(sizeof($arryMyLead)>0){
				$flag=true;
				$Line=0;
				foreach($arryMyLead as $key=>$lead){
				$flag=!$flag;
				#$bgcolor=($flag)?("#FDFBFB"):("");
				$Line++;

				$LeadName = stripslashes($lead['FirstName']).' '.stripslashes($lead['LastName']);


		?>
                            <tbody>
                           <? echo '<tr class="even">
                              <td><a href="vLead.php?view='.$lead['leadID'].'&curP=1&module=lead">'.substr($LeadName,0,20).'</a></td>
                              <td ><a href="vLead.php?view='.$lead['leadID'].'&curP=1&module=lead">'.$lead['type'].'</a></td>
                            </tr>'; ?>
                          
                           <? } ?> 

                             <tr>
                           <td  colspan="2">
                           <a href="viewLead.php?module=lead">More..</a>
                           </td>
                           </tr> 
						   
                         
                     <? } else{?>
                           <tr>
                                <td  colspan="2">
                           <font color="darkred" >No Data Found.</font>
                           </td>
                           </tr>
                           <? }?>
                           
              </table>
</div>
</div>
