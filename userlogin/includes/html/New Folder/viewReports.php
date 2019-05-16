
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewReports.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewReports.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
		}
</script>


<div class="had">
<? echo '&nbsp;Offensive Content Report';?>
</div>
<div class="message"><? if(!empty($_SESSION['mess_report'])) {echo $_SESSION['mess_report']; unset($_SESSION['mess_report']); }?></div>
<TABLE WIDTH="95%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
	  <td  valign="top">
	  
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
                    <tr>
                      <td> <select name="sortby" id="sortby" class="inputbox" >
					<option value="" >All</option>
						 <option value="Content" <? if($_GET['sortby']=='Content') echo 'selected';?>>Offensive Content</option>
						    <option value="Name" <? if($_GET['sortby']=='Name') echo 'selected';?>>Posted By</option>
							<option value="Email" <? if($_GET['sortby']=='Email') echo 'selected';?>>Email</option>
							<option value="Date" <? if($_GET['sortby']=='Date') echo 'selected';?>>Posted Date</option>
					 </select></td>
					  <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"></td>
					  <td>				   
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					 </select>
					 
					 </td>
					 
					 
                     
                      <td > 
                        <input name="search" type="submit" class="search_button" value="Go">
					  <? if($_GET['key']!='') {?> <a href="viewReports.php">View All</a><? }?></td>
                  
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>

  
  <tr align="left"  >
    <td width="45%" class="head1" >Offensive Content</td>
    <td width="2%" class="head1" >&nbsp;</td>
    <td width="17%" class="head1" >Posted By </td>
    <td width="15%" class="head1" >Email</td>
    <td width="10%"  class="head1" >Posted Date</td>
    <td width="11%"  align="center" class="head1" >Action</td>
  </tr>
 
  <?php 
  $pagerLink=$objPager->getPager($arryReport,$RecordsPerPage,$_GET['curP']);
 (count($arryReport)>0)?($arryReport=$objPager->getPageRecords()):("");
  if(is_array($arryReport) && $num>0){
  	$flag=true;
  	foreach($arryReport as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td >
    <?=substr(stripslashes($values['Content']),0,100)?>    </td>
    <td >&nbsp;</td>
    <td ><?=stripslashes($values['Name'])?></td>
    <td ><?  echo '<a href="mailto:'.$values['Email'].'">'.$values['Email'].'</a>'; ?></td>
    <td height="32" >
      <? echo stripslashes($values['Date']); ?>	     </td>
    <td height="32" align="center"  >
	<a href="editReport.php?edit=<?php echo $values['reportID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit">View</a>

	<a href="editReport.php?del_id=<?php echo $values['reportID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Report')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
   	<tr >
  	  <td  colspan="6" class="no_record">No record found.</td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="6" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryReport)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
