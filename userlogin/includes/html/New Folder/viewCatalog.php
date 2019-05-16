
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewCatalog.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCatalog.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>
<div class="had"><?php echo 'Manage Catalogs';?></div>
<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
	  <td  valign="top">
	  
<div class="message"><? if(!empty($_SESSION['mess_catalog'])) {echo $_SESSION['mess_catalog']; unset($_SESSION['mess_catalog']); }?></div>
	<table width="98%"  border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td width="81%">&nbsp;</td>
		<td width="19%" align="right"><a href="editCatalog.php" class="Blue">Add Catalog</a></td>
	  </tr>
	</table>

	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="0" cellspacing="3"  id="search_table">
                    <tr>
                      <td> <select name="sortby" id="sortby" class="inputbox" >
							<option value="" >All</option>
						    <option value="heading" <? if($_GET['sortby']=='heading') echo 'selected';?>>Catalog Heading</option>
						   <!-- <option value="catalogDate" <? if($_GET['sortby']=='catalogDate') echo 'selected';?>>Catalog Date</option>-->
					 </select></td>
                      <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> </td>
					  <td>
				   
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					 
					 </td>
					  
					  
                      <td>
                        <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewCatalog.php">View all</a><? }?></td>
                   
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td width="64%" class="head1" >Catalog Heading</td>
    <td width="9%" height="20" class="head1" >Status</td>
    <td width="11%" height="20" align="center" class="head1" >Action</td>
  </tr> 
  <?php 
  $pagerLink=$objPager->getPager($arryCatalog,$RecordsPerPage,$_GET['curP']);
 (count($arryCatalog)>0)?($arryCatalog=$objPager->getPageRecords()):("");
  if(is_array($arryCatalog) && $num>0){
  	$flag=true;
  	foreach($arryCatalog as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td>
    <?=stripslashes($values['heading'])?>    </td>
    <td height="20" >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editCatalog.php?active_id='.$values["catalogID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?>    </td>
    <td  align="center" >
	<a href="editCatalog.php?edit=<?php echo $values['catalogID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>

	<a href="editCatalog.php?del_id=<?php echo $values['catalogID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Catalog')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 


  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="3"  class="no_record">No catalog found. </td>
  </tr>

  <?php } ?>
    
  <tr>  <td height="20" colspan="3" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCatalog)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
