<script type="text/javascript"> 
function MoveFields() {
     $("#first_div").hide();
     $("#add_all_div").hide();
     $("#move_div").show();
     $("#cancel").show();
     $("#submit").show();
     $("#other_info").show();
     $("#entry_all").val("0");
 }



  
  $().ready(function() { 
      
   $('#fromall').click(function() { 
    return !$('#columnFrom option').remove().appendTo('#select_products2');  
   });  
   $('#add').click(function() { 
    return !$('#columnFrom option:selected').remove().appendTo('#select_products2');  
   });  
   $('#remove').click(function() {  
    return !$('#select_products2 option:selected').remove().appendTo('#columnFrom');  
   });  
   $('#removeall').click(function() { 
    return !$('#select_products2 option').remove().appendTo('#columnFrom');  
   });
  });  
 </script> 

<a href="<?= $ListUrl ?>" class="back">Back</a>
<div class="had">Manage Attribute <span> &raquo;
  <?
        $MemberTitle = (!empty($_GET['edit'])) ? (" Edit ") : (" Add ");
        echo $MemberTitle . $ModuleName;
        ?>
  </span></div>
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><form name="form1" action="" method="post"  enctype="multipart/form-data">
        <table width="100%"  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="middle"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                      <tr>
                        <td width="40%" align="right" valign="top" class="blackbold"> Select Categories Attribute Will Be Applied To : <span class="red">*</span> </td>
                        <td width="60%"  align="left" valign="top"><!--select name="attribute_categories[]" multiple class="select multiselect"  id="select_products2"-->
                            <?php/* if($arryAttributes[0]['IsGlobal'] == "Yes") { $selected = "selected"; }
                                                              if(empty($_REQUEST['edit']))   { $selected = "selected"; }
                                                       ?>
                            <option <?=$selected?> value="global">Global attribute</option>
                            <?php 
                                                                   $objCategory->getGlobalAttributeCategories(0,0,$_GET['ParentID'],$_REQUEST['edit']);*/
                                                                  ?>
                          <!--/select-->
                        </td>
                      </tr>

<tr>

<td colspan="2"><div id="move_div">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
       <td align="center" class="head" width="40%">
    Available Categories
       </td>
       <td class="head"></td>
       <td align="center" class="head" width="40%">
    Selected Categories
       </td>
</tr>
<tr>
       <td align="center" >
    <?php //By chetan//

echo '<select name="columnFrom[]" id="columnFrom"  class="inputbox" style="width:300px;height:300px;" multiple>';

  
          $objCategory->getGlobalAttributeCategories(0,0,$_GET['ParentID'],$_GET['edit']);
                                                                
//for ($j = 1; $j <= sizeof($ArrCusFlds); $j++) {
   
    //$columnHead = $column[$j - 1]["fieldname"] . ':' .  $column[$j - 1]["fieldname"] . '';

   // $sel = ($column[$j - 1]["colum_value"] == $arryColVal[$i - 1]['colvalue']) ? ('selected') : ('');
    
   /* if($ArrCusFlds[$j - 1]["fieldlabel"] != 'Country' && 
       $ArrCusFlds[$j - 1]["fieldlabel"] != 'State' &&
       $ArrCusFlds[$j - 1]["fieldlabel"] != 'Other State' &&
       $ArrCusFlds[$j - 1]["fieldlabel"]!= 'Other City' &&
       $ArrCusFlds[$j - 1]["fieldlabel"]!= 'Zip Code'     )
    {
    echo '<option value="'.$ArrCusFlds[$j - 1]["fieldname"].'#'.$ArrCusFlds[$j - 1]["fieldid"].'">'
            . '' . $ArrCusFlds[$j - 1]["fieldlabel"] . '</option>';
    }
}*/
echo '</select>';   
    
    //End//
    ?>
       </td>
       <td align="center" valign="top">
           <br><br> <br> <br> 
            <input type="button" value=" &raquo; &raquo; " name="fromall" id="fromall" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Move All</center>', 100,'')"; onMouseout="hideddrivetip()"> <br><br> 
           <input type="button" value=" &raquo;  " name="frombt" id="add" class="grey_bt" style="padding:5px;width:40px;"  onMouseover="ddrivetip('<center>Move Selected</center>', 100,'')"; onMouseout="hideddrivetip()">  <br> <br>
           <input type="button" value=" &laquo;  " name="tobt" id="remove" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Remove Selected</center>', 100,'')"; onMouseout="hideddrivetip()"> <br><br> 
           
           <input type="button" value=" &laquo; &laquo; " name="tobt" id="removeall" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Remove All</center>', 100,'')"; onMouseout="hideddrivetip()"> 
       </td>
       <td align="center">
      <?  
echo '<select name="select_products2[]" id="select_products2"  class="inputbox" style="width:300px;height:300px;" multiple>';
if($_GET['edit']>0){
$objCategory->getGlobalSelectedCategories($_GET['edit']);
}
echo '</select>';   
    
    
    ?>
       </td>
</tr>

</table>	
</div></td>
</tr>
                      <tr>
                        <td width="40%" align="right" valign="top"  class="blackbold"> Attribute Name : <span class="red">*</span> </td>
                        <td width="60%"  align="left" valign="top"><input  name="attname" id="attname" value="<?=$arryAttributes[0]['Name']?>" type="text" class="inputbox"  size="50" />
                        </td>
                      </tr>
                      <tr>
                        <td  height="30"  class="blackbold" align="right">Attribute Type  :</td>
                        <td align="left" ><select name="attribute_type" class="inputbox" id="attribute_type">
                            <option value="select">Drop-down</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td  height="30"  class="blackbold" align="right">Is this attribute active for products? :</td>
                        <td align="left" ><select  name="is_active" class="inputboxSmall" id="is_active">
                            <option value="Yes" <?php if($arryAttributes[0]['Status'] == "Yes"){echo "selected";} ?>>Yes</option>
                            <option  value="No" <?php if($arryAttributes[0]['Status'] == "No"){echo "selected";} ?>>No</option>
                          </select>
                        </td>
                      </tr>
<tr>
                        <td  height="30"  class="blackbold" align="right">Is this attribute Required? :</td>
                        <td align="left" ><select  name="required" class="inputboxSmall" id="required">
                            <option value="1" <?php if($arryAttributes[0]['required'] == "1"){echo "selected";} ?>>Yes</option>
                            <option  value="0" <?php if($arryAttributes[0]['required'] == "0"){echo "selected";} ?>>No</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td  height="30"  class="blackbold" align="right">Default Priority (used for sorting)  :</td>
                        <td align="left" ><select class="inputboxSmall" name="priority" id="priority">
                            <?php for($i=1;$i<=10;$i++){?>
                            <option value="<?=$i?>" <?php if($arryAttributes[0]['Priority'] == $i){echo "selected";} ?>>
                            <?=$i?>
                            </option>
                            <?php }?>
                          </select>
                        </td>
                      </tr>
<tr>
	<td colspan="2"  align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" >Option List</td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/global_att_form.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>
                <!--      <tr>
                        <td  align="right"   class="blackbold" valign="top">Options list (value per line) : <span class="red">*</span></td>
                        <td height="30" align="left"><textarea  name="options" id="options" class="inputbox" style="width:60%; height: 115px;"><?=$arryAttributes[0]['Options']?>
</textarea>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" ><div class="formItemComment dialog-add-attribute-help"> You are allowed to enter an unlimited number of attributes to any product. 
                            Attributes allow you to give your customer's choices for any product. 
                            Examples include size, color, or type. Each new selection must be entered on a new line for it to appear correctly. 
                            If the attribute is a price modifier, you need to tell the system to increase or decrease the price (+ or -) 
                            between parenthesis ( ) at the end of each attribute.You can also modify weight on an attribute by entering the increase or decrease after the price and separated by a comma. 
                            Examples below.<br>
                            <br>
                            <table cellspacing="0" cellpadding="0" width="100%" class="attribute-admin-list-table">
                              <tbody>
                                <tr>
                                  <td align="left" >Small(-25,-10)</td>
                                  <td align="left" >Decrease price by 25, decrease weight by 10</td>
                                </tr>
                                <tr>
                                  <td align="left" >Small(+25,+10)</td>
                                  <td align="left" >Increase price by 25, Increase weight by 10</td>
                                </tr>
                                <tr>
                                  <td align="left" >X-Large(+10)</td>
                                  <td align="left" >Increase price by 10</td>
                                </tr>
                              </tbody>
                            </table>
                          </div></td>
                      </tr>-->
                    </table>
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tbody>
                        <tr>
                          <td class="formItemControl big" align="left"><input  style="vertical-align:text-top;" type="radio" id="update_mode_save" checked="" value="save" name="update_mode">
                            <label for="update_mode_save"> <strong>Just Save Attribute</strong> - 
                            attribute data will saved into your database, but it will not make any effects on product attributes. </label>
                          </td>
                        </tr>
                        <tr>
                          <td class="formItemControl big" align="left"><input   style="vertical-align:text-top;" type="radio" id="update_mode_rewrite" value="rewrite" name="update_mode">
                            <label for="update_mode_rewrite"> <strong>Bulk Update</strong> - 
                            attribute will be updated or/and assigned with all products globally or in selected categories.
                            Attribute data will be updated, too. </label>
                          </td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="center" height="135" valign="top"><br>
              <? if ($_GET['edit'] > 0) $ButtonTitle = 'Update'; else $ButtonTitle = 'Submit'; ?>
              <input type="hidden" name="Gaid" id="Gaid" value="<?=$_GET['edit'];?>">
              <input name="Submit" type="submit" class="button" id="SaveGlobalAttribute" value=" <?= $ButtonTitle ?> " />
              &nbsp; </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
