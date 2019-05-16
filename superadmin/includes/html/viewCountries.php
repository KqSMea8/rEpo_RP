<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewCountries.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCountries.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
		}
</script>

<div class="had"><?php echo 'Manage Countries';?></div>
<? if(!empty($_SESSION['mess_country'])) {echo '<div class="message">'.$_SESSION['mess_country'].'</div>'; unset($_SESSION['mess_country']); }?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
		<td >
		<span>
		<?
		Alphabets("viewCountries.php?ch=","alpha",$_GET['ch']);
		?>
		</span>
		</td>
	  </tr>

	<tr>
		<td align="right" ><a href="editCountry.php?ch=<?php echo $_GET['ch'];?>" class="add">Add Country</a></td>
	  </tr>
	<tr>
	  <td  valign="top">

<!--
	<form action="" method="post" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table width="81%" height="38" border="0" cellpadding="2" cellspacing="4" align="center">
                    <tr valign="bottom">
                      <td width="16%">&nbsp;</td>
                      <td width="55%" align="right" class="field">Enter the keyword to search :</td>
                      <td align="left" nowrap><input type='text' name="Keyword"  id="Keyword" class="inputbox" value="<?=$_GET['key']?>"> 
                        <input name="search" type="submit" class="inputbox" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewCountries.php">View all</a><? }?></td>
                   <td width="21%" nowrap class="field">&nbsp;Search in :
				    <select name="SortBy" id="SortBy" class="inputbox" onChange="return ValidateSearch(1);">
					    <option value="c1.name" <? if($_GET['sortby']=='c1.name') echo 'selected';?>>Country Name</option>
					 </select>
					 <select name="Asc" id="Asc" class="inputbox" onChange="return ValidateSearch(1);">
					 	<option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						<option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					    
					 </select>
					 
					 </td>
				    </tr>
      </table></form>
	  -->
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
	
  
  <tr align="left"  >
    <td class="head1" >Country Name</td>
    <td width="10%"  align="center" class="head1" >Action</td>
  </tr>
 
  <?php 
  /*$pagerLink=$objPager->getPager($arryRegion,$RecordsPerPage,$_GET['curP']);
 (count($arryRegion)>0)?($arryRegion=$objPager->getPageRecords()):("");*/
  if(is_array($arryRegion) && $num>0){
  	$flag=true;
  	foreach($arryRegion as $key=>$values){
	$flag=!$flag;
	$rowclass=($flag)?("evenbg"):("oddbg");
  ?>
  <tr align="left" height="30" class="<?=$rowclass?>">
    <td class="blacknormal">
      <?=stripslashes($values['name'])?>  </td>
    <td align="center" class="head1_inner">

	<a href="editCountry.php?edit=<?php echo $values['country_id'];?>&ch=<?php echo $_GET['ch'];?>" ><?=$edit?></a>
	
	<a href="editCountry.php?del_id=<?php echo $values['country_id'];?>&ch=<?php echo $_GET['ch'];?>" onClick="return confDel('Country')"  ><?=$delete?></a>
	</td>
  </tr>
  <?php } // foreach end //?>
 

  <?php }else{?>
  	<tr align="center">
  	  <td height="20" colspan="2"  class="no_record">No country found. </td>
  </tr>

  <?php } ?>
    
  <tr >  <td height="20" colspan="2">Total Record(s) : &nbsp;<?php echo $num;?> 
  

</td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</div>
</form>

<br><br>
</td>
	</tr>
</table>
