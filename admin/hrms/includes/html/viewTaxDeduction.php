
<div class="had">Manage Tax Deduction</div>
<div class="message"><? if(!empty($_SESSION['mess_deduction'])) {echo $_SESSION['mess_deduction']; unset($_SESSION['mess_deduction']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

		<tr>
        <td>
		<a href="editTaxDeduction.php" class="add">Add Tax Deduction</a>

		</td>
      </tr>
	
	<tr>
	  <td  valign="top">
  
	

	
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr align="left" valign="middle" >
    <td class="head1" >Heading</td>
    <td width="15%" class="head1" >State</td>
    <td width="35%" class="head1" >Account</td>
 <td width="8%" class="head1" >Tax Rate</td>
     <td width="8%" align="center" class="head1" >Status</td>
   <td width="5%"  align="center" class="head1" >Action</td>
  </tr>

  <?php 
  
  $pagerLink=$objPager->getPager($arryTaxDeduction,$RecordsPerPage,$_GET['curP']);
 (count($arryTaxDeduction)>0)?($arryTaxDeduction=$objPager->getPageRecords()):("");
  if(is_array($arryTaxDeduction) && $num>0){
  	$flag=true;      
  	foreach($arryTaxDeduction as $key=>$values){
	$flag=!$flag;
  ?>
  <tr align="left" valign="middle" >
    <td><?=stripslashes($values['Heading'])?></td>
    <td><?=stripslashes($values['StateName'])?></td>
 <td><? 
if(!empty($values['AccountName'])) {
echo stripslashes($values['AccountName']).' - ('.$values['AccountType'].')'; 
}
?>  </td>

   <td><?=$values['TaxRate']?> %</td>

    <td align="center">
      <? 
	 if($values['Status'] ==1){
		  $class = 'Active'; 
	 }else{
		  $class = 'InActive'; 
	 }
	
	 echo '<a href="editTaxDeduction.php?active_id='.$values["dedID"].'" class="'.$class.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$class.'</a>';
		
	   
	 ?>    </td>
    <td align="center" class="head1_inner" >

	<a href="editTaxDeduction.php?edit=<?=$values['dedID']?>"><?=$edit?></a>

	<a href="editTaxDeduction.php?del_id=<?=$values['dedID']?>" onClick="return confirmDialog(this, 'Deduction')"><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="6" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr  >  <td height="20" colspan="6"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTaxDeduction)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
