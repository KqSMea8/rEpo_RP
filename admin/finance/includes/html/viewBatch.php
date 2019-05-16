<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_batch'])) {echo $_SESSION['mess_batch']; unset($_SESSION['mess_batch']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	
	
	<tr>
        <td align="right" >
		

		
	
		
		<a href="editBatch.php" class="add">Add Batch</a>

		
	 
		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	 
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
	<tr align="left"  >
		<td width="15%" class="head1" >Batch Name</td>
		<td  class="head1" >Description</td> 	
		<td width="12%"   class="head1" >No of Checks</td>
		<td width="15%"   class="head1" >Created By</td>
		<td width="12%"   class="head1" >Created Date</td>
		<td width="10%"  align="center" class="head1" >Status</td>
		<td width="8%"  align="center" class="head1 head1_action" >Action</td>
	</tr>
   
    <?php 
$printcheck = '<img src="'.$Config['Url'].'admin/images/print.png" border="0"  onMouseover="ddrivetip(\'<center>Print Batch</center>\', 70,\'\')"; onMouseout="hideddrivetip()" >';

  if(is_array($arryBatch) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryBatch as $key=>$values){
	$flag=!$flag;
	$Line++;
	$CheckCount = $objCommon->CountCheckInBatch($values["BatchID"]);
  ?>
    <tr align="left" >
	<td><?=stripslashes($values["BatchName"])?></td>
	<td><?=stripslashes($values["Description"])?></td>
	<td><?=$CheckCount?></td>
	<td >
	<?  
	if($values["AdminType"]=='employee') {
		echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
	}else {
		echo $values["PostedBy"];
	}
	 ?>  
	</td>
	 	 
	<td >
<?
if($values["CreatedDate"] > 0) {
     echo date($Config['DateFormat'], strtotime($values["CreatedDate"]));
} 
 ?>
   
</td>
	<td align="center">  
	<?php 
		 if($values['Status'] == 1){
			  $status = 'Closed';
			  $statusCls = 'InActive';
		 }else{
			  $status = 'Open';
			  $statusCls = 'Active';
		 }
	     
      		echo '<a href="editBatch.php?active_id='.$values["BatchID"].'&curP='.$_GET["curP"].'" class="'.$statusCls.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';

	 ?> </td> 
	 

      <td  align="center"  class="head1_inner" >
<a href="vBatch.php?curP=<?=$_GET['curP']?>&view=<?=$values['BatchID']?>" ><?=$view?></a>	

<?

 if($values['Status'] == 1 && $CheckCount>0){ 
	echo ' <a class="fancybox fancybox.iframe" href="batch.php?BatchID='.$values['BatchID'].'" >'.$printcheck.'</a>';
}else{
?>
<a href="editBatch.php?curP=<?=$_GET['curP']?>&edit=<?=$values['BatchID']?>" ><?=$edit?></a>
	<a href="editBatch.php?curP=<?=$_GET['curP']?>&del_id=<?=$values['BatchID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 

  <? } ?>      
	  </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7" id="td_pager" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryBatch)>0){?>
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
