<?php
$column = array();
$objField = new field();
if ($_GET['type'] == 'Ticket') {

    $fieldArr = $objField->getAllCustomFieldByModuleID('104');
    if($fieldArr)
    {
        
       foreach($fieldArr as $FArr){
           if(($FArr['type'] == 'checkbox' || $FArr['type'] == 'radio') &&  ($FArr['editable'] == '0' || $FArr['defaultvalue']==''))
           {
               
           }else{
               array_push($column,array("colum_name" => "".$FArr['fieldlabel']."", "table_name" => "c_ticket", "colum_value" => "".$FArr['fieldname']."",'column_type' => "".$FArr['type'].""));

           }
       }
        
    }
} else if ($_GET['type'] == 'lead') {
    $fieldArr = $objField -> getAllCustomFieldByModuleID('102');

    if($fieldArr)
    {
array_push($fieldArr,array("fieldlabel" => "City", "fieldname" => "city_id", "type" => "text"),array("fieldlabel" => "State", "fieldname" => "state_id", "type" => "text"));

       foreach($fieldArr as $FArr){
           if(($FArr['type'] == 'checkbox' ) &&  ($FArr['editable'] == '0' || $FArr['defaultvalue']==''))
           {
               
           }else{
               array_push($column,array("colum_name" => "".$FArr['fieldlabel']."", "table_name" => "c_lead", "colum_value" => "".($FArr['fieldname'] == 'assign') ? 'AssignTo' : $FArr['fieldname']."",'column_type' => "".$FArr['type'].""));

           }
       }

//array_push($column,array('column_type' => "".$FArr['type']."","colum_name" => "Highlight Row", "table_name" => "c_ticket", "colum_value" => "",'column_type' => "RowColor"));
        
    }
} else if ($_GET['type'] == 'Opportunity') {
    $fieldArr = $objField -> getAllCustomFieldByModuleID('103');
    if($fieldArr)
    {
        
       foreach($fieldArr as $FArr){
           if(($FArr['type'] == 'checkbox' || $FArr['type'] == 'radio') &&  ($FArr['editable'] == '0' || $FArr['defaultvalue']==''))
           {
               
           }else{
               array_push($column,array("colum_name" => "".$FArr['fieldlabel']."", "table_name" => "c_ticket", "colum_value" => "".$FArr['fieldname']."",'column_type' => "".$FArr['type'].""));

           }
       }
        
    }
} else if ($_GET['type'] == 'Campaign') {

    $fieldArr = $objField -> getAllCustomFieldByModuleID('106');
    if($fieldArr)
    {
       foreach($fieldArr as $FArr){
           if(($FArr['type'] == 'checkbox' || $FArr['type'] == 'radio') &&  ($FArr['editable'] == '0' || $FArr['defaultvalue']==''))
           {
               
           }else{
               array_push($column,array("colum_name" => "".$FArr['fieldlabel']."", "table_name" => "c_ticket", "colum_value" => "".$FArr['fieldname']."",'column_type' => "".$FArr['type'].""));

           }
       }
        
    }
} else if ($_GET['type'] == 'Quote') {

    $fieldArr = $objField -> getAllCustomFieldByModuleID('108');
    if($fieldArr)
    {
       foreach($fieldArr as $FArr){
           if(($FArr['type'] == 'checkbox' || $FArr['type'] == 'radio') &&  ($FArr['editable'] == '0' || $FArr['defaultvalue']==''))
           {
               
           }else{
               array_push($column,array("colum_name" => "".$FArr['fieldlabel']."", "table_name" => "c_ticket", "colum_value" => "".$FArr['fieldname']."",'column_type' => "".$FArr['type'].""));

           }
       }
        
    }
} else if ($_GET['type'] == 'Document') {

    $fieldArr = $objField -> getAllCustomFieldByModuleID('105');
    if($fieldArr)
    {
       foreach($fieldArr as $FArr){
           if(($FArr['type'] == 'checkbox' || $FArr['type'] == 'radio') &&  ($FArr['editable'] == '0' || $FArr['defaultvalue']==''))
           {
               
           }else{
               array_push($column,array("colum_name" => "".$FArr['fieldlabel']."", "table_name" => "c_ticket", "colum_value" => "".$FArr['fieldname']."",'column_type' => "".$FArr['type'].""));

           }
       }
        
    }
} else if ($_GET['type'] == 'Activity') {

    $fieldArr = $objField -> getAllCustomFieldByModuleID('136');
    if($fieldArr)
    {
       foreach($fieldArr as $FArr){
           if(($FArr['type'] == 'checkbox' || $FArr['type'] == 'radio') &&  ($FArr['editable'] == '0' || $FArr['defaultvalue']==''))
           {
               
           }else{
               array_push($column,array("colum_name" => "".$FArr['fieldlabel']."", "table_name" => "c_ticket", "colum_value" => "".$FArr['fieldname']."",'column_type' => "".$FArr['type'].""));

           }
       }
        
    }
}else if ($_GET['type'] == 'Customer') {
    
    $fieldArr = $objField -> getAllCustomFieldByModuleID('2015');
    if($fieldArr)
    {
       foreach($fieldArr as $FArr){
           //if(($FArr['type'] == 'checkbox' || $FArr['type'] == 'radio') &&  ($FArr['editable'] == '0' || $FArr['defaultvalue']==''))
           //{
               
           //}else{
               array_push($column,array("colum_name" => "".$FArr['fieldlabel']."", "table_name" => "c_ticket", "colum_value" => "".$FArr['fieldname']."",'column_type' => "".$FArr['type'].""));

           //}
       }
        
    }
}else if ($_GET['type'] == 'contact') {
    $fieldArr = $objField -> getAllCustomFieldByModuleID('107');
    if($fieldArr)
    {
       foreach($fieldArr as $FArr){
           if(($FArr['type'] == 'checkbox' || $FArr['type'] == 'radio') &&  ($FArr['editable'] == '0' || $FArr['defaultvalue']==''))
           {
               
           }else{
               array_push($column,array("colum_name" => "".$FArr['fieldlabel']."", "table_name" => "c_ticket", "colum_value" => "".$FArr['fieldname']."",'column_type' => "".$FArr['type'].""));

           }
       }
        
    }
}  



$adv_filter_options = array("e" => "equals",
    "n" => "not equal to",
    "s" => "starts with",
    "ew" => "ends with",
    "c" => "contains",
    "k" => "does not contain",
    "l" => "less than",
    "g" => "greater than",
    "m" => "less or equal",
    "h" => "greater or equal",
    "b" => "before",
    "a" => "after",
    "bw" => "between"
);
?>
