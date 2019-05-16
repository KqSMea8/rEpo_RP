<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewFinicityBank.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewFinicityBank.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>
<div class="had">Manage Finicity Bank</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_license'])) {echo $_SESSION['mess_license']; unset($_SESSION['mess_license']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" >
		
		<? if($_GET['key']!='') {?>
		  <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location='viewFinicityBank.php';" />
		<? }?>
		
		
      </tr>
<tr>

<td>
                   						<a href="viewFinicityBank.php?type=Banking" class="Active" style="background-color: #535353 !important;width: 55px;font-weight: bold;padding: 5px 10px;">Banking</a>
						<a href="viewFinicityBank.php?type=Credit" class="Active" style="background-color: #535353 !important;width: 55px;font-weight: bold;padding: 5px 10px;">Credit Card</a>
						<a href="viewFinicityBank.php?type=Mortgages" class="Active" style="background-color: #535353 !important;width: 55px;font-weight: bold;padding: 5px 10px;"> Mortgages and Loans </a>
					</td>
					
                   

                </tr>
	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','LicenseID','<?=sizeof($arryInstitution)?>');" /></td>-->
	<td width="25%"  class="head1" >Institution ID</td>
	<td class="head1" >Name</td>  
<td  width="15%" class="head1" >Currency</td>
    	<td width="20%"  class="head1" >Account Type</td>
	
    </tr>
   
    <?php 
  if(is_array($arryInstitution) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryInstitution as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="LicenseID[]" id="LicenseID<?=$Line?>" value="<?=$values['LicenseID']?>" /></td>-->
     
      <td ><?=stripslashes($values["institutionID"])?></td>
	<td ><?=stripslashes($values["name"])?></td>
<td ><?=stripslashes($values["currency"])?></td>
<td ><?=stripslashes($values["accountTypeDescription"])?></td>

    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryInstitution)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryInstitution)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','LicenseID','editLicense.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','LicenseID','editLicense.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','LicenseID','editLicense.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
