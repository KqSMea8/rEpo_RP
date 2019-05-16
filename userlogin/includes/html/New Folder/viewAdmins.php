<div class="had"><? echo 'Manage Administrators';?></div>
<div class="message"><? if(!empty($_SESSION['mess_adminis'])) {echo $_SESSION['mess_adminis']; unset($_SESSION['mess_adminis']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 <tr>
		<td align="right"><a href="editAdmin.php" class="Blue">Add Administrator</a></td>
	  </tr>
	<tr>
	  <td align="left">
	  


	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
                    <tr >
                      <td >
					  <select name="sortby" id="sortby" class="inputbox">
							<option value="" >All</option>
						    <option value="a.Name" <? if($_GET['sortby']=='a.Name') echo 'selected';?>>Name</option>
						    <option value="a.Username" <? if($_GET['sortby']=='a.Username') echo 'selected';?>>Username</option>
							
					 </select>
					 </td>
					   <td >
				    <input type="text" name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> 
					
					 
					 </td> 
					 <td><select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					 </td>
                      <td  align="left" >
                        <input name="search" type="submit" class="search_button" value="Go">
					  <? if($_GET['key']!='') {?> <a href="viewAdmins.php">View All</a><? }?></td>
                 
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr>
    <td width="39%" class="head1" >Name </td>
    <td width="32%" class="head1" > Username </td>
    <td width="17%" height="20" class="head1" >Status</td>
    <td width="12%" height="20" align="center" class="head1" >Action</td>
  </tr>
  
  <? 
  $pagerLink=$objPager->getPager($arryAdmin,$RecordsPerPage,$_GET['curP']);
 (count($arryAdmin)>0)?($arryAdmin=$objPager->getPageRecords()):("");
  if(is_array($arryAdmin) && $num>0){
  	$flag=true;
  	foreach($arryAdmin as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td>
	<? 	echo stripslashes($values['Name']);	?>	</td>
    <td ><? echo stripslashes($values['Username']); ?></td>
    <td height="20" >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 
		 if($values['AdminID']==1){	
		 	echo 'Active';
		 }else{
			echo '<a href="editAdmin.php?active_id='.$values["AdminID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		}
		
	   
	 ?>    </td>
    <td height="20" align="center" >
	<a href="editAdmin.php?edit=<? echo $values['AdminID'];?>&curP=<? echo $_GET['curP'];?>" ><?=$edit?></a>
	<? if($values['AdminID']>1){ ?>
	<a href="editAdmin.php?del_id=<? echo $values['AdminID'];?>&curP=<? echo $_GET['curP'];?>" onClick="return confDel('Administrator')" class="edit" ><?=$delete?></a>
	<? } ?>
		</td>
  </tr>
  <? } // foreach end //?>
 

 
  <? }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="4" class="no_record">No record found.</td>
  </tr>

  <? } ?>
    
  <tr >  <td height="20" colspan="4" >Total Record(s) : &nbsp;<? echo $num;?>      <? if(count($arryAdmin)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <? echo $pagerLink;
}?></td>
  </tr>
</table>


<input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewAdmins.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewAdmins.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>
