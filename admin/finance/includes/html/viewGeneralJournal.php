<script language="javascript1.2" type="text/javascript">
$(function(){
$("#Post_to_GL").click(function(e){

    var number_of_checked_checkbox= $(".posttogl:checked").length;
    if(number_of_checked_checkbox==0){
        alert("Please select atleast one journal entry.");
        return false;
    }else{
	 ShowHideLoader('1','P');
         return true;
    }

         });
    });
    
     function filterLead(id)
    {
        location.href = "viewGeneralJournal.php?customview=" + id ;
        LoaderSearch();
    }

function ChangePostToGlDate() {	
    	
	var CountCheck = document.getElementById("CountCheck").value;

	var orderno="";	var j=0;	
	for(var i=1; i<=CountCheck; i++){
		if(window.parent.document.getElementById("posttogl"+i).checked){
			j++;
			var posttogl =window.parent.document.getElementById("posttogl"+i).value;
			orderno+=posttogl+',';
		}
	}

	if(j>0){
		if((document.getElementById("gldaterow").style.display == 'none')){ 
			document.getElementById("gldaterow").style.display = '' ;	
		}
        }else{
		document.getElementById("gldaterow").style.display = 'none';  	
	}
    	
    }


function SelectCheck(MainID,ToSelect)
{	
	var flag,i;
	var Num = document.getElementById("CountCheck").value;
	if(document.getElementById(MainID).checked){
		flag = true;
	}else{
		flag = false;
	}
	
	for(i=1; i<=Num; i++){
		document.getElementById(ToSelect+i).checked=flag;
	}
	ChangePostToGlDate();
}
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center">
    
<?php if(!empty($_SESSION['mess_journal'])) {echo $_SESSION['mess_journal']; unset($_SESSION['mess_journal']); }?></div>
<form action="" method="post" name="form1" id="JournalEntryForm">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="top">
		<? if($ModifyLabel==1){ ?>
            <div style="float:right;">
            <input type="submit" class="button" name="Post_to_GL" id="Post_to_GL" onclick="return checkPosttoGL()" value="Post to GL" style="font-weight: normal; height: 22px;">
            </div>
		<? } ?>

            <div style="float:right; padding-right: 10px;">
            <a class="add" href="<?=$AddUrl?>">Add Journal Entry</a>
		 <? if($_GET['search']!='') {?>
	  	<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? }?>

            </div>
		</td>
      </tr>
      
	  <tr>
	  <td  valign="top" align="right">
  <?php //added by nisha
$ToSelect = 'posttogl';
include_once("../includes/FieldArrayRow.php");
echo $RowColorDropDown;?></td></tr>

<tr id="gldaterow"  style="display:none">
        
                  
 <td align="right" valign="top"><span class="posttogl">Post to GL Date: </span><script>
$(function() {
$( "#PostToGLDate" ).datepicker({ 
		
	
		showOn: "both",
	yearRange: '<?=date("Y")-10?>:<?=date("Y")?>', 


	dateFormat: 'yy-mm-dd',

	changeMonth: true,
	changeYear: true
	
	});
});
</script>
<? 
$todatdate=$Config['TodayDate'];
$todatdate = explode(" ", $todatdate);
//echo $todatdate[0];exit;

?>
   
<input id="PostToGLDate" name="PostToGLDate" readonly="" class="datebig" value="<?=$todatdate[0]?>"  type="text" >
               
                  
        
          
              
                      </td>
        </tr>

	<tr>
	  <td  valign="top">
	


<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>




   <? if ($_GET["customview"] == 'All') { ?>
    <tr align="left"  >
	<td width="10%" class="head1">Journal No</td>
	<td width="12%" class="head1">Journal Date</td>
	  <td width="12%" class="head1" >Post to GL Date</td>
	<td  class="head1">Memo</td>
	  <td width="12%"   class="head1" >Posted By</td>
	<td width="12%" align="right" class="head1">Debit</td>
	<td width="12%"  align="right" class="head1">Credit</td>
	<td width="12%"  align="center" class="head1">Currency</td>
	<td width="8%"  align="center" class="head1 head1_action">Action</td>	
       <? if($ModifyLabel==1){ ?> <td width="5%" align="center" class="head1"><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td><?}?>
    </tr>
 <? } else { ?>
        <tr align="left"  >
            <? foreach ($arryColVal as $key => $values) { ?>
                <td width=""  class="head1" ><?= $values['colname'] ?></td>

<? } ?>
            <td width="5%"  align="center" class="head1 head1_action">Action</td>	
            <td width="5%" align="center" class="head1">Select</td>
        </tr>

   <?  }
   $CountCheck=0;
  if(is_array($arryGerenalJournal) && $num>0){
	  	$flag=true;
		$Line=0;
		$TotalDebitAmnt=0;
		$TotalCreditAmnt=0;	
		$separator=0;
/******Void General journal*********/
 $void = '<img src="'.$Config['Url'].'admin/icons/memo.png" border="0"  onMouseover="ddrivetip(\'<center>Void General Journal</center>\', 140,\'\')"; onMouseout="hideddrivetip()" >';
/**********************************/

  	foreach($arryGerenalJournal as $key=>$values){
		$flag=!$flag;
		 
		$Line++;
	
		$TotalDebitAmnt += $values['TotalDebit'];
		$TotalCreditAmnt += $values['TotalCredit'];
	
		if($values['PostToGL'] == "Yes" && $separator!=1 ) {
			echo '<tr align="center"><td  colspan="10" class="selectedbg">&nbsp;</td></tr>';
			$separator=1;
		}

		$Currency = $values['Currency'];
		$Currency1=$Currency2='';
 
		if(!empty($values['BankTransfer'])){
			list($Currency1, $Currency2) = explode(",",$Currency);
			$Currency ='';
		}
  ?>
		
    <tr align="left"  bgcolor="<?= $bgcolor ?>" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>  > <!---modified by nisha---->
    <? if ($_GET["customview"] == 'All' ) { ?>  
	<td height="20"><?=$values['JournalNo'];?></td>
	<td><? if($values['JournalDate']>0) 
	echo date($Config['DateFormat'], strtotime($values['JournalDate']));
	?></td>
<td>
            <?
            if ($values['PostToGLDate'] > 0)
                echo date($Config['DateFormat'], strtotime($values['PostToGLDate']));
            ?>

        </td>
	<td><?=stripslashes($values['JournalMemo']);?></td>
<td >
<?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  
</td>
	<td align="right"><strong><?=number_format($values['TotalDebit'],2);?> <?=$Currency2?></strong></td>
	<td align="right"><strong><?=number_format($values['TotalCredit'],2);?> <?=$Currency1?></strong></td>
        <td align="center"><?=$Currency?></td>
         <?
                    } else {

                        foreach ($arryColVal as $key => $cusValue) {
                            echo '<td>';
                            if ($cusValue['colvalue'] == 'AssignTo') {
                                if ($values[$cusValue['colvalue']] != '') {
                                    $arryAssignee = $objLead->GetAssigneeUser($values[$cusValue['colvalue']]);

                                    foreach ($arryAssignee as $users) {
                                        ?>
                                    <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$users['EmpID'] ?>" ><?= $users['UserName'] ?></a>,
                                <?
                                }
                            } else {
                                echo "Not Specified";
                            }


        } else if(($cusValue['colvalue'] == 'JournalDate' || $cusValue['colvalue'] == 'JoiningDate' || $cusValue['colvalue'] == 'LeadDate')) {

                if($values[$cusValue['colvalue']]>0)
                echo date($Config['DateFormat'] , strtotime($values[$cusValue['colvalue']]));

        } else {
                            ?>

    <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
<?
}

echo '</td>';
}
}
  ?>
        
	<td align="center" class="head1_inner">
	<a href="<?=$ViewUrl?>&view=<?=$values['JournalID']?>"><?=$view?></a>&nbsp;
        <?php if($values['PostToGL'] != "Yes"){?>
        <a href="<?=$EditUrl?>&edit=<?php echo $values['JournalID']; ?>" class="Blue"><?= $edit ?></a>&nbsp;
        <a href="<?=$EditUrl?>&del_id=<?php echo $values['JournalID']; ?>" onclick="return confirmDialog(this, 'Journal Entry')" class="Blue" ><?= $delete ?></a>&nbsp;
        <?php }?>

<?php
/***************void General Journal****************/
if(!empty($_GET['void'])){ 
	if($values['PostToGL'] == 'Yes'){	
		echo '<a href="viewGeneralJournal.php?void_id='.$values['JournalID'].'&curP='.$_GET["curP"].'" onclick="return confirmAction(this, \'Void General Journal\', \'Void General Journal\')" >'.$void.'</a> ';
	}
}
/**************************************************/
?>

	</td>

	<? if($ModifyLabel==1){ ?>
        <td align="center">
            <?php if($values['PostToGL'] != "Yes"){
		$CountCheck++;
?>
             <input type="checkbox" onchange="return ChangePostToGlDate();" name="posttogl[]" id="posttogl<?=$CountCheck?>" class="posttogl" value="<?php echo $values['JournalID']; ?>">
            <?php }?>
        </td>
	<? } ?>

    </tr>
	

	
    <?php } // foreach end //?>
<? if ($_GET["customview"] == 'All' ) { ?>	
     <!--tr align="left">
	<td width="8%" class="head1" colspan="4">&nbsp;</td>
	
	<td class="head1" align="right"><strong>Total :</strong></td>
	<td  class="head1" align="right"><strong><?=number_format($TotalDebitAmnt,'2');?></strong></td>
	<td   class="head1" align="right" ><strong><?=number_format($TotalCreditAmnt,'2');?></strong></td>
	<td  class="head1" colspan="2">&nbsp;</td>
	 
    </tr-->
<? }?>

    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryGerenalJournal)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

   <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
  <input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">
 <!--added by nisha for row color---->
   <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arryGerenalJournal) ?>">
</td>
</tr>
</table>
</form>
