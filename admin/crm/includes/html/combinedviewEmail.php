<?php
$arryNextEmail = $objImportEmail->CombinedNextEmail($UserEmailId,$_GET['ViewId']);

$arryPrevEmail = $objImportEmail->CombinedPrevEmail($UserEmailId,$_GET['ViewId']);

?>
 
                                    
                                   



<div class="had">
    View Message 
    
     <?php if($arryNextEmail[0]['autoId']> 0)
    {
         
         if($arryNextEmail[0]['MailType']=='Inbox')$type_text="Inbox";    
         if($arryNextEmail[0]['MailType']=='Sent') $type_text="Sent";    
                                   
         ?>
    <a class="next" style="margin-top:3px; margin-right: 25px;" title="Next Email" href="combinedviewEmail.php?ViewId=<?php echo $arryNextEmail[0]["autoId"] ?>&type=<?=$type_text?>&emailId=<?=$UserEmailId?>" onclick="LoaderSearch();"></a>
    <?php } ?>
    <?php if($arryPrevEmail[0]['autoId']> 0)
    {
         if($arryPrevEmail[0]['MailType']=='Inbox')$type_text="Inbox";    
         if($arryPrevEmail[0]['MailType']=='Sent') $type_text="Sent";  
        ?>
    <a class="prev" style="margin-top:3px;margin-right: 25px;" title="Previous Email" href="combinedviewEmail.php?ViewId=<?=$arryPrevEmail[0]['autoId']?>&type=<?=$type_text?>&emailId=<?=$UserEmailId?>" onclick="LoaderSearch();"></a>
    <?php } ?>

</span>
</div>
<? if (!empty($errMsg)) {?>
<div align="center"  class="red" ><?php echo $errMsg; ?></div>
<? } ?>

<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>

<link href="multiSelect/uploadfile.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="../js/jquery.uploadfile.min.js"></script>


<script type="text/javascript">
    var ew_DHTMLEditors = [];
    $(document).ready(function() {
            //$('.fancybox').fancybox();
        $(".fancybox").fancybox({
            type: 'iframe',
            afterClose: function () { // USE THIS IT IS YOUR ANSWER THE KEY WORD IS "afterClose"
                parent.location.reload(true);
            }
        });
        });

   </script>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <form name="form1" id="form1" action=""  method="post" enctype="multipart/form-data" >


        <tr>
            <td  align="center" valign="top" >


                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    <tr>
                        <td colspan="4" align="left" class="head"></td>
                    </tr>
                    <?php
                    if (is_array($arrySentItems) && $num > 0) {
                        ?>
                        <tr  >
                            <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> From : </td>
                            <td   align="left" width="15%">
    <?php
    if ($arrySentItems[0][OrgMailType] == 'Inbox') {
        echo $arrySentItems[0][From_Email];
    } else {
        echo $arrySentItems[0][FromDD];
    }
    ?>

                            </td>       
                        </tr>
                        <tr>
                            <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> To : </td>
                            <td   align="left" width="15%">


                                <input name="recipients" readonly="" type="text" class="inputbox disabled_inputbox" style="width:402px;" id="recipients" value="<?php echo $arrySentItems[0][Recipient] ?>" /> 

                            </td>




                        </tr>
    <?php if (!empty($arrySentItems[0][Cc])) {
        ?>
                            <tr id="CCC"  >
                                <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Cc : </td>
                                <td   align="left" width="15%">

                                    <input name="Cc" readonly="" type="text" class="inputbox disabled_inputbox" style="width:402px;" id="Cc" value="<?php echo $arrySentItems[0][Cc] ?>" /> 

                                </td>




                            </tr>
    <?php } ?>
    <?php if (!empty($arrySentItems[0][Bcc])) {
        ?>
                            <tr id=""  >
                                <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Bcc : </td>
                                <td   align="left" width="15%">


                                    <input name="Bcc" readonly="" type="text" class="inputbox disabled_inputbox" style="width:402px;" id="Bcc" value="<?php echo $arrySentItems[0][Bcc] ?> " />
                                </td>



                            </tr>

    <?php } ?>

                        <tr  >
                            <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Subject : </td>
                            <td   align="left" width="15%">
                                <input name="Subject" readonly="" type="text" class="inputbox disabled_inputbox" style="width:402px;" value="<?php echo stripcslashes($arrySentItems[0][Subject]) ?>" />

                            </td>       
                        </tr>

                        <tr  >
                            <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Date : </td>
                            <td   align="left" width="15%">
    <?php
    echo date("F j, Y, g:i a", strtotime($arrySentItems[0][composedDate]));
    ?>

                            </td>       
                        </tr>

                        <tr>
                            <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> &nbsp; </td>      
                            <td  align="left" >
    <?php echo trim(stripslashes(str_replace('<br type="_moz" />', '', $arrySentItems[0]['EmailContent']))); ?>
                            </td>
                        </tr>

                        <tr>
                            <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> &nbsp; </td>      
                            <td  align="left" >


                            </td>
                        </tr>

    <?php
    $arryAttachment = $objImportEmail->GetAttachmentFileName($_GET['ViewId']);


    if (count($arryAttachment) > 0) {
        ?>
                            <tr  >
                                <td  align="" width="6%"   class="blackbold" style="padding-left:10px;">Attachment :<span class="red">*</span> </td>
                                <td   align="left" width="15%">

                            <?php
                            foreach ($arryAttachment as $key => $values) {

                                echo $values[FileName];
                                ?>  

                                        <a href="importdwn.php?file=upload/emailattachment/<?php echo $_SESSION[AdminEmail] . '/' . $values[FileName] ?>" class="download">Download</a><br> <br>


                                        </div>
                                    <?php }
                                    ?>
                                </td>




                            </tr>

                                <?php } ?>
                            <?php } else { ?>


                        <tr id=""  >
                            <td  align="" width="6%"   class="blackbold" style="padding-left:10px;">
                                No Email Found </td>

                        </tr>
<?php } ?>

                </table>	

            </td>
        </tr>
        <tr>
            <td  align="center">

                <div id="SubmitDiv" style="display:none1">




                </div>

            </td>
        </tr>
        <input type="hidden" name="Type" value="<?= $Type ?>">
        <input type="hidden" name="ViewId" value="<?= $_GET['ViewId'] ?>">
    </form>
</table>