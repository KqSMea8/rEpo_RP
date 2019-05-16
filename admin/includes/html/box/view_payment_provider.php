<?
	require_once($Prefix."classes/finance.class.php");
	$objCommon=new common();

	$ModuleName = "Payment Provider";	

	$arryProvider=$objCommon->ListPaymentProvider($_GET);
	$num=$objCommon->numRows();	 
?> 
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_prv'])) {echo $_SESSION['mess_prv']; unset($_SESSION['mess_prv']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	 
	<tr>
	  <td  valign="top">
	 
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
	<tr align="left"  >
		<td class="head1" >Provider Name</td>
		<td width="20%" class="head1" >Card Type</td>
		<td width="20%" class="head1" >Provider Fee (%)</td>    
		<!--td width="25%" class="head1" >GL Account [Credit Card]</td-->
		
		<td width="10%"  align="center" class="head1" >Status</td>
		<td width="15%"  align="center" class="head1 head1_action" >Action</td>
	</tr>
   
    <?php 
  if(is_array($arryProvider) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryProvider as $key=>$values){
	$flag=!$flag;
	$Line++;

  ?>
    <tr align="left" >
	<td><?=stripslashes($values["ProviderName"])?></td>
	<td><?=stripslashes($values["CardType"])?></td>
	<td><?=stripslashes($values["ProviderFee"])?></td>
	<!--td><?=stripslashes($values["AccountNameNumber"])?></td-->

	<td align="center">  
	<?php 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	     
      		echo '<a href="editPaymentProvider.php?active_id='.$values["ProviderID"].'" class="'.$status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$status.'</a>';
 
	 ?> 
	</td> 
	 

      <td  align="center"  class="head1_inner" >
	<a href="editPaymentProvider.php?edit=<?=$values['ProviderID']?>" ><?=$edit?></a>
	<br>  <a href="vProviderInfo.php?view=<?=$values['ProviderID']?>" >API Instructions</a>
	 </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="6" id="td_pager" >Total Record(s) : &nbsp;<?php echo $num;?>      </td>
  </tr>
  </table>

  </div> 
 
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   
</form>
</td>
	</tr>
</table>
