<script type="text/javascript" src="javascript/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="javascript/jquery.timepicker.css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">




//$('#timepicker_start').timepicker({ 'timeFormat': 'H:i:s' });

 $(function() {
			$('#CloseTime').timepicker({ 'timeFormat': 'H:i:s' });
			$('#timeformatExample2').timepicker({ 'timeFormat': 'h:i A' });
		  });

</script>


<div class="left_box">&nbsp;</div>



<div class="right_box">
    <form name="form1" id="form1" action="<?php //echo $ActionUrl;?>"  method="post" enctype="multipart/form-data">
  
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

  <? if (!empty($_SESSION['mess_opp'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_opp'])) {echo $_SESSION['mess_opp']; unset($_SESSION['mess_opp']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  


<?php      
/*******By Chetan 24Aug**********/
$head=1;
$arrayvalues = $arryOpportunity[0];
for($h=0;$h<sizeof($arryHead);$h++){?>
                    <tr>
                        <td colspan="4" align="left" class="head_desc"><?=$arryHead[$h]['head_value']?></td>
                    </tr>
<?php if($h == 0){?>                      
                        
    <tr>
            <td  width="25%" align="right"   class="blackbold"> Created Date : </td>
            <td  width="25%"  align="left" >
            <?php

            $CreatedDateAarry = explode(" ", $arryOpportunity[0]['AddedDate']);
            $CreatedDate = $CreatedDateAarry[0];

            if($arryOpportunity[0]['AddedDate']>0) 
                echo date($Config['DateFormat'], strtotime($arryOpportunity[0]['AddedDate']));
            else 
                echo NOT_SPECIFIED;

            ?>
            <input type="hidden" name="CreatedDate" id="CreatedDate" value="<?=$CreatedDate?>" />       

            </td>
    </tr>
                    
                    
<?php 
}

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
include("includes/html/box/CustomFieldsNew.php");

if(!empty($arryLead) && $arryLead[0]['leadID']>0 && $h == 0){ 

//$arryLeadHead=$objField->getHead(1,102,1);

$arryLeadField = $objField->getFormField('',$arryHeadLead[0]['head_id'],'1');

#echo "<pre>";
#print_r($arryLeadField);

 ?>
    
 <tr>

<? foreach($arryLeadField as $key=>$values){
if($values['fieldid']==137){?>

        <td width="25%"  align="right"   class="blackbold"> Lead Email : </td>
        <td width="25%"  align="left"  valign="top"  >
        <input name="primary_email" type="text" class="inputbox" id="primary_email" value="<?php echo stripslashes($arryLead[0]['primary_email']); ?>"  maxlength="50" />            </td>
<? }?>
<?php if($values['fieldid']==148){?>
        <td width="25%"  align="right"> Last Contact Date :  </td>
        <td width="25%" align="left" valign="top" >
        <?php if($arryLead[0]['LastContactDate']>0)$LastContactDate = $arryLead[0]['LastContactDate'];?>		
        <script>
        $(function() {
        $( "#LastContactDate" ).datepicker({ 
                showOn: "both",
                yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
                dateFormat: 'yy-mm-dd',
                maxDate: "+0D", 
                changeMonth: true,
                changeYear: true
                });
        });
        </script>
        <input id="LastContactDate" name="LastContactDate" readonly="" class="datebox" value="<?=isset($LastContactDate) ? $LastContactDate : '';?>"  type="text" >         </td>
<? } ?>
</tr>


 <?php if($values['fieldid']==142){?>   
<tr>
     <td width="25%"  align="right"   class="blackbold"> Industry  : </td>
     <td width="25%" align="left" valign="top"  >
		
        <select name="Industry" class="inputbox" id="Industry" >
            <option value="">--- Select ---</option>
            <?php for($i=0;$i<sizeof($arryIndustry);$i++) {?>
            <option value="<?=$arryIndustry[$i]['attribute_value']?>" <?  if($arryIndustry[$i]['attribute_value']==$arryOpportunity[0]['Industry']){echo "selected";}?>>
            <?=$arryIndustry[$i]['attribute_value']?>
            </option>
           <?php } ?>
        </select>
    </td>    
</tr>
<? }   }?>

      
<!--<tr>
	<td colspan="4" align="left" class="head_address"><?=$arryHeadLead[1]['head_value']?></td>
        <input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryLead[0]['state_id']; ?>" />	
        <input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryLead[0]['city_id']; ?>" />
</tr>-->
	  
       
<?php
/*By Chetan29June//
 /******************** Code ****************************
$arrayvalues = $arryLead[0];
$arryField = $objField->getFormField('',$arryHeadLead[1]['head_id'],'1');
include("includes/html/box/CustomFieldsNew.php");
*/
?>  
<SCRIPT LANGUAGE=JAVASCRIPT>
	//StateListSend();
</SCRIPT>
<?php } ?>



<?php 
//$arrayvalues = $arryOpportunity[0];
} 
//End//
?>    	
</table>	



<script type="text/javascript">
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
    <td  align="center" >
	
	<div id="SubmitDiv" <?=$dis?>>
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

</div>
<input type="hidden" name="OpportunityID" id="OpportunityID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="leadID" id="leadID" value="<?= (!empty($arryLead) && $arryLead[0]['leadID']!='') ? $arryLead[0]['leadID'] : '';?>" />
<input type="hidden" name="main_state_id" id="main_state_id" value="<?php echo $arryOpportunity[0]['state_id']; ?>"/>
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryOpportunity[0]['city_id']; ?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />





</td>
   </tr>
</table>
           </form>

</div>
<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["module"]=="Opportunity"){ ?>
	StateListSend();
<? } ?>
<? if($_GET["tab"]=="account"){ ?>
	ShowPermission();
<? } ?>
</SCRIPT>



