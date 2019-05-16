<script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
    }
    
    
 $(document).ready(function(){
     
        $("#AddSerialNumber").click(function(){
            var allSelectedSerialNumber = document.getElementById("allSelectedSerialNumber").value;
            allSelectedSerialNumber = allSelectedSerialNumber.replace(/,$/,"");
            
             var lineNumber = $("#lineNumber").val();
             var resSerialNo = allSelectedSerialNumber.split(",");
             var seriallength = resSerialNo.length;
             var totalQtyInvoced = $("#totalQtyInvoced").val();
            
                if(allSelectedSerialNumber == ""){
                     alert("Please select serial number.");
                      return false;
                }   
                
              if(seriallength > totalQtyInvoced || seriallength < totalQtyInvoced)   
                     {
                         alert("Please select "+totalQtyInvoced+" serial number only.");
                         return false;
                     }else{
                         
                          window.parent.document.getElementById("serial_value"+lineNumber).value = allSelectedSerialNumber;
                          parent.$.fancybox.close();
                     }
                     
                });
            });  
            
            
function seeList(form) { 
    var result = ""; 
    for (var i = 0; i < form.allSerialNo.length; i++) { 
        if (form.allSerialNo.options[i].selected) { 
            result += "\n " + form.allSerialNo.options[i].text+","; 
        } 
    } 
    
     //window.parent.document.getElementById("serial_value"+lineNumber).value = resSerialNo;
     document.getElementById("allSelectedSerialNumber").value = result;
    
   // alert("You have selected:" + result); 
} 
</script>
<style>
    .multiSelectBox{
         /*background-color: whitesmoke;margin-bottom: 1px;*/ 
         border-bottom: 1px solid #CCCCCC; 
         height: 18px;  
         padding: 5px 0 2px 3px;
         cursor: pointer;
         
    }
    .multiSelectBox:hover {
            background-color: whitesmoke;
           } 
           
    .fancybox-opened {
    width: auto !important;
   }
   
   .fancybox-skin {
    width: auto !important;
}
   
</style>
<?php if(empty($_GET['sku'])){?>
<table width="100%"  class="serialnumbers" border=0 align="center" cellpadding="0" cellspacing="0">
 <tr>
                   
<td align="left" class="red" align="center" style=" font-size: 14px;font-weight: bold;padding: 30px;">
Enter return Qty.
</td>
</tr>
</table>
<?php } else {?>
<div class="had">
    <?=SERIAL_NO_FPR_SKU;?> - <?=$_GET['sku']?>
  
</div>
<?php if (!empty($_SESSION['mess_Serial'])) { ?>
    <div class="redmsg" align="center"> <? echo $_SESSION['mess_Serial'];
    $dis = 1;
    ?></div>
    <? unset($_SESSION['mess_Serial']);
}
?>
<form name="addItemSerailNumber" id="addItemSerailNumber"  action=""  method="post" onSubmit="return validateI(this);"  enctype="multipart/form-data">
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
     
          <tr>
              <td align="left" valign="top" width="250px">
                          <?php if(!empty($arrySerialNumber)){?>
                          <b>Qty to Invoice: <?=$_GET['total']?></b><br>
                          
                          <?php  
                          
                          $serialValue = explode(",",$arrySerialNumber[0]['SerialNumbers']);
                          
                          //print_r($serialValue);
                          
                          
                          $serial_value_sel = explode(",",$_GET['serial_value_sel']);
                                $serial_value_sel=array_map('trim',$serial_value_sel);
                          ?>
                          
                           <select multiple="multiple" name="allSerialNo" id="allSerialNo"  class="borderall" onclick="seeList(this.form)" style="height: 250px; width: 280px;">
                          <?php for($i=0; $i< sizeof($serialValue); $i++){?>     
                               <option value="<?=$serialValue[$i]?>" class="multiSelectBox" <?php if (in_array($serialValue[$i], $serial_value_sel)){echo "selected";}?>><?=$serialValue[$i]?></option>
                          <?php }?>
                           </select> 
                          <?php } else {?>
                            <span class="red"><? echo "NO SERIAL AVAILABLE";?></span>
                          <?php }?>
                          <input type="hidden" name="lineNumber" id="lineNumber" value="<?=$_GET['id']?>">
                           <input type="hidden" name="allSelectedSerialNumber" id="allSelectedSerialNumber" value="<?=$serialValue[$i]?>">
                           <input type="hidden" name="totalQtyInvoced" id="totalQtyInvoced" value="<?=$_GET['total']?>">
                    </td>
                    <td align="left" valign="top"></td>
                </tr>
          <?php if(!empty($arrySerialNumber)){
              
                    if($_GET['view']!=1){
              ?>      
            <tr>
            <td align="center" colspan="2">
                    <input type="button" name="submit" id="AddSerialNumber" value="Select Serial Number"  class="button"/>
            </td>
            </tr>
                    <?php }
                    }?>
   
</table>
 </form>
<?php }?>