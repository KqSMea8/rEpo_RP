<div id="addimage_div" style="display:none; width: 400px; height: 350px;">
    <form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
        <input type="hidden" name="CategoryID" id="CategoryID" value="<? echo $CategoryID; ?>" /> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
            <? for ($i = $startImageCount; $i <= $MaxProductImage; $i++) { ?>	

                <tr> 
                    <td  height="30" align="right" valign="top"    class="blackbold"> 
                        Image-<?= $i ?> : </td>
                    <td  height="30" align="left" valign="top" class="blacknormal"> 
                        <input name="Image<?= $i ?>" type="file" class="inputbox" id="Image<?= $i ?>"> 
                    </td>
                </tr>	
                <tr> 
                    <td  height="50" align="right" valign="top"    class="blackbold"> 
                        Alt Text-<?= $i ?> : </td>
                    <td  height="50" align="left" valign="top" class="blacknormal"> 
                        <input name="alt_text<?= $i ?>" type="text" class="inputbox" id="alt_text<?= $i ?>"> 
                    </td>
                </tr>	

            <? } ?>   
        </table>
        <input name="Submit" type="submit" style="display: block; margin: auto;" class="button" id="<?= $ButtonID; ?>" value=" <?= $ButtonTitle ?> " <?= $DisabledButton ?> />

        <input type="hidden" name="ItemID" id="ItemID" value="<? echo $_GET['edit']; ?>" />
        <input type="hidden" name="Sku" id="Sku" value="<?= $Sku; ?>" />

        <input type="hidden" name="MaxProductImage" id="MaxProductImage" value="<? echo $MaxProductImage; ?>" />
    </form>
</div>
