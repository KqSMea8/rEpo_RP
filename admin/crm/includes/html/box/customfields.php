<?php

foreach($arryField as $key=>$values){
 
if($values['editable'] == 1){
    
    $mand='';
    if($values['mandatory']==1){
	
        $mand='<span class="red">*</span>';
    }
    

    if($values['type']=='text'){

            echo '<tr>
                    <td  align="right"   class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td>
                    <td    align="left" colspan="2" valign="top" >';

            echo '<input type="text" class="inputbox" name="'.$values['fieldname'].'" id="'.$values['fieldname'].'" value="'.$objField->GetCustomFieldsValue($_GET['edit'],$values['fieldid']).'" />';

            echo '</td>';

            echo '</tr>';

    }
    if($values['type']=='select'){

                echo '<tr>
                                <td  align="right"   class="blackbold">'.$values['fieldlabel'].':'.$mand.'</td>
                                <td   align="left" colspan="2" valign="top" >';
                                echo '<select name="'.$values['fieldname'].'" class="inputbox" id="'.$values['fieldname'].'"  >';
                                 $val=explode(',',$values['dropvalue']);
                                 echo '<option value="" >--Select '.$values['fieldlabel'].'--</option>';
                                  
                                 for($x=0;$x<sizeof($val);$x++) {
                                        $select =''; 
                                       if($objField->GetCustomFieldsValue($_GET['edit'],$values['fieldid']) == $val[$x]) { $select = "selected=selected";} 
                                       echo '<option value="'.$val[$x].'" '.$select.'> '.$val[$x].' </option>';
                                   } 
                           echo '</select>';  
                           echo '</td>';
                echo '</tr>';
    } 
    if($values['type']=='checkbox'){


            echo '<tr>
                        <td  align="right"   class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td>
                        <td    align="left" colspan="2" valign="top" >';

            echo '<input '.($objField->GetCustomFieldsValue($_GET['edit'],$values['fieldid']) ? 'checked=""' : "").' type="checkbox" class="inputbox" name="'.$values['fieldname'].'" id="'.$values['fieldname'].'" value="'.$values['defaultvalue'].'"  />';

            echo '</td>';

            echo '</tr>';

    }
    if($values['type']=='radio'){


            echo '<tr>
                            <td  align="right"   class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td>
                            <td    align="left" colspan="2" valign="top" >';

            echo '<input '.($objField->GetCustomFieldsValue($_GET['edit'],$values['fieldid']) ? 'checked=""' : "").' type="radio" class="inputbox" name="'.$values['fieldname'].'" id="'.$values['fieldname'].'" value="'.$values['defaultvalue'].'" />';

            echo '</td>';

            echo '</tr>';

    }
    if($values['type']=='date'){?>
	
    <tr>
        <?php echo '<td  align="right"   class="blackbold">'.$values['fieldlabel'].':'.$mand.' </td>'; ?>	
        <td  colspan="2"  align="left">
                <script>
                    $(function() {
                        $("#<?=$values['fieldname']?>").datepicker({
                            showOn: "both",
                            yearRange: '<?= date("Y") - 20 ?>:<?= date("Y") ?>',
                            dateFormat: 'yy-mm-dd',
                            maxDate: "+0D",
                            changeMonth: true,
                            changeYear: true
                        });
                    });
                </script>
                <input id="<?=$values['fieldname']?>" name="<?=$values['fieldname']?>" readonly="" class="datebox" value="<?= $objField->GetCustomFieldsValue($_GET['edit'],$values['fieldid']) ?>"  type="text" >         
        </td>
    </tr>

   <?php  }
    if($values['type']=='textarea'){ ?>

            <tr>
                    <td  align="right"   class="blackbold"><?=$values['fieldlabel'].$mand?> </td>
                    <td    align="left" colspan="2" valign="top" >

            <textarea class="inputbox" name="<?=$values['fieldname']?>" id="<?=$values['fieldname']?>"><?=$objField->GetCustomFieldsValue($_GET['edit'],$values['fieldid'])?> </textarea>

            </td>

            </tr>
            
    <?php  }
    if($values['type']=='hidden'){ ?>

            <tr>
                   <!-- <td  align="right"   class="blackbold"><?=$values['fieldlabel'].$mand?> </td>-->
                    <td    align="left" colspan="2" valign="top" >

            <input type="hidden" class="inputbox" name="<?=$values['fieldname']?>" id="<?=$values['fieldname']?>" value="<?=$values['defaultvalue']?>" />

            </td>

            </tr>        
    
    
<?php
} } }

?>