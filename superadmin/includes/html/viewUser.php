

<div class="had"><?=$MainModuleName?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	 
	<tr>
	  <td>

<div class="had">
Manage User    </div>
<a href="editUser.php" class="add">Add <?=$ModuleName?></a>


<div class="message" align="center"><? if(!empty($_SESSION['mess_user'])) {echo $_SESSION['mess_user']; unset($_SESSION['mess_user']); }?></div>

	  </td>
	  </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','Uid','<?=sizeof($arryUser)?>');" /></td>-->
      
      <td width="14%"  class="head1" >Name</td>
      <td width="15%" class="head1" >Designation</td>
      <td  class="head1" >Email</td>
       <!--td width="12%" class="head1" >Department</td-->
     
      <td width="6%"  align="center" class="head1" >Status</td>
      <td width="12%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
    
  if(is_array($arryUser) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryUser as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
     <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="Uid[]" id="Uid<?=$Line?>" value="<?=$values['Uid']?>" /></td>-->
     
      <td height="30" >
	<?=stripslashes($values["FirstName"]).' '.stripslashes($values["LastName"])?>
	  	
		 </td>
		<td><?=stripslashes($values["Designation"])?></td> 
  
		 
		<td><?=stripslashes($values["uEmail"])?></td> 
		 
 
    <td align="center"><? 
		 if($values['status'] ==1)
		 {
			  $status = 'Active';
		 }
		 else
		 {
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editUser.php?active_id='.$values["Uid"].'&curP='.$_GET["curP"].'" class="'.$status.'"  onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
		
	 ?></td>
      <td  align="center" class="head1_inner"  >

	  
	  
	  
	  <a href="editUser.php?edit=<?=$values['Uid']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	<a href="editUser.php?del_id=<?php echo $values['Uid'];?>&amp;curP=<?php echo $_GET['curP'];?>"  onclick="return confDel('User')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_USER?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($objUser)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryUser)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','EmpID','editUser.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','EmpID','editUser.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','EmpID','editUser.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
   
   </td>
	</tr>
   </TABLE>
   
  

