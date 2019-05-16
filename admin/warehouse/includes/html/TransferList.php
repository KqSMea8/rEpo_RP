<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SelectPO(transferID){	
	ResetSearch();
	window.parent.location.href = document.getElementById("link").value+"?tn="+transferID;
}

</script>

<div class="had">Select Transfer Order</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="TransferList.php" method="get" onSubmit="return ResetSearch();">
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
      <td width="12%"  class="head1" >Transfer Number</td>
       <td width="12%" class="head1" >Transfer Date</td>
	 <td width="10%" class="head1" >From Warehouse</td>
     <td class="head1" >To Warehouse</td>
      <td width="10%" align="center" class="head1" >Amount</td>
      <td width="10%" align="center" class="head1" >Currency</td>
     <td width="10%"  align="center" class="head1" >Status</td>
       
    </tr>
   
    <?php 
  if(is_array($arryTransfer) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryTransfer as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
       <td><a href="Javascript:void(0);" onclick="Javascript:SelectPO(<?=$values['transferID']?>)"><?=$values['transferNo']?></a></td>
	   <td>
	   <? if($values['transferDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['transferDate']));
		  // echo $values['transferDate'];
		?>
	   
	   </td>
	  <td><?=$values['from_warehouse']?></td>
      <td><?=stripslashes($values["to_warehouse"])?></td> 
       <td align="center"><?=$values['total_transfer_value']?></td>
     <td align="center"><?=$Config['Currency']?></td>
     <td align="center">	
	  <? 
		 if($values['Status'] ==1){
		   $Status = "Parked" ;
			 $StatusCls = 'green';
		 }else if($values['Status'] ==2){
			 $Status = "Completed" ;
			 $StatusCls = 'green';
			 
		 }else{
          $Status = "Cancel" ;
		  $StatusCls = 'red';
		 }

		echo '<span class="'.$StatusCls.'">'.$Status.'</span>';
		
	 ?></td>


   

    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_PO?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  
	 <td colspan="8"  id="td_pager">
	 Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPurchase)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	 </tr>
  </table>

  </div> 


  
</form>
</td>
	</tr>
</table>

