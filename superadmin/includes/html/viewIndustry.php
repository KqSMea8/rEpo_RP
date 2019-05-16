 
    <div class="clear"></div> 
    <div class="had">Manage Industry</div>
    <div class="message" align="center">
  <? if(!empty($_SESSION['mess_industry'])) {echo $_SESSION['mess_industry']; unset($_SESSION['mess_industry']); }?>
    </div>
  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_industry'])) {
    echo stripslashes($_SESSION['mess_industry']);
    unset($_SESSION['mess_industry']);
} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editIndustry.php" class="add">Add Industry</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="10%" height="20"  class="head1" align="left">Industry Name</td> 
                    <td width="20%" height="20"  class="head1" align="left">Description</td> 
                    <td width="5%" height="20"  class="head1" align="center">Status</td>
                    <td width="5%"   height="20"  class="head1" align="center">Action</td>
                </tr>
                <?php
                    	
                    if(is_array($arryIndustry) && $num>0){
					$flag=true;
					$Line=0;
					foreach($arryIndustry as $key=>$values){
					$flag=!$flag;
					$Line++;
					
                        ?>

            <tr align="left" bgcolor="<?= $bgcolor ?>">
			<td align="left"><?=stripslashes($values['IndustryName'])?></td>
			<td align="left"><?=stripslashes($values['Description'])?></td>
			<td align="center">
			<? 
			if($values['Status'] ==1){
			  $status = 'Active';
			}else{
			  $status = 'InActive';
			}
			echo '<a href="editIndustry.php?active_id='.$values["IndustryID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
			?></td>

			
			<td  align="center" class="head1_inner" >
			<?php if($values['IndustryID']>100){?>
			
			<a href="editIndustry.php?edit=<?php echo $values['IndustryID'];?>&curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>
            
			<a href="editIndustry.php?del_id=<?php echo $values['IndustryID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confirmDialog(this, 'Industry')" ><?=$delete?></a><br/>
			
			<?php }?>
			<a class="fancybox fancybox.iframe" href="accountInfo.php?view=<?php echo $values['IndustryID'].'@'.$values['Parent'];?>" >GL Accounts</a>
			 
			</td>

                     </tr>
                 <?php } // foreach end //?>
           <?php }else{?>
		<tr align="center" >
			<td  colspan="6" class="no_record"><?=NO_RECORD?></td>
		</tr>

           <?php } ?>
    
		<tr ><td  colspan="6" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryIndustry)>0){?>
		&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
		}?></td>
		</tr>
            </table>
        </td>
    </tr>
</table>
        

  
