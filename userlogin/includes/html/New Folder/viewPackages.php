
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewPackages.php?curP='+frm.CurrentPage.value+'&CatID='+frm.CatID.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewPackages.php?curP='+frm.CurrentPage.value+'&CatID='+frm.CatID.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
		}
</script>

<div class="had"><?=stripslashes($arryCategory[0]['Name'])?> Packages</div>
<div class="message"><? if(!empty($_SESSION['mess_memb'])) {echo $_SESSION['mess_memb']; unset($_SESSION['mess_memb']); }?></div>
<TABLE WIDTH="95%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	 <tr>
		<td  align="right"><a href="editPackage.php?CatID=<?=$_GET['CatID']?>">Add Package</a></td>
	  </tr>
	
	<tr>
	  <td valign="top">
	

	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
                    <tr>
                      <td> <select name="sortby" id="sortby" class="inputbox" >
						<option value="">All</option>
						  <option value="Name" <? if($_GET['sortby']=='Name') echo 'selected';?>>Package</option>
						  <? if($_GET['CatID']!=6 && $_GET['CatID']!=7){ ?>
						  <option value="Type" <? if($_GET['sortby']=='Type') echo 'selected';?>>Type</option>
						  <? } ?>
						  <option value="Price" <? if($_GET['sortby']=='Price') echo 'selected';?>>Price</option>
					 </select></td>
                      <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> </td>
					   <td >				   
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					 
					 </td>
					  
					  
                      <td>
                        <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewPackages.php?CatID=<?=$_GET['CatID']?>">View All</a><? }?></td>
                  
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  <tr align="left"  >
    <td width="33%"  class="head1" >Package</td>
    <td width="25%" class="head1"  <?=$TypeDisplay?> >Type</td>
    <td width="24%" class="head1" >Price (<?=$Config['Currency']?>)</td>
    <td width="24%"  class="head1" >Status</td>
    <td width="18%"  align="center" class="head1" >Action</td>
  </tr>
 
  <? 
  $pagerLink=$objPager->getPager($arryPackage,$RecordsPerPage,$_GET['curP']);
 (count($arryPackage)>0)?($arryPackage=$objPager->getPageRecords()):("");
  if(is_array($arryPackage) && $num>0){
  	$flag=true;
  	foreach($arryPackage as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td>
	<strong><?=stripslashes($values['Name'])?></strong>	</td>
    <td  <?=$TypeDisplay?>>
      <?=stripslashes($values['Type'])?>    </td>
    <td ><span >
      <?=stripslashes($values['Price'])?>
    </span></td>
    <td  >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 
	
	  		echo '<a href="editPackage.php?active_id='.$values["PackageID"].'&CatID='.$_GET["CatID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	 
	   
	 ?>    </td>
    <td  align="center"  >
	<a href="editPackage.php?edit=<? echo $values['PackageID'];?>&CatID=<?=$_GET['CatID']?>&curP=<? echo $_GET['curP'];?>" class="edit"><?=$edit?></a>
	<? if($values['PackageID']>1){ ?>
	 <a href="editPackage.php?del_id=<? echo $values['PackageID'];?>&CatID=<?=$_GET['CatID']?>&curP=<? echo $_GET['curP'];?>" onClick="return confDel('Package')" class="edit" ><?=$delete?></a>&nbsp;
	<? } ?>	</td>
  </tr>
  <? } // foreach end //?>
 

 
  <? }else{?>
  	<tr align="center" >
  	  <td  colspan="5" class="no_record">Package Not Found ! </td>
  </tr>

  <? } ?>
    
  <tr >  <td  colspan="5" >Total Record(s) : &nbsp;<? echo $num;?>      <? if(count($arryPackage)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <? echo $pagerLink;
}?></td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>">
<input type="hidden" name="CatID" id="CatID" value="<? echo $_GET['CatID']; ?>">

</form>
</td>
	</tr>
</table>
