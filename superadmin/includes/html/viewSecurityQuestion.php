<div class="had">Manage Security Question</div>

				<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
				 
				<tr>
				  <td>
				
			 
				<a href="editSecurityQuestion.php" class="add">Add Security Question</a>
				<div class="message" align="center"><? if(!empty($_SESSION['mess_question'])) {echo $_SESSION['mess_question']; unset($_SESSION['mess_question']); }?></div>
				</td>
				  </tr>
				 
				<tr>
				  <td  valign="top">
				<div id="prv_msg_div" style="display:none">  </div>
				<div id="preview_div">
				
				<table <?=$table_bg?>>
				   
				    <tr align="left"  >
				      
				      <td class="head1" >Question</td>
				      <!--td class="head1" >Answer Column</td-->
				     
				      <td width="6%"  align="center" class="head1" >Status</td>
				      <td width="12%"  align="center" class="head1 head1_action" >Action</td>
				    </tr>
				   
				    <?php 
				    
				  if(is_array($arryQuestion) && $num>0){
				  $flag=true;
				$Line=0;
 
				  foreach($arryQuestion as $key=>$values){
				$flag=!$flag;
				$Line++;
				
				  ?>
				     <tr align="left"  bgcolor="<?=$bgcolor?>">
				     
				<td><?=stripslashes($values["Question"])?></td> 		 
				<!--td><? //GetOptionLabel(stripslashes($values["ColumnName"]),$OptionArray); ?></td-->
				    <td align="center">
				      <? 
				 if($values['Status'] ==1){
				  $status = 'Active';
				 }else{
				  $status = 'InActive';
				 }
				echo '<a href="editSecurityQuestion.php?active_id='.$values["QuestionID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
				   
				 ?>    </td>
				     <td  align="center" class="head1_inner" >
				<a href="editSecurityQuestion.php?edit=<?php echo $values['QuestionID'];?>&curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>
				
				<a href="editSecurityQuestion.php?del_id=<?php echo $values['QuestionID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confirmDialog(this, 'Question')" ><?=$delete?></a></td>
				    </tr>
				    <?php } // foreach end //?>
				  
				    <?php }else{?>
				    <tr align="center" >
				      <td  colspan="8" class="no_record"><?=NO_USER?> </td>
				    </tr>
				    <?php } ?>
				  
				 <tr >  <td  colspan="6" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryQuestion)>0){?>
				&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
				}?></td>
				  </tr>
				  </table>
				
				  </div> 
				   
				   </td>
				</tr>
				   </TABLE>
				   
  
