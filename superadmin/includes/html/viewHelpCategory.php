<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>
<div class="had"><?=$ModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_help'])) {echo $_SESSION['mess_help']; unset($_SESSION['mess_help']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	<tr>
        <td align="right" >
		
		<a href="editHelpCategory.php" class="add">Add Help Category</a>

		
		<? if($_GET['sc']!='') {?>
		  <a href="viewHelpCategory.php" class="grey_bt">View All</a>
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
      <td class="head1" >Category Name</td>
 <td width="12%"   class="head1" >Order</td>
     <td width="12%"  align="center" class="head1" >Status</td>
      <td width="12%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryHelpCategory) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryHelpCategory as $key=>$values){
	$flag=!$flag;
	$Line++;

  ?>
    <tr align="left" bgcolor="<?=$bgcolor?>" >
    
     <td><?=stripslashes($values["CategoryName"])?></td>
   <td><?=stripslashes($values["OrderBy"])?></td>
	<td align="center">  
	<? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	

		echo '<a href="editHelpCategory.php?active_id='.$values["CategoryID"].'&curP='.$_GET["curP"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
	   
	 ?> </td> 
	 
	
      <td  align="center"  class="head1_inner" >
	  
		<a href="editHelpCategory.php?curP=<?=$_GET['curP']?>&edit=<?=$values['CategoryID']?>" ><?=$edit?></a>
		<a href="editHelpCategory.php?curP=<?=$_GET['curP']?>&del_id=<?=$values['CategoryID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
	
	  </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="6" id="td_pager" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryHelpCategory)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryHelpCategory)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','CategoryID','editHelpCategory.php?curP=<?=$_GET['curP']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','CategoryID','editHelpCategory.php?curP=<?=$_GET['curP']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','CategoryID','editHelpCategory.php?curP=<?=$_GET['curP']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   
</form>
</td>
	</tr>
</table>
