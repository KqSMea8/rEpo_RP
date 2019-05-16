<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	/*var keyword = document.getElementById("key").value;
	alert(keyword);
	return false;
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';*/

		var FromDate = document.getElementById("FromDate").value;
		var ToDate = document.getElementById("ToDate").value;
		if(ToDate!='' && FromDate!=''){

			FromDate = DefaultDateFormat(FromDate);
			ToDate = DefaultDateFormat(ToDate);

			if(ToDate < FromDate){
				alert("From Date should not be geater than To Date.");
				document.getElementById("FromDate").focus();
				return false;
			}
		}

		ShowHideLoader('1','F');
}
</script>

<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_news'])) {echo '<div class="message">'.$_SESSION['mess_news'].'</div>'; unset($_SESSION['mess_news']); }?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td>
<a href="editNews.php" class="add">Add Announcement</a>
		
<? if($_GET['search']!='') {?> <a href="viewNews.php" class="grey_bt">View All</a><? }?>
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
    <td width="12%" align="center" class="head1" >Date</td>
     <td width="10%" align="center" class="head1" >Image</td>
    <td width="8%" align="center" class="head1" >Status</td>
    <td width="13%"  align="center" class="head1 head1_action" >Action</td>
  </tr>

  <?php 
  if(is_array($arryNews) && $num>0){
  	$flag=true;
        
  	foreach($arryNews as $key=>$values){
	$flag=!$flag;
  ?>
  <tr align="left" >
    <td><?=stripslashes($values['heading'])?></td>
     <td><?=substr(strip_tags(stripslashes($values['detail'])),0,300)?>...</td>
   <td align="center">	<? if($values["newsDate"]>0) echo date($Config['DateFormat'], strtotime($values["newsDate"])); ?>    </td>
   
    <td align="center">
	  
<?
unset($PreviewArray);
$PreviewArray['Folder'] = $Config['NewsDir'];
$PreviewArray['FileName'] = $values['Image']; 	 
$PreviewArray['FileTitle'] = stripslashes($values['heading']);
$PreviewArray['Width'] = "100";
$PreviewArray['Height'] = "100";
$PreviewArray['Link'] = "1";
echo PreviewImage($PreviewArray);
?>

	  </td>
   
    <td align="center">
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editNews.php?active_id='.$values["newsID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
	   
	 ?>    </td>
    <td  align="center" class="head1_inner" >
	<a href="vNews.php?view=<?=$values['newsID']?>" class="fancybox fancybox.iframe"><?=$view?></a>
	<a href="editNews.php?edit=<?php echo $values['newsID'];?>&curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>

	<a href="editNews.php?del_id=<?php echo $values['newsID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confirmDialog(this, 'Announcement')" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="6" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryNews)>0){?>
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
