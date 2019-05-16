<div class="clear"></div>
<div class="had"> Industry :  <?=stripslashes($arryIndustry[0]['IndustryName'])?> 
</div>
 <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="10%" height="20"  class="head1" align="left">Account Name</td> 
                    <td width="10%" height="20"  class="head1" align="left">Account Number</td> 
                    <td width="10%" height="20"  class="head1" align="left">Range</td> 
                    <td width="5%" height="20"  class="head1" align="center">Account Type</td>
                </tr>
                <?php
					if(is_array($arryAccount) && $num>0){
					  $flag=true;
					  $Line=0;
				   foreach($arryAccount as $key=>$values){
					  $flag=!$flag;
					  $Line++;
                    	
                        ?>

            <tr align="left" bgcolor="<?= $bgcolor ?>">
			<td align="left"><?=stripslashes($values['AccountName'])?></td>
			<td align="left"><?=stripslashes($values['AccountNumber'])?></td>
			<td align="left"><?=stripslashes($values['RangeFrom']).'-'.stripslashes($values['RangeTo'])?></td>
			<td align="left"><?=stripslashes($values['AccountType'])?></td>
			
	
                     </tr>
                 <?php } // foreach end //?>
                  <?php }else{?>
		<tr align="center" >
			<td  colspan="6" class="no_record"><?=NO_RECORD?></td>
		</tr>

           <?php } ?>
    
		<tr ><td  colspan="6" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryAccount)>0){?>
		&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
		}?></td>
		</tr>
           
            </table>

