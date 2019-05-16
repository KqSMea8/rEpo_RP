

<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}

</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_supplier'])) {echo $_SESSION['mess_supplier']; unset($_SESSION['mess_supplier']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" height="40" valign="bottom">
		
		   <? if($num2>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_supplier.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
	 
		
		<!--<a href="editCargo.php" class="add">Add Cargo</a>-->
		<a href="editCargo.php" class="add">Add Cargo</a>

		 <? if($_GET['key']!='') {?>
	  	<a href="viewCargo.php" class="grey_bt">View All</a>
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
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','SuppID','<?=sizeof($arryCargo)?>');" /></td>-->
      <td width="12%"  class="head1" >Release Date</td>
     <td  width="12%" class="head1" >Release No</td>
       <td width="12%" class="head1" >Release By</td>
       <td width="12%" class="head1" >Release To</td>
      <td width="10%"  class="head1" >Carrier Name</td>
	  <td width="10%"  class="head1" >Shipment No</td>
      <td width="6%"  align="center" class="head1" >Status</td>
      <td width="6%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryCargo) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCargo as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	<td><?=stripslashes($values["ReleaseDate"])?></td> 
      <!--<td ><input type="checkbox" name="SuppID[]" id="SuppID<?=$Line?>" value="<?=$values['SuppID']?>" /></td>-->
    <td height="20"><a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$values['SuppCode']?>" ><?=$values["SuppCode"]?></a>
	
	
	</td>
    
    <td><?=stripslashes($values["ReleaseBy"])?></td> 
    <td><?=stripslashes($values["ReleaseTo"])?></td> 
    <td><?=stripslashes($values["CarrierName"])?></td> 
    <td><?=$values["ShipmentNo"]?></td>
		
 
    <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editCargo.php?active_id='.$values["cargo_id"].'&curP='.$_GET["curP"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
		
	 ?></td>
      <td  align="center" class="head1_inner"  >
	  <a href="vCargo.php?view=<?=$values['cargo_id']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	  
	  
	  <a href="editCargo.php?edit=<?=$values['cargo_id']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	<a href="editCargo.php?del_id=<?php echo $values['cargo_id'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No Cargo found.  </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCargo)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryCargo)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','SuppID','editCargo.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','SuppID','editCargo.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','SuppID','editCargo.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
