<link href="includes/date_picker/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="includes/date_picker/calendar.js"></script>
<?php
function date_picker($date_value,$FileName){
	//$str = "<input name=".$FileName." id=".$FileName." size=10 type=text class=inputbox value='".$date_value."' readonly='yes' />";
	//$str .= "&nbsp;<a href=\"Javascript: displayDatePicker('$FileName');\"><img src='includes/date_picker/cal.gif' border='0'></a>";
	
	$str = "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
  <tr>
    <td align=left width=\"20\"><input name=".$FileName." id=".$FileName." size=15 type=text class=txtfield_contact value='".$date_value."' readonly='yes' /></td>
    <td align=left width=\"12\"><a href=\"Javascript: displayDatePicker('$FileName');\"><img src='includes/date_picker/cal.gif' border='0'></a> </td>
	
  </tr>
</table>
";
	return $str;
}

function date_picker2($date_value,$FileName){
	//$str = "<input name=".$FileName." id=".$FileName." size=10 type=text class=inputbox value='".$date_value."' readonly='yes' />";
	//$str .= "&nbsp;<a href=\"Javascript: displayDatePicker('$FileName');\"><img src='includes/date_picker/cal.gif' border='0'></a>";
	
	$str = "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
  <tr>
    <td align=left width=\"20\"><input name=".$FileName." id=".$FileName." size=15 type=text class=inputbox value='".$date_value."' readonly='yes' /></td>
    <td align=left width=\"12\"><a href=\"Javascript: displayDatePicker('$FileName', false, 'mdy', '/');\"><img src='includes/date_picker/cal.gif' border='0'></a></td>
  </tr>
</table>
";
	return $str;
}

?>