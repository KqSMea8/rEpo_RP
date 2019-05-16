

<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}

</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_vendor'])) {echo $_SESSION['mess_vendor']; unset($_SESSION['mess_vendor']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td>
		
		<a href="editVendor.php" class="add">Add Vendor</a>
		   <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_vendor.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
	 
		

		 <? if($_GET['key']!='') {?>
	  	<a href="viewVendor.php" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','VendorID','<?=sizeof($arryVendor)?>');" /></td>-->
      <td width="12%"  class="head1" >Vendor Code</td>
     <td class="head1" >Vendor Name</td>
      <td width="17%"  class="head1" >Email</td>
       <td width="12%" class="head1" >Country</td>
       <td width="12%" class="head1" >State</td>
       <td width="12%" class="head1" >City</td>
      <td width="6%"  align="center" class="head1" >Status</td>
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryVendor) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryVendor as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
      <!--<td ><input type="checkbox" name="VendorID[]" id="VendorID<?=$Line?>" value="<?=$values['VendorID']?>" /></td>-->
    <td height="20"><?=$values["VendorCode"]?>
	</td>
    <td><?=stripslashes($values["VendorName"])?></td> 
    <td><?=stripslashes($values["Email"])?></td> 
    <td><?=stripslashes($values["Country"])?></td> 
    <td><?=stripslashes($values["State"])?></td> 
    <td><?=stripslashes($values["City"])?></td> 
		 
 
    <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editVendor.php?active_id='.$values["VendorID"].'&curP='.$_GET["curP"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
		
	 ?></td>
      <td  align="center" class="head1_inner"  >
	  <a href="vVendor.php?view=<?=$values['VendorID']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	  
	  
	  <a href="editVendor.php?edit=<?=$values['VendorID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	<a href="editVendor.php?del_id=<?php echo $values['VendorID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD_FOUND?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryVendor)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryVendor)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','VendorID','editVendor.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','VendorID','editVendor.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','VendorID','editVendor.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
