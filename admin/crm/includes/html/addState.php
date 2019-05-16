<script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
    }
    
    
 /*$(document).ready(function(){
     
        $("#AddState").click(function(){

            var state_value_sel = document.getElementById("state_value_sel").value;
            state_value_sel = state_value_sel.replace(/,$/,"");
            
             var lineNumber = $("#lineNumber").val();
             var resSerialNo = state_value_sel.split(",");
             var seriallength = resSerialNo.length;
             
            
                if(state_value_sel == ""){

                     alert("Please select state.");
                      return false;
                }   
                
                else{
                         
                          window.parent.document.getElementById("state_id"+lineNumber).value = state_value_sel;
                          window.parent.document.getElementById("city"+lineNumber).style.display="block";
                          parent.$.fancybox.close();
                     }
                     
                });
            });  
            
            

function seeList(form) { 
    var result = ""; 
    for (var i = 0; i < form.allState.length; i++) { 
        if (form.allState.options[i].selected) { 
            result += "\n " + form.allState.options[i].value+","; 
        } 
    } 
    
     //window.parent.document.getElementById("serial_value"+lineNumber).value = resSerialNo;
     document.getElementById("state_value_sel").value = result;
    
   // alert("You have selected:" + result); 
} */
</script>

<script type="text/javascript">
    $(function () {
      $("#AddState").click(function () {
          
        var state_value_sel = document.getElementById("state_value_sel").value;
       
        if ($('.chkNumber:checked').length) {
          var chkId = '';
          $('.chkNumber:checked').each(function () {
            chkId += $(this).val() + ",";
          });
          chkId = chkId.slice(0, -1);
          //alert(chkId);
          if(state_value_sel != ''){
              chkId = state_value_sel+','+chkId;
          }
          
            var uniqueListIndex=chkId.split(',').filter(function(currentItem,i,allItems){
                    return (i == allItems.indexOf(currentItem));
            });

            var chkId=uniqueListIndex.join(',');

            var lineNumber = $("#id").val();
             window.parent.document.getElementById("state_id"+lineNumber).value = chkId;
             window.parent.document.getElementById("city"+lineNumber).style.display="block";
             parent.$.fancybox.close();
        }
        else {
          alert("Please select state.");
        }
      });

      /*$('.chkSelectAll').click(function () {
        $('.chkNumber').prop('checked', $(this).is(':checked'));
      });

      $('.chkNumber').click(function () {
        if ($('.chkNumber:checked').length == $('.chkNumber').length) {
          $('.chkSelectAll').prop('checked', true);
        }
        else {
          $('.chkSelectAll').prop('checked', false);
        }
      });*/

    });
    
   
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
</style>



<div class="had">State List</div>
<?php if (!empty($_SESSION['mess_Serial'])) { ?>
    <div class="redmsg" align="center"> <? echo $_SESSION['mess_Serial'];
    $dis = 1;
    ?></div>
    <? unset($_SESSION['mess_Serial']);
}
?>
 

<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
   
     <tr>
            <td align="right" valign="bottom">
        <form name="frmSrch" id="frmSrch" action="addState.php" method="get" onSubmit="return ResetSearch();">
            <input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;
            <input type="hidden" name="country_id" id="country_id" value="<?=$_GET['country_id'];?>">
              <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>">
              <input type="hidden" name="state_value_sel" id="state_value_sel" value="<?=trim($_GET['state_value_sel']);?>">
            <input type="submit" name="sbt" value="Go" class="search_button">
        </form>



                    </td>
          </tr>
       
          <tr>
                   
                     <td align="left" valign="top" height="300">
                          <?php if(sizeof($arryState) > 0){?>
                         
                          
                          <?php  
                                 $state_value_sel = explode(",",$_GET['state_value_sel']);
                                 $state_value_sel=array_map('trim',$state_value_sel);
                          ?>
                          
                           <!--<select multiple="multiple" name="allState" id="allState"  class="borderall" onclick="seeList(this.form)" style="height: 250px; width: 280px;">
                          <?php foreach ($arryState as $value){?>    
                               
                               <option value="<?=$value['state_id']?>" class="multiSelectBox" <?php if (in_array($value['state_id'], $state_value_sel)){echo "selected";}?>><?=$value['name']?></option>
                          <?php }?>
                           </select>-->
                         
                         
                         <table width="100%"   border=2 align="center" cellpadding="0" cellspacing="0">
                               <tr>
                         <?php
                         $Line = 0;
                         foreach ($arryState as $value){
                             $Line++;
                             ?>           
                                    
                                    <td>   
                                      <input type="checkbox" class="chkNumber" name="allState" id="allState" <?php if (in_array($value['state_id'], $state_value_sel)){echo "checked";}?>  value="<?=$value['state_id']?>">
                                    <?=$value['name']?></td>
                                  
                           <?php  
                           
                           if($Line%3 == 0){echo "</tr><tr>"; }
                           
                                      } ?>
                         </table>           
                         
                          <?php } else {?>
                            <span class="red"><?=NO_STATE_FOUND;?></span>
                          <?php }?>
                          
                           
                    </td>
                    <td align="left" valign="top"></td>
                </tr>
          <?php if(sizeof($arryState) > 0){?>      
            <tr>
            <td align="center" colspan="3">
                    <input type="button" name="submit" id="AddState" value="Add State"  class="button"/>
            </td>
            </tr>
          <?php }?>
  
</table>
 
