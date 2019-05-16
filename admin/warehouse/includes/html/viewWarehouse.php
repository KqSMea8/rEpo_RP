<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';

	}
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_warehouse'])) {echo $_SESSION['mess_warehouse']; unset($_SESSION['mess_warehouse']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

     <tr>   
     
	  <td  valign="top" align="right">
	  
		   <? if($num>0){?>
<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_warehouse.php?<?=$QueryString?>';" -->
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
      
      <a href="editWarehouse.php" class="add" >Add Warehouse</a>
      
        <? if($_GET['key']!='') {?>
		  <a class="grey_bt"  href="viewWarehouse.php">View All</a>
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
      <!--td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','WID','<?=sizeof($arryWarehouse)?>');" /></td -->
  <td width="15%"  class="head1" >Warehouse Code</td>
      <td width="11%"  class="head1" >Warehouse Name</td>
      <td class="head1" width="12%"> City</td>
      <td class="head1" width="12%"> State</td>
      <td class="head1" width="12%"> Country</td>
      <td width="8%"  align="center" class="head1" > Status</td>
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryWarehouse) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryWarehouse as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--td ><input type="checkbox" name="WID[]" id="WID<?=$Line?>" value="<?=$values['WID']?>" /></td -->
      <td ><?=$values["warehouse_code"]?></td>
      <td height="22" > 
	  <? echo  stripslashes($values["warehouse_name"]); ?>		       </td>
		 
           <td > <? echo  stripslashes($values["City"]); ?></td>
      <td > <? echo  stripslashes($values["State"]); ?></td>
      <td ><? echo  stripslashes($values["Country"]); ?> </td>
           
     
	 
       
    <td align="center"><? 
		
		
		if($values['Status']==1){
			  $status = "Active";
			  }else{
			  $status = "InActive";
			  }
		
	?>
	 <? if($values['WID']>1){?> 
<a href="editWarehouse.php?active_id=<?php echo $values['WID'];?>&amp;curP=<?php echo $_GET['curP'];?>" class="<?=$status?>" ><?=$status?></a>
 <? } else{
     
    echo $status;
     
      }?>
		
	 </td>
 <td  align="center" class="head1_inner"   >
     
     
     <? if($values['WID']>1){?>
     <a href="vWarehouse.php?view=<?php echo $values['WID'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$view?></a>
     <a href="editWarehouse.php?edit=<?php echo $values['WID'];?>&amp;curP=<?php echo $_GET['curP'];?>&amp;tab=Warehouse" ><?=$edit?></a>
     <?php if(!$objWarehouse->isWarehouseTransactionExist($values['WID'])){?>  
     <a href="editWarehouse.php?del_id=<?php echo $values['WID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
     <?}?>
     <? } else{?>
     
     <a href="editWarehouse.php?edit=<?php echo $values['WID'];?>&amp;curP=<?php echo $_GET['curP'];?>&amp;tab=Warehouse" ><?=$edit?></a> 
     
     <? }?>
 </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryWarehouse)>0){?>
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
