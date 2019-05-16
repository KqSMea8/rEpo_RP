<!-- start calling -->
<?php require_once("callBlock.php"); ?>
<!-- end calling -->

<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }
    function filterLead(id)
    {
        location.href = "viewContact.php?module=contact&customview=" + id;
        LoaderSearch();
    }

//By Rajan 19 Jan 2016//
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
 //End Rajan 19 Jan 2016//

</script>
<div class="had">Manage Contact</div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_contact'])) {
	echo $_SESSION['mess_contact'];
	unset($_SESSION['mess_contact']);
} ?></div>
<form action="" method="post" name="form1">
<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>


	<tr>
		<td align="right"><? if ($num > 0) { ?>

		<ul class="export_menu">
			<li><a class="hide" href="#">Export Contact</a>
			<ul>
				<li class="excel"><a
					href="export_contact.php?<?=$QueryString?>&flage=1"><?=EXPORT_EXCEL?></a></li>
				<li class="pdf"><a href="pdfContact.php?<?=$QueryString?>"><?=EXPORT_PDF?></a></li>
				<li class="csv"><a
					href="export_contact.php?<?=$QueryString?>&flage=2"><?=EXPORT_CSV?></a></li>
				<li class="doc"><a href="export_todoc_Contact.php?<?=$QueryString?>"><?=EXPORT_DOC?></a></li>
			</ul>
			</li>
		</ul>

		<!--input type="button" class="pdf_button"  name="exp" value="Export To Pdf" onclick="Javascript:window.location = 'pdfContact.php?<?=$QueryString?>';" />
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_contact.php?<?= $QueryString ?>';" -->


		<input type="button" class="print_button" name="exp" value="Print"
			onclick="Javascript:window.print();" /> <? } ?> <a
			href="editContact.php?module=<?= $_GET['module'] ?>" class="add">Add
		Contact</a> <? if ($_GET['key'] != ''|| $num==0) {?> <!-- Edited By Rajan 19 jan 2016 -->
		<a href="viewContact.php?module=<?= $_GET['module'] ?>"
			class="grey_bt">View All</a> <? } ?></td>
	</tr>

	<? if($num>0){?>
	<tr>
		<td align="right"><?
		$ToSelect = 'AddID';
		include_once("../includes/FieldArrayRow.php");
		echo $RowColorDropDown;
		?></td>
	</tr>
	<? } ?>



	<tr>
		<td valign="top">




		<div id="prv_msg_div" style="display: none"><img
			src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?= $table_bg ?>>
		<? if ($_GET["customview"] == 'All') { ?>
			<tr align="left">

				<!--td width="10%"  class="head1" >Contact ID</td-->
				<td width="12%" class="head1">First Name</td>
				<td width="12%" class="head1">Last Name</td>
				<td width="20%" class="head1">Email</td>
				<td width="5%" class="head1">Title</td>

				<td class="head1">Assign To</td>
				<td class="head1" width="15%">Phone</td>
				<td width="6%" align="center" class="head1">Status</td>
				<td width="10%" align="center" class="head1 head1_action">Action</td>
				<? if($ModifyLabel==1){ ?>
				<td width="1%" class="head1"><input type="checkbox" name="SelectAll"
					id="SelectAll"
					onclick="Javascript:SelectCheckBoxes('SelectAll', 'AddID', '<?=sizeof($arryContact)?>');" /></td>
					<?}?>
			</tr>
			<? } else { ?>
			<tr align="left">
			<? foreach ($arryColVal as $key => $values) { ?>
				<td width="" class="head1"><?= $values['colname'] ?></td>

				<? } ?>
				<td width="10%" align="center" class="head1 head1_action">Action</td>
				<? if($ModifyLabel==1){ ?>
				<td width="1%" class="head1"><input type="checkbox" name="SelectAll"
					id="SelectAll"
					onclick="Javascript:SelectCheckBoxes('SelectAll', 'AddID', '<?=sizeof($arryContact)?>');" /></td>
					<?}?>
			</tr>

			<? } ?>
			<?php
			if (is_array($arryContact) && $num > 0) {
				$flag = true;
				$Line = 0;
				foreach ($arryContact as $key => $values) {
					$flag = !$flag;

					$Line++;

					?>
			<tr align="left"
			<? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>>
				<? if ($_GET["customview"] == 'All') { ?>

				<!--td ><?= $values["AddID"] ?></td-->
				<td
					onmouseover="mouseoverfun('FirstName','<?php echo $values['AddID']; ?>')"
					onmouseout="mouseoutfun('FirstName','<?php echo $values['AddID']; ?>')">
				<span id="FirstName<?php echo $values['AddID']; ?>"> <?= stripslashes($values["FirstName"]) ?></span>
				<?php if($ModifyLabel==1 && $FieldEditableArray['FirstName']==1){ ?>
				<span class="editable_evenbg"
					id="field_FirstName<?php echo $values['AddID']; ?>"></span> <span
					id="edit_FirstName<?php echo $values['AddID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('s_address_book','FirstName','AddID','<?php echo $values['AddID']; ?>','<?php echo $FieldTypeArray['FirstName']?>');"><?= $edit ?></span>
					<?php }?></td>

				<td
					onmouseover="mouseoverfun('LastName','<?php echo $values['AddID']; ?>')"
					onmouseout="mouseoutfun('LastName','<?php echo $values['AddID']; ?>')">
				<span id="LastName<?php echo $values['AddID']; ?>"> <?= stripslashes($values["LastName"]) ?></span>
				<?php if($ModifyLabel==1 && $FieldEditableArray['LastName']==1){ ?>
				<span class="editable_evenbg"
					id="field_LastName<?php echo $values['AddID']; ?>"></span> <span
					id="edit_LastName<?php echo $values['AddID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('s_address_book','LastName','AddID','<?php echo $values['AddID']; ?>','<?php echo $FieldTypeArray['LastName']?>');"><?= $edit ?></span>
					<?php }?></td>




				<td
					onmouseover="mouseoverfun('Email','<?php echo $values['AddID']; ?>')"
					onmouseout="mouseoutfun('Email','<?php echo $values['AddID']; ?>')">
					<? echo '<a href="mailto:' . $values['Email'] . '" id="Email'.$values['AddID'].'">' . $values['Email'] . '</a>'; ?>
					<?php if($ModifyLabel==1 && $FieldEditableArray['Email']==1){ ?> <span
					class="editable_evenbg"
					id="field_Email<?php echo $values['AddID']; ?>"></span> <span
					id="edit_Email<?php echo $values['AddID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('s_address_book','Email','AddID','<?php echo $values['AddID']; ?>','<?php echo $FieldTypeArray['Email']?>');"><?= $edit ?></span>
					<?php }?></td>

				<td
					onmouseover="mouseoverfun('Title','<?php echo $values['AddID']; ?>')"
					onmouseout="mouseoutfun('Title','<?php echo $values['AddID']; ?>')">
				<span id="Title<?php echo $values['AddID']; ?>"> <?= stripslashes($values["Title"]) ?>
				</span> <?php if($ModifyLabel==1 && $FieldEditableArray['Title']==1){ ?>
				<span class="editable_evenbg"
					id="field_Title<?php echo $values['AddID']; ?>"></span> <span
					id="edit_Title<?php echo $values['AddID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('s_address_book','Title','AddID','<?php echo $values['AddID']; ?>','<?php echo $FieldTypeArray['Title']?>');"><?= $edit ?></span>
					<?php }?></td>
				<td
					onmouseover="mouseoverfun('AssignTo','<?php echo $values['AddID']; ?>');"
					onmouseout="mouseoutfun('AssignTo','<?php echo $values['AddID']; ?>');">
				<div id="AssignTo<?php echo $values['AddID']; ?>"><? if (!empty($values['AssignTo'])) { ?><a
					class="fancybox fancybox.iframe"
					href="../userInfo.php?view=<?= $values['EmpID'] ?>"><?= stripslashes($values['AssignTo']) ?></a><? } else {
						echo NOT_ASSIGNED;
					} ?></div>
					<?php if($ModifyLabel==1 && $FieldEditableArray['AssignTo']==1){ ?>
				<span class="editable_evenbg"
					id="field_AssignTo<?php echo $values['AddID']; ?>"></span> <span
					id="edit_AssignTo<?php echo $values['AddID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('s_address_book','AssignTo','AddID','<?php echo $values['AddID']; ?>','<?php echo $FieldTypeArray['AssignTo']?>');"><?= $edit ?></span>
					<?php }?></td>


				<td
					onmouseover="mouseoverfun('Mobile','<?php echo $values['AddID']; ?>')"
					onmouseout="mouseoutfun('Mobile','<?php echo $values['AddID']; ?>');"><? if (!empty($values['Mobile'])) { ?><?= '<span id="Mobile'.$values['AddID'].'">'.stripslashes($values['Mobile']).'</span>' ?>

				<a href="javascript:void(0);"
					onclick="call_connect('call_form','to','<?=stripslashes($values['Mobile'])?>','<?=$values['EmpID']?>','<?=$country_code?>','<?=$country_prefix?>','Contact')"
					class="call_icon"> <span class="phone_img"></span></a> <? } else {
						echo '<span id="Mobile'.$values['AddID'].'">'.NOT_ASSIGNED.'</span>';
					} ?><?php if($ModifyLabel==1 && $FieldEditableArray['Mobile']==1){ ?>
				<span class="editable_evenbg"
					id="field_Mobile<?php echo $values['AddID']; ?>"></span> <span
					id="edit_Mobile<?php echo $values['AddID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('s_address_book','Mobile','AddID','<?php echo $values['AddID']; ?>','<?php echo $FieldTypeArray['Mobile']?>');"><?= $edit ?></span>
					<?php }?></td>



				<td align="center"><?
				if ($values['Status'] == 1) {
					$status = 'Active';
				} else {
					$status = 'InActive';
				}

				echo '<a href="editContact.php?active_id=' . $values["AddID"] . '&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
				?></td>
				<?
				} else {

					foreach ($arryColVal as $key => $cusValue) {
						echo '<td onmouseover="mouseoverfun(\''.$cusValue['colvalue'].'\',\''.$values['AddID'].'\');"  onmouseout="mouseoutfun(\''.$cusValue['colvalue'].'\',\''.$values['AddID'].'\');" >';

						if ($cusValue['colvalue'] == 'DepositDate') {

							if ($values[$cusValue['colvalue']] > 0) {
								echo '<span id="'.$cusValue['colvalue'].$values['AddID'].'">'.date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']])).'</span>';
							} else {
								echo '<span id="'.$cusValue['colvalue'].$values['AddID'].'">'.NOT_SPECIFIED.'</span>';
							}
						} else if ($cusValue['colvalue'] == 'Status') {

							if ($values[$cusValue['colvalue']] == 1) {
								$status = 'Active';
							} else {
								$status = 'InActive';
							}

							echo '<a href="editContact.php?active_id=' . $values["AddID"] . '&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
						}else if($cusValue['colvalue'] == 'CustID'){

							if(!empty($values['CustID'])){ echo '<span id="'.$cusValue['colvalue'].$values['AddID'].'">'.$values['CustomerName'].'</span>';}else{ echo '<span id="'.$cusValue['colvalue'].$values['AddID'].'">'.NOT_SPECIFIED.'</span>';}

						} else if ($cusValue['colvalue'] == 'AssignTo') {
							echo '<div id="'.$cusValue['colvalue'].$values['AddID'].'">';
							if (!empty($values['AssignTo'])) {
								?>
				<a class="fancybox fancybox.iframe"
					href="../userInfo.php?view=<?= $values['EmpID'] ?>"><?= stripslashes($values['AssignTo']) ?></a>
					<? } else {
						echo NOT_ASSIGNED;
					}
					echo '</div>';?>


					<? } elseif ($cusValue['colvalue'] == 'country_id') { ?>
					<?= (!empty($values['CountryName'])) ? ('<span id="'.$cusValue['colvalue'].$values['AddID'].'">'.stripslashes($values['CountryName']).'</span>') : ('<span id="'.$cusValue['colvalue'].$values['AddID'].'">'.NOT_SPECIFIED.'</span>') ?>
					<?php } else { ?>

					<?= (!empty($values[$cusValue['colvalue']])) ? ('<span id="'.$cusValue['colvalue'].$values['AddID'].'">'.stripslashes($values[$cusValue['colvalue']]).'</span>') : ('<span id="'.$cusValue['colvalue'].$values['AddID'].'">'.NOT_SPECIFIED.'</span>') ?>
					<?
					}?>
					<?php if($ModifyLabel==1 && $FieldEditableArray[$cusValue['colvalue']]==1){ ?>
				<span class="editable_evenbg"
					id="field_<?php echo $cusValue['colvalue'].$values['AddID']; ?>"></span>
				<span
					id="edit_<?php echo $cusValue['colvalue'].$values['AddID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('s_address_book','<?php echo $cusValue['colvalue'];?>','AddID','<?php echo $values['AddID']; ?>','<?php echo $FieldTypeArray[$cusValue['colvalue']]?>' ,'<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selecttbl']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfield']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?>
					<?php
					echo '</td>';
					}
				}
				?>
				<td align="center" class="head1_inner"> <a
					href="vContact.php?view=<?= $values['AddID'] ?>&module=<?= $_GET['module'] ?>&curP=<?= $_GET['curP'] ?>"><?= $view ?></a>
				<a
					href="editContact.php?edit=<?= $values['AddID'] ?>&module=<?= $_GET['module'] ?>&curP=<?= $_GET['curP'] ?>"><?= $edit ?></a>

				<a
					href="editContact.php?del_id=<?php echo $values['AddID']; ?>&module=<?= $_GET['module'] ?>&amp;curP=<?php echo $_GET['curP']; ?>"
					onclick="return confirmDialog(this, '<?= $ModuleName ?>')"><?= $delete ?></a>
				</td>



				<? if($ModifyLabel==1){ ?>
				<td><input type="checkbox" name="AddID[]" id="AddID<?=$Line?>"
					value="<?=$values['AddID']?>" /></td>
					<?}?>


			</tr>
			<?php } // foreach end //?>

			<?php } else { ?>
			<tr align="center">
				<td colspan="8" class="no_record"><?= NO_RECORD ?></td>
			</tr>
			<?php } ?>

			<tr>
				<td colspan="8">Total Record(s) : &nbsp;<?php echo $num; ?> <?php if (count($arryContact) > 0) { ?>
				&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink;
				}
				?></td>
			</tr>
		</table>

		</div>
		<? if (sizeof($arryContact)) { ?>
		<table width="100%" align="center" cellpadding="3" cellspacing="0"
			style="display: none">
			<tr align="center">
				<td height="30" align="left"><input type="button"
					name="DeleteButton" class="button" value="Delete"
					onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');">
				<input type="button" name="ActiveButton" class="button"
					value="Active"
					onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" />
				<input type="button" name="InActiveButton" class="button"
					value="InActive"
					onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" /></td>
			</tr>
		</table>
		<? } ?> <input type="hidden" name="CurrentPage" id="CurrentPage"
			value="<?php echo $_GET['curP']; ?>"> <input type="hidden" name="opt"
			id="opt" value="<?php echo $ModuleName; ?>"> <input type="hidden"
			name="NumField" id="NumField" value="<?=sizeof($arryContact)?>"><input
			type="hidden" name="opentd" id="opentd" value=""></td>
	</tr>
</table>
</form>

