 
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<SCRIPT LANGUAGE=JAVASCRIPT>

    function SelectAllRecord()
    {
        for (i = 1; i <= document.form1.Line.value; i++) {
            document.getElementById("EmpID" + i).checked = true;
        }

    }

    function SelectNoneRecords()
    {
        for (i = 1; i <= document.form1.Line.value; i++) {
            document.getElementById("EmpID" + i).checked = false;
        }
    }

    function getval(sel) {

        //alert(sel.value);
        document.getElementById("activity_type").value = sel.value;
    }

	 $(document).ready(function(){
    	$("#activityType").change(function(){ 
    		if($( this ).val() =='Zoom Meeting'){
    			$.fancybox.open({
    			    padding : 0,
    			    href:'meetingScheduleMeeting.php?module=Activity&openType=iframe',
    			    type: 'iframe'
    			});
    		}else if($( this ).val() =='Zoom Webinar'){
    			$.fancybox.open({
    			    padding : 0,
    			    href:'meetingScheduleWebinar.php?module=Activity&openType=iframe',
    			    type: 'iframe'
    			});
    		}
    	});
     });

</SCRIPT>

<?
if ($_GET['mode'] == "Task") {

    $detail_head = $_GET['mode'];

    $none = "style='display:none';";
} else {
    $detail_head = "Event";
    $none = "";
}
?>
<div><a href="javascript:;" style="color:#FFFFFF;" class="button" onclick="activity2('Event');">Event</a> &nbsp;&nbsp;&nbsp;<a style="color:#FFFFFF;" href="javascript:;" class="button" onclick="activity2('Task');">Task</a></div>

<div id="Event">
    <form name="form1" id="form1" action=""  method="post" enctype="multipart/form-data">
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">           

<?php
//By Chetan26Aug//
 if($_GET['mode'] == 'Task' || (isset($_GET['parent_type']) && $_GET['parent_type'] != ''))
 {
     $Narry = array_map(function($arr){
        
            if($arr['head_value'] == 'Related To')
            {
                unset($arr);
            }else{
               return $arr;
            }
    }, $arryHead);
   $arryHead = array_values(array_filter($Narry));
}

 $head=1;
 for($h=0;$h<sizeof($arryHead);$h++){
 if($h==0 && $arryHead[$h]['head_value'] == 'Details'){
     ?>
                        
                         <tr>
                            <td colspan="4" align="left" class="head"><?= $_GET['mode'] ?> <?=$arryHead[$h]['head_value']?></td>
                        </tr>

            		<!---Recurring Start-->
                            <?php   

                            include("../includes/html/box/recurring_2column_daily.php");?>

                            <!--Recurring End-->
                        
                        
                        
 <?php }else{?>     
                    <tr>
                        <td colspan="4" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
                    </tr>

 <?php }$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 


include("includes/html/box/CustomFieldsNew.php"); 

 }
//head close?>	
	

</table>	


	
	</td>
   </tr>



   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
<? if ($_GET['edit'] > 0)
    $ButtonTitle = 'Update ';
else
    $ButtonTitle = ' Submit ';
?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />

<input type="hidden" name="activityID" id="activityID" value="<?= $_GET['edit'] ?>" />
<input type="hidden" name="activity_type" id="activity_type" value="<?= $_GET['mode'] ?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?= $_SESSION['AdminType'] ?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?= $_SESSION['AdminID'] ?>" />
<input type="hidden" name="parent_type" id="parent_type" value="<?=(isset($_GET['parent_type'])) ? $_GET['parent_type'] : ''; ?>" />
<input type="hidden" name="parentID" id="parentID" value="<?=(isset($_GET['parentID'])) ? $_GET['parentID'] : '';?>"/>
<input type="hidden" name="ReferenceID" id="ReferenceID" value="" />


</div>

</td>
   </tr>
   </form>
</table>
</div>

  

  
  





