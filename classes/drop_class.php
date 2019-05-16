<?


class dropdown  {
   

/*
 * @multi select dropdown menu
 *
 * @param string $name
 *
 * @param array $options
 *
 * @param array $selected (default null)
 *
 * @param int size (optional)
 *
 * @return string
 *
 */
function multi_dropdown( $name,$options,$whichValue,$displayVal, $arrSel, $size=7 )
{
        /*** begin the select ***/
    
    
    $selected=explode(',',$arrSel);
    
        $dropdown = '<select name="'.$name.'[]" class="inputbox" id="'.$name.'" size="'.$size.'" multiple>'."\n";

        /*** loop over the options ***/
        for($i=0;$i<sizeof($options);$i++)
    {
        /*** assign a selected value ***/
            
             //$select = in_array( $options[$i][$whichValue], $selected[$i] ) ? ' selected' : null;
            
            if(in_array($options[$i][$whichValue],$selected)){$select= "selected";}else{ $select= " ";}

        //$select = $selected[$i]==$options[$i][$whichValue] ? ' selected' : null;

        /*** add each option to the dropdown ***/
        $dropdown .= '<option value="'.$options[$i][$whichValue].'"'.$select.'>'.$options[$i][$displayVal].'</option>'."\n";
    }

        /*** close the select ***/
        $dropdown .= '</select>'."\n";

        /*** and return the completed dropdown ***/
        return $dropdown;
}


function single_dropdown( $name, array $options,$whichValue,$displayVal, $selected=null )
{
  
    /*** begin the select ***/
    $dropdown = '<select name="'.$name.'" id="'.$name.'">'."\n";

    $selected = $selected;
    /*** loop over the options ***/
    foreach( $options as $key=>$option )
    {
        /*** assign a selected value ***/
        $select = $selected==$key ? ' selected' : null;

        /*** add each option to the dropdown ***/
        $dropdown .= '<option value="'.$options[$key][$whichValue].'"'.$select.'>'.$options[$key][$displayVal].'</option>'."\n";
    }

    /*** close the select ***/
    $dropdown .= '</select>'."\n";

    /*** and return the completed dropdown ***/
    return $dropdown;
}

}

?>
