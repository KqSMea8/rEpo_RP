

<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}


</script>

<div class="had"><?=$MainModuleName?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" height="40" valign="bottom">
		 <input type="hidden" name="link" id="link" value="editProduction.php">
		   <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_asm.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
	 
		<? if(empty($_GET['po'])){ ?>
			<a name="Add_Production" class="fancybox add fancybox.iframe" href="AssemblyList.php?link=editProduction.php" >Add <?=$MainModuleName?></a>
	
		<? } ?>
		

		 <? if($_GET['key']!='') {?>
	  	<a href="viewProduction.php?curP=<?= $_GET['curP'] ?>" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div class="message" align="center"><? if(!empty($_SESSION['mess_asm'])) {echo $_SESSION['mess_asm']; unset($_SESSION['mess_asm']); }?></div>
<br/>
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arryReturn)?>');" /></td>-->
       <td width="10%" class="head1" >Received Date</td>
	   <td width="13%"  class="head1" >Recieve No</td>
      <td width="13%"  class="head1" >Assemble No</td>
      <td  class="head1" >Warehouse Location</td>
	  <td width="10%" class="head1" >Assemble Date</td>
      <td   class="head1" >Assembled Qty</td>
	  <td width="8%" align="center" class="head1" >Status</td>
      <td width="8%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 

  if(is_array($arryAssemble) && $num>0){
  	$flag=true;
	$Line=0;

  	foreach($arryAssemble as $key=>$values){
	$objWarehouse=new warehouse();
	$arryWarehouse=$objWarehouse->AllWarehouses($values["warehouse_code"]);
	extract($arryWarehouse);
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	

  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      
			<td>
			<? if($values['UpdatedDate']>0) echo date($Config['DateFormat'], strtotime($values['UpdatedDate']));?>
			</td>
			<td><?=stripslashes($values["RecieveNo"])?></td>
			<td><?=stripslashes($values["asm_code"])?></td> 
			<td><?=stripslashes($arryWarehouse[0]['warehouse_name'])?></td> 
			<td><? if($values['asmDate']>0)  echo date($Config['DateFormat'], strtotime($values['asmDate']));?></td> 
			<td><?=$values["assembly_qty"]?></td>

			<td align="center"><?
					if ($values['Status'] == 1) {
					  $status = 'Cancelled';
						 $Class = 'red';
					   
					} else if($values['Status'] == 2){
						$status = 'Completed';
						$Class = 'green';
					}else{
			
					  $status = 'Parked';
					   $Class = 'green';
					}

			   

					echo '<span class="'.$Class.'" >' . $status . '</span>';
					?></td>
				<td  align="center" class="head1_inner"  >
				<?
				if ($values['Status'] ==0) { ?>
				<a href="vProduction.php?view=<?=$values['asmID']?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$view?></a>


				<a href="editProduction.php?edit=<?=$values['asmID']?>&amp;curP=<?php echo $_GET['curP'];?>&amp;popup="><?=$edit?></a>

				<a href="editProduction.php?del_id=<?php echo $values['asmID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>  
				<?    } 	else if($values['Status'] ==2) {?>
				<a href="vProduction.php?view=<?=$values['asmID']?>&amp;curP=<?php echo $_GET['curP'];?>"><?=$view?></a>
				<?    
				}else {?>
				<a href="vProduction.php?view=<?=$values['asmID']?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$view?></a> 
				<? } ?>


				</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No Record Found </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryAssemble)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryAssemble)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','SuppID','viewProduction.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','SuppID','editCargo.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','SuppID','editCargo.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
