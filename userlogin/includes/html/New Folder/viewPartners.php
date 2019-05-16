<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewPartners.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewPartners.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>

<div class="had"><?php echo 'Manage Footer Logo';?></div>
<div class="message"><? if(!empty($_SESSION['mess_partner'])) {echo $_SESSION['mess_partner']; unset($_SESSION['mess_partner']); }?></div>
<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	 <tr>
		<td align="right" ><a href="editPartner.php">Add Logo</a></td>
	  </tr>
	
	
	<tr>
	  <td  valign="top">
	

<!--
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
                    <tr>
                      <td> <select name="sortby" id="sortby" class="inputbox" >
							<option value="" >All</option>
						    <option value="heading" <? if($_GET['sortby']=='heading') echo 'selected';?>>Logo Title</option>
					 </select></td>
                      <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"></td>
					  
					   <td>
				   
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					 
					 </td>
					  
                      <td  > 
                        <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewPartners.php">View All</a><? }?></td>
                  
				    </tr>
      </table></form>
	  -->
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr align="left" valign="middle" >
    <td width="1%" class="head1" >&nbsp;</td>
    <td width="62%" class="head1" >Logo Title</td>
    <td width="22%"  class="head1" >Status</td>
    <td width="13%"  align="center" class="head1" >Action</td>
  </tr>
 
  <?php 
  $pagerLink=$objPager->getPager($arryPartner,$RecordsPerPage,$_GET['curP']);
 (count($arryPartner)>0)?($arryPartner=$objPager->getPageRecords()):("");
  if(is_array($arryPartner) && $num>0){
  	$flag=true;
  	foreach($arryPartner as $key=>$values){
	$flag=!$flag;
	//$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td>
      <?php 
	if($values['Image'] !='' && file_exists('../upload/partners/'.$values['Image']) ){
	?>
	<a href="#" onclick="OpenNewPopUp('../showimage.php?img=upload/partners/<?php echo $values['Image'];?>', 150, 100, 'yes' );">
	<? echo '<img src="../resizeimage.php?w=100&h=100&img=upload/partners/'.$values['Image'].'" border=0 >';?>
	</a>
	<?
				
	}		
	?>
   </td>
    <td><?php if($values['Partner'] !='' && file_exists('../partners/'.$values['Partner']) ){ ?>
	
<a href="#" onclick="OpenNewPopUp('../partnerplayer.php?vd=<? echo $values['Partner'];?>&image=partners/partners_image/<?php echo $values['Image'];?>', 330, 330, 'yes' );"><? echo stripslashes($values['heading']);?></a>
	
	<?
		/*echo '<a href="#" 		
		onclick="OpenNewPopUp(\'../partnerplayer.php?vd='.$values['Partner'].'&image=partners/partners_image/'.$values['Image'].'", 450, 400, \'yes\' \');">'.stripslashes($values['heading']).'</a>';*/
	}else{
		echo stripslashes($values['heading']);
	}
	?>	   </td>
    <td  >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editPartner.php?active_id='.$values["partnerID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?>    </td>
    <td  align="center"  >
	<a href="editPartner.php?edit=<?php echo $values['partnerID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>

	<a href="editPartner.php?del_id=<?php echo $values['partnerID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Logo')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 


  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="4" class="no_record">No record found. </td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="4" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPartner)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
