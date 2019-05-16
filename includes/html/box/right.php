<table width="228" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%" valign="top" height="16">
		</td>
	</tr>
	<? if (empty($_SESSION['UserName']) && empty($_SESSION['MemberID']) ) {?>
		
		
		
		<tr>
		<td  valign="top" >
	 
			<? 	//require_once("includes/html/box/banner_right.php"); 	?>
		</td>
		</tr>
	<? }else{
			require_once("includes/html/box/right_member.php"); 
	
	 } ?>
	
</table>			