<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>

<div class="had">User Info</div>

<!-- 
<a class="back" href="<?=$RedirectURL."?cmp=" . $_GET['cmp']?>">Back</a>
  <a href="<?=$EditUrl?>" class="edit">Edit</a> -->

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
<td align="left" >
	<a href="cmpList.php?link=viewEmployee.php" class="fancybox action_bt fancybox.iframe" class="action_bt">Select Company</a></td>
</tr>


<? if($CmpID>0){?>
<tr>
  <td  valign="top" align="left">

<table width="30%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0;">
  <tr>
        <td  align="right"   class="blackbold" width="30%" > Company Name  : </td>
        <td   align="left" >
<strong><?php echo stripslashes($arryCompany[0]['CompanyName']); ?></strong>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Company ID  :</td>
        <td   align="left" >
<?php echo stripslashes($arryCompany[0]['CmpID']); ?>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Display Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>
           </td>
      </tr>
<tr>
	 <td  align="right">Email : </td>
 <td  align="left">
<?php echo $arryCompany[0]['Email']; ?>
</td>
</tr>
</table>

</td>
</tr>

<? }  ?>

</table>


<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<? if($CmpID>0){?>
	 
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
     <td width="10%" align="center" class="head1" >Joining Date</td>
      <td width="6%"  align="center" class="head1" >Status</td>
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


	<!--  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>&cmp=<?php echo $_GET['cmp'];?>" ><?=$values["EmpCode"]?></a> --> 
	   
	   <a class="fancybox fancybox.iframe" href="userInfo.php?view=<?=$values['EmpID']?>&cmp=<?php echo $_GET['cmp'];?>" ><?=$values["EmpCode"]?></a>   
	   
	   
	   <? if($PermittedEmp==1){
		     #echo '<img src="'.$Prefix.'admin/images/admin_icon.png" border="0" style="float:right" onMouseover="ddrivetip(\'<center>Admin</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	   }?>
	   </td>
      <td height="30" >
	<?=stripslashes($values["UserName"])?>
	  	
		 </td>
		<td><?=stripslashes($values["JobTitle"])?></td> 
  
		 
		<td><?=stripslashes($values["Email"])?></td> 
		   <td ><?=stripslashes($values["Department"])?></td>
    <td align="center"> 
	<?=($values['JoiningDate']>0)?(date($Config['DateFormat'], strtotime($values['JoiningDate']))):('')?> 

	</td> 
    <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	echo '<a href="#" class="'.$status.'">'.$status.'</a>';

	//echo '<a href="editEmployee.php?active_id='.$values["EmpID"].'&curP='.$_GET["curP"].'" class="'.$status.'"  onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
		
	 ?></td>
      <td  align="center" class="head1_inner"  >

	  <a href="vEmployee.php?view=<?=$values['EmpID']?>&curP=<?=$_GET['curP']?>&cmp=<?=$_GET['cmp']?>" ><?=$view?></a>
	  
	  
	  <!--  <a href="editEmployee.php?edit=<?=$values['EmpID']?>&curP=<?=$_GET['curP']?>&cmp=<?=$_GET['cmp']?>" ><?=$edit?></a>
	  
	<a href="editEmployee.php?del_id=<?php echo $values['EmpID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>  
	-->
	
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
	<? } ?>
</table>
