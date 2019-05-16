<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>








<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_training'])) {echo $_SESSION['mess_training']; unset($_SESSION['mess_training']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
		<tr>
	  <td>
<a href="editTraining.php" class="add">Add Training</a>

<? if($num>0){?>
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_training.php?<?=$QueryString?>';" />
	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>


<? if($_GET['sc']!='') {?>
  <a href="viewTraining.php" class="grey_bt">View All</a>
<? }?>
	  </td>
	  </tr>
	

	 
	<tr>
	  <td  valign="top">
	 
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','trainingID','<?=sizeof($arryTraining)?>');" /></td>-->
      <td width="10%" class="head1" >Training ID</td>
      <td width="20%"  class="head1" >Course Name</td>
      <td width="20%" class="head1" >Company</td>
      <td class="head1" >Coordinator</td>
      <td width="17%" class="head1"  align="center">Training Date</td>
      <td width="10%"  align="center" class="head1" >Status</td>
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryTraining) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryTraining as $key=>$values){
	$flag=!$flag;
	$Line++;

  ?>
    <tr align="left" >
      <!--<td ><input type="checkbox" name="trainingID[]" id="trainingID<?=$Line?>" value="<?=$values['trainingID']?>" /></td>-->
       <td><?=$values["trainingID"]?></td>
     <td><?=stripslashes($values["CourseName"])?></td>
      <td><?=stripslashes($values["Company"])?></td>
	 <td>
	<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['Coordinator']?>" ><?=stripslashes($values['CoordinatorName'])?></a>	 
	  
	  </td>
	 
	 <td align="center">  
	 <? if($values['trainingDate']>0){
	  echo date($Config['DateFormat'], strtotime($values['trainingDate'])); 
	} 
	 ?>
     </td> 

	<td align="center">  
	<? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editTraining.php?active_id='.$values["trainingID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
	   
	 ?> </td> 
	 
	
      <td  align="center"  class="head1_inner" >
	  <a href="vTraining.php?curP=<?=$_GET['curP']?>&view=<?=$values['trainingID']?>" ><?=$view?></a>
	  
		<a href="editTraining.php?curP=<?=$_GET['curP']?>&edit=<?=$values['trainingID']?>" ><?=$edit?></a>
		<a href="editTraining.php?curP=<?=$_GET['curP']?>&del_id=<?=$values['trainingID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
	
	  </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7" id="td_pager" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTraining)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryTraining)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','trainingID','editTraining.php?curP=<?=$_GET['curP']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','trainingID','editTraining.php?curP=<?=$_GET['curP']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','trainingID','editTraining.php?curP=<?=$_GET['curP']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   
</form>
</td>
	</tr>
</table>
