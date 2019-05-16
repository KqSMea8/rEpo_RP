<?
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/user.class.php");
	include_once("includes/FieldArray.php");
	$ModuleName = "User";
	$objEmployee=new employee();
	$objUser=new user();
	
	(empty($_GET['Division']))?($_GET['Division']=""):("");

 	if($Config['CurrentDepID']>0){
		$ListUrl = 'viewUser.php';
	}else{
		$ListUrl = 'viewUsers.php';
	}

	/******Get Employee Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryEmployee=$objEmployee->ListEmployee($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objEmployee->ListEmployee($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************************/	
?>



<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_user'])) {echo $_SESSION['mess_user']; unset($_SESSION['mess_user']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	 
	<tr>
	  <td>


<a href="editUser.php" class="add">Add <?=$ModuleName?></a>

<? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='<?=$MainPrefix?>export_user.php?<?=$QueryString?>&Division=<?=$_GET['Division']?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?> 

<? if($_GET['search']!='') {?>
<a href="<?=$ListUrl?>" class="grey_bt">View All</a>
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
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','EmpID','<?=sizeof($arryEmployee)?>');" /></td>-->
      <td width="10%"  class="head1 left_corner" >User Code</td>
      <td width="14%"  class="head1" >Name</td>
      <td width="15%" class="head1" >Designation</td>
      <td  class="head1" >Email</td>
       <!--td width="12%" class="head1" >Department</td-->
     <td width="14%" align="center" class="head1" >Joining Date</td>
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
	
  ?>
    <tr align="left" >
      <!--<td ><input type="checkbox" name="EmpID[]" id="EmpID<?=$Line?>" value="<?=$values['EmpID']?>" /></td>-->
       <td >


	<a class="fancybox fancybox.iframe" href="<?=$MainPrefix?>userInfo.php?view=<?=$values['EmpID']?>" ><?=$values["EmpCode"]?></a>   
	   
	   
	   </td>
      <td height="30" >
	<?=stripslashes($values["UserName"])?>
	  	
		 </td>
		<td><?=stripslashes($values["JobTitle"])?></td> 
  
		 
		<td><?=stripslashes($values["Email"])?></td> 
		   <!--td ><?=stripslashes($values["Department"])?></td-->
    <td align="center"> 
	<?=($values['JoiningDate']>0)?(date($Config['DateFormat'], strtotime($values['JoiningDate']))):('')?> 

	</td> 
    <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editUser.php?active_id='.$values["EmpID"].'&curP='.$_GET["curP"].'" class="'.$status.'"  onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
		
	 ?></td>
      <td  align="center" class="head1_inner"  >

	  <a href="vUser.php?view=<?=$values['EmpID']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	  
	  
	  <a href="editUser.php?edit=<?=$values['EmpID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	<a href="editUser.php?del_id=<?php echo $values['EmpID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_USER?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryEmployee)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>

