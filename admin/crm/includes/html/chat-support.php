<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>








<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','EmpID','<?=sizeof($arryEmployee)?>');" /></td>-->
      <td width="10%"  class="head1 left_corner" >Emp Code</td>
      <td width="14%"  class="head1" >Name</td>
      <td width="15%" class="head1" >Designation</td>
      <td  class="head1" >Email</td>
       <td width="12%" class="head1" >Department</td>
      <td width="12%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryEmployee) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEmployee as $key=>$values){
	$flag=!$flag;
	$Line++;
	
	#$PermittedEmp=$objEmployee->isPermittedEmp($values['UserID']);
  ?>
    <tr align="left" >
      <!--<td ><input type="checkbox" name="EmpID[]" id="EmpID<?=$Line?>" value="<?=$values['EmpID']?>" /></td>-->
       <td >
			<?=$values["EmpCode"]?>  
	   </td>
      <td height="30" >
	<?=stripslashes($values["UserName"])?>
	  	
		 </td>
		<td><?=stripslashes($values["JobTitle"])?></td> 
  
		 
		<td><?=stripslashes($values["Email"])?></td> 
		   <td ><?=stripslashes($values["Department"])?></td>
      <td  align="center" class="head1_inner"  >
	  <a href="vEmployee.php?view=<?=$values['EmpID']?>&curP=<?=$_GET['curP']?>" >Chat History</a>
	  </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_EMPLOYEE?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryEmployee)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryEmployee)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','EmpID','editEmployee.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','EmpID','editEmployee.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','EmpID','editEmployee.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>

