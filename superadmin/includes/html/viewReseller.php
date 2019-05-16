

<div class="had">Manage Reseller</div>


<div class="message" align="center"><? if(!empty($_SESSION['mess_reseller'])) {echo $_SESSION['mess_reseller']; unset($_SESSION['mess_reseller']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
        <td align="right" >
	

			

		</td>
      </tr>

	<tr>
        <td align="right" >
		
		<? if($_GET['key']!='') {?>
		  <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location='viewReseller.php';" />
		<? }?>		

		<a href="editReseller.php" class="add">Add Reseller</a>
		</td>
      </tr>
	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','RsID','<?=sizeof($arryReseller)?>');" /></td>-->
      <td width="20%"  class="head1" >Reseller Name</td>
      <td width="15%"  class="head1" >Reseller ID</td>
       <td  class="head1" >Email</td>
       <td width="20%" class="head1" >Company Name</td>
      <td width="6%"  align="center" class="head1" >Status</td>
      <td width="10%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 


  if(is_array($arryReseller) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryReseller as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;

	$TotalCmp=$objReseller->GetResellerCompany($values['RsID']);
	$CmpTxt = 'Companies';
	if($TotalCmp<2) $CmpTxt = 'Company';
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="RsID[]" id="RsID<?=$Line?>" value="<?=$values['RsID']?>" /></td>-->
     
      <td height="50" >
	  <a href="editReseller.php?edit=<?=$values['RsID']?>&curP=<?=$_GET['curP']?>" ><strong><?=stripslashes($values["FullName"])?></strong></a> 

	 </td>
		  

<td><?=$values["RsID"]?></td>
<td><? echo '<a href="mailto:'.$values['Email'].'">'.$values['Email'].'</a>'; ?></td>
<td><?=stripslashes($values["CompanyName"])?></td>     

    <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editReseller.php?active_id='.$values["RsID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
		
	 ?></td>
      <td  align="center"  class="head1_inner">

<a href="editReseller.php?edit=<?=$values['RsID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	<a href="editReseller.php?del_id=<?php echo $values['RsID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')" ><?=$delete?></a>   
<br>

<? if($TotalCmp>0){?>
<a href="vRsCompany.php?rs=<?=$values['RsID']?>" ><?=$TotalCmp?> <?=$CmpTxt?></a>
<? } ?>

</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryReseller)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryReseller)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','RsID','editReseller.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','RsID','editReseller.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','RsID','editReseller.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
