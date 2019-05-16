<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_part'])) {echo $_SESSION['mess_part']; unset($_SESSION['mess_part']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
        <td align="left">

<a href="#select_training" onclick="Javascript:ShowTrainingList();" class="fancybox red_bt" style="margin:0px;">Select Training</a>

	</td>
 </tr>
 


<? if($_GET["t"]>0){ ?>	
	
	<tr>
        <td>
		
		<? require_once("includes/html/box/training_box.php");  ?>
		
		</td>
      </tr>









	<tr>
        <td align="right" >
	<a href="editParticipant.php?t=<?=$_GET["t"]?>" class="fancybox add" >Add Participant</a>
		
	 <? if($num>0){?>
		<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
		

		
		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	 
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','partID','<?=sizeof($arryParticipant)?>');" /></td>-->
      <td width="10%" class="head1" >Training ID</td>
      <td width="18%"  class="head1" >Employee Name</td>
      <td width="12%" class="head1" >Department</td>
      <td width="20%" class="head1" >Designation</td>
      <td class="head1"align="center" >Feedback</td>
      <td width="5%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryParticipant) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryParticipant as $key=>$values){
	$flag=!$flag;
	$Line++;
	if(empty($values["Feedback"])) $values["Feedback"] = 'N.A.';

	
  ?>
    <tr align="left" >
      <!--<td ><input type="checkbox" name="partID[]" id="partID<?=$Line?>" value="<?=$values['partID']?>" /></td>-->
       <td><?=$values["trainingID"]?></td>
     <td>	<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=stripslashes($values['UserName'])?></a>	 
</td>
	 <td><?=stripslashes($values["Department"])?></td>
	 <td><?=stripslashes($values["JobTitle"])?></td>
	 <td align="center"><div id="FeedDiv<?=$values['partID']?>"><?=nl2br(stripslashes($values["Feedback"]))?></div>

		<?  if($ModifyLabel==1){ 
				echo '<div class="head1_inner" ><a href="#feedback_form_div" class="fancybox" onclick="Javascript:SetFeedbackForm('.$values['partID'].');">'.$edit.'</a></div>';
			}
		?>

	 </td>

      <td  align="center"  class="head1_inner" >
		<a href="editParticipant.php?t=<?=$_GET['t']?>&del_id=<?=$values['partID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
	
	  </td>
    </tr>
    <?php } // foreach end //?>
  
 <tr  >  <td height="20" colspan="6" id="td_pager">
Total Record(s) : &nbsp;<?php echo $num;?>  
</td>
  </tr>

    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_PARTICIPANT?></td>
    </tr>
    <?php } ?>
  

  </table>

  </div> 
 
  
   
</form>
</td>
	</tr>
<? } ?>
</table>


<? 
	include("includes/html/box/select_training.php");
	include("includes/html/box/training_feedback.php");
	//include("includes/html/box/add_participant.php");
?>