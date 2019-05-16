<div class="had">
<?=$MainModuleName?>   <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$SubHeading) :("Add ".$ModuleName); ?>
		
		</span>
</div>
<form name="form1" action="" method="post"  enctype="multipart/form-data">
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="top">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <div  align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div><br>
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">


                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
											<tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                   Theme Name : </td>
                                                <td width="56%"  align="left" valign="top">
													<input  name="themeName" id="themeName" value="<?= stripslashes($arryTheme[0]['themeName']) ?>" type="text" class="inputbox" />
                                                    
                                                </td>
                                            </tr>
											<tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                                    Image :<span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                     <input  name="thumb_image" id="thumb_image" type="file" class="inputbox"  size="50" />
                                                    <br>
                                                                        <?= $MSG[201] ?>	
                                                    
                                                                        <br>
                                                                        
                                                  <?php
													$MainDir = $Prefix."template/".$_SESSION['CmpID']."/".$ThemeId."/"; 
													//$MainDir = $_SERVER["DOCUMENT_ROOT"]."/web/upload/company/logo/"; 
													if ($arryTheme[0]['thumb_image'] != '' && file_exists($MainDir.$arryTheme[0]['thumb_image'])) { 
													 $OldImage = $MainDir . $arryTheme[0]['thumb_image']; 
													?>
													<span id="DeleteSpan">
													<input type="hidden" name="OldImage" value="<?=$OldImage?>">  
													
													<a data-fancybox-group="gallery" class="fancybox" href="<?=$MainDir.$arryTheme[0]['thumb_image']?>">
													<? echo '<img src="resizeimage.php?w=200&h=200&img=' . $MainDir. $arryTheme[0]['thumb_image'] . '" border=0  >'; ?>
													</a>&nbsp;
													<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryTheme[0]['thumb_image']?>','DeleteSpan')" onmouseout="hideddrivetip();">
													<?=$delete?></a>
													
													</span>	
													                                                                           
													 <? } ?>
                                                </td>
                                            </tr>

                                           

                                        </table>

                                    </td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                            <? if ($_GET['edit'] > 0) {
                                $ButtonTitle = 'Update';
                            } else {
                                $ButtonTitle = 'Submit';
                            } ?>
                           <input type="hidden" name="id" id="id" value="<?= $ThemeId; ?>" />
                            <input name="Submit" type="submit" class="button" id="SubmitTheme" value=" <?= $ButtonTitle ?> " />&nbsp;
                        </td> 
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</form>

<script>
$(document).ready(function() {
$("#SubmitTheme").click(function(){
    var Name = $.trim($("#themeName").val());

    if(Name == "")
    {
        alert("Please Enter Theme Name");
        $("themeName").focus();
        return false;
    }

   
    
    ShowHideLoader('1','S');

});

});
</script>