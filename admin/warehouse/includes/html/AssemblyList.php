<script language="JavaScript1.2" type="text/javascript">
	function ResetSearch()	{	
		$("#prv_msg_div").show();
		$("#frmSrch").hide();
		$("#preview_div").hide();
	}
	function SelectPO(OrderID,nam)	{	
		ResetSearch();
		window.parent.location.href = document.getElementById("link").value+"?popup="+OrderID+"&invoice=1";
		
	}
</script>

<div class="had">Select Assemble Order</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="AssemblyList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	 <input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
</form>



		</td>
      </tr>
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
      <td width="12%"  class="head1" >Assemble No</td>
       <td  class="head1" >Warehouse Location</td>
	 <td width="12%" class="head1" >Assemble Date</td>
     <td width="10%" class="head1" >Bill Number</td>
      <td   class="head1" >Description</td>
      <td width="10%" align="center" class="head1" >Assemble Qty</td>
     <td width="10%"  align="center" class="head1" >Status</td>
      
    </tr>
   
    <?php 
$objWarehouse=new warehouse();
  if(is_array($arryAssemble) && $num>0){
 
  	$flag=true;
	$Line=0;
  	foreach($arryAssemble as $key=>$values){
	$wareName=$objWarehouse->AllWarehouses($values['warehouse_code']);
	$check=$objWarehouse->checkAssembly($values['asmID']);
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
		<td>
		<?php if(empty($check))
		{  ?>
		<a href="Javascript:void(0);" class="disab" id="asm<?=$values['asmID']?>" onclick="Javascript:SelectPO(<?=$values['asmID']?>,'asm')"><?=$values['asm_code']?></a></td>
		<? } else{ ?>
		<?=$values['asm_code']?>
		<? } ?>
		<td>
		<? 
		echo $wareName[0]['warehouse_name'];
		?>

		</td>
		<td><? if($values['asmDate']>0) echo date($Config['DateFormat'], strtotime($values['asmDate']));?></td>
		<td><?=stripslashes($values["Sku"])?></td> 
		<td "><?=$values['description']?></td>
		<td align="center"><?=$values['assembly_qty']?></td>
		<td width="10%" ><?
		if ($values['Status'] == 1) {
			$status = 'Cancel';
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


  

    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_ASSEMBLE?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  
	 <td colspan="8"  id="td_pager">
	 Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryAssemble)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	 </tr>
  </table>

  </div> 


  
</form>
</td>
	</tr>
</table>

