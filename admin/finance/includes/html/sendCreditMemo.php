<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">

    function validateMail() {
	var frm = document.formMail;
	if(document.getElementById("ToEmail").value =='Other'){		 
		if(!isEmail(frm.OtherEmail)){
			return false;
		}
	}else{
		if(!ValidateForSelect(document.getElementById("ToEmail"),"Email")){
			return false;
		}	
	}

        if (isEmailOpt(frm.CCEmail)
                ) {
            document.getElementById("prv_msg_div").style.display = 'block';
            document.getElementById("preview_div").style.display = 'none';
		frm.submit();
            return true;

        } else {
            return false;
        }


    }

//bysachin 
    function makepdffile(url) {
        var tempid = document.getElementById("tempID").value;

        var url1 = url + '&tempid=' + tempid;
        //alert(url1);
        $.ajax({
            url: url1,
//            success: function(data){alert(data);}
        });
    }


 function SetOtherEmail(){
	 if(document.getElementById("ToEmail").value=='Other'){
		 document.getElementById("OtherEmail").style.display = 'inline';
			
	}else {
		document.getElementById("OtherEmail").style.display = 'none';
	}
 }

</script>



<? 

if(!empty($ErrorMSG)){
echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>
<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">	
    <div class="had"><?= 'Send ' . $module ?> </div>
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left">

                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
                    <tr>
                        <td colspan="2" align="left" class="head"><?= $module ?> Information</td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold" width="20%"> Credit Memo ID # : </td>
                        <td   align="left" ><B><?= stripslashes($arryPurchase[0]['CreditID']) ?></B></td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold" width="20%"> Posted Date : </td>
                        <td   align="left" ><?= ($arryPurchase[0]['PostedDate'] > 0) ? (date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))) : (NOT_SPECIFIED) ?></td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold" >Created By  : </td>
                        <td   align="left" >
                            <?
                            if($arryPurchase[0]['AdminType'] == 'admin'){
                            $CreatedBy = 'Administrator';
                            }else{
                            $CreatedBy = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arryPurchase[0]['AdminID'].'" >'.stripslashes($arryPurchase[0]['CreatedBy']).'</a>';
                            }
                            echo $CreatedBy;
                            ?></td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold" >Approved  : </td>
                        <td   align="left"  >
                            <?= ($arryPurchase[0]['Approved'] == 1) ? ('<span class=green>Yes</span>') : ('<span class=red>No</span>') ?>

                        </td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold" >Order Status  : </td>
                        <td   align="left" >
                            <? 
                            if($arryPurchase[0]['Status'] == 'Cancelled' || $arryPurchase[0]['Status'] == 'Rejected'){
                            $StatusCls = 'red';
                            }else if($arryPurchase[0]['Status'] == 'Completed'){
                            $StatusCls = 'green';
                            }else{
                            $StatusCls = '';
                            }

                            echo '<span class="'.$StatusCls.'">'.$arryPurchase[0]['Status'].'</span>';

                            ?>

                        </td>
                    </tr>


                    <tr>
                        <td  align="right"   class="blackbold" > Vendor  : </td>
                        <td   align="left" >

                            <a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?= $arryPurchase[0]['SuppCode'] ?>" ><?= stripslashes($arryPurchase[0]['VendorName']) ?></a>		</td>
                    </tr>

                    <tr>
                        <td align="right"   class="blackbold">Vendor Email  : </td>
                        <td  align="left" ><?= stripslashes($arryPurchase[0]['Email']) ?></td>
                    </tr>


                </table>

            </td>
        </tr>





        <tr>
            <td  align="center" valign="top" >

                <form name="formMail" action=""  method="post" enctype="multipart/form-data">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
                        <tr>
                            <td colspan="2" align="left" class="head" >Send Email</td>
                        </tr>
                        <tr>
                            <td  align="right"   class="blackbold" width="20%" valign="top">To  : </td>
                            <td align="left">

                           
                                <!--input type="text" name="ToEmail" id="ToEmail" value="<?= stripslashes($arryPurchase[0]['Email']) ?>" class="disabled_inputbox" readonly-->


<select class="inputbox" name="ToEmail[]" id="ToEmail" onchange="Javascript: SetOtherEmail();" multiple style="height:100px<?=$ToEmailHide?>" >       
	<? 
if(!empty($arrayEmail)){
foreach($arrayEmail as $Email){ ?>
		<option value="<?=$Email?>" <?=($MainEmail==$Email)?('selected'):('')?>><?=$Email?></option> 
	<?php } }?>           
       <option value="Other"  <?=$OtherSelected?>>Other</option>
</select> 

<input type="text" name="OtherEmail" placeholder="Please Enter Email" id="OtherEmail" value="" <?=$OtherEmailHide?> class="inputbox" maxlength="50">


                            </td>
                        </tr>
                        <tr>
                            <td  align="right"   class="blackbold" >CC  : </td>
                            <td   align="left"  >
                                <input type="text" name="CCEmail" id="CCEmail" value="" class="inputbox" maxlength="80">
                                <a href="../signature.php?ModuleId=<?php echo $_GET['view']?>&ModuleName=<?php echo $ModuleDepName?>&Module=<?php echo $ModuleDepName.$_GET['module']?>" class="fancybox fancybox.iframe" style="font-weight: bold;">Signature</a>

                            </td>
                        </tr>
                        <!--temp code by sachin -->
                         <?php if (sizeof($GetPFdTempalteNameArray) > 0) { ?>
                            <tr>

                                <td  align="right"   class="blackbold" width="20%">Template : </td>
                                <td   align="left" >
                                    <select class="inputbox" name='tempidd' id="tempID" onchange='makepdffile("../pdfCommonhtml.php?o=<?= $_GET['view'] ?>&module=<?= $_GET['moduleu'] ?>&attachfile=1&ModuleDepName=<?= $ModuleDepName ?>")'>
                                        <option value="">Default</option>
                                        <?php
                                        foreach ($GetPFdTempalteNameArray as $vals) {

                                            echo '<option value="' . $vals['id'] . '">' . $vals['TemplateName'] . '</option>';
                                        }
                                        ?>
                                    </select>
                     <!--            <input type="text" name="tempid" id='tempid' value="3"/>-->
                                </td>
                            </tr>
<?php } ?>
                            <!--temp code by sachin -->
                        <tr>
                            <td  align="right"   class="blackbold" valign="top">Message  : </td>
                            <td   align="left"  >
                                <textarea name="Message" id="Message" class="bigbox" maxlength="500"></textarea>

                            </td>
                        </tr>
                        <tr>
                            <td  align="right"   class="blackbold" ></td>
                            <td   align="left"  >
                                <input type="button" name="butt" id="butt" class="button" value="Send" onClick="javascript: validateMail();">

                            </td>
                        </tr>
                    </table>	
                </form>

            </td>
        </tr>




    </table>
</div>

 

<script type="text/javascript">

    var editorName = 'Message';

    var editor = new ew_DHTMLEditor(editorName);
//EmailCompose
    editor.create = function () {
        var sBasePath = '../FCKeditor/';
        var oFCKeditor = new FCKeditor(editorName, '100%', 200, 'Basic');
        oFCKeditor.BasePath = sBasePath;
        oFCKeditor.ReplaceTextarea();
        this.active = true;
    }
    ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

    ew_CreateEditor();


</script>

<? } ?>

