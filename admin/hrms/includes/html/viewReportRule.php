<script language="JavaScript1.2" type="text/javascript">

	function ShowListing(){
		ShowHideLoader('1','L');	
		location.href = "viewLeave.php?d="+document.getElementById("Department").value;
	}


	
</script>







<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_report'])) {echo $_SESSION['mess_report']; unset($_SESSION['mess_report']); }?></div>



<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">

 <tr>
        <td>
		

<a href="reportForm.php" class="add">Add Custom Rule</a>

<? if($num>0){?>
	<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_leave.php?<?=$QueryString?>';" /-->
	<!--input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/-->
<? } ?>
<? if($_GET['search']!='') {?>
	<a href="viewLeave.php" class="grey_bt">View All</a>
<? }?>
		
		
		
		</td>
 </tr>






 <tr>
	  <td  valign="top">
	 


<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td class="head1" >Title</td>
 
     <td width="6%"  class="head1" align="center">Status</td>
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryReport) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryReport as $key=>$values){
	$flag=!$flag;
	$Line++;

	
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
		
	 ?>


    <tr align="left" >
      <td ><?=$values["title"]?></td>
     
  
      
      <td align="center" ><? echo '<a href="reportForm.php?active_id='.$values["reportID"].'&curP='.$_GET["curP"].'" class="'.$status.'"  onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';?></td>
      <td  align="center" class="head1_inner" >


<a href="reportForm.php?edit=<?php echo $values['reportID'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
 
<a href="reportForm.php?del_id=<?php echo $values['reportID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, 'Report Rule')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
 <tr >  <td  colspan="9" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      </td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

</td>
</tr>
</table>

</div>
