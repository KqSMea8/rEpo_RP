

<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}

</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_asset'])) {echo $_SESSION['mess_asset']; unset($_SESSION['mess_asset']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td>
		
		<a href="editAsset.php" class="add">Add Asset</a>
		   <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_asset.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
	 
		

		 <? if($_GET['key']!='') {?>
	  	<a href="viewAsset.php" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left">
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AssetID','<?=sizeof($arryAsset)?>');" /></td>-->
      <td width="8%"  class="head1">Tag ID</td>
       <td width="14%"  class="head1">Serial Number</td>

      <!--td width="14%"  class="head1">Vendor Name</td-->
       <td width="14%" class="head1" >Asset Name</td>
	   
       <!--td width="10%" class="head1">Category</td-->
       <td width="8%" class="head1">Model</td>
     <td width="18%"  class="head1">Assigned To</td>
      <td width="10%"  align="center" class="head1 head1_action">Action</td>
    </tr>
   
    <?php 
  if(is_array($arryAsset) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryAsset as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
      <!--<td ><input type="checkbox" name="AssetID[]" id="AssetID<?=$Line?>" value="<?=$values['AssetID']?>" /></td>-->
    <td height="20"><a class="fancybox fancybox.iframe" href="assetInfo.php?view=<?=$values['TagID']?>" ><?=$values["TagID"]?></a>
	
	
	</td>
	 <td><?=stripslashes($values["SerialNumber"])?></td> 
    <!--td><?=stripslashes($values["VendorName"])?></td--> 
    <td><?=stripslashes($values["AssetName"])?></td> 
	
    <!--td><?=stripslashes($values["Category"])?></td--> 
    <td><?=stripslashes($values["Model"])?></td> 
    
		 
 <td>
	<?php if(!empty($values["UserName"])){?>
	 <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['AssignID']?>" ><?=$values["UserName"]?>[<?=$values['JobTitle']?>]</a>
	 <?php }else{ ?>
	 <span class="red"><?=NOT_ASSIGNED?></span>
	 
	 <?php }?>
	</td>

      <td  align="center" class="head1_inner"  >
	  <a href="vAsset.php?view=<?=$values['AssetID']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	  
	  
	  <a href="editAsset.php?edit=<?=$values['AssetID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	<a href="editAsset.php?del_id=<?php echo $values['AssetID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_ASSET_FOUND?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryAsset)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryAsset)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','AssetID','editAsset.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','AssetID','editAsset.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','AssetID','editAsset.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
