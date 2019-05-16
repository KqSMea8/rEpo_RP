<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(SearchBy){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>

<div class="had">Manage KRA</div>
<div class="message"><? if(!empty($_SESSION['mess_kra'])) {echo $_SESSION['mess_kra']; unset($_SESSION['mess_kra']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	<tr>
	  <td>

<a href="editKra.php" class="add">Add <?=$ModuleName?></a>
	  
	  <? if($_GET['key']!='') {?> <a href="viewKra.php" class="grey_bt">View All</a><? }?>
<? if($num>0){ ?>
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>

	  </td>
	  </tr>

	<tr>
	  <td  >
	
<form action="" method="post" name="form1">

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >

<table <?=$table_bg?>>

<tr align="left"  >
	<td  class="head1" >KRA Title</td>
	<td width="25%"  class="head1" >Job Title</td>
	<td width="15%" class="head1" >Minimum Rating</td>
	<td width="15%" class="head1" >Maximum Rating</td>
	<td width="10%" align="center" class="head1" >Status</td>
	<td width="8%"  align="center" class="head1 head1_action" >Action</td>
</tr>
 

  <?php 
if(is_array($arryKra) && $num>0){ 

  $pagerLink=$objPager->getPager($arryKra,$RecordsPerPage,$_GET['curP']);
 (count($arryKra)>0)?($arryKra=$objPager->getPageRecords()):("");
 
  	$flag=true;
  	foreach($arryKra as $key=>$values){
	$flag=!$flag;
  ?>
  <tr align="left" >
    <td  ><?=stripslashes($values['heading'])?></td>
    <td ><?=stripslashes($values['JobTitle'])?></td>
    <td ><?=$values['MinRating']?></td>
    <td ><?=$values['MaxRating']?></td>

     <td align="center" >
      <? 
		 if($values['Status'] ==1){
			  $Status = 'Active'; 
		 }else{
			  $Status = 'InActive'; 
		 }
	
	 

		echo '<a href="editKra.php?active_id='.$values["kraID"].'" class="'.$Status.'">'.$Status.'</a>';
		
	   
	 ?>    </td>
    <td align="center"   class="head1_inner">
	<a href="editKra.php?edit=<?=$values['kraID']?>"><?=$edit?></a>

	<a href="editKra.php?del_id=<?=$values['kraID']?>" onClick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a>
	
		</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="6" class="no_record"><?=NO_RECORD?> </td>
  </tr>

  <?php } ?>
    
  <tr  >  <td height="20" colspan="6" id="td_pager">
Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryKra)>0){?>
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
