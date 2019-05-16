<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>
<div class="had">Manage License Key</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_license'])) {echo $_SESSION['mess_license']; unset($_SESSION['mess_license']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" >
		
		<? if($_GET['key']!='') {?>
		  <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location='viewLicense.php';" />
		<? }?>
		
		<a href="editLicense.php" class="add">Add License Key</a></td>
      </tr>
	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','LicenseID','<?=sizeof($arryLicense)?>');" /></td>-->
	<td width="25%"  class="head1" >Domain Name / IP Address</td>
	<td class="head1" >License Key</td>  
    	<td width="13%" align="center" class="head1" >Number Of Users</td>
	<td width="13%" align="center" class="head1" >Expiry Date</td>
	<td width="6%"  align="center" class="head1" >Status</td>
	<td width="6%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryLicense) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryLicense as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="LicenseID[]" id="LicenseID<?=$Line?>" value="<?=$values['LicenseID']?>" /></td>-->
     
      <td ><?=stripslashes($values["DomainName"])?></td>
	
<td>
<textarea name="LicenseKey" type="text" readonly class="disabled" id="LicenseKey" maxlength="250" style="height:80px;width:350px;"><?=stripslashes($values['LicenseKey'])?></textarea>

</td>
	<td align="center" ><?=$values['MaxUser']?></td>
	<td align="center"><?  if($values['ExpiryDate']>0){
		echo date("j F, Y",strtotime($values['ExpiryDate']));
	      }
	      
	?></td>

        <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	echo '<a href="editLicense.php?active_id='.$values["LicenseID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
		
	 ?></td>
      <td  align="center"  class="head1_inner"><a href="editLicense.php?edit=<?=$values['LicenseID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	<a href="editLicense.php?del_id=<?php echo $values['LicenseID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confDel('<?=$ModuleName?>')"  ><?=$delete?></a>   

</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryLicense)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
