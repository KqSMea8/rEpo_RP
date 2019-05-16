
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewOpportunity.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
	Fatal error: Cannot re-assign auto-global variable _REQUEST in /home4/dvhost/public_html/classes/member.class.php on line 1558	   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewOpportunity.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
	Fatal error: Cannot re-assign auto-global variable _REQUEST in /home4/dvhost/public_html/classes/member.class.php on line 1558		return false;
			*/
	}
function filterLead(id)
	{ 
		location.href="viewOpportunity.php?customview="+id+"&module=Opportunity&search=Search";		
                LoaderSearch();
	}
function SetFlag(ID,flag) {

		var SendUrl = "&action=OppFlagInfo&ID=" + escape(ID) + "&FlagType=" + flag + "&r=" + Math.random();

		//$("#flaginfo_"+LeadID).show();
		$("#flaginfo_"+ID).fadeIn(400).html('<img src ="images/ajax_loader_red_32.gif">');
		$.ajax({
			type: "GET",
			url: "ajax.php",
			data: SendUrl,
			cache: true,
			success: function(result){
//alert(result);

			$("#flaginfo_"+ID).html(result);

//<img class="flag_red" title="Flag" alt="Flag" src="images/email_flag.png">

			}  
		});
		return false;

}
$(document).ready(function(){

		$(".to-block").hover(
		function() { 
			$(this).find("a").show(300);
		  },
		  function() {
			 // if($(this).attr('class')!='add-edit-email')
				$(this).find("a").hide();
		
		});
                
                
                $(".flag_white").hide();
                $(".flag_red").show();
                $('.evenbg').hover(function() { 
			$(this).find(".flag_white").show();
                        //$(this).find(".flag_e").css('display','block');
		  },
		  function() {
			 
				$(this).find(".flag_white").hide();
                                //$(this).find(".flag_e").css('display','none');
                });
                $('.oddbg').hover(function() { 
			$(this).find(".flag_white").show();
                        //$(this).find(".flag_e").css('display','block');
		  },
		  function() {
			 
				 $(this).find(".flag_white").hide();
                                 //$(this).find(".flag_e").css('display','none');
                });
                
                
                
             
                
                //End jquery show/hide for Delete, Mark as Read, Mark as Unread buttons
  
     });


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
<style>
<!--
.to-block a{
  display: none;
  position: absolute;
  background: #e9e9e9;
  padding: 5px 24px;
    margin-left: -1px;
    margin-top: -5px;
    color:#005dbd;
      border: 1px solid gray;
  border-radius: 5px;
  }
  
  .flag_e:hover{
      cursor:pointer; 
      
  }
  
  
  -->
</style>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_opp'])) {echo $_SESSION['mess_opp']; unset($_SESSION['mess_opp']); }?></div>
<form action="" method="post" name="form1">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
        <td align="right">
        
      
   
        
	<? if($num>0){?>
<? if( $Config['flag']==0){?>
<ul class="export_menu">
<li><a class="hide" href="#">Export Opportunity</a>
<ul>
<li class="excel" ><a href="export_Opportunity.php?<?=$QueryString?>&flage=1" ><?=EXPORT_EXCEL?></a></li>
<li class="pdf" ><a href="pdfOpportunity.php?<?=$QueryString?>" ><?=EXPORT_PDF?></a></li>
<li class="csv" ><a href="export_Opportunity.php?<?=$QueryString?>&flage=2" ><?=EXPORT_CSV?></a></li>
<li class="doc" ><a href="export_todoc_Opportunity.php?<?=$QueryString?>" ><?=EXPORT_DOC?></a></li>	
</ul>
</li>
</ul>
<? }?>


<!--input type="button" class="pdf_button"  name="exp" value="Export To Pdf" onclick="Javascript:window.location = 'pdfOpportunity.php?<?=$QueryString?>';" />

		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_Opportunity.php?<?=$QueryString?>';" -->



		<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	<? } ?>
<? if( $Config['flag']==0){?>
		<a class="fancybox add_quick fancybox.iframe" href="addOpportunity.php">Quick Entry</a>
		<a class="add" href="editOpportunity.php?module=<?=$_GET['module']?>" >Add Opportunity</a>
<?}?>

	<? if($_GET['key']!='') {?>
	        <a class="grey_bt"  href="viewOpportunity.php?module=<?=$_GET['module']?>">View All</a>
	<? }?>

        
        
        
        </td>
      </tr>
    
<? if($num>0){?>
	<tr>
        <td align="right">

<?
$ToSelect = 'OpportunityID';
include_once("../includes/FieldArrayRow.php");
echo $RowColorDropDown;
?>

 </td>
      </tr>
<? } ?>  



      
	<tr>
	  <td  valign="top">
	

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
  <? if($_GET["customview"] == 'All'){?>
    <tr align="left"  >	
	<td width="14%"  class="head1" >Opportunity Name</td>
	<td width="12%"  class="head1" >Sales Stage</td>
	<td width="8%"  class="head1" >Lead Source</td>
	<td width="8%" class="head1" >Created Date</td>
	<td width="12%" class="head1" >Expected Close Date</td>
	<td  class="head1" >Assign To</td>
 <td  width="15%" class="head1">Phone</td>
	<td width="7%"  align="center" class="head1" >Status</td>
	<td width="12%"  align="center" class="head1 head1_action"  >Action</td>
	<? if($ModifyLabel==1){ ?>  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'OpportunityID', '<?= sizeof($arryOpportunity) ?>');" /></td><?}?>
    </tr>
 <? } else{?>
<tr align="left"  >
<?foreach($arryColVal as $key=>$values){?>
<td width=""  class="head1" ><?=$values['colname']?></td>

<?} ?>
  <td width="10%"  align="center" class="head1 head1_action" >Action</td>
<? if($ModifyLabel==1){ ?>  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'OpportunityID', '<?= sizeof($arryOpportunity) ?>');" /></td><?}?>


    </tr>

<? } 
  if(is_array($arryOpportunity) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryOpportunity as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	//code by bhoodev
		if($values['FlagType']=='Yes' ){ 
			$FlageImage='<img class="flag_red" title="Flag" alt="Flag" src="images/email_flag2.png">'; 
			$FlagType = 'Yes';
		}else{
			$FlageImage='<img class="flag_white" title="Flag" alt="Flag" src="images/email_flag.png">';
			$FlagType = 'NO';
		}
        //End  
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>>

<? if($_GET["customview"] == 'All'){?> 
   
     <td onmouseover="mouseoverfun('OpportunityName','<?php echo $values['OpportunityID']; ?>')"
					onmouseout="mouseoutfun('OpportunityName','<?php echo $values['OpportunityID']; ?>')">
					<a id="OpportunityName<?php echo $values['OpportunityID']; ?>"
					href="vOpportunity.php?view=<?=$values['OpportunityID']?>&module=<?=$_GET['module']?>&curP=<?=$_GET['curP']?>"><?=stripslashes($values["OpportunityName"])?></a>
					<?php if($ModifyLabel==1 && isset($FieldEditableArray['OpportunityName']) && $FieldEditableArray['OpportunityName']==1){ ?>
				<span
					class="editable_evenbg" id="field_OpportunityName<?php echo $values['OpportunityID']; ?>"></span>
				<span
					id="edit_OpportunityName<?php echo $values['OpportunityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_opportunity','OpportunityName','OpportunityID','<?php echo $values['OpportunityID']; ?>','<?php echo $FieldTypeArray['OpportunityName']?>');"><?= $edit ?></span>
					<?php }?>
			</td>

      <td	onmouseover="mouseoverfun('SalesStage','<?php echo $values['OpportunityID']; ?>')" onmouseout="mouseoutfun('SalesStage','<?php echo $values['OpportunityID']; ?>');">
				<span id="SalesStage<?php echo $values['OpportunityID']; ?>"><?=stripslashes($values["SalesStage"])?></span>
				<?php if($ModifyLabel==1 && isset($FieldEditableArray['SalesStage']) && $FieldEditableArray['SalesStage']==1){ ?>
				<span class="editable_evenbg" id="field_SalesStage<?php echo $values['OpportunityID']; ?>"></span>
				<span id="edit_SalesStage<?php echo $values['OpportunityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_opportunity','SalesStage','OpportunityID','<?php echo $values['OpportunityID']; ?>','<?php echo $FieldTypeArray['SalesStage']?>','<?php echo $SelectboxEditableArray['SalesStage']['selecttbl']?>','<?php echo $SelectboxEditableArray['SalesStage']['selectfield']?>','<?php echo $SelectboxEditableArray['SalesStage']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?>
			</td>


	   <td onmouseover="mouseoverfun('lead_source','<?php echo $values['OpportunityID']; ?>')"
					onmouseout="mouseoutfun('lead_source','<?php echo $values['OpportunityID']; ?>');">
					<?=(!empty($values['lead_source']))?('<span id="lead_source'.$values['OpportunityID'].'">'.stripslashes($values['lead_source']).'</span>'):('<span id="lead_source'.$values['OpportunityID'].'">'.NOT_SPECIFIED.'</span>')?>
					<?php if($ModifyLabel==1 && isset($FieldEditableArray['lead_source']) && $FieldEditableArray['lead_source']==1){ ?>
				<span class="editable_evenbg" id="field_lead_source<?php echo $values['OpportunityID']; ?>"></span>
				<span id="edit_lead_source<?php echo $values['OpportunityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_opportunity','lead_source','OpportunityID','<?php echo $values['OpportunityID']; ?>','<?php echo $FieldTypeArray['lead_source']?>','<?php echo $SelectboxEditableArray['lead_source']['selecttbl']?>','<?php echo $SelectboxEditableArray['lead_source']['selectfield']?>','<?php echo $SelectboxEditableArray['lead_source']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?>
    </td>

	<td><?=date($Config['DateFormat'] , strtotime($values["AddedDate"])); ?></td>
		<td	onmouseover="mouseoverfun('CloseDate','<?php echo $values['OpportunityID']; ?>')"
					onmouseout="mouseoutfun('CloseDate','<?php echo $values['OpportunityID']; ?>');">
				<span id="CloseDate<?php echo $values['OpportunityID']; ?>"><?=date($Config['DateFormat'] , strtotime($values["CloseDate"])); ?></span>
				<?php if($ModifyLabel==1 && isset($FieldEditableArray['CloseDate']) && $FieldEditableArray['CloseDate']==1){ ?>
				<span class="editable_evenbg" id="field_CloseDate<?php echo $values['OpportunityID']; ?>"></span>
				<span id="edit_CloseDate<?php echo $values['OpportunityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_opportunity','CloseDate','OpportunityID','<?php echo $values['OpportunityID']; ?>','<?php echo $FieldTypeArray['CloseDate']?>','<?php echo $SelectboxEditableArray['CloseDate']['selecttbl']?>','<?php echo $SelectboxEditableArray['CloseDate']['selectfield']?>','<?php echo $SelectboxEditableArray['CloseDate']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?></td>
     
	 <td onmouseover="mouseoverfun('AssignTo','<?php echo $values['OpportunityID']; ?>');"
					onmouseout="mouseoutfun('AssignTo','<?php echo $values['OpportunityID']; ?>');">
					<div id="AssignTo<?php echo $values['OpportunityID']; ?>"><?
				if ($values['AssignType'] == 'Group') {

					$arryGrp = $objGroup->getGroup($values['GroupID'], 1);
					$AssignName = $arryGrp[0]['group_name'];

					if ($values['AssignTo'] != '') {
						$arryAssignee = $objLead->GetAssigneeUser($values['AssignTo']);
						echo $AssignName;
						echo '<br>';
						?>
				<? foreach ($arryAssignee as $values2) { ?> <!--img border="0" title="Manager" src="../images/manager.png"-->
				<a class="fancybox fancybox.iframe"
					href="../userInfo.php?view=<?= $values2['EmpID'] ?>"><?= $values2['UserName'] ?></a>,<br>
					<?
				}
					}
				} else if ($values['AssignTo'] != '') {

					if ($values['AssignTo'] != '') {
						$arryAssignee2 = $objLead->GetAssigneeUser($values['AssignTo']);
						$assignee = $values['AssignTo'];
					}
					$AssignName = (!empty($arryAssignee2)) ? $arryAssignee2[0]['UserName'] : '';
					?> <? foreach ($arryAssignee2 as $values3) { ?> <!--img border="0" title="Manager" src="../images/manager.png"-->
				<a class="fancybox fancybox.iframe"
					href="../userInfo.php?view=<?= $values3['EmpID'] ?>"><?= $values3['UserName'] ?></a>,<br>
					<?
					}
				} else {
					echo NOT_SPECIFIED;
				}
				?>
				</div>
				<?php if($ModifyLabel==1 && isset($FieldEditableArray['AssignTo']) && $FieldEditableArray['AssignTo']==1){ ?>
				<span class="editable_evenbg" id="field_AssignTo<?php echo $values['OpportunityID']; ?>"></span>
				<span id="edit_AssignTo<?php echo $values['OpportunityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_opportunity','AssignTo','OpportunityID','<?php echo $values['OpportunityID']; ?>','<?php echo $FieldTypeArray['AssignTo']?>');"><?= $edit ?></span>
					<?php }?>
				</td>



<td onmouseover="mouseoverfun('LandlineNumber','<?php echo $values['OpportunityID']; ?>')"
					onmouseout="mouseoutfun('LandlineNumber','<?php echo $values['OpportunityID']; ?>');"><?php  if(!empty($values['LandlineNumber'])){ echo '<span id="LandlineNumber'.$values['OpportunityID'].'">'.$values['LandlineNumber'].'</span>';  ?>
				<a href="javascript:void(0);"
					onclick="call_connect('call_form','to','<?=stripslashes($values['LandlineNumber'])?>','<?=$values['EmpID']?>','<?=$country_code?>','<?=$country_prefix?>','Opportunity')"
					class="call_icon"><span class="phone_img"></span></a> <? } else { echo '<span id="LandlineNumber'.$values['OpportunityID'].'">'.NOT_SPECIFIED.'</span>'; }  ?>
					<?php if($ModifyLabel==1 && isset($FieldEditableArray['LandlineNumber']) && $FieldEditableArray['LandlineNumber']==1){ ?>
				<span class="editable_evenbg" id="field_LandlineNumber<?php echo $values['OpportunityID']; ?>"></span> 
				<span id="edit_LandlineNumber<?php echo $values['OpportunityID']; ?>"
					style="cursor: pointer; display:none;"
					onclick="getField('c_opportunity','LandlineNumber','OpportunityID','<?php echo $values['OpportunityID']; ?>','<?php echo $FieldTypeArray['LandlineNumber']?>');"><?= $edit ?></span>
				<?php }?>
					</td>
				







	 <td align="center"><? 
				if($values['Status'] ==1){
			  $status = 'Active';
				}else{
			  $status = 'InActive';
				}



				echo '<a href="editOpportunity.php?active_id='.$values["OpportunityID"].'&module='.$_GET["module"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';

				?></td>




<? }else{

	foreach($arryColVal as $key=>$cusValue){
						echo '<td onmouseover="mouseoverfun(\''.$cusValue['colvalue'].'\',\''.$values['OpportunityID'].'\');"  onmouseout="mouseoutfun(\''.$cusValue['colvalue'].'\',\''.$values['OpportunityID'].'\');" >';
						
						if($cusValue['colvalue'] == 'AssignTo'){
							echo '<div id="'.$cusValue['colvalue'].$values['OpportunityID'].'">';
							if($values[$cusValue['colvalue']]!=''){
								$arryAssignee = $objLead->GetAssigneeUser($values[$cusValue['colvalue']]);

								foreach($arryAssignee as $users) {?>
				<a class="fancybox fancybox.iframe"
					href="../userInfo.php?view=<?=$users['EmpID']?>"><?=$users['UserName']?></a>
				,
				<?}
							} else{
								echo NOT_SPECIFIED;
							}
							echo '</div>';
						} else if($cusValue['colvalue'] == 'AddedDate' || $cusValue['colvalue'] == 'CloseDate') {

							echo '<span id="'.$cusValue['colvalue'].$values['OpportunityID'].'">'.date($Config['DateFormat'] , strtotime($values[$cusValue['colvalue']])).'</span>';


						} else if ($cusValue['colvalue'] == 'Status') {

							if($values[$cusValue['colvalue']] ==1){
								$status = 'Active';
							}else{
								$status = 'InActive';
							}
							echo '<a href="editOpportunity.php?active_id='.$values["OpportunityID"].'&module='.$_GET["module"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
						}else{?>
						<?=(!empty($values[$cusValue['colvalue']]))?('<span id="'.$cusValue['colvalue'].$values['OpportunityID'].'">'.stripslashes($values[$cusValue['colvalue']]).'</span>'):('<span id="'.$cusValue['colvalue'].$values['OpportunityID'].'">'.NOT_SPECIFIED.'</span>')?>

						<?	}?>
						<?php if($ModifyLabel==1 && $FieldEditableArray[$cusValue['colvalue']]==1){ ?>
							<span class="editable_evenbg" id="field_<?php echo $cusValue['colvalue'].$values['OpportunityID']; ?>"></span> 
							<span id="edit_<?php echo $cusValue['colvalue'].$values['OpportunityID']; ?>"
								style="cursor: pointer; display:none;"
								onclick="getField('c_opportunity','<?php echo $cusValue['colvalue'];?>','OpportunityID','<?php echo $values['OpportunityID']; ?>','<?php echo $FieldTypeArray[$cusValue['colvalue']]?>' ,'<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selecttbl']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfield']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfieldType']?>');"><?= $edit ?></span>
							<?php }?>
						<?php 
						echo '</td>';

					}
				} ?>
   
      <td  align="center"  class="head1_inner">
 <div id="flagemail_<?php echo $values["OpportunityID"] ?>" class="flag_e" style="float:left;"><a href="" onclick="return SetFlag('<?=$values['OpportunityID']?>','<?=$FlagType?>');" id="flaginfo_<?=$values['OpportunityID']?>""><?=$FlageImage?></a></div>
	   <a href="vOpportunity.php?view=<?=$values['OpportunityID']?>&module=<?=$_GET['module']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	 
	  <a href="editOpportunity.php?edit=<?php echo $values['OpportunityID'];?>&module=<?=$_GET['module']?>&amp;curP=<?php echo $_GET['curP'];?>&tab=Edit" ><?=$edit?></a>
	  
	<a href="editOpportunity.php?del_id=<?php echo $values['OpportunityID'];?>&module=<?=$_GET['module']?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>


<? if($ModifyLabel==1){ ?>
 <td ><input type="checkbox" name="OpportunityID[]" id="OpportunityID<?=$Line?>" value="<?=$values['OpportunityID']?>" /></td>
<?}?>



    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="10" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryOpportunity)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  
  </div> 
 <? if(sizeof($arryOpportunity)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td  align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','OpportunityID','editOpportunity.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','OpportunityID','editOpportunity.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','OpportunityID','editOpportunity.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
  <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arryOpportunity) ?>">
<input type="hidden" name="opentd" id="opentd" value="">
</td>
	</tr>
</table>
</form>
