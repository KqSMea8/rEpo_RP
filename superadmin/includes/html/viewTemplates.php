
<div class="had"><?php echo 'Templates';?></div>
<? if(!empty($_SESSION['mess_template'])) {echo '<div class="message">'.$_SESSION['mess_template'].'</div>'; unset($_SESSION['mess_template']); }?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	

	<tr>
		<td align="right" ><a href="uploadTemplate.php" class="add">Upload Template</a></td>
	  </tr>
	<tr>
	  <td  valign="top">

<form action="" method="post" name="form1" enctype="multipart/form-data">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
	
  
  <tr align="left"  >
    <td class="head1" >Template Display Name</td>
	<td class="head1" >Template Name</td>
	<td class="head1" >Template Type</td>
	<td class="head1" >Theme</td>
    <td width="10%"  align="center" class="head1" >Action</td>
  </tr>
 
  <?php 
 
  if(is_array($arryTemplate) && $num>0){
  	$flag=true;
  	foreach($arryTemplate as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#f7f6ef"):("");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td class="blacknormal"> <?=stripslashes($values['TemplateDisplayName'])?>  </td>
	<td class="blacknormal"> <?=stripslashes($values['TemplateName'])?>  </td>
	<td class="blacknormal"> <?php if(stripslashes($values['TemplateType'])=='e') echo 'E-Commerce'; else echo 'Website';?>  </td>
    	<td class="blacknormal">
    	<?php if($values['Thumbnail']!=''){?>
    	<img width="205px;" height="150px;" src="../template/<?php echo $values['TemplateName'];?>/<?php echo $values['Thumbnail'];?>" >
    	<?php } else{echo 'No Preview Available';}
?></td>
    <td align="center" >

	<a href="uploadTemplate.php?edit=<?php echo $values['TemplateId'];?>" ><?=$edit?></a>
	
	<!-- <a href="uploadTemplate.php?del_id=<?php echo $values['TemplateId'];?>" onClick="return confDel('Country')"  ><?=$delete?></a> -->
	</td>
  </tr>
  <?php } // foreach end //?>
 

  <?php }else{?>
  	<tr align="center">
  	  <td height="20" colspan="2"  class="no_record">No Template found. </td>
  </tr>

  <?php } ?>
    
  <tr >  <td height="20" colspan="2">Total Record(s) : &nbsp;<?php echo $num;?> 
   

</td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</div>
</form>

<br><br>
</td>
	</tr>
</table>
