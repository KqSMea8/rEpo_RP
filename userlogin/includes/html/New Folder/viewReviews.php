

<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewReviews.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewReviews.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>
<div class="had">
<? echo '&nbsp;Store Reviews';?>
</div>
<div class="message"><? if(!empty($_SESSION['mess_review'])) {echo $_SESSION['mess_review']; unset($_SESSION['mess_review']); }?></div>
<TABLE WIDTH="95%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
	  <td  valign="top">
	  
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
                    <tr>
                      <td> <select name="sortby" id="sortby" class="inputbox" >
					<option value="" >All</option>
						 <option value="r.Message" <? if($_GET['sortby']=='r.Message') echo 'selected';?>>Comments</option>
					 <option value="m1.CompanyName" <? if($_GET['sortby']=='m1.CompanyName') echo 'selected';?>>Store</option>
						    <option value="r.Points" <? if($_GET['sortby']=='r.Points') echo 'selected';?>>Rating</option>
							<option value="m2.UserName" <? if($_GET['sortby']=='m2.UserName') echo 'selected';?>>Rated By</option>
							<option value="r.Date" <? if($_GET['sortby']=='r.Date') echo 'selected';?>>Date</option>
					 </select></td>
					 
                      <td><input type="text" name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> </td>
					   <td>
				   
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					 </select>
					 
					 </td>
                      <td>
                        <input name="search" type="submit" class="search_button" value="Go">
					  <? if($_GET['key']!='') {?> <a href="viewReviews.php">View All</a><? }?></td>
                  
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>

  
  <tr align="left"  >
    <td width="35%" class="head1" >Comments</td>
    <td width="20%" class="head1" >Store</td>
    <td width="9%" class="head1" >Rating </td>
    <td width="12%" class="head1" >Rated By </td>
    <td width="9%"  class="head1" > Date</td>
    <td width="6%" align="left" class="head1" >Status</td>
    <td width="9%"  align="center" class="head1" >Action</td>
  </tr>
 
  <?php 
  $pagerLink=$objPager->getPager($arryReview,$RecordsPerPage,$_GET['curP']);
 (count($arryReview)>0)?($arryReview=$objPager->getPageRecords()):("");
  if(is_array($arryReview) && $num>0){
  	$flag=true;
  	foreach($arryReview as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td >
    <?=substr(stripslashes($values['Message']),0,100)?>    </td>
    <td >
		<?
		$StoreLink = $Config['Url'].$Config['StorePrefix'].$values['UserName'].'/store.php';
		echo '<Span class=red>&nbsp;<a href="'.$StoreLink.'" target="_blank" >'.stripslashes($values['CompanyName']).'</a></span>';
	  ?>

	</td>
    <td ><img src="../images_small/<?=$values['Points']?>star.png"></td>
    <td > 
	 <? echo '<a onclick="OpenNewPopUp(\'vSeller.php?edit='.$values['RaterID'].'\', 550, 660, \'no\' );" href="#" ><b>'. stripslashes($values["RatedBy"]) .'</b></a>'; 
	 ?>
	</td>
    <td >
      <? echo stripslashes($values['Date']); ?>	     </td>
    <td align="left"  ><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 
echo '<a href="editReview.php?active_id='.$values["RankingID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?></td>
    <td align="center"  >
	<a href="editReview.php?edit=<?php echo $values['RankingID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit">View</a>

	<a href="editReview.php?del_id=<?php echo $values['RankingID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Review')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

  <tr align="center" >
  	  <td height="5" colspan="7" class="myt1"></td>
  </tr>
  <?php }else{?>
  	<tr >
  	  <td height="20" colspan="7" class="no_record">No record found.</td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="7" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryReview)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
