<script language="JavaScript1.2" type="text/javascript">

    function ValidateSearch(SearchBy) {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
        /*
         var frm  = document.form1;
         var frm2 = document.form2;
         if(SearchBy==1)  { 
         location.href = 'viewActivity.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
         } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
         location.href = 'viewActivity.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
         }
         return false;
         */
    }

    function filterLead(id)
    {

        location.href = "viewActivity.php?customview=" + id + "&module=Activity&search=Search";
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

<div class="had">Manage Event / Task</div>

<div class="message" align="center"><?
    if (!empty($_SESSION['mess_activity'])) {
        echo $_SESSION['mess_activity'];
        unset($_SESSION['mess_activity']);
    }
    ?></div>
  <form action="" method="post" name="form1">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td align="right">
            <!--div align="left">
            <b>Status :</b> <select name="event_status" class="inputbox" id="event_status" onchange="return filterEvent(this.value);" >
                            <option value="">--- Select ---</option>
                            
                                    <option value="Planned"<?
            if ($_GET['key'] == "Planned") {
                echo "selected";
            }
            ?>>Planned</option>
                        <option value="Held" <?
            if ($_GET['key'] == "Held") {
                echo "selected";
            }
            ?>>Held</option>
                        <option value="Not Held" <?
            if (stripslashes($_GET['key']) == "Not Held") {
                echo "selected";
            }
            ?>>Not Held</option>
                            </select>
            </div-->
            <? if ($num > 0) { ?>
	
	
<ul class="export_menu">
<li><a class="hide" href="#">Export Event / Task</a>
<ul>
<li class="excel" ><a href="export_Event.php?<?=$QueryString?>&flage=1" ><?=EXPORT_EXCEL?></a></li>
<li class="pdf" ><a href="pdfEventList.php?<?=$QueryString?>" ><?=EXPORT_PDF?></a></li>
<li class="csv" ><a href="export_Event.php?<?=$QueryString?>&flage=2" ><?=EXPORT_CSV?></a></li>	
<li class="doc" ><a href="export_todoc_Event.php?<?=$QueryString?>" ><?=EXPORT_DOC?></a></li>		
</ul>
</li>
</ul>




                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
            <? } ?>

            <a class="add" href="editActivity.php?module=<?= $_GET['module'] ?>&mode=Event" >Add Event / Task</a>
            <? if ($_GET['key'] != '') { ?>
                <a class="grey_bt" href="viewActivity.php?module=<?= $_GET['module'] ?>">View All</a>
            <? } ?>
        </td>
    </tr>

<? if($num>0){?>
	<tr>
        <td align="right">

<?
$ToSelect = 'activityID';
include_once("../includes/FieldArrayRow.php");
echo $RowColorDropDown;
?>

 </td>
      </tr>
<? } ?>  


    <tr>
        <td  valign="top">



          
                <div id="prv_msg_div" style="display:none">
                    <img src="images/loading.gif">&nbsp;Searching.........</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
                        <? if ($_GET["customview"] == 'All') { ?>
                            <tr align="left"  >
                            
                                <!--td width="6%"  class="head1" >ID</td-->
                                <td  class="head1" >Title</td>
                                <td width="10%" class="head1"> Activity Type </td>
                                <td  class="head1" >Priority</td>
                                <td width="12%" class="head1" >Created By</td>
                                <td width="17%" class="head1" > Start Date</td>
                                <td width="17%" class="head1" > Close Date</td>
                                <td width="8%"  align="center" class="head1" >  Status</td>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
<? if($ModifyLabel==1){ ?>  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'activityID', '<?= sizeof($arryActivity) ?>');" /></td><?}?>
                            </tr>
                        <? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                                <? } ?>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
<? if($ModifyLabel==1){ ?>  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'activityID', '<?= sizeof($arryActivity) ?>');" /></td><?}?>
                            </tr>

                            <?
                        }

                        if (is_array($arryActivity) && $num > 0) {
                            $flag = true;
                            $Line = 0;

$saveOutlook = '<img src="'.$Config['Url'].'admin/images/download.png" border="0"  onMouseover="ddrivetip(\'<center>Save to outlook</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';



                            foreach ($arryActivity as $key => $values) {
                                $flag = !$flag;
                 
                                $Line++;


                                ?>
                                <tr align="left"  <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>>

                                    <? if ($_GET["customview"] == 'All') { ?>  
                                  
                                    <!--td ><?= $values["activityID"] ?></td-->
                                       <td height="22"
					onmouseover="mouseoverfun('subject','<?php echo $values['activityID']; ?>')"
					onmouseout="mouseoutfun('subject','<?php echo $values['activityID']; ?>')">
				<span id="subject<?php echo $values['activityID']; ?>"><?
				echo stripslashes($values["subject"]);
				?></span> <?php if($ModifyLabel==1 && $FieldEditableArray['subject']==1){ ?>
				<span class="editable_evenbg"
					id="field_subject<?php echo $values['activityID']; ?>"></span> <span
					id="edit_subject<?php echo $values['activityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_activity','subject','activityID','<?php echo $values['activityID']; ?>','<?php echo $FieldTypeArray['subject']?>');"><?= $edit ?></span>
					<?php }?></td>
     <td	onmouseover="mouseoverfun('activityType','<?php echo $values['activityID']; ?>')"	onmouseout="mouseoutfun('activityType','<?php echo $values['activityID']; ?>')">
				<span id="activityType<?php echo $values['activityID']; ?>"><?= $values['activityType'] ?></span>
				<?php if($ModifyLabel==1 && $FieldEditableArray['activityType']==1){ ?>
				<span class="editable_evenbg"
					id="field_activityType<?php echo $values['activityID']; ?>"></span>
				<span id="edit_activityType<?php echo $values['activityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_activity','activityType','activityID','<?php echo $values['activityID']; ?>','<?php echo $FieldTypeArray['activityType']?>','<?php echo $SelectboxEditableArray['activityType']['selecttbl']?>','<?php echo $SelectboxEditableArray['activityType']['selectfield']?>','<?php echo $SelectboxEditableArray['activityType']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?></td>
             <td	onmouseover="mouseoverfun('priority','<?php echo $values['activityID']; ?>')"	onmouseout="mouseoutfun('priority','<?php echo $values['activityID']; ?>')">
					<?= (!empty($values['priority'])) ? ('<span id="priority'.$values['activityID'].'">'.stripslashes($values['priority']).'</span>') : ('<span id="priority'.$values['activityID'].'">'.NOT_SPECIFIED.'</span>') ?>
					<?php if($ModifyLabel==1 && $FieldEditableArray['priority']==1){ ?>
				<span class="editable_evenbg"
					id="field_priority<?php echo $values['activityID']; ?>"></span> <span
					id="edit_priority<?php echo $values['activityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_activity','priority','activityID','<?php echo $values['activityID']; ?>','<?php echo $FieldTypeArray['priority']?>','<?php echo $SelectboxEditableArray['priority']['selecttbl']?>','<?php echo $SelectboxEditableArray['priority']['selectfield']?>','<?php echo $SelectboxEditableArray['priority']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?></td>
                                        <td>
                                            <?php
                                            if ($values['created_by'] == 'admin') {

                                                $created_by = "Admin";
                                                ?>

                                                <?= $created_by ?> 

                                                <?
                                            } else {

                                                $created_by = $values['created'];
                                                ?>
                                                <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values["created_id"] ?>"><?= $created_by ?> </a>
                                                <?
                                            }
                                            ?>


                                        </td>
     <td	onmouseover="mouseoverfun('startDate','<?php echo $values['activityID']; ?>')"	onmouseout="mouseoutfun('startDate','<?php echo $values['activityID']; ?>')"><?php
					$stdate = $values["startDate"] . " " . $values["startTime"];
					echo '<span id="startDate'.$values['activityID'].'">'.date($Config['DateFormat'] . " ".$Config['TimeFormat'], strtotime($stdate)).'</span>';
					?> <?php if($ModifyLabel==1 && $FieldEditableArray['startDate']==1){ ?>
				<span class="editable_evenbg"
					id="field_startDate<?php echo $values['activityID']; ?>"></span> <span
					id="edit_startDate<?php echo $values['activityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_activity','startDate','activityID','<?php echo $values['activityID']; ?>','<?php echo $FieldTypeArray['startDate']?>','<?php echo $SelectboxEditableArray['startDate']['selecttbl']?>','<?php echo $SelectboxEditableArray['startDate']['selectfield']?>','<?php echo $SelectboxEditableArray['startDate']['selectfieldType']?>','<?php echo $SelectboxEditableArray['startDate']['relatedField']?>');"><?= $edit ?></span>
					<?php }?></td>
    <td	onmouseover="mouseoverfun('closeDate','<?php echo $values['activityID']; ?>')"	onmouseout="mouseoutfun('closeDate','<?php echo $values['activityID']; ?>')"><?php
					$ctdate = $values["closeDate"] . " " . $values["closeTime"];
					echo '<span id="closeDate'.$values['activityID'].'">'.date($Config['DateFormat'] . " ".$Config['TimeFormat'], strtotime($ctdate)).'</span>';
					?> <?php if($ModifyLabel==1 && $FieldEditableArray['closeDate']==1){ ?>
				<span class="editable_evenbg"
					id="field_closeDate<?php echo $values['activityID']; ?>"></span> <span
					id="edit_closeDate<?php echo $values['activityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_activity','closeDate','activityID','<?php echo $values['activityID']; ?>','<?php echo $FieldTypeArray['closeDate']?>','<?php echo $SelectboxEditableArray['closeDate']['selecttbl']?>','<?php echo $SelectboxEditableArray['closeDate']['selectfield']?>','<?php echo $SelectboxEditableArray['closeDate']['selectfieldType']?>','<?php echo $SelectboxEditableArray['closeDate']['relatedField']?>');"><?= $edit ?></span>
					<?php }?></td>

    <td align="center" onmouseover="mouseoverfun('status','<?php echo $values['activityID']; ?>')"	onmouseout="mouseoutfun('status','<?php echo $values['activityID']; ?>')"><?
					$status = $values['status'];
					echo '<span id="status'.$values['activityID'].'">'.$status.'</span>';
					?> <?php if($ModifyLabel==1 && $FieldEditableArray['status']==1){ ?>
				<span class="editable_evenbg"
					id="field_status<?php echo $values['activityID']; ?>"></span> <span
					id="edit_status<?php echo $values['activityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_activity','status','activityID','<?php echo $values['activityID']; ?>','<?php echo $FieldTypeArray['status']?>','<?php echo $SelectboxEditableArray['status']['selecttbl']?>','<?php echo $SelectboxEditableArray['status']['selectfield']?>','<?php echo $SelectboxEditableArray['status']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?></td>
                                        <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                           echo '<td onmouseover="mouseoverfun(\''.$cusValue['colvalue'].'\',\''.$values['activityID'].'\');"  onmouseout="mouseoutfun(\''.$cusValue['colvalue'].'\',\''.$values['activityID'].'\');" >';

						if ($cusValue['colvalue'] == 'assignedTo') {
							echo '<div id="'.$cusValue['colvalue'].$values['activityID'].'">';
							if ($values[$cusValue['colvalue']] != '') {
								$arryAssignee = $objLead->GetAssigneeUser($values[$cusValue['colvalue']]);

								foreach ($arryAssignee as $users) {
									?>
				<a class="fancybox fancybox.iframe"
					href="../userInfo.php?view=<?= $users['EmpID'] ?>"><?= $users['UserName'] ?></a>
				,
				<?
								}
							} else {
								echo NOT_SPECIFIED;
							}
							echo '</div>';
						} else if ($cusValue['colvalue'] == 'startDate') {

							$stdate = $values["startDate"] . " " . $values["startTime"];
							?>

							<?= ($values[$cusValue['colvalue']] > 0) ? ('<span id="'.$cusValue['colvalue'].$values['activityID'].'">'.date($Config['DateFormat'] . " ".$Config['TimeFormat'], strtotime($stdate)).'</span>') : ('<span id="'.$cusValue['colvalue'].$values['activityID'].'">'.NOT_SPECIFIED.'</span>') ?>
							<?
						} else if ($cusValue['colvalue'] == 'closeDate') {

							$cldate = $values["closeDate"] . " " . $values["closeTime"];
							?>

							<?= ($values[$cusValue['colvalue']] > 0) ? ('<span id="'.$cusValue['colvalue'].$values['activityID'].'">'.date($Config['DateFormat'] . " ".$Config['TimeFormat'], strtotime($cldate)).'</span>') : ('<span id="'.$cusValue['colvalue'].$values['activityID'].'">'.NOT_SPECIFIED.'</span>') ?>
							<? } else if ($cusValue['colvalue'] == 'Notification') { ?>

							<?= '<span id="'.$cusValue['colvalue'].$values['activityID'].'">'.($values[$cusValue['colvalue']] == 1) ? ("Yes") : ("No").'</span>' ?>
							<? } else if ($cusValue['colvalue'] == 'reminder') { ?>

							<?= '<span id="'.$cusValue['colvalue'].$values['activityID'].'">'.($values[$cusValue['colvalue']] == 1) ? ("Yes") : ("No").'</span>' ?>
							<? } else { ?>

							<?= (!empty($values[$cusValue['colvalue']])) ? ('<span id="'.$cusValue['colvalue'].$values['activityID'].'">'.stripslashes($values[$cusValue['colvalue']]).'</span>') : ('<span id="'.$cusValue['colvalue'].$values['activityID'].'">'.NOT_SPECIFIED.'</span>') ?>
							<?
							}?>
							<?php if($ModifyLabel==1 && $FieldEditableArray[$cusValue['colvalue']]==1){ ?>
				<span class="editable_evenbg"
					id="field_<?php echo $cusValue['colvalue'].$values['activityID']; ?>"></span>
				<span
					id="edit_<?php echo $cusValue['colvalue'].$values['activityID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_activity','<?php echo $cusValue['colvalue'];?>','activityID','<?php echo $values['activityID']; ?>','<?php echo $FieldTypeArray[$cusValue['colvalue']]?>' ,'<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selecttbl']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfield']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfieldType']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['relatedField']?>');"><?= $edit ?></span>
					<?php }?>
					<?php echo '</td>';
                                    }
                                }
                                ?> 

                                <td  align="center" class="head1_inner" >
                                    <?php
                                    if ($values['activityType'] == "Task") {
                                        $mode = "Task";
                                    } else {
                                        $mode = "Event";
                                    }
                                    ?>
                                    <a href="javascript:;" onclick="window.location = 'vActivity.php?view=<?php echo $values['activityID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&module=<?php echo $_GET['module']; ?>&mode=<?= $mode ?>';">
                                        <?= $view ?></a>
                                    <a href="javascript:;" onclick="window.location = 'editActivity.php?edit=<?php echo $values['activityID']; ?>&module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&mode=<?= $mode ?>&tab=Activity';" ><?= $edit ?></a>
                                    <a href="editActivity.php?del_id=<?php echo $values['activityID']; ?>&module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a> 

<a href="outlookEvent.php?activityID=<?=$values['activityID']?>" ><?=$saveOutlook?></a>




</td>

<? if($ModifyLabel==1){ ?>
 <td ><input type="checkbox" name="activityID[]" id="activityID<?=$Line?>" value="<?=$values['activityID']?>" /></td>
<?}?>



                                </tr>
                            <?php } // foreach end //   ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="9" class="no_record">No record found. </td>
                            </tr>
                        <?php } ?>



                        <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryActivity) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>

                </div> 
                <? if (sizeof($arryActivity)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'activityID', 'editActivity.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'activityID', 'editActivity.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'activityID', 'editActivity.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" /></td>
                        </tr>
                    </table>
                <? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
             <input type="hidden" name="NumField" id="NumField" value="<?=sizeof($arryActivity)?>">
             <input type="hidden" name="opentd" id="opentd" value="">
        </td>
    </tr>
</table>
 </form>
