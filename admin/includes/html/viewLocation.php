
<div class="had">Company Location</div>
<div class="message"><? if(!empty($_SESSION['mess_loc'])) {echo $_SESSION['mess_loc']; unset($_SESSION['mess_loc']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	 <? if($num<$Config['NumLocation']){?>
	 <tr>
		<td align="right" ><a href="editLocation.php" class="add">Add Location</a></td>
	  </tr>
	  <? } ?>
	  
	<tr>
	  <td valign="top">
	  
	
	
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
	
  
  <tr align="left"  >
     <td  class="head1" >Address</td>
   <td width="12%" class="head1" >City</td>
    <td width="12%" class="head1" >State</td>
    <td width="12%"  class="head1" >Country</td>
    <td width="8%"  class="head1" >Zip Code</td>
     <td width="10%"  align="center" class="head1" >Timezone</td>
     <td width="8%"  align="center" class="head1" >Status</td>
   <td width="10%"  align="center" class="head1" >Action</td>
  </tr>
 
  <?php 
  $pagerLink=$objPager->getPager($arryLocation,$RecordsPerPage,$_GET['curP']);
 (count($arryLocation)>0)?($arryLocation=$objPager->getPageRecords()):("");
  if(is_array($arryLocation) && $num>0){
  	$flag=true;
  	foreach($arryLocation as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
	<td><?=stripslashes($values['Address'])?></td>
	<td><?=stripslashes($values['City'])?></td>
	<td><?=stripslashes($values['State'])?></td>
	<td><?=stripslashes($values['Country'])?></td>
	<td><?=stripslashes($values['ZipCode'])?></td>
	<td align="center"><?=stripslashes($values['Timezone'])?></td>
	<td align="center">
	<? 
	if($values['Status'] ==1){
	 $status = 'Active';
	}else{
	 $status = 'InActive';
	}
	 
	if($values["locationID"]>1){
		echo '<a href="editLocation.php?active_id='.$values["locationID"].'" class="'.$status.'">'.$status.'</a>';
	}else{
		echo $status;
	}
	?></td>



    <td  align="center" class="head1_inner" >
	<a class="fancybox fancybox.iframe" href="locationInfo.php?view=<?=$values['locationID']?>" ><?=$view?></a>

	<? if($values["locationID"]>1){?>
	<a href="editLocation.php?edit=<?php echo $values['locationID'];?>" ><?=$edit?></a>
	
	<a href="editLocation.php?del_id=<?php echo $values['locationID'];?>" onClick="return confDel('Location')" ><?=$delete?></a>	
	<? }else{ ?>
	Primary Location
	<? } ?>		</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="8" class="no_record"><?=NO_LOCATION?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="8" >Total Location : &nbsp;<?php echo $num;?>
  <!--
  <?php if(count($arryLocation)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;}?>
-->
</td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
