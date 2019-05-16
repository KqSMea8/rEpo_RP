
        <table cellspacing="0" cellpadding="5" border="0" width="100%" class="borderall">
            
            <tbody>
                <tr>
                <td align="left" class="head_info" colspan="8">Payment View</td>
            </tr>
          <?php  if(!empty($arryOrderHis)){
                        
                        foreach($arryOrderHis as $val){
                                $num++;
             
 $totalAmount = $val->amount + $val->DocCost + $val->PageCost + $val->VideoCost + $val->VideoSizeCost + $val->UserCost;
                                ?>
         
                     <tr>
                         
                        <td align="right" valign="top" class="blackbold">Plan Amount : </td>
                        <td align="left" style="width:100px" colspan="2">$<?= $val->amount; ?></td>
                        <td align="right" valign="top" class="blackbold">Payment Date : </td>
                        <td align="left" style="width:100px" colspan="2"><?= date("Y-m-d", strtotime($val->recordInsertedDate)); ?></td> 
                    </tr>
                    <tr>    
                       
                        <td align="right" valign="top" class="blackbold">Extra Document Amount : </td>
                        <td align="left" style="width:100px" colspan="2">$<?= $val->DocCost; ?></td>  
                        <td align="right" valign="top" class="blackbold">Extra Document : </td>
                        <td align="left" style="width:100px" colspan="2"><?= $val->extraDoc; ?></td>  
                    </tr>
                    <tr>    
                          
                        <td align="right" valign="top" class="blackbold">Extra Page Amount  : </td>
                        <td align="left" style="width:100px" colspan="2">$<?= $val->PageCost; ?></td>
                        <td align="right" valign="top" class="blackbold">Extra Page  : </td>
                        <td align="left" style="width:100px" colspan="2"><?= $val->extraPage; ?> </td>    
                    </tr>
                    <tr>    
                       <td align="right" valign="top" class="blackbold">Extra Video Amount : </td>
                        <td align="left" style="width:100px" colspan="2">$<?= $val->VideoCost; ?> </td>
                         <td align="right" valign="top" class="blackbold">Extra Video : </td>
                        <td align="left" style="width:100px" colspan="2"><?= $val->extraVideo; ?> </td>
                   </tr>
                  <tr>
                        <td align="right" valign="top" class="blackbold">Extra Video Size Amount : </td>
                        <td align="left" style="width:100px" colspan="2">$<?= $val->VideoSizeCost; ?></td>
                       <td align="right" valign="top" class="blackbold">Extra Video Size  : </td>
                        <td align="left" style="width:100px" colspan="2"><?= $val->extraVideoSize; ?></td>
                 </tr>
                 <tr>
                         <td align="right" valign="top" class="blackbold">Extra User Amount   : </td>
                        <td align="left" style="width:100px" colspan="2">$<?= $val->UserCost; ?></td> 
                        <td align="right" valign="top" class="blackbold">Extra User  : </td>
                        <td align="left" style="width:100px" colspan="2"><?= $val->extraUser; ?></td> 
                    </tr>
                    <tr>    
                            
                        <td align="right" valign="top" class="blackbold">Total : </td>
                        <td align="left" style="width:100px" colspan="2">$<?= $totalAmount; ?></td>
                    </tr>
                        <?php }}?>
          </tbody></table>
    
