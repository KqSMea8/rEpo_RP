
<script language="JavaScript1.2" type="text/javascript">
function submitThisForm(frm){	
	document.topForm.submit();
}
function submitThisFormCity(frm){	
	document.topFormCity.action = '';
	location.href='viewCourier.php?country='+document.topForm.country.value+'&city_opt='+document.topForm.city_opt.value+'&city='+document.topFormCity.city.value;
}



	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewCourier.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCourier.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>

<div class="had">Manage Courier Companies<?=$CourierHeading?></div>


<div class="message"><? if(!empty($_SESSION['mess_courier'])) {echo $_SESSION['mess_courier']; unset($_SESSION['mess_courier']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
			<td  height="10" align="right">
			<? if($_GET['city_opt']==1){ ?>
			<a href="viewCourier.php?country=<?=$_GET['country']?>"><strong>Back to Manage Courier Companies</strong></a>
			<? } ?>
			</td>
	</tr>
 <tr>
			<td height="30" >
		  <form name="topForm" action="viewCourier.php" method="get">	
			  
	 <select name="country" class="inputbox" id="country" style="width: 200px;" onChange="submitThisForm(this);">
	  <option value="">---Select Country---</option>
      <? for($i=0;$i<sizeof($arryCountry);$i++) {
	  
	  	  /*$objCourier->AddCourierDefault($arryCountry[$i]['country_id']);*/
	  ?>
      <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$_GET['country']){echo "selected";}?>>
      <?=$arryCountry[$i]['name']?>
      </option>
      <? } ?>
    </select>
	<input type="hidden" name="city_opt" id="city_opt"  value="<?=$_GET['city_opt']?>" />
	  </form>
			</td>
</tr>	

<? if($_GET['city_opt']==1){ ?>
<tr>
			<td height="30" >
		  <form name="topFormCity" action="viewCourier.php" method="get">	
		
	<?  if(sizeof($arryCity)>0){ ?>		  
	 <select name="city" class="inputbox" id="city" style="width: 200px;" onChange="submitThisFormCity(this);">
	  <option value="">---Select City---</option>
      <? for($i=0;$i<sizeof($arryCity);$i++) {
	  ?>
      <option value="<?=$arryCity[$i]['city_id']?>" <?  if($arryCity[$i]['city_id']==$_GET['city']){echo "selected";}?>>
      <?=$arryCity[$i]['name']?>
      </option>
      <? } ?>
    </select>
	 <? }else{?>
	 No city found.
	 <? } ?>
	  </form>
			</td>
</tr>	
<? } ?>
	<tr>
	  <td height="250" valign="top">
	  

<? if($ShowResult==1){ ?>
	<table width="80%"  border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td width="51%">&nbsp;</td>
		<td width="49%" align="right" height="30"><a href="editCourier.php?country=<?=$_GET['country']?><?=$city_suffix?>" class="Blue">Add Courier Company</a></td>
	  </tr>
	</table>
<!--
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				 <table  border="0" cellpadding="0" cellspacing="3"  id="search_table">
                    <tr>
                      <td>
					   <select name="sortby" id="sortby" class="inputbox" >
						<option value="">All</option>
						<option value="s.name" <? if($_GET['sortby']=='s.name') echo 'selected';?>>Courier Name</option>
					    <option value="c.price" <? if($_GET['sortby']=='c.price') echo 'selected';?>>Price</option>		
					 </select>
					  
					  </td>
                      <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"></td>
					  
					    <td>				   
					 <select name="asc" id="asc" class="inputbox" >
						<option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						<option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					 </select>
					 
					 </td>
					  
                      <td> 
                        <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewCourier.php">View All</a><? }?></td>
                 
				    </tr>
      </table></form>-->
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
	
  
  <tr align="left"  >
    <td width="43%" class="head1" >Courier Name</td>
    <td width="32%" class="head1" >Price ($)</td>
    <td width="25%" align="center" class="head1" >Action</td>
  </tr>
  
  <?php 
  $pagerLink=$objPager->getPager($arryCourier,$RecordsPerPage,$_GET['curP']);
 (count($arryCourier)>0)?($arryCourier=$objPager->getPageRecords()):("");
  if(is_array($arryCourier) && $num>0){
  	$flag=true;
  	foreach($arryCourier as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td >
      <?=stripslashes($values['name'])?>
   </td>
    <td >
	<?=stripslashes($values['price'])?></td>
    <td align="center" >

	<a href="editCourier.php?edit=<?=$values['courier_id']?>&curP=<?=$_GET['curP']?>&country=<?=$_GET['country']?><?=$city_suffix?>" class="edit"><?=$edit?></a> 
	<? if($values['fixed']==1){ ?>
	<a href="viewCourier.php?country=<?=$_GET['country']?>&city_opt=1" class="edit"><strong>Manage Citywise Courier</strong></a> 
	<? }else{ ?>
	<a href="editCourier.php?del_id=<?=$values['courier_id']?>&curP=<?=$_GET['curP']?>&country=<?=$_GET['country']?><?=$city_suffix?>" onClick="return confDel('Courier Company')" class="edit" ><?=$delete?></a>
	<? } ?>
		</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td colspan="3" class="no_record">No record found.</td>
  </tr>

  <?php } ?>
    
  <tr >  <td colspan="3" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCourier)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
<? } ?>
</td>
	</tr>
</table>
