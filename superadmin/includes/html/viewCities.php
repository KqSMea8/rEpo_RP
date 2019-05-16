
<script language="JavaScript1.2" type="text/javascript">
function GoState(){	

	var stateDisplay = $("#state_td").css('display');
	 
	 
	if(stateDisplay!='none'){
		if(document.getElementById("state_id") != null){
			document.getElementById("main_state_id").value = document.getElementById("state_id").value;
		}
		if(!ValidateForSelect(document.getElementById("main_state_id"), "State")){
			return false;
		}
	}

	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';

	location.href = 'viewCities.php?country_id='+document.getElementById("country_id").value+'&state_id='+document.getElementById("main_state_id").value;
	return false;
}
function AddCity(){	
	location.href = 'editCity.php?country_id='+document.getElementById("country_id").value+'&state_id='+document.getElementById("main_state_id").value;
}

	function ValidateSearch(SearchBy){	
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewCities.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCities.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
		}
</script>

<div class="had"><?php echo 'Manage Cities';?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	

<tr>
	  <td  valign="top" align="left">
 
	
	<form name="topForm" action="viewCities.php" method="get" onSubmit="return GoState();">	
	<table width="300" border="0" cellspacing="0" cellpadding="2" style="margin:0;">
  <tr >
    <td height="25" ><strong>Country&nbsp;:</strong></td>
    <td><select name="country_id"  id="country_id" class="inputbox"  onchange="Javascript: StateListSend(1);" >
      <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
      <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$_GET['country_id']){echo "selected";}?>>
      <?=$arryCountry[$i]['name']?>
      </option>
      <? } ?>
    </select></td>
  </tr>
  <tr>
    <td height="25"><strong>State :</strong></td>
    <td id="state_td">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="hidden" name="main_state_id" id="main_state_id"  value="<?=$_GET['state_id']?>" /></td>
    <td>
	
	
<input name="Submit" type="submit" id="SubmitButton" value="Go" class="search_button" <? //if(sizeof($arryState)<=0) { echo 'disabled';} ?>>

<SCRIPT LANGUAGE=JAVASCRIPT>
		StateListSend();
</SCRIPT>
</td>
  </tr>
</table>
	 
	  </form>
	  
	  
	</td>
              </tr>	
	
	


	<tr>
	  <td  valign="top">
	  


<div class="message"><? if(!empty($_SESSION['mess_city'])) {echo $_SESSION['mess_city']; unset($_SESSION['mess_city']); }?></div>

<div id="ListingRecords">

<? if(!empty($ShowRecord)){ ?>	  


	<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td align="right" ><a href="editCity.php?country_id=<?=$_GET['country_id']?>&state_id=<?=$_GET['state_id']?>" class="add" >Add City</a></td>
		</tr>
	</table>
<!--
	<form action="" method="post" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table width="81%" height="38" border="0" cellpadding="2" cellspacing="4" align="center">
                    <tr valign="bottom">
                      <td width="16%">&nbsp;</td>
                      <td width="55%" align="right" class="field">Enter the keyword to search :</td>
                      <td align="left" nowrap><input type='text' name="Keyword"  id="Keyword" class="inputbox" value="<?=$_GET['key']?>"> 
                        <input name="search" type="submit" class="inputbox" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewCities.php">View all</a><? }?></td>
                   <td width="21%" nowrap class="field">&nbsp;Search in :
				    <select name="SortBy" id="SortBy" class="inputbox" onChange="return ValidateSearch(1);">
						<option value="">All</option>
						<option value="ct.name" <? if($_GET['sortby']=='ct.name') echo 'selected';?>>City Name</option>
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


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
<td>
<input type="submit" name="Delete" class="button" style="float:right;" value="Delete" onclick="javascript: return ValidateMultiple('record','delete','NumField','city_id');">
</td>
</tr>
</table>


<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
  <tr align="left" >
    <td class="head1" >City Name</td>
    <td width="10%" align="center" class="head1" >Edit</td>
<td width="2%"  align="center" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','city_id','<?=sizeof($arryRegion)?>');" />
  </tr>

  <?php 

  if(is_array($arryRegion) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryRegion as $key=>$values){
	$flag=!$flag;
	$rowclass=($flag)?("evenbg"):("oddbg");
	$Line++;

	
  ?>
  <tr align="left"  height="30" class="<?=$rowclass?>">
    <td class="blacknormal">
      <?=stripslashes($values['name'])?>  

 
  </td>
    <td align="center" class="head1_inner">

	<a href="editCity.php?edit=<?php echo $values['city_id'];?>&curP=<?php echo $_GET['curP'];?>&country_id=<?=$_GET['country_id']?>&state_id=<?=$_GET['state_id']?>" ><?=$edit?></a>
	
	<!--a href="editCity.php?del_id=<?php echo $values['city_id'];?>&curP=<?php echo $_GET['curP'];?>&country_id=<?=$_GET['country_id']?>&state_id=<?=$_GET['state_id']?>" onClick="return confDel('City')"  ><?=$delete?></a-->	
		</td>


	 <td align="center" class="head1_inner">

<?
$zipchecked = '';
if(!empty($_GET['pk'])){
	$arryZip = $objRegion->getZipCodeByCity($values['city_id']);
	echo $numZip = sizeof($arryZip);
	if($numZip>0){
		$zipchecked = '';
	}else{
		$zipchecked = 'checked';
	}
}
?>

	  <input type="checkbox" name="city_id[]" id="city_id<?=$Line?>" value="<?=$values['city_id']?>" <?=$zipchecked?>/>
	  

	  </td>
  </tr>
  <?php } // foreach end //?>
 


  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="3"  class="no_record">No city found.</td>
  </tr>

  <?php } ?>
    
  <tr>  <td height="20" colspan="3">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if($num > count($arryRegion)){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
 <input type="hidden" name="NumField" id="NumField" value="<?=$Line?>">
</div>
</form>



<? } ?>
</div>

</td>
	</tr>
</table>
