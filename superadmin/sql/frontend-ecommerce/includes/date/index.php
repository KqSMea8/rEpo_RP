<script type="text/javascript" language="javascript" src="includes/date/datetimepicker.js"></script>
<script language="JavaScript">
	if (document.images)
	{
	calimg= new Image(16,16); 
	calimg.src="images/cal.gif"; 
	}
</script>
<?

function calender_picker($date_value,$FileName){

		
		$str = "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
		  <tr>
			<td align=left width=\"20\"><input name=".$FileName." id=".$FileName." size=18 type=text class=txtfield_contact value='".$date_value."' readonly='yes' /></td>
			<td align=left width=\"12\"><a href=\"Javascript: NewCal('$FileName','yyyymmdd',true,24,'arrow');\"><img src='includes/date/images/cal.gif' border='0'></a> </td>
			
		  </tr>
		</table>";
		
		
		return $str;		
		
}

?>

