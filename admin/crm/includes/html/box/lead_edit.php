<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>



<div class="right_box"> 
<form name="form1" id="form1" action=""  method="post"  enctype="multipart/form-data">
    <table width="100%"  border="0" cellpadding="0" cellspacing="0">
       

            <? if (!empty($_SESSION['mess_lead'])) { ?>
                <tr>
                    <td  align="center"  class="message"  >
                        <? if (!empty($_SESSION['mess_lead'])) {
                            echo $_SESSION['mess_lead'];
                            unset($_SESSION['mess_lead']);
                        } ?>	
                    </td>
                </tr>
<? } ?>

            <tr>
                <td  align="center" valign="top" >


                    <table class="borderall" width="100%" cellspacing="0" cellpadding="5" border="0">

                     <?php
//By Chetan//
$head = 1;
$arrayvalues = $arryLead[0];
for($h=0;$h<sizeof($arryHead);$h++){
?>
    <tr>
        <td colspan="4" align="left" class="head_desc"><?=$arryHead[$h]['head_value']?></td>
    </tr>
 <?php if($h==0){?>    
    <tr>
        <td   align="right"   class="blackbold"> Created Date : </td>
        <td   align="left" colspan="3">
            <?php
            if ($arryLead[0]['UpdatedDate'] > 0)
                echo date($Config['DateFormat'], strtotime($arryLead[0]['UpdatedDate']));
            else
                echo NOT_SPECIFIED;
            ?>
        </td>
    </tr>

 <?php } $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
include("includes/html/box/CustomFieldsNew.php");
 } 
  //End//
?>        

	

</table>	



<script type="text/javascript">
                        $('#piGal table').bxGallery({
                            maxwidth: 300,
                            maxheight: 200,
                            thumbwidth: 75,
                            thumbcontainer: 300,
                            load_image: 'ext/jquery/bxGallery/spinner.gif'
                        });
                    </script>


<script type="text/javascript">
                        $("#piGal a[rel^='fancybox']").fancybox({
                            cyclic: true
                        });
                    </script>



	
	  
	
	</td>
   </tr>

   

   <tr>
    <td  align="center" >
	
	<div id="SubmitDiv" <?= $dis ?>>
	
<? if ($_GET['edit'] > 0) $ButtonTitle = 'Update ';
else $ButtonTitle = ' Submit '; ?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
<!--By Chetan
       <input type="hidden" name="fieldIds" value="<?=$StrField?>">
      <input type="hidden" name="fields" value="<?=$StrFieldName?>">
<!--End-->



</div>
<input type="hidden" name="leadID" id="leadID" value="<?= $_GET['edit'] ?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryLead[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryLead[0]['city_id']; ?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?= $_SESSION['AdminType'] ?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?= $_SESSION['AdminID'] ?>" />

</td>
   </tr>
  
</table> 
</form>
</div>
<SCRIPT LANGUAGE=JAVASCRIPT>
<? if ($_GET["tab"] == "Lead") { ?>
        StateListSend();
<? } ?>
<? if ($_GET["tab"] == "account") { ?>
        ShowPermission();
<? } ?>
</SCRIPT>
<script>
<? if ($arryLead[0]['type'] == 'Company') { ?>
    //document.getElementById('com').style.display = 'block';
        ltype();
<? } ?>
</script>


