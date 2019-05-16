<script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
    }
    
    
 /*$(document).ready(function(){
     
        $("#AddCity").click(function(){

            var allSelectedCity = document.getElementById("allSelectedCity").value;
            allSelectedCity = allSelectedCity.replace(/,$/,"");
            
             var lineNumber = $("#lineNumber").val();
             var resSerialNo = allSelectedCity.split(",");
             var seriallength = resSerialNo.length;
             
            
                if(allSelectedCity == ""){

                     alert("Please select city.");
                      return false;
                }   
                
                else{
                         
                          window.parent.document.getElementById("city_id"+lineNumber).value = allSelectedCity;
                          //window.parent.document.getElementById("city"+lineNumber).style.display="block";
                          parent.$.fancybox.close();
                     }
                     
                });
            });  
            
            

function seeList(form) { 
    var result = ""; 
    alert(form.allCity.value);
    for (var i = 0; i < form.allCity.length; i++) { 
        if (form.allCity.options[i].selected) { 
            result += "\n " + form.allCity.options[i].value+","; 
        } 
    }
        
        
    
     //window.parent.document.getElementById("serial_value"+lineNumber).value = resSerialNo;
     document.getElementById("allSelectedCity").value = result;
    
   // alert("You have selected:" + result); 
} */
</script>

 <script type="text/javascript">
    $(function () {
      $("#AddCity").click(function () {
          
          var city_value_sel = document.getElementById("city_value_sel").value;
          
        if ($('.chkNumber:checked').length) {
          var chkId = '';
          $('.chkNumber:checked').each(function () {
            chkId += $(this).val() + ",";
          });
          chkId = chkId.slice(0, -1);
          //alert(chkId);
          
          if(city_value_sel != ''){
              chkId = city_value_sel+','+chkId;
          }
          
           var uniqueListIndex=chkId.split(',').filter(function(currentItem,i,allItems){
                    return (i == allItems.indexOf(currentItem));
            });

            var chkId=uniqueListIndex.join(',');
            
            
            
            var lineNumber = $("#id").val();
            window.parent.document.getElementById("city_id"+lineNumber).value = chkId;   
            parent.$.fancybox.close();
        }
        else {
          alert("Please select city.");
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



<div class="had">City List</div>
<?php if (!empty($_SESSION['mess_Serial'])) { ?>
    <div class="redmsg" align="center"> <? echo $_SESSION['mess_Serial'];
    $dis = 1;
    ?></div>
    <? unset($_SESSION['mess_Serial']);
}
?>

<!--<form name="addItemCity" id="addItemCity"  action=""  method="post" onSubmit="return validateI(this);"  enctype="multipart/form-data">-->
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
    
    <tr>
            <td align="right" valign="bottom" colspan="3">
        <form name="frmSrch" id="frmSrch" action="addCity.php" method="get" onSubmit="return ResetSearch();">
            <input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;
            <input type="hidden" name="state_id" id="state_id" value="<?=$_GET['state_id'];?>">
              <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>">
              <input type="hidden" name="city_value_sel" id="city_value_sel" value="<?=trim($_GET['city_value_sel']);?>">
            <input type="submit" name="sbt" value="Go" class="search_button">
        </form>



                    </td>
          </tr>
          <tr>
             <td align="left" valign="top" height="350" colspan="3">
                 <table width="100%"   border=2 align="center" cellpadding="0" cellspacing="0">  
      <?php if(sizeof($arryCity) > 0){
      
                                 $city_value_sel = explode(",",$_GET['city_value_sel']);
                                 $city_value_sel=array_map('trim',$city_value_sel);
    
                         $Line = 0;
                         
                        
                         
                          foreach ($arryCity as $values){  ?> 
                            
                                
                                 
                                  
                                    
                                  
                                        <?php foreach ($values['StateName'] as $value){?> 
                                         <tr>
                                            <td colspan="3" style="font-weight: bold; font-size: 14px;">

                                                    <?=$value['name'];?>

                                              </td>      
                                       </tr>
                                        
                                     <?php  } ?>
                                   
                                    
                                      <tr>
                                         <?php 
                                          
                                         foreach ($values['CityList'] as $city){
                                            
                                             ?>           
                                           
                                            <td valign="top">   
                                              <input type="checkbox" class="chkNumber" name="allCity" id="allCity" <?php if (in_array($city['city_id'], $city_value_sel)){echo "checked";}?>  value="<?=$city['city_id']?>">
                                                <?=$city['name']?>
                                            </td>
                                          
                                      <?php 
                                      
                                      if($Line%3 == 0){echo "</tr><tr>"; }
                                      
                                       $Line++;
                                              }?>
                                    
                                    
                               
                                 
              
                   
                 
              
                <?php $Line++; }?>
                         
                         <?php }?>
                          </table>                  
                         </td>
                  </tr>                             
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top"></td>
                    <td align="left" valign="top"></td>
                </tr>
          <?php if(sizeof($arryCity) > 0){?>      
            <tr>
            <td align="center" colspan="3">
                    <input type="button" name="submit" id="AddCity" value="Add City"  class="button"/>
            </td>
            </tr>
          <?php }?>
   
</table>
 <!--</form>-->
