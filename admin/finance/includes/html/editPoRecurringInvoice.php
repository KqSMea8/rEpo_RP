
<!--a href="<?=$RedirectURL?>" class="back">Back</a-->


<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>


<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){

	var EntryType = Trim(document.getElementById("EntryType")).value;
	var EntryFrom = Trim(document.getElementById("EntryFrom")).value;
	var EntryTo = Trim(document.getElementById("EntryTo")).value;

        if(EntryType == "recurring"){
            if(!ValidateForSelect(frm.EntryFrom, "Entry From")){        
              return false;
            }

            /*if(!ValidateForSelect(frm.EntryTo, "Entry To")){        
                return false;
            }
            if(EntryFrom >= EntryTo) {
              document.getElementById("EntryFrom").focus();   
              alert("End Date Should be Greater Than Start Date.");
              return false;
             }*/
       }

  
	$("#rec_load").show();
	$("#rec_form").hide();	


}

  
        
        
</script>


<div id="rec_load" style="display:none;padding:60px;" align="center"><img src="../images/ajaxloader.gif"></div>
<div id="rec_form" style="min-height:200px;">
<form name="form1" id="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	 <td>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 


   <!--
 <tr>
        <td  align="right"   class="blackbold" > Invoice Number # : </td>
        <td   align="left" width="25%">
<?php echo stripslashes($arryPurchase[0]["InvoiceID"]); ?>

</td>

 <td  align="right"   class="blackbold" width="25%">  </td>
        <td   align="left" width="25%">


</td>
  
</tr>
<tr>
 
  <td  align="right" class="blackbold">Invoice Date  :</td>
        <td   align="left">

<?
    if ($arryPurchase[0]['PostedDate'] > 0)
        echo date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']));
    ?>

	
	</td>  
       

        
</tr>
-->

 <!---Recurring Start-->
  <?php 
 
    $arryRecurr = $arryPurchase;
    
   include("../includes/html/box/recurring_2column_sales.php");?>
   
   <!--Recurring End-->

   

</table>

</td>
   </tr>





  


   <tr>
    <td  align="center">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" />

	 


	</td>
   </tr>


  
</table>

 </form>
</div>

<? } ?>



