<script language="JavaScript1.2" type="text/javascript">

    function ValidateSearch(SearchBy) {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';

    }
    function filterLead(id)
    {

        location.href = "viewTicket.php?customview=" + id + "&module=Ticket&search=Search"
        LoaderSearch();
    }
function SetFlag(ID,flag) {

		var SendUrl = "&action=TicketFlagInfo&ID=" + escape(ID) + "&FlagType=" + flag + "&r=" + Math.random();

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
<div class="had">Manage <?= (isset($_GET['parent_type'])) ? $_GET['parent_type'] : ''; ?> Ticket</div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_ticket'])) {
    echo $_SESSION['mess_ticket'];
    unset($_SESSION['mess_ticket']);
} ?></div>
 <form action="" method="post" name="form1">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td  align="right">


            <? if ($num > 0) { ?>
<? if( $Config['flag']==0){?>
<ul class="export_menu">
<li><a class="hide" href="#">Export Ticket</a>
<ul>
<li class="excel" ><a href="export_ticket.php?<?=$QueryString?>&flage=1" ><?=EXPORT_EXCEL?></a></li>
<li class="pdf" ><a href="pdfTicket.php?<?=$QueryString?>" ><?=EXPORT_PDF?></a></li>
<li class="csv" ><a href="export_ticket.php?<?=$QueryString?>&flage=2" ><?=EXPORT_CSV?></a></li>	
<li class="doc" ><a href="export_todoc_Ticket.php?<?=$QueryString?>" ><?=EXPORT_DOC?></a></li>		
</ul>
</li>
</ul>
<? }?>
<!--input type="button" class="pdf_button"  name="exp" value="Export To Pdf" onclick="Javascript:window.location = 'pdfTicket.php?<?=$QueryString?>';" />
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_ticket.php?<?= $QueryString ?>';" -->



                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
            <? } ?>
<? if( $Config['flag']==0){?>
            <a href="<?= $AddUrl ?>" class="add" >Add <?= (isset($_GET['parent_type'])) ? $_GET['parent_type'] : ''; ?> Ticket</a>
<? }?>

<? if ($_GET['key'] != '') { ?>
                <a class="grey_bt"  href="<?= $ViewUrl ?>">View All</a>
<? } ?>
        </td>
    </tr>


<? if($num>0){?>
	<tr>
        <td align="right">

<?
$ToSelect = 'TicketID';
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

                    <table <?= $table_bg ?>>

                        <tr align="left"  >
<? if ($_GET["customview"] == 'All') { ?>
                            <tr align="left"  >
                                
                                <!--td width="7%"  class="head1" >Ticket ID</td-->
                                <td class="head1" >Title</td>
                                <td width="22%" class="head1" > Assign To</td>	
                                <td width="12%"  align="center" class="head1" >Status</td>
                                <td width="12%" class="head1" align="center"> Created On</td>
                                <td width="15%"  align="center" class="head1 head1_action" >Action</td>
<? if($ModifyLabel==1){ ?>  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'TicketID', '<?= sizeof($arryTicket) ?>');" /></td><?}?>
                            </tr>
<? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                            <? } ?>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
<? if($ModifyLabel==1){ ?>  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'TicketID', '<?= sizeof($arryTicket) ?>');" /></td><?}?>

                            </tr>

                        <? } ?>


                        <?php
                        if (is_array($arryTicket) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryTicket as $key => $values) {
                                $flag = !$flag;
                                
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
?>

 <tr align="left"  <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>>
			
                              
                               <? if ($_GET["customview"] == 'All') {
                                    //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                    ?>

             <!-- <td ><input type="checkbox" name="TicketID[]" id="TicketID<?= $Line ?>" value="<?= $values['TicketID'] ?>" /></td>-->
              <!--td ><?= $values["TicketID"] ?></td-->
        <td	onmouseover="mouseoverfun('title','<?php echo $values['TicketID']; ?>')"
						onmouseout="mouseoutfun('title','<?php echo $values['TicketID']; ?>')">
					<a id="title<?php echo $values['TicketID']; ?>"
						href="<? echo $vTicket . $values['TicketID'] ?>&curP=<?php echo $_GET['curP']; ?>&tab=Information"><?= stripslashes($values['title']) ?></a>
						<?php if($ModifyLabel==1 && $FieldEditableArray['title']==1){ ?> <span
						class="editable_evenbg"
						id="field_title<?php echo $values['TicketID']; ?>"></span> <span
						id="edit_title<?php echo $values['TicketID']; ?>"
						style="cursor: pointer; display: none;"
						onclick="getField('c_ticket','title','TicketID','<?php echo $values['TicketID']; ?>','<?php echo $FieldTypeArray['title']?>');"><?= $edit ?></span>
						<?php }?>
			</td>


                                   <td	onmouseover="mouseoverfun('AssignedTo','<?php echo $values['TicketID']; ?>');"
						onmouseout="mouseoutfun('AssignedTo','<?php echo $values['TicketID']; ?>');">
					<div id="AssignedTo<?php echo $values['TicketID']; ?>"><?
					if ($values['AssignType'] == 'Group') {

						$arryGrp = $objGroup->getGroup($values['GroupID'], 1);
						$AssignName = $arryGrp[0]['group_name'];
						?> <?php
						if ($values['AssignedTo'] != '') {
							$arryAssignee = $objLead->GetAssigneeUser($values['AssignedTo']);
							echo $AssignName;
							?> <? foreach ($arryAssignee as $values2) { ?> <a
						class="fancybox fancybox.iframe"
						href="../userInfo.php?view=<?= $values2['EmpID'] ?>"><?= $values2['UserName'] ?></a>,
						<?
							}
						}
					} else if ($values['AssignedTo'] != '') {

						if ($values['AssignedTo'] != '') {
							$arryAssignee2 = $objLead->GetAssigneeUser($values['AssignedTo']);
							$assignee = $values['AssignedTo'];
						}
						$AssignName = (!empty($arryAssignee2)) ? $arryAssignee2[0]['UserName'] : '';
						?> <? foreach ($arryAssignee2 as $values3) { ?> <a
						class="fancybox fancybox.iframe"
						href="../userInfo.php?view=<?= $values3['EmpID'] ?>"><?= $values3['UserName'] ?></a>,<br>
						<?
						}
					} else {
						echo NOT_SPECIFIED;
					}
					?></div>
					<?php if($ModifyLabel==1 && $FieldEditableArray['AssignedTo']==1){ ?>
					<span class="editable_evenbg"
						id="field_AssignedTo<?php echo $values['TicketID']; ?>"></span> <span
						id="edit_AssignedTo<?php echo $values['TicketID']; ?>"
						style="cursor: pointer; display: none;"
						onclick="getField('c_ticket','AssignedTo','TicketID','<?php echo $values['TicketID']; ?>','<?php echo $FieldTypeArray['AssignedTo']?>');"><?= $edit ?></span>
						<?php }?></td>

                                    <td align="center"
						onmouseover="mouseoverfun('Status','<?php echo $values['TicketID']; ?>')"
						onmouseout="mouseoutfun('Status','<?php echo $values['TicketID']; ?>');">
					<span id="Status<?php echo $values['TicketID']; ?>"><? echo $values['Status']; ?>
					</span> <?php if($ModifyLabel==1 && $FieldEditableArray['Status']==1){ ?>
					<span class="editable_evenbg"
						id="field_Status<?php echo $values['TicketID']; ?>"></span> <span
						id="edit_Status<?php echo $values['TicketID']; ?>"
						style="cursor: pointer; display: none;"
						onclick="getField('c_ticket','Status','TicketID','<?php echo $values['TicketID']; ?>','<?php echo $FieldTypeArray['Status']?>','<?php echo $SelectboxEditableArray['Status']['selecttbl']?>','<?php echo $SelectboxEditableArray['Status']['selectfield']?>','<?php echo $SelectboxEditableArray['Status']['selectfieldType']?>');"><?= $edit ?></span>
						<?php }?></td>

                                    <td align="center"> <? echo date($Config['DateFormat'], strtotime($values["ticketDate"])); ?></td>

                                <?
                                } else {

                                    foreach ($arryColVal as $key => $cusValue) {
							echo '<td onmouseover="mouseoverfun(\''.$cusValue['colvalue'].'\',\''.$values['TicketID'].'\');"  onmouseout="mouseoutfun(\''.$cusValue['colvalue'].'\',\''.$values['TicketID'].'\');" >';

							if ($cusValue['colvalue'] == 'AssignedTo') {
								echo '<div id="'.$cusValue['colvalue'].$values['TicketID'].'">';
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

							} else if($cusValue['colvalue'] == 'ticketDate') {

								if($values[$cusValue['colvalue']]>0)
								echo '<span id="'.$cusValue['colvalue'].$values['TicketID'].'">'.date($Config['DateFormat'] , strtotime($values[$cusValue['colvalue']])).'</span>';





							} else {
								?>

								<?= (!empty($values[$cusValue['colvalue']])) ? ('<span id="'.$cusValue['colvalue'].$values['TicketID'].'">'.stripslashes($values[$cusValue['colvalue']]).'</span>') : ('<span id="'.$cusValue['colvalue'].$values['TicketID'].'">'.NOT_SPECIFIED.'</span>') ?>
								<?
							} ?>
							<?php if($ModifyLabel==1 && $FieldEditableArray[$cusValue['colvalue']]==1){ ?>
					<span class="editable_evenbg"
						id="field_<?php echo $cusValue['colvalue'].$values['TicketID']; ?>"></span>
					<span
						id="edit_<?php echo $cusValue['colvalue'].$values['TicketID']; ?>"
						style="cursor: pointer; display: none;"
						onclick="getField('c_ticket','<?php echo $cusValue['colvalue'];?>','TicketID','<?php echo $values['TicketID']; ?>','<?php echo $FieldTypeArray[$cusValue['colvalue']]?>' ,'<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selecttbl']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfield']?>','<?php echo $SelectboxEditableArray[$cusValue['colvalue']]['selectfieldType']?>');"><?= $edit ?></span>
						<?php }?>

						<?php

						echo '</td>';
						}
					}
					?>

                                <td  align="center"   class="head1_inner">

 <div id="flagemail_<?php echo $values["TicketID"] ?>" class="flag_e" style="float:left;"><a href="" onclick="return SetFlag('<?=$values['TicketID']?>','<?=$FlagType?>');" id="flaginfo_<?=$values['TicketID']?>""><?=$FlageImage?></a></div>
<a href="<? echo $vTicket . $values['TicketID'] ?>&curP=<?php echo $_GET['curP']; ?>&tab=Information" ><?= $view ?></a>
                                    <a href="<?= $editTicket ?><?php echo $values['TicketID']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=Information" ><?= $edit ?></a>

                                    <a href="<?= $DelTicket ?><?php echo $values['TicketID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a> 

                                    <br><a class="fancybox com fancybox.iframe"  href="<? echo $vTicket . $values['TicketID'] ?>&curP=<?php echo $_GET['curP']; ?>&tab=Comments&pop=1" >Comments</a>



                                </td>

<? if($ModifyLabel==1){ ?>
 <td ><input type="checkbox" name="TicketID[]" id="TicketID<?=$Line?>" value="<?=$values['TicketID']?>" /></td>
<?}?>


                                </tr>
                    <?php } // foreach end // ?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryTicket) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
<? if (sizeof($arryTicket)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'TicketID', 'editTicket.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'TicketID', 'editTicket.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'TicketID', 'editTicket.php?curP=<?= $_GET['curP'] ?>&opt=<?= $_GET['opt'] ?>');" /></td>
                        </tr>
                    </table>
<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
  <input type="hidden" name="NumField" id="NumField" value="<?=sizeof($arryTicket)?>">
   <input type="hidden" name="opentd" id="opentd" value="">       
        </td>
    </tr>
</table>
  </form>
<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".com").fancybox({
            autoSize: false,
            'width': 800,
            'height': 600,
        });


    });

</script>
