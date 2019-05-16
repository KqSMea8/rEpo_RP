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
		
  <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_vacancy_report.php?<?=$QueryString?>';" />
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
       <td width="15%"  class="head1" >Vacancy Name</td>
     <td class="head1" >Job Title</td>
     <td  width="15%" class="head1" >Posted Date</td>
     <td width="12%" align="center" class="head1" >No of Position</td>
     <td width="12%" align="center" class="head1" >No of Applicant</td>
     <td width="12%" align="center" class="head1" >Shortlisted</td>
     <td width="12%" align="center" class="head1" >Offered</td>
     <td width="6%" align="center" class="head1" >Hired</td>
    </tr>
   
    <?php 
  if($num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryVacancy as $key=>$values){
	$flag=!$flag;
	$Line++;

	$NumApplicant = $objCandidate->GetNumCandidate('',$values['vacancyID']);
	$NumShortlisted = $objCandidate->GetNumCandidate('Shortlisted',$values['vacancyID']);
	$NumOffered = $objCandidate->GetNumCandidate('Offered',$values['vacancyID']);

  ?>
    <tr align="left" >
		<td><a class="fancybox fancybox.iframe" href="vacancyInfo.php?view=<?=$values['vacancyID']?>" ><?=stripslashes($values["Name"])?></a></td>
		<td><?=stripslashes($values["JobTitle"])?></td>
		<td > <? if($values["PostedDate"]>0) echo date($Config['DateFormat'], strtotime($values["PostedDate"])); ?></td>

		<td align="center"><?=$values["NumPosition"]?></td>
		<td align="center"><?=$NumApplicant?></td>
		<td align="center"><?=$NumShortlisted?></td>
		<td align="center"><?=$NumOffered?></td>
		<td align="center"><?=$values["Hired"]?></td>        
    </tr>
    <?php } // foreach end //?>
  
 <tr >  <td  colspan="8"  id="td_pager" >Total Record(s) : &nbsp;<?php echo $num;?> 
	 </td>
  </tr>

    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>

  </table>

  </div> 

<?  if($num>0){ ?>

<div class="report_chart"><h2><?=$MainModuleName?></h2><img src="barVacancy.php" ></div>

<? } ?>
  
</form>
</td>
	</tr>
</table>
