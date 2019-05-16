<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<form name="form1" id="form1" action=""  method="post"  enctype="multipart/form-data">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    
        <tr>
            <td  align="center" valign="top" >


                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                                      
<?php
//By Chetan26Aug//
 if((isset($_GET['mode']) && $_GET['mode'] == 'Task') || (isset($_GET['parent_type']) && $_GET['parent_type'] != ''))
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
 $arrayvalues = $arryActivity[0];
 for($h=0;$h<sizeof($arryHead);$h++){
 if($h==0 && $arryHead[$h]['head_value'] == 'Details'){
     ?>
                        
                         <tr>
                            <td colspan="4" align="left" class="head"><?= $_GET['mode'] ?> <?=$arryHead[$h]['head_value']?></td>
                        </tr>

                    <!---Recurring Start-->
                            <?php   
                            $arryRecurr = $arryActivity;
                            include("../includes/html/box/recurring_2column_daily.php");?>

                            <!--Recurring End-->
                        
                        
                        
 <?php }else{?>       
                    <tr>
                        <td colspan="4" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
                    </tr>

 <?php } $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 


include("includes/html/box/CustomFieldsNew.php"); 

 }
//head close?>  	       
	
</table>	
  

<script type="text/javascript">

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

    $('#piGal table').bxGallery({
        maxwidth: 300,
        maxheight: 200,
        thumbwidth: 75,
        thumbcontainer: 300,
        load_image: 'ext/jquery/bxGallery/spinner.gif'
    });
                </script>


<script type="text/javascript">
    $("#piGal a[rel^='fancybox']").fancybox({
        cyclic: true
    });
                </script>



	
	  
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
<? if ($_GET['edit'] > 0) $ButtonTitle = 'Update ';
else $ButtonTitle = ' Submit '; ?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />

<input type="hidden" name="activity_type" id="activity_type" value="<?= $arryActivity[0]['activityType'] ?>" />
<input type="hidden" name="activityID" id="activityID" value="<?= $_GET['edit'] ?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?= $_SESSION['AdminType'] ?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?= $_SESSION['AdminID'] ?>" />
<input type="hidden" name="ReferenceID" id="ReferenceID"  value="" />


</div>

</td>
   </tr>
</table>
   </form>


<SCRIPT LANGUAGE=JAVASCRIPT>



    selModule();

</SCRIPT>




