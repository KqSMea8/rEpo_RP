<div class="had">Vendor </div>
<table width="100%"   border=0 align="center" cellpadding=0 cellspacing=0 >
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_ship'])) {  echo stripslashes($_SESSION['mess_ship']);   unset($_SESSION['mess_ship']);} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="20%" height="20"  class="head1">Name</td>      
                    <td width="20%" height="20"  class="head1">Email</td>  
                    <td  width="20%" height="20"  class="head1">State</td>
                    <td  height="20%" width="8%" class="head1" align="center">Country</td>
                    <td  height="20%" width="8%" class="head1" align="center"> Plan Type</td>
                    <td  height="20%" width="8%" class="head1" align="center"> Expired Date</td>
                    <td  height="20" width="7%" class="head1" align="center">Status</td>
                  <!--  <td width="3%"   height="20" align="center" class="head1">Action&nbsp;&nbsp;</td> -->
                </tr>
                <?php
           
                   if(count($getvendorByCompnayResult)>0){
					   
					  
					   
						/********Connecting to main database*********/
						//$Config['DbName'] = $Config['DbMain'];
						//$objConfig->dbName = $Config['DbName'];
						//$objConfig->connect();
                    foreach ($getvendorByCompnayResult as $key => $values) {
                             if(!empty($values['state'])){
								 
                                 $StateName = $objRegion->getAllStateName($values['state']);
								
							 }else{ 
							    $StateName  = "";	 
							 }
							 
							 if(!empty($values['country'])){
                          $arryCountryNam = $objRegion->GetCountryName($values['country']);
						 
                          $arryCountryName = $arryCountryNam[0]->name;
							 }else{
								 $arryCountryName =""; 
							 }
							
							 $ActivePlans=$ObjPlan->getVendorActivePlan($values['ref_id'],$cmpDb);
							
	                         $plandata  = unserialize($ActivePlans[0]->plandata);
							 
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                             <td height="26"><?php echo  $values['fname']." ".$values['lname'] ;?>     </td>
                              <td><?php echo  $values['user_name'] ;?>  </td>
                              <td><?php  echo $StateName;  ?></td>
                              <td align="center"><?php  echo $arryCountryName;  ?></td>
                              <td align="center"><?php if(count($ActivePlans)>0){ if($plandata['demo']==1) echo 'Trial'; else echo 'Paid'; }else{ "-"; }?> </td>
                              <td align="center"><?php 
							  if(count($ActivePlans)>0){
							  if($plandata['demo']==1){ 
							  
							          echo date('d,M Y',strtotime($ActivePlans[0]->expireDate));
							  }else{
								  
								    echo  date('d,M Y',strtotime($ActivePlans[0]->renewDate));
							  }
							  }else{
								  
								 echo "-"; 
							  }	  
									  
									  
									  ?>
							  
							  
							  
							  
							  </td>
                              <td align="center" ><?
                                            if ($values['status'] == 1) {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }


                                            echo $status;
                                            ?>
                            </td>
                         <!--   <td height="26" class="head1_inner" align="center"  valign="top">
                                   <a href="addvendor.php?edit=<?php echo $values['id']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                    <a href="vendor.php?del_id=<?php echo $values['id']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>-->
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="6"  class="no_record">No vendor found. </td>
                    </tr>
                <?php } ?>

                <tr>  
                    <td height="20" colspan="6" >
                        Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($getvendorByCompnayResult)> 0) { ?>
                            &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pageslink;
                }
                ?></td>
                </tr>
            </table>
        </td>
    </tr>

</table>
