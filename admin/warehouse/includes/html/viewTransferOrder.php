<script language="JavaScript1.2" type="text/javascript">

function ShowDateField(){	
	 if(document.getElementById("fby").value=='Year'){
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else if(document.getElementById("fby").value=='Month'){
	    document.getElementById("monthDiv").style.display = 'block';
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else{
	   document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("yearDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'block';
		document.getElementById("toDiv").style.display = 'block';	
	 }
}



function ValidateSearch(frm){	
	

	  if(document.getElementById("key").value == "")
	  {
		alert("Please Enter Transfer Number.");
		document.getElementById("key").focus();
		return false;
	  }else{

	ShowHideLoader(1,'F');
	return true;	

	  }

	
}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td valign="bottom">
		Transfer Number :<span class="red">*</span><br> <input type="text" name="key"  id="key" class="textbox" size="10"  />
			  
		</td>

		
		
	   <td>&nbsp;</td>
		<td valign="bottom">
		Transfer Status :<br> <select name="st" class="textbox" id="st" style="width:100px;">
		<option value="">--- All ---</option>
		<option value="Open" <?  if($_GET['st'] == "Parked"){echo "selected";}?>>Parked</option>
		<option value="Completed" <?  if($_GET['st'] == "Completed"){echo "selected";}?>>Completed</option>
		<option value="Cancelled" <?  if($_GET['st'] == "Cancel"){echo "selected";}?>>Cancelled</option>
		</select> 
		</td>
	   <td>&nbsp;</td>

		
	 

	

	  <td align="right" valign="bottom">   <input name="search" type="submit" class="search_button" value="Go"  />	  
	  <script>
	  ShowDateField();
	  </script>
	  
	  </td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>	
	<tr>
        <td align="right" valign="top">
		
	 <? if($num>0 && !empty($_REQUEST['c'])){?>
	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
          <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_so_report.php?<?=$QueryString?>&module=Order';" />

	    <? } ?>


		</td>
      </tr>
	 
<?php if(!empty($_REQUEST['key'])){?>	  
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>
		
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arrySale)?>');" /></td>-->
		
                       <!-- <td width="4%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','transferID','<?= sizeof($arryProduct) ?>');" /></td>-->
                      <td width="10%" class="head1" >Transfer No</td>
                      <td width="12%"  class="head1" >Transfer Date</td>
                      <td width="15%" class="head1">From Warehosue</td>
                      <td width="18%" class="head1" >To Warehosue</td>
                      <td width="15%" class="head1" >Reciept Date</td>
                      <!--<td width="10%" class="head1" >Recieved By</td>-->
                      <!--<td width="16%" class="head1" >Note/Comment</td>-->
                      <td width="10%"  class="head1" align="center" >Status</td>
                          
                      <td width="10%"  align="center" class="head1" >Action</td>
                
    </tr>

		<?php 

		
		 if (is_array($arryTransfer) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryTransfer as $key => $values) {
                           $flag=!$flag;
	                  $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	                  $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
	
		 <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	 <!-- <td><input type="checkbox" name="transferID[]" id="transferID<?= $Line ?>" value="<?= $values['transferID']; ?>"></td>-->
                                <td ><?= stripslashes($values['transferNo']); ?></td>
                                <td ><?= stripslashes($values['transferDate']); ?></td>
                                
                                <td><?= stripslashes($values['from_warehouse']); ?></td>
                                <td> <?= stripslashes($values['to_warehouse']); ?></td>
                                <td> <?= stripslashes($values['transferDate']); ?></td>
                                <!--<td> <?= stripslashes($values['createBy']); ?></td>-->
                               <!-- <td><?= stripslashes($values['description']); ?></td>-->
                                
				<td width="10%" align="center" ><?
                                    if ($values['Status'] == 1) {
                                        $cls = 'green';
                                       $status = 'Parked';
                                    } else if($values['Status'] == 2) {
                                        $cls = 'green';
                                       $status = 'Completed';
                                    }else{
                                        
                                      $cls = 'red';
                                        $status = 'Canceled';  
                                    }

                               

                                    echo '<span class="'.$cls.'"  >' . $status . '</span>';
                                    ?></td>


<td>
<?

	if($values['Status'] == 2)
		echo '<br><a href="ShipTransfer.php?transferID='.$values['transferID'].'" target="_blank">'.CREATE_SHIPPING.'</a>';

?>

	</td>
    </tr>
		<?php } // foreach end //?>
		
		

		<?php }else{?>
		<tr align="center" >
		<td  colspan="10" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		<tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arrySale)>0){?>
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
<?php } else {?>
<!--<tr><td style=" border-top: 1px solid #DDDDDD;font-weight: bold; padding-left: 123px;text-align: left;" class="no_record">Please Select Customer.</td></tr>-->
<?php }?>
</table>

