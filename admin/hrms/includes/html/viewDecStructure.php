<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(SearchBy){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}

function ShowList(){
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
	document.topForm.submit();
}
</script>
<div class="had">Declaration Structure</div>
<div class="message"><? if(!empty($_SESSION['mess_dechead'])) {echo $_SESSION['mess_dechead']; unset($_SESSION['mess_dechead']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

 <tr>
<td >
 <form name="topForm" action="viewDecStructure.php" method="get">	
 	<?  if(sizeof($arryDecCategory)>0){ ?>	
<select name="cat" class="inputbox" id="cat" onChange="Javascript:ShowList();" >
        <option value="">--- Select Category ---</option>
        <? for($i=0;$i<sizeof($arryDecCategory);$i++) {?>
        <option value="<?=$arryDecCategory[$i]['catID']?>" <?  if($arryDecCategory[$i]['catID']==$_GET['cat']){echo "selected";}?>>
        <?=stripslashes($arryDecCategory[$i]['catName'])?>
        </option>
        <? } ?>
      </select>
      <? } ?> 
 </form>
</td>
</tr>

	
	<tr>
	  <td>
	
<form action="" method="post" name="form1">

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<? if($_GET['cat']>0){ ?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td  align="right">
	  <a href="editDecStructure.php?cat=<?=$_GET['cat']?>" class="add">Add Head</a>
	  <? if($_GET['key']!='') {?> <a href="viewDecStructure.php?cat=<?=$_GET['cat']?>" class="grey_bt">View All</a><? }?>
	</td>
	</tr>
</TABLE>

<table <?=$table_bg?>>

<tr align="left"  >
	<td  class="head1">Heading</td>
	<td width="25%"  class="head1">Sub Heading</td>
	<td width="10%" align="center" class="head1">Status</td>
	<td width="8%"  align="center" class="head1 head1_action" >Action</td>
</tr>
 

  <?php 
if(is_array($arryHead) && $num>0){
/*
  $pagerLink=$objPager->getPager($arryHead,$RecordsPerPage,$_GET['curP']);
 (count($arryHead)>0)?($arryHead=$objPager->getPageRecords()):("");*/
 
  	$flag=true;
  	foreach($arryHead as $key=>$values){
	$flag=!$flag;

	
  ?>
  <tr align="left" >
    <td height="35" ><?=stripslashes($values['heading'])?></td>
    <td ><?=stripslashes($values['subheading'])?></td>

     <td align="center" >
      <? 
		 if($values['Status'] ==1){
			  $Status = 'Active'; 
		 }else{
			  $Status = 'InActive'; 
		 }
	
	 
		if($values['Default'] ==1){
			echo $Status;
		}else{
			echo '<a href="editDecStructure.php?active_id='.$values["headID"].'&cat='.$_GET["cat"].'" class="'.$Status.'">'.$Status.'</a>';
		}
		
	   
	 ?>    </td>
    <td align="center"   class="head1_inner">
	<a href="editDecStructure.php?edit=<?=$values['headID']?>&cat=<?=$_GET['cat']?>"><?=$edit?></a>
	<? if($values['Default'] !=1){?>
	<a href="editDecStructure.php?del_id=<?=$values['headID']?>&cat=<?=$_GET['cat']?>" onClick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a>	
	<? } ?>
	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="4" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
	<!--
  <tr  >  <td height="20" colspan="4" >
Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryHead)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?>

</td>
  </tr>-->
</table>
<? } ?>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
