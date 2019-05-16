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
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_opp'])) {echo $_SESSION['mess_opp']; unset($_SESSION['mess_opp']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
      
   
        
	<? if($num>0){?>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_Opportunity.php?<?=$QueryString?>';" />
		<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	<? } ?>

		<a class="fancybox add_quick fancybox.iframe" href="addOpportunity.php">Quick Entry</a>
		<a class="add" href="editOpportunity.php?module=<?=$_GET['module']?>" >Add Opportunity</a>

	<? if($_GET['key']!='') {?>
	        <a class="grey_bt"  href="viewOpportunity.php?module=<?=$_GET['module']?>">View All</a>
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
	<!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OpportunityID','<?=sizeof($arryOpportunity)?>');" /></td>-->
	<td width="18%"  class="head1" >Opportunity Name</td>
	<td width="15%"  class="head1" >Sales Stage</td>
	<td width="10%"  class="head1" >Lead Source</td>
	<td width="12%" class="head1" >Created Date</td>
	<td width="12%" class="head1" >Expected Close Date</td>
	<td  class="head1" >Assign To</td>
	<td width="7%"  align="center" class="head1" >Status</td>
	<td width="10%"  align="center" class="head1 head1_action"  >Action</td>
    </tr>
 <? } else{?>
<tr align="left"  >
<?foreach($arryColVal as $key=>$values){?>
<td width=""  class="head1" ><?=$values['colname']?></td>

<?} ?>
  <td width="10%"  align="center" class="head1 head1_action" >Action</td>

    </tr>

<? }
  if(is_array($arryOpportunity) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryOpportunity as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">

<? if($_GET["customview"] == 'All'){?> 
     <!-- <td ><input type="checkbox" name="OpportunityID[]" id="OpportunityID<?=$Line?>" value="<?=$values['OpportunityID']?>" /></td>-->
      <td ><a href="vOpportunity.php?view=<?=$values['OpportunityID']?>&module=<?=$_GET['module']?>&curP=<?=$_GET['curP']?>" ><?=stripslashes($values["OpportunityName"])?></a></td>
      <td  > <?=stripslashes($values["SalesStage"])?>	 </td>
	    <td  ><?=(!empty($values['lead_source']))?(stripslashes($values['lead_source'])):(NOT_SPECIFIED)?> 	 </td>

	<td><?=date($Config['DateFormat'] , strtotime($values["AddedDate"])); ?></td>
		<td><?=date($Config['DateFormat'] , strtotime($values["CloseDate"])); ?></td>
     
	  <td><?
                                            if ($values['AssignType'] == 'Group') {

                                                $arryGrp = $objGroup->getGroup($values['GroupID'], 1);
                                                $AssignName = $arryGrp[0]['group_name'];

                                                if ($values['AssignTo'] != '') {
                                                    $arryAssignee = $objLead->GetAssigneeUser($values['AssignTo']);
                                                    echo $AssignName;
                                                    echo '<br>';
                                                    ?>
                                                    <div> 
                                                        <? foreach ($arryAssignee as $values2) { ?>
                                                        <!--img border="0" title="Manager" src="../images/manager.png"-->
                                                            <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values2['EmpID'] ?>" ><?= $values2['UserName'] ?></a>,<br>
                                                            <?
                                                        }
                                                    }
                                                } else if ($values['AssignTo'] != '') {

                                                    if ($values['AssignTo'] != '') {
                                                        $arryAssignee2 = $objLead->GetAssigneeUser($values['AssignTo']);
                                                        $assignee = $values['AssignTo'];
                                                    }
                                                    $AssignName = $arryAssignee2[0]['UserName'];
                                                    ?>
                                                    <? foreach ($arryAssignee2 as $values3) { ?>
                                                            <!--img border="0" title="Manager" src="../images/manager.png"-->
                                                        <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values3['EmpID'] ?>" ><?= $values3['UserName'] ?></a>,<br>
                                                        <?
                                                    }
                                                } else {
                                                    echo NOT_SPECIFIED;
                                                }
                                                ?></td>
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
		echo '<td>';
			if($cusValue['colvalue'] == 'AssignTo'){
				if($values[$cusValue['colvalue']]!=''){
					$arryAssignee = $objLead->GetAssigneeUser($values[$cusValue['colvalue']]);

					foreach($arryAssignee as $users) {?>
					<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$users['EmpID']?>" ><?=$users['UserName']?></a>,
				        <?}
                                 } else{
					echo NOT_SPECIFIED;
				 }
			} else if($cusValue['colvalue'] == 'AddedDate' || $cusValue['colvalue'] == 'CloseDate') {
				
				echo date($Config['DateFormat'] , strtotime($values[$cusValue['colvalue']]));


			} else if ($cusValue['colvalue'] == 'Status') {
                            
                                if($values[$cusValue['colvalue']] ==1){
                                  $status = 'Active';
                                }else{
                                   $status = 'InActive';
                                }
echo '<a href="editOpportunity.php?active_id='.$values["OpportunityID"].'&module='.$_GET["module"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
                          }else{?>
<?=(!empty($values[$cusValue['colvalue']]))?(stripslashes($values[$cusValue['colvalue']])):(NOT_SPECIFIED)?> 
			
		<?	}

		echo '</td>';

		}
	} ?>
   
      <td  align="center"  class="head1_inner">
	   <a href="vOpportunity.php?view=<?=$values['OpportunityID']?>&module=<?=$_GET['module']?>&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	 
	  <a href="editOpportunity.php?edit=<?php echo $values['OpportunityID'];?>&module=<?=$_GET['module']?>&amp;curP=<?php echo $_GET['curP'];?>&tab=Edit" ><?=$edit?></a>
	  
	<a href="editOpportunity.php?del_id=<?php echo $values['OpportunityID'];?>&module=<?=$_GET['module']?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryOpportunity)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  
  </div> 
 <? if(sizeof($arryOpportunity)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td  align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','OpportunityID','editOpportunity.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','OpportunityID','editOpportunity.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','OpportunityID','editOpportunity.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
