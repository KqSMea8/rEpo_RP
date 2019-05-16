<script type="text/javascript" src="javascript/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="javascript/jquery.timepicker.css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

<form name="form1" id="form1"  method="post" enctype="multipart/form-data">

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


    <tr id="sdrop">
          <?php $disply = 'style="display:none"'; ?>
          <td  align="right"  valign="top"  class="blackbold">
              <div  id="mailchimp_title" <?= $disply ?>>Mail Chimp : <span class="red">*</span> </div>
              <div  id="IContact_title" <?= $disply ?>>IContact : <span class="red">*</span> </div>
              <div  id="ConstantContant_title" <?= $disply ?>>ConstantContant : <span class="red">*</span> </div>
          </td>
          <td   align="left" valign="top"   >
             <?php /*<div  id="mailchimp_com" <?= $disply ?>>
                 <?php $arrayChimpCampaignList = $massmail->GetchimpCampaign();
                 //echo '<pre>';print_r($arrayChimpCampaignList);
                 ?>
                <select name="mailchimpCmpId[]" class="inputbox" id="MailChimpcampaigntype"  multiple>
		<?php foreach($arrayChimpCampaignList as $key=>$values){ ?>
                <option value="<?php echo $values['campaign_id'];?>"><?php echo $values['title'];?></option>
                <?php  } ?>
		</select>        
                                </div>*/?>
              <div  id="IContact_com" <?= $disply ?>>
                                    <select name="IContactcampaigntype" class="inputbox" id="IContactcampaigntype" >
		<option value="">--- Select ---</option>
                <option value="d">d</option>
                <option value="e">e</option>
                <option value="f">f</option>
		
                        
		</select>        
                                </div> 
              <div  id="ConstantContant_com" <?= $disply ?>>
                                    <select name="ConstantContantcampaigntype" class="inputbox" id="ConstantContantcampaigntype" >
		<option value="">--- Select ---</option>
                <option value="g">g</option>
                <option value="h">h</option>
                <option value="i">i</option>
		
                        
		</select>        
                                </div> 
          <div class="red" id="mailerr" style="margin-left:5px;"></div>    
          </td>
          
          <td  align="right"  valign="top"   class="blackbold"> <div  id="com_title" <?= $disply ?>>Mass Email Campaign : <span class="red">*</span> </div></td>
                            <td   align="left" valign="top"  >
                                <div  id="com" <?= $disply ?>>
                                    <select name="MassEmailCampaigntype" class="inputbox" id="MassEmailCampaigntype" onchange="lMtype();" >
		<option value="">--- Select ---</option>
                <option value="MCampaign">Mail Chimp</option>
                <!--option value="IContact">IContact</option-->
                <!--option value="ConstantContant">Constant Contact</option-->
		
                        
		</select>        
                                </div>
            <div class="red" id="MassEmailCampaigntypeerr" style="margin-left:5px;"></div>
                            </td>
                            
      </tr>
     
 
<?php
//By Chetan27Aug//

$head = 1;
for($h=0;$h<sizeof($arryHead);$h++){?>
                
    <tr>
        <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
    </tr>

<?php 

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
include("includes/html/box/CustomFieldsNew.php"); 

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
<input type="hidden" name="campaignID" id="campaignID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />



</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="Edit"){ ?>
	StateListSend();
<? } ?>
<? if($_GET["tab"]=="account"){ ?>
	ShowPermission();
<? } ?>
</SCRIPT>



