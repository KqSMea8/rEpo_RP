<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>









<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_event'])) {echo $_SESSION['mess_event']; unset($_SESSION['mess_event']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	 
	<tr>
	  <td  valign="top">
	  
	
	  
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','vacancyID','<?=sizeof($arryVacancy)?>');" /></td>-->
      <td width="15%"  class="head1" >Event Type</td>
      <td class="head1" >Employee</td>
     <td width="20%"  align="center" class="head1" >Event Date</td>
    
    
      <td width="15%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryEvent) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEvent as $key=>$values){
	$flag=!$flag;
	$Line++;
	
	
  ?>
    <tr align="left"  >
      <!--<td ><input type="checkbox" name="vacancyID[]" id="vacancyID<?=$Line?>" value="<?=$values['vacancyID']?>" /></td>-->
      <td><?=stripslashes($values["EventType"])?></td>
      
      
      <td>
	  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=stripslashes($values['UserName'])?></a>
	  </td>
       
        <td align="center">
		<? if($values['EventType'] == 'Birthday'){ 
		   echo date($Config['DateFormat'], strtotime($values['date_of_birth']));
		?>
		<?} else if($values['EventType'] == 'Joinning') {
		   echo date($Config['DateFormat'], strtotime($values['JoiningDate']));
		?>
		<? } else { if($values['EventType'] == 'Wedding'){ 
		   echo date($Config['DateFormat'], strtotime($values['JoiningDate']));
		}
		}
		?>
		</td>

        
		</td>
         <td  align="center"  class="head1_inner">
		 <? if($values['EventType'] == 'Birthday'){ 
		   $Cat =1;
		?>
		<?} else if($values['EventType'] == 'Joinning') {
		   $Cat =2;
		?>
		<? } else { if($values['EventType'] == 'Wedding'){ 
		   $Cat =3;
		}
		}
		?>
	  <a  href="sendEventEmail.php?cat=<?=$Cat?>&EmpID=<?=$values['EmpID']?>" class="action_bt" >Send Email</a>
	 
	  </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="5" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryVacancy)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryVacancy)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','vacancyID','editVacancy.php?curP=<?=$_GET[curP]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','vacancyID','editVacancy.php?curP=<?=$_GET[curP]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','vacancyID','editVacancy.php?curP=<?=$_GET[curP]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
