<a href="<?= $ListUrl ?>" class="back">Back</a>
<div class="had">Manage Manufacturer <span> &raquo;
    <?
    $MemberTitle = (!empty($_GET['edit'])) ? (" Edit ") : (" Add ");
    echo $MemberTitle . $ModuleName;
    ?></span></div>
<TABLE WIDTH=768   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <form name="form1" action="" id="ManufacturerForm" method="post"  enctype="multipart/form-data"><TR>
            <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle" >
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">


                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               <?= $ModuleName ?> Name <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Mname" id="Mname" value="<?= stripslashes($arryManufacturer[0]['Mname']) ?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                             <tr>
                                                <td width="30%" align="right" valign="top"   class="blackbold"> 
                                               <?= $ModuleName ?> Code <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Mcode" id="Mcode" value="<?= stripslashes($arryManufacturer[0]['Mcode']) ?>" type="text" class="inputbox <?php if(!empty($_GET['edit'])){?>disabled<?php }?>" <?php if(!empty($_GET['edit'])){?>disabled<?php }?>  size="50" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> <?= $ModuleName ?> Website </td>
                                                <td align="left" valign="top">
                                                    <input  name="Website" id="Website" value="<?= stripslashes($arryManufacturer[0]['Website']) ?>" type="text" class="inputbox"  size="30" />
                                                </td>
                                            </tr>
                                              <tr>
                                                <td  align="right" valign="top"   class="blackbold"> <?= $ModuleName ?> Detail </td>
                                                <td align="left" valign="top">
                                                    <Textarea name="Mdetail" id="Mdetail" class="inputbox" ><?= stripslashes($arryManufacturer[0]['Mdetail']); ?></Textarea>
                                                </td>
                                            </tr>
                                            
                                            <tr> 
                                                <td   align="right" valign="top"    class="blackbold"> 
                                                    <?= $ModuleName ?> Logo : </td>
                                                <td  height="50" align="left" valign="top" class="blacknormal"> 
                                                    <input name="Image" type="file" class="inputbox" id="Image" size="19"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
                                                    <br>
                                                    (Note : Supported file types for image are: jpg, gif.) </td>
                                            </tr>
                                            <?php
                                            if ($arryManufacturer[0]['Image'] != '' && file_exists('../../upload/manufacturer/' . $arryManufacturer[0]['Image'])) {
                                               
                                                $ImageExist = 1;
                                                global $Config;
                                                ?>
                                                <tr> 
                                                    <td  align="right"  class="blackbold" valign="top">Current 
                                                        Logo : </td>
                                                    <td  height="30" align="left"> 
                                                        
                                                        <a data-fancybox-group="gallery" class="fancybox" href="../../upload/manufacturer/<? echo $arryManufacturer[0][Image]; ?>"><? echo '<img src="../../resizeimage.php?w=100&h=100&img=upload/manufacturer/' . $arryManufacturer[0]['Image'] . '&bg=000000" border=0 >'; ?></a>		
                                                         &nbsp;<input type="checkbox" name="imagedelete" value="Yes">&nbsp;Delete

                                                    </td>
                                                </tr>
                                           <? } ?>



                                            <tr>
                                                <td align="right" valign="middle"  class="blackbold">Status  </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0"  class="margin-left">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($ManufacturerStatus == 1) ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($ManufacturerStatus == 0) ? "checked" : "" ?> value="0" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>
                                           
                                           

                                        </table>
                                        
                                    </td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                           <? if ($_GET['edit'] > 0){ $ButtonTitle = 'Update'; $btnId = "UpdateManufacturer";}  else{ $ButtonTitle = 'Submit'; $btnId = "SubmitManufacturer";} ?>
                            <input type="hidden" name="Mid" id="Mid" value="<?php echo $Mid; ?>">
                            <input name="Submit" type="button" class="button" id="<?=$btnId;?>" value=" <?= $ButtonTitle ?> " />&nbsp;
                           
                    </tr>

                </table></TD>
        </TR>
    </form>
</TABLE>
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
   $("#SubmitManufacturer").click(function(){
       
            var Mname = $.trim($("#Mname").val());
            var Mcode = $.trim($("#Mcode").val());
            var ext = $('#Image').val().split('.').pop().toLowerCase();
            var data = '&Mcode=' + Mcode +'&action=checkManufacturer';
           
    if(Mname == "")
       {
           alert("Please Enter Manufacturer Name.");
           $("#Mname").focus();
           return false;
       }
       
      if(Mcode == "")
       {
        alert("Please Enter Manufacturer Code.");
        $("#Mcode").focus();
        return false;
       }
       
       if(Mcode != "")
           {
                    $.ajax({
                    type: "POST",
                    url: "e_ajax.php",
                    data: data,
                    success: function (msg) {
                         if(msg == "1")
                          {
                            alert("Manufacturer Code Already Exists");
                            $("#Mcode").focus();
                            return false;
                          }
             
                         else if(ext != "")
                                {
                                     if($.inArray(ext, ['gif','jpg','jpeg']) == -1) {
                                         alert('Please Enter JPG And Gif Image Only.');
                                         return false;
                                     }
                                     else
                                         {
                                             $("#ManufacturerForm").submit();
                                               return true;
                                         }
                                }
                             
                             else
                                 {
                                     $("#ManufacturerForm").submit();
                                     return true;
                                 }
                    
                           }
                 });
            
           }

   
     });
     
       $("#UpdateManufacturer").click(function(){
       
            var Mname = $.trim($("#Mname").val());
            var ext = $('#Image').val().split('.').pop().toLowerCase();
            
           
    if(Mname == "")
       {
           alert("Please Enter Manufacturer Name.");
           $("#Mname").focus();
           return false;
       }
       
   if(ext != "")
        {
             if($.inArray(ext, ['gif','jpg','jpeg']) == -1) {
                 alert('Please Enter JPG And Gif Image Only.');
                 return false;
             }
             else
                {
                    $("#ManufacturerForm").submit();
                    return true;
                }
        }
                             
      else
        {
            $("#ManufacturerForm").submit();
            return true;
        }
       
      

   
     });
  }); 
  </script>