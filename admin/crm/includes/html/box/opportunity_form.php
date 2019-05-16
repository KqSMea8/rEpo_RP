
<script type="text/javascript" src="javascript/jquery.timepicker.js"></script>

<link rel="stylesheet" type="text/css" href="javascript/jquery.timepicker.css" />

 

<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">


                  $(function() {
			$('#CloseTime').timepicker({ 'timeFormat': 'H:i:s' });
			$('#timeformatExample2').timepicker({ 'timeFormat': 'h:i A' });
		  });

</script>
<form name="form1" id="form1" action="" method="post" enctype="multipart/form-data">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">



   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<?php 
$head=1;
for($h=0;$h<sizeof($arryHead);$h++){
?>
      
    <tr>
        <td colspan="4" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
    </tr>
    
<?php if($h == 0){?>  
            
    <tr>
        <td width="25%" align="right"   class="blackbold"> Today Date : </td>
        <td width="25%"  align="left" >
            <?php 
            $TodayDateAarry = explode(" ", $Config['TodayDate']);
            $TodayDate = $TodayDateAarry[0];
            echo date($Config['DateFormat'], strtotime($TodayDate));  ?>

            <input type="hidden" name="TodayDate" id="TodayDate" value="<?=$TodayDate?>" />
        </td>
    </tr>
            
            
            
<?php }
$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
include("includes/html/box/CustomFieldsNew.php"); 

 }

//head close?>
  

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



	
	  
	</table>
	</td>
   </tr>

   

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';
        
        
        ?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="OpportunityID" id="OpportunityID"  value="<?=$_GET['edit']?>" />
<input type="hidden" name="Status" id="Status"  value="0" />
<input type="hidden" name="main_state_id" id="main_state_id" value="<?php echo $arryOpportunity[0]['state_id']; ?>"/>
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryOpportunity[0]['city_id']; ?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />

</div>

</td>
   </tr>
</table>
   </form>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	//ShowPermission();
</SCRIPT>
