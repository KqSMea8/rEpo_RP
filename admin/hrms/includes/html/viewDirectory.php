<script language="JavaScript1.2" type="text/javascript">
function ValidateThis(){	
	ShowHideLoader(1,'P');
}

function ShowEditOption(){	
		$(".edit").hide();
		$(".button").show();
		$(".textbox").show();
}

</script>




<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_directory'])) { ?>
<div class="message" align="center"><? echo $_SESSION['mess_directory']; unset($_SESSION['mess_directory']); ?></div>
<? } ?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td valign="top" >
<? if($num>0){?>
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>	 

<? if($_GET['key']!='') {?>
<a href="viewDirectory.php" class="grey_bt">View All</a>
<? }?>	



		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1" onSubmit="return ValidateThis();">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 
 <? if($num>0){ ?>
	<tr align="right" >
      <td  colspan="3" height="30" valign="top"  >
	    <? if($ModifyLabel==1 && empty($_GET['pop'])){ ?>
		<a href="Javascript:ShowEditOption();"  class="edit">Change Listing Order</a>
	  <input type="submit" name="sbo" value="Update Order" class="button"  style="display:none;"> 
	  <? } ?>
	  </td>
    </tr>
   
    <?php 
       $MainDir = $Config['FileUploadDir'].$Config['EmployeeDir'];
  	$flag=true;
	$Line=0;
  	foreach($arryEmployee as $key=>$values){
	$flag=!$flag;
	$Line++;
	$bgclass = (!$flag)?("oddbg"):("evenbg");
  ?>
    <tr align="left" class="<?=$bgclass?>">
    <td valign="top" width="18%">
 <div> 
<?
unset($PreviewArray);
$PreviewArray['Folder'] = $Config['EmployeeDir'];
$PreviewArray['FileName'] = $values['Image']; 
$PreviewArray['NoImage'] = $Prefix."images/nouser.gif";	 
$PreviewArray['FileTitle'] = stripslashes($values['UserName']);
$PreviewArray['Width'] = "120";
$PreviewArray['Height'] = "120";
$PreviewArray['Link'] = "1";
echo PreviewImage($PreviewArray);
?>
</div>
			
		 </td>
		  
	  <td valign="top"> <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><B><?=stripslashes($values['UserName'])?></B></a> <br>
	 <?=stripslashes($values["JobTitle"])?> <br>
	 <?=stripslashes($values["Department"])?> <br>
	  Mobile: <?=stripslashes($values["Mobile"])?><br>
	  Email: <?=stripslashes($values["Email"])?>
	 
	 </td>
		 
	<td  width="18%" align="right">
	 <? if($ModifyLabel==1){ ?>
	<input type="text" name="OrderBy_<?=$values['EmpID']?>" class="textbox" style="display:none;" size="5" maxlength="10" value="<?=$values["OrderBy"]?>" onkeypress="return isNumberKey(event);">
	<? } ?>
 </td>

    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="3"  id="td_pager"><span class="red"><?=NO_RECORD?></span> </td>
    </tr>
    <?php } ?>
  

<? if($num>0  && empty($_GET['pop']) ){ ?>
	 <tr >  <td  colspan="3"  id="td_pager" >Total Record(s) : &nbsp;<?php echo $num;?> 
	 <?php if(count($arryEmployee55)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
<? } ?>

  </table>

  </div> 

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>

