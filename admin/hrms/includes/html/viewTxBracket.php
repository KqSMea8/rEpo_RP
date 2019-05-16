<script language="JavaScript1.2" type="text/javascript">
    	$(document).ready(function () {
		$("#y").on("change", function () { 
			if(document.getElementById("y").value==""){
				alert("Please Select Year.");
				document.getElementById("y").focus();
			}else{
				window.location = 'viewTaxBracket.php?y='+escape(document.getElementById("y").value);
				ShowHideLoader(1,'L');
			}
		});	

	});		
</script>

<div><a class="grey_bt" href="#">Manage Tax Deduction</a></div>


<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_bracket'])) {echo '<div class="message">'.$_SESSION['mess_bracket'].'</div>'; unset($_SESSION['mess_bracket']); }?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
<tr>
	<td>
	

<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">
<form action="" method="get" name="form3" >
<tr> <td><?=getYears($_GET['y'],"y","textbox")?></td>
     
</tr>
</form>	
</table>



	</td>
</tr>




<tr>
	<td>
	<a href="editTaxBracket.php?y=<?php echo $_GET['y'];?>" class="add">Add Tax Bracket</a>
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	</td>
</tr>

<tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>  
  <tr align="left" >    
    <td width="10%" class="head1"> Tax Rate </td>
    <? foreach($arryFiling as $k=>$val){ ?>
     <td  class="head1" ><?=stripslashes($val['filingStatus'])?> [<?=$Config['CurrencySymbol']?>]</td>
    <? } ?>
    <td width="5%"  align="center" class="head1 head1_action" >Action</td>
  </tr>

  <?php 
  if(is_array($arryBracket) && $num>0){
  	$flag=true;
  	foreach($arryBracket as $key=>$values){
	$flag=!$flag;
	
  ?>
  <tr align="left" >
	<td><strong><?=$values['TaxRate']." %"?></strong></td>

     <? 
	foreach($arryFiling as $k=>$val){
		$Line = $val["filingID"];
		unset($FilingValArray);
		$FilingValArray = explode("#",$values['Filing'.$Line]);

		$From = number_format($FilingValArray['0']);
		$To = number_format($FilingValArray['1']);
		if($To>0){	
			$FinalVal = $From.' - '.$To;
		}else{
			$FinalVal = 'over '.$From;
		}
		echo '<td>'.$FinalVal.'</td>';
	 }
      ?>	
	
     <td  align="center" class="head1_inner" >
	<a href="editTaxBracket.php?edit=<?php echo $values['bracketID'];?>&y=<?php echo $_GET['y'];?>"><?=$edit?></a>

	<a href="editTaxBracket.php?del_id=<?php echo $values['bracketID'];?>&y=<?php echo $_GET['y'];?>" onClick="return confirmDialog(this, 'Tax Bracket')" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="8" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="8" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  </td>
  </tr>
</table>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
   
