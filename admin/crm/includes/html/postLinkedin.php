<a class="back" href="Linkedin.php">Back</a>
<a href="viewLinkedinPost.php" class="fancybox add_quick">Post List</a>
<a class="add" href="linkedin-connection.php">Connection List</a>
<div class="had">Create Post </div>
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
			<td colspan="2" align="left"  class="head" >Post Share Information:</td>
			</tr>
			<tr>
			<td  align="right" width="40%"   class="blackbold"> Comment  :</td>
			<td   align="left" >
			<Textarea name="scomment" class="inputbox" style="height: 65px;"><?php echo !empty($_POST['scomment'])?$_POST['scomment']:'';?></Textarea>       </td>
			</tr>	

			<tr>
			<td  align="right" width="40%"   class="blackbold">Title :</td>
			<td   align="left" >
			<input name="stitle" type="text" class="inputbox"  value="<?php echo !empty($_POST['stitle'])?$_POST['stitle']:'';?>"/> </td>
			</tr>
			
			
            <tr>
			<td  align="right" width="40%"   class="blackbold">Content Url:  </td>
			<td   align="left" >
			<input name="surl" type="text" class="inputbox" value="<?php echo !empty($_POST['surl'])?$_POST['surl']:'';?>"/> </td>
			</tr>
			
			<tr>
			<td  align="right" width="40%"   class="blackbold">Content Picture Url : </td>
			<td   align="left" >
			<input name="simgurl" type="file" class="inputbox" />
			
			<!-- <input name="simgurl:" type="file" class="inputbox" id="picture"  maxlength="50" /> -->

			</td>
			</tr>
			
			<tr>
			<td  align="right" width="40%"   class="blackbold">Description : </td>
			<td   align="left" >
			<Textarea name="sdescription" class="inputbox" style="height: 65px;"><?php echo !empty($_POST['sdescription'])?$_POST['sdescription']:'';?></Textarea>       </td>
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
