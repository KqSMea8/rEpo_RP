<div class="message" align="center">
<? if (!empty($_SESSION['mess_phone'])) {
    echo $_SESSION['mess_phone'];
    unset($_SESSION['mess_phone']);
} 
    ?>
	<script>	
  //  parent.jQuery.fancybox.close();
 //   parent.location.reload(true);
	</script>


</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td  valign="top">
        <form action="" method="post">
          <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
			<tbody><tr>
				 <td colspan="2" align="left" class="head">Share Voice Mail</td>
				</tr>
				<tr>
					<td align="right" class="blackbold">Email  :<span class="red">*</span> </td>
					<td align="left">
						<input name="email" type="text" class="inputbox" value="" maxlength="50">
					</td>
				</tr>			
				<tr>
				<td align="right" class="blackbold"> Message : </td>
				<td align="left">
					<textarea name="message" class="inputbox"></textarea>
				</td>
			
				</tr>	
				<tr>
				<td align="right" class="blackbold">&nbsp; </td>
				<td align="left">
			
				<div id="SubmitDiv" style="display:none1">
			
					<input name="Submit" type="submit" class="button" id="SubmitButton" value="  Submit  ">
			
				</div>
			
				</td>
				</tr>
				
			</tbody></table>
			</form>
        </td>
    </tr>
</table>
