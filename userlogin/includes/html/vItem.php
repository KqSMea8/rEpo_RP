<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
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

<div>
<a onclick="return LoaderSearch();" href="dashboard.php?curP=1&tab=items" class="back">Back</a>

</div>
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
