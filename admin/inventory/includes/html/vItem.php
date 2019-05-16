<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];

function getConditionCost(cond)
	{


 var ItemID =  $("#ItemID").val();
 var category =  $("#category").val();
//editItem.php?edit=7344&curP=1&CatID=241&tab=Price

		location.href = "vItem.php?view=" + ItemID + "&Condition="+cond+"&CatID="+category+"&tab=Price";
		LoaderSearch();
	}

function getConditionQty(cond)
	{


 var ItemID =  $("#ItemID").val();
 var category =  $("#category").val();
//editItem.php?edit=7344&curP=1&CatID=241&tab=Price

		location.href = "vItem.php?view=" + ItemID + "&Condition="+cond+"&CatID="+category+"&tab=Quantity";
		LoaderSearch();
	}
</script>
<script>
    $(document).ready(function() {
        $(".deleteProductImages").click(function() {

            var proVal = $(this).attr('alt');
            var SplitVal = proVal.split("#")
            var ItemID = <?=$_GET['view']?>
            var ImgVal = SplitVal[1];
            var CatID = <?=$_GET['CatID']?>

            //alert(CatID);
            var data = '&ItemID=' + ItemID + '&ImgVal=' + ImgVal + '&CatID=' + CatID + '&action=deleteImage';
//alert(data);
            if (data) {

                $.ajax({
                    type: "POST",
                    url: "e_ajax.php",
                    data: data,
                    success: function(msg) {
                        //alert(msg);
                        window.location.href = msg;
                    }
                });
            }

        });


    });



</script>

<? //By chetan 28Jan //
 if($_GET['pop']!=1){ ?>
<?
	/*********************/
	/*********************/
	if($_GET['view']>0){
	   	$NextArray = $objItem->NextPrevItem($_GET['view'],1);
		$PrevArray = $objItem->NextPrevItem($_GET['view'],2);
		$NextID = !empty($NextArray[0]['ItemID'])?($NextArray[0]['ItemID']):(''); 
		$NextCatID = !empty($NextArray[0]['CategoryID'])?($NextArray[0]['CategoryID']):('');
		$PrevID = !empty($PrevArray[0]['ItemID'])?($PrevArray[0]['ItemID']):(''); 
		$PrevCatID = !empty($PrevArray[0]['CategoryID'])?($PrevArray[0]['CategoryID']):('');
		$NextPrevUrl = "vItem.php?tab=basic";
		include("../includes/html/box/next_prev.php");
	}
	/*********************/
	/*********************/
?>

<a onclick="return LoaderSearch();" href="viewItem.php?curP=<?=$_GET['curP']?>" class="back">Back</a>
<?php if ($_GET["tab"] != "Transaction") { ?>
<a onclick="return LoaderSearch();" href="editItem.php?edit=<?=$_GET['view']?>&CatID=<?=$_GET['CatID']?>&tab=<?=$_GET['tab']?>" class="edit">Edit</a>
<?php }?>

<? if($_GET['view']>0){?>
<a href="editItem.php" onclick="return LoaderSearch();" class="add">Add New Item</a>
<?}?>


<? }  //End//?>
<div class="had"> 
<?php
    if ($_GET["tab"] == "Transaction") { 
        $Title = 'Transaction Item';
    }else{
        $Title = 'View Item';
    }
  ?>
<?=$MainModuleName?>   &raquo; <span><?=$Title;?></span>
    
   

</div>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">

	<?php  include("includes/html/box/item_view.php");?>

	
	</td>
    </tr>
 
</table>
