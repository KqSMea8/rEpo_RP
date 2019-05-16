<script language="JavaScript1.2" type="text/javascript">

    function ValidateSearch(SearchBy) {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';

    }

    function filterLead(id)
    {
        location.href = "viewQuote.php?customview=" + id + "&module=Quote&search=Search";
        LoaderSearch();
    }

function makepdffile(url){
            $.ajax({
            url: url,
        });
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

<div class="had">Manage <?= $_GET['module'] ?>s</div>

<div class="message" align="center"><?
    if (!empty($_SESSION['mess_quote'])) {
        echo $_SESSION['mess_quote'];
        unset($_SESSION['mess_quote']);
    }
    ?></div>
 <form action="" method="post" name="form1">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

    <tr>
        <td align="right">
           
            <? if ($num > 0) { ?>
<ul class="export_menu">
<li><a class="hide" href="#">Export Quote</a>
<ul>
<li class="excel" ><a href="export_quote.php?<?=$QueryString?>&flage=1" ><?=EXPORT_EXCEL?></a></li>
<li class="pdf" ><a href="pdfQuotes.php?<?=$QueryString?>" ><?=EXPORT_PDF?></a></li>	
<li class="csv" ><a href="export_quote.php?<?=$QueryString?>&flage=2" ><?=EXPORT_CSV?></a></li>
<li class="doc" ><a href="export_todoc_Quotes.php?<?=$QueryString?>" ><?=EXPORT_DOC?></a></li>	
</ul>
</li>
</ul>

                <!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_quote.php?<?= $QueryString ?>';" -->



                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
            <? } ?>
            <? if ($_GET['key'] != '') { ?>
                <a class="grey_bt" href="viewQuote.php?module=<?= $_GET['module'] ?>">View All</a>
<? } ?>

	 <a class="add" href="editQuote.php?module=<?= $_GET['module'] ?>" >Add <?= $_GET['module'] ?></a>
        </td>
    </tr>


<? if($num>0){?>
	<tr>
        <td align="right">

<?
$ToSelect = 'quoteid';
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
                           
                                <!--td width="8%"  class="head1" >Quote No</td-->
                                <td   class="head1" >Subject</td>
                                <td width="12%" class="head1"> Quote Stage </td>
                                <!--td  class="head1" >Opportunity Name</td-->
                                <td width="15%" class="head1" >Valid Till</td>
                                <td  class="head1" width="10%" > Amount</td>

				   <td  class="head1" width="5%" > Currency</td>
                                <td width="15%"   class="head1" > Created Date</td>
                                <td width="10%"  align="center" class="head1" >Action</td>
<? if($ModifyLabel==1){ ?>  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'quoteid', '<?=sizeof($arryQuote)?>');" /></td><?}?>

                            </tr>
                            <? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

    <? } ?>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
<? if($ModifyLabel==1){ ?>  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'quoteid', '<?=sizeof($arryQuote)?>');" /></td><?}?>
                                
                            </tr>

                            <?
                        }

$sendemail = '<img src="' . $Config['Url'] . 'admin/images/emailsend.png" border="0"  onMouseover="ddrivetip(\'<center>Send Quote</center>\', 70,\'\')"; onMouseout="hideddrivetip()" >';







                        if (is_array($arryQuote) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryQuote as $key => $values) {
                                $flag = !$flag;
                               
                                $Line++;



 /********************/
$ModuleDepName = "Quote";
$PdfResArray = GetPdfLinks(array('Module' => 'Quote',  'ModuleID' => $values['quoteid'], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $values['quoteid'], 'PdfFolder' => $Config['C_Quote'], 'PdfFile' => $values['PdfFile']));
/********************/                               


                                ?>
                                <tr align="left"  <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>>
        <? if ($_GET["customview"] == 'All') { ?> 
                                          
                                          <!--td ><?= $values["quoteid"] ?></td-->
			<td height="22"	onmouseover="mouseoverfun('subject','<?php echo $values['quoteid']; ?>')"
			onmouseout="mouseoutfun('subject','<?php echo $values['quoteid']; ?>')"> 
			<span id="subject<?php echo $values['quoteid']; ?>">
			<?
			echo stripslashes($values["subject"]);
			?>		</span> <?php if($ModifyLabel==1 && $FieldEditableArray['subject']==1){ ?>
			<span class="editable_evenbg"
			id="field_subject<?php echo $values['quoteid']; ?>"></span> <span
			id="edit_subject<?php echo $values['quoteid']; ?>"
			style="cursor: pointer; display: none;"
			onclick="getField('c_quotes','subject','quoteid','<?php echo $values['quoteid']; ?>','<?php echo $FieldTypeArray['subject']?>');"><?= $edit ?></span>
			<?php }?>       </td>

                                       <td
					onmouseover="mouseoverfun('quotestage','<?php echo $values['quoteid']; ?>')"
					onmouseout="mouseoutfun('quotestage','<?php echo $values['quoteid']; ?>')">
				<span id="quotestage<?php echo $values['quoteid']; ?>"><?= $values['quotestage'] ?>
				</span> <?php if($ModifyLabel==1 && $FieldEditableArray['quotestage']==1){ ?>
				<span class="editable_evenbg"
					id="field_quotestage<?php echo $values['quoteid']; ?>"></span> <span
					id="edit_quotestage<?php echo $values['quoteid']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_quotes','quotestage','quoteid','<?php echo $values['quoteid']; ?>','<?php echo $FieldTypeArray['quotestage']?>','<?php echo $SelectboxEditableArray['quotestage']['selecttbl']?>','<?php echo $SelectboxEditableArray['quotestage']['selectfield']?>','<?php echo $SelectboxEditableArray['quotestage']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?></td>
                                         
                                        <td onmouseover="mouseoverfun('validtill','<?php if(!empty($values['quoteid'])){ echo $values['quoteid']; }?>')"
					onmouseout="mouseoutfun('validtill','<?php if(!empty($values['quoteid'])){ echo $values['quoteid'];  }?>')"><?
					if ($values["validtill"] >0 && $values["validtill"]!='' ) {//echo $Config['DateFormat'];
						echo '<span id="validtill'.$values['quoteid'].'">'.date($Config['DateFormat'], strtotime($values["validtill"])).'</span>';
					}
					?> <?php if($ModifyLabel==1 && $FieldEditableArray['validtill']==1){ ?>
				<span class="editable_evenbg"
					id="field_validtill<?php echo $values['quoteid']; ?>"></span> <span
					id="edit_validtill<?php echo $values['quoteid']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_quotes','validtill','quoteid','<?php echo $values['quoteid']; ?>','<?php echo $FieldTypeArray['validtill']?>','<?php echo $SelectboxEditableArray['validtill']['selecttbl']?>','<?php echo $SelectboxEditableArray['validtill']['selectfield']?>','<?php echo $SelectboxEditableArray['validtill']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?></td>
                                        <td
					onmouseover="mouseoverfun('TotalAmount','<?php echo $values['quoteid']; ?>')"
					onmouseout="mouseoutfun('TotalAmount','<?php echo $values['quoteid']; ?>')">
				<span id="TotalAmount<?php echo $values['quoteid']; ?>"><? echo $values['TotalAmount']; ?>
				</span> <?php if($ModifyLabel==1 && $FieldEditableArray['TotalAmount']==1){ ?>
				<span class="editable_evenbg"
					id="field_TotalAmount<?php echo $values['quoteid']; ?>"></span> <span
					id="edit_TotalAmount<?php echo $values['quoteid']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_quotes','TotalAmount','quoteid','<?php echo $values['quoteid']; ?>','<?php echo $FieldTypeArray['TotalAmount']?>','','','');"><?= $edit ?></span>
					<?php }?></td>
<td
					onmouseover="mouseoverfun('CustomerCurrency','<?php echo $values['quoteid']; ?>')"
					onmouseout="mouseoutfun('CustomerCurrency','<?php echo $values['quoteid']; ?>')">
				<span id="CustomerCurrency<?php echo $values['quoteid']; ?>"> <? echo $values['CustomerCurrency']; ?>
				</span> <?php if($ModifyLabel==1 && $FieldEditableArray['CustomerCurrency']==1){ ?>
				<span class="editable_evenbg"
					id="field_CustomerCurrency<?php echo $values['quoteid']; ?>"></span>
				<span id="edit_CustomerCurrency<?php echo $values['quoteid']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_quotes','CustomerCurrency','quoteid','<?php echo $values['quoteid']; ?>','<?php echo $FieldTypeArray['CustomerCurrency']?>','<?php echo $SelectboxEditableArray['CustomerCurrency']['selecttbl']?>','<?php echo $SelectboxEditableArray['CustomerCurrency']['selectfield']?>','<?php echo $SelectboxEditableArray['CustomerCurrency']['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?></td>
				<td
                                        <td>
                                            <?
                                            if ($values["PostedDate"] >0) {//echo $Config['DateFormat'];
                                                echo date($Config['DateFormat'], strtotime($values["PostedDate"]));
                                            }
                                            ?>
                                        </td>

                                        <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td onmouseover="mouseoverfun(\''.$cusValue['colvalue'].'\',\''.$values['quoteid'].'\');"  onmouseout="mouseoutfun(\''.$cusValue['colvalue'].'\',\''.$values['quoteid'].'\');" >';

						if ($cusValue['colvalue'] == 'assignTo') {
							echo '<div id="'.$cusValue['colvalue'].$values['quoteid'].'">';
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
								echo "Not Specified";
							}
							echo '</div>';
						} else if ($cusValue['colvalue'] == 'validtill' || $cusValue['colvalue'] == 'PostedDate') {


							if($values[$cusValue['colvalue']]>0)
							echo '<span id="'.$cusValue['colvalue'].$values['quoteid'].'">'.date($Config['DateFormat'] , strtotime($values[$cusValue['colvalue']])).'</span>';


							?>

							<? } else if ($cusValue['colvalue'] == 'CustType' && $values[$cusValue['colvalue']] != '') {
								?>
								<?= ($values[$cusValue['colvalue']] == 'c') ? ('<span id="'.$cusValue['colvalue'].$values['quoteid'].'">Customer</span>') : ('<span id="'.$cusValue['colvalue'].$values['quoteid'].'">Opportunity</span>') ?>
								<? } else { ?>

								<?= (!empty($values[$cusValue['colvalue']])) ? ('<span id="'.$cusValue['colvalue'].$values['quoteid'].'">'.stripslashes($values[$cusValue['colvalue']]).'</span>') : ('<span id="'.$cusValue['colvalue'].$values['quoteid'].'">'.NOT_SPECIFIED.'</span>') ?>
								<?
								} ?>
								<?php if($ModifyLabel==1 && $FieldEditableArray[$cusValue['colvalue']]==1){ ?>
				<span class="editable_evenbg"
					id="field_<?php echo $cusValue['colvalue'].$values['quoteid']; ?>"></span>
				<span
					id="edit_<?php echo $cusValue['colvalue'].$values['quoteid']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_quotes','<?php echo $cusValue['colvalue'];?>','quoteid','<?php echo $values['quoteid']; ?>','<?php echo $FieldTypeArray[$cusValue['colvalue']]?>' ,'<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selecttbl']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfield']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfieldType']?>');"><?= $edit ?></span>
					<?php }?>
					<?php

					echo '</td>';
                                    }
                                }
                                ?>

                                <td  align="center" class="head1_inner" ><a href="vQuote.php?view=<?php echo $values['quoteid']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&module=<?php echo $_GET['module']; ?>"><?= $view ?></a>
                                    <a href="editQuote.php?edit=<?php echo $values['quoteid']; ?>&module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&tab=Quote" ><?= $edit ?></a>
                                    <a href="editQuote.php?del_id=<?php echo $values['quoteid']; ?>&module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a> 

<a href="<?=$PdfResArray['DownloadUrl']?>" ><?=$download?></a>
<a <?=$PdfResArray['MakePdfLink']?> class="fancybox fancybox.iframe"  href="<?= $SendUrl . '&view=' . $values['quoteid'] ?>" ><?=$sendemail?></a>

<? echo '<ul class="print_menu" ><li class="print" ><a target="_blank" class="edit" href="'.$PdfResArray['PrintUrl'].'" >&nbsp;</a></li></ul>';  ?>

                                </td>
<? if($ModifyLabel==1){ ?>
 <td ><input type="checkbox" name="quoteid[]" id="quoteid<?=$Line?>" value="<?=$values['quoteid']?>" /></td>
<?}?>



                                </tr>
    <?php } // foreach end // ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record">No record found. </td>
                            </tr>
<?php } ?>



                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryQuote) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
    echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
<? if (sizeof($arryQuote)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'quoteID', 'editQuote.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'quoteID', 'editQuote.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'quoteID', 'editQuote.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" /></td>
                        </tr>
                    </table>
<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
  <input type="hidden" name="NumField" id="NumField" value="<?=sizeof($arryQuote)?>">
       <input type="hidden" name="opentd" id="opentd" value="">   
        </td>
    </tr>
</table>
  </form>
