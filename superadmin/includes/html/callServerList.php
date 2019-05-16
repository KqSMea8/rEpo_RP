<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';

	}
</script>
<div class="had">Manage Call Server</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_server'])) {echo $_SESSION['mess_server']; unset($_SESSION['mess_server']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" >
		
		<? if($_GET['key']!='') {?>
		  <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location='viewCompany.php';" />
		<? }?>
		
		<a href="addServer.php" class="add">Add Server</a>
		<a href="countryCodeList.php" class="edit">Manage Country Code</a>
		
		</td>
      </tr>
	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
    <td width="15%"  class="head1">Server Name</td>
    <td width="8%"  class="head1">Server IP</td>
    <td width="12%" class="head1">Server ID</td>
	<td width="8%" class="head1">Server Port</td>
	<td width="15%" class="head1">Created Date</td>
    <td width="6%"  align="center" class="head1">Status</td>
    <td width="6%"  align="center" class="head1">Action</td>
    </tr>
   
    <?php 

$deleteCmp = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

  if(is_array($callServer) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($callServer as $key=>$values){
	$flag=!$flag;
	$Line++;
	
?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	<td height="50"><?=stripslashes($values->server_name);?></td>
	<td ><?=$values->server_ip; ?></td>
	<td><?=$values->server_user; ?></td>   
	<td><?=$values->server_port; ?></td>   
	<td><?  echo date("j F, Y",strtotime($values->create_date)); ?></td>
    <td align="center">
	<? 
	if($values->status =='Active'){
	$status = 'Active';
	}else{
	$status = 'InActive';
	}
	echo '<a href="callServerList.php?active_id='.$values->id.'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
	?>
	</td>
    <td  align="center"  class="head1_inner"><a href="addServer.php?edit=<?=$values->id;?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
    <a href="callServerList.php?del_id=<?php echo $values->id;?>&amp;curP=<?php echo $_GET['curP'];?>"   ><?=$deleteCmp?></a> 
    <a href="export_calllog.php?id=<?php echo $values->server_ip;?>" class="export_icon" title="Call Log"></a> 
    </td>
    </tr>
    <?php } // foreach end //?>
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
	<tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($callServer)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	</tr>
  </table>
 </div> 
 
 
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
