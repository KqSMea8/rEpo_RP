<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];


	function getConditionCost(cond)
	{


 var ItemID =  $("#ItemID").val();
 var category =  $("#category").val();
//editItem.php?edit=7344&curP=1&CatID=241&tab=Price

		location.href = "editItem.php?edit=" + ItemID + "&Condition="+cond+"&CatID="+category+"&tab=Price";
		LoaderSearch();
	}
function getConditionQty(cond)
	{


 var ItemID =  $("#ItemID").val();
 var category =  $("#category").val();
//editItem.php?edit=7344&curP=1&CatID=241&tab=Price

		location.href = "editItem.php?edit=" + ItemID + "&Condition="+cond+"&CatID="+category+"&tab=Quantity";
		LoaderSearch();
	}
	
	
	
function AvoidSpace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}


</script>


<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>


<?
	/*********************/
	/*********************/
	if($_GET['edit']>0){
	   	$NextArray = $objItem->NextPrevItem($_GET['edit'],1);
		$PrevArray = $objItem->NextPrevItem($_GET['edit'],2);

		$NextID =  (!empty($NextArray[0]['ItemID']))?($NextArray[0]['ItemID']):("");   
		$NextCatID = (!empty($NextArray[0]['CategoryID']))?($NextArray[0]['CategoryID']):("");   
		$PrevID = (!empty($PrevArray[0]['ItemID']))?($PrevArray[0]['ItemID']):("");
		$PrevCatID = (!empty($PrevArray[0]['CategoryID']))?($PrevArray[0]['CategoryID']):("");  
 
		$NextPrevUrl = "editItem.php?tab=basic";
		include("../includes/html/box/next_prev_edit.php");
	}
	/*********************/
	/*********************/
?>

	
<a href="viewItem.php?curP=<?=$_GET['curP']?>" onclick="return LoaderSearch();" class="back">Back</a>
<?php if ($_GET["tab"] != "Transaction") { ?>
<? if($_GET['edit'] !=''){?>
<a onclick="return LoaderSearch();" href="vItem.php?view=<?=$_GET['edit']?>&CatID=<?=$_GET['CatID']?>&tab=<?=$_GET['tab']?>" class="grey_bt">View</a>
<? }?>

<?php }?>




<? if($_GET['edit']>0){?>
<a href="editItem.php" onclick="return LoaderSearch();" class="add">Add New Item</a>
<?}?>


<div class="had">
   <?=$MainModuleName?> <?= $MainParentCategory ?> 
    &raquo;
    <span><?
    if ($_GET["tab"] == "Transaction") { 
        $MemberTitle = 'Transaction ';
    }else{
        $MemberTitle = (!empty($_GET['edit'])) ? ("Edit ") : ("Add ");
    }
    echo $MemberTitle . $ModuleName;
    

    ?></span>

</div>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">

	<? if (!empty($_GET['edit'])) {
           include("includes/html/box/item_edit.php");
	}else{
          include("includes/html/box/item_form.php");
	} ?>

	
	</td>
    </tr>
 
</table>


