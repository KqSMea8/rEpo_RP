<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewCampaign.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCampaign.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
function filterLead(id)
	{ 	
		location.href="viewCampaign.php?customview="+id+"&module=Campaign&search=Search";		
                LoaderSearch();
	}
</script>
<div class="had">Manage Campaign</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_comp'])) {echo $_SESSION['mess_comp']; unset($_SESSION['mess_comp']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
        
   
        
	<? if($num>0){?>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_Campaign.php?<?=$QueryString?>';" />
		<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	<? } ?>

		<a class="add" href="editCampaign.php?module=<?=$_GET['module']?>" >Add Campaign</a>

	<? if($_GET['key']!='') {?>
		<a class="grey_bt"  href="viewCampaign.php?module=<?=$_GET['module']?>">View All</a>
	<? }?>
        
        
        
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
	  
	
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
    <? if($_GET["customview"] == 'All'){?>
    <tr align="left"  >

	 <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CampaignID','<?=sizeof($arryCampaign)?>');" /></td>-->
      <td width="18%"  class="head1" >Campaign Name</td>
      <td width="14%"  class="head1" >Campaign Type</td>
      <td width="12%"  class="head1" >Campaign Status</td>
       <td width="14%" class="head1" >Expected Revenue [<?=$Config['Currency']?>]</td>
     <td width="15%" class="head1" >Expected Close Date</td>
     
      <td  class="head1" >Assign To</td>
      <td width="10%"   align="center" class="head1" >Action</td>
    </tr>
<? } else{?>
 <tr align="left"  >
<?foreach($arryColVal as $key=>$values){?>
<td width=""  class="head1" ><?=$values['colname']?></td>

<?} ?>
  <td width="10%"  align="center" class="head1 head1_action" >Action</td>

    </tr>

<? }
  if(is_array($arryCampaign) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCampaign as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">

	<? if($_GET["customview"] == 'All'){?> 
		<!-- <td ><input type="checkbox" name="CampaignID[]" id="CampaignID<?=$Line?>" value="<?=$values['CampaignID']?>" /></td>-->
		<td ><?=stripslashes($values["campaignname"])?></td>
		<td height="20" > <?=stripslashes($values["campaigntype"])?>	 </td>
		<td height="20" > <?=stripslashes($values["campaignstatus"])?>	 </td>
		<td><?=$values['expectedrevenue']?> </td>
		<td height="20" > <?  if($values["closingdate"]!="0000-00-00"){//echo $Config['DateFormat'];
		echo date($Config['DateFormat'] , strtotime($values["closingdate"])); }?> </td>
		<td><? if(!empty($values['AssignTo'])) { ?>
		<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values['EmpID']?>"><?=$values['AssignTo']?> </a> 
		<? } else { echo NOT_ASSIGNED; }?></td>

	<? }else{

		foreach($arryColVal as $key=>$cusValue){
			echo '<td>';
			if($cusValue['colvalue'] == 'assignedTo'){
				if($values[$cusValue['colvalue']]!=''){
				$arryAssignee = $objLead->GetAssigneeUser($values[$cusValue['colvalue']]);

				foreach($arryAssignee as $users) {?>
				<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$users['EmpID']?>" ><?=$users['UserName']?></a>,
				<?}
		                 } else{
				echo "Not Specified";
				}
			}else if($cusValue['colvalue'] == 'closingdate' || $cusValue['colvalue'] == 'created_time' ){?>
<?=($values[$cusValue['colvalue']]>0)?(date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]))):('')?>		

                        <? }else{?>

			<?=(!empty($values[$cusValue['colvalue']]))?(stripslashes($values[$cusValue['colvalue']])):(NOT_SPECIFIED)?> 
			<?}

			echo '</td>';

		}
	} ?>
   
      <td  align="center" class="head1_inner"  >
	   <a href="vCampaign.php?view=<?=$values['campaignID']?>&module=<?=$_GET['module']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	 
	  <a href="editCampaign.php?edit=<?php echo $values['campaignID'];?>&module=<?=$_GET['module']?>&amp;curP=<?php echo $_GET['curP'];?>&tab=Edit" ><?=$edit?></a>
	  
	<a href="editCampaign.php?del_id=<?php echo $values['campaignID'];?>&module=<?=$_GET['module']?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCampaign)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  
  </div> 
 <? if(sizeof($arryCampaign)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','CampaignID','editCampaign.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','CampaignID','editCampaign.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','CampaignID','editCampaign.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
