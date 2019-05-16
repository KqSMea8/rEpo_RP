
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewKeywords.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewKeywords.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>

<div class="had"><?php echo 'Manage Search Terms';?></div>
<div class="message"><? if(!empty($_SESSION['mess_keyword'])) {echo $_SESSION['mess_keyword']; unset($_SESSION['mess_keyword']); }?></div>
<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<tr>
		<td  align="right"><a href="editKeyword.php" class="Blue">Add Search Term</a></td>
	  </tr>
	<tr>
	  <td  valign="top">


	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
                    <tr>
                      <td> <select name="sortby" id="sortby" class="inputbox" >
							<option value="" >All</option>
						    <option value="v.Keyword" <? if($_GET['sortby']=='v.Keyword') echo 'selected';?>>Search Term</option>
						    <option value="v.KeywordType" <? if($_GET['sortby']=='v.KeywordType') echo 'selected';?>>Search Type</option>
							
					 </select></td>
                      <td ><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> </td>
					  <td  >
				   
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					 
					 </td>
                      <td >
                        <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewKeywords.php">View all</a><? }?></td>
                   
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td width="38%" class="head1" >Search Term </td>
    <td width="31%" class="head1" > Search Type </td>
    <td width="14%"  class="head1" >Status</td>
    <td width="14%"  align="center" class="head1" >Action</td>
  </tr>
  
  <?php 
  $pagerLink=$objPager->getPager($arryKeyword,$RecordsPerPage,$_GET['curP']);
 (count($arryKeyword)>0)?($arryKeyword=$objPager->getPageRecords()):("");
  if(is_array($arryKeyword) && $num>0){
  	$flag=true;
  	foreach($arryKeyword as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td>
	<? 	echo stripslashes($values['Keyword']);	?>	</td>
    <td ><? echo stripslashes($values['KeywordType']); ?></td>
    <td  >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editKeyword.php?active_id='.$values["keywordID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?>    </td>
    <td  align="center"  >
	<a href="editKeyword.php?edit=<?php echo $values['keywordID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>

	<a href="editKeyword.php?del_id=<?php echo $values['keywordID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Search Term')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="4" class="no_record">Keyword Not Found.</td>
  </tr>

  <?php } ?>
    
  <tr>  <td  colspan="4">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryKeyword)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
