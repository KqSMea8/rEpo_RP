<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
	/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewBrands.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewBrands.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>
<div class="had"><?php echo 'Manage Brands';?></div>
<div class="message"><? if(!empty($_SESSION['mess_brand'])) {echo $_SESSION['mess_brand']; unset($_SESSION['mess_brand']); }?></div>

<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td  align="right"><a href="editBrand.php" class="Blue">Add Brand</a>
		</td>
		</tr>
	<tr>
	  <td  valign="top">
	  
	

	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  height="38" border="0" cellpadding="0" cellspacing="4"  id="search_table">
                    <tr>
                      <td >  <select name="sortby" id="sortby" class="inputbox" >
							<option value="" >All</option>
						    <option value="heading" <? if($_GET['sortby']=='heading') echo 'selected';?>>Brand Title</option>
					 </select></td>
                      <td ><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>">  </td>
					  
					    <td >
				  
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					 
					 </td>
					   <td >
                        <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewBrands.php">View All</a><? }?></td>
              
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr align="left" valign="middle" >
    <td width="3%" class="head1" >&nbsp;</td>
    <td width="62%" class="head1" >Brand Title</td>
    <td width="22%" height="20" class="head1 style1" >Status</td>
    <td width="13%" height="20" align="center" class="head1" >Action</td>
  </tr>

  <?php 
  $pagerLink=$objPager->getPager($arryBrand,$RecordsPerPage,$_GET['curP']);
 (count($arryBrand)>0)?($arryBrand=$objPager->getPageRecords()):("");
  if(is_array($arryBrand) && $num>0){
  	$flag=true;
  	foreach($arryBrand as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td style="padding:5px;">
      <?php 
	if($values['Image'] !='' && file_exists('../upload/brands/'.$values['Image']) ){
	?>
	<a href="#" onclick="OpenNewPopUp('../showimage.php?img=upload/brands/<?php echo $values['Image'];?>', 150, 100, 'yes' );">
	<? echo '<img src="../resizeimage.php?w=70&h=80&img=upload/brands/'.$values['Image'].'" border=0 >';?>
	</a>
	<?
				
	}		
	?>
   </td>
    <td class="blacknormal" style="padding-bottom:5px;"><?php if($values['Brand'] !='' && file_exists('../brands/'.$values['Brand']) ){ ?>
	
<a href="#" onclick="OpenNewPopUp('../brandplayer.php?vd=<? echo $values['Brand'];?>&image=brands/brands_image/<?php echo $values['Image'];?>', 330, 330, 'yes' );"><? echo stripslashes($values['heading']);?></a>
	
	<?
		/*echo '<a href="#" 		
		onclick="OpenNewPopUp(\'../brandplayer.php?vd='.$values['Brand'].'&image=brands/brands_image/'.$values['Image'].'", 450, 400, \'yes\' \');">'.stripslashes($values['heading']).'</a>';*/
	}else{
		echo stripslashes($values['heading']);
	}
	?>	   </td>
    <td height="20" >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editBrand.php?active_id='.$values["brandID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?>    </td>
    <td height="20" align="center"  >
	<a href="editBrand.php?edit=<?php echo $values['brandID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>

	<a href="editBrand.php?del_id=<?php echo $values['brandID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Brand')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="4" class="no_record">Brand Not Found ! </td>
  </tr>

  <?php } ?>
    
  <tr  >  <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryBrand)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
