<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>



<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_dec'])) {echo '<div class="message" align="center">'.$_SESSION['mess_dec'].'</div>'; unset($_SESSION['mess_dec']); }?>


<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td>
		
	
<a href="editDeclaration.php" class="add">Upload Declaration Form</a>

<? if($_GET['key']!='' || $_GET['yr']!='') {?>
  <a href="viewDeclaration.php" class="grey_bt">View All</a>
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
       <td width="10%" class="head1" >Emp Code</td>
       <td class="head1" >Employee Name</td>
        <td width="15%" class="head1" >Department</td>
    <td width="18%"  class="head1" >Designation</td>
       <td width="18%"  class="head1" >Year</td>
       <td width="15%"  class="head1">Document</td>
      <td width="10%"  align="center"  class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryDeclaration) && $num>0){
	$flag=true;
	$Line=0;
        
	foreach($arryDeclaration as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left" >
      <td ><?=$values["EmpCode"]?></td>
      <td>
	   
	<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=stripslashes($values['UserName'])?></a>	   </td>
	<td><?=stripslashes($values["Department"])?></td>
	<td><?=stripslashes($values["JobTitle"])?></td>
	<td><?=$values["Year"]?></td>
	<td> 
 	<?   if($values['document'] !='' && IsFileExist($Config['DeclarationDir'],$values['document'])){  ?>
	<a href="../download.php?file=<?=$values['document']?>&folder=<?=$Config['DeclarationDir']?>" class="download">Download</a>
	<? } ?>
	</td>

      <td  align="center" class="head1_inner">
	  
<a href="editDeclaration.php?edit=<?=$values['decID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
 
<a href="editDeclaration.php?del_id=<?=$values['decID']?>&curP=<?=$_GET['curP']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="7" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arryDeclaration)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink; }?>
  </td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

</td>
</tr>
</table>

</div>
