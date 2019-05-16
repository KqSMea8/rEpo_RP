
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewVideos.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewVideos.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>

<div class="had"><?php echo 'Manage Videos';?></div>
<div class="message"><? if(!empty($_SESSION['mess_video'])) {echo $_SESSION['mess_video']; unset($_SESSION['mess_video']); }?></div>
<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 <tr>
		<td  align="right"><a href="editVideo.php" class="Blue">Add Video</a></td>
	  </tr>
	<tr>
	  <td  valign="top">
	  


	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
			<table  border="0" cellpadding="0" cellspacing="3"  id="search_table">
                    <tr>
                      <td > <select name="sortby" id="sortby" class="inputbox" >
							<option value="" >All</option>
						    <option value="v.heading" <? if($_GET['sortby']=='v.heading') echo 'selected';?>>Video Title</option>
						    <option value="vc.Name" <? if($_GET['sortby']=='vc.Name') echo 'selected';?>>Category</option>
							
					 </select></td>
                      <td> <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select></td>
                      <td ><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> 
                       </td>
                   <td >
				    <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewVideos.php">View all</a><? }?>
					
					 
					 </td>
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr align="left" valign="middle" >
    <td width="2%" class="head1" >&nbsp;</td>
    <td width="33%" class="head1" >&nbsp;Video Title</td>
    <td width="10%" class="head1 style1" >Sort Order</td>
    <td width="20%" class="head1 style1" > Category </td>
    <td width="16%" class="head1 style1" >Set as Initial Video</td>
    <td width="7%" height="20" class="head1" >Status</td>
    <td width="12%" height="20"  align="center" class="head1" >Action</td>
  </tr>

  <?php 
  $pagerLink=$objPager->getPager($arryVideo,$RecordsPerPage,$_GET['curP']);
 (count($arryVideo)>0)?($arryVideo=$objPager->getPageRecords()):("");
  if(is_array($arryVideo) && $num>0){
  	$flag=true;
  	foreach($arryVideo as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td>
      <?php 
	if($values['Image'] !='' && file_exists('../videos/videos_image/'.$values['Image']) ){
	?>
	<a href="#" onclick="OpenNewPopUp('../showimage.php?img=videos/videos_image/<?php echo $values['Image'];?>', 150, 100, 'yes' );">
	<? echo '<img src="../videos/videos_image/'.$values['Image'].'" height="50" width="50" border=0 >';?>	</a>
	<?
				
	}		
	?>   </td>
    <td><?php if($values['Video'] !='' && file_exists('../videos/'.$values['Video']) ){ ?>
	<? echo stripslashes($values['heading']);?>&nbsp;
<a href="#" onclick="OpenNewPopUp('../videoplayer.php?vd=<? echo $values['Video'];?>&image=videos/videos_image/<?php echo $values['Image'];?>', 330, 330, 'yes' );">(Play)</a>
	
	<?
		/*echo '<a href="#" 		
		onclick="OpenNewPopUp(\'../videoplayer.php?vd='.$values['Video'].'&image=videos/videos_image/'.$values['Image'].'", 450, 400, \'yes\' \');">'.stripslashes($values['heading']).'</a>';*/
	}else{
		echo stripslashes($values['heading']);
	}
	?>	   </td>
    <td ><? echo stripslashes($values['sort_order']); ?></td>
    <td ><? echo stripslashes($values['Category']); ?></td>
    <td ><? 
		if($values['Status'] ==1 && $values['Video'] !='' && file_exists('../videos/'.$values['Video']) ){
			 if($values['showHome'] ==1){
				  echo $showHome = 'Show On Home Page';
			 }else{
				  $showHome = 'No';
				  echo '<a href="editVideo.php?showHomeID='.$values["videoID"].'&curP='.$_GET["curP"].'" class="edit">'.$showHome.'</a>';
			 }
		}
	
	 

		
	   
	 ?></td>
    <td height="20" >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editVideo.php?active_id='.$values["videoID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?>    </td>
    <td height="20" align="center" >
	<a href="editVideo.php?edit=<?php echo $values['videoID'];?>&curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>

	<a href="editVideo.php?del_id=<?php echo $values['videoID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Video')"  ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="7" class="no_record">No video found. </td>
  </tr>

  <?php } ?>
    
  <tr  >  <td height="20" colspan="7" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryVideo)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
