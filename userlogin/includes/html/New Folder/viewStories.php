

<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewStories.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewStories.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>

<div class="had"><?php echo 'Manage Success Stories'; ?></div>
<div class="message"><? if(!empty($_SESSION['mess_story'])) {echo $_SESSION['mess_story']; unset($_SESSION['mess_story']); }?></div>
<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 <tr>
		<td  align="right"><a href="editStory.php" class="Blue">Add Success Story</a></td>
	  </tr>
	<tr>
	  <td  valign="top">
	  
	

	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="0" cellspacing="3"  id="search_table">
                    <tr>
                      <td > <select name="sortby" id="sortby" class="inputbox" >
							<option value="" >All</option>
						    <option value="heading" <? if($_GET['sortby']=='heading') echo 'selected';?>>Story Heading</option>
						    <option value="SpeakerName" <? if($_GET['sortby']=='SpeakerName') echo 'selected';?>>Submitted By</option>
					 </select></td>
                      <td  >
					  <input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> 
					  </td>
                      <td  >
                         <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
						</td>
                   <td ><input name="search" type="submit" class="search_button" value="Go">
				   <? if($_GET['key']!='') {?> <a href="viewStories.php">View All</a><? }?>
					
					 
					 </td>
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td width="60%" class="head1" >Story Heading</td>
    <td width="2%" class="head1" >&nbsp;</td>
    <td width="20%" class="head1" ><!--Posted Date-->
     Submitted By</td>
    <td width="8%" height="20" class="head1" >Status</td>
    <td width="10%" height="20" align="center" class="head1" >Action</td>
  </tr>
 
  <?php 
  $pagerLink=$objPager->getPager($arryStory,$RecordsPerPage,$_GET['curP']);
 (count($arryStory)>0)?($arryStory=$objPager->getPageRecords()):("");
  if(is_array($arryStory) && $num>0){
  	$flag=true;
  	foreach($arryStory as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
	
	#if($values['Status']<=0){ $bgcolor="#000000"; }
	
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td >
    <?=stripslashes($values['heading'])?>    </td>
    <td  >&nbsp;</td>
    <td  >
     <?=stripslashes($values['SpeakerName'])?>    </td>
    <td height="20" >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editStory.php?active_id='.$values["storyID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?>    </td>
    <td height="20" align="center"  >
	<a href="editStory.php?edit=<?php echo $values['storyID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>

	<a href="editStory.php?del_id=<?php echo $values['storyID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Success Story')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr >
  	  <td height="20" colspan="5" class="no_record">No record found.</td>
  </tr>

  <?php } ?>
    
  <tr>  <td height="20" colspan="5">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryStory)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
