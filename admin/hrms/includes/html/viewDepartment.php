<script language="JavaScript1.2" type="text/javascript">
function ShowList(){
	ShowHideLoader(1,'L');
	document.topForm.submit();
}

</script>



<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_dept'])) {echo '<div class="message">'.$_SESSION['mess_dept'].'</div>'; unset($_SESSION['mess_dept']); }?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 
 <?if(sizeof($arryDepartment)!=1){?>
 <tr>
<td >
 <form name="topForm" action="viewDepartment.php" method="get">	
<select name="d" class="inputbox" id="d" onChange="Javascript:ShowList();">
	<option value="">--- Select Division ---</option>
	<? for($i=0;$i<sizeof($arryDepartment);$i++) {?>
		<option value="<?=$arryDepartment[$i]['depID']?>" <?  if($arryDepartment[$i]['depID']==$_GET['d']){echo "selected";}?>>
		<?=$arryDepartment[$i]['Department']?>
		</option>
	<? } ?>
 </select>
 </form>
</td>
</tr>
 <? } ?>
 <? if($_GET['d']>0){ ?>

	<tr>
        <td>
		<a href="editDepartment.php?d=<?=$_GET['d']?>" class="add">Add Department</a>


		</td>
      </tr>

	<tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td class="head1" >Department</td>
    <td width="25%"  class="head1" >Departmental Head</td>
    <td width="25%"  class="head1" >Other Heads</td>


    <td width="10%" align="center" class="head1" >Status</td>
    <td width="10%"  align="center" class="head1" >Action</td>
  </tr>

  <?php 
  if(is_array($arryDept) && $num>0){
  	$flag=true;
  	foreach($arryDept as $key=>$values){
	$flag=!$flag;
	$arryOtherHead = $objCommon->getOtherHead($values['depID'],'');
  ?>
  <tr align="left" >
    <td valign="top"><?=stripslashes($values['Department'])?></td>   
     <td valign="top">
	 <? if(!empty($values['UserName'])){ ?>
	 <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=stripslashes($values['UserName'])?></a> <?='['.stripslashes($values['JobTitle']).']'?>
	<? } ?>
	 </td> 

     <td valign="top">
	 <? foreach($arryOtherHead as $key2=>$values2){ if(!empty($values2['UserName'])){ ?>
	 <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values2['EmpID']?>" ><?=stripslashes($values2['UserName'])?></a> <?='['.stripslashes($values2['JobTitle']).']'?><br>
	<? }} ?>
	 </td> 

  
   <td align="center">
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 } 
		if($values["depID"]==1){
			echo $status;
		}else{
			echo '<a href="editDepartment.php?active_id='.$values["depID"].'&curP='.$_GET["curP"].'&d='.$_GET["d"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
		}
	   
	 ?>    </td>
    <td  align="center"  class="head1_inner">
	
	<a href="editDepartment.php?edit=<?=$values['depID']?>&curP=<?=$_GET['curP']?>&d=<?=$_GET['d']?>"><?=$edit?></a>
<? if($values["depID"]!=1){?>	<a href="editDepartment.php?del_id=<?=$values['depID']?>&curP=<?=$_GET['curP']?>&d=<?=$_GET['d']?>" onClick="return confirmDialog(this, '<?=$ModuleName?>')" ><?=$delete?></a>	
	<? } ?>
	</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="6" class="no_record"><?=NO_DEPARTMENT?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="6" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryDept)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

<?  include("includes/html/box/dept_head_form.php"); ?>


</td>
	</tr>

<? } ?>


</table>
