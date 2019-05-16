<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>









<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_vac'])) {echo $_SESSION['mess_vac']; unset($_SESSION['mess_vac']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td>
<a href="editVacancy.php" class="add">Add Vacancy</a>

<? if($num>0){?>
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_vacancy.php?<?=$QueryString?>';" />
	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>

<? if($_GET['key']!='') {?>
	<a href="viewVacancy.php" class="grey_bt">View All</a>
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
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','vacancyID','<?=sizeof($arryVacancy)?>');" /></td>-->
      <td width="15%"  class="head1" >Job Title</td>
      <td class="head1" >Vacancy Name</td>
     <td width="12%" class="head1" >Department</td>
     <td width="15%" class="head1" >Hiring Manager</td>
     <td width="12%" align="center" class="head1" > No of Position</td>
     <td width="6%" align="center" class="head1" >Hired</td>
      <td width="12%"  align="center" class="head1" >Posted Date</td>
      <td width="8%"  align="center" class="head1" >Status</td>
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryVacancy) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryVacancy as $key=>$values){
	$flag=!$flag;
	$Line++;
	
	 if($values['Status'] == "Approved") $stClass = 'green';
	 else if($values['Status'] == "Rejected") $stClass = 'red';
	 else $stClass = '';
  ?>
    <tr align="left"  >
      <!--<td ><input type="checkbox" name="vacancyID[]" id="vacancyID<?=$Line?>" value="<?=$values['vacancyID']?>" /></td>-->
      <td><?=stripslashes($values["JobTitle"])?></td>
      <td><?=stripslashes($values["Name"])?></td>
      <td><?=stripslashes($values["DepartmentName"])?></td>
      <td>
	  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['HiringManager']?>" ><?=stripslashes($values['UserName'])?></a>
	  </td>
        <td align="center"><?=$values["NumPosition"]?></td>
        <td align="center"><?=$values["Hired"]?></td>
        <td align="center">
		<? if($values['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?>
		</td>

         <td align="center" class="<?=$stClass?>"> <?=$values['Status']?>
		</td>
         <td  align="center"  class="head1_inner">
		 
	  <a class="fancybox fancybox.iframe" href="vacancyInfo.php?view=<?=$values['vacancyID']?>" ><?=$view?></a>
	 
	<a href="editVacancy.php?edit=<?=$values['vacancyID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	<a href="editVacancy.php?del_id=<?php echo $values['vacancyID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryVacancy)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryVacancy)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','vacancyID','editVacancy.php?curP=<?=$_GET['curP']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','vacancyID','editVacancy.php?curP=<?=$_GET['curP']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','vacancyID','editVacancy.php?curP=<?=$_GET['curP']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
