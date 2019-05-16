<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>









<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_candidate'])) {echo $_SESSION['mess_candidate']; unset($_SESSION['mess_candidate']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	
	
	<tr>
        <td  >
		

<? if($module=="Manage"){?>
	<a href="<?=$AddUrl?>" class="add">Add Candidate</a>
	<a href="addCnd.php" class="fancybox add_quick fancybox.iframe"><?=QUICK_ENTRY?></a>
<? }?>

<? if($num>0){?>
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_cand.php?<?=$QueryString?>';" />
	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>


<? if($_GET['key']!='') {?>
	<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
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
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CanID','<?=sizeof($arryCandidate)?>');" /></td>-->
      <td width="14%"  class="head1" >Candidate Name</td>
      <td  class="head1" >Email</td>
      <td width="15%" class="head1" >Contact Number</td>
      <td width="15%" class="head1" >Vacancy</td>
     <td width="10%" class="head1" >Image</td>
	 <? if($module=="Offered"){?> 
	 <td width="15%" align="center" class="head1" >Joining Date</td>
	 <? }else{ ?>
      <td width="15%"  align="center" class="head1" >Interview Stage</td>
	 <? } ?>
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryCandidate) && $num>0){
  	$flag=true;
	$Line=0;
        
  	foreach($arryCandidate as $key=>$values){
	$flag=!$flag;
	$Line++;
	
	if($values['InterviewStatus'] == "Passed") $stClass = 'green';
	else $stClass = '';

  ?>
    <tr align="left"  >
      <!--<td ><input type="checkbox" name="CanID[]" id="CanID<?=$Line?>" value="<?=$values['CanID']?>" /></td>-->
      <td><?=stripslashes($values["UserName"])?></td>
      <td><?=stripslashes($values["Email"])?></td>
		 
      <td><?=stripslashes($values["Mobile"])?></td>
      <td>
	  <a class="fancybox fancybox.iframe" href="vacancyInfo.php?view=<?=$values['vacancyID']?>" ><?=stripslashes($values["Vacancy"])?></a>
	  
	  </td>
	  
	  <td>
	  
<?  
	unset($PreviewArray);
	$PreviewArray['Folder'] = $Config['CandidateDir'];
	$PreviewArray['FileName'] = $values['Image']; 	
	$PreviewArray['FileTitle'] = stripslashes($values['UserName']);
	$PreviewArray['Width'] = "70";
	$PreviewArray['Height'] = "70";
	$PreviewArray['Link'] = "1";
	echo PreviewImage($PreviewArray);
 
?>

   </td>
    
	
	 <? if($module=="Offered"){?> 
	 <td align="center"> 
	 <? if($values['JoiningDate']>0)
	  echo date($Config['DateFormat'], strtotime($values['JoiningDate'])); 
	  
	  
	  echo '<br><a href="#join_form_div" class="fancybox action_bt" onclick="Javascript:SetJoinForm('.$values['CanID'].',\''.stripslashes($values["UserName"]).'\',\''.stripslashes($values["Email"]).'\',\''.$values["JoiningDate"].'\');">Join Candidate</a>';
	  
	 ?>
	 
	 </td>
	 <? }else{ ?>
	 
	<td align="center" class="<?=$stClass?>">

	
	<?  echo $values['InterviewStatus'];
		if($values['InterviewStatus']=="Passed"){
			if($module=="Manage"){
				echo '<br><a href="viewCandidate.php?module=Shortlisted&shortlist='.$values['CanID'].'" class="action_bt" onclick="return confAction(\''.$ModuleName.'\',\'Shortlist\');">Shortlist</a>';
			}else if($module=="Shortlisted"){
				echo '<br><a href="#offer_form_div" class="fancybox action_bt" onclick="Javascript:SetOfferForm('.$values['CanID'].',\''.stripslashes($values["UserName"]).'\',\''.stripslashes($values["Email"]).'\');">Send Offer</a>';
			}
		}
	?>
	
	</td> 
	 
	 <? } ?>
	
      <td  align="center"  class="head1_inner" >
	  <a href="<?=$ViewUrl.'&view='.$values['CanID']?>" ><?=$view?></a>
	  
	<? if($module=="Manage"){?>  
		<a href="<?=$EditUrl.'&edit='.$values['CanID']?>" ><?=$edit?></a>
		<a href="<?=$EditUrl.'&del_id='.$values['CanID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
	<? }else{ ?>
		<a href="viewCandidate.php?module=Manage&move_id=<?=$values['CanID']?>" onclick="return confMessage('<?=CONFIRM_MOVE_CANDIDATE?>')"  ><?=$move?></a> 
	<? } ?>
	  </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_CANDIDATE?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" id="td_pager" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCandidate)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryCandidate)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','CanID','editCandidate.php?curP=<?=$_GET['curP']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','CanID','editCandidate.php?curP=<?=$_GET['curP']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','CanID','editCandidate.php?curP=<?=$_GET['curP']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   
</form>
</td>
	</tr>
</table>
<? 
if($module=="Shortlisted"){
 	 include("includes/html/box/offer_form.php"); 
}else if($module=="Offered"){
 	 include("includes/html/box/join_form.php"); 
}
 
 
  ?>
