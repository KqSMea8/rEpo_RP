
<div class="had">Component Weightages</div>
<div class="message"><? if(!empty($_SESSION['mess_weight'])) {echo $_SESSION['mess_weight']; unset($_SESSION['mess_weight']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
		<tr>
	  <td>
	  <? if($_GET['key']!='') {?> <a href="viewComponent.php" class="grey_bt">View All</a><? }?>
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>

	  </td>
	  </tr>
	<tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >

<table <?=$table_bg?>>
  <?  if($num>0){ ?>
  <tr align="left" >
    <td width="30%" class="head1" >Category</td>
	<? 	foreach($arryComponent as $key=>$values){ 
		echo '<td  align="center" class="head1" >Weightage<br>'.stripslashes($values['heading']).'</td>';
	}?>
	<td width="5%"  align="center" class="head1 head1_action" >Action</td>
  </tr>

  <? foreach($arryWeightage as $key=>$values_cat){  ?>
  
  <tr align="left" valign="middle" >
    <td height="35" ><?=stripslashes($values_cat['catName'])?></td>
	<? 	foreach($arryComponent as $key=>$values){ 
			$compID = $values['compID'];
			$Weightage = $values_cat['Weightage'.$compID];
			$Weightage = ($Weightage>0)?($Weightage."%"):("N.A.");
		echo '<td  align="center" >'.$Weightage.'</td>';
	}?>
	<td align="center" class="head1_inner">
		<a href="editWeightage.php?edit=<?=$values_cat['catID']?>"><?=$edit?></a>
	</td>
  </tr>
  <?php } // foreach end //?>
	<tr > 
	<td  colspan="5" id="td_pager">
	Total Record(s) : &nbsp;<?php echo $num;?>  
  </td>
  </tr>

 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="4" class="no_record"><?=NO_COMPONENT?></td>
  </tr>

  <?php } ?>
    
  
</table>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
