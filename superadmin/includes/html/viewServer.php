<div class="had">Manage Server  </div>
<div class="message" align="center"><?php if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" >
		
		<? if($_GET['key']!='') {?>
		  <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location='viewCompany.php';" />
		<? }?>
		
		<? if($_SESSION['AdminType']=="admin"){?>
		<a href="editServer.php" class="add">Add Server</a>
		<? }?>



</td>
      </tr>
	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
    <td width="15%"  class="head1" >Name</td>
    <td width="8%"  class="head1" >IP</td>
    <td width="12%" class="head1" >Port</td>
    <td width="12%" class="head1" >Username</td>
	<td width="8%" class="head1" >Password</td>	
	<td width="12%" class="head1" >url</td>
    <td width="6%"  align="center" class="head1" >Status</td>
    <td width="6%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
  
    <?php 

$deleteCmp = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

$resend = '<img src="'.$Config['Url'].'admin/images/email.png" border="0"  onMouseover="ddrivetip(\'<center>Re-Send Activation Email</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

  if(!empty($arryServer)){
  	$flag=true;
	$Line=0;
  	foreach($arryServer as $key=>$values){
	$flag=!$flag;
	$rowclass=($flag)?("evenbg"):("oddbg");
	$Line++;

  ?>
    <tr align="left"  class="<?=$rowclass?>">
	<td ><?=$values["name"]?></td>
	<td><?=$values["ip"]?></td>  
	<td><?=$values["port"]?></td>  
	<td><?=$values["username"]?></td> 
	<td><?=$values["password"]?></td>   
	<td><?=$values["url"]?></td>      

    <td align="center"><?php $status =  $values['status']==1?"Active":"InActive"; ?>
		<a href="editServer.php?edit=<?=$values['id']?>&curP=<?=$_GET['curP']?>" class="<?php echo $status; ?>" ><?php echo $status; ?></a>
	</td>

    <td  align="center"  class="head1_inner">
    	<a href="editServer.php?edit=<?=$values['id']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
    	<? 
    	if($values['Fixed']==0){?>
    	<a onclick="return confirm('Are you sure to delete this server');" href="editServer.php?del_id=<?php echo $values['id'];?>&amp;curP=<?php echo $_GET['curP'];?>"   ><?=$deleteCmp?></a> 
    		
    	<? } ?>
		
	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo (int)$arryServer[0]['TOTAL_RECORD'];?>      <?php if(count($arryServer)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   
</form>
</td>
	</tr>
</table>
