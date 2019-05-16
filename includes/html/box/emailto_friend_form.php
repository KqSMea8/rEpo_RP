<div id="emailTo_Friend_div" style="display:none; width: 400px; height: 300px;">
    <h2><?=EMAIL_TO_FRIEND?></h2>
    <form name="form1" action=""  method="post">    
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
            <tr>
                <td align="right"    class="blackbold"><?=YOUR_NAME?> <span class="red">*</span></td>
                <td height="30" align="left"  class="blacknormal">
                    <input  name="yname" class="inputbox" id="yname" value="" type="text" />  </td>
            </tr> 
            <tr>
                <td  height="30" align="right"  class="blackbold" ><?=YOUR_EMAIL?><span class="red">*</span> </td>
                <td><input  name="yemail" id="yemail" class="inputbox" value="" type="text" /></td>
            </tr>
            <tr>
                <td  height="30"  class="blackbold" align="right"><?=stripslashes(YOUR_FRIEND_NAME)?><span class="red">*</span> </td>
                <td>
                    <input  name="fname" id="fname" class="inputbox" value="" type="text" />
                </td>
            </tr>  
            <tr>
                <td  height="30"  class="blackbold" align="right"><?=YOUR_FRIEND_EMAIL?><span class="red">*</span></td>
                <td> <input  name="femail" id="femail" class="inputbox" value="" type="text" /></td>
            </tr>  

        </table>
        
        <input  name="ProductID" id="ProductID" class="inputbox" value="<?=$arryProductDetail[0]['ProductID']?>" type="hidden" />
        <input  name="ProductName" id="ProductName" class="inputbox" value="<?=$arryProductDetail[0]['Name']?>" type="hidden" />
        <input  name="PrdLink" id="PrdLink" class="inputbox" value="<?=$PrdLink?>" type="hidden" />
          
        <input name="Submit" type="submit" style="display: block; margin: auto;" class="button" id="btnemailtofriend" value="<?=EMAIL_TO_FRIEND?>" />
    </form>
</div>
