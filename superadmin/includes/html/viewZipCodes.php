
<script language="JavaScript1.2" type="text/javascript">
function GoState(){

	var stateDisplay = $("#state_td").css('display');


	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}
	if(stateDisplay!='none'){
		if(!ValidateForSelect(document.getElementById("main_state_id"), "State")){
			return false;
		}
	}
	if(!ValidateForSelect(document.getElementById("main_city_id"), "City")){
		return false;
	}

	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';

	location.href = 'viewZipCodes.php?country_id='+document.getElementById("country_id").value+'&state_id='+document.getElementById("main_state_id").value+'&city_id='+document.getElementById("main_city_id").value;
	return false;
}


function ValidateSearch(SearchBy){	
	var frm  = document.form1;
	var frm2 = document.form2;
	if(SearchBy==1)  {
	   location.href = 'viewZipCodes.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
	} else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
	   location.href = 'viewZipCodes.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
	}
	return false;
}
</script>

<div class="had"><?php echo 'Manage Zip Code';?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	

<tr>
	  <td  valign="top" align="left">

	
	<form name="topForm" action="viewZipCodes.php" method="get" onSubmit="return GoState();">	
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
        <td    class="blackbold"><div id="MainCityTitleDiv"><strong> City :</strong></div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	  
  <tr>
    <td><input type="hidden" name="main_state_id" id="main_state_id"  value="<?=$_GET['state_id']?>" />
	<input type="hidden" name="main_city_id" id="main_city_id"  value="<?=$_GET['city_id']?>" /></td>
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
	  


<div class="message"><? if(!empty($_SESSION['mess_zipcode'])) {echo $_SESSION['mess_zipcode']; unset($_SESSION['mess_zipcode']); }?></div>

<div id="ListingRecords">

<? if($_GET['city_id']>0){ ?>	  


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td align="right" ><a href="editZipCode.php?country_id=<?=$_GET['country_id']?>&state_id=<?=$_GET['state_id']?>&city_id=<?=$_GET['city_id']?>" class="add" >Add Zip Code</a>&nbsp;&nbsp;
	<a href="importZipCode.php?country_id=<?=$_GET['country_id']?>&state_id=<?=$_GET['state_id']?>&city_id=<?=$_GET['city_id']?>"  ><span class="export_button" >Import Zip Code</span></a>
	</td>
</tr>


</table>


<form action="" method="post" name="form1">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
<td>
<input type="submit" name="Delete" class="button" style="float:right;" value="Delete" onclick="javascript: return ValidateMultiple('record','delete','NumField','zipcode_id');">
</td>
</tr>
</table>

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
  <tr align="left" >
    <td class="head1" >Zip Code</td>
    <td width="10%" align="center" class="head1 head1_action" >Edit</td>
    <td width="1%"  align="center" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','zipcode_id','<?=sizeof($arryRegion)?>');" />
  </tr>

  <?php 
$delete5='';
  if(is_array($arryRegion) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryRegion as $key=>$values){
	$flag=!$flag;
	$rowclass=($flag)?("evenbg"):("oddbg");
	$Line++;
  ?>
  <tr align="left" height="30" class="<?=$rowclass?>">
    <td class="blacknormal">
      <?=stripslashes($values['zip_code'])?>    </td>
    <td  align="center" class="head1_inner">

	<a href="editZipCode.php?edit=<?php echo $values['zipcode_id'];?>&curP=<?php echo $_GET['curP'];?>&country_id=<?=$_GET['country_id']?>&state_id=<?=$_GET['state_id']?>&city_id=<?=$_GET['city_id']?>" ><?=$edit?></a>
	
	<a href="editZipCode.php?del_id=<?php echo $values['zipcode_id'];?>&curP=<?php echo $_GET['curP'];?>&country_id=<?=$_GET['country_id']?>&state_id=<?=$_GET['state_id']?>&city_id=<?=$_GET['city_id']?>" onClick="return confDel('Zip Code')"  ><?=$delete5?></a>		
   </td>

 <td align="center" class="head1_inner">
	  <input type="checkbox" name="zipcode_id[]" id="zipcode_id<?=$Line?>" value="<?=$values['zipcode_id']?>" />
	  
	  </td>



  </tr>
  <?php } // foreach end //?>
 


  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="3"  class="no_record">No zip code found.</td>
  </tr>

  <?php } ?>
    
  <tr>  <td height="20" colspan="3">Total Record(s) : &nbsp;<?php echo $num;?>     <?php if($num > count($arryRegion)){?>
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
