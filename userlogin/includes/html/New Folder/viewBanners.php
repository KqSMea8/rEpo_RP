
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){
	/*	
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewBanners.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewBanners.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>
<div class="had"><?php echo 'Manage Banners';?></div>
<div class="message"><? if(!empty($_SESSION['mess_banner'])) {echo '<br><br>'.$_SESSION['mess_banner'].'<br><br>'; unset($_SESSION['mess_banner']); }?></div>
<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
	  <td align="right">
	  <a href="editBanner.php" class="Blue">Add Banner</a>
	  </td>
	  </tr>
	  
<tr>
	  <td  valign="top">


	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table border="0" cellpadding="0" cellspacing="4" id="search_table">
                    <tr>
                    
                      <td ><select name="sortby" id="sortby" class="inputbox" >
                        <option value="">All</option>
                        <option value="b.Title" <? if($_GET['sortby']=='b.Title') echo 'selected';?>>Banner Title</option>
                        <!--<option value="m.UserName" <? if($_GET['sortby']=='m.UserName') echo 'selected';?>>Posted By</option>
					<option value="b.Position" <? if($_GET['sortby']=='b.Position') echo 'selected';?>>Display Zone</option>
					<option value="b.BannerType" <? if($_GET['sortby']=='b.BannerType') echo 'selected';?>>Banner Type</option>-->
                        <option value="b.Status" <? if($_GET['sortby']=='b.Status') echo 'selected';?>>Status</option>
                      </select></td>
                      <td  ><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"></td  > 
					  
					   <td >
				    
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					 
					 </td>
					  
					  
                       <td  > <input name="search" type="submit" class="search_button" value="Go">
					  <? if($_GET['key']!='') {?> <a href="viewBanners.php">View All</a><? }?></td>
                   
				  
				   
				   
				   
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>

  <tr align="left" valign="middle" >
    <td width="34%" class="head1" >Banner </td>
    <td width="40%" class="head1" >Clicks<!--Posted By--></td>
    <td width="2%" class="head1" ><!--Display Zone--></td>
    <td width="2%" class="head1" ><!--Banner Type --></td>
    <td width="2%" class="head1" ><!--Payment--></td>
    <td width="6%" height="20" class="head1 style1" >Status</td>
    <td width="14%" height="20" align="center" class="head1 style1" >Action</td>
  </tr>
  
  <?php 
  $pagerLink=$objPager->getPager($arryBanner,$RecordsPerPage,$_GET['curP']);
 (count($arryBanner)>0)?($arryBanner=$objPager->getPageRecords()):("");
  if(is_array($arryBanner) && $num>0){
  	$flag=true;
  	foreach($arryBanner as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  
	//if($values['Status']<=0){ $bgcolor="#000000"; }
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td valign="top">
	
	<table width="200" border="0" cellspacing="1" cellpadding="1">
  <tr>
     <? 
	
	 if($values['Image'] !='' && file_exists('../banner/'.$values['Image']) ){  
	 				
		$ImgPath = '../resizeimage.php?w=60&h=60&img=banner/'.$values['Image'];
	 
	 
	 #echo '<td align="left" width="70"><a onclick="OpenNewPopUp(\'../showimage.php?img='.$values["BannerUrl"].'\', 350, 360, \'no\' );" href="#" alt="Click to View Banner" title="Click to View Banner"><img src="'.$ImgPath.'" border="0"></a></td>';

	 echo '<td align="left" width="200"><a onclick="OpenNewPopUp(\'../banner/'.$values["Image"].'\', 350, 360, \'no\' );" href="#" alt="Click to View Banner" title="Click to View Banner"><b>'.stripslashes($values["Title"]).'</b></a></td>';

	}else{
		echo '<td align="left" width="200">'.stripslashes($values["Title"]).'</td>';
	}				
	
		
						
	?>	
    <td align="left"><?=stripslashes($values["Title55"])?>
							</td>
  </tr>
</table>

	
	
	
						
						
						
						</td>
    <td class="blacknormal"><?=$values['Clicks']?>
      <?php
	/*
	if($values['MemberID'] > 0 && $values['UserName'] !=''){
		echo '<a onclick="OpenNewPopUp(\'vSeller.php?edit='.$values['MemberID'].'\', 650, 600, \'no\' );" href="#" class="Blue">'.$values['UserName'].'</span>';
	}else if($values['MemberID'] > 0){
		echo '<span class="red">(Member Removed)</span><span class="blacknormal">'.$values['UserName'].'</span>';
	}else{
		echo '<span class="blacknormal">Admin</span>';
	}
*/
	?>    </td>
    <td class="blacknormal"><? //echo $values['Position']; ?></td>
    <td class="blacknormal"><? //echo $values['BannerType']; ?></td>
    <td class="blacknormal"><? //if($values['Payment']==1) echo '<strong>Received</strong>'; else echo 'Pending';?></td>
    <td height="20" >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	echo  $status;
	/*
	 if($values['ActDate']>0){
		echo '<a href="editBanner.php?active_id='.$values["BannerID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
	 }else{
	 	echo  $status;
	 }*/
		
	 ?>    </td>
    <td height="20" align="center"  >
	<a href="editBanner.php?edit=<?php echo $values['BannerID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>
	<a href="editBanner.php?del_id=<?php echo $values['BannerID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Banner')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr >
  	  <td height="20" colspan="7" class="no_record">No Banner Found. </td>
  </tr>

  <?php } ?>
    
  <tr >  <td height="20" colspan="7" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryBanner)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
