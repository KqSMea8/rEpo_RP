
<script type="text/javascript">
function getDatabase(){
	ShowHideLoader('1','L');
		var database = $("#Database").val();
		   
		  window.parent.location.href = "?databaseName="+database;
		
	}
	
</script>
<div class="had">Database Backup  </div>

<div class="drop-dep">
   
	 <select name="Database" class="inputbox" method="get" id="Database" onchange="getDatabase();">
	  <option value=""> --- Select Database ---</option>
	 <?php foreach($arryFolder as $folder){
	 
	 ?>
      <option value="<?php echo $folder;?>" <?php if ($_GET['databaseName']==$folder){ echo 'selected';}?>><?php echo $folder; ?></option>
<?php } ?>
   </select>
</div>
<div class="message" align="center"><?php if(!empty($_SESSION['mess_Database'])) {echo $_SESSION['mess_Database']; unset($_SESSION['mess_Database']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" >
		
		<? if($_GET['key']!='') {?>
		  <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location='databaseBackup.php';" />
		<? }?>
		
		<? if($_SESSION['AdminType']=="admin"){?>


		

		<a href="databaseCronSetting.php" class="grey_bt">Database Cron Setting</a>


	  <a href="cmpListingdatabase.php?file=<?php echo $_GET['databaseName'];?>" class="fancybox grey_bt fancybox.iframe" class="action_bt" style="float:right">Remove Database Backup</a>

	<? if(!empty($_GET['databaseName'])){?>
	  <a onclick='return confirm("All database backups for this folder will be removed.\n\nAre you sure to you want to truncate this folder.");' href="databaseBackup.php?Truncate=<?php echo $_GET['databaseName'];?>" class="grey_bt fancybox.iframe" class="action_bt" style="float:right">Truncate Database Folder</a>
	<? } ?>
		<a href="cmpListdatabase.php?file=<?php echo $_GET['databaseName'];?>" class="fancybox add fancybox.iframe" >Create Database Backup</a>
		<? }?>



</td>
      </tr>
	  <tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
 <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
 <div id="preview_div">
 <? // Abid ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
    <td width="15%"  class="head1" >Database Name</td>
    <td width="15%"  class="head1" >File Size </td>
    <td width="15%"  class="head1" >Date</td> 
    <td width="6%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
  
  <?php 
  $deleteCmp = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

  if(!empty($file)){
  	    $flag=true;
	    $Line=0;  
  	foreach($files as $key=>$values) {
        $aa = date ("F d Y H:i:s",($values['date']));
        $flag=!$flag;
        $rowclass=($flag)?("evenbg"):("oddbg");
        $Line++;
  ?>
    <tr align="left"  class="<?=$rowclass?>">
	<td><?php  echo $values['filename'].'.'.$values['extension'];?></td>		
	<td><?php  echo $values['filesize'];?></td>	
	<td><?php  echo $aa;?></td>	     
    <td  align="center"  class="head1_inner">
    	<a target="_blank" href="dwndatabase.php?filename=<?php echo $_GET['databaseName'].'/'.$values['filename'].'.'.$values['extension'];?>"   ><?=$download?></a>  	
    	<a onclick="return confirm('Are you sure to delete this file');" href="databaseBackup.php?del_id=<?php echo $_GET['databaseName'].'/'.$values['filename'].'.'.$values['extension'];?>"   ><?=$deleteCmp?></a>     		  			
	</td>
    </tr>
<? //} ?>
    <?php  } // foreach end // End Abid ?>
    <?php }else{?>
    <tr align="center" >
    <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr>  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($file)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?>
  </td>
  </tr>
  </table>
  </div> 
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>"> 
  </form>
  </td>
  </tr>
  </table>
