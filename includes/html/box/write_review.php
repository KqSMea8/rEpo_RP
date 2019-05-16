<div id="write_review_div" style="display:none; width: 400px; height: 300px;">
    <h2><?=WRITE_REVIEW?></h2>
    <form name="form1" action=""  method="post">    
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
            <tr>
                <td align="right"    class="blackbold"><?=TITLE?> <span class="red">*</span></td>
                <td height="30" align="left"  class="blacknormal">
                    <input  name="ReviewTitle" class="inputbox" id="ReviewTitle" value="" type="text" />  </td>
            </tr> 
            <tr>
                <td  height="30" align="right"  class="blackbold" ><?=REVIEW?><span class="red">*</span> </td>
                <td>
                    <textarea name="ReviewText" id="ReviewText" cols="40" rows="10"></textarea>
                </td>
            </tr>
            <tr>
                <td  height="30"  class="blackbold" align="right"><?=RATING?><span class="red">*</span> </td>
                <td>
                   <div id="new-product-rating"></div>
                   <input type="hidden" value="" name="Rating" id="Rating">
                </td>
            </tr>  
          

        </table>
          <input name="ReviewProductID" id="ReviewProductID" type="hidden" value="<?=$arryProductDetail[0]['ProductID']?>" />
          <input type="hidden" name="ReviewCustId" id="ReviewCustId" value="<?=$_SESSION['Cid'];?>">
        <input name="Submit" type="submit" style="display: block; margin: auto;" class="button" id="btnSendReview" value="<?=SEND?>" />
    </form>
</div>
