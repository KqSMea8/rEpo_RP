<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';

	}
</script>



<div class="had">Manage Country Code</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_server'])) {echo $_SESSION['mess_server']; unset($_SESSION['mess_server']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


	<tr>
		<td >
		<span>
		<?
		Alphabets("countryCodeList.php?ch=","alpha",$_GET['ch']);
		?>
		</span>
		</td>
	</tr>

	<tr>
        <td align="right" >
		
		<? if($_GET['key']!='') {?>
		  <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location='viewCompany.php';" />
		<? }?>
		</td>
      </tr>
	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
    <td width="15%"  class="head1">Country Name</td>
    <td width="8%"  class="head1">Country Code</td>
	 <td width="8%"  class="head1">Country Prefix</td>
    <td width="6%"  align="center" class="head1">Status</td>
    <td width="6%"  align="center" class="head1">Action</td>
    </tr>
   
    <?php 

$deleteCmp = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

  if(is_array($CountryCode) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($CountryCode as $key=>$values){
	$flag=!$flag;
	$Line++;
	
?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	<td height="50"><?=stripslashes($values->name);?></td>
	<td ><?=$values->isd_code; ?></td>
   <td ><?=$values->isd_prefix; ?></td>
    <td align="center">
	<? 
	if($values->isd_status =='Active'){
	$status = 'Active';
	}else{
	$status = 'Inactive';
	}
	echo '<a href="JavaScript:void(0);" class="'.$status.'">'.$status.'</a>';
	?>
	</td>
    <td  align="center"  class="head1_inner">
	<a href="addCountryCode.php?edit=<?=$values->country_id;?>&curP=<?=$_GET['curP']?>&ch=<?=$_GET['ch']?>" ><?=$edit?></a>
    </td>
    </tr>
    <?php } // foreach end //?>
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
	<tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($CountryCode)>0){?>
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
