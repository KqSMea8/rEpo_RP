<?php 
	if(!empty($_POST['logID'])){?>
	<style>
	.red{
	display:none;
	}
	</style>
	
	<?php }?>


<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewCompany.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCompany.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>

<script language="javascript" type="text/javascript">
function showHide(shID) {
      if ($("."+shID).css('display') != 'none') { 
    	 // $("#"+shID+'_show').show();
    	  $("."+shID).hide();
    	  $("#"+shID+'_show').text('View All');
      }
      else { 
    	  //$("#"+shID+'_show').hide();
    	  $("."+shID).show();
    	  $("#"+shID+'_show').text('Minimize');
      }
}
</script>
<style type="text/css">
   /* This CSS is just for presentational purposes. */
   .logHide{display: none;}
   #wrap {
      font: 1.3em/1.3 Arial, Helvetica, sans-serif;
      width: 30em;
      margin: 0 auto;
      padding: 1em;
      background-color: #fff; }


   /* This CSS is used for the Show/Hide functionality. */
   .more {
      display: none;
      border-top: 1px solid #666;
      border-bottom: 1px solid #666; }
   a.showLink, a.hideLink {
      text-decoration: none;
      color: #36f;
      padding-left: 8px;
      background: transparent url(down.gif) no-repeat left; }
   a.hideLink {
      background: transparent url(up.gif) no-repeat left; }
   a.showLink:hover, a.hideLink:hover {
      border-bottom: 1px dotted #36f; }
      td.head1_inner table tr,  td.head1_inner table td {
    background: transparent !important;
    padding: 1px;
}
</style>

<div class="message" align="center">
<? if(!empty($_SESSION['mess_profile'])) {echo $_SESSION['mess_profile']; unset($_SESSION['mess_profile']); }?>
</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >




<? if(!empty($ErrorMsg)){?>
	<tr>

</tr>


<? }else{?>

	<tr>
	  <td  valign="top">

<form action="" method="post" name="form1">

<div id="preview_div">

 <? if($num>0){ ?>
<input type="submit" name="DeleteButton" class="button" style="float:right;margin-bottom:5px;" value="Delete" onclick="return confDel('User Log')">
 <? } ?>
 <div class="had">User Log </div>
 
<table <?=$table_bg?>>
   
    <tr align="left"  >  
    	<td width="10%" class="head1" >User Name</td>
     

	<td width="10%" class="head1" >Updated Time</td>
<td width="10%" class="head1" >IP Address</td>
	<? if(!$HideNavigation){?>
	<td width="10%" class="head1" >Updated Section</td>
	<?php }?>
	<td width="10%" align="" class="head1" >Field Name <span style="margin-left:25%;">Old Data</span> <span style="margin-left:25%;">New Data</span></td>
	<td width="1%"  align="center" class="head1" >
	<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','logID','<?=sizeof($arryUserProfileLog)?>');" />
	</td>

    </tr>
   
    <?php 
$viewpage = '<img src="'.$Config['Url'].'admin/images/view.png" border="0"  onMouseover="ddrivetip(\'<center>View</center>\', 70,\'\')"; onMouseout="hideddrivetip()" >';

//$kick = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Kick Out</center>\', 50,\'\')"; onMouseout="hideddrivetip()" >'; 


	$Today= date("Y-m-d");
  if(is_array($arryUserProfileLog) && $num>0){
 $Line = 0;
  	foreach($arryUserProfileLog as $key=>$values){ 
  		 $Line++;
  		
  		
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">

 
 <td>
 <?php if($values['AdminType']=='admin'){
 	echo "Admin";
  	}else{?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values['AdminID']?>" >
<?=stripslashes($values["UserName"])?></a>
<?}?>
</td>

 
 
<td ><?php echo date("j M, Y H:i:s",strtotime($values['UpdateDate']));?></td>  
<td>

<?=stripslashes($values["IpAdd"])?>
</td>

<? if(!$HideNavigation){?>
<td><?=$values['ModuleType'];?></td>
<?php }?>
<td  align="center"  class="head1_inner" width="30%">
<table width="100%">
<?php $USER_LOG = formatUserLog($values["Changes"]);
	  $USER_LOG_NEW = formatUserLog($values["ChangesNew"]);
		$i = 1;$logHide=$logHide1='';
		foreach ($USER_LOG as $logIndex => $LOG ){
			if($i>2) {
				$logHide = "logHide";
				$logHide1 = "logHide_".$Line;
			}
		?>
			<tr align="left" class="<?=$logHide.' '.$logHide1?>">
				<td width="36%"><?=$logIndex?>:</td>
				<td width="32%"><?=$LOG?></td>
				<td width="32%"><?=$USER_LOG_NEW[$logIndex]?></td>
			</tr>
	<?php 
	$i++;
		}
?>
<?php if($i>3){ ?>
			<tr>
				<td></td>
				<td >
				 <a href="#" id="logHide_<?=$Line?>_show" class="showLink" onclick="showHide('logHide_<?=$Line?>');return false;">View All</a> 
				</td>
			</tr>
			<?php }?>
</table>
</td>

<td  align="center"  class="head1_inner">
<input type="checkbox" name="logID[]" id="logID<?= $Line ?>" value="<?=$values['id']?>" />
</td>

    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="11" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryUserProfileLog)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryUserProfileLog)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','loginID','editCompany.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','loginID','editCompany.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','loginID','editCompany.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
  <input type="hidden" name="NumField" id="NumField" value="<?=$Line?>">
</form>
</td>
</tr>

<? }  

function formatUserLog($USER_LOG){
	$USER_LOG = json_decode((stripslashes($USER_LOG)), true);
	$log_arr = array();
	foreach ($USER_LOG as $logIndex => $LOG ){
		
		if($logIndex=='Comment') $LOG = 'MADE CHANGES';
		
		if( ($logIndex=='PaymentTerm' || $logIndex=='ShippingMethod') && ($LOG == 'Check') ) $LOG = 'None';
		
		$logIndex = preg_replace( '/\B([A-Z])/', ' $1', $logIndex );
		$logIndex = preg_replace('/([0-9]+)/', " of line item $1",$logIndex);
		
		if(empty($LOG)) $LOG = 'Empty';
		
		$log_arr[$logIndex] = $LOG;
	}
	return $log_arr;
}

?>


</table>
