<a class="back" href="viewTwitterPost.php" >Back</a>
 <a class="fancybox add_quick" href="Twitter.php">Home</a>
<div class="had">Create Tweet </div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
<tr>
<td align="left" valign="top">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
 <form name="form1" action=""  method="post" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_social'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
</td>
</tr>
<? } ?>
  
		<tr>
			<td  align="center" valign="top" >
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
			<tr>
			<td colspan="2" align="left"  class="head" >Tweet Information</td>
			</tr>
			<tr>
			<td  align="right" width="40%"   class="blackbold"> Message  :<span class="red">*</span> </td>
			<td   align="left" >
			<Textarea name="message" class="inputbox" style="height: 65px;"><?php echo !empty($_POST['message'])?$_POST['message']:'';?></Textarea>       </td>
			</tr>		
			<tr>
				<td  align="right" width="40%"   class="blackbold"> Picture  :<span class="red">*</span> </td>
				<td   align="left" >
				<input name="picture" type="file" class="inputbox" id="picture" value=""  maxlength="50" /></td>
			</tr>
			</table>	
			</td>
		</tr>

		<tr>
			<td  align="center" >
			<div id="SubmitDiv" style="display:none1">
			<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
			<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
			</div>
			</td>
		</tr>
   
   </form>
</table>
	</td>
    </tr>
 
</table>
