<script type="text/javascript" src="../admin/FCKeditor/fckeditor.js"></script>
<script
type="text/javascript" src="../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<script language="JavaScript1.2" type="text/javascript">

    function ValidateSearch(SearchBy) {
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

<div class="message" align="center">
    <? if(!empty($_SESSION['mess_license'])){echo $_SESSION['mess_license'];unset($_SESSION['mess_license']);}?>
</div>
<?php include('siteManagementMenu.php'); ?>
<div class="clear"></div>
<form name="form1" action="" method="post" enctype="multipart/form-data">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div align="right">
                                <a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;
                            </div> <br>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
                                <tr>
                                    <td align="center" valign="top">
                                        <table width="100%" border="0" cellpadding="5" cellspacing="1">
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">
                                                    Feature<span class="red">*</span>
                                                </td>
                                                <td width="56%" align="left" valign="top">
                                                    <input name="feature" id="feature" value="<?= !empty($arryPage[0]['feature']) ? stripslashes($arryPage[0]['feature']) : ''; ?>"
                                                        type="text" class="inputbox" size="50"/><?php if (!empty($errors['feature'])){echo $errors['feature'];}?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top" class="blackbold">
                                                    Description:
                                                </td>
                                                <td width="56%" align="left" valign="top"><input
                                                        name="description" id="description"
                                                        value="<?= !empty($arryPage[0]['description']) ? stripslashes($arryPage[0]['description']) : ''; ?>"
                                                        type="text" class="inputbox" />
                                                </td>
                                            </tr>


                                            <tr>
                                                <td align="right" valign="middle" class="blackbold">Type<span class="red">*</span></td>
                                                <td align="left" valign="middle">
                                                    <select name="type"
                                                                                         id="type" class="textbox">
                                                        <option value="">Please Select</option>
                                                        <option value="text" <? if( $arryPage[0]['type'] == $arryPage[0]['type']) echo 'selected';?>>Text</option>
                                                        <option value="checkbox" <? if( $arryPage[0]['type'] == $arryPage[0]['type']) echo 'selected';?>>Check Box</option>
                                                    </select>
                                                    <?php if (!empty($errors['type'])) {
                                                        echo $errors['type'];
                                                    } ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br> <? if ($_GET['edit'] > 0) {
                            $ButtonTitle = 'Update';
                            } else {
                            $ButtonTitle = 'Submit';
                            } ?> <input type="hidden" name="id" id="id" value="<?= $id; ?>" />
                            <input name="Submit" type="submit" class="button" id="SubmitPage"
                                   value=" <?= $ButtonTitle ?> " />&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
