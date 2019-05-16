<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center">
 
<? if(!empty($_SESSION['mess_account_type'])) {echo $_SESSION['mess_account_type']; unset($_SESSION['mess_account_type']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
 <td  valign="top">

<div id="ListingRecords">


 
<form action="" method="post" name="form1">
<div id="piGal">
<table <?=$table_bg?> >
   
    <tr align="left"  >
      <td width="15%"  class="head1"><?=$ModuleName?></td>
      <td width="30%"  class="head1">Range</td>
      <td width="30%"  class="head1">Report Type</td>
      <td width="5%"  class="head1" align="center">Status</td>
      <!--td width="5%"  align="center" class="head1" >Action</td-->
    </tr>
   
    <?php 
  if(is_array($arryAccountType) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryAccountType as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td><?=stripslashes(ucwords(strtolower($values["AccountType"])))?></td>
      <td><?=$values["RangeFrom"]."-".$values["RangeTo"]?></td>
      <td>
          <?php
          if( $values["ReportType"] == "PL"){
     echo "Profit & Loss";
}else{
 echo "Balance Sheet";
}
          
          
         ?>
      
      </td>
     
    <td align="center"><? 
if($values['Status'] == "Yes"){
 $status = 'Active'; $statusCls = 'green';
}else{
 $status = 'InActive'; $statusCls = 'red';
}
 

echo '<span class="'.$statusCls.'">'.$status.'</span>';
?></td>
      <!--td  align="center"  class="head1_inner">
<?php if($values['flag'] != 1) {?>
<a href="editAccountType.php?edit=<?php echo $values['AccountTypeID'];?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
 
<a href="editAccountType.php?del_id=<?php echo $values['AccountTypeID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>  
<?php }?>
 </td-->
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="4" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="4" >Total Record(s) : &nbsp;<?php echo $num;?>  </td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>



</div>	
</td>
</tr>
</table>






