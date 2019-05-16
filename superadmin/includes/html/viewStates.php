<script language="JavaScript1.2" type="text/javascript">

function ShowState(){
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
	document.topForm.submit();

}


	function ValidateSearch(SearchBy){	
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewStates.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewStates.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
		}
</script>
<div class="had"><?php echo 'Manage States';?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
<tr>
                <td height="15">&nbsp;</td>
              </tr>	  	
<tr>
	  <td  valign="top" align="left" <?=$Config['CountryDisplay']?>>
	
	<form name="topForm" action="viewStates.php" method="get">	
		
	<?  if(sizeof($arryCountry)>0){ ?>		  
	 <strong>Country :</strong>&nbsp;&nbsp;&nbsp;
	 <select name="country"  id="country" class="inputbox" style="width:180px;" onChange="Javascript:ShowState();">
	  <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
      <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$_GET['country']){echo "selected";}?>>
      <?=$arryCountry[$i]['name']?>
      </option>
      <? } ?>
    </select>
	 <? } ?>
	  </form>
	</td>
              </tr>
  
	
	<tr>
	  <td valign="top">
	  
<div class="message"><? if(!empty($_SESSION['mess_state'])) {echo $_SESSION['mess_state']; unset($_SESSION['mess_state']); }?></div>


<div id="ListingRecords">
<? if($_GET['country']>0){ ?>	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td  align="right"><a href="editState.php?country=<?=$_GET['country']?>" class="add">Add State</a></td>
		</tr>
	</table>
<!--
	<form action="" method="post" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table width="81%" height="38" border="0" cellpadding="2" cellspacing="4" align="center">
                    <tr valign="bottom">
                      <td width="16%">&nbsp;</td>
                      <td width="55%" align="right" class="field">Enter the keyword to search :</td>
                      <td width="27%" align="left" nowrap><input type='text' name="Keyword"  id="Keyword" class="inputbox" value="<?=$_GET['key']?>"> 
                        <input name="search" type="submit" class="inputbox" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewStates.php">View all</a><? }?></td>
                   <td width="21%" nowrap class="field">&nbsp;Search in :
				    <select name="SortBy" id="SortBy" class="inputbox" onChange="return ValidateSearch(1);">
						<option value="">All</option>
						<option value="s.name" <? if($_GET['sortby']=='s.name') echo 'selected';?>>State Name</option>
					    <option value="c.name" <? if($_GET['sortby']=='c.name') echo 'selected';?>>Country Name</option>		
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
    <td class="head1" >State Name</td>
    <td width="10%" align="center" class="head1" >Action</td>
  </tr>

  <?php 
 /* $pagerLink=$objPager->getPager($arryRegion,$RecordsPerPage,$_GET['curP']);
 (count($arryRegion)>0)?($arryRegion=$objPager->getPageRecords()):("");
*/
  if(is_array($arryRegion) && $num>0){
  	$flag=true;
  	foreach($arryRegion as $key=>$values){
	$flag=!$flag;
	$rowclass=($flag)?("evenbg"):("oddbg");
  ?>
  <tr align="left"  height="30" class="<?=$rowclass?>">
    <td class="blacknormal">
      <?=stripslashes($values['name'])?>    </td>
    <td  align="center" class="head1_inner">

<a href="editState.php?edit=<?php echo $values['state_id'];?>&curP=<?php echo $_GET['curP'];?>&country=<?=$_GET['country']?>" ><?=$edit?></a>


<a href="editState.php?del_id=<?php echo $values['state_id'];?>&curP=<?php echo $_GET['curP'];?>&country=<?=$_GET['country']?>"  onClick="return confDel('State')"  ><?=$delete?></a>		</td>
  </tr>
  <?php } // foreach end //?>

  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="2"  class="no_record">No state found. </td>
  </tr>

  <?php } ?>
    
  <tr >  <td height="20" colspan="2" >Total Record(s) : &nbsp;<?php echo $num;?>  
 
</td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</div>
</form>


<? } ?>

</div>

</td>
	</tr>
</table>
