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

//By Rajan 21 Jan 2016//
  $(document).ready(function(){
      
  	  $('#highlight select#RowColor').attr('onchange','javascript:showColorRowsbyFilter(this)');
        $('#highlight select#RowColor option').each(function() {
            $val = $(this).val();
            $text = $(this).text();
            $val = $val.replace('#', '');
    	    $(this).val($val);
        });
        
  });


  var showColorRowsbyFilter = function(obj)
  { 
      if(obj.value !='')
      {
          $url = window.location.href.split("&rows")[0]; 
          window.location.href = $url+'&rows='+obj.value;
      }
  }
//End Rajan 21 Jan 2016//
</script>
<div class="had">Manage Campaign</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_comp'])) {echo $_SESSION['mess_comp']; unset($_SESSION['mess_comp']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
        
   
        
	<? if($num>0){?>


<ul class="export_menu">
<li><a class="hide" href="#">Export Campaign</a>
<ul>
<li class="excel" ><a href="export_Campaign.php?<?=$QueryString?>&flage=1" ><?=EXPORT_EXCEL?></a></li>
<li class="pdf" ><a href="pdfCampaignList.php?<?=$QueryString?>" ><?=EXPORT_PDF?></a></li>
<li class="csv" ><a href="export_Campaign.php?<?=$QueryString?>&flage=2" ><?=EXPORT_CSV?></a></li>
<li class="doc" ><a href="export_todoc_Campaign.php?<?=$QueryString?>" ><?=EXPORT_DOC?></a></li>		
</ul>
</li>
</ul>









		
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
		<!-- <td ><input type="checkbox" name="CampaignID[]" id="CampaignID<?=$Line?>" value="<?=$values['campaignID']?>" /></td>-->
		<td
					onmouseover="mouseoverfun('campaignname','<?php echo $values['campaignID']; ?>')"
					onmouseout="mouseoutfun('campaignname','<?php echo $values['campaignID']; ?>')">
				<span id="campaignname<?php echo $values['campaignID']; ?>"> <?=stripslashes($values["campaignname"])?>
				</span> <?php if($ModifyLabel==1 && $FieldEditableArray['campaignname']==1){ ?>
				<span class="editable_evenbg"
					id="field_campaignname<?php echo $values['campaignID']; ?>"></span>
				<span id="edit_campaignname<?php echo $values['campaignID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_campaign','campaignname','campaignID','<?php echo $values['campaignID']; ?>','<?php echo $FieldTypeArray['campaignname']?>');"><?= $edit ?></span>
					<?php }?></td>
				<td height="20"
					onmouseover="mouseoverfun('campaigntype','<?php echo $values['campaignID']; ?>')"
					onmouseout="mouseoutfun('campaigntype','<?php echo $values['campaignID']; ?>')">
				<span id="campaigntype<?php echo $values['campaignID']; ?>"> <?=stripslashes($values["campaigntype"])?>
				</span> <?php if($ModifyLabel==1 && $FieldEditableArray['campaigntype']==1){ ?>
				<span class="editable_evenbg"
					id="field_campaigntype<?php echo $values['campaignID']; ?>"></span>
				<span id="edit_campaigntype<?php echo $values['campaignID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_campaign','campaigntype','campaignID','<?php echo $values['campaignID']; ?>','<?php echo $FieldTypeArray['campaigntype']?>','<?php echo $SelectboxEditableArray['campaigntype']['selecttbl']?>','<?php echo $SelectboxEditableArray['campaigntype']['selectfield']?>','<?php echo $SelectboxEditableArray['campaigntype']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?></td>
				<td height="20" height="20"
					onmouseover="mouseoverfun('campaignstatus','<?php echo $values['campaignID']; ?>')"
					onmouseout="mouseoutfun('campaignstatus','<?php echo $values['campaignID']; ?>')">
				<span id="campaignstatus<?php echo $values['campaignID']; ?>"> <?=stripslashes($values["campaignstatus"])?>
				</span> <?php if($ModifyLabel==1 && $FieldEditableArray['campaignstatus']==1){ ?>
				<span class="editable_evenbg"
					id="field_campaignstatus<?php echo $values['campaignID']; ?>"></span>
				<span id="edit_campaignstatus<?php echo $values['campaignID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_campaign','campaignstatus','campaignID','<?php echo $values['campaignID']; ?>','<?php echo $FieldTypeArray['campaignstatus']?>','<?php echo $SelectboxEditableArray['campaignstatus']['selecttbl']?>','<?php echo $SelectboxEditableArray['campaignstatus']['selectfield']?>','<?php echo $SelectboxEditableArray['campaignstatus']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?></td>
				<td
					onmouseover="mouseoverfun('expectedrevenue','<?php echo $values['campaignID']; ?>')"
					onmouseout="mouseoutfun('expectedrevenue','<?php echo $values['campaignID']; ?>')">
				<span id="expectedrevenue<?php echo $values['campaignID']; ?>"><?=$values['expectedrevenue']?>
				</span> <?php if($ModifyLabel==1 && $FieldEditableArray['expectedrevenue']==1){ ?>
				<span class="editable_evenbg"
					id="field_expectedrevenue<?php echo $values['campaignID']; ?>"></span>
				<span id="edit_expectedrevenue<?php echo $values['campaignID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_campaign','expectedrevenue','campaignID','<?php echo $values['campaignID']; ?>','<?php echo $FieldTypeArray['expectedrevenue']?>','<?php echo $SelectboxEditableArray['expectedrevenue']['selecttbl']?>','<?php echo $SelectboxEditableArray['expectedrevenue']['selectfield']?>','<?php echo $SelectboxEditableArray['expectedrevenue']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?></td>
				<td height="20" onmouseover="mouseoverfun('closingdate','<?php echo $values['campaignID']; ?>')"
					onmouseout="mouseoutfun('closingdate','<?php echo $values['campaignID']; ?>')"><?  if($values["closingdate"]!="0000-00-00"){//echo $Config['DateFormat'];
				echo '<span id="closingdate'.$values['campaignID'].'">'.date($Config['DateFormat'] , strtotime($values["closingdate"])).'</span>'; }?>
				<?php if($ModifyLabel==1 && $FieldEditableArray['campaignstatus']==1){ ?>
				<span class="editable_evenbg"
					id="field_closingdate<?php echo $values['campaignID']; ?>"></span>
				<span id="edit_closingdate<?php echo $values['campaignID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_campaign','closingdate','campaignID','<?php echo $values['campaignID']; ?>','<?php echo $FieldTypeArray['closingdate']?>','<?php echo $SelectboxEditableArray['closingdate']['selecttbl']?>','<?php echo $SelectboxEditableArray['closingdate']['selectfield']?>','<?php echo $SelectboxEditableArray['closingdate']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?>
				</td>
				<td onmouseover="mouseoverfun('assignedTo','<?php echo $values['campaignID']; ?>');"
					onmouseout="mouseoutfun('assignedTo','<?php echo $values['campaignID']; ?>');">
					<div id="assignedTo<?php echo $values['campaignID']; ?>"><? if(!empty($values['AssignTo'])) { ?> <a
					class="fancybox fancybox.iframe"
					href="../userInfo.php?view=<?=$values['EmpID']?>"><?=$values['AssignTo']?>
				</a> <? } else { echo NOT_ASSIGNED; }?>
				</div>
				<?php if($ModifyLabel==1 && $FieldEditableArray['assignedTo']==1){ ?>
				<span class="editable_evenbg" id="field_assignedTo<?php echo $values['campaignID']; ?>"></span>
				<span id="edit_assignedTo<?php echo $values['campaignID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_campaign','assignedTo','campaignID','<?php echo $values['campaignID']; ?>','<?php echo $FieldTypeArray['assignedTo']?>');"><?= $edit ?></span>
					<?php }?>
				</td>

	<? }else{

		foreach($arryColVal as $key=>$cusValue){
			echo '<td onmouseover="mouseoverfun(\''.$cusValue['colvalue'].'\',\''.$values['campaignID'].'\');"  onmouseout="mouseoutfun(\''.$cusValue['colvalue'].'\',\''.$values['campaignID'].'\');" >';
						
						if($cusValue['colvalue'] == 'assignedTo'){
							echo '<div id="'.$cusValue['colvalue'].$values['campaignID'].'">';
							if($values[$cusValue['colvalue']]!=''){
								$arryAssignee = $objLead->GetAssigneeUser($values[$cusValue['colvalue']]);

								foreach($arryAssignee as $users) {?>
				<a class="fancybox fancybox.iframe"
					href="../userInfo.php?view=<?=$users['EmpID']?>"><?=$users['UserName']?></a>
				,
				<?}
							} else{
								echo "Not Specified";
							}
							echo '</div>';
						}else if($cusValue['colvalue'] == 'closingdate' || $cusValue['colvalue'] == 'created_time' ){?>
						<?=($values[$cusValue['colvalue']]>0)?('<span id="'.$cusValue['colvalue'].$values['campaignID'].'">'.date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']])).'</span>'):('<span id="'.$cusValue['colvalue'].$values['campaignID'].'"></span>')?>

						<? }else{?>

						<?=(!empty($values[$cusValue['colvalue']]))?('<span id="'.$cusValue['colvalue'].$values['campaignID'].'">'.stripslashes($values[$cusValue['colvalue']]).'</span>'):('<span id="'.$cusValue['colvalue'].$values['campaignID'].'">'.NOT_SPECIFIED.'</span>')?>
						<?}
						?>
						<?php if($ModifyLabel==1 && $FieldEditableArray[$cusValue['colvalue']]==1){ ?>
							<span class="editable_evenbg" id="field_<?php echo $cusValue['colvalue'].$values['campaignID']; ?>"></span> 
							<span id="edit_<?php echo $cusValue['colvalue'].$values['campaignID']; ?>"
								style="cursor: pointer; display:none;"
								onclick="getField('c_campaign','<?php echo $cusValue['colvalue'];?>','campaignID','<?php echo $values['campaignID']; ?>','<?php echo $FieldTypeArray[$cusValue['colvalue']]?>' ,'<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selecttbl']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfield']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfieldType']?>');"><?= $edit ?></span>
							<?php }?>
						<?php
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
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','CampaignID','editCampaign.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','CampaignID','editCampaign.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','CampaignID','editCampaign.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  		<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
			<input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
			<input type="hidden"	name="NumField" id="NumField" value="<?=sizeof($arryCampaign)?>">
			<input type="hidden" name="opentd" id="opentd" value="">
</form>
</td>
	</tr>
</table>
