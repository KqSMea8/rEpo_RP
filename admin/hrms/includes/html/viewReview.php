<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(SearchBy){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>




<div class="had">Manage Review</div>
<div class="message"><? if(!empty($_SESSION['mess_review'])) {echo $_SESSION['mess_review']; unset($_SESSION['mess_review']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td>
<a href="editReview.php" class="add">Add <?=$ModuleName?></a>
	  
	  <? if($_GET['search']!='') {?> <a href="viewReview.php" class="grey_bt">View All</a><? }?>
<? if($num>0){?>
	<div id="print_export">
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_review.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	</div>  
	  <? } ?>
	  </td>
	  </tr>
	<tr>
	  <td>
	
<form action="" method="post" name="form1">

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >

<table <?=$table_bg?>>

<tr align="left"  >
	<td width="15%"  class="head1" >Employee</td>
	<td  class="head1" >Job Title</td>
	<td width="14%" class="head1" >Review From</td>
	<td width="15%" class="head1" >Review To</td>
	<td width="15%" class="head1" >Reviewer</td>
	<td width="12%" class="head1" >Status</td>
	<td width="10%"  align="center" class="head1 head1_action" >Action</td>
</tr>
 

  <?php 
if(is_array($arryReview) && $num>0){ 
  $pagerLink=$objPager->getPager($arryReview,$RecordsPerPage,$_GET['curP']);
 (count($arryReview)>0)?($arryReview=$objPager->getPageRecords()):("");
 
  	$flag=true;
  	foreach($arryReview as $key=>$values){
	$flag=!$flag;

	 if($values['Status'] != "Scheduled") $stClass = 'green';
	 else $stClass = '';

	
  ?>
  <tr align="left" >
    <td height="35" >
	<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=stripslashes($values['UserName'])?></a>
	</td>
    <td><?=stripslashes($values['JobTitle'])?></td>
    <td><? if($values["FromDate"]>0) echo date($Config['DateFormat'], strtotime($values["FromDate"])); ?></td>
    <td><? if($values["ToDate"]>0) echo date($Config['DateFormat'], strtotime($values["ToDate"])); ?></td>
    <td>	
	<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['ReviewerID']?>"><?=stripslashes($values['ReviewerName'])?></a>
	</td>
    <td class="<?=$stClass?>"><?=$values['Status']?></td>
	<td align="center" class="head1_inner">
	<a href="vReview.php?view=<?=$values['reviewID']?>&curP=<?=$_GET['curP']?>"><?=$view?></a>
	<a href="editReview.php?edit=<?=$values['reviewID']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>

	<a href="editReview.php?del_id=<?=$values['reviewID']?>&curP=<?=$_GET['curP']?>" onClick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a>
	
		</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="7" class="no_record"><?=NO_REVIEW?></td>
  </tr>

  <?php } ?>
    
  <tr  >  <td height="20" colspan="7" id="td_pager">
Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryReview)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?>

</td>
  </tr>
</table>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
