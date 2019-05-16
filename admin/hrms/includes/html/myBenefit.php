<div class="had"><?=$MainModuleName?></div>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td>
         
		
<? if($_GET['search']!='') {?> <a href="viewBenefit.php" class="grey_bt">View All</a><? }?>
	  </td>
	  </tr>
	<tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td width="25%" class="head1" >Heading</td>
    <td class="head1" > Detail </td>
        <td width="13%"  class="head1" >Download</td>

    <td width="13%"  align="center" class="head1 head1_action" >Action</td>
  </tr>

  <?php 
  if(is_array($arryBenefit) && $num>0)
  {
  	$flag=true;
       
  	foreach($arryBenefit as $key=>$values){
	$flag=!$flag;
  ?>
  <tr align="left" >
    <td><?=stripslashes($values['Heading'])?></td>
     <td><?=substr(strip_tags(stripslashes($values['Detail'])),0,300)?>...</td>
   <td >

 <? if($values['Document'] !='' && IsFileExist($Config['BenefitDir'], $values['Document']) ){
	$DocExist=1;
	?>
	<a href="../download.php?file=<?=$values['Document']?>&folder=<?=$Config['BenefitDir']?>" class="download">Download</a>	
	
    <? } else {	
	$DocExist=0;
	echo NOT_UPLOADED;
	}
?> 

       </td>
   
    
   
   
    <td  align="center" class="head1_inner" >
        <a href="vBenefit.php?view=<?=$values['Bid']?>" class="fancybox fancybox.iframe"><?=$view?></a>
		</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="6" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryBenefit)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
<? } ?>
