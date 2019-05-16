<div class="had">Manage Video Categories</div>
	  <div class="message"><? if(!empty($_SESSION['mess_vdcat'])) {echo stripslashes($_SESSION['mess_vdcat']); unset($_SESSION['mess_vdcat']); }?></div>
<TABLE WIDTH="90%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
    <td align="right" height="30"><a href="editVideoCategory.php?ParentID=<?=$ParentID?>&curP=<?php echo $_GET['curP'];?>" class="Blue">Add Video Category</a></td>
  </tr>
	
	
	<tr>
	  <td  valign="top">


<table <?=$table_bg?>>

  <tr align="left" valign="middle"  >
    <td width="63%" height="20" class="head1" >Category Name</td>
 
    <td width="18%"  height="20" class="head1"  >Status</td>
    <td width="19%"   height="20" align="center" class="head1"  >Action</td>
  </tr>
 
  <?php 
  $pagerLink=$objPager->getPager($arryCategory,$RecordsPerPage,$_GET['curP']);
 (count($arryCategory)>0)?($arryCategory=$objPager->getPageRecords()):("");
  if(is_array($arryCategory) && $num>0){
  	$flag=true;
  	foreach($arryCategory as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
	
	
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td height="20"  ="">
	 
&nbsp;

	 
	 
	 <?  echo '<SPAN>'.stripslashes($values['Name']).'</SPAN>';
	 ?></td>
    
    <td height="20" ><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editVideoCategory.php?active_id='.$values["catID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?></td>
    <td height="20" align="center" ><a href="editVideoCategory.php?edit=<?php echo $values['catID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>    <a href="editVideoCategory.php?del_id=<?php echo $values['catID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('<?=$cat_title?>')" class="edit" ><?=$delete?></a>
	
	</td>
  </tr>
  <?php } // foreach end //?>
  
  <?php }else{?>
  <tr >
  	  <td height="20" colspan="3" class="no_record">No record found.</td>
  </tr>

  <?php } ?>
   
 
  <tr >  <td height="20" colspan="3" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCategory)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
</td>
	</tr>
</table>