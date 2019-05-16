<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>
<div class="had"><?=$ModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_entitlement'])) {echo $_SESSION['mess_entitlement']; unset($_SESSION['mess_entitlement']); }?></div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
 <td  valign="top">

<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td align="right" height="30"><a href="editEntitlement.php" >Add <?=$ModuleName?></a></td>
 </tr>

 <tr>
	  <td  valign="top">
	  
	
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
        <tr >
          <td>		  
	<select name="sortby" id="sortby" class="textbox">
		<option value=""> All </option>
		<option value="e.EmpID" <? if($_GET['sortby']=='e.EmpID') echo 'selected';?>>Employee ID</option>
		<option value="em.UserName" <? if($_GET['sortby']=='em.UserName') echo 'selected';?>>Employee Name</option>
		<option value="a.Module" <? if($_GET['sortby']=='a.Module') echo 'selected';?>>Department</option>
		<option value="e.LeaveType" <? if($_GET['sortby']=='e.LeaveType') echo 'selected';?>>Leave Type</option>
	</select>
	  </td>
			  
          <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>" /></td>
          <td>            
              <select name="asc" id="asc" class="textbox" >
                <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
                <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
              </select>         
			   </td>
		 <td>
		 <input name="search" type="submit" class="search_button" value="Go"  />
		  <? if($_GET['key']!='') {?>
		  <a href="viewEntitlement.php">View All</a>
		<? }?>
		 
		 </td> 
        </tr>
</table>
 	</form>

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td width="10%" class="head1" >Employee ID</td>
       <td class="head1" >Employee Name</td>
        <td width="20%" class="head1" >Department</td>
    <td width="10%"  class="head1" >Leave Type</td>
       <td width="10%"  class="head1" align="center">Valid From</td>
     <td width="10%"  class="head1" align="center">Valid To</td>
     <td width="10%"  class="head1" align="center">Days</td>
      <td width="10%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryEntitlement) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryEntitlement as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td ><?=$values["EmpID"]?></td>
      <td>
	   <?=$values['UserName']?>
	   </td>
      <td ><?=$values["Department"]?></td>
    <td ><?=$values["LeaveType"]?></td>
      <td align="center"> <? if($values["LeaveStart"]>0) echo date("j M Y", strtotime($values["LeaveStart"])); ?></td>
      <td align="center"> <? if($values["LeaveEnd"]>0) echo date("j M Y", strtotime($values["LeaveEnd"])); ?></td>
      <td align="center"><?=$values["Days"]?></td>
      <td  align="center"  ><a href="editEntitlement.php?edit=<?php echo $values['EntID'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
 
<a href="editEntitlement.php?del_id=<?php echo $values['EntID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confDel('<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>  </td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>



</td>
</tr>
</table>