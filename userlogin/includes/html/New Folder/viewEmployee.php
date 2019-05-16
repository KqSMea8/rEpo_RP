<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewEmployee.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewEmployee.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>
<div class="had">Manage Employee</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?></div>
<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right"><a href="editEmployee.php" >Add Employee</a></td>
      </tr>
	<tr>
	  <td  valign="top">
	  
	
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
        <tr >
          <td>		  
	<select name="sortby" id="sortby" class="textbox">
		<option value=""> All </option>
		<option value="e.UserName" <? if($_GET['sortby']=='e.UserName') echo 'selected';?>>Name</option>
		<option value="e.EmpID" <? if($_GET['sortby']=='e.EmpID') echo 'selected';?>>Employee ID</option>
		<option value="e.Email" <? if($_GET['sortby']=='e.Email') echo 'selected';?>>Email</option>
		<option value="e.Role" <? if($_GET['sortby']=='e.Role') echo 'selected';?>>Role</option>
		<option value="e.Status" <? if($_GET['sortby']=='e.Status') echo 'selected';?>>Status</option>
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
		  <a href="viewEmployee.php">View All</a>
		<? }?>
		 
		 </td> 
        </tr>
      </table>
	</form>
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','EmpID','<?=sizeof($arryEmployee)?>');" /></td>-->
      <td width="26%"  class="head1" >Name</td>
      <td width="26%"  class="head1" >Employee ID</td>
      <td  class="head1" >Email</td>
      <td width="10%" class="head1" >Image</td>
      <td width="6%" class="head1" >Role</td>
      <td width="6%"  align="center" class="head1" >Status</td>
      <td width="6%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryEmployee) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEmployee as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="EmpID[]" id="EmpID<?=$Line?>" value="<?=$values['EmpID']?>" /></td>-->
     
      <td height="50" >
	  <a href="editEmployee.php?edit=<?=$values['EmpID']?>&curP=<?=$_GET['curP']?>" ><strong><?=stripslashes($values["UserName"])?></strong></a> 
	  	
		 </td>
		  
		   <td ><?=$values["EmpID"]?></td>
      <td><?  echo '<a href="mailto:'.$values['Email'].'">'.$values['Email'].'</a>'; ?></td>
      <td>
	  
<? if($values['Image'] !='' && file_exists('../upload/employee/'.$values['Image']) ){ ?>

<a href="../upload/employee/<?=$values['Image']?>" class="fancybox" data-fancybox-group="gallery"  title="<?=$values['UserName']?>" alt="<?=$values['UserName']?>"><? echo '<img src="../resizeimage.php?w=70&h=70&img=upload/employee/'.$values['Image'].'" border=0 >';?></a>
<?	} ?>	  </td>
 <td><?=$values["Role"]?></td>   
    <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editEmployee.php?active_id='.$values["EmpID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	 ?></td>
      <td  align="center"  ><a href="editEmployee.php?edit=<?=$values['EmpID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	<a href="editEmployee.php?del_id=<?php echo $values['EmpID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confDel('<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryEmployee)>0){?>
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
