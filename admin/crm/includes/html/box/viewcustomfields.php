<?php
if($viewId)
{
    $VId = $viewId;
}else{
    $VId = $_GET['view'];
}
if(is_array($arryField)){

    foreach($arryField as $key=>$values){

            echo '<tr>
                    <td  align="right"   class="blackbold">'.$values['fieldlabel'].': </td>
                    <td    align="left" colspan="2" valign="top" >';
                    if($values['type']=='date') { 
                       
                        echo date($Config['DateFormat'], strtotime($objField->GetCustomFieldsValue($VId,$values['fieldid']))); 
                    
                    }else{
                        $res = $objField->GetCustomFieldsValue($VId,$values['fieldid']);
                        echo ($res)? $res : '<span class="red">Not specified.</span>'; 
                        
                    } 
            echo  '</td></tr>';
   
    }
 } $arryField
 ?>

