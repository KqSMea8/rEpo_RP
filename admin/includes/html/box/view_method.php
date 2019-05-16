<?
	require_once($Prefix."classes/finance.class.php");
	$objCommon=new common();

	$ModuleName = "Payment Method";	

	$arryMethod=$objCommon->ListMethod($_GET);
	$num=$objCommon->numRows();

	$pagerLink=$objPager->getPager($arryMethod,$RecordsPerPage,$_GET['curP']);
	(count($arryMethod)>0)?($arryMethod=$objPager->getPageRecords()):("");
?>
<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_method'])) {echo $_SESSION['mess_method']; unset($_SESSION['mess_method']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	
	
	<tr>
        <td align="right" >
		

		
	
		
		<a href="editMethod.php" class="add">Add Payment Method</a>

		
		<? if($_GET['sc']!='') {?>
		  <a href="viewMethod.php" class="grey_bt">View All</a>
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
          <td class="head1" >Payment Method</td>
      <td width="25%" class="head1" >Payment Type</td>
      <!--td width="15%" class="head1" >Net (days) </td>
      <td width="15%" class="head1" >Due in (days)</td-->
      <!--td width="15%" class="head1" >Credit Limit (<?=$Config['Currency']?>)</td-->
     <td width="10%"  align="center" class="head1" >Status</td>
      <td width="8%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryMethod) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryMethod as $key=>$values){
	$flag=!$flag;
	$Line++;

  ?>
    <tr align="left" >
	<td><?=stripslashes($values["methodName"])?></td>
	<td><?=($values["methodType"]==1)?('Standard'):('Term')?></td>
	<!--td><?=($values["methodType"]==1)?(''):($values["Day"])?></td>
	<td><?=($values["methodType"]==1)?(''):($values["Due"])?></td-->
	<!--td>  
	 <? if($values['CreditLimit']>0){
	  echo $values['CreditLimit']; 
	} 
	 ?>
     </td-->	 
	 

	<td align="center">  
	<?php 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	     
      		echo '<a href="editMethod.php?active_id='.$values["methodID"].'&curP='.$_GET["curP"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';

                /* if(empty($values['fixed'])){
		echo '<a href="editTerm.php?active_id='.$values["termID"].'&curP='.$_GET["curP"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
                 }else{
                   echo '<span>'.$status.'</span>';
                 }*/
	 ?> </td> 
	 

      <td  align="center"  class="head1_inner" >
	<a href="editMethod.php?curP=<?=$_GET['curP']?>&edit=<?=$values['methodID']?>" ><?=$edit?></a>
	  <?php if(empty($values['fixed'])){ ?>
		
		<a href="editMethod.php?curP=<?=$_GET['curP']?>&del_id=<?=$values['methodID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
          <?php } ?>
	  </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="6" id="td_pager" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryMethod)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryMethod)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','methodID','editMethod.php?curP=<?=$_GET[curP]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','methodID','editMethod.php?curP=<?=$_GET[curP]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','methodID','editMethod.php?curP=<?=$_GET[curP]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   
</form>
</td>
	</tr>
</table>
