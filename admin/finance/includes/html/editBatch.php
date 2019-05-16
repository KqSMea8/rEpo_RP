<div><a href="<?= $RedirectURL ?>"  class="back">Back</a></div>

<div class="had">
    <?= $MainModuleName ?>    <span> &raquo;
        <? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>

    </span>
</div>

<? if (!empty($errMsg)) {?>
<div  class="red" ><?php echo $errMsg; ?></div>
<? } ?>

<script language="JavaScript1.2" type="text/javascript">
    function validateBatch(frm) {
        if (!ValidateForSimpleBlank(frm.BatchName, "Batch Name")) {
            return false;
        }
          
        var Url = "isRecordExists.php?BatchName="+escape(document.getElementById("BatchName").value)+"&BatchType="+escape(document.getElementById("BatchType").value)+"&editID="+escape(document.getElementById("BatchID").value);
        SendExistRequest(Url, "BatchName", "Batch Name");
        return false;
    }
 
</script>



    <form name="form1" action=""  method="post" onSubmit="return validateBatch(this);" enctype="multipart/form-data">
  <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
   <tbody>
       <tr>
            <td valign="top" align="center">
                <table width="100%" cellspacing="0" cellpadding="5" border="0" class="borderall">
                <tbody>
                    
                   
			 <tr>
                        <td  align="right"   class="blackbold" width="45%"> Batch Name  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <input name="BatchName" type="text" class="inputbox" id="BatchName" value="<?php echo stripslashes($arryBatch[0]['BatchName']); ?>"  maxlength="30"   onKeyPress="Javascript:return isAlphaKey(event);"/>            </td>
                    
                    </tr>
                    
                                   
  
                    <tr>
                        <td  align="right"  valign="top" class="blackbold" >   Description  : </td>
                        <td  align="left"  >                            
                          <textarea id="Description" class="inputbox" maxlenghth="250" name="Description" type="text"><?php echo stripslashes($arryBatch[0]['Description']); ?></textarea>

                        </td>
                    </tr>
                    
                  
                   
                    <tr>
                        <td align="right">Status : </td>
                    
                    <td   align="left" >
                        <input type="radio" <?php echo $Status==0?"checked":''; ?>  value="0" id="Status" name="Status">
                        Open&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" <?php echo $Status==1?"checked":''; ?> value="1" id="Status" name="Status">
                        Closed </td>
                    </tr>    
                    
                </tbody>
                </table>	
	</td>
   </tr>
   
    <tr>
            <td  align="center">
                <div id="SubmitDiv" style="display:none1">
                    <? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
                    <input type="hidden" name="BatchID" id="BatchID" value="<?= $_GET['edit'] ?>" />
		  <input type="hidden" name="BatchType" id="BatchType" value="<?=$_GET['BatchType']?>" />

                </div>
            </td>
        </tr>
</tbody>
</table>
       
    </form>





