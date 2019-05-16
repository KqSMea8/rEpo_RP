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
		
		<a href="assignAsset.php" class="add">Assign Asset</a>
		 <? if($_GET['key']!='') {?>
	  	<a href="viewAssignAsset.php" class="grey_bt">View All</a>
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
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AssignID','<?=sizeof($arryAssignAsset)?>');" /></td>-->
      <td width="13%"  class="head1">Asset Name</td>
      <td  class="head1">Assigned To</td>
      <td width="15%" class="head1">Assigned Date</td>
      <td width="18%"  class="head1">Expected Return Date</td>
      <td width="15%" class="head1">Return Date</td>
      <td width="8%"  align="center" class="head1 head1_action">Action</td>
    </tr>
   
    <?php 
  if(is_array($arryAssignAsset) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryAssignAsset as $key=>$values){
	$flag=!$flag;
	$Line++;
	if($values["AssignDate"] != "0000-00-00")
	{
	  $AssignDate = $values["AssignDate"];		
	}else{
	   $AssignDate = "-";
	}	
	if($values["ExpectedReturnDate"] != "0000-00-00")
	{
	  $expectedDate = $values["ExpectedReturnDate"];		
	}else{
	   $expectedDate = "-";
	}
	if($values["ReturnDate"] != "0000-00-00")
	{
	  $ReturnDate = $values["ReturnDate"];	
      $ReturnDateExist = "Yes";	  
	}else{
	   $ReturnDate = "-";
	   $ReturnDateExist = "No";
	}
	
  ?>
    <tr align="left">
      <!--<td><input type="checkbox" name="AssignID[]" id="AssignID<//?=$Line?>" value="<?=$values['AssignID']?>" /></td>-->
    <td height="20">
	 <a class="fancybox fancybox.iframe" href="assetInfo.php?view=<?=$values['TagID']?>"><?=$values["AssetName"]?></a>
	
	</td>
    <td><a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=$values["EmpName"]?></a>
	</td> 
    <td><?=($AssignDate>0)?(date($Config['DateFormat'], strtotime($AssignDate))):('')?></td> 
    <td><?=($expectedDate>0)?(date($Config['DateFormat'], strtotime($expectedDate))):('')?></td> 
    <td><?=($ReturnDate>0)?(date($Config['DateFormat'], strtotime($ReturnDate))):('')?></td> 
    <td  align="center" class="head1_inner">


		<a href="viewAssignAsset.php?del_id=<?php echo $values['AssignID'];?>&amp;AssetID=<?=$values['AssetID']?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
		

	     <?php if($ReturnDateExist == "No"){?>
		 <br><a class="fancybox action_bt fancybox.iframe" href="returnAsset.php?AssignID=<?=$values['AssignID']?>&AssetID=<?=$values['AssetID']?>">Return</a>
		 <?php }?>

	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="6"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryAssignAsset)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryAssignAsset)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','AssignID','editAsset.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','AssignID','editAsset.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','AssignID','editAsset.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".action_bt").fancybox({
			autoSize: false,
			width: 450,
			height: 250
	});

});

</script>