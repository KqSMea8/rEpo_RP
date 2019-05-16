<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>
		  
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td>
		
 <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_terminated.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
		

		 <? if($_GET['s']!='') {?>
	  	<a href="terminationReport.php" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 




	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <td width="10%"  class="head1" >Emp Code</td>
      <td width="15%"  class="head1" >Employee Name</td>
        <td  class="head1" >Department</td>
     <td width="10%" class="head1" >Exit Type</td>
        <td class="head1" >Reason</td>
      <td width="10%" class="head1" >Full & Final</td>
		
     <td width="15%" class="head1" >Joining Date</td>
      <td width="15%" class="head1" >Resignation Date</td>
    </tr>
   
    <?php 
  if(is_array($arryEmployee) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEmployee as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left"  >
 	<td><a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=$values["EmpCode"]?></a>	</td>
	<td height="30" >
		<?=stripslashes($values['UserName'])?>
	</td>
	<td><?=stripslashes($values["Department"])?></td>
 	<td><?=stripslashes($values["ExitType"])?></td>
	<td><?=stripslashes($values["ExitReason"])?></td>
	<td><?=stripslashes($values["FullFinal"])?></td>
	<td><? if($values["JoiningDate"]>0) echo date($Config['DateFormat'], strtotime($values["JoiningDate"])); ?></td>
	<td><? if($values["ExitDate"]>0) echo date($Config['DateFormat'], strtotime($values["ExitDate"])); ?></td>
     
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryEmployee)>0){?>
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

