<?
 $arryMyLead=$objLead->GetDashboardLead();

  $arryMyLeadCount =$objLead->GetDashboardLeadCount();
 // pr($arryMyLeadCount,1);
?>
<div class="first_col" style="<?=$WidthRow1?>">
            <div class="block p_l_request"> 
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
        $count =0;
       // pr($arryMyLead,1);
				foreach($arryMyLead as $key=>$lead){
				$flag=!$flag;
				#$bgcolor=($flag)?("#FDFBFB"):("");
				$Line++;
     

        if($lead['view_status'] != 1){
           $count ++;
          $image= '<img style="width: 37px;" src="../images/new-ani.gif" class="close_call"> ';
        }else {
          $image='';
        }
				$LeadName = stripslashes($lead['FirstName']).' '.stripslashes($lead['LastName']);


		?>
                            <tbody>
                           <? echo '<tr class="even">
                              <td>'.$image.'<a href="vLead.php?view='.$lead['leadID'].'&curP=1&module=lead">'.substr($LeadName,0,20).'</a></td>
                              <td ><a href="vLead.php?view='.$lead['leadID'].'&curP=1&module=lead">'.$lead['type'].'</a></td>
                            </tr>'; ?>
                          
                           <? } ?> 

                             <tr>
                              <?php 
                            $totalCount = $arryMyLeadCount[0]['leadCount']-$count ; 

                            if($totalCount > 6){
                           ?>

                           <td  colspan="2">

                            <span style="color:red; "><?= $totalCount ;   ?></span>
                           <a href="viewLead.php?module=lead">More..</a>
                           </td>

                           <?php } ?>

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
          </div>
